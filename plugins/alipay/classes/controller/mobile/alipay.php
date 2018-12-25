<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2017/7/18 14:07
 *Desc: WAP端支付宝支付
 */
class Controller_Mobile_Alipay extends Stourweb_Controller
{
    private $_id = 1;
    //支付宝即时交易目录
    private $_alipay_dir;
    //异步通知
    private $_notify_url;
    //同步通知
    private $_return_url;
    //操作中断返回地址
    private $_error_url;
	//不同版本下获取头部底部
    public $content;

    public function before()
    {
        parent::before();
        $this->_alipay_dir = ALIPAY . 'vendor' . DS . 'mobile' . DS . 'alipay' . DS;
        $this->_notify_url = $GLOBALS['cfg_basehost'] . '/alipay/mobile/notify_url/';
        $this->_return_url = $GLOBALS['cfg_basehost'] . '/alipay/mobile/return_url/';
        $this->_error_url = $GLOBALS['cfg_basehost'] . '/alipay/mobile/error_url/';
		
		if (empty($this->content))
        {
            $temp = rtrim(BASEPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR .
                'data' . DIRECTORY_SEPARATOR .
                'cache' . DIRECTORY_SEPARATOR .
                'payment' . DIRECTORY_SEPARATOR .
                'common' . DIRECTORY_SEPARATOR;
            $file = $temp . 'mobile.php';

            if (file_exists($file) && (time() - filemtime($file)) < 600)
            {
                $this->content = file_get_contents($file);
            }
            else
            {
                if (!file_exists(dirname($file)))
                {
                    mkdir(dirname($file), 0777, true);
                }
                $this->content = $this->file_get_content(Common::get_main_host() . '/phone/pub/pay');
                file_put_contents($file, $this->content);
            }
        }
    }

    /**
     * @function 支付宝支付入口
     */
    public function action_index()
    {

		//支付宝微信客户端
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
        {
            $view = View::factory( 'mobile' . DIRECTORY_SEPARATOR . 'alipay_wxclient');

            $conf = require dirname(DOCROOT) . '/data/mobile.php';
            $__url=explode('?',$_SERVER['HTTP_REFERER']);
            $back_url=$__url[0].'?'.$_SERVER['QUERY_STRING'];
            $url = Common::get_main_host() . '/phone/';
            //增加手机域名为空时的判断
            if (stripos($conf['domain']['mobile'], $url) === false&&!empty($conf['domain']['mobile']))
            {
                $url = $conf['domain']['mobile'];
            }
            $view = str_replace(
                array(
                    '<stourweb_pay_content/>',
                    '<stourweb_title/>',
                    '确认订单',
                    '产品支付',
                    'href="'.$url.'"'
                ),
                array(
                    $view->render(),
                    '支付宝微信端支付',
                    '订单支付',
                    '订单支付',
                    'href="'.$back_url.'"'
                ),
                $this->content
            );
            exit($view);
        }
        $ordersn = Common::remove_xss(Arr::get($_GET, 'ordersn'));
        $info = Model_Member_Order::info($ordersn);
        $info['typename'] = Model_Model::get_module_name($info['typeid']);
        self::_checked_ordersn($ordersn);
        $this->submit($info);
        exit;
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
     * @function 提交订单数据
     * @param $data
     */
    public function submit($data)
    {
        require_once($this->_alipay_dir . "lib/alipay_submit.class.php");
        //支付宝配置
        $alipay_config = $this->_alipay_config();
        //格式化提交数据
        $parameter = $this->_data_code($data, $alipay_config);
        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        //获取token
        $html_text = $alipaySubmit->buildRequestHttp($parameter);
        $html_text = urldecode($html_text);
        //获取request_token
        $para_html_text = $alipaySubmit->parseResponse($html_text);
        $request_token = $para_html_text['request_token'];
        //根据request_token重新封装数据
        $req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';
        $parameter["req_data"] = $req_data;
        $parameter["service"] = "alipay.wap.auth.authAndExecute";
        //提交数据
        $html_text = '<style>form{display: none}</style>';
        $html_text .= $alipaySubmit->buildRequestForm($parameter, "get", '确认');
        echo $html_text;
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
        //$alipay_config['seller_id'] = $alipay_config['partner'];
        //签名方式
        $alipay_config['sign_type'] = strtoupper('MD5');
        //字符编码格式
        $alipay_config['input_charset'] = strtolower('utf-8');
        //ca证书路径地址，用于curl中ssl校验
        $alipay_config['cacert'] = $this->_alipay_dir . 'cacert.pem';
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport'] = 'http';
        //安全检验码，以数字和字母组成的32位字符
        $alipay_config['key'] = trim($GLOBALS['cfg_alipay_key']);

        //返回参数
        return $alipay_config;
    }

    /**
     * @function 数据格式化
     * @param $data  订单详情
     * @param $conf  alipay_config 配置
     * @return array
     */
    private function _data_code($data, $conf)
    {
        $req_data = '<direct_trade_create_req><notify_url>' .
            $this->_notify_url .
            '</notify_url><call_back_url>' .
            $this->_return_url .
            '</call_back_url><seller_account_name>' .
            $GLOBALS['cfg_alipay_account'] .
            "</seller_account_name><out_trade_no>{$data['ordersn']}</out_trade_no><subject>{$data['ordersn']}</subject><total_fee>{$data['total']}</total_fee><merchant_url>" .
            $this->_error_url .
            "</merchant_url></direct_trade_create_req>";

        $parameter = array(
            "service"        => "alipay.wap.trade.create.direct",
            "partner"        => $conf['partner'],
            "sec_id"         => trim($conf['sign_type']),
            "format"         => 'xml',
            "v"              => '2.0',
            "req_id"         => date('Ymdhis'),
            "req_data"       => $req_data,
            "_input_charset" => strtolower('utf-8'),
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
        include($this->_alipay_dir . 'lib/alipay_notify.class.php');
        $alipay_config = $this->_alipay_config();
        $alipayNotify = new AlipayNotify($alipay_config);
        $result = $alipayNotify->verifyNotify();
        if ($result)
        {
            $doc = new DOMDocument();
            if ($alipay_config['sign_type'] == 'MD5')
            {
                $doc->loadXML($_POST['notify_data']);
            }
            if ($alipay_config['sign_type'] == '0001')
            {
                $doc->loadXML($alipayNotify->decrypt($_POST['notify_data']));
            }
            if (! empty($doc->getElementsByTagName("notify")
                            ->item(0)->nodeValue)
            )
            {
                //商户订单号
                $out_trade_no = $doc->getElementsByTagName("out_trade_no")
                                    ->item(0)->nodeValue;
                //交易状态
                $trade_status = $doc->getElementsByTagName("trade_status")
                                    ->item(0)->nodeValue;
                //总金额
                $total_fee = $doc->getElementsByTagName("total_fee")
                                 ->item(0)->nodeValue;
                //流水号
                $trade_no = $doc->getElementsByTagName("trade_no")
                    ->item(0)->nodeValue;
                if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS')
                {
                    if (St_Payment::total_fee_confirm($out_trade_no, $total_fee, '信息:支付宝手机支付(异),订单金额与实际支付不一致'))
                    {
                        $payset = Model_Payset::get_payset_info_by_id($this->_id);
                        St_Payment::pay_success($out_trade_no, $payset['name'] . '(手机端)');
                        //写入支付宝流水号
                        $online_transaction_no = array('source'=>'alipay','transaction_no'=>$trade_no);
                        DB::update('member_order')->set(array('online_transaction_no'=>json_encode($online_transaction_no)))
                            ->where('ordersn','=',$out_trade_no)
                            ->execute();
                    }
                    $bool = 'success';
                }
                else
                {
                    new Pay_Exception("状态:{$trade_status}");
                }
            }
        }
        else
        {
            new Pay_Exception("信息:合法性验证失败");
        }
        self::_write_log($this->request->action());

        return $bool;
    }

    /**
     * @function 页面跳转同步通知页面路径
     */
    public function action_return_url()
    {
        include($this->_alipay_dir . 'lib/alipay_notify.class.php');
        $alipay_config = $this->_alipay_config();
        $alipayNotify = new AlipayNotify($alipay_config);
        $result = $alipayNotify->verifyReturn();
        if ($result)
        {
            $info['sign'] = $_GET['result'] == 'success' ? '11' : '00';
        }
        else
        {
            $info['sign'] = '22';
            new Pay_Exception("信息:支付宝手机支付(同)合法性验证失败");

        }
        $info['ordersn'] = $_GET['out_trade_no'];
        self::_write_log($this->request->action());

        St_Payment::pay_status($info);
    }

    /**
     * @function 支付终端操作
     */
    public function action_error_url()
    {
        $info['sign'] = '01';
        $info['ordersn'] = $_GET['out_trade_no'];
        St_Payment::pay_status($info);
    }

    /**
     * @function 将回调参数写入日志文件
     * @param $method
     */
    private static function _write_log($method)
    {
        $pay_class = __CLASS__;
        $pay_log_dir = APPPATH . 'logs/pay/';
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
     * @function 获取远程数据
     * @param $url
     * @return mixed
     */
    public function file_get_content($url) {
        $ch=  curl_init($url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}