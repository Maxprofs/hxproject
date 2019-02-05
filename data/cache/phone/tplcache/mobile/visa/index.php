<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head head_script=FZzCXC >
    <meta charset="utf-8">
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
    <?php } ?>
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>" />
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,swiper.min.css');?>
    <?php echo Common::css_plugin('visa.css','visa');?>
    <?php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,common.js,delayLoading.min.js');?>
</head>
    <?php echo Request::factory("pub/header_new/typeid/$typeid/islistpage/1")->execute()->body(); ?>
    <div class="swiper-container st-focus-banners" >
        <ul class="swiper-wrapper">
            <?php require_once ("E:/wamp64/www/phone/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'s_visa_index_1',));}?>
                <?php $n=1; if(is_array($data['aditems'])) { foreach($data['aditems'] as $v) { ?>
                    <li class="swiper-slide">
                        <a class="item" href="<?php echo $v['adlink'];?>"><img class="swiper-lazy" data-src="<?php echo Common::img($v['adsrc'],750,260);?>" title="<?php echo $v['adname'];?>" alt="<?php echo $v['adname'];?>" /></a>
                        <div class="swiper-lazy-preloader"></div>
                    </li>
                <?php $n++;}unset($n); } ?>
            
        </ul>
        <div class="swiper-pagination ad-pagination"></div>
    </div>
    <!--轮播图-->
    <div class="st-search">
        <div class="st-search-box" id="search">
            <input type="text" class="st-search-text" placeholder="国家/地区" />
            <input type="button" class="st-search-btn" value="" />
        </div>
    </div>
    <!--搜索-->
    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">热门国家/地区</span>
        </h3>
        <ul class="st-hot-visa clearfix">
        <?php $visa_tag = new Taglib_Visa();if (method_exists($visa_tag, 'area')) {$data = $visa_tag->area(array('action'=>'area','flag'=>'hot','row'=>'6',));}?>
            <?php $n=1; if(is_array($data)) { foreach($data as $v) { ?>
                <li>
                    <a class="item" href="<?php echo $v['url'];?>">
                        <img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($v['litpic'],210,142);?>" />
                        <span class="name"><?php echo $v['kindname'];?></span>
                    </a>
                </li>
            <?php $n++;}unset($n); } ?>
        
        </ul>
        <div class="st-more-bar">
            <a class="more-link" href="/phone/visa/all/">查看更多</a>
        </div>
    </div>
    <div class="flow-path-container">
        <div class="flow-path-bar">
            <h3 class="flow-path-tit">签证办理，快人一步</h3>
            <p class="flow-path-txt">省时 · 省事 · 省心 · 省力</p>
        </div>
        <div class="path-wrapper">
            <ul class="path-list">
                <li class="item">
                    <i class="icon1"></i>
                    <span class="node">提交签证材料</span>
                </li>
                <li class="item">
                    <i class="icon2"></i>
                    <span class="node">审核材料</span>
                </li>
                <li class="item">
                    <i class="icon3"></i>
                    <span class="node">送签(面试)</span>
                </li>
                <li class="item">
                    <i class="icon4"></i>
                    <span class="node">签证</span>
                </li>
            </ul>
            <div class="path-end"><i class="e-icon"></i>出签成功率99.8%</div>
        </div>
    </div>
    <?php echo Request::factory('pub/code')->execute()->body(); ?>
    <?php echo Request::factory('pub/footer')->execute()->body(); ?>
    <script type="text/javascript">
        $(function(){
            //签证栏目页滚动广告
            var adSwiper = new Swiper('.st-focus-banners', {
                autoplay: 5000,
                pagination : '.ad-pagination',
                lazyLoading : true,
                observer: true,
                observeParents: true
            });
            $('#search').find('input').focus(function(){
            });
            $('.st-search-btn').click(function(){
                var city = $('.st-search-text').val();
                if(city == ''){
                    $('.st-search-text').focus();
                }else{
                    window.location.href=SITEURL+'visa/all?country='+encodeURIComponent(city);
                }
            })
        })
    </script>
<body>
</body>
</html>
