<?php
defined('SYSPATH') or die('No direct access allowed.');

/**
 * Created by Phpstorm.
 * User: netman
 * Date: 15-9-23
 * Time: 上午10:43
 * Desc: 目的地调用标签
 */
class Taglib_Destination
{

    /*
     * 获取广告
     * @param 参数
     * @return array
   */
    public static function query($params)
    {
        $default = array(
            'flag' => '',
            'row' => 8,
            'offset' => 0,
            'pid' => 0,
            'typeid' => 0,
            'isindex' => 0,//是否是首页,
            'currentid' => 0,
            'tagword'=>''
        );
        $params = array_merge($default, $params);
        extract($params);
        switch ($flag) {
            case 'top':
                $list = self::get_top($offset, $row,$isindex);
                break;
            case 'next':
                $list = self::get_next($offset, $row, $pid, $typeid,$isindex);
                break;
            case 'hot':
                $list = self::get_hot_dest($typeid, $offset, $row, $destid,$isindex);
                break;
            //栏目获取下级目的地,如果下级为空则返回同级
            case 'nextsame':
                $list = self::get_next_same($typeid, $offset, $row, $pid,$isindex);
                break;
            case 'same':
                $list = self::get_same($offset,$row,$pid,$isindex,$currentid);
                break;
            case 'tagrelative':
                $list = self::get_tagrelative($offset, $row,$tagword );
                break;
            case 'order':
                $list = self::_get_dest_by_order($offset, $row);
                break;
        }
        return $list;
    }


    /**
     * @function 获取下级目的地列表
     * @param $offset 偏移量
     * @param $row  条数
     * @param $pid  父级目的地id
     * @return mixed 下级目的地列表
     */
    public static function get_next($offset, $row, $pid, $typeid,$isindex)
    {

        $pid = empty($pid) ? 0 : $pid;
        $m = DB::select('id', 'kindname', 'pinyin', 'litpic')->from('destinations');
        $m->where('isopen', '=', 1);
        $m->and_where(DB::expr("find_in_set({$typeid},opentypeids)"), '>', 0);
        $m->and_where('pid', '=', $pid);
        //栏目首页开关判断
        if($isindex)
        {
            $m->and_where('isnav','=',1);
        }
        $m->order_by(DB::expr('ifnull(displayorder,9999)'), 'asc');
        $m->offset($offset);
        $m->limit($row);
        $arr = $m->execute()->as_array();
        return $arr;
    }


    /**
     * @function 按栏目读取热门目的地
     * @param int $typeid
     * @param int $offset
     * @param int $row
     * @param $destid
     * @return array
     */
    private static function get_hot_dest($typeid, $offset = 0, $row = 30, $destid)
    {

        $m = DB::select('id', 'kindname', 'pinyin', 'litpic')->from('destinations');
        $m->where('isopen', '=', 1);
        $m->and_where('ishot', '=', 1);
        $m->and_where(DB::expr("find_in_set({$typeid},opentypeids)"), '>', 0);
        if ($destid)
        {
            $m->and_where('pid', '=', $destid);
        }
        $m->order_by(DB::expr('ifnull(displayorder,9999)'), 'asc');
        $m->offset($offset);
        $m->limit($row);
        $arr = $m->execute()->as_array();
        return $arr;
    }

    /**
     * @function 获取顶级目的地
     * @param $offset
     * @param $row
     * @return mixed 顶级目的地列表
     */
    private static function get_top($offset, $row,$isindex)
    {
        $query = DB::select()->from('destinations')
            ->where('pid', '=', 0)
            ->and_where('isopen', '=', 1)
            ->and_where('isnav', '=', 1)
            ->and_where(DB::expr("find_in_set(12,opentypeids)"), '>', 0);
        //栏目首页开关判断
        if($isindex)
        {
            $query->and_where('isnav','=',1);
        }

        $query->order_by(DB::expr('ifnull(displayorder,9999)'), 'asc')
            ->offset($offset)
            ->limit($row);
        $arr = $query->execute()->as_array();


        return $arr;

    }


    private static function get_tagrelative( $offset, $row,$tagword)
    {
        if(empty($tagword))
        {
            return null;
        }
        $w = " where isopen=1 and find_in_set(12,opentypeids) ";

        $tagword_arr = explode(',',$tagword);
        $tagword_w_arr = array();
        foreach($tagword_arr as $tag)
        {
            $tagword_w_arr[] = " FIND_IN_SET('{$tag}',tagword) ";
        }
        if(count($tagword_w_arr)>0)
        {
            $w.=" and (".implode(' or ',$tagword_w_arr).")";
        }
        else
        {
            return null;
        }
        $arr = DB::query(Database::SELECT,"select * from sline_destinations {$w} order by ifnull(displayorder,9999) asc limit {$offset},{$row}")->execute()->as_array();
        return $arr;

    }

    public static function get_same($offset, $row, $pid,$isindex,$currentid)
    {

        $pid = empty($pid) ? 0 : $pid;
        $m = DB::select('id', 'kindname', 'pinyin', 'litpic')->from('destinations');
        $m->where('isopen', '=', 1);
        $m->and_where('pid', '=', $pid);
        $m->and_where(DB::expr("find_in_set(12,opentypeids)"), '>', 0);
        //栏目首页开关判断
        if($isindex)
        {
            $m->and_where('isnav','=',1);
        }
        //是否排除当前
        if($currentid)
        {
            $m->and_where('id','!=',$currentid);
        }
        $m->order_by(DB::expr('ifnull(displayorder,9999)'), 'asc');
        $m->offset($offset);
        $m->limit($row);
        $arr = $m->execute()->as_array();
        return $arr;
    }

    //按顺序读取目的地.
    private static function _get_dest_by_order($offset, $row)
    {
        $m = DB::select()->from('destinations');
        $m->where('isopen', '=', 1);
        $m->and_where(DB::expr("find_in_set(12,opentypeids)"), '>', 0);
        $m->order_by(DB::expr('ifnull(displayorder,9999)'), 'asc');
        $m->offset($offset);
        $m->limit($row);

        $arr = $m->execute()->as_array();

        return $arr;
    }


}