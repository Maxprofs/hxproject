<?php defined('SYSPATH') or die('No direct script access.');
$GLOBALS['cfg_plugin_share_wx_client_public_url'] = '/' . str_replace('\\', '/', str_replace(BASEPATH, '', dirname(__FILE__))) . '/public/';

define('DS', DIRECTORY_SEPARATOR);
define('SHAREWXCLIENT', BASEPATH . DS . 'plugins' . DS . 'share_wx_client' . DS);

//后台路由规则引入
if(defined('ISADMIN'))
{
    include 'admin_init.php';
}

/**前台路由规则**/

$routeFile = defined('ISMOBILE') == 1 ? 'm' : 'pc';
include $routeFile . '_init.php';

