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
    <div class="clearfix">
    	<div class="msg-title"><strong class="bt-bar">{$row['name']}</strong></div>
    	<div class="clear">
    		<ul class="info-item-block">
    			<li>
    				<span class="item-hd">通知游记作者</span>
    				<div class="item-bd">
    					<div class="">
    						<label class="radio-label mr-20"><input type="radio"  name="isopen[{$row['status']}]" value="1" {if $row['isopen']=='1'}checked="checked"{/if}/>开启</label>
                    <label class="radio-label mr-20"><input type="radio"  name="isopen[{$row['status']}]" value="0" {if $row['isopen']!='1'}checked="checked"{/if}/>关闭</label>
    					</div>
    					<textarea class="textarea w900" name="content[{$row['status']}]">{$row['content']}</textarea>
    					<div class="mt-5">
	                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#MEMBERNAME#}">会员名称</a>
	                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#WEBNAME#}">网站名称</a>
	                        <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PRODUCTNAME#}">游记名称</a>
	                    </div>
    				</div>
    			</li>
    		</ul>
    	</div>
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
            $.ajaxform({
                url:SITEURL+'notes/admin/notes/ajax_save_message',
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
