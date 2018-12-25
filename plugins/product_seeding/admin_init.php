<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2018/1/23 15:45
 *Desc:
 */

//通用规则
Route::set('product_seeding_admin', 'seeding/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
     ->defaults(array(
         'controller' => 'seeding',
         'action'     => 'index',
         'directory'  => 'admin',
     ));