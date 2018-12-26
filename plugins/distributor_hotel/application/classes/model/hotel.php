<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Hotel extends ORM
{
    public function delete_clear()
    {

        $rooms = ORM::factory('hotel_room')->where("hotelid={$this->id}")->find_all()->as_array();
        foreach ($rooms as $room)
        {
            if ($room->id)
                $room->delete_clear();
        }

        $this->delete();
    }

    /*
     * 更新最低报价
     * */
    public static function update_min_price($hotelid)
    {
        $sql = "SELECT MIN(price) as price FROM sline_hotel_room_price WHERE hotelid='$hotelid' and price>0 and day>=UNIX_TIMESTAMP()";
        $ar = DB::query(1, $sql)->execute()->as_array();
        $price = $ar[0]['price'] ? $ar[0]['price'] : 0;
        $model = ORM::factory('hotel', $hotelid);
        $model->price = $price;
        $model->update();
    }

    public static function hotel_list($pagesize,$keyword)
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
        $return = self::_set_pages('hotel', $pagesize, $url_array, 'addtime', $w, 'DESC','query_string');

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
            $row['url'] = Common::get_web_url($row['webid']) . "/hotels/show_{$row['aid']}.html";
            $row['series'] = Common::get_series($row['id'], '02');//编号
            $row['rank'] = ORM::factory('hotel_rank',$row['hotelrankid'])->get('hotelrank');
            $row['expired_date'] = self::get_expired_date($row['id']);
            $row['suit'] = self::get_hotel_suit($row['id']);
        }
        return $arr;

    }

    /**
     * 获取酒店过期日期
     * @param $hotelid
     */
    public static function get_expired_date($hotelid,$suitid='')
    {
        $w = !empty($suitid) ? " AND suitid=$suitid " : '';
        $sql = "SELECT MAX(day) AS suitday FROM `sline_hotel_room_price` WHERE hotelid='$hotelid' $w AND day>".time();
        $row = DB::query(1,$sql)->execute()->current();
        return $row['suitday'] ? date('Y-m-d',$row['suitday']) : '';
    }

    /**
     * 最低价格与利润
     * @param $hotelid
     * @param string $suitid
     * @return mixed
     */
    public static function get_min_data($hotelid,$suitid='')
    {
        $w = !empty($suitid) ? " AND suitid=$suitid " : '';
        $sql = "SELECT MIN(price) AS price,MIN(profit) as profit FROM `sline_hotel_room_price` WHERE hotelid='$hotelid' $w AND day>".time();
        $row = DB::query(1,$sql)->execute()->current();
        return $row;
    }


    /**
     * @param $hotelid
     */

    public static function get_hotel_suit($hotelid)
    {
        $sql = "SELECT * FROM `sline_hotel_room` WHERE hotelid='$hotelid'";
        $arr = DB::query(1,$sql)->execute()->as_array();
        foreach($arr as &$row)
        {
            $min_data = self::get_min_data($hotelid,$row['id']);
            $row['expired_date'] = self::get_expired_date($hotelid,$row['id']);
            $row['min_price'] = $min_data['price'];
            $row['min_profit'] = $min_data['profit'];
        }
        return $arr;
    }




}