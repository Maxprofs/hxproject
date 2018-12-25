<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2018/04/04 11:26
 * Desc: desc
 */
class Controller_Pc_Envelope_Member extends Stourweb_Controller
{

    private $mid = null;
    function before()
    {
        parent::before();
        $user = Model_Member::check_login();
        if (!empty($user['mid']))
        {
            $this->mid = $user['mid'];
        }
        else
        {
            $this->request->redirect('member/login');
        }
    }


    public function action_list()
    {

        $type = $this->request->param('type') ? $this->request->param('type') : 1;
        $pagesize = 12;
        $page = $this->request->param('p') ? $this->request->param('p') : 1;
        $out = Model_Order_Envelope::get_member_list($this->mid,$type,$pagesize,$page);
        $pager = Pagination::factory(
            array(
                'current_page' => array('source' => 'route', 'key' => 'p'),
                'view' => 'default/pagination/search',
                'total_items' => $out['total'],
                'items_per_page' => $pagesize,
                'first_page_in_url' => false,
            )
        );
        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
            'type'=>$type,
            'p'=>$page
        );

        //配置访问地址 当前控制器方法
        $pager->route_params($route_array);

        $config = Model_Sysconfig::get_sys_conf('value','cfg_envelope_description');
        //未使用的数量
        $unuse_number = DB::select(DB::expr('count(*) as num'))
            ->from('envelope_member')->where('memberid','=',$this->mid)
            ->and_where('use','=',0)->execute()->get('num');
        //使用数量
        $use_number = DB::select(DB::expr('count(*) as num'))
            ->from('envelope_member')->where('memberid','=',$this->mid)
            ->and_where('use','=',1)->execute()->get('num');
        $this->assign('list',$out['list']);
        $this->assign('unuse_number',$unuse_number);
        $this->assign('use_number',$use_number);
        $this->assign('config',$config);
        $this->assign('type',$type);
        $this->assign('pageinfo',$pager);
        $this->display('envelope/member/list');
    }

}