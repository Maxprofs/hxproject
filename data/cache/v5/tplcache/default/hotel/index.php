<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head script_body=txACXC > <meta charset="utf-8"> <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title> <?php if($seoinfo['keyword']) { ?> <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" /> <?php } ?> <?php if($seoinfo['description']) { ?> <meta name="description" content="<?php echo $seoinfo['description'];?>" /> <?php } ?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css_plugin('hotel.css','hotel');?> <?php echo Common::css('base.css,extend.css',false);?> <?php echo Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,template.js,delayLoading.min.js');?> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo $GLOBALS['cfg_indexname'];?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo $channelname;?> </div><!--面包屑--> <div class="st-hotel-home-top"> <div class="st-hotel-search"> <dl class="search-dl"> <dt>目的地</dt> <dd> <input type="text" class="h-text-search destname" onClick="hSearchShow()" placeholder="中文/拼音/首字母" > <div class="mdd-city-box" id="mdd-city-box"> <div class="ss-mdd-tit"><span>可直接输入城市或城市拼音</span><i id="mdd-hot-closed" onClick="hSearchHide()"></i></div> <div class="ss-mdd-box"> <div class="st-tabnav"> <span class="on" data-id="hot">热门</span> <span data-id="a,b,c">ABC</span> <span data-id="d,e,f,g">DEFG</span> <span data-id="h,i,j,k">HIJK</span> <span data-id="l,m,n">LMN</span> <span data-id="o,p,q,r">OPQR</span> <span data-id="s,t,w">STW</span> <span data-id="x,y,z">XYZ</span> </div> <div class="st-tabcon" id="dest_list"> <?php require_once ("E:/wamp64/www/taglib/dest.php");$dest_tag = new Taglib_Dest();if (method_exists($dest_tag, 'query')) {$data = $dest_tag->query(array('action'=>'query','flag'=>'hot','typeid'=>$typeid,'row'=>'15',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?> <a href="javascript:;" data-id="<?php echo $row['id'];?>"><?php echo $row['kindname'];?></a> <?php $n++;}unset($n); } ?> </div> </div> </div> </dd> </dl> <script type="text/html" id="tpl_dest_list">
                {{each list as value i}}
                    <a href="javascript:;" data-id="{{value.id}}">{{value.kindname}}</a>
                {{/each}}
            </script> <script>
                $(function(){
                    //按拼音筛选
                    $('.st-tabnav').find('span').click(function(){
                        var url = SITEURL+'hotel/ajax_dest';
                        var id = $(this).attr('data-id');
                        var dest = $(this).data(id);
                        var obj = $(this);
                        if(dest!=undefined){
                            $("#dest_list").html(dest);
                        }else{
                            $.getJSON(url,{dataid:id},function(data){
                                if(data.list){
                                    var destlist = template('tpl_dest_list',data);
                                    obj.data(id,destlist);
                                    $("#dest_list").html(destlist);
                                }
                            })
                        }
                        $(this).addClass('on').siblings().removeClass('on');
                    })
                    //选中目的地
                    $('body').delegate('#dest_list a','click',function(){
                        var destname = $(this).text();
                        var destid = $(this).attr('data-id');
                        $(".destname").val(destname);
                        $(".destname").attr('data-id',destid);
                        $('.mdd-city-box').hide();
                    })
                    //按拼音搜索目的地
                    $('.destname').keyup(function(){
                        hSearchHide();
                    })
                    $('.destname').Result({url:SITEURL+'destination/ajax_dest_by_pinyin',extraParams:{typeid:2}});
                })
            </script> <dl class="search-dl"> <dt>入住时间</dt> <dd> <input type="text" class="h-text-search date-ico" id="txtHotelTime1" placeholder="yy-mm-dd" value="<?php echo date('Y-m-d');?>" > </dd> </dl> <dl class="search-dl"> <dt>退房时间</dt> <dd> <input type="text" class="h-text-search date-ico" id="txtHotelTime2" placeholder="yy-mm-dd" value="<?php echo date('Y-m-d',strtotime('+1 day'));?>" > </dd> </dl> <dl class="search-dl"> <dt>酒店星级</dt> <dd> <input type="text" name="" class="h-text-search up-ico rankid" id="input-select" value="全部" > <input type="hidden" id="rankid" value="0"/> <div class="star-level-box"> <?php $hotel_tag = new Taglib_Hotel();if (method_exists($hotel_tag, 'rank_list')) {$data = $hotel_tag->rank_list(array('action'=>'rank_list',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $r) { ?> <span data-id="<?php echo $r['id'];?>"><?php echo $r['title'];?></span> <?php $n++;}unset($n); } ?> </div> </dd> </dl> <dl class="search-dl"> <dt>关键词</dt> <dd> <input type="text" name="keyword" class="h-text-search keyword" > </dd> </dl> <div class="st-hs-btn"><a href="javascript:;">搜索</a></div> </div><!--酒店首页条件搜索--> <script>
              $(function(){
                  //酒店搜索
                  $('.st-hs-btn').click(function(){
                        var rankid = $("#rankid").val();
                        var destname = $(".destname").val();
                        var params={keyword:$(".keyword").val(),starttime:$('#txtHotelTime1').val(),endtime:$('#txtHotelTime2').val()}
                        var query=new Array();
                        var destpy = "";
                        if(destname!=''){
                            $.ajax({type:'POST',url:SITEURL+'hotel/ajax_dest_py',async:false,data:'destname='+destname,success:function(data){
                                destpy = data;
                            }})
                        }
                      var url = SITEURL+'hotels/';
                      var py = '';
                      if(destpy!=''){
                          py = destpy;
                      }
                      url+=py+'-'+rankid+'-0-0-0-0-1';
                      for(var k in params){
                          if(params[k]!=''){
                              query.push(k+'='+params[k]);
                          }
                      }
                      if(query.length>0){
                          url+='?'+query.join('&');
                      }
                      window.location.href = url;
                  })
              })
          </script> <!--酒店首页轮播图--> <div id="st-hotel-slideBox" class="st-hotel-slideBox"> <div class="hd"> <ul> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$hotelad = $ad_tag->getad(array('action'=>'getad','name'=>'HotelRollingAd','pc'=>'1','return'=>'hotelad',));}?> <?php $n=1; if(is_array($hotelad['aditems'])) { foreach($hotelad['aditems'] as $k => $v) { ?> <li><?php echo $k;?></li> <?php $n++;}unset($n); } ?> </ul> </div> <div class="bd"> <ul> <?php $n=1; if(is_array($hotelad['aditems'])) { foreach($hotelad['aditems'] as $v) { ?> <li><a href="<?php echo $v['adlink'];?>" target="_blank"><img src="<?php echo Product::get_lazy_img();?>" original-src="<?php echo Common::img($v['adsrc'],768,324);?>" alt="<?php echo $v['adname'];?>" /></a></li> <?php $n++;}unset($n); } ?> </ul> </div> <!--前/后按钮代码--> <a class="prev" href="javascript:void(0)"></a> <a class="next" href="javascript:void(0)"></a> </div> <!--酒店首页轮播图结束--> <!--栏目介绍--> <?php if(!empty($seoinfo['jieshao'])) { ?> <div class="st-comm-introduce"> <div class="st-comm-introduce-txt"> <?php echo $seoinfo['jieshao'];?> </div> </div> <?php } ?> <div class="st-hotel-home-box"> <div class="hotel-tit-ico"><h3 class="hot-ico">热门推荐</h3><a class="more" href="/hotels/all" target="_blank">查看更多</a></div> <div class="hotel-tj-box"> <ul> <?php $hotel_tag = new Taglib_Hotel();if (method_exists($hotel_tag, 'query')) {$data = $hotel_tag->query(array('action'=>'query','flag'=>'order','row'=>'3',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?> <li> <div class="pic"><img src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo Common::img($row['litpic'],400,271);?>" alt="<?php echo $row['title'];?>" title="<?php echo $row['title'];?>" /></div> <div class="txt"> <a href="<?php echo $row['url'];?>" title="<?php echo $row['title'];?>" target="_blank"> <i></i> <p class="ads"><?php echo $row['title'];?></p> <p class="price"> <?php if(!empty($row['price'])) { ?> <span><span class="currency_sy"><?php echo Currency_Tool::symbol();?></span><?php echo $row['price'];?></span>起
                            <?php } else { ?> <span>电询</span> <?php } ?> </p> </a> </div> </li> <?php $n++;}unset($n); } ?> </ul> </div> </div><!--热门推荐--> <div class="st-hotel-home-box"> <div class="hotel-tit-ico"><h3 class="jx-ico">精选<?php echo $channelname;?></h3><a class="more" href="/hotels/all" target="_blank">查看更多</a></div> <div class="hotel-jx-box"> <ul> <?php $hotel_tag = new Taglib_Hotel();if (method_exists($hotel_tag, 'query')) {$data = $hotel_tag->query(array('action'=>'query','flag'=>'order','row'=>'8','offset'=>'3',));}?> <?php $k=1;?> <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?> <li <?php if($k%4==0) { ?>class="mr_0"<?php } ?>
> <div class="pic"><a href="<?php echo $row['url'];?>" title="<?php echo $row['title'];?>"><img src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo Common::img($row['litpic'],277,188);?>" alt="<?php echo $row['title'];?>" /></a></div> <div class="txt"> <p class="bt"><a href="<?php echo $row['url'];?>" target="_blank" title="<?php echo $row['title'];?>"><?php echo $row['title'];?></a><span><?php if(!empty($row['price'])) { ?><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><b><?php echo $row['price'];?></b>起<?php } else { ?>电询<?php } ?> </span></p> <p class="num"><span>满意度：<?php echo $row['satisfyscore'];?></span><span>销量：<?php echo $row['sellnum'];?></span></p> <p class="ads"><span><?php echo $row['address'];?></span></p> </div> <div class="list"> <?php $hotel_tag = new Taglib_Hotel();if (method_exists($hotel_tag, 'suit')) {$roomlist = $hotel_tag->suit(array('action'=>'suit','row'=>'2','productid'=>$row['id'],'return'=>'roomlist',));}?> <?php $n=1; if(is_array($roomlist)) { foreach($roomlist as $room) { ?> <a href="<?php echo $row['url'];?>" target="_blank"> <span><?php echo $room['title'];?></span> <em><?php if($room['price']) { ?><span class="currency_sy"><?php echo Currency_Tool::symbol();?></span><?php echo $room['price'];?>起<?php } else { ?>电询<?php } ?> </em> </a> <?php $n++;}unset($n); } ?> </div> <a class="more-fx" href="<?php echo $row['url'];?>" target="_blank">更多房型</a> </li> <?php $k++;?> <?php $n++;}unset($n); } ?> </ul> </div> </div><!--精选酒店--> </div> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Request::factory("pub/flink")->execute()->body(); ?> </body> <?php echo Common::js('datepicker/WdatePicker.js',0);?> <?php echo Common::js('result/result.js',0);?> <link type="text/css" href="<?php echo $GLOBALS['cfg_public_url'];?>js/result/result.css" rel="stylesheet" /> <script>
    $(function(){
        //酒店首页焦点图
        $('.st-hotel-slideBox').slide({
mainCell:'.bd ul',
 effect:"fold",
interTime: 5000,
delayTime: 500,
autoPlay:true,
                        switchLoad:'original-src'
})
        //酒店星级下拉选择
        $('#input-select').click(function(){
            var ul = $('.star-level-box');
            if(ul.css("display")=="none"){
                $('#input-select').removeClass('up-ico').addClass('down-ico')
                ul.slideDown("fast");
            }else{
                ul.slideUp("fast");
                $('#input-select').removeClass('down-ico').addClass('up-ico')
            }
        });
        $(".star-level-box span").click(function(){
            $('#input-select').removeClass('down-ico').addClass('up-ico')
            var txt = $(this).text();
            var rankid = $(this).attr('data-id');
            $("#rankid").val(rankid);
            $("#input-select").val(txt);
            var value = $(this).attr("rel");
            $(".star-level-box").hide();
        });
        //酒店预订时间选择
        $("#txtHotelTime1").focus(function(){
            $("#txtHotelTime2").attr('value','');
            WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d',maxDate:'#F{$dp.$D(\'txtHotelTime2\',{d:-1});}',doubleCalendar:true,isShowClear:false,readOnly:true,errDealMode:1})
            $("#txtHotelTime1").css("color","#333");
            $("#txtHotelTime2").blur();
        })
        $("#txtHotelTime2").focus(function(){
            WdatePicker({minDate:'#F{$dp.$D(\'txtHotelTime1\',{d:1});}',dateFmt:'yyyy-MM-dd',doubleCalendar:true,isShowClear:false,readOnly:true,errDealMode:1});
            $("#txtHotelTime2").css("color","#333");
            $("#txtHotelTime2").blur();
        })
    })
    //酒店搜索目的地弹出框
    function hSearchShow(){
        $('.mdd-city-box').show()
    }
    function hSearchHide(){
        $('.mdd-city-box').hide()
    }
</script> </html>
