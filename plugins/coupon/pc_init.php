<?php defined('SYSPATH') or die('No direct script access.');


//前台路由规则
Route::set('couponmember', 'member/coupon(-<isout>)(-<kindid>)(-<p>)', array('p' => '[0-9]+',
    'kindid' => '[0-9]+',
    'isout' => '[0-9]+',))
    ->defaults(array(
        'directory' => 'pc/coupon',
        'controller' => 'member',
        'action' => 'index'
    ));


//优惠券列表
Route::set('coupon_index', 'coupon(-<typeid>)(-<proid>)(-<p>)', array(
    'p' => '[0-9]+',
    'typeid' => '[0-9]+',
    'proid' => '[0-9]+',
))
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'coupon',
        'action' => 'index'
    ));
//领取
Route::set('coupon_get', 'coupon/ajxa_get_coupon')
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'coupon',
        'action' => 'ajxa_get_coupon'
    ));

//预定页优惠券模块
Route::set('coupon_box', 'coupon/box(-<typeid>)(-<proid>)',array('proid' => '[0-9]+',
    'typeid' => '[0-9]+',
))
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'coupon',
        'action' => 'box'
    ));

//使用条件判断
Route::set('coupon_check', 'coupon/ajax_check_samount')
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'coupon',
        'action' => 'ajax_check_samount'
    ));


//会员中心订单详情
Route::set('coupon_view_show', 'coupon/order_view(-<ordersn>)',array('ordersn' => '.*',
))
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'coupon',
        'action' => 'order_view'
    ));

//浮动框
Route::set('coupon_float_box', 'coupon/float_box(-<typeid>)(-<proid>)',array('proid' => '[0-9]+',
    'typeid' => '[0-9]+',
))
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'coupon',
        'action' => 'float_box'
    ));

//浮动框
Route::set('ajax_get_float_list', 'coupon/ajax_get_float_list')
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'coupon',
        'action' => 'ajax_get_float_list'
    ));
//产品搜索
Route::set('coupon_search', 'coupon/search-<cid>',array(
    'cid' => '[0-9]+',
))
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'coupon',
        'action' => 'search'
    ));
//积分兑换首页
Route::set('coupon_integral_home', 'coupon/integral_home')
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'coupon',
        'action' => 'integral_home'
    ));
    //积分兑换列表
Route::set('coupon_integral_all', 'coupon/integral_all')
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'coupon',
        'action' => 'integral_all'
    ));
    //积分兑换列表
Route::set('coupon_ajxa_get_coupon_from_integral', 'coupon/ajxa_get_coupon_from_integral')
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'coupon',
        'action' => 'ajxa_get_coupon_from_integral'
    ));
    //积分详情
Route::set('coupon_integral_show', 'coupon/integral_show')
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'coupon',
        'action' => 'integral_show'
    ));
