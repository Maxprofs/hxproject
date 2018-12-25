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
    <script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
</head>

<body top_float=Y6ByYj >
{request "pub/header/isshowpage/1/definetitle/".urlencode($seoinfo['seotitle'])}
<section style="height: 90%;">
<div class="mid_content" id="baidumap" style="height:100%;">

</div>
</section>
<script>
    var PUBLICURL="{$GLOBALS['cfg_public_url']}";
    var marker_icon="{$GLOBALS['cfg_public_url']}images/map_on.png";
    var current_lat=0;
    var current_lng=0;
    var added_hotelids=[];

    var map = new BMap.Map("baidumap");
    var posMarker=null;
    var posIcon= PUBLICURL+'images/map_pos.png';

    var posIconObj= new BMap.Icon(posIcon, new BMap.Size(15, 15), {});
    var geolocationControl=new BMap.GeolocationControl({locationIcon:posIconObj});
    map.addControl(geolocationControl);

    map.addEventListener('moveend',function(){
          var point=map.getCenter();
    })
    geolocationControl.addEventListener('locationSuccess',function(point){
        map.removeOverlay(posMarker);
          //  onMyposNaved(point)
    });
    nav_mypos(onMyposNaved);

    function addMarker(point, index){  // 创建图标对象
        var icon=index||index<=10?PUBLICURL+'images/map_'+index+'.png':marker_icon;
        var myIcon = new BMap.Icon(icon, new BMap.Size(30, 30), {
            //offset: new BMap.Size(10, 25)
        });
        var marker = new BMap.Marker(point, {icon: myIcon});
        map.addOverlay(marker);
        return marker;
    }
    function nav_mypos(success,fail)
    {
        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function(r){
            if(this.getStatus() == BMAP_STATUS_SUCCESS){
                current_lng=r.point.lng;
                current_lat=r.point.lat;
                if(typeof success=='function')
                    success(r.point);
            }
            else {
                if(typeof fail=='function')
                    fail();
            }
        },{enableHighAccuracy: true})

    }
    function onMyposNaved(point)
    {
        map.centerAndZoom(point, 15);
        var myIcon = new BMap.Icon(posIcon, new BMap.Size(15, 15), {
            //offset: new BMap.Size(10, 25)
        });
         posMarker = new BMap.Marker(point, {icon: myIcon});
        map.addOverlay(posMarker);
        map.addControl(new BMap.ScaleControl());
        map.addControl(new BMap.NavigationControl());
        get_near_hotels();
    }


    function get_near_hotels(point) {

        var url = SITEURL + 'hotel/ajax_near_hotels';
        var params={};
        if (point) {
            params ={lat: point.lat, lng: point.lng};
        }
        else {
            if (current_lat == 0 || current_lng == 0) {
                alert("请先定位");
                return;
            }
            params ={lat: current_lat, lng: current_lng};
        }
        $.ajax({
            type: "post",
            url: url,
            dataType: "json",
            data:params,
            success: function (result) {
                    addHotel(result.data);

            }
        });
    }

    function addHotel(list)
    {

        for(var i in list) {
            var row=list[i];
            var index=parseInt(i)+1;
            if (!row['lat'] || !row['lng'])
                return;

            var point = new BMap.Point(row['lng'], row['lat']);
            var marker = addMarker(point,index);
            (function(row,point,index){
                if(index==1)
                {
                    var infoHtml = "<div class='map_hotel'><div class='mtop'><span class='tit'>"+index+"."+row['title']+"</span><a href='"+row['url']+"' class='mdetail'>详情&gt;&gt;</a></div><div class='mbtm'><span class='price_t'>起价：</span><span class='price'>￥"+row['price']+"</span></div></div>";
                    var infoWindow = new BMap.InfoWindow(infoHtml, {width: 250,height:50});  // 创建信息窗口对象
                    map.openInfoWindow(infoWindow, point);
                }
                marker.addEventListener("click", function () {
                    var infoHtml = "<div class='map_hotel'><div class='mtop'><span class='tit'>"+index+"."+row['title']+"</span><a href='"+row['url']+"' class='mdetail'>详情&gt;&gt;</a></div><div class='mbtm'><span class='price_t'>起价：</span><span class='price'>￥"+row['price']+"</span></div></div>";
                    var infoWindow = new BMap.InfoWindow(infoHtml, {width: 250,height:50});  // 创建信息窗口对象
                    map.openInfoWindow(infoWindow, point);      // 打开信息窗口
                })
            })(row,point,index);
        }
    }

</script>
</body>
</html>
