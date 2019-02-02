<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo __('用户登录');?>--<?php echo $webname;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('style.css,extend.css');?>
    <?php echo Common::css('base.css,header.css,account.css');?>
    <?php echo Common::js('jquery.min.js,common.js,jquery.validate.min.js,layer2.0/layer.js,lib-flexible.js');?>
    <script type="text/javascript">
        var SITEURL = "<?php echo URL::site();?>";
    </script>
    <?php echo Common::js('login.js');?>
    <?php echo Common::js('Zepto.js,account.js');?>
</head>
<body>
<div class="header_top bar-nav">
    <a class="back-link-icon" href="<?php echo $url;?>"></a>
    <h1 class="page-title-bar"><?php echo __('登录');?></h1>
</div>
<!-- 头部 -->
<div class="account-container">
    <div class="account-content-box st_login">
        <div class="account-tab-bar">
            <span class="item<?php if($login_type!=2) { ?> on<?php } ?>
" data-type="form-submit"><?php echo __('账号密码登录');?></span>
            <?php if($isopen==1) { ?>
            <span class="item<?php if($login_type==2) { ?> on<?php } ?>
" data-type="sms-form-submit"><?php echo __('动态密码登录');?></span>
            <?php } ?>
        </div>
        <div class="account-tab-wrapper">
            <form id="form-submit">
                <ul class="account-group-list">
                    <li class="item-bar">
                        <input class="account-text form-clear-val" id="type" type="text" name="user" placeholder="<?php echo __('手机号');?>/<?php echo __('邮箱');?>">
                        <i class="clear-icon hide"></i>
                    </li>
                    <li class="item-bar">
                        <input class="account-text form-clear-val" id="loginPassWord" type="password" name="pwd" placeholder="<?php echo __('登录密码');?>">
                        <i class="clear-icon hide"></i>
                    </li>
                    <?php if(!$one) { ?>
                    <li class="item-bar">
                        <input class="account-text form-clear-val" type="text" id="user_code" name="code" placeholder="<?php echo __('图形验证码');?>">
                        <img class="pic-yzm captcha cursor" src="" />
                    </li>
                    <?php } ?>
                </ul>
            </form>
            <?php if($isopen==1) { ?>
            <form id="sms-form-submit">
                <ul class="account-group-list">
                    <li class="item-bar" id="account_phone_content">
                        <input class="account-text form-clear-val mobile" id="loginPhone" type="text" name="mobile" placeholder="<?php echo __('请输入手机号码');?>">
                        <i class="clear-icon hide"></i>
                    </li>
                    <?php if(!$one) { ?>
                        <li class="item-bar">
                            <input class="account-text form-clear-val" id="loginCheck" type="text" name="code" placeholder="<?php echo __('图形验证码');?>">
                            <img class="pic-yzm captcha cursor" src="" />
                        </li>
                    <?php } ?>
                    <li class="item-bar">
                        <input class="account-text form-clear-val" id="loginDynamic" type="text" name="sms_code" placeholder="<?php echo __('请输入短信验证码');?>">
                        <span class="dyn-code"><?php echo __('获取动态验证码');?></span>
                    </li>
                </ul>
            </form>
            <?php } ?>
        </div>
        <div class="error_txt hide" id="error_txt"></div>
        <div class="login-entry-bar">
            <a href="javascript:;" class="login-bar-btn" id="submit_btn"><?php echo __('登录');?></a>
        </div>
        <div class="account-jump-bar">
            <a href="<?php echo $cmsurl;?>member/register" class="link"><?php echo __('注册新用户');?></a>
            <a href="<?php echo $cmsurl;?>member/find" class="link"><?php echo __('找回密码');?></a>
        </div>
        <input type="hidden" id="send_waiting" value="<?php if($send_waiting) { ?><?php echo $send_waiting;?><?php } else { ?>0<?php } ?>
">
    </div>
    <?php echo Request::factory('member/login/third')->execute()->body(); ?>
    <!-- 第三方登陆 -->
</div>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        var accountTabBarItem = $('.account-tab-bar .item');
        var login_form,login_type=1;
var oHeight = $(document).height(); //浏览器当前的高度
$(window).resize(function(){
if($(document).height() < oHeight){
$(".other-login-area").css("position","static");
}else{
$(".other-login-area").css("position","absolute");
}
});

        //事件绑定
        function bind_event() {
            //初始化登陆form
            login_form=$("#form-submit");
            if($(".account-tab-bar>span.item.on").attr('data-type')=='sms-form-submit')
            {
                login_form=$("#sms-form-submit");
            }
            //初始化图形验证码
            login_form.find('.captcha').attr('src',ST.captcha(SITEURL+'captcha'));
            //刷新验证码
            login_form.find('.captcha').click(function(){
                $(this).attr('src',ST.captcha($(this).attr('src')));
            });
        }
        //登陆类型切换
