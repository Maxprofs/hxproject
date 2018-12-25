<?php defined('SYSPATH') or die('No direct script access.');

//目的地规则
Route::set('article_admin_dest', 'article/admin/destination(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'destination',
        'action' => 'destination',
        'directory'=>'admin/article'
    ));

//属性规则
Route::set('article_admin_attr', 'article/admin/attrid(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'attrid',
        'action' => 'index',
        'directory'=>'admin/article'
    ));

Route::set('article_admin', 'article/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'article',
        'action' => 'article',
        'directory'=>'admin'
    ));
