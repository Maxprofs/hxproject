<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Photo extends Stourweb_Controller
{
    /*
     * 相册总控制器
     * */

    private $_typeid = 6;
    private $_cache_key = '';

    public function before()
    {
        parent::before();
        //检查缓存
        $this->_cache_key = Common::get_current_url();
        $html = Common::cache('get', $this->_cache_key);
        $genpage = intval(Arr::get($_GET, 'genpage'));
        if (!empty($html) && empty($genpage))
        {
            echo $html;
            exit;
        }
        $channelname = Model_Nav::get_channel_name($this->_typeid);
        $this->assign('typeid', $this->_typeid);
        $this->assign('channelname', $channelname);
    }

    //首页
    public function action_index()
    {
        $this->request->redirect('photos/all');
    }

    //详细页
    public function action_show()
    {

        $aid = intval($this->request->param('aid'));
        $info = Model_Photo::photo_detail($aid);
        if (!$info)
        {
            $this->request->redirect('error/404');
        }
        $seoInfo = Product::seo($info);
        //点击率加一
        Product::update_click_rate($aid, $this->_typeid);
        //picture
        $piclist = Model_Photo::photo_picture($info['id']);
        foreach ($piclist as &$v)
        {
            if (empty($v['description']))
            {
                $v['description'] = $info['content'];
            }
            $v['bigpic'] = !empty($v['bigpic']) ? $v['bigpic'] : $v['litpic'];

        }
        $info['piclist'] = $piclist;
        //属性列表
        $info['attrlist'] = Model_Photo::photo_attr($info['attrid']);
        //点评数
        $info['commentnum'] = Model_Comment::get_comment_num($info['id'], $this->_typeid);


        //图标
        $info['iconlist'] = Product::get_ico_list($info['iconlist']);

        //目的地上级
        if ($info['finaldestid'] > 0)
        {
            $predest = Product::get_predest($info['finaldestid']);
            $this->assign('predest', $predest);
        }
        //扩展字段信息
        $extend_info = Model_Photo::photo_extend($info['id']);
        $this->assign('seoinfo', $seoInfo);
        $this->assign('info', $info);
        $this->assign('extendinfo', $extend_info);
        $this->assign('destid', $info['finaldestid']);
        $this->assign('tagword', $info['tagword']);
        $this->display('photo/show');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);


    }

    //列表页
    public function action_list()
    {
        $seoinfo = Model_Nav::get_channel_seo($this->_typeid);
        $this->assign('seoinfo', $seoinfo);

        //参数值获取
        $destPy = $this->request->param('destpy');
        $sign = $this->request->param('sign');
        $attrId = $this->request->param('attrid');
        $p = intval($this->request->param('p'));
        $attrId = !empty($attrId) ? $attrId : 0;

        $destPy = $destPy ? $destPy : 'all';
        $pagesize = 12;
        $keyword = Common::remove_xss(Arr::get($_GET, 'keyword'));


        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
            'destpy' => $destPy,
            'attrid' => $attrId,
        );
        //$start_time=microtime(true); //获取程序开始执行的时间

        $out = Model_Photo::search_result($route_array, $keyword, $p, $pagesize);
        $pager = Pagination::factory(
            array(

                'current_page' => array('source' => 'route', 'key' => 'p'),
                'view' => 'default/pagination/search',
                'total_items' => $out['total'],
                'items_per_page' => $pagesize,
                'first_page_in_url' => false,
            )
        );
        //配置访问地址 当前控制器方法

        $pager->route_params($route_array);
        $destId = $destPy == 'all' ? 0 : DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id');
        $destId = $destId ? $destId : 0;
        //目的地信息
        $destInfo = array();
        $preDest = array();
        if ($destId)
        {
            $destInfo = Model_Photo::get_dest_info($destId);
            $preDest = Model_Destinations::get_prev_dest($destId);
        }
        else
        {
            $mainNav = DB::select('seotitle', 'shortname', 'description', 'keyword')->from('nav')->where('typeid', '=', $this->_typeid)->execute()->current();
            $destInfo['seotitle'] = !empty($mainNav['seotitle']) ? $mainNav['seotitle'] : $mainNav['shortname'];
            $destInfo['description'] = "<meta name=\"keywords\" content=\"" . $mainNav['description'] . "\"/>";
            $destInfo['keyword'] = "<meta name=\"description\" content=\"" . $mainNav['keyword'] . "\"/>";
        }
        if ($p > 1)
        {
            $destInfo['seotitle'] = '第' . $p . '页_' . $destInfo['seotitle'];
        }
        $channel_info = Model_Nav::get_channel_info($this->_typeid);
        $channel_name = empty($channel_info['seotitle'])?$channel_info['shortname']:$channel_info['seotitle'];
        $seo_params = array(
            'destpy' => $destPy,
            'attrid' => $attrId,
            'p' => $p,
            'keyword' => $keyword,
            'channel_name'=>$channel_name
        );
        $chooseitem = Model_Photo::get_selected_item($route_array);
        $search_title = Model_Photo::gen_seotitle($seo_params);
        $tagword = Model_Photo_Kindlist::get_list_tag_word($destPy);
        $this->assign('tagword', $tagword);
        $this->assign('destid', $destId);
        $this->assign('destinfo', $destInfo);
      
        $this->assign('list', $out['list']);
        $this->assign('chooseitem', $chooseitem);
        $this->assign('searchtitle', $search_title);
        $this->assign('param', $route_array);
        $this->assign('currentpage', $p);
        $this->assign('pageinfo', $pager);

        $templet = St_Functions::get_list_dest_template_pc($this->_typeid,$destId);
        $templet = empty($templet)? Product::get_use_templet('photo_list'):$templet;
        $templet = $templet ? $templet : 'photo/list';
        $this->display($templet);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    public function action_ajax_add_focus()
    {
        if (!$this->request->is_ajax()) exit();
        $key = md5($_SERVER["REMOTE_ADDR"] . $_SERVER['HTTP_REFERER']);
        $session = Session::instance();
        if ($session->get($key))
        {
            echo 2;
            exit;
        }
        $session->set($key, 1);
        $productid = intval(Arr::get($_POST, 'productid'));
        $value_arr = array('favorite' => DB::expr('favorite + 1'));
        $isupdated = DB::update('photo')->set($value_arr)->where('id', '=', $productid)->execute();
        if ($isupdated)
        {
            echo 1;
            exit;
        }
    }

    public function action_ajax_add_comment()
    {
        if (!$this->request->is_ajax()) exit();
        $checkcode = Common::remove_xss(Arr::get($_POST, 'checkcode'));
        $productid = Common::remove_xss(Arr::get($_POST, 'productid'));
        $content = Common::remove_xss(Arr::get($_POST, 'content'));
        $dockid = Common::remove_xss(Arr::get($_POST, 'dockid'));
        $typeid = Common::remove_xss(Arr::get($_POST, 'typeid'));
        //验证码
        $checkcode = strtolower($checkcode);
        if (!Captcha::valid($checkcode))
        {
            echo 1; //验证码错误
            exit;
        }
        $login_user=Model_Member_Login::check_login_info();
        $memberId = $login_user ? $login_user['mid'] : '0';
        $m = ORM::factory('comment');
        $m->articleid = $productid;
        $m->content = $content;
        $m->dockid = $dockid;
        $m->typeid = $typeid;
        $m->memberid = $memberId;
        $m->addtime = time();
        $m->save();
        if ($m->saved())
        {
            echo 3;
            exit;
        }
    }

}