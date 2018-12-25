<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Car_Attr extends ORM
{
    /**
     * @desc 获取下级属性列表
     * @param $attrid
     * @return array
     */
    public static function get_attr_list($attrid)
    {
        if(empty($attrid))return null;
        $attrid = trim($attrid,',');
        $sql = "SELECT id,attrname FROM `sline_car_attr` WHERE id IN($attrid) AND isopen=1 and pid!=0 ORDER BY displayorder ASC";
        $arr = DB::query(1,$sql)->execute()->as_array();
        return $arr;
    }

    public static function get_attrname_list($attrid_str,$separator=',')
    {
        $attrid_arr=explode('_',$attrid_str);
        $arr = DB::select('attrname')->from('car_attr')->where('id','in',$attrid_arr)->execute()->as_array();
        $out = array();
        foreach($arr as $v)
        {
            $out[] = $v['attrname'];
        }
        $attr_str=implode($out,$separator);
        return $attr_str;

    }

}