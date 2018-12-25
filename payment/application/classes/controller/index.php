<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 支付类
 * Class Controller_Index
 */
class Controller_Index extends Stourweb_Controller
{
    //支付平台对象
    private $_platFrom;
    //模板目录
    private $_templte;
    //错误信息
    private $_error;

    private $_is_mobile = false;
    //错误提示
    const ORDERSN_ERROR = '订单错误';
    const ORDERSN_FORMAT_ERROR = '格式错误';
    const ORDERSN_NOT_EXISTS = '订单不存在';
    const ORDERSN_PAYED = '订单已支付';
    const TOKEN_ERROR = '口令错误';
    const POST_ERROR = '提交异常数据';
    const PRODUCT_NOT_EXISTS = '当前订单已失效';
    const ORDERSN_TIME_OUT = '订单的预定时间已超时，请重新下单';


    /**
     * 初始化支付对象
     */
    public function before()
    {
        parent::before();
        Common::C('base_url', $GLOBALS['base_url'] . Common::C('base_url'));
        $platFromClass = 'Pay_' . ucfirst(Common::C('platform'));
        $this->_platFrom = new $platFromClass();
        $this->_templte = Common::C('template_dir');
        //网站url
        $web_url = Common::get_main_host();
        //当前平台
        if(Common::C('platform') == 'mobile')
        {
            $this->_is_mobile = true;
            //手机域名检测
            $mobile_url = Common::C('cfg_m_main_url');
            if(empty($mobile_url) || $mobile_url == $web_url)
            {
                $url = $web_url.'/phone';
            }
            else
            {
                $url = $mobile_url;
            }

            $header = Request::factory($url.'/pub/header_new/typeid/0/ispaypage/1')->execute()->body();
        }
        else
        {
            $header = Request::factory($web_url.'/pub/header')->execute()->body();
        }


        $footer = Request::factory($web_url.'/pub/footer')->execute()->body();
        $this->assign('header',$header);
        $this->assign('footer',$footer);
    }

    /**
     * 支付页显示
     * URI:/payment/ $_POST数据
     */
    public function action_index()
    {

        $ordersn = $_REQUEST['ordersn'];
        $this->_ordersn_checked($ordersn);
        $info = Model_Member_Order::order_info($ordersn);

        //"0元"订单,免费产品
        if ($info['pay_price'] == 0)
        {
            St_Payment::zero_pay($ordersn);
        }
        //检查是否有附加产品

        $additional = DB::select()->from('member_order')->where('pid','=',$info['id'])->execute()->as_array();
        //单产品支付价格,在没有子产品的情况下等于订单总支付价格
        $info['single_pay_price'] = $info['pay_price'];
        if($additional)
        {
            foreach($additional as &$sub)
            {
                $sub = Model_Member_Order::order_info($sub['ordersn']);
                $info['single_pay_price'] = $info['single_pay_price'] - $sub['pay_price'];
            }
            $this->assign('additional',$additional);
        }
        //支付方式
        $pay_method = $this->_platFrom->pay_method();
        $info['series_number'] = St_Product::product_series($info['productautoid'],$info['typeid']);

        $this->assign('order',$info);
        $this->assign('pay_method',$pay_method);
        $this->assign('btn_title',$info['status']==0 ? '查看订单' : '立即支付');
        if(!$this->_is_mobile)
        {
            $this->display('pc/index');
        }
        else
        {
            $this->display('mobile/index');
        }


    }

