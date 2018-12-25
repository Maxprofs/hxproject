<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$webname}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    {Common::css('swiper.min.css,mobilebone.css,base.css,header.css,footer.css')}
    {Common::css_plugin('spot.css','spot')}
    {Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,delayLoading.min.js,mobilebone.js,Zepto.js,layer2.0/layer.js')}
    {Common::js_plugin('spot.js','spot')}
</head>
<style>
    #share_btn{
        color: #666!important;
        background-color: transparent!important;
        display: block;
        width: 33.333333%;
        height: 1.28rem;
        line-height: 1.28rem;
        position: relative;
        text-align: center;
        -webkit-box-flex: 1;
        font-size: 0.32rem;
    }
</style>
<body>
<div class="page out" id="pageHome">
    {request "pub/header_new/typeid/$typeid/isshowpage/1"}
    <!-- 公用顶部 -->
    <div class="page-content spot-content" id="productScrollFixed">
        <div class="swiper-container st-photo-container" >
            <ul class="swiper-wrapper">
                {if $info['piclist']}
                {loop $info['piclist'] $pic}
                <li class="swiper-slide">
                    <a class="item" href="javascript:;"><img class="swiper-lazy" data-src="{Common::img($pic[0],750,375)}" /></a>
                    <div class="swiper-lazy-preloader"></div>
                </li>
                {/loop}
                {else}
                <li class="swiper-slide">
                    <a class="item" href="javascript:;"><img class="swiper-lazy" data-src="{$GLOBALS['cfg_df_img']}" /></a>
                    <div class="swiper-lazy-preloader"></div>
                </li>
                {/if}
            </ul>
            <div class="swiper-pagination"></div>
            <div class="swiper-info"><span id="slideCurrentIndex"></span>/<span id="slideAllCount"></span></div>
        </div>
        <!-- 轮播图 -->

        <div class="product-tip-wrapper">
            <h1 class="product-title-bar">{$info['title']}</h1>
            <div class="product-ads-bar">
                {if Plugin_Productmap::_is_installed()&&!empty($info['lat'])&&!empty($info['lng'])&&!empty($info['address'])}
                <i class="ads-icon"></i>
                <a href="//{$GLOBALS['main_host']}/plugins/productmap/spot/map?id={$info['id']}" data-ajax='false'>
                    <span class="ads-msg">{$info['address']}</span>
                    <i class="ads-link"></i>
                </a>
                {else}
                {if !empty($info['address'])}
                <i class="ads-icon"></i>
                <span class="ads-msg">{$info['address']}</span>
                {/if}
                {/if}
            </div>
            <div class="product-info-bar">
                <a href="{$cmsurl}pub/comment/id/{$info['id']}/typeid/{$typeid}" data-ajax=false class="item">
                    <span class="name">{if $info['satisfyscore']>100}100{else}{$info['satisfyscore']}{/if}%满意度</span>
                    <span class="sub">共有{$info['commentnum']}条评论</span>
                </a>
                {php}$extends_title=Model_Spot::get_spot_extend_content($info['id'],2);{/php}
                {if $extends_title}
                <a href="#spotShowInfo" class="item">
                    <span class="name">景区介绍</span>
                    <span class="sub">
                        {loop $extends_title $k $extend_title}
                        {$extend_title['title']}{if $k<1}、{/if}
                        {/loop}
                    </span>
                </a>
                {/if}
            </div>
            <!--优惠券-->
            {if St_Functions::is_normal_app_install('coupon')}
                {php}$coupon=Model_Coupon::get_mobile_coupon_info($typeid,$info['id']);{/php}
                {if $coupon['totalnum']>0}
                <div class="product-coupon-bar">
                    <i class="coupon-icon"></i>
                    <div class="coupon-type">
                        {loop $coupon['price'] $coupon_price}
                        <span class="item">{$coupon_price}优惠券</span>
                        {/loop}
                    </div>
                    <span class="more-item">{$coupon['totalnum']}张可领取</span>
                </div>
                {/if}
                <script>
                    $(function(){
                        $('.product-coupon-bar .more-item').click(function(){
                            var typeid='{$typeid}';
                            var proid="{$info['id']}";
                            var url = SITEURL + 'coupon-0-'+typeid+'-'+proid;
                            window.location.href=url;
                        })
                    });
                </script>
            {/if}
            {if !empty($info['jifenbook_id'])||!empty($info['jifentprice_id'])}
            <div class="product-itg-bar">
                <i class="itg-icon"></i>
                <span class="item">获赠积分</span>
                <span class="item">积分抵扣</span>
                <i class="more-item"></i>
            </div>
            {/if}
        </div>
        <!-- 顶部信息 -->

        <div class="product-type-wrapper" id="productTypeWrapper">
            {st:spot action="suit_type" row="8" productid="$info['id']" return="typelist"}
            {loop $typelist $type}
            <div class="product-type-block retract">
                <div class="type-bar">
                    <span class="title">{$type['title']}</span>
                    <i class="icon"></i>
                </div>
                <ul class="product-type-group">
                    {st:spot action="suit_by_type" row="10" productid="$info['id']" suittypeid="$type['id']" return="suitlist"}
                    {loop $suitlist $suit}
                    <li class="type-item">
                        <div class="product-type-info" data-id="{$suit['id']}">
                            <div class="tit">{$suit['title']}</div>
                            <div class="set">
                                <!--退款条件-->
                                {if $suit['refund_restriction']==0}
                                <span class="label">无条件退</span>
                                {elseif $suit['refund_restriction']==1}
                                <span class="label">不可退改</span>
                                {elseif $suit['refund_restriction']==2}
                                <span class="label">有条件退</span>
                                {/if}
                                <!--支付方式-->
                                {if $suit['pay_way']==1}
                                <span class="label">线上支付</span>
                                {elseif $suit['pay_way']==2}
                                <span class="label">线下支付</span>
                                {elseif $suit['pay_way']==3}
                                <span class="label">线上支付</span>
                                <span class="label">线下支付</span>
                                {/if}
                            </div>
                            <div class="explain">
                                {if !empty($suit['day_before_des_mobile'])}
                                <span class="txt">{$suit['day_before_des_mobile']}</span>
                                {else}
                                <span>当天24:00前预定</span>
                                {/if}
                                <span class="txt">门票说明<i class="icon"></i></span>
                            </div>
                        </div>
                        <div class="product-type-booking">
                            {if $suit['price_status']==1}
                            {if $suit['ourprice']}<span class="price">{Currency_Tool::symbol()}<span class="num">{$suit['ourprice']}</span>起</span>{/if}
                            {if !empty($suit['ourprice'])}
                            <a class="spot-yd" href="{$cmsurl}spot/book/id/{$info['id']}?suitid={$suit['id']}" data-ajax="false"><span class="buy">预订</span></a>
                            {else}
                            <span class="buy grey">电询</span>
                            {/if}
                            {elseif $suit['price_status']==3}
                            <span class="buy grey">电询</span>
                            {elseif $suit['price_status']==2}
                            <span class="buy grey">订完</span>
                            {/if}
                        </div>
                    </li>
                    {/loop}
                </ul>
            </div>
            {/loop}
        </div>
        <!-- 门票分类 -->
        {if Model_Comment::get_comment_num($info['id'],$typeid)>0}
        <div class="rele-module-block">
            <div class="rele-hd-bar">
                <span class="title">游客点评</span>
                <span class="secondary">
                    <span class="item">{if $info['satisfyscore']>100}100{else}{$info['satisfyscore']}{/if}%满意度</span>
                    <span class="item">{$info['commentnum']}条评论</span>
                </span>
            </div>
            <div class="rele-module-area">
                {php}$comment_list=Model_Comment::search_result($typeid, $info['id'],'well',1,1);{/php}
                {php}if($comment_list['total']==0){$comment_list=Model_Comment::search_result($typeid, $info['id'],'mid',1,1);};{/php}
                {php}if($comment_list['total']==0){$comment_list=Model_Comment::search_result($typeid, $info['id'],'bad',1,1);};{/php}
                <ul class="comment-list-group">
                    {loop $comment_list['list'] $comment}
                    <li>
                        <div class="info-hd">
                            <img src="{$comment['litpic']}" alt="{$comment['nickname']}" class="hd-img" />
                            <div class="user">
                                <span class="name">{$comment['nickname']}</span>
                                <span class="date">{$comment['add_time']}</span>
                            </div>
                            <div class="comment-grade-bar">
                                {php}$rank=array();for($i=0; $i<$comment['rank'];$i++){$rank[$i]=$i;};{/php}
                                {loop $rank $level}
                                <span class="icon {if $level<$comment['rank']}on{/if}"></span>
                                {/loop}
                            </div>
                        </div>
                        <div class="info-bd">
                            {$comment['content']}
                        </div>
                    </li>
                    {/loop}
                </ul>
                <div class="more-bar-link">
                    <a href="javascript:;" class="more-btn pl">查看全部点评</a>
                </div>
            </div>
        </div>
        <!-- 评论模块 -->
        {/if}

        <div class="rele-module-block">
            <div class="rele-hd-bar">
                <span class="title">游客问答</span>
                <span class="secondary">
                    <span class="item">{Model_Question::get_question_num($typeid,$info['id'])}条问答</span>
                </span>
            </div>
            <div class="rele-module-area">
                {if Model_Question::get_question_num($typeid,$info['id'])>0}
                {php}$question_list=Model_Question::search_result(1,1,0,$typeid,$info['id']);{/php}
                <ul class="faq-list-group">
                    {loop $question_list['list'] $question}
                    <li class="item"><i class="icon">问</i>{$question['content']}</li>
                    {/loop}
                </ul>
                <div class="more-bar-link">
                    <a href="javascript:;" class="more-btn question">查看全部问答</a>
                </div>
                {else}
                <div class="rele-module-area">
                    <div class="module-empty-content">
                        <span class="txt">本产品暂无问答内容！</span>
                        <a href="javascript:;" class="link question_add">去提问</a>
                    </div>
                </div>
                {/if}
            </div>
        </div>
        <!-- 问答模块 -->

        {st:spot action="get_tagword_spot" tagword="$info['tagword']" spotid="$info['id']" row="5" return="recommends"}
        {if count($recommends)>0}
        <div class="rele-module-block">
            <div class="rele-hd-bar">
                <span class="title">相关推荐</span>
            </div>
            <div class="rele-module-area">
                <ul class="product-list-group">
                    {loop $recommends $rec}
                    <li>
                        <a class="item" href="{$rec['url']}" data-ajax="false">
                            <div class="pro-pic"><span><img src="{$defaultimg}" st-src="{Common::img($rec['litpic'])}" alt="{$rec['title']}" title="{$rec['title']}" /></span></div>
                            <div class="pro-info">
                                <h3 class="tit">{$rec['title']}</h3>
                                {if count($rec['iconlist'])>0}
                                <div class="attr">
                                    {if $GLOBALS['cfg_icon_rule']==1}
                                    {loop $rec['iconlist'] $icon}
                                    <span class="sx">{$icon['kind']}</span>
                                    {/loop}
                                    {else}
                                    {loop $rec['iconlist'] $ico}
                                    <img style="margin-right:0.1rem;" src="{$ico['litpic']}"/>
                                    {/loop}
                                    {/if}
                                </div>
                                {/if}
                                <div class="data">
                                    <span>{Model_Comment::get_comment_num($rec['id'],$typeid)}条点评</span>
                                    <span>{php echo rtrim($rec['satisfyscore'], '%') . '%';}满意</span>
                                </div>
                                {if !empty($rec['address'])}
                                <div class="addr">{$rec['address']}</div>
                                {/if}
                            </div>
                            <div class="pro-price">
                                {if $rec['price']}
                                <span class="price">
                                    <em>{Currency_Tool::symbol()}<strong>{$rec['price']}</strong>起</em>
                                </span>
                                {else}
                                <span class="price"><b class="no-style">电询</b></span>
                                {/if}
                            </div>
                        </a>
                    </li>
                    {/loop}
                </ul>
            </div>
        </div>
        <!-- 推荐相关 -->
        {/if}

        <div class="no-info-bar">亲，拉到最底啦~</div>
        {request "pub/code"}
        <div class="fixed-container-area">
            <div class="fixed-container-bar bom_fixed">
                <a href="tel:{$GLOBALS['cfg_m_phone']}" class="item kf" data-ajax="false" ><i class="icon"></i>电话客服</a>
                {if $info['hasticket']}
                <a href="javascript:;" class="item xz" id="chooseTicketType">选择票型</a>
                {/if}
            </div>
        </div>
    </div>
