<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'order' => array(
        'inventoryShortage' => array(
            'title' => '订单错误',
            'msg' => '库存不足，请联系网站管理员'
        ),
        'writeFailure' => array(
            'title' => '订单错误',
            'msg' => '订单创建失败，请联系网站管理员'
        ),
        'addOrderFailureMustLogin' => array(
            'title' => '下单失败',
            'msg' => '订单创建失败，必须登录才能下单'
        )
    )
);