<?php defined('SYSPATH') or die('No direct script access.');
Route::set('line_admin_calendar', 'line/admin/calendar(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'calendar',
        'action' => 'index',
        'directory' => 'admin/line'
    ));
//目的地规则
Route::set('line_admin_dest', 'line/admin/destination(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'destination',
        'action' => 'destination',
        'directory' => 'admin/line'
    ));
//订单规则
Route::set('line_admin_order', 'line/admin/order(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'order',
        'action' => 'index',
        'directory' => 'admin/line'
    ));
//属性规则
Route::set('line_admin_attr', 'line/admin/attrid(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'attrid',
        'action' => 'index',
        'directory' => 'admin/line'
    ));
//选项配置规则
Route::set('line_admin_config', 'line/admin/config(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'config',
        'action' => 'index',
        'directory' => 'admin/line'
    ));

Route::set('line_admin', 'line/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'line',
        'action' => 'line',
        'directory' => 'admin'
    ));
