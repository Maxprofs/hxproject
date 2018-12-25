<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/6 0006
 * Time: 18:25
 */
class Model_Ship_Line extends ORM
{
    private static $typeid = 104;
    public static function update_suit($lineid,$shipid)
    {
        if(empty($lineid) || empty($shipid))
            return;
        $rooms = DB::select('id','title')->from('ship_room')->where('shipid','=',$shipid)->execute()->as_array();//ORM::factory('ship_room')->where('shipid','=',$shipid)->get_all();
        $roomid_result = DB::select('roomid')->from('ship_line_suit')->where('lineid','=',$lineid)->execute()->as_array();
        $room_ids = array();
        foreach($roomid_result as $room_info)
        {
            $room_ids[] = $room_info['roomid'];
        }
        foreach($rooms as $room)
        {
            /*$suit_model = ORM::factory('ship_line_suit')->where('lineid','=',$lineid)->and_where('roomid','=',$room['id'])->find();
            if(!$suit_model->loaded())
            {
                $suit_model->lineid=$lineid;
                $suit_model->shipid=$shipid;
                $suit_model->roomid=$room['id'];
                $suit_model->suitname = $room['title'];
                $suit_model->save();
            }*/


            if(!in_array($room['id'],$room_ids))
            {
                DB::insert('ship_line_suit', array('lineid', 'shipid', 'roomid', 'suitname'))->values(array($lineid, $shipid, $room['id'], $room['title']))->execute();
            }
        }
        return true;
    }

    /**
     * 获取或更新最低价格
     * @param $lineid
     * @param $params
     * @param $flag  0表示返回最低价，1表示返回最低价和相应的市场价的数组
     * @param $isupdate 是否强制更新线路最低价格
     * @return number
     */
    public static function get_minprice($lineid,$params,$flag=0,$isupdate=false)
    {
        $time = strtotime(date('Y-m-d'));
        $update_minprice = $isupdate;
        if (!is_array($params))
        {
            $params = array('suitid' => $params);
        }
        $params['suitid'] = $isupdate?null:$params['suitid'];
        if (empty($params['suitid']) && !$isupdate)
        {
            if (!isset($params['info']))
            {
                $params['info'] = DB::select()->from('ship_line')->where('id', '=', $lineid)->execute()->current();
            }
            if ($params['info']['price_date'] == $time)
            {
                switch($flag)
                {
                    case 0:
                        $result = Currency_Tool::price($params['info']['price']);
                        break;
                    case 1:
                        $result = array('price'=> Currency_Tool::price($params['info']['price']),'storeprice'=> Currency_Tool::price($params['info']['storeprice']));
                        break;
                    default:
                        $result = Currency_Tool::price($params['info']['price']);
                        break;
                }
                return $result;
            }
            //更新最低价
            $update_minprice = true;
        }
        //提前预定
        $before_info = DB::select('islinebefore', 'linebefore')->from('ship_line')->where('id', '=', $lineid)->execute()->current();
        if ($before_info['islinebefore'] ==1 && $before_info['linebefore'] > 0)
        {
            $time = strtotime("+{$before_info['linebefore']} days", $time);
        }

        $where = !empty($params['suitid']) ? " AND a.suitid=" . intval($params['suitid']) : '';
        $sql ='select a.price,a.suitid,c.roomid,x.peoplenum,a.price/x.peoplenum as avgprice,a.storeprice from sline_ship_line_suit_price a inner join sline_ship_schedule_date b on a.dateid=b.id and a.scheduleid=b.scheduleid
        inner join (select a.id,a.roomid,b.scheduleid from sline_ship_line_suit a inner join sline_ship_line b
        on a.lineid=b.id and a.shipid=b.shipid where a.lineid='.$lineid.') c  on a.suitid=c.id and a.scheduleid=c.scheduleid
        inner join sline_ship_room x on c.roomid=x.id
        where a.lineid='.$lineid.' and a.price>0 and b.starttime>='.$time.' '.$where.' order by avgprice asc limit 1';


        $row = DB::query(1, $sql)->execute()->current();
        $price=0;
        $storeprice=0;
        $roomid=0;
        if (!empty($row))
        {
            $price = $row['price'] ? $row['price'] : 0;
            $storeprice = $row['storeprice'];//?$row['storeprice']:$price;
            $roomid = $row['roomid'];
            $peoplenum = DB::select('peoplenum')->from('ship_room')->where('id','=',$roomid)->execute()->get('peoplenum');
            $peoplenum = empty($peoplenum)?1:$peoplenum;
            $price = floor($price/$peoplenum);
            $storeprice= floor($storeprice/$peoplenum);
        }





        if ($update_minprice)
        {
            DB::update('ship_line')->set(array('price' => $price, 'price_date' => $time,'storeprice'=>$storeprice))->where('id', '=', $lineid)->execute();
        }

        switch($flag)
        {
            case 0:
                $result = Currency_Tool::price($price);
                break;
            case 1:
                $result = array('price'=> Currency_Tool::price($price),'storeprice'=> Currency_Tool::price($storeprice));
                break;
            default:
                $result = Currency_Tool::price($price);
                break;
        }
        return $result;
    }

