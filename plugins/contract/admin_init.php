<?php defined('SYSPATH') or die('No direct script access.');
/**后台路由规则**/
Route::set('contract_admin', 'contract/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'contract',
        'action' => 'index',
        'directory'=>'admin'
    ));
