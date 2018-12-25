<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mobile_Line_member extends Stourweb_Controller
{
    /*
     * 线路订单总控制器
     * */

    private $_typeid = 1;
    private $_mid = '';
    private $_member='';

    public function before()
    {
        parent::before();

        $this->_member = Model_Member_Login::check_login_info();
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
        $ordersn = Arr::get($_GET, 'ordersn');
        $info = Model_Member_Order::order_info($ordersn, $this->_mid);

        $model = ORM::factory('model', $info['typeid']);
        if (!$model->loaded())
            exit('paramaters error');

        $moduleinfo = $model->as_array();
        //当前版块是否是系统版块.
        $issystem = $moduleinfo['issystem'];

        //订单的附加保险

        if (St_Functions::is_system_app_install(111))
        {
            $additional = DB::select()->from('member_order')->where('pid','=',$info['id'])->execute()->as_array();

            $this->assign('additional', $additional);

        }
        $product = St_Product::get_product_info($info['typeid'],$info['productautoid']);
        $this->assign('product',$product);
        $status=DB::select()->from('line_order_status')->where('status','=',$info['status'])->and_where('is_show','=',1)->execute()->current();
        $info['statusname']=$status['status_name'];
        preg_match('/\((.*?)\)/',$info['productname'],$match_arr);
        $info['suitname'] = $match_arr[1] ? $match_arr[1] : '';
        $info = Pay_Online_Refund::get_refund_info($info);
        if($info['contract_id']&&in_array($info['status'],array(2,5)))
        {
            $info['contract'] = Model_Contract::get_contents($info['contract_id'],$this->_typeid);
            $url = St_Functions::get_web_url(0).'/contract/view/ordersn/'.$ordersn.'/headhidden/1';
            $contract  =St_Network::http($url);
            $this->assign('contract',$contract);
        }
        $this->assign('info', $info);
        $this->assign('issystem', $issystem);
        $this->display('../mobile/line/member/orderview');
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
                Model_Member_Order::back_order_status_changed($orgstatus, $m->as_array(), "Model_Line");
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
        $this->display('../mobile/line/member/refund');
    }


    /**
     * @function 退款
     */
    public function action_ajax_order_refund()
    {
        $result = Pay_Online_Refund::apply_order_refund($_POST,$this->_mid,'Model_Line');
        echo json_encode($result);
    }


    //退款撤回
    public function action_ajax_order_refund_back()
    {
        $ordersn = Common::remove_xss(Arr::get($_POST, 'ordersn'));
        $result = Pay_Online_Refund::order_refund_back($ordersn,$this->_mid,'Model_Line');
        echo json_encode($result);


    }

    /**
     * @function  确认消费
     */
    public function action_ajax_order_confirm()
    {
        $ordersn = Common::remove_xss($_GET['ordersn']);
        if(!$ordersn)
        {
            exit();
        }
        $data = array(
            'status'=>5
        );
        $flag = DB::update('member_order')->set($data)->where('ordersn','=',$ordersn)->execute();
        if($flag)
        {
            $order = DB::select()->from('member_order')->where('ordersn', '=', $ordersn)->execute()->current();
            $status = Model_Member_Order::back_order_status_changed(2, $order, 'Model_Line');
            echo json_encode(array('status'=>$status,'msg'=>'操作成功'));

            echo json_encode(array('status'=>true));
        }
        else
        {
            echo json_encode(array('status'=>false));
        }


    }

}