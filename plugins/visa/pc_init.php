<?php defined('SYSPATH') or die('No direct script access.');

//签证会员中心
Route::set('visamember', 'visa/member(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'member',
        'action' => 'index',
        'directory' =>'pc/visa'
    ));

//签证详细
Route::set('visa', 'visa(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'visa',
    'directory' =>'pc'
));

//签证预订
Route::set('visa_book', 'visa/book', array())->defaults(array(
    'controller' => 'visa',
    'action' => 'book',
    'directory' =>'pc'
));
Route::set('visa_create', 'visa/create', array())->defaults(array(
    'controller' => 'visa',
    'action' => 'create',
    'directory' => 'pc'
));

//签证列表
Route::set('visa_list', 'visa/(<countrypy>)(<sign>)(-<cityid>)(-<sorttype>)(-<visatypeid>)(-<p>)',
    array(
        'countrypy' => '[a-zA-Z][a-zA-Z0-9]+',
        'sign'=>'\/?',
        'cityid' => '[0-9]+',
        'sorttype' => '[0-9]+',
        'visatypeid' => '[0-9]+',
        'p' => '[0-9]+'
    ))
    ->defaults(array(
        'action'=>'list',
        'controller'=>'visa',
        'directory' =>'pc'
    ));

//签证其它路由规则
Route::set('visa_other', 'visa(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'visa',
        'directory' =>'pc'
    ));