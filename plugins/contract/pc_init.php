<?php defined('SYSPATH') or die('No direct script access.');
/**后台路由规则**/
Route::set('contract_pc', 'contract(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'contract',
        'action' => 'index',
        'directory' => 'pc',
    ));

