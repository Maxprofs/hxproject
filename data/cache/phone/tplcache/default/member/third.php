<div class="other-login-area">
    <div class="other-login-bar"><span class="tit"><?php echo __('其他方式登录');?></span></div>
    <div class="other-login-box">
        <a href="<?php echo $cmsurl;?>pub/thirdlogin/?type=qq&refer=<?php if($backurl) { ?><?php echo urlencode($backurl);?><?php } else { ?><?php echo urlencode($url);?><?php } ?>
" class="item qq"></a>
        <a href="<?php echo $cmsurl;?>pub/thirdlogin/?type=weibo&refer=<?php if($backurl) { ?><?php echo urlencode($backurl);?><?php } else { ?><?php echo urlencode($url);?><?php } ?>
" class="item wb"></a>
    </div>
</div>