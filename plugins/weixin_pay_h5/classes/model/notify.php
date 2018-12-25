<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Copyright:www.deccatech.cn
 * Author: netman
 * QQ: 1649513971
 * Time: 2017/7/5 10:07
 * Desc: 微信支付回调
 */

require_once WXH5 . 'vendor/weixin/lib/WxPay.Api.php';
require_once WXH5 . 'vendor/weixin/lib/WxPay.Notify.php';

/**
 * 微信支付回调类
 * Class notify
 */
class Model_Notify extends WxPayNotify
{

    public function __construct()
    {
        $this->_set_account_info();
    }

    /**
     * 重写父类异步验证
     * @param array $data
     * @param string $msg
     * @return bool
     */
    public function NotifyProcess($data, &$msg)
    {
        //


        $bool = false;
        //返回状态码、业务结果
        if (array_key_exists("return_code", $data) && array_key_exists("result_code", $data) && $data['return_code'] == 'SUCCESS' && $data['result_code'] == 'SUCCESS')
        {
            //查询订单
            if (isset($data["out_trade_no"]) && $data["out_trade_no"] != "")
            {
                //这里针对微信订单号作特殊处理,去掉后面的12位字符
                $ordersn = substr($data['out_trade_no'],0,strlen($data['out_trade_no'])-12);

                //检测是支付金额是否一致.
                if(St_Payment::total_fee_confirm($ordersn, $data['total_fee']/100))
                {
                    St_Payment::pay_success($ordersn,'微信支付(H5)');
                    $bool = true;
                    $online_transaction_no = array('source'=>'wxpay','transaction_no'=>$data['transaction_id']);
                    //写入微信订单号
                    DB::update('member_order')->set(array('online_transaction_no'=>json_encode($online_transaction_no)))
                        ->where('ordersn','=',$ordersn)
                        ->execute();
                }

            }
            else
            {
                //todo 写错误信息
               // new Pay_Exception("信息:微信公众号下单,未会返回商品订单号");
            }
        }
        else
        {
            //todo 写错误信息
           // new Pay_Exception("信息:微信公众号交易错误(msg_{$data['return_msg']})");
        }
        return $bool;
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