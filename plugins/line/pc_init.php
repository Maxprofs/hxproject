<?php defined('SYSPATH') or die('No direct script access.');

//前台路由规则
Route::set('linemember', 'lines/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'directory' => 'pc/line',
        'controller' => 'member',
        'action' => 'index'
    ));
Route::set('line_show', 'lines(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => '(print|show)'
))->defaults(array(
    'directory' => 'pc',
    'controller' => 'line',
    'action' => 'index',
));
//线路预订
Route::set('line_book', 'lines/book', array())->defaults(array(
    'controller' => 'line',
    'action' => 'book',
    'directory' => 'pc'
));
//线路列表
Route::set('line_list', 'lines/(<destpy>)(<sign>)(-<dayid>)(-<priceid>)(-<sorttype>)(-<displaytype>)(-<startcityid>)(-<attrid>)(-<p>)',
    array(
        'destpy' => '[0-9a-zA-Z]+',
        'sign' => '\/?',
        'dayid' => '[0-9]+',
        'priceid' => '[0-9]+',
        'sorttype' => '[0-9]+',
        'displaytype' => '[^-]',
        'startcityid' => '[0-9]+',
        'attrid' => '[0-9_]+',
        'p' => '[0-9]+'
    ))
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'line',
        'action' => 'list'
    ));
//线路其它路由规则
Route::set('line_other', 'line(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'line',
        'action' => 'index'
    ));