<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2017/7/19 14:27
 *Desc: 微信支付后台操作类
 */
class Controller_Mobile_Wxpay extends Stourweb_Controller
{
    //微信支付目录
    private $_wxpay_dir = '';
    //异步通知
    private $_notify_url = '';
    //日志目录
    const LOGSDIR = 'wxpay';

    public function before()
    {
        parent::before();
        $this->_wxpay_dir = WXPAY . 'vendor' . DS . 'mobile' . DS . 'wxpay' . DS;
        $domain = St_Functions::get_main_host();
        $m_main_url = $GLOBALS['cfg_m_main_url'];
//        $mobile_domain = $m_main_url == $domain ? $domain . '/phone' : $m_main_url;
        //增加手机域名为空时的判断
        if(empty($m_main_url) || $m_main_url == $domain)
        {
            $mobile_domain = $domain.'/phone';
        }
        else
        {
            $mobile_domain = $m_main_url;
        }
        $this->_notify_url = $mobile_domain . '/wxpay/mobile/notify_url';
        //绑定支付的APPID
        define('APPID', $GLOBALS['cfg_wxpay_appid']);
        //商户号
        define('MCHID', $GLOBALS['cfg_wxpay_mchid']);
        //商户支付密钥
        define('KEY', $GLOBALS['cfg_wxpay_key']);
        //公众帐号secert
        define('APPSECRET', $GLOBALS['cfg_wxpay_appsecret']);
    }

    public function action_index()
    {



        $ordersn = Common::remove_xss(Arr::get($_GET, 'ordersn'));
        $info = Model_Member_Order::info($ordersn);
        $info['typename'] = Model_Model::get_module_name($info['typeid']);
        self::_checked_ordersn($ordersn);
        $arr = $this->submit($info);
        $this->assign('parameter', $arr['parameter']);
        $this->assign('productname', $arr['productname']);
        $this->assign('total_fee', $arr['total_fee']);
        $this->assign('ordersn', $arr['ordersn']);
        $this->assign('addtime', date('Y-m-d H:i:s',$info['addtime']));
        $this->display('../mobile/wxpay/wx_jsapi');
    }

    /**
     * @function 检测订单状态
     * @param $ordersn
     * @return bool
     */
    private static function _checked_ordersn($ordersn)
    {
        $bool = false;
        $info['ordersn'] = $ordersn;
        if (! preg_match('~^\d+$~', $ordersn))
        {
            //订单号格式错误
            $info['sign'] = 25;
        }
        else if (Model_Member_Order::not_exists($ordersn))
        {
            //订单不存在
            $info['sign'] = 26;
        }
        else if (Model_Member_Order::payed($ordersn))
        {
            //订单已支付
            $info['sign'] = 24;
        }
        else
        {
            $bool = true;
        }
        //订单号错误提示
        if (! $bool)
        {
            St_Payment::pay_status($info);
            exit;
        }

        return $bool;
    }

    /**
     * @function 支付数据格式化
     * @param $data
     * @return array
     */
    public function submit($data)
    {
        require $this->_wxpay_dir . 'jsapi/index.php';

        $jsApiPay = new JsApiPay();
        $openId = $jsApiPay->GetOpenid();
        if (! isset($_GET['code']))
        {
            exit;
        }
        $input = new WxPayUnifiedOrder();
        $ordersn = Model_Wxpay::generate_ordersn($data['ordersn']);
        $input->SetBody($ordersn); //商品描述
        $input->SetAttach($data['remark']); //备注
        $input->SetOut_trade_no($ordersn); //商户订单号
        $input->SetTotal_fee($data['total'] * 100);//总金额,以分为单位
        $input->SetTime_start(date("YmdHis"));//交易起始时间
        $input->SetTime_expire(date("YmdHis", time() + 6000));//交易结束时间
        $input->SetGoods_tag("tag");//商品标记
        $input->SetNotify_url($this->_notify_url); //异步通知
        $input->SetTrade_type("JSAPI");
        $input->SetProduct_id($data['ordersn']);
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        //如果统一下单失败,跳转到支付错误页面.
        if($order['return_msg'] != '' && $order['return_code'] == 'FAIL' )
        {
            St_Payment::pay_failure($order['return_msg']);
            exit;
        }
        $jsApiParameters = $jsApiPay->GetJsApiParameters($order);
        $arr = array(
            'parameter'   => $jsApiParameters,
            'productname' => $data['productname'],
            'total_fee'   => $data['total'],
            'ordersn'     => $data['ordersn'],
            'template'    => WXPAY . 'views' . DIRECTORY_SEPARATOR  . 'mobile' . DIRECTORY_SEPARATOR . 'wx_jsapi.php',
        );

        return $arr;
    }

    /**
     * @function 微信支付异步通知回调地址
     */
    public function action_notify_url()
    {
        require $this->_wxpay_dir . 'jsapi/notify.php';
        $notify = new notify();
        self::_write_log($this->request->action());
        $notify->Handle(true);
    }

    /**
     * @function 将回调参数写入日志文件
     * @param $method
     */
    private static function _write_log($method)
    {
        $pay_class = __CLASS__;
        $base_path = rtrim(BASEPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'payment' . DIRECTORY_SEPARATOR;
        $pay_log_dir = $base_path . self::LOGSDIR . DIRECTORY_SEPARATOR . 'callback' . DIRECTORY_SEPARATOR;
        if (! file_exists($pay_log_dir))
        {
            mkdir($pay_log_dir, 0777, true);
        }
        //日志文件
        $file = $pay_log_dir . 'wxpay_wap_' . date('ymd') . '.txt';
        $data = "\r\n[{$method}:" . date('YmdHis');
        foreach ($_REQUEST as $k => $v)
        {
            $data .= " {$k}={$v}";
        }
        $data .= ']';
        file_put_contents($file, $data, FILE_APPEND);
    }

}