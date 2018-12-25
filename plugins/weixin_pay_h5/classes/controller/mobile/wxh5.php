<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Mobile_Wxh5 extends Stourweb_Controller{
    /*
     * 微信h5支付控制器
     * */
    public function before()
    {
        parent::before();
    }
    //请求支付
    public function action_index()
    {

        

        $ordersn = St_Filter::remove_xss(Arr::get($_GET,'ordersn'));
        $info = Model_Member_Order::order_info($ordersn);
        $this->_ordersn_checked($ordersn);
        $params = array();
        $ordersn = Model_Wxpay::generate_ordersn($info['ordersn']);
        $params['total_fee'] = $info['payprice'] *100;
        $params['body'] = $ordersn;
        $params['out_trade_no'] = $ordersn;
        //同步跳转地址
        //$params["return_url"] = $GLOBALS['cfg_basehost'].'/phone/member#&myOrder';
		$params["return_url"] = St_Functions::get_mobile_url().'/member#&myOrder';
        //$params["return_url"] = $GLOBALS['cfg_basehost'].'/payment/status/index/?sign='.md5('11').'&ordersn='.$info['ordersn'];

        //异步回调
        $params["notify_url"] =  $GLOBALS['cfg_basehost'].'/wxh5/mobile/notify_url';
        $params['basehost'] = $GLOBALS['mobile_host'];

        //统一下单,跳转支付
        $wx = new Model_Weixin();
        $url = $wx->unifiedOrder($params);
		if($url)
		{
			$this->_goto_pay($url);
			
		}




    }
    //同步回调
    public function action_return_url()
    {



    }
    //异步回调
    public function action_notify_url()
    {
		
		//file_put_contents(WXH5.'notify.txt', $GLOBALS['HTTP_RAW_POST_DATA']);
        $notify = new Model_Notify();
        $notify->Handle(true);

    }
	
	private function _goto_pay($url)
	{
		echo "<script>location.href='".$url."';</script>";
		exit;
		
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
        if (!preg_match('~^\d+$~', $ordersn))
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

        if (!$bool)
        {
            St_Payment::pay_status($info);
        }
    }













}