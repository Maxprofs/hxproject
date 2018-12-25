<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title background_size=VQe65k >笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base.css,base_new.css'); }
    <style>
        .container-page .item-hd{
            width: 70px !important;
        }
        .container-page .item-bd{
            padding-left: 75px !important;
        }
        .container-page .info-item-block
        {
            padding: 0 !important;
        }

    </style>
</head>
<body >
<div class="container-page">
    <ul class="info-item-block">
        <li>
            <span class="item-hd">应结金额：</span>
            <div class="item-bd">
                <span class="item-text c-f60">{$info['brokerage']}</span>
            </div>
        </li>
        <li>
            <span class="item-hd">可结金额：</span>
            <div class="item-bd">
                {if $info['finish_brokerage']}
                <span class="item-text">{$info['open_price']}</span>
                <input type="hidden" id="open_price"  value="{$info['open_price']}" />
                {else}
                <input type="text" id="open_price"    class="input-text w100" value="{$info['open_price']}" />

                {/if}

            </div>
        </li>
        <li>
            <span class="item-hd">确认说明：</span>
            <div class="item-bd">
                <span class="item-text c-999">确认后金额即会打入对应商家余额，不能撤销。</span>
            </div>
        </li>
    </ul>
    <div class="clear text-c">
        <a href="javascript:;" class=" btn btn-grey-outline radius">取消</a>
        <a href="javascript:;" class=" btn btn-primary radius ml-15">确定</a>
    </div>
</div>
<script>

    $(function() {
        var id = '{$info['id']}';
        ST.Util.resizeDialog('.container-page');

        $('.btn-primary').click(function () {
            var open_price = $('#open_price').val();
            ST.Util.responseDialog({id:id,open_price:open_price},true);
        });
        $('.btn-grey-outline').click(function () {
            ST.Util.responseDialog({},false);
        })

    })
</script>

</body>
</html>
