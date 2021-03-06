<?php defined('SYSPATH') or die('No direct script access.');
require_once dirname(dirname(__FILE__)) . "/lib/WxPay.Api.php";
require_once dirname(dirname(__FILE__)) . '/lib/WxPay.Notify.php';

/**
 * 微信支付回调类
 * Class notify
 */
class notify extends WxPayNotify
{
    const LOGSDIR = 'wxpay';
    private $_id = 8;

    /**
     * 重写父类异步验证
     * @param array  $data
     * @param string $msg
     * @return bool
     */
    public function NotifyProcess($data, &$msg)
    {
        $bool = false;
        //返回状态码、业务结果
        if (array_key_exists("return_code", $data) && array_key_exists("result_code", $data) && $data['return_code'] == 'SUCCESS' && $data['result_code'] == 'SUCCESS')
        {
            //查询订单
            if (isset($data["out_trade_no"]) && $data["out_trade_no"] != "")
            {
                $input = new WxPayOrderQuery();
                $input->SetOut_trade_no($data["out_trade_no"]);//商户订单号
                $result = WxPayApi::orderQuery($input);
                $tip = '信息:微信扫码交易,订单金额与实际支付不一致';
                //这里针对微信订单号作特殊处理,去掉后面的12位字符
                $ordersn = substr($data['out_trade_no'],0,strlen($data['out_trade_no'])-12);
                if (isset($result['total_fee']) && St_Payment::total_fee_confirm($ordersn, $result['total_fee'] / 100, $tip))
                {
                    $bool = true;
                    St_Payment::pay_success($ordersn, '微信支付(电脑端)');
                    $online_transaction_no = array('source'=>'wxpay','transaction_no'=>$data['transaction_id']);
                    //写入微信交易号
                    DB::update('member_order')->set(array('online_transaction_no'=>json_encode($online_transaction_no)))
                        ->where('ordersn','=',$ordersn)
                        ->execute();

                }
            }
            else
            {
                new Pay_Exception("信息:微信扫码下单,未会返回商品订单号", 0, self::LOGSDIR);
            }
        }
        else
        {
            new Pay_Exception("信息:微信扫码交易错误({$data['return_msg']})", 0, self::LOGSDIR);
        }

        return $bool;
    }

}