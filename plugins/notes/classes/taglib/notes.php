<?php

/**
 * Created by PhpStorm.
 * Author: netman
 * QQ: 87482723
 * Time: 15-9-28 下午7:35
 * Desc:游记调用标签
 */
class Taglib_Notes
{
    private static $_typeid = 101;

    public function right()
    {
        $bool = true;
        if (!St_Functions::is_system_app_install(self::$_typeid))
        {
            $bool = false;
        }
        return $bool;
    }


    public static function query($params)
    {
        $default = array(
            'row' => '30',
            'offset' => 0,
            'flag' => ''
        );
        $params = array_merge($default, $params);
        extract($params);

        switch ($flag)
        {
            case 'new':
                $list = self::get_new($offset, $row);
                break;
            case 'order':
                $list = self::get_order($offset, $row);
                break;
            case 'season':
                $list = self::get_season($offset, $row);
                break;
            case 'hot':
                $list = self::get_hot($offset, $row);
                break;
            case 'mdd':
                $list = self::get_mdd($offset,$row,$destid);

        }

        return self::format_row($list);


    }

    //当季热门
    private static function get_season($offset, $row)
    {
        $sql = "SELECT a.nickname,a.litpic as memberpic,a.remarks,a.mid,b.* ";
        $sql .= "FROM `sline_member` a LEFT JOIN `sline_notes` b ON(a.mid = b.memberid AND b.status=1 ) ";
        $sql .= "WHERE quarter(from_unixtime(modtime,'%y%m%d'))=quarter(curdate()) ";
        $sql .= "ORDER BY b.shownum DESC LIMIT {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;


    }

    //热门游记
    private static function get_hot($offset, $row)
    {
        $sql = "SELECT * FROM `sline_notes` AS a  ";
        $sql .= "WHERE a.status=1 ORDER BY a.shownum DESC LIMIT {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }


    /**@desc 按发布时间倒序获取
     * @param $offset
     * @param $row
     * @return mixed
     */
    private static function get_new($offset, $row)
    {
        $sql = "SELECT a.* FROM sline_notes a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=101) ";
        $sql .= "WHERE a.id>0 and a.status=1 ";
        $sql .= "ORDER BY a.modtime desc,a.addtime DESC,IFNULL(b.displayorder,9999) asc ";
        $sql .= "limit {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }


    private static function get_mdd($offset, $row,$destid)
    {
        $sql = "SELECT a.* FROM sline_notes a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=101) ";
        $sql .= "WHERE a.id>0 and a.status=1 and find_in_set('$destid',a.kindlist) ";
        $sql .= "ORDER BY a.modtime desc,a.addtime DESC,IFNULL(b.displayorder,9999) asc ";
        $sql .= "limit {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

    /**@desc 按排序获取
     * @param $offset
     * @param $row
     * @return mixed
     */

    private static function get_order($offset, $row)
    {
        $sql = "SELECT a.* FROM sline_notes a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=101) ";
        $sql .= "WHERE a.id>0 and a.status=1 ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "limit {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;

    }

    /**
     * 达人排行榜
     * @param $params
     * @return mixed
     */
    public static function daren($params)
    {
        $default = array(
            'row' => '30',
            'offset' => 0

        );
        $params = array_merge($default, $params);
        extract($params);

        $sql = "SELECT a.nickname,a.litpic AS m_litpic,a.remarks,b.* ,count(b.memberid) AS c FROM `sline_member` a LEFT JOIN `sline_notes` b ON(a.mid = b.memberid AND b.status=1) WHERE b.status=1  GROUP BY b.memberid ORDER BY c DESC LIMIT {$offset},{$row}";
        $ar = DB::query(1, $sql)->execute()->as_array();
        foreach ($ar as &$item)
        {
            if(empty($item['m_litpic']))
            {
                $item['m_litpic']='/res/images/member_nopic.png';
            }
        }
        return $ar;
    }

    /**
     * 格式化数据
     * @param $arr
     * @return mixed
     */
    public static function format_row($arr)
    {
        foreach ($arr as &$row)
        {
            $row['url'] = $GLOBALS['cfg_basehost'] . '/notes/show_' . $row['id'] . '.html';
            $member_info = DB::select_array(array('mid', 'nickname', 'litpic', 'remarks'))->from('member')->where('mid', '=', $row['memberid'])->execute()->current();
            $row['mid'] = $member_info['mid'];
            $row['nickname'] = $member_info['nickname'];
            if(empty($row['litpic']))
            {
                $row['litpic']=$row['bannerpic'];
            }
            if(empty($row['description']))
            {
                $row['description']=strip_tags($row['content']);
            }
            $row['memberpic'] = $member_info['litpic'] ?   $member_info['litpic'] : Model_Member::member_nopic();
            $row['remarks'] = $member_info['remarks'];
			$row['shownum'] += $row['read_num'];
        }
        return $arr;
    }

    public static function destionation($params)
    {
        $default = array(
            'row' => '30',
            'offset' => 0,
            'flag' => ''
        );
        $params = array_merge($default, $params);
        $data = Model_Notes::destionation_notes($params);
        return $data;
    }

    public static function comment($params)
    {
        $default = array(
            'row' => '5',
            'offset' => 0,
            'flag' => '',
            'page' => 1,
            'controller'=>'notes'
        );
        $params = array_merge($default, $params);
        $data = Product::content_comment($params);
        return $data;
    }

}