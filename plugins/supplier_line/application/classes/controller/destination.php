<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Destination extends Stourweb_Controller {

	private $product_arr = array(1 => 'line', 2 => 'hotel', 3 => 'car', 4 => 'article', 5 => 'spot', 6 => 'photo', 13 => 'tuan');
	private $name_arr = array(1 => '线路', 2 => '酒店', 3 => '租车', 4 => '文章', 5 => '景点', 6 => '相册', 13 => '团购');

	public function before() {
		parent::before();

	}

	public function action_ajax_getNextDestList() {
		$pid = Arr::get($_POST, 'pid');
		$keyword = Arr::get($_POST, 'keyword');
		$pid = empty($pid) ? 0 : $pid;

		if ($keyword) {
			$sql = "select id,kindname,pinyin from sline_destinations where kindname like '%{$keyword}%' order by pinyin asc";
		} else {
			$sql = "select id,kindname,pinyin from sline_destinations where pid=$pid  order by pinyin asc";
		}

		$destlist = DB::query(Database::SELECT, $sql)->execute()->as_array();

		echo json_encode($destlist);
	}

	/*
		      获取下级目的地和已设置的目的地名称,用于产品的目的地设置
	*/
	public function action_ajax_getDestsetList() {
		$st_supplier_id = Cookie::get('st_supplier_id');
		$userinfo = Model_Supplier::get_supplier_byid($st_supplier_id);
		$pid = Arr::get($_POST, 'pid');
		$keyword = Arr::get($_POST, 'keyword');
		$pid = empty($pid) ? 0 : $pid;
		$kindlist = Arr::get($_POST, 'kindlist');
		if ($keyword) {
			$sql = "select id,kindname,pinyin from sline_destinations where kindname like '%{$keyword}%' and isopen=1 and find_in_set({$userinfo['id']},supplierids) and find_in_set(1,opentypeids) order by pinyin asc";
		} else {
			$sql = "select id,kindname,pinyin from sline_destinations where isopen=1 and find_in_set({$userinfo['id']},supplierids) and find_in_set(1,opentypeids)  order by pinyin asc";
		}

		$destlist = DB::query(Database::SELECT, $sql)->execute()->as_array();

		foreach ($destlist as $key => $row) {
			// $sql = "select count(*) as num from sline_destinations where pid='{$row['id']}' and isopen=1  and find_in_set({$userinfo['id']},supplierids) and find_in_set(1,opentypeids)";
			// $r = DB::query(1, $sql)->execute()->as_array();
			// $destlist[$key]['childnum'] = $r[0]['num'];
            $destlist[$key]['childnum'] = '';
		}
		if ($kindlist) {
			$_arr = explode(',', $kindlist);
			foreach ($_arr as $k => $v) {
				$_dest = ORM::factory('destinations', $v);
				if ($_dest->id) {
					$nv['id'] = $_dest->id;
					$nv['kindname'] = $_dest->kindname;
					$new_arr[] = $nv;
				}
			}
		}
		$dest_parents = Model_Destinations::getParents($pid);
		echo json_encode(array('nextlist' => $destlist, 'selected' => $new_arr, 'parents' => $dest_parents));
	}

	public function action_ajax_setdest() {
		$typeid = Arr::get($_POST, 'typeid');
		$productid = Arr::get($_POST, 'productid');
		$kindlist = Arr::get($_POST, 'kindlist');

		$productid_arr = explode('_', $productid);

		$is_success = 'ok';
		foreach ($productid_arr as $k => $v) {
			if ($typeid <= 14) //是否是扩展模型
			{
				$model = ORM::factory($this->product_arr[$typeid], $v);
			} else {
				$model = ORM::factory('model_archive', $v);
			}

			if ($model->id) {
				$model->kindlist = $kindlist;
				$model->save();
				if (!$model->saved()) {
					$is_success = 'no';
				}

			}
		}

		echo $is_success;
		/*
			        $model=ORM::factory($product_arr[$typeid],$productid);
			        $kindlist=trim($kindlist,',');
			        $model->kindlist=$kindlist;
			        $model->save();
			        if($model->saved())
			           echo 'ok';
			        else
			           echo 'no';
		*/

	}

	public function action_dialog_setdest() {

		$id = $_GET['id'];
		$kindlist = $_GET['kindlist'];
		$finaldestid = $_GET['finaldestid'];
		$selector = $_GET['selector'];
		$typeid = $_GET['typeid'];
		$destList = $this->getProductDests($id, $typeid);
		if ($kindlist) {
			$destList = Model_Destinations::getKindlistArr($kindlist);

		}
		$finalDest = $this->getProductFinalDest($id, $typeid);
		if ($finaldestid) {
			$finalDest = ORM::factory('destinations', $finaldestid)->as_array();
		}
		$this->assign('id', $id);
		$this->assign('selector', urldecode($selector));
		$this->assign('finalDest', $finalDest);
		$this->assign('destList', $destList);

		$this->display('destination/dialog_setdest');
	}

	public function action_dialog_basicinfo() {
		$id = $_GET['id'];
		$model = ORM::factory('destinations', $id);
		if (!$model->loaded()) {
			exit('wrong id');
		}

		$info = $model->as_array();
		$this->assign('info', $info);
		$this->assign('id', $id);
		$this->assign('pics', Common::getUploadPicture($info['piclist']));
		$this->assign('templetlist', Common::getUserTemplteList('dest_index'));
		$this->display("destination/dialog_basicinfo");
	}

	public function action_dialog_productinfo() {
		$id = $_GET['id'];
		$typeid = $_GET['typeid'];
		$moduleinfo = Model_Model::getModuleInfo($typeid);
		$product_dest_table = $moduleinfo['pinyin'] . '_kindlist';
		$model = new Model_Tongyong($product_dest_table);
		$info = $model->where("kindid", '=', $id)->find()->as_array();

		$pageName = $moduleinfo['pinyin'] . '_list';
		$templateList = Model_Page_Config::getTemplateList($pageName);
		$this->assign('templateList', $templateList);
		$this->assign('id', $id);
		$this->assign('typeid', $typeid);
		$this->assign('info', $info);
		$this->display('destination/dialog_productinfo');

	}

	public function action_dialog_attrdest() {
		$id = $_GET['id'];
		$typeid = $_GET['typeid'];
		if ($typeid != 12) {
			$model = ORM::factory('model', $typeid);
			if (!$model->loaded()) {
				return null;
			}

			$table = $model->attrtable;
			$attrModel = ORM::factory($table, $id);
			if (!$attrModel->loaded()) {
				return null;
			}

			$destList = Model_Destinations::getKindlistArr($attrModel->destid);
			$this->assign('destList', $destList);
		} else {

			$model = ORM::factory('destinations_attr', $id);
			if ($model->loaded()) {
				$this->assign('destList', Model_Destinations::getKindlistArr($model->destid));
			}

		}
		$this->assign('id', $id);
		$this->assign('typeid', $typeid);
		$this->display('destination/dialog_setdest');
	}

	public function action_dialog_setweb() {
		$id = $_GET['id'];
		$pinyin = $_GET['pinyin'];
		if (empty($id)) {
			exit('Wrong ID');
		}

		$this->assign('id', $id);
		$this->assign('pinyin', $pinyin);
		$this->display('destination/dialog_setweb');
	}

	public function getProductDests($id, $typeid) {
		if (empty($id) || empty($typeid)) {
			return null;
		}

		$model = ORM::factory('model', $typeid);
		if (!$model->loaded()) {
			return null;
		}

		$table = $model->maintable;
		$info = ORM::factory($table, $id);
		if (!$info->loaded()) {
			return null;
		}

		$destList = Model_Destinations::getKindlistArr($info->kindlist);
		return $destList;
	}

	public function getProductFinalDest($id, $typeid) {
		if (empty($id) || empty($typeid)) {
			return null;
		}

		$model = ORM::factory('model', $typeid);
		if (!$model->loaded()) {
			return null;
		}

		$table = $model->maintable;
		$info = ORM::factory($table, $id);
		if (!$info->loaded()) {
			return null;
		}

		$destid = $info->finaldestid;
		$destObj = ORM::factory('destinations', $destid);
		if ($destObj->loaded()) {
			return $destObj->as_array();
		}
		return null;
	}

}