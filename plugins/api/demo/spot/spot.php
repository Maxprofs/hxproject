<?php
/**
 *User: idoiwill
 *Email: xslt@idoiwill.com
 *Blog: http://www.idoiwill.com
 *DateTime: 2017/5/15 15:01
 */

require './command/spotdemoapi.php';
$obj = new SpotDemoApi();

/***1广告图开始***/
/*$method = 'api/standard/spot/get_rolling_ad';
$params = array(
    'name' => 'SpotRollingAd',
);*/
/***1广告图结束***/

/***2栏目信息开始***/
/*$method = 'api/standard/spot/channel';
$params = array();*/
/***2栏目信息结束***/

/***3景点列表页开始***/
/*$method = 'api/standard/spot/list';
$params = array(
    'pagesize' => 2,
    'page'     => 1,
    'keyword'  => '',
);*/
/***3景点列表页开始***/

/***4景点详情页开始***/
/*$method = 'api/standard/spot/detail';
$params = array(
    'productid' => 1,
);*/
/***4景点详情页结束***/


/***5日历报价开始***/
/*$method = 'api/standard/spot/price';
$params = array(
    'suitid' => '2',
    'row'    => '30',
    'year'   => '2017',
    'month'  => '06',
);*/
/***5日历报价结束***/

/***6创建订单开始***/
$method = 'api/standard/spot/create_order';
$params = array(
    'typeid'         => 5,
    'productautoid'  => 2,
    'productautoaid' => 1,
    'productname'    => '喜来登大酒店',
    'price'          => 146,
    'linkman'        => 'xiaoxiao',
    'linktel'        => '18683851234',
    'remark'         => '我写的备注信息',
    'memberid'       => 2,
    'suitid'         => 2,
    'dingnum'        => 3,
    'paytype'        => 1,
    'dingjin'        => 0,
    'usedate'        => '2017-05-15',
);
/***6创建订单结束***/
header('Content-Type:text/html;charset=utf-8');
$response = $obj->send_request($method, $params);
var_dump($response);
