<?php defined('SYSPATH') or die('No direct script access.');

/**
 *  微信分享后台配置
 */
class Controller_Admin_Share_Wxclient  extends Stourweb_Controller
{
    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        $config = Kohana::$config->load('share_wx_client')->as_array();
        $this->assign('config', $config);
        $this->display('admin/share/wxclient/conf');
    }
}