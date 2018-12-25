<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/6 0006
 * Time: 18:25
 */
class Model_Ship_Floor extends ORM
{

    public static function get_floors($shipid)
    {

        $list = ORM::factory('ship_floor')->where('shipid','=',$shipid)->get_all();
        return $list;
    }
    public static function get_names_bystr($str)
    {

        if(empty($str))
            return null;
         $ids=explode(',',$str);
        $list=array();
        foreach($ids as $id)
        {
            $model = ORM::factory('ship_floor',$id);
            if($model->loaded())
            {
                $list[]= $model->as_array();
            }
        }

        $title_arr=array();
        foreach($list as $v)
        {
            $title_arr[]=$v['title'];
        }
        return implode(',',$title_arr);



    }

}