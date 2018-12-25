<?php defined('SYSPATH') or die();?><!doctype html>
<html>
<head>
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
    {Common::css('swiper.min.css,base.css,,reset-style.css,lib-flexible.js')}
    {Common::css_plugin('m_ship.css','ship')}
    {Common::js('lib-flexible.js,Zepto.js,swiper.min.js,jquery.min.js,delayLoading.min.js')}
</head>

<body>

{request "pub/header_new/typeid/$typeid/islistpage/1"}
    <!-- 公用顶部 -->

    <div class="ship-tip-container">
        <div class="tip-pic-box">
            <img src="{Common::img($info['litpic'],750,312)}" alt="{$info['title']}" title="{$info['title']}">
        </div>
        <div class="tip-pic-tit">{$info['title']}</div>
        <div class="ship-cs-item">
            <h3 class="show-tit-bar"><strong class="bt no-style">参数</strong></h3>
            <ul class="cs-list clearfix">
                <li>吨位：{$info['weight']}吨</li>
                <li>载客量：{$info['seatnum']}人</li>
                <li>船体长度：{$info['length']}米</li>
                <li>船体宽度：{$info['width']}米</li>
                <li>船速：{$info['speed']}节</li>
                <li>甲板楼层：{$info['floornum']}层</li>
                <li>首航时间：{$info['sailtime']}年</li>
            </ul>
        </div>
        <div class="ship-txt-item">
            <h3 class="show-tit-bar"><strong class="bt no-style">游轮简介</strong></h3>
            <div class="ship-txt-wrap">
                <div class="txt-box">
                    {$info['content']}
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
                {st:ship action="room_kind" shipid="$info['id']"  row="100" return="roomkinds"}
                {php}$roomnum = count($roomkinds){/php}
                <li class="swiper-slide">
                    <a class="item-a" href="{$cmsurl}ship/roomlist_{$info['id']}.html">
                        <div class="pic">
                            <img src="{Common::img(Model_Ship::get_facility_litpic($info['id']),190,190)}" alt="{$info['title']}" />
                        </div>
                        <div class="info">
                            <strong class="type no-style">邮轮舱房</strong>
                            <em class="num no-style">共{$roomnum}类</em>
                        </div>
                    </a>
                </li>
                {st:ship action="facility_kind" shipid="$info['id']" row="100" return="facilitykinds"}
                {loop $facilitykinds $kind}
                {st:ship action="facility" shipid="$info['id']" kindid="$kind['id']" row="100" return="facilities"}
                {php}$num = count($facilities){/php}
                <li class="swiper-slide">
                    <a class="item-a" href="{$cmsurl}ship/facility/aid/{$info['id']}/kindid/{$kind['id']}.html">
                        <div class="pic">
                            <img src="{Common::img(Model_Ship::get_facility_litpic($info['id'],$kind['id']),190,190)}" alt="{$kind['title']}" />
                        </div>
                        <div class="info">
                            <strong class="type no-style">{$kind['title']}</strong>
                            <em class="num no-style">共{$num}类</em>
                        </div>
                    </a>
                </li>
                {/loop}
                {/st}
            </ul>
        </div>
    </div>
    <!-- 设施介绍 -->
    
    <div class="ship-line-container">
        <div class="ship-tit-bar">
            <strong class="bt no-style">精选航线</strong>
            <a class="more-link" href="{$cmsurl}ship/all-0-0-0-0-{$info['id']}-0-1">更多<i class="more-link-icon"></i></a>
        </div>
        <ul class="ship-line-wrapper">
            {st:ship action="query" flag="byship" shipid="$info['id']" row="6" return="sublines"}
            {loop $sublines $line}
            <li>
                <a class="item-a clearfix" href="{$line['url']}">
                    <div class="pic"><img src="{$defaultimg}" st-src="{Common::img($line['litpic'],235,160)}" alt="{$line['title']}" title="{$line['title']}" /></div>
                    <div class="info">
                        <div class="name">{$line['title']}</div>
                        {if $line['starttime']||$line['startcity_name']}
                        <div class="star">出发地：{if !$line['starttime']}{date('m月d日',$line['starttime'])}，{/if}{if !empty($line['startcity_name'])}{$line['startcity_name']}{/if}</div>
                        {/if}
                        <div class="data">
                            {if !empty($line['finaldest_name'])}
                            <p class="mdd">目的地：{$line['finaldest_name']}</p>
                            {/if}
                            {if $line['price']}
                            <span class="pri"><em class="no-style">{Currency_Tool::symbol()}<b class="no-style">{$line['price']}</b></em>起/人</span>
                            {else}
                            <span class="pri"><em class="no-style"><b class="no-style">电询</b></em></span>
                            {/if}
                        </div>
                    </div>
                </a>
            </li>
            {/loop}
            {/st}

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