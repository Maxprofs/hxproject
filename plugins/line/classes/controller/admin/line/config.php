<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Line_Config  extends Stourweb_Controller{
    private $_typeid = 1;
    public function before()
    {
        parent::before();
    }

    /**
     * 参数配置
     */
    public function action_params()
	{
        $configinfo = Model_Sysconfig::get_configs(0);
        $this->assign('config',$configinfo);
		$this->display('admin/line/config/params');

	}

    /*
     * 发票配置
     */
    public function action_invoice()
    {
        $fields = array('cfg_invoice_open_1','cfg_invoice_type_1','cfg_invoice_content_1','cfg_invoice_des_1');
        $info = Model_Sysconfig::get_configs(0,$fields);
        $info['cfg_invoice_type_1_arr'] = explode(',',$info['cfg_invoice_type_1']);
        $this->assign('info',$info);
        $this->display('admin/line/config/invoice');
    }

    /*
     * 发票保存
     */
    public function action_ajax_invoice_save()
    {
        $params = array('webid'=>0);
        $params['cfg_invoice_open_1'] = $_POST['cfg_invoice_open_1'];
        $params['cfg_invoice_type_1'] = implode(',',$_POST['cfg_invoice_type_1']);
        $params['cfg_invoice_content_1'] = $_POST['cfg_invoice_content_1'];
        $params['cfg_invoice_des_1'] = $_POST['cfg_invoice_des_1'];
        Model_Sysconfig::save_config($params);
        echo json_encode(array('status'=>1));
    }
}