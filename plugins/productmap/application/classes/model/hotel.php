<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Hotel extends ORM
{
    public static function get_minprice($hotelid)
    {

        $sql = "SELECT MIN(price) AS price FROM `sline_hotel_room_price` WHERE hotelid='$hotelid' AND price!=0 AND day>=UNIX_TIMESTAMP()";
        $row = DB::query(1,$sql)->execute()->as_array();
        $row[0]['price']=Currency_Tool::price($row[0]['price']);
        return $row[0]['price'];
    }
}