</div>
{php}$extends=Model_Spot::get_spot_extend_content($info['id']);{/php}
{if $extends}
<div class="page out" id="spotShowInfo">
    <div class="header_top">
        <a class="back-link-icon" href="#pageHome" data-rel="back"></a>
        <h1 class="page-title-bar">景区介绍</h1>
    </div>
    <!-- 公用顶部 -->
    <div class="page-content">
        {loop $extends $extend}
            {if !empty($extend['content'])}
            <div class="spot-js-wrapper">
                <h4 class="tit-bar">{$extend['title']}</h4>
                <div class="spot-js-content editor-content clearfix">
                    {Common::content_image_width($extend['content'],540,0)}
                </div>
            </div>
            {/if}
        {/loop}
        <div class="no-info-bar">亲，拉到最底啦~</div>
    </div>
</div>
<!-- 景区介绍 -->
{/if}

{st:spot action="suit_type" row="8" productid="$info['id']" return="typelist"}
{loop $typelist $type}
{st:spot action="suit_by_type" row="10" productid="$info['id']" suittypeid="$type['id']" return="suitlist"}
{loop $suitlist $suit}
<div id="ticketInfo_{$suit['id']}" class="hide">
    <div class="product-show-info">
        <div class="info-show-bar">门票说明<i class="close-icon" id="closeTicketLayer_{$suit['id']}"></i></div>
        <div class="info-show-area">
            <div class="info-primary-hd">
                <h4 class="tit">{$suit['title']}</h4>
                <div class="attr">
                    <!--退款条件-->
                    {if $suit['refund_restriction']==0}
                    <span class="item">无条件退</span>
                    {elseif $suit['refund_restriction']==1}
                    <span class="item">不可退改</span>
                    {elseif $suit['refund_restriction']==2}
                    <span class="item">有条件退</span>
                    {/if}
                    <!--支付方式-->
                    {if $suit['pay_way']==1}
                    <span class="item">线上支付</span>
                    {elseif $suit['pay_way']==2}
                    <span class="item">线下支付</span>
                    {elseif $suit['pay_way']==3}
                    <span class="item">线上支付</span>
                    <span class="item">线下支付</span>
                    {/if}
                </div>
            </div>
            <div class="info-other-bd">
                <h4 class="tit">预定时间</h4>
                <div class="txt">
                    {if !empty($suit['day_before_des_mobile'])}
                    {$suit['day_before_des_mobile']}
                    {else}当天24:00前可预定{/if}
                </div>
            </div>
            <div class="info-other-bd">
                <h4 class="tit">有效期</h4>
                <div class="txt">
                    {if !empty($suit['effective_days'])}
                    {$suit['effective_before_days_des']}
                    {else}验票当天24:00前{/if}
                </div>
            </div>
            {if !empty($suit['get_ticket_way'])}
            <div class="info-other-bd">
                <h4 class="tit">取票说明</h4>
                <div class="txt">{$suit['get_ticket_way']}</div>
            </div>
            {/if}
            {if !empty($suit['suppliername'])}
            <div class="info-other-bd">
                <h4 class="tit">供应商</h4>
                <div class="txt editor-content clearfix">
                    {$suit['suppliername']}
                </div>
            </div>
            {/if}
            {if !empty($suit['description'])}
            <div class="info-other-bd">
                <h4 class="tit">门票说明</h4>
                <div class="txt editor-content clearfix">
                    {Common::content_image_width($suit['description'],540,0)}
                </div>
            </div>
            {/if}
        </div>
        <div class="product-booking-bar">
            <span class="total">{if !empty($suit['ourprice'])}{Currency_Tool::symbol()}<span class="num">{$suit['ourprice']}</span>起{else}电询{/if}</span>
            {if $suit['price_status']==1}
                {if !empty($suit['ourprice'])}
                <a class="btn" href="{$cmsurl}spot/book/id/{$info['id']}?suitid={$suit['id']}" data-ajax="false">立即预订</a>
                {else}
                <a class="btn" style="color: #fff;background-color: #999;cursor: default;" href="javascript:;">立即预订</a>
                {/if}
            {else}
            <a class="btn" style="color: #fff;background-color: #999;cursor: default;" href="javascript:;">立即预订</a>
            {/if}
        </div>
    </div>
