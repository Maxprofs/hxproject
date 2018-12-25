<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2017/7/19 14:27
 *Desc: PC端微信扫码支付
 */
class Controller_Pc_Wxpay extends Stourweb_Controller
{
    //微信支付目录
    private $_wxpay_dir = '';
    //异步通知
    private $_notify_url = '';
    //日志目录
    const LOGSDIR = 'wxpay';
    //通用部分(头、底部)
    public $content;

    public function before()
    {
        parent::before();
        $this->_wxpay_dir = WXPAY . 'vendor' . DS . 'pc' . DS . 'wxpay' . DS;
        $this->_notify_url = $GLOBALS['cfg_basehost'] . '/wxpay/pc/notify_url';

        //绑定支付的APPID
        define('APPID', $GLOBALS['cfg_wxpay_appid']);
        //商户号
        define('MCHID', $GLOBALS['cfg_wxpay_mchid']);
        //商户支付密钥
        define('KEY', $GLOBALS['cfg_wxpay_key']);
        //公众帐号secert
        define('APPSECRET', $GLOBALS['cfg_wxpay_appsecret']);
        //证书路径,注意应该填写绝对路径
        define('SSLCERT_PATH', WXPAY . 'vendor' . DIRECTORY_SEPARATOR . 'mobile/wxpay/cert/apiclient_cert.pem');

        define('SSLKEY_PATH', WXPAY . 'vendor' . DIRECTORY_SEPARATOR . 'mobile/wxpay/cert/apiclient_key.pem');

        //网站url
        $web_url = Common::get_main_host();
        $header = Request::factory($web_url.'/pub/header')->execute()->body();
        $footer = Request::factory($web_url.'/pub/footer')->execute()->body();
        $this->assign('header',$header);
        $this->assign('footer',$footer);

    }
    //扫码支付
    public function action_index()
    {
        $ordersn = Common::remove_xss(Arr::get($_GET, 'ordersn'));
        $info = Model_Member_Order::info($ordersn);
        $info['typename'] = Model_Model::get_module_name($info['typeid']);
        self::_checked_ordersn($ordersn);
        $pay_info = $this->submit($info);
        if ($pay_info)
        {
            $this->assign('src',$pay_info['src']);
            $this->assign('sign',$pay_info['sign']);
            $this->assign('ordersn',$pay_info['ordersn']);
            $this->display('wxpay/wx_scan');

        }

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
     * @function 提交数据
     * @param $data
     * @return bool|mixed
     */
    public function submit($data)
    {
        require $this->_wxpay_dir . 'native/index.php';
        $out = array();
        $notify = new NativePay();
        $input = new WxPayUnifiedOrder();
        $ordersn = Model_Wxpay::generate_ordersn($data['ordersn']);
        $input->SetBody($ordersn); //商品描述
        $input->SetAttach($data['remark']); //备注
        $input->SetOut_trade_no($ordersn); //商户订单号
        $input->SetTotal_fee($data['total'] * 100);//总金额,以分为单位
        $input->SetTime_start(date("YmdHis"));//交易起始时间
        $input->SetTime_expire(date("YmdHis", time() + 600));//交易结束时间
        $input->SetGoods_tag("");//商品标记
        $input->SetNotify_url($this->_notify_url); //异步通知
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($data['ordersn']);
        try
        {
            $result = $notify->GetPayUrl($input);
            if ($result['return_code'] == 'FAIL')
            {
                new Pay_Exception($result['return_msg'], 0, self::LOGSDIR);
                St_Payment::pay_failure($result['return_msg']);
                exit;
            }
            $src = $GLOBALS['cfg_basehost'] . '/res/vendor/qrcode/make.php?param=' . urlencode($result["code_url"]);

            $out['src'] = $src;
            $out['ordersn'] = $data['ordersn'];
            $out['sign'] = md5('11');
        }
        catch (WxPayException $e)
        {
            new Pay_Exception($e->errorMessage(), 0, self::LOGSDIR);
        }
        return $out;
    }

    /**
     * @function 微信支付异步通知回调地址
     */
    public function action_notify_url()
    {
        require $this->_wxpay_dir . 'native/notify.php';
        self::_write_log($this->request->action());
        $notify = new notify();
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
        $file = $pay_log_dir . str_replace('pay_', '', strtolower($pay_class)) . '_' . date('ymd') . '.txt';
        $data = "\r\n[{$method}:" . date('YmdHis');
        foreach ($_REQUEST as $k => $v)
        {
            $data .= " {$k}={$v}";
        }
        $data .= ']';
        file_put_contents($file, $data, FILE_APPEND);
    }

    /**
     * @function 检测是否支付
     */
    public function action_ajax_ispay()
    {
        $result = array(
            'result' => false,
        );
        if (preg_match('~^\d+$~', $_POST['ordersn']) && Model_Member_Order::payed($_POST['ordersn']))
        {
            $result['result'] = true;
        }
        echo json_encode($result);
    }

    /**
     * @function 获取远程数据
     * @param $url
     * @return mixed
     */
    public function file_get_content($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }
}