<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>属性配置</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>

	<div class="middle-con" >
        <form name="frm" id="frm" html_size=4Ii_Tk >
            <ul class="info-item-block">
                <li>
                   <span class="item-hd">属性名称：</span>
                   <div class="item-bd">{$info['attrname']}</div>
                </li>
                <li>
                    <span class="item-hd">属性描述：</span>
                    <div class="item-bd" >
                        <input type="text" name="description" class="set-text-xh w300" value="{$info['description']}">
                    </div>
                </li>
                <li>
                    <span class="item-hd">属性图片：</span>
                    <div class="item-bd">
                        <div class="up-file-div lh30 mt5 fl">
                            <div id="file_upload" class="btn-file mt-4"><div id="file_upload-button" class="uploadify-button " style="text-indent: -9999px; height: 25px; line-height: 25px; width: 80px; cursor: pointer"><span class="uploadify-button-text">上传图片</span></div></div>
                            {if !empty($info['litpic'])}
                            <div id="img"><img id="litimg" class="up-img-area" src="{$info['litpic']}" /></div>
                            {else}
                            <div id="img"><img id="litimg" class="up-img-area" src="{php echo Common::getDefaultImage();}" /></div>
                            {/if}
                        </div>
                    </div>
                </li>
            </ul>
            <div class="clear clearfix mt-5 text-c">
                <a class="btn btn-primary radius size-L ml-115" id="save_btn" href="javascript:;">保存</a>
            </div>
            <input type="hidden" name="litpic" id="litpic" value="{$info['litpic']}">
            <input type="hidden" name="attrid" id="attrid" value="{$info['id']}"/>
            <input type="hidden" name="typeid" value="{$typeid}"/>
        </form>
    </div>

	<script>
        $(function(){

            //上传图片
           $('#file_upload-button').css('backgroundImage','url("'+PUBLICURL+'images/upload-ico.png'+'")');
            $('#file_upload').click(function(){
                ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, parent.document, {loadWindow: window, loadCallback: Insert});
                function Insert(result,bool){
                    if(result.data.length>0){
                        var len=result.data.length-1;
                        var temp =result.data[len].split('$$');
                        $('#litimg')[0].src=temp[0];
                        $("#litpic").val(temp[0]);
                    }
                }
            });


            $("#save_btn").click(function(){

                var ajaxurl = SITEURL + 'line/admin/attrid/ajax_config_save';

                $.ajaxform({
                    url: ajaxurl,
                    method: 'POST',
                    form : '#frm',
                    dataType:'json',
                    success: function (data) {

                        if(data.status)
                        {

                            ST.Util.showMsg('保存成功',4);
                            //ST.Util.closeBox();//关闭当前窗口
                            //parent.window.getNav();

                        }
                        else
                        {
                            ST.Util.showMsg('保存失败',5);
                        }

                    }

                });


            })
        })

	</script>
</body>
</html>
