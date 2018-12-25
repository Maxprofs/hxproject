<!DOCTYPE html>
<html lang="en">
<head div_body=ZvBCXC >
    <meta charset="UTF-8">
    <title>{if $info['seotitle']}{$info['seotitle']}{else}{$info['title']}{/if}-{$GLOBALS['cfg_webname']}</title>
    {if $info['keyword']}
    <meta name="keywords" content="{$info['keyword']}" />
    {/if}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {if $info['description']}
    <meta name="description" content="{$info['description']}" />
    {/if}
    {Common::css('base.css,swiper.min.css')}
    {Common::css_plugin('m_theme.css','zt')}
    {Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,delayLoading.min.js,layer/layer.m.js')}
</head>
<body style="{if $info['bgimage']}background-image:url('{$info['bgimage']}');{/if}{if $info['bgcolor']}background-color:{$info['bgcolor']};{/if}{if $info['bgrepeat']}background-repeat:repeat{else}background-repeat:no-repeat{/if}">

{request "pub/header_new/default_tpl/header_new2/definetitle/".urlencode('专题详情')}
<!-- 公用顶部 -->

<div class="theme-content">
    <div class="float-nav-box">
        <div class="float-nav swiper-container swiper-container-horizontal">
            <ul class="clearfix swiper-wrapper">
                {if $info['introduce']}
                <li class="swiper-slide on"><a href="javascript:void(0)">{$info['title']}</a></li>
                {/if}
                {loop $channellist $k $channel}
                {if in_array($channel['kindtype'],array(1,2,3))}
                <li class="swiper-slide {if !$info['introduce'] && $k==0}on{/if}"><a href="javascript:void(0)">{$channel['title']}</a></li>
                {/if}
                {/loop}
            </ul>
        </div>
    </div>

    <div class="banners">
        <a href="javascript:void(0)">
            <img src="{if $info['m_banner']}{$info['m_banner']}{else}/plugins/zt/public/mobile/images/banner.png{/if}" alt="" />
        </a>
    </div>

    <div class="float-contents">
        {if $info['introduce']}
        <div class="float-item theme-sale-wrap">
            <div class="float-item-tit theme-sale-tit">
                <span class="bt"><strong>{$info['title']}</strong></span>
            </div>
            <div class="float-item-con">
                <div class="theme-sale-con">
                    <div class="theme-sale-msg">
                        {Product::strip_style($info['introduce'])}
                    </div>
                </div>
            </div>
        </div>
        <!-- 主题游特惠专享 -->
        {/if}
        {loop $channellist $channel}
        {if $channel['kindtype']==1}
        <div class="float-item">
            <div class="float-item-tit">
                <span class="bt"><strong>{$channel['title']}</strong></span>
            </div>
            <div class="float-item-con coupon-con">
                <div class="float-con-msg">
                    {Product::strip_style($channel['introduce'])}
                </div>
                <div class="coupon-con-slide swiper-container swiper-container-horizontal">
                    <ul class="swiper-wrapper clearfix" >
                        {loop $channel['productlist'] $coupon}
                        <li class="{if $coupon['status']==2}end{/if} swiper-slide get_coupon" data-couponid="{$coupon['id']}">
                            <a href="javascript:void(0)" class="clearfix">
                                <div class="coupon-info">
                                    <div class="coupon-price">{Currency_Tool::symbol()}<span>{$coupon['amount']}</span></div>
                                    <strong class="coupon-type">{$coupon['name']}</strong>
                                    <div class="coupon-txt">(满{$coupon['samount']}可用{if $coupon['typeid']==0},无品类限制{else},仅限{$coupon['typename']}部分产品{/if})</div>
                                </div>
                                <div class="coupon-btn" ><span>立即领取</span></div>
                            </a>
                        </li>
                        {/loop}
                    </ul>
                    <input type="hidden" id="fromurl" value="{}"/>
                </div>
            </div>
        </div>
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
                                layer.open({
                                    content: data.msg,
                                    time: 2,
                                    shade:false,
                                    style: 'background: rgba(0,0,0,.5); border: none; color:#fff;',
                                    end:function(){

                                    }
                                });
                            }
                            // get success
                            if(data.status==1)
                            {
                                layer.open({
                                    content: data.msg,
                                    time: 2,
                                    shade:false,
                                    style: 'background: rgba(0,0,0,.5); border: none; color:#fff;',
                                    end:function(){
                                        window.location.href=SITEURL+'member/login';
                                    }
                                });
                            }
                            // no more
                            if(data.status==2)
                            {
                                layer.open({
                                    content: data.msg,
                                    time: 2,
                                    shade:false,
                                    style: 'background: rgba(0,0,0,.5); border: none; color:#fff;',
                                    end:function(){

                                    }
                                });
                            }
                        }
                    })
                })
            })
        </script>
        <!-- 优惠券 -->
        {/if}
        {if $channel['kindtype']==2}
        <div class="float-item">
            <div class="float-item-tit">
                <span class="bt"><strong>{$channel['title']}</strong></span>
            </div>
            <div class="float-item-con">
                <div class="float-con-msg">
                    {Product::strip_style($channel['introduce'])}
                </div>
                <div class="float-product-list">
                    <ul class="clearfix">
                        {loop $channel['productlist'] $p}
                        {if $p['typeid']==13}
                        <li class="{if $p['endtime']>time()&& $p['totalnum']} {if $p['starttime']>time()}no-begin{else}{/if}{else}over{/if}">
                            <a href="{$p['url']}">
                                <div class="pic">
                                    <img src="{$defaultimg}" st-src="{Common::img($p['litpic'])}" alt="{$p['title']}"/>
                                    {if $p['endtime']>time() && $p['totalnum']}
                                    <div class="tuan-time">
                                        <span class="time" start-time="{$p['starttime']}" end-time="{$p['endtime']}">
                                            <span class="sy"></span>
                                            <span class="count"></span>
                                         </span>
                                    </div>
                                    {/if}
                                </div>
                                <div class="info">
                                    <h3 class="tit">{$p['title']}</h3>
                                    <div class="data">
                                        <div class="price-box">
                                            <span class="price">{if !empty($p['price'])}{Currency_Tool::symbol()}<em>{$p['price']}</em>起{else}电询{/if}</span>
                                        </div>
                                        <div class="order-btn"><span>
                                        {if $p['endtime']>time() && $p['totalnum'] }
                                        {if $p['starttime']>time()}即将开抢{else}立即抢购{/if}
                                        {else}
                                        抢光了
                                        {/if}</span></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        {else}
                        <li>
                            <a href="{$p['url']}">
                                <div class="pic">
                                    <img src="{$defaultimg}" st-src="{Common::img($p['litpic'])}" alt="{$p['title']}" />
                                    <!--<div class="pic-data">
                                        <div class="item"><span>320人出行</span></div>
                                        <div class="item"><span>100%满意度</span></div>
                                    </div>-->
                                </div>
                                <div class="info">
                                    <h3 class="tit">{$p['title']}</h3>
                                    <div class="data">
                                        <div class="price-box">
                                            <span class="price">{if !empty($p['price'])}{Currency_Tool::symbol()}<em>{$p['price']}</em>起{else}电询{/if}</span>
                                        </div>
                                        <div class="order-btn"><span>{if in_array($p['typeid'],array(105,114))}马上报名{else}立即预订{/if}</span></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        {/if}
                        {/loop}
                    </ul>
                </div>
                {if $channel['moreurl']}
                <div class="more-btn"><a href="{$channel['moreurl']}">查看更多 ></a></div>
                {/if}
            </div>
        </div>
        <!-- 热卖爆款  精选线路 -->
        {/if}
        {if $channel['kindtype']==3}
        <div class="float-item">
            <div class="float-item-tit">
                <span class="bt"><strong>{$channel['title']}</strong></span>
            </div>
            <div class="float-item-con other-con">
                <div class="float-con-msg">
                    {Product::strip_style($channel['introduce'])}
                </div>
                <div class="float-product-list">
                    <ul class="clearfix">
                        {loop $channel['productlist'] $p}
                        <li>
                            <a href="{$p['url']}">
                                <div class="pic">
                                    <img src="{$defaultimg}" st-src="{Common::img($p['litpic'])}" alt="{$p['title']}"/>
                                </div>
                                <div class="info">
                                    <h3 class="tit">{$p['title']}</h3>
                                </div>
                            </a>
                        </li>
                        {/loop}
                    </ul>
                </div>
                {if $channel['moreurl']}
                <div class="more-btn"><a href="{$channel['moreurl']}">查看更多 ></a></div>
                {/if}
            </div>
        </div>
        <!-- 相册/攻略 -->
        {/if}
        {/loop}
    </div>

