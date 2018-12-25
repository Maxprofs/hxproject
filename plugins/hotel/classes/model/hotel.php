<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Hotel extends ORM
{
    private static $_typeid=2;
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
        $day = strtotime(date('Y-m-d'));
        $sql = "SELECT MIN(price) as price FROM sline_hotel_room_price WHERE `hotelid`='$hotelid' and price>0 and `day`>={$day} and `number`!=0";
        $ar = DB::query(1, $sql)->execute()->current();
        $price = $ar['price'] ? $ar['price'] : 0;
        //更新最低价
        DB::update('hotel')->set(array('price' => $price, 'price_date' => strtotime(date('Y-m-d'))))->where('id', '=', $hotelid)->execute();
    }

    /**
     * 酒店克隆
     * @param $id 克隆的产品ID
     * @param $num 克隆基数
     */
    public function clone_hotel($id, $num)
    {
        $arr = $this->where("id=$id")->find()->as_array();
        unset($arr['aid']);
        unset($arr['id']);
        for ($i = 1; $i <= $num; $i++)
        {
            //信息表
            $arr['addtime'] = $arr['modtime'] = time();
            $arr['aid'] = Common::getLastAid('sline_hotel', 0);
            list($insertId, $row) = DB::insert('hotel', array_keys($arr))->values(array_values($arr))->execute();
            //字段扩展表
            if ($row > 0)
            {
                $result = DB::select()->from('hotel_extend_field')->where("productid={$id}")->execute()->current();
                if (!empty($result))
                {
                    unset($result['id']);
                    $result['productid'] = $insertId;
                    DB::insert('hotel_extend_field', array_keys($result))->values(array_values($result))->execute();
                }
            }
        }
        return $insertId;
    }

    public static function detail($aid)
    {
        $sql = "SELECT * FROM `sline_hotel` WHERE aid={$aid} and webid={$GLOBALS['sys_webid']}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr[0];
    }

    //取得酒店的挂牌价格
    public static function get_sellprice($hotelid)
    {
        $sql = "SELECT MIN(price) AS minprice,sellprice FROM `sline_hotel_room` WHERE hotelid='{$hotelid}'";
        $row = DB::query(1, $sql)->execute()->as_array();
        $row[0]['sellprice'] = Currency_Tool::price($row[0]['sellprice']);
        return $row[0]['sellprice'];
    }

    /**
     * @param $hotelid
     * @param string/array $info, 当为字符串和数字时表示房间id,为数组时表示酒店信息
     * @return int|number
     */
    public static function get_minprice($hotelid, $params = array())
    {
        $time = strtotime(date('Y-m-d'));
        $update_minprice = false;
        if (!is_array($params))
        {
            $params = array('suitid' => $params);
        }
        if (!isset($params['suitid']))
        {
            if (!isset($params['info']))
            {
                $params['info'] = DB::select()->from('hotel')->where('id', '=', $hotelid)->execute()->current();
            }
            if ($params['info']['price_date'] == $time)
            {
                return Currency_Tool::price($params['info']['price']);
            }
            //更新最低价
            $update_minprice = true;
        }
        $where = isset($params['suitid']) ? " AND suitid=" . $params['suitid'] : '';
        $sql = 'SELECT MIN(price) AS price FROM `sline_hotel_room_price` WHERE `hotelid`=' . $hotelid . ' AND `price`!=0 AND  `day`>=' . $time . ' and (`number`>0 or `number`=-1)' . $where;
        $row = DB::query(1, $sql)->execute()->current();
        if (!empty($row))
        {
            $price = $row['price'] ? $row['price'] : 0;
        }
        else
        {
            $price = 0;
        }
        if ($update_minprice)
        {
            DB::update('hotel')->set(array('price' => $price, 'price_date' => $time))->where('id', '=', $hotelid)->execute();
        }
        return Currency_Tool::price($price);
    }

    /**
     * 酒店属性
     * @param $attrid
     * @return array
     */
    public static function hotel_attr($attrid)
    {
        if (empty($attrid))
        {
            return;
        }
        $attrid = trim($attrid, ',');
        $arr = DB::select('attrname')->from('hotel_attr')->where("id in({$attrid}) and pid!=0")->execute()->as_array();
        return $arr;
    }


    /*
     * 获取目的地优化标题
     * */
    public static function search_seo($destpy)
    {
        if (!empty($destpy) && $destpy != 'all')
        {
            $destId = DB::select('id')->from('destinations')->where('pinyin','=',$destpy)->and_where('isopen','=',1)->execute()->get('id');
            $info = DB::select()->from('destinations')->where('id','=',$destId)->execute()->current();
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $info['kindname'];
        }
        else
        {
            $info = Model_Nav::get_channel_info(2);
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $info['m_title'];
        }

        return array('seotitle' => $seotitle);
    }

    /**
     * 手机端获取目的地优化标题
     */
    public static function search_seo_mobile($destpy, $type)
    {
        if (!empty($destpy) && $destpy != 'all')
        {
            $destinfo = DB::select('id','kindname')->from('destinations')->where('pinyin', '=', $destpy)->and_where('isopen', '=', 1)->execute()->current();
            //$info = ORM::factory('destinations', $destId)->as_array();
            $info = DB::select('seotitle')->from('hotel_kindlist')->where('kindid', '=', $destinfo['id'])->execute()->current();
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $destinfo['kindname'];
        }
        else
        {
            $info = Model_Nav::get_channel_info_mobile($type);
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $info['m_title'];
        }
        return array('seotitle' => $seotitle);
    }

    /*
     *获取套餐日期范围内价格总和.
     * */
    public static function suit_range_price($suitid, $sdate, $edate, $dingnum)
    {
        $startdate = $sdate;
        $sdate = strtotime($sdate);
        $flag = is_null($edate);
        $edate = !$flag ? strtotime($edate) : strtotime("$startdate +1 day");;


        $sql = "SELECT price FROM`sline_hotel_room_price` ";
        $sql .= "WHERE suitid='$suitid' AND day>='$sdate' AND day<'$edate'";
        $ar = DB::query(1, $sql)->execute()->as_array();
        $price = 0;
        foreach ($ar as $row)
        {
            $row['price'] = Currency_Tool::price($row['price']);
            $price += $row['price'];
        }
        return $price;
    }


    /**
     * @param $suitid
     * @return mixed
     * 获取套餐最小可预订日期
     */

    public static function suit_mindate_book($suitid)
    {
        $time = strtotime(date('Y-m-d'));
        $suitid = intval($suitid);
        $sql = "SELECT `day` FROM `sline_hotel_room_price` ";
        $sql .= "WHERE suitid='$suitid' AND day>=$time AND price>0 AND number!=0 ORDER BY day asc LIMIT 1";
        $ar = DB::query(1, $sql)->execute()->as_array();
        return $ar[0]['day'];
    }


    /**
     * @param $suitid
     * @param $sdate
     * @param $edate
     * @param $dingnum
     * @return bool
     *
     */
    public static function check_suit_storage($suitid, $sdate, $edate, $dingnum)
    {
        $sdate = strtotime($sdate);
        $edate = strtotime($edate);
        $day_count = St_Time::time_span($sdate, $edate);
        $day_count = $day_count['day'];

        $suitid = intval($suitid);
        $sql = "SELECT number FROM`sline_hotel_room_price` ";
        $sql .= "WHERE suitid='$suitid' AND day>=$sdate AND day<$edate";
        $ar = DB::query(1, $sql)->execute()->as_array();

        $flag = 1;
        //选择的天数与报价天数不相同，选择时间段内存在无效报价日期
        if(count($ar)!=$day_count)
        {
            $flag = 0;
            return $flag;
        }
        foreach ($ar as $row)
        {
            if ($row['number'] != '-1' && $row['number'] < $dingnum)
            {
                $flag = 0;
                break;
            }
        }
        return $flag;
    }


    //------------------------以下是搜索页新增加使用函数-----------------

    /**
     * 参数解析
     * @param $params
     */
    public static function search_result($params, $keyword, $currentpage, $pagesize = '10')
    {
        $destPy = $params['destpy'];
        $rankId = intval($params['rankid']);
        $priceId = intval($params['priceid']);
        $sortType = intval($params['sorttype']);
        $attrId = $params['attrid'];
        $page = $currentpage;
        $page = $page ? $page : 1;
        //新增离店时间、入住时间筛选
        $extWhere = self::get_hotel_id($params);
        $where = " WHERE a.ishidden=0 ";
        //按目的地搜索
        $value_arr = array();
        if ($destPy && $destPy != 'all')
        {
            $destId = DB::select('id')->from('destinations')->where('pinyin','=',$destPy)->execute()->get('id');
            $where .= " AND FIND_IN_SET('$destId',a.kindlist) ";
        }
        //星级
        if ($rankId)
        {
            $where .= " AND a.hotelrankid='$rankId'";
        }
        //价格区间
        if ($priceId)
        {
            $priceArr = DB::select()->from('hotel_pricelist')->where('id','=',$priceId)->execute()->current();
            $where .= " AND a.price BETWEEN {$priceArr['min']} AND {$priceArr['max']} ";
        }
        //排序
        $orderBy = "";
        if (!empty($sortType))
        {
            if ($sortType == 1)//价格升序
            {
                $orderBy = "  a.price ASC,";
            }
            else if ($sortType == 2) //价格降序
            {
                $orderBy = "  a.price DESC,";
            }
            else if ($sortType == 3) //销量降序
            {
                $orderBy = " a.bookcount DESC,";
            }
            else if ($sortType == 4)//推荐
            {
                $orderBy = " a.recommendnum DESC,";
            }
        }

        //关键词
        if (!empty($keyword))
        {
            $where .= " AND a.title like :keyword ";
            $value_arr[':keyword'] = '%'.$keyword.'%';
        }
        //按属性
        if (!empty($attrId))
        {
            $where .= Product::get_attr_where($attrId);
        }

        $offset = (intval($page) - 1) * $pagesize;

        //如果选择了目的地
        if (!empty($destId))
        {
            $sql = "SELECT a.* FROM `sline_hotel` a ";
            $sql .= "LEFT JOIN `sline_kindorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=2 AND a.webid=b.webid AND b.classid=$destId)";
            $sql.=" {$extWhere} ";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy}IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
            //$sql.= "LIMIT {$offset},{$pagesize}";

        }
        else
        {
            $sql = "SELECT a.* FROM `sline_hotel` a ";
            $sql .= "LEFT JOIN `sline_allorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=2 AND a.webid=b.webid)";
            $sql.=" {$extWhere} ";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy}IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
            //$sql.= "LIMIT {$offset},{$pagesize}";
        }
        //计算总数
        $totalSql = "SELECT count(*) as dd " . strchr($sql, " FROM");
        $totalSql = str_replace(strchr($totalSql, "ORDER BY"), '', $totalSql);//去掉order by
        $totalN = DB::query(1, $totalSql)->parameters($value_arr)->execute()->as_array();
        $totalNum = $totalN[0]['dd'] ? $totalN[0]['dd'] : 0;

        $sql .= "LIMIT {$offset},{$pagesize}";
        $arr = DB::query(1, $sql)->parameters($value_arr)->execute()->as_array();

        foreach ($arr as &$v)
        {
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], 2); //评论次数
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], 2) + intval($v['bookcount']); //销售数量
            $v['sellprice'] = Model_Hotel::get_sellprice($v['id']);//挂牌价
            $v['price'] = Model_Hotel::get_minprice($v['id'],$v);//最低价
            $v['attrlist'] = Model_Hotel_Attr::get_attr_list($v['attrid']);//属性列表.
            $v['url'] = Common::get_web_url($v['webid']) . "/hotels/show_{$v['aid']}.html";
            $v['iconlist'] = Product::get_ico_list($v['iconlist']);
            $v['satisfyscore']  =St_Functions::get_satisfy(self::$_typeid,$v['id'],$v['satisfyscore'],array('suffix'=>''));
            //$v['litpic'] = Common::img($v['litpic']);
            if(Model_Supplier::display_is_open()&&$v['supplierlist'])
            {
                $v['suppliername'] = Arr::get(Model_Supplier::get_supplier_info($v['supplierlist'],array('suppliername')),'suppliername');
            }
        }
        $out = array(
            'total' => $totalNum,
            'list' => $arr
        );
        return $out;
    }



    public static function get_month_price($year, $month, $suitid, $startdate)
    {

        $start = !empty($startdate) ? strtotime($startdate) : strtotime("$year-$month-1");
        $end = strtotime("$year-$month-31");
        $arr = DB::select()->from('hotel_room_price')
            ->where("suitid=$suitid")
            ->and_where('day', '>=', $start)
            ->and_where('day', '<=', $end)
            ->and_where('number', '!=', 0)
            ->execute()->as_array();
        $price = array();
        foreach ($arr as $row)
        {
            if ($row)
            {
                $day = $row['day'];
                $price[$day]['date'] = Common::mydate('Y-m-d', $row['day']);
                $price[$day]['basicprice'] = isset($row['adultbasicprice']) ? $row['adultbasicprice'] : $row['basicprice'];
                $price[$day]['basicprice'] = Currency_Tool::price($price[$day]['basicprice']);

                $price[$day]['profit'] = isset($row['adultprofit']) ? $row['adultprofit'] : $row['profit'];
                $price[$day]['profit'] = Currency_Tool::price($price[$day]['profit']);

                $price[$day]['price'] = isset($row['adultprice']) ? $row['adultprice'] : $row['price'];
                $price[$day]['price'] = Currency_Tool::price($price[$day]['price']);


                $price[$day]['child_basicprice'] = isset($row['childbasicprice']) ? $row['childbasicprice'] : 0;
                $price[$day]['child_basicprice'] = Currency_Tool::price($price[$day]['child_basicprice']);

                $price[$day]['child_profit'] = isset($row['childprofit']) ? $row['childprofit'] : 0;
                $price[$day]['child_profit'] = Currency_Tool::price($price[$day]['child_profit']);

                $price[$day]['child_price'] = isset($row['childprice']) ? $row['childprice'] : 0;
                $price[$day]['child_price'] = Currency_Tool::price($price[$day]['child_price']);


                $price[$day]['old_basicprice'] = isset($row['oldbasicprice']) ? $row['oldbasicprice'] : 0;
                $price[$day]['old_basicprice'] = Currency_Tool::price($price[$day]['old_basicprice']);

                $price[$day]['old_profit'] = isset($row['oldprofit']) ? $row['oldprofit'] : 0;
                $price[$day]['old_profit'] = Currency_Tool::price($price[$day]['old_profit']);

                $price[$day]['old_price'] = isset($row['oldprice']) ? $row['oldprice'] : 0;
                $price[$day]['old_profit'] = Currency_Tool::price($price[$day]['old_profit']);

                $price[$day]['roombalance'] = Currency_Tool::price($row['roombalance']);

                $price[$day]['suitid'] = $suitid;
                $price[$day]['number'] = $row['number'];//库存
                $price[$day]['description'] = $row['description'];//描述
            }
        }
        return $price;


    }



    //手机端搜索
    public static function search_result_mobile($params, $keyword, $starttime, $endtime, $pagesize = '10')
    {
        $destId = $destPy = $rankId = $priceId = $sortType = $k = $attrId = 0;
        $page = 1;
        $params = explode('-', str_replace('/', '-', $params));
        $count = count($params);
        switch ($count)
        {
            //目的地
            case 1:
                list($destpy) = $params;
                break;
            //关键字、属性
            case 7:
                list($destPy, $rankId, $priceId, $sortType, $k, $attrId, $page) = $params;
                break;
        }
        $destPy = Common::remove_xss($destPy);
        $rankId = Common::remove_xss($rankId);
        $sortType = Common::remove_xss($sortType);
        $keyword = Common::remove_xss($keyword);
        $starttime = Common::remove_xss($starttime);
        $endtime = Common::remove_xss($endtime);
        $attrId = Common::remove_xss($attrId);
        $page = Common::remove_xss($page);

        //新增离店时间、入住时间筛选
        $extWhere = self::get_hotel_id(array('starttime'=>$starttime,'endtime'=>$endtime));
        $where = ' WHERE a.ishidden=0 ';
        //按目的地搜索
        if ($destPy && $destPy != 'all')
        {
            $destId = ORM::factory('destinations')->where("pinyin='$destPy'")->find()->get('id');
            $where .= " AND FIND_IN_SET('$destId',a.kindlist) ";
        }
        //星级
        if ($rankId)
        {
            $where .= " AND a.hotelrankid='$rankId'";
        }
        //价格区间
        if ($priceId)
        {
            $priceArr = ORM::factory('hotel_pricelist', $priceId)->as_array();
            $where .= " AND a.price BETWEEN {$priceArr['min']} AND {$priceArr['max']} ";
        }
        //排序
        $orderBy = "";
        if (!empty($sortType))
        {
            if ($sortType == 0)//默认排序
            {
                $orderBy = " IFNULL(b.displayorder,9999) ASC,";
            }
            else if ($sortType == 1)//特价排序
            {
                $orderBy = "  a.price asc,";
            }
            else if ($sortType == 2) //价格
            {
                $orderBy = "  a.price desc,";
            }
            else if ($sortType == 3) //销量
            {
                $orderBy = " a.bookcount desc,";
            }
            else if ($sortType == 4)//人气
            {
                $orderBy = " a.recommendnum desc,";
            }
            else if ($sortType == 5) //满意度
            {
                $orderBy = " a.shownum desc,";
            }
        }

        //关键词
        if (!empty($keyword))
        {
            $where .= " AND a.title like '%$keyword%' ";
        }
        //按属性
        if (!empty($attrId))
        {
            $where .= Product::get_attr_where($attrId);
        }

        $offset = (intval($page) - 1) * $pagesize;

        //如果选择了目的地
        if (!empty($destId))
        {
            $sql = "SELECT a.* FROM `sline_hotel` a ";
            $sql .= "LEFT JOIN `sline_kindorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=2 AND b.classid={$destId})";
            $sql .= " {$extWhere} ";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy}IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
            $sql .= "LIMIT {$offset},{$pagesize}";

        }
        else
        {
            $sql = "SELECT a.* FROM `sline_hotel` a ";
            $sql .= "LEFT JOIN `sline_allorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=2)";
            $sql .= " {$extWhere} ";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy}IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
            $sql .= "LIMIT {$offset},{$pagesize}";


        }
        $data = DB::query(1, $sql)->execute()->as_array();

        foreach ($data as &$v)
        {
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], 2); //评论次数
            $v['satisfyscore']  =St_Functions::get_satisfy(self::$_typeid,$v['id'],$v['satisfyscore'],array('suffix'=>''));
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], 2) + intval($v['bookcount']); //销售数量
            $v['sellprice'] = Model_Hotel::get_sellprice($v['id']);//挂牌价
            $v['price'] = Model_Hotel::get_minprice($v['id'], array('info' => $v));//最低价
            $v['attrlist'] = Model_Hotel_Attr::get_attr_list($v['attrid']);//属性列表.
            $v['url'] = Common::get_web_url($v['webid']) . "/hotels/show_{$v['aid']}.html";
            $v['litpic'] = Common::img($v['litpic'],220,150);
            $v['hotelrankid'] = ORM::factory('hotel_rank', $v['hotelrankid'])->get('hotelrank');
        }
        return Product::list_search_format($data, $page);
    }

    /**
     * 通过入住时间和离店时间获取酒店id
     * @param $param
     * @return string
     */
    private static function get_hotel_id($param)
    {
        /*$where = '';
       if (!empty($param['starttime']) || !empty($param['endtime']))
       {
           if (!empty($param['starttime']) && !empty($param['endtime']))
           {
               //计算相差天数
               $days = ($param['endtime'] - $param['starttime']) / 86400;
               $result = DB::select()->from('hotel_room_price')->where("`day` >={$param['starttime']} and price >0 ")->order_by('suitid', 'asc')->order_by('hotelid', 'asc')->order_by('day', 'asc')->execute()->as_array();
               $data = array();
               $idArr = array();
               foreach ($result as $v)
               {
                   if (isset($data[$v['suitid']]))
                   {
                       array_push($data[$v['suitid']], $v);
                   }
                   else
                   {
                       $data[$v['suitid']][] = $v;
                   }
               }
               //筛选符合条件的数据
               foreach ($data as $k => $v)
               {
                   if ($v[0]['day'] == $param['starttime'] && $v[$days]['day'] == $param['endtime'])
                   {
                       array_push($idArr, $v[0]['hotelid']);
                   }
               }
           }
           else
           {
               //只有入住日期或离开日期
               $time = empty($param['starttime']) ? $param['endtime'] : $param['starttime'];
               $ids = DB::select('hotelid')->from('hotel_room_price')->where("`day` ={$time} and price >0 ")->execute()->as_array();
               $idArr = array();
               if (!empty($ids))
               {
                   //$idArr = array_column($idArr, 'hotelid');
                   foreach ($ids as $id)
                   {
                       if ($id['hotelid'])
                       {
                           array_push($idArr, $id['hotelid']);
                       }
                   }

               }
           }
           //合并where
           if (!empty($idArr))
           {
               $where = ' AND a.id in(' . implode(',', $idArr) . ') ';
           }
           else
           {
               $where = ' AND false ';
           }
       }
       return $where;*/
        $where = '';
        if (empty($param['starttime']) && empty($param['endtime']))
        {
            return '';
        }

        if (!empty($param['starttime']) && !empty($param['endtime']) && $param['starttime']!=$param['endtime'])
        {


            /*$days = ($param['endtime'] - $param['starttime']) / 86400;
            $result = DB::select()->from('hotel_room_price')->where("`day` >={$param['starttime']} and price >0 ")->order_by('suitid', 'asc')->order_by('hotelid', 'asc')->order_by('day', 'asc')->execute()->as_array();
            $data = array();
            $idArr = array();
            foreach ($result as $v)
            {
                if (isset($data[$v['suitid']]))
                {
                    array_push($data[$v['suitid']], $v);
                }
                else
                {
                    $data[$v['suitid']][] = $v;
                }
            }
            //筛选符合条件的数据
            foreach ($data as $k => $v)
            {
                if ($v[0]['day'] == $param['starttime'] && $v[$days]['day'] == $param['endtime'])
                {
                    array_push($idArr, $v[0]['hotelid']);
                }
            }*/
            //todo 这里要编写入住时间与离店时间是否有库存作具体判断,先就入住日期判断


            $where = " inner join (select distinct hotelid from sline_hotel_room_price where day='{$param['starttime']}') c on a.id=c.hotelid";


        }
        else
        {
            //只有入住日期或离开日期
            $time = empty($param['starttime']) ? $param['endtime'] : $param['starttime'];
            $where = " inner join   (select distinct hotelid from sline_hotel_room_price where day='{$time}') c on a.id=c.hotelid";
        }



        return $where;
    }

    /*
    * 生成searh页地址
    * */
    public static function get_search_url($v, $paramname, $p, $currentpage = 1)
    {

        $url = $GLOBALS['cfg_basehost'] . '/hotels/';
        switch ($paramname)
        {
            case "destpy":
                $url .= $v . '-' . $p['rankid'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .= $p['displaytype'] . '-' . $p['attrid'] . '-' . $currentpage;
                break;
            case "rankid":
                $url .= $p['destpy'] . '-' . $v . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .= $p['displaytype'] . '-' . $p['attrid'] . '-' . $currentpage;
                break;
            case "priceid":
                $url .= $p['destpy'] . '-' . $p['rankid'] . '-' . $v . '-' . $p['sorttype'] . '-';
                $url .= $p['displaytype'] . '-' . $p['attrid'] . '-' . $currentpage;
                break;
            case "sorttype":
                $url .= $p['destpy'] . '-' . $p['rankid'] . '-' . $p['priceid'] . '-' . $v . '-';
                $url .= $p['displaytype'] . '-' . $p['attrid'] . '-' . $currentpage;
                break;
            case "displaytype":
                $url .= $p['destpy'] . '-' . $p['rankid'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .= $v . '-' . $p['attrid'] . '-' . $currentpage;
                break;

            case "attrid":

                $orignalArr = Product::get_attr_parent($p['attrid'], 2);
                $nowArr = Product::get_attr_parent($v, 2);
                if (!empty($nowArr))
                {
                    $attrArr = $nowArr + $orignalArr;
                    sort($attrArr);
                    $attr_list = join('_', $attrArr);
                }
                else
                {
                    $attr_list = 0;
                }
                $url .= $p['destpy'] . '-' . $p['rankid'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .= $p['displaytype'] . '-' . $attr_list . '-' . $currentpage;
                break;
        }
        //拆分query_string
        $urlArr = self::convertUrlQuery($_SERVER['QUERY_STRING']);
        if (in_array($paramname, array('starttime', 'endtime')))
        {
            $url .= $p['destpy'] . '-' . $p['rankid'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
            $url .= $p['displaytype'] . '-' . $p['attrid'] . '-' . $currentpage;
            unset($urlArr[$paramname]);
        }
        if (!empty($urlArr))
        {
            $url .= '?' . http_build_query($urlArr);
            $url = rtrim($url, '?');
        }
        return $url;


    }

    public static function convertUrlQuery($query)
    {
        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param)
        {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }

    /**
     * @param $p
     * @return array
     * @desc 已选择项处理
     */
    public static function get_selected_item($p)
    {
        $p['displaytype'] = 0;
        $out = array();
        //入住时间
        if (!empty($p['starttime']))
        {
            $temp['itemname'] = '入住时间&nbsp;:&nbsp;' . $_GET['starttime'];
            $temp['url'] = self::get_search_url('', 'starttime', $p);
            $out[] = $temp;
        }
        //离开时间
        if (!empty($p['endtime']))
        {
            $temp['itemname'] = '离开时间&nbsp;:&nbsp;' . $_GET['endtime'];
            $temp['url'] = self::get_search_url('', 'endtime', $p);
            $out[] = $temp;
        }
        //目的地
        if ($p['destpy'] != 'all')
        {
            $temp = array();
            $url = self::get_search_url('all', 'destpy', $p);
            $temp['url'] = $url;
            $dest = DB::select('kindname')->from('destinations')->where('pinyin','=', $p['destpy'])->execute()->current();
            $temp['itemname'] = $dest['kindname'];
            $out[] = $temp;
        }
        //星级
        if ($p['rankid'] != 0)
        {
            $temp = array();
            $url = self::get_search_url('0', 'rankid', $p);
            $temp['url'] = $url;
            $temp['itemname'] = DB::select('hotelrank')->from('hotel_rank')->where('id','=',$p['rankid'])->execute()->get('hotelrank');
            $out[] = $temp;

        }
        //价格
        if ($p['priceid'] != 0)
        {
            $temp = array();
            $url = self::get_search_url('0', 'priceid', $p);
            $temp['url'] = $url;
            $ar = DB::select()->from('hotel_pricelist')->where('id','=', $p['priceid'])->execute()->current();
            $lowerprice = $ar['min'];
            $highprice = $ar['max'];
            $temp['itemname'] = self::get_price_list_title($lowerprice, $highprice);
            $out[] = $temp;

        }

        //属性
        if ($p['attrid'] != 0)
        {
            $attArr = $orgArr = explode('_', $p['attrid']);
            foreach ($attArr as $ar)
            {

                $orgArr = $attArr;
                $temp = array();
                $temp['itemname'] = DB::select('attrname')->from('hotel_attr')->where('id','=',$ar)->execute()->get('attrname');
                unset($orgArr[array_search($ar, $orgArr)]);
                if (!empty($orgArr))
                {
                    $attrid = implode('_', $orgArr);
                }
                else
                {
                    $attrid = 0;
                }

                $url = $GLOBALS['cfg_basehost'] . '/hotels/';
                $url .= $p['destpy'] . '-' . $p['rankid'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .= $p['displaytype'] . '-' . $attrid . '-1';

                $temp['url'] = $url;
                $out[] = $temp;
            }

        }
        return $out;

    }

    /**
     * @param $min
     * @param $max
     * @return string
     * @desc 根据价格大小生成价格优化标题.
     */
    public static function get_price_list_title($min, $max)
    {

        if ($min != '' && $max != '')
        {
            $title = '&yen;' . $min . '元-' . '&yen;' . $max . '元';
        }
        else if ($min == '')
        {
            $title = '&yen;' . $max . '元以下';
        }
        else if ($max == '')
        {
            $title = '&yen;' . $min . '元以上';
        }
        return $title;

    }

    /**
     * @param $param
     * @return string
     * @desc 生成优化标题
     */
    public static function gen_seotitle($param)
    {

        $main_items=array();
        $normal_items = array();
        if(!empty($param['p']))
        {

            $p = intval($param['p']);
            if($p>1)
            {
                $main_items[]='第'.$p.'页';
            }
        }

        if (!empty($param['destpy'])&&$param['destpy']!='all')
        {
            $dest_info = Model_Destinations::search_seo($param['destpy'], 2);
            $normal_items[] = $dest_info['seotitle'];
        }
        if(!empty($param['keyword']))
        {
            $normal_items[] ='关于'.$param['keyword'].'的搜索结果';
        }
        if (!empty($param['rankid']))
        {
            $normal_items[] = DB::select('hotelrank')->from('hotel_rank')->where('id','=',$param['rankid'])->execute()->get('hotelrank');
        }

        if (!empty($param['priceid']))
        {
            $priceArr = DB::select()->from('hotel_pricelist')->where('id','=',$param['priceid'])->execute()->current();
            $price = self::get_price_list_title($priceArr['min'], $priceArr['max']);
            $normal_items[] = "价格区间$price";
        }

        if (!empty($param['attrid']))
        {
            $normal_items[] = Model_Hotel_Attr::get_attrname_list($param['attrid'], '|');
        }

        $normal_items_str = implode('|',$normal_items);
        if(!empty($normal_items_str))
        {
            $main_items[]=$normal_items_str;
        }


       /* if(!empty($param['channel_name']))
        {
            $main_items[]=$param['channel_name'];
        }*/
        $main_items[] = $GLOBALS['cfg_webname'];

        $main_items_str = implode('-',$main_items);
        return $main_items_str;


    }

    //获取当前选择的线路目的地优化信息
    public static function get_dest_info($destid)
    {
        $file = SLINEDATA . "/autotitle.cache.inc.php"; //载入智能title配置
        if (file_exists($file))
        {
            require_once($file);
        }
        $arr = array();

        if ($destid)
        {

            $sql = "SELECT a.kindname,b.seotitle,b.jieshao,b.keyword,b.tagword,b.description,a.pinyin FROM `sline_destinations` as a left join `sline_hotel_kindlist` AS b ON a.id=b.kindid WHERE a.id = $destid ";
        }
        $row = DB::query(1, $sql)->execute()->current();

        $cfg_hotel_title = str_replace('XXX', $row['kindname'], $cfg_hotel_title);
        $cfg_hotel_desc = str_replace('XXX', $row['kindname'], $cfg_hotel_desc);
        if (empty($row['seotitle']))
        {

            $arr['seotitle'] = empty($cfg_hotel_title) ? $row['kindname'] : $cfg_hotel_title;
        }
        else
        {
            $arr['seotitle'] = $row['seotitle'];

        }
        if (empty($row['description']))
        {
            $arr['description'] = empty($cfg_hotel_desc) ? $row['description'] : $cfg_hotel_desc;
        }
        else
        {
            $arr['description'] = $row['description'];
        }
        $arr['typename'] = $row['kindname'];
        $arr['dest_jieshao'] = $row['jieshao'];
        $arr['dest_name'] = $row['kindname'];
        $arr['kindid'] = $destid;
        $arr['dest_id'] = $destid;
        $arr['dest_pinyin'] = $row['pinyin'];
        $arr['tagword'] = $row['tagword'];
        $arr['keyword'] = !empty($row['keyword']) ? "<meta name=\"keywords\" content=\"" . $row['keyword'] . "\"/>" : "";
        $arr['description'] = !empty($arr['description']) ? "<meta name=\"description\" content=\"" . $arr['description'] . "\"/>" : "";
        $arr['pinyin'] = $row['pinyin'];
        return $arr;
    }
    /**
     * @param $productid 产品ID
     * @param $dingnum 预订数量
     * @param string $suitid 套餐ID
     * @param string $usedate 使用日期，格式为2016-01-01
     * @param string $enddate 结束日期，格式为2016-01-01
     * @param array $extraparam 附加参数,
     * @return bool
     */
    public static function check_storage($productid,$dingnum,$suitid='',$usedate='',$enddate='',$extraparam='')
    {
        if(empty($suitid) || empty($usedate))
            return false;
        $suitid = intval($suitid);
        $starttime = strtotime($usedate);
        $endtime = empty($enddate)? $starttime+24*3600:strtotime($enddate);
        $day_count = St_Time::time_span($starttime, $endtime);
        $day_count = $day_count['day'];

        $sql = "SELECT number FROM`sline_hotel_room_price` ";
        $sql .= "WHERE suitid='$suitid' AND day>='$starttime' AND day<'$endtime'";
        $ar = DB::query(1, $sql)->execute()->as_array();
        $flag = empty($ar)?false:true;

        //选择的天数与报价天数不相同，选择时间段内存在无效报价日期
        if(count($ar)!=$day_count)
        {
            $flag = false;
            return $flag;
        }

        foreach ($ar as $row)
        {
            if ($row['number'] != '-1' && intval($row['number']) < intval($dingnum))
            {
                $flag = false;
                break;
            }
        }
        return $flag;
    }

    /**
     * @function 库存操作函数,当$number为正数是为加库存,当$number为负数时为减库存
     * @param $suitid
     * @param $dingnum
     * @param $order_arr
     * @return int|object
     */
    public static function storage($suitid,$dingnum,$order_arr)
    {

        $starttime = strtotime($order_arr['usedate']);
        $endtime = strtotime($order_arr['departdate']);
        $day_count = St_Time::time_span($starttime, $endtime);
        $day_count = $day_count['day'];
        $dingnum = intval($dingnum);
        $number_arr = DB::select('number')->from('hotel_room_price')
            ->where('day','>=',$starttime)
            ->and_where('day','<',$endtime)
            ->and_where('suitid','=',$suitid)
            ->execute()
            ->as_array();

        $flag = 1;

        //选择的天数与报价天数不相同，选择时间段内存在无效报价日期
        if(count($number_arr)!=$day_count)
        {
            $flag=0;
            return $flag;
        }

        foreach($number_arr as $row)
        {
            if($row['number']=='-1')
                continue;
            if($dingnum<0 && abs($row['number'])<$dingnum)
            {
                $flag=0;
                break;
            }
            else
            {
                $flag = 2;
            }
        }
        //如果库存都是无限，则返回true
        if($flag!=2)
            return $flag;


        $update_arr = array(
            'number' => DB::expr("number + $dingnum")
        );
        $query = DB::update('hotel_room_price')
            ->set($update_arr)
            ->where('day', '>=', $starttime)
            ->and_where('day', '<', $endtime)
            ->and_where('suitid', '=', $suitid)
            ->and_where('number', '<>', -1);
        return $query->execute();

    }
}