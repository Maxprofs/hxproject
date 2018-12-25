<?php defined('SYSPATH') or die('No direct script access.');

/**后台路由规则**/

//订单规则
Route::set('customize_admin_order', 'customize/admin/order(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'order',
        'action' => 'index',
        'directory'=>'admin/customize'
    ));
Route::set('customize_admin_field', 'customize/admin/field(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'field',
        'action' => 'index',
        'directory'=>'admin/customize'
    ));
Route::set('customize_admin_plan', 'customize/admin/plan(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'plan',
        'action' => 'index',
        'directory'=>'admin/customize'
    ));
Route::set('customize_admin_config', 'customize/admin/config(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'config',
        'action' => 'index',
        'directory' => 'admin/customize'
    ));
Route::set('customize_admin', 'customize/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'customize',
        'action' => 'customize',
        'directory'=>'admin'
    ));

