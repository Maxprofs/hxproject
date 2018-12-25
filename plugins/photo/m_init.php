<?php defined('SYSPATH') or die('No direct script access.');

//相册详情
Route::set('photo_mobile', 'photos(/<action>_<aid>(_<num>).html)', array(
    'aid' => '\d+',
    'num' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'photo',
    'directory' => 'mobile'
));

//相册列表
Route::set('photo_mobile_list', 'photos/<params>', array(
    'params' => '[a-zA-Z0-9]+(-[\d+_]+(-\d+)?(-\d+)?)?'
))->defaults(array(
    'action' => 'list',
    'controller' => 'photo',
    'directory' => 'mobile'
));

//相册其它路由规则
Route::set('photo_mobile_other', 'photo(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'photo',
        'directory' => 'mobile'
    ));