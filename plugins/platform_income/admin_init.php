<?php defined('SYSPATH') or die('No direct script access.');
//供应商收入审核
Route::set('platform_income_admin', 'income/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
     ->defaults(array(
         'controller' => 'income',
         'action'     => 'index',
         'directory'  => 'admin/platform',
     ));

//通用规则
Route::set('platform_admin', 'sterp/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
     ->defaults(array(
         'controller' => 'platform',
         'action'     => 'index',
         'directory'  => 'admin',
     ));