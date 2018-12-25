<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head div_body=wLACXC > <meta charset="utf-8"> <title><?php if($is_all) { ?>旅游景点大全_热门景点推荐_景点门票预订-<?php echo $GLOBALS['cfg_webname'];?><?php } else { ?><?php echo $searchtitle;?><?php } ?> </title> <?php echo $destinfo['keyword'];?> <?php echo $destinfo['description'];?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('base.css,extend.css');?> <?php echo Common::css_plugin('scenic.css','spot');?> <?php echo Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js');?> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <?php require_once ("E:/wamp64/www/taglib/position.php");$position_tag = new Taglib_Position();if (method_exists($position_tag, 'list_crumbs')) {$data = $position_tag->list_crumbs(array('action'=>'list_crumbs','destid'=>$destinfo['dest_id'],'typeid'=>$typeid,));}?> </div><!--面包屑--> <div class="st-main-page"> <div class="st-sceniclist-box"> <div class="seo-content-box"> <h3 class="seo-bar"><span class="seo-title"><?php if($destinfo['dest_name']) { ?><?php echo $destinfo['dest_name'];?><?php echo $channelname;?><?php } else { ?><?php echo $channelname;?><?php } ?> </span></h3> <?php if($destinfo['dest_jieshao']) { ?> <div class="seo-wrapper clearfix"> <?php echo $destinfo['dest_jieshao'];?> </div> <?php } ?> </div> <!-- 目的地优化设置 --> <div class="search-type-block" id="search-content" data-max="<?php echo $GLOBALS['cfg_spot_attr_show_num'];?>"> <?php if(count($chooseitem)>0) { ?> <div class="search-type-item clearfix"> <strong class="item-hd">已选条件：</strong> <div class="item-bd"> <div class="item-check"> <?php $n=1; if(is_array($chooseitem)) { foreach($chooseitem as $item) { ?> <a class="chick-child" data-url="<?php echo $item['url'];?>"><?php echo $item['itemname'];?><i class="closed"></i></a> <?php $n++;}unset($n); } ?> <a href="javascript:;" class="clear-item clearc">清空筛选条件 </a> </div> </div> </div> <?php } ?> <div class="search-type-item clearfix"> <strong class="item-hd">目的地：</strong> <div class="item-bd"> <div class="item-child"> <div class="child-block"> <ul class="child-list"> <?php require_once ("E:/wamp64/www/taglib/dest.php");$dest_tag = new Taglib_Dest();if (method_exists($dest_tag, 'query')) {$destlist = $dest_tag->query(array('action'=>'query','typeid'=>$typeid,'flag'=>'nextsame','row'=>'100','pid'=>$destid,'return'=>'destlist',));}?> <?php $n=1; if(is_array($destlist)) { foreach($destlist as $dest) { ?> <li class="item"><a href="<?php echo $cmsurl;?>spots/<?php echo $dest['pinyin'];?>/"><?php echo $dest['kindname'];?></a></li> <?php $n++;}unset($n); } ?> </ul> <?php if(count($destlist)>5) { ?> <a class="arrow down" href="javascript:;">展开</a> <?php } ?> </div> </div> </div> </div> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$grouplist = $attr_tag->query(array('action'=>'query','flag'=>'grouplist','typeid'=>$typeid,'row'=>'100','return'=>'grouplist',));}?> <?php $n=1; if(is_array($grouplist)) { foreach($grouplist as $k => $group) { ?> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$attrlist = $attr_tag->query(array('action'=>'query','flag'=>'childitem','typeid'=>$typeid,'groupid'=>$group['id'],'return'=>'attrlist',));}?> <div class="search-type-item clearfix" <?php if($k>=$GLOBALS['cfg_spot_attr_show_num']) { ?>style="display:none;"<?php } ?>
> <strong class="item-hd"><?php echo $group['attrname'];?>：</strong> <div class="item-bd"> <div class="item-child"> <div class="child-block"> <ul class="child-list"> <?php $n=1; if(is_array($attrlist)) { foreach($attrlist as $attr) { ?> <li class="item"><a <?php if(Common::check_in_attr($param['attrid'],$attr['id'])!==false) { ?>class="active"<?php } ?>
 href="<?php echo Model_Spot::get_search_url($attr['id'],'attrid',$param);?>"><?php echo $attr['attrname'];?></a></li> <?php $n++;}unset($n); } ?> </ul> </div> </div> </div> </div> <?php $n++;}unset($n); } ?> <div class="search-type-item-bak clearfix hide"> <strong class="item-hd">价格区间：</strong> <div class="item-bd"> <div class="item-child"> <div class="child-block"> <ul class="child-list"> <?php $spot_tag = new Taglib_Spot();if (method_exists($spot_tag, 'price_list')) {$pricelist = $spot_tag->price_list(array('action'=>'price_list','row'=>'20','return'=>'pricelist',));}?> <?php $n=1; if(is_array($pricelist)) { foreach($pricelist as $row) { ?> <li class="item"><a <?php if($param['priceid']==$row['id']) { ?>class="active"<?php } ?>
 href="<?php echo Model_Spot::get_search_url($row['id'],'priceid',$param);?>"><?php echo $row['title'];?></a></li> <?php $n++;}unset($n); } ?> </ul> </div> </div> </div> </div> <?php if(count($grouplist)>4) { ?> <a href="javascript:;" id="searchConsoleBtn" class="search-console-btn down">展开更多搜索</a> <?php } ?> </div><!--条件搜索--> <div class="st-sceniclist-con"> <div class="st-sort-menu"> <span class="sort-sum"> <a href="javascript:;">综合排序</a> <a href="javascript:;">价格
                    <?php if($param['sorttype']!=1 && $param['sorttype']!=2) { ?> <i class="jg-default" data-url="<?php echo Model_Spot::get_search_url(1,'sorttype',$param);?>"></i> <?php } ?> <?php if($param['sorttype']==1) { ?> <i class="jg-up" data-url="<?php echo Model_Spot::get_search_url(2,'sorttype',$param);?>"></i> <?php } ?> <?php if($param['sorttype']==2) { ?> <i class="jg-down" data-url="<?php echo Model_Spot::get_search_url(0,'sorttype',$param);?>"></i></a> <?php } ?> <a href="javascript:;">销量
                    <?php if($param['sorttype']!=3) { ?> <i class="xl-default" data-url="<?php echo Model_Spot::get_search_url(3,'sorttype',$param);?>"></i> <?php } ?> <?php if($param['sorttype']==3) { ?> <i class="xl-down" data-url="<?php echo Model_Spot::get_search_url(0,'sorttype',$param);?>"></i> <?php } ?> </a> <a href="javascript:;">推荐
                    <?php if($param['sorttype']!=4) { ?> <i class="tj-default" data-url="<?php echo Model_Spot::get_search_url(4,'sorttype',$param);?>"></i> <?php } ?> <?php if($param['sorttype']==4) { ?> <i class="tj-down" data-url="<?php echo Model_Spot::get_search_url(0,'sorttype',$param);?>"></i> <?php } ?> </a> </span><!--排序--> </div> <div class="scenic-list-con"> <?php if(!empty($list)) { ?> <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?> <div class="list-child"> <a href="<?php echo $row['url'];?>" target="_blank" title="<?php echo $row['title'];?>"> <div class="lc-image-text clearfix"> <div class="pic"> <span> <img src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo Common::img($row['litpic'],265,180);?>" alt="<?php echo $row['title'];?>"/> </span> </div> <div class="text"> <p class="bt"><?php echo $row['title'];?></p> <p class="attr clearfix"> <?php if($GLOBALS['cfg_icon_rule']==1) { ?> <?php $n=1; if(is_array($row['iconlist'])) { foreach($row['iconlist'] as $icon) { ?> <span><?php echo $icon['kind'];?></span> <?php $n++;}unset($n); } ?> <?php } else { ?> <?php $n=1; if(is_array($row['iconlist'])) { foreach($row['iconlist'] as $ico) { ?> <img src="<?php echo $ico['litpic'];?>"/> <?php $n++;}unset($n); } ?> <?php } ?> </p> <?php if(!empty($row['sellpoint'])) { ?> <p class="sell-point"> <?php echo $row['sellpoint'];?> </p> <?php } ?> <?php if(!empty($row['open_time_des'])) { ?> <dl class="open-time"> <dt>开放时间：</dt> <dd><p><?php echo $row['open_time_des'];?></p></dd> </dl> <?php } ?> <?php if(!empty($row['address'])) { ?> <p class="ads"><?php if($row['finaldestid']>0) { ?><span class="pos"><?php echo $row['finaldestname'];?></span><?php } ?> <?php echo $row['address'];?></p> <?php } ?> </div> <div class="booking"> <div class="lowest-jg"> <?php if(!empty($row['price'])) { ?> <i class="currency_sy"><?php echo Currency_Tool::symbol();?><em><?php echo $row['price'];?></em></i>起
                                    <?php } else { ?> <i class="currency_sy"><em>电询</em></i> <?php } ?> </div> <div class="data clearfix"> <p class="sati"> <span class="num"><?php echo $row['satisfyscore'];?></span> <span>满意度</span> </p> <p class="comment"> <span><?php echo $row['sellnum'];?>人已购买</span> <span><?php echo Model_Comment::get_comment_num($row['id'],$typeid);?>条评论</span> </p> </div> </div> </div> </a> <?php if($row['hasticket']) { ?> <div class="spot-typetable"> <div class="type-label clearfix"> <ul> <?php $spot_tag = new Taglib_Spot();if (method_exists($spot_tag, 'suit_list')) {$suitlist = $spot_tag->suit_list(array('action'=>'suit_list','row'=>'100','productid'=>$row['id'],'return'=>'suitlist',));}?> <?php $n=1; if(is_array($suitlist)) { foreach($suitlist as $suit) { ?> <li class="li-hide"> <div class="ticket-title"> <strong class="type-tit"><?php echo $suit['title'];?><?php if($suit['tickettype_name']) { ?>-<?php echo $suit['tickettype_name'];?><?php } ?> <i class="arr-ico"></i> </strong> </div> <div class="ticket-data clearfix"> <div class="ticket-type"><?php echo $type['title'];?></div> <div class="order-time"><?php if(!empty($suit['day_before_des_mobile'])) { ?> <?php echo $suit['day_before_des_mobile'];?> <?php } else { ?>当天24:00前可预定<?php } ?> </div> <div class="ticket-price"> <span class="price"><?php if($suit['ourprice']) { ?><em><?php echo Currency_Tool::symbol();?><strong><?php echo $suit['ourprice'];?></strong></em>起<?php } else { ?><strong>电询</strong><?php } ?> </span> <span class="ori-price">（<?php if(!empty($suit['sellprice'])) { ?><del><?php echo Currency_Tool::symbol();?><?php echo $suit['sellprice'];?></del><?php } else { ?>--<?php } ?>
）</span> </div> <div class="pay-type"><?php if($suit['pay_way']==1) { ?>线上支付
                                            <?php } else if($suit['pay_way']==2) { ?>线下支付
                                            <?php } else if($suit['pay_way']==3) { ?>线上支付/线下支付
                                            <?php } ?> </div> <div class="ticket-order-btn"> <?php if($suit['price_status']==1) { ?> <a class="booking-btn" href="<?php echo $cmsurl;?>spot/book/?suitid=<?php echo $suit['id'];?>&productid=<?php echo $suit['spotid'];?>">立即预订</a> <?php } else if($suit['price_status']==3) { ?> <a class="booking-btn over" href="javascript:;">电询</a> <?php } else if($suit['price_status']==2) { ?> <a class="booking-btn over" href="javascript:;">订完</a> <?php } ?> </div> </div> <div class="suit-des"> <div class="cartype-nr"> <?php if($suit['effective_days']) { ?> <div class="cartype-nr-sm"> <strong class="hd">门票有效期</strong> <div class="bd"> <?php if(!empty($suit['effective_days'])) { ?> <?php echo $suit['effective_before_days_des'];?> <?php } else { ?>验票当天24:00前<?php } ?> </div> </div> <?php } ?> <?php if(!empty($suit['get_ticket_way'])) { ?> <div class="cartype-nr-sm"> <strong class="hd">取票方式</strong> <div class="bd"><?php echo $suit['get_ticket_way'];?></div> </div> <?php } ?> <div class="cartype-nr-sm"> <strong class="hd">退改方式</strong> <div class="bd"> <?php if($suit['refund_restriction']==0) { ?>无条件退
                                                    <?php } else if($suit['refund_restriction']==1) { ?>不可退改
                                                    <?php } else if($suit['refund_restriction']==2) { ?>有条件退<?php } ?> </div> </div> <?php if(!empty($suit['suppliername'])) { ?> <div class="cartype-nr-sm"> <strong class="hd">供应商</strong> <div class="bd"><?php echo $suit['suppliername'];?></div> </div> <?php } ?> <?php if(!empty($suit['description'])) { ?> <div class="cartype-nr-sm"> <strong class="hd">门票说明</strong> <div class="bd"> <?php echo $suit['description'];?> </div> </div> <?php } ?> </div> </div> </li> <?php $n++;}unset($n); } ?> </ul> <div class="more-btn-box more_suit" style="display:none;"> <a href="javascript:;" class="more-ticket-btn">loading</a> </div> </div> </div> <?php } ?> </div> <?php $n++;}unset($n); } ?> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div> <?php } else { ?> <div class="no-content"> <p><i></i>抱歉，没有找到符合条件的产品！<a href="/spots/all">查看全部产品</a></p> </div> <?php } ?> </div> </div> </div> <div class="st-sidebox"> <?php require_once ("E:/wamp64/www/taglib/right.php");$right_tag = new Taglib_Right();if (method_exists($right_tag, 'get')) {$data = $right_tag->get(array('action'=>'get','typeid'=>$typeid,'data'=>$templetdata,'pagename'=>'search',));}?> </div><!--边栏模块--> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Request::factory("pub/flink")->execute()->body(); ?> <script>
    $(function(){
        //搜索条件
        $(".arrow").on("click",function(){
            if( $(this).hasClass("down") )
            {
                $(this).removeClass("down").addClass("up");
                $(this).text("收起");
                $(this).prev(".child-list").css("height","auto")
            }
            else
            {
                $(this).removeClass("up").addClass("down");
                $(this).text("展开");
                $(this).prev(".child-list").css("height","24px")
            }
        });
        $("#searchConsoleBtn").on("click",function(){
            if( $(this).hasClass("down") ){
                $("div.search-type-block div.search-type-item").show();
                $(this).removeClass("down").addClass("up").text("收起");
            }else{
                $("div.search-type-block div.search-type-item").each(function(){
                    var index=$("div.search-type-block div.search-type-item").index(this);
                    var max=Number($("#search-content").attr('data-max'));
                    if(index>max+1){
                        $(this).hide();
                    }
                })
                $(this).removeClass("up").addClass("down").text("展开更多搜索");
            }
        });
        //搜索条件去掉最后一条边框
        $('.line-search-tj').find('dl').last().addClass('bor_0')
        $(".line-search-tj dl dd em").toggle(function(){
            $(this).prev().height('24px');
            $(this).children('b').text('展开');
            $(this).children('i').removeClass('up')
        },function(){
            $(this).prev().height('auto');
            $(this).children('b').text('收起');
            $(this).children('i').addClass('up')
        });
        //套餐点击
        $(".type-tit").click(function(){
            var i_obj = $(this);
            if(i_obj.children().length>0 ){
                if(i_obj.hasClass('active'))
                {
                    i_obj.removeClass('active');
                    i_obj.parents().siblings(".suit-des").hide();
                }
                else
                {
                    i_obj.addClass('active');
                    i_obj.parents().siblings(".suit-des").show();
                }
            }
        });
//        //套餐点击
//        $(".type-tit").click(function(){
//            $(this).parents('tr').first().next().toggle();
//        })
        //排序方式点击
        $('.sort-sum').find('a').click(function(){
            var url = $(this).find('i').attr('data-url');
            if(url==undefined){
                url = location.href;
            }
            window.location.href = url;
        })
        //删除已选
        $(".item-check").find('i.closed').click(function(){
            var url = $(this).parent().attr('data-url');
            window.location.href = url;
        })
        //清空筛选条件
        $('.clearc').click(function(){
            var url = SITEURL+'spots/all/';
            window.location.href = url;
        })
        //隐藏没有属性下级分类
        $(".type").each(function(i,obj){
            var len = $(obj).find('dd p a').length;
            if(len<1){
                $(obj).hide();
            }
        })
        //隐藏多余的套餐
        $(".scenic-list-con .list-child").each(function () {
            var child=$(this).find(".spot-typetable ul li").length;
            $(this).find(".spot-typetable ul li").each(function () {
                if ($(this).index() < 3) {
                    $(this).removeClass('li-hide');
                }
            });
            if(child>3) {
                var hide_num = child - 3
                $(this).find(".spot-typetable div.more_suit a.more-ticket-btn").html('展开全部门票（' + hide_num + '）');
                $(this).find(".spot-typetable div.more_suit").show();
            }
        });
        //查看更多门票
        $(".more-ticket-btn").on("click",function(){
            var $this=$(this);
            var tiLi=$this.parents(".type-label").find("li.li-hide");
            if($this.hasClass("up")){
                tiLi.css({"display":"none"});
                $this.removeClass("up").text('展开全部门票（' + tiLi.length + '）');
            }else{
                tiLi.css({"display":"block"});
                $this.addClass("up").text('收起更多门票（' + tiLi.length + '）');
            }
        });
    })
</script> </body> </html>
