<?php defined('SYSPATH') or die('No direct script access.');

//相册会员中心
Route::set('photo_member', 'photos/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'index',
        'directory' => 'pc/photo'
    ));
//相册详情
Route::set('photo', 'photos(/<action>_<aid>(_<num>).html)', array(
    'aid' => '\d+',
    'num' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'photo',
    'directory' => 'pc'
));

//相册列表
Route::set('photo_list', 'photos/(<destpy>)(<sign>)(-<attrid>)(-<p>)(-<order>)',
    array(
        'destpy' => '[0-9a-zA-Z]+',
        'sign' => '\/?',
        'attrid' => '[0-9_]+',
        'p' => '[0-9]+',
        'order' => '[0-9]+'
    ))
    ->defaults(array(
        'action' => 'list',
        'controller' => 'photo',
        'directory' => 'pc'
    ));

//相册其它路由规则
Route::set('photo_other', 'photo(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'photo',
        'directory' => 'pc'
    ));