    /**
     * 参数解析
     * @param $params
     */
    public static function search_result($params, $keyword, $currentpage, $pagesize = '10')
    {
        $destPy = $params['destpy'];
        $dayId = intval($params['dayid']);
        $priceId = intval($params['priceid']);
        $sortType = intval($params['sorttype']);
        $startcityId = intval($params['startcityid']);
        $attrId = $params['attrid'];
        $shipid = intval($params['shipid']);
        $keyword = $keyword;
        $page = $currentpage;
        $page = $page ? $page : 1;


        $value_arr = array();
        $where = " WHERE a.ishidden=0 ";
        //按目的地搜索
        if ($destPy && $destPy != 'all')
        {
            $destId = DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id');
            $where .= " AND FIND_IN_SET('$destId',a.kindlist) ";
        }
        //天数
        if ($dayId)
        {

            if (self::is_last_day($dayId))
            {
                $where .= " AND a.lineday>='$dayId'";
            }
            else
            {
                $where .= " AND a.lineday='$dayId'";
            }

        }
        if($shipid)
        {
            $where .= " AND a.shipid='$shipid' ";
        }
        //价格区间
        if ($priceId)
        {

            $priceArr = DB::select()->from('ship_line_pricelist')->where('id', '=', $priceId)->execute()->current();
            $where .= " AND a.price BETWEEN {$priceArr['lowerprice']} AND {$priceArr['highprice']} ";
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
                $orderBy = " a.shownum DESC,";
            }
            /*  else if($sortType==5) //满意度
              {
                  $orderBy = " a.shownum desc,";
              }*/
        }

        //关键词
        if (!empty($startcityId))
        {
            $where .= " AND a.startcity=$startcityId ";
        }
        //按属性
        if (!empty($attrId))
        {
            $where .= Product::get_attr_where($attrId);
        }
        //按关键词
        if (!empty($keyword))
        {
            $value_arr[':keyword'] = '%' . $keyword . '%';
            $where .= " AND a.title like :keyword ";
        }

        $offset = (intval($page) - 1) * $pagesize;

        $orderBy = empty($orderBy) ? " IFNULL(b.displayorder,9999) ASC, " : $orderBy;

