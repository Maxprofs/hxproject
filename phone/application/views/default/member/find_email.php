<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{__('邮件找回密码')}-{$webname}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('style.css,extend.css')}
    {Common::css('base.css,header.css,account.css')}
    <script type="text/javascript">
        var SITEURL = "{URL::site()}";
    </script>
    {Common::js('jquery.min.js,common.js,jquery.validate.min.js,layer2.0/layer.js,lib-flexible.js')}
    {Common::js('login.js')}
    {Common::js('Zepto.js,account.js')}
</head>

<body>
<div class="header_top bar-nav">
    <a class="back-link-icon" href="{$url}"></a>
    <h1 class="page-title-bar">{__('已发送')}</h1>
</div>
<!-- 头部 -->

<div class="account-container">
    <div class="account-content-box">
        <div class="account-email-box" data="{$email}">
            <div class="email-icon"></div>
            <div class="email-txt">
                我们已向您的注册邮箱<br />{php} echo preg_replace('/(\w{4}).*@(.*?)/','$1****$2',$email);{/php}<br />发送了一封密码找回邮件，请您注意接收邮件
            </div>
            <div class="email-btn-bar"><a class="email-btn-link" target="_blank" href="{$login_email_url}">{__('去邮箱接收邮件')}</a></div>
            <div class="email-login-bar">{__('已邮件重置密码')}，<a class="email-login-link" href="{$cmsurl}member/login">{__('去登陆')} &gt;</a></div>
        </div>
    </div>
</div>
<script>
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
    }
</script>
</body>
</html>
