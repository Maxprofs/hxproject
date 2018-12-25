<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Images extends Controller
{

    private $watermark;

    public function action_index()
    {
        $data =& $_GET;
        $width = (int)$data['w'];
        $height = (int)$data['h'];
        if (preg_match('~((_1)*_\d+x\d+)\.(jpg|gif|png|jpeg)$~i', $data['file'], $match))
        {
            if (substr_count($match[1], '_') == 2)
            {
                $this->watermark = true;
            }
            $data['file'] = str_replace($match[1], '', $data['file']);
        }
        $rendered = FALSE;
        $original_file = DOCROOT . $data['file'];
        $filename = str_replace('/', DIRECTORY_SEPARATOR, SLINEDATA . "/thumb/{$width}x{$height}/" . basename($original_file));
        if (is_file($filename))
        {
            $this->_render_image($filename, $width, $height);
            $rendered = TRUE;
        }
        else
        {
            if (is_file($original_file))
            {
                $this->_thumb($original_file, $filename, $width, $height);
                $rendered = TRUE;
            }
        }
        if (!$rendered)
        {
            $this->response->status(404);
        }
    }

    /**
     * @function 生成缩率图
     * @param $original_file
     * @param $filename
     * @param $width
     * @param $height
     */
    protected function _thumb($original_file, $filename, $width, $height)
    {
        static $water_mark = null;
        if (!is_file($filename))
        {

            $need_width = $width;
            $need_height = $height;
            //计算最终的大小
            $size = $this->_get_compused_size($original_file,$width,$height);
            $width = $size['width'];
            $height = $size['height'];
            //按要求的最大边裁剪
            if($need_width>$need_height)
            {
                $image = Image::factory($original_file)->resize($width, $height, Image::WIDTH)->crop($width, $height);
            }
            else
            {
                $image = Image::factory($original_file)->resize($width, $height, Image::HEIGHT)->crop($width, $height);
            }

           // $image = Image::factory($original_file)->resize($width, $height, Image::PRECISE);
            mkdir(dirname($filename), 0777, true);
            //水印配置
            if ($this->watermark && is_null($water_mark))
            {
                $config_file = str_replace('/', DIRECTORY_SEPARATOR, DOCROOT . "{$GLOBALS['cfg_admin_dirname']}/application/config/watermark.php");
                if (file_exists($config_file))
                {
                    $water_mark = include $config_file;
                }
                else
                {
                    $water_mark = array();
                }
            }
            //水印生成条件
            if ($water_mark && $water_mark['watermark']['photo_markon'] && $water_mark['watermark']['photo_condition'])
            {
                //缩率图生成条件
                if (preg_match('~(\d+)x?(\d+)~is', $water_mark['watermark']['photo_condition'], $match))
                {
                    if ((!$width && $height >= $match[2]) || (!$height && $width >= $match[1]) || ($width >= $match[1] && $height >= $match[2]))
                    {
                        $config = $water_mark['watermark'];
                        if ($config['photo_marktype'] == 'img')
                        {
                            $mark = Image::factory(SLINEDATA . '/mark/mark.png');
                        }
                        else
                        {
                            $mark = Image::factory(SLINEDATA . '/mark/mark_text.png');
                        }
                        $position = array(
                            1 => array(0, 0),
                            2 => array(null, 0),
                            3 => array(true, 0),
                            4 => array(0, null),
                            5 => array(null, null),
                            6 => array(true, null),
                            7 => array(0, true),
                            8 => array(null, true),
                            9 => array(true, true),
                        );
                        $config['photo_waterpos'] = $config['photo_waterpos'] ? $config['photo_waterpos'] : rand(1, 9);
                        $position = $position[$config['photo_waterpos']];
                        $image->water_mark = true;
                        $image->watermark($mark, $position[0], $position[1]);
                    }
                }
            }
            $image->save($filename, !empty($GLOBALS['cfg_image_quality_open']) && !empty($GLOBALS['cfg_image_quality']) ? $GLOBALS['cfg_image_quality'] : 72);
            //$image->save($filename,70);
        }
        $this->_render_image($filename, $width, $height);
    }

    /**
     * @function 渲染图片
     * @param $filename
     * @param $width
     * @param $height
     */
    protected function _render_image($filename, $width, $height)
    {
        $etag_sum = md5($filename . $width . ',' . $height);
        switch (substr($filename, strrpos($filename, '.') + 1))
        {
            case 'png':
                $this->response->headers('Content-Type', 'image/png');
                break;
            case 'gif':
                $this->response->headers('Content-Type', 'image/gif');
                break;
            default:
                $this->response->headers('Content-Type', 'image/jpeg');
                break;
        }
        $this->response->headers('Cache-Control', 'max-age=' . Date::HOUR . ', public, must-revalidate')
            ->headers('Expires', gmdate('D, d M Y H:i:s', time() + Date::HOUR) . ' GMT')
            ->headers('Last-Modified', date('r', filemtime($filename)))
            ->headers('ETag', $etag_sum);
        if ($this->request->headers('if-none-match') AND (string)$this->request->headers('if-none-match') === $etag_sum)
        {
            $this->response->status(304)->headers('Content-Length', '0');
        }
        else
        {
            $this->response->body(file_get_contents($filename));
        }
    }


    /**
     * @function 计算出生成缩略图片的宽度和高度
     * @param $img
     * @param $expect_width
     * @param $expect_height
     * @return array
     */
    protected function _get_compused_size($img,$expect_width,$expect_height)
    {
        // Get the image information
        $info = getimagesize($img);
        //图片初始宽度
        $pre_width = $info[0];
        //图片初始高度
        $pre_height = $info[1];

        //系数,想要生成的缩略图的宽高,均要乘上该系数,如:想要生成的宽高为400*300 ,则返回的宽高为800*600
        $coefficient = 2;
        $width = $expect_width * $coefficient;
        $height = $expect_height * $coefficient;
        //如果扩大2倍后,高度超出,则恢复使用1倍
        if($width > $pre_width || $height > $pre_height)
        {
            $width = $width/2;
            $height = $height/2;
        }
        //如果需要宽度大于实际宽度,则取实际宽度
        if($width>$pre_width)
        {
            $width = $pre_width;
        }
        //如果需要高度大于实际高度,则取实际高度
        if($height>$pre_height)
        {
            $height = $pre_height;
        }

        return array(
            'width' => $width,
            'height' => $height
        );



    }
}