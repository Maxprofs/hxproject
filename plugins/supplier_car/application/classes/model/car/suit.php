<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Car_Suit extends ORM {
    public function delete_clear()
	{
	    DB::delete('car_suit_price')->where("suitid={$this->id}")->execute();
		$this->delete();
	}
}