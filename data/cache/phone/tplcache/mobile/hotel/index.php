<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
<?php if($seoinfo['keyword']) { ?>
<meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
<?php } ?>
<?php if($seoinfo['description']) { ?>
<meta name="description" content="<?php echo $seoinfo['description'];?>" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php echo Common::css('base.css,swiper.min.css,reset-style.css');?>
<?php echo Common::css_plugin('hotel.css','hotel');?>
<?php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,delayLoading.min.js');?>
</head>
<body bottom_float=Yg2qek >
    <?php echo Request::factory("pub/header_new/typeid/$typeid")->execute()->body(); ?>
    
    <div class="swiper-container st-focus-banners">
        <ul class="swiper-wrapper">
            <?php require_once ("E:/wamp64/www/phone/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'s_hotel_index_1',));}?>
            <?php $n=1; if(is_array($data['aditems'])) { foreach($data['aditems'] as $v) { ?>
            <li class="swiper-slide">
                <a class="item" href="<?php echo $v['adlink'];?>"><img class="swiper-lazy" data-src="<?php echo Common::img($v['adsrc'],750,260);?>" title="<?php echo $v['adname'];?>" alt="<?php echo $v['adname'];?>"></a>
                <div class="swiper-lazy-preloader"></div>
            </li>
            <?php $n++;}unset($n); } ?>
            
        </ul>
        <div class="swiper-pagination"></div>
    </div>
    <!--轮播图-->
    <?php if(Plugin_Productmap::_is_installed()) { ?>
    <div class="st-search">
        <div class="st-search-box">
            <input type="text" class="st-search-text keyword"  placeholder="搜索<?php echo $channelname;?>" />
            <input type="button" class="st-search-btn search" value="" />
        </div>
        <!--搜索-->
        <a class="map-near" href="//<?php echo $GLOBALS['main_host'];?>/plugins/productmap/hotel/mapnear"></a>
    </div>
    <?php } else { ?>
    <div class="st-search">
        <div class="st-search-box">
            <input type="text" class="st-search-text keyword"  placeholder="搜索<?php echo $channelname;?>" />
            <input type="button" class="st-search-btn search" value="" />
        </div>
        <!--搜索-->
    </div>
    <?php } ?>
    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt"><?php echo $channelname;?>推荐</span>
        </h3>
        <div class="swiper-container st-hot-hotel">
            <ul class="swiper-wrapper">
                <?php $hotel_tag = new Taglib_Hotel();if (method_exists($hotel_tag, 'query')) {$data = $hotel_tag->query(array('action'=>'query','flag'=>'order','row'=>'3',));}?>
                <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
                <li class="swiper-slide">
                    <a class="item" href="<?php echo $row['url'];?>">
                        <div class="pic"><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($row['litpic'],312,212);?>" /></div>
                        <div class="info">
                            <div class="tit"><?php echo $row['title'];?></div>
                            <div class="attr">
                                <?php $n=1; if(is_array($row['attrlist'])) { foreach($row['attrlist'] as $v) { ?>
                                <span class="label"><?php echo $v['attrname'];?></span>
                                <?php $n++;}unset($n); } ?>
                            </div>
                            <div class="price">
                                <?php if(!empty($row['price'])) { ?>
                                <span class="jg"><i class="currency_sy no-style"><?php echo Currency_Tool::symbol();?></i><span class="num"><?php echo $row['price'];?></span>起</span>
                                <?php } else { ?>
                                <span class="dx">电询</span>
                                <?php } ?>
                                <?php if(!empty($row['sellprice'])) { ?>
                                <span class="del">原价：<?php echo $row['sellprice'];?>元</span>
                                <?php } ?>
                            </div>
                        </div>
                    </a>
                </li>
                <?php $n++;}unset($n); } ?>
                
            </ul>
            <div class="swiper-pagination hot-pagination"></div>
        </div>
    </div>
    <!--产品推荐-->
    <?php require_once ("E:/wamp64/www/phone/taglib/dest.php");$dest_tag = new Taglib_Dest();if (method_exists($dest_tag, 'query')) {$data = $dest_tag->query(array('action'=>'query','flag'=>'channel_nav','typeid'=>'2','row'=>'3',));}?>
    <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt"><?php echo $row['kindname'];?></span>
        </h3>
        <ul class="st-list-block clearfix">
            <?php $hotel_tag = new Taglib_Hotel();if (method_exists($hotel_tag, 'query')) {$list = $hotel_tag->query(array('action'=>'query','flag'=>'mdd','destid'=>$row['id'],'return'=>'list','row'=>'4',));}?>
            <?php $n=1; if(is_array($list)) { foreach($list as $h) { ?>
            <li>
                <a class="item" href="<?php echo $h['url'];?>">
                    <div class="pic"><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($h['litpic'],330,225);?>" alt="<?php echo $h['title'];?>" /></div>
                    <div class="tit"><?php echo $h['title'];?></div>
                    <div class="price">
                        <?php if(!empty($h['price'])) { ?>
                        <span class="jg"><i class="currency_sy no-style"><?php echo Currency_Tool::symbol();?></i><span class="num"><?php echo $h['price'];?></span>起</span>
                        <?php } else { ?>
                        <span class="dx">电询</span>
                        <?php } ?>
                    </div>
                </a>
            </li>
            <?php $n++;}unset($n); } ?>
        </ul>
        <div class="st-more-bar">
            <a class="more-link" href="<?php echo $cmsurl;?>hotels/all/">查看更多</a>
        </div>
    </div>
    <!--周边酒店-->
    <?php $n++;}unset($n); } ?>
    
  <?php echo Request::factory("pub/code")->execute()->body(); ?>
  <?php echo Request::factory("pub/footer")->execute()->body(); ?>
  <script>
      $(function(){
        //酒店栏目页滚动广告
        var mySwiper = new Swiper('.st-focus-banners', {
            autoplay: 5000,
            pagination : '.swiper-pagination',
            lazyLoading : true,
            observer: true,
            observeParents: true
        });
        //酒店栏目页推荐产品
        var hotSwiper = new Swiper('.st-hot-hotel', {
            autoplay: 5000,
            pagination : '.hot-pagination',
            observer: true,
            observeParents: true
        });
        $('.search').click(function(){
            var keyword = $(".keyword").val();
            var url = SITEURL + 'hotels/all';
            if(keyword!=''){
              url+="?keyword="+encodeURIComponent(keyword);
            }
            window.location.href = url;
        })
      })
  </script>
</body>
</html>
