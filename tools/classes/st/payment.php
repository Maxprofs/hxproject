<?php defined('SYSPATH') or die('No direct script access.');


/**
 * 支付全局函数
 * Class product
 */
class St_Payment
{
    /**
     * 支付金额与订单金额是否相等
     * @param $ordersn
     * @param $payMoney
     * @param string $exception
     * @return bool
     */
   public static function total_fee_confirm($ordersn, $payMoney, $exception = '')
    {
        $bool = false;
        $info = Model_Member_Order::order_info($ordersn);
        //从计算表里取数据,防止有子订单数据.
        $total_info = Model_Member_Order_Compute::get_order_price($info['id']);
        if($total_info && !empty($total_info))
        {
            $info['payprice'] = $total_info['pay_price'];
        }
        if ($info['payprice'] == $payMoney)
        {
            $bool = true;
        }
        return $bool;
    }

    /**
     * 支付成功后，修改订单状态
     * @param $ordersn
     * @param string $payMethod
     * @param bool|false $is_offline 是否是线下支付
     */
    public static function pay_success($ordersn, $payMethod, $is_offline = false)
    {
        $bool = true;
        //线上支付
        if (!$is_offline)
        {
            //未支付，更新支付状态并赠送积分

            if (!self::is_order_payed($ordersn))
            {
                $info['sign'] = '11';
                $order = Model_Member_Order::info($ordersn);
                //支付成功,如果订单是需要确认的订单则修改订单状态为待审核,否则修改为待消费.
                //$status = $order['need_confirm'] == 1 ? 0 : 2;
                //支付成功,订单状态修改为待消费
                $status = 2;

                self::change_order($ordersn, $payMethod,$status);
                self::child_order_change_status($ordersn,$payMethod);
                $detectresult = Model_Member_Order_listener::detect($ordersn);
                if ($detectresult !== true)
                {
                    $bool = false;
                }

            }
            else
            {
                $info['sign'] = '24';
            }
        }
        else
        {
            //线下支付
            $info['sign'] = '12';
            self::chang_order_by_offline($ordersn, $payMethod);
            $info['ordersn'] = $ordersn;
			self::pay_status($info);

        }
    }

    /**
     * 订单是否支付
     * @param $ordersn
     * @return bool
     */
    public static function is_order_payed($ordersn)
    {

        $rs = DB::select('id')->from('member_order')
            ->where('ordersn','=',$ordersn)
            ->and_where('status','=',2)
            ->execute()
            ->as_array();
        return empty($rs) ? false : true;
    }

    /**
     * 线上支付修改订单状态
     * @param $ordersn
     * @param string $payMethod
     */
    public static function change_order($ordersn, $payMethod,$new_status=2)
    {
        $status = false;
        $product_model = '';
        $order_info = DB::select('status','typeid')->from('member_order')->where('ordersn','=',$ordersn)->execute()->current();
        $org_status = $order_info['status'];
        if(!in_array($org_status,array(1,3)))
        {
            return false;
        }
        if($org_status == 3)
        {
            $product_model = St_Product::get_product_model($order_info['typeid']);
        }


        //更改订单状态
        $rows = DB::update('member_order')
            ->where('ordersn', '=', "{$ordersn}")
            ->set(array('status' => $new_status, 'paysource' => $payMethod, 'paytime' => time()))
            ->execute();
        if ($rows == 1)
        {
            $order_info = DB::select()->from('member_order')->where('ordersn', '=', $ordersn)->execute()->current();
            Model_Member_Order::back_order_status_changed($org_status,$order_info,$product_model);


            $status = true;

        }
        return $status;

    }


      /**
         * 线下支付修改订单状态
         * @param $ordersn
         * @param $payMethod
         */
    public static function chang_order_by_offline($ordersn, $payMethod)
    {
        $prev_status =DB::select('status')->from('member_order')->where('ordersn', '=', $ordersn)->execute()->get('status');
        //更改订单状态
        $rows = DB::update('member_order')->where('ordersn', '=', "{$ordersn}")->set(array('paysource' => $payMethod))->execute();
        if ($rows != 1)
        {
            new Pay_Exception("订单({$ordersn})线下支付状态更新失败");
        }
        $order_info = DB::select()->from('member_order')->where('ordersn', '=', $ordersn)->execute()->current();
        Model_Member_Order_Log::add_log($order_info,$prev_status);
    }


    /**
     * 支付状态
     * @param $data
     */
    static function pay_status($data)
    {
        $data['sign'] = md5($data['sign']);
        $url = self::get_main_host() . '/payment/status';
        $html = "<form action='{$url}' style='display:none;' method='post' id='payment'>";
        foreach ($data as $name => $v)
        {
            $html .= "<input type='text' name='{$name}' value='{$v}'>";
        }
        $html .= '</form>';
        $html .= "<script>document.forms['payment'].submit();</script>";
        exit($html);
    }

    /**
     * 主站域名
     * @return string
     */
    static function get_main_host()
    {
        $host = '';
        $sql = "select weburl from sline_weblist where webid=0";
        $arr = DB::query(Database::SELECT, $sql)->execute()->current();
        if (!empty($arr))
        {
            $host = $arr['weburl'];
        }
        return $host;
    }

    /**
     * @function 写日志
     * @param $file
     * @param $msg
     */
    static function write_log($file,$msg)
    {
        if (!file_exists($file))
        {
            fopen($file, "w");
        }
        $time = date('Y-m-d H:i:s');
        $logFormat = <<<LOG
            #time:$time
            #message:$msg
LOG;
        file_put_contents($file, PHP_EOL.$logFormat.PHP_EOL, FILE_APPEND);

    }

    /**
     * 零元支付
     * @param $ordersn
     * @param string $payMethod
     */
    static function zero_pay($ordersn,$payMethod='积分抵现')
    {
        St_Payment::change_order($ordersn,$payMethod);
        self::child_order_change_status($ordersn,$payMethod);
        $info['sign'] = '14';
        $info['ordersn'] = $ordersn;
        St_Payment::pay_status($info);
    }

    /**
     * @function 子订单状态更改.
     * @param $ordersn
     * @param $paymethod
     */
    static function child_order_change_status($ordersn,$paymethod)
    {
        $parent_order = DB::select()->from('member_order')->where('ordersn','=',$ordersn)->execute()->current();
        if($parent_order['id'])
        {
            $child_order = DB::select()->from('member_order')->where('pid','=',$parent_order['id'])->execute()->as_array();
            foreach($child_order as $child)
            {
                self::change_order($child['ordersn'],$paymethod);
            }
        }
    }

    /**
     * 支付失败
     * @param $data
     */
    static function pay_failure($msg)
    {

        if(St_Functions::is_mobile())
        {
            $url = self::get_main_host() . '/error/payment?msg='.$msg;
        }
        else
        {
            $url = self::get_main_host() . '/error/payment';
        }

        $html = "<form action='{$url}' style='display:none;' method='post' id='payment_error'>";
        $html .= "<input type='text' name='msg' value='{$msg}'>";
        $html .= '</form>';
        $html .= "<script>document.forms['payment_error'].submit();</script>";
        exit($html);
    }


}