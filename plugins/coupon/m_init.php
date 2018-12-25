<?php defined('SYSPATH') or die('No direct script access.');


//前台路由规则
Route::set('mobile_couponmember', 'member/coupon(-<isout>)(-<kindid>)(-<p>)', array('p' => '[0-9]+',
    'kindid' => '[0-9]+',
    'isout' => '[0-9]+',))
    ->defaults(array(
        'directory' => 'mobile/coupon',
        'controller' => 'member',
        'action' => 'index'
    ));


//优惠券列表
Route::set('mobile_coupon_index', 'coupon(-<p>)(-<typeid>)(-<productid>)', array(
    'p' => '[0-9]+',
    'typeid' => '[0-9]+',
    'productid' => '[0-9]+',
))
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'coupon',
        'action' => 'index'
    ));
//领取
Route::set('mobile_coupon_get', 'coupon/ajxa_get_coupon')
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'coupon',
        'action' => 'ajxa_get_coupon'
    ));

//预定页优惠券模块
Route::set('mobile_coupon_box', 'coupon/box(-<typeid>)(-<proid>)',array('proid' => '[0-9]+',
    'typeid' => '[0-9]+',
))
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'coupon',
        'action' => 'box'
    ));
//新预定页优惠券模块
Route::set('mobile_coupon_box_new', 'coupon/box_new(-<typeid>)(-<proid>)',array('proid' => '[0-9]+',
    'typeid' => '[0-9]+',
))
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'coupon',
        'action' => 'box_new'
    ));

//使用条件判断
Route::set('mobile_coupon_check', 'coupon/ajax_check_samount')
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'coupon',
        'action' => 'ajax_check_samount'
    ));


//会员中心订单详情
Route::set('mobile_coupon_view_show', 'coupon/order_view(-<ordersn>)',array('ordersn' => '.*',
))
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'coupon',
        'action' => 'order_view'
    ));

//详情页加载框
Route::set('mobile_coupon_float_box', 'coupon/float_box(-<typeid>)(-<proid>)',array('proid' => '[0-9]+',
    'typeid' => '[0-9]+',
))
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'coupon',
        'action' => 'float_box'
    ));
//优惠券列表
Route::set('mobile_coupon_list', 'coupon/ajax_get_list')
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'coupon',
        'action' => 'ajax_get_list'
    ));
//会员中心分页加载
Route::set('mobile_coupon_ajax_get_list', 'member/coupon/ajax_get_list')
    ->defaults(array(
        'directory' => 'mobile/coupon',
        'controller' => 'member',
        'action' => 'ajax_get_list'
    ));

//产品搜索
Route::set('mobile_coupon_search', 'coupon/search-<cid>',array(
    'cid' => '[0-9]+',
))
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'coupon',
        'action' => 'search'
    ));


    //产品搜索
Route::set('mobile_search_ajax_more', 'coupon/search_ajax_more')
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'coupon',
        'action' => 'search_ajax_more'
    ));


//积分详情
Route::set('mobile_coupon_integral_show', 'coupon/integral_show')
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'coupon',
        'action' => 'integral_show'
    ));
//兑换
Route::set('mobile_coupon_ajxa_get_coupon_from_integral', 'coupon/ajxa_get_coupon_from_integral')
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'coupon',
        'action' => 'ajxa_get_coupon_from_integral'
    ));