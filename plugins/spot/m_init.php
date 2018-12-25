<?php defined('SYSPATH') or die('No direct script access.');

Route::set('spot_member', 'spots/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'index',
        'directory' => 'mobile/spot'
    ));

//景点门票
Route::set('spot_mobile', 'spots(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'spot',
    'directory' => 'mobile'
));

//景点列表
Route::set('spot_mobile_list', 'spots/<params>', array(
    'params' => '[a-zA-Z0-9]+/?((-\d+){2}(-[\d+_]+)?(-\d+)?)?',
))->defaults(array(
    'action' => 'list',
    'controller' => 'spot',
    'directory' => 'mobile'
));

//景点预订
Route::set('spot_mobile_book', 'spot/book((/<params>))', array(
    'params' => '.*'
))->defaults(array(
    'action' => 'book',
    'controller' => 'spot',
    'directory' => 'mobile',
));

//景点其它路由规则
Route::set('spot_mobile_other', 'spot(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'spot',
        'directory' => 'mobile'
    ));