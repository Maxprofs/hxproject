<?php defined('SYSPATH') or die('No direct script access.');
/**后台路由规则**/
Route::set('alipay_admin', 'alipay/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
     ->defaults(array(
         'controller' => 'alipay',
         'action'     => 'index',
         'directory'  => 'admin',
     ));