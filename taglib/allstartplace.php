<?php
/**
 * Created by Deccatech.
 * Author: roinheart
 * QQ: 361381214
 * Time: 18-10-26 下午12:07
 * Desc:出发城市调用标签
 */
class Taglib_Allstartplace {

	public static function city() {

		$sql = "SELECT *,cityname as title FROM `sline_startplace` WHERE isopen=1";
		$ar = DB::query(1, $sql)->execute()->as_array();
		return $ar;
	}
}