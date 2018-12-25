<?php defined('SYSPATH') or die('No direct script access.');
//前台路由规则
Route::set('car_member', 'cars/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'index',
        'directory' =>'pc/car',

    ));
//租车详情
Route::set('car', 'cars(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'car',
     'directory' => 'pc',
));
//租车预订
Route::set('car_book', 'cars/book', array())->defaults(array(
    'controller' => 'car',
    'action' => 'book',
    'directory' => 'pc',
));
//租车列表
Route::set('car_list','cars/(<destpy>)(<sign>)(-<carkindid>)(-<sorttype>)(-<attrid>)(-<priceid>)(-<p>)',
    array(
        'destpy' => '[0-9a-zA-Z]+',
        'sign'=>'\/?',
        'carkindid' => '[0-9]+',
        'sorttype' => '[0-9]+',
        'attrid' => '[0-9_]+',
        'priceid' => '[0-9]+',
        'p' => '[0-9]+'
    ))
    ->defaults(array(
        'controller'=>'car',
        'action'=>'list',
        'directory' => 'pc',
    ));
//租车其它路由规则
Route::set('car_other', 'car(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'car',
        'action' => 'index',
        'directory' => 'pc',
    ));
