<!doctype html>
<html>
<head float_border=CMfLuj >
<meta charset="utf-8">
<title>系统参数</title>
    {template 'stourtravel/public/public_min_js'}
    {Common::getCss('style.css,base.css,base_new.css')}
    {Common::getScript('config.js')}
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

                            <span class="item-hd">评论审核：</span>
                            <div class="item-bd">
                                <label class="radio-label" for="aduit_open"><input type="radio" id="aduit_open"  name="cfg_article_pinlun_audit_open" value="1" {if $config['cfg_article_pinlun_audit_open']=='1'}checked{/if}>开启</label>
                                <label class="radio-label ml-20" for="aduit_off"><input type="radio" id="aduit_off"  name="cfg_article_pinlun_audit_open" value="0" {if $config['cfg_article_pinlun_audit_open']=='0'}checked{/if}>关闭</label>
                                <span class="item-text c-999 ml-20">*开启：用户对文章攻略的评论需要管理员审核，才会在前台显示；关闭：用户评论之后直接在前台页面显示，管理员可在后台删除对应不合理的评论</span>
                            </div>
                        </li>
                    </ul>
                    <div class="clear clearfix">
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

                //var webid= $("#webid").val();
                Config.saveConfig(0);

            });

        })

    </script>

</body>
</html>
