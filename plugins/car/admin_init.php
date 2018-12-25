<?php defined('SYSPATH') or die('No direct script access.');
/**后台路由规则**/
//日历报价
Route::set('car_admin_calendar', 'car/admin/calendar(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'calendar',
        'action' => 'index',
        'directory' => 'admin/car'
    ));
//目的地规则
Route::set('car_admin_dest', 'car/admin/destination(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'destination',
        'action' => 'destination',
        'directory'=>'admin/car'
    ));
//订单规则
Route::set('car_admin_order', 'car/admin/order(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'order',
        'action' => 'index',
        'directory'=>'admin/car'
    ));
//属性规则
Route::set('car_admin_attr', 'car/admin/attrid(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'attrid',
        'action' => 'index',
        'directory'=>'admin/car'
    ));


Route::set('car_admin', 'car/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'car',
        'action' => 'car',
        'directory'=>'admin'
    ));
