<?php echo Common::css('header2.css');?>
<?php echo Common::css('base2.css');?>
<?php echo Common::js('delayLoading.min.js');?>
<?php echo Common::js('common.js');?>
<?php echo Common::js('login.js');?>
<?php if(St_Functions::is_normal_app_install('mobiledistribution')) { ?>
    <?php echo Model_Fenxiao::save_fxcode();?>
<?php } ?>
<?php if(!empty($channelname)) { ?>
<div class="header_top">
<a class="back-link-icon" <?php echo $backurl;?>  data-ajax="false"></a>
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
<?php } else { ?>
<div class="header-bar">
<?php if(!St_Functions::is_normal_app_install('city_site')) { ?>

<?php } else { ?>
<?php echo Request::factory("city/header")->execute()->body(); ?>
<?php } ?>
<div class="header-search-bar">
<input type="text" id="myinput" class="search-text" placeholder="目的地/酒店/景点/关键词" />
<input type="button" class="search-btn" />
</div>
<a class="header-ucenter-link" href="<?php echo $cmsurl;?>member"></a>
</div>
<?php } ?>
<!-- 头部 -->
<script type="text/javascript">
var SITEURL = "<?php echo $cmsurl;?>";
    //过滤非法字符
    function StripScript(s){
        var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）――|{}【】‘；：”“'。，、？]");
        var rs = "";
        for (var i = 0; i < s.length; i++) {
            rs = rs+s.substr(i, 1).replace(pattern, '');
        }
        return rs;
    }
//全局搜索s
$('.search-btn').click(function () {
var keyword = StripScript($.trim($("#myinput").val()));
if (keyword == '') {
keyword = $('#myinput').attr('placeholder');
if(keyword == '')
{
layer.open({
content: '<?php echo __("error_keyword_not_empty");?>',
btn: ['<?php echo __("OK");?>']
});
return false;
}
}
url = SITEURL +'search?keyword='+encodeURIComponent(keyword);
window.location.href = url;
});
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
        //登陆检测
        ST.Login.check_login();
        //$('body').append('<script'+' type="text/javascript" src="'+SITEURL+'member/login/ajax_islogin"></'+'script>');
    });
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
}
}
</script>
<?php echo  Stourweb_View::template('pub/share');  ?>
