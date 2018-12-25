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

<body>

{request "pub/header_new/typeid/$typeid/islistpage/1"}
{st:ship action="facility" shipid="$info['id']" kindid="$kindid" row="100" return="facilities"}
{loop $facilities $facility}
    <div class="ship-config-wrapper">
        <h3 class="config-bar">
            <span class="tit">
                <strong class="zh">{$facility['title']}</strong>
<!--                <em class="eg">La Pergola Restaurant</em>-->
            </span>
        </h3>
        <div class="ship-config-block">
            <ul class="config-item">
                <li>
                    <span class="hd">开放时间</span>
                    <div class="bd">{$facility['opentime']}</div>
                </li>
                <li>
                    <span class="hd">是否免费</span>
                    <div class="bd">{if $facility['isfree']==1}免费{else}自费{/if}</div>
                </li>
                <li>
                    <span class="hd">所在楼层</span>
                    <div class="bd">{if $facility['floors_names']}{$facility['floors_names']}{else}无{/if}</div>
                </li>
                <li>
                    <span class="hd">着装建议</span>
                    <div class="bd">{if $facility['dress']}{$facility['dress']}{else}无{/if}</div>
                </li>
                <li>
                    <span class="hd">特色</span>
                    <div class="bd">{if $facility['sellpoint']}{$facility['sellpoint']}{else}无{/if}</div>
                </li>
            </ul>
            <div class="config-txt">
                {php}$content = $facility['content'];{/php}
                {$content}
                {if strlen($content)>100}
                <span class="show-more">展开</span>
                {/if}
            </div>
            <div class="ship-config-slide swiper-container">
                <ul class="swiper-wrapper clearfix">
                    {php}
                    $pic_arr = explode(',',$facility['piclist']);
					$litpic_arr = array();
                    foreach($pic_arr as &$pic)
                    {
                    $pieces = explode('||',$pic);
                    $pieces[0] = Common::img($pieces[0],144,98);
					$litpic_arr[] =  $pieces[0];
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
    </div>
{/loop}
    <!-- 设施描述 -->


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