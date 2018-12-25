<?php defined('SYSPATH') or die('No direct script access.');

Route::set('distributor_pc', 'distributor/pc((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'distributor',
        'action' => 'distributor',
        'directory' => 'pc'
    ));