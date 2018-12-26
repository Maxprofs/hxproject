<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Spot extends ORM {

    protected  $_table_name = 'spot';

    /*
 * 更新最低报价
 * */
    public static function update_min_price($spotid)
    {
        $sql = "SELECT MIN(ourprice) as price FROM sline_spot_ticket WHERE spotid='$spotid' and ourprice>0";
        $ar = DB::query(1, $sql)->execute()->as_array();
        $price = $ar[0]['price'] ? $ar[0]['price'] : 0;
        $model = ORM::factory('spot', $spotid);
        $model->price = $price;
        $model->update();
    }

    public static function spot_list($pagesize,$keyword)
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
        $return = self::_set_pages('spot', $pagesize, $url_array, 'addtime', $w, 'DESC','query_string');

        $return['list'] = self::format_data($return['list']);

        return $return ;
    }

    //门票列表
    public static function ticket_list($pagesize,$keyword)
    {

        $url_array = array(
            'controller' => 'index',
            'action' => 'list'
        );
        //获取数据库对象

        //定义每页显示的条数
        $pagesize = isset($pagesize) ? $pagesize : 20;

        $ticket_result = self::get_ticket_list($pagesize,$keyword);

        $pager = Pagination::factory(array(
                'current_page' => array('source' => 'query_string', 'key' => 'p'), //配置数据的总量
                'view'=>'pagination/distributor',
                'total_items' =>$ticket_result['total'], //数据总条数
                'items_per_page' => $pagesize,   //配置每页显示的数量
                'first_page_in_url' => false,  //是否把第一页 p = 1 显示在地址栏 true为显示 false为不显示
            )
        );
        $pager->route_params($url_array);
        return array('list' => $ticket_result['list'], 'pageinfo' => $pager);
    }

    //获取门票列表
    public static function get_ticket_list($pagesize,$keyword)
    {
        $pagesize = !empty($pagesize) ? $pagesize : 20;
        $page = intval($_GET['p']);
        $page = $page < 1 ? 1 : $page;
        $offset = ($page - 1) * $pagesize;


        $st_distributor_id = intval(Cookie::get('st_distributor_id'));
        $w = " where FIND_IN_SET('{$st_distributor_id}',a.distributorlist) ";
        $keyword = Common::get_keyword($keyword);
        if (!empty($keyword)) {
            $w .= preg_match('`^\d+$`', $keyword) && preg_match('`^[A-Za-z]\d+`', $keyword) ? " and spoid={$keyword} " : " and (a.title like '%{$keyword}%' or b.title like '%{$keyword}%') ";
        }

        $sql = " select a.*,b.title as productname,b.webid,b.aid from sline_spot_ticket a left join sline_spot b on a.spotid=b.id {$w} order by a.modtime desc limit {$offset},{$pagesize} ";
        $sql_num = " select count(*) as num from sline_spot_ticket a left join sline_spot b on a.spotid=b.id {$w} ";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        foreach ($list as &$row)
        {
            $row['url']= Common::get_web_url($row['webid']) . "/spots/show_{$row['aid']}.html";
        }

        $total = DB::query(Database::SELECT,$sql_num)->execute()->get('num');
        return array('list'=>$list,'total'=>$total);

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

            $row['url'] = Common::get_web_url($row['webid']) . "/spots/show_{$row['aid']}.html";
            $row['series'] = Common::get_series($row['id'], '05');//编号
            //$row['expired_date'] = self::get_expired_date($row['id']);
            $row['suit'] = self::get_spot_suit($row['id']);



        }
        return $arr;

    }

    /**
     * 获取过期日期
     * @param $hotelid
     */
    public static function get_expired_date($carid,$suitid='')
    {

    }

    /**
     * 最低价格与利润
     * @param $hotelid
     * @param string $suitid
     * @return mixed
     */
    public static function get_min_data($spotid,$suitid='')
    {
        $w = !empty($suitid) ? " AND id=$suitid " : '';
        $sql = "SELECT MIN(ourprice) AS price  FROM `sline_spot_ticket` WHERE spotid='$spotid' $w ";
        $row = DB::query(1,$sql)->execute()->current();
        return $row;
    }
    public static function get_minprice($spotid, $params = array())
    {
        $rs = array('price' => 0);

        $time = strtotime(date('Y-m-d'));
        $update_minprice = false;
        if (!is_array($params))
        {
            $params = array('ticketid' => $params);
        }

        $where = "spotid='$spotid'   and `day`>=$time and `number`!=0";
        if($params['ticketid'])
        {
            $where .=" and ticketid={$params['ticketid']}";
        }
        $cur_time = time();
        $w = isset($params['ticketid']) ? " and a.ticketid ={$params['ticketid']} " : '';
        $sql = "select MIN(adultmarketprice) as sellprice from sline_spot_ticket_price a left join sline_spot_ticket b on a.ticketid=b.id   where b.spotid='{$spotid}' and a.number!=0 {$w} and a.day>({$cur_time}+b.day_before*24*3600-case when (b.hour_before=0 and b.minute_before=0) then 24*3600 else (3600*b.hour_before+b.minute_before*60) end) group by a.ticketid order by sellprice";
        $sellprice = DB::query(1, $sql)->execute()->get('sellprice');
        $rs['sellprice'] = Currency_Tool::price($sellprice) ?  Currency_Tool::price($sellprice) :0;


        if (!isset($params['ticketid']))
        {
            //报价最低
            if (!isset($params['info']))
            {
                $params['info'] = DB::select('price', 'price_date')->from('spot')->where('id', '=', $spotid)->execute()->current();
            }
            if ($time == $params['info']['price_date'])
            {
                $rs['price'] = Currency_Tool::price($params['info']['price']);
                return $rs;
            }
            //更新最低价
            $update_minprice = true;
        }

        $where = isset($params['ticketid']) ? " and a.ticketid ={$params['ticketid']} " : '';

        $sql = "select a.ticketid,min(adultprice) as price from sline_spot_ticket_price a left join sline_spot_ticket b on a.ticketid=b.id   where b.spotid='{$spotid}' and a.number!=0 {$where} and a.day>({$cur_time}+b.day_before*24*3600-case when (b.hour_before=0 and b.minute_before=0) then 24*3600 else (3600*b.hour_before+b.minute_before*60) end ) group by a.ticketid order by price";
        $result = DB::query(1, $sql)->execute()->current();
        if ($result)
        {
            $rs['price'] = $result['price'];
        }
        //更新产品最低价
        if ($update_minprice)
        {
            DB::update('spot')->set(array('price' => $rs['price'], 'price_date' => $time))->where('id', '=', $spotid)->execute();
        }
        $rs['price'] = Currency_Tool::price($rs['price']);
        return $rs;
    }


    /**
     * @param $hotelid
     */

    public static function get_spot_suit($productid)
    {
         $paytype_names = array('', '全款支付', '定金支付', '二次确认支付', '线下支付');
        $sql = "SELECT * FROM `sline_spot_ticket` WHERE spotid='$productid'";
        $arr = DB::query(1,$sql)->execute()->as_array();
        foreach($arr as &$row)
        {
            $min_data = Model_Spot::get_minprice($productid, $row['id']);;

            $row['min_price'] = $min_data['price'];
            $row['paytype_name'] =$paytype_names[$row['paytype']];

            $day_before = $row['day_before'];
            $hour_before = $row['hour_before'];
            $minute_before = $row['minute_before'];
            $str='';
            if($day_before!=0 || $hour_before!=0 || $minute_before!=0)
            {
                $str .= !$day_before || $day_before == 0 ? '当天' : $day_before . '天';
                if($hour_before!=0 || $minute_before!=0)
                {
                    $str .= $hour_before < 10 ? '0' .$hour_before : $hour_before;
                    $str .= ':';
                    $str .= $minute_before < 10 ? '0' . $minute_before : $minute_before;
                }
            }

            $row['day_before_str'] = $str;
            $row['suit_type'] = ORM::factory('spot_ticket_type',$row['tickettypeid'])->get('kindname');
        }
        return $arr;
    }

    /**
     * @param $newname
     * @param $spotid
     * @return int|mixed
     * 添加套餐类型
     */
    public static function add_suittype($newname,$productid)
    {
        $m = ORM::factory('spot_ticket_type')->where("kindname='$newname'")->find();
        if($m->loaded())
        {
            $id = $m->id;
        }
        else
        {
            $mi = ORM::factory('spot_ticket_type');
            $mi->kindname = $newname;
            $mi->spotid = $productid;
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

    public static function updateMinPrice($spotid)
    {
        $sql = "SELECT MIN(cast(ourprice as unsigned)) as price FROM sline_spot_ticket WHERE spotid='$spotid'";
        $ar = DB::query(1,$sql)->execute()->as_array();
        $price = $ar[0]['price'] ? $ar[0]['price'] : 0;
        $model = ORM::factory('spot',$spotid);
        $model->price = $price;
        $model->update();


    }

}