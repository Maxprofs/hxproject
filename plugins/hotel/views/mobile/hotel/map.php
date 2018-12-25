<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$webname}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('style.css,amazeui.css,map.css')}
    {Common::js('jquery.min.js,amazeui.js,map.js')}
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=F74WGaIGyzGjI7GRf27hxb5o"></script>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=de840e242ee29f28500b1391b96622ae"></script>
    <script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
</head>

<body>
{request "pub/header/isshowpage/1/definetitle/".urlencode($info['title'])}
<section style="height: 90%;">
<div class="mid_content" id="baidumap" style="height:100%;">


</div>
</section>
<script>
    var PUBLICURL="{$GLOBALS['cfg_public_url']}";
    var id="{$info['id']}";
    var lat="{$info['lat']}";
    var lng="{$info['lng']}";
    var title="{$info['title']}";
    var address="{$info['address']}";
    var marker_icon="{$GLOBALS['cfg_public_url']}images/map_on.png";
    var current_lat=0;
    var current_lng=0;
    var gaode_lat=0;
    var gaode_lng=0;
    var qq_lat=0;
    var qq_lng=0;
    var map = new BMap.Map("baidumap");
    var point=new BMap.Point(lng, lat);
    map.centerAndZoom(point, 11);
    var marker=addMarker(point,1);
    map.addControl(new BMap.ScaleControl());
    map.addControl(new BMap.NavigationControl());

    map.addControl(new BMap.GeolocationControl());

    var infoOpts = {

    }
    var infoHtml="<table class='map_info'><tr><td width='150px' valign='top'><span class='tit'>"+title+"</span><br/><span class='addr'>"+address+"</span></td><td align='center' onclick='openQQ()' style='padding-left:10px'><img src='"+PUBLICURL+"/images/map_tohere.png'><br/><a href='javascript:;' class='mnav' >去这里</a></td></tr></table>";
    var infoWindow = new BMap.InfoWindow(infoHtml, infoOpts);  // 创建信息窗口对象
    map.openInfoWindow(infoWindow, point);
    marker.addEventListener("click", function(){
        map.openInfoWindow(infoWindow, point);      // 打开信息窗口
    });
    var geolocation = new BMap.Geolocation();
    geolocation.getCurrentPosition(function(r){
        if(this.getStatus() == BMAP_STATUS_SUCCESS){
            current_lng=r.point.lng;
            current_lat=r.point.lat;
        }
        else {
        }
    },{enableHighAccuracy: true})

    function addMarker(point, index){  // 创建图标对象
        var myIcon = new BMap.Icon(marker_icon, new BMap.Size(30, 30), {
            //offset: new BMap.Size(10, 25)
        });
        var marker = new BMap.Marker(point, {icon: myIcon});

        map.addOverlay(marker);
        return marker;
    }

    qq.maps.convertor.translate(new qq.maps.LatLng(lat,lng), 3, function(res) {
        latlng = res[0];
        qq_lat=latlng.lat;
        qq_lng=latlng.lng;
    });
    function openQQ()
    {
        window.location.href="http://apis.map.qq.com/uri/v1/routeplan?type=drive&from=我的位置&fromcoord="+current_lat+","+current_lng+"&to="+title+"&tocoord="+qq_lat+","+qq_lng+"&policy=1";
    }

</script>
</body>
</html>
