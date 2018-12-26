<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Distributor extends Stourweb_Controller {

	public function before() {
		parent::before();
		$user = Model_Member::check_login();
		$action = $this->request->action();

		if ($action == 'index') {
			if (!empty($user['mid']) && $user['bflg'] == 1) {
				$this->mid = $user['mid'];
			} else {
				$this->request->redirect('member/login');
			}
		} else {
			if (!empty($user['mid'])) {
				$this->mid = $user['mid'];
			} else {
				$this->request->redirect('member/login');
			}
		}

		$this->assign('mid', $this->mid);

	}

	public function action_index() {
		// $model = new Model_Member_Private_Order();
		//       $data = $model->get_check_record(10);
		//       $this->assign('data',$data);
		$userinfo = Model_Member::get_member_info($this->mid);
		$this->assign('userinfo', $userinfo);
		$this->display('pc/index');
	}

	public function action_serviceinfo() {
		$params = $this->request->param('params');
		$info = Model_Distributor::distributor_find_relationship($params, 'ctrl');
		$this->assign('info', $info);
		$this->display('bind/serviceinfo');
	}
	public function action_bind() {
		$info = Product::get_login_user_info();
		$this->assign('mid', $info['mid']);
		$this->display('bind/index');
	}
	public function action_ajax_bind() {
		$mid = str_replace('"', '', Arr::get($_GET, 'mid'));
		$bid = str_replace('"', '', Arr::get($_GET, 'bid'));
		if ($mid == 0 || $bid == 0) {
			echo json_encode(array("status" => false, "msg" => '绑定服务网点失败!'));
			return;
		}
		if (Model_Distributor::distributor_bind($mid, $bid)) {
			echo json_encode(array("status" => true, "msg" => '绑定服务网点成功!'));
		} else {
			echo json_encode(array("status" => false, "msg" => '绑定服务网点失败!'));
		}
	}
	// 分销商列表读取
	public function action_pageload() {
		$start = Arr::get($_GET, 'start');
		$limit = Arr::get($_GET, 'limit');
		$keyword = Arr::get($_GET, 'keyword');
		$city = Arr::get($_GET, 'city');
		if ($keyword == null) {
			$distributor = Model_Distributor::distributor_bindlist('', $start, $limit, $city);
			echo json_encode($distributor);
		} else {

			$distributor = Model_Distributor::distributor_bindlist($keyword, '', '', $city);
			echo json_encode($distributor);
		}
	}
}
