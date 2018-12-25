<?php defined('SYSPATH') or die('No direct script access.');

/**后台路由规则**/

Route::set('zt_admin', 'zt/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'zt',
        'action' => 'list',
        'directory' => 'admin'
    ));