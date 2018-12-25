<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Spot extends ORM
{

    public static $typeid = 5;
    protected $_table_name = 'spot';

    public function delete_clear()
    {
        $tickets = ORM::factory('spot_ticket')->where("spotid={$this->id}")->find_all()->as_array();
        foreach ($tickets as $ticket)
        {
            $ticket->delete_clear();
        }
        $this->delete();
    }

    /**
     * 更新景点最低报价
     *
     */
    public static function update_min_price($spotid)
    {
        $day = strtotime(date('Y-m-d'));
        $sql = "SELECT MIN(adultprice) as price FROM sline_spot_ticket_price WHERE spotid='$spotid' and `day`>=$day and `number`!=0";
        $ar = DB::query(1, $sql)->execute()->current();
        $price = $ar['price'] ? $ar['price'] : 0;
        //更新最低价
        DB::update('spot')->set(array('price' => $price, 'price_date' => strtotime(date('Y-m-d'))))->where('id', '=', $spotid)->execute();
    }

    /**
     * 更新最低报价(先更新门票最低价,后更新景点)
     *
     */
    public static function update_min_price_spot_ticket($spotid,$ticketid)
    {
        $rs = array('price' => 0);
        $cur_time = time();
        $where = " and a.ticketid ={$ticketid} ";
        $sql = "select a.ticketid,min(adultprice) as price from sline_spot_ticket_price a left join sline_spot_ticket b on a.ticketid=b.id   where b.spotid='{$spotid}' and a.number!=0 {$where} and a.day>({$cur_time}+b.day_before*24*3600-case when (b.hour_before=0 and b.minute_before=0) then 24*3600 else (3600*b.hour_before+b.minute_before*60) end ) group by a.ticketid order by price";
        $result = DB::query(1, $sql)->execute()->current();
        if ($result)
        {
            $rs['price'] = $result['price'];
        }
        //更新当前套餐最低价
        DB::update('spot_ticket')->set(array('ourprice' => $rs['price']))->where('id', '=', $ticketid)->execute();
        //更新景点最低报价
        self::update_min_price($spotid);
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
		$sellprice = 0;
		if($params['ticketid'])
		{
			$sql = "select min(cast(sellprice as signed )) as sellprice from sline_spot_ticket where spotid={$spotid} and id={$params['ticketid']}";
			$sellprice = DB::query(1, $sql)->execute()->get('sellprice');
		}
		if($params['info']['id'])
		{
			$sql = "select MAX(cast(sellprice as signed )) as sellprice from sline_spot_ticket where spotid={$spotid} ";
			$sellprice = DB::query(1, $sql)->execute()->get('sellprice');
		}
        $rs['sellprice'] = Currency_Tool::price($sellprice);


        if (!isset($params['ticketid']))
        {
            //报价最低
            if (!isset($params['info']))
            {
                $params['info'] = DB::select('price', 'price_date')->from('spot')->where('id', '=', $spotid)->execute()->current();
            }
            if ($time == $params['info']['price_date'] && !$params['info']['price'])
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
     * @param $spotid
     * @return array
     * 获取扩展字段信息
     */
    public static function get_extend_info($spotid)
    {
        $row = DB::select()->from('spot_extend_field')->where('productid', '=', $spotid)->execute()->as_array();
        return $row;
    }

    /**
     * @param $spotid
     * @return bool
     * 检测是否有门票
     */
    public static function has_ticket($spotid)
    {
        $arr = DB::select('id')->from('spot_ticket')->where('spotid', '=', $spotid)->and_where('status', '=', 3)->execute()->as_array();
        return count($arr) ? true : false;
    }

    /**
     * @param $destid
     * @param $row
     * @param $offset
     * @return mixed
     */

    public static function get_spot_bymdd($destid, $row, $offset)
    {
        $sql = "SELECT a.* FROM `sline_spot` AS a LEFT JOIN `sline_kindorderlist` b ON (a.id=b.aid and b.typeid=" . self::$typeid . " and b.classid='$destid') ";
        $sql .= "WHERE a.ishidden=0 AND FIND_IN_SET('{$destid}',a.kindlist)";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return self::format_spot_row($arr);
    }

    public static function format_spot_row($arr)
    {
        foreach ($arr as &$v)
        {
            $priceArr = Model_Spot::get_minprice($v['id']);
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], self::$typeid); //评论次数
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], self::$typeid) + intval($v['bookcount']); //销售数量
            $v['price'] = $priceArr['price'];
            $v['sellprice'] = $priceArr['sellprice'];
            $v['predest']= Product::get_predest($v['finaldestid']);
            $v['attrlist'] = Model_Spot_Attr::get_attr_list($v['attrid']);//属性列表.
            $v['url'] = Common::get_web_url($v['webid']) . "/spots/show_{$v['aid']}.html";
            $v['satisfyscore'] = St_Functions::get_satisfy(self::$typeid, $v['id'], $v['satisfyscore']);//满意度
            $v['iconlist'] = Product::get_ico_list($v['iconlist']);
            $v['hasticket'] = self::has_ticket($v['id']);

            if(Model_Supplier::display_is_open()&&$v['supplierlist'])
            {
                $v['suppliername'] = Arr::get(Model_Supplier::get_supplier_info($v['supplierlist'],array('suppliername')),'suppliername');
            }
        }
        return $arr;
    }

    /**
     * 详情 BY aid
     * @param $aid
     * @return mixed
     */
    public static function spot_detail($aid)
    {
        $sql = "SELECT * FROM sline_spot ";
        $sql .= "WHERE webid={$GLOBALS['sys_webid']} AND aid={$aid} ";
        $sql .= "limit 1";
        $arr = DB::query(1, $sql)->execute()->as_array();
        $arr['sellprice'] = Currency_Tool::price($arr['sellprice']);
        return $arr[0];
    }

    /**
     * 属性
     * @param $attrid
     * @return array
     */
    public static function spot_attr($attrid)
    {
        if (empty($attrid))
        {
            return;
        }
        $attrid = trim($attrid, ',');
        $arr = DB::select('attrname')->from('spot_attr')->where("id in({$attrid}) and pid!=0")->execute()->as_array();
        return $arr;
    }

    //------------------------以下是搜索页新增加使用函数-----------------

    /**
     * 参数解析
     * @param $params
     */
    public static function search_result($params, $keyword, $currentpage, $pagesize = '10')
    {
        $destPy = Common::remove_xss($params['destpy']);
        $priceId = Common::remove_xss($params['priceid']);
        $sortType = Common::remove_xss($params['sorttype']);
        $attrId = Common::remove_xss($params['attrid']);
        $page = $currentpage;
        $page = $page ? $page : 1;

        $value_arr=array();

        $where = " WHERE a.ishidden=0 ";
        //按目的地搜索
        if ($destPy && $destPy != 'all')
        {
            $destId = ORM::factory('destinations')->where("pinyin='$destPy'")->find()->get('id');
            $where .= " AND FIND_IN_SET('$destId',a.kindlist) ";
        }


        //价格区间
        if ($priceId)
        {
            $priceArr = ORM::factory('spot_pricelist', $priceId)->as_array();
            $min = $priceArr['min'] ? $priceArr['min'] : 0;
            $max = $priceArr['max'] ? $priceArr['max'] : 99999;
            $where .= " AND a.price BETWEEN {$min} AND {$max} ";
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
            $sql = "SELECT a.* FROM `sline_spot` a ";
            $sql .= "LEFT JOIN `sline_kindorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=" . self::$typeid . " AND a.webid=b.webid AND b.classid=$destId)";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
        }
        else
        {
            $sql = "SELECT a.* FROM `sline_spot` a ";
            $sql .= "LEFT JOIN `sline_allorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=" . self::$typeid . " AND a.webid=b.webid)";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
        }
        //计算总数
        $totalSql = "SELECT count(*) as dd " . strchr($sql, " FROM");
        $totalSql = str_replace(strchr($totalSql, "ORDER BY"), '', $totalSql);//去掉order by

        $totalN = DB::query(1, $totalSql)->parameters($value_arr)->execute()->current();
        $totalNum = $totalN['dd'] ? $totalN['dd'] : 0;

        $sql .= "LIMIT {$offset},{$pagesize}";

        $arr = DB::query(1, $sql)->parameters($value_arr)->execute()->as_array();
        $arr = self::format_spot_row($arr);
        $out = array(
            'total' => $totalNum,
            'list' => $arr
        );
        return $out;


    }

    /**
     * 手机端搜索
     */
    public static function search_result_mobile($params, $keyword, $pagesize = '10')
    {
        $destPy = $priceId = $sortType = $attrId = 0;
        $page = 1;
        $params = explode('-', str_replace('/', '-', $params));
        $count = count($params);
        switch ($count)
        {
            //目的地
            case 1:
                list($destPy) = $params;
                break;
            //关键字、属性
            case 5:
                list($destPy, $priceId, $sortType, $attrId, $page) = $params;
                break;
        }

        $priceId = intval($priceId);
        $sortType = intval($sortType);
        $page = intval($page);

        $where = ' WHERE a.ishidden=0 ';
        $value_arr = array();
        //按目的地搜索
        if ($destPy && $destPy != 'all')
        {
            $destId = DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id');
            $where .= " AND FIND_IN_SET('$destId',a.kindlist) ";
        }
        //价格区间
        if ($priceId)
        {
            $priceArr = DB::select()->from('spot_pricelist')->where('id', '=', $priceId)->execute()->current();
            $min = $priceArr['min'] ? $priceArr['min'] : 0;
            $where .= " AND a.price BETWEEN {$min} AND {$priceArr['max']} ";
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
            $where .= " AND a.title like :keyword ";
            $value_arr[':keyword'] = '%' . $keyword . '%';
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
            $sql = "SELECT a.* FROM `sline_spot` a ";
            $sql .= "LEFT JOIN `sline_kindorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=5 AND b.classid=$destId)";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy}IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
            $sql .= "LIMIT {$offset},{$pagesize}";
        }
        else
        {
            $sql = "SELECT a.* FROM `sline_spot` a ";
            $sql .= "LEFT JOIN `sline_allorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=5)";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy}IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
            $sql .= "LIMIT {$offset},{$pagesize}";
        }
        $data = DB::query(1, $sql)->parameters($value_arr)->execute()->as_array();
        foreach ($data as &$v)
        {
            $priceArr = Model_Spot::get_minprice($v['id'], array('info' => $v));
            $v['commentnum'] = Model_Comment::get_comment_num($v['id'], self::$typeid); //评论次数
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], self::$typeid) + intval($v['bookcount']); //销售数量
            $v['sellprice'] = $priceArr['sellprice'];//挂牌价
            $v['satisfyscore'] = St_Functions::get_satisfy(self::$typeid, $v['id'], $v['satisfyscore']);//满意度
            $v['price'] = $priceArr['price'];//最低价
            $v['iconlist'] = Product::get_ico_list($v['iconlist']);//卖点.
            $v['attrlist'] = Model_Spot_Attr::get_attr_list($v['attrid']);//属性列表.
            $v['url'] = Common::get_web_url($v['webid']) . "/spots/show_{$v['aid']}.html";
            $v['litpic'] = Common::img($v['litpic'], 220,150);

        }

        return Product::list_search_format($data, $page);
    }

    /*
    * 生成searh页地址
    * */
    public static function get_search_url($v, $paramname, $p, $currentpage = 1)
    {

        $url = $GLOBALS['cfg_basehost'] . '/spots/';
        switch ($paramname)
        {
            case "destpy":
                $url .= $v . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .= $p['attrid'] . '-' . $currentpage;
                break;

            case "priceid":
                $url .= $p['destpy'] . '-' . $v . '-' . $p['sorttype'] . '-';
                $url .= $p['attrid'] . '-' . $currentpage;
                break;
            case "sorttype":
                $url .= $p['destpy'] . '-' . $p['priceid'] . '-' . $v . '-';
                $url .= $p['attrid'] . '-' . $currentpage;
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
                $url .= $p['destpy'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .= $attr_list . '-' . $currentpage;
                break;

        }
        return $url;


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
        //目的地
        if ($p['destpy'] != 'all')
        {
            $temp = array();
            $url = self::get_search_url('all', 'destpy', $p);
            $temp['url'] = $url;
            $dest = ORM::factory('destinations')->where("pinyin='" . $p['destpy'] . "'")->find()->as_array();

            $temp['itemname'] = $dest['kindname'];
            $out[] = $temp;
            /*if (empty($dest['iswebsite']))
            {
                $temp['itemname'] = $dest['kindname'];
                $out[] = $temp;
            }*/
        }

        //价格
        if ($p['priceid'] != 0)
        {
            $temp = array();
            $url = self::get_search_url('0', 'priceid', $p);
            $temp['url'] = $url;
            $ar = ORM::factory('spot_pricelist', $p['priceid'])->as_array();
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
                $temp['itemname'] = ORM::factory('spot_attr', $ar)->get('attrname');
                unset($orgArr[array_search($ar, $orgArr)]);
                if (!empty($orgArr))
                {
                    $attrid = implode('_', $orgArr);
                }
                else
                {
                    $attrid = 0;
                }

                $url = $GLOBALS['cfg_basehost'] . '/spots/';
                $url .= $p['destpy'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
                $url .= $attrid . '-1';

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
        if(!empty($param['page']))
        {

            $p = intval($param['page']);
            if($p>1)
            {
                $main_items[]='第'.$p.'页';
            }
        }


        if (!empty($param['destpy']) && $param['destpy']!='all')
        {
            $destInfo = Model_Destinations::search_seo($param['destpy'], self::$typeid);
            $normal_items[] = $destInfo['seotitle'];
        }
        if (isset($_GET['keyword']))
        {
            $normal_items[] = '关于' . $_GET['keyword'] . '的搜索结果';
        }
        if (!empty($param['priceid']))
        {
            $priceArr = ORM::factory('spot_pricelist', $param['priceid'])->as_array();
            $price = self::get_price_list_title($priceArr['min'], $priceArr['max']);
            $normal_items[] = "价格区间$price";
        }
        if (!empty($param['attrid']))
        {
            $attrid_str = str_replace('_',',',$param['attrid']);
            $normal_items[] = Model_Spot_Attr::get_attrname_list($attrid_str, '|');

        }
        $normal_items_str = implode('|',$normal_items);
        if(!empty($normal_items_str))
        {
            $main_items[]=$normal_items_str;
        }

      /*  if(!empty($param['channel_name']))
        {
            $main_items[]=$param['channel_name'];
        }*/
        $main_items[] = $GLOBALS['cfg_webname'];

        $main_items_str = implode('-',$main_items);
        return $main_items_str;


    }
    /*
         * 获取目的地优化标题
         * */
    public static function search_seo($destpy, $type)
    {
        if (!empty($destpy) && $destpy != 'all')
        {
            $destinfo = DB::select('id','kindname')->from('destinations')->where('pinyin', '=', $destpy)->and_where('isopen', '=', 1)->execute()->current();
            //$info = ORM::factory('destinations', $destId)->as_array();
            $info = DB::select('seotitle')->from('spot_kindlist')->where('kindid', '=', $destinfo['id'])->execute()->current();
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $destinfo['kindname'];
        }
        else
        {
            $info = Model_Nav::get_channel_info_mobile($type);
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $info['m_title'];
        }

        return array('seotitle' => $seotitle);
    }
    //获取当前选择的目的地优化信息
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

            $sql = "SELECT a.kindname,b.seotitle,b.jieshao,b.keyword,b.tagword,b.description,a.pinyin FROM `sline_destinations` as a left join `sline_spot_kindlist` AS b ON a.id=b.kindid WHERE a.id = $destid ";
        }
        $row = DB::query(1, $sql)->execute()->current();

        $cfg_spot_title = str_replace('XXX', $row['kindname'], $cfg_spot_title);
        $cfg_spot_desc = str_replace('XXX', $row['kindname'], $cfg_spot_desc);
        if (empty($row['seotitle']))
        {

            $arr['seotitle'] = empty($cfg_spot_title) ? $row['kindname'] : $cfg_spot_title;
        }
        else
        {
            $arr['seotitle'] = $row['seotitle'];

        }
        if (empty($row['description']))
        {
            $arr['description'] = empty($cfg_spot_desc) ? $row['description'] : $cfg_spot_desc;
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
     * @param array $extraparam 附加参数
     * @return bool
     */
    public static function check_storage($productid,$dingnum,$suitid='',$usedate='',$enddate='',$extraparam='')
    {
        if(empty($suitid) || empty($usedate))
            return false;
        $day = strtotime($usedate);
        $query = DB::select('number','ticketid')->from('spot_ticket_price')
            ->and_where('ticketid','=',$suitid)
            ->and_where('day','=',$day);
        $row = $query->execute()->current();
        $status = true;
        if(empty($row) || empty($row['ticketid']))
        {
            $status = false;
        }
        else if($row['number']!='-1' && intval($row['number'])<intval($dingnum))
        {
            $status = false;
        }
        return $status;
    }

    /**
     * @function 库存操作函数,当$number为正数是为加库存,当$number为负数时为减库存
     * @param $suitid
     * @param $dingnum
     * @param $order_arr
     * @return bool|object
     */
    public static function storage($suitid,$dingnum,$order_arr)
    {

        $day = strtotime($order_arr['usedate']);
        $org_number = DB::select('number')->from('spot_ticket_price')
            ->where('day', '=', $day)
            ->and_where('ticketid', '=', $suitid)
            ->execute()
            ->get('number');
        if ($org_number == -1) {
            return true;
        }
        if (intval($dingnum) < 0) {
            //如果库存小于需求库存量,则直接返回减库存失败
            if ($org_number < abs($dingnum)) {
                return false;
            }
        }
        $update_arr = array(
            'number' => DB::expr("number + $dingnum")
        );
        $query = DB::update('spot_ticket_price')
            ->set($update_arr)
            ->where('ticketid', '=', $suitid)
            ->and_where('number', '<>', -1)
            ->and_where('day', '=', $day);

        return $query->execute();
    }


    //获取某月的报价表
    public static function get_month_price($year, $month, $suitid, $startdate='')
    {
        $start = !empty($startdate) ? strtotime($startdate) : strtotime("$year-$month-1");
        $end = strtotime("$year-$month-31");
       /* $arr = DB::select()->from('spot_ticket_price')
            ->where("ticketid=$suitid")
            ->and_where('day', '>=', $start)
            ->and_where('day', '<=', $end)
            ->and_where('number', '!=', 0)
            ->execute()->as_array();*/
        $cur_time = time();
        $sql = "select a.* from sline_spot_ticket_price a left join sline_spot_ticket b on a.ticketid=b.id ";
        $sql .=" where a.ticketid='{$suitid}' and a.number!=0  ";
        $sql .=" and a.day>({$cur_time}+b.day_before*24*3600-case when (b.hour_before=0 and b.minute_before=0) then 24*3600 else (3600*b.hour_before+b.minute_before*60) end) and a.day>={$start} and a.day<={$end}";
        $arr = DB::query(Database::SELECT,$sql)->execute()->as_array();

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
                $price[$day]['adult_price'] = Currency_Tool::price($row['adultprice']);

                $price[$day]['suitid'] = $suitid;
                $price[$day]['number'] = $row['number'];//库存
                $price[$day]['description'] = $row['description'];//描述
            }
        }
        return $price;
    }

    public static function before_order_check($spotid,$suitid,$day)
    {
        $cur_time = time();
        $sql = "select * from sline_spot_ticket_price a left join sline_spot_ticket b on a.ticketid=b.id ";
        $sql .=" where a.ticketid='{$suitid}' and a.number!=0 and a.day='{$day}' ";
        $sql .=" and a.day>({$cur_time}+b.day_before*24*3600-case when (b.hour_before=0 and b.minute_before=0) then 24*3600 else (3600*b.hour_before+b.minute_before*60) end) limit 1";
        $day_price = DB::query(Database::SELECT,$sql)->execute()->current();
        if(empty($day_price) || empty($day_price['day']))
        {
            return false;
        }
        return $day_price;
    }
    public static function get_suit_price($year, $month, $suitid)
    {

    }

    public static function get_spot_extend_content($spotid,$count=null)
    {
        $list=Model_Spot_Content::get_extend_field_content();
        $row = DB::select()->from('spot')->where('webid', '=', $GLOBALS['sys_webid'])->and_where('id', '=', $spotid)->execute()->current();
        $data=array();
        if(!empty($row['open_time_des']))
        {
            $data['open_time_des']['content']=$row['open_time_des'];
            $data['open_time_des']['title']='开放时间';
        }
        if(!empty($row['sellpoint']))
        {
            $data['sellpoint']['content']=$row['sellpoint'];
            $data['sellpoint']['title']='亮点介绍';
        }
        foreach ($list as &$item)
        {
            if($item['columnname']=='tupian')
            {
                continue;
            }
            else if($item['issystem']==1)
            {
                $data[$item['columnname']]['content']=$row[$item['columnname']];
                $data[$item['columnname']]['title']=$item['chinesename'];
            }
            else
            {
                $extend_field = DB::select()->from('spot_extend_field')->where('productid', '=', $row['id'])->execute()->current();
                $data[$item['columnname']]['content']=$extend_field[$item['columnname']];
                $data[$item['columnname']]['title']=$item['chinesename'];
            }
        }
        if(is_null($count))
        {
            return $data;
        }
        else
        {
            $i=1;
            $return=array();
            foreach ($data as $key=>$val)
            {
                if($i<=$count)
                {
                    $return[]=$val;
                }
                $i++;
            }
            return $return;
        }

    }
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

    /**
     * @function 获取产品详情的模板
     * @param $info
     * @param bool $wap
     */
    public static function get_product_template($info,$wap=false)
    {
        $template = false;
        if(!$wap&&$info['templet'])
        {
            $template = 'usertpl/' . $info['templet'] . '/index';
            if(!file_exists(rtrim(BASEPATH,DIRECTORY_SEPARATOR).'/'.$template.EXT))
            {
                return false;
            }
        }
        elseif ($wap&&$info['wap_templet'])
        {
            $template = 'usertpl/' . $info['wap_templet'] . '/index';
            if(!file_exists(rtrim(BASEPATH,DIRECTORY_SEPARATOR).'/phone/'.$template.EXT))
            {
                return false;
            }
        }
        return $template;

    }
}