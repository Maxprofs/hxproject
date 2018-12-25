<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,listimageup.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
    {php echo Common::getCss('base.css,style.css,destination_dialog_basicinfo.css,base_new.css'); }
</head>
<body >
   <div class="s-main">
       <div class="main-body">
           <div class="cfg-header-bar nav">
               <div class="cfg-header-tab">
                   <span data-rel="seo" class="item on">优化信息</span>
                   <span  data-rel="jieshao" class="item">页面介绍</span>
                   <span data-rel="template" class="item">模板设置</span>
               </div>
               <div class="clear-both"></div>
           </div>
           <div class="nav-list">
               <div class="item-one" id="item_jieshao" style="display: none;">
               		<ul class="info-item-block">
               			<li>
               				<span class="item-hd">介绍：</span>
               				<div class="item-bd">
               					{php Common::getEditor('jieshao',$info['jieshao'],400,250);}
               				</div>
               			</li>
               		</ul>
               </div>
               <div class="item-one" id="item_seo">
               		<ul class="info-item-block">
               			<li>
               				<span class="item-hd">优化标题：</span>
               				<div class="item-bd"><input class="input-text w300" name="seotitle" value="{$info['seotitle']}"/></div>
               			</li>
               			<li>
               				<span class="item-hd">Tag词：</span>
               				<div class="item-bd"><input class="input-text w300" name="tagword" value="{$info['tagword']}"/></div>
               			</li>
               			<li>
               				<span class="item-hd">关键词：</span>
               				<div class="item-bd"><input class="input-text w300" name="keyword" value="{$info['keyword']}"/></div>
               			</li>
               			<li>
               				<span class="item-hd">描述：</span>
               				<div class="item-bd"><textarea class="textarea w300" name="description">{$info['description']}</textarea></div>
               			</li>
               		</ul>
               </div>
               
               <div class="item-one" id="item_template" style="display: none;">
               		<ul class="info-item-block">
               			<li>
               				<span class="item-hd">模板：</span>
               				<div class="item-bd">
               					<a href="javascript:;" data-rel="" class="label-module-item mr-5 {if empty($info['templetpath'])}label-module-cur-item{/if}">标准</a>
                               	{loop $templateList $tpl}
                               	<a href="javascript:;" data-rel="{$tpl['path']}" class="label-module-item mr-5 {if $info['templetpath']==$tpl['path']}label-module-cur-item{/if}">{$tpl['path']}</a>
                               	{/loop}
               				</div>
               			</li>
               		</ul>
               </div>

           </div>
       </div>


       <div class="clear clearfix">
           <a href="javascript:;" class="btn btn-primary radius size-L ml-115 mt-5" id="confirm-btn">确定</a>
       </div>
   </div>
<script>
    var id="{$id}";
    var typeid="{$typeid}"
    $(function() {
        $(document).on('click',".label-module-item",function(){
            $(".label-module-item").removeClass('label-module-cur-item');
            $(this).addClass('label-module-cur-item');
        })
        $(document).on('click',".nav span",function(){
            var name=$(this).attr('data-rel');
            $(this).siblings().removeClass('on');
            $(".nav-list .item-one").hide();

            $(this).addClass('on');
            $("#item_"+name).show();
        })

        $(document).on('click','#confirm-btn',function(){
            var data={};
            data['seotitle']=$(".main-body input[name=seotitle]").val();
            data['tagword']=$(".main-body input[name=tagword]").val();
            data['keyword']=$(".main-body input[name=keyword]").val();
            data['description']=$(".main-body textarea[name=description]").val();
            data['shownum']=$(".main-body input[name=shownum]").val();
            data['jieshao']=jieshaoEditor.getContent();
            data['templetpath']=$(".label-module-item.label-module-cur-item").attr("data-rel");
            ST.Util.responseDialog({id:id,typeid:typeid,data:data},true);
        })
    })
</script>

</body>
</html>
