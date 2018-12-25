<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Stourweb_Controller
{

    private $_cache_key = '';

    public function before()
    {
        parent::before();
        //检查缓存
        $this->_cache_key = Common::get_current_url();
        $html = Common::cache('get', $this->_cache_key);
        $genpage = intval(Arr::get($_GET, 'genpage'));
        if (! empty($html) && empty($genpage) && ! St_Functions::is_normal_app_install('weixinquicklogin') && ! Common::is_weixin_browser())
        {
            echo $html;
            exit;
        }
    }

    //首页
    public function action_index()
    {
        //seo信息
        $seoinfo = array(
            'seotitle'    => $GLOBALS['cfg_indextitle'],
            'keyword'     => $GLOBALS['cfg_keywords'],
            'description' => $GLOBALS['cfg_description'],
        );

        //获取栏目名称与开启状态
        $channel = Model_Nav::get_all_channel_info_mobile();
        $this->assign('channel', $channel);
        $this->assign('seoinfo', $seoinfo);
        $this->assign('is_index', 1);
        $this->display('index', 'index');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    //移动端子站内容
    public function action_sub_station()
    {
        $param = $this->request->param();
        $host_url = $GLOBALS['cfg_basehost'] . $GLOBALS['cfg_phone_cmspath'];
        //目的地检测
        $dest = Model_Destinations::get_dest_bypinyin($param['pinyin']);
        if (empty($dest) || Model_Model::exsits_model($param['model']))
        {
            $this->request->redirect('/pub/404');
        }
        //获取内容
        //$html = file_get_contents($host_url . "/{$param['model']}/show_{$param['aid']}.html?webid={$dest['id']}");
        //缓存位置
        $path = SLINEDATA . '/cache/sub_station/';
        //请求内容url
        $file_name = $host_url . "/{$param['model']}/show_{$param['aid']}.html?webid={$dest['id']}";
        //缓存文件
        $path_file = $path . md5($file_name) . '.html';
        if (! is_dir($path))
        {
            if (! mkdir($path, 0777, true))
            {
                $html = file_get_contents($path_file);
            }
            else
            {
                $html = file_get_contents($file_name);
                file_put_contents($path_file, $html);
            }
        }
        else
        {
            if (file_exists($path_file))
            {
                $filemtime = filemtime($path_file);
                if (time() - $filemtime >= 86400 * 2)
                {
                    $html = file_get_contents($file_name);
                    file_put_contents($path_file, $html);
                }
                else
                {
                    $html = file_get_contents($path_file);
                }
            }
            else
            {
                $html = file_get_contents($file_name);
                file_put_contents($path_file, $html);
            }
        }
        if (empty($html))
        {
            $this->request->redirect('/pub/404');
        }
        $this->response->body($html);
    }
}