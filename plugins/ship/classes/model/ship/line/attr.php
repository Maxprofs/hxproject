<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/13 0013
 * Time: 9:14
 */
class Model_Ship_Line_Attr extends ORM
{
    public static function get_attrname_list($attrid_str,$separator=',')
    {
        $attrid_arr=explode('_',$attrid_str);
        $arr = DB::select('attrname')->from('ship_line_attr')->where('id','in',$attrid_arr)->execute()->as_array();
        $out = array();
        foreach($arr as $v)
        {
            $out[] = $v['attrname'];
        }
        $attr_str=implode($out,$separator);
        return $attr_str;

    }

    //通过字符串获取属性集
    public static function get_attrs($str, $field = '*',$is_child=null)
    {
        $data = array();
        if (empty($str))
        {
            return null;
        }
        $query = DB::select($field)->from('ship_line_attr')->where('id', 'in', explode(',', $str));
        if($is_child)
        {
            $query=$query->and_where('pid','!=',0);
        }
        $result = $query->execute()->as_array();
        if ($field != '*')
        {
            foreach ($result as $v)
            {
                $data[] = $v[$field];
            }
        }
        else
        {
            $data = $result;
        }
        return $data;
    }

}