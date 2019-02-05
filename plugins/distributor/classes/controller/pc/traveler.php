<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Traveler extends Stourweb_Controller {

	public function before() {
		parent::before();
		$user = Model_Member::check_login();
		if (!empty($user['mid']) && $user['bflg'] == '1') {
			$this->mid = $user['mid'];
		} else {
			$this->request->redirect('member/login');
		}

		$this->assign('mid', $this->mid);

	}

	public function action_index() {

		$this->display('pc/traveler');
	}
	//门市pc后台向供应商提交订单
	public function action_ajax_submitorder(){
		$orderid=Common::remove_xss(Arr::get($_POST,'orderid'));
		$dpaypic=Common::remove_xss(Arr::get($_POST,'voucherpath'));
		$m=ORM::factory('member_order')->where('id','=',$orderid)->find();
		$info = Model_Member_Order::get_order_by_ordersn($m->ordersn);
		$m->dconfirm=1;
		//不需要供应商确认,则订单直接转为待付款状态
		if ($m->need_confirm==0) {
			$m->status=1;
			$m->dpaydate=$m->usedate;
		}
		if (!empty($dpaypic)) {
			$m->dpaypic=$dpaypic;
		}
		if (!$m->save()) {
			echo json_encode(array('status'=>false,'msg'=>'订单提交失败'));
			return;
		}
		Model_Member_Order_Log::add_log($info,'','','服务网点已提交至供应商');
		echo json_encode(array('status'=>true,'msg'=>'订单已提交至供应商'));
	}
	//pc后台修改游客订单总价
	public function action_ajax_modifyorderprice() {
		$now=time();
		$ordersn = Common::remove_xss(Arr::get($_POST, 'ordersn'));
		$info = Model_Member_Order::get_order_by_ordersn($ordersn);
		$sql="select modtime from sline_member_order_compute where order_id={$info['id']}";
		$r=DB::query(Database::SELECT,$sql)->execute()->current();
		if ($r['modtime']!=0) {
			if ($now-$r['modtime']<5) {
				echo json_encode(array('status' => false, 'msg' => "凡事慢慢来哦！"));
				return;
			}
		}
		$modprice = Common::remove_xss(Arr::get($_POST, 'price'));
		$total=Model_Member_Order::order_supplier_total_price($ordersn);
		if (!$total) {
			echo json_encode(array('status' => false, 'msg' => "订单编号错误。"));
			return;
		}
		if ($modprice<$total) {
			echo json_encode(array('status' => false, 'msg' => "不能低于{$total}元。"));
			return;
		}
		if ($info['distributor']==$this->mid) {

			$sql="update sline_member_order_compute set total_price={$modprice},modtime={$now} where order_id={$info['id']}";
			DB::query(Database::UPDATE,$sql)->execute();
			Model_Member_Order_Log::add_log($info,'','',"您的服务网点已修改订单金额。");
			echo json_encode(array('status' => true, 'msg' => "订单修改成功！"));
			return;
		}else{
			echo json_encode(array('status' => false, 'msg' => "你不能修改订单！"));
			return;
		}
	}
	public function action_ajax_gettravelers() {
		$start = Arr::get($_GET, 'start');
		$limit = Arr::get($_GET, 'limit');
		$sql = "select count(mid) as total from sline_member where mid in (select mid from sline_relationship where pid=$this->mid)";
		$total = DB::query(Database::SELECT, $sql)->execute()->as_array();
		$sql = "select mid,truename,mobile,email,cardid,logintime,address from sline_member where mid in (select mid from sline_relationship where pid=$this->mid) order by mid asc limit $start,$limit";
		$infoArr = DB::query(Database::SELECT, $sql)->execute()->as_array();
		$result['total'] = $total[0]['total'];
		$result['list'] = $infoArr;
		echo json_encode($result);
	}
	public function action_genexcel() {
		list($starttime, $endtime) = split('/', $this->request->param()['params']);
		$starttime = strtotime($starttime);
		if (empty($starttime)) {
			echo "<script>if(confirm('没有选择开始时间,点击‘确认’退出。')){window.close()}</script>";
			return;
		}
		$endtime = strtotime($endtime);
		if ($starttime > $endtime) {
			echo "<script>if(confirm('开始时间大于结束时间,点击‘确认’退出。')){window.close()}</script>";
			return;
		}
		$sql = "select mid,truename,mobile,email,cardid,logintime,address from sline_member where mid in (select mid from sline_relationship where pid=$this->mid) and jointime>=$starttime and jointime<=$endtime order by mid asc";
		$infoArr = DB::query(Database::SELECT, $sql)->execute()->as_array();

		$excel = $this->gene_excel($infoArr);

		$filename = date('Ymdhis');
		ob_end_clean(); //清除缓冲区
		header('Pragma:public');
		header('Expires:0');
		header('Content-Type:charset=utf-8');
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Content-Type:application/force-download');
		header('Content-Type:application/vnd.ms-excel');
		header('Content-Type:application/octet-stream');
		header('Content-Type:application/download');
		header('Content-Disposition:attachment;filename=' . $filename . ".xls");
		header('Content-Transfer-Encoding:binary');
		echo iconv('utf-8', 'gbk', $excel);
		exit();
	}
	protected function gene_excel($order_list) {

		$table = "<table border='1' ><tr>";
		$table .= "<td>游客编号</td>";
		$table .= "<td>游客姓名</td>";
		$table .= "<td>游客手机</td>";
		$table .= "<td>游客邮箱</td>";
		$table .= "<td>证件号码</td>";
		$table .= "<td>登录时间</td>";
		$table .= "<td>联系地址</td>";
		$table .= "</tr>";
		foreach ($order_list as $row) {

			$table .= "<tr>";
			$table .= "<td>{$row['mid']}</td>";
			$table .= "<td>{$row['truename']}</td>";
			$table .= "<td>{$row['mobile']}</td>";
			$table .= "<td>{$row['email']}</td>";
			$table .= "<td>{$row['cardid']}</td>";
			if ($row['logintime'] == 0) {
				$table .= "<td>未登录</td>";
			} else {
				$table .= "<td>{$row['logintime']}</td>";
			}
			$table .= "<td>{$row['adress']}</td>";
			$table .= "</tr>";
		}

		$table .= "</table>";
		return $table;
	}
}
