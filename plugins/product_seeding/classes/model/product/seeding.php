<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2018/1/23 17:18
 *Desc:
 */
class Model_Product_Seeding extends ORM
{
    /**
     * @function 根据id获取软文植入产品数据
     * @param $id
     * @return mixed
     */
    public static function get_info($id)
    {
        return DB::select()
                 ->from('product_seeding')
                 ->where('id', '=', $id)
                 ->execute()
                 ->current();
    }

    /**
     * @function 保存
     * @param $arr
     * @param $id
     * @return bool
     */
    public static function save_info($arr, $id)
    {
        $orm = ORM::factory('product_seeding', $id);
        foreach ($arr as $k => $v)
        {
            $orm->$k = $v;
        }
        $orm->save();
        if ($orm->saved())
        {
            return true;
        }

        return false;
    }
}