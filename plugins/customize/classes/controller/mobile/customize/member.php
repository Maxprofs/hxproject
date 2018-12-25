<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mobile_Customize_member extends Stourweb_Controller
{

    private $_typeid = 14;
    private $_mid = '';
    private $_user='';
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
        $orderSn = Arr::get($_GET, 'ordersn');
        $info = Model_Member_Order::order_info($orderSn,$this->_mid);
        $model= ORM::factory('model',$info['typeid']);
        if(!$model->loaded())
        {
            exit('paramaters error');
        }

        $moduleinfo = $model->as_array();

        $customize_info = ORM::factory('customize',$info['productautoid'])->as_array();
        $customize_info['linedoc'] = unserialize($customize_info['linedoc']);
        $customize_info['totalnum'] = intval($customize_info['adultnum'])+intval($customize_info['childnum']);
        $customize_info['maxjifentprice'] = floor($customize_info['maxtpricejifen']/$GLOBALS['cfg_exchange_jifen']);

        $extend_info = Model_Customize::get_extend_info($customize_info['id']);

        $extend_fields=Model_Customize_Extend_Field_Desc::get_fields();
        foreach($extend_fields as $k=>$v)
        {
            if(empty($extend_info[$v['fieldname']]))
            {
                unset($extend_fields[$k]);
            }
        }
        $supplier = DB::select()->from('supplier')->where('id','=',$customize_info['supplierlist'])->execute()->current();

        //当前版块是否是系统版块.
        $issystem =$moduleinfo['issystem'];
        $this->assign('info', $info);
        $this->assign('customize_info',$customize_info);
        $this->assign('extend_fields',$extend_fields);
        $this->assign('extend_info',$extend_info);
        $this->assign('supplier',$supplier);
        $this->assign('user',$this->_user);
        $this->assign('issystem', $issystem);
        $this->display('../mobile/customize/member/orderview');
    }
    public function action_order_save()
    {

        $customizeid = $_POST['customizeid'];
        $customize_model = ORM::factory('customize',$customizeid);
        $order_model = ORM::factory('member_order')->where('typeid','=',$this->_typeid)->and_where('productautoid','=',$customizeid)->find();
        $order_info = $order_model->as_array();
        if(!$customize_model->loaded() || !$customize_model->loaded())
        {
            echo '未知错误';
            return;
        }


        //发票信息
        $isneedbill = $_POST['isneedbill'];
        if($isneedbill==1)
        {
            $bill_model = ORM::factory('member_order_bill')->where('orderid','=',$order_model->id)->find();
            $bill_model->title=$_POST['bill_title'];
            $bill_model->receiver=$_POST['bill_receiver'];
            $bill_model->mobile=$_POST['bill_phone'];
            $bill_model->province=$_POST['bill_prov'];
            $bill_model->city=$_POST['bill_city'];
            $bill_model->address=$_POST['bill_address'];
            $bill_model->orderid = $order_model->id;
            $bill_model->save();
        }


        //优惠券
        $couponid = intval(Arr::get($_POST, 'couponid'));
        if($couponid)
        {
            $cid = DB::select('cid')->from('member_coupon')->where("id=$couponid")->execute()->current();
            $totalprice = Model_Coupon::get_order_totalprice($order_info);
            $ischeck =  Model_Coupon::check_samount($couponid,$totalprice,1,$order_info['id']);
            if($ischeck['status']==1)
            {
                Model_Coupon::add_coupon_order($cid,$order_info['ordersn'],$totalprice,$ischeck,$couponid); //添加订单优惠券信息
            }
        }

        //游客
        $tourer = array();
        $tourername_arr = $_POST['t_tourername'];
        $cardtype_arr = $_POST['t_cardtype'];
        $cardnumber_arr = $_POST['t_cardnumber'];
        $tourerid_arr = $_POST['t_touerid'];
        foreach ($tourername_arr as $k=>$v)
        {
            $tourer[] = array(
                'name' => $v,
                'cardtype' => $cardtype_arr[$k],
                'cardno' => $cardnumber_arr[$k],
                'id'=>$tourerid_arr[$k]

            );
        }
        $this->add_up_tourer($order_info['id'], $tourer, $this->_mid);

        //积分
        $usejifen = 0;
        $needjifen = intval($_POST['needjifen']);
        if ($needjifen && $order_model->usejifen!=1)
        {
            $jifentprice = floor($needjifen/$GLOBALS['cfg_exchange_jifen']);
            if ($jifentprice>0)
            {
                $usejifen = 1;
            }
            $order_model->usejifen = $usejifen;
            $order_model->needjifen = $needjifen;
            $order_model->jifentprice = $jifentprice;
        }

        $order_model->save();
        if ($order_model->usejifen && $order_model->needjifen)
        {
            Model_Member_Jifen::deduct($order_model->ordersn);
        }

        Common::session('_platform', 'pc');
        $payurl = Common::get_main_host() . "/payment/?ordersn=" . $order_model->ordersn;
        $this->request->redirect($payurl);
    }
    //取消订单
    public function action_ajax_order_cancel()
    {
        $flag = 0;
        $orderId =$_GET['orderid'];
        $m = ORM::factory('member_order')->where("memberid={$this->_mid} and id={$orderId} and status < 2")->find();
        if ($m->loaded())
        {
            $orgstatus = $m->status;
            $m->status = 3;//取消订单
            $m->where("memberid={$this->_mid}");
            $m->update();
            if ($m->saved())
            {
                Model_Member_Order::back_order_status_changed($orgstatus,$m->as_array(),"Model_Customize");
                $flag = 1;
            }
        }
        echo json_encode(array('status' => $flag));
    }
    //退款
    public function action_ajax_order_refund()
    {
        $ordersn = Common::remove_xss(Arr::get($_POST, 'ordersn'));
        $reason = Common::remove_xss(Arr::get($_POST, 'reason'));
        $order = DB::select()->from('member_order')->where('memberid', '=', $this->_mid)->and_where('status', '=', 2)->and_where('ordersn', '=', $ordersn)->execute()->current();
        if (!$order)
        {
            exit;
        }
        $row = DB::update('member_order')->set(array('status' => 6, 'refund_reason' => $reason))->where('id', '=', $order['id'])->execute();
        if ($row)
        {
            $order = DB::select()->from('member_order')->where('id', '=', $order['id'])->execute()->current();
            Model_Member_Order::back_order_status_changed(2,$order,"Model_Customize");
            $updateData = array('orderid' => $order['id'], 'prev_status' => 2, 'current_status' => 6, 'description' => __('您已成功提交退款申请，您的退款商家正在确认中，请稍后。') . '<p>' . __('退款原因：') . $reason . '<p>', 'addtime' => time());
            DB::insert('member_order_log', array_keys($updateData))->values(array_values($updateData))->execute();
            $result = array('bool' => true, 'message' => __('退款请求提交成功，等待商家确认'));
        }
        else
        {
            $result = array('bool' => true, 'message' => __('退款请求提交失败，请稍后再试'));
        }
        echo json_encode($result);
    }

    //退款撤回
    public function action_ajax_order_refund_back()
    {
        $ordersn = Common::remove_xss(Arr::get($_POST, 'ordersn'));
        $order = DB::select()->from('member_order')->where('memberid', '=', $this->_mid)->and_where('ordersn', '=', $ordersn)->execute()->current();
        if (!$order)
        {
            exit;
        }
        $result = array('bool' => true, 'message' => __('不同意您的申请，详情请联系商家'));
        if ($order['status'] == 6)
        {
            $row = DB::update('member_order')->set(array('status' => 2))->where('id', '=', $order['id'])->execute();
            if ($row)
            {
                $order = DB::select()->from('member_order')->where('id', '=', $order['id'])->execute()->current();
                Model_Member_Order::back_order_status_changed(6,$order,"Model_Customize");
                $updateData = array('orderid' => $order['id'], 'prev_status' => 6, 'current_status' => 2, 'description' => __('您提交取消退款申请，商家同意您的请求'), 'addtime' => time());
                DB::insert('member_order_log', array_keys($updateData))->values(array_values($updateData))->execute();
                $result = array('bool' => true, 'message' => __('商家同意您的申请'));
            }
        }
        else if ($order['status'] == 4)
        {
            $result = array('bool' => false, 'message' => __('商家已退款，您的申请未通过'));
        }
        echo json_encode($result);
    }
}