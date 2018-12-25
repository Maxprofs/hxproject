<?php defined('SYSPATH') or die('No direct script access.');
/**后台路由规则**/

//目的地规则
Route::set('photo_admin_dest', 'photo/admin/destination(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'destination',
        'action' => 'destination',
        'directory'=>'admin/photo'
    ));

//属性规则
Route::set('photo_admin_attr', 'photo/admin/attrid(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'attrid',
        'action' => 'index',
        'directory'=>'admin/photo'
    ));


Route::set('photo_admin', 'photo/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'photo',
        'action' => 'photo',
        'directory'=>'admin'
    ));