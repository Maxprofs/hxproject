<?php defined('SYSPATH') or die();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    <meta name="apple-mobile-web-app-capable" content="yes" />
    {Common::css('swiper.min.css,base.css,lib-flexible.js')}
    {Common::css_plugin('m_ship.css','ship')}
    {Common::js('lib-flexible.js,Zepto.js,swiper.min.js,jquery.min.js,delayLoading.min.js')}
</head>

<body right_padding=BFIq_s  right_head=KmACXC >

{request "pub/header_new/typeid/$typeid/islistpage/1"}
    <!-- 公用顶部 -->
{st:ship action="room_kind" shipid="$info['id']"  row="100" return="roomkinds"}
{loop $roomkinds $roomkind}
    <div class="ship-cabin-wrapper">
        <h3 class="cabin-bar">{$roomkind['title']}</h3>
        {st:ship action="room" shipid="$info['id']" kindid="$roomkind['id']"  row="100" return="rooms"}
        {php}$k=1;{/php}
        {loop $rooms $room}
        <div class="ship-config-block">
            <dl class="ship-dl">
                <dt><i class="icon">{$k}</i>{$room['title']}</dt>
                <dd class="clearfix">
                    <span>窗型：{if $room['iswindow']==1}有窗{else}无窗{/if}</span>
                    <span>入住：{$room['peoplenum']}人</span>
                    <span>面积：{$room['area']}m²</span>
                    <span>楼层：{$room['floors_str']}</span>
                </dd>
            </dl>
            <div class="config-txt">
                {php}$content = $room['content'];{/php}
                {$content}
                {if strlen($content)>100}
                <span class="show-more">展开</span>
                {/if}
            </div>
            <div class="ship-config-slide swiper-container">
                <ul class="swiper-wrapper clearfix">
                    {php}
                    $pic_arr = explode(',',$room['piclist']);
					$litpic_arr = array();
                    foreach($pic_arr as &$pic)
                    {
                    $pieces = explode('||',$pic);
                    $pieces[0] = Common::img($pieces[0],144,98);
					$litpic_arr[] = $pieces[0];
                    $pic = implode('||',$pieces);
                    }
                    $room['piclist'] = implode(',',$pic_arr);
					
					
                    {/php}
                    {loop $litpic_arr $pic}
                    <li class="swiper-slide">
                        <a class="item-a" href="javascript:;">
                            <img  src="{$defaultimg}" st-src="{Common::img($pic)}"  alt="标题" />
                        </a>
                    </li>
                    {/loop}

                </ul>
            </div>
        </div>
        {php}$k++;{/php}
        {/loop}
    </div>
    <!-- 舱房详细 -->

{/loop}
{request 'pub/code'}
    <script>

        //头部下拉导航
        $(".st-user-menu").on("click",function(){
            $(".header-menu-bg,.st-down-bar").show();
            $("body").css("overflow","hidden")
        });
        $(".header-menu-bg").on("click",function(){
            $(".header-menu-bg,.st-down-bar").hide();
            $("body").css("overflow","auto")
        });

        //设施介绍
        var swiper = new Swiper('.ship-config-slide', {
                slidesPerView: 2.45,
            });

        //展开收起
        $(".show-more").on("click",function(){
            var $this = $(this);
            if( $this.hasClass("on") ){
                $this.removeClass("on").css("position","absolute").text("展开");
                $this.parent(".config-txt").css({
                    height:"1.92rem"
                })
            }
            else{
                $this.addClass("on").css("position","static").text("收起");
                $this.parent(".config-txt").css({
                    height:"auto"
                })
            }
        })

    </script>

</body>
</html>