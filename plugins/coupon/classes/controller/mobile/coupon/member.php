<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Mobile_Coupon_Member extends Stourweb_Controller
{
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
    }

    public function action_index()
    {
        $this->display('../mobile/coupon/member/index');
    }

    public function action_ajax_get_list()
    {
        $page = intval(Arr::get($_GET, 'page'));
        $isout = intval(Arr::get($_GET, 'isout'));
        $kindid = intval(Arr::get($_GET, 'kindid'));
        $pagesize = 5;
        $params = array('isout' => $isout, 'kindid' => $kindid);
        $out = Model_Coupon::member_search_result($params, $page, $pagesize);
        $list = Model_Coupon::get_data($out['list']);
        foreach($list as &$k)
        {
            if($isout==2)
            {
                $k['class'] = 'after';
            }
            if($isout==3)
            {
                $k['class'] = 'after';
            }
            $k['isout'] = $isout;

        }
        echo Product::list_search_format($list, $page, $pagesize);
    }


}