    /**
     * 支付确认
     */
    public function action_confirm()
    {
        //支付宝支付在微信客户端里打开
        if (Common::C('platform') == 'mobile' && $_GET['method'] == 1 && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
        {
            $view = View::factory($this->_templte . "mobile/alipay_wxclient");

            $conf = require dirname(DOCROOT) . '/data/mobile.php';
            $url = Common::get_main_host() . '/phone/';
            if (stripos($conf['domain']['mobile'], $url) === false)
            {
                $url = $conf['domain']['mobile'];
            }
            $__url=explode('?',$_SERVER['HTTP_REFERER']);
            $back_url=$__url[0].'?'.$_SERVER['QUERY_STRING'];
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
                $this->_platFrom->content
            );
            exit($view);
        }
        //根据支付方式选择
        $this->_ordersn_checked($_GET['ordersn']);
        //支付数据格式化
        $info = Model_Member_Order::info($_GET['ordersn']);
        $platFrom = Common::C('platform');
        $conf = Common::C($platFrom);
        $className = 'Pay_' . ucfirst($platFrom) . '_' . $conf['method'][$_GET['method']]['en'];
        //实列化对象
        $obj = new $className();
        $isWx = $_GET['method'] == '8' ? 1 : 0;
        switch ($isWx)
        {
            //微信支付
            case 1:
                if ($platFrom == 'pc')
                {
                    //PC微信扫码支付
                    $pay_info = $obj->submit($info);
                    if ($pay_info)
                    {
                        $this->assign('src',$pay_info['src']);
                        $this->assign('sign',$pay_info['sign']);
                        $this->assign('ordersn',$pay_info['ordersn']);
                        $this->display('pc/wx_scan');

                    }
                }
                else
                {
                    //mobile 微信公众号
                    $arr = $obj->submit($info);
                    $view = View::factory($arr['template']);
                    $view->parameter = $arr['parameter'];
                    $view->productname = $arr['productname'];
                    $view->total_fee = $arr['total_fee'];
                    $view->addtime = date('Y-m-d H:i:s',$info['addtime']);
                    $view->ordersn = $info['ordersn'];
                    $this->response->body($view);
                }
                break;
            case 0:
                $obj->submit($info);
                break;
        }
    }

    /**
     * 检测订单号是否正确
     * @param $ordersn
     * @return bool
     */
    private function _ordersn_checked($ordersn)
    {
        $bool = false;
        $info['ordersn'] = $ordersn;
        $order_info = Model_Member_Order::order_info($ordersn);
        $product_info = Model_Model::get_product_bymodel($order_info['typeid'],$order_info['productautoid'],'id');
        if(empty($product_info) || empty($product_info[0]) || empty($product_info[0]['id']))
        {
            //订单号格式错误
            $info['sign'] = 28;
            new Pay_Exception("订单{$ordersn}" . self::PRODUCT_NOT_EXISTS);
        }
        else if (!preg_match('~^\d+$~', $ordersn))
        {
            //订单号格式错误
            $info['sign'] = 25;
            new Pay_Exception("订单{$ordersn}" . self::ORDERSN_FORMAT_ERROR);
        }
        else if (Model_Member_Order::not_exists($ordersn))
        {
            //订单不存在
            $info['sign'] = 26;
            new Pay_Exception("订单{$ordersn} " . self::ORDERSN_NOT_EXISTS);
        }
        else if (Model_Member_Order::payed($ordersn))
        {
            //订单已支付
            $info['sign'] = 24;
            new Pay_Exception("订单{$ordersn} " . self::ORDERSN_PAYED);
        }
        else if ($order_info['status']!=1)
        {
            //只有等待支付订单才能进行支付.
            $info['sign'] = 27;
            new Pay_Exception("订单{$ordersn} " . self::POST_ERROR);
        }
        else if (!Model_Model::check_usedate($order_info))
        {
            // 支付时间需在订单最晚预定时间内
            $info['sign'] = 29;
            new Pay_Exception("订单{$ordersn} " . self::ORDERSN_TIME_OUT);
        }
        else
        {
            $bool = true;
        }
        //订单号错误提示
        if (!$bool)
        {
            Common::pay_status($info);
        }
    }

    /**
     * AJAX 检测是否支付
     */
    public function action_ajax_ispay()
    {
        $result = array(
            'result' => false
        );
        if (preg_match('~^\d+$~', $_POST['ordersn']) && Model_Member_Order::payed($_POST['ordersn']))
        {
            $result['result'] = true;
        }
        echo json_encode($result);
    }
}