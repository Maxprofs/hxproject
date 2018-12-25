<div class="header_top bar-nav">
    <a class="back-link-icon" href="#myAccount" data-rel="back"></a>
    <h1 class="page-title-bar">实名认证</h1>
</div>
<!-- 公用顶部 -->

<div class="page-content">
    <div class="certification-on">
        {if $info['verifystatus']==3}
        <div class="msg-erro">
            <strong>认证失败：证信息不符!</strong>
            <i class="close"></i>
        </div>
        {/if}
        {if $info['verifystatus'] != 1}
        <form id="certification_frm">
            {if $info['verifystatus'] == 2}
            <div class="msg"><p>已认证</p></div>
            {else}
            <div class="msg"><p>请填写身份信息，通过后不能修改</p></div>
            {/if}
            <div class="content">
                <ul>
                    <li>
                        <div class="item">
                            <label class="lb">真实姓名</label>
                            <input class="txt input-text" type="text" id="truename" name="truename" {if $info['verifystatus']==2}readonly{/if} placeholder="请输入真实姓名" value="{if $info['verifystatus']==2 || $info['verifystatus']==3}{$info['truename']}{/if}" />
                            {if $info['verifystatus']==0 || $info['verifystatus']==3}
                            <i class="close clear hide"></i>
                            {/if}
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <label class="lb">身份证</label>
                            {if $info['cardid']}
                            {php $id_card = substr($info['cardid'],0,14) . '****';}
                            {else}
                            {php $id_card = '';}
                            {/if}
                            {if $info['verifystatus']==2}
                            <span class="txt">{$id_card}</span>
                            {else}
                            <input class="txt input-text" type="text" id="cardid" name="cardid" {if $info['verifystatus']==2}readonly{/if} placeholder="请输入身份证号码" value="{if $info['verifystatus']==2}{$id_card}{elseif $info['verifystatus']==3}{$info['cardid']}{/if}" />
                            {/if}
                            {if $info['verifystatus']==0 || $info['verifystatus']==3}
                            <i class="close clear hide"></i>
                            {/if}
                        </div>
                    </li>
                </ul>
            </div>
            <div class="card-onload">
                {if $info['verifystatus']==0 || $info['verifystatus']==3}
                <h3>请上传您的身份证正反面照片</h3>
                {else}
                <h3></h3>
                {/if}
                {if $info['verifystatus'] != 2}
                <div class="card-front">
                    <div id="uploadimg">
                        <div id="fileList" class="uploader-list"></div>
                    </div>
                    {if $info['verifystatus']!=2}
                    <!--<input type="file" class="file-upload" id="idcard_positive_file" />-->
                    <div class="imgPicker" id="imgPicker1"></div>
                    <input type="hidden" id="idcard_positive" name="idcard_positive" />
                    <img src="{$cmsurl}public/images/certification-front.png" width="100%" height="100%" alt="">
                    {else}
                    <img src="{$idcard_pic['front_pic']}" width="100%" height="100%" alt="">
                    {/if}
                </div>
                <div class="card-back">
                    {if $info['verifystatus']!=2}
                    <div id="uploadimg">
                        <div id="fileList" class="uploader-list"></div>
                    </div>
                    <!--<input type="file" class="file-upload" id="idcard_negative_file" />-->
                    <div class="imgPicker" id="imgPicker2"></div>
                    <input type="hidden" id="idcard_negative" name="idcard_negative" />
                    <img src="{$cmsurl}public/images/certification-back.png" width="100%" height="100%" alt="">
                    {else}
                    <img src="{$idcard_pic['verso_pic']}" width="100%" height="100%" alt="">
                    {/if}
                </div>
                {/if}
            </div>
            <div class="error-txt hide"><i class="ico"></i><span class="errormsg"></span></div>
            {if $info['verifystatus']!=2}
            <a class="card-btn" href="javascript:void(0)">确认</a>
            {/if}
        </form>
        {/if}
        {if $info['verifystatus']==1}
        <div class="certification-examine">
            <div class="pic"></div>
            <p>资料审核中...</p>
        </div>
        {/if}
    </div>
