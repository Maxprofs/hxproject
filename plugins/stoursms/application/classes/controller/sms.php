<?php defined('SYSPATH') or die('No direct script access.');

class Controller_SMS extends Stourweb_Controller {

	private $_provider = null;
	private $_provider_instance = null;

	public function before() {

		require_once TOOLS_COMMON . 'sms/smsservice.php';
		$provider_id = Common::remove_xss(Arr::get($_GET, 'provider_id'));
		$this->_provider = SMSService::get_provider($provider_id);
		$this->_provider_instance = SMSService::create_provider_instance($this->_provider);
		include_once APPPATH . 'classes/model/smsprovider.php';
		$this->_support = new SMSProvider;
		$this->assign('count', $this->_support->query_balance($provider_id));
		parent::before();
	}

	public function action_index() {
		$this->validate_login();

		$cfg_sms_username = Common::get_sys_para('cfg_sms_username');
		$cfg_sms_password = Common::get_sys_para('cfg_sms_password');
		$cfg_sms_price = Common::get_sys_para('cfg_sms_price');
		$this->assign('cfg_sms_username', $cfg_sms_username);
		$this->assign('cfg_sms_password', $cfg_sms_password);
		$this->assign('cfg_sms_price', $cfg_sms_price);

		$this->assign('provider', $this->_provider);

		// $out = $this->_provider_instance->query_balance();
		// $out = json_decode($out);
		// $balance = $out->Success ? $out->Data : "帐号不正确";
		// $this->assign('balance', $balance);
		$this->display('sms/config');
	}

	public function action_ajax_saveconfig() {
		$this->validate_login();

		$isopen = Common::remove_xss(Arr::get($_POST, 'isopen'));
		$cfg_sms_username = Common::remove_xss(Arr::get($_POST, 'cfg_sms_username'));
		$cfg_sms_password = Common::remove_xss(Arr::get($_POST, 'cfg_sms_password'));
		$cfg_sms_price = Common::remove_xss(Arr::get($_POST, 'cfg_sms_price'));
		$sysconfig_model = new Model_Sysconfig();
		$sysconfig_model->saveConfig(array(
			'webid' => 0,
			'cfg_sms_username' => $cfg_sms_username,
			'cfg_sms_password' => $cfg_sms_password,
			'cfg_sms_price' => $cfg_sms_price,
		));

		if ($isopen == "1") {
			SMSService::set_open_provider($this->_provider);
		} else {
			SMSService::set_close_provider($this->_provider);
		}

		echo json_encode(array('status' => true));
	}

	/*
		     * 查询
	*/
	public function action_ajax_query() {
		$this->validate_login();
		$querytype = $this->params['querytype'];
		$querydate = $this->params['querydate'];
		if ($querytype == 'uselog') {
			$out = $this->_provider_instance->query_send_log($querydate);
		}
		if ($querytype == 'faillog') {
			$out = $this->_provider_instance->query_send_fail_Log($querydate);
		}
		echo $out;
	}
}