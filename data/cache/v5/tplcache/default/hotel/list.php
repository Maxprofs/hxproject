<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head> <meta charset="utf-8"> <head> <meta charset="utf-8"> <title><?php if($is_all) { ?>酒店查询_酒店预订_当季热门酒店-<?php echo $GLOBALS['cfg_webname'];?><?php } else { ?><?php echo $searchtitle;?><?php } ?> </title> <?php echo $destinfo['keyword'];?> <?php echo $destinfo['description'];?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css_plugin('hotel.css','hotel');?> <?php echo Common::css('base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,delayLoading.min.js');?> </head> <script>
$(function(){
//酒店搜索条件去掉最后一条边框
$('.line-search-tj').find('dl').last().addClass('bor_0')
        $(".line-search-tj dl dd em").toggle(function(){
            $(this).prev().children('.hide-list').hide();
            $(this).children('b').text('展开');
            $(this).children('i').removeClass('up')
        },function(){
            $(this).prev().children('.hide-list').show();
            $(this).children('b').text('收起');
            $(this).children('i').addClass('up')
        });
$(".hpic-slide").slide({mainCell:".bd ul",delayTime:0,trigger:"click"});

})
</script> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <?php require_once ("E:/wamp64/www/taglib/position.php");$position_tag = new Taglib_Position();if (method_exists($position_tag, 'list_crumbs')) {$data = $position_tag->list_crumbs(array('action'=>'list_crumbs','destid'=>$destinfo['dest_id'],'typeid'=>$typeid,));}?> </div><!--面包屑--> <div class="st-main-page"> <div class="st-hotellist-box"> <div class="seo-content-box"> <h3 class="seo-bar"><span class="seo-title"><?php if($destinfo['dest_name']) { ?><?php echo $destinfo['dest_name'];?><?php echo $channelname;?><?php } else { ?><?php echo $channelname;?><?php } ?> </span></h3> <?php if($destinfo['dest_jieshao']) { ?> <div class="seo-wrapper clearfix"> <?php echo $destinfo['dest_jieshao'];?> </div> <?php } ?> </div> <!-- 目的地优化设置 --> <div class="st-list-search"> <div class="been-tj" <?php if(count($chooseitem)<1) { ?>style="display:none"<?php } ?>
> <strong>已选条件：</strong> <p> <?php $n=1; if(is_array($chooseitem)) { foreach($chooseitem as $item) { ?> <span class="chooseitem" data-url="<?php echo $item['url'];?>"><?php echo $item['itemname'];?><i></i></span> <?php $n++;}unset($n); } ?> <a href="javascript:;" class="clearc">清空筛选条件 </a> </p> </div> <div class="line-search-tj"> <dl class="date"> <dt>日期：</dt> <dd> <input type="text" placeholder="入住日期" id="txtHotelTime1" value="<?php echo $starttime;?>" /> <span>-</span> <input type="text" placeholder="离开日期" id="txtHotelTime2" value="<?php echo $endtime;?>" /> </dd> </dl> <dl class="type"> <dt>目的地：</dt> <dd> <p> <?php require_once ("E:/wamp64/www/taglib/dest.php");$dest_tag = new Taglib_Dest();if (method_exists($dest_tag, 'query')) {$destlist = $dest_tag->query(array('action'=>'query','typeid'=>$typeid,'flag'=>'nextsame','row'=>'100','pid'=>$destid,'return'=>'destlist',));}?> <?php $n=1; if(is_array($destlist)) { foreach($destlist as $dest) { ?> <a href="<?php echo Model_Hotel::get_search_url($dest['pinyin'],'destpy',$param);?>" <?php if($param['destpy']==$dest['pinyin']) { ?>class="on"<?php } ?>
><?php echo $dest['kindname'];?></a> <?php $n++;}unset($n); } ?> </p> <?php if(count($destlist)>10) { ?> <em><b>收起</b><i class='up'></i></em> <?php } ?> </dd> </dl> <dl class="type"> <dt>星级：</dt> <dd> <p> <?php $hotel_tag = new Taglib_Hotel();if (method_exists($hotel_tag, 'rank_list')) {$ranklist = $hotel_tag->rank_list(array('action'=>'rank_list','row'=>'20','return'=>'ranklist',));}?> <?php $n=1; if(is_array($ranklist)) { foreach($ranklist as $row) { ?> <a <?php if($param['rankid']==$row['id']) { ?>class="on"<?php } ?>
 href="<?php echo Model_Hotel::get_search_url($row['id'],'rankid',$param);?>"><?php echo $row['title'];?></a> <?php $n++;}unset($n); } ?> </p> <?php if(count($ranklist)>10) { ?> <em><b>收起</b><i class='up'></i></em> <?php } ?> </dd> </dl> <dl class="type"> <dt>价格区间：</dt> <dd> <p> <?php $hotel_tag = new Taglib_Hotel();if (method_exists($hotel_tag, 'price_list')) {$pricelist = $hotel_tag->price_list(array('action'=>'price_list','row'=>'20','return'=>'pricelist',));}?> <?php $n=1; if(is_array($pricelist)) { foreach($pricelist as $row) { ?> <a <?php if($param['priceid']==$row['id']) { ?>class="on"<?php } ?>
 href="<?php echo Model_Hotel::get_search_url($row['id'],'priceid',$param);?>"><?php echo $row['title'];?></a> <?php $n++;}unset($n); } ?> </p> </dd> </dl> <!--属性组读取--> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$grouplist = $attr_tag->query(array('action'=>'query','flag'=>'grouplist','typeid'=>$typeid,'return'=>'grouplist',));}?> <?php $n=1; if(is_array($grouplist)) { foreach($grouplist as $group) { ?> <dl class="type"> <dt><?php echo $group['attrname'];?>：</dt> <dd> <p> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$attrlist = $attr_tag->query(array('action'=>'query','flag'=>'childitem','typeid'=>$typeid,'groupid'=>$group['id'],'return'=>'attrlist',));}?> <?php $n=1; if(is_array($attrlist)) { foreach($attrlist as $attr) { ?> <a href="<?php echo Model_Hotel::get_search_url($attr['id'],'attrid',$param);?>" <?php if(Common::check_in_attr($param['attrid'],$attr['id'])!==false) { ?>class="on"<?php } ?>
><?php echo $attr['attrname'];?></a> <?php $n++;}unset($n); } ?> </p> </dd> </dl> <?php $n++;}unset($n); } ?> </div> </div><!--条件搜索--> <div class="st-hotellist-con"> <div class="st-sort-menu"> <span class="sort-sum"> <a href="javascript:;">综合排序</a> <a href="javascript:;">价格
                    <?php if($param['sorttype']!=1 && $param['sorttype']!=2) { ?> <i class="jg-default" data-url="<?php echo Model_Hotel::get_search_url(1,'sorttype',$param);?>"></i> <?php } ?> <?php if($param['sorttype']==1) { ?> <i class="jg-up" data-url="<?php echo Model_Hotel::get_search_url(2,'sorttype',$param);?>"></i> <?php } ?> <?php if($param['sorttype']==2) { ?> <i class="jg-down" data-url="<?php echo Model_Hotel::get_search_url(0,'sorttype',$param);?>"></i></a> <?php } ?> <a href="javascript:;">销量
                    <?php if($param['sorttype']!=3) { ?> <i class="xl-default" data-url="<?php echo Model_Hotel::get_search_url(3,'sorttype',$param);?>"></i> <?php } ?> <?php if($param['sorttype']==3) { ?> <i class="xl-down" data-url="<?php echo Model_Hotel::get_search_url(0,'sorttype',$param);?>"></i> <?php } ?> </a> <a href="javascript:;">推荐
                    <?php if($param['sorttype']!=4) { ?> <i class="tj-default" data-url="<?php echo Model_Hotel::get_search_url(4,'sorttype',$param);?>"></i> <?php } ?> <?php if($param['sorttype']==4) { ?> <i class="tj-down" data-url="<?php echo Model_Hotel::get_search_url(0,'sorttype',$param);?>"></i> <?php } ?> </a> </span><!--排序--> </div> <div class="hotel-list-con"> <?php if(!empty($list)) { ?> <?php $n=1; if(is_array($list)) { foreach($list as $h) { ?> <div class="list-child"> <div class="lc-image-text"> <div class="pic"><a href="<?php echo $h['url'];?>" title="<?php echo $h['title'];?>"><img src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo Common::img($h['litpic'],265,180);?>" alt="<?php echo $h['title'];?>" /></a></div> <div class="text"> <p class="bt"> <a href="<?php echo $h['url'];?>" target="_blank" title="<?php echo $h['title'];?>"><?php echo $h['title'];?> <?php $n=1; if(is_array($h['iconlist'])) { foreach($h['iconlist'] as $icon) { ?> <img src="<?php echo $icon['litpic'];?>" /> <?php $n++;}unset($n); } ?> </a> </p> <p class="attr"> <span>销量：<?php echo $h['sellnum'];?></span> <span>满意度：<?php if(!empty($h['satisfyscore'])) { ?><?php echo $h['satisfyscore'];?>%<?php } ?> </span> <span>推荐：<?php echo $h['recommendnum'];?></span> </p> <p class="js">酒店介绍：<?php echo Common::cutstr_html($h['content'],80);?></p> <p class="ads"><?php echo $h['address'];?></p> <?php if($h['suppliername']) { ?> <p class="gys">供应商：<?php echo $h['suppliername'];?></p> <?php } ?> </div> <div class="lowest-jg"> <?php if($h['price']) { ?> <span><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><b><?php echo $h['price'];?></b>起</span> <?php } else { ?> <span>电询</span> <?php } ?> </div> </div> <?php $hotel_tag = new Taglib_Hotel();if (method_exists($hotel_tag, 'suit')) {$roomlist = $hotel_tag->suit(array('action'=>'suit','row'=>'10','productid'=>$h['id'],'return'=>'roomlist',));}?> <?php if(!empty($roomlist)) { ?> <div class="roomtype-con"> <table width="100%" border="0"> <tr class="room-attr"> <th width="280" height="40" scope="col"><span class="pl20">房型</span></th> <th width="100" scope="col">床型</th> <th width="100" scope="col">餐标</th> <th width="100" scope="col">原价</th> <th width="100" scope="col">优惠价</th> <th width="100" scope="col">支付方式</th> <th scope="col">&nbsp;</th> </tr> <?php $n=1; if(is_array($roomlist)) { foreach($roomlist as $room) { ?> <tr data-more="more_<?php echo $room['id'];?>"> <td height="40" class="room" style="cursor: pointer"> <strong class="type-tit"><?php echo $room['title'];?></strong> <?php if(!empty($room['piclist'])) { ?> <i class="pic-ico"></i> <?php } ?> </td> <td align="center"><span><?php echo $room['roomstyle'];?></span></td> <td align="center"><span><?php echo $room['breakfirst'];?></span></td> <td align="center"><span><?php if($room['sellprice']) { ?><?php echo Currency_Tool::symbol();?><?php echo $room['sellprice'];?><?php } ?> </span></td> <td align="center"><span class="yh"><?php if($room['price']) { ?><?php echo Currency_Tool::symbol();?><?php echo $room['price'];?><?php } else { ?>电询<?php } ?> </span></td> <td><?php if(!empty($room['paytype_name'])) { ?><span class="fk-way"><?php echo $room['paytype_name'];?></span><?php } ?> </td> <td><a class="booking-btn" <?php if(empty($room['price'])) { ?>style="color: #fff;background-color: #999;cursor: default;"<?php } ?>
 href="<?php if($room['price']) { ?>/hotels/book?suitid=<?php echo $room['id'];?>&hotelid=<?php echo $room['hotelid'];?><?php } else { ?>javascritp:;<?php } ?>
"><?php if(empty($room['price'])) { ?>订完<?php } else { ?>预订<?php } ?> </a></td> </tr> <tr style="display: none"> <td height="40" colspan="7" > <div class="roomtype-sheshi"> <?php if(count($room['piclist'])>0) { ?> <div class="images-con"> <img class="show-pic" src="<?php echo $room['piclist']['0']['0'];?>"> <span class="ck"><em>查看全部<?php echo count($room['piclist']);?>张图片</em></span> </div> <?php } ?> <ul class="type-attr"> <li>面积：<?php echo $room['roomarea'];?>平方米</li> <li>楼层：<?php echo $room['roomfloor'];?>层</li> <li>房间：<?php echo $room['number'];?>间</li> <li>窗户：<?php echo $room['roomwindow'];?></li> <li>宽带：<?php echo $room['computer'];?></li> </ul> <?php if(!empty($room['description'])) { ?> <div class="type-sm">
                                            房型说明：<?php echo Common::cutstr_html($room['description'],2000);?> </div> <?php } ?> <div class="pic-fixed-box" style=" display:none"> <div class="zoom-images-box"> <div id="hpic-slide" class="hpic-slide"> <div class="bd"> <h3><?php echo $room['title'];?></h3> <ul> <?php $n=1; if(is_array($room['piclist'])) { foreach($room['piclist'] as $pic) { ?> <li><img src="<?php echo Common::img($pic['0'],456,330);?>"></li> <?php $n++;}unset($n); } ?> </ul> <a class="prev" href="javascript:void(0)"></a> <a class="next" href="javascript:void(0)"></a> </div> <div class="hd"> <div class="hp-closed"><span></span></div> <ul> <?php $n=1; if(is_array($room['piclist'])) { foreach($room['piclist'] as $pic) { ?> <li class="on"><img src="<?php echo Common::img($pic['0'],110,74);?>"></li> <?php $n++;}unset($n); } ?> </ul> </div> </div> </div> </div> </div> </td> </tr> <?php $n++;}unset($n); } ?> </table> </div> <?php } ?> </div> <?php $n++;}unset($n); } ?> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div> <?php } else { ?> <div class="no-content"> <p><i></i>抱歉，没有找到符合条件的产品！<a href="/hotels/all">查看全部产品</a></p> </div> <?php } ?> </div> </div> </div><!--列表主体--> <div class="st-sidebox"> <?php require_once ("E:/wamp64/www/taglib/right.php");$right_tag = new Taglib_Right();if (method_exists($right_tag, 'get')) {$data = $right_tag->get(array('action'=>'get','typeid'=>$typeid,'data'=>$templetdata,'pagename'=>'search',));}?> </div><!--边栏模块--> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Request::factory("pub/flink")->execute()->body(); ?> <?php echo Common::js('datepicker/WdatePicker.js',0);?> <script>
    $(function(){
        //展示房型详细信息
        $('.room').click(function(){
            $(this).parent().next().toggle();
        })
        //展示更新房型图片
        $('.ck').click(function(){
            $(this).parents('.roomtype-sheshi').first().find('.pic-fixed-box').show();
        })
        //关闭图层显示
        $(".hp-closed").click(function(){
            $(this).parents(".pic-fixed-box").first().hide();
        })
        //酒店预订时间选择
        $("#txtHotelTime1").focus(function(){
            $("#txtHotelTime2").attr('value','');
            WdatePicker({onpicking:function(dp){
                var starttime=dp.cal.getNewDateStr();
                var url=window.location.href;
                window.location.href=changeURLPar(url,'starttime',starttime);
            },dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d',maxDate:'#F{$dp.$D(\'txtHotelTime2\',{d:-1});}',doubleCalendar:true,isShowClear:false,readOnly:true,errDealMode:1})
            $("#txtHotelTime1").css("color","#333");
            $("#txtHotelTime2").blur();
        })
        $("#txtHotelTime2").focus(function(){
            WdatePicker({onpicking:function(dp){
                var endtime=dp.cal.getNewDateStr();
                var url=window.location.href;
                    window.location.href=changeURLPar(url,'endtime',endtime);
            },minDate:'#F{$dp.$D(\'txtHotelTime1\',{d:1});}',dateFmt:'yyyy-MM-dd',doubleCalendar:true,isShowClear:false,readOnly:true,errDealMode:1});
            $("#txtHotelTime2").css("color","#333");
            $("#txtHotelTime2").blur();
        })
        //排序方式点击
        $('.sort-sum').find('a').click(function(){
            var url = $(this).find('i').attr('data-url');
            if(url==undefined){
                url = location.href;
            }
            window.location.href = url;
        })
        //删除已选
        $(".chooseitem").find('i').click(function(){
            var url = $(this).parent().attr('data-url');
            window.location.href = url;
        })
        //清空筛选条件
        $('.clearc').click(function(){
            var url = SITEURL+'hotels/all/';
            window.location.href = url;
        })
        //隐藏没有属性下级分类
        $(".type").each(function(i,obj){
            var len = $(obj).find('dd p a').length;
            if(len<1){
                $(obj).hide();
            }
        })
        function changeURLPar(destiny, par, par_value)
        {
            var pattern = par+'=([^&]*)';
            var replaceText = par+'='+par_value;
            if (destiny.match(pattern))
            {
                var tmp = '/'+par+'=[^&]*/';
                tmp = destiny.replace(eval(tmp), replaceText);
                return (tmp);
            }
            else
            {
                if (destiny.match('[\?]'))
                {
                    return destiny+'&'+ replaceText;
                }
                else
                {
                    return destiny+'?'+replaceText;
                }
            }
            return destiny+'\n'+par+'\n'+par_value;
        }
    })
</script> </body> </html>
