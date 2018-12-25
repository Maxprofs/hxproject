<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Hotel_Attr extends ORM
{

    public static function get_attr_name_list($attrid_str, $separator = ',')
    {
        $rs = DB::select('attrname')->from('hotel_attr')->where('id', 'in', explode(',', $attrid_str))->execute()->as_array();
        $attr_arr = array();
        foreach ($rs as $v)
        {
            $attr_arr[] = $v['attrname'];
        }
        $attr_str = implode($separator, $attr_arr);
        return $attr_str;
    }

    /**
     * @param $attrid
     * @return mixed
     * @desc 根据属性id返回属性数组.
     */
    public static function get_attr_list($attrid)
    {
        if (empty($attrid)) return array();
        $attrid = trim($attrid, ',');
        $sql = "SELECT id,attrname FROM `sline_hotel_attr` WHERE id IN($attrid) AND isopen=1 AND pid!=0 ORDER BY displayorder ASC";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

    public static function get_attrname_list($attrid_str, $separator = ',')
    {
        $attrid_arr = explode('_', $attrid_str);
        $arr = DB::select('attrname')->from('hotel_attr')->where('id', 'in', $attrid_arr)->execute()->as_array();
        $out = array();
        foreach ($arr as $v)
        {
            $out[] = $v['attrname'];
        }
        $attr_str = implode($out, $separator);
        return $attr_str;
    }
}