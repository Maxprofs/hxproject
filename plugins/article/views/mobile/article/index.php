<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
{if $seoinfo['keyword']}
<meta name="keywords" content="{$seoinfo['keyword']}" />
{/if}
{if $seoinfo['description']}
<meta name="description" content="{$seoinfo['description']}" />
{/if}
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
{Common::css('base.css,swiper.min.css')}
{Common::css_plugin('article.css','article')}
{Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,template.js,delayLoading.min.js')}

</head>
<body>

  	{request "pub/header_new/typeid/$typeid"}

    <div class="swiper-container st-focus-banners" >
        <ul class="swiper-wrapper">
            {st:ad action="getad" name="s_article_index_1"}
            {loop $data['aditems'] $v}
            <li class="swiper-slide">
                <a class="item" href="{$v['adlink']}"><img class="swiper-lazy" data-src="{Common::img($v['adsrc'],750,260)}" title="{$v['adname']}" alt="{$v['adname']}" /></a>
                <div class="swiper-lazy-preloader"></div>
            </li>
            {/loop}
            {/st}
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
            <span class="title-txt">最新{$channelname}</span>
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

    {st:dest action="query" flag="channel_nav" typeid="4" row="3"}
    {loop $data $row}
    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">{$row['kindname']}</span>
        </h3>
        <ul class="st-article-list">
            {st:article action="query" flag="mdd" destid="$row['id']" offset="0" row="3" return="articlelist" havepic="false"}
            {loop $articlelist $articlerow}
            <li>
                <a class="item" href="{$articlerow['url']}">
                    <div class="pic"><img src={$defaultimg} st-src="{Common::img($articlerow['litpic'],235,160)}" alt="{$articlerow['title']}" /></div>
                    <div class="info">
                        <p class="tit">{$articlerow['title']}</p>
                        <p class="txt">{Common::cutstr_html($articlerow['summary'],30)}</p>
                        <p class="data">
                            <span class="mdd"><i class="icon"></i>{$articlerow['finaldest']['kindname']}</span>
                            <span class="num"><i class="icon"></i>{$articlerow['shownum']}</span>
                        </p>
                    </div>
                </a>
            </li>
            {/loop}
            {/st}
        </ul>
        <div class="st-more-bar">
            <a class="more-link" href="{$cmsurl}raiders/{$row['pinyin']}">查看更多</a>
        </div>
    </div>
    <!--成都攻略-->
    {/loop}
    {/st}

    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">热门目的地</span>
        </h3>
        <ul class="hot-city-list clearfix">
            {st:dest action="query" flag="hot" typeid="4" offset="0" row="16"}
                {loop $data $row}
                <li>
                    <a class="item" href="{$cmsurl}raiders/{$row['pinyin']}">{$row['kindname']}</a>
                </li>
                {/loop}
            {/st}
        </ul>
    </div><!--热门目的地-->

    {request "pub/footer"}
    {request "pub/code"}

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

    {Common::js('layer/layer.m.js')}

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
