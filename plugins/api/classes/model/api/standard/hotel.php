<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Api_Standard_Hotel
{
    private static $_typeid = 2;

    public static function search($params)
    {
        $status = true;
        $destPy = $params['destpy'];
        $rankId = intval($params['rankid']);
        $priceId = intval($params['priceid']);
        $sortType = intval($params['sorttype']);
        $attrId = $params['attrid'];
        $page = $params['page'];
        $keyword = St_String::filter_mark(Common::remove_xss($params['keyword']));
        $page = $page ? $page : 1;
        $pagesize = $params['pagesize'] ;
        $pagesize = $pagesize ? $pagesize : 12;
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
            $where .= self::get_attr_where($attrId);
        }

        $offset = (intval($page) - 1) * $pagesize;

        //经度,纬度附近酒店
        $add_field = '';
        $add_where = '';
        if($params['lat'] && $params['lng'])
        {
            $lat = round($params['lat'],3);
            $lng = round($params['lng'],3);
            $distance = $params['distance'];

            $add_field =" , ROUND(6378.138*2*ASIN(SQRT(POW(SIN((".$lat."*PI()/180-FORMAT(a.lat,3)*PI()/180)/2),2)+COS(".$lat."*PI()/180)*COS(FORMAT(a.lat,3)*PI()/180)*POW(SIN((".$lng."*PI()/180-FORMAT(a.lng,3)*PI()/180)/2),2)))*1000) AS distance";

            $add_where = " and a.lat>0 and a.lng>0 and ROUND(6378.138*2*ASIN(SQRT(POW(SIN((".$lat."*PI()/180-FORMAT(a.lat,3)*PI()/180)/2),2)+COS(".$lat."*PI()/180)*COS(FORMAT(a.lat,3)*PI()/180)*POW(SIN((".$lng."*PI()/180-FORMAT(a.lng,3)*PI()/180)/2),2)))*1000)<$distance ";

            $sql = "SELECT a.* {$add_field} FROM `sline_hotel` a ";
            $sql .= $where;
            $sql.=" {$extWhere} ";
            $sql.= $add_where;
            $sql .= "ORDER BY distance ASC,a.modtime DESC,a.addtime DESC ";
        }

        //如果选择了目的地
        else if(!empty($destId))
        {
            $sql = "SELECT a.* {$add_field} FROM `sline_hotel` a ";
            $sql .= "LEFT JOIN `sline_kindorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=2 AND a.webid=b.webid AND b.classid=$destId)";
            $sql.=" {$extWhere} ";
            $sql .= $where;
            $sql .= "ORDER BY IFNULL(b.displayorder,9999) ASC,{$orderBy}a.modtime DESC,a.addtime DESC ";
        }
        else
        {
            $sql = "SELECT a.* {$add_field} FROM `sline_hotel` a ";
            $sql .= "LEFT JOIN `sline_allorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=2 AND a.webid=b.webid)";
            $sql.=" {$extWhere} ";
            $sql .= $where;
            $sql .= "ORDER BY IFNULL(b.displayorder,9999) ASC,{$orderBy}a.modtime DESC,a.addtime DESC ";
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

            $v['price'] = Model_Hotel::get_minprice($v['id'],$v);//最低价
            $v['attrlist'] = Model_Hotel_Attr::get_attr_list($v['attrid']);
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], 2); //评论次数
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], 2) + intval($v['bookcount']); //销售数量
            $v['litpic'] = Common::img($v['litpic']);
            $v['litpic'] = Model_Api_Standard_System::reorganized_resource_url($v['litpic']);
            $v['iconlist'] = Product::get_ico_list($v['iconlist']);
            $v['sellprice'] = Model_Hotel::get_sellprice($v['id']);//挂牌价
