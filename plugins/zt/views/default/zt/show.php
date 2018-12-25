<!doctype html>
<html>
<head html_div=4vBCXC >
    <meta charset="utf-8">
    <title>{if $info['seotitle']}{$info['seotitle']}{else}{$info['title']}{/if}-{$GLOBALS['cfg_webname']}</title>
    {if $info['keyword']}
    <meta name="keywords" content="{$info['keyword']}" />
    {/if}
    {if $info['description']}
    <meta name="description" content="{$info['description']}" />
    {/if}
    {include "pub/varname"}
    {Common::css('base.css')}
    {Common::css_plugin('pc_theme.css,pc_header.css','zt')}
    {Common::js('jquery.min.js,base.js,SuperSlide.min.js,jquery.validate.js,jquery.validate.addcheck.js,delayLoading.min.js,common.js,login.js')}
</head>

<body>
{include "zt/ztheader"}
<div class="theme-container">
    <div class="theme-top-wrap" style="background:url('{if $info['pc_banner']}{$info['pc_banner']}{else}/plugins/zt/public/images/banner.png{/if}') center no-repeat"></div>
    <!-- 顶部背景 -->
    <div class="theme-main-area" style="{if $info['bgimage']}background-image:url('{$info['bgimage']}');{else}background-image:none;{/if}{if $info['bgcolor']}background-color:{$info['bgcolor']};{/if}{if $info['bgrepeat']}background-repeat:repeat{else}background-repeat:no-repeat{/if}">
        <div class="wm-1200">
            {if $info['introduce']}
            <div class="theme-sale-wrap">
                <h3 class="theme-sale-tit"><strong class="bt">{$info['title']}</strong></h3>
                <div class="theme-sale-block">
                    <div class="theme-hd"></div>
                    <div class="theme-md">
                        {$info['introduce']}
                    </div>
                    <div class="theme-bd"></div>
                </div>
            </div>
            <!-- 特惠专享 -->
            {/if}
            {loop $channellist $channel}
            {if $channel['kindtype']==1}
            <div class="theme-item-box">
                <div class="theme-item-tit">
                    <h3 class="bar"><span class="bt">{$channel['title']}</span></h3>
                    <div class="txt">
                        {$channel['introduce']}
                    </div>
                </div>
                <div class="theme-coupon-item" id="theme-coupon-item">
                    <a class="prev" href="javascript:;"></a>
                    <a class="next" href="javascript:;"></a>
                    <div class="bd">
                        <ul class="clearfix">
                            {loop $channel['productlist'] $coupon}
                            <li {if $coupon['status']==2}class="end"{/if}>
                            <div class="info">
                                <span class="pri">&yen;<span class="num">{$coupon['amount']}</span></span>
                                <span class="type">{$coupon['name']}</span>
                                <span class="txt">(满{$coupon['samount']}可用{if $coupon['typeid']==0},无品类限制{else},仅限{$coupon['typename']}部分产品{/if})</span>
                            </div>
                            <a href="javascript:;" class="get get_coupon" data-couponid="{$coupon['id']}">立即领取</a>
                            </li>
                            {/loop}
                        </ul>
                        {Common::js('layer/layer.js',0)}
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
                                            if(data.status==0)
                                            {
                                                layer.msg(data.msg, {icon: 5});
                                            }
                                            if(data.status==1)
                                            {
                                                //show login box
                                                $('#is_login_order').removeClass('hide');

                                            }
                                            if(data.status==2)
                                            {
                                                layer.msg(data.msg, {icon: 6,time: 1000},function(){
                                                    window.location.reload();
                                                });
                                            }
                                        }
                                    })
                                })
                            })
                        </script>
                    </div>
                </div>
            </div>
            <!-- 优惠券 -->
            {/if}
            {if $channel['kindtype']==2}
            <div class="theme-item-box">
                <div class="theme-item-tit">
                    <h3 class="bar"><span class="bt">{$channel['title']}</span></h3>
                    <div class="txt">
                        {$channel['introduce']}
                    </div>
                </div>
                <div class="theme-product-item">
                    <ul class="clearfix">
                        {loop $channel['productlist'] $p}
                        {if $p['typeid']==13}
                        <li class="{if $p['endtime']>time()&& $p['totalnum']} {if $p['starttime']>time()}load{else}ing{/if}{else}end{/if}">
                            <a class="pic" href="{$p['url']}" target="_blank">
                                <img src="{Product::get_lazy_img()}" st-src="{Common::img($p['litpic'],285,190)}" alt="{$p['title']}" width="285" height="190"  />
                                {if $p['endtime']>time() && $p['totalnum']}
                                <div class="date tuan_item" start-time="{$p['starttime']}" end-time="{$p['endtime']}">
                                    <span class="sy"></span>
                                    <span class="time"></span>
                                </div>
                                {/if}
                            </a>
                            <div class="info">
                                <a class="tit" href="{$p['url']}" target="_blank">{$p['title']}</a>
                                <div class="fix">
                                    <span class="pri">{if !empty($p['price'])}{Currency_Tool::symbol()}<span class="num">{$p['price']}</span>起{else}电询{/if}</span>
                                    <a class="buy" href="{$p['url']}" target="_blank">
                                        {if $p['endtime']>time() && $p['totalnum'] }
                                        {if $p['starttime']>time()}即将开抢{else}立即抢购{/if}
                                        {else}
                                        抢光了
                                        {/if}
                                    </a>
                                </div>
                            </div>
                        </li>
                        {else}
                        <li>
                            <a class="pic" href="{$p['url']}" target="_blank"><img src="{Product::get_lazy_img()}" st-src="{Common::img($p['litpic'],285,190)}" alt="{$p['title']}" width="285" height="190" /></a>
                            <div class="info">
                                <a class="tit" href="{$p['url']}" target="_blank">{$p['title']}</a>
                                <div class="fix">
                                    <span class="pri">{if !empty($p['price'])}{Currency_Tool::symbol()}<span class="num">{$p['price']}</span>起{else}电询{/if}</span>
                                    <a class="buy" href="{$p['url']}" target="_blank">{if in_array($p['typeid'],array(105,114))}马上报名{else}立即预订{/if}</a>
                                </div>
                            </div>
                        </li>
                        {/if}
                        {/loop}
                    </ul>
                    {if $channel['moreurl']}
                    <a href="{$channel['moreurl']}" class="more-link">查看更多 &gt;</a>
                    {/if}
                </div>
            </div>
            <!-- 通用 -->
            {/if}
            {if $channel['kindtype']==3}
            <div class="theme-item-box">
                <div class="theme-item-tit">
                    <h3 class="bar"><span class="bt">{$channel['title']}</span></h3>
                    <div class="txt">
                        {$channel['introduce']}
                    </div>
                </div>
                <div class="theme-product-item">
                    <ul class="clearfix">
                        {loop $channel['productlist'] $p}
                        <li>
                            <a class="pic" href="{$p['url']}" target="_blank"><img src="{Product::get_lazy_img()}" st-src="{Common::img($p['litpic'],285,190)}" alt="{$p['title']}"  /></a>
                            <div class="info">
                                <a class="tit alone" href="{$p['url']}" target="_blank">{$p['title']}</a>
                            </div>
                        </li>
                        {/loop}
                    </ul>
                    {if $channel['moreurl']}
                    <a href="{$channel['moreurl']}" class="more-link">查看更多 &gt;</a>
                    {/if}
                </div>
            </div>
            <!-- 相册、攻略 -->
            {/if}
            {/loop}
        </div>
    </div>

