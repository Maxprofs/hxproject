<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head div_head=LZzCXC >
<meta charset="utf-8">
<head>
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    {include "pub/varname"}
    {Common::css_plugin('visa.css','visa')}
    {Common::css('base.css,extend.css',false)}
    {Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,slideTabs.js,delayLoading.min.js')}
</head>
<script>
	$(function(){
			$('.crowd-tabbox').switchTab();
            if($('#attachment').length>0){
                $('#download_arr').removeClass('hide');
            }
	})
</script>
<body>

{request "pub/header"}
{if St_Functions::is_normal_app_install('coupon')}
{request 'coupon/float_box-'.$typeid.'-'.$info['id']}
{/if}
<div class="big">
    <div class="wm-1200">

        <div class="st-guide">
            <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&gt;
            <a href="/visa/">{$channelname}</a>&gt;
            {$info['title']}
        </div><!--面包屑-->
        <div class="st-main-page">

            <div class="visa_show_top">
                <div class="pic"><a href="javascript:;"><img src="{Common::img($info['litpic'],450,306)}" alt="{$info['title']}" /></a></div>
                <div class="txt_con">
                    <h1>{$info['title']}
                        {loop $info['iconlist'] $icon}
                        <img src="{$icon['litpic']}" />
                        {/loop}</h1>
                    <ul>
                    	<li class="li_c">
                        <span>销量：{$info['sellnum']}</span>
                        <span>|</span>
                        <span>满意度：{if $info['satisfyscore']}{$info['satisfyscore']}{else}100{/if}%</span>
                        <span>|</span>
                        <a href="#comment_target">{$info['commentnum']}条点评</a>
                        </li>
                        <li class="li_c"><em>办理时长：</em>{$info['handleday']}</li>
                        <li class="li_d"><em>签证类型：</em>{$info['visatype']}</li>
                        <li class="li_d"><em>所属领区：</em>{$info['belongconsulate']}</li>
                        <li class="li_d"><em>停留时间：</em>{$info['partday']}</li>
                        <li class="li_d"><em>有效日期：</em>{$info['validday']}</li>
                        <li class="li_d"><em>面试需要：</em>{$info['interview']}</li>
                        <li class="li_d"><em>邀 请 函：</em>{$info['letter']}</li>{php}$download=1;{/php}
                        <li class="li_c"><em>受理范围：</em>{$info['handlerange']}</li>
                        {if !empty($info['attachment'])}
                        <li class="li_c hide" id="download_arr"><a class="download-btn" href="#download">下载资料</a></li>
                        {/if}
                    </ul>
                    {if !empty($info['jifentprice_info']) || !empty($info['jifenbook_info']) || !empty($info['jifencomment_info'])}
                    <div class="msg-ul clearfix">
                        <em class="item-hd">积分优惠：</em>
                        <div class="item-bd">
                            {if !empty($info['jifentprice_info'])}
                            <div class="jf-type-wrap">
                                <span class="di num">{Currency_Tool::symbol()}{$info['jifentprice_info']['jifentprice']}<i></i></span>
                                <div class="info">
                                    <strong class="tit">积分抵现金</strong>
                                    <p class="txt">预订产品可使用积分抵现金，最高可抵{Currency_Tool::symbol()}{$info['jifentprice_info']['jifentprice']}。</p>
                                </div>
                            </div>
                            {/if}
                            {if !empty($info['jifenbook_info'])}
                            <div class="jf-type-wrap">
                                <span class="ding num">{$info['jifenbook_info']['value']}{if $info['jifenbook_info']['rewardway']==1}%{else}分{/if}<i></i></span>
                                <div class="info">
                                    <strong class="tit">预订送积分</strong>
                                    <p class="txt">预订并消费产品可活动积分赠送，可获得{if $info['jifenbook_info']['rewardway']==1}订单总额{$info['jifenbook_info']['value']}%的{else}{$info['jifenbook_info']['value']}{/if}积分。</p>
                                </div>
                            </div>
                            {/if}
                            {if !empty($info['jifencomment_info'])}
                            <div class="jf-type-wrap">
                                <span class="ping num">{$info['jifencomment_info']['value']}分<i></i></span>
                                <div class="info">
                                    <strong class="tit">评论送积分</strong>
                                    <p class="txt">预订并消费产品后，评论产品通过审核可获得{$info['jifencomment_info']['value']}积分</p>
                                </div>
                            </div>
                            {/if}
                        </div>
                    </div>
                    {/if}
                    <p class="md-js">{$info['sellpoint']}</p>
                </div>
                <div class="show_msg">
                    <p class="price">优惠价：<span>{if !empty($info['price'])}<i class="currency_sy">{Currency_Tool::symbol()}</i><b>{$info['price']}</b>{else}电询{/if}</span></p>
                    <p class="date"><input type="text" id="usedate" placeholder="请选择出行时间" /></p>
                    <p class="lx"><span>{$info['visatype']}<s></s></span></p>
                    <p class="num">
                        <em>预定数量：</em>
                        <span class="sub"></span>
                        <input type="text" id="dingnum" value="1" />
                        <span class="add"></span>
                    </p>
                    <p class="price">总价：<span><i class="currency_sy">{Currency_Tool::symbol()}</i><b class="totalprice">{$info['price']}</b></span></p>
                    <p class="now_btn"><a href="javascript:;">立即预定</a></p>
                </div>
            </div><!--顶部介绍-->

            <div class="st-visa-show">
                <div class="visashow-con">
                    <div class="tabnav-list">
                        {st:detailcontent action="get_content" pc="1" typeid="$typeid" productinfo="$info" return="visacontent"}
                        {loop $visacontent $row}
                        {if $row['columnname']=='attachment' && empty($info['attachment'])}
                           {else}
                            <span>{$row['chinesename']}</span>
                        {/if}

                        {/loop}
                        {/st}

                        <span>客户评价</span>
                        <span>我要咨询</span>
                        <a class="yd-btn" style="display: none"  href="javascript:;">开始预订</a>
                    </div><!--签证导航-->
                    <div class="tabbox-list">
                        {loop $visacontent $v}
                        {if $v['columnname']=='material'}
                        <div class="tabcon-list">
                            <div class="list-tit"><strong>{$v['chinesename']}</strong></div>
                            <div class="crowd-tabbox">
                                <div class="st-tabnav">
                                    {php $in = 1;}
                                    {loop $materials $ma}
                                    {if $ma['content']}
                                    <span class="{if $in==1}on{/if}">{$ma['title']}</span>
                                    {/if}
                                    {php $in++;}
                                    {/loop}
                                </div>
                                {php $ind = 1;}
                                {loop $materials $ma}
                                {if $ma['content']}
                                <div class="st-tabcon" style="display: {if $ind==1}block{else}none{/if};">
                                    {$ma['content']}
                                </div>
                                {/if}
                                {php $ind++;}
                                {/loop}
                            </div>
                            <div class="list-txt">

                            </div>
                        </div>
                        {elseif $v['columnname']=='attachment'}
                          {if !empty($info['attachment'])}
                        <a name="download"></a>
                        <div class="tabcon-list">
                            <div class="list-tit"><strong>{$v['chinesename']}</strong></div>
                            <div class="list-txt">
                                <ol class="attachment" id="attachment">
                                {loop $info['attachment']['path'] $k $v}
                                <li><a href="/pub/download/?file={$v}&name={$info['attachment']['name'][$k]}" title="{$info['attachment']['name'][$k]} 下载" class="name">{$info['attachment']['name'][$k]}</a></li>
                                {/loop}
                                </ol>
                            </div>
                           </div>
                          {/if}
                        {else}
                        <div class="tabcon-list">
                            <div class="list-tit"><strong>{$v['chinesename']}</strong></div>
                            <div class="list-txt">
                                {Common::content_image_width($v['content'],833,0)}
                            </div>
                        </div>
                        {/if}
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

{request "pub/footer"}
{request "pub/flink"}
{Common::js('floatmenu/floatmenu.js')}
{Common::css('/res/js/floatmenu/floatmenu.css',0,0)}
{Common::js('datepicker/WdatePicker.js',0)}
<input type="hidden" id="price" value="{$info['price']}">
<input type="hidden" id="productid" value="{$info['id']}"/>
<script>
    $(function(){


        //积分
        $(".jf-type-wrap").hover(function(){
            $(this).children(".info").show()
        },function(){
            $(this).children(".info").hide()
        });

        //滚动显示预订按钮
        var topHeight = $('.tabnav-list').offset().top;
        $(window).scroll(function(){
            if($(document).scrollTop() >= topHeight){
                $(".yd-btn").show()
            }else{
                $(".yd-btn").hide();
            }
        });
        $(".yd-btn").click(function(){
            $(".now_btn").trigger('click');
        });


        //预订
        $(".now_btn").click(function(){
            if(!is_login_order()){
                return false;
            }
            var productId = $("#productid").val();
            var useDate = $("#usedate").val();
            var dingNum = Number($("#dingnum").val());
            var url = SITEURL+'visa/book?usedate='+useDate+"&productid="+productId+"&dingnum="+dingNum;
            window.location.href = url;

        })

        //内容切换
        $.floatMenu({
            menuContain : '.tabnav-list',
            tabItem : 'span',
            chooseClass : 'on',
            contentContain : '.tabbox-list',
            itemClass : '.tabcon-list'
        });
        $("#usedate").focus(function(){

            WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d',doubleCalendar:false,isShowClear:false,readOnly:true,errDealMode:1})

        })
        //减少数量
        $(".sub").click(function(){
            var dingnum = Number($("#dingnum").val());
            if(dingnum>1){
                dingnum--;
                $("#dingnum").val(dingnum);
            }
            get_total_price();
        })
        //增加数量
        $(".add").click(function(){
            var dingnum = Number($("#dingnum").val());
            dingnum++;
            $("#dingnum").val(dingnum);
            get_total_price();
        })
    })
    //获取总价
    function get_total_price()
    {
        var price = Number($("#price").val());
        var dingnum = Number($("#dingnum").val());
        var total = price * dingnum;
        $('.totalprice').html(total);
    }
</script>
{include "member/login_order"}
</body>
</html>
