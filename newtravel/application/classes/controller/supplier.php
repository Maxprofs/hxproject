<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Supplier extends Stourweb_Controller {
	/*
		     * 供应商总控制器
		     *
	*/
	var $_apiUrl = NULL; //短信接口地址
	public function before() {
		parent::before();
		$action = $this->request->action();
		if ($action == 'index') {
			$param = $this->params['action'];
			$right = array(
				'read' => 'slook',
				'save' => 'smodify',
				'delete' => 'sdelete',
				'update' => 'smodify',
			);
			$user_action = $right[$param];
			if (!empty($user_action)) {
				Common::getUserRight('supplier', $user_action);
			}
		}
		if ($action == 'add') {
			Common::getUserRight('supplier', 'sadd');
		}
		if ($action == 'edit') {
			Common::getUserRight('supplier', 'smodify');
		}
		if ($action == 'ajax_save') {
			Common::getUserRight('supplier', 'smodify');
		}
		$this->assign('parentkey', $this->params['parentkey']);
		$this->assign('itemid', $this->params['itemid']);
	}
	var $html = ''; //供应商设置页面初始化HTML
	public function action_select_limit() {
		$params = $this->request->param()['params'];
		$params = split('/', $params);
		$params[5] = str_replace(' ', '', $params[5]);
		//设置已选择节点1
		$this->assign('setids', $params[5]);
		$params[5] = split(',', $params[5]);

		if ($params[3] == 'dest') {
			$sql = "select id,kindname,pid,opentypeids from sline_destinations where 1";
		}
		if ($params[3] == 'from') {
			$sql = "select id,cityname,pid from sline_startplace where 1";
		}
		$list = DB::query(Database::SELECT, $sql)->execute()->as_array();
		if ($params[3] == 'dest') {
			$children = $this->bar($list, 0, 'dest', $params[5]);
		}
		if ($params[3] == 'from') {
			$children = $this->bar($list, 0, 'from', $params[5]);
		}
		if ($params[5] != '') {
			split(',', $params);
		}
		//设置已选择节点2
		$this->assign('sethtml', $this->html);

		$this->assign('list', $children);
		$this->assign('limittype', $params[3]);
		$this->display('stourtravel/supplier/select');
	}
	var $modultype = array('1' => '线路', '2' => '酒店', '3' => '租车', '5' => '景点', '8' => '签证', '104' => '游轮');

	private function settags($typeids) {
		$tags = '';
		$modulsids = split(',', trim($typeids));
		foreach ($modulsids as $k => $v) {
			if (array_key_exists($v, $this->modultype)) {
				$tags .= $this->modultype[$v] . ' ';
			}
		}
		if ($tags == '') {
			return '所有模块不可见';
		} else {
			return $tags . '模块可见';
		}

	}
// 生成出发地，目的地bootstrap treeview init 数据
	private function bar($arr, $pid, $action, $ids) {
		$children = array();
		foreach ($arr as $k => $v) {
			if ($v['pid'] == $pid) {
				if ($action == 'dest') {
					$tags = $this->settags($v['opentypeids']);
					if (array_search((int) $v['id'], $ids) !== false) {
						$this->html .= "<span id='" . $v['id'] . "'>" . $v['id'] . "  " . $v['kindname'] . "<s onclick='removespan(this)'></s></span>";
						$children[] = array('text' => $v['id'] . "  " . $v['kindname'], 'tags' => array($tags), 'pid' => $v['pid'], 'state' => array('checked' => true), 'nodes' => $this->bar($arr, $v['id'], 'dest', $ids));
					} else {
						$children[] = array('text' => $v['id'] . "  " . $v['kindname'], 'tags' => array($tags), 'pid' => $v['pid'], 'nodes' => $this->bar($arr, $v['id'], 'dest', $ids));
					}
				} else {
					if (array_search((int) $v['id'], $ids) !== false) {
						$this->html .= "<span id='" . $v['id'] . "'>" . $v['id'] . "  " . $v['cityname'] . "<s onclick='removespan(this)'></s></span>";
						if ($v['pid'] == 0) {
							$children[] = array('text' => $v['id'] . "  " . $v['cityname'], 'pid' => $v['pid'], 'state' => array('primary' => true, 'checked' => true), 'nodes' => $this->bar($arr, $v['id'], 'from', $ids));
						} else {
							$children[] = array('text' => $v['id'] . "  " . $v['cityname'], 'pid' => $v['pid'], 'state' => array('checked' => true), 'nodes' => $this->bar($arr, $v['id'], 'from', $ids));
						}
					} else {
						//供应商设置出发地最顶层项目不能选择，所以这里需要把顶层项目的checkbox关掉
						// 通过bootstrap-treeview.js中自定义primary节点参数实现主节点checkbox关闭
						if ($v['pid'] == 0) {
							$children[] = array('text' => $v['id'] . "  " . $v['cityname'], 'pid' => $v['pid'], 'state' => array('primary' => true), 'nodes' => $this->bar($arr, $v['id'], 'from', $ids));
						} else {
							$children[] = array('text' => $v['id'] . "  " . $v['cityname'], 'pid' => $v['pid'], 'nodes' => $this->bar($arr, $v['id'], 'from', $ids));
						}
					}
				}

			}
		}
		return $children;
	}

	public function action_index() {
		$action = $this->params['action'];
		if (empty($action)) //显示列表
		{
			$product_list = $this->_supplier_product_list();
			$this->assign('product_list', $product_list);

			$kindmenu = ORM::factory("supplier_kind")->get_all();
			$this->assign('kindmenu', $kindmenu);
			$this->display('stourtravel/supplier/list');
		} else if ($action == 'read') //读取列表
		{
			$start = Arr::get($_GET, 'start');
			$limit = Arr::get($_GET, 'limit');
			$keyword = Arr::get($_GET, 'keyword');
			$kindid = Arr::get($_GET, 'kindid');
			$verifystatus = Arr::get($_GET, 'verifystatus');
			$suppliertype = Arr::get($_GET, 'suppliertype');
			$authorization = Arr::get($_GET, 'authorization');
			$sort = json_decode(Arr::get($_GET, 'sort'), true);
			$w = ' where 1 ';
			if ($sort[0]['property']) {
				$order = 'order by a.' . $sort[0]['property'] . ' ' . $sort[0]['direction'] . ',a.addtime desc';
			} else {
				$order = 'order by a.addtime desc';
			}

			if ($keyword !== '') {
				$w .= "and (a.suppliername like '%{$keyword}%' or a.telephone like '%{$keyword}%' or a.mobile like '%{$keyword}%')";
			}
			if ($kindid !== '') {
				$w .= "and kindid={$kindid} ";
			}
			if ($verifystatus !== '') {
				$w .= "and verifystatus={$verifystatus} ";
			}
			if ($suppliertype !== '') {
				$w .= "and suppliertype={$suppliertype} ";
			}
			if ($authorization !== '') {
				$w .= "and find_in_set({$authorization},authorization) ";
			}

			$sql = "select a.*  from sline_supplier as a $w $order limit $start,$limit";
			//echo $sql;
			$totalcount_arr = DB::query(Database::SELECT, "select count(*) as num from sline_supplier a $w")->execute()->as_array();
			$list = DB::query(Database::SELECT, $sql)->execute()->as_array();
			$new_list = array();
			$product_list = $this->_supplier_product_list();
			foreach ($list as $k => $v) {
				$authorization_list = explode(",", $v["authorization"]);
				$v["authorization_h"] = "";

				foreach ($product_list as $product) {
					if (in_array($product["id"], $authorization_list)) {
						$v["authorization_h"] .= "{$product['modulename']},";
					}
				}

				$v["authorization_h"] = rtrim($v["authorization_h"], ",");

				$new_list[] = $v;
			}
			$result['total'] = $totalcount_arr[0]['num'];
			$result['lists'] = $new_list;
			$result['success'] = true;
			echo json_encode($result);
		} else if ($action == 'save') //保存字段
		{
		} else if ($action == 'delete') //删除某个记录
		{
			$rawdata = file_get_contents('php://input');
			$data = json_decode($rawdata);
			$id = $data->id;
			if (is_numeric($id)) //
			{
				$model = ORM::factory('supplier', $id);
				$model->delete();
			}
		} else if ($action == 'update') //更新某个字段
		{
			$id = Arr::get($_POST, 'id');
			$field = Arr::get($_POST, 'field');
			$val = Arr::get($_POST, 'val');

			if ($field == 'displayorder') //如果是排序
			{
				$val = empty($val) ? 9999 : $val;
			}
			$value_arr[$field] = $val;
			$isupdated = DB::update('supplier')->set($value_arr)->where('id', '=', $id)->execute();
			if ($isupdated) {
				echo 'ok';
			} else {
				echo 'no';
			}
		}
	}

	/*
		     * 添加
	*/
	public function action_add() {
		$this->assign('action', 'add');
		$this->assign('kind', $this->_supplier_kind());
		$this->assign('product_list', $this->_supplier_product_list());
		$this->assign('info', array('verifystatus' => 3)); //后台添加的供应商默认为已通过验证
		$this->display('stourtravel/supplier/edit');
	}

	/*
		     * 修改
	*/
	public function action_edit() {
		$id = $this->params['id']; //会员id.
		$this->assign('action', 'edit');
		$info = ORM::factory('supplier', $id)->as_array();
		$info['piclist_arr'] = json_encode(Common::getUploadPicture($info['piclist'])); //图片数组
		$info['kindlist_arr'] = Model_Destinations::getKindlistArr($info['kindlist']); //目的地数组
		$qua = unserialize($info['qualification']);
		//$qua['kindtype'] = ORM::factory('supplier_kind',$qua['kindid'])->get('kindname');
		$product_list = $this->_supplier_product_list();
		if (!empty($qua['apply_kind']) || !empty($qua['apply_product'])) {
			$apply_product = array();
			//保留，兼容老申请资料中申请的供应商分类
			if (!empty($qua['apply_kind'])) {
				$apply_product = ORM::factory('supplier_kind')->where("id in(" . $qua['apply_kind'] . ")")->get_all();
			}
			//新申请资料中申请的是供应商可供应产品
			if (!empty($qua['apply_product'])) {
				$apply_product_list = explode(",", $qua['apply_product']);
				foreach ($product_list as $product) {
					if (in_array($product["id"], $apply_product_list)) {
						$apply_product[] = $product;
					}
				}

			}
			$this->assign('apply_product', $apply_product);
		}

		$sql = "SELECT id,kindname FROM `sline_destinations` WHERE supplierids != '' and find_in_set(" . $id . ",supplierids)";
		$setdest = DB::query(Database::SELECT, $sql)->execute()->as_array();
		$sql = "SELECT id,cityname FROM `sline_startplace` WHERE supplierids != '' and find_in_set(" . $id . ",supplierids)";
		$setfrom = DB::query(Database::SELECT, $sql)->execute()->as_array();
		foreach ($setdest as $k => $v) {
			$desthtml .= "<span id='" . $v['id'] . "'>" . $v['id'] . "  " . $v['kindname'] . "<s onclick='removespan(this)'></s></span>";
			if ($k == 0) {
				$destids = $v['id'];
			} else {
				$destids .= ',' . $v['id'];
			}
		}
		$desthtml .= "<input type='hidden' id='destids' name='destids' value=" . $destids . ">";
		foreach ($setfrom as $k => $v) {
			$fromhtml .= "<span id='" . $v['id'] . "'>" . $v['id'] . "  " . $v['cityname'] . "<s onclick='removespan(this)'></s></span>";
			if ($k == 0) {
				$fromids = $v['id'];
			} else {
				$fromids .= ',' . $v['id'];
			}
		}
		$fromhtml .= "<input type='hidden' id='fromids' name='fromids' value=" . $fromids . ">";
		$this->assign('desthtml', $desthtml);
		$this->assign('fromhtml', $fromhtml);

		$this->assign('product_list', $product_list);
		$this->assign('info', $info);
		$this->assign('qua', $qua);
		$this->assign('kind', $this->_supplier_kind());

		$this->display('stourtravel/supplier/edit');
	}

	/**
	 * 供应商分类
	 */
	private function _supplier_kind() {
		$kind = DB::query(Database::SELECT, "select *,concat(path,'-',id) as level from sline_supplier_kind where isopen=1 order by level asc,displayorder asc")->execute()->as_array();
		return $kind;
	}

	/**
	 * 供应商可授权的产品列表
	 */
	private function _supplier_product_list() {
		$product_list = ORM::factory('model')->where('isopen=1 and id not in(4,6,7,10,11,14)')->get_all();
		foreach ($product_list as $k => $v) {
			if (!St_Functions::is_system_app_install($v['id']) && $v['maintable'] != "model_archive") {
				unset($product_list[$k]);
			}
		}
		return $product_list;
	}

	/*
		     * 保存
	*/
	public function action_ajax_save() {
		$destids = split(',', ARR::get($_POST, 'destids'));
		$fromids = split(',', ARR::get($_POST, 'fromids'));
		$action = ARR::get($_POST, 'action'); //当前操作
		$id = ARR::get($_POST, 'id');
		$status = false;

		//添加操作
		if ($action == 'add' && empty($id)) {
			$model = ORM::factory('supplier');
			$model->addtime = time();
		} else {
			$model = ORM::factory('supplier')->where('id', '=', $id)->find();
		}

		if (!empty($_POST['mobile'])) {
			$tempModel = ORM::factory('supplier')->where('mobile', '=', $_POST['mobile'])->find();
			if ($tempModel->loaded() && $tempModel->id != $id) {
				echo json_encode(array('status' => false, 'msg' => '手机号码已经存在'));
				return;
			}
			$model->mobile = $_POST['mobile'];
		}
		if (!empty($_POST['password'])) {
			$model->password = md5($_POST['password']);
		}

		$imagestitle = Arr::get($_POST, 'imagestitle');
		$images = Arr::get($_POST, 'images');
		$imgheadindex = Arr::get($_POST, 'imgheadindex');

		//图片处理
		$piclist = '';
		$litpic = $images[$imgheadindex];
		for ($i = 1;isset($images[$i]); $i++) {
			$desc = isset($imagestitle[$i]) ? $imagestitle[$i] : '';
			$pic = !empty($desc) ? $images[$i] . '||' . $desc : $images[$i];
			$piclist .= $pic . ',';

		}
		$piclist = strlen($piclist) > 0 ? substr($piclist, 0, strlen($piclist) - 1) : ''; //图片

		$model->suppliername = ARR::get($_POST, 'suppliername');
		$model->suppliertype = ARR::get($_POST, 'suppliertype'); //供应商类型
		$model->linkman = ARR::get($_POST, 'linkman');
		$model->telephone = ARR::get($_POST, 'telephone');
		$model->address = ARR::get($_POST, 'address');
		$model->email = Arr::get($_POST, 'email');
		$model->litpic = $litpic;
		$model->piclist = $piclist;
		$model->fax = ARR::get($_POST, 'fax');
		$model->qq = ARR::get($_POST, 'qq');
		$model->kindid = ARR::get($_POST, 'kindid');
		$model->modtime = time();

		$model->verifystatus = Arr::get($_POST, 'verifystatus');

		$model->lng = Arr::get($_POST, 'lng');
		$model->lat = Arr::get($_POST, 'lat');
		$model->kindlist = implode(',', Model_Destinations::getParentsStr(implode(',', Arr::get($_POST, 'kindlist')))); //所属目的地
		$model->content = Arr::get($_POST, 'content'); //供应商介绍
		$model->finaldestid = empty($_POST['finaldestid']) ? Model_Destinations::getFinaldestId(explode(',', $model->kindlist)) : $_POST['finaldestid'];
		$model->authorization = implode(',', $_POST['authorization']);

		$qua = unserialize($model->qualification);
		if (!empty($qua) && $model->verifystatus == 3) {
			$model->reprent = $qua['reprent'];
		} else if ($model->verifystatus == 2) {
			$model->reason = Arr::get($_POST, 'reason');
		}

		if ($action == 'add' && empty($id)) {
			$model->create();
		} else {
			$model->update();
		}
		if ($model->saved()) {
			if ($action == 'add') {
				$productid = $model->id; //插入的产品id
				// 分别写入供应商目的地，出发地限制
				foreach ($destids as $k => $id) {
					$this->set_spplierids('destinations', $id, $productid);
				}
				foreach ($fromids as $k => $id) {
					$this->set_spplierids('startplace', $id, $productid);
				}
			} else {
				$productid = $model->id;
			}

// ++++++++++++++++++++++++++
			$status = true;
		}
		echo json_encode(array('status' => $status, 'productid' => $productid));
	}
	public function action_ajax_set_supplierid() {
		$tbl = ARR::get($_POST, 'tbl');
		$isopen = ARR::get($_POST, 'isopen');
		$placeid = ARR::get($_POST, 'placeid');
		$supplierid = ARR::get($_POST, 'supplierid');
		$this->set_spplierids($tbl, $placeid, $supplierid, $isopen);
	}
	/*
		        $tblname:数据库表名
		        $destid:目的地或出发地ID
		        $supplierid:供应商ID
		        $isopen:1为写入新数据，非1为新数据替换老数据
	*/
	private function set_spplierids($tblname, $destid, $supplierid, $isopen = 1) {
		$frist = $row = ORM::factory($tblname, $destid);
		if (!$row->loaded()) {
			return false;
		}
		$supplierids = $row->supplierids;
		$supplierArr = empty($supplierids) ? array() : explode(',', $supplierids);
		if ($isopen) {
			$supplierArr[] = $supplierid;
		} else {
			$supplierArr = array_diff($supplierArr, array($supplierid));
		}
		$row->supplierids = implode(',', $supplierArr);
		return $row->save();
	}
	/*
		      以json方式返回供应商列表
	*/
	public function action_ajax_supplier_list() {
		$model = ORM::factory('supplier');
		$list = $model->get_all();
		echo json_encode($list);
	}

	/*
		          以json方式返回供应商列表
	*/
	public function action_ajax_supplier_kindid() {

		$pid = Arr::get($_POST, 'pid') ? Arr::get($_POST, 'pid') : 0;

		$sql = "SELECT * FROM sline_supplier  where  `kindid`={$pid}  ORDER BY  CONVERT(suppliername USING gbk) ASC";

		$list = DB::query(Database::SELECT, $sql)->execute()->as_array();
		echo json_encode(array('nextlist' => $list));
	}

	/*
		      设置产品供应商
	*/
	public function action_ajax_set_supplier() {
		$product_arr = array(
			1 => 'line',
			2 => 'hotel',
			3 => 'car',
			4 => 'article',
			5 => 'spot',
			6 => 'photo',
			8 => 'visa',
			13 => 'tuan',
		);
		$typeid = ARR::get($_POST, 'typeid');
		$productid = ARR::get($_POST, 'productid');
		$supplierids = ARR::get($_POST, 'supplierids');
		$model = ORM::factory($product_arr[$typeid], $productid);
		$is_success = 'ok';
		$productid_arr = explode('_', $productid);
		foreach ($productid_arr as $k => $v) {

			$value_arr['supplierlist'] = $supplierids;
			$isupdated = DB::update($product_arr[$typeid])->set($value_arr)->where('id', '=', $v)->execute();
			if (!$isupdated) {
				$is_success = 'no';
			}
		}
		echo $is_success;
	}

	/*
		     * ajax检测是否存在
	*/
	public function action_ajax_check() {
		$field = $this->params['type'];
		$val = ARR::get($_POST, 'val'); //值
		$mid = ARR::get($_POST, 'mid'); //会员id
		$flag = Model_Member::checkExist($field, $val, $mid);
		echo $flag;
	}

	public function action_dialog_set() {
		$this->assign("typeid", $_GET['typeid']);
		$this->assign('selector', urldecode($_GET['selector']));
		$this->assign('product_list', $this->_supplier_product_list());
		$this->assign('kind', $this->_supplier_kind());
		$this->display('stourtravel/supplier/dialog_set');
	}

	public function action_ajax_dialog_search() {
		$data = &$_POST;
		$supplier = DB::select()->from('supplier')->where('verifystatus', '=', 3)->and_where('suppliername', '!=', '')->and_where('suppliername', 'is not', DB::expr(' null'));
		if ($data['authorization']) {
			$supplier->and_where(DB::expr('find_in_set(' . $data['authorization'] . ',authorization)'), '>', 0);
		}
		if ($data['kindid']) {
			$supplier->and_where('kindid', '=', $data['kindid']);
		}
		if ($data['keyword']) {
			$supplier->and_where('suppliername', 'like', DB::expr('"%' . $data['keyword'] . '%"'), '>', 0);
		}
		echo json_encode($supplier->execute()->as_array());
	}

	/**
	 * 分类列表视图
	 */
	public function action_kind() {
		//栏目深度
		$level = 0;
		$parent = ($node = Arr::get($_GET, 'node')) == 'root' ? 0 : $node;
		$table = 'supplier_kind';
		$action = $this->params['action'];
		$model = ORM::factory($table);
		switch ($action) {
		case 'read':
			$path = 0;
			$list = $model->where("pid={$parent}")->get_all();
			foreach ($list as $k => $v) {
				$list[$k]['allowDrag'] = false;
				$list[$k]['leaf'] = substr_count($list[$k]['path'], '-') < $level ? false : true;
			}
			$list[] = array(
				'leaf' => true,
				'id' => "{$parent}add",
				'kindname' => "<button class=\"btn btn-primary radius size-S\" onclick=\"addSub('{$parent}','{$path}')\">添加</button>",
				'allowDrag' => false,
				'allowDrop' => false,
				'displayorder' => 'add',
			);
			echo json_encode(array('success' => true, 'text' => '', 'children' => $list));
			break;
		case 'addsub':
			$pid = Arr::get($_POST, 'pid');
			$model->pid = $pid;
			$model->kindname = "未命名";
			$model->path = Arr::get($_POST, 'path');
			$model->save();
			if ($model->saved()) {
				$model->reload();
				$data = $model->as_array();
				$data['leaf'] = true;
				echo json_encode($data);
			}
			break;
		case 'save':
			$rawdata = file_get_contents('php://input');
			$field = Arr::get($_GET, 'field');
			$data = json_decode($rawdata);
			$id = $data->id;
			if ($field) {
				$model = ORM::factory($table, $id);
				if ($model->id) {
					$model->$field = $data->$field;
					$model->save();
					if ($model->saved()) {
						echo 'ok';
					} else {
						echo 'no';
					}
				}
			}
			break;
		case 'update':
			$id = Arr::get($_POST, 'id');
			$field = Arr::get($_POST, 'field');
			$val = Arr::get($_POST, 'val');

			$value_arr[$field] = $val;
			$isupdated = DB::update($table)->set($value_arr)->where('id', '=', $id)->execute();
			if ($isupdated) {
				echo 'ok';
			} else {
				echo 'no';
			}

			break;
		case 'delete':
			$rawdata = file_get_contents('php://input');
			$data = json_decode($rawdata);
			$id = $data->id;
			if (!is_numeric($id)) {
				echo json_encode(array('success' => false));
				exit;
			}
			$model = ORM::factory($table, $id);
			$model->delete();
			break;
		default:
			$this->display('stourtravel/supplier/kind');
		}
	}

	/**
	 * @function 供应商设置
	 */
	public function action_config() {
		$config = DB::select()->from('sysconfig')
			->where('varname', '=', 'cfg_supplier_display_status')
			->execute()->current();

		$this->assign('config', $config);
		$this->display('stourtravel/supplier/config');
	}

	/**
	 * @function 保存供应商配置
	 */
	public function action_ajax_save_config() {
		$display = $_POST['display'];
		$data = array(
			'value' => $display,
		);
		$config = DB::select('id')->from('sysconfig')
			->where('varname', '=', 'cfg_supplier_display_status')
			->execute()->get('id');
		if ($config) {
			DB::update('sysconfig')->set($data)
				->where('varname', '=', 'cfg_supplier_display_status')->execute();
		} else {
			$data['webid'] = 0;
			$data['varname'] = 'cfg_supplier_display_status';
			DB::insert('sysconfig', array_keys($data))->values(array_values($data))->execute();
		}
		echo json_encode(array('status' => 1));
	}

}