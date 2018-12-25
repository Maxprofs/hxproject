<?php

Route::set('finance_add_count_info', 'financeextend/order_set_count_info', array())
    ->defaults(array(
        'directory'=>'pc',
        'controller' => 'financeextend',
        'action' => 'order_set_count_info'
    ));
Route::set('finance_caculate_commission', 'financeextend/order_caculate_platform_commission', array())
    ->defaults(array(
        'directory'=>'pc',
        'controller' => 'financeextend',
        'action' => 'order_caculate_platform_commission'
    ));