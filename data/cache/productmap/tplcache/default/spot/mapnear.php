<!doctype html>
<html>
<head head_ul=_5zCXC >
    <meta charset="utf-8">
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $webname;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,map.css');?>
    <?php echo Common::js('jquery.min.js');?>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=F74WGaIGyzGjI7GRf27hxb5o"></script>
    <script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
</head>
<body>
<header>
    <div class="header_top sys_header">
        <div class="st_back"><a href="javascript:;" onclick="javascript:history.go(-1);"></a></div>
        <h1 class="tit">
            <?php echo $seoinfo['seotitle'];?>
        </h1>
    </div>
</header>
<section style="height: 90%;">
<div class="mid_content" id="baidumap" style="height:100%;">
</div>
</section>
<script>
    var SITEURL="<?php echo $cmsurl;?>";
    var CURRENCY_SYMBOL="<?php echo $currency_symbol;?>";
    var PUBLICURL="<?php echo $GLOBALS['cfg_res_url'];?>";
    var marker_icon=PUBLICURL+"/images/map_on.png";
    var current_lat=0;
    var current_lng=0;
    var added_hotelids=[];
    var map = new BMap.Map("baidumap");
    var posMarker=null;
    var posIcon= PUBLICURL+'/images/map_pos.png';
    var posIconObj= new BMap.Icon(posIcon, new BMap.Size(15, 15), {});
    var geolocationControl=new BMap.GeolocationControl({locationIcon:posIconObj});
    map.addControl(geolocationControl);
    var gbl_added_ids=[];
    var gbl_loading=false;
    map.addEventListener('moveend',function(){
        get_near_spots();
          var point=map.getCenter();
    })
    map.addEventListener('resize',function(){
        get_near_spots();
    })
    map.addEventListener('zoomend',function(){
        get_near_spots();
    })
    geolocationControl.addEventListener('locationSuccess',function(point){
        map.removeOverlay(posMarker);
          //  onMyposNaved(point)
    });
    nav_mypos(onMyposNaved);
    function addMarker(point, index){  // 创建图标对象
        var icon=index&&index<=10?PUBLICURL+'/images/map_'+index+'.png':marker_icon;
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
        map.centerAndZoom(point, 11);
        var myIcon = new BMap.Icon(posIcon, new BMap.Size(15, 15), {
            //offset: new BMap.Size(10, 25)
        });
         posMarker = new BMap.Marker(point, {icon: myIcon});
        map.addOverlay(posMarker);
        map.addControl(new BMap.ScaleControl());
        map.addControl(new BMap.NavigationControl());
        get_near_spots();
    }
    function get_near_spots(point) {
        var url = SITEURL + 'spot/ajax_near_spots';
        var params={};
        /*if (point) {
            params ={lat: point.lat, lng: point.lng};
        }
        else {
            if (current_lat == 0 || current_lng == 0) {
                alert("请先定位");
                return;
            }
            params ={lat: current_lat, lng: current_lng};
        }*/
        if(gbl_loading)
        {
           return;
        }
        gbl_loading=true;
        var bound = map.getBounds();
        var point1 = bound.getSouthWest();
        var point2 = bound.getNorthEast();
        params['west_lng'] = point1.lng;
        params['south_lat'] = point1.lat;
        params['east_lng'] = point2.lng;
        params['north_lat'] = point2.lat;
        $.ajax({
            type: "post",
            url: url,
            dataType: "json",
            data:params,
            success: function (result) {
                if(!result || !result.status || !result.data)
                {
                    showHint();
                }
                else
                {
                    addSpot(result.data,result.nearhas);
                }
            },
           complete:function(){
               gbl_loading=false;
           }
        });
    }
    function addSpot(list,nearhas)
    {
        for(var i in list) {
            var row=list[i];
            var index=parseInt(i)+1;
            if (!row['lat'] || !row['lng'])
            {
                return;
            }
            if($.inArray(row['id'],gbl_added_ids)!=-1)
            {
                continue;
            }
            gbl_added_ids.push(row['id']);
            var point = new BMap.Point(row['lng'], row['lat']);
            var marker = addMarker(point,index);
            (function(row,point,index){
                var price=row['price']? CURRENCY_SYMBOL+row['price']:'电询';
                if(index==1&&nearhas)
                {
                    var infoHtml = "<div class='map_hotel'><div class='mtop'><span class='tit'>"+index+"."+row['title']+"</span></div><div class='mbtm'><span class='price_t'>起价：</span><span class='price'>"+price+"</span><a href='"+row['url']+"' class='mdetail'>详情&gt;&gt;</a></div></div>";
                    var infoWindow = new BMap.InfoWindow(infoHtml, {width: 250,height:50});  // 创建信息窗口对象
                    map.openInfoWindow(infoWindow, point);
                }
                marker.addEventListener("click", function () {
                    var infoHtml = "<div class='map_hotel'><div class='mtop'><span class='tit'>"+index+"."+row['title']+"</span></div><div class='mbtm'><span class='price_t'>起价：</span><span class='price'>"+price+"</span><a href='"+row['url']+"' class='mdetail'>详情&gt;&gt;</a></div></div>";
                    var infoWindow = new BMap.InfoWindow(infoHtml, {width: 250,height:50});  // 创建信息窗口对象
                    map.openInfoWindow(infoWindow, point);      // 打开信息窗口
                })
            })(row,point,index);
        }
    }
    function showHint()
    {
        var content="当前位置附近没有景点";
        var html="<div class='hint_dlg'>"+content+"</div>";
        var htmlObj=$(html);
        $("body").append(htmlObj);
        var win_width=$(window).width();
        var hint_width=htmlObj.width();
        var left=(win_width-hint_width)/2;
        htmlObj.css("left",left);
        setTimeout(hideHint,2000);
    }
    function hideHint()
    {
        $(".hint_dlg").remove();
    }
</script>
</body>
</html>
