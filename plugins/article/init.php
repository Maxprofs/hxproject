<?php defined('SYSPATH') or die('No direct script access.');
$GLOBALS['cfg_plugin_article_public_url'] ='/'.str_replace('\\','/',str_replace(BASEPATH,'',dirname(__FILE__))).'/public/';

/**后台路由规则**/
if(defined('ISADMIN'))
{
    include 'admin_init.php';
}
/**前台路由规则**/

$routeFile = ISMOBILE == 1 ? 'm' : 'pc';
include $routeFile . '_init.php';
