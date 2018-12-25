<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2018/03/28 18:25
 * Desc: desc
 */

class Model_Order_Envelope extends Model
{


    /**
     * @function 添加订单红包记录，在付款成功后调用
     * @param $ordersn
     */
     public static function add_order_envelope($ordersn,$order=null)
     {
         if(!$order)
         {
             $order = DB::select('memberid','status','typeid')
                 ->from('member_order')->where('ordersn','=',$ordersn)
                 ->execute()->current();
         }
         //订单必须是已经付款的
         if(!in_array($order['status'],array(2,5)))
         {
             return true;
         }
         //判断该订单是否已经存在分享记录
         $check_is_add = DB::select('id')->from('envelope_order')
             ->where('ordersn','=',$ordersn)->execute()->get('id');
         if($check_is_add)
         {
             return true;
         }
         $envelope= DB::select('id','share_money')->from('envelope')
             ->where("find_in_set({$order['typeid']},typeids)")
             ->and_where('status','=',1)
             ->and_where('delete','=',0)
             ->and_where('is_finish','=',0)
             ->execute()->current();
         //是否存在有效的红包策略
         if(!$envelope)
         {
             return true;
         }
         DB::query(null,'start transaction');
         $sql ="select id from sline_envelope WHERE id={$envelope['id']} for UPDATE ";
         $e_id = DB::query(1,$sql)->execute();
         //获取随机金额
         $money_list_data = self::get_round_money_list($envelope['share_money']);
         $envelope_order = array(
             'envelope_id'=>$envelope['id'],
             'money'=>$envelope['share_money'],
             'memberid'=>$order['memberid'],
             'status'=>0,
             'addtime'=>time(),
             'ordersn'=>$ordersn,
             'max_number'=>$money_list_data['max_number'],
             'money_list'=>$money_list_data['money_list'],
         );
         try
         {
             DB::insert('envelope_order',array_keys($envelope_order))->values(array_values($envelope_order))->execute();
             DB::query(null,'commit');
         }catch (Exception $e)
         {
             DB::query(null,'rollback');
         }
         return true;

     }


    /**
     * @function 生成红包金额链
     * @param $share_monry 分享总金额
     */
     public static function get_round_money_list($share_money)
     {
         $money_arr = array();//最终的红包数组
         $number = 1;//红包个数
         while ($number<11)
         {
             if($number==10)
             {
                 $money = $share_money;
             }
             else
             {
                 //当前最大随机金额
                 $rand_money = $share_money - (10-$number);
                 $money = rand(1,$rand_money);
             }
             $money_arr[] = $money;
             $share_money -= $money;
             $number++;
         }

         //金额最后处理，判断是够有重复的最大金额
         $max_money = max($money_arr);
         $max_key = array_search($max_money,$money_arr);
         foreach ($money_arr as $key=>$money)
         {
             if($money==$max_money&&$max_key!=$key)
             {
                 $money_arr[$key] -= 1;
                 $money_arr[$max_key] += 1;
                 break;
             }
         }



         //最大红包必须要在过半之后才会产生
         return array('max_number'=>rand(5,10),'money_list'=>json_encode($money_arr));
     }

    /**
     * @function 会员获取红包
     * @param $memberid 会员id
     * @param $envelope_order_id envelope_order表主键
     * @param $is_new_member 是否为新会员
     */
     public static function add_envelope_member($memberid,$envelope_order_id,$is_new_member=0)
     {
         DB::query(null,'start transaction');
         $sql = "select id,max_number,money_list,envelope_id,`status` from sline_envelope_order WHERE id=$envelope_order_id and is_finish=0 for UPDATE ";
         //判断当前红包是否领完
         $envelope_order = DB::query(1,$sql)->execute()->current();
         if(!$envelope_order)
         {
             DB::query(null,'rollback');
             return array('status'=>0,'msg'=>'下手慢了哦，已经领完了!');
         }
         $envelope = DB::select('id','title','typeids','total_number','share_number')->from('envelope')
             ->where('id','=',$envelope_order['envelope_id'])->execute()->current();
         if(!$envelope)
         {
             DB::query(null,'rollback');
             return array('status'=>0,'msg'=>'下手慢了哦，已经领完了!');
         }
         $has_number = DB::select(DB::expr('count(*) as num'))
             ->from('envelope_member')->where('envelope_order_id','=',$envelope_order_id)
             ->execute()->get('num');
         if($has_number>9)
         {
             DB::query(null,'rollback');
             return array('status'=>0,'msg'=>'下手慢了哦，已经领完了!');
         }
         $has_number++;//当前用户是第几个领取
         //当前用户的红包金额
         $money_data = self::_get_envelope_member_money($envelope_order,$has_number);
         $envelope_member = array(
             'memberid'=>$memberid,
             'money'=>$money_data['money'],
             'addtime'=>time(),
             'is_max'=>$money_data['is_max'],
             'envelope_order_id'=>$envelope_order_id,
             'typeids'=>$envelope['typeids'],
             'envelope_title'=>$envelope['title'],
             'is_new_member'=>$is_new_member,
             'envelope_id'=>$envelope['id']
         );
         try
         {
             $rsn = DB::insert('envelope_member',array_keys($envelope_member))->values(array_values($envelope_member))->execute();
             if($rsn)
             {
                 //去除当前金额
                 $money_list = json_decode($envelope_order['money_list'],true);
                 unset($money_list[$money_data['key']]);
                 sort($money_list);
                 $envelope_order_update = array(
                     'money_list'=>json_encode($money_list),
                 );
                 if(!$envelope_order['status'])
                 {
                     //更新生成记录，表示已经领取了
                     $envelope_order_update['status'] = 1;

                     //有效分享次数加1
                     $update_data = array(
                         'share_number'=>DB::expr('share_number+1'),
                     );
                     //领完；自动关闭策略
                     if($envelope['share_number']==($envelope['total_number']-1))
                     {
                         $update_data['status'] = 0 ;
                         $update_data['is_finish'] = 1;
                     }
                     $update = DB::update('envelope')->set($update_data)->where('id','=',$envelope['id'])->and_where('share_number','<',$envelope['total_number'])->execute();
                     if(!$update)
                     {
                         DB::query(null,'rollback');
                         return array('status'=>0,'msg'=>'系统繁忙，请稍后再试!');
                     }
                 }
                 //已经领完
                 if($has_number==10)
                 {
                     $envelope_order_update['is_finish'] = 1;
                 }
                 DB::update('envelope_order')->set($envelope_order_update)->where('id','=',$envelope_order_id)->execute();
                 DB::query(null,'commit');
                 return array('status'=>1,'msg'=>'领取成功!');
             }
         }
         catch (Exception $e)
         {
             DB::query(null,'rollback');
             return array('status'=>0,'msg'=>'系统繁忙，请稍后再试!');
         }
         
     }

