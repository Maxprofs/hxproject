<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Pc_Article extends Stourweb_Controller{
    /*
     * 攻略总控制器
     * */

    private $typeid = 4;
    private $_cache_key = '';
    public function before()
    {
        parent::before();
        //检查缓存
        $this->_cache_key = Common::get_current_url();
        $html = Common::cache('get',$this->_cache_key);
        $genpage = intval(Arr::get($_GET,'genpage'));
        if(!empty($html) && empty($genpage))
        {
            echo $html;
            exit;
        }
        $channelname = Model_Nav::get_channel_name($this->typeid);
        $this->assign('typeid', $this->typeid);
        $this->assign('channelname', $channelname);
    }

    //首页
    public function action_index()
    {
        $seoinfo = Model_Nav::get_channel_seo($this->typeid);
        $this->assign('seoinfo', $seoinfo);
        $templet = Product::get_use_templet('article_index');
        $templet = $templet ? $templet : 'article/index';
        $this->display($templet);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set',$this->_cache_key,$content);
    }
    //详细页
    public function action_show()
    {
        $aid = intval($this->request->param('aid'));
        $info = Model_Article::detail_aid($aid);
        if (!$info)
        {
            $this->request->redirect('error/404');
        }
		//301重定向
		if(!empty($info['redirecturl']))
		{
			header( "HTTP/1.1 301 Moved Permanently" );    
			header( "Location: {$info['redirecturl']}" );
			exit();
		}
        //seo
        $seoInfo = Product::seo($info);

        //属性列表
        $info['attrlist'] = Model_Article::attr($info['attrid']);
        //点评数
        $info['commentnum'] = Model_Comment::get_comment_num($info['id'], $this->typeid);
        //产品图标
        $info['iconlist'] = Product::get_ico_list($info['iconlist']);
        //上一条,下一条
        $info['prev'] = Model_Article::get_prev_next('prev',$info['id']);
        $info['next'] = Model_Article::get_prev_next('next',$info['id']);
        //目的地上级
        if($info['finaldestid']>0)
        {
            $predest = Product::get_predest($info['finaldestid']);
            $this->assign('predest',$predest);
            $this->assign('destid',$info['finaldestid']);
        }
        //用户信息
        $userInfo = Product::get_login_user_info();

        //扩展字段信息
        $extend_info = Model_Article::extend($info['id']);
        $this->assign('seoinfo', $seoInfo);
        $this->assign('info', $info);
        $this->assign('userinfo',$userInfo);
        $this->assign('extendinfo',$extend_info);


        $this->assign('destid',$info['finaldestid']);
        $this->assign('tagword',$info['tagword']);

        $templet = Product::get_use_templet('article_show');
        $templet = $templet ? $templet : 'article/show';
        $this->display($templet);
        Product::update_click_rate($info['aid'], $this->typeid);

        //缓存内容
        $content = $this->response->body();
        Common::cache('set',$this->_cache_key,$content);

    }
    public function action_ajax_comment(){
        $params = array();
        $params['page'] = intval($this->request->param('params'));
        $params['row'] = 5;
        $params['typeid'] = $this->typeid;
        $params['controller'] = 'article';
        $params['articleid']=intval($_GET['articleid']);
        $result = Product::content_comment($params);
        foreach($result['data'] as &$v){
            $v['member']['litpic']=Common::img($v['member']['litpic'],29,29);
            $v['addtime'] = date('Y-m-d',strtotime($v['addtime']));
        }
        echo json_encode($result);
    }
    //列表页
    public function action_list()
    {
        $req_uri = $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $is_all = false;
        if (Common::get_web_url(0) . '/raiders/all' == $req_uri || Common::get_web_url(0) . '/raiders/all/' == $req_uri)
        {
            $is_all = true;
        }
        //参数值获取
        $destPy = $this->request->param('destpy');
        $sign = $this->request->param('sign');
        $attrId = $this->request->param('attrid');
        $p = intval($this->request->param('p'));
        $attrId = !empty($attrId) ? $attrId : 0;
        $sorttype = $this->request->param('sorttype');
        $sorttype = empty($sorttype)?0:$sorttype;
        $destPy = $destPy ? $destPy : 'all';
        $pagesize = 10;
        $keyword = Common::remove_xss(Arr::get($_GET,'keyword'));
        $keyword = strip_tags($keyword);
        $keyword = St_String::filter_mark($keyword);


        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
            'destpy' => $destPy,
            'sorttype' =>$sorttype,
            'attrid' => $attrId,
        );
        //$start_time=microtime(true); //获取程序开始执行的时间

        $out = Model_Article::search_result($route_array,$keyword,$p,$pagesize);
        $pager = Pagination::factory(
            array(

                'current_page' => array('source' => 'route', 'key' => 'p'),
                'view'=>'default/pagination/search',
                'total_items' => $out['total'],
                'items_per_page' => $pagesize,
                'first_page_in_url' => false,
            )
        );
        //配置访问地址 当前控制器方法

        $pager->route_params($route_array);
        $destId = $destPy=='all' ? 0 : DB::select('id')->from('destinations')->where('pinyin','=',$destPy)->execute()->get('id');
        $destId = $destId ? $destId : 0;

        Common::check_is_sub_web($destId,'raiders/'.$destPy);
        //目的地信息
        $destInfo = array();
        $preDest = array();
        if($destId)
        {
            //$destInfo = ORM::factory('destinations',$destId)->as_array();
            $destInfo = Model_Article::get_dest_info($destId);

        }

        $channel_info = Model_Nav::get_channel_info($this->typeid);
        $channel_name = empty($channel_info['seotitle'])?$channel_info['shortname']:$channel_info['seotitle'];
        $seo_params = array(
            'destpy' => $destPy,
            'attrid' => $attrId,
            'p'=>$p,
            'keyword'=>$keyword,
            'channel_name'=>$channel_name
        );
        $chooseitem = Model_Article::get_selected_item($route_array);
        $search_title = Model_Article::gen_seotitle($seo_params);
        $tagword = Model_Article_Kindlist::get_list_tag_word($destPy);
        $this->assign('tagword', $tagword);
        $this->assign('destid',$destId);
        $this->assign('destinfo',$destInfo);
        $this->assign('list',$out['list']);
        $this->assign('chooseitem',$chooseitem);
        $this->assign('searchtitle',$search_title);
        $this->assign('param',$route_array);
        $this->assign('currentpage',$p);
        $this->assign('pageinfo',$pager);
        $this->assign('total_count',$out['total']);
        $this->assign('is_all', $is_all);


        $templet = St_Functions::get_list_dest_template_pc($this->typeid,$destId);
        $templet = empty($templet)?Product::get_use_templet('article_list'):$templet;
        $templet = $templet ? $templet : 'article/list';
        $this->display($templet);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set',$this->_cache_key,$content);
    }


    public function action_ajax_add_comment()
    {
        if(!$this->request->is_ajax())exit();
        $checkcode = Arr::get($_POST,'checkcode');
        $articleid =intval(Arr::get($_POST,'articleid'));

        $content = Common::remove_xss(Arr::get($_POST,'content'));
        $typeid = intval(Arr::get($_POST,'typeid'));
        $dockid = intval(Arr::get($_POST,'dockid'));

        $checkcode=strtolower($checkcode);
        $passed=Captcha::valid($checkcode);
        Session::instance()->delete('captcha_response');
        if(!$passed)
        {
            echo 1; //验证码错误
            exit;
        }
        $login_user=Model_Member_Login::check_login_info();
        $memberId = $login_user ?  $login_user['mid'] :  '0';
        $m = ORM::factory('comment');
        $m->articleid = $articleid;
        $m->content = $content;
        $m->typeid = $typeid;
        $m->memberid = $memberId;
        $m->dockid = $dockid;
        $m->addtime = time();
        //是否开启审核
        if($GLOBALS['cfg_article_pinlun_audit_open'] == 0)
        {
            $m->isshow = 1;
        }
        $m->save();
        if($m->saved())
        {
            $comment=$m->as_array();
            if($comment['isshow']==1)
            {
                Model_Comment::on_verified($comment['id'],$typeid,$memberId);
            }
            echo 3;
            exit;
        }
    }










}