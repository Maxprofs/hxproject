<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 公共控制器
 */
class Controller_Pc_Precash extends Stourweb_Controller {
	private $_user_info;
	public function before() {
		parent::before();
		//登陆状态判断
		$user = Model_Member::check_login();
		if (!empty($user['mid']) && $user['bflg'] == 1) {
			$this->mid = $user['mid'];
		} else {
			$this->request->redirect('member/login');
		}
	}
	public function action_ajax_savecash() {
		$cash = Arr::get($_POST, 'cash');
		if ((int) $cash < 100) {
			$out['status'] = false;
			$out['msg'] = '充值最少不得低于100元。';
			echo json_encode($out);
			return;
		}
		$voucherpath = Arr::get($_POST, 'voucherpath');
		$description = "预存款充值{$cash}元，状态：待审核。";
		$log_result = Model_Member_Cash_Log::add_log($this->mid, 100, $cash, $description, array('voucherpath' => $voucherpath, 'savecashstatus' => 0));
		if (!$log_result) {
			$out['status'] = false;
			$out['msg'] = '提交失败';
			echo json_encode($out);
			return;
		}
		$out['status'] = true;
		$out['msg'] = '提交成功';
		echo json_encode($out);
	}
	public function action_ajax_upload_voucher() {
		$filedata = Arr::get($_FILES, 'filedata');
		if (!$filedata) {
			$filedata = Arr::get($_FILES, 'file');
		}
		$storepath = UPLOADPATH . '/voucher/';
		if (!file_exists($storepath)) {
			mkdir($storepath);
		}
		$filename = uniqid();
		$out = array();
		$ext = end(explode('.', $filedata['name']));

		if (move_uploaded_file($filedata['tmp_name'], $storepath . $filename . '.' . $ext)) {
			$out['status'] = 1;
			$out['litpic'] = '/uploads/voucher/' . $filename . '.' . $ext;
			$out['msg'] = '上传成功';
		} else {
			$out['status'] = 0;
			$out['msg'] = '上传失败,图片大小不得超过2M';
		}
		echo json_encode($out);
	}
}