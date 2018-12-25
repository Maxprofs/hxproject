<?php defined('SYSPATH') or die('No direct script access.');

/**后台路由规则**/
//日历报价
Route::set('hotel_admin_calendar', 'hotel/admin/calendar(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'calendar',
        'action' => 'index',
        'directory' => 'admin/hotel'
    ));
//目的地规则
Route::set('hotel_admin_dest', 'hotel/admin/destination(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'destination',
        'action' => 'destination',
        'directory' => 'admin/hotel'
    ));
//订单规则
Route::set('hotel_admin_order', 'hotel/admin/order(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'order',
        'action' => 'index',
        'directory' => 'admin/hotel'
    ));
//属性规则
Route::set('hotel_admin_attr', 'hotel/admin/attrid(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'attrid',
        'action' => 'index',
        'directory' => 'admin/hotel'
    ));

Route::set('hotel_admin_config', 'hotel/admin/config(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'config',
        'action' => 'index',
        'directory' => 'admin/hotel'
    ));

Route::set('hotel_admin', 'hotel/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'hotel',
        'action' => 'hotel',
        'directory' => 'admin'
    ));