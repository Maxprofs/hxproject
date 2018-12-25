<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Line
 * 线路控制器
 */
class Controller_Pc_Line extends Stourweb_Controller {
	private $_typeid = 1;
	private $_cache_key = '';
	private $channelname;

	public function before() {
		parent::before();

		//检查缓存
		$this->_cache_key = Common::get_current_url();
		$html = Common::cache('get', $this->_cache_key);
		$genpage = intval(Arr::get($_GET, 'genpage'));
		if (!empty($html) && empty($genpage)) {
			echo $html;
			exit;
		}
		$this->channelname = Model_Nav::get_channel_name(1);
		$this->assign('typeid', $this->_typeid);
		$this->assign('channelname', $this->channelname);
	}

	/**
	 * 线路首页
	 */
	public function action_index() {

		$seoinfo = Model_Nav::get_channel_seo($this->_typeid);
		$this->assign('seoinfo', $seoinfo);
		//首页模板
		$templet = Product::get_use_templet('line_index');
		$templet = $templet ? $templet : 'line/index';
		$this->display($templet);
		//缓存内容
		$content = $this->response->body();
		Common::cache('set', $this->_cache_key, $content);
	}

	/*
		     * 线路搜索页
	*/
	public function action_list() {

		$req_uri = $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$is_all = false;
		if (Common::get_web_url(0) . '/lines/all' == $req_uri || Common::get_web_url(0) . '/lines/all/' == $req_uri) {
			$is_all = true;
		}
		//参数值获取
		$destPy = $this->request->param('destpy');
		$sign = $this->request->param('sign');
		$dayId = intval($this->request->param('dayid'));
		$priceId = intval($this->request->param('priceid'));
		$sortType = intval($this->request->param('sorttype'));
		$displayType = intval($this->request->param('displaytype'));
		$startcityId = intval($this->request->param('startcityid'));
		$attrId = $this->request->param('attrid');
		$p = intval($this->request->param('p'));
		$attrId = !empty($attrId) ? $attrId : 0;
		$destPy = $destPy ? $destPy : 'all';
		$keyword = Common::remove_xss(Arr::get($_GET, 'keyword'));
		$keyword = strip_tags($keyword);
		$keyword = St_String::filter_mark($keyword);

		$pagesize = 12;
		$channel_info = Model_Nav::get_channel_info($this->_typeid);
		$channel_name = empty($channel_info['seotitle']) ? $channel_info['shortname'] : $channel_info['seotitle'];
		$route_array = array(
			'controller' => $this->request->controller(),
			'action' => $this->request->action(),
			'destpy' => $destPy,
			'dayid' => $dayId,
			'priceid' => $priceId,
			'sorttype' => $sortType,
			'displaytype' => $displayType,
			'startcityid' => $startcityId,
			'attrid' => $attrId,
			'p' => $p,
			'channel_name' => $channel_name,
		);

		$out = Model_Line::search_result($route_array, $keyword, $p, $pagesize);
		$pager = Pagination::factory(
			array(
				'current_page' => array('source' => 'route', 'key' => 'p'),
				'view' => 'default/pagination/search',
				'total_items' => $out['total'],
				'items_per_page' => $pagesize,
				'first_page_in_url' => false,
			)
		);
		//配置访问地址 当前控制器方法
		$pager->route_params($route_array);
		$destId = $destPy == 'all' ? 0 : DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id');
		$destId = $destId ? $destId : 0;
		Common::check_is_sub_web($destId, 'lines/' . $destPy);
		//目的地信息
		$destInfo = array();
		if ($destId) {
			$destInfo = Model_Line::get_dest_info($destId);
		}
		$search_title = Model_Line::gen_seotitle($route_array);
		$chooseitem = Model_Line::get_selected_item($route_array);
		$tagword = Model_Line_Kindlist::get_list_tag_word($destPy);
		$this->assign('tagword', $tagword);
		$this->assign('destid', $destId);
		$this->assign('destinfo', $destInfo);
		$this->assign('searchtitle', $search_title);
		$this->assign('list', $out['list']);
		$this->assign('chooseitem', $chooseitem);
		$this->assign('param', $route_array);
		$this->assign('currentpage', $p);
		$this->assign('pageinfo', $pager);
		$this->assign('is_all', $is_all);

		$templet = St_Functions::get_list_dest_template_pc($this->_typeid, $destId);
		$templet = empty($templet) ? Product::get_use_templet('line_list') : $templet;
		$templet = $templet ? $templet : 'line/list';
		$this->display($templet);
		//缓存内容
		$content = $this->response->body();
		Common::cache('set', $this->_cache_key, $content);

	}

