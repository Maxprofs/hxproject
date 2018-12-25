<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 支付状态信息
 * Class Controller_Status
 */
class Controller_Status extends Stourweb_Controller
{
    private $_platFrom;
    //sign 状态信息
    private $_sign = array(
        //成功
        '11' => array('title' => '支付成功', 'msg' => '恭喜，支付成功!'),
        '12' => array('title' => '提交成功', 'msg' => '您的订单已提交成功，我们会尽快为您确认！'),
        '13' => array('title' => '预订成功', 'msg' => '预订成功'),
        '14' => array('title' => '预订成功', 'msg' => '您预定的是免费产品，平台确认后即可到店消费！'),
        '27' => array('title' => '等待确认', 'msg' => '您已成功提交订单，请等待商家确认产品余位。'),
        //失败
        '00' => array('title' => '支付失败', 'msg' => '对不起，支付失败！'),
        '01' => array('title' => '支付失败', 'msg' => '支付中断！'),
        //提示
        '21' => array('title' => '提示信息', 'msg' => '非法操作'),
        '22' => array('title' => '提示信息', 'msg' => '数字签名失败'),
        '23' => array('title' => '提示信息', 'msg' => '订单金额与实际支付不一致'),
        '24' => array('title' => '提示信息', 'msg' => '订单已支付'),
        '25' => array('title' => '提示信息', 'msg' => '订单号格式错误'),
        '26' => array('title' => '提示信息', 'msg' => '订单号不存在'),
        '28' => array('title' => '提示信息', 'msg' => '当前订单已失效'),
        '29' => array('title' => '提示信息', 'msg' => '订单的预定时间已超时，请重新下单')

    );

    /**
     * 初始化设置
     */
    public function before()
    {
        parent::before();
        $this->_platFrom = 'Pay_' . ucfirst(Common::C('platform'));
    }

    public function action_index()
    {
        $no = $_REQUEST['sign'];
        foreach ($this->_sign as $k => $v)
        {
            if ($no == md5($k))
            {
                $info = $v;
                $info['sign'] = $k;
            }
        }
        if (!isset($info))
        {
            $info = $this->_sign['21'];
        }
        //订单详情
        if (isset($_REQUEST['ordersn']) && !empty($_REQUEST['ordersn']))
        {
            $order = Model_Member_Order::info($_REQUEST['ordersn']);
            if (St_Functions::is_normal_app_install('red_envelope'))
            {
                $envelope_show = Model_Order_Envelope::pay_success_url($_REQUEST['ordersn']);
                $info['envelope_show'] = $envelope_show;
            }
            $info['productname'] = $order['productname'];
            $info['ordersn'] = $order['ordersn'];
            $info['total'] = $order['total'];
            $info['show'] = $order['show'];
            $info['order_id'] = $order['id'];
        }
        $platFrom = new $this->_platFrom();

        $this->response->body($platFrom->html($info));
    }
}
