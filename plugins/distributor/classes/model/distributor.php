<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Distributor extends ORM {
	//对应数据库
	protected $_table_name = 'member';
	protected $_primary_key = 'mid';
	//通过分享二维码使用手机号码注册，需要减掉绑定的分销商的短信数目，并且分销商要能查询到发送的短信信息
	// 待开发
	
	/*
		获取产品门市价格
		$pid：产品ID
	*/
	public function get_storeprice($pid)
	{
		$price=DB::select('storeprice')->from('line')->where('id','=',$pid)->execute()->as_array();
		return $price;
	}
	//替换relationship表的绑定关系，
	// $rid：原绑定分销商账号ID
	// $cid：现在绑定分销商账号ID
	public function distributor_modify_relationship($rid,$cid)
	{
		try {
			DB::update('relationship')->set(array('pid' => $cid))->where('pid', '=', $rid)->execute();
		} catch (Database_Exception $e) {
			
		}
	}
	public function distributor_updata($mid, $field, $val) {

		$r = DB::update('member')->set(array($field => $val))->where('mid', '=', $mid)->execute();
		if (!empty($r)) {
			return true;
		} else {
			return false;
		}

	}
	//查找绑定关系
	public function distributor_find_relationship($mid, $action) {
		switch ($action) {
		case 'view':
			$r = DB::select('pid')->from('relationship')->where('mid', '=', $mid)->execute()->as_array();
			$pid = $r[0]['pid'];
			$distributorinfo = DB::select('mid')->from('member')->where('mid', '=', $pid)->execute()->as_array();
			$did = (int) $distributorinfo[0]['mid'];
			return $did;
			break;
		case 'ctrl':
			$dinfo = Model_Member::get_member_info($mid);
			return $dinfo;
			break;
		}
	}

	/*
		注册绑定分销商，并修改member表binddistributor字段
	*/
	public static function distributor_bind($mid, $did,$sendnum) {
		$count = count(DB::select('rid')->from('relationship')->where('mid', '=', $mid)->and_where('pid', '=', $did)->execute()->as_array());
		if ($count != 0) {
			return false;
		} else {
			$arr['mid'] = $mid;
			$arr['pid'] = $did;
			$arr['rpid'] = $did;
			try {
				$r = DB::insert('relationship', array_keys($arr))->values(array_values($arr))->execute();
				DB::update('member')->set(array('binddistributor' => $r[0]))->where('mid', '=', $mid)->execute();
				return true;
			} catch (Database_Exception $e) {
				return false;
			}
		}
	}
	/*
		* 绑定读取分销商列表
	*/
	public static function distributor_bindlist($keyword = '', $start = '', $limit = '', $city) {
		switch ($keyword) {
		case '':
			$distributor_total = count(DB::select('mid', 'nickname', 'truename', 'phone', 'mobile', 'address')->from('member')->where('bflg', '=', '1')->and_where('isopen', '=', '1')->and_where('city', '=', $city)->and_where('sms', '>', 0)->execute()->as_array());
			$distributor_list = DB::select('mid', 'nickname', 'truename', 'phone', 'mobile', 'address')->from('member')->where('bflg', '=', '1')->and_where('isopen', '=', '1')->and_where('city', '=', $city)->and_where('sms', '>', 0)->limit($start . "," . $limit)->execute()->as_array();
			break;
		default:
			$distributor_total = count(DB::select('mid', 'nickname', 'truename', 'phone', 'mobile', 'address')->from('member')->or_where_open()->where('nickname', 'like', '%' . $keyword . '%')->or_where('truename', 'like', '%' . $keyword . '%')->or_where('phone', 'like', '%' . $keyword . '%')->or_where('mobile', 'like', '%' . $keyword . '%')->or_where('address', 'like', '%' . $keyword . '%')->or_where_close()->and_where('bflg', '=', '1')->and_where('isopen', '=', '1')->and_where('city', '=', $city)->and_where('sms', '>', 0)->execute()->as_array());
			$distributor_list = DB::select('mid', 'nickname', 'truename', 'phone', 'mobile', 'address')->from('member')->or_where_open()->where('nickname', 'like', '%' . $keyword . '%')->or_where('truename', 'like', '%' . $keyword . '%')->or_where('phone', 'like', '%' . $keyword . '%')->or_where('mobile', 'like', '%' . $keyword . '%')->or_where('address', 'like', '%' . $keyword . '%')->or_where_close()->and_where('bflg', '=', '1')->and_where('isopen', '=', '1')->and_where('city', '=', $city)->and_where('sms', '>', 0)->execute()->as_array();
			break;
		}
		$distributor['total'] = $distributor_total;
		$distributor['lists'] = $distributor_list;
		$distributor['success'] = true;
		return $distributor;
	}

	/*
		* 管理员读取分销商列表
	*/
	public static function distributor_list($id = '', $keyword = '', $start = '', $limit = '') {
		switch ($keyword) {
		case '':
			if ($id == '') {
				$distributor_total = count(DB::select('mid', 'nickname', 'truename', 'phone', 'email', 'mobile', 'isopen')->from('member')->where('bflg', '=', '1')->and_where('isopen', '!=', '3')->execute()->as_array());
				$distributor_list = DB::select('mid', 'nickname', 'truename', 'phone', 'email', 'mobile', 'isopen')->from('member')->where('bflg', '=', '1')->and_where('isopen', '!=', '3')->limit($start . "," . $limit)->execute()->as_array();
				$distributor['total'] = $distributor_total;
				$distributor['lists'] = $distributor_list;
				$distributor['success'] = true;
			} else {
				$distributor = DB::select()->from('member')->where('mid', '=', $id)->execute()->as_array();
			}
			break;
		default:
			$distributor = DB::select('mid', 'nickname', 'truename', 'phone', 'email', 'mobile', 'isopen')->from('member')->or_where_open()->where('nickname', 'like', '%' . $keyword . '%')->or_where('truename', 'like', '%' . $keyword . '%')->or_where('phone', 'like', '%' . $keyword . '%')->or_where('mobile', 'like', '%' . $keyword . '%')->or_where('email', 'like', '%' . $keyword . '%')->or_where_close()->and_where('bflg', '=', '1')->
				break;
		}
		return $distributor;
	}
	public static function distributor_del($id) {
		$val_arr['isopen'] = 3;
		$admin=DB::select('mid','isadmin')->from('member')->where('isadmin','=',1)->execute()->as_array();
		if ($admin[0]['mid']==$id) {
			return 0;
		}
		$total_rows = DB::update('member')->set($val_arr)->where('mid', '=', $id)->execute();
		if ($total_rows!=0) {
			self::distributor_modify_relationship($id,$admin[0]['mid']);
		}
		return $total_rows;
	}
	/*
		* 新增用户
		* @param array $data
		* return mixed
	*/
	// public static function distributor_adduser($data) {
	// 	//数据验证
	// 	//检查账号
	// 	$user = self::distributor($data['account'], null, false);
	// 	if (!empty($user)) {
	// 		return __('error_member_exists');
	// 	}
	// 	//添加
	// 	if (stripos($data['account'], '@') === false) {
	// 		$data['mobile'] = $data['account'];
	// 	} else {
	// 		$data['email'] = $data['account'];
	// 	}
	// 	$data['addtime'] = time();
	// 	$result = DB::insert('distributor', array_keys($data))->values(array_values($data))->execute();
	// 	return $result[1] > 0 ? $result : __('error_member_insert');
	// }
	/*
		* 修改分销商账号
	*/
	public static function distributor_edit($id) {
		return self::distributor_list($id);
	}
	/*
		     * 查找用户
		     * @param string $account 用户账号
		     * return array
	*/
	public static function distributor_find($account, $pwd = null, $hasencode) {
		$where = "(mobile='$account' or email='$account')";
		if (!is_null($pwd)) {
			$pwd = $hasencode ? $pwd : md5($pwd);
			$where .= " and password='" . $pwd . "'";
		}
		$result = DB::select()->from('member')->where($where)->execute()->as_array();
		if (!empty($result)) {
			$result = $result[0];
		}
		return $result;
	}
}