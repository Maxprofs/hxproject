<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2017/7/18 16:52
 *Desc: PC端支付宝担保交易
 */
class Controller_Pc_Alipaydanbao extends Stourweb_Controller
{
    //支付id
    private $_id = 13;
    //支付宝担保交易目录
    private $_alipay_danbao_dir;
    //异步通知
    private $_notify_url = '';
    //同步通知
    private $_return_url = '';
    //日志目录
    const LOGSDIR = 'alipaydanbao';

    public function before()
    {
        parent::before();
        $this->_alipay_danbao_dir = ALIPAY . 'vendor' . DS . 'pc' . DS . 'alipay_danbao' . DS;
        $this->_notify_url = $GLOBALS['cfg_basehost'] . '/alipaydanbao/pc/notify_url';
        $this->_return_url = $GLOBALS['cfg_basehost'] . '/alipaydanbao/pc/return_url';
    }

    public function action_index()
    {
        $ordersn = Common::remove_xss(Arr::get($_GET, 'ordersn'));
        $info = Model_Member_Order::info($ordersn);
        $info['typename'] = Model_Model::get_module_name($info['typeid']);
        self::_checked_ordersn($ordersn);
        $this->submit($info);
        exit;
    }

    public function submit($data)
    {
        require_once($this->_alipay_danbao_dir . "lib/alipay_submit.class.php");
        //支付宝配置
        $alipay_config = $this->_alipay_config();
        //格式化提交数据
        $parameter = $this->_data_format($data, $alipay_config);
        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = '<style>form{display: none}</style>';
        $html_text .= $alipaySubmit->buildRequestForm($parameter, "post", '');
        echo $html_text;
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
     * @function 整合支付宝配置
     * @return mixed
     */
    private function _alipay_config()
    {
        //合作身份者id
        $alipay_config['partner'] = trim($GLOBALS['cfg_alipay_pid']);
        //收款支付宝账号
        $alipay_config['seller_email'] = trim($GLOBALS['cfg_alipay_account']);
        //安全检验码
        $alipay_config['key'] = trim($GLOBALS['cfg_alipay_key']);
        //签名方式
        $alipay_config['sign_type'] = strtoupper('MD5');
        //字符编码格式
        $alipay_config['input_charset'] = strtolower('utf-8');
        //ca证书路径地址，用于curl中ssl校验
        $alipay_config['cacert'] = $this->_alipay_danbao_dir . 'cacert.pem';
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport'] = 'http';

        return $alipay_config;
    }

    /**
     * @function 数据格式化
     * @param $data  订单详情
     * @param $conf  alipay_config 配置
     * @return array
     */
    private function _data_format($data, $conf)
    {
        $parameter = array(
            "service"           => "create_partner_trade_by_buyer",
            "partner"           => $conf['partner'], //合作身份者id
            "seller_email"      => $conf['seller_email'],//收款支付宝账号
            "payment_type"      => '1', //支付类型
            "notify_url"        => $this->_notify_url, //订单异步通知
            "return_url"        => $this->_return_url, //订单同步通知
            "out_trade_no"      => $data['ordersn'],  //订单编号
            "subject"           => $data['ordersn'], //订单标题
            "price"             => $data['total'], //订单单价
            'total_fee'         => $data['total'],//订单总金额
            "quantity"          => '1',//商品数量
            "logistics_type"    => 'EXPRESS', //物流类型
            "logistics_fee"     => '0.00', //物流费用
            "logistics_payment" => 'SELLER_PAY', //物流支付类型
            "body"              => $data['remark'], //订单备注
            "show_url"          => $data['show_url'], //产品详情页
            "_input_charset"    => trim(strtolower('utf-8')) //字符编码格式
        );

        return $parameter;
    }

    /**
     * @function 服务器异步通知页面路径
     * @return string
     */
    public function action_notify_url()
    {
        $bool = 'fail';
        include($this->_alipay_danbao_dir . 'lib/alipay_notify.class.php');
        $alipay_config = $this->_alipay_config();
        $alipayNotify = new AlipayNotify($alipay_config);
        $result = $alipayNotify->verifyNotify();
        if ($result)
        {
            //买家已经确认收货
            if ($_POST['trade_status'] == 'TRADE_FINISHED')
            {
                $tip = '信息:支付宝担保(异)交易,异步支付订单金额与实际支付不一致';
                if (St_Payment::total_fee_confirm($_POST['out_trade_no'], $_POST['total_fee'], $tip))
                {
                    $payset = Model_Payset::get_payset_info_by_id($this->_id);
                    St_Payment::pay_success($_POST['out_trade_no'], $payset['name'] . '(电脑端)');
                }
                $bool = 'success';
            }
            else
            {
                new Pay_Exception("状态:{$_POST['trade_status']}", 0, self::LOGSDIR);
            }
        }
        else
        {
            new Pay_Exception("信息:合法性验证失败", 0, self::LOGSDIR);
        }
        self::_write_log($this->request->action());

        return $bool;
    }

    /**
     * @function 页面跳转同步通知页面路径
     */
    public function action_return_url()
    {
        include($this->_alipay_danbao_dir . 'lib/alipay_notify.class.php');
        $alipay_config = $this->_alipay_config();
        $alipayNotify = new AlipayNotify($alipay_config);
        $result = $alipayNotify->verifyReturn();
        if ($result)
        {
            //判断该笔订单是否在商户网站中已经做过处理
            if ($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS')
            {
                $tip = '信息:支付宝担保(同)交易,同步支付订单金额与实际支付不一致';
                $info['sign'] = St_Payment::total_fee_confirm($_GET['out_trade_no'], $_GET['total_fee'], $tip) ? '11' : '23';
            }
            else
            {
                $info['sign'] = '00';
                new Pay_Exception("状态:{$_GET['trade_status']}", 0, self::LOGSDIR);
            }
        }
        else
        {
            $info['sign'] = '22';
            new Pay_Exception("状态:支付宝担保(同)交易数据有效性验证失败", 0, self::LOGSDIR);
        }
        $info['ordersn'] = $_GET['out_trade_no'];

        self::_write_log($this->request->action());
        St_Payment::pay_status($info);
    }

    /**
     * @function 将回调参数写入日志文件
     * @param $method
     */
    private static function _write_log($method)
    {
        $pay_class = __CLASS__;
        $base_path = rtrim(BASEPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR .
            'data' . DIRECTORY_SEPARATOR .
            'logs' . DIRECTORY_SEPARATOR .
            'payment' . DIRECTORY_SEPARATOR;
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
}