<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head body_html=pLACXC >
<meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    {include "pub/varname"}
    {Common::css('base.css,extend.css')}
    {Common::css_plugin('scenic.css','spot')}

    {Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js')}
</head>

<body>
{request "pub/header"}
{if St_Functions::is_normal_app_install('coupon')}
{request 'coupon/float_box-'.$typeid.'-'.$info['id']}
{/if}

  <div class="big">
  	<div class="wm-1200">

    <div class="st-guide">
        {st:position action="show_crumbs" typeid="$typeid" info="$info"}
    </div><!--面包屑-->
      
      <div class="st-main-page">
      	<div class="st-scenic-show">
            <div class="scenicshow-tw">
                <div class="focus-slide">
                    <div class="imgnav" id="imgnav">
                        <div id="img">
                            {loop $info['piclist'] $pic}
                            <img src="{Common::img($pic[0],460,312)}"/>
                            {/loop}
                            <div id="front" title="上一张"><a href="javaScript:void(0)" class="pngFix"></a></div>
                            <div id="next" title="下一张"><a href="javaScript:void(0)" class="pngFix"></a></div>
                        </div>
                        <div id="cbtn">
                            <i class="picSildeLeft"><img src="{$GLOBALS['cfg_public_url']}images/picSlideLeft.gif"/></i>
                            <i class="picSildeRight"><img src="{$GLOBALS['cfg_public_url']}images/picSlideRight.gif"/></i>
                            <div id="cSlideUl">
                                <ul>
                                    {loop $info['piclist'] $pic}
                                    <li><img src="{Common::img($pic[0],90,61)}"/></li>
                                    {/loop}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="default-bdshare" class="bdsharebuttonbox">
                        <a href="#" class="bds_more" data-cmd="more">分享</a>
                    </div>
                </div>
                <div class="cp-show-msg">
                    <div class="hs-title">
                        <h1>{$info['title']}</h1>
                        <div class="attr">
                            {if $GLOBALS['cfg_icon_rule']==1}
                            {loop $info['iconlist'] $icon}
                            <span class="attr-item">{$icon['kind']}</span>
                            {/loop}
                            {else}
                            {loop $info['iconlist'] $ico}
                            <img src="{$ico['litpic']}"/>
                            {/loop}
                            {/if}
                        </div>
                    </div>
                    <div class="price-box">
                        <div class="price clearfix">
                            {if !empty($info['price'])}
                            <span><i class="currency_sy">{Currency_Tool::symbol()}</i><b>{$info['price']}</b>起</span>
                            {else}
                            <span><b>电询</b></span>
                            {/if}
                        </div>
                    </div>
                    <div class="sl">
                        <span>销量：{$info['sellnum']}</span><s>|</s><span class="myd">满意度：{$info['satisfyscore']}</span><s>|</s><a href="#comment_target">{$info['commentnum']}条点评</a>
                    </div>
                    {if (!empty($info['jifentprice_info'])&&$info['jifentprice_info']['jifentprice']>0) || (!empty($info['jifenbook_info'])&&$info['jifenbook_info']['value']>0) ||(!empty($info['jifencomment_info'])&&$info['jifencomment_info']['value']>0)}
                    <div class="msg-ul">
                        {if !empty($info['jifentprice_info'])&&$info['jifentprice_info']['jifentprice']>0}
                        <div class="jf-type-wrap">
                            <span class="di num">{$info['jifentprice_info']['toplimit']}分<i></i></span>
                            <div class="info">
                                <strong class="tit">积分抵现金</strong>
                                <p class="txt">预订产品可使用积分抵现金，最高可抵{Currency_Tool::symbol()}{$info['jifentprice_info']['jifentprice']}。</p>
                            </div>
                        </div>
                        {/if}
                        {if !empty($info['jifenbook_info'])&&$info['jifenbook_info']['value']>0}
                        <div class="jf-type-wrap">
                            <span class="ding num">{if $info['jifenbook_info']['rewardway']==1}订单总额{$info['jifenbook_info']['value']}%的{else}{$info['jifenbook_info']['value']}{/if}<i></i></span>
                            <div class="info">
                                <strong class="tit">预订送积分</strong>
                                <p class="txt">预订并消费产品可获得积分赠送，可获得{if $info['jifenbook_info']['rewardway']==1}订单总额{$info['jifenbook_info']['value']}%的{else}{$info['jifenbook_info']['value']}{/if}积分。</p>
                            </div>
                        </div>
                        {/if}
                        {if !empty($info['jifencomment_info'])&&$info['jifencomment_info']['value']>0}
                        <div class="jf-type-wrap">
                            <span class="ping num">{$info['jifencomment_info']['value']}分<i></i></span>
                            <div class="info">
                                <strong class="tit">评论送积分</strong>
                                <p class="txt">预订并消费产品后，评论产品通过审核可获得{if $info['jifencomment_info']['rewardway']==1}订单总额{$info['jifencomment_info']['value']}%的{else}{$info['jifencomment_info']['value']}{/if}积分</p>
                            </div>
                        </div>
                        {/if}
                    </div>
                    {/if}
                    {if !empty($info['sellpoint'])}
                    <div class="sell-point">{$info['sellpoint']}</div>
                    {/if}
                    {if !empty($info['open_time_des'])}
                    <dl class="time">
                        <dt>开放时间：</dt>
                        <dd>{$info['open_time_des']}</dd>
                    </dl>
                    {/if}
                    {if !empty($info['address'])}
                    <dl class="time">
                        <dt>景点地址：</dt>
                        <dd>{$info['address']}</dd>
                    </dl>
                    {/if}
                </div>
            </div>
            <div class="scenicshow-con">
                <div class="tabnav-list">
                    {if $info['hasticket']}
                    <span class="on">门票信息</span>
                    {/if}
                    {st:detailcontent action="get_content" pc="1" typeid="$typeid" productinfo="$info" return="spotcontent"}
                    {loop $spotcontent $row}
                    <span>{$row['chinesename']}</span>
                    {/loop}
                    {/st}
                    <span>客户评价</span>
                    <span>我要咨询</span>
                </div>
                <!--导航-->

                <div class="tabbox-list">
                    {if $info['hasticket']}
                    <div class="tabcon-list">
                        <div class="spot-typetable">
                            <div class="type-label clearfix">
                                <ul>
                                    {st:spot action="suit_list" row="100" productid="$info['id']" return="suitlist"}
                                    {loop $suitlist $suit}
                                    <li>
                                        <div class="ticket-title"><strong class="type-tit">{$suit['title']}-{$suit['tickettype_name']}<i class="arr-ico"></i></strong></div>
                                        <div class="ticket-data clearfix">
                                            <div class="ticket-type">{$type['title']}</div>
                                            <div class="order-time">{if !empty($suit['day_before_des'])}{$suit['day_before_des']}{else}当天24:00前{/if}</div>
                                            <div class="ticket-price">
                                                {if !empty($suit['ourprice'])}
                                                <span class="price"><em>{Currency_Tool::symbol()}<strong>{$suit['ourprice']}</strong></em>起</span>
                                                {else}<span class="price"><strong>电询</strong></span>{/if}
                                                {if $suit['sellprice']}
                                                <span class="ori-price">（<del>{Currency_Tool::symbol()}{$suit['sellprice']} </del>）</span>
                                                {/if}
                                            </div>
                                            <div class="pay-type">
                                                {if $suit['pay_way']==1}线上支付
                                                {elseif $suit['pay_way']==2}线下支付
                                                {elseif $suit['pay_way']==3}线上支付/线下支付
                                                {/if}
                                            </div>
                                            <div class="ticket-order-btn">
                                                {if $suit['price_status']==1}
                                                {if !empty($suit['ourprice'])}
                                                <a class="booking-btn" href="javascript:;" data-suitid="{$suit['id']}">立即预订</a>
                                                {else}
                                                <a class="booking-btn over" href="javascript:;">电询</a>
                                                {/if}
                                                {elseif $suit['price_status']==3}
                                                <a class="booking-btn over" href="javascript:;">电询</a>
                                                {elseif $suit['price_status']==2}
                                                <a class="booking-btn over" href="javascript:;">订完</a>
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="suit-des">
                                            <div class="cartype-nr">
                                                {if $suit['effective_days']}
                                                <div class="cartype-nr-sm">
                                                    <strong class="hd">门票有效期</strong>
                                                    <div class="bd">
                                                        {if !empty($suit['effective_days'])}
                                                        {$suit['effective_before_days_des']}
                                                        {else}验票当天24:00前{/if}</div>
                                                </div>
                                                {/if}
                                                {if !empty($suit['get_ticket_way'])}
                                                <div class="cartype-nr-sm">
                                                    <strong class="hd">取票方式</strong>
                                                    <div class="bd">{$suit['get_ticket_way']}</div>
                                                </div>
                                                {/if}
                                                <div class="cartype-nr-sm">
                                                    <strong class="hd">退改方式</strong>
                                                    <div class="bd">
                                                        {if $suit['refund_restriction']==0}无条件退
                                                        {elseif $suit['refund_restriction']==1}不可退改
                                                        {elseif $suit['refund_restriction']==2}有条件退{/if}
                                                    </div>
                                                </div>
                                                {if !empty($suit['suppliername'])}
                                                <div class="cartype-nr-sm">
                                                    <strong class="hd">供应商</strong>
                                                    <div class="bd">{$suit['suppliername']}</div>
                                                </div>
                                                {/if}
                                                {if !empty($suit['description'])}
                                                <div class="cartype-nr-sm">
                                                    <strong class="hd">门票说明</strong>
                                                    <div class="bd">
                                                        {$suit['description']}
                                                    </div>
                                                </div>
                                                {/if}
                                            </div>
                                        </div>
                                    </li>
                                    {/loop}
                                </ul>
                            </div>
                        </div>
                    </div>
                    {/if}
                    {loop $spotcontent $s}
                    <div class="tabcon-list">
                        <div class="list-tit"><strong>{$s['chinesename']}</strong></div>
                        <div class="list-txt">
                            {Common::content_image_width($s['content'],833,0)}
                        </div>
                    </div>
                    {/loop}
                    {include "pub/comment"}
                    {include "pub/ask"}
                </div>
            </div>
        </div><!--详情主体-->
        <div class="st-sidebox">
            {st:right action="get" typeid="$typeid" data="$templetdata" pagename="show"}
        </div><!--边栏模块-->
      </div>
    
    </div>
  </div>
  <input type="hidden" id="productid" value="{$info['id']}"/>
{request "pub/footer"}
{request "pub/flink"}
{Common::js('floatmenu/floatmenu.js')}
{Common::css('/res/js/floatmenu/floatmenu.css',0,0)}
{Common::js('SuperSlide.min.js,template.js,scorll.img.js')}
<script type="text/javascript">
    $(document).ready(function(){

        //积分
        $(".jf-type-wrap").hover(function(){
            $(this).children(".info").show()
        },function(){
            $(this).children(".info").hide()
        });

        //内容切换
        $.floatMenu({
            menuContain : '.tabnav-list',
            tabItem : 'span',
            chooseClass : 'on',
            contentContain : '.tabbox-list',
            itemClass : '.tabcon-list'
        });
        //套餐点击
        $(".type-tit").click(function(){
            var i_obj = $(this);
            if(i_obj.children().length>0 ){
                if(i_obj.hasClass('active'))
                {
                    i_obj.removeClass('active');
                    i_obj.parents().siblings(".suit-des").hide();
                }
                else
                {
                    i_obj.addClass('active');
                    i_obj.parents().siblings(".suit-des").show();
                }
            }
        });

        //预订
        $(".booking-btn").click(function(){
            var suitid = $(this).attr('data-suitid');
            if(!suitid || !is_login_order()){
                return false;
            }
            var productid = $("#productid").val();
            var url = SITEURL+'spot/book/?suitid='+suitid+"&productid="+productid;
            window.location.href = url;
        })
    });


</script>
{include "member/login_order"}
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='/res/js/bdshare/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
</body>
</html>
