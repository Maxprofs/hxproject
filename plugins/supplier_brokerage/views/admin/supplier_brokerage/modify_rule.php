<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>线路订单管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript('config.js');}
</head>
<body style="overflow:hidden">

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:hidden">
                <div class="container-page">
                    <div class="cfg-header-bar">
                        <a href="javascript:;" class="fr btn btn-primary radius mt-4 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
                    <div class="clearfix">
                        <form id="configfrm">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">结算规则：</span>
                                    <div class="item-bd">
                                        <div class="pb-10">
                                            <label class="radio-label"><input type="radio" value="0" name="cfg_supplier_brokerage_type"  {if $config['cfg_supplier_brokerage_type']!=1} checked{/if} />从订单【已完成】开始按 T+
                                                <input type="text"   name="cfg_supplier_brokerage_finish_days"  value="{$config['cfg_supplier_brokerage_finish_days']}" class="input-text w50" /> 自动结算</label>
                                        </div>
                                        <div class="pb-10">
                                            <label class="radio-label"><input type="radio" value="1" name="cfg_supplier_brokerage_type"  {if $config['cfg_supplier_brokerage_type']==1} checked{/if} />从订单【待消费】开始按 T+
                                                <input type="text" name="cfg_supplier_brokerage_start_days" value="{$config['cfg_supplier_brokerage_start_days']}" class="input-text w50" /> 自动结算</label>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </form>
                        <div class="clear pb-20">
                            <a href="javascript:;" id="sub_frm" class="btn btn-primary radius size-L ml-115">保存</a>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

<script>

    $('#sub_frm').click(function () {
        Config.saveConfig(0);
    })



</script>

</body>
</html>
