<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Notes extends ORM
{

    /**
     * 会员发布的游记列表
     * @param $mid
     * @param $page
     * @param $pagesize
     * @return mixed
     */
    public static function member_notes_list($mid, $currentpage, $pagesize)
    {
        $page = $currentpage ? $currentpage : 1;
        $offset = (intval($page) - 1) * $pagesize;


        $sql = "SELECT a.* FROM `sline_notes` a ";
        $sql .= "WHERE a.memberid=$mid ";
        $sql .= "ORDER BY modtime desc ";

        //计算总数
        $totalSql = "SELECT count(*) as dd " . strchr($sql, " FROM");
        $totalSql = str_replace(strchr($totalSql, "ORDER BY"), '', $totalSql);//去掉order by

        $totalN = DB::query(1, $totalSql)->execute()->get('dd');
        $totalNum = $totalN ? $totalN : 0;
        $sql .= "LIMIT {$offset},{$pagesize}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        foreach ($arr as &$row)
        {
            if(empty($row['litpic']))
            {
                $row['litpic']=$row['bannerpic'];
            }
            if(empty($row['description']))
            {
                $row['description']=strip_tags($row['content']);
            }
            $row['url'] = $GLOBALS['cfg_basehost'] . '/notes/show_' . $row['id'] . '.html';
        }
        $out = array(
            'total' => $totalNum,
            'list' => $arr
        );
        return $out;

    }

    /**
     * 获取总的游记数量
     * @return int
     */
    public static function get_total_notes()
    {
        $sql = "SELECT COUNT(*) as dd FROM `sline_notes` WHERE status=1";
        $num = DB::query(1, $sql)->execute()->get('dd');
        return $num ? $num : 0;
    }

    /**
     * 获取最新游记
     * @param $offset
     * @param $pagesize
     * @return mixed
     */
    public static function get_new_notes($offset, $pagesize)
    {
        $sql = "SELECT * FROM `sline_notes` AS a  LEFT JOIN (SELECT mid,nickname,litpic as memberpic,remarks FROM sline_member) AS m ON m.mid=a.memberid WHERE a.status=1";
        $sql .= " ORDER BY modtime DESC LIMIT $offset,$pagesize";
        $arr = DB::query(1, $sql)->execute()->as_array();
        foreach ($arr as $key =>&$row)
        {
            if(empty($row['litpic']))
            {
                $row['litpic']=$row['bannerpic'];
            }
            if(empty($row['description']))
            {
                $row['description']=strip_tags($row['content']);
            }
            $row['url'] = $GLOBALS['cfg_basehost'] . '/notes/show_' . $row['id'] . '.html';
            $arr[$key]['shownum'] += $arr[$key]['read_num'];
        }
        return $arr;
    }

    public static function search($destid, $keyword, $sorttype, $status = false, $offset, $row = 10, $mid = 0)
    {
        $ordertable = empty($destid) ? 'sline_allorderlist' : 'sline_kindorderlist';

        $sql = "SELECT a.* FROM `sline_notes` a ";
        $sql .= "LEFT JOIN `{$ordertable}` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=101) ";
        $sql .= "WHERE a.id is not null ";
        if (!empty($destid))
            $sql .= "AND FIND_IN_SET($destid,a.kindlist) ";
        if (!empty($keyword))
            $sql .= "AND a.title like '%{$keyword}%' ";
        if (!empty($mid))
            $sql .= "AND a.memberid={$mid} ";
        if ($status !== false)
            $sql .= "AND a.status={$status} ";
        if (empty($sorttype))
            $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.shownum desc,a.modtime desc,a.addtime DESC ";
        else if ($sorttype == 1)
            $sql .= "ORDER BY a.modtime DESC,a.addtime DESC,IFNULL(b.displayorder,9999) ASC";
        $sql .= " LIMIT {$offset},{$row}";
        $arr = DB::query(Database::SELECT, $sql)->execute()->as_array();
        foreach ($arr as &$v)
        {
            $v['url'] = Common::get_web_url(0) . "/notes/show_{$v['id']}.html";
            if(empty($v['litpic']))
            {
                $v['litpic']=$v['bannerpic'];
            }
            if(empty($v['description']))
            {
                $v['description']=strip_tags($v['content']);
            }
            //匹配正文内容是否是PC编辑的
            if(preg_match('/<p.*?>.*?<\/p>/m',$v['content'],$match))
            {
                $v['is_pc']=1;
            }
            $v['litpic'] = empty($v['litpic']) ? Common::nopic() : Common::img($v['litpic'],690,345);
            $v['title'] = Common::cutstr_html($v['title'], 40);
			$v['shownum'] += $v['read_num'];
        }
        return $arr;
    }

    public static function destionation_notes($params)
    {
        $row = 10;
        $page = 1;
        $_data = array();
        extract($params);
        $ordertable = empty($destid) ? 'allorderlist' : 'kindorderlist';
        $obj = DB::select('notes.*')->from('notes')->join($ordertable, 'LEFT')->on('notes.id', '=', "{$ordertable}.aid")->and_having_open()->/*and_having("{$ordertable}.typeid", '=', 101)->*/
        and_having('notes.status', '=', 1);
        if (!empty($destid))
        {
            $obj = $obj->and_having(DB::expr("FIND_IN_SET({$destid},`sline_notes`.`kindlist`)"), '>', 0);
        }
        $obj = $obj->and_having_close()->order_by('notes.shownum', 'DESC');
        $total = $obj->execute();
        $result = $obj->limit($row)->offset(($page - 1) * $row)->execute()->as_array();
        foreach ($result as $k => $v)
        {
            $member = Model_Member::get_member_info($v['memberid']);
            if (!$member['litpic'])
            {
                $member['litpic'] = Common::member_nopic();
            }
            if (empty($result[$k]['litpic']))
            {
                $result[$k]['litpic'] = $result[$k]['bannerpic'];
            }
            if(empty($result[$k]['description']))
            {
                $result[$k]['description']=strip_tags($result[$k]['content']);
            }
            $result[$k]['url'] = "/notes/show_{$v['id']}.html";
            $result[$k]['member'] = $member;
        }
        $_data['data'] = $result;
        //分页处理
        $pager = Pagination::factory(
            array(
                'current_page' => array('source' => 'route', 'key' => 'params', 'page' => $page),
                'view' => 'default/pagination/show',
                'total_items' => count($total),
                'items_per_page' => $params['row'],
                'first_page_in_url' => true,
            ), Request::factory('notes_other')
        );
        $route_array = array(
            'controller' => 'notes',
            'action' => 'ajax_destionation_notes'
        );
        $pager->route_params($route_array);
        $pager->setup();
        $_data['page'] = $pager->render();
        return $_data;
    }
}