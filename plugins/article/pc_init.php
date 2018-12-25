<?php defined('SYSPATH') or die('No direct script access.');

//攻略首页
Route::set('article', 'raiders(/)', array())->defaults(array(
    'action' => 'index',
    'controller' => 'article',
    'directory' => 'pc'
));

//攻略详情
Route::set('article_show', 'raiders(/<action>_<aid>.html)', array(
    'aid' => '\d+',
    'action' => 'show'
))->defaults(array(
    'action' => 'index',
    'controller' => 'article',
    'directory' => 'pc'
));

//攻略列表
Route::set('article_list', 'raiders/(<destpy>)(<sign>)(-<sorttype>)(-<attrid>)(-<p>)',
    array(
        'destpy' => '[0-9a-zA-Z]+',
        'sign' => '\/?',
        'attrid' => '[0-9_]+',
        'sorttype' => '[0-9]+',
        'p' => '[0-9]+'
    ))
    ->defaults(array(
        'action' => 'list',
        'controller' => 'article',
        'directory' => 'pc'
    ));

//攻略其它路由规则
Route::set('article_other', 'article(/<action>(/<params>))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'article',
        'directory' => 'pc'
    ));