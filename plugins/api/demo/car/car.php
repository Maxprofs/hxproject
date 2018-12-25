<?php
/**
 *User: idoiwill
 *Email: xslt@idoiwill.com
 *Blog: http://www.idoiwill.com
 *DateTime: 2017/5/15 15:01
 */

require './command/cardemoapi.php';
$obj = new CarDemoApi();

/***1广告图开始***/
/*$method = 'api/standard/car/get_rolling_ad';
$params = array(
    'name' => 's_car_index_1',
);*/
/***1广告图结束***/

/***2栏目信息开始***/
/*$method = 'api/standard/car/channel';
$params = array();*/
/***2栏目信息结束***/

/***3景点列表页开始***/
/*$method = 'api/standard/car/list';
$params = array(
    'pagesize' => 2,
    'page'     => 1,
    'keyword'  => '',
);*/
/***3景点列表页开始***/

/***4景点详情页开始***/
/*$method = 'api/standard/car/detail';
$params = array(
    'productid' => 1,
);*/
/***4景点详情页结束***/


/***5日历报价开始***/
/*$method = 'api/standard/car/price';
$params = array(
    'suitid' => '1',
    'row'    => '30',
    'year'   => '2017',
    'month'  => '07',
);*/
/***5日历报价结束***/

/***6创建订单开始***/
$method = 'api/standard/car/create_order';
$params = array(
    'typeid'         => 3,
    'productautoid'  => 1,
    'productautoaid' => 1,
    'productname'    => '雪佛兰,动力十足，不耐用',
    'price'          => 150,
    'linkman'        => 'webkiller',
    'linktel'        => '18683851234',
    'remark'         => '我写的备注信息',
    'memberid'       => 2,
    'suitid'         => 2,
    'dingnum'        => 3,
    'paytype'        => 1,
    'dingjin'        => 0,
    'usedate'        => '2017-05-18',
);
/***6创建订单结束***/
header('Content-Type:text/html;charset=utf-8');
$response = $obj->send_request($method, $params);
var_dump($response);
