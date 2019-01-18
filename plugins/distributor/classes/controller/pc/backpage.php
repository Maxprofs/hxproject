<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Backpage extends Stourweb_Controller {

	public function before() {
		parent::before();
		$user = Model_Member::check_login();
		if (!empty($user['mid']) && $user['bflg']=='1') {
			$this->mid = $user['mid'];
		} else {
			$this->request->redirect('member/login');
		}

		$this->assign('mid', $this->mid);

	}

	public function action_index() {
		$userinfo = Model_Member::get_member_info($this->mid);
		$this->assign('userinfo', $userinfo);
		
		$this->display('pc/index');
	}

}