</div>
{/loop}
{/loop}
<!-- 门票说明详情 -->

{if (!empty($jifenbook_info)&&$jifenbook_info['value']>0)||(!empty($jifentprice_info)&&$jifentprice_info['jifentprice']>0)||(!empty($jifencomment_info)&&$jifencomment_info['value']>0)}
<div id="integralInfo" class="hide">
    <div class="product-show-info">
        <div class="info-show-bar">积分优惠<i class="close-icon" id="closeTicketLayer_jifen"></i></div>
        <div class="info-show-area full">
            {if !empty($jifentprice_info)&&$jifentprice_info['jifentprice']>0}
            <div class="info-integral-block">
                <h4 class="tit">积分抵现</h4>
                <ul class="info-list">
                    <li>购买该产品可使用积分抵现<span class="dk">（{$jifentprice_info['toplimit']}积分抵{Currency_Tool::symbol()}{$jifentprice_info['jifentprice']}）</span></li>
                </ul>
            </div>
            {/if}
            {if (!empty($jifenbook_info)&&$jifenbook_info['value']>0)||(!empty($jifencomment_info)&&$jifencomment_info['value']>0)}
            <div class="info-integral-block">
                <h4 class="tit">赠送积分</h4>
                <ul class="info-list">
                    {if !empty($jifenbook_info)&&$jifenbook_info['value']>0}
                    <li>购买该产品可获得{if $jifenbook_info['rewardway']==1}订单总额{$jifenbook_info['value']}%的{else}{$jifenbook_info['value']}{/if}积分</li>
                    {/if}
                    {if !empty($jifencomment_info)&&$jifencomment_info['value']>0}
                    <li>评论该产品可获得{if $jifencomment_info['rewardway']==1}订单总额{$jifencomment_info['value']}%的{else}{$jifencomment_info['value']}{/if}积分</li>
                    {/if}
                </ul>
            </div>
            {/if}

        </div>
    </div>
</div>
{/if}
<!-- 积分抵扣优惠 -->
<script>
    $(function(){
        //顶部菜单监听,分销按钮事件特殊处理
        var callback=false;
        $(".bom_fixed").bind("DOMNodeInserted",function(e){
            if($("#share_btn").length>0&&callback==false){
                //移除dom
                callback=true;
                $("#share_btn").removeAttr('style').addClass('item').addClass('fx').html('<i class="icon"></i>我要分销');
            }
        });

        $("#pageHome .header_top a.back-link-icon").attr({'data-ajax':'false','href':'{$cmsurl}spots'}).removeAttr("onclick");

        $('.pl').click(function(){
            var url = SITEURL+"pub/comment/id/{$info['id']}/typeid/{$typeid}";
            window.location.href = url;
        });

        //问答页面
        $('.question').click(function(){
            var url = SITEURL+"question/product_question_list?articleid={$info['id']}&typeid={$typeid}";
            window.location.href = url;
        });
        //提问页面
        $('.question_add').click(function(){
            var url = SITEURL+"question/product_question_write?articleid={$info['id']}&typeid={$typeid}";
            window.location.href = url;
        });
    })
</script>
</body>
</html>
