<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}短信平台</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,plist.css,sms_sms.css,base_new.css'); }
    {php echo Common::getScript('common.js,config.js,DatePicker/WdatePicker.js');}
</head>

<body>
<table class="content-tab" div_body=mIACXC >
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
    {php $j=0;}
    {loop $msg_config_data $msg_order_status_name $msg_order_status_value}
    {php $j++;}
    	<div class="clearfix">
    		<div class="msg-title"><strong class="bt-bar">{$msg_order_status_name}</strong></div><!--（*此项配置需在应用商城购买安装供应商相关功能才有效）-->  
    		{loop $msg_order_status_value $msg_recipients $msg_config_value}
            <div class="clear">
            	<ul class="info-item-block">
            		<li>
            			<span class="item-hd">通知{$msg_recipients}{if $n==2}{/if}：</span>
            			<div class="item-bd">
            				<div class="">
                                <label class="radio-label mr-20"><input type="radio" id="{$msg_config_value['msgtype']}_isopen" name="{$msg_config_value['msgtype']}_isopen" value="1" {if $msg_config_value['is_open']=='1'}checked="checked"{/if}/>开启</label>
                   
                    <label class="radio-label mr-20"><input type="radio" id="{$msg_config_value['msgtype']}_isopen" name="{$msg_config_value['msgtype']}_isopen" value="0" {if $msg_config_value['is_open']!='1'}checked="checked"{/if}/>关闭</label>
                           </div>
                           <textarea class="textarea w900" name="{$msg_config_value['msgtype']}" id="{$msg_config_value['msgtype']}">{$msg_config_value['templet']}</textarea>
                           <div class="mt-5">
                           		<a href="javascript:;" class="short-cut label-module-cur-item" data="{#MEMBERNAME#}">会员名称{$j}</a>
		                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#WEBNAME#}">网站名称</a>
		                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PHONE#}">联系电话</a>
		                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PRODUCTNAME#}">产品名称</a>
		                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PRICE#}">单价</a>
		                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#NUMBER#}">预订数量</a>
		                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#TOTALPRICE#}">总价</a>
                                <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PAYPRICE#}">支付金额</a>
		                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#ORDERSN#}">订单号</a>
		                        {if strpos($msg_config_value['msgtype'], 'order_msg3')!=0}
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
       </div>    	
    {/loop}
    </form>
	<div class="clear clearfix pt-10 pb-20">
        <a href="javascript:;" class="btn btn-primary radius size-L ml-115" id="normal-btn">保存</a>
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
            $.ajax({
                url:SITEURL+'noticemanager/ajax_save_sms_msg',
                data: $('#msgfrm').serialize(),
                type: "POST",
                dataType:'json',
                success:function(data){
                    if(data.status){
                        ST.Util.showMsg('保存成功',4);
                    }
                    else {
                        ST.Util.showMsg('保存失败',5);
                    }
                }
            })
            return false;
        })
    })
</script>

</body>
</html>
