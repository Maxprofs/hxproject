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
<table class="content-tab" style="">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:hidden">
            <form id="product_fm">
                <div class="s-main">
                    <div class="main-body">
                        <div class="cfg-header-bar">
                            <div class="cfg-header-tab">
                                <span data-rel="seo" class="item on"><s></s>优化信息</span>
                                <span  data-rel="jieshao" class="item"><s></s>页面介绍</span>
                                <span data-rel="template" class="item"><s></s>模板设置</span>
                            </div>
                            <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                        </div>
                        <div class="product-add-div">
                            <div class="nav-list">
                              <form method="post">
                                <div class="item-one" id="item_jieshao" style="display: none;">
                                    <ul class="info-item-block">
                                        <li>
                                            <span class="item-hd">介绍：</span>
                                            <div class="item-bd">{php Common::getEditor('jieshao',$info['jieshao'],900,300);}</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="item-one" id="item_seo">
                                    <ul class="info-item-block">
                                        <!--<li>
                                            <span class="item-hd">显示条数：</span>
                                            <div class="item-bd"><input class="input-text w300" name="shownum" value="{$info['shownum']}"/></div>
                                        </li>-->
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
                                            <div class="item-bd"><textarea class="textarea w900 des" name="description">{$info['description']}</textarea></div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="" id="item_template" style="display: none;">
                                    <ul class="info-item-block">
                                        <li>
                                            <span class="item-hd">模板：</span>
                                            <div class="item-bd">
                                                    <a href="javascript:;" data-rel="" class="i-tpl mr-5 label-module-item {if empty($info['templetpath'])}label-module-cur-item{/if}">标准</a>
                                                    {loop $templateList $tpl}
                                                    <a href="javascript:;" data-rel="{$tpl['path']}" class="i-tpl mr-5 label-module-item {if $info['templetpath']==$tpl['path']}label-module-cur-item{/if}">{$tpl['path']}</a>
                                                    {/loop}
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                  <input type="hidden" name="kindid" value="{$id}"/>
                              </form>
                            </div>
                        </div>
                    </div>
                    <div class="clear clearfix mt-5">
                        <a href="javascript:;" class="confirm-btn btn btn-primary radius size-L ml-115">确定</a>
                    </div>
                </div>
            </form>
        </td>
    </tr>
</table>
<script>
    var id="{$id}";
    var typeid="{$typeid}";
    $(function() {
        $(document).on('click',".i-tpl",function(){
            $(".i-tpl").removeClass('label-module-cur-item');
            $(this).addClass('label-module-cur-item');
        });
        $(document).on('click',".cfg-header-tab span",function(){
            var name=$(this).attr('data-rel');
            $(this).siblings().removeClass('on');
            $(".nav-list .item-one").hide();

            $(this).addClass('on');
            $("#item_"+name).show();
        });

        $(document).on('click','.confirm-btn',function(){

            var templetpath=$(".i-tpl.label-module-cur-item").attr("data-rel");
            var ajaxurl=SITEURL+'notes/admin/destination/ajax_save';
            $.ajaxform({
                url: ajaxurl,
                data:{templetpath:templetpath},
                method: 'POST',
                form : '#product_fm',
                dataType:'json',
                success: function (data) {
                    if(data.status)
                    {
                        ST.Util.showMsg('保存成功',4);
                    }
                    else
                    {
                        ST.Util.showMsg('保存失败',5);
                    }
                }

            });
            
           /* var data={};
            data['seotitle']=$(".main-body input[name=seotitle]").val();
            data['tagword']=$(".main-body input[name=tagword]").val();
            data['keyword']=$(".main-body input[name=keyword]").val();
            data['description']=$(".main-body textarea[name=description]").val();
            data['shownum']=$(".main-body input[name=shownum]").val();
            data['jieshao']=jieshaoEditor.getContent();
            data['templetpath']=$(".i-tpl.on").attr("data-rel");
            ST.Util.responseDialog({id:id,typeid:typeid,data:data},true);*/




        });
    })
</script>

</body>
</html>

