<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Spot_Attr extends ORM {

    protected  $_table_name = 'spot_attr';
    
	public function delete_clear()
	{
		 $this->delete();
	}
	public static function get_attrname_list($attrid_str,$separator=',')
	{
        $attrid_arr=explode(',',$attrid_str);
        if(empty($attrid_arr))
            return null;
        $name_arr=DB::select('attrname')->from('spot_attr')->where('id','in',$attrid_arr)->execute()->as_array();
        $attr_str='';
        foreach($name_arr as $v)
        {
            $attr_str.=$v['attrname'].$separator;
        }
        $attr_str=trim($attr_str,$separator);
        return $attr_str;
		
	}

    /**
     * @function 获取景点属性列表
     * @param $attrid
     * @return array
     */
    public static function get_attr_list($attrid)
    {
        if(empty($attrid))return array();
        $sql = "SELECT id,attrname FROM `sline_spot_attr` WHERE id IN($attrid) AND isopen=1 AND pid!=0 ORDER BY displayorder ASC";
        $arr = DB::query(1,$sql)->execute()->as_array();
        return $arr;
    }
}