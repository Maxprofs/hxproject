<!doctype html>
<html>
<head table_head=MSuttC >
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
    {Common::css('base.css')}
    {Common::js('jquery.min.js,base.js,common.js')}
</head>

<body>
{request 'pub/header'}

<div class="coupon-slide">
    {st:ad action="getad" name="Coupon_Index_Ad1" pc="1" return="ad"}
    <a class="pic" href="{$ad['adlink']}" target="_blank"><img src="{Common::img($ad['adsrc'],1920,380)}" alt=" {$ad['adname']}" width="1920" height="380" /></a>
    {/st}
</div>
<!-- 广告图 -->

<div class="big">
    <div class="wm-1200">

        <div class="coupon-list-content">
            <h3 class="coupon-list-tit">免费领券</h3>
            <div class="coupon-list-block">
                <ul class="clearfix">

                    {php}$index=1;{/php}
                    {loop $list $l}
                    <li class="{if $l['status']==2}over {elseif $l['status']==3}usable{else}{/if} {if $index%3==0} mr_0{/if}">
                        {if $l['status']!=2&&$l['isout']==1}
                        <span class="attr"></span>
                        {/if}
                        <div class="l-con">
                                <span class="hd">
                                  {if $l['type']==0}
                                    <strong class="jg">￥<b>{$l['amount']}</b></strong>
                                    {else}
                                    <strong class="jg"><b>{$l['amount']}折</b></strong>
                                    {/if}
                                    <span class="se">
                                        <em class="t1">{$l['name']}</em>
                                        {if $l['samount']}
                                        <em class="t2">满{$l['samount']}元可用</em>
                                        {else}
                                        <em class="t2">无金额限制</em>
                                        {/if}
                                    </span>
                                </span>
                            {if $l['typeid']==0}
                            <span class="xg">品类限制：无品类限制</span>
                            {elseif $l['typeid']==1}
                            <span class="xg">品类限制：{$l['typename']}产品</span>
                            {else}
                            <span class="xg">品类限制：限购部分{Common::cutstr_html($l['typename'],12)}产品</span>
                            {/if}
                            <span class="xl">需提前{$l['antedate']}天使用，每人限领{$l['maxnumber']}张</span>
                            {if $l['isnever']==1}
                            <span class="date">{$l['starttime']}~{$l['endtime']}</span>
                            {else}
                            <span class="date">永久有效</span>
                            {/if}
                            {if $l['status']==3}
                            <span class="num">{$l['surplus']}张</span>
                            {else}
                            <span class="num">还剩<b>{$l['surplus']}</b>张</span>
                            {/if}
                        </div>
                        {if $l['status']==1||$l['status']==4}
                        <a class="r-btn get_coupon"   {if $l['gradename_all']} title="{$l['gradename_all']}可领取"{/if}  href="javascript:void(0)" couponid="{$l['id']}">
                            免费领取
                            {if $l['gradename']}
                            <span><i>（{$l['gradename']}等可领取）</i></span>
                            {/if}
                        </a>
                        {elseif $l['status']==2}
                        <span class="r-btn">今日已领完</span>
                        <span class="label"></span>
                        {elseif $l['status']==3}
                        <a class="r-btn" href="{$cmsurl}coupon/search-{$l['id']}">立即使用</a>
                        {/if}
                    </li>
                    {php}$index++;{/php}
                    {/loop}
                </ul>
            </div>
            <div class="clearfix">

            </div>
            <div class="main_mod_page clear">
                {$pageinfo}
            </div>

        </div>

    </div>
</div>

{request 'pub/footer'}
{request 'pub/flink'}
{Common::js('layer/layer.js',0)}
</body>
</html>
<script>
    $(function(){
        //领取优惠券
        $('.get_coupon').click(function(){
            var couponid = $(this).attr('couponid');
            $.ajax({
                type: 'POST',
                url: SITEURL + 'coupon/ajxa_get_coupon',
                data: {cid:couponid},
                async: false,
                dataType: 'json',
                success: function (data) {
                    if(data.status==0)
                    {
                        layer.msg(data.msg, {icon: 5,time: 1000});
                    }
                    if(data.status==1)
                    {
                        layer.msg(data.msg, {icon: 5,time: 1000},function(){
                            var url = SITEURL+'member/login?redirecturl={$redirecturl}';
                            window.location.href=url;
                        });
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
