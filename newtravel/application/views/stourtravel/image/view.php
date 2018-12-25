<!doctype html>
<html>
<head div_body=mIACXC >
    <meta charset="utf-8">
    <title>添加分组-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); }
</head>
<body>
<div class="content-in new_add_file">
	<ul class="info-item-block">
		<li>
			<span class="item-hd">相册名称：</span>
			<div class="item-bd">
				<input type="text" id="name" name="name" class="input-text w200" maxlength="20" />
			</div>
		</li> 
		<li>
			<span class="item-hd">相册描述：</span>
			<div class="item-bd">
				<textarea id="desc" class="textarea w200" name="desc" cols=""  rows=""></textarea>
			</div>
		</li>
	</ul>
    
    <div class="text-c">
        <a class="btn btn-grey-outline size radius cancel_btn mr-10" href="#">取消</a>
        <a class="btn btn-primary size radius confirm_btn" href="javascript:;">确定</a>
    </div>
</div>
<!--创建相册-->

</body>
<script type="text/javascript" charset="utf-8">
    $(function(){
        $("#name").blur(function(){
           $(this).val($(this).val().replace(/^\s*/,'').replace(/\s*$/,''));
        });
        $('.cancel_btn').live('click', function () {
            ST.Util.closeBox();
        });
        $('.confirm_btn').click(function(){
            var name=$("#name").val();
            var desc=$("#desc").val();
            if(name.length<1){
                ST.Util.showMsg("请填写相册名称", 1);
                return;
            }
            ST.Util.responseDialog({status:0,data:{name:name,description:desc}},true);
        });
    })


</script>
</html>
