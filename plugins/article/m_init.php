<?php defined('SYSPATH') or die('No direct script access.');

//攻略详情
Route::set('article_mobile', 'raiders(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'article',
    'directory' => 'mobile'
));

//攻略列表
Route::set('article_mobile_list', 'raiders/<params>', array(
    'params' => '[a-zA-Z0-9]+/?((-[\d+_]+)+(-\d+)?)?'
))->defaults(array(
    'action' => 'list',
    'controller' => 'article',
    'directory' => 'mobile'
));

//攻略其它路由规则
Route::set('article_mobile_other', 'article(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'article',
        'directory' => 'mobile'
    ));