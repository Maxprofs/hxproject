<?php defined('SYSPATH') or die('No direct script access.');


Route::set('ship_member', 'ship/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'index',
        'directory' =>'pc/ship'
    ));


//线路详情
Route::set('ship_show', 'ship(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => '(print|show|cruise)'
))->defaults(array(
    'directory'=>'pc',
    'action' => 'index',
    'controller' => 'ship'
));
//线路预订
Route::set('ship_book', 'ship/book', array())->defaults(array(
    'controller' => 'ship',
    'action' => 'book',
    'directory' => 'pc'
));
//创建订单
Route::set('ship_create', 'ship/create', array())->defaults(array(
    'controller' => 'ship',
    'action' => 'create',
    'directory' => 'pc',
));

//线路列表

Route::set('ship_list', 'ship/(<destpy>)(<sign>)(-<dayid>)(-<priceid>)(-<sorttype>)(-<startcityid>)(-<shipid>)(-<attrid>)(-<p>)',
    array(
        'destpy' => '[0-9a-zA-Z]+',
        'sign'=>'\/?',
        'dayid' => '[0-9]+',
        'priceid' => '[0-9]+',
        'sorttype' => '[0-9]+',
        'startcityid' => '[0-9]+',
        'shipid' => '[0-9]+',
        'attrid' => '[0-9_]+',
        'p' => '[0-9]+'
    ))
    ->defaults(array(
        'directory' => 'pc',
        'controller'=>'ship',
        'action'=>'list'
    ));
Route::set('ship_other', 'ship(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'ship',
        'action' => 'index'
    ));
