<?php defined('SYSPATH') or die('No direct script access.');

//供应商中心
Route::set('supplier_brokerage_pc', 'brokerage(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'brokerage',
        'action' => 'index',
        'directory' => 'pc'
    ));
