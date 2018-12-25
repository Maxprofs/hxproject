<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/6 0006
 * Time: 18:25
 */
class Model_Ship_Schedule_Date extends ORM
{
    public static function get_date_list($scheduleid,$suitid)
    {
        $sql = "select a.*,b.dateid,b.profit,b.basicprice,b.price,b.storeprice,b.number from sline_ship_schedule_date a left join sline_ship_line_suit_price b on a.id=b.dateid and b.suitid=$suitid where a.scheduleid=$scheduleid";
        $list = DB::query(Database::SELECT,$sql)->execute()->as_array();
        return $list;
    }
}