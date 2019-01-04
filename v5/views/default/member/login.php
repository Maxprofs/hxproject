<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{__('用户登陆')}-{$webname}</title>
    {include "pub/varname"}
    {Common::css('base.css,user.css,extend.css,account.css')}
    {Common::js('jquery.min.js,base.js,common.js,jquery.validate.js,jquery.validate.addcheck.js,jquery.md5.js')}
</head>
<style type="text/css">
    .login-tab-bar .item{
        width: 100%;
    }
</style>
<body>
{request "pub/header"}
      
  <div class="st-userlogin-box" {if $GLOBALS['cfg_login_bg']}style="background: url('{$GLOBALS['cfg_login_bg']}') center top no-repeat;"{/if}>
    <div class="st-login-wp">
        <div class="st-login-wrapper">
            <div class="login-tab-bar" id="loginTabBar">
                <span class="item on" data-type="user_login">{__('账号密码登录')}</span>
                <!-- if $isopen==1 -->
                <!-- <span class="item" data-type="sms_fast_login">{__('动态码登录')}</span> -->
                <!-- /if -->
            </div>
            <div class="login-tab-box">
                <form id="user_login" method="post">
                    <ul class="login-info-item">
                        <li class="account">
                            <i class="icon"></i>
                            <input type="text" class="entry-text" id="loginname" name="loginname" placeholder="{__('请输入手机号或邮箱')}" />
                        </li>
                        {if !$one}
                        <li class="verify">
                            <i class="icon"></i>
                            <input type="text" class="entry-text" id="code" name="code" placeholder="{__('请输入验证码')}" />
                            <img class="yzm captcha" src="" />
                        </li>
                        {/if}
                        <li class="password">
                            <i class="icon"></i>
                            <input type="password" class="entry-text" name="loginpwd" id="loginpwd" placeholder="{__('请输入登录密码')}" />
                        </li>
                    </ul>
                    <input type="hidden" name="logincode" value="{$frmcode}"/>
                    <input type="hidden" name="fromurl" value="{$fromurl}">
                </form>
                {if $isopen==1}
                    <form id="sms_fast_login" method="post">
                        <ul class="login-info-item">
                            <li class="phone">
                                <i class="icon"></i>
                                <input type="text" class="entry-text" id="mobile" name="mobile" placeholder="{__('请输入手机号')}" />
                            </li>
                            {if !$one}
                            <li class="verify">
                                <i class="icon"></i>
                                <input type="text" class="entry-text" id="code2" name="code2" placeholder="{__('请输入验证码')}" />
                                <img class="yzm captcha" src="" />
                            </li>
                            {/if}
                            <li class="code">
                                <i class="icon"></i>
                                <input type="text" class="entry-text" name="sms_code" id="sms_code" placeholder="{__('请输入动态码')}" />
                                <span class="send" id="send_sms_code">{__('获取动态码')}</span>
                            </li>
                        </ul>
                        <input type="hidden" name="logincode" value="{$frmcode}"/>
                        <input type="hidden" name="fromurl" value="{$fromurl}">
                    </form>
                {/if}
            </div>
            <div class="login-error" id="login-error" style="display: none;">{__('验证码不能为空')}</div>
            <div class="login-link-bar">
                <a class="login-link-btn btn_login" href="javascript:;">{__('登 录')}</a>
            </div>
            <div class="login-reg-bar">
                <span class="item">{__('没有账号')}，<a href="{$cmsurl}member/register">{__('免费注册')}</a></span>
                <span class="item fr"><a href="{$cmsurl}member/findpwd">{__('找回密码')}</a></span>
            </div>
            <div class="other-login-area">
                <dl>
                    <!-- <dt><span>{__('使用其他方式登录')}</span><em></em></dt> -->
                    <dd>
                        {if (!empty($GLOBALS['cfg_qq_appid']) && !empty($GLOBALS['cfg_qq_appkey']))}
                        <a class="qq qqlogin"
                           href="{$GLOBALS['cfg_basehost']}/plugins/login_qq/index/index/?refer={urlencode($fromurl)}">QQ</a>
                        {/if}
                        {if (!empty($GLOBALS['cfg_weixi_appkey']) && !empty($GLOBALS['cfg_weixi_appsecret']))}
                        <a class="wx wxlogin"
                           href="{$GLOBALS['cfg_basehost']}/plugins/login_weixin/index/index/?refer={urlencode($fromurl)}">wx</a>
                        {/if}

                        {if (!empty($GLOBALS['cfg_sina_appkey']) && !empty($GLOBALS['cfg_sina_appsecret']))}
                        <a class="wb wblogin"
                           href="{$GLOBALS['cfg_basehost']}/plugins/login_weibo/index/index/?refer={urlencode($fromurl)}">wb</a>
                        {/if}
                    </dd>
                </dl>
            </div>
        </div>
    </div>
  </div>
<div class="login-shadow" style="display: none;">
    <div class="send-tip-box"><i class="icon"></i>{__('动态密码已发送，15分钟有效')}</div>
