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
        $st_supplier_id = Cookie::get('st_supplier_id');

        if(empty($st_supplier_id))
        {
            $this->request->redirect($GLOBALS['cfg_basehost'].'/plugins/supplier/pc/login');
        }
        else
        {
            $this->_user_info = Model_Supplier::get_supplier_byid($st_supplier_id);
            $this->assign('userinfo',$this->_user_info);
        }
    }
    //头部
    public function action_header()
    {
        $header = Request::factory($GLOBALS['cfg_basehost'].'/plugins/supplier/pc/pub/header?sid='.$this->_user_info['id'])->execute()->body();
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
        $footer = Request::factory($GLOBALS['cfg_basehost'].'/plugins/supplier/pc/pub/footer')->execute()->body();
        $this->assign("footer",$footer);
        $this->display("pub/footer");
    }



 

  
}