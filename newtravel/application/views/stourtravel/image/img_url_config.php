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
                        <span class="item-hd">缩略图地址{Common::get_help_icon('cfg_img_param')}：</span>
                        <div class="item-bd">
                            <label class="radio-label mr-20" for="aduit_open">
                                <input name="cfg_img_param" id="aduit_open" type="radio" class="checkbox" {if $config['cfg_img_param']!=='1'}checked{/if} value="0">默认
                            </label>
                            <label class="radio-label mr-20" for="aduit_off">
                                <input name="cfg_img_param" id="aduit_off" type="radio" class="checkbox" {if $config['cfg_img_param']==='1'}checked{/if} value="1">参数形式
                            </label>
                            <span class="item-text c-999 ml-20">*默认：使用原版的缩略图地址规则；参数形式：使用新版的缩略图生成地址</span>
                        </div>
                    </li>
                </ul>
                <div class="btn-wrap mt-25">
                    <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                </div>
            </form>
            <input type="hidden" name="webid" id="webid" value="0">
        </td>
    </tr>
</table>
<script>
    $(document).ready(function(){
        //配置信息保存
        $("#btn_save").click(function(){
            var value=$('input[name="cfg_img_param"]:checked').val();
            $.ajax({
                type: "POST",
                url: SITEURL + 'image/img_url_config/set/',
                data:{'cfg_img_param':value},
                success:function (data) {
                    if (data == 'success') {
                        ST.Util.showMsg('设置成功',4);
                    }else{
                        ST.Util.showMsg('设置失败',5);
                    }
                }
            });
        })
    })
</script>

</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201809.0602&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
