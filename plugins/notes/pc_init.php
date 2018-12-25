<?php defined('SYSPATH') or die('No direct script access.');

//游记会员中心
Route::set('notes_mynotes', 'notes/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'mynotes',
        'directory' => 'pc/notes'
    ));

//游记版块
Route::set('notes', 'notes(/<action>_<id>.html)', array(
    'id' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'notes',
    'directory' => 'pc'
));

//游记其它版块
Route::set('notes_other', 'notes(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'notes',
        'action' => 'index',
        'directory' => 'pc'
    ));
