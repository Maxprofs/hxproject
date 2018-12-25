<!doctype html>
<html>
<head script_top=59LzDt >
    <meta charset="utf-8">
    <title>{__('支付错误')}-{$webname}</title>
    {Common::css('base.css,extend.css')}
    {include "pub/varname"}
    {Common::js('jquery.min.js,base.js,common.js')}

</head>

<body>

{request "pub/header"}
<div class="big">
    <div class="wm-1200">
        <div class="st-main-page mt20">
            <div class="st-payment-ts">
                <div class="payment-lose-box">
                    <div class="lose-con">
                        <h3>{__('支付失败')}</h3>
                        <div class="txt">{if $msg}{$msg},{/if}{__('请联系管理员')}</div>
                        <div class="btn-box">
                            <a class="again-pay-btn" href="{$GLOBALS['cfg_basehost']}">{__('返回首页')}</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{request "pub/footer"}

</body>
</html>
