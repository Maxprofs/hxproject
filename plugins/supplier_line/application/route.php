<?php defined('SYSPATH') or die('No direct script access.');
Route::set('default', '(<controller>(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'index',
        'action' => 'index',
    ));
