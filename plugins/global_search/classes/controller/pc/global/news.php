<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: netman
 * Time: 2017/10/20 18:21
 * Desc: 资讯
 */

class   Controller_Pc_Global_News extends Stourweb_Controller
{
    private $_webid = 0;
    function before()
    {
        Model_Global_Search::check_app_install(115);
     //   global $sys_webid;
     //   $this->_webid = $sys_webid;
        parent::before();

    }


    public function action_index()
    {
        $pagesize = 12;
        $p = intval($_GET['p']) ? intval($_GET['p']) : 1 ;
        $keyword = Common::remove_xss($_GET['keyword']);//关键词
        $pinyin = Common::remove_xss($this->request->controller());//拼音
        $attrlist = Common::remove_xss($this->request->param('attrlist')) ;//属性
        $attrlist = explode('_',$attrlist);
        $typeid = DB::select('id')->from('model')->where('pinyin','=',$pinyin)->execute()->get('id');
        if(!is_array($attrlist)||!$typeid)
        {
            $this->request->redirect('error/404');
        }
        if(!$keyword)
        {
            $this->request->redirect($GLOBALS['cfg_basehost'],301);
        }
        $shortname = DB::select('shortname')->from('nav')->where('typeid','=',$typeid)
            ->and_where('webid','=',$this->_webid)
            ->and_where('isopen','=',1)
            ->and_where('linktype','=',1)
            ->execute()->get('shortname');
        if(!$shortname)
        {
            $this->request->redirect('error/404');
        }
        $searchcode =  St_String::split_keyword($keyword);//分词
        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
            'pinyin'=>$pinyin,
            'keyword' => $keyword,
            'attrlist' => $attrlist,
            'typeid' => $typeid

        );
        $search_items = Model_Global_Module_News::get_search_items($route_array);
        $out = Model_Global_Search::search_result($route_array, $searchcode, $p, $pagesize);
        $pager = Pagination::factory(
            array(
                'current_page' => array('source' => 'query_string', 'key' => 'p'),
                'view' => 'default/pagination/search',
                'total_items' => $out['total'],
                'items_per_page' => $pagesize,
                'first_page_in_url' => false,
            )
        );
        //配置访问地址 当前控制器方法
        $pager->route_params($route_array);
        $searchmodel = Model_Global_Search::get_search_model($searchcode,$keyword,$typeid);
        $this->assign('searchmodel',$searchmodel);

        $this->assign('search_items',$search_items);
        $this->assign('attr_list',$attrlist);
        $this->assign('shortname',$shortname);
        $this->assign('typeid',$typeid);
        $this->assign('params',$route_array);
        $this->assign('list', $out['list']);
        $this->assign('currentpage', $p);
        $this->assign('pageinfo', $pager);
        $tempalate = 'search/news';
        $this->display($tempalate);
    }


}