	/*
		  * 线路预订
	*/
	public function action_book() {

		//会员信息
		$userInfo = Product::get_login_user_info();
		//要求预订前必须登陆
		if (!empty($GLOBALS['cfg_login_order']) && empty($userInfo['mid'])) {
			$this->request->redirect(Common::get_main_host() . '/member/login/?redirecturl=' . urlencode(Common::get_current_url()));
		}
		$productId = intval(Arr::get($_GET, 'lineid'));
		$suitId = intval(Arr::get($_GET, 'suitid'));
		//如果参数为空,则返回上级页面
		if (empty($productId) || empty($suitId)) {
			$this->request->redirect($this->request->referrer());
		}
		//预订日期
		$useDate = Arr::get($_GET, 'usedate');
		//套餐信息
		$suitInfo = Model_Line_Suit::suit_info($suitId);
		//产品信息
		$info = ORM::factory('line', $productId)->as_array();

		$info['url'] = Common::get_web_url($info['webid']) . "/lines/show_{$info['aid']}.html";
		//套餐按出发日期价格
		$suitPrice = Model_Line_Suit::suit_price($suitId, $useDate);
		//保险信息
		//$insuranceInfo = Model_Line::get_insurances($info['insuranceids'], $info['lineday']);

		$info['usedate'] = $useDate;
		//产品编号
		$info['series'] = St_Product::product_series($info['id'], 1);

		if ($info['contractid']) {

			$info['contract'] = Model_Contract::get_contents($info['contractid'], $this->_typeid);

		}
		if (!$suitPrice['propgroup']) {
			Common::head404();
		}

		//frmcode
		$code = md5(time());
		Common::session('code', $code);

		//积分抵现所需积分
		$jifentprice_info = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);

		$adultnum = intval($_GET['adultnum']) >= 0 ? intval($_GET['adultnum']) : 1;
		$childnum = intval($_GET['childnum']) >= 0 ? intval($_GET['childnum']) : 0;
		$oldnum = intval($_GET['oldnum']) >= 0 ? intval($_GET['oldnum']) : 0;
		$roomnum = intval($_GET['roomnum']) >= 0 ? intval($_GET['roomnum']) : 0;
		if ($suitPrice['number'] != -1 && $suitPrice['number'] < $adultnum) {
			$adultnum = $suitPrice['number'];
		}
		$roombalance = intval($_GET['roombalance']) ? intval($_GET['roombalance']) : 0;

		//预订送积分信息
		$jifenbook_info = Model_Jifen::get_used_jifenbook($info['jifenbook_id'], $this->_typeid);

