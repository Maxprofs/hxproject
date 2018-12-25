<?php defined('SYSPATH') or die('No direct script access.');
class Taglib_Coupon
{


    public static function query($params)
    {

        $default = array(
            'row'    => '8',
            'p' => 0,
            'kind'=>2,
        );
        $params = array_merge($default, $params);
        extract($params);

        $out = Model_Coupon::search_result(array(), $p, $row,null,null,$kind);
        $list = $out['list'];
        foreach($list as &$l)
        {
            $l['litpic']  = '/uploads/integral.jpg';
            $l['title'] = $l['name'];
            $l['need_jifen'] = $l['needjifen'];
            $l['url'] = '/coupon/integral_show?cid='.$l['id'];
        }

        return $list;
    }



}