<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/6 0006
 * Time: 18:25
 */
class Model_Ship_Room_Kind extends ORM
{
    public static function get_title($id)
    {
        $model = ORM::factory('ship_room_kind',$id);
        if($model->loaded())
            return $model->title;
        return '';
    }
}