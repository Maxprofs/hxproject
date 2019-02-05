<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>"/>
    <?php } ?>
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>"/>
    <?php } ?>
    <?php echo Common::css('base.css,swiper.min.css,reset-style.css');?>
    <?php echo Common::css_plugin('car.css','car');?>
    <?php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,delayLoading.min.js');?>
</head>
<body>
    <?php echo Request::factory("pub/header_new/typeid/$typeid/isshowpage/1")->execute()->body(); ?>
    <div class="swiper-container st-photo-container">
        <ul class="swiper-wrapper">
            <?php $n=1; if(is_array($info['piclist'])) { foreach($info['piclist'] as $pic) { ?>
            <li class="swiper-slide">
                <a class="item" href="javascript:;"><img class="swiper-lazy" data-src="<?php echo Common::img($pic['0'],750,375);?>" alt="<?php echo $pic['1'];?>" /></a>
                <div class="swiper-lazy-preloader"></div>
            </li>
            <?php $n++;}unset($n); } ?>
        </ul>
        <div class="swiper-pagination"></div>
    </div>
    <!--轮播图-->
    <div class="car-show-top">
        <div class="tit"><?php echo $info['title'];?></div>
        <div class="txt">推荐理由：<?php echo $info['sellpoint'];?></div>
        <div class="supplier_data clearfix hide">
            <?php if($info['suppliers']) { ?>
            <p class="supplier">供应商：<?php echo $info['suppliers']['suppliername'];?></p>
            <?php } ?>
            <?php if($info['xxxxx']) { ?>
            <s></s>
            <p class="num"><?php echo $info['sellnum'];?>人参加过</p>
            <s></s>
            <p class="dest">目的地：<?php echo $info['finaldest_name'];?></p>
            <?php } ?>
        </div>
        <div class="attr">
            <?php $n=1; if(is_array($info['attrlist'])) { foreach($info['attrlist'] as $attr) { ?>
            <span class="label"><?php echo $attr['attrname'];?></span>
            <?php $n++;}unset($n); } ?>
        </div>
        <div class="price">
            <span class="jg">
                <?php if($info['price'] > 0) { ?>
                <i class="currency_sy no-style"><?php echo Currency_Tool::symbol();?></i><span class="num"><?php echo $info['price'];?></span>起
                <?php } else { ?>
                <span class="dx">电询</span>
                <?php } ?>
            </span>
        </div>
        <ul class="info">
            <li class="item">
                <span class="num"><?php echo $info['sellnum'];?></span>
                <span class="unit">销量</span>
            </li>
            <li class="item">
                <span class="num"><?php echo $info['satisfyscore'];?>%</span>
                <span class="unit">满意度</span>
            </li>
            <li class="item link pl">
                <span class="num"><?php echo $info['commentnum'];?></span>
                <span class="unit">人点评</span>
                <i class="more-icon"></i>
            </li>
            <li class="item link question">
                <span class="num"><?php echo Model_Question::get_question_num($typeid,$info['id']);?></span>
                <span class="unit">人咨询</span>
                <i class="more-icon"></i>
            </li>
        </ul>
    </div>
    <!--顶部介绍-->
    <div class="car-info-container">
        <h3 class="car-info-bar">
            <span class="title-txt">产品简介</span>
        </h3>
        <ul class="car-info-list">
            <li class="item"><span class="hd">车辆编号：</span><?php echo St_Product::product_series($info['id'], '3');?></li>
            <li class="item"><span class="hd">车辆车型：</span><?php echo $info['carkindname'];?></li>
        </ul>
        <div class="car-choose-date order" data-id="<?php echo $info['id'];?>"><i class="car-icon"></i>选择车型价格<i class="more-icon"></i></div>
    </div>
    <!-- 产品简介 -->
    <!--优惠券-->
    <?php if(St_Functions::is_normal_app_install('coupon')) { ?>
    <?php echo Request::factory("coupon/float_box-$typeid-".$info['id'])->execute()->body(); ?>
    <?php } ?>
    <?php require_once ("E:/wamp64/www/phone/taglib/detailcontent.php");$detailcontent_tag = new Taglib_Detailcontent();if (method_exists($detailcontent_tag, 'get_content')) {$data = $detailcontent_tag->get_content(array('action'=>'get_content','typeid'=>'3','productinfo'=>$info,'onlyrealfield'=>'1',));}?>
    <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
    <div class="car-info-container">
        <h3 class="car-info-bar">
            <span class="title-txt"><?php echo $row['chinesename'];?></span>
        </h3>
        <div class="car-info-wrapper clearfix">
            <?php echo $row['content'];?>
        </div>
    </div>
    <!--车辆信息-->
    <?php $n++;}unset($n); } ?>
    
    <?php echo Request::factory('pub/code')->execute()->body(); ?>
    <?php echo Request::factory('pub/footer')->execute()->body(); ?>
    <div class="bom_link_box">
        <div class="bom_fixed">
            <a href="tel:<?php echo $GLOBALS['cfg_m_phone'];?>">电话咨询</a>
            <a class="on order" data-id="<?php echo $info['id'];?>" href="javascript:;">立即预定</a>
        </div>
    </div>
<script>
    $(function () {
        //详情页滚动图
        var mySwiper = new Swiper('.st-photo-container', {
            autoplay: 5000,
            pagination : '.swiper-pagination',
            lazyLoading : true,
            observer: true,
            observeParents: true
        });
        //预订按钮
        $('.order').click(function(){
            var productid = $(this).attr('data-id');
            url = SITEURL+'car/book/id/'+productid;
            window.location.href = url;
        });
        //发表评论
        $('.pl').click(function(){
            var url = SITEURL+"pub/comment/id/<?php echo $info['id'];?>/typeid/<?php echo $typeid;?>";
            window.location.href = url;
        })
        //问答页面
        $('.question').click(function(){
            var url = SITEURL+"question/product_question_list?articleid=<?php echo $info['id'];?>&typeid=<?php echo $typeid;?>";
            window.location.href = url;
        })
    });
</script>
</body>
</html>
