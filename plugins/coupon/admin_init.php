<?php
$GLOBALS['cfg_plugin_coupon_public_url'] ='/'.str_replace('\\','/',str_replace(BASEPATH,'',dirname(__FILE__))).'/public/';


//ÓÅ»İÈ¯ºóÌ¨
Route::set('coupon/admin', 'coupon/admin/(<controller>(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'coupon',
        'action' => 'index',
        'directory'=>'admin'
    ));


