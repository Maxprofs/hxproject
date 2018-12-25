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
<table class="content-tab" strong_clear=5k1LPl >
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:auto;">
            <div class="cfg-header-bar">
                <div class="cfg-header-tab">
                    <span class="item on">乙方信息</span>
                </div>
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
            </div>
            <form id="product_fm">
                <div class="product-add-div" >
                    <ul class="info-item-block">

                        <li>
                            <span class="item-hd">乙方名称：</span>
                            <div class="item-bd">
                                <input type="text" name="name" data-required="true" value="{$config['name']}" class="input-text w300">
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">乙方电话：</span>
                            <div class="item-bd">
                                <input type="text" name="phone" data-required="true" value="{$config['phone']}" class="input-text w300">
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">乙方签章：</span>
                            <div class="item-bd">
                                <a href="javascript:;" id="file_upload" class="btn btn-primary radius size-S mt-5">上传图片</a>
                                <span class="item-text ml-10 c-999">*仅支持png格式，最佳尺寸150*150,未上传则不显示签章；上传后预览可查看效果</span>
                                <div class="pt-10 clearfix">
                                    <img src="{$config['seal']}" id="adimg" class="up-img-area">
                                </div>

                            </div>
                        </li>
                    </ul>
                </div>
                <input type="hidden" id="webid" name="webid" value="0">
                <input type="hidden" id="id" name="id" value="{$config['id']}">
                <input type="hidden" id="cfg_contract_seal" name="seal" value="{$config['seal']}">
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
                    url   :  SITEURL+"contract/admin/contract/config/action/save",
                    method  :  "POST",
                    form  : "#product_fm",
                    dataType  :  "json",
                    success  :  function(result)
                    {
                        if(result.status!=true)
                        {
                            ZENG.msgbox._hide();
                            ST.Util.showMsg('保存失败',5);
                        }
                        else
                        {
                            ST.Util.showMsg('保存成功',4)
                            window.location.reload();
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

        //上传图片
        $('#file_upload').click(function(){
            ST.Util.showBox('上传签章', SITEURL + 'image/insert_view/ext/png', 0,0, null, null, parent.document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                var temp =result.data[0].split('$$');
                var src = temp[0];
                if(!src.match(/\.png$/i))
                {
                    ST.Util.showMsg('只能选择png格式的图片!',5,1500);
                }
                else
                {
                    if(src){
                        $("#adimg").attr('src',src);
                        $('#cfg_contract_seal').val(src);
                    }
                }
            }
        })
    });

</script>



</body>
</html>
