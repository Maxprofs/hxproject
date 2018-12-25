<?php defined('SYSPATH') or die('No direct script access.');


//会员中心
Route::set('red_envelope_mobile_member', 'member/envelope(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'index',
        'directory'=>'mobile/envelope'
    ));
Route::set('red_envelope_mobile', 'envelope(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'envelope',
        'action' => 'index',
        'directory' => 'mobile'
    ));