<?php defined('SYSPATH') or die('No direct script access.');
//前台路由规则
Route::set('api_pc_standard_main', 'api/standard(/<controller>(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'test',
        'action' => 'test',
        'directory' =>'pc/api/standard',

    ));

Route::set('api_pc_extension_main', 'api/extension(/<controller>(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'test',
        'action' => 'test',
        'directory' =>'pc/api/extension',

    ));

