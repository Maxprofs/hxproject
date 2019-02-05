
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $webname;?></title>
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>"/>
    <?php } ?>
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>"/>
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,footer.css,header.css,swiper.min.css');?>
    <?php echo Common::css_plugin('tickets.css','spot');?>
    <?php echo Common::js('lib-flexible.js,swiper.min.js,zepto.js');?>
    <?php echo Common::js('jquery.min.js');?>
    <?php echo Common::js_plugin('tickets.js','spot');?>
</head>
<body>
<?php echo Request::factory("pub/header_new/default_tpl/header_new2/typeid/$typeid")->execute()->body(); ?>
<!-- 头部 -->
<div class="search-area clearfix">
<div class="search-area-bar">
    <input class="search-area-text keyword" type="text" name="" placeholder="搜索旅游景点" />
    <i class="search-btn-icon search"></i>
</div>
<a href="http://<?php echo $GLOBALS['main_host'];?>/plugins/productmap/spot/mapnear"><span class="position"><i class="near-icon"></i><span class="near-txt">周边景点</span></span></a>
</div>
<!-- 搜索 -->
<div class="swiper-container swiper-banner-container">
<ul class="swiper-wrapper">
    <?php require_once ("E:/wamp64/www/phone/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'s_spot_index_1',));}?>
    <?php $n=1; if(is_array($data['aditems'])) { foreach($data['aditems'] as $v) { ?>
        <li class="swiper-slide">
        <a class="item" href="<?php echo $v['adlink'];?>"><img src="<?php echo Common::img($v['adsrc'],540,137);?>" alt="<?php echo $v['adname'];?>" /></a>
        </li>
    <?php $n++;}unset($n); } ?>
    
</ul>
<!-- 分页器 -->
<div class="swiper-pagination"></div>
</div>
<!-- banner -->
<div class="product-recommend-module">
<div class="product-recommend-bar">精选人气景点</div>
<div class="swiper-container product-recommend-block">
<ul class="swiper-wrapper">
<?php $spot_tag = new Taglib_Spot();if (method_exists($spot_tag, 'query')) {$data = $spot_tag->query(array('action'=>'query','flag'=>'order','row'=>'5',));}?>
<?php $n=1; if(is_array($data)) { foreach($data as $k => $row) { ?>
<li class="swiper-slide">
<a href="<?php echo $row['url'];?>" class="item">
<div class="pic"><img src="<?php echo Common::img($row['litpic'],198,135);?>" alt="<?php echo $row['title'];?>"></div>
<div class="info">
<div class="tit"><?php echo $row['title'];?></div>
<?php if($row['price']) { ?>
<div class="price">&yen;<span class="num"><?php echo $row['price'];?></span>起</div>
<?php } else { ?>
<div class="price">电询</div>
<?php } ?>
</div>
<?php if($k < 3) { ?>
<i class="item-rank"><img src="/phone/public/images/rank-0<?php echo $k+1;?>.png" alt="" /></i>
<?php } ?>
</a>
</li>
<?php $n++;}unset($n); } ?>

</ul>
</div>
</div>
<!-- 精选 -->
<div class="product-container">
<div class="product-title-bar">
<h3>热门景点</h3>
</div>
<div class="product-list-block">
<ul>
<?php $spot_tag = new Taglib_Spot();if (method_exists($spot_tag, 'query')) {$data = $spot_tag->query(array('action'=>'query','flag'=>'order','offset'=>'5','row'=>'10',));}?>
<?php  $num = 0 ?>
<?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
<li>
<a class="item" href="<?php echo $row['url'];?>">
<div class="pro-pic"><span><img src="<?php echo Common::img($row['litpic'],115,115);?>" alt="<?php echo $row['title'];?>" /></span></div>
<div class="pro-info">
<h3 class="tit"><?php echo $row['title'];?></h3>
<div class="attr">
<?php $n=1; if(is_array($row['attrlist'])) { foreach($row['attrlist'] as $a) { ?>
<span class="sx"><?php echo $a['attrname'];?></span>
<?php $n++;}unset($n); } ?>
</div>
<div class="data">
<span><?php echo $row['commentnum'];?>条点评</span>
<span><?php echo $row['satisfyscore'];?>满意</span>
</div>
<div class="addr"><?php echo $row['address'];?></div>
</div>
            <div class="pro-price">
                <span class="price"><em>
                    <?php if($row['price']) { ?>
                            &yen;<strong><?php echo $row['price'];?></strong>起
                    <?php } else { ?>
                            <strong>电询</strong>
                    <?php } ?>
                </em></span>
            </div>
</a>
</li>
<?php  $num ++?>
<?php $n++;}unset($n); } ?>

</ul>
<?php if($num == 10) { ?>
<div class="module-more-bar">
<a class="module-more-link" href="<?php echo $cmsurl;?>spots/all/">查看更多</a>
</div>
    <?php } ?>
</div>
</div>
<!-- 产品列表 -->
<?php echo Request::factory("pub/footer/default_tpl/footer2")->execute()->body(); ?>
<a href="javascript:;" class="back-top" id="backTop"></a>
<script type="text/javascript">
//头部下拉导航
$(".st-user-menu").on("click", function() {
$(".header-menu-bg,.st-down-bar").show();
$("body").css("overflow", "hidden")
});
$(".header-menu-bg").on("click", function() {
$(".header-menu-bg,.st-down-bar").hide();
$("body").css("overflow", "auto");
});
    $(".header_top a.back-link-icon").attr({'data-ajax':'false','href':'<?php echo $cmsurl;?>'}).removeAttr('onclick').unbind('click');
$('.search').click(function(){
        var keyword = $('.keyword').val();
        var url = SITEURL + 'spots/all';
        if(keyword!=''){
            url+="?keyword="+encodeURIComponent(keyword);
        }
        window.location.href = url;
    })
</script>
</body>
</html>