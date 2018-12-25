<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title clear_body=rxACXC >笛卡CMS{$coreVersion}短信平台</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,plist.css,sms_sms.css'); }
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
            <div class="list-top-set">
                <div class="list-web-pad"></div>
                <div class="list-web-ct">
                    <table class="list-head-tb">
                        <tbody><tr>
                            <td class="head-td-lt">

                            </td>
                            <td class="head-td-rt">
                                <a href="javascript:;" class="refresh-btn" onclick="window.location.reload()">刷新</a>

                        </tr>
                        </tbody></table>
                </div>
            </div>
            <div class="manage-nr">

                <div class="sms-set">

                    <div class="msg-switcher">

                        <div class="info-one">
                            <form id="frm">
                                <div class="set-one">
                                    <div class="set-one-box">
                                        <div class="box-tit">订单未处理</div>
                                        <div class="box-con">
                                            <textarea name="order_msg1">{$order_msg1}</textarea>
                                        </div>
                                    </div>
                                    <div class="set-one-tool">
                                        <div class="tool-cs">
                                            <span><input type="radio" name="isopen1" value="1" {if $order_msg1_open==1}checked="checked"{/if}/><label>开启</label></span>
                                            <span><input type="radio" name="isopen1" value="0" {if $order_msg1_open==0}checked="checked"{/if}/><label>关闭</label></span>
                                        </div>
                                        <div class="tool-bn">
                                            <a href="javascript:;" class="short-cut" data="{#MEMBERNAME#}">会员名称</a>
                                            <a href="javascript:;" class="short-cut" data="{#WEBNAME#}">网站名称</a>
                                            <a href="javascript:;" class="short-cut" data="{#PHONE#}">联系电话</a>
                                            <a href="javascript:;" class="short-cut" data="{#PRODUCTNAME#}">产品名称</a>
                                            <a href="javascript:;" class="short-cut" data="{#PRICE#}">单价</a>
                                            <a href="javascript:;" class="short-cut" data="{#NUMBER#}">预订数量</a>
                                            <a href="javascript:;" class="short-cut" data="{#TOTALPRICE#}">总价</a>
                                            <a href="javascript:;" class="short-cut" data="{#PAYPRICE#}">支付金额</a>
                                            <a href="javascript:;" class="short-cut" data="{#ORDERSN#}">订单号</a>
                                            <a href="javascript:;" class="short-cut" data="{#USEDATE#}">入住时间</a>
                                            <a href="javascript:;" class="short-cut" data="{#DEPARTDATE#}">离店时间</a>

                                            <div class="clear-both"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="set-one">
                                    <div class="set-one-box">
                                        <div class="box-tit">订单处理中</div>
                                        <div class="box-con">
                                            <textarea name="order_msg2">{$order_msg2}</textarea>
                                        </div>
                                    </div>
                                    <div class="set-one-tool">
                                        <div class="tool-cs">
                                            <span><input type="radio" name="isopen2" value="1" {if $order_msg2_open==1}checked="checked"{/if}/><label>开启</label></span>
                                            <span><input type="radio" name="isopen2" value="0" {if $order_msg2_open==0}checked="checked"{/if}/><label>关闭</label></span></div>
                                        <div class="tool-bn">
                                            <a href="javascript:;" class="short-cut" data="{#MEMBERNAME#}">会员名称</a>
                                            <a href="javascript:;" class="short-cut" data="{#WEBNAME#}">网站名称</a>
                                            <a href="javascript:;" class="short-cut" data="{#PHONE#}">联系电话</a>
                                            <a href="javascript:;" class="short-cut" data="{#PRODUCTNAME#}">产品名称</a>
                                            <a href="javascript:;" class="short-cut" data="{#PRICE#}">单价</a>
                                            <a href="javascript:;" class="short-cut" data="{#NUMBER#}">预订数量</a>
                                            <a href="javascript:;" class="short-cut" data="{#TOTALPRICE#}">总价</a>
                                            <a href="javascript:;" class="short-cut" data="{#PAYPRICE#}">支付金额</a>
                                            <a href="javascript:;" class="short-cut" data="{#ORDERSN#}">订单号</a>
                                            <a href="javascript:;" class="short-cut" data="{#USEDATE#}">入住时间</a>
                                            <a href="javascript:;" class="short-cut" data="{#DEPARTDATE#}">离店时间</a>
                                            <div class="clear-both"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="set-one">
                                    <div class="set-one-box">
                                        <div class="box-tit">订单付款成功</div>
                                        <div class="box-con">
                                            <textarea name="order_msg3">{$order_msg3}</textarea>
                                        </div>
                                    </div>
                                    <div class="set-one-tool">
                                        <div class="tool-cs"><span><input type="radio" name="isopen3" value="1" {if $order_msg3_open==1}checked="checked"{/if}/><label>开启</label></span>
                                            <span><input type="radio" name="isopen3" value="0" {if $order_msg3_open==0}checked="checked"{/if}/><label>关闭</label></span>
                                        </div>
                                        <div class="tool-bn">
                                            <a href="javascript:;" class="short-cut" data="{#MEMBERNAME#}">会员名称</a>
                                            <a href="javascript:;" class="short-cut" data="{#WEBNAME#}">网站名称</a>
                                            <a href="javascript:;" class="short-cut" data="{#PHONE#}">联系电话</a>
                                            <a href="javascript:;" class="short-cut" data="{#PRODUCTNAME#}">产品名称</a>
                                            <a href="javascript:;" class="short-cut" data="{#PRICE#}">单价</a>
                                            <a href="javascript:;" class="short-cut" data="{#NUMBER#}">预订数量</a>
                                            <a href="javascript:;" class="short-cut" data="{#TOTALPRICE#}">总价</a>
                                            <a href="javascript:;" class="short-cut" data="{#PAYPRICE#}">支付金额</a>
                                            <a href="javascript:;" class="short-cut" data="{#ORDERSN#}">订单号</a>
                                            <a href="javascript:;" class="short-cut" data="{#ETICKETNO#}">电子票号</a>
                                            <a href="javascript:;" class="short-cut" data="{#USEDATE#}">入住时间</a>
                                            <a href="javascript:;" class="short-cut" data="{#DEPARTDATE#}">离店时间</a>
                                            <div class="clear-both"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="set-one">
                                    <div class="set-one-box">
                                        <div class="box-tit">订单取消</div>
                                        <div class="box-con">
                                            <textarea name="order_msg4">{$order_msg4}</textarea>
                                        </div>
                                    </div>
                                    <div class="set-one-tool">
                                        <div class="tool-cs"><span><input type="radio" name="isopen4" value="1" {if $order_msg4_open==1}checked="checked"{/if}/><label>开启</label></span>
                                            <span><input type="radio" name="isopen4" value="0" {if $order_msg4_open==0}checked="checked"{/if}/><label>关闭</label></span>
                                        </div>
                                        <div class="tool-bn">
                                            <a href="javascript:;" class="short-cut" data="{#MEMBERNAME#}">会员名称</a>
                                            <a href="javascript:;" class="short-cut" data="{#WEBNAME#}">网站名称</a>
                                            <a href="javascript:;" class="short-cut" data="{#PHONE#}">联系电话</a>
                                            <a href="javascript:;" class="short-cut" data="{#PRODUCTNAME#}">产品名称</a>
                                            <a href="javascript:;" class="short-cut" data="{#PRICE#}">单价</a>
                                            <a href="javascript:;" class="short-cut" data="{#NUMBER#}">预订数量</a>
                                            <a href="javascript:;" class="short-cut" data="{#TOTALPRICE#}">总价</a>
                                            <a href="javascript:;" class="short-cut" data="{#PAYPRICE#}">支付金额</a>
                                            <a href="javascript:;" class="short-cut" data="{#ORDERSN#}">订单号</a>
                                            <a href="javascript:;" class="short-cut" data="{#USEDATE#}">入住时间</a>
                                            <a href="javascript:;" class="short-cut" data="{#DEPARTDATE#}">离店时间</a>
                                            <div class="clear-both"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="set-save">
                                    <a href="javascript:;" class="normal-btn" id="btn_save">保存</a>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>


        </td>
    </tr>
</table>
<script language="javascript">
    $(function(){

        $('.set-one .short-cut').click(function(){
            var ele=$(this).parents('.set-one:first').find('.box-con textarea');
            var value=$(this).attr('data');
            ST.Util.insertContent(value,ele);

        })

        //保存
        $("#btn_save").click(function(){
            $.ajax({
                url:SITEURL+'hotel/admin/hotel/ajax_save_sms_msg',
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
