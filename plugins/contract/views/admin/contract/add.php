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
{php Common::getEditor('jseditor','',$sysconfig['cfg_admin_htmleditor_width'],500,'Sline','','print',true);}
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:auto;">
            <div class="cfg-header-bar">
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
            </div>
            <form id="product_fm">
                <div class="product-add-div" >
                    <ul class="info-item-block">

                        <li>
                            <span class="item-hd">合同名称：</span>
                            <div class="item-bd">
                                <input type="text" name="title" data-required="true" value="{$info['title']}" class="input-text w900">
	                            <span class="item-text ml-10 c-999">*合同条款内容与笛卡无关</span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">所属产品：</span>
                            <div class="item-bd">
                                <div class="select-box w150">
                                    <select class="select" name="typeid">
                                        <option value="0">请选择</option>
                                        {loop $models $m}
                                        <option value="{$m['id']}" {if $info['typeid']==$m['id']}selected="selected"{/if} >{$m['shortname']}</option>
                                        {/loop}
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">乙方信息：</span>
                            <div class="item-bd">
                                <div class="select-box w150">
                                    <select class="select" name="partyBid">
                                        {if $default_partyB}
                                        <option value="0">请选择</option>
                                        {/if}
                                        {loop $party $p}
                                        <option value="{$p['id']}" {if $info['partyBid']==$p['id']||(!$info['partyBid']&&$default_partyB==$p['id'])}selected="selected"{/if} >{$p['name']}</option>
                                        {/loop}
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">合同条款：</span>
                            <div class="item-bd">
                                <textarea name="content" id="txt_content">{$info['content']}</textarea>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">合同状态：</span>
                            <div class="item-bd">
                                <label class="radio-label"><input type="radio" name="status"  {if $info['status']==1}checked="checked"{/if} value="1">开启</label>
                                <label class="radio-label ml-20"><input type="radio" name="status"  {if $info['status']==0}checked="checked"{/if} value="0">关闭</label>
                            </div>
                        </li>
                    </ul>

                </div>
                <input type="hidden" id="id" name="id" value="{$info['id']}">
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
            //window.content.setHeight(400);
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
                    url   :  SITEURL+"contract/admin/contract/ajax_save",
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
                            $("#id").val(text);
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
    });

</script>



</body>
</html>
