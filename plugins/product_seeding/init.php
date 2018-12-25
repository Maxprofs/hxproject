<?php defined('SYSPATH') or die('No direct script access.');
/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2018/1/23 15:45
 *Desc:
 */
$GLOBALS['cfg_plugin_product_seeding_public_url'] = '/' . ltrim(str_replace('\\', '/', str_replace(BASEPATH, '', dirname(__FILE__))), '/') . '/public/';
if (! defined('DS'))
{
    define('DS', DIRECTORY_SEPARATOR);
}

define('PRODUCTSEEDING', rtrim(BASEPATH, DS) . DS . 'plugins' . DS . 'product_seeding' . DS);

//后台路由规则引入
if (defined('ISADMIN'))
{
    include 'admin_init.php';
}
/**前台路由规则**/
$routeFile = ISMOBILE == 1 ? 'm' : 'pc';
include $routeFile . '_init.php';
