<?php defined('SYSPATH') or die('No direct script access.');

Route::set('notes_mobile_index', 'notes(/<action>(_<id>.html))', array(
    'id' => '\d+',
    'action' => 'index|show|ajax_get_more'
))->defaults(array(
    'action' => 'index',
    'controller' => 'notes',
    'directory' => 'mobile'
));
Route::set('notes_member', 'notes/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'mynotes',
        'directory' => 'mobile/notes'
    ));

Route::set('notes_mobile_other', 'notes/<params>', array(
    'params' => '[a-zA-Z0-9]+/?(-\d+)?'
))->defaults(array(
    'action' => 'index',
    'controller' => 'notes',
    'directory' => 'mobile'
));