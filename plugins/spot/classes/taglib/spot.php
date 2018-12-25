<?php
defined('SYSPATH') or die('No direct access allowed.');

/**
 * Created by Phpstorm.
 * User: netman
 * Date: 15-9-29
 * Time: 上午10:43
 * Desc: 景点/门票调用标签
 */
class Taglib_Spot
{

    /*
     * 获取景点
     * @param 参数
     * @return array

   */
    private static $basefield = 'a.*';
    private static $typeid = 5;

    /**
     * 检测该产品模块是否安装
     * @return bool
     */
    public function right()
    {
        $bool = true;
        if (!St_Functions::is_system_app_install(self::$typeid))
        {
            $bool = false;
        }
        return $bool;
    }

    /**
     * @function 获取除本身的在外的相关景点
     * @param $params
     * @return array|mixed
     */
    public static function get_tagword_spot($params)
    {
        $default = array(
            'row' => '10',
            'offset' => 0,
            'tagword' => '',
            'spotid' => null
        );
        $params = array_merge($default, $params);
        extract($params);
        //查询相关tag内容
        $offset = intval($offset);
        $row = intval($row);
        $tagword_arr = explode(",", $tagword);
        if (count($tagword_arr) <= 0)
            return array();

        $sql = "SELECT " . self::$basefield . " FROM `sline_spot` a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=" . self::$typeid . ") ";
        $sql .= "WHERE a.ishidden=0 AND ( ";
        foreach ($tagword_arr as $tagword_item) {
            $sql .= "FIND_IN_SET('{$tagword_item}',a.tagword) OR ";
        }
        $sql = rtrim($sql, " OR ");
        $sql .= ") ";
        if (!is_null($spotid))
        {
            $sql .= "AND a.id<>{$spotid} ";
        }
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "limit {$offset},{$row}";
        $arr = self::execute($sql);
        $list = self::format_list_info($arr);
        return $list;
    }

