<?php defined('SYSPATH') or die('No direct script access.');

Route::set('car_member', 'cars/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'index',
        'directory' =>'mobile/car',

    ));
//线路详情
Route::set('mobile_car', 'cars(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'car',
    'directory'=>'mobile'
));

//租车列表
Route::set('mobile_car_list', 'cars/<params>', array(
    'params' => '[a-zA-Z0-9]+((-[\d_]+){4}+(-\d+)?+(?))?'
))->defaults(array(
    'action' => 'list',
    'controller' => 'car',
    'directory'=>'mobile'
));

//线路预订
Route::set('mobile_car_book', 'car/book((/<params>))', array(
    'params' => '.*'
))->defaults(array(
    'directory' => 'mobile',
    'controller' => 'car',
    'action' => 'book',
));
//线路其它路由规则
Route::set('mobile_car_other', 'car(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'directory' => 'mobile',
        'controller' => 'car',
        'action' => 'index'
    ));