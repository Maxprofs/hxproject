<?php defined('SYSPATH') or die('No direct script access.');

/**后台路由规则**/

//目的地规则
Route::set('spot_admin_dest', 'spot/admin/destination(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'destination',
        'action' => 'destination',
        'directory' => 'admin/spot'
    ));
//订单规则
Route::set('spot_admin_order', 'spot/admin/order(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'order',
        'action' => 'index',
        'directory' => 'admin/spot'
    ));
//属性规则
Route::set('spot_admin_attr', 'spot/admin/attrid(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'attrid',
        'action' => 'index',
        'directory' => 'admin/spot'
    ));

//配置
Route::set('spot_admin_config', 'spot/admin/config(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'config',
        'action' => 'index',
        'directory' => 'admin/spot'
    ));



Route::set('spot_admin', 'spot/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'spot',
        'action' => 'spot',
        'directory' => 'admin'
    ));