        //如果选择了目的地
        if (!empty($destId))
        {
            $sql = "SELECT a.* FROM `sline_ship_line` a ";
            $sql .= "LEFT JOIN `sline_kindorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=".self::$typeid." AND a.webid=b.webid AND b.classid=$destId)";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy} a.modtime DESC,a.addtime DESC ";
            //$sql.= "LIMIT {$offset},{$pagesize}";

        }
        else
        {
            $sql = "SELECT a.* FROM `sline_ship_line` a ";
            $sql .= "LEFT JOIN `sline_allorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=".self::$typeid." AND a.webid=b.webid)";
            $sql .= $where;
            //$sql.= "ORDER BY IFNULL(b.displayorder,9999) ASC,{$orderBy}a.modtime DESC,a.addtime DESC ";
            $sql .= "ORDER BY {$orderBy} a.modtime DESC,a.addtime DESC ";
            //$sql.= "LIMIT {$offset},{$pagesize}";


        }

        //计算总数
        $totalSql = "SELECT count(*) as dd " . strchr($sql, " FROM");
        $totalSql = str_replace(strchr($totalSql, "ORDER BY"), '', $totalSql);//去掉order by


        $totalN = DB::query(1, $totalSql)->parameters($value_arr)->execute()->as_array();
        $totalNum = $totalN[0]['dd'] ? $totalN[0]['dd'] : 0;

        //数据量大时的优化方法,数据量小时不推荐使用此方法
        //$idWhere = "SELECT id FROM `sline_line` ORDER BY id limit $offset, 1";
        //$sql = str_replace("WHERE","WHERE a.id>($idWhere) AND",$sql);
        //$sql.= "LIMIT {$pagesize}";

        $sql .= "LIMIT {$offset},{$pagesize}";

        $arr = DB::query(1, $sql)->parameters($value_arr)->execute()->as_array();
        foreach ($arr as &$v)
        {
            $price_info = Model_Ship_Line::get_minprice($v['id'], array('info'=>$v),1);
            $v['price'] = $price_info['price'];
            $v['storeprice'] = $price_info['storeprice'];
            $v['attrlist'] = Model_Ship_Line::line_attr($v['attrid']);
            $v['startcity_name'] = Model_Startplace::start_city($v['startcity']);
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], self::$typeid); //评论次数
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'],  self::$typeid) + intval($v['bookcount']); //销售数量
            $v['url'] = Common::get_web_url($v['webid']) . "/ship/show_{$v['aid']}.html";
            $v['litpic'] = Common::img($v['litpic']);
            $v['iconlist'] = Product::get_ico_list($v['iconlist']);
            $v['starttime'] = Model_Ship_Line::get_many_starttime($v['id'],4);
            $v['passed_destnames'] = Model_Ship_Line_Jieshao::get_passed_destlist($v['id']);
            $v['score'] = strpos($v['satisfyscore'], '%') === false ? $v['satisfyscore'] . '%' : $v['satisfyscore'];
        }
        $out = array(
            'total' => $totalNum,
            'list' => $arr
        );
        return $out;

    }

    //获取当前选择的线路目的地优化信息
    public static function get_dest_info($destid)
    {
        $destid = intval($destid);
        $arr = array();
        if ($destid)
        {
            $sql = "SELECT a.kindname,b.seotitle,b.jieshao,b.keyword,b.tagword,b.description,a.pinyin FROM `sline_destinations` as a left join `sline_ship_line_kindlist` AS b ON a.id=b.kindid WHERE a.id = $destid ";
        }
        $row = DB::query(1, $sql)->execute()->current();

        if (empty($row['seotitle']))
        {

            $arr['seotitle'] = $row['kindname'];
        }
        else
        {
            $arr['seotitle'] = $row['seotitle'];

        }
        if (empty($row['description']))
        {
            $arr['description'] =  $row['description'];
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
     * 获取出发日期时间戳
     * @param $lineid
     * @param $hasprice 是否返回价格
     */
    public static function get_starttime($lineid,$suitid='',$hasprice=false)
    {
        $time = strtotime(date('Y-m-d'));
        $where = !empty($suitid) ? " AND a.suitid=" . intval($suitid) : '';

        //提前预定
        $before_info = DB::select('islinebefore', 'linebefore')->from('ship_line')->where('id', '=', $lineid)->execute()->current();
        if ($before_info['islinebefore'] > 0 && $before_info['linebefore'] > 0)
        {
            $time = strtotime("+{$before_info['linebefore']} days", $time);
        }
        $sql='select min(b.starttime) as starttime,a.price from sline_ship_line_suit_price a inner join sline_ship_schedule_date b on a.dateid=b.id and a.scheduleid=b.scheduleid
        inner join (select a.id,b.scheduleid from sline_ship_line_suit a inner join sline_ship_line b
        on a.lineid=b.id and a.shipid=b.shipid where a.lineid='.$lineid.') c  on a.suitid=c.id and a.scheduleid=c.scheduleid where a.lineid='.$lineid.' and a.price>0 and b.starttime>='.$time.' '.$where;
        $row = DB::query(1, $sql)->execute()->current();

        $starttime='';
        if (!empty($row))
        {
           $starttime = $row['starttime'];
        }
        if($hasprice && !empty($row))
        {
            return array('starttime'=>$starttime,'price'=>$row['price']);
        }
        return $starttime;
    }


    public static function get_many_starttime($lineid,$limit=1)
    {
        $time = strtotime(date('Y-m-d'));
        //提前预定
        $before_info = DB::select('islinebefore', 'linebefore')->from('ship_line')->where('id', '=', $lineid)->execute()->current();
        if ($before_info['islinebefore'] > 0 && $before_info['linebefore'] > 0)
        {
            $time = strtotime("+{$before_info['linebefore']} days", $time);
        }
        $sql='select b.starttime as starttime,a.price from sline_ship_line_suit_price a inner join sline_ship_schedule_date b on a.dateid=b.id and a.scheduleid=b.scheduleid
        inner join (select a.id,b.scheduleid from sline_ship_line_suit a inner join sline_ship_line b
        on a.lineid=b.id and a.shipid=b.shipid where a.lineid='.$lineid.') c  on a.suitid=c.id and a.scheduleid=c.scheduleid where a.lineid='.$lineid.' and a.price>0 and b.starttime>='.$time.'  limit '.$limit;
        $row = DB::query(1, $sql)->execute()->as_array();
        $date=array();
        foreach($row as $item){
            array_push($date,date('Y-m-d',$item['starttime']));
        }
        return $date?implode(',',$date):'';
    }


    //获取所有属性
    public static function line_attr($attrid)
    {
        if (empty($attrid))
        {
            return;
        }
        $attrid = trim($attrid, ',');
        $attrid_arr = explode(',', $attrid);

        $arr = DB::select('attrname')->from('ship_line_attr')->where('id', 'in', $attrid_arr)->and_where('pid', '!=', 0)->execute()->as_array();
        return $arr;
    }
    /**
     * @param $lineday
     * 检测是否是最后一天
     */
    public static function is_last_day($lineday)
    {

        $row = DB::select()->from('ship_line_day')->where('title', '>', $lineday)->limit(1)->execute()->current();
        return $row['id'] > 0 ? 0 : 1;
    }

    /**
     * @param $p
     * @return array
     * @desc 已选择项处理
     */
    public static function get_selected_item($p)
    {
        $out = array();
        //目的地
        if ($p['destpy'] != 'all')
        {
            $temp = array();
            $url = self::get_search_url('all', 'destpy', $p);
            $temp['url'] = $url;
            $dest = DB::select()->from('destinations')->where('pinyin', '=', $p['destpy'])->execute()->current();
            $temp['itemname'] = $dest['kindname'];
            $out[] = $temp;
        }
        //天数
        if ($p['dayid'] != 0)
        {
            $temp = array();
            $url = self::get_search_url('0', 'dayid', $p);
            $temp['url'] = $url;
            $temp['itemname'] = self::get_day_list_title($p['dayid']);
            $out[] = $temp;

        }
        //价格
        if ($p['priceid'] != 0)
        {
            $temp = array();
            $url = self::get_search_url('0', 'priceid', $p);
            $temp['url'] = $url;
            $ar = DB::select()->from('line_pricelist')->where('id', '=', $p['priceid'])->execute()->current();

            $lowerprice = $ar['lowerprice'];
            $highprice = $ar['highprice'];
            $temp['itemname'] = self::get_price_list_title($lowerprice, $highprice);
            $out[] = $temp;

        }
        //startcityid
        if ($p['startcityid'] != 0)
        {
            $temp = array();
            $url = self::get_search_url('0', 'startcityid', $p);
            $temp['url'] = $url;
            $temp['itemname'] = DB::select('cityname')->from('startplace')->where('id', '=', $p['startcityid'])->execute()->get('cityname');
            $out[] = $temp;

        }
        if ($p['shipid'] != 0)
        {
            $temp = array();
            $url = self::get_search_url('0', 'shipid', $p);
            $temp['url'] = $url;
            $temp['itemname'] = DB::select('title')->from('ship')->where('id', '=', $p['shipid'])->execute()->get('title');
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
                $temp['itemname'] = DB::select('attrname')->from('ship_line_attr')->where('id', '=', $ar)->execute()->get('attrname');//ORM::factory('line_attr', $ar)->get('attrname');
                unset($orgArr[array_search($ar, $orgArr)]);
                if (!empty($orgArr))
                {
                    $attrid = implode('_', $orgArr);
                }
                else
                {
                    $attrid = 0;
                }


                $url = $GLOBALS['cfg_basehost'] . '/ship/';
                $url .= $p['destpy'] . '-' . $p['dayid'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .= $p['startcityid'] . '-' .$p['shipid'].'-'. $attrid . '-1';

                $temp['url'] = $url;
                $out[] = $temp;
            }

        }
        return $out;

    }
    /*
   * 生成优化标题
   */
    public static function gen_seotitle($param)
    {
        $main_items=array();
        $normal_items = array();

        if (!empty($param['p']))
        {
            $p = intval($param['p']);
            if ($p > 1)
            {
                $main_items[] = '第' . $p . '页';
            }
        }

        if (!empty($param['destpy']))
        {
            $destInfo = Model_Destinations::search_seo($param['destpy'], 104);
            $normal_items[] = $destInfo['seotitle'];
        }
        if (!empty($param['keyword']))
        {
            $normal_items[] = '关于' . $param['keyword'] . '的搜索结果';
        }
        if (!empty($param['startcityid']))
        {
            $normal_items[] = Model_Startplace::start_city($param['startcityid']) . "出发";
        }
        if (!empty($param['dayid']))
        {
            $normal_items[] = $param['dayid'] . "日游";
        }

        if (!empty($param['priceid']))
        {
            $price_info = DB::select()->from('ship_line_pricelist')->where('id','=', $param['priceid'])->execute()->current();

            $normal_items[] = "价格区间{$price_info['lowerprice']}~{$price_info['highprice']}";
        }

        if (!empty($param['attrid']))
        {
            $normal_items[] = Model_Ship_Line_Attr::get_attrname_list($param['attrid'], '|');
        }

        $normal_items_str = implode('|',$normal_items);
        if(!empty($normal_items_str))
        {
            $main_items[]=$normal_items_str;
        }

        $main_items[] = $GLOBALS['cfg_webname'];

        $main_items_str = implode('-',$main_items);
        return $main_items_str;


    }
    /*
    * 价格格式化
    * */
    public static function get_price_list_title($lowerprice, $highprice)
    {
        $currency_symbol = Currency_Tool::symbol();
        if ($lowerprice != '' && $highprice != '')
        {
            $title = $currency_symbol . $lowerprice . '元-' .$currency_symbol . $highprice . '元';
        }
        else if ($lowerprice == '')
        {
            $title = $currency_symbol.'' . $highprice . '元以下';
        }
        else if ($highprice == '')
        {
            $title =$currency_symbol . $lowerprice . '元以上';
        }
        return $title;
    }

    /*
     * 出游天数格式化
     * */
    public static function get_day_list_title($day)
    {
        $title = Product::to_upper($day);

        $suit = ORM::factory('ship_line_day')->get_all();

        if ($day < count($suit))
        {
            $title .= '日游';
        }
        else
        {
            $title .= '日游以上';
        }

        return $title;
    }
    /*
    * 生成searh页地址
    * */
    public static function get_search_url($v, $paramname, $p, $currentpage = 1)
    {


        $url = $GLOBALS['cfg_basehost'] . '/ship/';
        switch ($paramname)
        {
            case "destpy":
                $url .= $v . '-' . $p['dayid'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .=  $p['startcityid'] . '-' .$p['shipid'].'-'. $p['attrid'] . '-' . $currentpage;
                break;
            case "dayid":
                $url .= $p['destpy'] . '-' . $v . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .= $p['startcityid'] . '-' . $p['shipid'].'-'.$p['attrid'] . '-' . $currentpage;
                break;
            case "priceid":
                $url .= $p['destpy'] . '-' . $p['dayid'] . '-' . $v . '-' . $p['sorttype'] . '-';
                $url .=  $p['startcityid'] . '-' . $p['shipid'].'-'.$p['attrid'] . '-' . $currentpage;
                break;
            case "sorttype":
                $url .= $p['destpy'] . '-' . $p['dayid'] . '-' . $p['priceid'] . '-' . $v . '-';
                $url .= $p['startcityid'] . '-' .$p['shipid'].'-'. $p['attrid'] . '-' . $currentpage;
                break;

            case "startcityid":
                $url .= $p['destpy'] . '-' . $p['dayid'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .=  $v . '-' .$p['shipid'].'-'. $p['attrid'] . '-' . $currentpage;
                break;
            case "shipid":
                $url .= $p['destpy'] . '-' . $p['dayid'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .=  $p['startcityid'] . '-' . $v.'-'.$p['attrid'] . '-' . $currentpage;
                break;
            case "attrid":

                $orignalArr = Product::get_attr_parent($p['attrid'], self::$typeid);
                $nowArr = Product::get_attr_parent($v, self::$typeid);
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


                $url .= $p['destpy'] . '-' . $p['dayid'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .= $p['startcityid'] . '-' .$p['shipid'].'-'. $attr_list . '-' . $currentpage;
                break;

        }

        return $url;


    }
    /**
     * 获取游轮出发地
     * @param $id
     * @param string $field
     * @return mixed
     */
    public static function get_start_city($id, $field = '*')
    {
        $result=DB::select($field)->from('startplace')->where('id', '=', $id)->execute()->current();
        if($field!='*'){
            $result=$result[$field];
        }
        return $result;
    }

    //日历
    public static function get_suit_price($year, $month,$lineid, $startdate)
    {
        $starttime = !empty($startdate) ? strtotime($startdate) : strtotime("$year-$month-1");
        $endtime = strtotime(date('Y-m-d', strtotime("$year-$month-1 +1 month -1 day")));
        $suitfields = "a.basicprice,a.profit,a.price,a.storeprice,a.number,a.suitid";
        $sql = "select {$suitfields},a.price as minprice,a.price/z.peoplenum as avgprice,b.starttime as day   from sline_ship_line_suit_price a inner join sline_ship_schedule_date b";
        $sql.=" on a.dateid=b.id and a.scheduleid=b.scheduleid ";
        $sql.=" inner join (select x.id as suitid,y.peoplenum from  sline_ship_line_suit x inner join sline_ship_room y on x.roomid=y.id) z on a.suitid=z.suitid ";

        $sql.="inner join sline_ship_line c ";
        $sql.=" on a.lineid=c.id and a.shipid=c.shipid and a.scheduleid=c.scheduleid ";
        $sql.=" where b.starttime>={$starttime} and b.starttime<={$endtime} and a.price>0 and c.id={$lineid} order by b.starttime asc,avgprice asc";
        $list = DB::query(Database::SELECT,$sql)->execute()->as_array();



        $newlist = array();
        $days = array();
        foreach($list as $v)
        {
            if(in_array($v['day'],$days))
            {
                continue;
            }
            $days[]=$v['day'];
            $roomid = DB::select('roomid')->from('ship_line_suit')->where('id','=',$v['suitid'])->execute()->get('roomid');
            $peoplenum = DB::select('peoplenum')->from('ship_room')->where('id','=',$roomid)->execute()->get('peoplenum');
            $peoplenum = empty($peoplenum)?1:$peoplenum;
            $v['minprice'] =  Currency_Tool::price(floor($v['minprice']/$peoplenum));
            $v['price'] =  Currency_Tool::price($v['price']);
            $newlist[$v['day']] = $v;
        }
        return $newlist;
    }
    //获取某个线路某天的所有报价
    public static function get_price_byday($lineid,$useday)
    {
        $lineid = intval($lineid);
        $day = strtotime($useday);
        $suitfields = "a.basicprice,a.profit,a.price,a.storeprice,a.number,a.suitid,a.dateid";
        $sql = "select {$suitfields},b.starttime as day  from sline_ship_line_suit_price a inner join sline_ship_schedule_date b";
        $sql.=" on a.dateid=b.id and a.scheduleid=b.scheduleid inner join sline_ship_line c ";
        $sql.=" on a.lineid=c.id and a.shipid=c.shipid and a.scheduleid=c.scheduleid ";
        $sql.=" where b.starttime={$day} and c.id={$lineid}";
        $list = DB::query(Database::SELECT,$sql)->execute()->as_array();
        foreach($list as &$v)
        {
            $v['price'] =  Currency_Tool::price($v['price']);
            $v['basicprice'] =  Currency_Tool::price($v['basicprice']);
            $v['profit'] =  Currency_Tool::price($v['profit']);
            $suitsql = "select b.title as suitname,b.peoplenum,c.title as kindname from sline_ship_line_suit a"
                ." inner join sline_ship_room b on a.shipid=b.shipid and a.roomid=b.id "
                ." left join sline_ship_room_kind c on b.kindid=c.id where a.id={$v['suitid']}";
            $suit_info = DB::query(Database::SELECT,$suitsql)->execute()->current();
            $v=array_merge($v,$suit_info);
        }
        return $list;

    }
	 //获取某个套餐的信息
    public static function get_suit_info($lineid,$suitid,$dateid)
    {
        $suitfields = "a.basicprice,a.profit,a.price,a.storeprice,a.number,a.suitid,a.dateid";
        $sql = "select {$suitfields} as day  from sline_ship_line_suit_price a ";
        $sql .= " inner join sline_ship_line b on a.lineid=b.id and a.shipid=b.shipid and a.scheduleid=b.scheduleid ";
        $sql .= " where a.suitid={$suitid} and a.dateid={$dateid} and a.lineid={$lineid}";
        $row = DB::query(Database::SELECT,$sql)->execute()->current();

        if(empty($row['suitid']))
            return null;

        $row['price'] =  Currency_Tool::price($row['price']);
        $row['basicprice'] =  Currency_Tool::price($row['basicprice']);
        $row['profit'] =  Currency_Tool::price($row['profit']);
            $suitsql = "select b.title as suitname,b.peoplenum,b.kindid from sline_ship_line_suit a"
                ." inner join sline_ship_room b on a.shipid=b.shipid and a.roomid=b.id where a.id={$row['suitid']}";
            $suit_info = DB::query(Database::SELECT,$suitsql)->execute()->current();
        $row=array_merge($row,$suit_info);
        return $row;
    }


    public static function jieshao($lineid,$lineday)
    {
        $lineid = intval($lineid);
        $lineday = intval($lineday);
        $sql = "SELECT * FROM sline_ship_line_jieshao where lineid ={$lineid} ORDER BY day ASC LIMIT 0,$lineday";
        $arr= DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }
    public static function mobile_jieshao($lineid,$lineday)
    {

        $lineid = intval($lineid);
        $lineday = intval($lineday);
        $sql = "SELECT * FROM sline_ship_line_jieshao where lineid ={$lineid} ORDER BY day ASC LIMIT 0,$lineday";
        $arr= DB::query(1, $sql)->execute()->as_array();
        foreach($arr as &$a)
        {
            $a['content'] = Product::strip_style($a['content']);
        }
        return $arr;


    }

    //渡轮添加订单，由于与标准产品差异较大，所以不使用Product::add_order
    public static function add_order($arr)
    {
        $model = ORM::factory('member_order');
        $flag = 0;
        if (is_array($arr))
        {
            //添加供应商信息
            $arr['supplierlist'] = Product::get_product_supplier($arr['typeid'], $arr['productautoid']);

            if ($arr['paytype'] == '3')//这里补充一个当为二次确认时,修改订单为未处理状态.
            {
                $arr['status'] = 0;
            }
            if (empty($arr['memberid']))
            {
                $arr['memberid'] = Product::auto_reg($arr['linktel']);
            }
            foreach ($arr as $k => $v)
            {
                $model->$k = $v;
            }
            $model->save();
            $flag = $model->saved();

            if ($flag)
            {

                $detectresult = Model_Member_Order_listener::detect($arr['ordersn']);
                if ($detectresult !== true)
                    return false;

                //下单成功,设置当前平台PC
                Common::session('_platform', 'pc');
                //减库存
                $dingnum = intval($arr['dingnum']) + intval($arr['childnum']) + intval($arr['oldnum']);

                $memberinfo = Model_Member::get_member_byid($arr['memberid']);
                $mobile = $arr['linktel'] ? $arr['linktel'] : $memberinfo['mobile'];
                $prefix = !empty($memberinfo['nickname']) ? $memberinfo['nickname'] : $memberinfo['mobile'];
                $orderAmount = Product::calculate_price($model->as_array());
                if ($arr['paytype'] == '3') //二次确认支付
                {
                    $msgInfo = Product::get_define_msg($arr['typeid'], 1);
                    if ($msgInfo['isopen'] == 1) //等待客服处理短信
                    {
                        $content = $msgInfo['msg'];
                        $content = str_replace('{#WEBNAME#}', $GLOBALS['cfg_webname'], $content);
                        $content = str_replace('{#PHONE#}', $GLOBALS['cfg_phone'], $content);
                        $content = str_replace('{#MEMBERNAME#}', $memberinfo['nickname'], $content);
                        $content = str_replace('{#PRODUCTNAME#}', $arr['productname'], $content);
                        $content = str_replace('{#PRICE#}', $orderAmount['priceDescript'], $content);
                        $content = str_replace('{#NUMBER#}', $orderAmount['numberDescript'], $content);
                        $content = str_replace('{#TOTALPRICE#}', $orderAmount['totalPrice'], $content);
                        $content = str_replace('{#PAYPRICE#}', $orderAmount['payPrice'], $content);
                        $content = str_replace('{#ORDERSN#}', $arr['ordersn'], $content);
                        $content = str_replace('{#ETICKETNO#}', $arr['eticketno'], $content);
                        Product::send_msg($mobile, $prefix, $content);//发送短信.
                    }
                    $emailInfo = Product::get_email_msg($arr['typeid'], 1);
                    if ($emailInfo['isopen'] == 1 && $memberinfo['email'])
                    {
                        $title = "预定" . $arr['productname'] . '[' . $GLOBALS['cfg_webname'] . ']';
                        $content = $emailInfo['msg'];
                        $content = str_replace('{#WEBNAME#}', $GLOBALS['cfg_webname'], $content);
                        $content = str_replace('{#PHONE#}', $GLOBALS['cfg_phone'], $content);
                        $content = str_replace('{#MEMBERNAME#}', $memberinfo['nickname'], $content);
                        $content = str_replace('{#PRODUCTNAME#}', $arr['productname'], $content);
                        $content = str_replace('{#PRICE#}', $orderAmount['priceDescript'], $content);
                        $content = str_replace('{#NUMBER#}', $orderAmount['numberDescript'], $content);
                        $content = str_replace('{#TOTALPRICE#}', $orderAmount['totalPrice'], $content);
                        $content = str_replace('{#PAYPRICE#}', $orderAmount['payPrice'], $content);
                        $content = str_replace('{#ORDERSN#}', $arr['ordersn'], $content);
                        $content = str_replace('{#ETICKETNO#}', $arr['eticketno'], $content);
                        Product::order_email($memberinfo['email'], $title, $content);
                    }


                }
                else //全款支付/订金支付
                {
                    $msgInfo = Product::get_define_msg($arr['typeid'], 2);
                    if ($msgInfo['isopen'] == 1)
                    {
                        $content = $msgInfo['msg'];
                        $content = str_replace('{#WEBNAME#}', $GLOBALS['cfg_webname'], $content);
                        $content = str_replace('{#PHONE#}', $GLOBALS['cfg_phone'], $content);
                        $content = str_replace('{#MEMBERNAME#}', $memberinfo['nickname'], $content);
                        $content = str_replace('{#PRODUCTNAME#}', $arr['productname'], $content);
                        $content = str_replace('{#PRICE#}', $orderAmount['priceDescript'], $content);
                        $content = str_replace('{#NUMBER#}', $orderAmount['numberDescript'], $content);
                        $content = str_replace('{#TOTALPRICE#}', $orderAmount['totalPrice'], $content);
                        $content = str_replace('{#PAYPRICE#}', $orderAmount['payPrice'], $content);
                        $content = str_replace('{#ORDERSN#}', $arr['ordersn'], $content);
                        $content = str_replace('{#ETICKETNO#}', $arr['eticketno'], $content);
                        Product::send_msg($mobile, $prefix, $content);//发送短信.
                    }
                    $emailInfo = Product::get_email_msg($arr['typeid'], 2);
                    if ($emailInfo['isopen'] == 1 && $memberinfo['email'])
                    {
                        $title = "预定" . $arr['productname'] . '[' . $GLOBALS['cfg_webname'] . ']';
                        $content = $emailInfo['msg'];
                        $content = str_replace('{#WEBNAME#}', $GLOBALS['cfg_webname'], $content);
                        $content = str_replace('{#PHONE#}', $GLOBALS['cfg_phone'], $content);
                        $content = str_replace('{#MEMBERNAME#}', $memberinfo['nickname'], $content);
                        $content = str_replace('{#PRODUCTNAME#}', $arr['productname'], $content);
                        $content = str_replace('{#PRICE#}', $orderAmount['priceDescript'], $content);
                        $content = str_replace('{#NUMBER#}', $orderAmount['numberDescript'], $content);
                        $content = str_replace('{#TOTALPRICE#}', $orderAmount['totalPrice'], $content);
                        $content = str_replace('{#PAYPRICE#}', $orderAmount['payPrice'], $content);
                        $content = str_replace('{#ORDERSN#}', $arr['ordersn'], $content);
                        $content = str_replace('{#ETICKETNO#}', $arr['eticketno'], $content);
                        Product::order_email($memberinfo['email'], $title, $content);
                    }


                }

                //供应商短信发送
                if ($GLOBALS['cfg_supplier_msg_open'] == 1 && !empty($GLOBALS['cfg_supplier_msg']))
                {
                    $content = $GLOBALS['cfg_supplier_msg'];
                    $content = str_replace('{#WEBNAME#}', $GLOBALS['cfg_webname'], $content);
                    $content = str_replace('{#PHONE#}', $memberinfo['mobile'], $content);
                    $content = str_replace('{#MEMBERNAME#}', $memberinfo['nickname'], $content);
                    $content = str_replace('{#PRODUCTNAME#}', $arr['productname'], $content);
                    $content = str_replace('{#PRICE#}', $orderAmount['priceDescript'], $content);
                    $content = str_replace('{#NUMBER#}', $orderAmount['numberDescript'], $content);
                    $content = str_replace('{#TOTALPRICE#}', $orderAmount['totalPrice'], $content);
                    $content = str_replace('{#PAYPRICE#}', $orderAmount['payPrice'], $content);
                    $content = str_replace('{#ORDERSN#}', $arr['ordersn'], $content);
                    $content = str_replace('{#ETICKETNO#}', $arr['eticketno'], $content);

                    //本站管理员短信发送
                    $cfg_webmaster_phone = $GLOBALS['cfg_webmaster_phone'];
                    if (!empty($cfg_webmaster_phone))
                    {
                        Product::send_msg($cfg_webmaster_phone, $prefix, $content);//发送短信
                    }

                    if ($GLOBALS['cfg_supplier_send_open'] == 1)
                    {
                        $supplierphone = Product::get_supplier_link($arr['productautoid'], $arr['typeid']);
                        if (!empty($supplierphone))
                        {
                            Product::send_msg($supplierphone, $prefix, $content);//发送短信.
                        }
                    }
                }

                //供应商email发送
                if ($GLOBALS['cfg_supplier_email_open'] == 1 && !empty($GLOBALS['cfg_supplier_emailmsg']))
                {
                    $content = $GLOBALS['cfg_supplier_emailmsg'];
                    $title = "预定" . $arr['productname'] . '[' . $GLOBALS['cfg_webname'] . ']';
                    $content = str_replace('{#WEBNAME#}', $GLOBALS['cfg_webname'], $content);
                    $content = str_replace('{#PHONE#}', $memberinfo['mobile'], $content);
                    $content = str_replace('{#MEMBERNAME#}', $memberinfo['nickname'], $content);
                    $content = str_replace('{#PRODUCTNAME#}', $arr['productname'], $content);
                    $content = str_replace('{#PRICE#}', $orderAmount['priceDescript'], $content);
                    $content = str_replace('{#NUMBER#}', $orderAmount['numberDescript'], $content);
                    $content = str_replace('{#TOTALPRICE#}', $orderAmount['totalPrice'], $content);
                    $content = str_replace('{#PAYPRICE#}', $orderAmount['payPrice'], $content);
                    $content = str_replace('{#ORDERSN#}', $arr['ordersn'], $content);
                    $content = str_replace('{#ETICKETNO#}', $arr['eticketno'], $content);


                    //本站管理员短信发送
                    $cfg_webmaster_email = $GLOBALS['cfg_webmaster_email'];
                    if (!empty($cfg_webmaster_email))
                    {
                        Product::order_email($cfg_webmaster_email, $title, $content);
                    }

                    if ($GLOBALS['cfg_supplier_sendemail_open'] == 1)
                    {
                        $supplieremail = Product::get_supplier_link($arr['productautoid'], $arr['typeid'], false);
                        if (!empty($supplieremail))
                        {
                            Product::order_email($supplieremail, $title, $content);
                        }
                    }
                }
            }


        }

        return $flag;


    }
    public static function minu_storage($suitid,$dateid,$dingnum)
    {
        $dingnum = intval($dingnum);
        $sql = "UPDATE `sline_ship_line_suit_price` SET number=number-$dingnum WHERE dateid='$dateid' AND suitid='$suitid' AND number!=0 and number!=-1";
        $result = DB::query(Database::UPDATE, $sql)->execute();
        return $result;
    }

    public static function update_click_rate($id)
    {
        $sql = "UPDATE `sline_ship_line` SET shownum=shownum+1 WHERE id='{$id}'";
        DB::query(Database::UPDATE,$sql)->execute();
    }

    /**
     * @function 库存操作函数,当$dingnum,当$dingnum为负数时为减库存
     * @param $suitid
     * @param $dingnum
     * @param $order_arr
     * @return int/bool
     */
    public static function storage($suitid,$dingnum,$order_arr)
    {
        $starttime = strtotime($order_arr['usedate']);
        $endtime = strtotime($order_arr['departdate']);
        $dingnum = intval($dingnum);

        if(empty($order_arr['child_list']) && empty($order_arr['id']))
        {
            return false;
        }

        $child_list  = $order_arr['child_list'];
        if(empty($child_list))
        {
            $child_list = DB::select('suitid','dingnum')->from('member_order_child')->where('pid','=',$order_arr['id'])->execute()->as_array();
        }

        $line_info  = DB::select()->from('ship_line')->where('id','=',$order_arr['productautoid'])->execute()->current();
        if(empty($line_info['id']))
        {
            return false;
        }
        $date_info = DB::select()->from('ship_schedule_date')->where('scheduleid','=',$line_info['scheduleid'])->and_where('starttime','=',$starttime)->and_where('endtime','=',$endtime)->execute()->current();//
        if(empty($date_info))
        {
            return false;
        }



        foreach($child_list as $child)
        {
            $suit_price =  DB::select()->from('ship_line_suit_price')->where('suitid','=',$child['suitid'])
                ->and_where('lineid','=',$order_arr['productautoid'])
                ->and_where('scheduleid','=',$line_info['scheduleid'])
                ->and_where('dateid','=',$date_info['id'])
                ->execute()->current();
            if($suit_price['number']=='-1')
                continue;
            if($dingnum<0  && intval($suit_price['number']<abs($dingnum)))
            {
                return false;
            }
            $update_arr =$dingnum>0? array('number' => DB::expr("number + {$child['dingnum']}")): array( 'number' => DB::expr("number - {$child['dingnum']}"));
            $flag = DB::update('ship_line_suit_price')->set($update_arr)
                ->where('suitid','=',$child['suitid'])
                ->and_where('lineid','=',$order_arr['productautoid'])
                ->and_where('scheduleid','=',$line_info['scheduleid'])
                ->and_where('dateid','=',$date_info['id'])->execute();
            if(!$flag)
            {
                return false;
            }
        }
        return true;
    }



}