<!doctype html> <html> <head> <meta charset="utf-8"> <title>实名认证-<?php echo $webname;?></title> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('user.css,base.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,jquery.validate.js,jquery.cookie.js,user-center-operate.js,jquery.validate.addcheck.js,jquery.upload.js');?> <?php echo Common::js('layer/layer.js');?> <!--引入CSS--> <?php echo Common::css('res/js/webuploader/webuploader.css',false,false);?> <!--引入JS--> <?php echo Common::js('webuploader/webuploader.min.js');?> <!--引入自定义CSS--> <?php echo Common::css('res/css/web-uploader-custom.css',false,false);?> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>">首页</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;会员中心
            </div> <!--面包屑--> <div class="st-main-page"> <?php echo  Stourweb_View::template("member/left_menu");  ?> <!-- 会员中心导航 --> <div class="user-cont-box"> <div class="real-name-container"> <div class="real-name-bar">实名认证</div> <div class="real-name-wrapper"> <div class="real-name-step"> <ul class="step-item clearfix"> <li class="item-child item-first step-on"> <span class="speed"> <i class="num-icon">1</i> <em class="txt-label">填写资料</em> </span> </li> <li class="item-child item-second <?php if($info['verifystatus']>0&&$is_update==0) { ?> step-on <?php } ?>
