<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Pc_Notice extends Stourweb_Controller{
    private $_id = NULL;
    private $_user_info = NULL;

    public function before()
    {
        parent::before();
        $this->assign('cmsurl', URL::site());
        //登陆状态判断
        $this->_id = Cookie::get('st_supplier_id');
        if(empty($this->_id))
        {
            $this->request->redirect('pc/login');
        }
        else
        {
            $this->_user_info = Model_Supplier::get_supplier_byid($this->_id);
            $this->assign('userinfo',$this->_user_info);
        }

    }


    public function action_ajax_checkorder()
    {
        $order_log_file = APPPATH.'/data/order_'.$this->_id.'.php';
        $org_id = '';
        if(file_exists($order_log_file))
        {
            $org_id = file_get_contents($order_log_file);
        }
        $new_order = ORM::factory('member_order')->where("supplierlist=$this->_id")->order_by('addtime','DESC')->limit(1)->find()->as_array();
        if($new_order['id'] != $org_id)
        {
            file_put_contents($order_log_file,$new_order['id']);
            echo json_encode(array('status'=>1,'order_info'=>$new_order));
        }
        else
        {
           echo json_encode(array('status'=>0));
        }






    }


}