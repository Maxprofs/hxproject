<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Car extends ORM
{
    public function delete_clear()
    {

        $suits = ORM::factory('car_suit')->where("carid={$this->id}")->find_all()->as_array();
        foreach ($suits as $s)
        {
            if ($s->id)
                $s->delete_clear();
        }

        $this->delete();
    }

    /*
     * 更新最低报价
     * */
    public static function update_min_price($carid)
    {
        $sql = "SELECT MIN(adultprice) as price FROM sline_car_suit_price WHERE carid='$carid' and adultprice>0 and day>=UNIX_TIMESTAMP()";
        $ar = DB::query(1, $sql)->execute()->as_array();
        $price = $ar[0]['price'] ? $ar[0]['price'] : 0;
        $model = ORM::factory('car', $carid);
        $model->price = $price;
        $model->update();
    }

    public static function car_list($pagesize,$keyword)
    {
        $pagesize = $pagesize ? $pagesize : 30;
        $st_distributor_id = intval(Cookie::get('st_distributor_id'));
        $w = "FIND_IN_SET('{$st_distributor_id}',distributorlist) ";
        $keyword = Common::get_keyword($keyword);
        if (!empty($keyword))
        {
            $w .= preg_match('`^\d+$`', $keyword) && preg_match('`^[A-Za-z]\d+`', $keyword) ? " and id={$keyword}" : " and (title like '%{$keyword}%')";

        }
        //2.路由字符串
        $url_array = array(
            'controller' => 'index',
            'action' => 'list'
        );
        $return = self::_set_pages('car', $pagesize, $url_array, 'addtime', $w, 'DESC','query_string');

        $return['list'] = self::format_data($return['list']);

        return $return ;
    }
    /**
     * 分页
     * @param $db_name
     * @param $pagesize
     * @param array $url_array
     * @param $sort
     * @param null $where
     * @param string $orderby
     * @param string $source
     * @return array
     */
    public static function _set_pages($db_name, $pagesize, array $url_array, $sort, $where = NULL, $orderby = 'DESC', $source = 'query_string')
    {

        //获取数据库对象
        if ($where)
        {
            $page_object = ORM::factory($db_name)->where($where);
        }

        else
        {
            $page_object = ORM::factory($db_name);
        }
        //定义每页显示的条数
        $pagesize = isset($pagesize) ? $pagesize : 20;

        $pager = Pagination::factory(array(
                'current_page' => array('source' => $source, 'key' => 'p'), //配置数据的总量
                'view'=>'pagination/distributor',
                'total_items' => $page_object->count_all(), //数据总条数
                'items_per_page' => $pagesize,   //配置每页显示的数量
                'first_page_in_url' => false,  //是否把第一页 p = 1 显示在地址栏 true为显示 false为不显示
            )
        );


        $pager->route_params($url_array);

        if ($where) $page_object = ORM::factory($db_name)->where($where);
        else
            $page_object = ORM::factory($db_name);

        //返回当前页的数据结果
        $list = $page_object->offset($pager->offset)->limit($pager->items_per_page)->order_by($sort, $orderby)->get_all();

        return array('list' => $list, 'pageinfo' => $pager);

    }


    /**
     * 格式化数据输出
     * @param $arr
     */
    public static function format_data($arr)
    {
        foreach($arr as &$row)
        {

            $row['url'] = Common::get_web_url($row['webid']) . "/cars/show_{$row['aid']}.html";
            $row['series'] = Common::get_series($row['id'], '03');//编号
            $row['carkind'] = ORM::factory('car_kind',$row['carkindid'])->get('kindname');
            $row['expired_date'] = self::get_expired_date($row['id']);
            $row['suit'] = self::get_car_suit($row['id']);



        }
        return $arr;

    }

    /**
     * 获取酒店过期日期
     * @param $hotelid
     */
    public static function get_expired_date($carid,$suitid='')
    {
        $w = !empty($suitid) ? " AND suitid=$suitid " : '';
        $sql = "SELECT MAX(day) AS suitday FROM `sline_car_suit_price` WHERE carid='$carid' $w AND day>".time();
        $row = DB::query(1,$sql)->execute()->current();
        return $row['suitday'] ? date('Y-m-d',$row['suitday']) : '';
    }

    /**
     * 最低价格与利润
     * @param $hotelid
     * @param string $suitid
     * @return mixed
     */
    public static function get_min_data($carid,$suitid='')
    {
        $w = !empty($suitid) ? " AND suitid=$suitid " : '';
        $sql = "SELECT MIN(adultprice) AS price,MIN(adultprofit) as profit FROM `sline_car_suit_price` WHERE carid='$carid' $w AND day>".time();
        $row = DB::query(1,$sql)->execute()->current();
        return $row;
    }


    /**
     * @param $hotelid
     */

    public static function get_car_suit($carid)
    {
        $sql = "SELECT * FROM `sline_car_suit` WHERE carid='$carid'";
        $arr = DB::query(1,$sql)->execute()->as_array();
        foreach($arr as &$row)
        {
            $min_data = self::get_min_data($carid,$row['id']);
            $row['expired_date'] = self::get_expired_date($carid,$row['id']);
            $row['min_price'] = $min_data['price'];
            $row['min_profit'] = $min_data['profit'];
            $row['suit_type'] = ORM::factory('car_suit_type',$row['suittypeid'])->get('kindname');
        }
        return $arr;
    }

    /**
     * @param $newname
     * @param $carid
     * @return int|mixed
     * 添加套餐类型
     */
    public static function add_suittype($newname,$carid)
    {
        $m = ORM::factory('car_suit_type')->where("kindname='$newname'")->find();
        if($m->loaded())
        {
            $id = $m->id;
        }
        else
        {
            $mi = ORM::factory('car_suit_type');
            $mi->kindname = $newname;
            $mi->carid = $carid;
            $mi->save();
            $id = 0;
            if($mi->saved())
            {
                $mi->reload();
                $id = $mi->id;
            }
        }

        return $id;
    }




}