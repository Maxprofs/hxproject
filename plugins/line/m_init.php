<?php defined('SYSPATH') or die('No direct script access.');


//前台路由规则
Route::set('linemember', 'lines/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'directory' => 'mobile/line',
        'controller' => 'member',
        'action' => 'index'
    ));
//线路详情
Route::set('mobile_line', 'lines(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => '(print|show)'
))->defaults(array(
    'action' => 'index',
    'controller' => 'line',
    'directory' => 'mobile'
));


//线路列表
Route::set('mobile_line_list', 'lines/<params>', array(
    'params' => '[a-zA-Z0-9]+\/?((-0-0)?(-\d+){3}-[^-]+(-\d+)?-[\d+_]+(-\d+)?)?'
))->defaults(array(
    'action' => 'list',
    'controller' => 'line',
    'directory' => 'mobile'
));

//线路预订
Route::set('mobile_line_book', 'line/book((/<params>))', array(
    'params' => '.*'
))->defaults(array(
    'directory' => 'mobile',
    'controller' => 'line',
    'action' => 'book',
));
//线路其它路由规则
Route::set('mobile_line_other', 'line(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'line',
        'action' => 'index'
    ));