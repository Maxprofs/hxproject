<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/15 0015
 * Time: 17:35
 */
class Ship{
    //获取游轮供应商
    public static function get_suppliers()
    {
        $list =  ORM::factory('supplier')->get_all();
        return $list;

    }
}