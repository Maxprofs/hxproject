<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {php echo Common::css('base.css,swiper.min.css,reset-style.css');}
    {Common::css_plugin('line.css','line')}
    {php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,delayLoading.min.js');}
</head>
<body>

    {request "pub/header_new/typeid/$typeid"}

    <div class="swiper-container st-focus-banners" >
        <ul class="swiper-wrapper">
            {st:ad action="getad" name="s_line_index_1"}
                {loop $data['aditems'] $v}
                 <li class="swiper-slide">
                    <a class="item" href="{$v['adlink']}"><img class="swiper-lazy" data-src="{Common::img($v['adsrc'],750,260)}" title="{$v['adname']}" alt="{$v['adname']}" /></a>
                    <div class="swiper-lazy-preloader"></div>
                </li>
                {/loop}
            {/st}
        </ul>
        <div class="swiper-pagination ad-pagination"></div>
    </div>
    <!--轮播图-->

    <div class="st-search">
        <div class="st-search-box">
            <input type="text" class="st-search-text keyword" placeholder="搜索{$channelname}" />
            <input type="button" class="st-search-btn search" value="" />
        </div>
    </div>
    <!--搜索-->

    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">{$channelname}推荐</span>
        </h3>
        <div class="swiper-container st-hot-line">
            <ul class="swiper-wrapper">
                {st:line action="query" flag="order" row="4"}
                    {loop $data $row}
                        <li class="swiper-slide">
                            <a class="item" href="{$row['url']}" title="{$row['title']}">
                                <div class="pic"><img class="swiper-lazy" data-src="{Common::img($row['litpic'],312,212)}" /></div>
                                <div class="info">
                                    <div class="tit">
                                        <span class="city">{if !empty($row['startcity'])}[{$row['startcity']}]{/if}</span>
                                        {if $row['color']}
                                        <span style="color:{$row['color']}">{$row['title']}</span>
                                        {else}{$row['title']}{/if}
                                    </div>
                                    <div class="attr">
                                        {loop $row['attrlist'] $v}
                                            <span class="label">{$v['attrname']}</span>
                                        {/loop}
                                    </div>
                                    <div class="price">
                                        {if !empty($row['price'])}
                                         <span class="jg"><i class="currency_sy no-style">{Currency_Tool::symbol()}</i><span class="num">{$row['price']}</span>起</span>
                                        {else}
                                        <span class="jg"><span class="num">电询</span></span>
<!--                                          <span class="dx">电询</span>-->
                                        {/if}
                                    </div>
                                 </div>
                            </a>
                            <div class="swiper-lazy-preloader"></div>
                        </li>
                    {/loop}
                {/st}
            </ul>
            <div class="swiper-pagination hot-pagination"></div>
        </div>
    </div><!--产品推荐-->

    {st:dest action="query" flag="channel_nav" typeid="1" row="3"}
    {loop $data $row}
    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">{$row['kindname']}</span>
        </h3>
        <ul class="st-list-block clearfix">
            {st:line action="query" flag="mdd" destid="$row['id']" return="list" row="4"}
                {loop $list $h}
                <li>
                    <a class="item" href="{$h['url']}">
                        <div class="pic"><img src="{$defaultimg}" st-src="{Common::img($h['litpic'],330,225)}" alt="{$h['title']}" /></div>
                        <div class="tit double">{$h['title']}</div>
                        <div class="price">
                            {if !empty($h['price'])}
                             <span class="jg"><i class="currency_sy no-style">{Currency_Tool::symbol()}</i><span class="num">{$h['price']}</span>起</span>
                            {else}
                            <span class="jg"><span class="num">电询</span></span>
                            {/if}
                        </div>
                    </a>
                </li>
                {/loop}
            {/st}
        </ul>
        <div class="st-more-bar">
            <a class="more-link" href="{$cmsurl}lines/{$row['pinyin']}/">查看更多</a>
        </div>
    </div>
    {/loop}
    {/st}

    {request 'pub/code'}
    {request 'pub/footer'}
    <script>
        $(function(){

            //线路栏目页滚动广告
            var adSwiper = new Swiper('.st-focus-banners', {
                autoplay: 5000,
                pagination : '.ad-pagination',
                lazyLoading : true,
                observer: true,
                observeParents: true
            });

            //线路栏目页推荐产品
            var hotSwiper = new Swiper('.st-hot-line', {
                autoplay: 5000,
                pagination : '.hot-pagination',
                lazyLoading : true,
                observer: true,
                observeParents: true
            });

            $('.search').click(function(){
                var keyword = $('.keyword').val();
                var url = SITEURL + 'lines/all';

                if(keyword!=''){
                    url+="?keyword="+encodeURIComponent(keyword);
                }
                window.location.href = url;
            })

        })
    </script>

</body>
</html>
