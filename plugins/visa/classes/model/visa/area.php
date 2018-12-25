<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Visa_Area extends ORM {
 
     public function deleteClear()
	 {
		 $this->delete();  
	 }
    /**
     * @param $keyword
     * @return string
     * @desc 匹配汉字
     */

    public static function match_chinese($keyword)
    {

        $keyword = St_Functions::remove_xss(self::unescape($keyword));
        $sql = "SELECT kindname FROM `sline_visa_area` WHERE isopen=1 AND pid!=0 AND kindname LIKE '%$keyword%' LIMIT 0,10  ";
        $res = DB::query(1,$sql)->execute()->as_array();
        $str = '';
        foreach($res AS $row)
        {
            $row['kindname'] = str_replace($keyword, '<b>' . $keyword . '</b>', $row['kindname']);
            $str .= $row['kindname'] . ',';
        }
        $str = substr($str, 0, strlen($str)-1);
        return $str;
    }

    /**
     * @param $keyword
     * @return string
     * @desc 匹配拼音
     */

    public static  function match_pinyin($keyword)
    {

        $sql = "SELECT a.kindname FROM `sline_visa_area` a WHERE a.isopen=1";
        $res = DB::query(1,$sql)->execute()->as_array();
        $str = '';


        foreach($res AS $row) // 获取全部name
        {
            if(strlen($keyword) == 1)
            {
                $pinyin = Common::get_pinyin($row['kindname']); // 获取拼音
                if(strpos($pinyin, $keyword) !== false)
                {
                    if(substr($pinyin, 0, 1) == $keyword)
                    {
                        $str .= $row['kindname'] . ",";
                    }
                }
            }
            else
            {
                $pinyin = Common::get_pinyin($row['kindname'], 1); // 获取拼音
                if(strpos($pinyin, $keyword) !== false)
                {
                    $str .= $row['kindname'] . ",";
                }
            }
        }

        $str = substr($str, 0, strlen($str)-1);
        return $str;
    }

    /**
     * @param $kindname
     * @return mixed
     * @desc 根据区域名获取拼音
     */
    public static function get_pinyin($kindname)
    {
        $sql = "SELECT pinyin FROM `sline_visa_area` WHERE kindname=:kindname";
        $ar = DB::query(1,$sql)->param(':kindname',$kindname)->execute()->as_array();
        return $ar[0]['pinyin'] ? $ar[0]['pinyin'] : '';
    }

    /**
     * @function 解密
     * @param $str
     * @return string
     */
    private static function unescape($str)
    {
        $ret = '';
        $len = strlen($str);
        for ($i = 0; $i < $len; $i ++)
        {
            if ($str[$i] == '%' && $str[$i + 1] == 'u')
            {
                $val = hexdec(substr($str, $i + 2, 4));
                if ($val < 0x7f)
                    $ret .= chr($val);
                else
                    if ($val < 0x800)
                        $ret .= chr(0xc0 | ($val >> 6)) .
                            chr(0x80 | ($val & 0x3f));
                    else
                        $ret .= chr(0xe0 | ($val >> 12)) .
                            chr(0x80 | (($val >> 6) & 0x3f)) .
                            chr(0x80 | ($val & 0x3f));
                $i += 5;
            } else
                if ($str[$i] == '%')
                {
                    $ret .= urldecode(substr($str, $i, 3));
                    $i += 2;
                } else
                    $ret .= $str[$i];
        }
        return $ret;
    }
}