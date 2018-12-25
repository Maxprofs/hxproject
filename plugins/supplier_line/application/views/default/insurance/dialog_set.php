<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>保险选择</title>
    {include "pub"}
    {Common::css('admin_base.css,admin_base2.css,admin_style.css,style.css,insurance_dialog_set.css')}
    {Common::css('public/js/uploadify/uploadify.css',false,false)}
    {Common::css('public/js/artDialog/css/ui-dialog.css',false,false)}
    {Common::css('public/js/msgbox/msgbox.css',false,false)}
    {Common::js('jquery.min.js,artDialog/dist/dialog-plus.js,msgbox/msgbox.js,jquery.colorpicker.js,common.js,choose.js,product.js,uploadify/uploadify.js')}
</head>

<body>
<div class="s-main">
    <div class="s-body">
        {loop $products $key $product}
        <span class="sp-item"><input type="checkbox" name="productcode" class="i-box" value="{$product['id']}" {if in_array($product['id'],$selids)}checked="checked"{/if}/><label class="i-tit" title="{$product['productname']}">{$product['productname']}</label></span>
        {/loop}
        <div class="clear-both"></div>
    </div>
    <div class="save-con">
        <a href="javascript:;" class="confirm-btn">确定</a>
    </div>
</div>
<script>
    var id="{$id}";
    $(".confirm-btn").click(function () {
        var data = [];
        $(".sp-item").each(function (index, ele) {
            if($(ele).find('input:checked').length>0)
            data.push({id: $(ele).find("input:checkbox").val(), 'productname': $(ele).find("label").text()});
        });
        ST.Util.responseDialog({id:id,data:data},true);

    });

</script>
</body>
</html>
