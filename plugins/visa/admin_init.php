<?php defined('SYSPATH') or die('No direct script access.');
/**后台路由规则**/

//目的地规则
Route::set('visa_admin_dest', 'visa/admin/destination(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'destination',
        'action' => 'destination',
        'directory'=>'admin/visa'
    ));
//订单规则
Route::set('visa_admin_order', 'visa/admin/order(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'order',
        'action' => 'index',
        'directory'=>'admin/visa'
    ));
//属性规则
Route::set('visa_admin_attr', 'visa/admin/attrid(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'attrid',
        'action' => 'index',
        'directory'=>'admin/visa'
    ));


Route::set('visa_admin', 'visa/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'visa',
        'action' => 'visa',
        'directory'=>'admin'
    ));