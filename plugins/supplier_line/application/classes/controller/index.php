<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Index extends Stourweb_Controller {

	private $_user_info;
	private $_typeid = 1;

	public function before() {

		parent::before();

		$st_supplier_id = Cookie::get('st_supplier_id');

		if (empty($st_supplier_id)) {
			$this->request->redirect($GLOBALS['cfg_basehost'] . '/plugins/supplier/pc/login');
		} else {
			$this->_user_info = Model_Supplier::get_supplier_byid($st_supplier_id);

			self::_check_right();

			$this->assign('userinfo', $this->_user_info);
		}
		$this->assign('weblist', Common::getWebList());

	}

	//首页
	public function action_index() {

		$header = Request::factory($GLOBALS['cfg_basehost'] . '/plugins/supplier/pc/pub/header/?sid=' . $this->_user_info['id'])->execute()->body();
		$this->assign("header", $header);
		$this->display('index');
	}
	public function action_list() {
		$supplierid = $this->_user_info['id'];
		$page = intval($_GET['page']);
		$pagesize = intval($_GET['pagesize']);
		$pagesize = empty($pagesize) ? 30 : $pagesize;
		$page = empty($page) ? 1 : $page;
		$start = $pagesize * ($page - 1);
		$searchParams = array();
		$keyword = $_GET['keyword'];
		$order = 'order by a.modtime desc';
		$serial = $keyword = Arr::get($_GET, 'keyword');
		$w = "a.id is not null and a.supplierlist='$supplierid'";

		if ($pagesize != 30) {
			$searchParams['pagesize'] = $pagesize;
		}
		if (!empty($keyword)) {
			$searchParams['keyword'] = $keyword;
			$w .= preg_match('`^\d+$`', $keyword) && preg_match('`^[A-Za-z]\d+`', $serial) ? " and a.id={$keyword}" : " and (a.title like '%{$serial}%' or a.supplierlist in(select id from sline_supplier where suppliername like '%{$serial}%'))";
		}

		$sql = "select a.refuse_msg,a.status,a.id,a.aid,a.title,a.supplierlist,a.iconlist,a.finaldestid,a.price,a.startcity,a.attrid,a.webid,a.kindlist,a.ishidden,IFNULL(b.displayorder,9999) as displayorder from sline_line as a left join sline_allorderlist b on (a.id=b.aid and b.typeid=1)   where $w $order  limit $start,$pagesize";

		$totalcount_arr = DB::query(Database::SELECT, "select count(*) as num from sline_line a where $w")->execute()->as_array();
		$list = DB::query(Database::SELECT, $sql)->execute()->as_array();

		foreach ($list as $k => &$v) {

			$v['kindname'] = Model_Destinations::getKindnameList($v['kindlist']);
			$finalDestModel = ORM::factory('destinations', $v['finaldestid']);
			if ($finalDestModel->loaded()) {
				$v['finaldestname'] = $finalDestModel->kindname;
			}

			$v['attrname'] = Model_Line_Attr::getAttrnameList($v['attrid']);
			$v['url'] = Common::getBaseUrl($v['webid']) . '/lines/show_' . $v['aid'] . '.html';
			$iconname = Model_Icon::getIconName($v['iconlist']);
			$name = '';
			foreach ($iconname as $icon) {
				if (!empty($icon)) {
					$name .= '<span style="color:red">[' . $icon . ']</span>';
				}

			}
			$v['iconname'] = $name;
			$v['lineseries'] = St_Product::product_series($v['id'], 1); //线路编号
			//供应商信息
			$supplier = ORM::factory('supplier')->where("id='{$v['supplierlist']}'")->find()->as_array();
			$v['suppliername'] = $supplier['suppliername'];
			$v['linkman'] = $supplier['linkman'];
			$v['mobile'] = $supplier['mobile'];
			$v['address'] = $supplier['address'];
			$v['qq'] = $supplier['qq'];

			//套餐信息
			$suitSql = "select max(b.day) as suitday from sline_line_suit a left join sline_line_suit_price b on a.id=b.suitid where a.lineid={$v['id']} and b.day>0  group by a.id";
			$suitday = DB::query(1, $suitSql)->execute()->get('suitday');

			$v['suitday'] = !empty($suitday) ? date('Y-m-d', $suitday) : '';

		}

		$currentUrl = Url::site() . 'index/list';
		$searchUrlArr = $this->getSearchUrl($currentUrl, $searchParams);
		$pagestr = Common::page($totalcount_arr[0]['num'], $page, $pagesize, $searchUrlArr['otherurl'], 5, $searchUrlArr['firsturl']);
		$this->assign('pagestr', $pagestr);
		$this->assign('keyword', $keyword);
		$this->assign('pagesize', $pagesize);
		$this->assign('list', $list);
		$this->display('list');
	}
	public function action_suit() {
		$supplierid = $this->_user_info['id'];

		$page = intval($_GET['page']);
		$pagesize = intval($_GET['pagesize']);
		$pagesize = empty($pagesize) ? 30 : $pagesize;
		$page = empty($page) ? 1 : $page;
		$start = $pagesize * ($page - 1);
		$searchParams = array();
		$keyword = $_GET['keyword'];
		$webid = Arr::get($_GET, 'webid');
		$webid = empty($webid) ? '-1' : $webid;
		$order = 'order by a.modtime desc';
		$w = "a.id is not null and a.supplierlist=$supplierid";

		if ($pagesize != 30) {
			$searchParams['pagesize'] = $pagesize;
		}
		if (!empty($keyword)) {
			$searchParams['keyword'] = $keyword;
			$w .= preg_match('`^\d+$`', $keyword) && preg_match('`^[A-Za-z]\d+`', $keyword) ? " and a.id={$keyword}" : " and (a.title like '%{$keyword}%' or a.supplierlist in(select id from sline_supplier where suppliername like '%{$keyword}%'))";
		}
		$w .= $webid == '-1' ? '' : " and a.webid=$webid";

		$sql = "select a.id,a.aid,a.title,a.supplierlist,a.iconlist,a.finaldestid,a.price,a.startcity,a.attrid,a.webid,a.kindlist,a.ishidden,a.piclist,IFNULL(b.displayorder,9999) as displayorder from sline_line as a left join sline_allorderlist b on (a.id=b.aid and b.typeid=1)   where $w $order  limit $start,$pagesize";

		$totalcount_arr = DB::query(Database::SELECT, "select count(*) as num from sline_line a where $w")->execute()->as_array();
		$list = DB::query(Database::SELECT, $sql)->execute()->as_array();

		$new_list = array();
		foreach ($list as $k => $v) {

			$v['kindname'] = Model_Destinations::getKindnameList($v['kindlist']);
			$finalDestModel = ORM::factory('destinations', $v['finaldestid']);
			if ($finalDestModel->loaded()) {
				$v['finaldestname'] = $finalDestModel->kindname;
			}

			$v['attrname'] = Model_Line_Attr::getAttrnameList($v['attrid']);
			$v['url'] = Common::getBaseUrl($v['webid']) . '/lines/show_' . $v['aid'] . '.html';
			$iconname = Model_Icon::getIconName($v['iconlist']);
			$name = '';
			foreach ($iconname as $icon) {
				if (!empty($icon)) {
					$name .= '<span style="color:red">[' . $icon . ']</span>';
				}

			}
			$v['iconname'] = $name;
			$v['lineseries'] = St_Product::product_series($v['id'], 1); //线路编号
			//供应商信息
			$v['suitday'] = !empty($v['suitday']) ? date('Y-m-d', $v['suitday']) : '';
			$v['minprice'] = '';
			$v['minprofit'] = '';
			/*foreach($supplier as $key=>$v)
				                {
				                    $v[$key] = $v;
			*/
			//$suit=ORM::factory('line_suit')->where("lineid={$v['id']}")->get_all();
			$suitOrder = 'order by suitday desc';
			$suitSql = "select a.*,max(b.day) as suitday from sline_line_suit a left join sline_line_suit_price b on a.id=b.suitid where a.lineid={$v['id']}  group by a.id $suitOrder";
			$suit = DB::query(Database::SELECT, $suitSql)->execute()->as_array();
			if (!empty($suit)) {
				$v['tr_class'] = 'parent-line-tr';
			}

			$new_list[] = $v;
			foreach ($suit as $key => $val) {
				$val['title'] = $val['suitname'];
				$val['suitday'] = !empty($val['suitday']) ? date('Y-m-d', $val['suitday']) : '';
				$val['lineseries'] = '';
				$val['minprice'] = Model_Line_Suit_Price::getMinPrice($val['id']);
				$val['minprofit'] = Model_Line_Suit_Price::getMinPrice($val['id'], 'adultprofit');
				$val['id'] = 'suit_' . $val['id'];
				if ($key != count($suit) - 1) {
					$val['tr_class'] = 'suit-tr';
				}

				$new_list[] = $val;
			}
		}

		$currentUrl = Url::site() . 'index/suit';
		$searchUrlArr = $this->getSearchUrl($currentUrl, $searchParams);
		$pagestr = Common::page($totalcount_arr[0]['num'], $page, $pagesize, $searchUrlArr['otherurl'], 5, $searchUrlArr['firsturl']);
		$this->assign('pagestr', $pagestr);
		$this->assign('pagesize', $pagesize);
		$this->assign('list', $new_list);
		$this->display('suit');
	}
	public function getSearchUrl($url, $params) {
		$result = array();
		$str = '';
		foreach ($params as $key => $v) {
			if (empty($str)) {
				$str .= '?' . $key . '=' . $v;
			} else {
				$str .= '&' . $key . '=' . $v;
			}

		}
		$result['firsturl'] = $url . $str;
		$str .= empty($str) ? '?page={page}' : '&page={page}';
		$result['otherurl'] = $url . $str;
		return $result;
	}
	public function action_ajax_update_suit() {
		$supplierid = $this->_user_info['id'];
		$suitid = $_POST['suitid'];
		$field = $_POST['field'];
		$val = $_POST['val'];
		$suit = ORM::factory('line_suit', $suitid);
		if (!$suit->loaded()) {
			echo json_encode(array('status' => false, 'msg' => '套餐不存在'));
			return;
		}

		$line = ORM::factory('line', $suit->lineid);
		if (!$line->loaded() || $line->supplierlist != $supplierid) {
			echo json_encode(array('status' => false, 'msg' => '权限不足'));
			return;
		}
		$suit->$field = $val;
		$suit->save();
		if ($suit->saved()) {
			echo json_encode(array('status' => true, 'msg' => '修改成功'));
		} else {
			echo json_encode(array('status' => false, 'msg' => '修改失败'));
		}
	}
	public function action_ajax_del_suit() {
		$supplierid = $this->_user_info['id'];
		$suitid = $_POST['suitid'];
		$suit = ORM::factory('line_suit', $suitid);
		if (!$suit->loaded()) {
			echo json_encode(array('status' => false, 'msg' => '套餐不存在'));
			return;
		}
		$lineid = $suit->lineid;
		$line = ORM::factory('line', $lineid);
		if (!$line->loaded() || $line->supplierlist != $supplierid) {
			echo json_encode(array('status' => false, 'msg' => '权限不足'));
			return;
		}

		$suit->deleteClear();
		Model_Line::updateMinPrice($lineid);
		echo json_encode(array('status' => true, 'msg' => '修改成功'));
	}
	public function action_ajax_off_product() {
		$supplierid = $this->_user_info['id'];
		$id = $_POST['id'];
		$line = ORM::factory('line', $id);
		if (!$line->loaded() || $line->supplierlist != $supplierid || $line->status != 3) {
			echo json_encode(array('status' => false, 'msg' => '权限不足'));
			return;
		}
		$line->status = 2;
		$line->ishidden = 1;
		$line->save();
		echo json_encode(array('status' => true, 'msg' => '下线成功'));
	}
	public function action_ajax_up_product() {
		$supplierid = $this->_user_info['id'];
		$id = $_POST['id'];
		$line = ORM::factory('line', $id);
		if (!$line->loaded() || $line->supplierlist != $supplierid) {
			echo json_encode(array('status' => false, 'msg' => '权限不足'));
			return;
		}
		$line->status = 0;
		$line->ishidden = 0;
		$line->save();
		echo json_encode(array('status' => true, 'msg' => '上线成功'));
	}
	//克隆线路
	public function action_ajax_clone_product() {
		$num = Arr::get($_POST, 'num');
		$lineid = Arr::get($_POST, 'id');
		$model = new Model_Line();
		$flag = $model->clone_line($lineid, $num);
		echo json_encode(array('status' => $flag));
	}
	public function action_edit() {
		$supplierid = $this->_user_info['id'];
		$lineid = $this->params['id'];
		$model = ORM::factory('line', $lineid);

		if (!$model->loaded() || $model->supplierlist != $supplierid) {
			exit("没有权限操作此线路");
		}

		$this->assign('action', 'edit');
		$startplacelist = ORM::factory('startplace')->where("pid!=0")->and_where('isopen', '=', 1)->get_all();
		$this->assign('startplacelist', $startplacelist);
		$this->assign('hasinsurance', Model_Insurance::hasInsurance());
		if ($model->id) {
			$info = $model->as_array();
			$extendinfo = Common::getExtendInfo(1, $model->id);
			$info['kindlist_arr'] = Model_Destinations::getKindlistArr($info['kindlist']);
			$info['attrlist_arr'] = Common::getSelectedAttr(1, $info['attrid']);
			$info['iconlist_arr'] = Common::getSelectedIcon($info['iconlist']);
			$info['supplier_arr'] = ORM::factory('supplier', $info['supplierlist'])->as_array();
			$info['insurance_arr'] = Model_Insurance::getNamePaires($info['insuranceids']);
			$day_arr = array_chunk(ORM::factory('line_jieshao')->where("lineid='" . $info['id'] . "'")->order_by('day', 'asc')->get_all(), $info['lineday']);
			$info['linejieshao_arr'] = $day_arr[0];
			$info['linedoc'] = unserialize($info['linedoc']);
			$columns = ORM::factory('line_content')->where("(webid=0 and isopen=1 and isline=0 and columnname!='linespot') or (columnname='tupian' and webid=0)")->order_by('displayorder', 'asc')->get_all();
			$this->assign('columns', $columns);
			$this->assign('webid', $info['webid']);
			$this->assign('info', $info);
			$this->assign('extendinfo', $extendinfo); //扩展信息
			$this->assign('position', '修改' . $info['title']);
			$this->assign('usertransport', explode(',', $info['transport']));
			$this->display('edit');
		} else {
			echo 'URL地址错误，请重新选择线路';
		}
	}
	public function action_add() {
		if ($this->_user_info['verifystatus'] != 3) {
			exit('未通过资质审核,暂时不能进行此操作');
		}
		$supplierid = $this->_user_info['id'];
		$webid = 0;
		$this->assign('webid', 0);
		$columns = ORM::factory('line_content')->where("(webid=" . $webid . " and isopen=1 and isline=0 and columnname!='linespot') or columnname='tupian' ")->order_by('displayorder', 'asc')->get_all();
		$startplacelist = ORM::factory('startplace')->where("pid!=0")->and_where('isopen', '=', 1)->get_all();
		$this->assign('startplacelist', $startplacelist);
		$this->assign('columns', $columns);
		$this->assign('usertransport', array());
		$this->assign('position', '添加线路');
		$this->assign('action', 'add');
		$this->assign('hasinsurance', Model_Insurance::hasInsurance());
		$this->display('edit');
	}

	public function action_ajax_linesave() {

		$supplierid = $this->_user_info['id'];
		$attrids = implode(',', Arr::get($_POST, 'attrlist')); //属性
		if (!empty($attrids)) {
			$attrids = implode(',', Model_Attrlist::getParentsStr($attrids, 1));
		}
		$lineid = Arr::get($_POST, 'lineid');
		$data_arr = array();
		$data_arr['webid'] = Arr::get($_POST, 'webid');
		$data_arr['webid'] = empty($data_arr['webid']) ? 0 : $data_arr['webid'];
		$webid = $data_arr['webid'];
		$kindlist = Arr::get($_POST, 'kindlist');
		if ($webid != 0) //自动添加子站目的地属性
		{
			if (is_array($kindlist)) {
				if (!in_array($webid, $kindlist)) {
					array_push($kindlist, $webid);
				}
			} else {
				$kindlist = array($webid); //如果为空则直接加webid
			}
		}
		$data_arr['title'] = Arr::get($_POST, 'title');
		$data_arr['sellpoint'] = Arr::get($_POST, 'sellpoint');
		$data_arr['kindlist'] = implode(',', Model_Destinations::getParentsStr(implode(',', $kindlist)));
		$data_arr['finaldestid'] = empty($_POST['finaldestid']) ? Model_Destinations::getFinaldestId(explode(',', $data_arr['kindlist'])) : $_POST['finaldestid'];
		$data_arr['attrid'] = $attrids;
		$data_arr['lineday'] = Arr::get($_POST, 'lineday') ? Arr::get($_POST, 'lineday') : 1;
		$data_arr['linenight'] = Arr::get($_POST, 'linenight') ? Arr::get($_POST, 'linenight') : 0;
		$data_arr['islinebefore'] = $_POST['islinebefore'] ? 1 : 0;
		$data_arr['recommendnum'] = $_POST['recommendnum'];
		$data_arr['linebefore'] = Arr::get($_POST, 'linebefore') ? Arr::get($_POST, 'linebefore') : 0;

		$data_arr['color'] = Arr::get($_POST, 'color');
		$data_arr['satisfyscore'] = Arr::get($_POST, 'satisfyscore') ? Arr::get($_POST, 'satisfyscore') : 0;
		$data_arr['bookcount'] = Arr::get($_POST, 'bookcount') ? Arr::get($_POST, 'bookcount') : 0;
		//$data_arr['ishidden'] = Arr::get($_POST, 'ishidden') ? Arr::get($_POST, 'ishidden') : 0;//显示隐藏
		$data_arr['seotitle'] = Arr::get($_POST, 'seotitle');
		$data_arr['keyword'] = Arr::get($_POST, 'keyword');
		$data_arr['description'] = Arr::get($_POST, 'description');
		$data_arr['modtime'] = time();
		$data_arr['isstyle'] = Arr::get($_POST, 'isstyle') ? Arr::get($_POST, 'isstyle') : 2; //默认标准版
		$data_arr['showrepast'] = Arr::get($_POST, 'showrepast');
		$data_arr['jieshao'] = Arr::get($_POST, 'jieshao');
		$data_arr['biaozhun'] = Arr::get($_POST, 'biaozhun');
		$data_arr['beizu'] = Arr::get($_POST, 'beizu');
		$data_arr['payment'] = Arr::get($_POST, 'payment');
		$data_arr['feeinclude'] = Arr::get($_POST, 'feeinclude');
		$data_arr['features'] = Arr::get($_POST, 'features');
		$data_arr['reserved1'] = Arr::get($_POST, 'reserved1');
		$data_arr['reserved2'] = Arr::get($_POST, 'reserved2');
		$data_arr['reserved3'] = Arr::get($_POST, 'reserved3');
		$data_arr['startcity'] = Arr::get($_POST, 'startcity');
		$data_arr['iconlist'] = Arr::get($_POST, 'iconlist') ? implode(',', Arr::get($_POST, 'iconlist')) : '';
		$data_arr['insuranceids'] = Arr::get($_POST, 'insuranceids') ? implode(',', Arr::get($_POST, 'insuranceids')) : '';
		$data_arr['adminid'] = Session::instance()->get('userid');
		$data_arr['supplierlist'] = $supplierid;
		$data_arr['status'] = 0;
		$data_arr['ishidden'] = 1;

		$data_arr['showhotel'] = Arr::get($_POST, 'showhotel');
		$data_arr['showtran'] = Arr::get($_POST, 'showtran');
		//图片处理
		$images_arr = Arr::get($_POST, 'images');
		$imagestitle_arr = Arr::get($_POST, 'imagestitle');
		$headimgindex = Arr::get($_POST, 'imgheadindex');
		$imgstr = "";
		foreach ($images_arr as $k => $v) {
			$imgstr .= $v . '||' . $imagestitle_arr[$k] . ',';
			if ($headimgindex == $k) {
				$data_arr['litpic'] = $v;
			}
		}
		$imgstr = trim($imgstr, ',');
		$data_arr['piclist'] = $imgstr;
		$data_arr['linedoc'] = serialize(Arr::get($_POST, 'linedoc'));
		if ($lineid == 0) {
			$data_arr['addtime'] = $data_arr['modtime'];
			$model = ORM::factory('line');
			$model->aid = Common::getLastAid('sline_line', $data_arr['webid']);
			$model->addtime = time();
			$model->modtime = time();
			$model->ishidden = 1;
		} else {
			$data_arr['modtime'] = time();
			$model = ORM::factory('line', $lineid);

			if ($model->supplierlist != $supplierid) {
				exit('权限不足');
			}

			if ($model->webid != $data_arr['webid']) //如果更改了webid重新生成aid
			{
				$aid = Common::getLastAid('sline_line', $data_arr['webid']);
				$model->aid = $aid;
			}
			$model->modtime = time();
		}
		foreach ($data_arr as $k => $v) {
			$model->$k = $v;
		}
		$model->save();
		if ($model->saved()) {
			$model->reload();
			$lineid = $model->id;
			$this->savejieshao($lineid);
			Common::saveExtendData(1, $lineid, $_POST); //扩展信息保存
			echo json_encode(array('status' => 1, 'productid' => $lineid));
		} else {
			echo json_encode(array('status' => 1, 'productid' => '0'));
		}

		//$this->request->redirect("/index/list");
	}
	public function savejieshao($lineid) {
		$title_arr = Arr::get($_POST, 'jieshaotitle');
		$breakfirsthas_arr = Arr::get($_POST, 'breakfirsthas');
		$breakfirst_arr = Arr::get($_POST, 'breakfirst');
		$lunchhas_arr = Arr::get($_POST, 'lunchhas');
		$lunch_arr = Arr::get($_POST, 'lunch');
		$supperhas_arr = Arr::get($_POST, 'supperhas');
		$supper_arr = Arr::get($_POST, 'supper');
		$hotel_arr = Arr::get($_POST, 'hotel');
		$transport_arr = Arr::get($_POST, 'transport');
		$jieshao_arr = Arr::get($_POST, 'txtjieshao');
		// $beforemodels=ORM::factory('line_jieshao')->where("lineid='$lineid'")->find_all()->as_array();
		foreach ($title_arr as $k => $v) {
			$model = ORM::factory('line_jieshao')->where("lineid='$lineid' and day='$k'")->find();
			if (empty($model->id)) {
				$model = ORM::factory('line_jieshao');
			}

			$model->lineid = $lineid;
			$model->day = $k;
			$model->hotel = $hotel_arr[$k];
			$model->breakfirst = $breakfirst_arr[$k];
			$model->lunch = $lunch_arr[$k];
			$model->supper = $supper_arr[$k];
			$model->title = $v;
			$superhas_arr[$k] = empty($superhas_arr[$k]) ? 0 : $superhas_arr[$k];
			$lunchhas_arr[$k] = empty($lunchhas_arr[$k]) ? 0 : $lunchhas_arr[$k];
			$breakfirsthas_arr[$k] = empty($breakfirsthas_arr[$k]) ? 0 : $breakfirsthas_arr[$k];
			$model->supperhas = $supperhas_arr[$k];
			$model->lunchhas = $lunchhas_arr[$k];
			$model->breakfirsthas = $breakfirsthas_arr[$k];
			$model->transport = implode(',', $transport_arr[$k]);
			$link = new Model_Tool_Link();
			$model->jieshao = $link->keywordReplaceBody($jieshao_arr[$k], 1);
			$model->save();
		}
	}

	public function action_ajax_getspot() {
		$content = Arr::get($_POST, 'content');
		$lineid = Arr::get($_POST, 'lineid');
		$day = Arr::get($_POST, 'day');
		$model = new Model_Line();
		$out = $model->autoGetSpot($content, $lineid, $day);
		echo json_encode($out);
	}

	/*
		    * 添加套餐
	*/
	public function action_suit_add() {

		$supplierid = $this->_user_info['id'];
		$lineid = $this->params['lineid'];
		$lineinfo = ORM::factory('line', $lineid)->as_array();
		$info = array('lastoffer' => array('pricerule' => 'all'));
		$this->assign('lineinfo', $lineinfo);
		$this->assign('info', $info);
		$this->assign('action', 'add');
		$this->assign('position', '添加套餐');
		$this->display('suit_edit');
	}

	/*
		   * 修改套餐
	*/
	public function action_suit_edit() {

		$supplierid = $this->_user_info['id'];
		$suitid = $this->params['suitid'];
		$info = ORM::factory('line_suit', $suitid)->as_array();
		$line = ORM::factory('line', $info['lineid']);
		if (!$line->loaded() || $line->supplierlist != $supplierid) {
			exit('权限不足');
			return;
		}

		$info['lastoffer'] = unserialize($info['lastoffer']);
		if (empty($info['lastoffer'])) {
			$info['lastoffer'] = array('pricerule' => 'all');
		}
		$lineinfo = ORM::factory('line', $info['lineid'])->as_array();
		$this->assign('action', 'edit');
		$this->assign('lineinfo', $lineinfo);
		$this->assign('info', $info);
		$this->assign('position', '修改套餐');
		$this->display('suit_edit');
	}

	/*
		     * 保存套餐
	*/
	public function action_ajax_suitsave() {

		$supplierid = $this->_user_info['id'];
		$lineid = Arr::get($_POST, 'lineid');
		$suitid = $_POST['suitid'];
		$data_arr = array();
		$data_arr['suitname'] = Arr::get($_POST, 'suitname');
		$data_arr['lineid'] = Arr::get($_POST, 'lineid');
		$data_arr['description'] = Arr::get($_POST, 'description');
		$data_arr['paytype'] = Arr::get($_POST, 'paytype');
		$data_arr['dingjin'] = $data_arr['paytype'] == 2 ? Arr::get($_POST, 'dingjin') : '';
		$data_arr['sellprice'] = Arr::get($_POST, 'sellprice');
		$data_arr['roomdesc'] = Arr::get($_POST, 'roomdesc');
		$data_arr['childdesc'] = Arr::get($_POST, 'childdesc');
		$data_arr['olddesc'] = Arr::get($_POST, 'olddesc');
		//会员支付方式
		$data_arr['pay_way'] = array_sum(Arr::get($_POST, 'pay_way'));
		$data_arr['need_confirm'] = Arr::get($_POST, 'need_confirm') ? Arr::get($_POST, 'need_confirm') : 0;

		if ($suitid) {
			$model = ORM::factory('line_suit', $suitid);
			$line = ORM::factory('line', $model->lineid);
			if (!$line->loaded() || $line->supplierlist != $supplierid) {
				echo json_encode(array('status' => false, 'msg' => '权限不足'));
				return;
			}
		} else {
			$model = ORM::factory('line_suit');
		}

		foreach ($data_arr as $k => $v) {
			$model->$k = $v;
		}
		$model->save();
		if ($model->saved()) {
			$model->reload();
			Model_Line::update_line_to_check($lineid);
			echo json_encode(array('status' => true, 'msg' => '保存成功', 'id' => $model->id));
		} else {
			echo json_encode(array('status' => false, 'msg' => '保存失败'));
		}

	}

	public function action_ajax_del_doc() {
		$supplierid = $this->_user_info['id'];
		$id = Arr::get($_POST, 'lineid');
		$model = ORM::factory('line', $id);
		if (!$model->loaded() || $model->supplierlist != $supplierid) {
			echo json_encode(array('status' => false, ''));
			return;
		}

		$doc = $model->get('linedoc');
		if ($doc) {
			$path = BASEPATH . $doc;
			@unlink($path);
		}
		echo json_encode(array('status' => 1));
	}

	//检查权限
	private function _check_right() {
		$right_arr = explode(',', $this->_user_info['authorization']);
		if (!in_array($this->_typeid, $right_arr)) {
			exit('Warning:no right to do this!');
		}

	}

	/**
	 * @function 修改报价弹窗
	 */
	public function action_dialog_edit_suit_price() {
		$suitid = $_GET['suit'];
		$lineid = $_GET['lineid'];
		$date = strtotime($_GET['date']);
		$ar = Model_Line_Suit_Price::get_price_by_date($suitid, $date);
		$this->assign('suitid', $suitid);
		$this->assign('lineid', $lineid);
		$this->assign('date', $_GET['date']);
		$this->assign('info', $ar);
		$this->display('calendar/dialog_add_price');
	}

	/**
	 * @function 保存一天的报价
	 */
	public function action_ajax_save_day_price() {
		$propgroup = $_POST['propgroup'] ? $_POST['propgroup'] : array();

		if (in_array(2, $propgroup)) {
			$adultbasicprice = $_POST['adultbasicprice'];
			$adultprofit = $_POST['adultprofit'];
			$adultprice = $adultbasicprice + $adultprofit;
		} else {
			$adultprofit = $adultbasicprice = $adultprice = 0;
		}

		if (in_array(1, $propgroup)) {
			$childbasicprice = $_POST['childbasicprice'];
			$childprofit = $_POST['childprofit'];
			$childprice = $childbasicprice + $childprofit;
		} else {
			$childprice = $childprofit = $childbasicprice = 0;
		}
		if (in_array(3, $propgroup)) {
			$propgroup[] = 3;
			$oldbasicprice = $_POST['oldbasicprice'];
			$oldprofit = $_POST['oldprofit'];
			$oldprice = $oldbasicprice + $oldprofit;
		} else {
			$oldprice = $oldbasicprice = $oldprofit = 0;
		}
		$roombalance = $_POST['roombalance'] ? $_POST['roombalance'] : 0;
		$store = $_POST['store'];
		$store == 1 ? $number = -1 : $number = $_POST['number'];
		$suitid = $_POST['suitid'];
		$lineid = $_POST['lineid'];
		$date = $_POST['date'];
		$data = array(
			'adultbasicprice' => $adultbasicprice,
			'adultprofit' => $adultprofit,
			'adultprice' => $adultprice,
			'childbasicprice' => $childbasicprice,
			'childprofit' => $childprofit,
			'childprice' => $childprice,
			'oldbasicprice' => $oldbasicprice,
			'oldprofit' => $oldprofit,
			'oldprice' => $oldprice,
			'roombalance' => $roombalance,
			'number' => $number,
			'propgroup' => implode(',', $propgroup),
		);
		$isdel = 0;
		if (!$propgroup || ($adultprice == 0 && $childprice == 0 && $oldprice == 0)) {
			$isdel = 1;
		}
		Model_Line_Suit_Price::update_date_price($lineid, $suitid, $date, $data, $isdel);
		Model_Line::update_min_price($lineid);
		Model_Line::update_line_to_check($lineid);
		$data['date'] = $date;
		echo json_encode($data);

	}

	/**
	 * @function 清空全部报价
	 */
	public function action_ajax_clear_all_price() {
		$suitid = $_POST['suitid'];
		$lineid = $_POST['lineid'];
		DB::delete('line_suit_price')->where('suitid', '=', $suitid)
			->and_where('lineid', '=', $lineid)->execute();
		Model_Line::update_line_to_check($lineid);
	}

	/**
	 * @function 添加报价
	 */
	public function action_dialog_add_suit_price() {
		$action = $_GET['action'];
		$lineid = $_GET['lineid'];
		$suitid = $_GET['suit'];

		$this->assign('action', $action);
		$this->assign('lineid', $lineid);
		$this->assign('suitid', $suitid);
		$this->display('calendar/dialog_add_price');
	}

	/**
	 * @function 保存套餐报价
	 */
	public function action_ajax_save_suit_price() {
		$lineid = $_POST['lineid'];
		$suitid = $_POST['suitid'];
		$arr = $_POST;
		$this->save_baojia($lineid, $suitid, $arr);
		Model_Line::update_line_to_check($lineid);
	}

	public function save_baojia($lineid, $suitid, $arr) {
		$pricerule = Arr::get($arr, 'pricerule');
		$starttime = Arr::get($arr, 'starttime');
		$endtime = Arr::get($arr, 'endtime');
		$propgroup = Arr::get($arr, 'propgroup');

		if (empty($starttime) || empty($endtime)) {
			return false;
		}
		//儿童
		$childbasicprice = $childprofit = 0;
		if (in_array(1, $propgroup)) {
			$childbasicprice = Arr::get($arr, 'childbasicprice') ? Arr::get($arr, 'childbasicprice') : $childbasicprice;
			$childprofit = Arr::get($arr, 'childprofit') ? Arr::get($arr, 'childprofit') : $childprofit;
		}
		//成人
		$adultbasicprice = $adultprofit = 0;
		if (in_array(2, $propgroup)) {
			$adultbasicprice = Arr::get($arr, 'adultbasicprice') ? Arr::get($arr, 'adultbasicprice') : $adultbasicprice;
			$adultprofit = Arr::get($arr, 'adultprofit') ? Arr::get($arr, 'adultprofit') : $adultprofit;
		}
		//老人
		$oldbasicprice = $oldprofit = 0;
		if (in_array(3, $propgroup)) {
			$oldbasicprice = Arr::get($arr, 'oldbasicprice') ? Arr::get($arr, 'oldbasicprice') : $oldbasicprice;
			$oldprofit = Arr::get($arr, 'oldprofit') ? Arr::get($arr, 'oldprofit') : $oldprofit;
		}
		$roombalance = $arr['roombalance'];
		// $description = Arr::get($arr, 'description'); //描述
		$arr['store'] == 1 ? $number = -1 : $number = Arr::get($arr, 'number'); //库存
		$monthval = Arr::get($arr, 'monthval');
		$weekval = Arr::get($arr, 'weekval');
		$stime = strtotime($starttime);
		$etime = strtotime($endtime);
		$adultprice = (int) $adultbasicprice + (int) $adultprofit;
		$childprice = (int) $childbasicprice + (int) $childprofit;
		$oldprice = (int) $oldbasicprice + (int) $oldprofit;

		//按日期范围报价
		if ($pricerule == '1') {
			$begintime = $stime;
			while (true) {
				$data_arr = array();
				$data_arr['lineid'] = $lineid;
				$data_arr['suitid'] = $suitid;
				$data_arr['adultbasicprice'] = $adultbasicprice;
				$data_arr['adultprofit'] = $adultprofit;
				$data_arr['adultprice'] = $adultprice;
				$data_arr['childbasicprice'] = $childbasicprice;
				$data_arr['childprofit'] = $childprofit;
				$data_arr['childprice'] = $childprice;
				$data_arr['oldbasicprice'] = $oldbasicprice;
				$data_arr['oldprofit'] = $oldprofit;
				$data_arr['oldprice'] = $oldprice;
				//  $data_arr['day'] = $begintime;
				// $data_arr['description'] = $description;
				$data_arr['roombalance'] = empty($roombalance) ? 0 : $roombalance;
				$data_arr['number'] = $number;
				$data_arr['propgroup'] = implode(',', $propgroup);
				$isdel = 0;
				if (!$propgroup || ($adultprice == 0 && $childprice == 0 && $oldprice == 0)) {
					$isdel = 1;
				}

				Model_Line_Suit_Price::update_date_price($lineid, $suitid, date('Y-m-d', $begintime), $data_arr, $isdel);
				$begintime = $begintime + 86400;
				if ($begintime > $etime) {
					break;
				}

			}
		}
		//按号进行报价
		else if ($pricerule == '3') {
			$syear = date('Y', $stime);
			$smonth = date('m', $stime);
			$sday = date('d', $stime);
			$eyear = date('Y', $etime);
			$emonth = date('m', $etime);
			$eday = date('d', $etime);
			$beginyear = $syear;
			$beginmonth = $smonth;
			while (true) {
				$daynum = date('t', strtotime($beginyear . '-' . $beginmonth . '-' . '01'));
				foreach ($monthval as $v) {
					if ((int) $v < 10) {
						$v = '0' . $v;
					}

					$newtime = strtotime($beginyear . '-' . $beginmonth . '-' . $v);
					if ((int) $v > (int) $daynum || $newtime < $stime || $newtime > $etime) {
						continue;
					}

					$data_arr['lineid'] = $lineid;
					$data_arr['suitid'] = $suitid;
					$data_arr['adultbasicprice'] = $adultbasicprice;
					$data_arr['adultprofit'] = $adultprofit;
					$data_arr['adultprice'] = $adultprice;
					$data_arr['childbasicprice'] = $childbasicprice;
					$data_arr['childprofit'] = $childprofit;
					$data_arr['childprice'] = $childprice;
					$data_arr['oldbasicprice'] = $oldbasicprice;
					$data_arr['oldprofit'] = $oldprofit;
					$data_arr['oldprice'] = $oldprice;
					$data_arr['day'] = $newtime;
					// $data_arr['description'] = $description;
					$data_arr['roombalance'] = empty($roombalance) ? 0 : $roombalance;
					$data_arr['number'] = $number;
					$data_arr['propgroup'] = implode(',', $propgroup);
					$isdel = 0;
					if (!$propgroup || ($adultprice == 0 && $childprice == 0 && $oldprice == 0)) {
						$isdel = 1;
					}

					Model_Line_Suit_Price::update_date_price($lineid, $suitid, date('Y-m-d', $newtime), $data_arr, $isdel);

				}
				$beginmonth = (int) $beginmonth + 1;
				if ($beginmonth > 12) {
					$beginmonth = $beginmonth - 12;
					$beginyear++;
				}
				if (($beginmonth > $emonth && $beginyear >= $eyear) || ($beginmonth <= $emonth && $beginyear > $eyear)) {
					break;
				}

				$beginmonth = $beginmonth < 10 ? '0' . $beginmonth : $beginmonth;
			}
		}
		//按星期进行报价
		else if ($pricerule == '2') {
			$begintime = $stime;
			while (true) {
				$cur_week = date('w', $begintime);
				$cur_week = $cur_week == 0 ? 7 : $cur_week;
				if (in_array($cur_week, $weekval)) {
					$data_arr['lineid'] = $lineid;
					$data_arr['suitid'] = $suitid;
					$data_arr['adultbasicprice'] = $adultbasicprice;
					$data_arr['adultprofit'] = $adultprofit;
					$data_arr['adultprice'] = $adultprice;
					$data_arr['childbasicprice'] = $childbasicprice;
					$data_arr['childprofit'] = $childprofit;
					$data_arr['childprice'] = $childprice;
					$data_arr['oldbasicprice'] = $oldbasicprice;
					$data_arr['oldprofit'] = $oldprofit;
					$data_arr['oldprice'] = $oldprice;
					$data_arr['day'] = $begintime;
					// $data_arr['description'] = $description;
					$data_arr['roombalance'] = empty($roombalance) ? 0 : $roombalance;
					$data_arr['number'] = $number;
					$data_arr['propgroup'] = implode(',', $propgroup);
					$isdel = 0;
					if (!$propgroup || ($adultprice == 0 && $childprice == 0 && $oldprice == 0)) {
						$isdel = 1;
					}
					Model_Line_Suit_Price::update_date_price($lineid, $suitid, date('Y-m-d', $begintime), $data_arr, $isdel);

				}
				$begintime = $begintime + 86400;
				if ($begintime > $etime) {
					break;
				}

			}
		}
		Model_Line::update_min_price($lineid);
	}

	public function action_ajax_verify_product() {
		$supplierid = $this->_user_info['id'];
		$id = $_POST['id'];
		$line = ORM::factory('line', $id);
		if (!$line->loaded() || $line->supplierlist != $supplierid) {
			echo json_encode(array('status' => false, 'msg' => '权限不足'));
			return;
		}
		$line->status = 1;
		$line->ishidden = 1;
		$line->save();
		echo json_encode(array('status' => true, 'msg' => '提交审核成功'));
	}
// ++++++
	public function action_dialog_setstartplace() {
		$id = $this->params['id'];
		$startplacetop = DB::select()->from('startplace')->where('pid', '=', 0)->and_where('isopen', '=', 1)->execute()->as_array();
		$startplacelist = DB::select()->from('startplace')->where('pid', '!=', 0)->and_where('isopen', '=', 1)->execute()->as_array();
		foreach ($startplacetop as &$item) {
			$pid = $item['id'];
			$item['num'] = DB::query(Database::SELECT, "select count(*) as num from sline_startplace where pid='{$pid}' and isopen=1 ")->execute()->get('num');
		}
		$this->assign('startplacetop', $startplacetop);
		$this->assign('startplacelist', $startplacelist);
		$this->assign('startplaceid', $id);
		$this->display('dialog_setstartplace');
	}

	public function action_ajax_get_start_place() {
		$id = intval($_REQUEST['pid']);
		$keyword = trim(Arr::get($_POST, 'keyword'));
		$sql = "SELECT * FROM sline_startplace";
		$where = " WHERE isopen=1";
		if ($id) {
			$where .= " AND pid={$id}";
		}
		if ($keyword) {
			$keyword_str = '%' . $keyword . '%';
			$where .= " AND cityname like '{$keyword_str}'";
		}
		$sql .= $where;
		$startplace = DB::query(Database::SELECT, $sql)->execute()->as_array();
		echo json_encode(array('status' => $startplace ? true : false, 'msg' => 'ok', 'list' => $startplace, 'count' => count($startplace)));
	}
}