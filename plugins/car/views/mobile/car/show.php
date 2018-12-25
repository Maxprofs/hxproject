<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}"/>
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}"/>
    {/if}
    {Common::css('base.css,swiper.min.css,reset-style.css')}
    {Common::css_plugin('car.css','car')}
    {Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,delayLoading.min.js')}
</head>
<body>

    {request "pub/header_new/typeid/$typeid/isshowpage/1"}

    <div class="swiper-container st-photo-container">
        <ul class="swiper-wrapper">
            {loop $info['piclist'] $pic}
            <li class="swiper-slide">
                <a class="item" href="javascript:;"><img class="swiper-lazy" data-src="{Common::img($pic[0],750,375)}" alt="{$pic[1]}" /></a>
                <div class="swiper-lazy-preloader"></div>
            </li>
            {/loop}
        </ul>
        <div class="swiper-pagination"></div>
    </div>
    <!--轮播图-->

    <div class="car-show-top">
        <div class="tit">{$info['title']}</div>
        <div class="txt">推荐理由：{$info['sellpoint']}</div>
        <div class="supplier_data clearfix hide">
            {if $info['suppliers']}
            <p class="supplier">供应商：{$info['suppliers']['suppliername']}</p>
            {/if}
            {if $info['xxxxx']}
            <s></s>
            <p class="num">{$info['sellnum']}人参加过</p>
            <s></s>
            <p class="dest">目的地：{$info['finaldest_name']}</p>
            {/if}
        </div>
        <div class="attr">
            {loop $info['attrlist'] $attr}
            <span class="label">{$attr['attrname']}</span>
            {/loop}
        </div>
        <div class="price">
            <span class="jg">
                {if $info['price'] > 0}
                <i class="currency_sy no-style">{Currency_Tool::symbol()}</i><span class="num">{$info['price']}</span>起
                {else}
                <span class="dx">电询</span>
                {/if}
            </span>
        </div>
        <ul class="info">
            <li class="item">
                <span class="num">{$info['sellnum']}</span>
                <span class="unit">销量</span>
            </li>
            <li class="item">
                <span class="num">{$info['satisfyscore']}%</span>
                <span class="unit">满意度</span>
            </li>
            <li class="item link pl">
                <span class="num">{$info['commentnum']}</span>
                <span class="unit">人点评</span>
                <i class="more-icon"></i>
            </li>
            <li class="item link question">
                <span class="num">{Model_Question::get_question_num($typeid,$info['id'])}</span>
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
            <li class="item"><span class="hd">车辆编号：</span>{St_Product::product_series($info['id'], '3')}</li>
            <li class="item"><span class="hd">车辆车型：</span>{$info['carkindname']}</li>
        </ul>
        <div class="car-choose-date order" data-id="{$info['id']}"><i class="car-icon"></i>选择车型价格<i class="more-icon"></i></div>
    </div>
    <!-- 产品简介 -->

    <!--优惠券-->
    {if St_Functions::is_normal_app_install('coupon')}
    {request "coupon/float_box-$typeid-".$info['id']}
    {/if}
    {st:detailcontent action="get_content" typeid="3" productinfo="$info" onlyrealfield="1"}
    {loop $data $row}
    <div class="car-info-container">
        <h3 class="car-info-bar">
            <span class="title-txt">{$row['chinesename']}</span>
        </h3>
        <div class="car-info-wrapper clearfix">
            {$row['content']}
        </div>
    </div>
    <!--车辆信息-->
    {/loop}
    {/st}

    {request 'pub/code'}
    {request 'pub/footer'}

    <div class="bom_link_box">
        <div class="bom_fixed">
            <a href="tel:{$GLOBALS['cfg_m_phone']}">电话咨询</a>
            <a class="on order" data-id="{$info['id']}" href="javascript:;">立即预定</a>
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
            var url = SITEURL+"pub/comment/id/{$info['id']}/typeid/{$typeid}";
            window.location.href = url;
        })
        //问答页面
        $('.question').click(function(){
            var url = SITEURL+"question/product_question_list?articleid={$info['id']}&typeid={$typeid}";
            window.location.href = url;
        })

    });

</script>
</body>
</html>
