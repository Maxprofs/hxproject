<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head bottom_strong=rMQzDt >
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}"/>
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}"/>
    {/if}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {php echo Common::css('base.css,swiper.min.css,reset-style.css');}
    {Common::css_plugin('photo.css','photo')}
    {php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,delayLoading.min.js');}
</head>
<body>

    <!-- <header class="hide">
        <div class="header_top photo_bg_black">
            <div class="st_back"><a href="{$cmsurl}photos/"></a></div>
            <h1 class="tit">{$info['title']}</h1>
        </div>
    </header> -->

    {request "pub/header_new/typeid/$typeid/isshowpage/1"}
    
    <div class="photo-show-page">

        <div class="swiper-container st-photo-container">
            <ul class="swiper-wrapper">
                {loop $info['piclist'] $v}
                <li class="swiper-slide">
                    <img class="swiper-lazy" data-src="{Common::img($v['litpic'],540,0,true)}"/>
                    <div class="swiper-lazy-preloader"></div>
                </li>
                {/loop}
            </ul>
            <div class="swiper-pagination"></div>
        </div>

        <div class="photo-info" id="des">
            <h3 class="tit">{$info['title']}<span style=" margin-left: 10px"><i id="curPage" class="no-style"></i>/<i id="allPage" class="no-style"></i></span></h3>
            <div class="txt">
                {$info['content']}
            </div>
        </div>

    </div>

{request "pub/code"}

    <div class="dz-pl-box">
        <input class="txt comment-fb-link" type="text" placeholder="评论" />
        <a class="msg" href="{$cmsurl}pub/article_comment_list?typeid={$typeid}&articleid={$info['articleid']}"><i></i>{$info['commentnum']}</a>
        <a class="love {if !is_null(Session::instance()->get('comment_'.$info['id'].'_'.$typeid,null))}on{/if}" id="favorite"><i></i>{$info['favorite']}</a>
    </div>
    <!-- 评论 -->
    <div id="introduce" class="introduce">
        <div class="des">
            <h2>说明</h2>
            <div class="des-txt">
                <p>{$info['content']}</p>
            </div>
        </div>
        <a class="close" href="javascript:void(0)"></a>
    </div>
    <!--介绍弹出-->
<script>
    $(function () {

        //相册
        var mySwiper = new Swiper('.st-photo-container', {
            autoplay: 5000,
            lazyLoading : true,
            observer: true,
            observeParents: true,
            onInit: function(swiper){
                  document.getElementById("curPage").innerHTML = 1;
                  document.getElementById("allPage").innerHTML = (swiper.slides.length)
                },
            onSlideChangeStart: function(swiper){
               document.getElementById("curPage").innerHTML = swiper.activeIndex + 1;
            }
        });

        //介绍弹出
        $("#des").on("click",function(){
            $("#introduce").show();
            $("#des").hide();
        });

        $("#introduce .close").on("click",function(){
            $("#introduce").hide();
            $("#des").show();
        });

        $('.comment-fb-link').click(function () {
            var url = SITEURL + 'pub/article_write_comment?typeid={$typeid}&articleid=' + "{$info['articleid']}";
            window.location.href = url;
        });
        $('#favorite').click(function () {
            var node = $(this);
            if (!$(this).hasClass('on')) {
                $.post(SITEURL + 'photo/ajax_favorite', {typeid:'{$typeid}',id:'{$info["id"]}'}, function (result) {
                    if (result.status) {
                        node.addClass('on').html('<i></i>' + result.data);
                    }
                },'json')
            }
        });
    })
</script>
</body>
</html>
