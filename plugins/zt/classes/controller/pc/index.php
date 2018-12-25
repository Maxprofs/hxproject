<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Pc_Index extends Stourweb_Controller{
    /*
     * PC专题控制器
     * */
    public function before()
    {
        parent::before();
    }
    //pc展示页面
    public function action_index()
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
            $templet = 'index';
        }
        else
        {
            $templet.='/index';
        }
        $this->display($templet);


    }














}