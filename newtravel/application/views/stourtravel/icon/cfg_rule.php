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
                                    <span class="item-hd">前台显示{Common::get_help_icon('icon_cfg_rule',true)}：</span>
                                    <div class="item-bd">
                                        <label class="radio-label"><input type="radio" {if $config['cfg_icon_rule']!=1}checked {/if}name="cfg_icon_rule" value="0">图标</label>
                                        <label class="radio-label ml-20"><input type="radio" {if $config['cfg_icon_rule']==1}checked {/if} name="cfg_icon_rule"  value="1">卖点</label>
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
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201802.0204&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
