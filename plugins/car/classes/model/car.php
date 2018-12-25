<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Car extends ORM
{

    private static $_typeid=3;
	public function delete_clear()
		{

			$suits = ORM::factory('car_suit')->where("carid={$this->id}")->find_all()->as_array();
			foreach ($suits as $suit)
			{
				$suit->delete_clear();
			}

			$this->delete();
		}


    /**
     * @function 更新最低报价
     * @param $carid
     */
    public static function update_min_price($carid)
    {
        $day = strtotime(date('Y-m-d'));
        $sql = "SELECT MIN(adultprice) as price FROM sline_car_suit_price WHERE `carid`='$carid' and `adultprice`>0 and `day`>={$day} and `number`!=0";
        $ar = DB::query(1, $sql)->execute()->current();
        $price = $ar['price'] ? $ar['price'] : 0;
        //更新最低价
        DB::update('car')->set(array('price' => $price, 'price_date' => strtotime(date('Y-m-d'))))->where('id', '=', $carid)->execute();
    }

    /**
     * @function 租车克隆
     * @param $id 克隆的产品ID
     * @param $num 克隆基数
     */
    public function clone_car($id, $num)
    {
        $arr = $this->where("id=$id")->find()->as_array();
        unset($arr['aid']);
        unset($arr['id']);
        for ($i = 1; $i <= $num; $i++)
        {
            //信息表
            $arr['addtime'] = $arr['modtime'] = time();
            $arr['aid'] = Common::getLastAid('sline_car', $arr['webid']);
            list($insertId, $row) = DB::insert('car', array_keys($arr))->values(array_values($arr))->execute();
            //字段扩展表
            if ($row > 0)
            {
                $result = DB::select()->from('car_extend_field')->where("productid={$id}")->execute()->current();
                if (!empty($result))
                {
                    unset($result['id']);
                    $result['productid'] = $insertId;
                    DB::insert('car_extend_field', array_keys($result))->values(array_values($result))->execute();
                }
            }
        }
    }

    /*
     * 获取目的地优化标题
     * */
    public static function search_seo($destpy)
    {
        if (!empty($destpy) && $destpy != 'all')
        {

            $destId = DB::select('id')->from('destinations')->where('pinyin', '=', $destpy)->and_where('isopen', '=', 1)->execute()->get('id');
            $info = DB::select('kindname', 'seotitle')->from('destinations')->where('id', '=', $destId)->execute()->current();
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $info['kindname'];
        }
        else
        {
            $info = Model_Nav::get_channel_info(3);
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $info['m_title'];
        }

        return array('seotitle' => $seotitle);
    }
    /*
        * 手机端获取目的地优化标题
        * */
    public static function search_seo_mobile($destpy)
    {
        if (!empty($destpy) && $destpy != 'all')
        {

            $destinfo = DB::select('id','kindname')->from('destinations')->where('pinyin', '=', $destpy)->and_where('isopen', '=', 1)->execute()->current();
            //$info = ORM::factory('destinations', $destId)->as_array();
            $info = DB::select('seotitle')->from('car_kindlist')->where('kindid', '=', $destinfo['id'])->execute()->current();
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $destinfo['kindname'];
        }
        else
        {
            $info = Model_Nav::get_channel_info_mobile(3);
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $info['m_title'];
        }

        return array('seotitle' => $seotitle);
    }

    /**
     * 结伴排序
     * @param $offset
     * @param $row
     * @return mixed
     */
    public static function get_car_list($whereStr = '', $offset, $row)
    {
        $sql = "SELECT a.id,a.webid,a.sellpoint,a.aid,a.kindlist,a.title,a.litpic,a.shownum,a.price,a.satisfyscore,a.bookcount,a.attrid,a.iconlist,a.carkindid";
        $sql .= " FROM `sline_car` AS a LEFT JOIN `sline_allorderlist` b ON (a.id=b.aid and b.typeid=3)";
        $sql .= " WHERE a.id>0 " . $whereStr;
        $sql .= " ORDER BY IFNULL(b.displayorder,9999) ASC,a.addtime DESC";
        $sql .= " LIMIT {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();

        foreach ($arr as &$v)
        {
            //如果没有图片
            if (empty($v['litpic']))
            {
                $v['litpic'] = Common::nopic();
            }
            $v['litpic'] = Common::img($v['litpic'], 283, 193);
            $v['url'] = Common::get_web_url($v['webid']) . '/cars/show_' . $v['aid'] . '.html';
            //价格
            $v['price'] = Model_Car::get_car_suit_price($v['aid'], $v['webid'], $v['id']);
            //车辆属性
            $v['attrlist'] = Model_Car_attr::get_attr_list($v['attrid']);
            //车型
            $v['kindname'] = Model_Car_Kind::get_carkindname($v['carkindid']);

            $v['satisfyscore'] =St_Functions::get_satisfy(self::$_typeid,$v['id'],$v['satisfyscore'],array('suffix'=>''));

        }
        return $arr;
    }

    /**
     * 获取车子新版最低报价
     * @param $aid
     * @param $webid
     * @param int $carid
     * @param int $suitid
     * @return int
     */
    public static function get_car_suit_price($aid, $webid, $carid = 0, $suitid = 0)
    {
        if (empty($carid))
        {
            $carid = DB::select('id')->from('car')->where('aid', '=', $aid)->and_where('webid', '=', $webid)->execute()->get('id');
        }
        $w = $suitid ? " AND suitid ='{$suitid}' " : ''; //是否按套餐读取
        $time = strtotime(date('Y-m-d'));
        if ($suitid) //如果指定了套餐id
        {
            $sql = "SELECT MIN(adultprice) AS price FROM sline_car_suit_price WHERE adultprice>0 and carid='{$carid}' AND day >= '{$time}' {$w} and number!=0";
        }
        else
        {
            $suitidlist = implode(',', self::get_car_suitId_list($carid));
            $w = empty($suitidlist) ? '' : " AND suitid IN ($suitidlist)";
            $sql = "SELECT MIN(adultprice) AS price FROM sline_car_suit_price WHERE adultprice>0 and  carid='{$carid}' AND day >= '{$time}' {$w} and number!=0";
        }
        $dataArr = NULL;
        $dataArr = DB::query(1, $sql)->execute()->current();
        if (!empty($dataArr))
        {
            $dataArr['price'] = Currency_Tool::price($dataArr['price']);
            $price = $dataArr['price'] ? $dataArr['price'] : 0;
        }
        else
        {
            $price = 0;
        }
        return $price;
    }

    /**
     * 获取车子套餐id列表
     * @param $carid
     * @return array
     */
    function get_car_suitId_list($carid)
    {
        $sql = "SELECT id FROM sline_car_suit WHERE carid={$carid}";
        $data = NULL;
        $dataArr = DB::query(1, $sql)->execute()->as_array();
        foreach ($dataArr as $row)
        {
            array_push($out, $row['id']);
        }
        return $out;
    }

    /*
     *获取套餐日期范围内价格总和.
     * */
    public static function suit_range_price($suitid, $sdate, $edate, $dingnum)
    {
        $sdate = strtotime($sdate);
        $edate = strtotime($edate);

        $sql = "SELECT adultprice FROM`sline_car_suit_price` ";
        $sql .= "WHERE suitid='$suitid' AND day>=$sdate AND day<=$edate";
        $ar = DB::query(1, $sql)->execute()->as_array();
        $price = 0;
        foreach ($ar as $row)
        {
            $row['adultprice'] = Currency_Tool::price($row['adultprice']);
            $price += $row['adultprice'] * $dingnum;
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
        $sql = "SELECT day FROM`sline_car_suit_price` ";
        $sql .= "WHERE suitid='$suitid' AND day>=$time AND price>0 AND number!=0 LIMIT 1";
        $ar = DB::query(1, $sql)->execute()->as_array();
        return $ar[0]['day'];
    }

    /**
     * @param $aid
     * @return mixed
     * 租车详情
     */
    public static function detail($aid)
    {
        $sql = "SELECT * FROM `sline_car` WHERE aid={$aid} and webid={$GLOBALS['sys_webid']}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr[0];
    }

    /**
     * 租车属性
     * @param $attrid
     * @return array
     */
    public static function car_attr($attrid)
    {
        if (empty($attrid))
        {
            return;
        }
        $attrid = trim($attrid, ',');
        $arr = DB::select('attrname')->from('car_attr')->where("id in({$attrid}) and pid!=0")->execute()->as_array();
        return $arr;
    }

    /**
     * 租车最低价
     * @param $carid
     * @param array $params
     * @return number
     */
    public static function get_minprice($carid, $params = array())
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
                $params['info'] = DB::select()->from('car')->where('id', '=', $carid)->execute()->current();
            }
            if ($params['info']['price_date'] == $time)
            {
                return Currency_Tool::price($params['info']['price']);
            }
            //更新最低价
            $update_minprice = true;
        }
        $where = isset($params['suitid']) ? " AND suitid=" . $params['suitid'] : '';
        $sql = 'SELECT MIN(adultprice) AS price FROM `sline_car_suit_price` WHERE adultprice > 0 and carid=' . $carid . ' AND day>=' . $time . ' AND (number>0 OR number=-1) ' . $where;
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
            DB::update('car')->set(array('price' => $price, 'price_date' => $time))->where('id', '=', $carid)->execute();
        }
        return Currency_Tool::price($price);
    }

    /**
     * 参数解析
     * @param $params
     */
    public static function search_result($params, $keyword, $currentpage, $pagesize = '10')
    {
        $destPy = $params['destpy'];
        $carkindId = intval($params['carkindid']);
        $sortType = intval($params['sorttype']);
        $attrId = $params['attrid'];
        $priceId = $params['priceid'];
        $page = intval($currentpage);
        $page = $page ? $page : 1;
        $where = " WHERE a.ishidden=0 ";
        $value_arr = array();
        //按目的地搜索
        if ($destPy && $destPy != 'all')
        {
            $destId = DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id');
            $where .= " AND FIND_IN_SET('$destId',a.kindlist) ";
        }
        //车型
        if ($carkindId)
        {
            $where .= " AND a.carkindid='$carkindId'";
        }
        //价格区间
        if ($priceId) {
            $priceArr = DB::select()->from('car_pricelist')->where('id', '=', $priceId)->execute()->current();
            if (empty($priceArr)) {
                Common::head404();
            }
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
            $sql = "SELECT a.* FROM `sline_car` a ";
            $sql .= "LEFT JOIN `sline_kindorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=3 AND b.classid=$destId)";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
            //$sql.= "LIMIT {$offset},{$pagesize}";
        }
        else
        {
            $sql = "SELECT a.* FROM `sline_car` a ";
            $sql .= "LEFT JOIN `sline_allorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=3)";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
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
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], 3) + intval($v['bookcount']); //销售数量
            $v['price'] = Model_Car::get_minprice($v['id']);//最低价

            $v['attrlist'] = Model_Car_Attr::get_attr_list($v['attrid']);//属性列表.
            $v['url'] = Common::get_web_url($v['webid']) . "/cars/show_{$v['aid']}.html";
            //车型
            $v['kindname'] = Model_Car_Kind::get_carkindname($v['carkindid']);
            $v['iconlist'] = Product::get_ico_list($v['iconlist']);
            $v['satisfyscore'] = St_Functions::get_satisfy(self::$_typeid,$v['id'],$v['satisfyscore'],array('suffix'=>''));
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

    /**
     * 参数解析
     * @param $params
     */
    public static function search_result_mobile($uriArr, $pagesize = '10')
    {
        $where = ' WHERE a.ishidden=0 ';
        //按目的地搜索
        if ($uriArr['destPy'] && $uriArr['destPy'] != 'all')
        {
            $destId = DB::select('id')->from('destinations')->where('pinyin', '=', $uriArr['destPy'])->execute()->get('id');
            $where .= " AND FIND_IN_SET('$destId',a.kindlist) ";
        }
        //车型
        if ($uriArr['kindid'])
        {
            $where .= " AND a.carkindid='{$uriArr['kindid']}'";
        }
        //排序
        $orderBy = "";
        if (!empty($uriArr['sorttype']))
        {
            if ($uriArr['sorttype'] == 1)//价格从低到高
            {
                $orderBy = "  a.price ASC,";
            }
            else if ($uriArr['sorttype'] == 2) //价格从高到低
            {
                $orderBy = "  a.price DESC,";
            }
            else if ($uriArr['sorttype'] == 3) //销量
            {
                $orderBy = " a.bookcount DESC,";
            }
            else if ($uriArr['sorttype'] == 4)//推荐
            {
                $orderBy = " a.recommendnum DESC,";
            }
        }

        //关键词
        if (!empty($uriArr['keyword']))
        {
            $where .= " AND a.title like '%{$uriArr['keyword']}%' ";
        }
        // 价格区间排序
        if (!empty($uriArr['priceid'])) {
            $priceArr = DB::select()->from('car_pricelist')->where('id', '=', $uriArr['priceid'])->execute()->current();
            $where .= " AND a.price BETWEEN {$priceArr['min']} AND {$priceArr['max']} ";
        }
        //按属性
        if (!empty($uriArr['attrid']))
        {
            $where .= Product::get_attr_where($uriArr['attrid']);
        }
        $offset = (intval($uriArr['page']) - 1) * $pagesize;

        //如果选择了目的地
        if (!empty($destId))
        {
            $sql = "SELECT a.* FROM `sline_car` a ";
            $sql .= "LEFT JOIN `sline_kindorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=3 AND b.classid=$destId)";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
            $sql .= "LIMIT {$offset},{$pagesize}";

        }
        else
        {
            $sql = "SELECT a.* FROM `sline_car` a ";
            $sql .= "LEFT JOIN `sline_allorderlist` b ";
            $sql .= "ON (a.id=b.aid AND b.typeid=3)";
            $sql .= $where;
            $sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
            $sql .= "LIMIT {$offset},{$pagesize}";


        }
        $data = DB::query(1, $sql)->execute()->as_array();
        foreach ($data as &$v)
        {
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], 3) + intval($v['bookcount']); //销售数量

            $v['url'] = Common::get_web_url($v['webid']) . "/cars/show_{$v['aid']}.html";
            $v['litpic'] = Common::img($v['litpic'], 220, 150);
            $v['url'] = Common::get_web_url($v['webid']) . '/cars/show_' . $v['aid'] . '.html';
            //价格
            $v['price'] = Model_Car::get_minprice($v['aid'], array('info' => $v));
            //车辆属性
            $v['attrlist'] = Model_Car_attr::get_attr_list($v['attrid']);
            //车型
            $v['kindname'] = Model_Car_Kind::get_carkindname($v['carkindid']);
            $v['satisfyscore'] = St_Functions::get_satisfy(self::$_typeid,$v['id'],$v['satisfyscore'],array('suffix'=>''));
        }

        return Product::list_search_format($data, $uriArr['page']);
    }


    /*
    * 生成searh页地址
    * */
    public static function get_search_url($v, $paramname, $p, $currentpage = 1)
    {   
        $url = $GLOBALS['cfg_basehost'] . '/cars/';
        switch ($paramname)
        {
            case "destpy":
                $url .= $v . '-' . $p['carkindid'] . '-' . $p['sorttype'] . '-';
                $url .= $p['attrid'] . '-' . $p['priceid'] . '-' . $currentpage;
                break;

            case "carkindid":
                $url .= $p['destpy'] . '-' . $v . '-' . $p['sorttype'] . '-';
                $url .= $p['attrid'] . '-' . $p['priceid'] . '-' . $currentpage;
                break;
            case "sorttype":
                $url .= $p['destpy'] . '-' . $p['carkindid'] . '-' . $v . '-';
                $url .= $p['attrid'] . '-' . $p['priceid'] . '-' . $currentpage;
                break;
            case "attrid":
                $orignalArr = Product::get_attr_parent($p['attrid'], 3);
                $nowArr = Product::get_attr_parent($v, 3);
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
                $url .= $p['destpy'] . '-' . $p['carkindid'] . '-' . $p['sorttype'] . '-';
                $url .= $attr_list . '-' . $p['priceid'] . '-' . $currentpage;
                break;
            case 'priceid':
                $url .= $p['destpy'] . '-' . $p['carkindid'] . '-' . $p['sorttype'] . '-' .$p['attrid'] . '-'. $v;
                $url .= '-' . $currentpage;
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
        $out = array();
        //目的地
        if ($p['destpy'] != 'all')
        {
            $temp = array();
            $url = self::get_search_url('all', 'destpy', $p);
            $temp['url'] = $url;
            $dest = DB::select('id', 'kindname', 'iswebsite')->from('destinations')->where('pinyin', '=', $p['destpy'])->execute()->current();
            if (empty($dest['iswebsite']))
            {
                $temp['itemname'] = $dest['kindname'];
                $out[] = $temp;
            }
        }

        //价格
        if ($p['carkindid'] != 0)
        {
            $temp = array();
            $url = self::get_search_url('0', 'carkindid', $p);
            $temp['url'] = $url;
            $temp['itemname'] = Model_Car_Kind::get_carkindname($p['carkindid']);
            $out[] = $temp;
        }
        // 价格区间选择
        if ($p['priceid'] != 0) 
        {
            $temp = array();
            $url = self::get_search_url('0', 'priceid', $p);
            $temp['url'] = $url;
            $pricelist = ORM::factory('car_pricelist', $p['priceid'])->as_array();
            $temp['itemname'] = '￥' . $pricelist['min'] . '-￥'. $pricelist['max'];
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
                $temp['itemname'] = DB::select('attrname')->from('car_attr')->where('id', '=', $ar)->execute()->get('attrname');
                unset($orgArr[array_search($ar, $orgArr)]);
                if (!empty($orgArr))
                {
                    $attrid = implode('_', $orgArr);
                }
                else
                {
                    $attrid = 0;
                }

                $url = $GLOBALS['cfg_basehost'] . '/cars/';
                $url .= $p['destpy'] . '-' . $p['carkindid'] . '-' . $p['sorttype'] . '-' . $attrid . '-1';
                $temp['url'] = $url;
                $out[] = $temp;
            }

        }
        return $out;

    }


    /**
     * @param $param
     * @return string
     * @desc 生成优化标题
     */
    public static function gen_seotitle($param, $extra_param=null)
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


        if (!empty($param['destpy']) && $param['destpy']!='all')
        {
            $destInfo = Model_Destinations::search_seo($param['destpy'], self::$_typeid);
            $normal_items[] = $destInfo['seotitle'];
        }
        if(!empty($param['keyword']))
        {
            $normal_items[] ='关于'.$param['keyword'].'的搜索结果';
        }
        if (!empty($param['carkindid']))
        {
            $normal_items[] = Model_Car_Kind::get_carkindname($param['carkindid']);
        }
        if (!empty($param['attrid']))
        {
            $normal_items[] = Model_Car_Attr::get_attrname_list($param['attrid'], '|');
        }
        if (!empty($param['priceid']))
        {
            $price_info = DB::select()->from('car_pricelist')->where('id', '=', $param['priceid'])->execute()->current();
            $normal_items[] = "价格区间{$price_info['min']}-{$price_info['max']}";
        }

        $normal_items_str = implode('|',$normal_items);
        if(!empty($normal_items_str))
        {
            $main_items[]=$normal_items_str;
        }

        /*if(!empty($param['channel_name']))
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

            $sql = "SELECT a.kindname,b.seotitle,b.jieshao,b.keyword,b.tagword,b.description,a.pinyin FROM `sline_destinations` as a left join `sline_car_kindlist` AS b ON a.id=b.kindid WHERE a.id = $destid ";
        }
        $row = DB::query(1, $sql)->execute()->current();

        $cfg_car_title = str_replace('XXX', $row['kindname'], $cfg_car_title);
        $cfg_car_desc = str_replace('XXX', $row['kindname'], $cfg_car_desc);
        if (empty($row['seotitle']))
        {

            $arr['seotitle'] = empty($cfg_car_title) ? $row['kindname'] : $cfg_car_title;
        }
        else
        {
            $arr['seotitle'] = $row['seotitle'];

        }
        if (empty($row['description']))
        {
            $arr['description'] = empty($cfg_car_desc) ? $row['description'] : $cfg_car_desc;
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
        $starttime = strtotime($usedate);
        $endtime = empty($enddate)? $starttime:strtotime($enddate);
        $sql = "SELECT number FROM `sline_car_suit_price` ";
        $sql .= "WHERE suitid='$suitid' AND day>=$starttime AND day<=$endtime";
        $ar = DB::query(1, $sql)->execute()->as_array();
        $flag = empty($ar)?false:true;



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
        $number_arr = DB::select('number')->from('car_suit_price')
            ->where('day','>=',$starttime)
            ->and_where('day','<=',$endtime)
            ->and_where('suitid','=',$suitid)
            ->execute()
            ->as_array();

        $flag = 1;

        foreach($number_arr as $row)
        {
            if($row['number']=='-1')
                continue;
            if($dingnum<0 && abs($row['number'])<$dingnum)
            {
                $flag=0;
            }
            else
            {
                $flag = 2;
            }
            break;
        }
        //如果库存都是无限，则返回true
        if($flag!=2)
           return $flag;


        $update_arr = array(
            'number' => DB::expr("number + $dingnum")
        );
        $query = DB::update('car_suit_price')
            ->set($update_arr)
            ->where('day', '>=', $starttime)
            ->and_where('day', '<=', $endtime)
            ->and_where('suitid', '=', $suitid)
            ->and_where('number', '<>', -1);
        return $query->execute();
    }

    //获取某月的报价表
    public static function get_month_price($year, $month, $suitid, $startdate)
    {
        $start = !empty($startdate) ? strtotime($startdate) : strtotime("$year-$month-1");
        $end = strtotime("$year-$month-31");
        $arr = DB::select()->from('car_suit_price')
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
                $price[$day]['suitid'] = $suitid;
                $price[$day]['number'] = $row['number'];//库存
                $price[$day]['description'] = $row['description'];//描述
            }
        }
        return $price;
    }


}