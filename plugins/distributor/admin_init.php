<?php defined('SYSPATH') or die('No direct script access.');

Route::set('distributor_admin', 'distributor/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'distributor',
        'action' => 'distributor',
        'directory' => 'admin'
    ));
