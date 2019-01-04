<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Index extends Stourweb_Controller {

	private $_typeid = 0;
	private $_cache_key = '';
	public function before() {
		parent::before();
		//检查缓存
		$this->_cache_key = Common::get_current_url();
		$html = Common::cache('get', $this->_cache_key);
		$genpage = Common::remove_xss(Arr::get($_GET, 'genpage'));

		if (!empty($html) && empty($genpage)) {
			echo $html;
			exit;
		}
		$this->assign('indexpage', 1);
		$this->assign('typeid', $this->_typeid);

	}
	//首页
	public function action_index() 
	{

		$city = St_Functions::st_setStartCity();
		if ($_COOKIE["cityname"] == '') {
			setcookie("cityname", $city['name']);
			setcookie("cityid", $city['id']);
			$GLOBALS['cityname'] = $city['name'];
			$GLOBALS['cityid'] = $city['id'];
			$this->assign('cityname', $city['name']);
			$this->assign('cityid', $city['id']);
		} else {
			$GLOBALS['cityname'] = $_COOKIE['cityname'];
			$GLOBALS['cityid'] = $_COOKIE['cityid'];
		}
		//seo信息
		$seoinfo = array(
			'seotitle' => $GLOBALS['cfg_indextitle'],
			'keyword' => $GLOBALS['cfg_keywords'],
			'description' => $GLOBALS['cfg_description'],
		);
		$channel = Model_Nav::get_all_channel_info();
		$this->assign('channel', $channel);
		$this->assign('seoinfo', $seoinfo);
		$templet = Product::get_use_templet('index');
		if (empty($templet)) {
			$templet = 'index/index_1';
		}
		$this->display($templet);
		//缓存内容
		$content = $this->response->body();
		Common::cache('set', $this->_cache_key, $content);
	}
	public function action_city() {
		$id = $this->request->param('id');
		$name = St_Functions::st_getcityname($id)[0]['cityname'];
		$GLOBALS['cityname'] = $name;
		$GLOBALS['cityid'] = $id;
	}
}