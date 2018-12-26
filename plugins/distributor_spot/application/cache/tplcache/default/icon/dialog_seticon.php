<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS</title>
    <?php echo Common::css("admin_style.css,admin_base.css,admin_base2.css,icon_dialog_seticon.css");?>
    <?php echo Common::js("jquery.min.js,common.js,product.js,choose.js");?>
    <?php echo  Stourweb_View::template("pub/public_js");  ?>
</head>
<body >
   <div class="s-main">
       <div class="icon-list">
        <?php $n=1; if(is_array($icons)) { foreach($icons as $icon) { ?>
           <span class="icon-item <?php if(in_array($icon['id'],$selIcons)) { ?>on<?php } ?>
" data-rel="<?php echo $icon['id'];?>"><img src="<?php echo $icon['picurl'];?>"/></span>
        <?php $n++;}unset($n); } ?>
           <div class="clear-both"></div>
       </div>
       <div class="save-con">
           <a href="javascript:;" class="confirm-btn">确定</a>
       </div>
   </div>
<script>
     var id="<?php echo $id;?>";
     var selector="<?php echo $selector;?>"
     $(function(){
           $(document).on('click','.icon-item',function(){
                 if($(this).is('.on'))
                 {
                     $(this).removeClass('on');
                 }
                 else
                 {
                     $(this).addClass('on');
                 }
          });
           $(document).on('click','.confirm-btn',function(){
                var data=[];
                $(".icon-list .icon-item.on").each(function(index,element){
                     var id=$(element).attr("data-rel");
                     var url=$(element).find('img').attr('src');
                     data.push({id:id,url:url});
                });
               ST.Util.responseDialog({id:id,data:data,selector:selector},true);
           })
     })
</script>
</body>
</html>
