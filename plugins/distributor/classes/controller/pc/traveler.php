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
		if ($starttime>$endtime) {
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