</div>
{request "pub/footer"}

<div class="theme-side-fixed" id="themeSideFixed">
    <ul class="theme-side-nav">

        {loop $channellist $channel}
        {if in_array($channel['kindtype'],array(1,2,3))}
        <li class="nav-item item">{$channel['title']}</li>
        {/if}
        {/loop}
        <li class="item" id="themeBackTop">TOP ↑</li>
    </ul>
</div>
<!-- 定位导航 -->

<script>
    $(function(){

        var arr = [];
        var ele = $('.theme-item-box');
        var item = $('.nav-item');

        for(var i=0; i<ele.length; i++){
            arr.push($(ele[i]).offset().top)
        }

        item.on('click',function(){
            var _this = $(this);
            var index = _this.index();

            $('html,body').animate({
                scrollTop: arr[index] + 1
            },500);

            setTimeout(function(){
                tab(_this,i,'current');
            },500)

        });

        //漂浮导航
        $(window).on('scroll',function(){

            var $themeSideFixed = $('#themeSideFixed');
            var scrollTop = $(window).scrollTop();

            if(scrollTop > arr[0]){
                $themeSideFixed.show()
            }
            else{
                $themeSideFixed.hide()
            }

            for(i=0; i<arr.length; i++){
                if($(document).scrollTop()>arr[i]){
                    tab(item,i,'current')
                }
            }

        });


        function tab(id,idx,cls){
            id.removeClass(cls).eq(idx).addClass(cls)
        }


        //优惠券
        $("#theme-coupon-item").slide({
            mainCell:".bd ul",
            effect:"left",
            delayTime: 500,
            vis:3,
            scroll:3,
            autoPage: true,
            autoPlay: false
        });

        //返回顶部
        $('#themeBackTop').on('click',function(){
            $('html,body').animate({
                scrollTop: 0
            },500)
        })

        $('.tuan_item').each(function (index, element) {

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
                $(node).find('.time').html(html);
            }, 1000);
        }

    })
</script>
{if empty($userinfo['mid'])}
{Common::js('jquery.md5.js')}
{include "member/login_fast"}

{/if}
</body>
</html>
