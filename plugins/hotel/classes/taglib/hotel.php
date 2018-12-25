<?php
defined('SYSPATH') or die('No direct access allowed.');

/**
 * Created by Phpstorm.
 * User: netman
 * Date: 15-9-23
 * Time: 上午10:43
 * Desc: 酒店标签
 */
class Taglib_Hotel
{
    private static $_typeid = 2;
    private static $_paytype = array('', '全款支付', '定金支付', '二次确认支付', '线下支付');

    /*
     * 获取酒店
     * @param 参数
     * @return array

   */
    private static $basefield = 'a.id,
                                a.webid,
                                a.sellpoint,
                                a.aid,
                                a.kindlist,
                                a.title,
                                a.address,
                                a.litpic,
                                a.hotelrankid,
                                a.finaldestid,
                                a.webid,
                                a.hotelrankid,
                                a.shownum,
                                a.price,
                                a.price_date,
                                a.satisfyscore,
                                a.bookcount,
                                a.attrid,
                                a.iconlist';

    /**
     * 检测该产品模块是否安装
     * @return bool
     */
    public function right()
    {
        $bool = true;
        if (!St_Functions::is_system_app_install(self::$_typeid))
        {
            $bool = false;
        }
        return $bool;
    }

    /**
     * @param $params
     * @return mixed
     * @description 标签接口
     */
    public static function query($params)
    {
        $default = array(
            'row' => '10',
            'flag' => '',
            'offset' => 0,
            'destid' => 0,
            'tagword' => ''
        );
        $params = array_merge($default, $params);
        extract($params);
        switch ($flag)
        {
            case 'new':
                $list = self::get_hotel_new($offset, $row);
                break;
            case 'order':
                $list = self::get_hotel_order($offset, $row);
                break;
            case 'mdd':
                $list = self::get_hotel_bymdd($offset, $row, $destid);
                break;
            case 'tagrelative':
                $list = self::get_hotel_bytagword($offset, $row, $tagword);
                break;
            case 'theme':
                $list = self::get_hotel_by_themeid($offset, $row, $themeid);
                break;
        }
        //对获取的数据进行初始化处理
        foreach ($list as &$v)
        {
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], 2); //评论次数
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], 2) + intval($v['bookcount']); //销售数量
            $v['sellprice'] = Model_Hotel::get_sellprice($v['id']);//挂牌价
            // $v['sellprice'] =  Currency_Tool::price($v['sellprice']);

            $v['price'] = Model_Hotel::get_minprice($v['id'], array('info' => $v));//最低价
            //$v['price'] = Currency_Tool::price($v['price']);
            $v['attrlist'] = Model_Hotel_Attr::get_attr_list($v['attrid']);//属性列表.
            $v['url'] = Common::get_web_url($v['webid']) . "/hotels/show_{$v['aid']}.html";
            $v['satisfyscore']  =St_Functions::get_satisfy(self::$_typeid,$v['id'],$v['satisfyscore'],array('suffix'=>''));
        }//var_dump($list);
        return $list;

    }

    /**
     * 获取酒店套餐
     * @param $params
     * @return Array
     */

    public static function suit($params)
    {
        $default = array('row' => '10', 'productid' => 0);
        $params = array_merge($default, $params);
        extract($params);

        $suit = ORM::factory('hotel_room')
            ->where("hotelid=:productid")
            ->order_by('displayorder', 'ASC')
            ->param(':productid', $productid)
            ->limit($row)
            ->get_all();
        $suit_order=array();
        $default_suit=array();
        foreach ($suit as &$r)
        {
            $r['title'] = $r['roomname'];
            $r['price'] = Model_Hotel::get_minprice($productid, $r['id']);

            $r['sellprice'] = Currency_Tool::price($r['sellprice']);
            $r['piclist'] = Product::pic_list($r['piclist']);
            $time = DB::select('day')->from('hotel_room_price')->where("hotelid={$productid} and suitid={$r['id']} and number!=0 and day>=" . strtotime(date('Y-m-d')))->order_by('day', 'asc')->execute()->current();
            $r['startTime'] = !empty($time) ? $time['day'] : time();
            $r['endTime'] = strtotime('+1 day', $r['startTime']);
            $r['paytype_name'] = self::$_paytype[$r['paytype']];
            if(empty($r['displayorder'])||$r['displayorder']=='9999')
            {
                $default_suit[]=$r;
            }
            else
            {
                $suit_order[]=$r;
            }
        }
        unset($r);
        unset($suit);
        //对默认的套餐按价钱排序
        usort($default_suit,function ($a,$b){
            if($a['price']==$b['price'])
            {
                return  0 ;
            }
            return $a['price']<$b['price'] ? - 1 : 1 ;
        });
        foreach ($default_suit as $item)
        {
            $suit_order[]=$item;
        }

        return $suit_order;
    }

    /**
     * 获取酒店报价列表
     * @param $params
     * @return array
     */
    public static function price_list($params)
    {
        $default = array('row' => '10');
        $params = array_merge($default, $params);
        extract($params);
        $arr = ORM::factory('hotel_pricelist')
            ->where("webid=0")
            ->limit($row)
            ->get_all();
        foreach ($arr as &$row)
        {
            if ($row['min'] != '' && $row['min']!=0 && $row['max'] != '' && $row['max']!=0)
            {
                $row['title'] = Currency_Tool::symbol() . $row['min'] . '-' .Currency_Tool::symbol() . $row['max'] ;
            }
            else if ($row['min'] == '' || $row['min']==0)
            {
                $row['title'] = Currency_Tool::symbol() . $row['max'] . '以下';
            }
            else if ($row['max'] == '' || $row['max']==0)
            {
                $row['title'] =Currency_Tool::symbol() . $row['min'] . '以上';
            }
        }
        return $arr;

    }

    /**
     * 酒店星级列表
     * @param $params
     * @return array
     */
    public static function rank_list($params)
    {
        $default = array('row' => '10');
        $params = array_merge($default, $params);
        extract($params);
        $arr = ORM::factory('hotel_rank')
            ->where("webid=0")
            ->order_by('orderid', 'ASC')
            ->limit($row)
            ->get_all();
        foreach ($arr as &$row)
        {
            $row['title'] = $row['hotelrank'];
        }
        return $arr;

    }

    /*
     * 获取最新酒店
     * */
    private static function get_hotel_new($offset, $row)
    {
        $sql = "SELECT " . self::$basefield . " FROM sline_hotel a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=2) ";
        $sql .= "WHERE a.ishidden=0 ORDER BY a.modtime desc,a.addtime DESC,IFNULL(b.displayorder,9999) asc ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;

    }

    /*
     * 按顺序获取酒店
     * */
    private static function get_hotel_order($offset, $row)
    {
        $sql = "SELECT " . self::$basefield . " FROM sline_hotel a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=2) ";
        $sql .= "WHERE a.ishidden=0 ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "limit {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;


    }

    /*
     * 按目的地获取酒店
     * */
    private static function get_hotel_bymdd($offset, $row, $destid)
    {
        $destid = intval($destid);
        $offset = intval($offset);
        $row = intval($row);
        $sql = "SELECT distinct(a.id)," . self::$basefield . " FROM `sline_hotel` a ";
        $sql .= "LEFT JOIN `sline_kindorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=2 and b.classid={$destid}) ";
        $sql .= "WHERE a.ishidden=0 AND FIND_IN_SET($destid,a.kindlist) ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;
    }

    private static function get_hotel_bytagword($offset, $row, $tagword)
    {
        $offset = intval($offset);
        $row = intval($row);
        $tagword_arr = explode(",", $tagword);
        if (count($tagword_arr) <= 0)
            return array();

        $sql = "SELECT " . self::$basefield . " FROM sline_hotel a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=2) ";
        $sql .= "WHERE a.ishidden=0 AND ( ";
        foreach ($tagword_arr as $tagword_item)
        {
            $sql .= "FIND_IN_SET('{$tagword_item}',a.tagword) OR ";
        }
        $sql = rtrim($sql, " OR ");
        $sql .= ") ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;

    }

    private static function get_hotel_by_themeid($offset, $row, $themeid)
    {
        $offset = intval($offset);
        $row = intval($row);
        $themeid = intval($themeid);
        $sql = "SELECT " . self::$basefield . " FROM sline_hotel a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=2) ";
        $sql .= "WHERE a.ishidden=0 AND FIND_IN_SET($themeid,a.themelist) ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;

    }

    /*
     * 执行sql语句
     * */
    private static function execute($sql)
    {
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

} 