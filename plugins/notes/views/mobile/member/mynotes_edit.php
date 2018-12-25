<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>发布游记</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    {Common::css('base.css,mobilebone.css')}
    {Common::css_plugin('note.css','notes')}
    {Common::js('lib-flexible.js,jquery.min.js,template.js,mobilebone.js,jquery.validate.js')}
    {Common::js('layer/layer.m.js')}
    {Common::js('artEditor.js')}
    <script type="text/javascript" src="//{$GLOBALS['main_host']}/res/js/webuploader/webuploader.min.js"></script>
</head>
<style>
    .upload_content{
        width: 100%;height:3.466667rem;
    }
    .webuploader-container .webuploader-element-invisible{
        display: none;
    }
    .inputEdit{
        width: 100%;
        min-height: 300px;
        box-sizing: border-box;
        padding: 10px;
        color: #444;
    }
    #imageUploadContent div[id^="rt_rt_"]{
        z-index: 12;
    }
</style>
<body>
<form id="note_info" body_html=DDACXC >
<div class="page out" id="publishNoteFirst">
    <div class="header_top">
        <a class="back-link-icon back_my_notes" data-ajax="false" data-href="{$cmsurl}member/#&{$cmsurl}notes/member"></a>
        <h1 class="page-title-bar">{if $info['id']}编辑{else}发布{/if}游记</h1>
    </div>
    <!-- 公用顶部 -->

    <div class="page-content">
        <input type="hidden" id="banner" name="banner" value="{$info['litpic']}"/>
        <input type="hidden" id="noteid" name="noteid" value="{$info['id']}"/>
        <input type="hidden" name="frmcode" value="{$frmcode}"/>
        <div class="publish-note-area">

            <div class="publish-note-fm" id="imageUploadContent">
                <div class="upload_content">{if $info['litpic']}<img src="{Common::img($info['litpic'],358,258)}">{/if}</div>
            </div>

            <div class="publish-note-title">
                <textarea class="input-edit" id="inputEdit" name="title" maxlength="40" placeholder="输入游记标题(40个字以内)">{if $info}{$info['title']}{/if}</textarea>
            </div>
            <div class="footer-btn-bar">
                <a href="#publishNoteWrite" id="next_edit" class="btn-v">下一步</a>
            </div>

        </div>


    </div>

</div>
<!-- 发布游记 -->

<div class="page out" id="publishNoteWrite">
    <div class="header_top">
        <a class="back-link-icon" href="#publishNoteFirst" data-rel="back"></a>
        <h1 class="page-title-bar">{if $info['id']}编辑{else}发布{/if}游记</h1>
    </div>
    <!-- 公用顶部 -->

    <div class="page-content">
        <div class="publish-note-area">
            <div class="publish-article-content">
                <input type="hidden" id="target">
                <div class="article-content" id="notesContent">
                    {if $info}{$info['content']}{/if}
                </div>
                <div class="footer-btn g-image-upload-box">
                    <div class="upload-button">
                        <span class="upload"><i class="upload-img"></i>插入图片</span>
                        <input class="input-file" id="imageUpload" type="file" name="fileInput" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="footer-btn-bar">
                <a href="javascript:;" id="save_notes" class="btn-v">{if $info['id']}保存{else}发布{/if}</a>
            </div>

        </div>


    </div>

</div>
</form>
<!-- 发布游记 -->

