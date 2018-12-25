<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Line extends ORM {
	private static $_typeid = 1;

	//删除数据
	public function delete_clear() {
		$suits = ORM::factory('line_suit')->where("lineid={$this->id}")->find_all()->as_array();
		foreach ($suits as $suit) {
			$suit->delete_clear();
		}
		$this->delete();
	}

	/**
	 * @function 线路支付流程
	 * @return mixed
	 */
	public static function pay_status() {
		static $status = array();
		if (!$status) {
			$status = DB::select()->from('line_order_status')->where('is_show', '=', 1)->order_by('displayorder', 'asc')->execute()->as_array();
		}
		return $status;
	}

	/**
	 * @param $lineid
	 * @param array $params
	 * @return number
	 */
	public static function get_minprice($lineid, $params = array()) {
		if (empty($lineid)) {
			return false;
		}

		$time = strtotime(date('Y-m-d'));
		$day = $time;
		$update_minprice = false;
		if (!is_array($params)) {
			$params = array('suitid' => $params);
		}
		if (!isset($params['suitid'])) {
			if (!isset($params['info'])) {
				$params['info'] = DB::select()->from('line')->where('id', '=', $lineid)->execute()->current();
			}
			if ($params['info']['price_date'] == $time && !$params['info']['price']) {
				return Currency_Tool::price($params['info']['price']);
			}
			//更新最低价
			$update_minprice = true;
		}
		$where = isset($params['suitid']) ? " and suitid = " . $params['suitid'] : '';
		//最低价规则
		$cfg_line_minprice_rule = $GLOBALS['cfg_line_minprice_rule'];

		//提前预定
		$info = DB::select('islinebefore', 'linebefore')->from('line')->where('id', '=', $lineid)->execute()->current();
		if ($info['islinebefore'] > 0 && $info['linebefore'] > 0) {
			$time = strtotime("+{$info['linebefore']} days", $time);
		}
		$sql = "SELECT MIN(`adultprice`) as price FROM sline_line_suit_price WHERE `lineid`={$lineid} and `adultprice`>0 and `day`>={$day} and `number`!=0 $where and find_in_set(2,propgroup)";
		$condition = array('oldprice', 'childprice');
		switch ($cfg_line_minprice_rule) {
		//儿童
		case 1:
			$sql = 'SELECT MIN(`childprice`) as price FROM sline_line_suit_price WHERE `lineid`=' . $lineid . ' and `childprice`>0 and `day`>=' . $time . ' and (`number` >0 or `number`=-1) and find_in_set(1,propgroup)' . $where;
			$condition = array('adultprice', 'oldprice');
			break;
		//成人
		case 2:
			$sql = 'SELECT MIN(`adultprice`) as price FROM sline_line_suit_price WHERE `lineid`=' . $lineid . ' and `adultprice`>0 and day>=' . $time . ' and (`number` >0 or `number`=-1) and find_in_set(2,propgroup)' . $where;
			$condition = array('childprice', 'oldprice');
			break;
		//老人
		case 3:
			$sql = 'SELECT MIN(`oldprice`) as price FROM sline_line_suit_price WHERE `lineid`=' . $lineid . ' and `oldprice`>0 and day>=' . $time . ' and (`number` >0 or `number`=-1) and find_in_set(3,propgroup)' . $where;
			$condition = array('adultprice', 'childprice');
			break;
		}

		$rs = DB::query(1, $sql)->execute()->current();
		if (!$rs['price']) {
			$sql = "select * from ((SELECT MIN({$condition[0]}) as price1 FROM sline_line_suit_price WHERE `lineid`={$lineid} and {$condition[0]}>0 and `day`>={$time} and (`number` >0 or `number`=-1) $where) as temp1,(SELECT MIN({$condition[1]}) as price2 FROM sline_line_suit_price WHERE `lineid`={$lineid} and {$condition[1]}>0 and `day`>={$time} and (`number` >0 or `number`=-1) $where) as temp2)";
			$result = DB::query(1, $sql)->execute()->current();

			if ($result['price1'] && $result['price2']) {
				$rs['price'] = ($result['price1'] > $result['price2'] ? $result['price2'] : $result['price1']);
			} else {
				$rs['price'] = !empty($result['price1']) ? $result['price1'] : $result['price2'];
			}
			//$rs['price'] = ($result['price1'] > $result['price2'] && $result['price2'] ? $result['price2'] : $result['price1']);
			$rs['price'] = $rs['price'] > 0 ? $rs['price'] : 0;
		}
		//更新最低价
		if ($update_minprice) {
			DB::update('line')->set(array('price' => $rs['price'], 'price_date' => $day))->where('id', '=', $lineid)->execute();
		}
		self::update_sellprice($lineid);
		return Currency_Tool::price($rs['price']);
	}

	/**
	 * 线路属性
	 * @param $attrid
	 * @return array
	 */
	public static function line_attr($attrid) {
		if (empty($attrid)) {
			return;
		}
		$attrid = trim($attrid, ',');
		$attrid_arr = explode(',', $attrid);

		$arr = DB::select('attrname')->from('line_attr')->where('id', 'in', $attrid_arr)->and_where('pid', '!=', 0)->execute()->as_array();
		return $arr;
	}

	/**
	 * 线路详情
	 * @param $id
	 * @return array
	 */
	public static function detail($id) {
		$value_arr = array(':id' => $id, ':webid' => $GLOBALS['sys_webid']);
		$sql = "SELECT * FROM sline_line WHERE aid=:id and webid=:webid";
		$arr = DB::query(1, $sql)->parameters($value_arr)->execute()->as_array();
		return $arr[0];
	}

	/**
	 * @param $destid
	 * @param $row
	 * @param $offset
	 * @desc 按目的地获取线路
	 */

	public static function get_line_bymdd($destid, $row, $offset) {
		$destid = intval($destid);
		$sql = "SELECT a.* FROM `sline_line` AS a LEFT JOIN `sline_kindorderlist` b ON (a.id=b.aid and b.typeid=1 and b.classid='$destid') ";
		$sql .= "WHERE a.ishidden=0 AND FIND_IN_SET('{$destid}',a.kindlist) ";
		$sql .= "ORDER BY IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
		$sql .= "LIMIT {$offset},{$row}";
		$arr = DB::query(1, $sql)->execute()->as_array();
		return self::format_line_row($arr);
	}

	/**
	 * @param $list
	 * @return mixed
	 * @desc 格式化线路列
	 */
	public static function format_line_row($list) {
		foreach ($list as &$v) {

			$v['price'] = Model_Line::get_minprice($v['id'], $v);

			$v['sellprice'] = $v['storeprice'] = Currency_Tool::price($v['storeprice']);

			$v['attrlist'] = Model_Line::line_attr($v['attrid']);

			$v['url'] = Common::get_web_url($v['webid']) . "/lines/show_{$v['aid']}.html";

			$v['startcity'] = Model_Startplace::start_city($v['startcity']);

			$v['iconlist'] = Product::get_ico_list($v['iconlist']);
		}
		return $list;
	}

	/**
	 * 参数解析
	 * @param $params
	 */
	public static function search_result($params, $keyword, $currentpage, $pagesize = '10') {
		$destPy = $params['destpy'];
		$dayId = intval($params['dayid']);
		$priceId = intval($params['priceid']);
		$sortType = intval($params['sorttype']);
		$startcityId = intval($params['startcityid']);
		$attrId = $params['attrid'];
		$page = $currentpage;
		$page = $page ? $page : 1;

		$value_arr = array();
		$where = " WHERE a.ishidden=0 ";
		//按目的地搜索
		if ($destPy && $destPy != 'all') {
			$destId = DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id');
			//如果找不到则跳转404页面
			if (empty($destId)) {
				Common::head404();
			}
			$where .= " AND FIND_IN_SET('$destId',a.kindlist) ";
		}
		//天数
		if ($dayId) {
			$days = DB::select('word')->from('line_day')->where('word', '=', $dayId)->execute()->get('word', 0);
			if (empty($days)) {
				Common::head404();
			}

			if (self::is_last_day($days)) {
				$where .= " AND a.lineday>='$days'";
			} else {
				$where .= " AND a.lineday='$days'";
			}

		}
		//价格区间
		if ($priceId) {

			$priceArr = DB::select()->from('line_pricelist')->where('id', '=', $priceId)->execute()->current();
			if (empty($priceArr)) {
				Common::head404();
			}
			$where .= " AND a.price BETWEEN {$priceArr['lowerprice']} AND {$priceArr['highprice']} ";
		}
		//排序
		$orderBy = "";
		if (!empty($sortType)) {
			if ($sortType == 1) //价格升序
			{
				$orderBy = "  a.price ASC,";
			} else if ($sortType == 2) //价格降序
			{
				$orderBy = "  a.price DESC,";
			} else if ($sortType == 3) //销量降序
			{
				$orderBy = " a.bookcount DESC,";
			} else if ($sortType == 4) //推荐
			{
				$orderBy = " a.recommendnum DESC,";
			}
			/*  else if($sortType==5) //满意度
				              {
				                  $orderBy = " a.shownum desc,";
			*/
		}

		//出发城市
		if (!empty($startcityId)) {
			$city = Model_Startplace::start_city($startcityId);
			if (empty($city)) {
				Common::head404();
			}
			$where .= " AND a.startcity=$startcityId ";
		}
		//按属性
		if (!empty($attrId)) {
			//属性检测
			$attrid_arr = explode('_', $attrId);
			foreach ($attrid_arr as $atid) {
				$info = Model_Line_Attr::get_attr_info($atid);
				if (empty($info)) {
					Common::head404();
				}
			}
			$where .= Product::get_attr_where($attrId);
		}
		//按关键词
		if (!empty($keyword)) {
			$value_arr[':keyword'] = '%' . $keyword . '%';
			$where .= " AND a.title like :keyword ";
		}

		$offset = (intval($page) - 1) * $pagesize;

		$orderBy = empty($orderBy) ? " IFNULL(b.displayorder,9999) ASC, " : $orderBy;

		//如果选择了目的地
		if (!empty($destId)) {
			$sql = "SELECT a.* FROM `sline_line` a ";
			$sql .= "LEFT JOIN `sline_kindorderlist` b ";
			$sql .= "ON (a.id=b.aid AND b.typeid=1 AND b.classid=$destId)";
			$sql .= $where;
			$sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC, a.modtime DESC,a.addtime DESC ";
			//$sql.= "LIMIT {$offset},{$pagesize}";

		} else {
			$sql = "SELECT a.* FROM `sline_line` a ";
			$sql .= "LEFT JOIN `sline_allorderlist` b ";
			$sql .= "ON (a.id=b.aid AND b.typeid=1 AND a.webid=b.webid)";
			$sql .= $where;
			//$sql.= "ORDER BY IFNULL(b.displayorder,9999) ASC,{$orderBy}a.modtime DESC,a.addtime DESC ";
			$sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC, a.modtime DESC,a.addtime DESC ";
			//$sql.= "LIMIT {$offset},{$pagesize}";

		}

		//计算总数
		$totalSql = "SELECT count(*) as dd " . strchr($sql, " FROM");
		$totalSql = str_replace(strchr($totalSql, "ORDER BY"), '', $totalSql); //去掉order by

		$totalN = DB::query(1, $totalSql)->parameters($value_arr)->execute()->as_array();
		$totalNum = $totalN[0]['dd'] ? $totalN[0]['dd'] : 0;

		//数据量大时的优化方法,数据量小时不推荐使用此方法
		//$idWhere = "SELECT id FROM `sline_line` ORDER BY id limit $offset, 1";
		//$sql = str_replace("WHERE","WHERE a.id>($idWhere) AND",$sql);
		//$sql.= "LIMIT {$pagesize}";

		//检测页面数量是否超限
		$total_page = (int) ceil($totalNum / $pagesize);
		if (($total_page > 0 AND intval($page) > $total_page) OR ($total_page == 0 AND $page > 1)) {
			Common::head404();
		}

		$sql .= "LIMIT {$offset},{$pagesize}";

		$arr = DB::query(1, $sql)->parameters($value_arr)->execute()->as_array();
		foreach ($arr as &$v) {
			$v['price'] = Model_Line::get_minprice($v['id'], $v);
			$v['attrlist'] = Model_Line::line_attr($v['attrid']);
			$v['startcity'] = Model_Startplace::start_city($v['startcity']);
			$v['commentnum'] = Model_Comment::get_comment_num($v['id'], 1); //评论次数
			$v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], 1) + intval($v['bookcount']); //销售数量
			$v['url'] = Common::get_web_url($v['webid']) . "/lines/show_{$v['aid']}.html";
			$v['litpic'] = Common::img($v['litpic']);
			$v['iconlist'] = Product::get_ico_list($v['iconlist']);
			$v['startdate'] = Model_Line::get_startdate($v);
			$v['score'] = St_Functions::get_satisfy(self::$_typeid, $v['id'], $v['satisfyscore']);
			if (Model_Supplier::display_is_open() && $v['supplierlist']) {
				$v['suppliername'] = Arr::get(Model_Supplier::get_supplier_info($v['supplierlist'], array('suppliername')), 'suppliername');
			}

			//积分抵现所需积分
			if ($v['jifentprice_id']) {
				$jifentprice_info = Model_Jifen_Price::get_used_jifentprice($v['jifentprice_id'], self::$_typeid);
				if ($jifentprice_info['jifentprice']) {
					$v['jifentprice'] = $jifentprice_info['jifentprice'];
				}
			}

		}
		$out = array(
			'total' => $totalNum,
			'list' => $arr,
		);
		return $out;

	}

	/**
	 * 参数解析
	 * @param $params
	 */
	public static function search_result_mobile($params, $keyword, $pagesize = '10') {
		//参数处理
		$urlParam = $params;
		$destPy = 'all';
		$priceId = $sortType = $aa = $attrId = $startcityId = 0;
		$params = explode('-', str_replace('/', '-', $urlParam));
		$count = count($params);

		switch ($count) {
		//目的地
		case 1:
			list($destPy) = $params;
			break;
		//关键字、属性
		case 8:
			//$aa  原来用于搜索关键字处理，现在停用
			list($destPy, $dayId, $priceId, $sortType, $aa, $startcityId, $attrId, $page) = $params;
			break;
		}

		$dayId = intval($dayId);
		$sortType = intval($sortType);
		$startcityId = intval($startcityId);
		$page = intval($page);

		$where = ' WHERE a.ishidden=0 ';
		$param_values = array();
		//按目的地搜索
		if ($destPy && $destPy != 'all') {
			$destId = DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id');
			$where .= " AND FIND_IN_SET('$destId',a.kindlist) ";
		}
		//天数
		if ($dayId) {
			$days = DB::select('word')->from('line_day')->where('word', '=', $dayId)->execute()->get('word', 0);
			if (self::is_last_day($days)) {
				$where .= " AND a.lineday>='$days'";
			} else {
				$where .= " AND a.lineday='$days'";
			}
		}
		//价格区间
		if ($priceId) {
			$priceArr = DB::select()->from('line_pricelist')->where('id', '=', $priceId)->execute()->current();
			$where .= " AND a.price BETWEEN {$priceArr['lowerprice']} AND {$priceArr['highprice']} ";
		}
		//排序
		$orderBy = " IFNULL(b.displayorder,9999) ASC,";
		if (!empty($sortType)) {
			if ($sortType == 1) //特价排序
			{
				$orderBy = " a.price asc,";
			} else if ($sortType == 2) //价格
			{
				$orderBy = " a.price desc,";
			} else if ($sortType == 4) //推荐
			{
				$orderBy = " a.recommendnum desc,";
			} else if ($sortType == 3) //销量
			{
				$orderBy = " a.bookcount desc,";
			} else if ($sortType == 5) //满意度
			{
				$orderBy = " a.shownum desc,";
			}
		}

		//关键词
		if (!empty($keyword)) {
			if (preg_match('`([a-zA-Z])(\d{3,8})`', $keyword, $preg)) {
				$id = ltrim($preg[2], '0');
				$where .= " AND a.id=:id";
				$param_values[':id'] = $id;
			} else if (is_numeric($keyword)) {
				$result = St_Product::product_series($keyword, '', true);
				$where .= " AND a.id=:id";
				$param_values[':id'] = $result['id'];

			} else {
				$where .= " AND a.title like :keyword ";
				$param_values[':keyword'] = '%' . $keyword . '%';

			}

		}
		//按属性
		if (!empty($attrId)) {
			$where .= Product::get_attr_where($attrId);
		}
		if ($startcityId) {
			$where .= "AND a.startcity='{$startcityId}'";

		}
		$offset = (intval($page) - 1) * $pagesize;

		//如果选择了目的地
		if (!empty($destId)) {
			$sql = "SELECT a.* FROM `sline_line` a ";
			$sql .= "LEFT JOIN `sline_kindorderlist` b ";
			$sql .= "ON (a.id=b.aid AND b.typeid=1 AND b.classid=$destId)";
			$sql .= $where;
			$sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
			$sql .= "LIMIT {$offset},{$pagesize}";

		} else {
			$sql = "SELECT a.* FROM `sline_line` a ";
			$sql .= "LEFT JOIN `sline_allorderlist` b ";
			$sql .= "ON (a.id=b.aid AND b.typeid=1)";
			$sql .= $where;
			$sql .= "ORDER BY {$orderBy} IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC ";
			$sql .= "LIMIT {$offset},{$pagesize}";

		}
		$data = DB::query(1, $sql)->parameters($param_values)->execute()->as_array();
		foreach ($data as &$v) {
			$v['price'] = Model_Line::get_minprice($v['id'], array('info' => $v));
			$v['attrlist'] = Model_Line::line_attr($v['attrid']);
			$v['startcity'] = Model_Startplace::start_city($v['startcity']);
			$v['commentnum'] = Model_Comment::get_comment_num($v['id'], 1); //评论次数
			$v['satisfyscore'] = St_Functions::get_satisfy(self::$_typeid, $v['id'], $v['satisfyscore']); //满意度
			$v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], 1) + intval($v['bookcount']); //销售数量
			$v['url'] = Common::get_web_url($v['webid']) . "/lines/show_{$v['aid']}.html";
			$v['iconlist'] = Product::get_ico_list($v['iconlist']);
			$v['cfg_icon_rule'] = $GLOBALS['cfg_icon_rule'];
			$v['litpic'] = Common::img($v['litpic'], 220, 150);
		}
		return Product::list_search_format($data, $page);
	}

	/**
	 * @param $lineid
	 * @return bool
	 * 线路提前天数是否开启.
	 */
	public static function is_line_before($lineid) {

		if (empty($lineid)) {
			return false;
		}

		$islinebefore = DB::select('islinebefore')->from('line')->where('id', '=', $lineid)->execute()->get('islinebefore'); //ORM::factory('line', $lineid)->get('islinebefore');
		if ($islinebefore == 1) {
			return true;
		}

		return false;
	}

	/**
	 * @return mixed
	 * @desc:获取套餐报价
	 */
	public static function get_suit_price($suitid) {
		$time = strtotime(date('Y-m-d'));
		$sql = "SELECT * FROM `sline_line_suit_price` WHERE suitid='$suitid' and day >='$time' and (adultprice>0 or childprice>0 or oldprice>0) and `number`!=0 order by day asc";
		$arr = DB::query(1, $sql)->execute()->as_array();

		foreach ($arr as &$v) {
			$v['childprofit'] = Currency_Tool::price(floatval($v['childprofit']));
			$v['childbasicprice'] = Currency_Tool::price(floatval($v['childbasicprice']));
			$v['childprice'] = Currency_Tool::price(floatval($v['childprice']));
			$v['oldprofit'] = Currency_Tool::price(floatval($v['oldprofit']));
			$v['oldbasicprice'] = Currency_Tool::price(floatval($v['oldbasicprice']));
			$v['oldprice'] = Currency_Tool::price(floatval($v['oldprice']));
			$v['adultprofit'] = Currency_Tool::price(floatval($v['adultprofit']));
			$v['adultbasicprice'] = Currency_Tool::price(floatval($v['adultbasicprice']));
			$v['adultprice'] = Currency_Tool::price(floatval($v['adultprice']));
			$v['roombalance'] = Currency_Tool::price(floatval($v['roombalance']));

		}
		return $arr;
	}

	//新增线路处理函数

	//处理出发日期列表和出发日期下拉选择

	public static function get_startdate($row) {
		$today = time();
		$montharr = self::get_month_price_list($row['id'], $row);
		$monthstr = '';
		$curday = (int) date('d', $today);
		if (empty($montharr)) {

			$monthstr = empty($row['linedate']) ? '电询' : $row['linedate'];
		} else {
			foreach ($montharr as $key => $value) {
				$monthstr .= $key . '、';
				//$weekday = date('w', strtotime(date('Y', $today) . '-' . $key));
			}
			if (!empty($monthstr)) {
				$monthstr = trim($monthstr, '、');
				$monthstr .= '日';
			}

		}
		return $monthstr;
	}

	//获取最近报价

	public static function get_month_price_list($lineid, $line_info = null) {
		$time = strtotime(date('Y-m-d', time()));
		if (!is_null($line_info['linebefore']) && $line_info['linebefore']) {
			$time = strtotime(date('Y-m-d', strtotime("+{$line_info['linebefore']} days")));
		}
		$lineid = intval($lineid);
		//$sql = "SELECT * FROM `sline_line_suit_price` WHERE lineid='$lineid' AND `day`>{$time} ORDER BY `day` ASC limit 0,6";
		$sql = "SELECT a.* FROM sline_line_suit_price a INNER JOIN (SELECT `day`,min(adultprice) adultprice FROM sline_line_suit_price WHERE lineid='{$lineid}' AND `day`>={$time} GROUP BY `day` ) b ON a.day = b.day AND a.adultprice = b.adultprice AND lineid='{$lineid}' ORDER BY a.day limit 0,6";
		$arr = DB::query(1, $sql)->execute()->as_array();
		$monthprice = array();
		foreach ($arr as $row) {
			$key = date('m-d', $row['day']);
			$row['adultprice'] = Currency_Tool::price($row['adultprice']);
			$monthprice[$key] = $row['adultprice'];

		}
		return $monthprice;
	}

	/*
		     * 生成searh页地址
	*/
	public static function get_search_url($v, $paramname, $p, $currentpage = 1) {

		$url = $GLOBALS['cfg_basehost'] . '/lines/';

		$url_arr = array(
			'destpy' => $p['destpy'],
			'dayid' => $p['dayid'],
			'priceid' => $p['priceid'],
			'sorttype' => $p['sorttype'],
			'displaytype' => $p['displaytype'],
			'startcityid' => $p['startcityid'],
			'attrid' => $p['attrid'],
		);
		if ($paramname == 'attrid') {
			$orignalArr = Product::get_attr_parent($p['attrid'], 1);
			$nowArr = Product::get_attr_parent($v, 1);
			if (!empty($nowArr)) {
				$attrArr = $nowArr + $orignalArr;
				sort($attrArr);
				$attr_list = join('_', $attrArr);
			} else {
				$attr_list = 0;
			}
			$url_arr['attrid'] = $attr_list;
		} else {
			$url_arr[$paramname] = $v;
		}
		if (empty($url_arr['dayid']) && empty($url_arr['priceid']) && empty($url_arr['sorttype']) && empty($url_arr['displaytype']) && empty($url_arr['startcityid']) && empty($url_arr['attrid'])) {
			$url .= $url_arr['destpy'] . '/';
		} else {
			$url .= $url_arr['destpy'] . '-' . $url_arr['dayid'] . '-' . $url_arr['priceid'] . '-' . $url_arr['sorttype'] . '-';
			$url .= $url_arr['displaytype'] . '-' . $url_arr['startcityid'] . '-' . $url_arr['attrid'] . '-' . $currentpage;

		}
		return $url;
	}

	/**
	 * @param $p
	 * @return array
	 * @desc 已选择项处理
	 */
	public static function get_selected_item($p) {
		$out = array();
		//目的地
		if ($p['destpy'] != 'all') {
			$temp = array();
			$url = self::get_search_url('all', 'destpy', $p);
			$temp['url'] = $url;
			$dest = DB::select()->from('destinations')->where('pinyin', '=', $p['destpy'])->execute()->current();
			$temp['itemname'] = $dest['kindname'];
			$out[] = $temp;
		}
		//天数
		if ($p['dayid'] != 0) {
			$temp = array();
			$url = self::get_search_url('0', 'dayid', $p);
			$temp['url'] = $url;
			$temp['itemname'] = self::get_day_list_title($p['dayid']);
			$out[] = $temp;

		}
		//价格
		if ($p['priceid'] != 0) {
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
		if ($p['startcityid'] != 0) {
			$temp = array();
			$url = self::get_search_url('0', 'startcityid', $p);
			$temp['url'] = $url;
			$temp['itemname'] = DB::select('cityname')->from('startplace')->where('id', '=', $p['startcityid'])->execute()->get('cityname');
			$out[] = $temp;

		}
		//属性
		if ($p['attrid'] != 0) {

			$attArr = $orgArr = explode('_', $p['attrid']);
			foreach ($attArr as $ar) {

				$orgArr = $attArr;
				$temp = array();
				$temp['itemname'] = DB::select('attrname')->from('line_attr')->where('id', '=', $ar)->execute()->get('attrname'); //ORM::factory('line_attr', $ar)->get('attrname');
				unset($orgArr[array_search($ar, $orgArr)]);
				if (!empty($orgArr)) {
					$attrid = implode('_', $orgArr);
				} else {
					$attrid = 0;
				}
				$url = $GLOBALS['cfg_basehost'] . '/lines/';
				if (empty($p['dayid']) && empty($p['priceid']) && empty($p['sorttype']) && empty($p['displaytype']) && empty($p['startcityid']) && empty($attrid)) {
					$url .= $p['destpy'] . '/';
				} else {
					$url .= $p['destpy'] . '-' . $p['dayid'] . '-' . $p['priceid'] . '-' . $p['sorttype'] . '-';
					$url .= $p['displaytype'] . '-' . $p['startcityid'] . '-' . $attrid . '-1';
				}
				$temp['url'] = $url;
				$out[] = $temp;
			}

		}
		return $out;

	}

	/*
		     * 价格格式化
	*/
	public static function get_price_list_title($lowerprice, $highprice) {
		if ($lowerprice != '' && $highprice != '') {
			$title = '&yen;' . $lowerprice . '元-' . '&yen;' . $highprice . '元';
		} else if ($lowerprice == '') {
			$title = '&yen;' . $highprice . '元以下';
		} else if ($highprice == '') {
			$title = '&yen;' . $lowerprice . '元以上';
		}
		return $title;
	}

	/*
		     * 出游天数格式化
	*/
	public static function get_day_list_title($day) {
		$title = Product::to_upper($day);

		$suit = ORM::factory('line_day')->get_all();

		if ($day < count($suit)) {
			$title .= '日游';
		} else {
			$title .= '日游以上';
		}

		return $title;
	}

	/*
		    * 生成优化标题
	*/
	public static function gen_seotitle($param) {
		$main_items = array();
		$normal_items = array();

		if (!empty($param['p'])) {
			$p = intval($param['p']);
			if ($p > 1) {
				$main_items[] = '第' . $p . '页';
			}
		}
		if (!empty($param['destpy'])) {
			$destInfo = Model_Destinations::search_seo($param['destpy'], 1);
			$normal_items[] = $destInfo['seotitle'];
		}
		if (!empty($param['keyword'])) {
			$normal_items[] = '关于' . $param['keyword'] . '的搜索结果';
		}
		if (!empty($param['startcityid'])) {
			$normal_items[] = Model_Startplace::start_city($param['startcityid']) . "出发";

		}
		if (!empty($param['dayid'])) {
			$normal_items[] = $param['dayid'] . "日游";
		}

		if (!empty($param['priceid'])) {

			$price_info = DB::select()->from('line_pricelist')->where('id', '=', $param['priceid'])->execute()->current();

			$normal_items[] = "价格区间{$price_info['lowerprice']}-{$price_info['highprice']}";
		}
		if (!empty($param['attrid'])) {
			$normal_items[] = Model_Line_Attr::get_attrname_list($param['attrid'], '|');

		}
		$normal_items_str = implode('|', $normal_items);
		if (!empty($normal_items_str)) {
			$main_items[] = $normal_items_str;
		}

		/* if (!empty($param['channel_name']))
			        {
			            $main_items[] = $param['channel_name'];
		*/
		$main_items[] = $GLOBALS['cfg_webname'];

		$main_items_str = implode('-', $main_items);
		return $main_items_str;
	}

	/**
	 * @param $destpy
	 * @return array
	 */
	public static function search_seo_mobile($destpy) {
		if (!empty($destpy) && $destpy != 'all') {

			$destinfo = DB::select('id', 'kindname')->from('destinations')->where('pinyin', '=', $destpy)->and_where('isopen', '=', 1)->execute()->current();
			//$info = ORM::factory('destinations', $destId)->as_array();
			$info = DB::select('seotitle')->from('line_kindlist')->where('kindid', '=', $destinfo['id'])->execute()->current();
			$seotitle = $info['seotitle'] ? $info['seotitle'] : $destinfo['kindname'];
		} else {
			$info = Model_Nav::get_channel_info_mobile(1);
			$seotitle = $info['seotitle'] ? $info['seotitle'] : $info['m_title'];
		}

		return array('seotitle' => $seotitle);
	}

	/**
	 * @param $ids
	 * @param $day
	 * @return mixed
	 * @desc 获取线路保险
	 */
	public static function get_insurances($ids, $day) {

		$sql = "SELECT * FROM `sline_insurance` WHERE FIND_IN_SET(id,'$ids')";
		$arr = DB::query(1, $sql)->execute()->as_array();
		foreach ($arr as &$v) {
			$productArr = unserialize($v['content']);
			$desc = $productArr['ProductDetailsResponse']['ProductDetails']['Product']['ShortDescription']
				. $productArr['ProductDetailsResponse']['ProductDetails']['Product']['FullDescription'][0];
			$v['description'] = $desc;
			$v['day'] = $day;

		}
		return $arr;
	}

	/**
	 * @param $lineday
	 * 检测是否是最后一天
	 */
	public static function is_last_day($lineday) {

		$row = DB::select()->from('line_day')->where('word', '>', $lineday)->limit(1)->execute()->current();
		return $row['word'] > 0 ? 0 : 1;
	}

	//获取当前选择的线路目的地优化信息
	public static function get_dest_info($destid) {
		$destid = intval($destid);
		$file = SLINEDATA . "/autotitle.cache.inc.php"; //载入智能title配置
		if (file_exists($file)) {
			require_once $file;
		}
		$arr = array();
		if ($destid) {

			$sql = "SELECT a.kindname,b.seotitle,b.jieshao,b.keyword,b.tagword,b.description,a.pinyin FROM `sline_destinations` as a left join `sline_line_kindlist` AS b ON a.id=b.kindid WHERE a.id = $destid ";
		}
		$row = DB::query(1, $sql)->execute()->current();

		$cfg_line_title = str_replace('XXX', $row['kindname'], $cfg_line_title);
		$cfg_line_desc = str_replace('XXX', $row['kindname'], $cfg_line_desc);
		if (empty($row['seotitle'])) {

			$arr['seotitle'] = empty($cfg_line_title) ? $row['kindname'] : $cfg_line_title;
		} else {
			$arr['seotitle'] = $row['seotitle'];

		}
		if (empty($row['description'])) {
			$arr['description'] = empty($cfg_line_desc) ? $row['description'] : $cfg_line_desc;
		} else {
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

	//获取线路套餐日历最近30天报价
	public static function get_suit_date_list($lineid, $suitid) {
		$time = strtotime(date('Y-m-d'));
		//线路提前预定

		$info = DB::select('islinebefore', 'linebefore')->from('line')->where('id', '=', $lineid)->execute()->current();
		$ext['islinebefore'] = $info['islinebefore'];
		$ext['linebefore'] = $info['linebefore'];

		if ($ext['islinebefore'] > 0 && $ext['linebefore'] > 0) {
			$time = strtotime("+{$ext['linebefore']} days", $time);
		}
		$sql = "SELECT adultprice,childprice,oldprice,`day`,propgroup,`number`,`roombalance` FROM `sline_line_suit_price` ";
		$sql .= "WHERE lineid=':lineid' AND suitid=':suitid' AND day>=$time AND (number>0 or number=-1) AND(adultprice>0 or childprice>0 or oldprice>0) ORDER BY day ASC LIMIT 30";
		$arr = DB::query(1, $sql)
			->parameters(
				array(
					':lineid' => $lineid,
					':suitid' => $suitid,
				)
			)
			->execute()
			->as_array();
		foreach ($arr as &$row) {
			$propgroup_arr = explode(',', $row['propgroup']);
			$row['adultprice'] = in_array(2, $propgroup_arr) ? Currency_Tool::price($row['adultprice']) : 0;
			$row['childprice'] = in_array(1, $propgroup_arr) ? Currency_Tool::price($row['childprice']) : 0;
			$row['oldprice'] = in_array(3, $propgroup_arr) ? Currency_Tool::price($row['oldprice']) : 0;
			$row['shortdate'] = date('m-d', $row['day']);
			$row['weekday'] = '周' . self::get_cn_week(date('w', $row['day'])); //星期
			$row['useday'] = date('Y-m-d', $row['day']);

		}
		return $arr;

	}

	public static function get_cn_week($num) {
		$arr = array('日', '一', '二', '三', '四', '五', '六');
		return $arr[(int) $num];
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
	public static function check_storage($productid, $dingnum, $suitid = '', $usedate = '', $enddate = '', $extraparam = '') {
		if (empty($suitid) || empty($usedate)) {
			return false;
		}

		$day = strtotime($usedate);
		$query = DB::select('number', 'suitid')->from('line_suit_price')
			->and_where('suitid', '=', $suitid)
			->and_where('day', '=', $day);
		$row = $query->execute()->current();
		$status = true;
		if (empty($row) || empty($row['suitid'])) {
			$status = false;
		} else if ($row['number'] != '-1' && intval($row['number']) < intval($dingnum)) {
			$status = false;
		}
		return $status;
	}

	/**
	 * @function 库存操作函数,当$dingnum为正数是为加库存,当$dingnum为负数时为减库存
	 * @param $suitid
	 * @param $dingnum
	 * @param $day
	 * @return bool|object
	 */
	public static function storage($suitid, $dingnum, $order_arr) {
		$day = strtotime($order_arr['usedate']);
		$org_number = DB::select('number')->from('line_suit_price')
			->where('day', '=', $day)
			->and_where('suitid', '=', $suitid)
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
			'number' => DB::expr("number + $dingnum"),
		);
		$query = DB::update('line_suit_price')
			->set($update_arr)
			->where('suitid', '=', $suitid)
			->and_where('number', '<>', -1)
			->and_where('day', '=', $day);

		return $query->execute();

	}

	/**
	 * @function 提取景点
	 * @param $content
	 * @param $lineid
	 * @param $day
	 * @return array
	 */
	public function auto_get_spot($content, $lineid, $day) {

		$arr = DB::query(Database::SELECT, "select * from sline_spot where (litpic!='' or piclist!='') and ishidden=0")->execute()->as_array();
		$keysarrs = $picsarr = $idsarr = $orderarr = array();
		foreach ($arr as $row) {
			array_push($keysarrs, $row['shortname']);
			array_push($picsarr, $row['litpic']);
			array_push($idsarr, $row['id']);
			array_push($orderarr, $row['displayorder']);
		}
		$k = 0;
		$num = count($keysarrs);
		$out = array();

		for ($i = 0; $i < $num; $i++) {
			if (Common::checkStr($content, trim($keysarrs[$i]))) //如果找到
			{
				$litpic = empty($picsarr[$i]) ? Common::getDefaultImage() : $picsarr[$i];
				$spotid = $idsarr[$i];
				$spotname = $keysarrs[$i];
				$autoid = $this->insert_day_spot($lineid, $spotname, $litpic, $day, $spotid);
				if ($autoid) {
					$out[] = array('title' => $spotname, 'spotid' => $spotid, 'autoid' => $autoid);
				}

			}
			$k++;
		}

		return $out;
	}

	/**
	 * @function 插入景点到线路途经景点库
	 * @param $lineid
	 * @param $spotname
	 * @param $litpic
	 * @param $day
	 * @param $spotid
	 * @return int
	 */
	private function insert_day_spot($lineid, $spotname, $litpic, $day, $spotid) {
		$sql = "select count(*) as num from sline_line_dayspot where lineid='$lineid' and title='$spotname' and day=$day";

		$row = $this->query($sql, 1);
		$flag = 0;
		if ($row[0]['num'] == 0) {
			$sql = "insert into sline_line_dayspot(lineid,title,spotid,litpic,day) values('$lineid','$spotname','$spotid','$litpic','$day')";
			$ar = $this->query($sql, Database::INSERT);
			if ($ar[0] > 0) {
				$flag = $ar[0];
			}

		}
		return $flag;
	}

	//删除提取景点
	public function del_day_spot($autoid) {
		$sql = "delete from sline_line_dayspot where id= '$autoid'";
		$flag = DB::query(Database::DELETE, $sql)->execute();
		return $flag;
	}

	/**
	 * @function 获取行程景点
	 * @param $day
	 * @param $lineid
	 * @return string
	 */
	public static function get_day_spot_html($day, $lineid) {
		$sql = "select * from sline_line_dayspot where lineid='$lineid' and day='$day'";
		$arr = DB::query(1, $sql)->execute();
		$out = '';
		foreach ($arr as $row) {
			$out .= '<span><s onclick="delDaySpot(this,\'' . $row['id'] . '\')"></s>' . $row['title'] . '</span>';
		}
		return $out;
	}

	/**
	 * @function 克隆线路
	 * @param $id
	 * @param $num
	 * @return mixed
	 */
	public function clone_line($id, $num) {
		$arr = $this->where("id=$id")->find()->as_array();
		unset($arr['id']); //去除id项.
		unset($arr['starttime']);
		unset($arr['endtime']);
		unset($arr['linephone']);
		unset($arr['istejia']);
		unset($arr['ssmalprovince']);
		unset($arr['ssmalcity']);
		unset($arr['ssmalarea']);
		unset($arr['price_date']);
		for ($i = 1; $i <= $num; $i++) {
			$newaid = Common::getLastAid('sline_line', 0); //新线路aid
			$arr['aid'] = $newaid;
			$arr['addtime'] = $arr['modtime'] = time();
			$arr['webid'] = 0;
			$arr['lineicon'] = '0';
			$arr['ishidden'] = 1;
			$arr['status'] = 2;
			$sql = "INSERT INTO sline_line (";
			$sql2 = "VALUES ( ";
			$sql_key = '';
			$sql_value = '';
			foreach ($arr as $key => $value) {
				if (!empty($value) || $key == 'webid') {
					$sql_key .= "`" . $key . "`,";
					$sql_value .= "'" . addslashes($value) . "',";
				}
			}
			$sql_key = substr($sql_key, 0, -1) . ")";
			$sql_value = substr($sql_value, 0, -1) . ")";
			$sql = $sql . $sql_key . $sql2 . $sql_value . ";";
			$ar = $this->query($sql, 2);
			$new_line_id = $ar[0]; //新插入id
			$this->clone_jieshao($id, $new_line_id);
			$this->clone_extend_info($id, $new_line_id);
		}
		return $new_line_id;
	}

	//路径检查，如果不存在则创建
	private function cloneCreateDir($url) {

		if (!file_exists($url)) {
			mkdir($url);
		}

	}

	/*
		     * 克隆新版行程内容
	*/
	private function clone_jieshao($oldlineid, $newlineid) {
		$sql = "select * from sline_line_jieshao where lineid='$oldlineid'";
		$arr = $this->query($sql, 1);
		$intArr = array('breakfirsthas', 'supperhas', 'lunchhas');
		foreach ($arr as $row) {
			unset($row['id']);
			$row['lineid'] = $newlineid;
			$sql = "INSERT INTO sline_line_jieshao (";
			$sql2 = "VALUES ( ";
			$sql_key = '';
			$sql_value = '';
			foreach ($row as $key => $value) {
				if (in_array($key, $intArr)) {
					$value = empty($value) ? 0 : $value;
				}
				$sql_key .= "`" . $key . "`,";
				$sql_value .= "'" . addslashes($value) . "',";
			}
			$sql_key = substr($sql_key, 0, -1) . ")";
			$sql_value = substr($sql_value, 0, -1) . ")";
			$sql = $sql . $sql_key . $sql2 . $sql_value . ";";
			$this->query($sql, 2);
		}

	}

	/**
	 * @function 更新线路最低报价
	 * @param $lineid
	 */
	public static function update_min_price($lineid) {
		$day = strtotime(date('Y-m-d'));
		//最低价规则
		$cfg_line_minprice_rule = Model_Sysconfig::get_configs(0, 'cfg_line_minprice_rule', true);
		//提前预定
		$info = DB::select('islinebefore', 'linebefore')->from('line')->where('id', '=', $lineid)->execute()->current();
		if ($info['islinebefore'] > 0 && $info['linebefore'] > 0) {
			$day = strtotime("+{$info['linebefore']} days", $day);
		}

		$sql = "SELECT MIN(`adultprice`) as price FROM sline_line_suit_price WHERE `lineid`={$lineid} and `adultprice`>=0 and day>={$day} and `number`!=0 and find_in_set(2,propgroup)";
		$condition = array('childprice', 'oldprice');
		switch ($cfg_line_minprice_rule) {
		//儿童
		case 1:
			$sql = "SELECT MIN(`childprice`) as price FROM sline_line_suit_price WHERE `lineid`={$lineid} and `childprice`>=0 and `day`>={$day} and `number`!=0 and find_in_set(1,propgroup)";
			$condition = array('adultprice', 'oldprice');
			break;
		//成人
		case 2:
			$sql = "SELECT MIN(`adultprice`) as price FROM sline_line_suit_price WHERE `lineid`={$lineid} and `adultprice`>=0 and day>={$day} and `number`!=0 and find_in_set(2,propgroup)";
			$condition = array('childprice', 'oldprice');
			break;
		//老人
		case 3:
			$sql = "SELECT MIN(`oldprice`) as price FROM sline_line_suit_price WHERE `lineid`={$lineid} and `oldprice`>=0 and day>={$day} and `number`!=0 and find_in_set(3,propgroup)";
			$condition = array('adultprice', 'childprice');
			break;
		}

		$rs = DB::query(1, $sql)->execute()->current();
		if (!$rs['price']) {
			$sql = "select * from ((SELECT MIN({$condition[0]}) as price1 FROM sline_line_suit_price WHERE `lineid`={$lineid} and {$condition[0]}>0 and `day`>={$day} and `number`!=0) as temp1,(SELECT MIN({$condition[1]}) as price2 FROM sline_line_suit_price WHERE `lineid`={$lineid} and {$condition[1]}>0 and `day`>={$day} and `number`!=0) as temp2)";
			$result = DB::query(1, $sql)->execute()->current();
			$rs['price'] = ($result['price1'] > $result['price2'] && $result['price2'] ? $result['price2'] : $result['price1']);
		}
		//更新最低价

		DB::update('line')->set(array('price' => $rs['price'], 'price_date' => strtotime(date('Y-m-d'))))->where('id', '=', $lineid)->execute();

		self::update_sellprice($lineid);
	}

	/**
	 * @function 更新线路显示原价
	 */
	public static function update_sellprice($lineid) {
		$sellprice = DB::select(DB::expr('max(sellprice) as sellprice'))->from('line_suit')
			->where('lineid', '=', $lineid)->execute()->get('sellprice');
		DB::update('line')->set(array('storeprice' => $sellprice))->where('id', '=', $lineid)->execute();

	}

	public function clone_extend_info($id, $new_line_id) {
		$extend_info = DB::select()->from('line_extend_field')->where('productid', '=', $id)->execute()->current();
		if (empty($extend_info)) {
			return true;
		}

		unset($extend_info['id']);
		$extend_info['productid'] = $new_line_id;
		$model = ORM::factory('line_extend_field');
		foreach ($extend_info as $k => $v) {
			$model->$k = $v;
		}
		$model->save();
		return $model->saved();
	}

	//获取某月的报价表
	public static function get_month_price($year, $month, $suitid, $startdate) {
		$start = !empty($startdate) ? strtotime($startdate) : strtotime("$year-$month-1");
		$end = strtotime("$year-$month-31");
		$arr = DB::select()->from('line_suit_price')
			->where("suitid=$suitid")
			->and_where('day', '>=', $start)
			->and_where('day', '<=', $end)
			->and_where('number', '!=', 0)
			->execute()->as_array();

		$price = array();
		foreach ($arr as $row) {
			if ($row) {
				$day = $row['day'];
				$price[$day]['date'] = Common::mydate('Y-m-d', $row['day']);
				$price[$day]['basicprice'] = isset($row['adultbasicprice']) ? $row['adultbasicprice'] : $row['basicprice'];
				$price[$day]['basicprice'] = Currency_Tool::price($price[$day]['basicprice']);

				$price[$day]['profit'] = isset($row['adultprofit']) ? floatval($row['adultprofit']) : $row['profit'];
				$price[$day]['profit'] = Currency_Tool::price($price[$day]['profit']);

				$price[$day]['price'] = isset($row['adultprice']) ? floatval($row['adultprice']) : floatval($row['price']);
				$price[$day]['price'] = Currency_Tool::price($price[$day]['price']);

				$price[$day]['child_basicprice'] = isset($row['childbasicprice']) ? floatval($row['childbasicprice']) : 0;
				$price[$day]['child_basicprice'] = Currency_Tool::price($price[$day]['child_basicprice']);

				$price[$day]['child_profit'] = isset($row['childprofit']) ? floatval($row['childprofit']) : 0;
				$price[$day]['child_profit'] = Currency_Tool::price($price[$day]['child_profit']);

				$price[$day]['child_price'] = isset($row['childprice']) ? floatval($row['childprice']) : 0;
				$price[$day]['child_price'] = Currency_Tool::price($price[$day]['child_price']);

				$price[$day]['old_basicprice'] = isset($row['oldbasicprice']) ? floatval($row['oldbasicprice']) : 0;
				$price[$day]['old_basicprice'] = Currency_Tool::price($price[$day]['old_basicprice']);

				$price[$day]['old_profit'] = isset($row['oldprofit']) ? floatval($row['oldprofit']) : 0;
				$price[$day]['old_profit'] = Currency_Tool::price($price[$day]['old_profit']);

				$price[$day]['old_price'] = isset($row['oldprice']) ? floatval($row['oldprice']) : 0;
				$price[$day]['old_profit'] = Currency_Tool::price($price[$day]['old_profit']);

				$price[$day]['roombalance'] = Currency_Tool::price($row['roombalance']);

				$price[$day]['suitid'] = $suitid;
				$price[$day]['number'] = $row['number']; //库存
				$price[$day]['description'] = $row['description']; //描述
			}
		}
		return $price;
	}

	/**
	 * @function 获取线路可用模板列表
	 * @param $page
	 */
	public static function get_template_list($page, $webid) {
		if ($webid) {
			$pclist = Model_Templet::get_templet_list_by_page('sub_site', $page, $webid);
		} else {
			$pclist = Model_Templet::get_templet_list_by_page('pc', $page, $webid);
		}
		$waplist = Model_Templet::get_templet_list_by_page('wap', $page, 0);
		return array('pclist' => array_reverse($pclist), 'waplist' => array_reverse($waplist));
	}

	/**
	 * @function 获取产品详情的模板
	 * @param $info
	 * @param bool $wap
	 */
	public static function get_product_template($info, $wap = false) {
		$template = false;
		if (!$wap && $info['templet']) {
			$template = 'usertpl/' . $info['templet'] . '/index';
			if (!file_exists(rtrim(BASEPATH, DIRECTORY_SEPARATOR) . '/' . $template . EXT)) {
				return false;
			}
		} elseif ($wap && $info['wap_templet']) {
			$template = 'usertpl/' . $info['wap_templet'] . '/index';
			if (!file_exists(rtrim(BASEPATH, DIRECTORY_SEPARATOR) . '/phone/' . $template . EXT)) {
				return false;
			}
		}
		return $template;

	}

}