    public static function format_list_info($list)
    {
        //对获取的数据进行初始化处理
        foreach ($list as &$v)
        {
            $priceArr = Model_Spot::get_minprice($v['id'], array('info' => $v));
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], self::$typeid); //评论次数
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], self::$typeid) + intval($v['bookcount']); //销售数量
            $v['sellprice'] = $priceArr['sellprice'];//挂牌价
            $v['price'] = $priceArr['price'];//最低价
            $v['iconlist'] = Product::get_ico_list($v['iconlist']);
            $v['satisfyscore'] = St_Functions::get_satisfy(self::$typeid, $v['id'], $v['satisfyscore']);//满意度
            $v['attrlist'] = Model_Spot_Attr::get_attr_list($v['attrid']);//属性列表.
            $v['url'] = Common::get_web_url($v['webid']) . "/spots/show_{$v['aid']}.html";
        }
        return $list;
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
                $list = self::get_spot_new($offset, $row);
                break;
            case 'order':
                $list = self::get_spot_order($offset, $row);
                break;
            case 'mdd':
                $list = self::get_spot_bymdd($offset, $row, $destid);
                break;
            case 'tagrelative':
                $list = self::get_spot_by_tagword($row, $offset, $tagword);
                break;
            case 'theme':
                $list = self::get_spot_by_themeid($offset, $row, $themeid);
                break;
        }
        $list=self::format_list_info($list);
        return $list;

    }

    /**
     * 获取门票类型
     * @param $params
     * @return Array
     */

    public static function suit_type($params)
    {
        $default = array('row' => '10', 'productid' => 0);
        $params = array_merge($default, $params);
        extract($params);
        $suit = ORM::factory('spot_ticket_type')
            ->where("spotid=:productid")
            ->order_by('displayorder','asc')
            ->param(':productid', $productid)
            ->get_all();

        foreach ($suit as $key => &$r)
        {
            if (self::check_suittype_hasticket($productid, $r['id']))
            {
                $r['title'] = $r['kindname'];
            }
            else
            {
                unset($suit[$key]);
            }
        }
        return $suit;

    }

    /**
     * 获取景点门票列表
     * @param $params
     * @return Array
     */

    public static function suit($params)
    {
        $default = array('row' => '10', 'productid' => 0);
        $params = array_merge($default, $params);
        extract($params);
        $suit = ORM::factory('spot_ticket')
            ->where("spotid=:productid")
            ->param(':productid', $productid)
            ->order_by('displayorder', 'ASC')
            ->get_all();
        $cur_time = time();
        foreach ($suit as $key => &$r)
        {
            $tickettype = DB::select('kindname')->from('spot_ticket_type')->where('id', '=', $r['tickettypeid'])->execute()->get('kindname');
            $r['ticketname'] = $r['title'];
            $title = $tickettype . '(' . $r['title'] . ')';
            $r['title'] = $title;
            $priceArr = Model_Spot::get_minprice($r['spotid'], $r['id']);
            $r['ourprice'] = $priceArr['price'];
            $r['price'] = Currency_Tool::price($r['price']);
            $sql = "select * from sline_spot_ticket_price a left join sline_spot_ticket b on a.ticketid=b.id   where a.ticketid='{$r['id']}' and a.number!=0  and a.day>({$cur_time}+b.day_before*24*3600-case when (b.hour_before=0 and b.minute_before=0) then 24*3600 else (3600*b.hour_before+b.minute_before*60) end) order by a.day asc limit 1";
            $info = DB::query(Database::SELECT,$sql)->execute()->current();
            $r['number'] = isset($info['number']) ? $info['number'] : 0;
            $r['startTime'] = !empty($info) ? $info['day'] : time();
            $r['paytype_name'] = Model_Member_Order::get_paytype_name($r['paytype']);
        }

        return $suit;

    }

    /**
     * 获取景点门票列表
     * @param $params
     * @return Array
     */

    public static function suit_by_type($params)
    {
        $default = array('row' => '10', 'productid' => 0, 'suittypeid' => 0);
        $params = array_merge($default, $params);
        extract($params);

        $suit = ORM::factory('spot_ticket')
            ->where("spotid=:productid and tickettypeid=:tickettypeid")
            ->param(':productid', $productid)
            ->param(':tickettypeid', $suittypeid)
            ->and_where('status','=',3)
            ->order_by('displayorder', 'ASC')
            ->get_all();
        $suitInfo=Model_Spot_Suit::format_suit_info($suit);
        return $suitInfo;

    }

    /**
     * 获取景点门票列表:非类型分类
     * @param $params
     * @return Array
     */

    public static function suit_list($params)
    {
        $default = array('row' => '10', 'productid' => 0, 'suittypeid' => 0);
        $params = array_merge($default, $params);
        extract($params);

        $suit = ORM::factory('spot_ticket')
            ->where("spotid=:productid")
            ->param(':productid', $productid)
            ->and_where('status','=',3)
            ->order_by('displayorder', 'ASC')
            ->get_all();
        $suitInfo=Model_Spot_Suit::format_suit_info($suit);
        return $suitInfo;

    }

    /**
     * 获取门票价格列表
     * @param $params
     * @return array
     */
    public static function price_list($params)
    {
        $default = array('row' => '10');
        $params = array_merge($default, $params);
        extract($params);
        $arr = ORM::factory('spot_pricelist')
            ->where("webid=0")
            ->limit($row)
            ->get_all();
        foreach ($arr as &$row)
        {
            if ($row['min'] != '' && $row['max'] != '')
            {
                $row['title'] = Currency_Tool::symbol() . $row['min'] . '-' . Currency_Tool::symbol() . $row['max'];
            }
            else if ($row['min'] == '')
            {
                $row['title'] = Currency_Tool::symbol() . $row['max'] . '以下';
            }
            else if ($row['max'] == '')
            {
                $row['title'] = Currency_Tool::symbol() . $row['min'] . '以上';
            }
        }
        return $arr;

    }


    /*
     * 获取最新景点
     * */
    private static function get_spot_new($offset, $row)
    {
        $sql = "SELECT " . self::$basefield . " FROM `sline_spot` a ";
        $sql .= "WHERE a.ishidden=0 ORDER BY a.modtime desc,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;

    }

    /*
     * 按顺序获取酒店
     * */
    private static function get_spot_order($offset, $row)
    {
        $sql = "SELECT " . self::$basefield . " FROM `sline_spot` a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=" . self::$typeid . ") ";
        $sql .= "WHERE a.ishidden=0 ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "limit {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;


    }

    private static function get_spot_by_tagword($row, $offset, $tagword)
    {
        $offset = intval($offset);
        $row = intval($row);
        $tagword_arr = explode(",", $tagword);
        if (count($tagword_arr) <= 0)
            return array();

        $sql = "SELECT " . self::$basefield . " FROM `sline_spot` a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=" . self::$typeid . ") ";
        $sql .= "WHERE a.ishidden=0 AND ( ";
        foreach ($tagword_arr as $tagword_item)
        {
            $sql .= "FIND_IN_SET('{$tagword_item}',a.tagword) OR ";
        }
        $sql = rtrim($sql, " OR ");
        $sql .= ") ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "limit {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;
    }

    /*
     * 按目的地获取景点
     * */
    private static function get_spot_bymdd($offset, $row, $destid)
    {
        $sql = "SELECT " . self::$basefield . " FROM `sline_spot` a ";
        $sql .= "LEFT JOIN `sline_kindorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.classid = $destid and b.typeid=" . self::$typeid . ") ";
        $sql .= "WHERE a.ishidden=0 AND FIND_IN_SET('$destid',a.kindlist) ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;
    }

    /**
     * @param $spotid
     * @param $tickettypeid
     * @return mixed
     * 检测门票类型是否有票
     */
    private static function check_suittype_hasticket($spotid, $tickettypeid)
    {
        $sql = "SELECT id FROM `sline_spot_ticket`  WHERE spotid='$spotid' AND tickettypeid='$tickettypeid'";
        $row = DB::query(1, $sql)->execute()->current();
        return $row['id'] ? true : false;


    }

    /*
 * 获取专题景点
 * */
    private static function get_spot_by_themeid($offset, $row, $themeid)
    {
        $sql = "SELECT " . self::$basefield . " FROM `sline_spot` a ";
        $sql .= "WHERE a.ishidden=0 AND FIND_IN_SET($themeid,a.themelist) ";
        $sql .= "ORDER BY a.modtime desc,a.addtime DESC ";
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