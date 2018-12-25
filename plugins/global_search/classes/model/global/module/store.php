<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2017/10/20 16:25
 * Desc: 线路搜索模型
 */

class Model_Global_Module_Store extends ORM
{

    /**
     * @function 线路搜索
     * @param $params
     * @param $p
     * @param $pagesize
     * @param $keysearch
     * @param $model
     */
    public static function search_list($params,$p,$pagesize,$where,$model)
    {
        $offset = --$p*$pagesize;
        $where .=" and a.status=1";
        //价格区间
        if ($params['priceid'])
        {
            $priceArr = DB::select()->from('store_pricelist')->where('id', '=', $params['priceid'])->execute()->current();
            if (empty($priceArr))
            {
                Common::head404();
            }
            $where .= " AND a.price BETWEEN {$priceArr['lowerprice']} AND {$priceArr['highprice']} ";
        }
        //总数
        $total = DB::select(DB::expr('count(*) as num '))
            ->from(DB::expr('sline_store as a'))
            ->where($where)->execute()->get('num');
        $files = 'a.*';
        $sql = "select $files,(LENGTH(a.title)-LENGTH(REPLACE(a.title,'{$params['keyword']}',''))) as order_by from sline_store as a LEFT JOIN `sline_allorderlist` b ON (a.id=b.aid and b.typeid=113) WHERE $where
        ORDER BY order_by desc,IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC limit $offset,$pagesize";
        $list = DB::query(1,$sql)->execute()->as_array();
        foreach ($list as &$v)
        {
            $priceArr = Model_Store::get_min_price($v['id']);
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], 113); //评论次数
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], 113) + intval($v['bookcount']); //销售数量
            $v['sellprice'] = $priceArr['sellprice'];//挂牌价
            $v['price'] = $priceArr['price'];//最低价
            $v['attrlist'] = Model_Spot_Attr::get_attr_list($v['attrid']);//属性列表.
            $v['url'] = Common::get_web_url($v['webid']) . "/store/show_{$v['aid']}.html";
            $v['satisfyscore'] = St_Functions::get_satisfy(113, $v['id'], $v['satisfyscore'],array('suffix'=>''));//满意度
            $v['iconlist'] = Product::get_ico_list($v['iconlist']);
            $v['series'] = St_Product::product_series($v['id'], 113);
            if(Model_Supplier::display_is_open()&&$v['supplierlist'])
            {
                $v['suppliername'] = Arr::get(Model_Supplier::get_supplier_info($v['supplierlist'],array('suppliername')),'suppliername');
            }
        }
        $out = array(
            'total' => $total,
            'list' => $list
        );
        return $out;

    }

    /**
     * @function 返回搜索条件
     * @param $destid 目的地
     * @param $attrlist 属性
     * @param $typeid 类型
     * @return array
     */
    public static function get_search_items($params)
    {
        $destid = $params['destid'];
        $attrlist = $params['attrlist'];
        $typeid = $params['typeid'];
        $dayid = $params['dayid'];
        $priceid = $params['priceid'];
        $items = array();
        //目的地
        if($destid)
        {
            $dest = DB::select('id','kindname')
                ->from('store_destinations')
                ->where('id','=',$destid)
                ->execute()->current();
            $dest['type'] = 'dest';
            $dest['attrname'] = $dest['kindname'];
            $items[] = $dest;
        }

        //价格
        if($priceid)
        {
            $temp = array();
            $ar = DB::select()->from('store_pricelist')->where('id','=',$priceid)->execute()->current();
            $lowerprice = $ar['lowerprice'];
            $highprice = $ar['highprice'];
            $temp['attrname'] = Model_Global_Search::get_price_list_title($lowerprice, $highprice);
            $temp['type'] = 'price';
            $temp['id'] = $priceid;
            $items[] = $temp;
        }

        //属性
        $attr_arr = array();
        $attrlist = implode(',',$attrlist);
        if($attrlist)
        {
            $attrtable = DB::select('attrtable')->from('model')->where('id','=',$typeid)->execute()->get('attrtable');
            //排除通用模块和签证模块(读取属性)
            if(!empty($attrtable) && $typeid!=8)
            {
                $m = DB::select('attrname','id')->from($attrtable);
                $m->where('isopen','=',1);
                if($attrtable == 'model_attr')
                {
                    $m->and_where('typeid','=',$typeid);
                }
                $m->and_where(DB::expr(" and id in ($attrlist)"));
                $m->order_by(DB::expr('ifnull(displayorder,9999)'),'asc');
                $attr_arr = $m->execute()->as_array();
            }
            foreach ($attr_arr as &$a)
            {
                $a['type'] = 'attr';
            }
        }
        return  array_merge($items,$attr_arr);
    }



    /**
     * @function 判断当前关键字是否为目的地，并返回下级目的地
     * @param $keyword 关键词
     * @param $typeid 类型id
     */
    public static function check_and_get_destinations($keyword,$typeid)
    {

        $destinations = array();

        foreach ($keyword as $key)
        {
            $sql = "select id,kindname from sline_store_destinations WHERE isopen=1 
and pid = (SELECT id from sline_store_destinations WHERE kindname like '%$key%' and isopen=1 limit 1)";
            $list  = DB::query(1,$sql)->execute()->as_array();
            if($list)
            {
                $destinations = $list;
                break;
            }
        }
        if(!$destinations)
        {
            $destinations = DB::select('id','kindname')
                ->from('store_destinations')
                ->where('pid','=',0)
                ->and_where('isopen','=',1)
                ->execute()->as_array();
        }
        return $destinations;
    }








}