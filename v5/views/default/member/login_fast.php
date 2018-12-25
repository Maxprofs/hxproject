<div class="content-fix-box hide" id="is_login_order">
    <div class="login-small-box">
        <div class="login-small-con">
            <h3 class="tab-nav-bar">
                <span class="item on" data-type="user_fast_login">{__('账户密码登录')}</span>
                <span class="item" data-type="mobile_fast_login">{__('动态码登录')}</span>
                <i class="close-btn"></i>
            </h3>
            <div class="tab-wrapper">
                <form id="user_fast_login" method="post" color_head=BIACXC >
                    <div class="tab-item-box">
                        <div class="user-name">
                            <input type="text" name="loginname" id="loginname" class="user-zh" placeholder="{__('请输入手机号')}/{__('邮箱')}">
                        </div>
                        <div class="user-num">
                            <input type="text" name="logincode" id="frmcode" class="user-zh" placeholder="{__('请输入验证码')}">
                            <span class="yzm"><img class="captcha" src="{$cmsurl}captcha"></span>
                            <span class="change-next change_yzm">{__('换一张')}</span>
                        </div>
                        <div class="user-password">
                            <input type="password" name="loginpwd" id="loginpwd"  class="user-zh" placeholder="{__('请输入登录密码')}">
                        </div>
                    </div>
                </form>
                <form id="mobile_fast_login" method="post">
                    <div class="tab-item-box">
                        <div class="user-phone">
                            <input type="text" class="user-zh" name="mobile" id="mobile" placeholder="{__('请输入手机号')}">
                        </div>
                        <div class="user-num">
                            <input type="text" class="user-zh" name="login_code" id="login_code" placeholder="{__('请输入验证码')}">
                            <span class="yzm"><img class="captcha" src="{$cmsurl}captcha"></span>
                            <span class="change-next change_yzm">{__('换一张')}</span>
                        </div>
                        <div class="user-password user-num">
                            <input type="text" class="user-zh" name="sms_code" id="sms_code" placeholder="{__('请输入动态密码')}">
                            <span class="code" id="send_sms_code">{__('获取动态码')}</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="login-error" style="display: none;"></div>
            <div class="login-btn"><a href="javascript:;" id="login_order">{__('登 录')}</a></div>
            <div class="reg-find-acc">{__('没有账号')}，<a href="{$cmsurl}member/register">{__('免费注册')}</a>
                <a class="fr" href="{$cmsurl}member/findpwd">{__('找回密码')}</a>
            </div>
        </div>
        <div class="other-login">
            <dl>
                <dt><span>{__('使用其他方式登录')}</span><em></em></dt>
                <dd>
                    {if (!empty($GLOBALS['cfg_qq_appid']) && !empty($GLOBALS['cfg_qq_appkey']))}
                    <a class="qq third-login" href="javascript:" data="{$GLOBALS['cfg_basehost']}/plugins/login_qq/index/index/?refer">QQ</a>
                    {/if}
                    {if (!empty($GLOBALS['cfg_weixi_appkey']) && !empty($GLOBALS['cfg_weixi_appsecret']))}
                    <a class="wx third-login" href="javascript:" data="{$GLOBALS['cfg_basehost']}/plugins/login_weixin/index/index/?refer">wx</a>
                    {/if}
                    {if (!empty($GLOBALS['cfg_sina_appkey']) && !empty($GLOBALS['cfg_sina_appsecret']))}
                    <a class="wb third-login" href="javascript:" data="{$GLOBALS['cfg_basehost']}/plugins/login_weibo/index/index/?refer">wb</a>
                    {/if}
                </dd>
            </dl>
        </div>
    </div>
</div>
<div class="login-shadow" style="display: none;">
    <div class="send-tip-box"><i class="icon"></i>{__('动态密码已发送，15分钟有效')}</div>
