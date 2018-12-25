<?php defined('SYSPATH') or die('No direct script access.');

Route::set('spot_member', 'spots/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'index',
        'directory' => 'pc/spot'
    ));
Route::set('spot', 'spots(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'spot',
    'directory' => 'pc'
));

//景点列表
Route::set('spot_list', 'spots/(<destpy>)(<sign>)(-<priceid>)(-<sorttype>)(-<attrid>)(-<p>)',
    array(
        'destpy' => '[0-9a-zA-Z]+',
        'sign' => '\/?',
        'priceid' => '[0-9]+',
        'sorttype' => '[0-9]+',
        'attrid' => '[0-9_]+',
        'p' => '[0-9]+'
    ))
    ->defaults(array(
        'action' => 'list',
        'controller' => 'spot',
        'directory' => 'pc'
    ));
//景点其它路由规则
Route::set('spot_other', 'spot(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'spot',
        'directory' => 'pc'
    ));