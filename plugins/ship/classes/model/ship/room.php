<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/6 0006
 * Time: 18:25
 */
class Model_Ship_Room extends ORM
{
    public static function get_names_byfloor($floorid)
    {
        $list = self::get_list_byfloor($floorid);
        $title_arr=array();
        foreach($list as $v)
        {
            $title_arr[]=$v['title'];
        }
        return implode(',',$title_arr);
    }
    public static function get_list_byfloor($floorid)
    {
        if(empty($floorid))
            return null;
        $list = ORM::factory('ship_room')->where("find_in_set($floorid,floors)")->get_all();
        return $list;
    }
    public function get_floors($onlynames=true)
    {
        $floorid_arr= explode(',',$this->floors);
        $floors=array();
        $names=array();
        foreach($floorid_arr as $id)
        {
            $floor = ORM::factory('ship_floor',$id);
            if($floor->loaded())
            {
                $floors[]=$floor->as_array();
                $names[] = $floor->title;
            }
        }
        if($onlynames)
            return implode(',',$names);
        return $floors;
    }


}