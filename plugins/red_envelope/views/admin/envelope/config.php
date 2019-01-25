<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,DatePicker/WdatePicker.js,product_add.js,choose.js,st_validate.js,jquery.colorpicker.js,jquery.jqtransform.js,imageup.js,jquery.validate.js,config.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>

    <!--顶部-->
    {php Common::getEditor('jseditor','',$sysconfig['cfg_admin_htmleditor_width'],300,'Sline','','print',true);}
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:auto;">
                <div class="cfg-header-bar">
                    <a href="javascript:;" onclick="location.reload()" class="fr btn btn-primary radius mt-6 mr-10">刷新</a>
                </div>
                    <form id="configfrm">
                        <div class="clearfix">
                            <ul  class="info-item-block">
                                <li>
                                    <span class="item-hd">红包说明：</span>
                                    <div class="item-bd">
                                        {php Common::getEditor('cfg_envelope_description',$config,$sysconfig['cfg_admin_htmleditor_width'],400);}
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-5">
                            <a href="javascript:;" id="save_btn" class="btn btn-primary radius size-L ml-115">保存</a>
                        </div>
                    </form>
            </td>
        </tr>
    </table>
<script>
$(function () {
    $("#save_btn").click(function(){
        Config.saveConfig(0);
    })
})
</script>
</body>
</html>
