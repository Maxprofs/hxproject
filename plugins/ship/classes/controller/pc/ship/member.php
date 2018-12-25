<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Ship_Member extends Stourweb_Controller
{
    /*
     * 租车总控制器
     * */

    private $_typeid = 104;
    private $_mid = '';

    public function before()
    {
        parent::before();
        //检查缓存
        $this->refer_url = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $GLOBALS['cfg_cmsurl'];
        $this->assign('backurl', $this->refer_url);
        $user = Model_Member::check_login();
        if (!empty($user['mid']))
        {
            $this->_mid = $user['mid'];
        }
        else
        {
            $this->request->redirect('member/login');
        }
        $this->assign('mid', $this->_mid);
        $this->assign('typeid',$this->_typeid);
    }
    public function action_orderlist()
    {

        $pageSize = 10;
        $orderType = $_GET['ordertype'];
        $orderType = $orderType ? $orderType : 'all';
        $page = intval($_GET['p']);
        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
            'ordertype' => $orderType,
        );

        $out = Model_Member_Order::order_list($this->_typeid, $this->_mid, $orderType, $page,$pageSize);

        $pager = Pagination::factory(
            array(
                'current_page' => array('source' => 'query_string', 'key' => 'p'),
                'view' => 'default/pagination/search',
                'total_items' => $out['total'],
                'items_per_page' => $pageSize,
                'first_page_in_url' => false,
            )
        );
        //配置访问地址 当前控制器方法
        $pager->route_params($route_array);
        $this->assign('pageinfo', $pager);
        $this->assign('list', $out['list']);
        $this->assign('ordertype', $orderType);
        $this->display('ship/member/orderlist');

    }
    public function action_orderview()
    {
        $orderSn = Arr::get($_GET, 'ordersn');
        $info = Model_Member_Order::order_info($orderSn,$this->_mid);
        $issystem = ORM::factory('model', $info['typeid'])->get('issystem');
        $sublist =DB::select()->from('member_order_child')->where('pid','=',$info['id'])->execute()->as_array();
        $tourlist = DB::select()->from('member_order_tourer')->where('orderid','=',$info['id'])->execute()->as_array();

        $status=DB::select()->from('ship_order_status')->where('status','=',$info['status'])->and_where('is_show','=',1)->execute()->current();
        $info['statusname']=$status['status_name'];
        $info = Pay_Online_Refund::get_refund_info($info);
        $this->assign('info', $info);

        $this->assign('sublist',$sublist);
        $this->assign('tourlist',$tourlist);
        $this->display('ship/member/orderview');
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
                Model_Member_Order::back_order_status_changed($orgstatus,$m->as_array(),"Model_Ship_Line");
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

        $online_transaction_no = json_decode($info['online_transaction_no'],true);
        if(!empty($online_transaction_no))
        {
            $info['refund_auto'] = 1 ;
        }
        if(!$ordersn)
        {
            exit();
        }
        $this->assign('info',$info);
        $this->display('member/order/refund');
    }

    /**
     * @function 退款
     */
    public function action_ajax_order_refund()
    {
        $result = Pay_Online_Refund::apply_order_refund($_POST,$this->_mid,'Model_Ship_Line');
        echo json_encode($result);
    }


    //退款撤回
    public function action_ajax_order_refund_back()
    {
        $ordersn = Common::remove_xss(Arr::get($_POST, 'ordersn'));
        $result = Pay_Online_Refund::order_refund_back($ordersn,$this->_mid,'Model_Ship_Line');
        echo json_encode($result);


    }
}