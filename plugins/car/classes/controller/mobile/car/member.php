<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mobile_Car_Member extends Stourweb_Controller
{
    /*
     * 租车订单总控制器
     * */

    private $_typeid = 3;
    private $_mid = '';
    private $_member='';

    public function before()
    {
        parent::before();

        $this->_member = Common::session('member');
        $this->_mid=$this->_member['mid'];

        if (empty($this->_mid))
        {
             Common::message(array('message' => __('unlogin'), 'jumpUrl' => $this->cmsurl . 'member/login'));
        }
        $this->assign('mid', $this->_mid);
        $this->assign('typeid', $this->_typeid);
    }

    public function action_orderlist()
    {

    }
    public function action_orderview()
    {
        $orderSn = Arr::get($_GET, 'ordersn');
        $info = Model_Member_Order::order_info($orderSn,$this->_mid);
        $model= ORM::factory('model',$info['typeid']);
        if(!$model->loaded())
            exit('paramaters error');

        $moduleinfo = $model->as_array();
        //当前版块是否是系统版块.
        $issystem =$moduleinfo['issystem'];
        $product = St_Product::get_product_info($info['typeid'],$info['productautoid']);
        $this->assign('product',$product);

        $suit = Model_Car_Suit::suit_info($info['suitid']);
        $status=DB::select()->from('car_order_status')->where('status','=',$info['status'])->and_where('is_show','=',1)->execute()->current();
        $info['statusname']=$status['status_name'];
        $this->assign('suit',$suit);
        $info = Pay_Online_Refund::get_refund_info($info);
        $this->assign('info', $info);
        $this->assign('issystem', $issystem);
        $this->display('../mobile/car/member/orderview');
    }
    //取消订单
    public function action_ajax_order_cancel()
    {
        $flag = 0;
        $orderId = Common::remove_xss(Arr::get($_GET, 'orderid'));
        $m = ORM::factory('member_order')->where("memberid={$this->_mid} and id={$orderId} and status < 2")->find();
        if ($m->loaded())
        {
            $orgstatus = $m->status;
            $m->status = 3;//取消订单
            $m->where("memberid={$this->_mid}");
            $m->update();
            if ($m->saved())
            {
                Model_Member_Order::back_order_status_changed($orgstatus,$m->as_array(),"Model_Car");
                $flag = 1;
            }
        }
        echo json_encode(array('status' => $flag));
    }



    /**
     * @function  退款页面
     */
    public function action_order_refund()
    {
        $ordersn = Common::remove_xss($_GET['ordersn']);
        if(!$ordersn)
        {
            exit();
        }

        $info = Model_Member_Order::order_info($ordersn,$this->_mid);
        if($info['status']!=2)
        {
            exit();
        }
        $online_transaction_no = json_decode($info['online_transaction_no'],true);
        if(!empty($online_transaction_no))
        {
            $info['refund_auto'] = 1 ;
        }

        $this->assign('info',$info);
        $this->display('../mobile/car/member/refund');
    }


    /**
     * @function 退款
     */
    public function action_ajax_order_refund()
    {
        $result = Pay_Online_Refund::apply_order_refund($_POST,$this->_mid,'Model_Car');
        echo json_encode($result);
    }


    //退款撤回
    public function action_ajax_order_refund_back()
    {
        $ordersn = Common::remove_xss(Arr::get($_POST, 'ordersn'));
        $result = Pay_Online_Refund::order_refund_back($ordersn,$this->_mid,'Model_Car');
        echo json_encode($result);


    }

}