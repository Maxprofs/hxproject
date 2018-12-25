<?php defined('SYSPATH') or die('No direct script access.');
/**后台路由规则**/

//目的地规则
Route::set('notes_admin_dest', 'notes/admin/destination(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'destination',
        'action' => 'destination',
        'directory'=>'admin/notes'
    ));

Route::set('notes_admin_comment', 'notes/admin/comment(/<action>(/<params>))', array('controller' => 'comment','params' => '.*'))
    ->defaults(array(
        'controller' => 'comment',
        'action' => 'index',
        'directory' => 'admin/notes'
    ));
Route::set('notes_admin', 'notes/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'notes',
        'action' => 'index',
        'directory' => 'admin'
    ));

