<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2018/1/23 15:49
 *Desc:
 */
class Controller_Admin_Seeding extends Stourweb_Controller
{
    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        $is_install_article = St_Functions::is_system_app_install(4);
        $is_install_news = St_Functions::is_system_app_install(115);
        $is_install_notes = St_Functions::is_system_app_install(101);
        $pdts = self::_get_install_pdts();

        $article = Model_Product_Seeding::get_info(1);
        $news = Model_Product_Seeding::get_info(2);
        $notes = Model_Product_Seeding::get_info(3);

        $this->assign('is_install_article', $is_install_article);
        $this->assign('is_install_news', $is_install_news);
        $this->assign('is_install_notes', $is_install_notes);

        $this->assign('article', $article);
        $this->assign('news', $news);
        $this->assign('notes', $notes);

        $this->assign('pdts', $pdts);
        $this->display('admin/seeding/index');
    }

    /**
     * @function 获取已安装应用
     * @return array
     * @throws Kohana_Exception
     */
    private static function _get_install_pdts()
    {
        $sql = 'SELECT DISTINCT a.* FROM `sline_model` AS a LEFT JOIN `sline_nav` AS b ON(a.`id` = b.`typeid` AND b.`pid`=0) WHERE a.`id` NOT IN(4,6,10,11,12,14,101,105,107) ORDER BY IFNULL(b.`displayorder`, 9999)';
        $product_list = DB::query(1, $sql)
                          ->execute()
                          ->as_array();
        foreach ($product_list as $k => $v)
        {
            if ($v['maintable'] != 'model_archive')
            {
                if (! St_Functions::is_system_app_install($v['id']))
                {
                    unset($product_list[$k]);
                }
            }
        }
        $product_list = array_merge($product_list);

        return $product_list;
    }

    /**
     * @function 保存
     */
    public function action_ajax_save()
    {
        $article = array(
            'status'   => Arr::get($_POST, 'article_status'),
            'location' => Arr::get($_POST, 'article_location'),
            'typeid'   => Arr::get($_POST, 'article_typeid'),
            'kind'     => Arr::get($_POST, 'article_kind'),
        );
        $news = array(
            'status'   => Arr::get($_POST, 'news_status'),
            'location' => Arr::get($_POST, 'news_location'),
            'typeid'   => Arr::get($_POST, 'news_typeid'),
            'kind'     => 1,
        );
        $notes = array(
            'status'   => Arr::get($_POST, 'notes_status'),
            'location' => Arr::get($_POST, 'notes_location'),
            'typeid'   => Arr::get($_POST, 'notes_typeid'),
            'kind'     => 1,
        );

        $bool_article = Model_Product_Seeding::save_info($article, 1);
        $bool_news = Model_Product_Seeding::save_info($news, 2);
        $bool_notes = Model_Product_Seeding::save_info($notes, 3);

        $bool = $bool_article && $bool_news && $bool_notes;

        exit(json_encode(array('status' => $bool)));
    }
}