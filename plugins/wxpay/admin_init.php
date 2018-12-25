<?php defined('SYSPATH') or die('No direct script access.');
/**后台路由规则**/
Route::set('wxpay_admin', 'wxpay/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
     ->defaults(array(
         'controller' => 'wxpay',
         'action'     => 'index',
         'directory'  => 'admin',
     ));