<?php defined('SYSPATH') or die('No direct script access.');
//目的地规则
Route::set('ship_admin_dest', 'ship/admin/destination(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'destination',
        'action' => 'destination',
        'directory'=>'admin/ship'
    ));
//订单规则
Route::set('ship_admin_order', 'ship/admin/order(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'order',
        'action' => 'index',
        'directory'=>'admin/ship'
    ));
//属性规则
Route::set('ship_admin_attr', 'ship/admin/attrid(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'attrid',
        'action' => 'index',
        'directory'=>'admin/ship'
    ));

Route::set('ship_admin', 'ship/admin/(<controller>(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'ship',
        'action' => 'index',
        'directory'=>'admin'
    ));