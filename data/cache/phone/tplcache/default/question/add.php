<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
    <?php } ?>
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>" />
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,question.css,reset-style.css');?>
    <?php echo Common::js('lib-flexible.js,jquery.min.js,common.js,jquery.validate.min.js');?>
</head>
<body>
    <?php echo Request::factory("pub/header_new/typeid/$typeid")->execute()->body(); ?>
    <form id="st_form" method="post" action="<?php echo $cmsurl;?>questions/save" enctype="application/x-www-form-urlencoded">
        <div class="mid_content">
            <div class="faq-con">
                <dl>
                    <dt>问题标题：</dt>
                    <dd><textarea name="txtTitle" id="txtTitle" cols="" rows="" placeholder="请输入您的问题标题，必填"></textarea></dd>
                </dl>
                <dl>
                    <dt>内容：</dt>
                    <dd><textarea name="txtContent" id="txtContent" cols="" rows="" placeholder="请您详细说明您的问题，必填"></textarea></dd>
                </dl>
                <p id="lblErrorMsg"></p>
            </div>
            <!--标题内容-->
            <div class="linkway">
                <h3>联系方式</h3>
                <ul>
                    <li>
                        <strong class="no-style">昵称</strong>
                        <input type="text" name="txtNickname" id="txtNickname" disabled="true"/>
                        <span id="myclick" class="nm" onClick="myclick()"><i></i>匿名</span>
                    </li>
                    <li>
                        <strong class="no-style">电话</strong>
                        <input type="text"  name="txtTel" id="txtTel"/>
                        <span>必填</span>
                    </li>
                    <li>
                        <strong class="no-style">验证码</strong>
                        <input type="text"  name="txtValidateCode" id="txtValidateCode"/>
                        <span><img src="" height="30" id="imgValidateCode" /></span>
                    </li>
            </div>
        </div>
        <!--联系方式-->
    </form>
    <script>
        var djspan = document.getElementById('myclick');
        var djon = djspan.firstChild;
        function myclick() {
            if (djon.className == '') {
                djon.setAttribute('class', 'on');
                $("#txtNickname").attr("disabled", false);
            } else if (djon.className == 'on') {
                djon.setAttribute('class', ' ');
                $("#txtNickname").attr("disabled", true);
                $("#txtNickname").val("");
            }
        }
    </script>
    <div class="hold-bottom-bar">
        <div class="bottom-fixed">
            <a class="wask" href="javascript:;" id="btnOK">提交</a>
        </div>
    </div>
    <!-- 提交 -->
    <?php echo Request::factory("pub/code")->execute()->body(); ?>
    <script>
        $(function () {
            $('#imgValidateCode').attr('src',ST.captcha(SITEURL+'captcha'));
            $('#imgValidateCode').click(function(){
                $(this).attr('src',ST.captcha($(this).attr('src')));
            });
            $("#btnOK").click(function(){
                $("#st_form").submit();
            });
            //验证
            $('#st_form').validate({
                rules:{
                    txtTitle:'required',
                    txtContent:'required',
                    txtValidateCode: {
                        required: true,
                        minlength: 4,
                        remote: {
                            type: "POST",
                            url:"<?php echo $cmsurl;?>question/ajax_checkValidateCode",
                            data:{
                                ValidateCode:function(){return $("#txtValidateCode").val();}
                            }
                        }
                    },
                    txtNickname:{
                        required:function(){
                            if($("#txtNickname").attr("disabled") == true)
                                return false;
                            else
                                return true;
                        }
                    },
                    txtTel:{
                        required: true,
                        mobile: true
                    }
                },
                messages:{
                    txtTitle:'<?php echo __("error_question_title_not_empty");?>',
                    txtContent:'<?php echo __("error_question_content_not_empty");?>',
                    txtValidateCode: {
                        required: '<?php echo __("error_code_not_empty");?>',
                        minlength: '<?php echo __("error_code_Length");?>',
                        remote: '<?php echo __("error_code");?>'
                    },
                    txtNickname:{
                        required:'<?php echo __("error_member_nickname_not_empty");?>'
                    },
                    txtTel:{
                        required: '<?php echo __("error_linktel_not_empty");?>',
                        mobile: '<?php echo __("error_linktel_phone");?>'
                    }
                },
                errorPlacement: function(error, element) {
                    var content=$('#lblErrorMsg').html();
                    if(content.trim()==''){
                        $('#lblErrorMsg').html('<i></i>');
                        error.appendTo($('#lblErrorMsg'));
                    }
                },
                showErrors:function(errorMap,errorList){
                    if(errorList.length<1){
                        $('#lblErrorMsg').html('');
                    }else{
                        this.defaultShowErrors();
                    }
                }
            });
        });
    </script>
</body>
</html>
