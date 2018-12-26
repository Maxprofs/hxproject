<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Supplier extends ORM
{
    //对应数据库
    protected $_table_name = 'distributor';
    protected $_primary_key = 'id';
    /**
     * 根据会员id获取用户信息
     * @param $mid
     * @return array
     */
    public static function get_distributor_byid($distributorid)
    {
        if ($distributorid)
        {
            $memberinfo = ORM::factory('distributor', $distributorid)->as_array();
            $memberinfo['distributorkind'] = ORM::factory('distributor_kind',$memberinfo['kindid'])->get('kindname');
            return $memberinfo;
        }

    }


}