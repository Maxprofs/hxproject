<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Line_member extends Stourweb_Controller
{
    /*
     * 线路订单总控制器
     * */

    private $_typeid = 1;
    private $_mid = '';

    public function before()
    {
        parent::before();
        //检查缓存
        $this->refer_url = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $GLOBALS['cfg_cmsurl'];
        $this->assign('backurl', $this->refer_url);
        $user = Model_Member::check_login();
        $this->user=$user;
        if (!empty($user['mid']))
        {
            $this->_mid = $user['mid'];
        }
        else
        {
            $this->request->redirect('member/login');
        }
        $this->assign('mid', $this->_mid);
        $this->assign('typeid', $this->_typeid);
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

        $out = Model_Member_Order::order_list($this->_typeid, $this->_mid, $orderType, $page, $pageSize);

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
        $this->display('line/member/orderlist');

    }

    public function action_orderview()
    {
        $orderSn = Arr::get($_GET, 'ordersn');
        if ($this->user['bflg']==0) {
            $info = Model_Member_Order::order_info($orderSn, $this->_mid);
        }elseif($this->user['bflg']==1){
            $info = Model_Member_Order::order_info($orderSn);
        }
        

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
        $info['statusname']=$status['status_name'];
        preg_match('/\((.*?)\)/',$info['productname'],$match_arr);
        $info['suitname'] = $match_arr[1] ? $match_arr[1] : '';
        $info = Pay_Online_Refund::get_refund_info($info);

        if($info['contract_id']&&in_array($info['status'],array(2,5)))
        {
            $info['contract'] = Model_Contract::get_contents($info['contract_id'],$this->_typeid);
        }
        $this->assign('info', $info);
        $this->assign('issystem', $issystem);
        $this->display('line/member/orderview');
    }

    //取消订单
    public function action_ajax_order_cancel()
    {

        $flag = 0;
        $orderId = Common::remove_xss(Arr::get($_GET, 'orderid'));
        $m = ORM::factory('member_order')->where("memberid={$this->_mid} and id={$orderId} and status < 2")->find();
        if ($this->mid!=$m['memberid']) {
            echo json_encode(array('status' => $flag));
            return;
        }
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

    //确认消费
    public function action_ajax_order_consume_confirm()
    {
        $ordersn = Common::remove_xss(Arr::get($_POST, 'ordersn'));
        $data = array('status'=>5);
        $flag = DB ::update('member_order')->set($data)->where('ordersn','=',$ordersn)->execute();
        if($flag){
            $order = DB::select()->from('member_order')->where('ordersn', '=', $ordersn)->execute()->current();
            $status = Model_Member_Order::back_order_status_changed(2, $order, 'Model_Line');
            echo json_encode(array('status'=>$status,'msg'=>'操作成功'));
        }else{
            echo json_encode(array('status'=>false,'msg'=>'操作失败'));
        }

    }
}