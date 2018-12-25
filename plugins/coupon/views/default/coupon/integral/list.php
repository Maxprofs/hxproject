<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{if $seoinfo['seotitle']}{$seoinfo['seotitle']}{else}积分商城{/if}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    {include "pub/varname"}
    {Common::css('header-club.css,club.css,base.css,extend.css',false)}
    {Common::css_plugin('jf.mall.css','integral')}
    {Common::js("jquery.min.js,base.js,common.js")}
</head>
<body>
{request "member/club/header"}
<div class="main-container bg-grey-f7">
    <div class="wm-1200">

        <div class="st-guide">
            <a href="/" title="首页" target="_blank">首页</a>
            &nbsp;&gt;&nbsp;
            <strong title="积分商城">积分商城</strong>
        </div>
        <!-- 面包屑 -->

        <div class="search-mall-wrap">
            <dl class="clearfix">
                <dt class="search-type">商品分类：</dt>
                <dd class="search-item">
                    <a href="/integral/all" >全部</a>
                    <a href="/coupon/_integral_all" class="on">积分兑换券</a>
                    {loop $type $t}
                    <a href="/integral/{$t['id']}" >{$t['attrname']}</a>
                    {/loop}

                </dd>
            </dl>
        </div>
        <!-- 搜索 -->
        {if $result}
        <div class="exchange-content">
            <div class="exchange-block">
                <ul class="clearfix">
                    {loop $result $k $v}
                    <li {if $k && ($k+1)%4==0}class="mr_0"{/if}>
                        <a href="{$cmsurl}coupon/integral_show?cid={$v['id']}"  class="pic"><img src="{Common::img($v['litpic'],285,194)}" alt="{$v['name']}"/></a>
                        <div class="info">
                            <a href="javascript:;"  class="bt">{$v['name']}<br>
                                {if $v['type']==0}
                                <em>订单满{$v['samount']}立减{$v['amount']}元</em>
                                {else}
                                <em>订单满{$v['samount']}享{$v['amount']}折</em>
                                {/if}
                            </a>
                            <p class="data clearfix">
                                <em class="jf-num"><b>{$v['needjifen']}</b>积分</em>
                                <a class="dh-btn get_coupon"  data-maxnumber="{$v['maxnumber']}" {if $v['isnever']==1} data-endtime="{$v['endtime']}" {/if} data-id="{$v['id']}" data-jifen="{$v['needjifen']}" data-title="{$v['name']}" href="javascript:;">立即兑换</a>
                            </p>
                        </div>
                    </li>
                    {/loop}
                </ul>
            </div>
            <div class="main_mod_page clear">
                {$pager}
            </div>
        </div>
        {else}
        <div class="no-content">
            <p><i></i>抱歉，没有找到符合条件的产品！<a href="/integral/all">查看全部产品</a></p>
        </div>
        {/if}
        <!-- 积分兑换券 -->

    </div>
</div>
<!-- 页面主体 -->

<div class="hint-change hide" id="hintChange">
    <i class="icon"></i>
    <div class="hint-wrap">
        <p class="tf">您正在使用<span class="jf"></span>兑换</p>
        <p class="ts"></p>
        <p class="tt"></p>
    </div>
</div>

<!-- footer -->
{request "pub/footer"}
<!-- footer end -->
</body>
</html>
{Common::js('layer/layer.js',0)}
<script>


    $(function(){
        $('.get_coupon').click(function(){

            var couponid = $(this).attr('data-id');
            var title = $(this).attr('data-title');
            var jifen = $(this).attr('data-jifen');
            var endtime = $(this).attr('data-endtime');
            var maxnumber = $(this).attr('data-maxnumber');
            console.debug(endtime);
            if(!endtime)
            {
                endtime = '永久有效';
            }
            else
            {
                endtime ='有效期至：'+endtime;
            }
            if(!maxnumber)
            {
                maxnumber = '&nbsp;&nbsp;&nbsp;'
            }
            else
            {
                maxnumber = '&nbsp;&nbsp;&nbsp;每个会员限领'+maxnumber+'张'
            }
            $('#hintChange .jf').text(jifen+'积分');
            $('#hintChange .ts').text(title);
            $('#hintChange .tt').html(endtime+maxnumber);
            $("#hintChange").removeClass("hide");
            layer.open({
                type: 1,
                title: '提示兑换',
                area: ['500px'],
                btn: ['确定','取消'],
                btnAlign: 'c',
                content: $('#hintChange'),
                yes:function(){
                    get_coupon(couponid);
                }
                ,btn2: function(){
                    $("#hintChange").addClass("hide");
                    layer.closeAll()
                }
                ,cancel: function(){
                    $("#hintChange").addClass("hide");
                    layer.closeAll()
                }
            });
        })
    })


    function get_coupon(couponid)
    {

        $.ajax({
            type: 'POST',
            url: SITEURL + 'coupon/ajxa_get_coupon_from_integral',
            data: {cid:couponid},
            async: false,
            dataType: 'json',
            success: function (data)
            {
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


    }
</script>