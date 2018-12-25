<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2017/12/26 11:57
 *Desc: 收入审核
 */
class Controller_Pc_Platform_Income extends Stourweb_Controller
{
    public function before()
    {
        parent::before();
    }

    public function action_order_listener()
    {
        $ordersn = Common::remove_xss(Arr::get($_GET, 'ordersn'));
        $order = Model_Member_Order::order_info($ordersn);
        if (! $order)
        {
            exit(json_encode(array('status' => 1, 'msg' => '订单不存在')));
        }
        if (2 != $order['status'])
        {
            exit(json_encode(array('status' => 1, 'msg' => '非已支付状态')));
        }
        if ($order['payprice'] <= 0)
        {
            exit(json_encode(array('status' => 1, 'msg' => '支付金额小于或等于0')));
        }
        //$member = Model_Member::get_member_byid($order['memberid']);
        $model = Model_Model::get_module_info($order['typeid']);
        $arr = array(
            'ordersn'   => $order['ordersn'],
            'type_id'   => $order['typeid'],
            'amount'    => $order['payprice'],
            'mid'       => $order['memberid'],
            'pdt_type'  => $model['modulename'],
            'pdt_name'  => $order['productname'],
            'pay_time'  => $order['paytime'],
            'pay_type'  => $order['paysource'],
            'pay_num'   => $order['online_transaction_no'],
            'pay_proof' => $order['payment_proof'],
            'salesman'  => $order['saleman'],
            'linkman'   => $order['linkman'],
            'linktel'   => $order['linktel'],
            'status'    => 0,
        );

        if (Model_Platform_Income::save_info($arr))
        {
            exit(json_encode(array('status' => 1, 'msg' => '已添加收入记录')));
        }

        exit(json_encode(array('status' => 1, 'msg' => '添加收入记录失败')));
    }
}