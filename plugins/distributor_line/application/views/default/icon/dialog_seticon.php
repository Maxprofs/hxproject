<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS4.0</title>
    {include "pub"}
    {Common::css('admin_base.css,admin_base2.css,admin_style.css,style.css,icon_dialog_seticon.css')}
    {Common::css('public/js/uploadify/uploadify.css',false,false)}
    {Common::css('public/js/artDialog/css/ui-dialog.css',false,false)}
    {Common::css('public/js/msgbox/msgbox.css',false,false)}
    {Common::js('jquery.min.js,artDialog/dist/dialog-plus.js,msgbox/msgbox.js,jquery.colorpicker.js,common.js,choose.js,product.js,uploadify/uploadify.js')}

</head>
<body >
   <div class="s-main">
       <div class="icon-list">
        {loop $icons $icon}
           <span class="icon-item {if in_array($icon['id'],$selIcons)}on{/if}" data-rel="{$icon['id']}"><img src="{$icon['picurl']}"/></span>
        {/loop}
           <div class="clear-both"></div>
       </div>
       <div class="save-con">
           <a href="javascript:;" class="confirm-btn">确定</a>
       </div>
   </div>
<script>
     var id="{$id}";
     var selector="{$selector}"
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
