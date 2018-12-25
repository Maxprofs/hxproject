<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head html_strong=SvRzDt >
    <meta charset="utf-8">

    <title>优惠券领取-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    {include "pub/varname"}
    {Common::css_plugin('coupon.css','coupon')}
    {Common::css('base.css,user.css')}
    {Common::js('jquery.min.js,base.js,common.js')}
</head>

<body>

{request 'pub/header'}
<div class="big">
    <div class="wm-1200">

        <div class="st-guide">
            <a href="/">首页</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;会员中心
        </div>
        <!--面包屑-->

        <div class="st-main-page">
            {include "member/left_menu"}
            <div class="user-coupon-content">
                <div class="user-coupon-block">
                    <div class="user-coupon-tit clearfix"><strong class="bt">优惠券</strong><a class="more-link" href="/coupon">领用优惠券&gt;</a></div>
                    <div class="user-coupon-item">
                        <div class="down-select">
                            <strong class="hd">{if $param['isout']==1} 未使用 {elseif $param['isout']==2 }已过期 {elseif $param['isout']==3 }已使用 {else}全部  {/if}（{count($list)}）<i></i></strong>
                            <ul class="bd isout">
                                <li isout="0">全部</li>
                                <li isout="1">未使用</li>
                                <li isout="2">已过期</li>
                                <li isout="3">已使用</li>
                            </ul>
                        </div>
                        <div class="down-select">
                            <strong class="hd"  > {if $param['kindid']==1}通用券{elseif $param['kindid']==2}兑换券{else}全部 {/if}</strong>
                            <ul class="bd kindid">
                                <li kindid="0">全部</li>
                                <li kindid="1">通用券</li>
                                <li kindid="2">兑换券</li>
                            </ul>
                        </div>
                    </div>
                    <div class="user-coupon-list">
                        <ul class="clearfix">
                            {php}$index=1;{/php}
                            {loop $list $l}
                            <li  class=" {if $l['isout']==2|| $l['totalnum']==$l['usenum']}grey  {/if} {if $index%4==0}mr_0 {/if} ">
                                {if $l['isout']==1&& $l['totalnum']!=$l['usenum']}
                                <span class="ico"></span>
                                {/if}
                                <div class="t-con">
                                    <span class="attr">
                                        <strong>
                                            {if $l['type']==0}
                                            ￥<b>{$l['amount']}</b>
                                            {else}
                                            <b>{$l['amount']}</b>折
                                            {/if}
                                        </strong>
                                        <em>{$l['name']}【{if $l['kindid']==1}通用券{else}兑换券{/if}】</em>
                                    </span>
                                    {if $l['samount']}
                                    <span class="md">【满{$l['samount']}元可用】</span>
                                    {else}
                                    <span class="md">【无金额限制】</span>
                                    {/if}
                                    {if $l['isnever']==1}
                                    <span class="date">{$l['starttime']}~{$l['endtime']}</span>
                                    {else}
                                    <span class="date">永久有效</span>
                                    {/if}
                                </div>
                                <div class="b-con">
                                    <ul>
                                        <li>品类限制：<span class="y1">{if $l['typename']}{Common::cutstr_html($l['typename'],12)}产品{else} 无品类限制{/if}</span></li>
                                        <li>使用限制：<span class="y1">需提前{$l['antedate']}天使用</span></li>
                                        {if  $l['ordersn']}
                                        <li>订单号 ：<a href="/member/order/view?ordersn={$l['ordersn']}"><span class="y2">{$l['ordersn']}</span></a></li>
                                        {/if}
                                    </ul>
                                    {if $l['isout']!=2&& $l['totalnum']!=$l['usenum']}
                                    <a class="use-btn" href="{$cmsurl}coupon/search-{$l['cid']}">立即使用</a>
                                    {/if}
                                </div>
                                {if $l['isout']!=2&& $l['totalnum']!=$l['usenum']}
                                <span class="num">共{$l['totalnum']}张</span>
                                {elseif $l['isout']==2&& $l['totalnum']!=$l['usenum']}
                                <span class="over-time"></span>
                                {elseif  $l['totalnum']==$l['usenum']}
                                <span class="use-over"></span>
                                {/if}
                            </li>
                            {php}$index++;{/php}
                            {/loop}
                        </ul>
                        {if empty($list)}
                        <div class="no-coupon">
                            <i class="icos"></i>
                            <p>您的优惠券空空如也，赶紧<a class="color-2" href="/coupon">领取优惠券！</a></p>
                        </div>
                        {/if}
                    </div>
                </div>
                <div class="main_mod_page clear">
                    {$pageinfo}
                </div>
                <!-- 翻页 -->
            </div>
            <!-- 优惠券列表 -->

        </div>
        <input type="hidden" id="kindid" value="{$param['kindid']}">
        <input type="hidden" id="isout" value="{$param['isout']}">
    </div>
</div>

{request 'pub/footer'}

</body>
</html>
<script>
    $(function(){
        $('.isout li').click(function(){
            var isout = $(this).attr('isout');
            var kindid = $('#kindid').val();
            var url = SITEURL +'member/coupon-'+isout+'-'+kindid;
            window.location.href = url;
        })
        $('.kindid li').click(function(){
            var kindid = $(this).attr('kindid');
            var isout = $('#isout').val();
            var url = SITEURL +'member/coupon-'+isout+'-'+kindid;
            window.location.href = url;
        })

        $("#nav_mycoupon").addClass('on');
        if(typeof(on_leftmenu_choosed)=='function')
        {
            on_leftmenu_choosed();
        }



    })


</script>
