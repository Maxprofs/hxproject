<?php defined('SYSPATH') or die('No direct script access.');

/**后台路由规则**/
Route::set('wxh5_admin', 'wxh5/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'wxh5',
        'action'     => 'index',
        'directory'  => 'admin',
    ));

