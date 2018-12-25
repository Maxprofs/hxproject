<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,st_validate.js,jquery.colorpicker.js,jquery.jqtransform.js,imageup.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>

    <!--顶部-->
    {php Common::getEditor('jseditor','',$sysconfig['cfg_admin_htmleditor_width'],300,'Sline','','print',true);}
    <table class="content-tab" padding_font=0sqjwk >
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:auto;">
                <div class="cfg-header-bar">
                    <div class="cfg-header-tab">
                        <span class="item on" id="column_basic" onclick="Product.switchTabs(this,'basic')">基础信息</span>
                        {loop $columns $column}
                        <span class="item" id="column_{$column['columnname']}" onclick="Product.switchTabs(this,'{$column['columnname']}',switchBack)">{$column['chinesename']}</span>
                        {/loop}
                        <span class="item" id="column_youhua" onclick="Product.switchTabs(this,'youhua')">优化信息</span>
                        <span class="item" id="column_extend" onclick="Product.switchTabs(this,'extend')">扩展信息</span>
                    </div>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <form id="product_fm">
                    <div class="product-add-div" id="content_basic">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">站点：</span>
                                <div class="item-bd">
                                    <div class="select-box w150">
                                        <select class="select" name="webid">
                                            <option value="0" {if $info['webid']==0}selected="selected"{/if} >主站</option>
                                            {loop $weblist $k}
                                            <option value="{$k['webid']}" {if $info['webid']==$k['webid']}selected="selected"{/if} >{$k['webname']}</option>
                                            {/loop}
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">车辆名称{Common::get_help_icon('product_car_title')}：</span>
                                <div class="item-bd">
                                    <input type="text" name="title" data-required="true" value="{$info['title']}" class="input-text w900">
                                    <input type="hidden" id="carid" name="carid" value="{$info['id']}">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">车辆卖点{Common::get_help_icon('product_car_sellpoint')}：</span>
                                <div class="item-bd">
                                    <input type="text" name="sellpoint" value="{$info['sellpoint']}"  class="input-text w900"/>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">车型：</span>
                                <div class="item-bd">
                                    <div class="select-box w150">
                                        <select class="select" name="carkindid">
                                            {loop $carkindidlist $k}
                                            <option value="{$k['id']}" {if $info['carkindid']==$k['id']}selected="selected"{/if} >{$k['kindname']}</option>
                                            {/loop}
                                        </select>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">座位数：</span>
                                <div class="item-bd">
                                    <input type="text" name="seatnum" data-regrex="number"  data-msg="必须为数字" value="{$info['seatnum']}" class="input-text w150">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">建议乘客数：</span>
                                <div class="item-bd">
                                    <input type="text" name="maxseatnum" value="{$info['maxseatnum']}" data-regrex="number"  data-msg="必须为数字" class="input-text w150">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">使用年限：</span>
                                <div class="item-bd">
                                    <input type="text" name="usedyears" data-regrex="number" value="{$info['usedyears']}"  data-msg="必须为数字" class="input-text w150">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">咨询电话：</span>
                                <div class="item-bd">
                                    <input type="text" name="phone" value="{$info['phone']}" class="input-text w150">
                                </div>
                            </li>
                        </ul>
                        <div class="line"></div>
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">供应商选择：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3 va-t" onclick="Product.getSupplier(this,'.supplier-sel',3)"  title="选择">选择</a>
                                    <div class="save-value-div ml-10 supplier-sel w700">
                                       {if !empty($info['supplier_arr']['id'])}
                                        <span class="mb-5"><s onclick="$(this).parent('span').remove()"></s>{$info['supplier_arr']['suppliername']}<input type="hidden" name="supplierlist[]" value="{$info['supplier_arr']['id']}"></span>
                                       {/if}
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">目的地选择：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3 va-t" onclick="Product.getDest(this,'.dest-sel',3)" title="选择">选择</a>
                                    <div class="save-value-div ml-10 dest-sel w700">
                                        {loop $info['kindlist_arr'] $k $v}
                                           <span class="mb-5 {if $info['finaldestid']==$v['id']}finaldest{/if}" title="{if $info['finaldestid']==$v['id']}最终目的地{/if}" ><s onclick="$(this).parent('span').remove()"></s>{$v['kindname']}<input type="hidden" class="lk" name="kindlist[]" value="{$v['id']}"/>
                                               {if $info['finaldestid']==$v['id']}<input type="hidden" class="fk" name="finaldestid" value="{$info['finaldestid']}"/>{/if}</span>
                                        {/loop}
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">车辆属性：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3 va-t" onclick="Product.getAttrid(this,'.attr-sel',3)" title="选择">选择</a>
                                    <div class="save-value-div ml-10 attr-sel w700">
                                        {loop $info['attrlist_arr'] $k $v}
                                         <span class="mb-5"><s onclick="$(this).parent('span').remove()"></s>{$v['attrname']}<input type="hidden" name="attrlist[]" value="{$v['id']}"></span>
                                        {/loop}
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">前台隐藏：</span>
                                <div class="item-bd">
                                    <label class="radio-label"><input type="radio" name="ishidden"  {if $info['ishidden']==0}checked="checked"{/if} value="0">显示</label>
                                    <label class="radio-label ml-20"><input type="radio" name="ishidden"  {if $info['ishidden']==1}checked="checked"{/if} value="1">隐藏</label>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">显示模版：</span>
                                <div class="item-bd">
                                    <div class="temp-chg" id="templet_list">
                                        <a {if $info['templet']==''}class="on"{/if}  href="javascript:void(0)"  data-value="" onclick="setTemplet(this)">标准</a>
                                        {loop $templetlist $r}
                                        <a {if $info['templet']==$r['path']}class="on"{/if}  href="javascript:void(0)" data-value="{$r['path']}" onclick="setTemplet(this)">{$r['templetname']}</a>
                                        {/loop}
                                        <input type="hidden" name="templet" id="templet" value="{$info['templet']}"/>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="line"></div>
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">图标设置：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3 va-t" onclick="Product.getIcon(this,'.icon-sel')"  title="选择">选择</a>
                                    <div class="save-value-div ml-10 icon-sel w700">
                                        {loop $info['iconlist_arr'] $k $v}
                                         <span class="mb-5"><s onclick="$(this).parent('span').remove()"></s><img src="{$v['picurl']}"><input type="hidden" name="iconlist[]" value="{$v['id']}"></span>
                                        {/loop}
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">显示数据：</span>
                                <div class="item-bd">
                                    <span class="item-text">推荐次数<input type="text" name="recommendnum" value="{$info['recommendnum']}" data-regrex="number" data-msg="*必须为数字" class="input-text w80 ml-5"></span>
                                    <span class="item-text ml-20" name="satisfyscore">满意度<input type="text" name="satisfyscore" class="input-text w80 ml-5" data-regrex="number" data-msg="*必须为数字" value="{$info['satisfyscore']}"></span>
                                    <span class="item-text ml-20">销量<input type="text" name="bookcount" class="input-text w80 ml-5" data-regrex="number" data-msg="*必须为数字" value="{$info['bookcount']}"></span>
                                </div>
                            </li>
                        </ul>
                        <div class="line"></div>
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">预订送积分策略：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3 va-t" onclick="Product.getJifenbook(this,'.jifenbook-sel',3)" title="选择">选择</a>
                                    <div class="save-value-div ml-10 jifenbook-sel">
                                        {if !empty($info['jifenbook_info'])}
                                        <span><s onclick="$(this).parent('span').remove()"></s>{$info['jifenbook_info']['title']}({$info['jifenbook_info']['value']}{if $info['jifenbook_info']['rewardway']==1}%{/if}积分)
                                            {if $info['jifenbook_info']['isopen']==0}<a class="cor_f00">[已关闭]</a>{/if}<input type="hidden" name="jifenbook_id" value="{$info['jifenbook_info']['id']}">
                                        </span>
                                        {/if}
                                    </div>
                                    <span class="item-text c-999 ml-10">*未选择的情况下默认使用全局策略</span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">积分抵现策略：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3 va-t" onclick="Product.getJifentprice(this,'.jifentprice-sel',3)" title="选择">选择</a>
                                    <div class="save-value-div ml-10 jifentprice-sel">
                                        {if !empty($info['jifentprice_info'])}
                                        <span><s onclick="$(this).parent('span').remove()"></s>{$info['jifentprice_info']['title']}({$info['jifentprice_info']['toplimit']}积分)
                                            {if $info['jifentprice_info']['isopen']==0}<a class="cor_f00">[已关闭]</a>{/if}<input type="hidden" name="jifentprice_id" value="{$info['jifentprice_info']['id']}">
                                        </span>
                                        {/if}
                                    </div>
                                    <span class="item-text c-999 ml-10">*未选择的情况下默认使用全局策略</span>
                                </div>
                            </li>
                        </ul>
                        <div class="line"></div>
                    </div>
                    <div class="product-add-div content-hide" id="content_content">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">车辆信息：</span>
                                <div class="item-bd">
                                    <textarea name="content" id="txt_content">{$info['content']}</textarea>
                                </div>
                            </li>
                         </ul>
                    </div>
                    <div class="product-add-div content-hide" id="content_notice">
	                    <ul class="info-item-block">
		                    <li>
			                    <span class="item-hd" id="content_notice_title"></span>
			                    <div class="item-bd">
				                    <textarea name="notice" id="txt_notice">{$info['notice']}</textarea>
			                    </div>
		                    </li>
	                    </ul>


                    </div>
                    <div class="product-add-div content-hide" id="content_tupian">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">租车相册：</span>
                                <div class="item-bd">
                                    <div class="">
                                        <div id="pic_btn" class="btn btn-primary radius size-S mt-3 va-t">上传图片</div>
                                        <span class="item-text c-999 ml-10">建议上传尺寸1024*695px</span>
                                    </div>
                                    <div class="up-list-div">
                                        <ul class="pic-sel">
                                        </ul>
                                        <input id="litpic" type="hidden" value="{$info['litpic']}"/>
                                        <input type="hidden" class="headimgindex" name="imgheadindex" value="<?php  echo $head_index;  ?>">
                                    </div>
                                </div>
                            </li>
                        </ul>
                     </div>
                    <div class="product-add-div content-hide" id="content_youhua">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">优化标题：</span>
                                <div class="item-bd">
                                    <input type="text" name="seotitle" id="seotitle" class="input-text w900" value="{$info['seotitle']}" >
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">Tag词：</span>
                                <div class="item-bd">

                                    <input type="text" id="tagword" name="tagword" class="input-text w900 " value="{$info['tagword']}" >
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">关键词：</span>
                                <div class="item-bd">
                                    <input type="text" name="keyword" id="keyword" name="keyword" class="input-text w900" value="{$info['keyword']}">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">页面描述：</span>
                                <div class="item-bd">
                                    <textarea class="textarea w900"  name="description" id="description" cols="" rows="">{$info['description']}</textarea>
                                </div>
                            </li>

                        </ul>
                    </div>
                    {php $contentArr=Common::getExtendContent(3,$extendinfo);}
                    {php echo $contentArr['contentHtml'];}
                    <div class="product-add-div content-hide" data-id="extend" id="content_extend">
                        {php echo $contentArr['extendHtml'];}
                    </div>
                </form>
                <div class="clear clearfix pt-20 pb-20">
                    <a class="btn btn-primary radius size-L ml-115" id="save_btn" href="javascript:;">保存</a>
                </div>
            </td>
        </tr>
    </table>