    /**
     * @function 获取当前用户的领取金额
     * @param $envelope_order
     * @param $now_number
     */
     private static function _get_envelope_member_money($envelope_order,$now_number)
     {
         $is_max = 0 ;
         $money_list = json_decode($envelope_order['money_list'],true);
         if($now_number==$envelope_order['max_number'])
         {
             $money = max($money_list);
             $is_max = 1;
             $key =array_search($money,$money_list);
         }
         else
         {
             $key = array_rand($money_list,1);
             $money = $money_list[$key];
         }
         return array('money'=>$money,'key'=>$key,'is_max'=>$is_max);
     }

    /**
     * @function 订单展示页
     * @param $ordersn
     */
    public static function order_show($ordersn,$is_view=false)
    {
        $where = " a.ordersn='$ordersn'";
        if(!$is_view)
        {
            $where .=" and b.delete=0 and b.status=1 and b.is_finish=0";
        }
        $sql ="select a.envelope_id,a.id,a.max_number,b.share_litpic as litpic,b.share_title as title,b.share_description as sellpoint from sline_envelope_order as a LEFT JOIN sline_envelope as b on a.envelope_id=b.id where  $where";

        $info = DB::query(1,$sql)->execute()->current();
        if(!$info)
        {
            return false;
        }
        $total = DB::select('total_money')->from('envelope')->where('id','=',$info['envelope_id'])
            ->execute()->get('total_money');

        $info['view_total'] = self::_get_finish_total($total);
        $info['title'] = str_replace('{#TOTAL#}',$total,$info['title']);
        $info['title'] = str_replace('{#MAX#}',$info['max_number'],$info['title']);
        $info['sellpoint'] = str_replace('{#TOTAL#}',$total,$info['sellpoint']);
        $info['sellpoint'] = str_replace('{#MAX#}',$info['max_number'],$info['sellpoint']);

        if(!$info['litpic'])
        {
            $info['litpic'] = Model_Envelope::get_default_share_litpic();
        }
        return $info;
    }

    /**
     * @function 获取显示的价格
     * @param $total
     */
    private static function _get_finish_total($total)
    {
        switch (true)
        {
            case ($total<1001):
                return $total;
                break;
            case $total>1000&&$total<10000:
                return round($total/1000).'千';
                break;
            case $total>9999&&$total<10000001:
                return round($total/10000).'万';
                break;
            default:
                return round($total/10000000).'千万';
        }

    }




    /**
     * @function 获取该红包的领取记录
     * @param $envelope_order_id
     * @param null $mid
     */
    public static function get_envelope_show_list($envelope_order_id,$mid=null)
    {
        $sql ="select a.*,b.nickname,b.litpic from sline_envelope_member as a LEFT JOIN sline_member as b on a.memberid=b.mid WHERE a.envelope_order_id=$envelope_order_id";
        $list = DB::query(1,$sql)->execute()->as_array();
        $own = array();//自己的领取
        $has_max = 0 ;//手气最佳是否出现
        foreach ($list as &$l)
        {
            if(!$l['litpic'])
            {
                $l['litpic'] = Model_Member::member_nopic();
            }
            if($l['memberid']==$mid)
            {
                $own = $l;
                $module_title = DB::select('modulename')->from('model')
                    ->where("id in ({$l['typeids']})")->execute()->as_array('modulename');
                $own['module_title'] = implode(',',array_keys($module_title));
            }
            if($l['is_max'])
            {
                $has_max = 1;
            }
            $l['money'] = Currency_Tool::price($l['money']);
        }
        unset($l);
        return array($list,$own,$has_max) ;

    }

