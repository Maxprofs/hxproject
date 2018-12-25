<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/6 0006
 * Time: 18:25
 */
class Model_Ship_Facility_Kind extends ORM
{
    public static function get_title($id)
    {
        $info= DB::select('title')->from('ship_facility_kind')->where('id','=',$id)->execute()->current();
        if($info['title'])
            return $info['title'];
        return '';
    }
}