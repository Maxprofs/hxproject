<?php defined('SYSPATH') or die('No direct script access.');

Route::set('hotel_member', 'hotels/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'member',
        'directory' => 'mobile/hotel'
    ));
//酒店详细
//酒店详细
Route::set('hotel_mobile', 'hotels(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'hotel',
    'directory' => 'mobile'
));

//酒店列表
Route::set('hotel_mobile_list', 'hotels/<params>', array(
    'params' => '[a-zA-Z0-9]+/?((-\d+){3}-[^-]+-[\d_]+(-\d+)?)?'
))->defaults(array(
    'action' => 'list',
    'controller' => 'hotel',
    'directory' => 'mobile'
));
//酒店预订
Route::set('hotel_mobile_book', 'hotel/book((/<params>))', array(
    'params' => '.*'
))->defaults(array(
    'action' => 'book',
    'controller' => 'hotel',
    'directory' => 'mobile',
));
//酒店其它路由规则
Route::set('hotel_mobile_other', 'hotel(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'hotel',
        'directory' => 'mobile'
    ));