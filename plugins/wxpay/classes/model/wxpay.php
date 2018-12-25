<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Wxpay{

    /**
     * @function 生成微信支付订单号(规则:原订单号+当前时间time()10位+2位随机数)
     * @param $ordersn
     * @return 返回32位订单号.
     */
    static function generate_ordersn($ordersn)
    {
        $rand_num = St_Math::get_random_number(2);
        return $ordersn.time().$rand_num;

    }


}