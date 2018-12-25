<?php defined('SYSPATH') or die('No direct script access.');

Route::set('hotel_member', 'hotels/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'member',
        'directory' => 'pc/hotel'
    ));
//酒店详细
Route::set('hotel', 'hotels(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'hotel',
    'directory' => 'pc'
));

//酒店预订
Route::set('hotel_book', 'hotels/book', array())->defaults(array(
    'action' => 'book',
    'controller' => 'hotel',
    'directory' => 'pc'
));
//酒店列表
Route::set('hotel_list', 'hotels/(<destpy>)(<sign>)(-<rankid>)(-<priceid>)(-<sorttype>)(-<displaytype>)(-<attrid>)(-<p>)',
    array(
        'destpy' => '[0-9a-zA-Z]+',
        'sign' => '\/?',
        'rankid' => '[0-9]+',
        'priceid' => '[0-9]+',
        'sorttype' => '[0-9]+',
        'displaytype' => '[^-]',
        'attrid' => '[0-9_]+',
        'p' => '[0-9]+'
    ))
    ->defaults(array(
        'action' => 'list',
        'controller' => 'hotel',
        'directory' => 'pc'
    ));
//其它路由规则
Route::set('hotel_other', 'hotel(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'directory' => 'pc',
        'controller' => 'hotel',
        'action' => 'index'
    ));