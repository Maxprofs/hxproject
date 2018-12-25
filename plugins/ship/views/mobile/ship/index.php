<?php defined('SYSPATH') or die();?><!doctype html>
<html>
<head body_html=smACXC >
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    <meta name="apple-mobile-web-app-capable" content="yes" />
    {Common::css('swiper.min.css,base.css,reset-style.css,lib-flexible.js')}
    {Common::css_plugin('m_ship.css','ship')}
    {Common::js('lib-flexible.js,Zepto.js,swiper.min.js,jquery.min.js,delayLoading.min.js')}

</head>

<body>

{request "pub/header_new/typeid/$typeid"}
    <!-- 公用顶部 -->

    <div class="swiper-container slide-img-block">
        <div class="swiper-wrapper">
            {st:ad action="getad" name="s_ship_index_1"}
            {loop $data['aditems'] $v}
            <div class="swiper-slide">
                <a class="pic" href="{$v['adlink']}"><img class="swiper-lazy" data-src="{Common::img($v['adsrc'],750,260)}" alt="{$v['adname']}" /></a>
                <div class="swiper-lazy-preloader"></div>
            </div>
            {/loop}
            {/st}
        </div>
        <!-- 分页器 -->
        <div class="swiper-pagination"></div>
    </div>
    <!-- 图片切换 -->
    
    <div class="ship-hot-mdd">
        <div class="ship-tit-bar">
            <strong class="bt">热搜目的地</strong>
            <a class="more-link" href="{$cmsurl}ship/all">更多<i class="more-link-icon"></i></a>
        </div>
        <ul class="ship-mdd-wrapper clearfix">
            {st:dest action="query" flag="hot" typeid="$typeid" row="10"}
            {loop $data $dest}
            <li><a href="{$cmsurl}ship/{$dest['pinyin']}">{$dest['kindname']}</a></li>
            {/loop}
            {/st}
        </ul>
    </div>
    <!-- 热搜目的地 -->

    <div class="ship-hot-container">
        <div class="ship-tit-bar">
            <strong class="bt">热门邮轮</strong>
        </div>
        <div class="ship-hot-slide swiper-container">
            <ul class="swiper-wrapper clearfix">
                {st:ship action="ship" row="6" return="subdata"}
                {loop $subdata $ship}
                <li class="swiper-slide">
                    <a class="item-a" href="{$ship['url']}">
                        <span class="pic">
                            <img src="{Common::img($ship['litpic'],274,186)}" alt="{$ship['title']}" />
                        </span>
                        <span class="bt">{$ship['title']}</span>
                    </a>
                </li>
                {/loop}
            </ul>
        </div>
    </div>
    <!-- 热门邮轮 -->
    
    <div class="ship-line-container">
        <div class="ship-tit-bar">
            <strong class="bt">精选航线</strong>
            <a class="more-link" href="{$cmsurl}ship/all">更多<i class="more-link-icon"></i></a>
        </div>
        <ul class="ship-line-wrapper">
            {st:ship action="query" flag="order" row="5" return="shiplist"}

            {loop $shiplist $ship}
            <li>
                <a class="item-a clearfix" href="{$ship['url']}">
                    <div class="pic"><img src="{$defaultimg}" st-src="{Common::img($ship['litpic'],235,160)}" alt="{$ship['title']}" /></div>
                    <div class="info">
                        <div class="name">{Common::cutstr_html($ship['title'],30)}</div>
                        {if $ship['starttime']||$ship['startcity_name']}
                        <div class="star">出发地：{if !empty($ship['starttime'])}{date('m月d日',$ship['starttime'])}，{/if}{if !empty($ship['startcity_name'])}{$ship['startcity_name']}{/if}</div>
                        {/if}
                        <div class="data">
                            {if !empty($ship['finaldest_name'])}
                            <p class="mdd">目的地：{$ship['finaldest_name']}</p>
                            {/if}
                            {if $ship['price']}
                            <span class="pri"><em class="no-style">{Currency_Tool::symbol()}<b class="no-style">{$ship['price']}</b></em>起/人</span>
                            {else}
                            <span class="pri"><em class="no-style"><b class="no-style">电询</b></em></span>
                            {/if}
                        </div>
                    </div>
                </a>
            </li>
            {/loop}

        </ul>
    </div>
    <!-- 精选航线 -->
{request 'pub/code'}

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