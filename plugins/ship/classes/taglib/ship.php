<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/18 0018
 * Time: 15:23
 */
class Taglib_Ship
{
    private static $basefiled = 'a.id,a.webid,a.aid,a.title,a.price,a.price_date,a.litpic,a.startcity,a.kindlist,a.attrid,a.bookcount,a.storeprice,a.sellpoint,a.iconlist,a.satisfyscore,a.scheduleid,a.finaldestid';
    private static $typeid = 104;

    //邮轮线路列表
    public static function query($param)
    {

        $default = array(
            'row' => '10',
            'flag' => 'order',
            'offset' => 0,
            'destid' => 0,
            'attrid' => 0,
            'tagword' =>''

        );
        $param = array_merge($default, $param);
        extract($param);


        switch ($flag)
        {
            case 'new':
                     $list = self::get_line_new($offset, $row);
                break;
            case 'order':
                $list = self::get_line_order($offset, $row);
                break;
            case 'mdd':
                   $list = self::get_line_bymdd($offset, $row, $destid);
                break;
            case 'byship':
                $list = self::get_line_byship($offset, $row, $shipid);
                break;
            case 'theme':
                // $list = self::get_line_by_themeid($offset, $row, $themeid);
                break;
            case 'attr':
                // $list = self::get_line_by_attrid($offset, $row, $attrid);
                break;
            case 'tagrelative':

                $list = self::get_tagrelative($offset, $row, $tagword);
                break;
        }

        foreach ($list as &$v)
        {
            if($v['finaldestid'])
            {
                $v['finaldest_name'] = DB::select('kindname')->from('destinations')->where("id ={$v['finaldestid']}")->execute()->get('kindname');
            }
            $price_info = Model_Ship_Line::get_minprice($v['id'], array('info' => $v), 1);
            $v['price'] = $price_info['price'];
            $v['storeprice'] = $price_info['storeprice'];
            $v['starttime'] = Model_Ship_Line::get_starttime($v['id']);
            $v['attrlist'] = Model_Ship_Line::line_attr($v['attrid']);
            $v['url'] = Common::get_web_url($v['webid']) . "/ship/show_{$v['aid']}.html";
            $v['startcity_name'] = Model_Startplace::start_city($v['startcity']);
            $v['piclist_arr'] = Product::pic_list($v['piclist']);
            $v['iconlist'] = Product::get_ico_list($v['iconlist']);
            $v['schedule_name'] = DB::select('title')->from('ship_schedule')->where('id','=',$v['scheduleid'])->execute()->get('title');
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], self::$typeid); //评论次数
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], self::$typeid) + intval($v['bookcount']); //销售数量
        }
        return $list;
    }

    public static function supplier($param)
    {
        $default = array(
            'row' => '10',
            'offset' => 0
        );
        $list = Model_Ship::get_supplier_list($param);
        return $list;
    }

    //读取全局线路
    public static function get_line_order($offset, $row)
    {
        global $sys_webid;
        $offset = intval($offset);
        $row = intval($row);
        $sql = "SELECT " . self::$basefiled . " FROM `sline_ship_line` AS a LEFT JOIN `sline_allorderlist` b ON (a.id=b.aid and b.typeid=" . self::$typeid . ") ";
        $sql .= "WHERE a.ishidden=0 AND  a.webid={$sys_webid} ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $arr;
    }

    //读取全局线路
    public static function get_tagrelative($offset, $row,$tagword)
    {
        if(empty($tagword))
        {
            return null;
        }
        global $sys_webid;
        $offset = intval($offset);
        $row = intval($row);
        $sql = "SELECT " . self::$basefiled . " FROM `sline_ship_line` AS a LEFT JOIN `sline_allorderlist` b ON (a.id=b.aid and b.typeid=" . self::$typeid . ") ";
        $sql .= "WHERE a.ishidden=0 AND  a.webid={$sys_webid} ";

        if (!empty($tagword))
        {
            $tagword_arr = explode(',',$tagword);
            $tagword_w_arr = array();
            foreach($tagword_arr as $tag)
            {
                $tagword_w_arr[] = " FIND_IN_SET('{$tag}',a.tagword) ";
            }
            if(count($tagword_w_arr)>0)
            {
                $sql.=" and (".implode(' or ',$tagword_w_arr).")";
            }
            else
            {
                return null;
            }
        }
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $arr;
    }

    //读取全局线路
    public static function get_line_new($offset, $row)
    {
        global $sys_webid;
        $offset = intval($offset);
        $row = intval($row);
        $sql = "SELECT " . self::$basefiled . " FROM `sline_ship_line` AS a LEFT JOIN `sline_allorderlist` b ON (a.id=b.aid and b.typeid=" . self::$typeid . ") ";
        $sql .= "WHERE a.ishidden=0 AND  a.webid={$sys_webid} ";
        $sql .= "ORDER by a.modtime DESC,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $arr;
    }

    //读取某轮船下的线路
    public static function get_line_byship($offset, $row, $shipid)
    {
        global $sys_webid;
        $offset = intval($offset);
        $row = intval($row);
        $sql = "SELECT " . self::$basefiled . " FROM `sline_ship_line` AS a LEFT JOIN `sline_allorderlist` b ON (a.id=b.aid and b.typeid=" . self::$typeid . ") ";
        $sql .= "WHERE a.ishidden=0 AND  a.webid={$sys_webid} and shipid='{$shipid}' ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $arr;
    }

    //获取某个目的地下的邮轮
    private static function get_line_bymdd($offset, $row, $destid)
    {
        $offset = intval($offset);
        $row = intval($row);
        $destid = intval($destid);
        $sql = "SELECT " . self::$basefiled . " FROM `sline_ship_line` AS a LEFT JOIN `sline_kindorderlist` b ON (a.id=b.aid and b.typeid=104 and b.classid='$destid') ";
        $sql .= "WHERE a.ishidden=0 AND FIND_IN_SET('{$destid}',a.kindlist) ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $arr;
    }

    //轮船列表
    public static function ship($param)
    {
        $default = array(
            'row' => '10',
            'flag' => 'order',
            'offset' => 0,
            'destid' => 0,
            'attrid' => 0,
            'supplierid' => 0
        );
        $param = array_merge($default, $param);
        extract($param);
        switch ($flag)
        {

            case 'order':
                $list = self::get_ship_order($offset, $row);
                break;
            case 'sub':
                $list = self::get_ship_sub($offset, $row, $supplierid);
                break;
        }
        foreach ($list as &$v)
        {
            $v['url'] = Common::get_web_url(0) . "/ship/cruise_{$v['id']}.html";
        }
        return $list;
    }

    //获取普通排序的轮船列表
    public static function get_ship_order($offset, $row)
    {
        $offset = intval($offset);
        $row = intval($row);
        $sql = "SELECT * FROM `sline_ship` where ishidden=0 ORDER BY displayorder asc,addtime desc ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $arr;
    }

    //获取供应商下面的船只
    public static function get_ship_sub($offset, $row, $supplierid)
    {
        $offset = intval($offset);
        $row = intval($row);
        $supplierid = intval($supplierid);
        $sql = "SELECT * FROM `sline_ship` where ishidden=0 and supplierlist='{$supplierid}' ORDER BY displayorder asc,addtime desc ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = DB::query(Database::SELECT, $sql)->execute()->as_array();

        return $arr;
    }

    /**
     * @param $params
     * @return Array
     * 天数读取
     */

    public static function day_list($params)
    {
        $default = array('row' => '10');
        $params = array_merge($default, $params);
        extract($params);
        $suit = ORM::factory('ship_line_day')->get_all();


        $autoindex = 1;
        foreach ($suit as &$r)
        {
            $number = substr($r['title'], 0, 2);
            $r['number'] = $number;
            $arr = array("零", "一", "二", "三", "四", "五", "六", "七", "八", "九");
            if (strlen($number) == 1)
            {
                $result = $arr[$number];
            }
            else
            {
                if ($number == 10)
                {
                    $result = "十";
                }
                else
                {
                    if ($number < 20)
                    {
                        $result = "十";
                    }
                    else
                    {
                        $result = $arr[substr($number, 0, 1)] . "十";
                    }
                    if (substr($number, 1, 1) != "0")
                    {
                        $result .= $arr[substr($number, 1, 1)];
                    }
                }
            }

            if ($autoindex == count($suit))
            {
                $r['title'] = $result . "日游以上";
            }
            else
            {
                $r['title'] = $result . "日游";
            }

            $autoindex++;


        }

        return $suit;
    }

    public static function price_list($params)
    {
        $default = array('row' => '10');
        $params = array_merge($default, $params);
        extract($params);
        $suit = ORM::factory('ship_line_pricelist')
            ->where('lowerprice', '>=', 0)
            ->order_by('lowerprice', 'asc')
            ->get_all();
        foreach ($suit as &$row)
        {
            if ($row['lowerprice'] == 0 && $row['highprice'] != 0)
            {
                $row['title'] = Currency_Tool::symbol() . $row['highprice'] . '以下';
            }
            else if ($row['highprice'] == '' || $row['highprice'] == 0)
            {
                $row['title'] = Currency_Tool::symbol() . $row['lowerprice'] . '以上';
            }
            else if ($row['lowerprice'] != '' && $row['highprice'] != '')
            {
                $row['title'] = Currency_Tool::symbol() . $row['lowerprice'] . '-' . Currency_Tool::symbol() . $row['highprice'];
            }


        }
        return $suit;
    }

    //获取设施分类
    public static function facility_kind($param)
    {
        $default = array(
            'row' => '10',
            'shipid' => '0',
            'offset' => 0
        );
        $param = array_merge($default, $param);
        extract($param);
        $shipid = intval($shipid);
        $row = intval($row);
        $offset = intval($offset);

        if (!empty($shipid))
        {
            $sql = " SELECT DISTINCT a.* FROM sline_ship_facility_kind a inner join sline_ship_facility b on a.id=b.kindid where b.shipid='{$shipid}' ORDER BY  displayorder LIMIT {$offset},{$row}";
        }
        else
        {
            $sql = "SELECT * FROM sline_ship_facility_kind  ORDER BY  displayorder LIMIT {$offset},{$row}";
        }
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $list;
    }

    //获取设施列表
    public static function facility($param)
    {
        $default = array(
            'row' => '10',
            'shipid' => '0',
            'kindid' => 0,
            'offset' => 0
        );
        $param = array_merge($default, $param);
        extract($param);
        $shipid = intval($shipid);
        $row = intval($row);
        $offset = intval($offset);
        $kindid = intval($kindid);
        if (empty($shipid))
            return null;
        $where = " WHERE shipid='{$shipid}' ";
        $where .= !empty($kindid) ? " AND kindid='{$kindid}' " : '';
        $sql = "SELECT * FROM sline_ship_facility {$where} ORDER BY  displayorder LIMIT {$offset},{$row}";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        foreach($list as &$v)
        {
            $v['floors_names'] = Model_Ship_Floor::get_names_bystr($v['floors']);
        }
        return $list;
    }

    //获取舱房分类
    public static function room_kind($param)
    {
        $default = array(
            'row' => '10',
            'shipid' => '0',
            'offset' => 0
        );
        $param = array_merge($default, $param);
        extract($param);
        $shipid = intval($shipid);
        $row = intval($row);
        $offset = intval($offset);

        if (!empty($shipid))
        {
            $sql = " SELECT a.*,sum(b.num) as roomnum FROM sline_ship_room_kind a inner join sline_ship_room b on a.id=b.kindid where b.shipid='{$shipid}' GROUP BY a.id  ORDER BY  displayorder LIMIT {$offset},{$row}";
        }
        else
        {
            $sql = "SELECT * FROM sline_ship_room_kind  ORDER BY  displayorder LIMIT {$offset},{$row}";
        }
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $list;
    }

    //获取舱房分类
    public static function room($param)
    {
        $default = array(
            'row' => '10',
            'shipid' => '0',
            'kindid' => 0,
            'offset' => 0
        );
        $param = array_merge($default, $param);
        extract($param);
        $shipid = intval($shipid);
        $kindid = intval($kindid);
        $row = intval($row);
        $offset = intval($offset);

        $where = " WHERE shipid='{$shipid}' ";
        $where .= !empty($kindid) ? " AND kindid='{$kindid}' " : '';
        $sql = "SELECT * FROM sline_ship_room {$where} ORDER BY  displayorder LIMIT {$offset},{$row}";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        foreach($list as &$v)
        {
            $v['floors_str'] = Model_Ship_Floor::get_names_bystr($v['floors']);
        }
        return $list;
    }

    //获取楼层
    public static function floor($param)
    {
        $default = array(
            'row' => '10',
            'shipid' => '0',
            'kindid' => 0,
            'offset' => 0
        );
        $param = array_merge($default, $param);
        extract($param);
        $shipid = intval($shipid);
        $row = intval($row);
        $offset = intval($offset);
        $sql = "SELECT * FROM sline_ship_floor WHERE shipid='{$shipid}' ORDER BY  displayorder LIMIT {$offset},{$row}";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        foreach ($list as &$v)
        {
            $facility_names =  Model_Ship_Facility::get_names_byfloor($v['id']);
            $room_names = Model_Ship_Room::get_names_byfloor($v['id']);
            $v['facilityname_arr'] = empty($facility_names)?null:explode(',', $facility_names);
            $v['roomname_arr'] = empty($room_names)?null:explode(',', $room_names);

        }
        return $list;
    }

    public static function get_content($params)
    {
        $default = array(
            'typeid' => '',
            'productinfo' => 0,
            'onlyrealfield' => 0,
            'pc' => 0

        );
        $params = array_merge($default, $params);
        extract($params);
        if (empty($typeid))
        {
            return array();
        };
        $arr = DB::select('columnname', 'chinesename', 'isrealfield')->from('ship_line_content')->order_by('displayorder', 'asc')->execute()->as_array();

        $productid = $productinfo['id'];//产品id
        //邮轮扩展
        $ar = DB::select()->from('ship_line_extend_field')->where('productid','=',$productid)->execute()->as_array();

        $list = array();
        foreach ($arr as $v)
        {
            if ($v['columnname'] == 'tupian')
            {
                continue;
            }
            if ($v['isrealfield'] == 1)
            {
                $content = !empty($productinfo[$v['columnname']]) ? $productinfo[$v['columnname']] : $ar[0][$v['columnname']];
                $content = $content ? $content : '';
            }
            else
            {

                $content = $productinfo['id'];
            }
            //行程附件
            if ($v['columnname'] == 'linedoc')
            {
                if ('array' == strtolower($content))
                {
                    $content = null;
                }
            }
            $a = array();
            $a['columnname'] = $v['columnname'];
            $a['chinesename'] = $v['chinesename'];

            $a['content'] = $pc == 0 ? Product::strip_style($content) : $content; //针对PC/手机版选择是否去样式.

            //var_dump($a,13246798);
            $list[] = $a;

        }
        return $list;
    }
}