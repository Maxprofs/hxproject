<?php defined('SYSPATH') or die('No direct script access.');
/**后台路由规则**/
Route::set('api_admin_main', 'api/admin(/<controller>(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'client',
        'action' => 'index',
        'directory'=>'admin/api'
    ));
