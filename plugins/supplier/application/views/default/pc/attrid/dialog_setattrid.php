<!doctype html>
<html>
<head body_background=3Ya1fl >
    <meta charset="utf-8">
    <title>笛卡CMS4.0</title>
    {Model_Supplier::css('admin_base.css,admin_base2.css,admin_style.css,style.css,attrid_dialog_setattrid.css','')}
    {Common::css('public/js/uploadify/uploadify.css',false,false)}
    {Common::css('public/js/artDialog/css/ui-dialog.css',false,false)}
    {Common::css('public/js/msgbox/msgbox.css',false,false)}
    {Common::js('jquery.min.js,artDialog/dist/dialog-plus.js,msgbox/msgbox.js,jquery.colorpicker.js,common.js,choose.js,product.js,uploadify/uploadify.js')}
    {include "pub"}


</head>
<body >
   <div class="s-main">
       <div class="attr-list">
        {loop $attridList $list}
           {if !empty($list['children'])}
            <div class="con-row">
                <div class="con-tit">
                     {$list['attrname']}
                </div>
                <div class="con-list">
                    <ul>
                     {php $rowNum=6;$nextIndex=0}
                     {loop $list['children'] $key $row}
                        {if $key%$rowNum==0}
                          {php $nextIndex=$key+$rowNum-1;}
                          <li>
                        {/if}
                        <span class="item"><input type="checkbox" name="attrid" pid="{$list['id']}" pname="{$list['attrname']}" class="i-box" {if in_array($row['id'],$attrids)}checked="checked"{/if} value="{$row['id']}"/><label class="i-lb">{$row['attrname']}</label></span>
                        {if ($key==$nextIndex||$key==count($list['children'])-1) }
                         <div class="clear-both"></div></li>
                        {/if}
                     {/loop}
                     </ul>
                </div>
            </div>
           {/if}
        {/loop}
       </div>
       <div class="save-con">
           <a href="javascript:;" class="confirm-btn">确定</a>
       </div>
   </div>
<script>
     var id="{$id}";
     var selector="{$selector}"
     $(function(){

         window.setTimeout(function(){
             ST.Util.resizeDialog('.s-main');
         },0);

           $(document).on('click','.confirm-btn',function(){
                  var attrs=[];
                  var pids=[];



                  $('.item .i-box:checked').each(function(index,element){

                         var pid=$(element).attr('pid');
                         var pname=$(element).attr('pname');
                         if($.inArray(pid,pids)==-1)
                         {
                             attrs.push({id:pid,attrname:pname});
                             pids.push(pid);
                         }
                         var attrname=$(element).siblings('.i-lb:first').text();
                         var id=$(element).val();
                         attrs.push({id:id,attrname:attrname});
                  });

                 ST.Util.responseDialog({id:id,data:attrs,selector:selector},true);
           })






     })
</script>

</body>
</html>
