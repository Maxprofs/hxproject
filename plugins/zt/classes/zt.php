<?php
/**
 * Created by PhpStorm.
 * Author: netman
 * QQ: 87482723
 * Time: 17-1-17 下午3:25
 * Desc:
 */
Class Zt{

    /*
    * 获取产品主url
    * */
    public static function get_base_url($webid)
    {
        $url = $GLOBALS['cfg_basehost'];
        if ($webid != 0)
        {
            $sql = "select weburl from sline_destinations where id='$webid'";
            $row = DB::query(1, $sql)->execute();
            return $row[0]['weburl'];
        }
        return $url;
    }

}