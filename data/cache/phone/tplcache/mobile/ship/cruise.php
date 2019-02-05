<?php defined('SYSPATH') or die();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>" />
    <?php } ?>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <?php echo Common::css('swiper.min.css,base.css,,reset-style.css,lib-flexible.js');?>
    <?php echo Common::css_plugin('m_ship.css','ship');?>
    <?php echo Common::js('lib-flexible.js,Zepto.js,swiper.min.js,jquery.min.js,delayLoading.min.js');?>
</head>
<body>
<?php echo Request::factory("pub/header_new/typeid/$typeid/islistpage/1")->execute()->body(); ?>
    <!-- 公用顶部 -->
    <div class="ship-tip-container">
        <div class="tip-pic-box">
            <img src="<?php echo Common::img($info['litpic'],750,312);?>" alt="<?php echo $info['title'];?>" title="<?php echo $info['title'];?>">
        </div>
        <div class="tip-pic-tit"><?php echo $info['title'];?></div>
        <div class="ship-cs-item">
            <h3 class="show-tit-bar"><strong class="bt no-style">参数</strong></h3>
            <ul class="cs-list clearfix">
                <li>吨位：<?php echo $info['weight'];?>吨</li>
                <li>载客量：<?php echo $info['seatnum'];?>人</li>
                <li>船体长度：<?php echo $info['length'];?>米</li>
                <li>船体宽度：<?php echo $info['width'];?>米</li>
                <li>船速：<?php echo $info['speed'];?>节</li>
                <li>甲板楼层：<?php echo $info['floornum'];?>层</li>
                <li>首航时间：<?php echo $info['sailtime'];?>年</li>
            </ul>
        </div>
        <div class="ship-txt-item">
            <h3 class="show-tit-bar"><strong class="bt no-style">游轮简介</strong></h3>
            <div class="ship-txt-wrap">
                <div class="txt-box">
                    <?php echo $info['content'];?>
                </div>
                <span class="txt-icon"></span>
            </div>
        </div>
    </div>
    <!-- 游轮介绍 -->
    <div class="ship-ss-container">
        <div class="ship-tit-bar">
            <strong class="bt no-style">设施介绍</strong>
        </div>
        <div class="ship-ss-slide swiper-container">
            <ul class="swiper-wrapper clearfix">
                <?php $ship_tag = new Taglib_Ship();if (method_exists($ship_tag, 'room_kind')) {$roomkinds = $ship_tag->room_kind(array('action'=>'room_kind','shipid'=>$info['id'],'row'=>'100','return'=>'roomkinds',));}?>
                <?php $roomnum = count($roomkinds)?>
                <li class="swiper-slide">
                    <a class="item-a" href="<?php echo $cmsurl;?>ship/roomlist_<?php echo $info['id'];?>.html">
                        <div class="pic">
                            <img src="<?php echo Common::img(Model_Ship::get_facility_litpic($info['id']),190,190);?>" alt="<?php echo $info['title'];?>" />
                        </div>
                        <div class="info">
                            <strong class="type no-style">邮轮舱房</strong>
                            <em class="num no-style">共<?php echo $roomnum;?>类</em>
                        </div>
                    </a>
                </li>
                <?php $ship_tag = new Taglib_Ship();if (method_exists($ship_tag, 'facility_kind')) {$facilitykinds = $ship_tag->facility_kind(array('action'=>'facility_kind','shipid'=>$info['id'],'row'=>'100','return'=>'facilitykinds',));}?>
                <?php $n=1; if(is_array($facilitykinds)) { foreach($facilitykinds as $kind) { ?>
                <?php $ship_tag = new Taglib_Ship();if (method_exists($ship_tag, 'facility')) {$facilities = $ship_tag->facility(array('action'=>'facility','shipid'=>$info['id'],'kindid'=>$kind['id'],'row'=>'100','return'=>'facilities',));}?>
                <?php $num = count($facilities)?>
                <li class="swiper-slide">
                    <a class="item-a" href="<?php echo $cmsurl;?>ship/facility/aid/<?php echo $info['id'];?>/kindid/<?php echo $kind['id'];?>.html">
                        <div class="pic">
                            <img src="<?php echo Common::img(Model_Ship::get_facility_litpic($info['id'],$kind['id']),190,190);?>" alt="<?php echo $kind['title'];?>" />
                        </div>
                        <div class="info">
                            <strong class="type no-style"><?php echo $kind['title'];?></strong>
                            <em class="num no-style">共<?php echo $num;?>类</em>
                        </div>
                    </a>
                </li>
                <?php $n++;}unset($n); } ?>
                
            </ul>
        </div>
    </div>
    <!-- 设施介绍 -->
    
    <div class="ship-line-container">
        <div class="ship-tit-bar">
            <strong class="bt no-style">精选航线</strong>
            <a class="more-link" href="<?php echo $cmsurl;?>ship/all-0-0-0-0-<?php echo $info['id'];?>-0-1">更多<i class="more-link-icon"></i></a>
        </div>
        <ul class="ship-line-wrapper">
            <?php $ship_tag = new Taglib_Ship();if (method_exists($ship_tag, 'query')) {$sublines = $ship_tag->query(array('action'=>'query','flag'=>'byship','shipid'=>$info['id'],'row'=>'6','return'=>'sublines',));}?>
            <?php $n=1; if(is_array($sublines)) { foreach($sublines as $line) { ?>
            <li>
                <a class="item-a clearfix" href="<?php echo $line['url'];?>">
                    <div class="pic"><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($line['litpic'],235,160);?>" alt="<?php echo $line['title'];?>" title="<?php echo $line['title'];?>" /></div>
                    <div class="info">
                        <div class="name"><?php echo $line['title'];?></div>
                        <?php if($line['starttime']||$line['startcity_name']) { ?>
                        <div class="star">出发地：<?php if(!$line['starttime']) { ?><?php echo date('m月d日',$line['starttime']);?>，<?php } ?>
<?php if(!empty($line['startcity_name'])) { ?><?php echo $line['startcity_name'];?><?php } ?>
</div>
                        <?php } ?>
                        <div class="data">
                            <?php if(!empty($line['finaldest_name'])) { ?>
                            <p class="mdd">目的地：<?php echo $line['finaldest_name'];?></p>
                            <?php } ?>
                            <?php if($line['price']) { ?>
                            <span class="pri"><em class="no-style"><?php echo Currency_Tool::symbol();?><b class="no-style"><?php echo $line['price'];?></b></em>起/人</span>
                            <?php } else { ?>
                            <span class="pri"><em class="no-style"><b class="no-style">电询</b></em></span>
                            <?php } ?>
                        </div>
                    </div>
                </a>
            </li>
            <?php $n++;}unset($n); } ?>
            
        </ul>
    </div>
    <!-- 精选航线 -->
<?php echo Request::factory('pub/code')->execute()->body(); ?>
    <script>
        //头部下拉导航
        $(".st-user-menu").on("click",function(){
            $(".header-menu-bg,.st-down-bar").show();
            $("body").css("overflow","hidden")
        });
        $(".header-menu-bg").on("click",function(){
            $(".header-menu-bg,.st-down-bar").hide();
            $("body").css("overflow","auto")
        });
        //设施介绍
        var swiper = new Swiper('.ship-ss-slide', {
                slidesPerView: 3.38
            });
        //点击展开
        var $txtIcon = $(".ship-txt-wrap>.txt-icon");
        $txtIcon.on("click",function(){
            if( $txtIcon.hasClass("up") ){
                $txtIcon.removeClass("up");
                $txtIcon.prev(".txt-box").css({
                    height: "1.04rem"
                });
            }
            else{
                $txtIcon.addClass("up");
                $txtIcon.prev(".txt-box").css({
                    height: "auto"
                });
            }
        });
    </script>
</body>
</html>