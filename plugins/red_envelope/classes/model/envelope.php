<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2018/03/28 18:25
 * Desc: desc
 */
class Model_Envelope extends Model
{

    /**
     * @function 获取红包可用的模块
     * @return mixed
     */
    public static function get_use_modules()
    {
        $product_list = DB::select('modulename','id')
            ->from('model')->where('is_envelope','=',1)
            ->execute()->as_array();
        return $product_list;

    }


    /**
     * @function 获取修改页面最终的可用模块
     * @param $product_list
     * @param $eid
     */
    public static function get_finish_use_modules($product_list,$eid)
    {
        $where = " status=1";
        if($eid)
        {
            $where .=" and id<>$eid";
        }
        $has_list = DB::select('typeids')->from('envelope')
            ->where($where)->execute()->as_array('typeids');
        $has_list = array_keys($has_list);
        foreach ($has_list as $has)
        {
            $has = explode(',',$has);
            foreach ($product_list as $key=>$product)
            {
                if(in_array($product['id'],$has))
                {
                    unset($product_list[$key]);
                }

            }

        }
        return $product_list;

    }


    /**
     * @function 获取红包策略的成交转化率
     * @param $e_id
     */
    public static function get_envelope_use_rate($e_id)
    {
        $out_number = DB::select(DB::expr('count(*) as num'))
        ->from('envelope_member')->where('envelope_id','=',$e_id)
           ->execute()->get('num');
        $use_number =  DB::select(DB::expr('count(*) as num'))
            ->from('envelope_member')->where('envelope_id','=',$e_id)
            ->and_where('use','=',1)->execute()->get('num');
        if($out_number)
        {

            return round($use_number/$out_number*100);
        }
        else
        {
            return '0' ;
        }
    }

    /**
     * @function 获取红包拉新率
     */
    public static function get_envelope_new_rate($e_id)
    {

        $out_number = DB::select(DB::expr('count(*) as num'))
            ->from('envelope_member')->where('envelope_id','=',$e_id)
            ->execute()->get('num');
        $new_number =  DB::select(DB::expr('count(*) as num'))
            ->from('envelope_member')->where('envelope_id','=',$e_id)
            ->and_where('is_new_member','=',1)->execute()->get('num');
        if($out_number)
        {

            return round($new_number/$out_number*100);
        }
        else
        {
            return '0' ;
        }

    }

    /**
     * @function 红包领取率
     * @param $e_id
     */
    public static function get_envelope_get_rate($e_id)
    {
        $total_order = DB::select(DB::expr('count(*) as num'))
            ->from('envelope_order')->where('envelope_id','=',$e_id)
            ->execute()->get('num');
        $total_number = $total_order *10 ;
        $out_number = DB::select(DB::expr('count(*) as num'))
            ->from('envelope_member')->where('envelope_id','=',$e_id)
            ->execute()->get('num');
        if($total_number)
        {

            return round($out_number/$total_number*100);
        }
        else
        {
            return '0' ;
        }



    }


    public static function get_excel_stat_table()
    {
        $table = "<table><tr>";
        $table .= "<td>会员昵称</td>";
        $table .= "<td>会员手机号</td>";
        $table .= "<td>金额</td>";
        $table .= "<td>可用产品</td>";
        $table .= "<td>红包名称</td>";
        $table .= "<td>领取时间</td>";
        $table .= "<td>使用时间</td>";
        $table .= "</tr>";

        $list_sql = "select a.*,b.nickname,b.mobile from sline_envelope_member as a LEFT JOIN sline_member as b on a.memberid=b.mid ";
        $list = DB::query(1,$list_sql)->execute()->as_array();
        foreach ($list as $l)
        {
            $l['addtime'] = date('Y-m-d H:i:s',$l['addtime']);
            if($l['use'])
            {
                $l['usetime'] = date('Y-m-d H:i:s',$l['usetime']);
            }
            if($l['typeids'])
            {
                $modulelist = DB::select('modulename')->from('model')
                    ->where("id in ({$l['typeids']})")
                    ->execute()->as_array('modulename');
                $l['typeid_title'] = implode(',',array_keys($modulelist));
            }
            $table .= "<tr>";
            $table .= "<td>{$l['nickname']}</td>";
            $table .= "<td>{$l['mobile']}</td>";
            $table .= "<td>{$l['money']}</td>";
            $table .= "<td>{$l['typeid_title']}</td>";
            $table .= "<td>{$l['envelope_title']}</td>";
            $table .= "<td>{$l['addtime']}</td>";
            $table .= "<td>{$l['usetime']}</td>";
            $table .="</tr>";
        }
        $table .="</table>";
        return $table;


    }




    /**
     * @function 获取默认的封面图片
     */
    public static function get_default_share_litpic()
    {
        return '/uploads/red_envelope/red-page-default.jpg';

    }






}