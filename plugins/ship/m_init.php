<?php defined('SYSPATH') or die('No direct script access.');
Route::set('ship_member', 'ship/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'index',
        'directory' =>'mobile/ship'
    ));

//设施详情
Route::set('ship_mobile_facility', 'ship/facility(/<params>).html',
    array('params' => '.*')
)->defaults(array(
    'directory'=>'mobile',
    'action' => 'facility',
    'controller' => 'ship'
));


//加载更多
Route::set('ship_mobile_ajax_line_more', 'ship/ajax_line_more/(<destpy>)(<sign>)(-<dayid>)(-<priceid>)(-<sorttype>)(-<startcityid>)(-<shipid>)(-<attrid>)(-<p>)',
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
        'directory' => 'mobile',
        'controller'=>'ship',
        'action'=>'ajax_line_more'
    ));


//线路预订
Route::set('ship_mobile_book', 'ship/book', array())->defaults(array(
    'controller' => 'ship',
    'action' => 'book',
    'directory' => 'mobile'
));
//创建订单
Route::set('ship_mobile_create', 'ship/create', array())->defaults(array(
    'controller' => 'ship',
    'action' => 'create',
    'directory' => 'mobile',
));

//航线列表
Route::set('ship_mobile_list', 'ship/(<destpy>)(-<dayid>)(-<priceid>)(-<sorttype>)(-<startcityid>)(-<shipid>)(-<attrid>)(-<p>)',
    array(
        'destpy' => '[0-9a-zA-Z]+',
        'dayid' => '[0-9]+',
        'priceid' => '[0-9]+',
        'sorttype' => '[0-9]+',
        'startcityid' => '[0-9]+',
        'shipid' => '[0-9]+',
        'attrid' => '[0-9_]+',
        'p' => '[0-9]+'
    ))
    ->defaults(array(
        'directory' => 'mobile',
        'controller'=>'ship',
        'action'=>'list'
    ));

//详情
Route::set('ship_mobile_show', 'ship(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => '(print|show|cruise|roomlist)'
))->defaults(array(
    'directory'=>'mobile',
    'action' => 'index',
    'controller' => 'ship'
));

//其它路由规则
Route::set('ship_mobile_other', 'ship(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'ship',
        'action' => 'index'
    ));