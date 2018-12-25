<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{$info['name']}-{$GLOBALS['cfg_webname']}</title>
    <meta name="keywords" content="{$info['name']}" />
    <meta name="description" content="{$info['name']}" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css_plugin('style-new.css','integral')}
    {Common::css_plugin('swiper.min.css','integral')}
    {Common::css_plugin('shop.css','integral')}

    {Common::js_plugin('lib-flexible.js','integral')}
    {Common::js_plugin('jquery.min.js','integral')}
    {Common::js_plugin('swiper.min.js','integral')}
    {Common::js('delayLoading.min.js')}
    {Common::js('layer/layer.m.js',0)}
</head>
<body>
<div class="header_top bar-nav">
    <a class="back-link-icon" href="javascript:history.go(-1)"></a>
    <h1 class="page-title-bar">商品详情</h1>
</div>
<!-- 公用顶部 -->
<div class="page-content page-content-bottom">
    <div class="swiper-container show-img-block">
        <div class="swiper-wrapper">

            <div class="swiper-slide">
                <a class="pic" href="javascript:;"><img src="{$info['litpic']}" alt="{$info['name']}" /></a>
            </div>

        </div>
        <div class="swiper-pagination"></div>
    </div>
    <!-- 图片切换 -->

    <div class="show-txt-block">
        <p class="tit">{$info['name']}</p>
        <p class="option clearfix">
            <span class="fl">库存数量：{$info['leftnum']}件</span>
            <strong class="fr">{$info['needjifen']}积分</strong>
        </p>
    </div>

    <div class="show-des-block">
        <h3>商品详情</h3>
        <div class="txt">
            订单满减：
            {if $info['type']==0}
            <em>订单满{$info['samount']}立减{$info['amount']}元</em>
            {else}
            <em>订单满{$info['samount']}享{$info['amount']}折</em>
            {/if}
            <br>
            <br>
            有效期：
            {if $info['isnever']==0}
            永久有效
            {else}
            {$info['starttime']}至{$info['endtime']}有效
            {/if}
            <br>
            {if $info['gradename_all']}
            <br>

            限{$info['gradename_all']}可领取

            <br>
            {/if}
            <br>
            使用限制:
            {if $info['typename']}
            {$info['typename']}
            {if $info['typeid']==1}
            等产品可用
            {else}
            等部分产品可用
            {/if}
            {else}
            无产品限制
            {/if}
        </div>
    </div>

</div>

<div class="footer clearfix">
    <div class="txt">{$info['needjifen']}积分</div>
    {if $member['jifen'] < $info['needjifen']}
    <div class="unlink"><a class="unlink" href="javascript:;">积分不足</a></div>
    {else}
    <div class="link get_coupon" ><a  href="javascript:;">立即兑换</a></div>
    {/if}
</div>


<script type="text/javascript">
    var SITEURL = '{$cmsurl}'
    $(function() {
        $("html,body").css("height", "100%");

        var couponid = '{$info['id']}';
        var title = '{$info['name']}';
        var needjifen = '{$info['needjifen']}';
        $('.get_coupon').click(function () {
            layer.open({
                content:'您确定要用'+needjifen+'积分兑换'+title+'吗?',
                btn: ['确定','取消'],
                yes:function(){
                    get_coupon(couponid);
                }
                ,btn2: function(){
                    layer.closeAll()
                }
                ,cancel: function(){
                    layer.closeAll()
                }
            });


        })


    });

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
                layer.open({
                    content: data.msg
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                });
                setTimeout(location.reload(),2000)
            }
        })


    }

</script>
</body>
</html>
