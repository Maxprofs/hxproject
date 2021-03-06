<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{__('订单详情')}-{$webname}</title>
    {Common::css('user.css,base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js')}
    {Common::js('layer/layer.js',0)}
</head>

<body {if $moduleinfo['id']==1||$moduleinfo['id']==5}style="background: #f6f6f6"{/if}>

{request "pub/header"}

<div class="big {if $moduleinfo['id']==5}bg-f6f6f6{/if}">
    <div class="wm-1200">

        <div class="st-guide"><a href="/">{__('首页')}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{__('会员中心')}&nbsp;&nbsp;&gt;&nbsp;&nbsp;{__('订单详情')}
        </div>

        <div class="st-main-page">

            {include "member/left_menu"}

            <div class="user-order-box">
                <iframe frameborder="0" id="iframepage" src="/{$moduleinfo['path']}/member/orderview?ordersn={$ordersn}" style="width:100%;display: none" onload="ReFrameHeight()"></iframe>
            </div><!--所有订单-->

        </div>

    </div>
</div>
<script>
    var module_pinyin = "{$moduleinfo['pinyin']}";
    $(function(){
        $(".user-side-menu #nav_"+module_pinyin+"order").addClass('on');
        if(typeof(on_leftmenu_choosed)=='function')
        {
            on_leftmenu_choosed();
        }
    });
    function ReFrameHeight() {
        var ifm= document.getElementById("iframepage");
        var subWeb = document.frames ? document.frames["iframepage"].document : ifm.contentDocument;

       $(subWeb.body).addClass('clearfix')
        if(ifm != null && subWeb != null) {
           $(ifm).show();
            ifm.height = subWeb.body.scrollHeight;
        }
    }
</script>
{request "pub/footer"}
</body>
</html>
