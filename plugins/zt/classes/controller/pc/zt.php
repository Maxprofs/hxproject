<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Pc_Zt extends Stourweb_Controller{
    /*
     * PC专题控制器
     * */
    public function before()
    {
        parent::before();
    }
    //pc展示页面
    public function action_show()
    {

        $userinfo = Product::get_login_user_info();
        $this->assign('userinfo',$userinfo);
        $param = $this->request->param('pinyin');
        if(is_numeric($param))
        {
            $info = DB::select()->from('zt')->where('id','=',$param)->execute()->current();
            //如果拼音存在则作301跳转.
            if(!empty($info['pinyin']))
            {
                $this->request->redirect('zt/'.$info['pinyin'],301);
            }
        }
        else
        {
            $info = DB::select()->from('zt')->where('pinyin','=',$param)->execute()->current();
        }
        if(empty($info['id']))
        {
            $this->request->redirect('error/404');
        }

        $channel_list = Model_Zt_Channel::get_channel_list($info['id']);
        $this->assign('info',$info);
        $this->assign('channellist',$channel_list);
        $templet = $info['pc_templet'];


        if(strpos($templet,'usertpl')===false)
        {
            $templet = Product::get_use_templet('zhuanti_show');
            $templet = empty($templet)?'zt/show':$templet;
        }
        else
        {
            $templet.='/index';
        }
        $this->display($templet);
    }

    public function action_index()
    {
        $seo = Model_Zt::get_channel_seo();
        $p = intval($_GET['p']);
        $sorttype = intval($_GET['sorttype']);
        $pagesize = 12;

        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
            'sorttype'=>$sorttype
        );
        $result = Model_Zt::search_result($route_array, null, $p, $pagesize);
        $pager = Pagination::factory(
            array(
                'current_page' => array('source' => 'query_string', 'key' => 'p'),
                'view' => 'default/pagination/search',
                'total_items' => $result['total'],
                'items_per_page' => $pagesize,
                'first_page_in_url' => false,
            )
        );
        //配置访问地址 当前控制器方法

        $this->assign('total',$result['total']);
        $this->assign('sorttype',$sorttype);
        $pager->route_params($route_array);
        $this->assign('pageinfo', $pager);
        $this->assign('list',$result['list']);
        $this->assign('seo',$seo);
        $templet = Product::get_use_templet('zhuanti_index');
        $templet = $templet ? $templet : 'zt/index';
        $this->display($templet);
    }













}