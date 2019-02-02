<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2018/01/10 15:16
 * Desc: desc
 */
class Model_Supplier_Brokerage extends ORM
{


    /**
     * @function 添加佣金记录
     */
    public static function add_brokerage($ordersn,$order=null)
    {
        if(!$ordersn)
        {
            return false;
        }
        if(!$order['status']||!$order['supplierlist'])
        {
            $order = DB::select('id','status','supplierlist')->from('member_order')
                ->where('ordersn','=',$ordersn)->execute()->current();
        }
        //必须是已经付款的订单,且有供应商
        if(!in_array($order['status'],array(2,5))||!$order['supplierlist'])
        {
            return false;
        }
        $order_compute = DB::select()->from('member_order_compute')
            ->where('order_id','=',$order['id'])->execute()->current();
        //检测是否是定金支付
        if(!((float)$order_compute['subscription_price']))
        {
            $brokerage = $order_compute['total_price']-$order_compute['platform_commission']-$order_compute['additional_total_price'];
            $total_price = $order_compute['total_price'];
        }
        else
        {
            $brokerage = $order_compute['subscription_price']-$order_compute['platform_commission']-$order_compute['additional_total_price'];
            $total_price = $order_compute['subscription_price'];
        }

        $brokerage < 0 ? $brokerage = 0 :'';
        $data = array(
            'supplierlist'=>$order['supplierlist'],
            'ordersn'=>$ordersn,
            'addtime'=>time(),
            'order_price'=>$total_price,
            'brokerage'=>$brokerage
        );
        try
        {
            DB::insert('supplier_brokerage',array_keys($data))
                ->values(array_values($data))->execute();
            return true;
        }catch (Exception $e)
        {
            return false;
        }

    }


    /**
     * @function 自动更新结算状态
     */
    public static function auto_change_status()
    {
        $config = Model_Sysconfig::get_configs(0,array('cfg_supplier_brokerage_start_days','cfg_supplier_brokerage_finish_days','cfg_supplier_brokerage_type'));
        //待消费开始自动结算
        if($config['cfg_supplier_brokerage_type']==1)
        {
            $days = $config['cfg_supplier_brokerage_start_days'];
            empty($days) ?  $time= time() : $time = strtotime("-$days days");
            $sql ="select a.id from sline_supplier_brokerage as a LEFT JOIN sline_member_order as b on a.ordersn=b.ordersn WHERE a.status=1 and b.status in (2,5) and (b.paytime<=$time OR  b.`paytime` IS NULL)";

        }
        //订单完成自动结算
        else
        {
            $days = $config['cfg_supplier_brokerage_finish_days'];
            empty($days) ?  $time= time() : $time = strtotime("-$days days");
            $sql ="select a.id from sline_supplier_brokerage as a LEFT JOIN sline_member_order as b on a.ordersn=b.ordersn WHERE a.status=1 and b.status=5 and (b.finishtime<=$time OR  b.`finishtime` IS NULL)";
        }
        $list = DB::query(1,$sql)->execute()->as_array();
        $ids = array();
        foreach ($list as $l)
        {
            if($l['id'])
            {
                $ids[] = $l['id'];
            }
        }
        if($ids)
        {
            $ids = implode(',',$ids);
            $data = array(
                'finish_brokerage'=>DB::expr('brokerage'),
                'status'=>2,
                'modtime'=>time(),
            );
            DB::update('supplier_brokerage')->set($data)->where("id in ($ids)")->execute();
        }
        return true;
    }


    /**
     * @function 获取供应商的金额情况
     */
    public static function get_supplier_price_info($supplierid)
    {
        if(!$supplierid)
        {
            return array();
        }
        $withdraw_price_finish = self::get_supplier_withdraw_price($supplierid,1);//已提现的金额
        $withdraw_price_approval = self::get_supplier_withdraw_price($supplierid,0);//申请中的金额
        $brokerage_price = self::get_supplier_brokerage_price($supplierid);
        return array(
            'allow_price'=>$brokerage_price-$withdraw_price_finish-$withdraw_price_approval,//可提现金额
            'withdraw_price_finish'=>$withdraw_price_finish ? $withdraw_price_finish : 0,//已提现金额
            'withdraw_price_approval'=>$withdraw_price_approval ? $withdraw_price_approval : 0,//申请中的金额
            'brokerage_price'=>$brokerage_price,//佣金
        );

    }

