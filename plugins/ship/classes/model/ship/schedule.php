<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/6 0006
 * Time: 18:25
 */
class Model_Ship_Schedule extends ORM
{
    /**
     * 获取行程天数
     * @param $field
     * @param $val
     * @return null
     */
    public static function get_travel_days($field, $val)
    {
        $result = DB::select('title')->from('ship_schedule')->where($field, '=', $val)->execute()->current();
        if (!$result)
        {
            return '';
        }
        return $result['title'];
    }
}