//            $v['url'] = Common::get_web_url($v['webid']) . "/hotels/show_{$v['aid']}.html";
            $v['score']  =St_Functions::get_satisfy(self::$_typeid,$v['id'],$v['satisfyscore']);

        }
        $out = array(
            'total' => $totalNum,
            'list' => $arr,
            'status'=>$status
        );
        return $out;
    }





    /*
 * 属性生成where条件,用于多条件属性搜索.
 * */
    public static function get_attr_where($attrid)
    {
        $str = '';
        $arr = Common::remove_arr_empty(explode('_', $attrid));
        foreach ($arr as $value)
        {
            $value = intval($value);
            if ($value != 0)
            {
                $str .= " and FIND_IN_SET($value,a.attrid) ";
            }
        }
        return $str;
    }


    /**
     * 通过入住时间和离店时间获取酒店id
     * @param $param
     * @return string
     */
    private static function get_hotel_id($param)
    {
        $where = '';
        if (empty($param['starttime']) && empty($param['endtime']))
        {
            return '';
        }

        if (!empty($param['starttime']) && !empty($param['endtime']) && $param['starttime']!=$param['endtime'])
        {

            $where = " inner join (select distinct hotelid from sline_hotel_room_price where day='{$param['starttime']}' or day='{$param['endtime']}' group by suitid having count(*)>1) c on a.id=c.hotelid";
        }
        else
        {
            //只有入住日期或离开日期
            $time = empty($param['starttime']) ? $param['endtime'] : $param['starttime'];
            $where = " inner join   (select distinct hotelid from sline_hotel_room_price where day='{$time}') c on a.id=c.hotelid";
        }

        return $where;
    }


    public static function detail($id)
    {
        if($id)
        {
            $info = DB::select()->from('hotel')->where('id','=',$id)->execute()->current();
            //seo
            $seo_info = Product::seo($info);

            $info['seo_info'] = $seo_info;
            //产品图片
            $piclist = Product::pic_list($info['piclist']);
            $p = array();
            foreach($piclist as &$pic)
            {
                $pi = Model_Api_Standard_System::reorganized_resource_url($pic[0]);
                array_push($p,$pi);
            }
            $info['pic_list'] = $p;
            //属性列表
            $info['attr_list'] = Model_Hotel::hotel_attr($info['attrid']);
            $info['price'] = Model_Hotel::get_minprice($info['id'],array('info'=>$info));
            //点评数
            $info['commentnum'] = Model_Comment::get_comment_num($info['id'], 2);
            //销售数量
            $info['sellnum'] = Model_Member_Order::get_sell_num($info['id'], 2) + intval($info['bookcount']);
            //产品编号
            $info['series'] = St_Product::product_series($info['id'], 2);
            //产品图标
            $info['icon_list'] = Product::get_ico_list($info['iconlist']);
            //满意度
            $info['score'] = St_Functions::get_satisfy(self::$_typeid, $info['id'], $info['satisfyscore']);
            $info['litpic'] = Model_Api_Standard_System::reorganized_resource_url($info['litpic']);
            $info['basehost'] = $GLOBALS['cfg_basehost'];
            $info['lat']=(float)$info['lat'];
            $info['lng']=(float)$info['lng'];
            //扩展字段信息
            $extend_info = ORM::factory('hotel_extend_field')
                ->where("productid=" . $info['id'])
                ->find()
                ->as_array();
            $info['extend_info'] = $extend_info;
            //套餐信息
            $info['suit_list'] = self::suit($info['id']);

            //详情内容
            $params = array(
                'typeid' => '2',
                'productinfo' => $info,
                'onlyrealfield' => 1,
                'pc' => 0

            );
            $info['introduce_list'] = self::get_detail_content($params);
            return $info;
        }
        else
        {
            return array();
        }

    }

    /**
     * @function 栏目信息
     * @return mixed
     */
    public static function channel()
    {
        $row = DB::select()->from('nav')->where('typeid','=',self::$_typeid)->and_where('issystem','=',1)->execute()->current();
        return $row;
    }

    /**
     * 获取酒店套餐
     * @param $params
     * @return Array
     */

    public static function suit($productid)
    {
        $pay_name = array(
            '1' => '全款支付',
            '2' => '定金支付',
            '3' => '二次确认'
        );
        $suit = ORM::factory('hotel_room')
            ->where("hotelid=:productid")
            ->order_by('displayorder', 'ASC')
            ->param(':productid', $productid)
            ->get_all();
        foreach ($suit as &$r)
        {
            $r['title'] = $r['roomname'];
            $r['price'] = Model_Hotel::get_minprice($productid, $r['id']);
            // $r['price'] = Currency_Tool::price($r['price']);

            $v['sellprice'] = Model_Hotel::get_sellprice($productid);//挂牌价
            $r['piclist'] = Product::pic_list($r['piclist']);
            foreach( $r['piclist'] as &$roompic)
            {
                $roompic = Model_Api_Standard_System::reorganized_resource_url($roompic[0]);
            }
            $time = DB::select('day')->from('hotel_room_price')->where("hotelid={$productid} and suitid={$r['id']} and number!=0 and day>=" . strtotime(date('Y-m-d')))->order_by('day', 'asc')->execute()->current();
            $r['startTime'] = !empty($time) ? $time['day'] : time();
            $r['endTime'] = strtotime('+1 day', $r['startTime']);
            $r['paytype_name'] = $pay_name[$r['paytype']];
        }
        return $suit;
    }

    /**
     * @function 获取线路详细行程内容
     * @param $params
     * @return array
     */
    private static function get_detail_content($params)
    {

        $default = array(
            'typeid' => '2',
            'productinfo' => 0,
            'onlyrealfield' => 1,
            'pc' => 0

        );
        $params = array_merge($default, $params);
        extract($params);
        $arr = DB::select()->from('hotel_content')
            ->where('webid','=',0)
            ->and_where('isopen','=',1)
            ->order_by('displayorder','ASC')
            ->execute()
            ->as_array();

        //扩展表数据
        $productid = $productinfo['id'];//产品id
        $ar = DB::select()->from('hotel_extend_field')->where('productid','=',$productid)->execute()->as_array();

        $list = array();
        foreach ($arr as $v)
        {
            if ($v['columnname'] == 'tupian' || $v['columnname'] == 'linedoc')
            {
                continue;
            }
            if ($v['isrealfield'] == 1)
            {
                $content = !empty($productinfo[$v['columnname']]) ? $productinfo[$v['columnname']] : $ar[0][$v['columnname']];
                $content = $content ? $content : '';
            }
            if (empty($content))
            {
                continue;
            }

            $a = array();
            $a['columnname'] = $v['columnname'];
            $a['chinesename'] = $v['chinesename'];
            if($v['columnname'] == 'jieshao' && $productinfo['isstyle'] == 1)
            {
                $content = $productinfo['jieshao'];
                if(empty($content))
                {
                    continue;
                }
                $a['is_array'] = 0;

            }
            //$a['xcx_content'] = Model_Api_Standard_Xcx::filter_content($content); //针对小程序去除样式
            $a['content'] = Model_Api_Standard_Xcx::filter_content($content);
            $list[] = $a;

        }
        return $list;
    }


}