</div>
<script>
    $(document).ready(function () {
        var one='{Common::session("login_num")}';
        if(!one){
            $("img.captcha").parents('div.user-num').hide();
            $("img.captcha").parents('div.user-num').remove();
        }

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
        bind_event();
        //事件绑定
        function bind_event() {
            //切换验证码
            $('.change_yzm').click(function(){
                var _obj=$(this).siblings("span.yzm").find('.captcha');
                $(this).siblings("span.yzm").find('.captcha').attr('src',ST.captcha(_obj.attr('src')));
            });
            //初始化登陆form
            var login_form=$("#user_fast_login");
            if($(".tab-nav-bar>span.item.on").attr('data-type')=='mobile_fast_login')
            {
                login_form=$("#mobile_fast_login");
            }
            //$('#submit_btn').addClass('disabled');
            //初始化图形验证码
            login_form.find('.captcha').attr('src',ST.captcha(SITEURL+'captcha'));
            //刷新验证码
            login_form.find('.captcha').click(function(){
                $(this).attr('src',ST.captcha($(this).attr('src')));
            });

        }
        $('#send_sms_code').click(function(){
            var bool = $(this).attr('do-send');
            if (bool === 'false') {
                return false;
            }
            //除动态码外
            $('#sms_code').rules("remove", 'required');
            if(!$("#mobile_fast_login").valid())
            {
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
            if($("input[name='login_code']").length>0)
            {
                data['code']=$("input[name='login_code']").val();
                if(!data['code'])
                {
                    $('.login-error').show();
                    $(".login-error").html('{__("error_code")}');
                    return false;
                }
            }
            $.ajax({
                type:"post",
                async: false,
                url:url,
                data:data,
                dataType:'json',
                success: function(data){
                    if(data.status == '1'){
                        //发送成
                        count_down(120);
                        $('#send_sms_code').attr('do-send','false').removeClass('cursor');
                    }else{
                        $('#mobile_fast_login').find('.captcha').attr('src', ST.captcha(SITEURL + 'captcha'));
                        $('#send_sms_code').html("获取动态码");
                        if(data.msg!=undefined){
                            $('.login-error').show();
                            $(".login-error").html(data.msg);
                        }else{
                            $('.login-error').show();
                            $(".login-error").html('{__("error_user_pwd")}');
                        }
                    }
                },
                error:function(a,b,c){

                }
            });
        });
        var node;
        //关闭弹出框
        $('.close-btn').click(function () {
            $('#is_login_order').addClass('hide');
        });
        //弹出层
        $('.tab-item-box').eq(0).show();
        $('.tab-nav-bar .item').on('click',function(){
            var index = $(this).index();
            $(this).addClass('on').siblings().removeClass('on');
            $('.tab-item-box').hide();
            $('.tab-item-box').eq(index).show();
            bind_event();
        })
        //第三方登陆
        $('.other-login dd a').click(function(e){
            e.preventDefault();
            var href = $(this).attr('data') + '=' + encodeURIComponent(window.location.href);
            window.location.href=href;
        });
        //登陆
        $('#login_order').click(function(){
            node=$(this);
            //初始化登陆form
            var login_form=$("#user_fast_login");
            if($(".tab-nav-bar>span.item.on").attr('data-type')=='mobile_fast_login')
            {
                login_form=$("#mobile_fast_login");
            }
            login_form.submit();
        });
        $("#user_fast_login").validate({
            rules: {
                loginname: {
                    required: true,
                },
                loginpwd: {
                    required: true,
                    minlength: 6
                },
                logincode:{
                    required: true,
                },
            },
            messages: {
                loginname: {
                    required: '{__("error_user_not_empty")}',
                },
                loginpwd: {
                    required: '{__("error_pwd_not_empty")}',
                    minlength: '{__("error_pwd_min_length")}'
                },
                logincode:{
                    required: '{__("error_code_not_empty")}',
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
                //初始化登陆form
                var login_form=$("#user_fast_login");
                var url = SITEURL+'member/login/ajax_login';
                var loginname = $("#loginname").val();
                var loginpwd = $.md5($("#loginpwd").val());
                var frmcode = $("#frmcode").val();
                $.ajax({
                    type:"post",
                    async: false,
                    url:url,
                    data:{loginname:loginname,loginpwd:loginpwd,code:frmcode},
                    dataType:'json',
                    success: function(data){
                        if(data.status == '1'){//登陆成功,跳转到来源网址
                            ST.Login.login_callback(data);
//                                $('body').append(data.js);//同步登陆js
                            window.location.reload();
                        }
                        else
                        {
                            $('.login-error').show();
                            if(data.msg!=undefined){
                                $(".login-error").html(data.msg);
                            }else{
                                $(".login-error").html('{__("error_user_pwd")}');
                            }
                            if (login_form.find('.captcha').length <=0) {
                                var yzm_html='<div class="user-num"><input type="text" class="user-zh" name="logincode" id="frmcode" placeholder="请输入验证码">' +
                                    '<span class="yzm"><img class="captcha" src=""></span>' +
                                    '<span class="change-next change_yzm">换一张</span></div>';
                                login_form.find("div.user-name").after(yzm_html);
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
        $("#mobile_fast_login").validate({
            rules: {
                mobile:{
                    required: true,
                    isMobile:true,
                },
                login_code:{
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
                },
                login_code:{
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
                //初始化登陆form
                var login_form=$("#mobile_fast_login");
                var url = SITEURL+'member/login/ajax_check_sms_code';
                var phone = $("#mobile").val();
                var sms_code = $("#sms_code").val();
                var code = null;
                if(login_form.find("input[name=login_code]").length>0){
                    code = login_form.find("input[name=login_code]").val();
                }
                $.ajax({
                    type:"post",
                    async: false,
                    url:url,
                    data:{phone:phone,sms_code:sms_code,code:code},
                    dataType:'json',
                    success: function(data){
                        if(data.status == '1'){//登陆成功,跳转到来源网址
                            ST.Login.login_callback(data);
                            window.location.reload();
                            //$('body').append(data.js);//同步登陆js
                        }else{
                            $('.login-error').show();
                            if(data.msg!=undefined){
                                $(".login-error").html(data.msg);
                            }else{
                                $(".login-error").html('{__("error_user_pwd")}');
                            }
                            if (login_form.find('.captcha').length <=0) {
                                var yzm_html='<div class="user-num"><input type="text" class="user-zh" name="login_code" id="login_code" placeholder="请输入验证码">' +
                                    '<span class="yzm"><img class="captcha" src=""></span>' +
                                    '<span class="change-next change_yzm">换一张</span></div>';
                                login_form.find("div.user-phone").after(yzm_html);
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
    });
</script>
