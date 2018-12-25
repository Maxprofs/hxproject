<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>供应商管理系统-{$webname}</title>
    {Common::css("style.css,base.css")}
    {Common::js("jquery.min.js,jquery.validate.min.js")}
</head>

<body>

<div class="page-box">
    {request 'pc/pub/header'}
    <!-- 顶部 -->

    {template 'pc/pub/sidemenu_account'}
    <!-- 侧边导航 -->

    <div class="main">
        <div class="content-box">

            {include "pc/pub/qualifyalert"}

            <div class="frame-box">
                <div class="frame-con">

                    <div class="change-phone-box">
                        <div class="change-phone-tit"><strong class="bt">更换绑定邮件</strong></div>
                        <div class="change-phone-con">
                            <div class="change-phone-step">
                                <div class="current-step">
                                    <span class="on"><strong>身份验证</strong><i>1</i></span>
                                    <span id="setp2_span"><strong>绑定邮件</strong><i>2</i></span>
                                    <span id="setp3_span"><strong>完成</strong><i>3</i></span>
                                </div>

                                <div class="current-con" id="setp1_div">
                                    <form id="setp1_form" table_head=sFACXC >
                                        <ul>
                                            <li>
                                                <strong class="bt">邮件地址：</strong>

                                                <div class="msg-box"><span class="phone-num">{php}echo (empty($data['email'])?'未绑定':$data['email']) {/php}</span></div>
                                            </li>
                                            <li>
                                                <strong class="bt">验证码：</strong>

                                                <div class="msg-box">
                                                    <input type="text" class="num-txt" name="code" id="code" placeholder="输入验证码"/>
                                                    <span class="yz-num"><img id="yzm-img" src="{$cmsurl}captcha" onClick="this.src=this.src+'?math='+ Math.random()" ></span>
                                                    <span class="change-yzm">看不清，<a style="cursor: pointer" onClick="document.getElementById('yzm-img').src=document.getElementById('yzm-img').src+'?math='+ Math.random()">换一张</a></span>
                                                    <div class="error-txt" style="display: none"></div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="next-btn step1-btn"><a href="javascript:;">下一步</a></div>
                                    </form>
                                </div>
                                <!--第一步-->

                                <div class="current-con" id="setp2_div" style=" display:none">
                                    <form id="setp2_form">
                                        <ul>
                                            <li>
                                                <strong class="bt">新邮件地址：</strong>

                                                <div class="msg-box">
                                                    <input type="text" class="new-phone-num" name="newemail" id="newemail" placeholder="请输入新邮件地址"/>
                                                    <div class="error-txt" style="display: none"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <strong class="bt">邮件验证码：</strong>

                                                <div class="msg-box">
                                                    <input type="text" class="num-txt" name="smscode" id="smscode" placeholder="输入邮件验证码"/>
                                                    <span class="trends-ma sms-send" do-send="true">获取动态验证码</span>
                                                    <div class="error-txt" style="display: none"></div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="next-btn step2-btn"><a  href="javascript:;">下一步</a></div>
                                    </form>
                                </div>
                                <!--第二步-->

                                <div class="current-con" id="setp3_div" style=" display:none">
                                    <div class="success-txt">恭喜您，邮件地址更新成功！</div>
                                    <div class="back-home-btn"><a href="{$cmsurl}pc/index/userinfo">去我的账户首页</a></div>
                                </div>
                                <!--第三步-->

                            </div>
                        </div>
                    </div>
                    <!-- 修改邮件 -->

                </div>
            </div>

            {template 'pc/pub/footer'}

        </div>
    </div>
    <!-- 主体内容 -->

</div>

