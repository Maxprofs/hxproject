<?php defined('SYSPATH') or die('No direct script access.');


$GLOBALS['cfg_plugin_red_envelope_public_url'] = '/' . str_replace('\\', '/', str_replace(BASEPATH, '', dirname(__FILE__))) . '/public/';
$GLOBALS['cfg_plugin_red_envelope_public_full_url'] =  St_Functions::is_SSL()? 'https://'.$GLOBALS['main_host'].$GLOBALS['cfg_plugin_red_envelope_public_url']:'http://'.$GLOBALS['main_host'].$GLOBALS['cfg_plugin_red_envelope_public_url'];
//后台路由规则引入
if(defined('ISADMIN'))
{
    include 'admin_init.php';
}

/**前台路由规则**/

$routeFile = ISMOBILE == 1 ? 'm' : 'pc';
include $routeFile . '_init.php';

