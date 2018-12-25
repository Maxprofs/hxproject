<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>注册</title>
    {Common::css("base.css,login.css")}
    {Common::js("jquery.min.js,jquery.validate.min.js")}
</head>

<body>

{template 'pc/pub/login_header'}
<!-- 顶部 -->

<div class="main-reg-box">
    <div class="main-con">
        <div class="reg-box">

            <div class="reg-phone-tit">注册</div>

            <div class="reg-phone-step">

                <div class="current-step">
                    <span class="on"><strong>创建账户</strong><i>1</i></span>
                    <span id="setp2_span"><strong>填写资料</strong><i>2</i></span>
                    <span id="setp3_span"><strong>注册成功</strong><i>3</i></span>
                </div>
                <div class="current-con" id="setp1_div">
                    <form id="setp1_form">
                        <ul>
                            <li>
                                <strong class="bt register-mode">手机号码：</strong>
                                <div class="msg-box">
                                    <input type="text" class="new-phone-num" name="phone" id="phone" placeholder="输入手机号码"/>
                                    <input type="text" class="new-phone-num" name="email" id="email" placeholder="输入邮箱地址" style="display: none;"/>
                                    <span class="change-yzm">
                                        <a style="cursor: pointer" id="btnSwitchRegisterMode" onClick="switchRegisterMode(this);">使用手机注册</a>
                                    </span>
                                    <div class="error-txt" style="display: none"></div>
                                </div>
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
                            <li>
                                <strong class="bt">动态验证码：</strong>

                                <div class="msg-box">
                                    <input type="text" class="num-txt" name="smscode" id="smscode" placeholder="输入动态验证码"/>
                                    <span class="trends-ma sms-send" do-send="true">获取动态验证码</span>
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
                                <strong class="bt">密码：</strong>
                                <div class="msg-box">
                                    <input type="password" class="new-phone-num" name="password1" id="password1" placeholder="请填写登录密码"/>
                                    <span class="error-txt" style="display: none"></span>
                                </div>
                            </li>
                            <li>
                                <strong class="bt">确认密码：</strong>
                                <div class="msg-box">
                                    <input type="password" class="new-phone-num" name="password2" id="password2" placeholder="再输入一次密码"/>
                                    <span class="error-txt" style="display: none"></span>
                                </div>
                            </li>
                        </ul>
                        <div class="next-btn step2-btn"><a href="javascript:;">下一步</a></div>
                        <input type="hidden" name="account" id="account">
                        <input type="hidden" name="smscode2" id="smscode2">
                        <input type="hidden" name="code2" id="code2">
                    </form>
                </div>
                <!--第二步-->

                <div class="current-con" id="setp3_div" style=" display:none">
                    <div class="success-txt">
                        <h3>恭喜您，注册成功！</h3>
                        <p class="fu">通过旅行社身份验证后， 才能享受更多旅行社会员专属特权</p>
                    </div>
                    <div class="back-btn">
                        <a class="home-btn" href="{$cmsurl}pc">账户首页</a>
                        <a class="now-btn" href="{$cmsurl}pc/qualify/index">马上验证</a>
                    </div>
                </div>
                <!--第三步-->

            </div>

        </div>
    </div>
</div>


