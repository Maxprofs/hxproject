<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Spot_Config extends Stourweb_Controller
{
    private $_typeid = 105;

    public function before()
    {
        parent::before();
        $action = $this->request->action();
        //这里需要补权限的判断功能
    }

    public function action_index()
    {
        $config = DB::select()->from('sysconfig')->where('varname','like','cfg_plugin_spot_%')->or_where('varname','=','cfg_spot_supplier_check_auto')->execute()->as_array();
        $list = array();
        foreach($config as $v)
        {
            $list[$v['varname']] = $v['value'];
        }
        $this->assign('list',$list);
        $this->display('admin/spot/config/index');
    }

    public function action_ajax_config_save()
    {
        $cfg_arr = array('webid'=>0);
        foreach($_POST as $k=>$v)
        {
            if(strpos($k,'cfg_')===0)
            {
                $cfg_arr[$k] = $v;
            }
        }
        $sys_model = new Model_Sysconfig();
        $sys_model->saveConfig($cfg_arr);
        echo json_encode(array('status'=>true,'msg'=>'保存成功'));

    }
    public function action_agreement()
    {
        $config = DB::select()->from('sysconfig')->where('varname','like','cfg_plugin_spot_agreement_%')->execute()->as_array();
        $list = array();
        foreach($config as $v)
        {
            $list[$v['varname']] = $v['value'];
        }
        $this->assign('list',$list);
        $this->display('admin/spot/config/agreement');
    }
}