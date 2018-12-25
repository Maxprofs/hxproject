<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Customize extends ORM {
    public static $typeid = 14;
    public static $deprecated_fields = array('hotelrank','room','foot');

    public  function delete_clear()
    {
        DB::delete('member_order')->where('productautoid','=',$this->id)->and_where('typeid','=',14);
        $this->delete();

    }

    public static function get_deprecated_fields()
    {
        return self::$deprecated_fields;
    }

    public static function storage($suitid,$dingnum,$order_arr)
    {
        return true;
    }
    public static function get_extend_info($productid)
    {
        //扩展信息
        $extend_info = DB::select()->from('customize_extend_field')->where('productid','=',$productid)->execute()->current();
        foreach($extend_info as $k=>$v)
        {
            $field_name = substr($k,2);
            if(!empty($info[$field_name]) && in_array($field_name,Model_Customize::get_deprecated_fields()))
            {
                $extend_info[$k] = $info[$field_name];
            }
        }
        return $extend_info;
    }
    public static function add_order_log($order,$prev_status)
    {
        if($order['status']==1)
        {
           return Model_Member_Order_Log::add_log($order,$prev_status,true,'客服处理您的需求，为您推荐了旅行方案');
        }
        else
        {
           return Model_Member_Order_Log::add_log($order,$prev_status,true);
        }
    }
}