		$this->assign('adultnum', $adultnum);
		$this->assign('childnum', $childnum);
		$this->assign('oldnum', $oldnum);
		$this->assign('roomnum', $roomnum);
		$this->assign('roombalance', $roombalance);
		$this->assign('info', $info);
		$this->assign('suitInfo', $suitInfo);
		$this->assign('suitPrice', $suitPrice);
		$this->assign('jifentprice_info', $jifentprice_info);
		$this->assign('jifenbook_info', $jifenbook_info);
		$this->assign('userInfo', $userInfo);
		$this->assign('frmcode', $code);
		$this->display('line/book/index');
	}

	/*
		 * 创建订单
	*/

	public function action_create() {

		$frmCode = Arr::get($_POST, 'frmcode');
		$checkCode = strtolower(Arr::get($_POST, 'checkcode'));
		//验证码验证
		if (!Captcha::valid($checkCode) || empty($checkCode)) {
			exit();
		}
		//安全校验码验证
		$orgCode = Common::session('code');
		if ($orgCode != $frmCode) {
			exit();
		}
		//会员信息
		$userInfo = Product::get_login_user_info();
		$memberId = $userInfo ? $userInfo['mid'] : 0; //会员id
		$webid = intval(Arr::get($_POST, 'webid')); //网站id
		$adultNum = intval(Arr::get($_POST, 'adult_num')); //成人数量
		$childNum = intval(Arr::get($_POST, 'child_num')); //小孩数量
		$oldNum = intval(Arr::get($_POST, 'old_num')); //老人数量
		$suitId = intval(Arr::get($_POST, 'suitid')); //套餐id
		$lineId = intval(Arr::get($_POST, 'lineid')); //线路id
		$useDate = Arr::get($_POST, 'usedate'); //出发日期
		$linkMan = Arr::get($_POST, 'linkman'); //联系人姓名
		$linkTel = Arr::get($_POST, 'linktel'); //联系人电话
		$linkEmail = Arr::get($_POST, 'linkemail'); //联系人邮箱

		$linkTel = empty($linkTel) && !empty($userInfo) ? $userInfo['mobile'] : $linkTel;
		$linkEmail = empty($linkEmail) && !empty($userInfo) ? $userInfo['email'] : $linkEmail;

		$remark = Arr::get($_POST, 'remark'); //订单备注
		$roomBalanceNum = intval(Arr::get($_POST, 'roombalance_num')); //单房差数量
		$roomBalance_Paytype = 1; //单房差支付方式在线支付.
		$isneedBill = intval(Arr::get($_POST, 'isneedbill')); //是否需要发票

		$billTitle = Arr::get($_POST, 'bill_title'); //发票抬头
		$billReceiver = Arr::get($_POST, 'bill_receiver'); //发票接收人
		$billPhone = Arr::get($_POST, 'bill_phone'); //发票联系人电话
		$billProv = Arr::get($_POST, 'bill_prov'); //发票联系人省份
		$billCity = Arr::get($_POST, 'bill_city'); //发票联系人城市
		$billAddress = Arr::get($_POST, 'bill_address'); //发票联系人地址

		$needJifen = intval($_POST['needjifen']);

		//检测订单有效性
		$check_result = Common::before_order_check(array('model' => 'line', 'productid' => $lineId, 'suitid' => $suitId, 'day' => strtotime($useDate)));
		if (!$check_result) {
			$this->request->redirect('/tips/order');
		};
		//发票信息
		//发票
		$usebill = $_POST['usebill'];
		$invoice_type = $_POST['invoice_type'];
		$bill_info = array(
			'title' => $_POST['invoice_title'],
			'content' => $_POST['invoice_content'],
			'type' => $_POST['invoice_type'],
			'taxpayer_number' => $invoice_type != 0 ? $_POST['invoice_taxpayer_number'] : '',
			'taxpayer_address' => $invoice_type == 2 ? $_POST['invoice_taxpayer_address'] : '',
			'taxpayer_phone' => $invoice_type == 2 ? $_POST['invoice_taxpayer_phone'] : '',
			'bank_branch' => $invoice_type == 2 ? $_POST['invoice_bank_branch'] : '',
			'bank_account' => $invoice_type == 2 ? $_POST['invoice_bank_account'] : '',
			'mobile' => $_POST['invoice_addr_phone'],
			'receiver' => $_POST['invoice_addr_receiver'],
			'postcode' => $_POST['invoice_addr_postcode'],
			'province' => $_POST['invoice_addr_province'],
			'city' => $_POST['invoice_addr_city'],
			'address' => $_POST['invoice_addr_address'],
		);

		//游客信息读取
		$t_name = Arr::get($_POST, 't_name');
		$t_cardtype = Arr::get($_POST, 't_cardtype');
		$t_cardno = Arr::get($_POST, 't_cardno');
		$t_sex = Arr::get($_POST, 't_sex');
		$t_mobile = Arr::get($_POST, 't_mobile');
		$t_issave = Arr::get($_POST, 't_issave');
		$tourer = array();
		$totalNum = $adultNum + $childNum + $oldNum;
		for ($i = 0; $i < $totalNum; $i++) {
			if (empty($t_name[$i])) {
				continue;
			}
			$tourer[] = array(
				'name' => $t_name[$i],
				'sex' => $t_sex[$i],
				'cardtype' => $t_cardtype[$i],
				'cardno' => $t_cardno[$i],
				'mobile' => $t_mobile[$i],
				'issave' => $t_issave[$i],
			);
		}

		//套餐信息
		$suitInfo = Model_Line_Suit::suit_info($suitId);
		//产品信息
		$info = ORM::factory('line', $lineId)->as_array();

		//判断产品状态,如果是未上架状态,则不能预订
		if ($info['status'] != 3) {
			exit('sorry,this product is sold out!');
		}

		//预订送积分

		//套餐按出发日期价格
		$suitPrice = Model_Line_Suit::suit_price($suitId, $useDate);
		$orderSn = Product::get_ordersn('01');

		//积分抵现.
		$jifentprice = 0;
		$useJifen = 0;
		if ($needJifen) {
			$jifentprice = Model_Jifen_Price::calculate_jifentprice($info['jifentprice_id'], $this->_typeid, $needJifen, $userInfo);
			$useJifen = empty($jifentprice) ? 0 : 1;
			$needJifen = empty($jifentprice) ? 0 : $needJifen;
		}
		//积分评论
		$jifencomment_info = Model_Jifen::get_used_jifencomment($this->_typeid);
		$jifencomment = empty($jifencomment_info) ? 0 : $jifencomment_info['value'];

		//判断库存
		if (!Model_Line::check_storage($lineId, $totalNum, $suitId, $useDate)) {
			exit('storage is not enough!');
		}

		//自动关闭订单时间
		$auto_close_time = $suitInfo['auto_close_time'] ? $suitInfo['auto_close_time'] : 0;

		if ($auto_close_time) {
			// $auto_close_time = strtotime("+{$auto_close_time} hours");
			$auto_close_time = $auto_close_time + time();
		}

		$arr = array(
			'ordersn' => $orderSn,
			'webid' => $webid,
			'typeid' => $this->_typeid,
			'productautoid' => $info['id'],
			'productaid' => $info['aid'],
			'productname' => $info['title'] . "({$suitInfo['suitname']})",
			'price' => $suitPrice['adultprice'],
			'childprice' => $suitPrice['childprice'],
			'oldprice' => $suitPrice['oldprice'],
			'usedate' => $useDate,
			'dingnum' => $adultNum,
			'childnum' => $childNum,
			'oldnum' => $oldNum,
			'linkman' => $linkMan,
			'linktel' => $linkTel,
			'linkemail' => $linkEmail,
			'jifentprice' => $jifentprice,
			'jifenbook' => $info['jifenbook_id'],
			'jifencomment' => $jifencomment,
			'addtime' => time(),
			'memberid' => $memberId,
			'dingjin' => $suitInfo['dingjin'],
			'paytype' => $suitInfo['paytype'],
			'suitid' => $suitId,
			'usejifen' => $useJifen,
			'needjifen' => $needJifen,
			'roombalance' => $suitPrice['roombalance'],
			'roombalancenum' => $roomBalanceNum,
			'roombalance_paytype' => $roomBalance_Paytype,
			'status' => $suitInfo['need_confirm'] ? 0 : 1, //需要确认
			'remark' => $remark,
			'isneedpiao' => $isneedBill,
			'source' => 1, //来源PC,
			'pay_way' => $suitInfo['pay_way'], //支付方式
			'need_confirm' => $suitInfo['need_confirm'] ? $suitInfo['need_confirm'] : 0, //是否需要确认.
			'auto_close_time' => $auto_close_time, //自动关闭订单时间

		);

		/*--------------------------------------------------------------优惠券信息------------------------------------------------------------*/
		//优惠券判断
		$croleid = intval(Arr::get($_POST, 'couponid'));
		if ($croleid) {
			$cid = DB::select('cid')->from('member_coupon')->where("id=$croleid")->execute()->current();
			$totalprice = Model_Coupon::get_order_totalprice($arr);
			$ischeck = Model_Coupon::check_samount($croleid, $totalprice, $this->_typeid, $info['id'], $useDate);
			if ($ischeck['status'] == 1) {
				Model_Coupon::add_coupon_order($cid, $orderSn, $totalprice, $ischeck, $croleid); //添加订单优惠券信息
			} else {
				exit('coupon  verification failed!'); //优惠券不满足条件
			}
		}
		/*-----------------------------------------------------------------优惠券信息--------------------------------------*/

		//合同判断
		if ($info['contractid']) {
			$contract = Model_Contract::get_contents($info['contractid'], $this->_typeid);
			if ($contract) {
				$arr['contract_id'] = $info['contractid'];
			}
		}

		//添加订单
		if (St_Product::add_order($arr, 'Model_Line', $arr)) {

			Common::session('_platform', 'pc');
			$orderInfo = Model_Member_Order::get_order_by_ordersn($orderSn);
			Model_Member_Order_Tourer::add_tourer_pc($orderInfo['id'], $tourer, $orderInfo['memberid']);
			//添加保险

			$baseid_arr = $_POST['baseid'];
			$planid_arr = $_POST['planid'];
			$ins_num = count($baseid_arr);
			for ($i = 0; $i < $ins_num; $i++) {
				if (empty($baseid_arr[$i])) {
					continue;
				}
				$params = array(
					'$orderSn' => $orderSn,
					'dingnum' => $adultNum + $childNum + $oldNum,
					'baseid' => $baseid_arr[$i],
					'planid' => $planid_arr[$i],
					'tours' => $tourer,
					'memberid' => $orderInfo['memberid'],
					'usedate' => $useDate,
				);
				Model_Insurance_Base::add_product_order($params);
			}
			//如果有附加保险订单,则需要重新计算compute表.
			if ($ins_num > 0) {
				//订单结算信息表数据更新
				Model_Member_Order_Compute::update($arr['ordersn']);
			}

			//添加红包
			if (St_Functions::is_normal_app_install('red_envelope')) {
				$envelope_member_id = intval($_POST['envelope_member_id']);
				if ($envelope_member_id && $memberId) {
					Model_Order_Envelope::order_use_envelope($envelope_member_id, $orderSn, $this->_typeid, $memberId);
				}
			}

			//发票信息存储
			if ($usebill) {
				Model_Member_Order_Bill::add_bill_info($orderInfo['id'], $bill_info);
			}
			//这里作判断是跳转到会员中心还是支付页面
			$payurl = Common::get_main_host() . "/payment/?ordersn=" . $orderSn . "&from=book";
			$this->request->redirect($payurl);
		}
	}

	/*
		     * 线路内容页
	*/
	public function action_show() {
		$id = intval($this->request->param('aid'));
		//线路详情
		$info = Model_Line::detail($id);
		if (!$info) {
			$this->request->redirect('error/404');
		}
		//301重定向
		if (!empty($info['redirect_url'])) {
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: {$info['redirect_url']}");
			exit();
		}
		//seo
		$seoInfo = Product::seo($info);
		//产品图片
		$info['piclist'] = Product::pic_list($info['piclist']);
		//属性列表
		$info['attrlist'] = Model_Line::line_attr($info['attrid']);
		//提前预定
		$beforBook = array(
			'islinebefore' => $info['islinebefore'],
			'linebefore' => $info['linebefore'],
		);
		$info['price'] = Model_Line::get_minprice($info['id'], array('info' => $info));
		//出发城市
		$info['startcity'] = Model_Startplace::start_city($info['startcity']);
		//点评数
		$info['commentnum'] = Model_Comment::get_comment_num($info['id'], 1);
		//销售数量
		$info['sellnum'] = Model_Member_Order::get_sell_num($info['id'], 1) + intval($info['bookcount']);
		//产品编号
		$info['series'] = St_Product::product_series($info['id'], 1);
		//产品图标
		$info['iconlist'] = Product::get_ico_list($info['iconlist']);
		//行程附件
		$info['linedoc'] = unserialize($info['linedoc']);
		//支付方式
		$paytypeArr = explode(',', $GLOBALS['cfg_pay_type']);
		//市场价
		$info['sellprice'] = $info['storeprice'] ? $info['storeprice'] : 0;
		//满意度
		$info['score'] = St_Functions::get_satisfy($this->_typeid, $info['id'], $info['satisfyscore']);

		$info['jifentprice_info'] = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);
		$info['jifenbook_info'] = Model_Jifen::get_used_jifenbook($info['jifenbook_id'], $this->_typeid);
		$info['jifencomment_info'] = Model_Jifen::get_used_jifencomment($this->_typeid);

		if (Model_Supplier::display_is_open() && $info['supplierlist']) {
			$info['suppliername'] = Arr::get(Model_Supplier::get_supplier_info($info['supplierlist'], array('suppliername')), 'suppliername');
		}

		//目的地上级
		if ($info['finaldestid'] > 0) {
			$predest = Product::get_predest($info['finaldestid']);
			$this->assign('predest', $predest);
		}

		//扩展字段信息
		$extend_info = ORM::factory('line_extend_field')
			->where("productid=" . $info['id'])
			->find()
			->as_array();

		$this->assign('seoinfo', $seoInfo);
		$this->assign('info', $info);
		$this->assign('paytypeArr', $paytypeArr);
		$this->assign('extendinfo', $extend_info);
		$this->assign('destid', $info['finaldestid']);
		$this->assign('tagword', $info['tagword']);
		$templet = Model_Line::get_product_template($info);
		$templet = $templet ? $templet : Product::get_use_templet('line_show');
		$templet = $templet ? $templet : 'line/show';
		$this->display($templet);
		//缓存内容
		$content = $this->response->body();
		Common::cache('set', $this->_cache_key, $content);
		Product::update_click_rate($info['aid'], $this->_typeid);

	}

	public function action_print() {
		$id = intval($this->params['id']);
		if (empty($id)) {
			exit('wrong id');
		}
		//线路详情
		$info = ORM::factory('line', $id)->as_array();
		$info['startcity'] = Model_Startplace::start_city($info['startcity']);
		$this->assign('info', $info);
		$this->display('line/print');
		//缓存内容
		$content = $this->response->body();
		Common::cache('set', $this->_cache_key, $content);

	}

	/*
		     * 验证验证码是否正确
	*/
	public function action_ajax_check_code() {
		$flag = 'false';
		$checkcode = strtolower(Arr::get($_POST, 'checkcode'));
		if (Captcha::valid($checkcode)) {
			$flag = 'true';
		}
		echo $flag;
	}

	/*
		     * ajax获取线路套餐报价
	*/
	public function action_ajax_line_suit_price() {

		$lineid = intval(St_Filter::remove_xss(Arr::get($_POST, 'lineid')));
		$suitid = intval(St_Filter::remove_xss(Arr::get($_POST, 'suitid')));

		$arr = Model_Line::get_suit_price($suitid);
		$str = '{"data":[ ';
		$dayBeforeNum = 0;
		if (!empty($lineid)) {
			$dyaBeforeNum = DB::select('linebefore')->from('line')->where('id', '=', $lineid)->execute()->get('linebefore');

			$dayBeforeNum = !empty($dyaBeforeNum) ? $dyaBeforeNum : $dyaBeforeNum;
		}
		$dayBefore = strtotime(date('Y-m-d'));
		if (Model_Line::is_line_before($lineid)) {
			$dayBefore += $dayBeforeNum * 24 * 60 * 60;
		}

		foreach ($arr as $row) {
			if ($row['day'] < $dayBefore) {
				continue;
			}

			$day = date('Y-m-d', $row['day']); //
			$adultprice = $row['adultprice']; //成人价格
			$childprice = $row['childprice']; //小孩价格
			$oldprice = $row['oldprice']; //老人价格
			$price = !empty($adultprice) ? $adultprice : '';
			$price = !empty($childprice) && empty($price) ? $childprice : $price;
			$price = !empty($oldprice) && empty($price) ? $oldprice : $price;

			$cfg_line_minprice_rule = $GLOBALS['cfg_line_minprice_rule'];

			$minprice = $adultprice;
			$minprice = (floatval($childprice) < floatval($minprice) && $childprice > 0) || empty($minprice) ? $childprice : $minprice;
			$minprice = (floatval($oldprice) < floatval($minprice) && $oldprice > 0) || empty($minprice) > 0 ? $oldprice : $minprice;

			switch ($cfg_line_minprice_rule) {
			case 1:
				$price = $childprice;
				break;
			case 2:
				$price = $adultprice;
				break;
			case 3:
				$price = $oldprice;
				break;
			default:
				$price = $adultprice;
				break;
			}
			$price = empty($price) ? $minprice : $price;

			$number = $row['number'] == -1 ? '余位充足' : '余位 ' . $row['number'];

			$str .= '{ "pdatetime": "' . $day . '", "price": "' . $price . '","childprice": "","description": "' . $number . '", "info": ""},';

		}
		$str = substr($str, 0, strlen($str) - 1);
		$str .= ' ]}';
		echo $str;
		exit();
	}

	/*
		     * 获取套餐人群
	*/

	public function action_ajax_suit_people() {
		$out = array();
		$suitid = Arr::get($_GET, 'suitid');
		$suitid = intval($suitid);
		$row = ORM::factory('line_suit', $suitid)->as_array();
		$group_arr = explode(',', $row['propgroup']);

		//获取最接近当前日期的报价
		$day = time();
		$ar = Model_Line_Suit_Price::get_price_byday($suitid, $day);
		if ($ar) {

			$out['useday'] = date('Y-m-d', $ar[0]['day']); //当前使用日期.
			$out['storage'] = $ar[0]['number']; //库存

		}

		if (in_array(1, $group_arr)) {
			$out['haschild'] = 1;
			$out['childprice'] = $ar[0]['childprice'] ? $ar[0]['childprice'] : 0;
		}
		if (in_array(2, $group_arr)) {
			$out['hasadult'] = 1;
			$out['adultprice'] = $ar[0]['adultprice'] ? $ar[0]['adultprice'] : 0;
		}
		if (in_array(3, $group_arr)) {
			$out['hasold'] = 1;
			$out['oldprice'] = $ar[0]['oldprice'] ? $ar[0]['oldprice'] : 0;
		}
		echo json_encode($out);

	}

	/**
	 * 按天获取报价与库存.
	 */

	public static function action_ajax_price_day() {
		$useday = strtotime(Arr::get($_GET, 'useday'));
		$suitid = Arr::get($_GET, 'suitid');
		$ar = Model_Line_Suit_Price::get_price_byday($suitid, $useday);
		echo json_encode($ar[0]);

	}

	/*
		    * 首页ajax请求获取线路
	*/
	public function action_ajax_index_line() {
		$destid = Arr::get($_GET, 'destid');
		$destid = intval($destid);
		$pagesize = Arr::get($_GET, 'pagesize');
		$pagesize = intval($pagesize);
		$offset = 0;
		$list = Model_Line::get_line_bymdd($destid, $pagesize, $offset);
		echo json_encode(array('list' => $list));
	}

	/**
	 * 获取日历下拉数据
	 */
	public function action_ajax_date_options() {
		$lineid = intval(Arr::get($_POST, 'lineid'));
		$suitid = intval(Arr::get($_POST, 'suitid'));
		$price_list = Model_Line::get_suit_date_list($lineid, $suitid);
		$hasprice = DB::select(DB::expr('count(*) as num'))->from('line_suit_price')
			->where('lineid', '=', $lineid)->and_where('suitid', '=', $suitid)
			->execute()->get('num');

		echo json_encode(array('list' => $price_list, 'hasprice' => $hasprice));

	}

	/**
	 * 日历报价
	 */
	public function action_dialog_calendar() {

		$suitid = intval(Arr::get($_POST, 'suitid'));
		$year = intval(Arr::get($_POST, 'year'));
		$month = intval(Arr::get($_POST, 'month'));
		$lineid = intval(Arr::get($_POST, 'lineid'));
		$containdiv = Arr::get($_POST, 'containdiv');
		$nowDate = new DateTime();
		$year = !empty($year) ? $year : $nowDate->format('Y');
		$month = !empty($month) ? $month : $nowDate->format('m');
		$out = '';
		$info = DB::select('islinebefore', 'linebefore')->from('line')->where('id', '=', $lineid)->execute()->current();
		$ext['islinebefore'] = $info['islinebefore'];
		$ext['linebefore'] = $info['linebefore'];
		if ($ext['islinebefore']) {
			$startdate = date('Y-m-d', strtotime("+{$ext['linebefore']} days", time()));
		}

		$priceArr = Product::get_suit_price($year, $month, $suitid, $this->_typeid, $startdate);

		$cfg_line_minprice_rule = $GLOBALS['cfg_line_minprice_rule'];
		foreach ($priceArr as &$v) {

			$adultprice = $v['price'];
			$childprice = $v['child_price'];
			$oldprice = $v['old_price'];
			$minprice = $adultprice;
			$minprice = (floatval($childprice) < floatval($minprice) && $childprice > 0) || empty($minprice) ? $childprice : $minprice;
			$minprice = (floatval($oldprice) < floatval($minprice) && $oldprice > 0) || empty($minprice) > 0 ? $oldprice : $minprice;

			switch ($cfg_line_minprice_rule) {
			case 1:
				$price = $childprice;
				break;
			case 2:
				$price = $adultprice;
				break;
			case 3:
				$price = $oldprice;
				break;
			default:
				$price = $adultprice;
				break;
			}
			$price = empty($price) ? $minprice : $price;
			$v['price'] = $price;
		}

		$out .= Common::calender($year, $month, $priceArr, $suitid, $containdiv);
		echo $out;
	}

	//判断库存
	public function action_ajax_check_storage() {
		$productid = $_POST['productid'];
		$dingnum = $_POST['dingnum'];
		$suitid = $_POST['suitid'];
		$startdate = $_POST['startdate'];
		$status = Model_Line::check_storage($productid, $dingnum, $suitid, $startdate);
		echo json_encode(array('status' => $status));
	}

}