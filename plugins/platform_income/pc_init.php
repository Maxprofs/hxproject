<?php defined('SYSPATH') or die('No direct script access.');
//收入审核
Route::set('platform_income', 'income(/<action>(/<params>))', array('params' => '.*'))
     ->defaults(array(
         'action'     => 'index',
         'controller' => 'income',
         'directory'  => 'pc/platform',
     ));
//通用路由
Route::set('platform_income_other', 'platform(/<action>(/<params>))', array('params' => '.*'))
     ->defaults(array(
         'action'     => 'index',
         'controller' => 'platform',
         'directory'  => 'pc',
     ));