<!doctype html> <html> <head table_head=awBCXC > <meta charset="utf-8"> <title><?php echo $seo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title> <?php if($seo['keyword']) { ?> <meta name="keywords" content="<?php echo $seo['keyword'];?>"/> <?php } ?> <?php if($seo['description']) { ?> <meta name="description" content="<?php echo $seo['description'];?>"/> <?php } ?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('base.css');?> <?php echo Common::css_plugin('zhuanti-list.css','zt');?> <?php echo Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js,SuperSlide.min.js');?> <script>
$(function() {
var offsetLeft = new Array();
var windowWidth = $(window).width();
function get_width() {
//设置"down-nav"宽度为浏览器宽度
$(".down-nav").width($(window).width());
$(".st-menu li").hover(function() {
var liWidth = $(this).width() / 2;
$(this).addClass("this-hover");
offsetLeft = $(this).offset().left;
//获取当前选中li下的sub-list宽度
var sub_list_width = $(this).children(".down-nav").children(".sub-list").width();
$(this).children(".down-nav").children(".sub-list").css("width", sub_list_width);
$(this).children(".down-nav").css("left", -offsetLeft);
$(this).children(".down-nav").children(".sub-list").css("left", offsetLeft - sub_list_width / 2 + liWidth);
var offsetRight = windowWidth - offsetLeft;
var side_width = (windowWidth - 1200) / 2;
if(sub_list_width > offsetRight) {
$(this).children(".down-nav").children(".sub-list").css({
"left": offsetLeft - sub_list_width / 2 + liWidth,
"right": side_width,
"width": "auto"
});
}
if(side_width > offsetLeft - sub_list_width / 2 + liWidth) {
$(this).children(".down-nav").children(".sub-list").css({
"left": side_width,
"right": side_width,
"width": "auto"
});
}
}, function() {
$(this).removeClass("this-hover");
});
};
get_width();
$(window).resize(function() {
get_width();
});
//首页焦点图
$('.st-focus-banners').slide({
mainCell: ".banners ul",
titCell: ".focus li",
effect: "fold",
interTime: 5000,
delayTime: 1000,
autoPlay: true
});

//城市站点
$(".head_start_city").hover(function(){
$(this).addClass("change_tab");
},function(){
$(this).removeClass("change_tab");
});
})
</script> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo $GLOBALS['cfg_indexname'];?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo $channelname;?> </div> <!-- 面包屑 --> <div class="st-zt-list"> <div class="zt-sort-block"> <a class="item <?php if(empty($sorttype)) { ?>on<?php } ?>
" href="/zt/">综合排序</a> <a class="item <?php if(!empty($sorttype)) { ?>on<?php } ?>
" href="/zt/?sorttype=<?php if($sorttype==1) { ?>2<?php } else { ?>1<?php } ?>
">时间<?php if(empty($sorttype)) { ?><i class="default-ico"></i><?php } else if($sorttype==1) { ?><i class="down-ico"></i><?php } else { ?><i class="up-ico"></i><?php } ?> </a> <span class="info">共计<em><?php echo $total;?></em>个专题</span> </div> <!-- 排序 --> <div class="zt-list-con"> <ul class="clearfix"> <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?> <li class="<?php if($n%4==0) { ?>mr_0<?php } ?>
"> <a href="<?php echo $row['url'];?>" class="pic"><img src="<?php echo Common::img($row['pc_banner'],271,134);?>" alt="<?php echo $row['title'];?>" /></a> <div class="info"> <a href="javascript:;" class="tit"><?php echo $row['title'];?></a> <p class="time">发布时间：<?php echo date('Y-m-d',$row['addtime']);?></p> </div> </li> <?php $n++;}unset($n); } ?> </ul> </div> </div> <!-- 砖头列表 --> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div> <!-- 翻页 --> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <script>
$(function() {
//动态获取改变窗口高度
function getConsize() {
$('.st-sidemenu-box').height($(window).height());
}
$(window).resize(function() {
getConsize()
});
getConsize();
})
</script> </body> </html>