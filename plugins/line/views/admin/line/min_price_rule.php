<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head float_ul=dHACXC >
    <meta charset="utf-8">
    <title>线路最低价规则</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript('config.js,jquery.jqtransform.js,jquery.colorpicker.js');}
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <form id="configfrm">
                    <div class="cfg-header-bar">
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
                    <ul class="info-item-block">
                        <li>
                            <span class="item-hd">前台低价显示{Common::get_help_icon('min_price')}：</span>
                            <div class="item-bd">
                                <label class="radio-label"><input type="radio" name="cfg_line_minprice_rule" value="2" {if $config['cfg_line_minprice_rule']==2}checked{/if}>优先成人</label>
                                <label class="radio-label ml-20"><input type="radio" name="cfg_line_minprice_rule" value="1" {if $config['cfg_line_minprice_rule']==1}checked{/if}>优先儿童</label>
                                <label class="radio-label ml-20"><input type="radio" name="cfg_line_minprice_rule" value="3" {if $config['cfg_line_minprice_rule']==3}checked{/if}>优先老人</label>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">起价说明{Common::get_help_icon('min_price_description')}：</span>
                            <div class="item-bd">
                                <textarea class="set-area" style="width: 588px" name="cfg_line_price_description" cols="" rows="">{$config['cfg_line_price_description']}</textarea>
                            </div>
                        </li>
                    </ul>
                    <div class="clear clearfix mt-5">
                        <a class="btn btn-primary radius size-L ml-115" href="javascript:;" id="btn_save">保存</a>
                        <input type="hidden" name="webid" id="webid" value="0">
                    </div>
                </form>
            </td>
        </tr>
    </table>

<script>

    $(document).ready(function(){
        //配置信息保存
        $("#btn_save").click(function(){
            Config.saveConfig(0);
            $.get(SITEURL+"line/admin/line/ajax_clear_minprice",function(status){

            });
        });
    })

</script>

</body>
</html>