{Common::js("layer/layer.js")}
<script>
    $(function(){
        $("#nav_modify_email").addClass('on');
        function count_down(v) {
            if (v > 0) {
                $('.sms-send').html(--v  + '秒后重新发送');
                setTimeout(function () {
                    count_down(v);
                }, 1000);
                $('.sms-send').attr('do-send', 'false');
            }
            else {
                $('.sms-send').attr('do-send', 'true').html('重新发送');
            }
        }
        //验证码
        $('.sms-send').click(function () {
            $("#smscode").parent().find('.error-txt').hide();
            var bool = $(this).attr('do-send');
            var node = this;
            if (bool === 'true') {
                if ($("#newemail").val() != '') {
                    //发送验证码
                    $('.sms-send').attr('do-send', 'false');
                    $.post(SITEURL + 'pc/pub/ajax_send_message', {'email': $("#newemail").val(),'type':'findpass_code'}, function (bool) {
                        if (bool != 1) {
                            var message = bool == 0 ? '发送失败，请检查邮件接口或消息开关' : bool;
                            $('.sms-send').attr('do-send', 'true');
                            $("#smscode").parent().find('.error-txt').html(message);
                            $("#smscode").parent().find('.error-txt').show();
                            $("#yzm-img").attr('src', $("#yzm-img").attr('src') + '?math='+ Math.random());
                            $("#code").val('');
                        } else {
                            count_down(60);
                        }
                        return false;
                    }, 'text');
                }else{
                    $("#newemail").parent().find('.error-txt').html('“新邮件地址”格式错误');
                    $("#newemail").parent().find('.error-txt').show();
                }
            }
        });

        $('#setp1_form').validate({
            rules: {
                code: {
                    required: true,
                    minlength: 4,
                },
            },
            messages: {
                code: {
                    required: '“验证码”不少于4位',
                    minlength: '“验证码”不少于4位'
                },
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                var content =$(element).parent().find('.error-txt').html();
                if (content == '') {
                    $(element).parent().find('.error-txt').html('')
                    error.appendTo($(element).parent().find('.error-txt'));
                }
            },
            showErrors: function (errorMap, errorList) {
                if (errorList.length < 1) {
                    $('.error-txt').html('');
                    $('.error-txt').hide();
                } else {
                    $(errorList[0].element).parent().find('.error-txt').show();
                    this.defaultShowErrors();
                }
            }, submitHandler: function (form) {
                //验证码
                $.post(SITEURL + 'pc/pub/ajax_do_code', {'code': $('#code').val()}, function (data) {
                    if (data.status == 1) {
                        $("#setp2_span").addClass('on');
                        $("#setp1_div").hide();
                        $("#setp2_div").show();
                    }else{
                        layer.msg('“验证码”错误', {icon:5});
                    }
                }, 'json');
                return false;
            }
        });
        //第一步
        $(".step1-btn").click(function(){
            $("#setp1_form").submit();
        });
        $('#setp2_form').validate({
            rules: {
                newemail: {
                    required: true,
                    email: true
                },
                smscode: {
                    required: true,
                    minlength: 4
                },
            },
            messages: {
                newemail: {
                    required: '“新邮件地址”不能为空',
                    email: '“新邮件地址”格式错误'
                },
                smscode: {
                    required: '“邮件验证码”不能为空',
                    minlength: '“邮件验证码”不少于4位'
                },
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                var content =$(element).parent().find('.error-txt').html();
                if (content == '') {
                    $(element).parent().find('.error-txt').html('')
                    error.appendTo($(element).parent().find('.error-txt'));
                }
            },
            showErrors: function (errorMap, errorList) {
                if (errorList.length < 1) {
                    $('.error-txt').html('');
                    $('.error-txt').hide();
                } else {
                    $(errorList[0].element).parent().find('.error-txt').show();
                    this.defaultShowErrors();
                }
            }, submitHandler: function (form) {
                $.post(SITEURL + 'pc/user/ajax_do_modify_email_setp2', {
                    'newemail': $('#newemail').val(),
                    'smscode': $('#smscode').val(),
                }, function (data) {
                    if (data.status == 1) {
                        $("#setp3_span").addClass('on');
                        $("#setp2_div").hide();
                        $("#setp3_div").show();
                    }else{
                        layer.msg(data.msg, {icon:5});
                    }
                }, 'json');
                return false;
            }
        });
        //第一步
        $(".step2-btn").click(function(){
            $("#setp2_form").submit();
        });
    });
</script>
</body>
</html>
