<!doctype html>
<html>
<head div_left=5aKzDt >
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base.css,icon_dialog_seticon.css,base_new.css'); }
</head>
<body>

   <div class="s-main">
       <div class="icon-list">
        {loop $icons $icon}
           <label class="radio-label w100">
               <input  {if in_array($icon['id'],$selIcons)}checked{/if} type="checkbox" data-title="{$icon['kind']}"  data-rel="{$icon['id']}"/>
               <span class="i-lb">{$icon['kind']}</span>
           </label>
        {/loop}
           <div class="clear-both"></div>
       </div>
       <div class="clear clearfix text-c mt-10">
           <a href="javascript:;" id="confirm-btn" class="btn btn-primary radius size-L">确定</a>
       </div>
   </div>

<script>
     var id="{$id}";
     var selector="{$selector}";
     $(function(){
         window.setTimeout(function(){
             ST.Util.resizeDialog('.s-main');
         },0);
           $(document).on('click','#confirm-btn',function(){
                var data=[];
                $(".icon-list .radio-label input:checked").each(function(index,element){
                     var id=$(element).attr("data-rel");
                     var title=$(element).attr("data-title");
                     data.push({id:id,title:title});
                });
               ST.Util.responseDialog({id:id,data:data,selector:selector},true);
           })

     })
</script>

</body>
</html>
