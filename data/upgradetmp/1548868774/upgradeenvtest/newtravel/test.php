<?php

function xml_to_array($xml)
{
    $array = (array)(simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA));
    foreach ($array as $key => $item)
    {
        $array[$key] = struct_to_array((array)$item);
    }
    return $array;
}

function struct_to_array($item)
{
    if (!is_string($item))
    {
        $item = (array)$item;
        foreach ($item as $key => $val)
        {
            $item[$key] = struct_to_array($val);
        }
    }
    return $item;
}

$testxml = <<<xml
<?xml version="1.0" encoding="UTF-8"?>
<result>
  <totalNum><![CDATA[9]]></totalNum>
  <status><![CDATA[1]]></status>
  <products>
    <product>
      <productNo><![CDATA[8147819]]></productNo>
      <productName><![CDATA[大连森林动物园成人票（官方电子票,景区窗口验证）]]></productName>
      <img><![CDATA[http://b2b.qnwer.com/img/234339/1453434787217.jpg]]></img>
      <treeId>0</treeId>
      <isPackage>0</isPackage>
      <isCode>1</isCode>
      <thumbnail><![CDATA[http://b2b.qnwer.com/img/234339/1453434787217.jpg]]></thumbnail>
      <isOnlinepay><![CDATA[1]]></isOnlinepay>
      <ticketCount><![CDATA[56]]></ticketCount>
      <attentCount><![CDATA[0]]></attentCount>
      <salePrice><![CDATA[115]]></salePrice>
      <cityName><![CDATA[大连]]></cityName>
      <SettlementPrice><![CDATA[108]]></SettlementPrice>
      <marketPrice><![CDATA[120]]></marketPrice>
      <express><![CDATA[无须配送]]></express>
      <orderDesc><![CDATA[可当天预订，要求必须<font color=green><b>120</b>分钟内完成</font>在线支付。]]></orderDesc>
      <priceStartDate><![CDATA[2016-03-01]]></priceStartDate>
      <priceEndDate><![CDATA[2016-06-30]]></priceEndDate>
      <viewName><![CDATA[大连森林动物园]]></viewName>
      <viewLongitude><![CDATA[121.61708]]></viewLongitude>
      <viewLatitude><![CDATA[38.88529]]></viewLatitude>
      <viewAddress><![CDATA[中国大连市西岗区南石道街迎春路60号]]></viewAddress>
      <isTop><![CDATA[8]]></isTop>
      <viewId><![CDATA[sldwy]]></viewId>
      <pubDate><![CDATA[2016-01-22 09:56:16.0]]></pubDate>
    </product>

  </products>
</result>
xml;


        $getproductlistresult = xml_to_array($testxml);