{Common::js("layer/layer.js")}
<script>
    function switchRegisterMode() {
        var sender = $("#btnSwitchRegisterMode");
        if (sender.text() == "使用邮箱注册") {
            $("#phone").hide();
            $("#phone").rules('remove');
            $("#email").show();
            $("#email").rules("add", {required: true, email: true, messages: {required: "“邮件地址”不能为空", email: '“邮件地址”格式不正确'}});
            sender.text("使用手机注册");
            $(".register-mode").text("邮箱地址：");
        }
        else {
            $("#phone").show();
            $("#phone").rules("add", {required: true, mobile: true, messages: {required: '“手机号码”不能为空', mobile: '“手机号码”格式不正确'}});
            $("#email").hide();
            $("#email").rules('remove');
            sender.text("使用邮箱注册");
            $(".register-mode").text("手机号码：");
        }
    }

    $(function(){

        function count_down(v) {
            if (v > 0) {
                $('.sms-send').html(--v + '秒后重新发送');
                setTimeout(function () {
                    count_down(v);
                }, 1000);
                $('.sms-send').attr('do-send', 'false')
            }
            else {
                $('.sms-send').attr('do-send', 'true').html('重新发送');

            }
        }
        //验证码
        $('.sms-send').click(function () {
            $('.error-txt').hide();
            var bool = $(this).attr('do-send');
            var node = this;
            if (bool === 'true') {
                var regtype = $("#email").is(":hidden") ? 'phone' : 'email';
                var content = regtype == 'phone' ? $("#phone").val() : $("#email").val();
                var postValue = regtype == 'phone' ? {'phone': content, 'type': 'register_code'} : {'email': content, 'type': 'register_code'};
                if (content != '') {//发送验证码
                    $.post(SITEURL + 'pc/register/ajax_do_check', postValue, function (data) {
                        if (data.status == 1) {
                            if ($("#code").val() != '') {
                                //发送验证码
                                $.post(SITEURL + 'pc/pub/ajax_do_code', {'code': $('#code').val()}, function (data) {
                                    if (data.status == 1) {
                                        //发送验证码
                                        $('.sms-send').attr('do-send', 'false')
                                        $.post(SITEURL + 'pc/pub/ajax_send_message', postValue, function (bool) {
                                            if (bool != 1) {
                                                var message = bool == 0 ? '发送失败，请检查' + (regtype == 'phone' ? "短信" : "邮件") + '接口或消息开关' : bool;
                                                $('.sms-send').attr('do-send','true');
                                                $("#smscode").parent().find('.error-txt').html(message);
                                                $("#smscode").parent().find('.error-txt').show();
                                                $("#yzm-img").attr('src', $("#yzm-img").attr('src') + '?math='+ Math.random());
                                                $("#code").val('');
                                            } else {
                                                count_down(60);
                                            }
                                            return false;
                                        }, 'text');
                                    } else {
                                        $("#code").parent().find('.error-txt').html('“验证码”错误');
                                        $("#code").parent().find('.error-txt').show();
                                    }
                                }, 'json')
                            }else{
                                $("#code").parent().find('.error-txt').html('“验证码”错误');
                                $("#code").parent().find('.error-txt').show();
                            }
                        } else {
                            $("#phone").parent().find('.error-txt').html(data.msg);
                            $("#phone").parent().find('.error-txt').show();
                        }
                    }, 'json')
                }else{
                    $("#phone").parent().find('.error-txt').html('“' + (regtype == 'phone' ? '手机号码' : '邮件地址') + '”错误');
                    $("#phone").parent().find('.error-txt').show();
                }
            }
        });

        $('#setp1_form').validate({
            rules: {
                smscode: {
                    required: true,
                    minlength: 4
                },
                code: {
                    required: true,
                    minlength: 4
                }
            },
            messages: {
                smscode: {
                    required: '“验证码”不能为空',
                    minlength: '“验证码”不少于4位'
                },
                code: {
                    required: '“验证码”不能为空',
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
                var postValue = $("#email").is(":hidden") ? {'phone': $('#phone').val()} : {'email': $('#email').val()};
                postValue.smscode = $('#smscode').val();
                postValue.code = $('#code').val();
                $.post(SITEURL + 'pc/register/ajax_do_setp1', postValue, function (data) {
                    if (data.status == 1) {
                        $("#account").val((postValue.phone != null && postValue.phone != undefined && postValue.phone != '') ? postValue.phone : postValue.email);
                        $("#smscode2").val($('#smscode').val());
                        $("#code2").val($('#code').val());
                        $("#setp2_span").addClass('on');
                        $("#setp1_div").hide();
                        $("#setp2_div").show();
                    }else{
                        layer.msg(data.msg, {icon:5});
                    }
                }, 'json');
                return false;
            }
        });

        //第一步
        $(".step1-btn").click(function(){
            $("#setp1_form").submit();
        });

        switchRegisterMode();

        $('#setp2_form').validate({
            rules: {
                password1: {
                    required: true,
                    minlength: 6
                },
                password2: {
                    required: true,
                    minlength: 6
                },
            },
            messages: {
                password1: {
                    required: '“密码”不能为空',
                    minlength: '“密码”不少于6位'
                },
                password2: {
                    required: '“确认密码”不能为空',
                    minlength: '“确认密码”不少于6位'
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
                if($("#password1").val() != $("#password2").val()) {
                    layer.msg('“确认密码”与“密码”不一致', {icon:5});
                    return false;
                }
                if($('#account').val() == ''){
                    layer.msg('“电话号码或邮件地址”不能为空', {icon:5},function(){
                        window.location.reload();
                    });
                }
                if($('#smscode2').val() == '' && $('#code2').val() == ''){
                    layer.msg('“验证码”不能为空', {icon:5},function(){
                        window.location.reload();
                    });
                }
                $.post(SITEURL + 'pc/register/ajax_do_setp2', {
                    'password': $('#password1').val(),
                    'account': $('#account').val(),
                    'smscode': $('#smscode2').val(),
                    'code': $('#code2').val(),
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
        //第二步
        $(".step2-btn").click(function(){
            $("#setp2_form").submit();
        });

    });
</script>
{template 'pc/pub/footer'}

</body>
</html>
