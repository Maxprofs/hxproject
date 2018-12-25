<?php defined('SYSPATH') or die('No direct script access.');


//签证会员中心
Route::set('visa_member', 'visa/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'index',
        'directory' =>'mobile/visa'
    ));


//签证详细
Route::set('visa_mobile', 'visa(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'visa',
    'directory' => 'mobile'
));

//签证预订
Route::set('visa_discount', 'visa/discount', array(
    'params' => '.*'
))->defaults(array(
    'action' => 'discount',
    'controller' => 'visa',
    'directory' => 'mobile'
));

//签证列表
Route::set('visa_mobile_list', 'visa/<params>', array(
    'params' => '((?!search|create)[a-zA-Z0-9])+/?(-[\d_]+(-\d+){0,2})?'
))->defaults(array(
    'action' => 'list',
    'controller' => 'visa',
    'directory' => 'mobile'
));

//签证预订
Route::set('visa_mobile_book', 'visa/book((/<params>))', array(
    'params' => '.*'
))->defaults(array(
    'action' => 'book',
    'controller' => 'visa',
    'directory' => 'mobile'
));

//签证其它路由规则
Route::set('visa_mobile_other', 'visa(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'visa',
        'directory' => 'mobile'
    ));