<!doctype html>
<html>
<head float_border=5QJIAj >
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}短信平台</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,plist.css,sms_sms.css,base_new.css'); }
    {php echo Common::getScript('common.js,config.js,DatePicker/WdatePicker.js');}
</head>

<body>

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <!--面包屑-->
                <div class="cfg-header-bar">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>

                <form id="msgfrm">
                    {loop $status_arr $row}
                    <div class="clear">
                        <ul class="info-item-block">
                            <li>
                                 <span class="item-hd">{$row['name']}{Common::get_help_icon('message_order_'.$row['status'])}：</span>
                                <div class="item-bd">
                                    <div>
                                        <label class="radio-label mr-20"><input type="radio"  name="isopen[{$row['status']}]" value="1" {if $row['isopen']=='1'}checked="checked"{/if}/>开启</label>
                                        <label class="radio-label mr-20"><input type="radio"  name="isopen[{$row['status']}]" value="0" {if $row['isopen']!='1'}checked="checked"{/if}/>关闭</label>
                                    </div>
                                    <textarea class="textarea w900" name="content[{$row['status']}]">{$row['content']}</textarea>
                                    <div class="mt-5">
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#MEMBERNAME#}">会员名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#WEBNAME#}">网站名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PHONE#}">联系电话</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PRODUCTNAME#}">产品名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PRICE#}">单价</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#NUMBER#}">预订数量</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#TOTALPRICE#}">总价</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#ORDERSN#}">订单号</a>
                                        {if $row['status']==2}
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#ETICKETNO#}">电子票号</a>
                                        {/if}
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#USEDATE#}">开始时间</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#DEPARTDATE#}">结束时间</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    {/loop}
                    <input type="hidden" name="typeid" value="{$typeid}"/>
                </form>

                <div class="clear clearfix pb-20 pt-10">
                    <a id="normal-btn" class="btn btn-primary radius size-L ml-115" href="javascript:void(0)">保存</a>
                </div>
            </td>
        </tr>
    </table>

    <script language="javascript">
        $(function(){
            $('.short-cut').click(function(){
                var ele=$(this).parents('.item-bd:first').find('textarea');
                var value=$(this).attr('data');
                ST.Util.insertContent(value,ele);
            })

            $("#normal-btn").click(function(){
                $.ajaxform({
                    url:SITEURL+'message/ajax_save_order',
                    method:  "POST",
                    form: "#msgfrm",
                    dataType: "json",
                    success:  function(result, opts)
                    {
                        if(result.status)
                        {
                            ST.Util.showMsg('保存成功!','4',2000);
                        }
                    }
                });
            })
        })
    </script>

</body>
</html>
