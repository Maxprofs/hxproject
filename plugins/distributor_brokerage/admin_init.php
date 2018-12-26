<?php defined('SYSPATH') or die('No direct script access.');

//后台路由
Route::set('distributor_brokerage_admin', 'distributor_brokerage/admin/brokerage(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'brokerage',
        'action' => 'index',
        'directory' => 'admin'
    ));