<script>
    //保存状态
    window.is_saving = 0;
 $(document).ready(function(e) {
     window.content=window.JSEDITOR('txt_content');
     window.content.ready(function(){
          window.content.setHeight(200);
     })

     window.notice=window.JSEDITOR('txt_notice');
     window.notice.ready(function(){
             window.notice.setHeight(200);
         })

     $("#product_fm input").st_readyvalidate();

     $("#save_btn").click(function(e) {
         //检测是否是在保存状态
         if(is_saving == 1){
             return false;
         }
         window.is_saving = 1;
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
                 url   :  SITEURL+"car/admin/car/ajax_carsave",
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
                         // Ext.get('line_id').setValue(text);
                         $("#carid").val(text);
                         ST.Util.showMsg('保存成功',4)
                     }
                     window.is_saving = 0;
                 }});

         }
         else
         {
             ST.Util.showMsg("请将信息填写完整",1,1200);
             window.is_saving = 0;
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
 //设置模板
 function setTemplet(obj)
 {
     var templet = $(obj).attr('data-value');
     $(obj).addClass('on').siblings().removeClass('on');
     $("#templet").val(templet);

 }


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

        //切换时的回调函数
        function switchBack(columnname)
        {

            if($('#column_'+columnname).length>0){
                if( $('#content_'+columnname+'_title').length>0){
                    $('#content_'+columnname+'_title').html($('#column_'+columnname).text()+'：');
                }
            }

        }
 </script>

</body>
</html>
