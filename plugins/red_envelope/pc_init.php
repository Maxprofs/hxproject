<?php defined('SYSPATH') or die('No direct script access.');
//会员中心
Route::set('red_envelope_pc_member', 'member/envelope(-<type>)(-<p>)',
    array('p' => '[0-9]+', 'type' => '[0-9]+'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'list',
        'directory'=>'pc/envelope'
    ));
Route::set('red_envelope_pc', 'envelope(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'envelope',
        'action' => 'index',
        'directory' => 'pc'
    ));