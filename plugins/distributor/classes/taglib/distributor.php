<?php defined('SYSPATH') or die('No direct script access.');
class Taglib_Distributor {
	public static function getstoreprice($pid)
		return Model_Distributor::get_storeprice($pid);
	}
}