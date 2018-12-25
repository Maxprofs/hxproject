<?php defined('SYSPATH') or die('No direct script access.');
$GLOBALS['cfg_plugin_alipay_public_url'] = '/' . str_replace('\\', '/', str_replace(BASEPATH, '', dirname(__FILE__))) . '/public/';

if (! defined('DS'))
{
    define('DS', DIRECTORY_SEPARATOR);
}
$temp = rtrim(BASEPATH, DS);
define('ALIPAY', $temp . DS . 'plugins' . DS . 'alipay' . DS);

//后台路由规则引入
if (defined('ISADMIN'))
{
    include 'admin_init.php';
}
/**前台路由规则**/
$routeFile = ISMOBILE == 1 ? 'm' : 'pc';
include $routeFile . '_init.php';