    /**
     * @function 获取供应商提现金额
     * @param $supplierid
     * @param $status 提现状态
     */
    public static function get_supplier_withdraw_price($supplierid,$status)
    {
        return DB::select(DB::expr('sum(withdrawamount) as price'))
            ->from('supplier_finance_drawcash')
            ->where('supplierid','=',$supplierid)
            ->and_where('status','=',$status)
            ->execute()->get('price');

    }


    /**
     * @function 获取供应商佣金金额
     * @param $supplierid
     */
    public static function get_supplier_brokerage_price($supplierid)
    {
        return DB::select(DB::expr('sum(finish_brokerage) as price'))
            ->from('supplier_brokerage')
            ->where('supplierlist','=',$supplierid)
            ->execute()->get('price');

    }

    /**
     * @function 获取提现方式的中文名称
     * @param $type
     */
    public static function get_proceeds_type($type)
    {
        $arr = array(
            '1'=>'银行',
            '2'=>'支付宝',
            '3'=>'微信',
        );
        return $arr[$type];
    }

    /**
     * @function 获取所有供应商的财务信息
     */
    public static function get_total_price_info()
    {
        //总交易金额
        $total_price = DB::select(DB::expr('sum(finish_brokerage) as total'))
            ->from('supplier_brokerage')->execute()->get('total');
        //已经完成提现的
        $withdraw_price_finish = DB::select(DB::expr('sum(withdrawamount) as price'))
            ->from('supplier_finance_drawcash')
            ->and_where('status','=',1)
            ->execute()->get('price');
        //申请中的
        $withdraw_price_approval = DB::select(DB::expr('sum(withdrawamount) as price'))
            ->from('supplier_finance_drawcash')
            ->and_where('status','=',0)
            ->execute()->get('price');
        return array(
            'allow_price'=>number_format($total_price-$withdraw_price_finish-$withdraw_price_approval,2) ,//可提现金额
            'withdraw_price_finish'=>number_format($withdraw_price_finish ? $withdraw_price_finish : 0,2),//已提现金额
            'withdraw_price_approval'=>number_format($withdraw_price_approval ? $withdraw_price_approval : 0,2),//申请中的金额
        );

    }


    /**
     * @function 获取供应商时间范围内的财务信息
     * @param $supplierid
     * @param $starttime
     * @param $endtime
     */
    public static function get_supplier_time_price($supplierid,$starttime,$endtime)
    {
        if($endtime)
        {
            $endtime = $endtime+24*60*60;
        }
        //佣金总
        $w = "supplierlist=$supplierid";
        if($starttime)
        {
            $w .=" and addtime>=$starttime";
        }
        if($endtime)
        {
            $w .= " and addtime<=$endtime";
        }
        $total_price = DB::select(DB::expr('sum(finish_brokerage) as total'))->from('supplier_brokerage')
            ->where($w)->execute()->get('total');
        //提现记录信息
        $w = "supplierid=$supplierid";
        if($starttime)
        {
            $w .=" and addtime>=$starttime";
        }
        if($endtime)
        {
            $w .= " and addtime<=$endtime";
        }
        //提现中金额
        $withdraw_price_approval = DB::select(DB::expr('sum(withdrawamount) as total'))->from('supplier_finance_drawcash')
            ->where($w)->and_where('status','=',0)->execute()->get('total');
        //已提现金额
        $withdraw_price_finish = DB::select(DB::expr('sum(withdrawamount) as total'))->from('supplier_finance_drawcash')
            ->where($w)->and_where('status','=',1)->execute()->get('total');
        return array(
            'allow_price'=>number_format($total_price-$withdraw_price_finish-$withdraw_price_approval,2) ,//可提现金额
            'withdraw_price_finish'=>number_format($withdraw_price_finish ? $withdraw_price_finish : 0,2),//已提现金额
            'withdraw_price_approval'=>number_format($withdraw_price_approval ? $withdraw_price_approval : 0,2),//申请中的金额
        );

    }







}