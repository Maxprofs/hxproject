<?php defined('SYSPATH') or die('No direct script access.');
/**后台路由规则**/

Route::set('admin_envelope', 'envelope/admin/envelope(/<action>(/<params>))', array('controller' => 'envelope','params' => '.*'))
    ->defaults(array(
        'controller' => 'envelope',
        'action' => 'index',
        'directory' => 'admin'
    ));