//        $('.account-group-list').eq(0).show();
        accountTabBarItem.on('click',function(){
            var _this = $(this);
            var index = _this.index();
            _this.addClass('on').siblings().removeClass('on');
            var login_type=_this.attr("data-type");
            $('.account-group-list').hide();
            $('#'+login_type).find(".account-group-list").show();
            //更新
            bind_event();
            //清除错误信息
            $("#error_txt").html('');
//            $('.dyn-code').addClass('disabled');
        });
        //初始化
        bind_event();
        //初始化当前登陆框
        $(".account-tab-bar span.item.on").trigger('click');
        //验证
        $('#form-submit').validate({
            rules:{
                user:{
                    required:true,
                },
                email:{
                    required:true,
                    email: true,
                },
                mobile: {
                    required:true,
                    mobile:true,
                },
                code:{
                    required:true,
                },
                pwd: {
                    required: true,
                    minlength: 6
                },
            },
            messages:{
                user: {
                    required: '<?php echo __("account_user_required");?>',
                },
                mobile: {
                    required: '<?php echo __("account_mobile_required");?>',
                    mobile: '<?php echo __("account_mobile_error");?>',
                },
                email: {
                    required: '<?php echo __("account_email_required");?>',
                    email: '<?php echo __("account_email_error");?>',
                },
                code:{
                    required: '<?php echo __("account_code_required");?>',
                },
                pwd: {
                    required: '<?php echo __("account_pwd_required");?>',
                    minlength: '<?php echo __("account_pwd_min_length");?>'
                },
            },
            errorElement: "p",
            errorPlacement: function(error, element) {
                var content=$('#error_txt').html();
                if(content==''){
                    error.appendTo($('#error_txt'));
                }
            },
            showErrors:function(errorMap,errorList){
                $('#error_txt').html("");
                if (errorList.length >= 1) {
                    this.defaultShowErrors();
                }
            },
            onkeyup:function(){
                if(this.checkForm())
                {
                    $('#submit_btn').removeClass('disabled');
                }else{
                    $('#submit_btn').addClass('disabled');
                }
            }
        });
        //验证
        $('#sms-form-submit').validate({
            rules:{
                mobile: {
                    required:true,
                    mobile:true,
                    remote: {
                        url: SITEURL+'pub/ajax_check_username',
                        type: 'post',
                        data:{
                            username:function(){
                                return $("#loginPhone").val();
                            }
                        }
                    }
                },
                code:{
                    required:true,
                },
                sms_code:{
                    required:true,
                },
            },
            messages:{
                mobile: {
                    required: '<?php echo __("account_mobile_required");?>',
                    mobile: '<?php echo __("account_mobile_error");?>',
                    remote:'<?php echo __("error_user_noexists");?>'
                },
                code:{
                    required: '<?php echo __("account_code_required");?>',
                },
                sms_code:{
                    required: '<?php echo __("account_sms_code_required");?>',
                },
            },
            errorElement: "p",
            errorPlacement: function(error, element) {
                var content=$('#error_txt').html();
                if(content==''){
                    error.appendTo($('#error_txt'));
                }
            },
            showErrors:function(errorMap,errorList){
                $('#error_txt').html("");
                if (errorList.length >= 1) {
                    this.defaultShowErrors();
                }
            },
            onkeyup:function(){
                if(this.checkForm())
                {
                    $('#submit_btn').removeClass('disabled');
                }else{
                    $('#submit_btn').addClass('disabled');
                }
            }
        });
        //登陆账号类型检查
        $('#type').keyup(function(){
            var reg=/^[0-9]+$/;
            if(!reg.test($(this).val())){
                $(this).attr({class:'email account-text form-clear-val',name:'email'});
            }else{
                $(this).attr({class:'mobile account-text form-clear-val',name:'mobile'});
            }
        });
        var send_waiting=parseInt($("#send_waiting").val());
        if(send_waiting>0)
        {
            count_down(send_waiting);
        }
        function count_down(v) {
            if (v > 0) {
                $('.dyn-code').html(--v+'秒后重新发送');
                $('.dyn-code').attr('do-send','false').css("color","#999").removeClass('cursor');
                setTimeout(function () {
                    count_down(v);
                }, 1000);
            }else {
                $('.dyn-code').attr('do-send', 'true').css("color","#23cc77").addClass('cursor').html('重新获取验证码');
            }
        }
        $('.dyn-code').click(function(){
            $('#error_txt').html('');
            var bool = $(this).attr('do-send');
            if (bool === 'false') {
                return false;
            }
            //除动态码外
            $('#loginDynamic').rules("remove", 'required');
            if(!$("#sms-form-submit").valid())
            {
                layer.open({
                    content: $('#error_txt').html(),
                    skin: 'msg',
                    time: 1.5
                });
                return false;
            }
            $('.dyn-code').attr('do-send','false').css("color","#999").removeClass('cursor').html("发送中...");
            if($(this).hasClass('disabled'))
            {
                $(this).text('获取动态验证码');
                return false;
            }
            var phone=$("#loginPhone").val();
            var data={};
            data['phone']=phone;
            //验证码存在则不能为空
            if($("#loginCheck").length>0)
            {
                data['code']=$("#loginCheck").val();
            }
            ST.Login.login_sendCode_m(data,function (re) {
                if (parseInt(re.status) < 1) {
                    if(re.msg){
                        layer.open({
                            content: re.msg,
                            skin: 'msg',
                            time: 3
                        });
                    }else{
                        layer.open({
                            content: '<?php echo __("account_sms_code_send_error");?>',
                            skin: 'msg',
                            time: 3
                        });
                    }
                    $('.dyn-code').attr('do-send', 'true').css("color","#23cc77").addClass('cursor').html('获取动态验证码');
                    //login_form.find('.captcha').attr('src', ST.captcha(SITEURL + 'captcha'));
                }else{
                    if(re.type&&re.msg)
                    {
                        layer.open({
                            content: re.msg,
                            skin: 'msg',
                            time: 3
                        });
                    }else{
                        layer.open({
                            content: '<?php echo __("account_sms_code_send_success");?>',
                            skin: 'msg',
                            time: 3
                        });
                    }
                    count_down(120);
                    $('#submit_btn').removeClass('disabled');
                    return false;
                    //发送成功
                }
            });
        });
        //提交数据
        $('#submit_btn').click(function(){
            //动态获取当前的登陆类型
            login_form=$("#form-submit");
            if($(".account-tab-bar>span.item.on").attr('data-type')=='sms-form-submit')
            {
                login_form=$("#sms-form-submit");
                login_type=2;
                $('#loginDynamic').rules('add', {required: true});
            }else{
                login_type=1;
            }
            if(login_form.valid()){
                //账号登陆
                if(login_type==1)
                {
                    var data={};
                    login_form.find('input').each(function(){
                        if($(this).attr('type')!='button'){
                            var name=$(this).attr('name');
                            if(name=='email' || name=='mobile'){
                                data['user']=$(this).val();
                            }else{
                                data[name]=$(this).val();
                            }
                        }
                    });
                    ST.Login.login_in_m(data,function (rs) {
                        if (parseInt(rs.status) < 1) {
                            $('#submit_btn').addClass('disabled');
                            layer.open({
                                content: rs.msg,
                                skin: 'msg',
                                time: 1.5
                            });
                            if (login_form.find('.captcha').length <=0) {
                                var yzm_html='<li class="item-bar"><input class="account-text form-clear-val" type="text" name="code" placeholder="图形验证码">' +
                                    '<img class="pic-yzm captcha cursor" src="" /></li>';
                                login_form.find(".account-group-list").append(yzm_html);
                                login_form.find('.captcha').attr('src', ST.captcha(SITEURL + 'captcha'));
                                //刷新验证码
                                login_form.find('.captcha').click(function(){
                                    $(this).attr('src',ST.captcha($(this).attr('src')));
                                });
                            }
                            //login_form.find('.captcha').attr('src', ST.captcha(SITEURL + 'captcha'));
                        } else{
                            ST.Login.update_storage_login_data(rs.secret, rs.time);
                            layer.open({
                                content: '<?php echo __("success_login");?>',
                                skin: 'msg',
                                time: 2,
                                end: function () {
                                    window.location.href = rs.url;
                                }
                            });
                        }
                    })
                }else{
                    var data={};
                    login_form.find('input').each(function(){
                        if($(this).attr('type')!='button'){
                            var name=$(this).attr('name');
                            data[name]=$(this).val();
                        }
                    });
                    ST.Login.login_codeLogin_m(data,function (re2) {
                        if(re2.status){
                            ST.Login.update_storage_login_data(re2.secret, re2.time);
                            layer.open({
                                content: '<?php echo __("success_login");?>',
                                skin: 'msg',
                                time: 2,
                                end: function () {
                                    window.location.href = re2.url;
                                }
                            });
                        }else{
                            if(re2.msg){
                                layer.open({
                                    content: re2.msg,
                                    skin: 'msg',
                                    time: 3
                                });
                            }else{
                                layer.open({
                                    content: '<?php echo __("error_login");?>',
                                    skin: 'msg',
                                    time: 3
                                });
                            }
                            if (login_form.find('.captcha').length <=0) {
                                var yzm_html='<li class="item-bar"><input class="account-text form-clear-val" type="text" name="code" placeholder="图形验证码">' +
                                    '<img class="pic-yzm captcha cursor" src="" /></li>';
                                login_form.find(".account-group-list li#account_phone_content").after(yzm_html);
                            }
                            //login_form.find('.captcha').attr('src', ST.captcha(SITEURL + 'captcha'));
                        }
                    });
                }
            }else{
                layer.open({
                    content: $('#error_txt').html(),
                    skin: 'msg',
                    time: 1.5
                });
                return false;
            }
        });
    })
</script>
</html>