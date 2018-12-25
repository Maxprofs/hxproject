<?php defined('SYSPATH') or die('No direct script access.');
class Taglib_Distributor {
	public static function getdlist() {
		$distributor = Model_Distributor::distributor_list();
		return $distributor;
	}
}