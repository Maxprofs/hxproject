<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Api_Standard_System extends Controller_Pc_Api_Base
{

    public function before()
    {
        parent::before();
    }

    /*
     * 获取所有系统模块类型信息列表
     */
    public function action_get_model_type_list()
    {
        $result = Model_Api_Standard_System::get_model_type_list();
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }

    /**
     * 获取客服电话
     */
    public function action_get_kefu_phone()
    {
        $phone = Model_Api_Standard_System::get_sys_para('cfg_m_phone');
        $result = array(
            'phone' => $phone
        );
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }

    //拥有的模块
    public function action_own_module()
    {
        $result = array();
        $product = DB::select('productcode')->from('app')->where('system_part_type', '=', 2)->execute()->as_array();
        foreach ($product as $item)
        {
            if (strpos($item['productcode'], 'stourwebcms_app_')!==false)
            {
                array_push($result, str_replace('stourwebcms_app_', '', $item['productcode']));
            }
        }
        $this->send_datagrams($this->client_info['id'], array('myapplication'=>$result,'symbol'=>Currency_Tool::symbol()), $this->client_info['secret_key']);
    }


}