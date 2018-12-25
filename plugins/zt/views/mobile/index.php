<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{if $info['seotitle']}{$info['seotitle']}{else}{$info['title']}{/if}-{$GLOBALS['cfg_webname']}</title>
    {if $info['keyword']}
    <meta name="keywords" content="{$info['keyword']}" />
    {/if}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {if $info['description']}
    <meta name="description" content="{$info['description']}" />
    {/if}
    {Common::css_plugin('m_theme.css','zt')}
    {Common::css('base.css,swiper.min.css,style-new.css')}
    {Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,delayLoading.min.js,jquery.layer.js')}

</head>
<body>

{request "pub/header_new/definetitle/".$info['title']}
<!-- 公用顶部 -->

<div class="theme-page-content" {if $info['bgimage']} style="background:url('{$info['bgimage']}') center repeat" {elseif $info['bgcolor']}style="background:{$info['bgcolor']}"{/if} >

<div class="theme-img-block">
    {if $info['m_banner']}
    <img src="{Common::img($info['m_banner'])}" />
    {else}
    <img src="{$GLOBALS['cfg_plugin_zt_public_full_url']}images/theme-top-bg.png" />
    {/if}
</div>
<!-- 顶部图片 -->

<div class="tehui-container">
    <h3 class="tehui-tit"><strong>{$info['title']}</strong></h3>
    <div class="tehui-wrap">
        <div class="top-block"></div>
        <div class="mid-block">
            {Product::strip_style($info['introduce'])}
        </div>
        <div class="bom-block"></div>
    </div>
</div>
<!-- 特惠专享 -->
{loop $channellist $channel}
{if $channel['kindtype']==1}
<div class="theme-container">
    <div class="theme-tit">
        <h3 class="bt"><strong>{$channel['title']}</strong></h3>
        <div class="txt">{Product::strip_style($channel['introduce'])}</div>
    </div>
    <div class="get-slide-block swiper-container">
        <ul class="get-slide-list swiper-wrapper clearfix">
            {loop $channel['productlist'] $coupon}
            <li class="swiper-slide">
                {if $coupon['status']==2}<i class="over-icon"></i>{/if}
                <span class="num">&yen;<em>{$coupon['amount']}</em></span>
                <span class="pri">满&yen;{$coupon['samount']}可用</span>
                <a href="javascript:;" class="get get_coupon" data-couponid="{$coupon['id']}">立即领取</a>
            </li>
            {/loop}

        </ul>
        <input type="hidden" id="fromurl" value="{}"/>
    </div>
</div>
<!-- 领福利 -->
<script>
    $(function(){
        $('.get_coupon').click(function(){
            var couponid = $(this).attr('data-couponid');
            $.ajax({
                type: 'POST',
                url: SITEURL + 'coupon/ajxa_get_coupon',
                data: {cid:couponid},
                async: false,
                dataType: 'json',
                success: function (data) {
                    //has get one or more
                    if(data.status==0)
                    {

                        $.layer({
                            type:1,
                            icon:2,
                            text:data.msg,
                            time:1000
                        })
                    }
                    // get success
                    if(data.status==1)
                    {
                        $.layer({
                            type:1,
                            icon:2,
                            text:data.msg,
                            time:1000
                        })
                        setTimeout(function(){
                            var url = SITEURL+'member/login';
                            window.location.href=url;
                        },1000);

                    }
                    // no more
                    if(data.status==2)
                    {
                        $.layer({
                            type:1,
                            icon:1,
                            text:data.msg,
                            time:1000
                        })
                        setTimeout(function(){
                            //window.location.reload();
                        },1000);
                    }
                }
            })
        })
    })
</script>
{/if}
{if $channel['kindtype']==2}
<div class="theme-container">
    <div class="theme-tit">
        <h3 class="bt"><strong>{$channel['title']}</strong></h3>
        <div class="txt">{Product::strip_style($channel['introduce'])}</div>
    </div>

    <div class="theme-wrap">
        <ul class="theme-list clearfix">
            {loop $channel['productlist'] $p}
            <li>
                <a class="item-a" href="{$p['url']}" target="_blank">
                    <span class="pic"><img src="{$defaultimg}" st-src="{Common::img($p['litpic'])}" alt="{$p['title']}" /></span>
                    <span class="bt">{$p['title']}<em>{$p['sellpoint']}</em></span>
                    <p class="num">
                        <span class="jg">{if !empty($p['price'])}{Currency_Tool::symbol()}<em>{$p['price']}</em>起{else}电询{/if}</span>
                        {if $p['sellprice']}
                        <del class="yj">原价:{Currency_Tool::symbol()}{$p['sellprice']}</del>
                        {/if}
                    </p>
                </a>
            </li>
            {/loop}
        </ul>
        {if $channel['moreurl']}
        <div class="more-item"><a class="more-link" href="{$channel['moreurl']}" target="_blank">查看更多</a></div>
        {/if}
    </div>
</div>
<!-- 推荐线路 -->
{/if}
{if $channel['kindtype']==3}
<div class="theme-container">
    <div class="theme-tit">
        <h3 class="bt"><strong>{$channel['title']}</strong></h3>
        <div class="txt">{Product::strip_style($channel['introduce'])}</div>
    </div>
    <div class="theme-wrap">
        <ul class="theme-list clearfix">
            {loop $channel['productlist'] $p}
            <li>
                <a class="item-a" href="{$p['url']}" target="_blank">
                    <em class="attr">{$p['typename']}</em>
                    <span class="pic"><img src="{$defaultimg}" st-src="{Common::img($p['litpic'])}" alt="{$p['title']}" /></span>
                    <p class="tit">{$p['title']}</p>
                    <p class="txt">{$p['summary']}</p>
                </a>
            </li>
            {/loop}
        </ul>
        {if $channel['moreurl']}
        <div class="more-item"><a class="more-link" href="{$channel['moreurl']}" target="_blank">查看更多</a></div>
        {/if}
    </div>
</div>

{/if}
{/loop}



</div>

{request "pub/code"}
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

    var swiper = new Swiper('.get-slide-block', {
        slidesPerView: 3.4
    });

</script>

</body>
</html>