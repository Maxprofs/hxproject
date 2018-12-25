<?php defined('SYSPATH') or die('No direct script access.');



class Controller_Pc_Coupon_Member extends Stourweb_Controller
{

    private $_cache_key = '';

    public function before()
    {
        parent::before();
        //检查登陆信息
        $userInfo = Product::get_login_user_info();
        if(empty($userInfo))
        {
            $this->request->redirect('member/login');
            $this->assign('mid', $userInfo['mid']);
        }
        //检查缓存
        $this->_cache_key = Common::get_current_url();
        $html = Common::cache('get', $this->_cache_key);
        $genpage = Common::remove_xss(Arr::get($_GET, 'genpage'));
        if (!empty($html) && empty($genpage))
        {
            echo $html;
            exit;
        }
    }


  public function action_index()
  {

      $p = intval($this->request->param('p'));
      $isout = intval($this->request->param('isout'));
      $kindid = intval($this->request->param('kindid'));
      $pagesize = 12;
      $route_array = array(
          'controller' => $this->request->controller(),
          'action' => $this->request->action(),
          'isout'=>$isout,
          'kindid'=>$kindid
      );
      $out = Model_Coupon::member_search_result($route_array, $p, $pagesize);
      $pager = Pagination::factory(
          array(
              'current_page' => array('source' => 'route', 'key' => 'p'),
              'view' => 'default/pagination/search',
              'total_items' => $out['total'],
              'items_per_page' => $pagesize,
              'first_page_in_url' => false,
          )
      );
      //配置访问地址 当前控制器方法
      $pager->route_params($route_array);
      $this->assign('list', $out['list']);
      $this->assign('param', $route_array);
      $this->assign('currentpage', $p);
      $this->assign('pageinfo', $pager);
      $this->display('coupon/member/index');

  }



}