<?php
/**
 * Created by Deccatech.
 * Author: roinheart
 * QQ: 361381214
 * Time: 18-10-28 下午23:13
 * Desc:城市站点调用标签
 */
class Taglib_Citystation {

	public static function cityStation() {

		$sql = "SELECT id,cityname,pid FROM `sline_startplace`";
		$ar = DB::query(1, $sql)->execute()->as_array();

		return $ar;
	}
}