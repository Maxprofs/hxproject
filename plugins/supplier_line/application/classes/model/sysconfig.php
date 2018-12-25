<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Sysconfig extends ORM
{
    /*
     * 获取配置文件
     * @param int $webid 站点id
     * return array
     */
    public static function config($webid = 0)
    {
        $sql = "select varname,value from sline_sysconfig where webid={$webid}";
        return DB::query(Database::SELECT, $sql)->execute()->as_array();
    }
    /*
   * 根据webid获取所有配置信息
   * */
    public function get_config($webid)
    {
        $arr = $this->where('webid','=',$webid)->get_all();
        $out = array();
        foreach($arr as $row)
        {
            $out[$row['varname']] = $row['value'];
        }
        return $out;
    }


    /**
     * @function 获取系统配置
     * @param int $webid
     * @param null $fields 要获取的字段数组或字符
     * @param $isvalue 是否直接返回值
     * @return array
     */
    public static function get_configs($webid = 0, $fields = null, $isvalue = null)
    {
        $query = DB::select('value', 'varname')->from('sysconfig')->where('webid', '=', $webid);
        if (is_array($fields))
            $query->and_where('varname', 'in', $fields);
        if (is_string($fields))
            $query->and_where('varname', '=', $fields);
        $list = $query->execute()->as_array();
        $out = array();
        foreach ($list as $row) {
            if ($isvalue)
                return $row['value'];
            $out[$row['varname']] = $row['value'];
        }
        return $out;
    }

    public static function get_sys_conf($field, $varname, $webid = 0)
    {
        $result = DB::select($field)->from('sysconfig')->where('varname', '=', $varname)->and_where('webid', '=', $webid)->execute()->current();
        return $result[$field];
    }
}