<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/6 0006
 * Time: 18:25
 */
class Model_Ship_Facility extends ORM
{
    public static function get_names_byfloor($floorid)
    {
        $list = self::get_list_byfloor($floorid);
        $title_arr=array();
        foreach($list as $v)
        {
            $title_arr[]=$v['title'];
        }
        return empty($title_arr)?null:implode(',',$title_arr);
    }
    public static function get_list_byfloor($floorid)
    {
        if(empty($floorid))
            return null;
        $list = ORM::factory('ship_facility')->where("find_in_set($floorid,floors)")->get_all();
        return $list;
    }
}