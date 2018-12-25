<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>API客户端添加/修改</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js,template.js");}
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
    <style type="text/css">
        .hidebroder{
            border: 0px
        }
    </style>
</head>
<body style="background-color: #fff">

<form method="post" name="product_frm" id="product_frm">
	<ul class="info-item-block">
		{if !empty($info['id'])}
		<li>
			<span class="item-hd">ID{Common::get_help_icon('plugin_api_edit_client_id')}：</span>
			<div class="item-bd">
				<input class="input-text w250" type="input" id="id" name="id" value="{$info['id']}" readonly />
			</div>
		</li>
		{/if}
		<li>
			<span class="item-hd">名称{Common::get_help_icon('plugin_api_edit_client_name')}：</span>
			<div class="item-bd">
				<input type="input" id="name" name="name" value="{$info['name']}" class="input-text w250"/>
			</div>
		</li>
		{if !empty($info['secret_key'])}
		<li>
			<span class="item-hd">通信密钥{Common::get_help_icon('plugin_api_edit_client_secret_key')}：</span>
			<div class="item-bd">
				<input type="input" id="secret_key" name="secret_key" value="{$info['secret_key']}" class="input-text w250" readonly/>
			</div>
		</li>
		{/if}
		<li>
			<span class="item-hd">扩展配置{Common::get_help_icon('plugin_api_edit_client_ext_config')}：</span>
			<div class="item-bd">
				<textarea id="config" name="config" rows="5" class="textarea w250">{$info['config']}</textarea>
			</div>
		</li>
		<li>
			<span class="item-hd">状态：</span>
			<div class="item-bd">
				<span class="select-box w150">
					<select class="select" id="status" name="status">
	                    <option value="1" {if $info['status']=='1'}selected{/if}>正常</option>
	                    <option value="0" {if $info['status']=='0'}selected{/if}>停用</option>
	                </select>
				</span>	
			</div>
		</li>
	</ul>
	<div class="clearfix">
		<a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
	</div>
    <div class="out-box-con">




        <dl class="list_dl">
            <dt class="wid_90">&nbsp;</dt>
            <dd>
                
            </dd>
        </dl>


    </div>
</form>


<script>

    $(document).ready(function () {
        $("#btn_save").click(function () {
            if ($('#name').val() == '') {
                ST.Util.showMsg('请填写“名称”', '3', 2000);
                return false;
            }
            //保存
            ST.Util.showMsg("保存中...", 6, 1000000);
            $.ajax({
                type: 'post',
                url: SITEURL + "api/admin/client/ajax_save_client",
                data: $("#product_frm").serialize(),
                dataType: 'json',
                success: function (rs) {
                    ST.Util.hideMsgBox();
                    if (rs.status === 1) {
                        ST.Util.showMsg('保存成功', 4);
                        setTimeout(function(){
                            ST.Util.closeBox();
                        },1000);

                    } else {
                        ST.Util.showMsg(rs.msg, 5, 3000);
                    }
                }
            });
        });

    });
</script>

</body>
</html>
