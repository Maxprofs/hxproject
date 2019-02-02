<?php echo Common::css('header.css');?>
<?php echo Common::js('common.js');?>
<?php echo Common::js('login.js');?>
<?php if(St_Functions::is_normal_app_install('mobiledistribution')) { ?>
    <?php echo Model_Fenxiao::save_fxcode();?>
<?php } ?>
<div class="header_top">
    <?php if($showlogo==1) { ?>
        <!--检测城市站点是否安装-->
        <?php if(!St_Functions::is_normal_app_install('city_site')) { ?>
            <?php Common::img($GLOBALS['cfg_m_logo']) ?>
            <a class="header_logo" data-ajax="false" href="<?php echo $GLOBALS['cfg_m_main_url'];?>"><img src="<?php echo Common::img($GLOBALS['cfg_m_logo']);?>" height="30" /></a>
        <?php } else { ?>
            <?php echo Request::factory("city/header")->execute()->body(); ?>
        <?php } ?>
    <?php } else { ?>
    <a class="back-link-icon" <?php echo $backurl;?>  data-ajax="false"></a>
    <?php } ?>
    <h1 class="page-title-bar"><?php echo $channelname;?></h1>
    <div class="st-top-menu">
        <?php if(!$isindex) { ?>
        <span class="st-user-menu"></span>
        <div class="header-menu-bg"></div>
        <div class="st-down-bar">
            <ul>
                <li><a href="<?php echo $cmsurl;?>" data-ajax="false"><i class="icon home-ico"></i>首页</a></li>
                <li><a href="<?php echo $cmsurl;?>search" data-ajax="false"><i class="icon search-ico"></i>搜索</a></li>
                <li><a href="<?php echo $cmsurl;?>member" data-ajax="false"><i class="icon center-ico"></i>个人中心</a></li>
            </ul>
        </div>
        <?php } else { ?>
        <a class="st-user-center" href="<?php echo $cmsurl;?>member"></a>
        <?php } ?>
    </div>
</div>
<script>
    var SITEURL = "<?php echo URL::site();?>";
    $(function(){
        //头部下拉导航
        $(".st-user-menu").on("click",function(){
            $(".header-menu-bg,.st-down-bar").show();
            $("html,body").css({overflow:"hidden"})
        });
        $(".header-menu-bg").on("click",function(){
            $(".header-menu-bg,.st-down-bar").hide();
            $("html,body").css({overflow:"auto"})
        })
    })
function is_login($obj){
        var fx_url="content=<?php echo urlencode($info['title']);?>";
        if($obj['islogin']==1){
            if($obj['info']['fx_member']){
                if(window.location.href.indexOf('/show_')!=-1)
                {
                    var btn = $($obj['info']['fx_btn'].replace('[fx_url]', fx_url));
                    $('.bom_fixed a').eq(0).after(btn);
                    btn.attr('data-ajax',false);
                    btn.addClass('now-sell');
                }
            }
            //ST.
        }
    }
    //登陆检测
    ST.Login.check_login();
    //$('body').append('<script'+' type="text/javascript" src="'+SITEURL+'member/login/ajax_islogin"></'+'script>');
</script>
<!--微信分享-->
<?php if(!$isordershow) { ?>
<?php echo  Stourweb_View::template('pub/share');  ?>
<?php } ?>
