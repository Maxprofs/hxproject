<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Mobile_Zt extends Stourweb_Controller{
    /*
     *手机专题控制器
     * */
    public function before()
    {
        parent::before();
    }
    //手机专题展示页面
    public function action_show()
    {
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
           Common::head_404();
        }

        $channel_list = Model_Zt_Channel::get_channel_list($info['id']);
        $info['litpic'] = $info['m_banner'];
        $info['sellpoint'] = St_String::cut_html_str($this->get_sellpoint($info['introduce']),30);



        $this->assign('info',$info);
        $this->assign('channellist',$channel_list);
        $templet = $info['m_templet'];
        if(strpos($templet,'usertpl')===false)
        {
            $templet = '../mobile/zt/show';
            $this->display($templet,'zhuanti_show');
        }
        else
        {
            $templet = $templet.'/index';
            $this->display($templet,NULL,1);
        }

    }

    //专题首页
    public function action_index()
    {
        $seo = Model_Zt::get_channel_seo(1);
        $this->assign('seo',$seo);
        $this->display('../mobile/zt/index', 'zhuanti_index');
    }

    //获取专题列表
    public function action_ajax_get_list()
    {
        $page = $_POST['page'];
        $pagesize = 6;
        $result = Model_Zt::search_result(null, null, $page, $pagesize);

        foreach($result['list'] as &$row)
        {
            $row['addtime_str'] = date('Y-m-d',$row['addtime']);
        }
        echo json_encode($result);
    }
    private function get_sellpoint($str)
    {
        $str = trim($str); //清除字符串两边的空格
        $str = htmlspecialchars_decode($str);
        $str = strip_tags($str,""); //利用php自带的函数清除html格式
        $str = preg_replace("/\t/","",$str); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
        $str = preg_replace("/\r\n/","",$str);
        $str = preg_replace("/\r/","",$str);
        $str = preg_replace("/\n/","",$str);
        $str = preg_replace("/ /","",$str);
        $str = preg_replace("/  /","",$str);
        $str = preg_replace ('/&nbsp;/is', '', $str);//匹配html中的空格
        return $str;
    }














}