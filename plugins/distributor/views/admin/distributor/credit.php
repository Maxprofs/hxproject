<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>分销商列表-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {Common::getScript('datepicker/WdatePicker.js')}
    <style>
        .item-name{
            position: relative;
            top: 5.5px;
        }
    </style>
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
                <div class="cfg-search-bar" id="search_bar">
                    <span class="cfg-search-tab display-mod fr">
                        <a href="javascript:void(0);" title="加盟授信管理" class="item on">加盟授信管理</a>
                    </span>
                </div>
                <div id="product_grid_panel" class="content-nrt" style="width: 100%;">
                    <div class="product-add-div">
                        <ul class="info-item-block">
                            <li class="list_dl">
                                <span class="item-hd">部门名称：</span>
                                <div class="item-bd">
                                    <span class="item-name" id="nickname">{$info[0]['nickname']}</span>
                                </div>
                            </li>
                            <li class="list_dl">
                                <span class="item-hd">授信额度<span style="color: red;">*</span>：</span>
                                <div class="item-bd">
                                    <input type="text" class="input-text w150" id="sx" value="{$info[0]['credit']}" oninput="value=value.replace(/[^\d]/g,'')">&nbsp;&nbsp;&nbsp;&nbsp;元
                                </div>
                            </li>
                            <li class="list_dl">
                                <span class="item-hd">加盟期限<span style="color: red;">*</span>：</span>
                                <div class="item-bd">
                                    <input type="text" class="input-text w150" id="jmqx" value="{$info[0]['jiamengqixian']}" onclick="WdatePicker({minDate:'%y-%M-%d'})">
                                </div>
                            </li>
                            <li class="list_dl">
                                <span class="item-hd">加盟费<span style="color: red;">*</span>：</span>
                                <div class="item-bd">
                                    <input type="text" class="input-text w150" id="jmf" value="{$info[0]['jiamengfei']}" oninput="value=value.replace(/[^\d]/g,'')">&nbsp;&nbsp;&nbsp;&nbsp;元/年
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="clear clearfix">
                    <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                </div>
            </td>
        </tr>
    </table>
</body>
<script>
    $(function() {
        $("#btn_save").click(function(event) {
            var url=SITEURL+'distributor/admin/distributor/ajax_savecredit'
            if ($('#sx').val()=='' || $('#jmqx').val()=='' || $('#jmf').val()=='') {
                ST.Util.showMsg('未填写完成。', 5, 2000);
                return;
            }
            var mid={$info[0]['mid']};
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {mid:mid,sx:$('#sx').val(),jmqx:$('#jmqx').val(),jmf:$('#jmf').val()},
            })
            .done(function(data) {
                if (data.status) {
                    ST.Util.showMsg(data.msg, 4, 1000);
                    setTimeout("window.location.reload()",'1000')
                }else{
                    ST.Util.showMsg(data.msg, 5, 1000);
                    setTimeout("window.location.reload()",'1000')
                }

            })
        });
    });
</script>

</html>