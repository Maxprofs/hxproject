<!doctype html> <html> <head> <meta charset="utf-8"> <title><?php if($is_all) { ?>当季热门旅游线路_最新旅游线路大全-<?php echo $GLOBALS['cfg_webname'];?><?php } else { ?><?php echo $searchtitle;?><?php } ?> </title> <?php echo $destinfo['keyword'];?> <?php echo $destinfo['description'];?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css_plugin('lines.css','line');?> <?php echo Common::css('base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js');?> <script>
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
                    $('.grouplist-all').show();
                    $(this).removeClass("down").addClass("up").text("收起")
                }
                else{
                    $('.grouplist-all').hide();
                    $(this).removeClass("up").addClass("down").text("展开更多搜索")
                }
            })
            $("#st-search-pop-layer").css({
                "top":$("#search-type-dest").height()
            })
        })
    </script> </head> <body top_padding=WPOzDt > <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <?php require_once ("E:/wamp64/www/taglib/position.php");$position_tag = new Taglib_Position();if (method_exists($position_tag, 'list_crumbs')) {$data = $position_tag->list_crumbs(array('action'=>'list_crumbs','destid'=>$destinfo['dest_id'],'typeid'=>$typeid,));}?> </div> <!--面包屑--> <div class="st-main-page"> <div class="st-linelist-box"> <div class="st-line-brief"> <div class="dest-tit"><i class="st-line-icon line-mdd-icon"></i><?php if($destinfo['dest_name']) { ?><?php echo $destinfo['dest_name'];?><?php echo $channelname;?><?php } else { ?><?php echo $channelname;?><?php } ?> </div> <?php if($destinfo['dest_jieshao']) { ?> <div class="brief-con"> <?php echo $destinfo['dest_jieshao'];?> </div> <?php } ?> </div> <!--栏目介绍--> <div class="search-type-block "> <div class="search-type-item clearfix choose-item" <?php if(count($chooseitem)<1) { ?>style="display:none"<?php } ?>