<script>
    var is_editing=false;
    $(function () {
        //banner上传实例
        var uploader1 = new WebUploader.Uploader({
            // 选完文件后，是否自动上传。
            auto: true,
            // swf文件路径
            swf: "//{$GLOBALS['main_host']}/res/js/webuploader/Uploader.swf",
            // 文件接收服务端。
            server: '{$cmsurl}notes/member/ajax_upload_img',
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {
                id: '#imageUploadContent',
                multiple:false
            },
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            //限制只能上传一个文件
            fileNumLimit: 1,
            compress:{
                width: 1600,
                height: 1600,
                // 图片质量。仅仅有type为`image/jpeg`的时候才有效。
                quality: 90,
                // 是否同意放大，假设想要生成小图的时候不失真。此选项应该设置为false.
                allowMagnify: false,
                // 是否同意裁剪。
                crop: false,
                // 是否保留头部meta信息。
                preserveHeaders: true,
                // 假设发现压缩后文件大小比原来还大，则使用原来图片
                // 此属性可能会影响图片自己主动纠正功能
                noCompressIfLarger: false,
                // 单位字节，假设图片大小小于此值。不会採用压缩。(大于2M压缩)
                compressSize: 1024*1024*2
            }
        });
        // 文件上传过程中创建进度条实时显示。
        uploader1.on( 'uploadProgress', function( file, percentage ) {
            layer.open({type: 2});
        });
        // 文件上传成功
        uploader1.on( 'uploadSuccess', function( file,data) {
            var $imgBanner = $('#banner');
            if(data.status){
                $('div.upload_content').html('<img src="'+data.cover+'"/>');
                $imgBanner.val(data.litpic);
                is_editing=true;
            }else{
                layer.open({
                    content: data.msg,
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
            }
        });
        // 完成上传完了，成功或者失败，先删除进度条。
        uploader1.on( 'uploadComplete', function( file ) {
            layer.closeAll();
        });
        //切换监听
        Mobilebone.callback = function(pageIn,pageOut,options) {
            if(pageIn.id==='publishNoteFirst'){
                uploader1.refresh();//刷新容器
            }
        };

        $("#inputEdit").change(function(){
            is_editing=true;
        });
        $('#notesContent').change(function () {
            is_editing=true;
        });
        if($("#noteid").val())
        {
            is_editing=true;
        }
        $("a.back_my_notes").unbind('click').bind('click',function(){
            var url=$(this).data('href');
            if(is_editing)
            {
                layer.open({
                    content: '要放弃本次编辑吗？',
                    btn: ['放弃', '继续'],
                    yes: function(index){
                        window.location.href=url;
                    }
                })
            }
            else
            {
                window.location.href=url;
            }
        });
        $(".publish-note-fm:after").click(function () {
            $("#imageUploadContent").trigger('click');
        });

        $("#save_notes").unbind('click').bind('click',function(){
            var _content = $.trim($('#notesContent').html());
            var default_content='<div class="placeholader" style="pointer-events: none;">记录旅行感悟(限1500字)</div>';
            if(!_content||_content==default_content)
            {
                layer.open({
                    content: '内容不能为空',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                return false;
            }
            var _banner = $("[name=banner]").val();
            if(!_banner)
            {
                layer.open({
                    content: '封面图片未设置',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                $("a.back-link-icon[href='#publishNoteFirst']")[0].click();
                return false;
            }
            var _title = $("[name=title]").val();
            if(!$.trim(_title))
            {
                layer.open({
                    content: '标题不能为空',
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
                $("a.back-link-icon[href='#publishNoteFirst']")[0].click();
                return false;
            }
            var noteid=$("#noteid").val();
            var frmcode=$("input[name=frmcode]").val();
            $.ajax({
                type:'POST',
                url:'{$cmsurl}notes/member/ajax_save',
                data:{
                    "frmcode":frmcode,
                    "noteid":noteid,
                    "cover":_banner,
                    "title":_title,
                    "content":_content,
                },
                dataType:'json',
                success:function(data){
                    if(data.status){
                        var msg;
                        if(noteid)
                        {
                            msg='保存成功';
                        }
                        else
                        {
                            msg='提交成功,等待审核';
                        }
                        layer.open({
                            content:msg,
                            skin: 'msg',
                            time: 2 //2秒后自动关闭
                        });
                        is_editing=false;
                        $("a.back-link-icon.back_my_notes")[0].click();
                    }else{
                        layer.open({
                            content: data.msg,
                            skin: 'msg',
                            time: 2 //2秒后自动关闭
                        });
                    }
                }
            });
        });

        $('#notesContent').artEditor({
            imgTar: '#imageUpload',
            limitSize: 10,   // 兆
            showServer: true,
            uploadUrl: '{$cmsurl}notes/member/ajax_upload_base64Img',
            data: {},
            uploadField: 'image',
            breaks: false,
            placeholader: '记录旅行感悟(限1500字)',
            validHtml: ["p"],
            formInputId: 'target',
            uploadSuccess: function (res) {
                // 这里是处理返回数据业务逻辑的地方
                // `res`为服务器返回`status==200`的`response`
                // 如果这里`return <path>`将会以`<img src='path'>`的形式插入到页面
                // 如果发现`res`不符合业务逻辑
                // 比如后台告诉你这张图片不对劲
                // 麻烦返回 `false`
                // 当然如果`showServer==false`
                // 无所谓咯
                var result = JSON.parse(res);
                if (result.status) {
                    return result.url;
                } else {
                    alert(result.msg)
                }
                return false;
            },
            uploadError: function (status, error) {
                //这里做上传失败的操作
                //也就是http返回码非200的时候
                alert('网络异常' + status)
            }
        });
    });
</script>
</body>
</html>