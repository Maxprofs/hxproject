<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,choose.js,DatePicker/WdatePicker.js,product_add.js,st_validate.js,jquery.colorpicker.js,jquery.jqtransform.js,imageup.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>

    <!--顶部-->
    {php Common::getEditor('jseditor','',$sysconfig['cfg_admin_htmleditor_width'],300,'Sline','','print',true);}
    <table class="content-tab" html_clear=zwpE7l >
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:auto;">
                <form id="product_fm">
                    <div class="cfg-header-bar">
                        <div class="cfg-header-tab">
                            <span class="item on" id="column_basic" onclick="Product.switchTabs(this,'basic')">基础信息</span>
                            <span class="item" id="column_image" onclick="Product.switchTabs(this,'image')">相册图片</span>
                            <span class="item" id="column_image" onclick="Product.switchTabs(this,'seo')">优化信息</span>
                            <span class="item" id="column_extend" onclick="Product.switchTabs(this,'extend')">扩展配置</span>
                        </div>
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
                    <div class="product-add-div" id="content_basic">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">相册名称：</span>
                                <div class="item-bd">
                                    <input type="text" name="title" data-required="true" value="{$info['title']}" class="input-text w500">
                                    <input type="hidden" id="photoid" name="photoid" value="{$info['id']}">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">站点：</span>
                                <div class="item-bd">
                                    <span class="select-box w200">
                                        <select class="select" name="webid">
                                            <option value="0" {if $info['webid']==0}selected="selected"{/if} >主站</option>
                                           {loop $weblist $web}
                                                <option value="{$web['webid']}" {if $web['webid']==$info['webid']}selected="selected"{/if}>{$web['webname']}</option>
                                           {/loop}
                                        </select>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">目的地选择：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-4" onclick="Product.getDest(this,'.dest-sel',6)"  title="选择">选择</a>
                                    <div class="save-value-div mt-2 ml-10 dest-sel">
                                        {loop $info['kindlist_arr'] $k $v}
                                       <span class="{if $info['finaldestid']==$v['id']}finaldest{/if}" title="{if $info['finaldestid']==$v['id']}最终目的地{/if}" ><s onclick="$(this).parent('span').remove()"></s>{$v['kindname']}<input type="hidden" class="lk" name="kindlist[]" value="{$v['id']}"/>
                                           {if $info['finaldestid']==$v['id']}<input type="hidden" class="fk" name="finaldestid" value="{$info['finaldestid']}"/>{/if}</span>
                                        {/loop}
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">相册分类：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-4"onclick="Product.getAttrid(this,'.attr-sel',6)" title="选择">选择</a>
                                    <div class="save-value-div mt-2 ml-10 attr-sel">
                                        {loop $info['attrlist_arr'] $k $v}
                                        <span><s onclick="$(this).parent('span').remove()"></s>{$v['attrname']}<input type="hidden" name="attrlist[]" value="{$v['id']}"></span>
                                        {/loop}
                                    </div>
                                </div>
                            </li>
                            <!--  <dl>
                                <dt>相册编辑：</dt>
                                <dd>
                                    <input type="text" class="set-text-xh text_300 mt-2" name="author" value="{$info['author']}">
                                </dd>
                            </dl>-->
                            <li>
                                <span class="item-hd">前台隐藏：</span>
                                <div class="item-bd">
                                    <label class="radio-label"><input type="radio" name="ishidden"  {if $info['ishidden']==0}checked="checked"{/if} value="0">显示</label>
                                    <label class="radio-label"><input type="radio" name="ishidden"  {if $info['ishidden']==1}checked="checked"{/if} value="1">隐藏</label>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">相册介绍：</span>
                                <div class="item-bd">
                                    <textarea class="textarea w900" name="content">{$info['content']}</textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="content_image" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">相册图片：</span>
                                <div class="item-bd">
                                    <div class="">
                                        <div id="pic_btn" class="btn btn-primary radius size-S">上传图片</div>
                                        <span class="item-text c-999 ml-10">建议上传尺寸770*690px以内</span>
                                    </div>
                                    <div class="up-list-div">
                                        <ul class="pic-sel">
                                        </ul>
                                        <input id="litpic" type="hidden" value="{$info['litpic']}"/>
                                        <input type="hidden" class="headimgindex" name="imgheadindex" value="">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="content_seo" class="product-add-div content-hide" >
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">优化标题：</span>
                                <div class="item-bd">
                                    <input type="text" name="seotitle" id="seotitle" class="input-text w900" value="{$info['seotitle']}">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">Tag词：</span>
                                <div class="item-bd">
                                    <input type="text" id="tagword" name="tagword" class="input-text w500" value="{$info['tagword']}">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">关键词：</span>
                                <div class="item-bd">
                                    <input type="text" name="keyword" id="keyword" class="input-text w500" value="{$info['keyword']}">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">页面描述：</span>
                                <div class="item-bd">
                                    <textarea class="textarea w900" name="description" id="description" cols="" rows="">{$info['description']}</textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="content_extend" class="product-add-div content-hide" >
                        {php Common::genExtendData(6,$extendinfo);}
                    </div>
                </form>
                <div class="clear clearfix pt-20 pb-20">
                    <a class="btn btn-primary radius size-L ml-115" id="save_btn" href="javascript:;">保存</a>
                    <!--<a class="save" href="javascript:;" onclick="nextStep()">下一步</a>-->
                </div>
            </td>
        </tr>
    </table>

<script>
 $(document).ready(function(e) {


     $("#product_fm input").st_readyvalidate();


     $("#save_btn").click(function(e) {
         var validate=$("#product_fm input").st_govalidate({require:function(element,index){
             $(element).css("border","1px solid red");
             if(index==1)
             {
                 var switchDiv=$(element).parents(".product-add-div").first();
                 if(switchDiv.is(":hidden")&&!switchId)
                 {
                     var switchId=switchDiv.attr('id');
                     var columnId=switchId.replace('content','column');
                     $("#"+columnId).trigger('click');
                 }

             }
         }});
         if(validate==true)
         {
             ST.Util.showMsg('保存中',6,10000);
             $.ajaxform({
                 url   :  SITEURL+"photo/admin/photo/ajax_photosave",
                 method  :  "POST",
                 form  : "#product_fm",
                 dataType  :  "html",
                 success  :  function(result)
                 {
                     var text = result;
                     if(window.isNaN(text))
                     {
                         ZENG.msgbox._hide();
                         ST.Util.showMsg('保存失败',5);
                     }
                     else
                     {
                         $("#photoid").val(text);
                         ST.Util.showMsg('保存成功',4)
                     }
                 }});

         }
         else
         {
             ST.Util.showMsg("请将信息填写完整",1,1200);
         }
     });

     $('#pic_btn').click(function(){
         ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
         function Insert(result,bool){
             var len=result.data.length;
             for(var i=0;i<len;i++){
                 var temp =result.data[i].split('$$');
                 Imageup.genePic(temp[0],".up-list-div ul",".cover-div",temp[1]);
             }
         }
     })



 });



</script>
<script>
    {if $action=='edit'}
        var piclist = ST.Modify.getUploadFile({$info['piclist_arr']});
        $(".pic-sel").html(piclist);
        var litpic = $("#litpic").val();
        $(".img-li").find('img').each(function(i,item){

            if($(item).attr('src')==litpic){
                var obj = $(item).parents('.img-li').first().find('.btn-ste')[0];
                Imageup.setHead(obj,i+1);

            }
        })
        window.image_index= $(".pic-sel").find('li').length;//已添加的图片数量
        {/if}
</script>

</body>
</html>
