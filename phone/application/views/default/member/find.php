<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title size_color=5ATBbm >{__('找回密码')}-{$webname}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('style.css,extend.css')}
    {Common::css('base.css,header.css,account.css')}
    <script type="text/javascript">
        var SITEURL = "{URL::site()}";
    </script>
    {Common::js('jquery.min.js,common.js,jquery.validate.min.js,jquery.validate.addcheck.js,layer2.0/layer.js,lib-flexible.js')}
    {Common::js('login.js')}
    {Common::js('Zepto.js,account.js')}
</head>
<body>
<div class="header_top bar-nav">
    <a class="back-link-icon" href="javascript:history.back(-1);"></a>
    <h1 class="page-title-bar">{__('找回密码')}1/2</h1>
</div>
<!-- 头部 -->
<div class="account-container">

    <div class="account-content-box">
        <div class="account-tab-bar">
            {if $isopen=='1'}
            <span class="item on" data-type="find_by_mobile">{__('手机号码找回')}</span>
            {/if}
            <span class="item {if $isopen!='1'}on{/if}" data-type="find_by_email">{__('电子邮箱找回')}</span>
        </div>
        <div class="account-tab-wrapper">
            <form id="form-submit">
                <ul class="account-group-list" id="find_by_mobile">
                    <li class="item-bar">
                        <input class="account-text form-clear-val" id="mobile" type="text" name="mobile" placeholder="{__('请输入注册时使用的手机号')}">
                        <i class="clear-icon hide"></i>
                    </li>
                    <li class="item-bar">
                        <input class="account-text form-clear-val" type="text" id="code" name="code" placeholder="{__('图形验证码')}">
                        <img class="pic-yzm captcha" src="" />
                    </li>
                    <li class="item-bar">
                        <input class="account-text form-clear-val" id="msg" type="text" name="msg" placeholder="{__('请输入短信验证码')}">
                        <span class="dyn-code" id="resend">{__('获取动态密码')}</span>
                    </li>
                </ul>
                <ul class="account-group-list" id="find_by_email">
                    <li class="item-bar">
                        <input class="account-text form-clear-val" type="text" name="email" id="email" placeholder="{__('请输入注册时使用的邮箱')}">
                        <i class="clear-icon hide"></i>
                    </li>
                    <li class="item-bar">
                        <input class="account-text form-clear-val" type="text" id="code2" name="code2" placeholder="{__('图形验证码')}">
                        <img class="pic-yzm captcha" src="" />
                    </li>
                </ul>
            </form>
        </div>
        <div class="st_txt_ts" style="margin-bottom: 0;font-size:0.4rem;margin-top:0.4rem"></div>
        <div class="error_txt hide" id="error_txt"></div>
        <div class="login-entry-bar">
            <a href="javascript:;" class="login-bar-btn disabled" id="next_step">{__('下一步')}</a>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    $(document).ready(function(){
        var accountTabBarItem = $('.account-tab-bar .item');
        var find_form;
        //登陆类型切换
        accountTabBarItem.on('click',function(){
            var _this = $(this);
            var index = _this.index();
            _this.addClass('on').siblings().removeClass('on');

            var find_type=_this.attr("data-type");
            $('.account-group-list').hide();
            $('#'+find_type).show();
            //更新
            bind_event();

            //清除错误信息
            $("#error_txt").html('');
        });
        //事件绑定
        function bind_event() {
            //初始化form
            find_form=$("#find_by_mobile");
            if($(".account-tab-bar>span.item.on").attr('data-type')=='find_by_email')
            {
                find_form=$("#find_by_email");
            }
            $('.st_txt_ts').hide();
            //初始化图形验证码
            find_form.find('.captcha').attr('src',ST.captcha(SITEURL+'captcha'));
            //刷新验证码
            find_form.find('.captcha').click(function(){
                $(this).attr('src',ST.captcha($(this).attr('src')));
            });
        }
        //初始化当前登陆框
        $(".account-tab-bar span.item.on").trigger('click');

        //验证
        $('#form-submit').validate({
            rules:{
                user:'required',
                email:{
                    required: true,
                    email: true,
                },
                mobile: {
                    required:true,
                    mobile:true,
                },
                code:{
                    required:true,
                },
                code2:{
                    required:true,
                },
                msg:'required',
            },
            messages:{
                user:'{__("account_user_required")}',
                mobile: {
                    required: '{__("account_mobile_required")}',
                    mobile: '{__("account_mobile_error")}',
                },
                email: {
                    required: '{__("account_email_required")}',
                    email: '{__("account_email_error")}',
                },
                code:{
                    required: '{__("account_code_required")}',
                },
                code2:{
                    required: '{__("account_code_required")}',
                },
                msg:'{__("account_sms_code_required")}',
            },
            errorElement: "p",
            errorPlacement: function(error, element) {
                var content=$('#error_txt').html();
                if(content==''){
                    error.appendTo($('#error_txt'));
                }
            },
            showErrors:function(errorMap,errorList){
                $('#error_txt').html('');
                if (errorList.length >= 1) {
                    this.defaultShowErrors();
                }
            },
            onkeyup:function(){
                if(this.checkForm())
                {
                    $('#next_step').removeClass('disabled');
                }else{
                    $('#next_step').addClass('disabled');
                }
            }
        });
        $("#resend").click(function () {
            $('#error_txt').html('');
            var bool = $(this).attr('do-send');
            if (bool === 'false') {
                return false;
            }
            find_form=$("#find_by_mobile");
            //除动态码外
            var node=$('#form-submit');
            node.find("input[name='msg']").rules("remove", 'required');
            if(node.valid()){
                //send sms
                var data={};
                data['user']=$("#mobile").val();
                data['code']=$("#code").val();
                $.post(SITEURL+'member/find/ajax_send_code',data,function(rs){
                    if(parseInt(rs.status)<1){
                        layer.open({
                            content: rs.msg,
                            skin: 'msg',
                            time: 3
                        });
                        $('#msg').val('');
                    }else{
                        $('.st_txt_ts').show().html(rs.msg);
                        count_down(120);
                        $("#msg").rules("remove", 'required');
                    }
                },'json')
            }else{
                layer.open({
                    content: $('#error_txt').html(),
                    skin: 'msg',
                    time: 3
                });
                return false;
            }
        });
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

        $("#next_step").click(function () {
            $('#error_txt').html('');
            var next_step=$(this);
            var node=$('#form-submit');
            //初始化登陆form
            find_form=$("#find_by_mobile");
            if($(".account-tab-bar>span.item.on").attr('data-type')=='find_by_email')
            {
                find_form=$("#find_by_email");
                if(node.valid()){
                    var data={};
                    find_form.find('input').each(function(){
                        var name=$(this).attr('name');
                        if(name=='email'){
                            data['user']=$("#email").val();
                        }else{
                            data[name]=$(this).val();
                        }
                    });
                    $.post(SITEURL+'member/find/index',data,function(rs){
                        console.log(rs);
                        if(parseInt(rs.status)<1){
                            layer.open({
                                content: rs.msg,
                                skin: 'msg',
                                time: 3
                            });
                        }else{
                            window.location.href=rs.url;
                        }
                    },'json');
                }else{
                    layer.open({
                        content: $('#error_txt').html(),
                        skin: 'msg',
                        time: 3
                    });
                    return false;
                }
            }else{
                $("#msg").rules("add", 'required');
                if(node.valid()){
                    if(next_step.hasClass('disabled'))
                    {
                        return false;
                    }
                    //check sms code
                    var data={};
                    find_form.find('input').each(function(){
                        var name=$(this).attr('name');
                        if(name=='mobile'){
                            data['user']=$("#mobile").val();
                        }else{
                            data[name]=$(this).val();
                        }
                    });
                    $.post(SITEURL+'member/find/ajax_check_sms_code',data,function(rs){
                        if(parseInt(rs.status)<1){
                            layer.open({
                                content: rs.msg,
                                skin: 'msg',
                                time: 3
                            });
                            $('#msg').val('');
                        }else{
                            window.location.href=rs.url;
                        }
                    },'json')
                }else{
                    layer.open({
                        content: $('#error_txt').html(),
                        skin: 'msg',
                        time: 3
                    });
                    return false;
                }
            }

        });
//        $('#submit_btn').click(function(){
//            var node=$(this).parents('form');
//        });
    });

</script>
</html>