</div>
<script>
    var $certification_frm = $('#certification_frm');
    //表单验证
    $certification_frm.validate({
        ignore: [],
        rules: {
            truename: {
                required: true
            },
            cardid: {
                required: true,
                isIdCardNo:true
            },
            idcard_positive: {
                required: true
            },
            idcard_negative: {
                required: true
            }
        },
        messages: {
            truename: {
                required: '请填写真实姓名'
            },
            cardid: {
                required: '请填写身份证号',
                isIdCardNo:'身份证格式错误'
            },
            idcard_positive: {
                required: '请上传身份证正面照',
            },
            idcard_negative: {
                required: '请上传身份证反面照',
            }

        },
        errorPlacement: function (error, element) {
            var content = $('.errormsg').html();
            if (content == '') {
                error.appendTo($('.errormsg'));
            }
        },
        showErrors: function (errorMap, errorList) {
            if (errorList.length < 1) {
                $('.errormsg:eq(0)').html('');
                $('.error-txt').addClass('hide');
            } else {
                this.defaultShowErrors();
                $('.error-txt').removeClass('hide');
            }
        },
        submitHandler: function (form) {
            var formData = $certification_frm.serialize();
            $.ajax({
                type:'POST',
                url:SITEURL+'member/account/ajax_certification_save',
                data:formData,
                dataType:'json',
                success:function(data){
                    if(data.status){
                        $.layer({
                            type:1,
                            icon:1,
                            text:'提交成功,等待审核',
                            time:2000
                        });
                        setTimeout(function(){
                            window.location.reload();
                        },1000);
                    }else{
                        $.layer({
                            type:1,
                            icon:2,
                            text:data.msg,
                            time:2000
                        });
                    }
                }
            });


        }
    });

    $(function () {
        //正面上传实例
        var uploader1 = new WebUploader.Uploader({
            // 选完文件后，是否自动上传。
            auto: true,
            // swf文件路径
            swf: "//{$GLOBALS['main_host']}/res/js/webuploader/Uploader.swf",
            // 文件接收服务端。
            server: SITEURL + 'member/account/ajax_upload_img',
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick:'#imgPicker1',
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
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
            var $img_hide1 = $('#imgPicker1').next();
            var $img1 = $('#imgPicker1').parent().find('img');
            if(data.success == 'true'){
                $img1.attr('src',data.litpic);
                $img_hide1.val(data.litpic);
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
            layer.closeAll()
        });

        //背面上传实例
        var uploader2 = new WebUploader.Uploader({
            // 选完文件后，是否自动上传。
            auto: true,
            // swf文件路径
            swf: '/res/js/webuploader/Uploader.swf',
            // 文件接收服务端。
            server: SITEURL + 'member/account/ajax_upload_img',
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick:'#imgPicker2',
            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
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
        uploader2.on( 'uploadProgress', function( file, percentage ) {
            layer.open({type: 2});
        });
        // 文件上传成功
        uploader2.on( 'uploadSuccess', function( file,data) {
            var $img_hide2 = $('#imgPicker2').next();
            var $img2 = $('#imgPicker2').parent().find('img');
            if(data.success == 'true'){
                $img2.attr('src',data.litpic);
                $img_hide2.val(data.litpic);
            }else{
                layer.open({
                    content: data.msg,
                    skin: 'msg',
                    time: 2 //2秒后自动关闭
                });
            }
        });
        // 完成上传完了，成功或者失败，先删除进度条。
        uploader2.on( 'uploadComplete', function( file ) {
            layer.closeAll();
        });


        //上传身份证照片
        $('.file-upload').change(function () {
            var $this = $(this);
            var $img_hide = $this.next();
            var $img = $this.parent().find('img');
            var fileList = $this.prop('files');
//            return false;
            var fileData = getFileInfo(fileList);


            $.ajax({
                url:SITEURL + 'member/account/ajax_upload_img',
                type:'POST',
                data:fileData,
                cache:false,
                processData:false,
                contentType:false,
                dataType:'json',
                beforeSend:function () {
                    layer.open({type: 2});
                },
                success:function (data) {
                    layer.closeAll();
                    if(data.success == 'true'){
                        $img.attr('src',data.litpic);
                        $img_hide.val(data.litpic);
                    }else{
                        layer.open({
                            content: data.msg,
                            skin: 'msg',
                            time: 2 //2秒后自动关闭
                        });
                    }
                },
                error:function(){
                  $.layer.close();
                }
            });
        });

        //提交实名认证信息
        $('.card-btn').click(function () {
            $certification_frm.submit();
        });

        //关闭错误提示
        $('.msg-erro').find('.close').click(function () {
            $('.msg-erro').addClass('hide');
        });

        //显示关闭按钮
        $('.input-text').keyup(function () {
            var $close = $(this).parent().find('.close');
            var text = $(this).val();
            if(text != ''){
                $close.removeClass('hide');
            }else{
                $close.addClass('hide');
            }
        });
        
        //清空当前行
        $('.clear').click(function () {
            $(this).parent().find('.input-text').val('');
            $(this).parent().find('.close').addClass('hide');
        });
    });

    //身份证图片信息获取
    function getFileInfo(fileList) {
        var data = new FormData();
        data.append('Filedata',fileList[0]);
        return data;
    }
</script>
