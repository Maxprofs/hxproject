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
<?php echo Common::css('base.css,swiper.min.css');?>
<?php echo Common::css_plugin('article.css','article');?>
<?php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,template.js,delayLoading.min.js');?>
</head>
<body>
  <?php echo Request::factory("pub/header_new/typeid/$typeid")->execute()->body(); ?>
    <div class="swiper-container st-focus-banners" >
        <ul class="swiper-wrapper">
            <?php require_once ("E:/wamp64/www/phone/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'s_article_index_1',));}?>
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
        <div class="st-search-box">
            <input type="text" class="st-search-text keyword" placeholder="搜索攻略" />
            <input type="button" class="st-search-btn" value="" />
        </div>
    </div>
    <!--搜索-->
    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">最新<?php echo $channelname;?></span>
        </h3>
        <div class="news-random">
            <ul>
            </ul>
            <div class="random-btn">
                <a class="item" href="javascript:;" id="btnNextNewArticle"><i class="random-icon"></i>换一个</a>
            </div>
        </div>
    </div>
    <!--最新攻略-->
    <?php require_once ("E:/wamp64/www/phone/taglib/dest.php");$dest_tag = new Taglib_Dest();if (method_exists($dest_tag, 'query')) {$data = $dest_tag->query(array('action'=>'query','flag'=>'channel_nav','typeid'=>'4','row'=>'3',));}?>
    <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt"><?php echo $row['kindname'];?></span>
        </h3>
        <ul class="st-article-list">
            <?php $article_tag = new Taglib_Article();if (method_exists($article_tag, 'query')) {$articlelist = $article_tag->query(array('action'=>'query','flag'=>'mdd','destid'=>$row['id'],'offset'=>'0','row'=>'3','return'=>'articlelist','havepic'=>'false',));}?>
            <?php $n=1; if(is_array($articlelist)) { foreach($articlelist as $articlerow) { ?>
            <li>
                <a class="item" href="<?php echo $articlerow['url'];?>">
                    <div class="pic"><img src=<?php echo $defaultimg;?> st-src="<?php echo Common::img($articlerow['litpic'],235,160);?>" alt="<?php echo $articlerow['title'];?>" /></div>
                    <div class="info">
                        <p class="tit"><?php echo $articlerow['title'];?></p>
                        <p class="txt"><?php echo Common::cutstr_html($articlerow['summary'],30);?></p>
                        <p class="data">
                            <span class="mdd"><i class="icon"></i><?php echo $articlerow['finaldest']['kindname'];?></span>
                            <span class="num"><i class="icon"></i><?php echo $articlerow['shownum'];?></span>
                        </p>
                    </div>
                </a>
            </li>
            <?php $n++;}unset($n); } ?>
            
        </ul>
        <div class="st-more-bar">
            <a class="more-link" href="<?php echo $cmsurl;?>raiders/<?php echo $row['pinyin'];?>">查看更多</a>
        </div>
    </div>
    <!--成都攻略-->
    <?php $n++;}unset($n); } ?>
    
    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">热门目的地</span>
        </h3>
        <ul class="hot-city-list clearfix">
            <?php require_once ("E:/wamp64/www/phone/taglib/dest.php");$dest_tag = new Taglib_Dest();if (method_exists($dest_tag, 'query')) {$data = $dest_tag->query(array('action'=>'query','flag'=>'hot','typeid'=>'4','offset'=>'0','row'=>'16',));}?>
                <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
                <li>
                    <a class="item" href="<?php echo $cmsurl;?>raiders/<?php echo $row['pinyin'];?>"><?php echo $row['kindname'];?></a>
                </li>
                <?php $n++;}unset($n); } ?>
            
        </ul>
    </div><!--热门目的地-->
    <?php echo Request::factory("pub/footer")->execute()->body(); ?>
    <?php echo Request::factory("pub/code")->execute()->body(); ?>
    <script type="text/html" id="tpl_new_article">
        {{each list as value i}}
        <li>
            <a class="item" href="{{value.url}}">
                <div class="pic"><img src="{{value.litpic}}" alt="{{value.title}}" /></div>
                <div class="tit">{{value.title}}</div>
                <div class="txt">{{value.summary}}</div>
            </a>
        </li>
        {{/each}}
    </script>
    <?php echo Common::js('layer/layer.m.js');?>
    <script>
        var new_article_index = 0;
        $(function(){
            //文章目页滚动广告
            var adSwiper = new Swiper('.st-focus-banners', {
                autoplay: 5000,
                pagination : '.ad-pagination',
                lazyLoading : true,
                observer: true,
                observeParents: true
            });
            $("#btnNextNewArticle").click(function(){
                get_new_article();
            })
            get_new_article();
            $(".st-search-btn").click(function(){jump_search();})
        })
        function get_new_article(){
            layer.open({
                type: 2,
                content: '正在加载数据...',
                time :20
            });
            var url = SITEURL+'article/ajax_article_order';
            $.getJSON(url,{offset:new_article_index,count:1,havepic:false},function(data){
                if(data){
                    var html = template("tpl_new_article",data);
                    $(".news-random ul").html(html);
                    new_article_index++;
                }
                layer.closeAll();
            })
        };
        function jump_search(){
            var keyword = $(".keyword").val();
            var url = SITEURL+'raiders/all';
            if(url!=''){
                url+='?keyword='+encodeURIComponent(keyword);
            }
            location.href = url;
        }
    </script>
</body>
</html>
