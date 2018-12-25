<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$webname}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('base.css,map.css')}
    {Common::js('jquery.min.js')}
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=F74WGaIGyzGjI7GRf27hxb5o"></script>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.4.2&key=de840e242ee29f28500b1391b96622ae"></script>
</head>
<body>
<header>
    <div class="header_top sys_header">
        <div class="st_back"><a href="javascript:;" onclick="javascript:history.go(-1);"></a></div>
        <h1 class="tit">
            {Common::cutstr($info['title'],10)}
        </h1>
    </div>
</header>
<section style="height: 90%;">
<div class="mid_content" id="baidumap" style="height:100%;">

</div>
</section>

<div class="foo-box hide" id="app_panel" style="display: none;">
    <div class="foo-container">
        <ul class="list" id="app_list">
            <li><a id="baidu_lk" data-url="http://api.map.baidu.com/direction?origin=latlng:{#LAT#},{#LNG#}|name:我的位置&destination=latlng:{$info['lat']},{$info['lng']}|name={$info['title']}&region=中国&mode=driving&output=html&src=web"  href="">打开百度地图</a></li>
            <li><a id="gaode_lk" data-url="http://uri.amap.com/navigation?from={#LNGLAT#},我的位置&to={#DLNGLAT#},{$info['title']}" href="">打开高德地图</a></li>
        </ul>
    </div>
</div>
<script>
    var PUBLICURL="{$GLOBALS['cfg_res_url']}";
    var id="{$info['id']}";
    var lat="{$info['lat']}";
    var lng="{$info['lng']}";
    var title="{$info['title']}";
    var address="{$info['address']}";
    var marker_icon=PUBLICURL+"/images/map_on.png";
    var posMarker=null;
    var posIcon= PUBLICURL+'/images/map_pos.png';
    var current_lat=0;
    var current_lng=0;
    var qq_current_lat=0;
    var qq_current_lng=0;
    var gaode_lat=0;
    var gaode_lng=0;
    var qq_lat=0;
    var qq_lng=0;
    var map = new BMap.Map("baidumap");
    var point=new BMap.Point(lng, lat);
    map.centerAndZoom(point, 15);
    var marker=addMarker(point,1);
    map.addControl(new BMap.ScaleControl());
    map.addControl(new BMap.NavigationControl());

    var posIconObj= new BMap.Icon(posIcon, new BMap.Size(15, 15), {});
    var geolocationControl=new BMap.GeolocationControl({locationIcon:posIconObj});
    map.addControl(geolocationControl);

    var infoOpts = {

    }
    var infoHtml="<table class='map_info'><tr><td width='150px' valign='top'><span class='tit'>"+title+"</span><br/><span class='addr'>"+address+"</span></td><td align='center' onclick='openApp()' style='padding-left:10px'><img src='"+PUBLICURL+"/images/map_tohere.png'><br/><a href='javascript:;' class='mnav' >去这里</a></td></tr></table>";
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
            onMyposNaved(r.point);
        }
        else {
        }
    },{enableHighAccuracy: true})

    //目的地坐标转换
    AMap.convertFrom([lng,lat], 'baidu', function(status, result) {
        var url=$("#gaode_lk").attr('data-url');
        //url=url.replace(/\{#DLAT#\}/g,result.locations[1]);
        url=url.replace(/\{#DLNGLAT#\}/g,result.locations[0]);
        $("#gaode_lk").attr('data-url',url);

    });

    function onMyposNaved(point)
    {
        var url=$("#baidu_lk").attr('data-url');
        url=url.replace(/\{#LAT#\}/g,current_lat);
        url=url.replace(/\{#LNG#\}/g,current_lng);
        $("#baidu_lk").attr('href',url);

        AMap.convertFrom([current_lng,current_lat], 'baidu', function(status, result) {
            var url=$("#gaode_lk").attr('data-url');
            url=url.replace(/\{#LNGLAT#\}/g,result.locations[0]);
            $("#gaode_lk").attr('href',url);
        });
    }

    function addMarker(point, index){  // 创建图标对象
        var myIcon = new BMap.Icon(marker_icon, new BMap.Size(30, 30), {
            //offset: new BMap.Size(10, 25)
        });
        var marker = new BMap.Marker(point, {icon: myIcon});

        map.addOverlay(marker);
        return marker;
    }

    function openApp()
    {
        $("#app_panel").show();
    }

    $("#app_panel").click(function(){
        $(this).hide();
    });

</script>
</body>
</html>
