<?php
$GLOBALS['cfg_plugin_distributor_public_url'] = '/' . str_replace('\\', '/', str_replace(BASEPATH, '', dirname(__FILE__))) . '/public/';

define('PLUGINPATH', dirname(DOCROOT). DIRECTORY_SEPARATOR.'www'.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR);//插件根目录

//后台路由规则引入

if(defined('ISADMIN'))
{
    include 'admin_init.php';
}
$routeFile = ISMOBILE == 1 ? 'm' : 'pc';
include $routeFile . '_init.php';


