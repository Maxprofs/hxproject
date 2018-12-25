<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/13 0013
 * Time: 9:16
 */
class Model_Ship_Line_Suit_Price extends ORM
{
    public static function get_min_price($suitid,$shipid,$scheduleid)
    {
        $sql = "select min(price) as price from sline_ship_line_suit_price where suitid='{$suitid}' and shipid='{$shipid}' and scheduleid='{$scheduleid}'";

        $row = DB::query(Database::SELECT,$sql)->execute()->current();
        $price = empty($row) && empty($row['price'])?0:$row['price'];
        return $price;
    }
    public static function get_min_profit($suitid,$shipid,$scheduleid)
    {
        $sql = "select min(profit) as price from sline_ship_line_suit_price where suitid='{$suitid}' and shipid='{$shipid}' and scheduleid='{$scheduleid}'";
        $row = DB::query(Database::SELECT,$sql)->execute()->current();
        $price = empty($row) && empty($row['price'])?0:$row['price'];
        return $price;
    }
}