<?php defined('SYSPATH') or die('No direct script access.');
/**后台路由规则**/

Route::set('share_wx_client_admin', 'share/admin/wxclient(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'wxclient',
        'action' => 'index',
        'directory' => 'admin/share'
    ));