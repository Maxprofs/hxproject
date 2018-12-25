<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2018/04/03 15:06
 * Desc: desc
 */
class Controller_Mobile_Envelope_Member extends Stourweb_Controller
{


    function before()
    {
        parent::before();
    }
    public function action_member_list()
    {
        $member = Model_Member_Login::check_login_info();
        if($mid = $member['mid'])
        {
            $backUrl = 'href="javascript:;" onclick="javascript:history.go(-1);"';
            if (stripos($_SERVER['HTTP_REFERER'], Common::cookie_domain()) === false)
            {
                $conf = require dirname(DOCROOT) . '/data/mobile.php';
                $url = Common::get_main_host() . '/phone/';
                if (stripos($conf['domain']['mobile'], $url) === false)
                {
                    $url = $conf['domain']['mobile'];
                }
                $backUrl = 'href="' . $url . '"';
            }
            $config = Model_Sysconfig::get_sys_conf('value','cfg_envelope_description');
            $this->assign('config', $config);
            $this->assign('backurl', $backUrl);
            $this->display('../mobile/envelope/member/list');
        }
        else
        {
            $this->request->redirect('member/login');
        }

    }

    //加载更多
    public function action_ajax_get_more_list()
    {
        $member = Model_Member_Login::check_login_info();
        if($mid = $member['mid'])
        {
            $page = intval($_POST['page']);
            $type = intval($_POST['type']);
            $pagesize = 10 ;


            $offset = ($page-1) * $pagesize;

            $where = "memberid=$mid";
            if($type==1)
            {
                $where .=" and `use`=0";
            }
            elseif ($type==2)
            {
                $where .=" and `use`=1";
            }
            $list = DB::select('id','money','use','typeids')->from('envelope_member')
                ->where($where)->offset($offset)->limit($pagesize)->execute()->as_array();
            foreach ($list as &$l)
            {

                $l['money'] = Currency_Tool::price($l['money']);
                $module_title = DB::select('modulename')->from('model')
                    ->where("id in ({$l['typeids']})")->execute()->as_array('modulename');
                $l['module_title'] = implode(',',array_keys($module_title));
            }
            unset($l);
            $total = count($list);
            $total<$pagesize ? $outpage = -1 : $outpage = ++$page ;
            echo json_encode(array('outpage'=>$outpage,'list'=>$list));

        }


    }



}