<?php defined('SYSPATH') or die('No direct script access.');


Route::set('share_wx_client_other', 'share/wxclient(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'wxclient',
        'directory' => 'mobile/share'
    ));
