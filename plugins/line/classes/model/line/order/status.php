<?php defined('SYSPATH') or die('No direct access allowed.');


class Model_Line_Order_Status extends ORM
{
    public static function get_status_info($status)
    {
       $row = DB::select()->from('line_order_status')->where('status','=',$status)->execute()->current();
       return $row;

    }




}