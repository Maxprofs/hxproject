<?php echo Common::css('user_start_city_station.css',true);?> <?php echo Common::js("py.js");?> <?php
$arrInitParam = array(
    'controller' => 'line',
    'action' => 'list',
    'destpy' => 'all',
    'dayid' => 0,
    'priceid' => 0,
    'sorttype' => 0,
    'displaytype' => 0,
    'startcityid' => 0,
    'attrid' => 0,
    'p' => 0,
    'channel_name' => '线路',
);
?> <?php require_once ("E:/wamp64/www/taglib/citystation.php");$citystation_tag = new Taglib_Citystation();if (method_exists($citystation_tag, 'citystation')) {$arrCityList = $citystation_tag->citystation(array('action'=>'citystation','return'=>'arrCityList',));}?> <div class="city_warp" id="city_warp"> <div class="city_select"> <dl class="start_city_station"> <dt class="city_station"><i class="city_station_icon"></i><span class="city_station_btn"><?php 
                if ($_COOKIE['cityname']=='') { ?> <?php echo $cityname;?> <?php }else{ echo $_COOKIE['cityname']; }
             ?></span><span>站</span><b class="city_station_arrow"></b><span class="city_station_id" style="visibility: hidden;"> <?php 
                if ($_COOKIE['cityid']=='') { ?> <?php echo $cityid;?> <?php }else{ echo $_COOKIE['cityname']; }
             ?> </span></dt> </div> <dd class="city_searchBox"> <div class="hot_station"> <h4> <?php  
                    foreach ($arrCityList as $key => $val) {
                        if (array_search('热门出发城市', $val)){ ?> <?php echo $val['cityname'];?> <?php 
                            $hotid=$val['id'];
                            break; 
                        }else{continue;}
                    }  
                ?> </h4> <p> <?php 
                    foreach ($arrCityList as $key => $city) {
                        if ($hotid==$city['pid']) { ?> <a id="<?php echo $city['id'];?>" href="###" onclick="changecity(this)"><?php echo $city['cityname'];?></a> <!-- <a href="<?php echo Model_Line::get_search_url($city['id'],'startcityid',$arrInitParam);?>"><?php echo $city['cityname'];?></a> --> <?php
                            continue;
                        }
                    }
                ?> </p> </div> <div class="station_search"> <dir class="station_search_box"> <p class="station_search_p">搜索城市（支持汉字、首字母查询）</p> <input class="station_search_input" type="text" oninput="detectInput(this.value)"> </dir> <div class="station_search_result" style="display:block;"> </div> <div class="station_wordsselect"> <?php
            $k=0;
            $arrCityIndex = array();
            foreach ($arrCityList as $key => $value) {
                if ($value['pid']==0 and $value['cityname']!='热门出发城市') { 
                    if ($value['cityname']=='A') { ?> <a href="###" onmouseover="displayul(this);" class="<?php echo $value['id'];?> on"><?php echo $value['cityname'];?></a> <?php } else { ?> <a href="###" onmouseover="displayul(this);" class="<?php echo $value['id'];?>"><?php echo $value['cityname'];?></a> <?php }?> <?php       
                    $arrCityIndex[]=['id'=>$value['id'],'cityname'=>$value['cityname']];
                    $k++;
                    continue;
            }elseif ($k>26) {
                break;
            }
        }
         ?> </div> <div class="city_list" style="scroll-behavior: auto;"> <?php 
    foreach ($arrCityIndex as $key => $value) { 
        if ($value['cityname']=='A') { ?> <ul class="station_search_list <?php echo $value['cityname'];?>" style="display: block;"> <?php }else{ ?> <ul class="station_search_list <?php echo $value['cityname'];?>" style="display: none;"> <?php }
        ?> <li> <span class="<?php echo $value['id'];?>"><?php echo $value['cityname'];?></span> <?php 
                foreach ($arrCityList as $cityid => $city) {
                    if ($city['pid']==$value['id']) { ?> <a id="<?php echo $city['id'];?>" href="###" onclick="changecity(this)"><?php echo $city['cityname'];?></a> <!-- <a href="<?php echo Model_Line::get_search_url($city['id'],'startcityid',$arrInitParam);?>"><?php echo $city['cityname'];?></a> --> <?php    }
                }
             ?> </li> </ul> <?php } ?> </div> </div> </dd> </dl> </div> <script>
