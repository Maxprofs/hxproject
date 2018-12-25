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
{Common::css('base.css,swiper.min.css,reset-style.css')}
{Common::css_plugin('hotel.css','hotel')}
{Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,delayLoading.min.js')}

</head>
<body bottom_float=Yg2qek >

    {request "pub/header_new/typeid/$typeid"}
    
    <div class="swiper-container st-focus-banners">
        <ul class="swiper-wrapper">
            {st:ad action="getad" name="s_hotel_index_1"}
            {loop $data['aditems'] $v}
            <li class="swiper-slide">
                <a class="item" href="{$v['adlink']}"><img class="swiper-lazy" data-src="{Common::img($v['adsrc'],750,260)}" title="{$v['adname']}" alt="{$v['adname']}"></a>
                <div class="swiper-lazy-preloader"></div>
            </li>
            {/loop}
            {/st}
        </ul>
        <div class="swiper-pagination"></div>
    </div>
    <!--轮播图-->

    {if Plugin_Productmap::_is_installed()}
    <div class="st-search">
        <div class="st-search-box">
            <input type="text" class="st-search-text keyword"  placeholder="搜索{$channelname}" />
            <input type="button" class="st-search-btn search" value="" />
        </div>
        <!--搜索-->
        <a class="map-near" href="//{$GLOBALS['main_host']}/plugins/productmap/hotel/mapnear"></a>
    </div>
    {else}
    <div class="st-search">
        <div class="st-search-box">
            <input type="text" class="st-search-text keyword"  placeholder="搜索{$channelname}" />
            <input type="button" class="st-search-btn search" value="" />
        </div>
        <!--搜索-->
    </div>
    {/if}

    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">{$channelname}推荐</span>
        </h3>
        <div class="swiper-container st-hot-hotel">
            <ul class="swiper-wrapper">
                {st:hotel action="query" flag="order" row="3"}
                {loop $data $row}
                <li class="swiper-slide">
                    <a class="item" href="{$row['url']}">
                        <div class="pic"><img src="{$defaultimg}" st-src="{Common::img($row['litpic'],312,212)}" /></div>
                        <div class="info">
                            <div class="tit">{$row['title']}</div>
                            <div class="attr">
                                {loop $row['attrlist'] $v}
                                <span class="label">{$v['attrname']}</span>
                                {/loop}
                            </div>
                            <div class="price">
                                {if !empty($row['price'])}
                                <span class="jg"><i class="currency_sy no-style">{Currency_Tool::symbol()}</i><span class="num">{$row['price']}</span>起</span>
                                {else}
                                <span class="dx">电询</span>
                                {/if}
                                {if !empty($row['sellprice'])}
                                <span class="del">原价：{$row['sellprice']}元</span>
                                {/if}
                            </div>
                        </div>
                    </a>
                </li>
                {/loop}
                {/st}
            </ul>
            <div class="swiper-pagination hot-pagination"></div>
        </div>
    </div>
    <!--产品推荐-->

    {st:dest action="query" flag="channel_nav" typeid="2" row="3"}
    {loop $data $row}
    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">{$row['kindname']}</span>
        </h3>
        <ul class="st-list-block clearfix">
            {st:hotel action="query" flag="mdd" destid="$row['id']" return="list" row="4"}
            {loop $list $h}
            <li>
                <a class="item" href="{$h['url']}">
                    <div class="pic"><img src="{$defaultimg}" st-src="{Common::img($h['litpic'],330,225)}" alt="{$h['title']}" /></div>
                    <div class="tit">{$h['title']}</div>
                    <div class="price">
                        {if !empty($h['price'])}
                        <span class="jg"><i class="currency_sy no-style">{Currency_Tool::symbol()}</i><span class="num">{$h['price']}</span>起</span>
                        {else}
                        <span class="dx">电询</span>
                        {/if}
                    </div>
                </a>
            </li>
            {/loop}
        </ul>
        <div class="st-more-bar">
            <a class="more-link" href="{$cmsurl}hotels/all/">查看更多</a>
        </div>
    </div>
    <!--周边酒店-->
    {/loop}
    {/st}

  {request "pub/code"}
  {request "pub/footer"}

  <script>
      $(function(){

        //酒店栏目页滚动广告
        var mySwiper = new Swiper('.st-focus-banners', {
            autoplay: 5000,
            pagination : '.swiper-pagination',
            lazyLoading : true,
            observer: true,
            observeParents: true
        });

        //酒店栏目页推荐产品
        var hotSwiper = new Swiper('.st-hot-hotel', {
            autoplay: 5000,
            pagination : '.hot-pagination',
            observer: true,
            observeParents: true
        });

        $('.search').click(function(){
            var keyword = $(".keyword").val();
            var url = SITEURL + 'hotels/all';

            if(keyword!=''){
              url+="?keyword="+encodeURIComponent(keyword);
            }
            window.location.href = url;
        })

      })
  </script>

</body>
</html>
