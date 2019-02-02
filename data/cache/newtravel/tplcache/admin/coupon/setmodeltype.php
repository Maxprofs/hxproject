<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title clear_background=868Vrl >笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('base.css,attrid_dialog_setattrid.css'); ?>
</head>
<body >
   <div class="s-main">
       <div class="attr-list">
           <?php if($sysmodels) { ?>
            <div class="con-row">
                <div class="con-tit">
                     系统应用
                </div>
                <div class="con-list">
                    <ul>
                        <li>
                            <?php $n=1; if(is_array($sysmodels)) { foreach($sysmodels as $model) { ?>
                            <span class="item"><label ><input type="checkbox" modulename="<?php echo $model['modulename'];?>"    <?php if(in_array($model['id'],$models)) { ?>checked="checked"<?php } ?>
 value="<?php echo $model['id'];?>"/><?php echo $model['modulename'];?></label></span>
                            <?php $n++;}unset($n); } ?>
                            <div class="clear-both"></div>
                        </li>
                    </ul>
                </div>
            </div>
           <?php } ?>
           <?php if($extendmodels) { ?>
           <div class="con-row">
               <div class="con-tit">
                   扩展应用
               </div>
               <div class="con-list">
                   <ul>
                       <li>
                           <?php $n=1; if(is_array($extendmodels)) { foreach($extendmodels as $model) { ?>
                           <span class="item"><label ><input modulename="<?php echo $model['modulename'];?>" type="checkbox"   <?php if(in_array($model['id'],$models)) { ?>checked="checked"<?php } ?>
 value="<?php echo $model['id'];?>"/><?php echo $model['modulename'];?></label></span>
                           <?php $n++;}unset($n); } ?>
                           <div class="clear-both"></div>
                       </li>
                   </ul>
               </div>
           </div>
           <?php } ?>
       </div>
       <div class="save-con">
           <a href="javascript:;" class="confirm-btn">确定</a>
       </div>
   </div>
<script>
     var id="<?php echo $id;?>";
     var selector="<?php echo $selector;?>"
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
