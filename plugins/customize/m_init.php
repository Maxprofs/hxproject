<?php defined('SYSPATH') or die('No direct script access.');

//私人定制
Route::set('customize_member', 'customize/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'member',
        'directory' => 'mobile/customize'
    ));

Route::set('customize_plan', 'customize(/<action>_<id>.html)', array(
    'id' => '\d+',
    'action' => 'plan'
))->defaults(array(
    'action' => 'index',
    'controller' => 'customize',
    'directory' => 'mobile'
));

Route::set('customize_mobile', 'customize(/<action>)', array(
    'action' => 'index|ajax_get_more|ajax_check_msg'
))->defaults(array(
    'action' => 'index',
    'controller' => 'customize',
    'directory' => 'mobile'
));

//私人定制其它路由规则
Route::set('customize_mobile_other', 'customize(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'customize',
        'directory' => 'mobile'
    ));