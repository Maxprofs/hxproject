<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Notes_Member extends Stourweb_Controller
{
    /*
     * 游记会员中心控制器
     * */

    private $_typeid = 101;
    private $_mid = '';
    public function before()
    {
        parent::before();

        $this->refer_url = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $GLOBALS['cfg_cmsurl'];
        $this->assign('backurl', $this->refer_url);
        $user = Model_Member::check_login();
        if (!empty($user['mid']))
        {
            $this->_mid = $user['mid'];
        }
        else
        {
            $this->request->redirect('member/login');
        }
        $this->assign('mid', $this->_mid);
        $this->assign('typeid',$this->_typeid);
    }
    //我的游记
    public function action_mynotes()
    {

        $pageSize = 10;

        $page = intval(Arr::get($_GET, 'p'));
        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action()
        );

        $out = Model_Notes::member_notes_list($this->_mid, $page, $pageSize);
        $pager = Pagination::factory(
            array(
                'current_page' => array('source' => 'query_string', 'key' => 'p'),
                'view' => 'default/pagination/search',
                'total_items' => $out['total'],
                'items_per_page' => $pageSize,
                'first_page_in_url' => false,
            )
        );
        //配置访问地址 当前控制器方法
        $pager->route_params($route_array);
        $this->assign('pageinfo', $pager);
        $this->assign('list', $out['list']);
        $this->display('notes/member/mynotes');

    }
    //自动补全目的地
    public function action_ajax_autocomplete(){
        $data=array('hasdata'=>0);
        $param = Common::remove_xss($_GET['key']);


        $sql=DB::select('id','kindname')->from('destinations')->where('kindname','like','%'.$param.'%')->and_where(DB::expr('FIND_IN_SET(4,opentypeids)'),'>',0);
        $result=$sql->execute()->as_array();
        if($result){
            $data['hasdata']=1;
            $data['list']=$result;
        }
        echo json_encode($data);
    }
}