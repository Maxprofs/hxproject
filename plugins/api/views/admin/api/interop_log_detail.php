<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>API交互日志详细信息</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js,template.js");}
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
    <style>
        input{ width: 280px;}
    </style>
</head>
<body style="background-color: #fff">

<form method="post" name="product_frm" id="product_frm">
	<ul class="info-item-block">
		<li>
			<span class="item-hd">API客户端：</span>
			<div class="item-bd lh-30">
				{$info['api_client_name']}
			</div>
		</li>
		<li>
			<span class="item-hd">API URL：</span>
			<div class="item-bd">
				<input class="input-text w250" type="input" id="url" name="url" value="{$info['url']}" readonly/>
			</div>
		</li>
		<li>
			<span class="item-hd">执行状态：</span>
			<div class="item-bd lh-30">
				{if $info['success'] == '0'} 
				  失败
                {else}
               	 成功
                {/if}
			</div>
		</li>
		<li>
			<span class="item-hd">信息：</span>
			<div class="item-bd">
				<textarea class="textarea w250" id="msg" name="msg" cols="40" rows="5" readonly>{$info['msg']}</textarea>
			</div>
		</li>
		<li>
			<span class="item-hd">调用者信息：</span>
			<div class="item-bd">
				<textarea class="textarea w250" id="remote_info" name="remote_info" cols="40" rows="5" readonly>{$info['remote_info']}</textarea>
			</div>
		</li>
		<li>
			<span class="item-hd">请求参数：</span>
			<div class="item-bd">
				<textarea class="textarea w250" id="request_params" name="request_params" cols="40" rows="5" readonly>{$info['request_params']}</textarea>
			</div>
		</li>
		<li>
			<span class="item-hd">时间：</span>
			<div class="item-bd lh-30">
				{$info['action_time_h']}
			</div>
		</li>
	</ul>
	<div class="clearfix">
		<a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">关闭</a>
	</div>
</form>


<script>

    $(document).ready(function () {
        $("#btn_save").click(function () {
            ST.Util.closeBox();
        });

    });
</script>

</body>
</html>