</div>

{request "pub/code"}
{request "pub/footer/default_tpl/footer2"}
{Common::js_plugin('floatmenu.js','zt')}
<script type="text/javascript">
    $(function(){
        $("html,body").css("height", "100%");

        //头部下拉导航
        $(".st-user-menu").on("click", function() {
            $(".header-menu-bg,.st-down-bar").show();
            $("body").css("overflow", "hidden");
        });

        $(".header-menu-bg").on("click", function() {
            $(".header-menu-bg,.st-down-bar").hide();
            $("body").css("overflow", "auto");
        });

        //floatMenu导航
        $.floatMenu({
            menuContain: '.float-nav',
            tabItem: 'li',
            chooseClass: 'on',
            contentContain: '.float-contents',
            itemClass: '.float-item'
        });

        //导航标题
        var swiper01 = new Swiper('.float-nav', {
            slidesPerView: 'auto'
        });

        //领取优惠券
        var swiper02 = new Swiper('.coupon-con-slide', {
            slidesPerView: 'auto'
        });

        $('.tuan-time').find('.time').each(function (index, element) {

            show_count(element);
        });
        function show_count(node) {
            var endTime = $(node).attr('end-time') * 1000;
            var startTime = $(node).attr('start-time') * 1000;
            var timer_rt = window.setInterval(function () {
                var time=0;
                var now = new Date();
                now = now.getTime();
                if (startTime > now) {
                    time = startTime - now;
                    $(node).find('.sy').html('距离开始');
                } else if (endTime > now) {
                    time = endTime - now;
                    $(node).find('.sy').html('剩余');
                } else {
                    clearInterval(timer_rt);
                }
                time = parseInt(time / 1000);
                var day = Math.floor(time / (60 * 60 * 24));
                var hour = Math.floor((time - day * 24 * 60 * 60) / 3600);
                var minute = Math.floor((time - day * 24 * 60 * 60 - hour * 3600) / 60);
                var html = '';
                if (day > 0) {
                    html += day + '天';
                }
                if (hour > 0) {
                    html += hour + '时';
                }
                if (minute > 0) {
                    html += minute + '分';
                }
                html += time%60 + '秒';

                if(day==0 && hour==0 && minute==0 && time%60==0){
                    window.location.reload();
                }
                $(node).find('.count').html(html);
            }, 1000);
        }


    });
</script>
</body>
</html>