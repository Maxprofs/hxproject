<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>保险选择</title>
    <?php echo  Stourweb_View::template("pub");  ?>
    <?php echo Common::css('admin_base.css,admin_base2.css,admin_style.css,style.css,insurance_dialog_set.css');?>
    <?php echo Common::css('public/js/uploadify/uploadify.css',false,false);?>
    <?php echo Common::css('public/js/artDialog/css/ui-dialog.css',false,false);?>
    <?php echo Common::css('public/js/msgbox/msgbox.css',false,false);?>
    <?php echo Common::js('jquery.min.js,artDialog/dist/dialog-plus.js,msgbox/msgbox.js,jquery.colorpicker.js,common.js,choose.js,product.js,uploadify/uploadify.js');?>
</head>
<body>
<div class="s-main">
    <div class="s-body">
        <?php $n=1; if(is_array($products)) { foreach($products as $key => $product) { ?>
        <span class="sp-item"><input type="checkbox" name="productcode" class="i-box" value="<?php echo $product['id'];?>" <?php if(in_array($product['id'],$selids)) { ?>checked="checked"<?php } ?>
/><label class="i-tit" title="<?php echo $product['productname'];?>"><?php echo $product['productname'];?></label></span>
        <?php $n++;}unset($n); } ?>
        <div class="clear-both"></div>
    </div>
    <div class="save-con">
        <a href="javascript:;" class="confirm-btn">确定</a>
    </div>
</div>
<script>
    var id="<?php echo $id;?>";
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
