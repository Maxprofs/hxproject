<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Sms extends Stourweb_Controller {

	public function before() {
		parent::before();
		$user = Model_Member::check_login();
		if (!empty($user['mid']) && $user['bflg']==1) {
			$this->mid = $user['mid'];
		} else {
			$this->request->redirect('member/login');
		}

		$this->assign('mid', $this->mid);
	}

	public function action_sms() {
		$cfg_sms_price = Common::get_sys_para('cfg_sms_price');
		$this->assign('cfg_sms_price', $cfg_sms_price);
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
		$total = (int) $num * $price;
		$balance = DB::query(Database::SELECT, "select money from sline_member where mid=$mid")->execute()->as_array();
		$balance = $balance[0]['money'];
		if ($balance < $total) {
			echo json_encode(array('state' => false, 'msg' => "当前账户余额不足，短信购买失败"));
			exit;
		}

		$balance = $balance - $total;
		DB::query(Database::UPDATE, "update sline_member set money=$balance,sms=$num+sms where mid=$mid")->execute();
		$type = 1; //支出
		$description = "购买" . $num . "条短信成功，消费" . $total . "元，当前余额" . $balance . "元。";
		$log_result = Model_Member_Cash_Log::add_log($mid, $type, $total, $description,array('checktype'=>1));
		if (!$log_result) {
			throw new Exception('保存日志失败');
		}
		echo json_encode(array('state' => true, 'msg' => $description));
	}
}
