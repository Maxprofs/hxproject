<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Hotel_Room extends ORM {
 
     public function delete_clear()
	 {
         DB::delete('hotel_room_price')->where("suitid={$this->id}")->execute();
		 $this->delete();  
	 }

	/**
	 * @function 酒店套餐信息
	 * @param $suitid
	 * @return mixed
	 */
	public static function suit_info($suitid)
	{
		$suitid = intval($suitid);
		$sql = "SELECT * FROM `sline_hotel_room` WHERE id='$suitid'";
		$ar = DB::query(1,$sql)->execute()->as_array();
		$ar[0]['price']=Currency_Tool::price($ar[0]['price']);
		$ar[0]['sellprice']=Currency_Tool::price($ar[0]['sellprice']);
		$ar[0]['dingjin'] = Currency_Tool::price($ar[0]['dingjin']);

		return $ar[0];

	}
}