var startCityName = new Array();
$(function() {
    $('body').click(function(e) {
        var target=$(e.target);
        if(!target.is('#city_warp *')){
            if ($('.city_searchBox').css('display')=='block') {
                $('.city_searchBox').css('display', 'none');
            }
        }
        
    });
    $('.city_select').mouseover(function(event) {
        $(this).css('cursor', 'pointer');
    });
    $('.city_select').click(function(event) {
        var display=$('.city_searchBox').css('display');
        if (display=='block') {
            $('.city_searchBox').css('display','none');
            $('.city_station_arrow').css('background-position', '-183px -133px');
        }else{
            $('.city_searchBox').css('display','block');
            $('.city_station_arrow').css('background-position', '-166px -133px');
        }
    });
    $('.station_search_input').val("");
    $('.station_search_input').focus(function(event) {
        /* Act on the event */
        $('.station_search_p').text('');
    });
});
function changecity(ele) {
    $.cookie('cityname',$(ele).text());
    $.cookie('cityid',$(ele).attr('id'));
    var url =SITEURL +'city/'+$(ele).attr('id');
    $.ajax({
        url: url,
        type: 'POST',
        datatype:'json',
        success:function(e) {
        }
    });
    window.location.href=SITEURL;
}
function displayul(ele) {
    $('.city_list ul').each(function(index, el) {
        if ($(el).css('display')=='block') {
            $(el).css('display','none');
        }
    });
    $('.'+$(ele).text()).css('display', 'block');
    $('.station_wordsselect a').each(function(index, el) {
        $(el).removeClass('on');
    });
    $(ele).addClass('on');
}
function detectInput(inputval) {
        $('.station_search_result').html("");
        $('.station_search_p').text('');
        if (inputval == "") {
            $('.station_search_p').text('搜索城市（支持汉字、首字母查询）');
            $(".station_search_result").text("");
        }
         var reg=/[\u4e00-\u9fa5]/g;
        if (inputval.match(reg)) {
            var r = output(inputval, zhText);
            if (r==0) {
                $(".station_search_result").html("<span style='font-weight:bold;font-size:12px;font-family:Tahoma,Simsun,sans-serif;display: inline-block;margin-right: 10px;line-height: 28px;color: #0065bb'>未查找到相关信息</span>");
                return;
            }
            createLink();
            return;
        }
        if (output(inputval, simplePy) != 0) {
            createLink();
            return;
        }
        if (output(inputval,fullPy)!=0){
            createLink();
            return;
        }
        if (r == 'close') { return; }
        if (r == 0) {
            $(".station_search_result").html("<span style='font-weight:bold;font-size:12px;font-family:Tahoma,Simsun,sans-serif;display: inline-block;margin-right: 10px;line-height: 28px;color: #0065bb'>未查找到相关信息</span>");
        }
}
function createLink() {
            var i = 0;
            $.each(startCityName, function(index, val) {
                if (typeof(val) == 'string' && i<5) {
                    i++;
                    $('.station_search_result').append("<a style='font-weight:bold;font-size:12px;font-family:Tahoma,Simsun,sans-serif;display: inline-block;margin-right: 10px;line-height: 28px;color: #0065bb' href='<?php echo Model_Line::get_search_url('" + index + "','startcityid',$arrInitParam);?>'>" + val + "</a>");
                }
            });
}
function output(searchKey, jsonStr) {
    startCityName = new Array();
    var k = 0;
    if (searchKey.length == 0) { return 'close'; }
    var regex = new RegExp('^' + searchKey, 'i');
    var jsonObj = $.parseJSON(jsonStr);
    $.each(jsonObj, function(index, obj1) {
        /* iterate through array or object */
        $.each(obj1, function(index, obj2) {
            /* iterate through array or object */
            $.each(obj2, function(index, val) {
                /* iterate through array or object */
                if (regex.test(index)) {
                    searchCityName(val);
                    k = k + 1
                }
            });
        });
    });
    return k;
}
function searchCityName(searchKey) {
    var jsonObj = $.parseJSON(cityName);
    $.each(jsonObj, function(index, obj1) {
        /* iterate through array or object */
        $.each(obj1, function(index, obj2) {
            /* iterate through array or object */
            $.each(obj2, function(index, val) {
                /* iterate through array or object */
                if (index == searchKey) {
                    startCityName[index] = val;
                }
            });
        });
    });
}
</script>