"> <span class="speed"> <i class="num-icon">2</i> <em class="txt-label">资料审核</em> </span> </li> <li class="item-child item-third <?php if($info['verifystatus']==2&&$is_update==0) { ?> step-on<?php } ?> <?php if($info['verifystatus']==3&&$is_update==0) { ?> step-fail<?php } ?>
"> <span class="speed"> <i class="num-icon">3</i> <em class="txt-label"><?php if($info['verifystatus']==3) { ?>审核失败 <?php } else { ?> 审核通过<?php } ?> </em> </span> </li> </ul> </div> <!-- 认证进度 --> <div class="rn-info-box"> <?php if($info['verifystatus']==0||$is_update==1) { ?> <form id="sub_frm"  method="post" action="<?php echo $cmsurl;?>member/index/do_modify_idcard"> <ul class="rn-info-block"> <li> <strong class="item-hd"><i class="star-icon">*</i>真实姓名：</strong> <div class="item-bd"> <input class="default-text" type="text" name="truename" placeholder="请填写真实姓名" value="<?php echo $info['truename'];?>" /> </div> </li> <li> <strong class="item-hd"><i class="star-icon">*</i>身份证号码：</strong> <div class="item-bd"> <input class="default-text" type="text" name="cardid" placeholder="请填写身份证号码" value="<?php echo $info['cardid'];?>" /> </div> </li> <li> <strong class="item-hd"><i class="star-icon">*</i>身份证正面：</strong> <div class="item-bd"> <p class="update-txt">仅支持JPG，PNG、GIF格式图片，大小不超过2M，要求姓名和身份证号清晰可见</p> <div class="update-box"> <span class="update-before-area" data-type="1"> <?php if($info['idcard_pic']['front_pic']) { ?> <img src="<?php echo Common::img($info['idcard_pic']['front_pic'],198,123);?>" width="198" height="123" /> <?php } else { ?> <i class="icon upbtn" id="imgPicker1"></i> <em class="sm">请上传身份证正面照片</em> <?php } ?> </span> <?php if($info['idcard_pic']['front_pic']) { ?> <a href="javascript:;" data-id="imgPicker1" class="update-delete-btn">删除</a> <?php } ?> <input class="pic_hidden" type="hidden" value="<?php echo $info['idcard_pic']['front_pic'];?>" id="front_pic" name="front_pic"> </div> </div> </li> <li> <strong class="item-hd"><i class="star-icon">*</i>身份证背面：</strong> <div class="item-bd"> <p class="update-txt">仅支持JPG，PNG、GIF格式图片，大小不超过2M，要求姓名和身份证号清晰可见</p> <div class="update-box"> <span class="update-before-area" data-type="2"> <?php if($info['idcard_pic']['verso_pic']) { ?> <img src="<?php echo Common::img($info['idcard_pic']['verso_pic'],198,123);?>" width="198" height="123" /> <?php } else { ?> <i class="icon upbtn" id="imgPicker2"></i> <em class="sm">请上传身份证背面照片</em> <?php } ?> </span> <?php if($info['idcard_pic']['verso_pic']) { ?> <a href="javascript:;" data-id="imgPicker2" class="update-delete-btn">删除</a> <?php } ?> <input class="pic_hidden"  type="hidden" value="<?php echo $info['idcard_pic']['verso_pic'];?>" id="verso_pic" name="verso_pic"> </div> </div> </li> <li> <strong class="item-hd"></strong> <div class="item-bd"> <a class="submit-rz-btn" href="javascript:;">提交</a> </div> </li> </ul> </form> <?php } ?> <!-- 填写资料 --> <?php if($is_update==0) { ?> <?php if($info['verifystatus']==1) { ?> <div class="rn-load-block "> <i class="icon"></i> <p class="txt">资料审核中...</p> </div> <?php } else if($info['verifystatus']==2) { ?> <!-- 审核中 --> <div class="rn-pass-block "> <dl> <dt><i class="icon"></i>实名认证成功！</dt> <dd> <p>真实姓名：<?php echo $info['truename'];?></p> <p>身份证号码：<?php echo substr_replace($info['cardid'],'********',3,11);?></p> </dd> </dl> </div> <?php } else if($info['verifystatus']==3) { ?> <!-- 认证成功 --> <div class="rn-fail-block "> <dl> <dt><i class="icon"></i>实名认证失败！</dt> <dd> <p class="txt">失败原因：证信息不符。</p> <a class="back-step-link" href="<?php echo $cmsurl;?>member/index/modify_idcard?is_update=1">重新填写</a> </dd> </dl> </div> <?php } ?> <?php } ?> <!-- 认证失败 --> </div> <!-- 认证需求 --> </div> </div> </div> <!--实名认证--> </div> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> </body> </html> <script>
    $(function(){
        upload("#imgPicker1");
        upload("#imgPicker2");
        //上传图片
//        $('.rn-info-block').on('click','.upbtn',function(){
//            upload(this);
//        });
        $('.rn-info-block').on('click','.update-delete-btn',function(){
            var obj = $(this).parent().parent().find('.update-before-area');
            if(obj.attr('data-type')==1)
            {
                var msg = '请上传身份证正面照片';
            }
            else if(obj.attr('data-type')==2)
            {
                var msg = '请上传身份证背面照片';
            }
            var uploader=$(this).data('id');
            var html = '<i class="icon upbtn" id="'+uploader+'"></i><em class="sm">'+msg+'</em>';
            $(this).parent().parent().find('.update-before-area').html(html);
            $(this).parent().find('.update-delete-btn').remove();
            upload('#'+uploader);
        });
        $("#nav_safecenter").addClass('on');
        $('.submit-rz-btn').click(function(){
            $('#sub_frm').submit();
        });
        $("#sub_frm").validate({
            ignore:"",
            rules: {
                'truename': {
                    required: true
                },
                'front_pic': {
                    required: true
                },
                'verso_pic': {
                    required: true
                },
                'cardid':{
                    required:true,
                    isIDCard:true
                }
            },
            messages: {
                'truename':{
                    required:'<span class="error-txt"><i class="ico"></i>请填写真实姓名</span>'
                },
                'verso_pic':{
                    required:'<span class="error-txt"><i class="ico"></i>请上传身份证背面照片</span>'
                },
                'front_pic':{
                    required:'<span class="error-txt"><i class="ico"></i>请上传身份证正面照片</span>'
                },
                'cardid':{
                    required:'<span class="error-txt"><i class="ico"></i>请填写身份证号码</span>',
                    isIDCard:'<span class="error-txt"><i class="ico"></i>请输入正确的身份证号码</span>'
                }
            },
            errorPlacement: function (error, element) {
                $(element).parent().append(error);
            },
            success: function (msg, element) {
                $(element).parent().find('.error-txt').remove();
            }
        });
    })
        //webuploader上传
        function upload(obj) {
            //obj='#imas'jquery对象;
            //正面上传实例
            var uploader = new WebUploader.Uploader({
                // 选完文件后，是否自动上传。
                auto: true,
                // swf文件路径
                swf: '/res/js/webuploader/Uploader.swf',
                // 文件接收服务端。
                server: SITEURL + 'member/index/ajax_upload_picture',
                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick:obj,
                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                //上传前压缩项
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
            uploader.on( 'uploadProgress', function( file, percentage ) {
            });
            // 文件上传成功
            uploader.on( 'uploadSuccess', function( file,data) {
                //如果上传成功
                if (data.status) {
                    var html = '<span class="update-after-area"><img src="'+data.litpic+'" width="198" height="123"></span>';
                    var parent_obj = $(obj).parent().parent();
                    $(obj).parent().html(html);
                    parent_obj.append('<a href="javascript:;" class="update-delete-btn">删除</a>');
                    parent_obj.find('.pic_hidden').val(data.litpic)
                }else{
                    $.layer({
                        type:1,
                        icon:2,
                        text:data.msg,
                        time:1000
                    });
                }
            });
            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on( 'uploadComplete', function( file ) {
//                $.layer.close();
            });
        }
</script>
