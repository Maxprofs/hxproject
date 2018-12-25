<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Customize_Extend_Field_Desc extends ORM {

    //获取所有的扩展字段
	 public static function get_fields()
     {
         $fields = DB::select()->from('customize_extend_field_desc')->where('pid','=',0)->and_where('isopen','=',1)->order_by('displayorder','ASC')->execute()->as_array();
         foreach($fields as &$v)
         {
             $subs = DB::select('chinesename')->from('customize_extend_field_desc')->where('pid','=',$v['id'])->and_where('isopen','=',1)->order_by('displayorder','ASC')->execute()->as_array();
             $options = array();
             foreach($subs as $sub)
             {
                 $options[] = $sub['chinesename'];
             }
             $v['options'] = $options;
         }
         return $fields;
     }
}