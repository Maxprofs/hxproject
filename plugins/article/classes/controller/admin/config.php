<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Config  extends Stourweb_Controller{
    public function before()
    {
        parent::before();
    }

    /**
     * 参数配置
     */
    public function action_params()
	{
        $configinfo = Model_Sysconfig::get_configs(0,'cfg_article_pinlun_audit_open');
        $this->assign('config',$configinfo);
		$this->display('admin/article/params');

	}

	

}