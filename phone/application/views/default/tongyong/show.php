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
    {Common::css('base.css,tongyong.css,swiper.min.css,reset-style.css,mobilebone.css')}
    {Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,delayLoading.min.js,mobilebone.js')}
</head>
    <style>
       .suitdisable {
        background: #c5c5c5!important;
        }
    </style>
<body>
<div class="page out" id="pageHome">
    {request "pub/header_new/typeid/$typeid/isshowpage/1"}
     
    <div class="swiper-container st-photo-container" >
        <ul class="swiper-wrapper">
        {loop $info['piclist'] $pic}
            <li class="swiper-slide">
                <a class="item" href="javascript:;"><img class="swiper-lazy" data-src="{Common::img($pic[0],750,375)}"></a>
                <div class="swiper-lazy-preloader"></div>
            </li>
        {/loop}
        </ul>
        <div class="swiper-pagination"></div>
    </div>
    <!--轮播图-->
      
      <div class="ty-show-top">
      	<p class="tit">{$info['title']}</p>
      	<p class="txt">{$info['sellpoint']}</p>
        <div class="supplier_data clearfix hide">
          {if $info['suppliers']}
          <p class="supplier">供应商：{$info['suppliers']['suppliername']}</p>
          {/if}
          {if $info['xxxxx']}
          <s></s>
          <p class="num">{$info['sellnum']}人参加过</p>
          <s></s>
          <p class="dest">目的地：{$info['finaldest_name']}</p>
          {/if}
        </div>
      	<p class="price" id ="price_txt">
            {if !empty($info['price'])}
            <span class="jg"><i class="currency_sy no-style">{Currency_Tool::symbol()}</i><span class="num">{$info['price']}</span>起</span>
            {else}
            <span class="jg">电询</span>
            {/if}
            <del class="del">原价:<i class="currency_sy no-style">{Currency_Tool::symbol()}</i>{$info['sellprice']}</del>
        </p>
        {if !empty($minsuit)}
        <p class="jf"> {if !empty($info['jifentprice_info'])}积分抵现:{$info['jifentprice_info']['jifentprice']}&nbsp;&nbsp;{/if}{if !empty($info['jifencomment_info'])}评论送积分:{$info['jifencomment_info']['value']}&nbsp;&nbsp;{/if}{if !empty($info['jifenbook_info'])}预订送积分:{$info['jifenbook_info']['value']}{if $info['jifenbook_info']['rewardway']==1}%{else}分{/if}{/if}</p>
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
      
      <!-- <div class="cp_show_msg">
        <div class="opt_type">选择产品类型<i>&gt;</i></div>
      </div> -->
      <!--产品信息-->


        <!--优惠券-->
        {if St_Functions::is_normal_app_install('coupon')}
        {request "coupon/float_box-$typeid-".$info['id']}
        {/if}

        {st:tongyong action="suit" productid="$info['id']" row="100" return="suits"}
        {if !empty($suits)}
        <div class="campaign-pack-block">
            <h3 class="title-bar">活动套餐</h3>
            <ul class="attr-list" id="suits_con">

                {loop $suits $k $suit}
                <li class="item clearfix" data-suitid="{$suit['id']}" data-price="{$suit['price']}"><span class="bt">{$suit['suitname']}</span><a href="#suit_des_{$suit['id']}"><i class="ico"></i></a><span class="price"></span>
                <div class="childdesc"  style="display: none">{$suit['childdesc']}</div>
                </li>
                {/loop}
            </ul>
        </div>
        {/if}
        

      <div class="ty-info-container">
        <h3 class="ty-info-bar">
            <span class="title-txt">产品介绍</span>
        </h3>
        <div class="ty-info-wrapper clearfix">
        	{$info['content']}
        </div>
      </div>
	    {st:detailcontent action="get_content" typeid="$typeid" productinfo="$info" return="tongyong"}
        {loop $tongyong $row}
      <div class="ty-info-container">
        <h3 class="ty-info-bar">
            <span class="title-txt">{$row['chinesename']}</span>
        </h3>
        <div class="ty-info-wrapper clearfix">
            {$row['content']}
        </div>
      </div>
        {/loop}
        {/st}

    </div>
    
  </section>

{request 'pub/footer'}
{request "pub/code"}
  <div class="bom_link_box">
    <div class="bom_fixed">
        <a href="tel:{$GLOBALS['cfg_m_phone']}">电话咨询</a>
        <a class="on order suitdisable" id='colorbook'  data-id="{$info['id']}" href="javascript:;">立即预定</a>
    </div>
  </div>
  </div>
    {loop $suits $k $suit}
        <div class="page out" id="suit_des_{$suit['id']}">
            <div class="header_top bar-nav">
                <a  class="back-link-icon" href="javascript:;" data-rel="back"></a>
                <h1 class="page-title-bar">套餐说明</h1>
            </div>
            <div class="page-content" style="background: white">
                <div class="set-meal-box">
                    <p class="tit">{$suit['suitname']}</p>
                    <p class="des">{Product::strip_style($suit['description'])}</p>
                    <div class="pay">
                        <h3>支付方式</h3>
                        <p>{if $suit['paytype']==1}全款支付{elseif $suit['paytype']==2}定金支付，定金{Currency_Tool::symbol()}{$suit['dingjin']}{elseif $suit['paytype']==3}二次确认支付{/if}</p>
                    </div>
                </div>
            </div>
        </div>
    {/loop}
  
<script>
    var pinyin="{$pinyin}";
    var id="{$info['id']}";
    var CURRENCY_SYMBOL="{Currency_Tool::symbol()}";

    $(function(){

        //详情页滚动图
        var mySwiper = new Swiper('.st-photo-container', {
            autoplay: 5000,
            pagination : '.swiper-pagination',
            lazyLoading : true,
            observer: true,
            observeParents: true
        });

        $('.pl').click(function(){
            var url = SITEURL+"pub/comment/id/{$info['id']}/typeid/{$typeid}";
            window.location.href = url;
        })
        //预订按钮
        $('.order').click(function(){
            // var suitid = $(this).attr('data-suitid');
            var suitid = $("#suits_con .active").attr('data-suitid');
            url = SITEURL+pinyin+'/book/id/'+id+'?suitid='+suitid;
            window.location.href = url;
        })

        $(".opt_type").click(function(){
            url = SITEURL+pinyin+'/book/id/'+id;
            window.location.href = url;
        });
        //发表评论
        $('.pl').click(function(){
            var url = SITEURL+"pub/comment/id/{$info['id']}/typeid/{$typeid}";
            window.location.href = url;
        })
        //问答页面
        $('.question').click(function(){
            var url = SITEURL+"question/product_question_list?articleid={$info['id']}&typeid={$typeid}";
            window.location.href = url;
        })
        // 活动套餐
        $("#suits_con li").click(function(){
                $(this).addClass('active');
                $(this).siblings().removeClass('active');
                var suitid = $(this).attr('data-suitid');

                var price = $(this).attr('data-price');
                // alert(CURRENCY_SYMBOL);return false;
                var price_str='';
                if(price > 0) {
                    price_str = '<span class="jg">' + CURRENCY_SYMBOL + '<strong class="num">' + price + '</strong>起</span>';
                }
                else
                {
                    price_str='<span class="jg dx">电询</span>';
                }

                var childdesc = $.trim($(this).find('.childdesc').html());
                $("#child_desc").html(childdesc);

                if(!childdesc || childdesc.length==0)
                {
                    $("#child_desc_con").hide();
                }
                else
                {
                    $("#child_desc_con").show();
                }
                $("#colorbook").removeClass('suitdisable');
                $("#price_txt").html(price_str);
                $("#book_5").show().siblings('.book-status').hide();
                // alert(suitid);return false;
                // get_suit_date(suitid);
            });
        
    });

</script>
</body>
</html>
