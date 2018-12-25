<?php
$GLOBALS['cfg_plugin_ship_public_url'] ='/'.str_replace('\\','/',str_replace(BASEPATH,'',dirname(__FILE__))).'/public/';




if(defined('ISADMIN'))
{
    include 'admin_init.php';
}
$routeFile = ISMOBILE == 1 ? 'm' : 'pc';
include $routeFile . '_init.php';




