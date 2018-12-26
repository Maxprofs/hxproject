<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Supplier_finance_Drawcash extends ORM
{

    public function get_list()
    {
        $pagesize = 20;
        $st_distributor_id = intval(Cookie::get('st_distributor_id'));

        //2.路由字符串
        $url_array = array(
            'controller' => 'drawcash',
            'action' => 'list'
        );

        $return = $this->_set_pages('distributor_finance_drawcash', $pagesize, $url_array, 'addtime', "distributorid={$st_distributor_id}");
        $return['list'] = $this->_format_data($return['list']);
        return $return;
    }

    public function get_detail($id)
    {
        $drawcash_id = intval($id);
        $sql = "select * from sline_distributor_finance_drawcash where id={$drawcash_id}";
        $list = $this->_format_data(DB::query(Database::SELECT, $sql)->execute()->as_array());
        return $list;
    }


    private function _format_data($list)
    {
        for ($i = 0; $i < count($list); $i++)
        {
            $item = $list[$i];
            if ($item['status'] == "0")
                $list[$i]["status_name"] = "审核中";
            if ($item['status'] == "1")
                $list[$i]["status_name"] = "已完成";
            if ($item['status'] == "2")
                $list[$i]["status_name"] = "未通过";
        }

        return $list;
    }

    /**
     * 分页
     * @param $db_name
     * @param $pagesize
     * @param array $url_array
     * @param $sort
     * @param null $where
     * @param string $orderby
     * @param string $source
     * @return array
     */
    private function _set_pages($db_name, $pagesize, array $url_array, $sort, $where = NULL, $orderby = 'DESC', $source = 'query_string')
    {

        //获取数据库对象
        if ($where) $page_object = ORM::factory($db_name)->where($where);
        else
            $page_object = ORM::factory($db_name);


        //定义每页显示的条数
        $pagesize = isset($pagesize) ? $pagesize : 20;

        $pager = Pagination::factory(array(
                'current_page' => array('source' => $source, 'key' => 'p'), //配置数据的总量
                'view' => 'pagination/distributor',
                'total_items' => $page_object->count_all(), //数据总条数
                'items_per_page' => $pagesize, //配置每页显示的数量
                'first_page_in_url' => false, //是否把第一页 p = 1 显示在地址栏 true为显示 false为不显示
            )
        );

        //配置访问地址 当前控制器方法
        //var_dump($url_array);exit;
        $pager->route_params($url_array);

        if ($where) $page_object = ORM::factory($db_name)->where($where);
        else
            $page_object = ORM::factory($db_name);

        //返回当前页的数据结果
        $list = $page_object->offset($pager->offset)->limit($pager->items_per_page)->order_by($sort, $orderby)->get_all();

        return array('list' => $list, 'pageinfo' => $pager);

    }

}