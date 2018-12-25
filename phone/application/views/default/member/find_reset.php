<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title color_head=CIACXC >{__('设置新密码')}-{$webname}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('style.css,extend.css')}
    <script type="text/javascript">
        var SITEURL = "{URL::site()}";
    </script>
    {Common::css('base.css,header.css,account.css')}
</head>
<body>
    <div class="header_top bar-nav">
        <a class="back-link-icon" href="{$url}"></a>
        <h1 class="page-title-bar">{__('找回密码')}2/2</h1>
    </div>
    <!-- 头部 -->
    <div class="account-container">
        <div class="account-content-box">
            <form id="form-submit">
                <ul class="account-group-list">
                    <li class="item-bar">
                        <input class="account-text form-clear-val" type="password" name="pwd" id="pwd" placeholder="{__('请输入新密码')}">
                        <i class="visible-icon hide"></i>
                    </li>
                    <li class="item-bar">
                        <input class="account-text form-clear-val" type="password" name="password" placeholder="{__('请再次输入密码')}">
                        <i class="visible-icon hide"></i>
                    </li>
                </ul>
                <div class="error_txt hide" id="error_txt"></div>
                <div class="login-entry-bar">
                    <a href="javascript:;"  class="login-bar-btn disabled" id="submit_btn">{__('重置密码')}</a>
                </div>
                <input type="hidden" name="query" value="{md5($data['user'])}"/>
                <input type="hidden" name="mid" value="{$data['mid']}"/>
                <input type="hidden" name="token" value="{$data['token']}">
            </form>
        </div>
    </div>
</body>
{Common::js('jquery.min.js,common.js,jquery.validate.min.js,layer2.0/layer.js,lib-flexible.js')}
{Common::js('login.js')}
{Common::js('Zepto.js,account.js')}
<script type="text/javascript">
$(document).ready(function(){
    var expired='{$expired}';
    if(expired=='1'){
        layer.open({
            content:'{__("account_find_pwd_expired")}',
            skin: 'msg',
            time: 3,
            end:function () {
                window.location.href='{$cmsurl}member/find';
            }
        });
    }else{
        //切换
        $('.account-group-list').eq(0).show();
    }
    //验证
    $('#form-submit').validate({
        rules:{
            pwd: {
                required: true,
                minlength: 6
            },
            password: {
                required: true,
                minlength: 6,
                equalTo: "#pwd"
            }
        },
        messages:{
            pwd:'{__("account_pwd_min_length")}',
            password:'{__("account_pwd_different")}'
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
            if (errorList.length < 1) {
                $("#submit_btn").removeClass('disabled');
            } else {
                $("#submit_btn").addClass('disabled');
                this.defaultShowErrors();
            }
        }
    });
    $('#submit_btn').click(function(){
        if($('#form-submit').valid()){
            //$('#form-submit').submit();
            if($('#form-submit').hasClass('disabled'))
            {
                return false;
            }
            var data={};
            $('#form-submit').find('input').each(function(){
                var name=$(this).attr('name');
                data[name]=$(this).val();
            });
            $.post(SITEURL+'member/find/ajax_reset_pwd',data,function(rs){
                if(parseInt(rs.status)<1){
                    layer.open({
                        content: rs.msg,
                        skin: 'msg',
                        time: 3
                    });
                    $('#msg').val('');
                }else{
                    layer.open({
                        content: rs.msg,
                        skin: 'msg',
                        time: 3,
                        end:function () {
                            window.location.href='{$cmsurl}member/login';
                        }
                    });
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
    });
});

</script>
</html>
