<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Taglib_Tongyong
 * 通用标签
 *
 */
class Taglib_Tongyong
{

    /**
     * 获取通用套餐列表
     * @param $params
     * @return Array
     */

    public static function suit($params)
    {
        $default = array('row' => '10', 'productid' => 0);
        $params = array_merge($default, $params);
        extract($params);
        $suit = ORM::factory('model_suit')
            ->where("productid=:productid")
            ->param(':productid', $productid)
            ->get_all();
        foreach ($suit as &$r)
        {
            $r['title'] = $r['suitname'];
            $tempData = self::recent_suit($r['id'],$productid);
            if ($tempData)
            {
                $r['price'] = $tempData['price'];
                $r['day'] = date('Y-m-d', $tempData['day']);
                $r['maxnumber'] = $tempData['number'];
            }
            else
            {
                $r['price'] = 0;
                $r['day'] = date('Y-m-d');
            }

        }
        return $suit;

    }

    /**
     * @function 当前套餐最近可预订产品的价格及日期
     * @param $suitId
     * @return mixed
     */
    public static function recent_suit($suitId,$product_id)
    {
        $result = DB::select()->from('model_suit_price')->where('day', '>', strtotime(date('Ymd')))->and_where('number', '!=', 0)->and_where('suitid', '=', $suitId)->and_where('productid','=',$product_id)->execute()->current();
        $result['price'] = Currency_Tool::price($result['price']);
        return $result;
    }

    /**
     * 获取通用产品列表
     * @param $params
     * @return mixed
     */
    public static function query($params)
    {

        $default = array(
            'row' => '10',
            'pinyin' => '',
            'typeid' => '',
            'flag' => '',
            'offset' => 0,
            'destid' => 0,
            'tagword' => ''
        );
        $params = array_merge($default, $params);
        extract($params);
        $tongyongModel = null;
        if (!empty($typeid))
        {
            $tongyongModel = ORM::factory('model', $typeid);
        }
        else if (empty($typeid) && !empty($pinyin))
        {
            $tongyongModel = ORM::factory('model')->where('pinyin', '=', $pinyin)->find();
        }


        if (empty($tongyongModel) || !$tongyongModel->loaded())
        {
            return null;
        }

        $modelInfo = $tongyongModel->as_array();
        $typeid = $tongyongModel->id;
        $pinyin = $tongyongModel->pinyin;

        $list = null;
        switch ($flag)
        {
            case 'mdd':
                $list = self::get_mdd_data($modelInfo, $offset, $row,$destid);
                break;
            case 'new':
                $list = self::get_list_new($modelInfo, $offset, $row);
                break;
            case 'order':
                $list = self::get_list_order($modelInfo, $offset, $row);
                break;
            case 'tagrelative':
                $list = self::get_list_bytagword($modelInfo, $offset, $row, $tagword);
                break;
        }
        //对获取的数据进行初始化处理
        foreach ($list as &$v)
        {
            $v['price'] = Model_Tongyong::get_minprice($v['id'], array('info' => $v));
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], $typeid); //评论次数
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], $typeid) + intval($v['bookcount']); //销售数量
            $v['sellprice'] = Model_Tongyong::get_min_sellprice($v['id']);
            $v['attrlist'] = Model_Model_Attr::get_attr_list($v['attrid'],$typeid);//属性列表.
            $v['url'] = Common::get_web_url($v['webid']) . "/" . $pinyin . "/show_{$v['aid']}.html";
        }
        return $list;
    }

    /**
     * 获取最新的列表
     * @param $typeid
     * @param $offset
     * @param $row
     */
    public static function get_list_new($modelInfo, $offset, $row)
    {
        $typeid = $modelInfo['id'];
        $addtable = $modelInfo['addtable'];
        $addtable = 'sline_' . $addtable;

        $w = " where a.typeid={$typeid} and a.ishidden=0 ";
        $sql = "SELECT a.* FROM sline_model_archive as a " .
            " LEFT JOIN {$addtable} b on (a.id=b.productid) " .
            " LEFT JOIN sline_allorderlist c on (a.id=c.id and c.typeid={$typeid})" .
            $w .
            " ORDER BY ifnull(c.displayorder,9999) asc,a.addtime desc " .
            " limit {$offset},{$row}";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $list;
    }

    /**
     * 获取目的地相关的列表
     * @param $typeid
     * @param $offset
     * @param $row
     * @param $destid
     */
    public static function get_mdd_data($modelInfo, $offset, $row,$destid)
    {
        $typeid = $modelInfo['id'];
        $addtable = $modelInfo['addtable'];
        $addtable = 'sline_' . $addtable;


        $w = " where a.typeid={$typeid} and a.ishidden=0 and find_in_set({$destid},a.kindlist) ";
        $sql = "SELECT a.* FROM sline_model_archive as a " .
            " LEFT JOIN {$addtable} b on (a.id=b.productid) " .
            " LEFT JOIN sline_allorderlist c on (a.id=c.id and  a.typeid=c.typeid)" .
            $w .
            " ORDER BY ifnull(c.displayorder,9999) asc,a.addtime desc " .
            " limit {$offset},{$row}";

        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $list;
    }


    /**
     * 执行sql
     * @param $sql
     * @return mixed
     */
    private static function execute($sql)
    {
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

    public static function get_list_order($modelInfo, $offset, $row)
    {
        $typeid = $modelInfo['id'];
        $addtable = $modelInfo['addtable'];
        $addtable = 'sline_' . $addtable;

        $w = " where a.ishidden=0 and a.typeid={$typeid} ";
        $sql = "SELECT a.* FROM sline_model_archive as a " .
            " LEFT JOIN {$addtable} b on (a.id=b.productid) " .
            " LEFT JOIN sline_allorderlist c on (a.aid=c.aid and c.typeid={$typeid})" .
            $w .
            " ORDER BY ifnull(c.displayorder,9999) asc,a.addtime desc " .
            " limit {$offset},{$row}";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $list;
    }

    public static function get_list_bytagword($modelInfo, $offset, $row, $tagword)
    {
        $typeid = $modelInfo['id'];
        $addtable = $modelInfo['addtable'];
        $addtable = 'sline_' . $addtable;
        $tagword_arr = explode(",", $tagword);
        if (count($tagword_arr) <= 0)
            return array();

        $w = " where a.ishidden=0 and a.typeid={$typeid} AND ( ";
        foreach ($tagword_arr as $tagword_item)
        {
            $w .= "FIND_IN_SET('{$tagword_item}',a.tagword) OR ";
        }
        $w = rtrim($w, " OR ");
        $w .= ") ";

        $sql = "SELECT a.* FROM sline_model_archive as a " .
            " LEFT JOIN {$addtable} b on (a.id=b.productid) " .
            " LEFT JOIN sline_allorderlist c on (a.aid=c.aid and c.typeid={$typeid})" .
            $w .
            " ORDER BY ifnull(c.displayorder,9999) asc,a.addtime desc " .
            " limit {$offset},{$row}";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $list;

    }

}