<?php defined('SYSPATH') or die('No direct access allowed.');


class Model_Line_Attr extends ORM
{
    public static function get_attrname_list($attrid_str,$separator=',')
    {
        $attrid_arr=explode('_',$attrid_str);
        $arr = DB::select('attrname')->from('line_attr')->where('id','in',$attrid_arr)->execute()->as_array();
        $out = array();
        foreach($arr as $v)
        {
            $out[] = $v['attrname'];
        }
        $attr_str=implode($out,$separator);
        return $attr_str;

    }

    public function delete_clear()
    {
        Common::deleteRelativeImage($this->litpic);
        $children=ORM::factory('line_attr')->where("pid={$this->id}")->find_all()->as_array();
        foreach($children as $child)
        {
            $child->delete_clear();
        }
        $this->delete();
    }

    /*
     * 获得属性内容
     */
    public static function get_attr_info($attrid)
    {
        return DB::select('attrname')->from('line_attr')->where('id','=',$attrid)->execute()->current();
    }


}