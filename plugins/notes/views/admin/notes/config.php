<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>系统参数</title>
    {template 'stourtravel/public/public_min_js'}
    {Common::getCss('style.css,base.css,base_new.css')}
    {Common::getScript('config.js,jquery.validate.js')}
</head>
<body>

<table class="content-tab" bottom_top=gDMzDt >
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
                        <span class="item-hd">评论审核：</span>
                        <div class="item-bd">
                            <label class="radio-label mr-20" for="aduit_open">
                                <input name="cfg_notes_pinlun_audit_open" type="radio" id="aduit_open"  class="checkbox" {if $config['cfg_notes_pinlun_audit_open']!=='0'}checked{/if} value="1">开启
                            </label>
                            <label class="radio-label mr-20" for="aduit_off">
                                <input name="cfg_notes_pinlun_audit_open" type="radio" id="aduit_off" class="checkbox" {if $config['cfg_notes_pinlun_audit_open']==='0'}checked{/if} value="0">关闭
                            </label>
                            <span class="item-text c-999 ml-20">*开启：用户对游记的评论需要管理员审核，才会在前台显示；关闭：用户评论之后直接在前台页面显示，管理员可在后台关闭不合理的评论展示</span>
                        </div>
                    </li>
                </ul>
                <div class="btn-wrap mt-25">
                    <input type="hidden" name="webid" id="webid" value="0">
                    <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                </div>
            </form>
        </td>
    </tr>
</table>

<script>

    $(document).ready(function(){

        //配置信息保存
        $("#btn_save").click(function(){
            var webid= $("#webid").val();
            Config.saveConfig(webid);
        })
    })
</script>

</body>
</html>
