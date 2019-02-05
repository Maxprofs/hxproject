<!DOCTYPE html>
<html>
<head html_div=tIACXC >
    <meta charset="UTF-8">
    <title>会员俱乐部</title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('style-new.css,member-club.css,mobilebone.css,swiper.min.css');?>
    <?php echo Common::js('lib-flexible.js');?>
    <?php echo Common::js('jquery.min.js,swiper.min.js');?>
</head>
<body>
<div id="clubHome" class="page out">
    <div class="header_top bar-nav">
        <a class="back-link-icon" href="<?php echo $cmsurl;?>member/index" data-ajax="false"></a>
        <h1 class="page-title-bar">会员俱乐部</h1>
        <div class="st-top-menu">
            <span class="st-user-menu"></span>
            <div class="header-menu-bg"></div>
            <div class="st-down-bar">
                <ul>
                    <li><a href="<?php echo $cmsurl;?>" data-ajax="false"><i class="icon home-ico"></i>首页</a></li>
                    <li><a href="<?php echo $cmsurl;?>search" data-ajax="false"><i class="icon search-ico"></i>搜索</a></li>
                    <li><a href="<?php echo $cmsurl;?>member" data-ajax="false"><i class="icon center-ico"></i>个人中心</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- 公用顶部 -->
    <div class="page-content">
        <?php if($member) { ?>
        <div class="club-hd-box">
            <a class="vip-name" href="<?php echo $cmsurl;?>member/club/member_rank"><?php echo $rank['current_rank']['name'];?></a>
            <a class="user-center" href="<?php echo $cmsurl;?>member/" data-ajax="false">
                <span class="user-hd-img">
                    <img src="<?php echo $member['litpic'];?>" alt="" title="" />
                    <i class="level"><?php echo $member['rank'];?></i>
                </span>
                <span class="user-name"><?php echo $member['nickname'];?></span>
            </a>
            <a class="integral" href="<?php echo $cmsurl;?>member/club/score">
                <span>可用积分：<em><?php echo $member['jifen'];?></em></span>
                <?php if(isset($rank["range"][$rank['current']])) { ?><span>距离升级还需：<?php  echo $rank["range"][$rank['current']]-$rank['jifen'];?> </span><?php } ?>
            </a>
            <div class="earn-integral">
                <h3>我要赚积分</h3>
                <a class="more" href="<?php echo $cmsurl;?>member/club/member_task">查看更多<i class="more-arrow"></i></a>
                <div class="eran-list">
                    <ul class="clearfix">
                        <?php $n=1; if(is_array($strategy)) { foreach($strategy as $s) { ?>
                        <li>
                            <div>
                                <i class="ico ico-<?php echo $label[$s['label']];?>"></i>
                                <p><?php echo $s['title'];?></p>
                                <p class="num">+<?php echo $s['value'];?></p>
                            </div>
                        </li>
                        <?php $n++;}unset($n); } ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="club-login-before">
            <div class="login-wrap">
                <img src="<?php echo $cmsurl;?>public/images/member-club-head.jpg" alt="" title="" />
                <a class="club-login-btn" data-ajax="false" href="<?php echo $cmsurl;?>member/login/">立即登录</a>
            </div>
        </div>
        <?php } ?>
        <?php require_once ("E:/wamp64/www/phone/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'s_club_index_1',));}?>
            <?php if($data['aditems']) { ?>
                <div class="swiper-container slide-img-block">
                    <div class="swiper-wrapper">
                        <?php $n=1; if(is_array($data['aditems'])) { foreach($data['aditems'] as $v) { ?>
                        <div class="swiper-slide">
                            <a class="pic" href="<?php echo $v['adlink'];?>"><img src="<?php echo Common::img($v['adsrc'],640,214);?>" alt="<?php echo $v['adname'];?>" /></a>
                        </div>
                        <?php $n++;}unset($n); } ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            <?php } ?>
        
        <!-- 图片切换 -->
<?php if(St_Functions::is_system_app_install(107)) { ?>
        <div class="integral-mall">
            <div class="integral-mall-box">
                <div class="title">
                    <h3>超值兑换</h3>
                    <a class="link-mall" data-ajax="false" href="<?php echo $cmsurl;?>integral"></a>
                </div>
                <ul class="list clearfix">
                    <?php ?>
                    <?php $n=1; if(is_array($integrals)) { foreach($integrals as $v) { ?>
                    <li>
                        <a data-ajax="false" href="<?php echo $v['url'];?>">
                            <div class="pic"><img src="<?php echo Common::img($v['litpic'],348,210);?>" alt="<?php echo $v['title'];?>" title="<?php echo $v['title'];?>"></div>
                            <p class="tit"><?php echo $v['title'];?></p>
                            <p class="num"><em><?php echo $v['need_jifen'];?></em>积分</p>
                        </a>
                    </li>
                    <?php $n++;}unset($n); } ?>
                </ul>
            </div>
        </div>
        <?php } ?>
        <div class="integral-ad-box">
            <ul class="clearfix">
                <li><a href="<?php echo $cmsurl;?>member/club/member_task"><img src="<?php echo $cmsurl;?>public/images/pic/mem-7.jpg" alt="" title="" /></a></li>
                <li><a href="<?php echo $cmsurl;?>member/club/member_rank"><img src="<?php echo $cmsurl;?>public/images/pic/mem-8.jpg" alt="" title="" /></a></li>
            </ul>
        </div>
    </div>
</div>
<!--绑定手机-->
<div id="bindPhone" class="page out" data-url="<?php echo $cmsurl;?>member/account/phone"  data-params="root=window&callback=callback_page"></div>
<!--绑定邮箱-->
<div id="bindMailbox" data-url="<?php echo $cmsurl;?>member/account/email"  data-params="root=window&callback=callback_page" class="page out"></div>
<!--个人资料-->
<div id="editData" class="page out" data-url="<?php echo $cmsurl;?>member/account/edit"  data-params="root=window&callback=callback_page"></div>
<!---->
<div id="myScore" class="page out" data-url="<?php echo $cmsurl;?>member/club/score" data-params="root=window&callback=callback_page"></div>
</body>
<?php echo Common::js('jquery.min.js,mobilebone.js,swiper.min.js,jquery.validate.min.js,jquery.layer.js,template.js,layer/layer.m.js');?>
<script type="text/javascript" src="//<?php echo $GLOBALS['main_host'];?>/res/js/jquery.validate.addcheck.js"></script>
<!--引入CSS-->
<link rel="stylesheet" type="text/css" href="//<?php echo $GLOBALS['main_host'];?>/res/js/webuploader/webuploader.css">
<!--引入JS-->
<script type="text/javascript" src="//<?php echo $GLOBALS['main_host'];?>/res/js/webuploader/webuploader.min.js"></script>
<script>
    var SITEURL = "<?php echo $cmsurl;?>";
    $(function(){
        //头部下拉导航
        $(".st-user-menu").on("click",function(){
            $(".header-menu-bg,.st-down-bar").show();
            $("html,body").css({overflow:"hidden"})
        });
        $(".header-menu-bg").on("click",function(){
            $(".header-menu-bg,.st-down-bar").hide();
            $("html,body").css({overflow:"auto"})
        });
    });
    Mobilebone.evalScript = true;
    window.callback_page = function (pageInto, pageOut, response) {
        var contain_id = $(pageInto).attr('id');
        var url = $(pageInto).attr('data-url');
        $("#" + contain_id).load(url);
    };
    window.is_login = function (object) {
        var login_status = parseInt($('#islogin').val());
        if (!login_status) {
            window.location.href = "<?php echo $cmsurl;?>member/login";
            return true;
        } else {
            return false;
        }
    };
    $('.back-center').click(function () {
        window.location.href = SITEURL;
    });
    //轮播图
    var mySwiper = new Swiper ('.slide-img-block', {
        pagination: '.slide-img-block .swiper-pagination',
        autoplay: 5000,
        observer:true,
        observeParents:true
    });
</script>
<link type="text/css" rel="stylesheet" href="<?php echo $cmsurl;?>public/mui/css/mui.picker.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $cmsurl;?>public/mui/css/mui.poppicker.css" />
<script src="<?php echo $cmsurl;?>public/mui/js/mui.min.js"></script>
<script src="<?php echo $cmsurl;?>public/mui/js/mui.picker.js"></script>
<script src="<?php echo $cmsurl;?>public/mui/js/mui.poppicker.js"></script>
<script src="<?php echo $cmsurl;?>public/mui/js/city.data-3.js" type="text/javascript" charset="utf-8"></script>
</html>