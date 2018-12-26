<?php

/**
 * Class Controller_Pub
 */
class Controller_Pub extends Stourweb_Controller
{

    private  $_user_info = NULL;
    //初始化设置
    public function before()
    {
        parent::before();
        //登陆状态判断
        $st_distributor_id = Cookie::get('st_distributor_id');
        if(empty($st_distributor_id))
        {
            $this->request->redirect($GLOBALS['cfg_basehost'].'/plugins/distributor/pc/login');
        }
        else
        {
            $this->_user_info = Model_Supplier::get_distributor_byid($st_distributor_id);
            $this->assign('userinfo',$this->_user_info);
        }
    }
    //头部
    public function action_header()
    {

        $header = Request::factory($GLOBALS['cfg_basehost'].'/plugins/distributor/pc/pub/header?sid='.$this->_user_info['id'])->execute()->body();		
        $this->assign("header",$header);
        $this->display("pub/header");
    }
    //左侧菜单
    public function action_sidemenu()
    {
        $this->display("pub/sidemenu");
    }

    //底部
    public function action_footer()
    {
        $footer = Request::factory($GLOBALS['cfg_basehost'].'/plugins/distributor/pc/pub/footer')->execute()->body();
        $this->assign("footer",$footer);
        $this->display("pub/footer");
    }



 

  
}