<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{__('用户注册')}--{$webname}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('style.css,extend.css')}
    {Common::css('base.css,header.css,account.css,mobilebone.css')}
    <script type="text/javascript">
        var SITEURL = "{URL::site()}";
    </script>
    {Common::js('jquery.min.js,common.js,jquery.validate.min.js,layer2.0/layer.js,lib-flexible.js')}
    {Common::js('login.js')}
    {Common::js('Zepto.js,account.js,mobilebone.js')}
    <script>
        Mobilebone.evalScript = true;
    </script>
</head>
<style>
    .top_user_reg{
        font-size: 0.42rem!important;
    }
</style>
<body>
<div class="page out" id="reg">
    <div class="header_top bar-nav">
        <a class="back-link-icon" href="{$cmsurl}member/login" data-ajax=false></a>
        <h1 class="page-title-bar">{__('注册')}</h1>
    </div>
    <!-- 头部 -->
    <div class="account-container">

        <div class="account-content-box">

            <div class="account-tab-bar">
                <span class="item on" data-type="form-mobile">{__('手机号码注册')}</span>
                <span class="item" data-type="form-email">{__('电子邮箱注册')}</span>
            </div>

            <div class="account-tab-wrapper">
                <form id="form-mobile">
                    <ul class="account-group-list">
                        <li class="item-bar">
                            <input class="account-text form-clear-val" id="phone" type="text" name="user" placeholder="{__('请输入手机号码')}">
                            <i class="clear-icon hide"></i>
                        </li>
                        <li class="item-bar">
                            <input class="account-text form-clear-val" type="text" id="mobile_code" name="code" placeholder="{__('图形验证码')}">
                            <img  class="captcha yzm_pic cursor pic-yzm" src="" height="30"/>
                        </li>
                        {if $isopen}
                        <li class="item-bar">
                            <input class="account-text form-clear-val" type="text" name="msg" placeholder="{__('请输入短信验证码')}">
                            <span class="dyn-code cursor" id="resend" do-send="true">{__('获取动态验证码')}</span>
                        </li>
                        {/if}
                        <li class="item-bar">
                            <input class="account-text form-clear-val" type="password" name="pwd" placeholder="{__('设置登录密码(至少6位)')}">
                            <i class="clear-icon hide"></i>
                        </li>
                    </ul>
                    <input type="hidden" name="frmcode" value="{$frmcode}"/>
                </form>
                <form id="form-email">
                    <ul class="account-group-list">
                        <li class="item-bar">
                            <input class="account-text form-clear-val" id="email" type="text" name="user" placeholder="{__('请输入电子邮箱')}">
                            <i class="clear-icon hide"></i>
                        </li>
                        <li class="item-bar">
                            <input class="account-text form-clear-val" type="text" id="email_code" name="code" placeholder="{__('图形验证码')}">
                            <img  class="captcha yzm_pic cursor pic-yzm" src="" height="30"/>
                        </li>
                        {if $is_emailcode_open==1}
                        <li class="item-bar">
                            <input class="account-text form-clear-val" type="text" name="msg" placeholder="{__('请输入邮箱验证码')}">
                            <span class="dyn-code" id="email_resend" do-send="true">{__('获取动态验证码')}</span>
                        </li>
                        {/if}
                        <li class="item-bar">
                            <input class="account-text form-clear-val" type="password" name="pwd" placeholder="{__('设置登录密码(至少6位)')}">
                            <i class="clear-icon hide"></i>
                        </li>
                    </ul>
                    <input type="hidden" name="is_email"/>
                    <input type="hidden" name="frmcode" value="{$frmcode}"/>
                </form>
            </div>
            {if $is_agreement==1}
            <div class="register-agreement-bar">
                <span class="check-label checked" id="checkLabel"><i class="check-icon"></i>{__('同意我们的')}</span><a href="#registerAgreement">《{$GLOBALS['cfg_member_agreement_title']}》</a>
            </div>
            {/if}
            <div class="error_txt hide" id="error_txt"></div>
            <div class="login-entry-bar">
                <a href="javascript:;" class="login-bar-btn disabled" id="registerBarBtn">{__('注册')}</a>
            </div>
        </div>

    </div>
</div>
{if $is_agreement==1}
<div class="page out" id="registerAgreement">
    <header>
        <div class="header_top">
            <a class="back-link-icon" href="javascript:;"  data-rel="back"></a>
            <h1 class="page-title-bar">{$GLOBALS['cfg_member_agreement_title']}</h1>
        </div>
    </header>
    <!-- 公用顶部 -->
    <div class="page-content">
        <div class="bk-document-page">
            <div class="bk-content-wrap">
                {Common::content_image_width($GLOBALS['cfg_member_agreement'],540,0)}
            </div>
        </div>
    </div>
