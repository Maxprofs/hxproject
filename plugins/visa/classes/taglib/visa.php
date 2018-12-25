<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Taglib_Visa
 * 签证标签
 */
class Taglib_Visa
{

    private static $_typeid = 8;
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

    //private static $basefiled = '';
    private static $default = array(
        'row' => '10',
        'flag' => '',
        'offset' => 0,
        'destid' => 0,
        'pid' => 0,
        'tagword' => ''
    );

    /**
     * 签证
     * @param $param
     */
    public static function query($param)
    {
        $param = array_merge(self::$default, $param);
        extract($param);
        switch ($flag)
        {
            case 'order':
                $list = self::get_visa_order($offset, $row);
                break;
            case 'tagrelative':
                $list = self::get_visa_by_tagword($row, $offset, $tagword);
                break;
            case 'new':
                $list = self::get_visa_new($offset, $row);
                break;

        }
        foreach ($list as &$v)
        {
            $v['litpic'] = Common::img($v['litpic']);
            $v['marketprice'] = Currency_Tool::price($v['marketprice']);
            $v['sellprice'] = $v['marketprice'];
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], self::$_typeid) + intval($v['bookcount']); //销售数量
            $v['price'] = Currency_Tool::price($v['price']);
            $v['url'] = Common::get_web_url($v['webid']) . "/visa/show_{$v['aid']}.html";
        }
        return $list;

    }

    /**
     * @param $param
     * @return Array
     * @desc 读取签发城市
     */
    public static function city($param)
    {
        $default = array(
            'row' => '10',
            'flag' => '',
            'offset' => 0,
        );
        $param = array_merge($default, $param);
        extract($param);
        $arr = ORM::factory('visa_city')
            ->where("isopen=1")
            ->get_all();
        foreach($arr as &$r)
        {
            $r['title'] = $r['kindname'];
        }
        return $arr;

    }
    /**
     * @param $param
     * @return Array
     * @desc 读取签证类型
     */
    public static function kind($param)
    {
        $default = array(
            'row' => '10',
            'offset' => 0,
        );
        $param = array_merge($default, $param);
        extract($param);
        $arr = ORM::factory('visa_kind')
            ->where("isopen=1")
            ->get_all();
        foreach($arr as &$r)
        {
            $r['title'] = $r['kindname'];
        }
        return $arr;

    }

    /**
     * 签证热门国家、地区
     * @param $param
     * @return mixed
     */
    public static function area($param)
    {
        $param = array_merge(self::$default, $param);
        extract($param);
        switch ($flag)
        {
            case 'order':
                $list = self::get_area_order($offset, $row);
                if($minprice=='true'){
                  self::get_min_price($list);
                }
                break;
				case 'hot':
                $list = self::get_area_hot($offset, $row);
                if($minprice=='true'){
                  self::get_min_price($list);
                }
                break;
            case 'query':
                $list = self::get_area_query($offset, $row, $pid);
                break;
        }
        foreach ($list as &$v)
        {
            $v['litpic'] = Common::img($v['litpic']);
            $v['url'] = Common::get_web_url($v['webid']) . "/visa/{$v['pinyin']}/";
            $v['title'] = $v['kindname'];
        }
        return $list;
    }

    /**
     * @param $offset
     * @param $row
     * @return mixed
     */
    public static function get_area_order($offset, $row)
    {
        $sql = 'SELECT * FROM sline_visa_area ';
        $sql .= 'WHERE  isopen=1 and webid=0 ';
        $sql .= 'order by displayorder asc,id desc ';
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;
    }

	    //热门签证国家
    public static function get_area_hot($offset, $row)
    {

        $sql = 'SELECT * FROM sline_visa_area ';
        $sql .= 'WHERE  isopen=1 and webid=0 and ishot=1 and pid!=0 ';
        $sql .= 'order by displayorder asc,id desc ';
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;
    }


    public static function get_area_query($offset, $row, $pid)
    {
        $pid = $pid ? $pid : 0;
        $sql = 'SELECT * FROM sline_visa_area ';
        $sql .= "WHERE pid={$pid} and isopen=1 and webid=0 ";
        $sql .= 'order by displayorder asc,id desc ';
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;
    }

    public static function get_visa_order($offset,$row)
    {

        $where = "a.webid=0 AND a.ishidden=0";
        $sql = "SELECT a.* FROM `sline_visa` AS a LEFT JOIN `sline_allorderlist` AS b ON a.id=b.aid AND b.typeid=8 ";
        $sql .= "WHERE {$where} ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

    private static function get_visa_new($offset, $row)
    {
        $sql = "SELECT a.* FROM `sline_visa` a ";
        $sql .= "WHERE a.ishidden=0 ORDER BY a.modtime desc,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;

    }

    private static function get_visa_by_tagword($row, $offset, $tagword)
    {
        $offset = intval($offset);
        $row = intval($row);
        $tagword_arr = explode(",", $tagword);
        if (count($tagword_arr) <= 0)
            return array();

        $sql = "SELECT a.* FROM `sline_visa` a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=" . self::$_typeid . ") ";
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

    private static function get_min_price(&$destArr){
      foreach($destArr as &$v){
          $sql="SELECT min(CAST(price as SIGNED)) as price FROM `sline_visa` WHERE ishidden=0 and nationid={$v['id']} and price>0 group by nationid ";
          $arr = DB::query(1, $sql)->execute()->current();
          $v['price']=$arr==false?0:Currency_Tool::price($arr['price']);
      }
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


}