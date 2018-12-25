<?php defined('SYSPATH') or die('No direct script access.');

Route::set('zt_index', 'zt(/index)')
    ->defaults(array(
        'action' => 'index',
        'controller' => 'zt',
        'directory' => 'pc'
    ));

Route::set('zt_show', 'zt/<pinyin>(.html)', array('pinyin' => '[0-9a-zA-Z]+'))
    ->defaults(array(
        'action' => 'show',
        'controller' => 'zt',
        'directory' => 'pc'
    ));

