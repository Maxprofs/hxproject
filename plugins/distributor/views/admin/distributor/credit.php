<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>分销商列表-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {Common::getScript('datepicker/WdatePicker.js')}
</head>

<body style="overflow:hidden">
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:hidden">
                <div class="cfg-header-bar clearfix">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <div class="product-add-div">
                    <ul class="info-item-block">
                        <li class="list_dl">
                            <span class="item-hd w200">分销商账号：</span>
                            <div class="item-bd">
                                <span class="w200" id="account"></span>
                            </div>
                        </li>
                        <li class="list_dl">
                            <span class="item-hd w200">分销商名称：</span>
                            <div class="item-bd">
                                <span class="w200" id="account"></span>
                            </div>
                        </li>
                        <li class="list_dl">
                            <span class="item-hd w200">加盟期限：</span>
                            <div class="item-bd">
                                <input type="text" class="input-text w200" name="querydate" onclick="WdatePicker({minDate:'%y-%M-%d'})" />
                            </div>
                        </li>
                        <li class="list_dl">
                            <span class="item-hd w200">授信额度：</span>
                            <div class="item-bd">
                                <input type="text" class="input-text w200" id="credit" maxlength="6" oninput = "value=value.replace(/[^\d]/g,'')" />
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="clear clearfix">
                    <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                </div>
            </td>
        </tr>
    </table>
</body>
<script>

</script>

</html>