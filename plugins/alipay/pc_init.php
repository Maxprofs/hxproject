<?php defined('SYSPATH') or die('No direct script access.');
//支付宝网银支付路由规则
Route::set('alipaybank', 'alipaybank/pc(/<action>(/<params>))', array('params' => '.*'))
     ->defaults(array(
         'action'     => 'index',
         'controller' => 'alipaybank',
         'directory'  => 'pc',
     ));
//支付宝即时支付路由规则
Route::set('alipaycash', 'alipaycash/pc(/<action>(/<params>))', array('params' => '.*'))
     ->defaults(array(
         'action'     => 'index',
         'controller' => 'alipaycash',
         'directory'  => 'pc',
     ));
//支付宝担保交易路由规则
Route::set('alipaydanbao', 'alipaydanbao/pc(/<action>(/<params>))', array('params' => '.*'))
     ->defaults(array(
         'action'     => 'index',
         'controller' => 'alipaydanbao',
         'directory'  => 'pc',
     ));
//支付宝双功能路由规则
Route::set('alipaydouble', 'alipaydouble/pc(/<action>(/<params>))', array('params' => '.*'))
     ->defaults(array(
         'action'     => 'index',
         'controller' => 'alipaydouble',
         'directory'  => 'pc',
     ));


//手机端路由规则
Route::set('mobile_alipay', 'alipay/mobile(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action'     => 'index',
        'controller' => 'alipay',
        'directory'  => 'mobile',
    ));