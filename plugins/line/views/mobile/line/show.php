<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head font_html=oxACXC >
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {php echo Common::css('base.css,swiper.min.css,reset-style.css');}
    {Common::css_plugin('line.css','line')}
    {php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,delayLoading.min.js');}
</head>

<body>

    {request "pub/header_new/typeid/$typeid/isshowpage/1"}

    <div class="swiper-container st-photo-container" >
        <ul class="swiper-wrapper">
            {loop $info['piclist'] $pic}
             <li class="swiper-slide">
                <a class="item" href="javascript:;"><img class="swiper-lazy" data-src="{Common::img($pic[0],450,225)}"></a>
                <div class="swiper-lazy-preloader"></div>
             </li>
            {/loop}
        </ul>
        <div class="swiper-pagination"></div>
        <div class="pd-info-bar">
            {if $info['startcity']}
            <span class="item">{$info['startcity']}出发</span>
            |
            {/if}
            <span class="item">{if !empty($info['lineday'])}{$info['lineday']}天{/if}{if !empty($info['linenight'])}{$info['linenight']}晚{/if}</span>
            <span class="item fr">产品编号：{$info['lineseries']}</span>
        </div>
    </div>
    <!--轮播图-->

    <div class="line-show-top">
        <h1 class="tit">
            <!-- {if !empty($info['startcity'])}
            <span class="city">{if !empty($info['startcity'])}[{$info['startcity']}]{/if}</span>
            {/if} -->
            {if $info['color']}
                <span style="color: {$info['color']}">{$info['title']}</span>
            {else}
                {$info['title']}
            {/if}
            {if $GLOBALS['cfg_icon_rule']!=1}
            {loop $info['iconlist'] $v}
             <img class="icon" src="{$v['litpic']}"/>
            {/loop}
            {/if}
        </h1>
        <div class="txt">{$info['sellpoint']}</div>
        <div class="attr">
            {if $GLOBALS['cfg_icon_rule']==1}
            {loop $info['iconlist'] $v}
             <span class="label">{$v['kind']}</span>
            {/loop}
            {/if}
        </div>
        <div class="price">
            {if !empty($info['price'])}
             <span class="jg"><i class="currency_sy no-style">{Currency_Tool::symbol()}</i><span class="num">{$info['price']}</span>起</span>
            {else}
            <span class="jg"><span class="num">电询</span></span>
            {/if}
            {if $info['sellprice']>0}
            <span class="del">原价:<i class="currency_sy no-style">{Currency_Tool::symbol()}</i>{$info['sellprice']}</span>
            {/if}
        </div>
        {if $info['suppliers']}
        <div class="supplier">
            <span class="hd-item">供应商：</span>
            <div class="bd-item">{$info['suppliers']['suppliername']}</div>
        </div>
        {/if}
        <ul class="info">
            <li class="item">
                <span class="num">{$info['sellnum']}</span>
                <span class="unit">销量</span>
            </li>
            <li class="item">
                <span class="num">{$info['satisfyscore']}</span>
                <span class="unit">满意度</span>
            </li>
            <li class="item link pl">
                <span class="num">{$info['commentnum']}</span>
                <span class="unit">人点评</span>
                <i class="more-icon"></i>
            </li>
            <li class="item link question">
                <span class="num">{Model_Question::get_question_num($typeid,$info['id'])}</span>
                <span class="unit">人咨询</span>
                <i class="more-icon"></i>
            </li>
        </ul>
    </div>
    <!--顶部介绍-->

    <div class="discount-block">
    {if St_Functions::is_normal_app_install('coupon')}
    {request "coupon/float_box-$typeid-".$info['id']}
    {/if}
    <!--优惠券-->
    {if St_Functions::is_normal_app_install('together')}
    {request "together/app/typeid/".$typeid."/productid/".$info['id']}
    {/if}
    <!-- 拼团 -->
    </div>
    {st:line action="suit" productid="$info['id']" return="suitlist"}
    {if $suitlist && $info['status']==3}
    <div class="line-info-container">

        <div class="line-choose-date order" data-id="{$info['id']}"><i class="car-icon"></i>选择线路类型、出发日期<i class="more-icon"></i></div>
    </div>
    {/if}
    <!--产品信息-->

    {st:detailcontent action="get_content" typeid="1" productinfo="$info"}
        {loop $data $row}
        {if $row['columnname']=='jieshao'}
        <!--行程安排-->
        {if $info['isstyle']==1&&$info['jieshao']}
        <div class="line-info-container">
            <h3 class="line-info-bar">
                <span class="title-txt">{$row['chinesename']}</span>
            </h3>
            <div class="line-info-wrapper clearfix">
                <!--简洁版-->
                {Common::content_image_width($info['jieshao'],540,0)}
            </div>
        </div>
         <!--标准版-->
        {elseif $info['isstyle']==2}
        {php}$daysinfo = Model_Line_Jieshao::detail_mobile($row['content'],$info['lineday']);$k=0;
         foreach($daysinfo as $v)
         {
            if($v['title']){$k++;}
         }
        {/php}
        {if $k>0}
        <div class="line-info-container">
            <h3 class="line-info-bar">
                <span class="title-txt">{$row['chinesename']}</span>
                {php}$index=1;{/php}
                {loop $info['linedoc']['path'] $a $v}
                {if $index==1}
                <a class="down-file-btn"  href="/pub/download/?file={$v}&name={$info['linedoc']['name'][$a]}">下载行程</a>
                {/if}
                {php}$index++;{/php}
                {/loop}
            </h3>
            <div class="line-info-wrapper">
                <div class="eachday">
                    {loop $daysinfo $v}
                    {php} if(!$v['title']){break;}{/php}
                    <div class="day-num">
                        <div class="hd">
                            <span class="day-on">第{$v['day']}天</span>
                            <span class="dest">{$v['title']}</span>
                        </div>
                        <div class="hg clearfix">
                            {if $info['showrepast']==1}
                            <dl class="sum">
                                <dt class="yc"><i class="icon"></i>用餐</dt>
                                <dd class="con">
                                    {if $v['breakfirsthas']}
                                    {if !empty($v['breakfirst'])}
                                    <span class="tc">早餐：{$v['breakfirst']}</span>
                                    {else}
                                    <span class="tc">早餐：含</span>
                                    {/if}
                                    {else}
                                    <span class="tc">早餐：不含</span>
                                    {/if}

                                    {if $v['lunchhas']}
                                    {if !empty($v['lunch'])}
                                    <span class="tc">午餐：{$v['lunch']}</span>
                                    {else}
                                    <span class="tc">午餐：含</span>
                                    {/if}
                                    {else}
                                    <span class="tc">午餐：不含</span>
                                    {/if}

                                    {if $v['supperhas']}
                                    {if !empty($v['supper'])}
                                    <span class="tc">晚餐：{$v['supper']}</span>
                                    {else}
                                    <span class="tc">晚餐：含</span>
                                    {/if}
                                    {else}
                                    <span class="tc">晚餐：不含</span>
                                    {/if}
                                </dd>
                            </dl>
                            {/if}
                            {if $info['showhotel']==1}
                            <dl class="sum">
                                <dt class="zs"><i class="icon"></i>住宿</dt>
                                <dd class="con">
                                    {$v['hotel']}
                                </dd>
                            </dl>
                            {/if}
                            {if $info['showtran']==1}
                            <dl class="sum">
                                <dt class="jt"><i class="icon"></i>交通</dt>
                                <dd class="con">
                                    {loop explode(',',$v['transport']) $t}
                                    <span class="gj">{$t}</span>
                                    {/loop}
                                </dd>
                            </dl>
                            {/if}
                            <dl class="sum">
                                <dt class="xc"><i class="icon"></i>行程</dt>
                                <dd class="con clearfix">
                                    {$v['jieshao']}
                                </dd>
                                {if St_Functions::is_system_app_install(5)}
                                <dd class="spot">
                                    <ul class="clearfix">
                                        {st:line action="line_spot" day="$v['day']" productid="$v['lineid']" return="spotlist"}
                                        {php $sindex=1;}
                                        {loop $spotlist $spot}
                                        <li>
                                            <a class="item" href="{$spot['url']}">
                                                <img src="{$spot['litpic']}" alt="{$spot['title']}">
                                                <span class="bt">{$spot['title']}</span>
                                            </a>
                                        </li>
                                        {php $sindex++;}
                                        {/loop}
                                    </ul>
                                </dd>
                                {/if}
                            </dl>
                        </div>
                    </div>
                    {/loop}
                </div>
            </div>
        </div>
        {/if}
        {/if}
        {else}
        <!--其他-->
        <div class="line-info-container">
            <h3 class="line-info-bar">
                <span class="title-txt">{$row['chinesename']}</span>
            </h3>
            <div class="line-info-wrapper clearfix">
                {$row['content']}
            </div>
        </div>
        {/if}
        {/loop}
    {/st}

    {request "pub/code"}
    {request 'pub/footer'}
	{if $info['status']!=3}
	    <div class="product-under-shelves">
		    <div class="shelves-txt">非常抱歉！该商品已下架！</div>
	    </div>
    {/if}
    <div class="bom_link_box">
        <div class="bom_fixed">
            <a href="tel:{$GLOBALS['cfg_m_phone']}">电话咨询</a>
	        {if $info['status'] == 3 && $suitlist}
              <a class="on order"  data-id="{$info['id']}" href="javascript:;" >立即预定</a>
	        {else}
	        <a class="on order grey"   href="javascript:;" >立即预定</a>
	        {/if}
        </div>
    </div>

    {if St_Functions::is_normal_app_install('together')}
         {request "together/joinlist/typeid/$typeid/productid/".$info['id']}
    {/if}
    <!-- 参团弹出框 -->

    <script>

        $(function(){

            insertVideo();

            //详情页滚动图
            var mySwiper = new Swiper('.st-photo-container', {
                autoPlay: false,
                pagination : '.swiper-pagination',
                lazyLoading : true,
                observer: true,
                observeParents: true
            });

            $('.pl').click(function(){
                var url = SITEURL+"pub/comment/id/{$info['id']}/typeid/{$typeid}";
                window.location.href = url;
            });

            //问答页面
            $('.question').click(function(){
                var url = SITEURL+"question/product_question_list?articleid={$info['id']}&typeid={$typeid}";
                window.location.href = url;
            });

            //预订按钮
            $('.order').click(function(){
                var productid = $(this).attr('data-id');
                if(productid)
                {
                    url = SITEURL+'line/book/id/'+productid;
                    window.location.href = url;
                }
            })


            //拼团
            $(".group-info-block").click(function(){
                $(".group-list-block").show();
                $("html,body").css({height:"100%",overflow:"hidden"});
            });
            $("#group-close-ico").click(function(){
                $(".group-list-block").hide();
                $("html,body").css({height:"auto",overflow:"auto"});
            });

        });

        //视屏
        function insertVideo(){
            {if $info['product_video']}
                //{php}list($videoPath)=explode('|',$info['product_video']){/php}
                var video,
                    bigLIElem = '<li class="swiper-slide">' +
                                    '<video id="myVideo" class="video-js" preload="auto" width="100%" height="100%" style="object-fit:fill" x5-playsinline="true" webkit-playsinline="" playsinline="" poster="{Common::img($info['litpic'],450,225)}" data-setup="{}">' +
                                        '<source src="{$GLOBALS["cfg_m_main_url"]}{$videoPath}" type="video/mp4">' +
                                        '<source src="{$GLOBALS["cfg_m_main_url"]}{$videoPath}" type="video/webm">' +
                                    '</video>' +
                                    '<span class="vis-play-btn"></span>' +
                                    '<span class="vis-pause-btn hide"></span>' +
                                '</li>';    
                $(".swiper-wrapper").prepend(bigLIElem);

                video = document.getElementById("myVideo");
                $(".vis-play-btn").on("click",function(){
                    if(video.paused){
                        $(this).hide();
                        video.play();
                    }
                    else{
                        video.pause();
                    }
                });

                $(video).on("click",function(){
                    if(!video.paused){
                        if($(".vis-pause-btn").hasClass("hide")){
                            $(".vis-pause-btn").removeClass("hide");
                        }
                        else{
                            $(".vis-pause-btn").addClass("hide");
                        }
                    }
                });

                $(video).on("ended",function(){
                    $(".vis-play-btn").show();
                });


                $(".vis-pause-btn").on("click",function(){
                    $(this).addClass("hide");
                    $(".vis-play-btn").show();
                    video.pause();
                })

            {/if}
        }

    </script>

</body>
</html>
