<?php defined('SYSPATH') or die();?><!doctype html>
<html>
<head body_html=smACXC >
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
    <?php echo Common::css('swiper.min.css,base.css,reset-style.css,lib-flexible.js');?>
    <?php echo Common::css_plugin('m_ship.css','ship');?>
    <?php echo Common::js('lib-flexible.js,Zepto.js,swiper.min.js,jquery.min.js,delayLoading.min.js');?>
</head>
<body>
<?php echo Request::factory("pub/header_new/typeid/$typeid")->execute()->body(); ?>
    <!-- 公用顶部 -->
    <div class="swiper-container slide-img-block">
        <div class="swiper-wrapper">
            <?php require_once ("E:/wamp64/www/phone/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'s_ship_index_1',));}?>
            <?php $n=1; if(is_array($data['aditems'])) { foreach($data['aditems'] as $v) { ?>
            <div class="swiper-slide">
                <a class="pic" href="<?php echo $v['adlink'];?>"><img class="swiper-lazy" data-src="<?php echo Common::img($v['adsrc'],750,260);?>" alt="<?php echo $v['adname'];?>" /></a>
                <div class="swiper-lazy-preloader"></div>
            </div>
            <?php $n++;}unset($n); } ?>
            
        </div>
        <!-- 分页器 -->
        <div class="swiper-pagination"></div>
    </div>
    <!-- 图片切换 -->
    
    <div class="ship-hot-mdd">
        <div class="ship-tit-bar">
            <strong class="bt">热搜目的地</strong>
            <a class="more-link" href="<?php echo $cmsurl;?>ship/all">更多<i class="more-link-icon"></i></a>
        </div>
        <ul class="ship-mdd-wrapper clearfix">
            <?php require_once ("E:/wamp64/www/phone/taglib/dest.php");$dest_tag = new Taglib_Dest();if (method_exists($dest_tag, 'query')) {$data = $dest_tag->query(array('action'=>'query','flag'=>'hot','typeid'=>$typeid,'row'=>'10',));}?>
            <?php $n=1; if(is_array($data)) { foreach($data as $dest) { ?>
            <li><a href="<?php echo $cmsurl;?>ship/<?php echo $dest['pinyin'];?>"><?php echo $dest['kindname'];?></a></li>
            <?php $n++;}unset($n); } ?>
            
        </ul>
    </div>
    <!-- 热搜目的地 -->
    <div class="ship-hot-container">
        <div class="ship-tit-bar">
            <strong class="bt">热门邮轮</strong>
        </div>
        <div class="ship-hot-slide swiper-container">
            <ul class="swiper-wrapper clearfix">
                <?php $ship_tag = new Taglib_Ship();if (method_exists($ship_tag, 'ship')) {$subdata = $ship_tag->ship(array('action'=>'ship','row'=>'6','return'=>'subdata',));}?>
                <?php $n=1; if(is_array($subdata)) { foreach($subdata as $ship) { ?>
                <li class="swiper-slide">
                    <a class="item-a" href="<?php echo $ship['url'];?>">
                        <span class="pic">
                            <img src="<?php echo Common::img($ship['litpic'],274,186);?>" alt="<?php echo $ship['title'];?>" />
                        </span>
                        <span class="bt"><?php echo $ship['title'];?></span>
                    </a>
                </li>
                <?php $n++;}unset($n); } ?>
            </ul>
        </div>
    </div>
    <!-- 热门邮轮 -->
    
    <div class="ship-line-container">
        <div class="ship-tit-bar">
            <strong class="bt">精选航线</strong>
            <a class="more-link" href="<?php echo $cmsurl;?>ship/all">更多<i class="more-link-icon"></i></a>
        </div>
        <ul class="ship-line-wrapper">
            <?php $ship_tag = new Taglib_Ship();if (method_exists($ship_tag, 'query')) {$shiplist = $ship_tag->query(array('action'=>'query','flag'=>'order','row'=>'5','return'=>'shiplist',));}?>
            <?php $n=1; if(is_array($shiplist)) { foreach($shiplist as $ship) { ?>
            <li>
                <a class="item-a clearfix" href="<?php echo $ship['url'];?>">
                    <div class="pic"><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($ship['litpic'],235,160);?>" alt="<?php echo $ship['title'];?>" /></div>
                    <div class="info">
                        <div class="name"><?php echo Common::cutstr_html($ship['title'],30);?></div>
                        <?php if($ship['starttime']||$ship['startcity_name']) { ?>
                        <div class="star">出发地：<?php if(!empty($ship['starttime'])) { ?><?php echo date('m月d日',$ship['starttime']);?>，<?php } ?>
<?php if(!empty($ship['startcity_name'])) { ?><?php echo $ship['startcity_name'];?><?php } ?>
</div>
                        <?php } ?>
                        <div class="data">
                            <?php if(!empty($ship['finaldest_name'])) { ?>
                            <p class="mdd">目的地：<?php echo $ship['finaldest_name'];?></p>
                            <?php } ?>
                            <?php if($ship['price']) { ?>
                            <span class="pri"><em class="no-style"><?php echo Currency_Tool::symbol();?><b class="no-style"><?php echo $ship['price'];?></b></em>起/人</span>
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
        //轮播图
        var mySwiper = new Swiper ('.slide-img-block', {
                autoplay: 5000,
                pagination: '.slide-img-block .swiper-pagination',
                lazyLoading : true,
                observer: true,
                observeParents: true
            });
        //热门邮轮
        var swiper = new Swiper('.ship-hot-slide', {
                slidesPerView: 2.55
            });
    </script>
</body>
</html>