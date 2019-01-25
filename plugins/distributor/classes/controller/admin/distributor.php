<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Distributor extends Stourweb_Controller {

	public function before() {
		parent::before();
		// $action = $this->request->action();
		// $param = $this->params['action'];
		$this->assign('parentkey', $this->params['parentkey']);
		$this->assign('itemid', $this->params['itemid']);

		// var_dump($this->request);exit;
	}
	public function action_distributor() {
		$this->display('admin/distributor/list');
	}
	public function action_setadminmember() {
		$admin = DB::select('mid', 'mobile', 'email')->from('member')->where('isadmin=1')->execute()->as_array();
		if ($admin[0]['mobile'] != '') {
			$this->assign('account', $admin[0]['mobile']);
		} else {
			$this->assign('account', $admin[0]['email']);
		}
		$this->display('admin/distributor/setadminmember');
	}
	public function action_precash() {

		$this->display('admin/distributor/precash');
	}
	public function action_ajax_load_cashlog()
	{
		$page=Arr::get($_GET,'page');
		$limit=Arr::get($_GET,'limit');
		$start=Arr::get($_GET,'start');
		$finish=$page*$limit;
		$sql="select sline_member_cash_log.id,sline_member.nickname,sline_member_cash_log.amount,FROM_UNIXTIME(sline_member_cash_log.addtime,'%Y-%m-%d %H:%i') as addtime,sline_member_cash_log.description,sline_member_cash_log.voucherpath,sline_member_cash_log.savecashstatus from sline_member,sline_member_cash_log where sline_member_cash_log.memberid=sline_member.mid and sline_member_cash_log.type=100 order by sline_member_cash_log.id desc limit $start,$finish";
		$list=DB::query(Database::SELECT,$sql)->execute()->as_array();
		$sql="select count(id) as total from sline_member_cash_log where type=100";
		$total=DB::query(Database::SELECT,$sql)->execute()->as_array();
		$out['list']=$list;
		$out['total']=$total[0]['total'];
		echo json_encode($out);
	}
	public function action_credit() {
		$this->display('admin/distributor/credit');
	}
	//设置管理员业务账号
	public function action_ajax_set() {
		$account = str_replace('"', '', Arr::get($_GET, 'param'));
		$d = Model_Distributor::distributor_find($account);
		$isadmin = DB::select('mid', 'isadmin')->from('member')->where('isadmin=1')->execute()->as_array();

		if (empty($d)) {
			echo json_encode(array('status' => false, 'msg' => '不存在您填写的账号！'));
			return;
		} else {
			if (!empty($isadmin)) {
				if (!Model_Distributor::distributor_updata($isadmin[0]['mid'], 'isadmin', 0)) {
					echo json_encode(array('status' => false, 'msg' => '设置失败！'));
					return;
				} else {
					Model_Distributor::distributor_modify_relationship($isadmin[0]['mid'], $d['mid']);
				}
			}
			if (Model_Distributor::distributor_updata($d['mid'], 'isadmin', 1)) {
				echo json_encode(array('status' => true, 'msg' => '设置管理员分销账号成功！'));
				return true;
			} else {
				echo json_encode(array('status' => false, 'msg' => '设置失败！'));
			}
		}
	}
	// 分销商列表读取
	public function action_pageload() {
		$start = Arr::get($_GET, 'start');
		$limit = Arr::get($_GET, 'limit');
		$keyword = Arr::get($_GET, 'keyword');
		if ($keyword == null) {
			$distributor = Model_Distributor::distributor_list('', '', $start, $limit);
			echo json_encode($distributor);
		} else {
			$distributor = Model_Distributor::distributor_list('', $keyword, $start, $limit);
			echo json_encode($distributor);
		}
	}
	public function action_add() {
		$this->assign('action', 'add');
		$this->display('admin/distributor/edit');
	}
	public function action_edit() {
		$params = $this->request->param('params');
		$a = split('/', $params);
		$id = $a[0];
		$_GET[$a[1]] = $a[2];
		$info = Model_Distributor::distributor_edit($id);
		$info[0]['idcard_pic'] = (array) json_decode($info[0]['idcard_pic']);
		$_SESSION['mobile'] = $info[0]['mobile'];
		$_SESSION['email'] = $info[0]['email'];
		$this->assign('info', $info);
		$this->assign('action', 'edit');
		$this->display('admin/distributor/edit');
	}

	public function action_del() {
		$id = $this->request->get('id');

		$rows = Model_Distributor::distributor_del($id);
		if (!$rows) {
			echo json_encode(array('status' => false, 'msg' => '管理员分销商账号不能删除，请更改后删除！'));
		} else {
			echo json_encode(array('status' => true, 'msg' => '删除成功！'));
		}

	}
	/*
		     * 保存
	*/
	public function action_ajax_save() {

		$regType = Arr::get($_POST, 'regtype');
		$action = ARR::get($_POST, 'action'); //当前操作
		$id = ARR::get($_POST, 'id');
		$status = false;
		$model = ORM::factory('member');
		//添加用户验证账号是否存在
		if ($action == 'add') {
			if (ARR::get($_POST, "mobile") != '') {
				$mobile = ORM::factory('member')->where('mobile', '=', ARR::get($_POST, "mobile"))->find()->as_array();
				if ($mobile['mid'] != '') {
					echo json_encode(array('status' => 0, 'msg' => '手机号码已存在，请更换手机号！'));
					return;
				}
			}
			if (ARR::get($_POST, "email") != '') {
				$email = ORM::factory('member')->where('email', '=', ARR::get($_POST, "email"))->find()->as_array();
				if ($email['mid'] != '') {
					echo json_encode(array('status' => 0, 'msg' => '邮箱已存在，请更换邮箱！'));
					return;
				}
			}
		} else {
			// 编辑用户验证账号
			if (ARR::get($_POST, "mobile") != '' && ARR::get($_POST, "mobile") != $_SESSION['mobile']) {
				$mobile = ORM::factory('member')->where('mobile', '=', ARR::get($_POST, "mobile"))->find()->as_array();
				if ($mobile['mid'] != '') {
					echo json_encode(array('status' => 0, 'msg' => '手机号码已存在，请更换手机号！'));
					return;
				}
			}
			if (ARR::get($_POST, "email") != '' && ARR::get($_POST, "mobile") != $_SESSION['mobile']) {
				$email = ORM::factory('member')->where('email', '=', ARR::get($_POST, "email"))->find()->as_array();
				if ($email['mid'] != '') {
					echo json_encode(array('status' => 0, 'msg' => '邮箱已存在，请更换邮箱！'));
					return;
				}
			}
		}

		if ($action == 'add' && empty($id)) {
			if ($regtype == '0') {
				$model->regtype = 0;
			} else {
				$model->regtype = 1;
			}
			$model->joinip = Common::get_ip();
			$model->bflg = 1;
			$model->jifen = 0;
			$model->jointime = time();
		} else {
			$model = ORM::factory('member')->where('mid', '=', $id)->find();
		}
		$model->mobile = Common::remove_xss(ARR::get($_POST, "mobile"));
		$model->email = Common::remove_xss(ARR::get($_POST, "email"));
		if (ARR::get($_POST, "paypwd") != "") {
			$model->zhifumima = md5(ARR::get($_POST, "paypwd"));
		}
		if (ARR::get($_POST, "pwd")) {
			$model->pwd = md5(ARR::get($_POST, "pwd"));
		}
		$front_pic = Common::remove_xss(ARR::get($_POST, "front_pic"));
		$verso_pic = Common::remove_xss(ARR::get($_POST, "verso_pic"));
		if ($front_pic != '' && $verso_pic != '') {
			$model->idcard_pic = json_encode(array('front_pic' => $front_pic, 'verso_pic' => $verso_pic));
			$model->verifystatus = 2;
		} else {
			echo json_encode(array('status' => 0, 'msg' => '身份证图片不正确，请重新上传！'));
			return;
		}
		$model->province = ARR::get($_POST, "province");
		$model->city = ARR::get($_POST, "city");
		$model->nickname = Common::remove_xss(ARR::get($_POST, "nickname"));
		$model->phone = ARR::get($_POST, "phone");
		$model->truename = ARR::get($_POST, "truename");
		$model->qq = ARR::get($_POST, "qq");
		$model->wechat = ARR::get($_POST, "wechat");
		$model->address = ARR::get($_POST, "address");
		$model->lng = ARR::get($_POST, "lng");
		$model->lat = ARR::get($_POST, "lat");
		$model->createdate = ARR::get($_POST, "createdate");
		$model->xinyongdaima = ARR::get($_POST, "xinyongdaima");
		$model->beianhao = ARR::get($_POST, "beianhao");
		$model->companyname = ARR::get($_POST, "companyname");
		$model->cardid = ARR::get($_POST, "idcard");
		$model->license_pic = ARR::get($_POST, "license_pic");
		$model->isopen = ARR::get($_POST, "isopen");

		if ($action == 'add' && empty($id)) {
			$model->create();
		} else {
			$model->update();
		}

		if ($model->saved()) {
			if ($action == 'add') {
				$productid = $model->mid; //插入的产品id
				//管理员添加的用户账号直接绑定分销商为自己
				$r = Model_Distributor::distributor_bind($productid, $productid);
				$model->binddistributor = $r[0];
				$model->update();
			} else {
				$productid = $model->mid;
			}
			$status = true;

		}
		echo json_encode(array('status' => $status, 'productid' => $productid));
	}

	/**
	 * 修改密码
	 */
	// public function action_ajax_do_modify_password() {
	// 	if (!$this->request->is_ajax()) {
	// 		echo json_encode(array('status' => 0, 'msg' => '请求异常'));
	// 		exit;
	// 	}

	// 	$oldpassword = Common::remove_xss(Arr::get($_POST, 'oldpassword'));
	// 	$newpassword = Common::remove_xss(Arr::get($_POST, 'newpassword'));

	// 	//注册信息验证
	// 	$validataion = Validation::factory($this->request->post());
	// 	$validataion->rule('oldpassword', 'not_empty');
	// 	$validataion->rule('oldpassword', 'min_length', array(':value', '6'));
	// 	$validataion->rule('newpassword', 'not_empty');
	// 	$validataion->rule('newpassword', 'min_length', array(':value', '6'));
	// 	if (!$validataion->check()) {
	// 		$error = $validataion->errors();
	// 		$keys = array_keys($validataion->errors());
	// 		if ($keys[0] == 'oldpassword') {
	// 			echo json_encode(array('status' => 0, 'msg' => '“当前密码”不少于6位'));
	// 			exit;
	// 		}
	// 		if ($keys[0] == 'newpassword') {
	// 			echo json_encode(array('status' => 0, 'msg' => '“新密码”不少于6位'));
	// 			exit;
	// 		}
	// 	}
	// 	$updateArr = array('password' => md5($newpassword));
	// 	$st_supplier_id = intval(Cookie::get('st_supplier_id'));
	// 	$whereStr = "password='" . md5($oldpassword) . "' AND id='{$st_supplier_id}'";

	// 	$rtn = Model_Supplier::update_field_by_where($updateArr, $whereStr, 'supplier');
	// 	if ($rtn) {
	// 		echo json_encode(array('status' => 1, 'msg' => '修改成功'));
	// 		exit;
	// 	} else {
	// 		echo json_encode(array('status' => 0, 'msg' => '“当前密码”错误'));
	// 		exit;
	// 	}
	// }
}