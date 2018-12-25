<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Hotel
 * @desc 酒店总控制器
 */
class Controller_Mobile_Article extends Stourweb_Controller
{
    private $_typeid = 4;   //产品类型
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
     * 酒店首页
     */
    public function action_index()
    {
         $seoinfo = Model_Nav::get_channel_seo_mobile($this->_typeid);
         $this->assign('seoinfo',$seoinfo);
         $this->display('../mobile/article/index','article_index');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /**
     * 详细页
     */
    public function action_show()
    {
        $aid = intval($this->request->param('aid'));
        //子站内容显示
        if(isset($_GET['webid']))
        {
            $GLOBALS['sys_webid'] =intval(Arr::get($_GET,'webid'));
        }
        $row = Model_Article::get_article_details($GLOBALS['sys_webid'], $aid);
        //点击率加一
        Product::update_click_rate($aid, $this->_typeid);
        if(count($row) <= 0)
        {
           // $this->request->redirect('error/404');
            Common::head_404();
        }

        $row = Model_Article::get_article_attachinfo($row);
        $row = $row[0];

        $seoinfo = Product::seo($row);

        $this->assign('seoinfo',$seoinfo);
        $this->assign('info',$row);
        $this->assign('tagword', $row['tagword']);
        $this->display('../mobile/article/show','article_show');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /**
     * 搜索结果
     */
    public function action_list()
    {
        //参数处理
        $paras = explode('-', $this->request->param('params'));
        $dest = $paras[0];
        $sorttype = empty($paras[1]) ? "0" : $paras[1];
        $attrid = empty($paras[2]) ? "0" : $paras[2];
        $keyword = Common::remove_xss($_GET["keyword"]);

        $destinfo = Model_Destinations::get_dest_bypinyin($dest);
        $destId = empty($destinfo["id"]) ? "0" : $destinfo["id"];
        $destname =$dest!='all' ? DB::select('kindname')->from('destinations')->where('pinyin','=',$dest)->execute()->get('kindname') : '目的地';

        $page =intval(Arr::get($_GET, 'page'));
        $page = $page < 1 ? 1 : $page;

        $seo_params = array(
            'destpy' => $dest,
            'attrid' => $attrid,
            'p'=>$page,
            'keyword'=>$keyword
        );
        $search_title = Model_Article::gen_seotitle($seo_params);
        $this->assign('search_title',$search_title);

        //获取seo信息
        $seo = Model_Destinations::search_seo($dest, $this->_typeid);
        $this->assign('seoinfo', $seo);
        $this->assign('destid', $destId);
        $this->assign('destname',$destname);
        $this->assign('destpy',$dest);
        $this->assign('sorttype', $sorttype);
        $this->assign('attrid', $attrid);
        $this->assign('keyword', $keyword);
        $this->assign('page', $page);

        $this->display('../mobile/article/list','article_list');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /**
     * 搜索页
     */
    public function action_search()
    {
        $this->display('../mobile/article/search');
    }

    public
    function action_searchnav()
    {
        $this->assign('typeid', $this->_typeid);
        $this->display('../mobile/article/searchnav');
    }

    /*
 * 选择目的地
 */
    public
    function action_ajax_get_next_dests()
    {
        $destpy = $_POST['destpy'];
        $typeid = $_POST['typeid'];
        $isparent = $_POST['isparent'];
        $destpy = empty($destpy) ? 'all' : $destpy;
        $dest_info = array('id' => '0', 'kindname' => '目的地', 'pinyin' => 'all');
        $pid = 0;
        if ($destpy != 'all')
        {
            $dest_info = DB::select()->from('destinations')->where('pinyin', '=', $destpy)->execute()->current();
            $subnum = DB::select(array(DB::expr("count(*)"), 'num'))->from('destinations')->where('pid', '=', $dest_info['id'])->and_where('isopen', '=', 1)->and_where(DB::expr("FIND_IN_SET({$typeid},opentypeids)"), '>', 0)->execute()->get('num');
            $pid = $isparent == 1 || $subnum <= 0 ? $dest_info['pid'] : $dest_info['id'];
        }
        $parents = null;
        if ($pid != 0)
        {
            $parents = Model_Destinations::get_parents($pid);
            $parents = array_reverse($parents);
            $parents[] = $dest_info;
        }
        $list = DB::select('id', 'pinyin', 'kindname')->from('destinations')->where('isopen', '=', 1)->and_where('pid', '=', $pid)->and_where(DB::expr("FIND_IN_SET({$typeid},opentypeids)"), '>', 0)->execute()->as_array();
        foreach ($list as &$child)
        {
            $child['subnum'] = DB::select(array(DB::expr("count(*)"), 'num'))->from('destinations')->where('pid', '=', $child['id'])->and_where('isopen', '=', 1)->and_where(DB::expr("FIND_IN_SET({$typeid},opentypeids)"), '>', 0)->execute()->get('num');
        }
        $parent = DB::select('id', 'kindname', 'pinyin')->from('destinations')->where('id', '=', $pid)->execute()->current();
        echo json_encode(array('status' => true, 'list' => $list, 'parents' => $parents, 'parent' => $parent));
    }

    /**
     * @return string|void
     */
    public function action_ajax_article_order()
    {
        if(!$this->request->is_ajax())return '';
        $offset =  intval(Arr::get($_GET,'offset'));
        $count =  intval(Arr::get($_GET,'count'));
        $havepic =  intval(Arr::get($_GET,'havepic'));

        $rows = Model_Article::get_article_order($offset, $count, $havepic);
        if(count($rows) <= 0)
        {
            echo json_encode(false);
            return false;
        }
        $rows = Model_Article::get_article_attachinfo($rows);

        foreach($rows as &$row)
        {
            $row['litpic'] = Common::img($row['litpic'],690,345);
            $row['summary'] = Common::cutstr_html($row['summary'], 100);
        }

        echo json_encode(array('list'=>$rows));
    }

    /**
     * ajax请求 加载更多
     * @param string $pagesize
     * @return string|void
     */
    public function action_ajax_article_more($pagesize = '10')
    {
        if (!$this->request->is_ajax()) return '';
        $page = intval(Arr::get($_GET, 'page'));
        $offset = (intval($page) - 1) * $pagesize;
        $destpy = $_GET['destpy'];
        $destinfo = Model_Destinations::get_dest_bypinyin($destpy);
        $destid = empty($destinfo["id"]) ? "0" : $destinfo["id"];
        $sorttype =intval(Arr::get($_GET, 'sorttype'));
        $attrid = Arr::get($_GET, 'attrid');
        $keyword =Arr::get($_GET, 'keyword');

        $rows = Model_Article::search_article($destid, $attrid, $keyword, $offset, $pagesize, false, $sorttype);

        if (count($rows) <= 0)
        {
            echo json_encode(false);
            return false;
        }
        $data = Model_Article::get_article_attachinfo($rows);

        foreach ($data as &$v)
        {
            $v['litpic'] = Common::img($v['litpic'],220,150);
            $v['summary'] = Common::cutstr_html($v['summary'], 40);
            $v['modtime'] = date('Y-m-d',$v['modtime']);
        }

        echo Product::list_search_format($data, $page);
    }
}