</div>
{/if}
</body>
<script type="text/javascript">
    $(document).ready(function () {
        var accountTabBarItem = $('.account-tab-bar .item');
        var reg_form;

        //登陆类型切换
        accountTabBarItem.on('click',function(){
            var _this = $(this);
            var index = _this.index();

            _this.addClass('on').siblings().removeClass('on');

            var reg_type=_this.attr("data-type");
            $('.account-group-list').hide();
            $('#'+reg_type).find(".account-group-list").show();
            //更新
            bind_event();
            //清除错误信息
            $("#error_txt").html('');
        });

        //事件绑定
        function bind_event() {
            //初始化form
            reg_form=$("#form-mobile");
            if($(".account-tab-bar>span.item.on").attr('data-type')=='form-email')
            {
                reg_form=$("#form-email");
            }
            //初始化图形验证码
            reg_form.find('.captcha').attr('src',ST.captcha(SITEURL+'captcha'));
            //刷新验证码
            reg_form.find('.captcha').click(function(){
                $(this).attr('src',ST.captcha($(this).attr('src')));
            });
        }

        bind_event();

        //初始化当前注册框
        $(".account-tab-bar span.item.on").trigger('click');

        //验证
        $('#form-mobile').validate({
            rules: {
                user: {
                    required: true,
                    mobile: true,
                    remote: {
                        url: SITEURL+'pub/ajax_check_username_available',
                        type: 'post',
                        data:{
                            username:function(){
                                return $("#phone").val();
                            }
                        }
                    }
                },
                msg: 'required',
                code:{
                    required:true,
                },
                pwd: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                user: {
                    required: '{__("account_mobile_required")}',
                    mobile: '{__("account_mobile_error")}',
                    remote:'{__("error_user_exists")}'
                },
                msg: '{__("account_sms_code_required")}',
                code:{
                    required: '{__("account_code_required")}',
                },
                pwd: {
                    required: '{__("account_pwd_required")}',
                    minlength: '{__("account_pwd_min_length")}'
                }

            },
            errorElement: "p",
            errorPlacement: function (error, element) {
                var content=$('#error_txt').html();
                if(content==''){
                    error.appendTo($('#error_txt'));
                }
            },
            showErrors: function (errorMap, errorList) {
                $('#error_txt').html('');
                if (errorList.length >= 1) {
                    this.defaultShowErrors();
                }
            },
            onkeyup:function(){
                if(this.checkForm())
                {
                    $('#registerBarBtn').removeClass('disabled');
                }else{
                    $('#registerBarBtn').addClass('disabled');
                }
            }
        });
        $('#form-email').validate({
            rules: {
                user: {
                    required: true,
                    email: true,
                    remote: {
                        url: SITEURL+'pub/ajax_check_username_available',
                        type: 'post',
                        data:{
                            username:function(){
                                return $("#email").val();
                            }
                        }
                    }
                },
                code:{
                    required:true,
                    remote:{
                        url: SITEURL+'pub/ajax_check_code',
                        type:'post',
                        data:{
                            checkcode:function(){
                                return $("#email_code").val();
                            }
                        }
                    }
                },
                msg: 'required',
                pwd: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                user: {
                    required: '{__("account_email_required")}',
                    email: '{__("account_email_error")}',
                    remote:'{__("error_user_exists")}'
                },
                msg: '{__("account_sms_code_required")}',
                code:{
                    required: '{__("account_code_required")}',
                    remote:'{__("account_code_error")}'
                },
                pwd: {
                    required: '{__("account_pwd_required")}',
                    minlength: '{__("account_pwd_min_length")}'
                }

            },
            errorElement: "p",
            errorPlacement: function (error, element) {
                var content=$('#error_txt').html();
                if(content==''){
                    error.appendTo($('#error_txt'));
                }
            },
            showErrors: function (errorMap, errorList) {
                $('#error_txt').html('');
                if (errorList.length >= 1) {
                    this.defaultShowErrors();
                }
            },
            onkeyup:function(){
                if(this.checkForm())
                {
                    $('#registerBarBtn').removeClass('disabled');
                }else{
                    $('#registerBarBtn').addClass('disabled');
                }
            }
        });
        var reg_type=1;
        $('.dyn-code').click(function() {
            $('#error_txt').html('');
            //初始化登陆form
            reg_form=$("#form-mobile");
            if($(".account-tab-bar>span.item.on").attr('data-type')=='form-email')
            {
                reg_type=2;
                reg_form=$("#form-email");
            }else{
                reg_type=1;
            }
            var _send_btn=$(this);
            var bool = _send_btn.attr('do-send');
            if (bool === 'false') {
                return false;
            }
            //除动态码外
            reg_form.find("input[name='msg']").rules("remove", 'required');
            //除密码外
            reg_form.find("input[name='pwd']").rules("remove", 'required');
            reg_form.find("input[name='pwd']").rules("remove", 'minlength');
            if(!reg_form.valid())
            {
                layer.open({
                    content: $('#error_txt').html(),
                    skin: 'msg',
                    time: 1.5
                });
                return false;
            }
            if (_send_btn.hasClass('disabled')) {
                _send_btn.text('获取动态验证码');
                return false;
            }
            //发送验证码
            var frmcode = "{$frmcode}";
            var code = reg_form.find("input[name='code']").val();
            if(reg_type==1)
            {
                var phone = $('#phone').val();
                $('#resend').attr('do-send','false').css("color","#999").removeClass('cursor').html("发送中...");
                $.post(SITEURL+'member/register/ajax_send_message', {'phone': phone,'frmcode':frmcode,'code':code}, function (bool) {
                    $('#error_txt').html('');
                    _send_btn.html("获取动态验证码");
                    if (bool != 1) {
                        var message = bool == 0 ? '发送失败，稍后在试' : bool;
                        layer.open({
                            content: message,
                            skin: 'msg',
                            time: 1.5
                        });
                        $('#resend').attr('do-send', 'true').css("color","#23cc77").addClass('cursor').html('获取动态验证码');
                    }else{
                        count_down(120);
                    }
                    return false;
                }, 'text');
            }else{
                var email = $('#email').val();
                $('#email_resend').attr('do-send','false').css("color","#999").removeClass('cursor').html("发送中...");
                $.post(SITEURL+'member/register/ajax_send_email_message', {'email': email,'frmcode':frmcode,'code':code}, function (bool) {
                    $('#error_txt').html('');
                    if (bool != 1) {
                        var message = bool == 0 ? '发送失败，稍后在试' : bool;
                        layer.open({
                            content: message,
                            skin: 'msg',
                            time: 1.5
                        });
                        $('#email_resend').attr('do-send', 'true').css("color","#23cc77").addClass('cursor').html('获取动态验证码');
                    }else{
                        count_down_email(120);
                    }
                    return false;
                }, 'text')
            }
        })
        function count_down(v) {
            if (v > 0) {
                $('#resend').html(--v+'秒后重新发送');
                $('#resend').attr('do-send','false').css("color","#999").removeClass('cursor');
                setTimeout(function () {
                    count_down(v);
                }, 1000);
            }
            else {
                $('#resend').attr('do-send', 'true').css("color","#23cc77").addClass('cursor').html('重新获取验证码');
            }
        }
        function count_down_email(v) {
            if (v > 0) {
                $('#email_resend').html(--v+'秒后重新发送');
                $('#email_resend').attr('do-send','false').css("color","#999").removeClass('cursor');
                setTimeout(function () {
                    count_down_email(v);
                }, 1000);
            }
            else {
                $('#email_resend').attr('do-send', 'true').css("color","#23cc77").addClass('cursor').html('重新获取验证码');
            }
        }
        //提交
        $('#registerBarBtn').click(function(){
            if($("#checkLabel").length>0&&!$("#checkLabel").hasClass('checked')){
                layer.open({
                    content: '请先阅读并同意我们的服务条款',
                    skin: 'msg',
                    time: 1.5
                });
                $('#registerBarBtn').addClass('disabled');
                return false;
            }
            $('#error_txt').html('');
            var node=$("#form-mobile");
            if($(".account-tab-bar>span.item.on").attr('data-type')=='form-email')
            {
                node=$("#form-email");
            }
            //var node=$(this).parents('form');
            //除密码外
            node.find("input[name='pwd']").rules("add",{required:true,minlength:6});
            if(node.find("input[name='msg']").length>0)
            {
                node.find("input[name='msg']").rules("add",{required:true});
            }
            if(node.valid()){
                var data={};
                node.find('input').each(function(){
                    if($(this).attr('type')!='button'){
                        data[$(this).attr('name')]=$(this).val();
                    }
                });
                $.post(SITEURL+'member/register/ajax_reg',data,function(rs){
                    if(parseInt(rs.status)<1){
                        layer.open({
                            content: rs.msg,
                            skin: 'msg',
                            time: 1.5
                        });
                        node.find('.captcha').attr('src',ST.captcha(SITEURL+'captcha'));
                    }else{
                        layer.open({
                            content: '{__("account_register_success")}',
                            skin: 'msg',
                            time: 2,
                            end:function(){
                               window.location.href=rs.url;
                            }
                        });    
                    }
                },'json');
            }else{
                layer.open({
                    content: $('#error_txt').html(),
                    skin: 'msg',
                    time: 1.5
                });
                return false;
            }
        });
    });
</script>
</html>
