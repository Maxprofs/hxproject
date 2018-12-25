<?php defined('SYSPATH') or die('No direct script access.');

Route::set('zt_index', 'zt(/index)')
    ->defaults(array(
        'action' => 'index',
        'controller' => 'zt',
        'directory' => 'mobile'
    ));

//手机专题详情
Route::set('zt_show', 'zt/<pinyin>(.html)', array('pinyin' => '[0-9a-zA-Z]+'))
    ->defaults(array(
        'action' => 'show',
        'controller' => 'zt',
        'directory' => 'mobile'
    ));
//其它路由规则
Route::set('zt_other', 'zt(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'zt',
        'directory' => 'mobile'
));