    /**
     * @function 获取预定页可用的红包
     * @param $typeid
     * @param $memberid
     */
    public static function get_book_envelope($typeid,$memberid=null)
    {
        if(!$memberid)
        {
            $member =Model_Member::check_login();
            $memberid = $member['mid'];
        }
        if(!$memberid)
        {
            return false;
        }
        $list = DB::select('id','money')->from('envelope_member')
            ->where("find_in_set($typeid,typeids)")
            ->and_where('use','=',0)
            ->and_where('memberid','=',$memberid)
            ->execute()->as_array();
        foreach ($list as &$l)
        {
            $l['money'] = Currency_Tool::price($l['money']);
        }
        return $list;

    }


    /**
     * @function 使用红包，下订单使用
     * @param $envelope_member_id envelope_member 表主键
     * @param $ordersn 订单号
     * @param $typeid 产品类型
     * @param $memberid 会员id
     */
    public static function order_use_envelope($envelope_member_id,$ordersn,$typeid,$memberid)
    {
        $envelope_member = DB::select('id','money')->from('envelope_member')
            ->where("find_in_set($typeid,typeids)")
            ->and_where('id','=',$envelope_member_id)
            ->and_where('memberid','=',$memberid)
            ->and_where('use','=',0)
            ->execute()->current();
        if($envelope_member['id'])
        {

            $order = DB::select()->from('member_order')->where('ordersn','=',$ordersn)
                ->execute()->current();
            //获取当前的支付总额
            $pay_price = Model_Member_Order::order_total_payprice($order['id'],$order);
            //获取实际的红包抵扣金额
            $use_money = $pay_price<$envelope_member['money'] ? $pay_price : $envelope_member['money'];

            if($use_money<1)
            {
                return true;
            }

            $data = array(
                'use'=>1,
                'usetime'=>time(),
                'ordersn'=>$ordersn,
                'use_money'=>$use_money
            );
            $rsn = DB::update('envelope_member')->set($data)->where('id','=',$envelope_member_id)->execute();
            //更新优惠金额
            if($envelope_member['money']&&$rsn)
            {
                $privileg_price = Model_Member_Order::order_privileg_price($order['id'],$order);
                DB::update('member_order_compute')->set(array('privileg_price'=>$privileg_price))
                    ->where('order_id','=',$order['id'])->execute();
            }
        }

    }

    /**
     * @function 获取订单的红包抵扣金额
     * @param $ordersn
     */
    public static function get_order_envelope_price($ordersn)
    {
        $money = DB::select('use_money')->from('envelope_member')
            ->where('ordersn','=',$ordersn)
            ->execute()->get('use_money');
        $money ? $money = $money : $money= 0 ;
        return $money;
    }


    /**
     * @function 获取会员的红包列表
     * @param $memberid
     * @param $type
     * @param $pagesize
     */
    public static function get_member_list($memberid,$type,$pagesize,$page)
    {
        $offset = ($page-1) * $pagesize;

        $where = "memberid=$memberid";
        if($type==1)
        {
            $where .=" and `use`=0";
        }
        elseif ($type==2)
        {
            $where .=" and `use`=1";
        }
        $total = DB::select(DB::expr('count(*) as num'))->from('envelope_member')
            ->where($where)->execute()->get('num');
        $list = DB::select('id','money','use','typeids')->from('envelope_member')
            ->where($where)->offset($offset)->limit($pagesize)->execute()->as_array();
        foreach ($list as &$l)
        {

            $l['money'] = Currency_Tool::price($l['money']);
            $module_title = DB::select('modulename')->from('model')
                ->where("id in ({$l['typeids']})")->execute()->as_array('modulename');
            $l['module_title'] = implode(',',array_keys($module_title));
        }
        unset($l);
        return array('total'=>$total,'list'=>$list);
    }


    /**
     * @function 获取支付成功的地址
     * @param $ordersn
     */
    public static function pay_success_url($ordersn)
    {
        $info = self::order_show($ordersn);
        if($info)
        {
            $baseurl = $GLOBALS['cfg_mobile_config']['domain']['mobile'];

            $url = rtrim($baseurl,'//') .'/'.'envelope/view/params/'.base64_encode($info['id']);
            $info['url'] = $url;
            return $info;
        }
        return false;
    }

    /**
     * @function 订单取消
     * @param $ordersn
     */
    public static function cancel_order_back($ordersn)
    {
        $data = array(
            'use'=>0,
            'ordersn'=>'',
            'usetime'=>'',
            'use_money'=>0,
        );
        DB::update('envelope_member')->set($data)->where('ordersn','=',$ordersn)
            ->execute();
    }
}