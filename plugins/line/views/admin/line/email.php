<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}短信平台</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
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
                <form id="frm">
                    <div class="clear">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">订单未处理：</span>
                                <div class="item-bd">
                                    <div>
                                        <label class="radio-label"><input type="radio" name="isopen1" value="1" {if $order_msg1_open==1}checked="checked"{/if}/>开启</label>
                                        <label class="radio-label ml-20"><input type="radio" name="isopen1" value="0" {if $order_msg1_open==0}checked="checked"{/if}/>关闭</label>
                                    </div>
                                    <textarea class="textarea w900" name="order_msg1">{$order_msg1}</textarea>
                                    <div class="mt-5">
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#MEMBERNAME#}">会员名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#WEBNAME#}">网站名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PHONE#}">联系电话</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PRODUCTNAME#}">产品名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PRICE#}">单价</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#NUMBER#}">预订数量</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#TOTALPRICE#}">总价</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PAYPRICE#}">支付金额</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#ORDERSN#}">订单号</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="clear">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">订单处理中：</span>
                                <div class="item-bd">
                                    <div>
                                        <label class="radio-label"><input type="radio" name="isopen2" value="1" {if $order_msg2_open==1}checked="checked"{/if}/>开启</label>
                                        <label class="radio-label ml-20"><input type="radio" name="isopen2" value="0" {if $order_msg2_open==0}checked="checked"{/if}/>关闭</label>
                                    </div>
                                    <textarea class="textarea w900" name="order_msg2">{$order_msg2}</textarea>
                                    <div class="mt-5">
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#MEMBERNAME#}">会员名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#WEBNAME#}">网站名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PHONE#}">联系电话</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PRODUCTNAME#}">产品名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PRICE#}">单价</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#NUMBER#}">预订数量</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#TOTALPRICE#}">总价</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PAYPRICE#}">支付金额</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#ORDERSN#}">订单号</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="clear">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">订单付款成功：</span>
                                <div class="item-bd">
                                    <div>
                                        <label class="radio-label"><input type="radio" name="isopen3" value="1" {if $order_msg3_open==1}checked="checked"{/if}/>开启</label>
                                        <label class="radio-label ml-20"><input type="radio" name="isopen3" value="0" {if $order_msg3_open==0}checked="checked"{/if}/>关闭</label>
                                    </div>
                                    <textarea class="textarea w900" name="order_msg3">{$order_msg3}</textarea>
                                    <div class="mt-5">
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#MEMBERNAME#}">会员名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#WEBNAME#}">网站名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#PHONE#}">联系电话</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#PRODUCTNAME#}">产品名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#PRICE#}">单价</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#NUMBER#}">预订数量</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#TOTALPRICE#}">总价</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#PAYPRICE#}">支付金额</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#ORDERSN#}">订单号</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#ETICKETNO#}">电子票号</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="clear">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">订单取消：</span>
                                <div class="item-bd">
                                    <div>
                                        <label class="radio-label"><input type="radio" name="isopen4" value="1" {if $order_msg4_open==1}checked="checked"{/if}/>开启</label>
                                        <label class="radio-label"><input type="radio" name="isopen4" value="0" {if $order_msg4_open==0}checked="checked"{/if}/>关闭</label>
                                    </div>
                                    <textarea class="textarea w900" name="order_msg4">{$order_msg4}</textarea>
                                    <div class="mt-5">
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#MEMBERNAME#}">会员名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#WEBNAME#}">网站名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PHONE#}">联系电话</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PRODUCTNAME#}">产品名称</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PRICE#}">单价</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#NUMBER#}">预订数量</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#TOTALPRICE#}">总价</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PAYPRICE#}">支付金额</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#ORDERSN#}">订单号</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix pt-10 pb-20">
                        <a href="javascript:;" class="btn btn-primary radius size-L ml-115" id="btn_save">保存</a>
                        <input type="hidden" name="msgtype" value="order_msg"/>
                    </div>
                </form>
            </td>
        </tr>
    </table>

<script>
   $(document).ready(function(){
         //添加标签
         $('.short-cut').click(function(){
                 var ele=$(this).parents('.item-bd:first').find('textarea');
                 var value=$(this).attr('data');
                 ST.Util.insertContent(value,ele);
         })

       //保存
       $("#btn_save").click(function(){
           $.ajax({
               url:SITEURL+'line/admin/line/ajax_save_email_msg',
               data: $('#frm').serialize(),
               type: "POST",
               dataType:'json',
               success:function(data){
                   if(data.status){
                       ST.Util.showMsg('保存成功',4);
                   }
               }
           })
           return false;
       })
   })


</script>


</body>
</html>