</div>
  
{request "pub/footer"}
{Common::js('layer/layer.js')}
<script>
    $(function() {
        $('.close-ico').click(function() {
            $('#stHotDestBox').hide()
        });

        //登录
        $('.login-info-item').eq(0).show();
        $('#loginTabBar .item').on('click',function(){
            $('.login-error').html('');
            $('.login-error').hide();
            var index = $(this).index();
            $(this).addClass('on').siblings().removeClass('on');
            $('.login-info-item').hide();
            $('.login-info-item').eq(index).show();
            bind_event();
        });
        bind_event();
        //事件绑定
        function bind_event() {
            //初始化form
            var login_form=$("#user_login");
            if($(".login-tab-bar>span.item.on").attr('data-type')=='sms_fast_login')
            {
                login_form=$("#sms_fast_login");
            }
            //$('.btn_login').addClass('disabled');
            //初始化图形验证码
            login_form.find('.captcha').attr('src',ST.captcha(SITEURL+'captcha'));
            //刷新验证码
            login_form.find('.captcha').click(function(){
                $(this).attr('src',ST.captcha($(this).attr('src')));
            });
        }

    })
</script>
<script>
    $(function(){
		 document.onkeydown = function(e){
            var ev = document.all ? window.event : e;
            if(ev.keyCode==13) {
                $(".btn_login").trigger('click');
            }
        }

        //登陆
        $(".btn_login").unbind('click').bind('click',function(){
            $('#sms_code').rules("add", 'required');
            //初始化form
            var login_form=$("#user_login");
            if($(".login-tab-bar>span.item.on").attr('data-type')=='sms_fast_login')
            {
                login_form=$("#sms_fast_login");
            }
            login_form.submit();
        });

        function count_down(v) {
            if (v > 0) {
                $('#send_sms_code').html(--v+'秒后');
                $('#send_sms_code').attr('do-send','false').removeClass('cursor');
                //$('#submit_btn').removeClass('disabled');
                setTimeout(function () {
                    count_down(v);
                }, 1000);
            }else {
                $('#send_sms_code').attr('do-send', 'true').addClass('cursor').html('重新获取');
            }
        }
        //发送按钮绑定
        $('#send_sms_code').click(function(){
            $('.login-error').html('');
            var bool = $(this).attr('do-send');
            if (bool === 'false') {
                return false;
            }
            //除动态码外
            $('#sms_code').rules("remove", 'required');
            if(!$("#sms_fast_login").valid()){
                return false;
            }
            $(this).text('发送中...');
            if($(this).hasClass('disabled'))
            {
                $(this).text('获取动态码');
                return false;
            }

            var url = SITEURL+'member/login/ajax_send_code';
            var data={};
            var phone = $("#mobile").val();
            data['phone']=phone;
            //验证码存在则不能为空
            if($("input[name='code2']").length>0)
            {
                data['code']=$("input[name='code2']").val();
            }
            $.ajax({
                type:"post",
                async: false,
                url:url,
                data:data,
                dataType:'json',
                success: function(data){
                    if(data.status == '1'){
                        //发送成功
                        $('.login-shadow').show();
                        setTimeout(function () {
                            $('.login-shadow').hide();
                        }, 2000);
                        count_down(120);
                        $('#send_sms_code').attr('do-send','false').removeClass('cursor');
                    }else{
                        $('#send_sms_code').html("获取动态码");
                        if(data.msg!=undefined){
                            $('.login-error').show();
                            $(".login-error").html(data.msg);
                        }else{
                            $('.login-error').show();
                            $(".login-error").html('{__("error_user_pwd")}');
                        }
                        if ($("#sms_fast_login").find('.captcha').length <=0) {
                            var yzm_html='<li class="verify"><i class="icon"></i><input type="text" class="entry-text" name="code" id="code" placeholder="请输入验证码">' +
                                '<img class="yzm captcha" src=""></li>';
                            $("#sms_fast_login").find("li.phone").after(yzm_html);
                            //刷新验证码
                            $("#sms_fast_login").find('.captcha').click(function(){
                                $(this).attr('src',ST.captcha($(this).attr('src')));
                            });
                        }
                        $("#sms_fast_login").find('.captcha').attr('src', ST.captcha(SITEURL + 'captcha'));
                    }
                },
                error:function(a,b,c){

                }
            });
        });
        $("#user_login").validate({
            rules: {
                loginname: {
                    required: true,
                },
                code:{
                    required: true,
                },
                loginpwd: {
                    required: true,
                    minlength: 6
                },
            },
            messages: {
                loginname: {
                    required: '{__("error_user_not_empty")}',
                },
                code:{
                    required: '{__("error_code_not_empty")}',
                },
                loginpwd: {
                    required: '{__("error_pwd_not_empty")}',
                    minlength: '{__("error_pwd_min_length")}'
                },
            },
            errorPlacement: function (error, element) {
                var content = $('.login-error').html();
                if (content == '') {
                    $('.login-error').show();
                    $('.login-error').html(error);
                }
            },
            showErrors: function (errorMap, errorList) {
                if (errorList.length < 1) {
                    $('.login-error').hide();
                    $('.login-error').html('');
                } else {
                    $('.login-error').show();
                    this.defaultShowErrors();
                }
            },
            submitHandler:function(form){
                //初始化form
                var login_form=$("#user_login");
                var url = SITEURL+'member/login/ajax_login';
                var loginname = $("#loginname").val();
                var loginpwd = $.md5($("#loginpwd").val());
                var frmcode = login_form.find("input[name='logincode']").val();
                var code = null;
                if($("#loginfrm").find("input[name=code]").length>0){
                    code = $("#loginfrm").find("input[name=code]").val();
                }
                $.ajax({
                    type:"post",
                    async: false,
                    url:url,
                    data:{loginname:loginname,loginpwd:loginpwd,frmcode:frmcode,code:code},
                    dataType:'json',
                    success: function(data){
                        if(data.status == '1'){//登陆成功,跳转到来源网址
                            ST.Login.login_callback(data);
                            var url = login_form.find("input[name=fromurl]").val();
                            setTimeout(function(){window.open(url,'_self');},500);
                        }else{
                            $('.login-error').show();
                            if(data.msg!=undefined){
                                $(".login-error").html(data.msg);
                            }else{
                                $(".login-error").html('{__("error_user_pwd")}');
                            }
                            if (login_form.find('.captcha').length <=0) {
                                var yzm_html='<li class="verify"><i class="icon"></i><input type="text" class="entry-text" name="code" id="code" placeholder="请输入验证码">' +
                                    '<img class="yzm captcha" src=""></li>';
                                login_form.find("li.account").after(yzm_html);
                                //刷新验证码
                                login_form.find('.captcha').click(function(){
                                    $(this).attr('src',ST.captcha($(this).attr('src')));
                                });
                            }
                            login_form.find('.captcha').attr('src', ST.captcha(SITEURL + 'captcha'));
                        }
                    },
                    error:function(a,b,c){}
                });
                return false;
            }
        });
        $("#sms_fast_login").validate({
            rules: {
                mobile: {
                    required: true,
                    isMobile:true,
                    remote: {
                        url: SITEURL+'member/findpwd/ajax_check_loginname',
                        type: 'post',
                        data:{
                            loginname:function(){
                                return $("#mobile").val();
                            }
                        }
                    }
                },
                code2:{
                    required: true,
                },
                sms_code:{
                    required: true
                },
            },
            messages: {
                mobile: {
                    required: '{__("error_user_not_empty")}',
                    isMobile: '{__("error_user_phone")}',
                    remote:'{__("error_user_noexists")}'
                },
                code2:{
                    required: '{__("error_code_not_empty")}',
                },
                sms_code:{
                    required: '{__("error_msg_not_empty")}'
                },
            },
            errorPlacement: function (error, element) {
                var content = $('.login-error').html();
                if (content == '') {
                    $('.login-error').show();
                    $('.login-error').html(error);
                }
            },
            showErrors: function (errorMap, errorList) {
                if (errorList.length < 1) {
                    $('.login-error').hide();
                    $('.login-error').html('');
                } else {
                    $('.login-error').show();
                    this.defaultShowErrors();
                }
            },
            submitHandler:function(form){
                var login_form=$("#sms_fast_login");
                var url = SITEURL+'member/login/ajax_check_sms_code';
                var phone = $("#mobile").val();
                var sms_code = $("#sms_code").val();
                var frmcode = login_form.find("input[name=logincode]").val();
                var code = null;
                if(login_form.find("input[name=code2]").length>0){
                    code = login_form.find("input[name=code2]").val();
                }
                var return_url = login_form.find("input[name=fromurl]").val();
                $.ajax({
                    type:"post",
                    async: false,
                    url:url,
                    data:{phone:phone,frmcode:frmcode,sms_code:sms_code,code:code},
                    dataType:'json',
                    success: function(data){
                        if(data.status == '1'){//登陆成功,跳转到来源网址
                            ST.Login.login_callback(data);
                            console.log(return_url);
                            setTimeout(function () {
                                window.open(return_url, '_self');
                            }, 500);
                            //$('body').append(data.js);//同步登陆js
                        }else{
                            $('.login-error').show();
                            if(data.msg!=undefined){
                                $(".login-error").html(data.msg);
                            }else{
                                $(".login-error").html('{__("error_user_pwd")}');
                            }
                            if (login_form.find('.captcha').length <=0) {
                                var yzm_html='<li class="verify"><i class="icon"></i><input type="text" class="entry-text" name="code" id="code" placeholder="请输入验证码">' +
                                    '<img class="yzm captcha" src=""></li>';
                                login_form.find("li.phone").after(yzm_html);
                            }
                            login_form.find('.captcha').attr('src', ST.captcha(SITEURL + 'captcha'));
                        }
                    },
                    error:function(a,b,c){}
                });
                return false;
            }
        });
    })


</script>
</body>
</html>
