<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Spot_Ticket_Type extends ORM
{
    /**
     * @function 获取门票类型
     * @param      $id
     * @param bool $column
     * @return mixed
     */
    public static function get_info($id, $column = false)
    {
        if ($column)
        {
            return DB::select($column)
                     ->from('spot_ticket_type')
                     ->where('id', '=', $id)
                     ->execute()
                     ->get($column, '');
        }

        return DB::select()
                 ->where('spot_ticket_type')
                 ->where('id', '=', $id)
                 ->execute()
                 ->current();
    }
}