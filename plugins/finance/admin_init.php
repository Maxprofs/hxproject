<?php


Route::set('finance_admin', 'finance/admin((/<controller>)(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'controller' => 'financeextend',
        'action' => 'index',
        'directory'=>'admin',
    ));