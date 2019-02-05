<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head strong_clear=YgxOJl >
    <meta charset="utf-8">
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $webname;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
    <?php } ?>
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>" />
    <?php } ?>
    <?php echo Common::css('base.css,swiper.min.css,reset-style.css');?>
    <?php echo Common::css_plugin('hotel.css','hotel');?>
    <?php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,delayLoading.min.js');?>
</head>
<body>
    <?php echo Request::factory("pub/header_new/typeid/$typeid/isshowpage/1")->execute()->body(); ?>
    <div class="swiper-container st-photo-container">
        <ul class="swiper-wrapper">
            <?php $n=1; if(is_array($info['piclist'])) { foreach($info['piclist'] as $pic) { ?>
             <li class="swiper-slide">
                <a class="item" href="javascript:;"><img class="swiper-lazy" data-src="<?php echo Common::img($pic['0'],750,375);?>" /></a>
                <div class="swiper-lazy-preloader"></div>
             </li>
            <?php $n++;}unset($n); } ?>
        </ul>
        <div class="swiper-pagination"></div>
    </div>
    <!--轮播图-->
    <div class="hotel-show-top">
        <h1 class="tit"><?php echo $info['title'];?></h1>
        <div class="txt"><?php echo $info['sellpoint'];?></div>
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
        <div class="price">
            <span class="jg"><i class="currency_sy no-style"><?php echo Currency_Tool::symbol();?></i><span class="num"><?php echo $info['price'];?></span>起</span>
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
    <div class="hotel-info-container">
        <h3 class="hotel-info-bar">
            <span class="title-txt">产品简介</span>
        </h3>
        <ul class="hotel-info-list">
            <li class="item">
                <span class="hd">酒店档次：</span>
                <div class="bd"><?php echo $info['hotelrank'];?></div>
            </li>
            <li class="item">
                <span class="hd">酒店地址：</span>
                <div class="bd">
                    <?php if(Plugin_Productmap::_is_installed()) { ?>
                    <a class="map-pro-addr" href="<?php if(!empty($info['lat'])&&!empty($info['lng'])) { ?>//<?php echo $GLOBALS['main_host'];?>/plugins/productmap/hotel/map?id=<?php echo $info['id'];?><?php } else { ?>javascript:;<?php } ?>
"><?php if(!empty($info['lat'])&&!empty($info['lng'])) { ?><span class="go-map"></span><?php } ?>
<?php echo $info['address'];?> </a>
                    <?php } else { ?>
                    <?php echo $info['address'];?>
                    <?php } ?>
                </div>
            </li>
            <li class="item">
                <span class="hd">酒店电话：</span>
                <div class="bd"><?php echo $info['telephone'];?></div>
            </li>
        </ul>
        <div class="hotel-choose-date order" data-id="<?php echo $info['id'];?>"><i class="car-icon"></i>选择房型、入住日期<i class="more-icon"></i></div>
    </div>
    <!--产品简介-->
    <!--优惠券-->
    <?php if(St_Functions::is_normal_app_install('coupon')) { ?>
    <?php echo Request::factory("coupon/float_box-$typeid-".$info['id'])->execute()->body(); ?>
    <?php } ?>
   <?php require_once ("E:/wamp64/www/phone/taglib/detailcontent.php");$detailcontent_tag = new Taglib_Detailcontent();if (method_exists($detailcontent_tag, 'get_content')) {$data = $detailcontent_tag->get_content(array('action'=>'get_content','typeid'=>'2','productinfo'=>$info,'onlyrealfield'=>'1',));}?>
    <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
    <div class="hotel-info-container">
        <h3 class="hotel-info-bar">
            <span class="title-txt"><?php echo $row['chinesename'];?></span>
        </h3>
        <div class="hotel-info-wrapper clearfix">
           <?php echo $row['content'];?>
        </div>
    </div><!--酒店详细-->
    <?php $n++;}unset($n); } ?>
   
    <?php echo Request::factory("pub/code")->execute()->body(); ?>
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
        $('.pl').click(function(){
            var url = SITEURL+"pub/comment/id/<?php echo $info['id'];?>/typeid/<?php echo $typeid;?>";
            window.location.href = url;
        })
        //预订按钮
        $('.order').click(function(){
            var productid = $(this).attr('data-id');
            url = SITEURL+'hotel/book/id/'+productid;
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
