<?php defined('SYSPATH') or die('No direct script access.');

//路由规则
Route::set('mobile_wxpay', 'wxpay/mobile(/<action>(/<params>))', array('params' => '.*'))
     ->defaults(array(
         'action'     => 'index',
         'controller' => 'wxpay',
         'directory'  => 'mobile',
     ));