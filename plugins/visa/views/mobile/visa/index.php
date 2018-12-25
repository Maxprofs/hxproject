<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head head_script=FZzCXC >
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {php echo Common::css('base.css,swiper.min.css');}
    {Common::css_plugin('visa.css','visa')}
    {php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,common.js,delayLoading.min.js');}
</head>

    {request "pub/header_new/typeid/$typeid/islistpage/1"}

    <div class="swiper-container st-focus-banners" >
        <ul class="swiper-wrapper">
            {st:ad action="getad" name="s_visa_index_1"}
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
        <div class="st-search-box" id="search">
            <input type="text" class="st-search-text" placeholder="国家/地区" />
            <input type="button" class="st-search-btn" value="" />
        </div>
    </div>
    <!--搜索-->

    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">热门国家/地区</span>
        </h3>
        <ul class="st-hot-visa clearfix">
        {st:visa action="area" flag="hot" row="6"}
            {loop $data $v}
                <li>
                    <a class="item" href="{$v['url']}">
                        <img src="{$defaultimg}" st-src="{Common::img($v['litpic'],210,142)}" />
                        <span class="name">{$v['kindname']}</span>
                    </a>
                </li>
            {/loop}
        {/st}
        </ul>
        <div class="st-more-bar">
            <a class="more-link" href="/phone/visa/all/">查看更多</a>
        </div>
    </div>

    <div class="flow-path-container">
        <div class="flow-path-bar">
            <h3 class="flow-path-tit">签证办理，快人一步</h3>
            <p class="flow-path-txt">省时 · 省事 · 省心 · 省力</p>
        </div>
        <div class="path-wrapper">
            <ul class="path-list">
                <li class="item">
                    <i class="icon1"></i>
                    <span class="node">提交签证材料</span>
                </li>
                <li class="item">
                    <i class="icon2"></i>
                    <span class="node">审核材料</span>
                </li>
                <li class="item">
                    <i class="icon3"></i>
                    <span class="node">送签(面试)</span>
                </li>
                <li class="item">
                    <i class="icon4"></i>
                    <span class="node">签证</span>
                </li>
            </ul>
            <div class="path-end"><i class="e-icon"></i>出签成功率99.8%</div>
        </div>
    </div>

    {request 'pub/code'}
    {request 'pub/footer'}

    <script type="text/javascript">

        $(function(){

            //签证栏目页滚动广告
            var adSwiper = new Swiper('.st-focus-banners', {
                autoplay: 5000,
                pagination : '.ad-pagination',
                lazyLoading : true,
                observer: true,
                observeParents: true
            });

            $('#search').find('input').focus(function(){

            });

            $('.st-search-btn').click(function(){
                var city = $('.st-search-text').val();
                if(city == ''){
                    $('.st-search-text').focus();
                }else{
                    window.location.href=SITEURL+'visa/all?country='+encodeURIComponent(city);
                }
            })

        })

    </script>

<body>
</body>
</html>
