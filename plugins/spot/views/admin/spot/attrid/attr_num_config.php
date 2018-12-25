<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>预定协议</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css,jqtransform.css'); }
    {php echo Common::getScript('config.js');}
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
                <div class="w-set-con">
                    <div class="cfg-header-bar">
                        {template 'admin/spot/attrid/header_tab'}
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
                    <div class="w-set-nr">

                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">显示分类数量{Common::get_help_icon('attr_number')}：</span>
                                <div class="item-bd">
                                    <input type="text" name="cfg_spot_attr_show_num" maxlength="2" class="set-text-xh w80 number_only" value="{$config['cfg_spot_attr_show_num']}">
                                </div>
                            </li>
                        </ul>
                        <div class="clear clearfix mt-5">
                            <a class="btn btn-primary size-L radius ml-115" href="javascript:;" id="btn_save">保存</a>
                            <!-- <a class="cancel" href="#">取消</a>-->
                            <input type="hidden" name="webid" id="webid" value="0">
                        </div>

                    </div>
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

        });
        //只能输入数字
        $('.number_only').keyup(function(){

            var v = $(this).val();
            $(this).val(ST.Util.numberOnly(v));

        })

    })


</script>

</body>
</html>
