<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Spot_Ticket extends ORM {

    protected  $_table_name = 'spot_ticket';
    
	public function delete_clear()
	{
        DB::delete('spot_ticket_price')->where('ticketid','=',$this->id)->execute();
		 $this->delete();
	}

}