> <strong class="item-hd">已选条件：</strong> <div class="item-bd"> <div class="item-check"> <?php $n=1; if(is_array($chooseitem)) { foreach($chooseitem as $item) { ?> <a class="chick-child chooseitem" data-url="<?php echo $item['url'];?>"   href="javascript:;"><?php echo $item['itemname'];?><i class="closed"></i></a> <?php $n++;}unset($n); } ?> <a class="clear-item clearc" href="javascript:;">清空筛选条件</a> </div> </div> </div> <div class="search-type-item clearfix"> <strong class="item-hd">目的地：</strong> <div class="item-bd"> <div class="item-child"> <div class="child-block"> <ul class="child-list"> <?php require_once ("E:/wamp64/www/taglib/dest.php");$dest_tag = new Taglib_Dest();if (method_exists($dest_tag, 'query')) {$destlist = $dest_tag->query(array('action'=>'query','typeid'=>$typeid,'flag'=>'nextsame','row'=>'100','pid'=>$destid,'return'=>'destlist',));}?> <?php $n=1; if(is_array($destlist)) { foreach($destlist as $dest) { ?> <li class="item"><a  <?php if($param['destpy']==$dest['pinyin']) { ?>class="active"<?php } ?>
 href="<?php echo Model_Line::get_search_url($dest['pinyin'],'destpy',$param);?>" ><?php echo $dest['kindname'];?></a></li> <?php $n++;}unset($n); } ?> </ul> <?php if(count($destlist)>5) { ?> <a class="arrow down" href="javascript:;">展开</a> <?php } ?> </div> </div> </div> </div> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$grouplist = $attr_tag->query(array('action'=>'query','flag'=>'grouplist','typeid'=>$typeid,'return'=>'grouplist',));}?> <?php $index=1;?> <?php $n=1; if(is_array($grouplist)) { foreach($grouplist as $group) { ?> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$attrlist = $attr_tag->query(array('action'=>'query','flag'=>'childitem','typeid'=>$typeid,'groupid'=>$group['id'],'return'=>'attrlist',));}?> <?php  if(empty($attrlist)){continue;} ?> <div class="search-type-item clearfix <?php if($GLOBALS['cfg_line_attr_show_num']<$index) { ?>grouplist-all<?php } ?>
" <?php if($GLOBALS['cfg_line_attr_show_num']<$index) { ?>style="display:none"<?php } ?>
> <strong class="item-hd"><?php echo $group['attrname'];?>：</strong> <div class="item-bd"> <div class="item-child"> <div class="child-block"> <ul class="child-list"> <?php $n=1; if(is_array($attrlist)) { foreach($attrlist as $attr) { ?> <li class="item"><a <?php if(Common::check_in_attr($param['attrid'],$attr['id'])!==false) { ?>class="active"<?php } ?>
 href="<?php echo Model_Line::get_search_url($attr['id'],'attrid',$param);?>" ><?php echo $attr['attrname'];?></a></li> <?php $n++;}unset($n); } ?> </ul> <?php if(count($attrlist)>5) { ?> <a class="arrow down" href="javascript:;">展开</a> <?php } ?> </div> </div> </div> </div> <?php $index++;?> <?php $n++;}unset($n); } ?> <a href="javascript:;" id="searchConsoleBtn" style="display: none" class="search-console-btn down">展开更多搜索</a> </div> <!-- 搜索条件 --> <div class="st-linelist-con"> <div class="st-sort-menu"> <span class="sort-sum"> <a href="javascript:;">综合排序</a> <a href="javascript:;">价格
                                    <?php if($param['sorttype']!=1 && $param['sorttype']!=2) { ?> <i class="jg-default" data-url="<?php echo Model_Line::get_search_url(1,'sorttype',$param);?>"></i> <?php } ?> <?php if($param['sorttype']==1) { ?> <i class="jg-up" data-url="<?php echo Model_Line::get_search_url(2,'sorttype',$param);?>"></i> <?php } ?> <?php if($param['sorttype']==2) { ?> <i class="jg-down" data-url="<?php echo Model_Line::get_search_url(0,'sorttype',$param);?>"></i></a> <?php } ?> </a> <a href="javascript:;">销量
                                    <?php if($param['sorttype']!=3) { ?> <i class="xl-default" data-url="<?php echo Model_Line::get_search_url(3,'sorttype',$param);?>"></i> <?php } ?> <?php if($param['sorttype']==3) { ?> <i class="xl-down" data-url="<?php echo Model_Line::get_search_url(0,'sorttype',$param);?>"></i> <?php } ?> </a> <select class="sel-price search-sel"> <option data-url="<?php echo Model_Line::get_search_url(0,'priceid',$param);?>">价格区间</option> <?php $line_tag = new Taglib_Line();if (method_exists($line_tag, 'price_list')) {$data = $line_tag->price_list(array('action'=>'price_list',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $r) { ?> <option  <?php if($param['priceid']==$r['id']) { ?>selected<?php } ?>
 data-url="<?php echo Model_Line::get_search_url($r['id'],'priceid',$param);?>"><?php echo $r['title'];?></option> <?php $n++;}unset($n); } ?> </select> <select class="sel-day search-sel"> <option data-url="<?php echo Model_Line::get_search_url(0,'dayid',$param);?>">出游天数</option> <?php $line_tag = new Taglib_Line();if (method_exists($line_tag, 'day_list')) {$data = $line_tag->day_list(array('action'=>'day_list',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $r) { ?> <option  <?php if($param['dayid']==$r['word']) { ?>selected<?php } ?>
 data-url="<?php echo Model_Line::get_search_url($r['word'],'dayid',$param);?>"><?php echo $r['title'];?></option> <?php $n++;}unset($n); } ?> </select> <?php if($GLOBALS['cfg_startcity_open']) { ?> <select class="sel-dest search-sel"> <option data-url="<?php echo Model_Line::get_search_url(0,'startcityid',$param);?>">出发城市</option> <?php require_once ("E:/wamp64/www/taglib/startplace.php");$startplace_tag = new Taglib_Startplace();if (method_exists($startplace_tag, 'city')) {$startcitylist = $startplace_tag->city(array('action'=>'city','row'=>'100','return'=>'startcitylist',));}?> <?php $n=1; if(is_array($startcitylist)) { foreach($startcitylist as $city) { ?> <option  <?php if($param['startcityid']==$city['id']) { ?>selected<?php } ?>
 data-url="<?php echo Model_Line::get_search_url($city['id'],'startcityid',$param);?>"><?php echo $city['title'];?></option> <?php $n++;}unset($n); } ?> </select> <?php } ?> </span> <span class="switch-show"> </span><!--切换模式--> </div> <?php if($list) { ?> <div class="txt-line-list"> <ul> <?php $n=1; if(is_array($list)) { foreach($list as $line) { ?> <li> <a href="<?php echo $line['url'];?>" target="_blank"> <div class="pic"><span><img src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo $line['litpic'];?>" alt="<?php echo $line['title'];?>" title="<?php echo $line['title'];?>"></span></div> <div class="txt"> <p class="bt"><?php echo $line['title'];?></p> <p class="attr"> <?php if($GLOBALS['cfg_icon_rule']==1) { ?> <?php $n=1; if(is_array($line['iconlist'])) { foreach($line['iconlist'] as $icon) { ?> <span/><?php echo $icon['kind'];?></span> <?php $n++;}unset($n); } ?> <?php } else { ?> <?php $n=1; if(is_array($line['iconlist'])) { foreach($line['iconlist'] as $icon) { ?> <img src="<?php echo $icon['litpic'];?>"/></span> <?php $n++;}unset($n); } ?> <?php } ?> </p> <p class="ts"> <?php if(!empty($line['startcity'])) { ?> <span class="pos"><?php echo $line['startcity'];?>出发</span> <?php } ?> <?php echo $line['sellpoint'];?> </p> <p class="msg"> <span class="item dates">
                                                团期：<?php echo $line['startdate'];?> <?php 
                                                  $start = explode('、',$line['startdate']);
                                                ?> </span> <?php if(count($start)>5) { ?> <span class="more-date-btn">更多</span> <?php } ?> </p> <p class="msg"> <span class="item days">行程：<?php echo $line['lineday'];?>天</span> <?php if($line['suppliername']) { ?> <span class="item supplier">供应商：<?php echo $line['suppliername'];?></span> <?php } ?> </p> </div> <div class="booking"> <span class="jg"> <?php if(!empty($line['price'])) { ?> <i><?php echo Currency_Tool::symbol();?><em><?php echo $line['price'];?></em></i>起
                                            <?php } else { ?> <i><em class="dx">电询</em></i> <?php } ?> </span> <?php if($line['jifentprice']) { ?> <span class="jf"><i>积分抵现</i><em>抵<strong><?php echo $line['jifentprice'];?></strong></em></span> <?php } ?> <div class="data clearfix"> <p class="sati"> <span class="num"><?php echo $line['score'];?></span> <span>满意度</span> </p> <p class="comment"> <span><?php echo $line['sellnum'];?>人已购买</span> <span><?php echo $line['commentnum'];?>条评论</span> </p> </div> </div> </a> </li> <?php $n++;}unset($n); } ?> </ul> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div> </div> <?php } else { ?> <div class="no-content"> <p><i></i>抱歉，没有找到符合条件的产品！<a href="/lines/all">查看全部产品</a></p> </div> <?php } ?> </div> </div> <!--列表主体--> <div class="st-sidebox"> <?php require_once ("E:/wamp64/www/taglib/right.php");$right_tag = new Taglib_Right();if (method_exists($right_tag, 'get')) {$data = $right_tag->get(array('action'=>'get','typeid'=>$typeid,'data'=>$templetdata,'pagename'=>'search',));}?> </div> <!--边栏模块--> </div> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Request::factory("pub/flink")->execute()->body(); ?> </body> </html> <script>
    //排序方式点击
    $('.sort-sum').find('a').click(function(){
        var url = $(this).find('i').attr('data-url');
        if(url==undefined){
            url = location.href;
        }
        window.location.href = url;
    });
    //删除已选
    $(".chooseitem").find('i').click(function(){
        var url = $(this).parent().attr('data-url');
        window.location.href = url;
    });
    //清空筛选条件
    $('.clearc').click(function(){
        var url = SITEURL+'lines/all/';
        window.location.href = url;
    });
    //隐藏没有属性下级分类
    $(".search-type-item").each(function(i,obj){
        if($(obj).hasClass('choose-item'))
        {
            return true;
        }
        var len = $(obj).find('.child-list .item').length;
        if(len<1){
            $(obj).remove();
        }
    });
    if($('.grouplist-all').length>0)
    {
            $('#searchConsoleBtn').show();
    }
    else
    {
        $('#searchConsoleBtn').hide();
    }
    $('.search-sel').change(function () {
        var url = $(this).find('option:selected').data('url');
        location.href = url;
    })
</script>