<?php defined('SYSPATH') or die('No direct script access.');
$GLOBALS['cfg_plugin_platform_income_public_url'] = '/' . ltrim(str_replace('\\', '/', str_replace(BASEPATH, '', dirname(__FILE__))), '/') . '/public/';
if (! defined('DS'))
{
    define('DS', DIRECTORY_SEPARATOR);
}
define('STERP', rtrim(BASEPATH, DS) . DS . 'plugins' . DS . 'platform_income' . DS);
//后台路由
if (defined('ISADMIN'))
{
    include 'admin_init.php';
}

//前台路由
$routeFile = ISMOBILE == 1 ? 'm' : 'pc';
include $routeFile . '_init.php';

