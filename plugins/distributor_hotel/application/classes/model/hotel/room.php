<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Hotel_Room extends ORM {
 
     public function delete_clear()
	 {

         DB::delete('hotel_room_price')->where("suitid={$this->id}")->execute();
		 $this->delete();  
	 }
}