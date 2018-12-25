<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/13 0013
 * Time: 9:16
 */
class Model_Ship_Line_Jieshao extends ORM
{

    //获取经过国家城市列表
    public static function get_passed_destlist($lineid)
    {
        $list = DB::select('country')->from('ship_line_jieshao')->where('lineid','=',$lineid)->execute()->as_array();
        $dest_arr = array();
        foreach($list as $v)
        {
            if(!empty($v['country']))
                $dest_arr[] = $v['country'];
        }
        return $dest_arr;
    }
}