<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Customize_Plan extends ORM {

    public static function search_result($params,$page,$pagesize=8)
    {
        $page = intval($page);
        $page = $page<1?1:$page;
        $offset = ($page-1)*$pagesize;

        $w = " where id is not null";
        $sql = " select * from sline_customize_plan {$w} ";
        $sql .= " order by displayorder asc,modtime desc,addtime desc";
        $sql .=" limit {$offset},{$pagesize}";
        $sql_num = " select count(*) as num from sline_customize_plan {$w}";

        $list = DB::query(Database::SELECT,$sql)->execute()->as_array();
        $total = DB::query(Database::SELECT,$sql_num)->execute()->get('num');

        foreach($list as &$v)
        {
            $v['url'] = Common::get_web_url(0) . "/customize/plan_{$v['id']}.html";
        }
        $out = array(
            'total' => $total,
            'list' => $list
        );
        return $out;
    }

    public static function update_click_rate($id)
    {
        $sql = "UPDATE `sline_customize_plan` SET shownum=shownum+1 WHERE id='{$id}'";
        DB::query(Database::UPDATE,$sql)->execute();
    }
}