<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Car_Kind extends ORM
{

    /*
        * 获取酒店
        * @param 参数
        * @return array
      */
    public static function get_carkindname($kindid)
    {

        $row = DB::select('kindname')->from('car_kind')->where('id','=',':carkindid')->bind(':carkindid',$kindid)->execute()->current();

        return $row['kindname'] ? $row['kindname'] : '';
    }

}