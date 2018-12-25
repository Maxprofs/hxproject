<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Article_Attr extends ORM {

    protected  $_table_name = 'article_attr';
	
	
	public static function getAttrnameList($attrid_str,$separator=',')
	{
        $attrid_arr=explode(',',$attrid_str);
        if(empty($attrid_arr))
            return null;
        $name_arr=DB::select('attrname')->from('article_attr')->where('id','in',$attrid_arr)->execute()->as_array();
        $attr_str='';
        foreach($name_arr as $v)
        {
            $attr_str.=$v['attrname'].$separator;
        }
        $attr_str=trim($attr_str,$separator);
        return $attr_str;
		
	}
	/**
     * @param $attrid
     * @return mixed
     * @desc 根据属性id返回属性数组.
     */
    public static function get_attr_list($attrid)
    {
       if(empty($attrid))return array();
        $attrid = trim($attrid,',');
       $sql = "SELECT id,attrname,pid FROM `sline_article_attr` WHERE id IN($attrid) AND isopen=1 AND pid!=0 ORDER BY displayorder ASC";
       $arr = DB::query(1,$sql)->execute()->as_array();
       return $arr;
    }
    //属性信息
    public static function get_attrname_list($attrid_str,$separator=',')
    {
        $attrid_arr=explode('_',$attrid_str);
        $arr = DB::select('attrname')->from('article_attr')->where('id','in',$attrid_arr)->execute()->as_array();
        $out = array();
        foreach($arr as $v)
        {
            $out[] = $v['attrname'];
        }
        $attr_str=implode($out,$separator);
        return $attr_str;

    }

}