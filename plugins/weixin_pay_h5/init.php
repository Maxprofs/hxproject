<?php defined('SYSPATH') or die('No direct script access.');


$GLOBALS['cfg_plugin_weixin_pay_h5_public_url'] = '/' . str_replace('\\', '/', str_replace(BASEPATH, '', dirname(__FILE__))) . '/public/';

//定义应用根目录
define('WXH5', dirname(__FILE__).DIRECTORY_SEPARATOR);

//后台路由规则引入
if(defined('ISADMIN'))
{
    include 'admin_init.php';
}

//手机支付配置
Route::set('weixin_pay_mobile', 'wxh5/mobile(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'wxh5',
        'directory' => 'mobile'
    ));


