<?php
/**
 * Copyright:www.deccatech.cn
 * Author: netman
 * QQ: 1649513971
 * Time: 2017/7/4 16:36
 * Desc:微信模型类
 */
include_once WXH5.'vendor/weixin/lib/WxPay.Api.php';

Class Model_Weixin{

    public function __construct()
    {
        $this->_set_account_info();
    }

    /**
     * @function h5支付统一下单
     * @param $params
     */
    public function unifiedOrder($params)
    {


        $input = new WxPayUnifiedOrder();
        //商品描述
        $input->SetBody($params['body']);
        //附加数据
        $input->SetAttach("weixin_h5_pay");
        //订单号 ordersn
        $input->SetOut_trade_no($params['out_trade_no']);
        //费用,单位为分
        $input->SetTotal_fee($params['total_fee']);
        //交易开始时间
        $input->SetTime_start(date("YmdHis"));
        //订单失效时间 24小时失效
        $input->SetTime_expire(date("YmdHis", time() + 3600*24));
        //$input->SetGoods_tag("test");
        //回调地址
        $input->SetNotify_url($params['notify_url']);
        //交易类型,固定为微信h5支付
        $input->SetTrade_type("MWEB");
        //设置场景信息
        $sence_info = '{"h5_info": {"type":"Wap","wap_url": "'.$params['basehost'].'","wap_name": "'.$GLOBALS['cfg_webname'].'"}}';
        $input->SetSceneinfo($sence_info);

        $input->SetSpbill_create_ip(St_Functions::get_ip());//终端ip 

        $unifiedOrderResult = WxPayApi::unifiedOrder($input);
		//print_r($unifiedOrderResult);

        //商户根据实际情况设置相应的处理流程
        if ($unifiedOrderResult["return_code"] == "FAIL")
        {
            //商户自行增加处理流程
            echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
			exit;
        }
        elseif($unifiedOrderResult["result_code"] == "FAIL")
        {
            //商户自行增加处理流程
            echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
            echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
			exit;
        }
        //下单成功,跳转mweb_url 开始支付
        else
        {
            $mweb_url = $unifiedOrderResult['mweb_url'];
            if($params['return_url'])
            {
                $mweb_url.='&redirect_url='.urlencode($params['return_url']);
            }
			return $mweb_url;
            

        }



    }



    /**
     * @function 设置微信帐号相关的信息
     */
    private function _set_account_info()
    {

        //帐户配置信息
        $config = Kohana::$config->load('wxh5')->as_array();
        WxPayConfig::$appid = $config['appid'];
        WxPayConfig::$appsecret = $config['appsecret'];
        WxPayConfig::$mchid = $config['mchid'];
        WxPayConfig::$key = $config['mchkey'];
    }


}


