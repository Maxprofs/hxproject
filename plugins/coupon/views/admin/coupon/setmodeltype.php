<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title clear_background=868Vrl >笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base.css,attrid_dialog_setattrid.css'); }
</head>
<body >
   <div class="s-main">
       <div class="attr-list">
           {if $sysmodels}
            <div class="con-row">
                <div class="con-tit">
                     系统应用
                </div>
                <div class="con-list">
                    <ul>
                        <li>
                            {loop $sysmodels $model}
                            <span class="item"><label ><input type="checkbox" modulename="{$model['modulename']}"    {if in_array($model['id'],$models)}checked="checked"{/if} value="{$model['id']}"/>{$model['modulename']}</label></span>
                            {/loop}
                            <div class="clear-both"></div>
                        </li>
                    </ul>
                </div>
            </div>
           {/if}
           {if $extendmodels}
           <div class="con-row">
               <div class="con-tit">
                   扩展应用
               </div>
               <div class="con-list">
                   <ul>
                       <li>
                           {loop $extendmodels $model}
                           <span class="item"><label ><input modulename="{$model['modulename']}" type="checkbox"   {if in_array($model['id'],$models)}checked="checked"{/if} value="{$model['id']}"/>{$model['modulename']}</label></span>
                           {/loop}
                           <div class="clear-both"></div>
                       </li>
                   </ul>
               </div>
           </div>
           {/if}

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
                  var checkmodels=[];
                  $('.item input:checked').each(function(index,element){
                         var modulename=$(element).attr('modulename');
                         var id=$(element).val();
                      checkmodels.push({id:id,modulename:modulename});
                  });
                 ST.Util.responseDialog({data:checkmodels,selector:selector},true);
           })






     })
</script>

</body>
</html>
