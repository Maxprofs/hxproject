<div class="other-login-area">
    <div class="other-login-bar"><span class="tit">{__('其他方式登录')}</span></div>
    <div class="other-login-box">
        <a href="{$cmsurl}pub/thirdlogin/?type=qq&refer={if $backurl}{urlencode($backurl)}{else}{urlencode($url)}{/if}" class="item qq"></a>
        <a href="{$cmsurl}pub/thirdlogin/?type=weibo&refer={if $backurl}{urlencode($backurl)}{else}{urlencode($url)}{/if}" class="item wb"></a>
    </div>
</div>