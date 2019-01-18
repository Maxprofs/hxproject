<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Sms extends Stourweb_Controller {

	public function before() {
		parent::before();
		$user = Model_Member::check_login();
		if (!empty($user['mid'])) {
			$this->mid = $user['mid'];
		} else {
			$this->request->redirect('member/login');
		}

		$this->assign('mid', $this->mid);
	}

	public function action_sms() {
		$cfg_sms_price = Common::get_sys_para('cfg_sms_price');
		$this->assign('cfg_sms_price',$cfg_sms_price);
		$this->display('pc/sms');
	}
	public function action_ajax_query() {
		$querydate = $this->params['querydate'];
		$did = Arr::get($_GET, 'mid');
		$time = strtotime($querydate);
		$now = time();
		$sql = "select sendtime,contents,mobile,smstype from sline_sms_send_log where sendtime>=$time and sendtime<=$now and did=$did";
		$result = DB::query(Database::SELECT, $sql)->execute()->as_array();
		$arr = array('Success' => true, 'msg' => '查询成功', 'Data' => array());
		$arr['Data'] = $result;
		echo json_encode($arr);
	}
	public function action_ajax_buy_sms() {
		$mid = $this->_data['mid'];
		$num = Arr::get($_GET, 'num');
		$price = Common::get_sys_para('cfg_sms_price');
		$total = (int)$num*$price;
		echo json_encode(array('total'=>$total));
	}
}
