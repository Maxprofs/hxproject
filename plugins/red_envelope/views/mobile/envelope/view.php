<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>瓜分红包-{$GLOBALS['cfg_webname']}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    {Common::css('base.css')}
    {Common::css_plugin('redenvelope.css','red_envelope')}
    {Common::js('jquery.min.js,lib-flexible.js')}
</head>

<body>

    <div class="header_top">
        <a class="back-link-icon" href="{$cmsurl}/member" ></a>
        <h1 class="page-title-bar">瓜分红包</h1>
    </div>
    <!-- 公用头部 -->

    <div class="re-main">
        {st:ad action="getad" name="envelope_mobile_ad" return="ad"}
        {if $ad['adsrc']}
        <div class="re-banner-bar" style="background:url('{$ad['adsrc']}') center no-repeat;background-size:contain "></div>
        {else}
        <div class="re-banner-bar"></div>
        {/if}

    </div>
    <!-- banner -->
    {if $own}
    <div class="re-info-block">
        {if $own['is_max']}
        <div class="re-best-icon"></div>
        {/if}

        <div class="re-info-box">
            <dl class="info-dl">
                <dt></dt>
                <dd>
                    <div class="tit">恭喜您获得<span class="num">{Currency_Tool::symbol()}{$own['money']}</span>红包</div>
                    <div class="date">{date('Y-m-d H:i',$own['addtime'])}（{$own['module_title']}产品可用）</div>
                    <div class="account">红包已存入账号：{$own['nickname']}</div>
                </dd>
            </dl>
            <a class="re-use-link" href="{$cmsurl}">立即使用</a>
        </div>
    </div>
    {/if}

    <div class="re-section-block">
        <div class="re-section-box">
            <div class="section-bar">查看大家手气</div>
            <ul class="re-get-item-list">
                {loop $list $l}
                <li>
                    <div class="hd"><img src="{$l['litpic']}" alt="{$l['nickname']}"></div>
                    <div class="bd">
                        <div class="name">{$l['nickname']}</div>
                        <div class="date">{date('Y-m-d H:i:s',$l['addtime'])}</div>
                    </div>
                    <div class="ft">
                        <div class="num">{Currency_Tool::symbol()}{$l['money']}</div>
                        {if $l['is_max']}
                        <div class="label"><i class="z-icon"></i>手气最佳</div>
                        {/if}
                    </div>
                </li>
                {/loop}
            </ul>
            {if !$has_max}
            <div class="re-bester-txt">最佳手气尚未出现，稍后揭晓</div>
            {/if}
        </div>
    </div>

    <div class="re-section-block">
        <div class="re-section-box">
            <div class="section-bar">活动规则</div>
            <div class="re-section-rule">
                {Common::content_image_width($config,100,0)}
            </div>
        </div>
    </div>


</body>
</html>
<script>
    var SITEURL = "{URL::site()}";
</script>
{include '../mobile/envelope/pub/envelope_share'}