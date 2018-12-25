<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Photo 相册
 */
class Controller_Mobile_Photo extends Stourweb_Controller
{
    private $_typeid = 6;   //产品类型
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
        $this->assign('typeid', $this->_typeid);
        $this->assign('channelname', $channelname);
    }

    /**
     * 相册首页
     */
    public function action_index()
    {
        $seoinfo = Model_Nav::get_channel_seo_mobile($this->_typeid);
        $this->assign('seoinfo', $seoinfo);
        $this->assign('destpy', 'all');
        $this->assign('destname', '目的地');
        $this->assign('attrid', '');
        $this->assign('page', 1);
        $this->assign('sorttype', 0);
        $this->display('../mobile/photo/list', 'photo_list');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /**
     * 相册列表
     */
    public function action_list()
    {
        //参数处理
        $seo = array();
        $params = $this->request->param('params');
        $params = explode('-', $params);
        list($destPy, $attr, $page, $sorttype) = $params;
        $destname = $destPy != 'all' && !empty($destPy) ? DB::select('kindname')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('kindname') : '目的地';
        $destid = $destPy != 'all' ? DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id') : 0;
        $page = $page < 1 ? 1 : $page;
        //获取seo信息
        if ($destPy == 'all')
        {
            $mainNav = DB::select('seotitle', 'shortname', 'description')->from('nav')->where('typeid', '=', $this->_typeid)->execute()->current();
            $seo['seotitle'] = !empty($mainNav['seotitle']) ? $mainNav['seotitle'] : $mainNav['shortname'];
            $seo['description'] = $mainNav['description'];
        }
        else
        {
            $seo = Model_Photo::search_seo($destPy);
        }
        if ($page > 1)
        {
            $seo['seotitle'] = '第' . $page . '页_' . $seo['seotitle'];
        }

        $seo_params = array(
            'destpy' => $destPy,
            'attrid' => $attr,
            'p' => $page
        );
        $search_title = Model_Photo::gen_seotitle($seo_params);

        $this->assign('search_title',$search_title);
        $this->assign('seoinfo', $seo);
        $this->assign('destpy', $destPy);
        $this->assign('destname', $destname);
        $this->assign('destid', $destid);
        $this->assign('attrid', $attr);
        $this->assign('page', $page);
        $this->assign('sorttype', $sorttype);
        $this->display('../mobile/photo/list', 'photo_list');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    public
    function action_searchnav()
    {
        $this->assign('typeid', $this->_typeid);
        $this->display('../mobile/photo/searchnav');
    }

    /**
     * ajax请求 加载更多
     */
    public function action_ajax_photo_more()
    {
        $params = $this->request->param('params');
        $params = explode('-', $params);
        list($destPy, $attr, $p, $order) = $params;
        if (strlen($order) == 0)
        {
            $order = 0;
        }
        echo $this->list_data($destPy, $attr, $p, $order);
    }

    /**
     * 获取list 数据
     * @param $destPy
     * @param $attr
     * @param $p
     * @param bool|false $order
     * @return mixed
     */
    private function list_data($destPy, $attr, $page, $order)
    {
        $data = array();
        //目的地
        if ($destPy != 'all')
        {
            $destArr = Model_Destinations::get_dest_bypinyin($destPy);
            if (!empty($destArr['id']))
            {
                $data['kindlist'] = $destArr['id'];
            }
        }
        //属性
        if (!empty($attr))
        {
            $data['attrid'] = explode('_', $attr);
        }
        //分页
        $page = empty($page) ? 1 : $page;
        $data['offset'] = ($page - 1) * 10;
        //排序
        $data['order'] = $order;
        $data = Model_Photo::photo_list($data);
        foreach ($data as &$v)
        {
            $v['litpic'] = Common::img($v['litpic'], 220, 150);
            $v['url'] = Common::get_web_url($v['webid']) . "/photos/show_{$v['aid']}.html";
            $v['description'] = Common::cutstr_html($v['content'], 120);
            $v['pic_num'] = DB::query(Database::SELECT,"select count(*) as num from sline_photo_picture where pid='{$v['id']}'")->execute()->get('num');
        }
        return Product::list_search_format($data, $page);
    }

    /**
     * 相册详情
     */
    public function action_show()
    {
        $aid = intval($this->request->param('aid'));
        //子站内容显示
        if (isset($_GET['webid']))
        {
            $GLOBALS['sys_webid'] = intval(Arr::get($_GET, 'webid'));
        }
        $row = Model_Photo::photo_detail($aid);
        //点击率加一
        Product::update_click_rate($aid, $this->_typeid);
        //picture
        $piclist = Model_Photo::photo_picture($row['id']);
        foreach ($piclist as &$v)
        {
            if (empty($v['description']))
            {
                $v['description'] = $row['content'];
            }
        }
        $row['piclist'] = $piclist;
        $row['articleid'] = $row['id'];
        $row['commentnum'] = Model_Comment::get_comment_num($row['id'], 6);
        $row['sellpoint'] = St_String::cut_html_str($row['content'],50,'...');
        $seoInfo = Product::seo($row);
        $this->assign('info', $row);
        $this->assign('seoinfo', $seoInfo);
        $this->display('../mobile/photo/show', 'photo_show');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /**
     * 用户喜欢程度
     */
    public function action_ajax_favorite()
    {
        $id = (int)$_POST['id'];
        $typeId = (int)$_POST['typeid'];
        $result = array('status' => false);
        $cookie = "comment_{$id}_{$typeId}";
        $favorited = Session::instance()->get($cookie,null);
        if (!$favorited)
        {
            $row = DB::update('photo')->set(array('favorite' => DB::expr('favorite+1')))->where('id', '=', $id)->execute();
            if ($row)
            {
                $data = DB::select('favorite')->from('photo')->where('id', '=', $id)->execute()->current();
                $result['data'] = $data['favorite'];
                $result['status'] = true;
                Session::instance()->set($cookie, true);
            }
        }
        echo json_encode($result);
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

}