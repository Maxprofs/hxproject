<?php defined('SYSPATH') or die('No direct script access.');

class Taglib_photo
{
    private static $_typeid = 6;

    public static function comment($params)
    {
        $obj = DB::select()->from('comment')->where('typeid', '=', self::$_typeid)->and_where('articleid', '=', $params['articleid'])->and_where('isshow', '=', 1)->order_by('addtime', 'DESC');
        $result = $obj->execute()->as_array();
        foreach ($result as $k => $v)
        {
            $result[$k]['member'] = array();
            $result[$k]['reply'] = array();
            $result[$k]['addtime'] = date('Y-m-d', $result[$k]['addtime']);
            $result[$k]['member'] = Product::init_member($v['memberid']);
            if ($v['dockid'])
            {
                $tempInfo = DB::select()->from('comment')->where('id', '=', $v['dockid'])->and_where('isshow', '=', 1)->execute()->current();
                if ($tempInfo)
                {
                    list($tempInfo['litpic'], $tempInfo['nickname']) = Product::init_member($tempInfo['memberid'], true);
                    $tempInfo['addtime'] = date('Y-m-d', $tempInfo['addtime']);
                    $result[$k]['reply'] = $tempInfo;
                }
            }
        }

        return $result;
    }

    public static function query($params)
    {
        $default = array(
            'row' => '10',
            'flag' => '',
            'offset' => 0,
            'destid' => 0,
            'tagword' => ''
        );
        $params = array_merge($default, $params);
        extract($params);
        switch ($flag)
        {
            case 'new':
                $list = self::get_photo_new($offset, $row);
                break;
            case 'order':
                $list = self::get_photo_order($offset, $row);
                break;
            case 'mdd':
                $list = self::get_photo_bymdd($offset, $row, $destid);
                break;
            case 'tagrelative':
                $list = self::get_photo_bytagword($offset, $row, $tagword);
                break;
        }
        //对获取的数据进行初始化处理
        foreach ($list as &$v)
        {

            $v['url'] = Common::get_web_url($v['webid']) . "/photos/show_{$v['aid']}.html";

        }//var_dump($list);
        return $list;

    }

    private static function get_photo_new($offset, $row)
    {
        $sql = "SELECT a.* FROM sline_photo a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=6) ";
        $sql .= "WHERE a.ishidden=0 ORDER BY a.modtime desc,a.addtime DESC,IFNULL(b.displayorder,9999) asc ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;

    }


    private static function get_photo_order($offset, $row)
    {
        $sql = "SELECT a.* FROM sline_photo a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=6) ";
        $sql .= "WHERE a.ishidden=0 ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "limit {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;


    }


    private static function get_photo_bymdd($offset, $row, $destid)
    {
        $destid = intval($destid);
        $offset = intval($offset);
        $row = intval($row);
        $sql = "SELECT distinct(a.id),a.* FROM `sline_photo` a ";
        $sql .= "LEFT JOIN `sline_kindorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=6 and b.classid={$destid}) ";
        $sql .= "WHERE a.ishidden=0 AND FIND_IN_SET($destid,a.kindlist) ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;
    }

    private static function get_photo_bytagword($offset, $row, $tagword)
    {
        $offset = intval($offset);
        $row = intval($row);
        $tagword_arr = explode(",", $tagword);
        if (count($tagword_arr) <= 0)
            return array();

        $sql = "SELECT a.* FROM sline_photo a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=6) ";
        $sql .= "WHERE a.ishidden=0 AND ( ";
        foreach ($tagword_arr as $tagword_item)
        {
            $sql .= "FIND_IN_SET('{$tagword_item}',a.tagword) OR ";
        }
        $sql = rtrim($sql, " OR ");
        $sql .= ") ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = self::execute($sql);
        return $arr;

    }

    /*
    * 执行sql语句
    * */
    private static function execute($sql)
    {
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }
}