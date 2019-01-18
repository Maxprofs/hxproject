<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{__('门市后台')}-{$webname}</title>
    {include "pub/varname"}
    {Common::css('user.css,base.css,extend.css',false)}

    <script type="text/javascript" src="/res/js/artDialog/lib/sea.js"></script>
    {Common::js('jquery.min.js,base.js,common.js,dialog.js')}
</head>
<body>
{request "pub/header"}
<div class="big">
<div class="wm-1200">

    <div class="st-guide">
        <a href="{$cmsurl}">{__('首页')}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{__('门市后台')}
    </div><!--面包屑-->
    <div class="st-main-page">
    {include "member/left_menu"}
        <div class="user-order-box">
            <a href="/distributor/pc/sms/index">短信管理</a>
        </div>
    </div><!--会员首页-->

</div>

</div>

{Common::js('layer/layer.js')}
{request "pub/footer"}
<script>

</script>
{include "member/order/jsevent"}
</body>
</html>
