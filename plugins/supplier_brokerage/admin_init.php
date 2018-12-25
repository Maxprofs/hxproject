<?php defined('SYSPATH') or die('No direct script access.');

//后台路由
Route::set('supplier_brokerage_admin', 'supplier_brokerage/admin/brokerage(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'brokerage',
        'action' => 'index',
        'directory' => 'admin'
    ));


