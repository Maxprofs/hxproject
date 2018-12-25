<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Financeextend extends Stourweb_Controller
{
    public function before()
    {
        parent::before();
    }

    //预定产品设置记录相应的成本和基础价
    public function action_order_set_count_info()
    {
        $ordersn = Common::remove_xss(Arr::get($_GET,'ordersn'));

        if(!empty($ordersn))
        {
            $order = DB::select()->from('member_order')->where('ordersn','=',$ordersn)->execute()->current();
            if(!empty($order))
            {
                $rtn = Model_Member_Order_Extend::add_order_extend($order);
                echo json_encode($rtn);
            }
        }

    }

    //订单付款成功后调用计算佣金.
    public function action_order_caculate_platform_commission()
    {
        $ordersn = St_Filter::remove_xss(Arr::get($_GET,'ordersn'));
        if(!empty($ordersn))
        {
            $order = DB::select()->from('member_order')->where('ordersn','=',$ordersn)->execute()->current();
            if(!empty($order))
            {

                $rtn = Model_Member_Order_Extend::add_commission_record($order);
                echo json_encode($rtn); 
            }
        }

    }


}