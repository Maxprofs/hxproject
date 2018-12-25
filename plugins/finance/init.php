<?php defined('SYSPATH') or die('No direct script access.');

$GLOBALS['cfg_plugin_finance_public_url'] = str_replace('\\','/',str_replace(BASEPATH,'',dirname(__FILE__))).'/public/';


if(defined('ISADMIN'))
{
    include 'admin_init.php';
}
/**前台路由规则**/
$routeFile = defined('ISMOBILE') ? 'm' : 'pc';
include $routeFile . '_init.php';

