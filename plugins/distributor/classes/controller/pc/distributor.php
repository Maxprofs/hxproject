<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Distributor extends Stourweb_Controller {

	public function before() {
		parent::before();
		$user = Model_Member::check_login();

		$this->user = Model_Member::get_member_info($user['mid']);
		
		if (!empty($user['mid'])) {
			$this->mid = $user['mid'];
		} else {
			$this->request->redirect('member/login');
		}
		$this->assign('mid', $this->mid);
	}

	public function action_serviceinfo() {
		$params = $this->request->param('params');
		$info = Model_Distributor::distributor_find_relationship($params, 'ctrl');
		$this->assign('info', $info);
		$this->display('bind/serviceinfo');
	}
	public function action_bind() {
		$info = Product::get_login_user_info();
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
	public function action_ajax_renewal() {
		if ($this->user['bflg'] == 0) {
			echo "<script>alert(What do u want?Body!)</script>";
		}
		$mid = $this->user['mid'];
		$money = $this->user['money'];
		$jmf = $this->user['jiamengfei'];
		$ye = $money - $jmf;
		if ($ye < 0) {
			echo json_encode(array("status" => false, "msg" => '预存款不足，请充值预存款！'));
			return;
		}
		$jmqx = strtotime(str_replace('-', '', $this->user['jiamengqixian']));
		$jmqx = "'" . date('Y-m-d', $jmqx + 365 * 24 * 60 * 60) . "'";
		$sql = "update sline_member set money={$ye},jiamengqixian={$jmqx} where mid={$mid}";
		DB::query(Database::UPDATE, $sql)->execute();
		$log_des = "加盟协议续期成功，扣款:{$jmf}元。当前余额:{$ye}元。";
		Model_Member_Cash_Log::add_log($mid, 1, $jmf, $log_des);
		echo json_encode(array("status" => true, "msg" => '续期成功，一起愉快的玩耍吧！'));
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
