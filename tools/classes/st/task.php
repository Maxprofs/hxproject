<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2018/01/11 14:28
 * Desc: 任务调用类
 */

class St_Task
{

    /**
     * @function 计划任务初始化,需要执行的时间
     * Cron::set($name, array($frequency, $callback))
     */
    public static function init()
    {
        //订单取消任务
        Cron::set('order_cancel', array('*/5 * * * *', 'St_Task::cancel_order'));
        //订单自动完成任务(每晚9:30执行一次)
        Cron::set('order_complete', array('30 21 * * *', 'St_Task::complete_order'));

        Cron::set('auto_change_supplier_brokerage', array('*/5 * * * *', 'St_Task::auto_change_supplier_brokerage'));

        Cron::run();
    }

    /**
     * @function 订单取消任务.
     */
    public static function cancel_order()
    {
        //订单未付款,过期时间大于当前时间的订单
         $order_list = DB::select()->from('member_order')
             ->where('auto_close_time','>',0)
             ->and_where('auto_close_time','<',time())
             ->and_where('status','=',1)
             ->execute()
             ->as_array();
         foreach($order_list as $order)
         {
             $data = array(
                 'status' => 3
             );
             $flag = DB::update('member_order')->set($data)->where('id','=',$order['id'])->execute();
             if($flag)
             {
                 $order['status'] = 3;
                 $model = DB::select('maintable')->from('model')->where('id','=',$order['typeid'])->execute()->get('maintable');
                 if($model)
                 {
                     $product_model = "Model_".ucfirst($model);
                 }
                 if($product_model)
                 {
                     Model_Member_Order::back_order_status_changed(1,$order,$product_model);
                 }

             }



         }

    }

    /**
     * 订单自动完成
     */
    public static function complete_order()
    {
        //使用日期大于当前日期的自动完成.

        $sql = "SELECT * FROM `sline_member_order` WHERE status=2 and unix_timestamp(usedate)<".time();
        $order_list = DB::query(1,$sql)->execute()->as_array();

        foreach($order_list as $order)
        {
            $data = array(
                'status' => 5
            );
            $flag = DB::update('member_order')->set($data)->where('id','=',$order['id'])->execute();
            if($flag)
            {
                $order['status'] = 5;
                $product_model = St_Product::get_product_model($order['typeid']);
                if($product_model)
                {
                    Model_Member_Order::back_order_status_changed(2,$order,$product_model);
                }

            }



        }

    }


    /**
     * @function 供应商财务自动结算
     */
    public static function auto_change_supplier_brokerage()
    {

        if(St_Functions::is_normal_app_install('supplierfinancemanage'))
        {
            Model_Supplier_Brokerage::auto_change_status();
        }


    }




    public static function write_test()
    {
        file_put_contents(CACHE_DIR . 'crontest.txt',date('Y-m-d H:i:s')."/r/n",FILE_APPEND);
    }
}