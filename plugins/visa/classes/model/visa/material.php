<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2018/1/9 17:25
 *Desc:
 */
class Model_Visa_Material extends ORM
{
    /**
     * @function 获取签证人群列表数据
     * @param int $is_show
     * @return mixed
     */
    public static function get_list($is_show = null)
    {
        $query = DB::select()
                   ->from('visa_material');
        if (! is_null($is_show))
        {
            $query->where('is_show', '=', $is_show);
        }

        return $query->execute()
                     ->as_array();
    }
}