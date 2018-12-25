<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Notes
 * @desc 游记
 */
class Controller_Mobile_Notes extends Stourweb_Controller
{
    private $_typeid = 101;   //产品类型
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

        $channelname = Model_Nav::get_channel_name_mobile($this->_typeid);
        $this->assign('typeid',$this->_typeid);
        $this->assign('channelname',$channelname);
    }

    /**
     * 游记首页
     */
    public function action_index()
    {
        //参数处理
        $paras = explode('-', Common::remove_xss($this->request->param('params')));

        $destPy = $paras[0];
        $destPy = $destPy=='all'?'0':$destPy;

        $sorttype = empty($paras[1]) ? "0" : $paras[1];
        $keyword = Common::remove_xss($_GET["keyword"]);

        $destinfo = Model_Destinations::get_dest_bypinyin($destPy);
        $destid = empty($destinfo['id']) ? "0" : $destinfo["id"];
        $destname = empty($destinfo['id'])?'目的地':$destinfo['kindname'];

        $seoinfo = Model_Nav::get_channel_seo_mobile($this->_typeid);

        $pagesize=10;
        $list = Model_Notes::search($destid,$keyword,$sorttype,1,0,$pagesize);
        foreach($list as &$row)
        {
            $row['litpic'] = empty($row['litpic'])?Common::nopic():Common::img($row['litpic'],690,469);
            $memberInfo = Model_Member::get_member_byid($row['memberid']);
            $row['memberinfo'] = $memberInfo;
        }
        $this->assign('list',$list);
        $this->assign('seoinfo',$seoinfo);
        $this->assign('destid', $destid);
        $this->assign('destname',$destname);
        $this->assign('sorttype', $sorttype);
        $this->assign('pagesize',$pagesize);

        $this->assign('keyword', $keyword);
        $this->display('../mobile/notes/index','notes_index');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    public function action_ajax_get_more()
    {
        $pagesize = intval($_POST['pagesize']);
        $page = intval($_POST['page']);
        $page = empty($page)?1:$page;
        $destid=$_POST['destid'];
        $sortype = $_POST['sorttype'];
        $keyword = $_POST['keyword'];
        $offset = $pagesize*($page-1);
        $list=Model_Notes::search($destid,$keyword,$sortype,1,$offset,$pagesize);
        foreach($list as &$row)
        {
            $row['litpic'] = empty($row['litpic'])?Common::nopic():Common::img($row['litpic'],690,345);
            $memberInfo = Model_Member::get_member_byid($row['memberid']);
            $row['modtime'] = date('Y-m-d',$row['modtime']);
            $row['memberinfo'] = $memberInfo;
        }
        echo Product::list_search_format($list,$page-1,$pagesize);
    }

    /**
     * 详细页
     */
    public function action_show()
    {
        $id = intval($this->request->param('id'));
        $noteModel=ORM::factory('notes',$id);

        $member = Model_Member_Login::check_login_info();
        if(!$noteModel->loaded())
        {
            Common::head_404();
        }
        if($noteModel->status!=1 && $noteModel->memberid!=$member['mid'])
        {
            Common::head_404();
        }
        $noteModel->shownum=intval($noteModel->shownum)+1;
        $noteModel->save();
        $noteModel->reload();
        $info=$noteModel->as_array();
        if(empty($info['litpic']))
        {
            $info['litpic']=$info['bannerpic'];
        }
        $memberInfo = Model_Member::get_member_byid($info['memberid']);
        $info['memberinfo'] = $memberInfo;
        $info['articleid'] = $info['id'];
        $info['commentnum'] = Model_Comment::get_comment_num($info['id'],$this->_typeid);
        $seoinfo = Product::seo($info);
        //前台显示虚拟阅读量+真实阅读量
        $info['shownum'] += $info['read_num'];
        $this->assign('seoinfo',$seoinfo);
        $this->assign('info',$info);
        $this->display('../mobile/notes/show','notes_show');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

}