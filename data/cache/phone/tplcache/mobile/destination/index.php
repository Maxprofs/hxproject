<!doctype html>
<html>
<head html_script=vIACXC >
<meta charset="utf-8">
<title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
<?php if($seoinfo['keyword']) { ?>
<meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
<?php } ?>
<?php if($seoinfo['description']) { ?>
<meta name="description" content="<?php echo $seoinfo['description'];?>" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php echo Common::css('base.css,swiper.min.css,destination.css');?>
<?php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,template.js');?>
</head>
<body>
  <?php echo Request::factory("pub/header_new/typeid/$typeid")->execute()->body(); ?>
    <div class="swiper-container st-focus-banners" >
        <ul class="swiper-wrapper">
            <?php require_once ("E:/wamp64/www/phone/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'s_dest_index_1',));}?>
            <?php $n=1; if(is_array($data['aditems'])) { foreach($data['aditems'] as $v) { ?>
            <li class="swiper-slide">
                <a class="item" href="<?php echo $v['adlink'];?>"><img class="swiper-lazy" data-src="<?php echo Common::img($v['adsrc'],750,260);?>"></a>
                <div class="swiper-lazy-preloader"></div>
            </li>
            <?php $n++;}unset($n); } ?>
            
        </ul>
        <div class="swiper-pagination ad-pagination"></div>
    </div>
    <!--轮播图-->
    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">热门目的地</span>
        </h3>
        <ul class="hot-dest-list clearfix">
            <?php $destination_tag = new Taglib_Destination();if (method_exists($destination_tag, 'query')) {$data = $destination_tag->query(array('action'=>'query','flag'=>'hot','typeid'=>'12','offset'=>'0','row'=>'6',));}?>
            <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
            <li>
                <a class="item" href="<?php echo $cmsurl;?><?php echo $row['pinyin'];?>">
                    <img src="<?php echo Common::img($row['litpic'],210,142);?>"  alt="<?php echo $row['kindname'];?>" />
                    <span class="tit"><?php echo $row['kindname'];?></span>
                </a>
            </li>
            <?php $n++;}unset($n); } ?>
            
        </ul>
    </div>
    <!--热门目的地-->
    <div class="dest-list-box">
        <?php $destination_tag = new Taglib_Destination();if (method_exists($destination_tag, 'query')) {$data = $destination_tag->query(array('action'=>'query','flag'=>'next','typeid'=>'12','offset'=>'0','row'=>'9999','pid'=>'0',));}?>
        <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
        <h3><i class="icon"></i><a href="<?php echo $cmsurl;?><?php echo $row['pinyin'];?>"><?php echo $row["kindname"];?></a></h3>
        <div class="con">
            <?php $destination_tag = new Taglib_Destination();if (method_exists($destination_tag, 'query')) {$data1 = $destination_tag->query(array('action'=>'query','flag'=>'next','typeid'=>'12','offset'=>'0','row'=>'9999','pid'=>$row['id'],'return'=>'data1',));}?>
            <?php $n=1; if(is_array($data1)) { foreach($data1 as $row1) { ?>
            <dl>
                <dt><a href="<?php echo $cmsurl;?><?php echo $row1['pinyin'];?>"><?php echo $row1["kindname"];?></a></dt>
                <dd>
                    <?php $destination_tag = new Taglib_Destination();if (method_exists($destination_tag, 'query')) {$data2 = $destination_tag->query(array('action'=>'query','typeid'=>'12','flag'=>'next','offset'=>'0','row'=>'9999','pid'=>$row1['id'],'return'=>'data2',));}?>
                    <?php $n=1; if(is_array($data2)) { foreach($data2 as $row2) { ?>
                    <a href="<?php echo $cmsurl;?><?php echo $row2['pinyin'];?>"><?php echo $row2["kindname"];?></a>
                    <?php $n++;}unset($n); } ?>
                    
                </dd>
            </dl>
            <?php $n++;}unset($n); } ?>
            
        </div>
        <?php $n++;}unset($n); } ?>
        
        <!--目的地列表-->
    </div>
    <?php echo Request::factory("pub/footer")->execute()->body(); ?>
    <?php echo Request::factory("pub/code")->execute()->body(); ?>
    <script>
        $(function(){
            //目的地栏目页滚动广告
            var adSwiper = new Swiper('.st-focus-banners', {
                autoplay: 5000,
                pagination : '.ad-pagination',
                lazyLoading : true,
                observer: true,
                observeParents: true
            });
        })
    </script>
</body>
</html>
