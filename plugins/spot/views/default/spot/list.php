<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head div_body=wLACXC >
<meta charset="utf-8">
    <title>{if $is_all}旅游景点大全_热门景点推荐_景点门票预订-{$GLOBALS['cfg_webname']}{else}{$searchtitle}{/if}</title>
    {$destinfo['keyword']}
    {$destinfo['description']}
    {include "pub/varname"}
    {Common::css('base.css,extend.css')}
    {Common::css_plugin('scenic.css','spot')}
    {Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js')}
</head>
<body>
{request "pub/header"}
<div class="big">
    <div class="wm-1200">
        <div class="st-guide">
        {st:position action="list_crumbs" destid="$destinfo['dest_id']" typeid="$typeid"}
        </div><!--面包屑-->
        <div class="st-main-page">
        <div class="st-sceniclist-box">
            <div class="seo-content-box">
                <h3 class="seo-bar"><span class="seo-title">{if $destinfo['dest_name']}{$destinfo['dest_name']}{$channelname}{else}{$channelname}{/if}</span></h3>
                {if $destinfo['dest_jieshao']}
                <div class="seo-wrapper clearfix">
                    {$destinfo['dest_jieshao']}
                </div>
                {/if}
            </div>
            <!-- 目的地优化设置 -->
            <div class="search-type-block" id="search-content" data-max="{$GLOBALS['cfg_spot_attr_show_num']}">
                {if count($chooseitem)>0}
                <div class="search-type-item clearfix">
                    <strong class="item-hd">已选条件：</strong>
                    <div class="item-bd">
                        <div class="item-check">
                            {loop $chooseitem $item}
                            <a class="chick-child" data-url="{$item['url']}">{$item['itemname']}<i class="closed"></i></a>
                            {/loop}
                            <a href="javascript:;" class="clear-item clearc">清空筛选条件 </a>
                        </div>
                    </div>
                </div>
                {/if}
                <div class="search-type-item clearfix">
                    <strong class="item-hd">目的地：</strong>
                    <div class="item-bd">
                        <div class="item-child">
                            <div class="child-block">
                                <ul class="child-list">
                                    {st:dest action="query" typeid="$typeid" flag="nextsame" row="100" pid="$destid" return="destlist"}
                                    {loop $destlist $dest}
                                    <li class="item"><a href="{$cmsurl}spots/{$dest['pinyin']}/">{$dest['kindname']}</a></li>
                                    {/loop}
                                    {/st}
                                </ul>
                                {if count($destlist)>5}
                                <a class="arrow down" href="javascript:;">展开</a>
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
                {st:attr action="query" flag="grouplist" typeid="$typeid" row="100" return="grouplist"}
                {loop $grouplist $k $group}
                {st:attr action="query" flag="childitem" typeid="$typeid" groupid="$group['id']" return="attrlist"}
                <div class="search-type-item clearfix" {if $k>=$GLOBALS['cfg_spot_attr_show_num']}style="display:none;"{/if}>
                    <strong class="item-hd">{$group['attrname']}：</strong>
                    <div class="item-bd">
                        <div class="item-child">
                            <div class="child-block">
                                <ul class="child-list">
                                    {loop $attrlist $attr}
                                    <li class="item"><a {if Common::check_in_attr($param['attrid'],$attr['id'])!==false}class="active"{/if} href="{Model_Spot::get_search_url($attr['id'],'attrid',$param)}">{$attr['attrname']}</a></li>
                                    {/loop}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {/st}
                {/loop}
                {/st}
                <div class="search-type-item-bak clearfix hide">
                    <strong class="item-hd">价格区间：</strong>
                    <div class="item-bd">
                        <div class="item-child">
                            <div class="child-block">
                                <ul class="child-list">
                                    {st:spot action="price_list" row="20" return="pricelist"}
                                    {loop $pricelist $row}
                                    <li class="item"><a {if $param['priceid']==$row['id']}class="active"{/if} href="{Model_Spot::get_search_url($row['id'],'priceid',$param)}">{$row['title']}</a></li>
                                    {/loop}
                                    {/st}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {if count($grouplist)>4}
                <a href="javascript:;" id="searchConsoleBtn" class="search-console-btn down">展开更多搜索</a>
                {/if}
            </div><!--条件搜索-->
            <div class="st-sceniclist-con">
              <div class="st-sort-menu">
                <span class="sort-sum">
                <a href="javascript:;">综合排序</a>
                <a href="javascript:;">价格
                    {if $param['sorttype']!=1 && $param['sorttype']!=2}
                    <i class="jg-default" data-url="{Model_Spot::get_search_url(1,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==1}
                    <i class="jg-up" data-url="{Model_Spot::get_search_url(2,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==2}
                    <i class="jg-down" data-url="{Model_Spot::get_search_url(0,'sorttype',$param)}"></i></a>
                    {/if}
                <a href="javascript:;">销量
                    {if $param['sorttype']!=3}
                    <i class="xl-default" data-url="{Model_Spot::get_search_url(3,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==3}
                    <i class="xl-down" data-url="{Model_Spot::get_search_url(0,'sorttype',$param)}"></i>
                    {/if}
                </a>
                <a href="javascript:;">推荐
                    {if $param['sorttype']!=4}
                    <i class="tj-default" data-url="{Model_Spot::get_search_url(4,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==4}
                    <i class="tj-down" data-url="{Model_Spot::get_search_url(0,'sorttype',$param)}"></i>
                    {/if}
                </a>
              </span><!--排序-->
              </div>
            <div class="scenic-list-con">
                {if !empty($list)}
                {loop $list $row}
                <div class="list-child">
                    <a href="{$row['url']}" target="_blank" title="{$row['title']}">
                        <div class="lc-image-text clearfix">
                            <div class="pic">
                                <span>
                                    <img src="{Product::get_lazy_img()}" st-src="{Common::img($row['litpic'],265,180)}" alt="{$row['title']}"/>
                                </span>
                            </div>
                            <div class="text">
                                <p class="bt">{$row['title']}</p>
                                <p class="attr clearfix">
                                    {if $GLOBALS['cfg_icon_rule']==1}
                                    {loop $row['iconlist'] $icon}
                                    <span>{$icon['kind']}</span>
                                    {/loop}
                                    {else}
                                    {loop $row['iconlist'] $ico}
                                    <img src="{$ico['litpic']}"/>
                                    {/loop}
                                    {/if}
                                </p>
                                {if !empty($row['sellpoint'])}
                                <p class="sell-point">
                                    {$row['sellpoint']}
                                </p>
                                {/if}
                                {if !empty($row['open_time_des'])}
                                <dl class="open-time">
                                    <dt>开放时间：</dt>
                                    <dd><p>{$row['open_time_des']}</p></dd>
                                </dl>
                                {/if}
                                {if !empty($row['address'])}
                                <p class="ads">{if $row['finaldestid']>0}<span class="pos">{$row['finaldestname']}</span>{/if}{$row['address']}</p>
                                {/if}
                            </div>
                            <div class="booking">
                                <div class="lowest-jg">
                                    {if !empty($row['price'])}
                                    <i class="currency_sy">{Currency_Tool::symbol()}<em>{$row['price']}</em></i>起
                                    {else}
                                    <i class="currency_sy"><em>电询</em></i>
                                    {/if}
                                </div>
                                <div class="data clearfix">
                                    <p class="sati">
                                        <span class="num">{$row['satisfyscore']}</span>
                                        <span>满意度</span>
                                    </p>
                                    <p class="comment">
                                        <span>{$row['sellnum']}人已购买</span>
                                        <span>{Model_Comment::get_comment_num($row['id'],$typeid)}条评论</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    {if $row['hasticket']}
                    <div class="spot-typetable">
                        <div class="type-label clearfix">
                            <ul>
                                {st:spot action="suit_list" row="100" productid="$row['id']" return="suitlist"}
                                {loop $suitlist $suit}
                                <li class="li-hide">
                                    <div class="ticket-title">
                                        <strong class="type-tit">{$suit['title']}{if $suit['tickettype_name']}-{$suit['tickettype_name']}{/if}
                                            <i class="arr-ico"></i>
                                        </strong>
                                    </div>
                                    <div class="ticket-data clearfix">
                                        <div class="ticket-type">{$type['title']}</div>
                                        <div class="order-time">{if !empty($suit['day_before_des_mobile'])}
                                            {$suit['day_before_des_mobile']}
                                            {else}当天24:00前可预定{/if}</div>
                                        <div class="ticket-price">
                                            <span class="price">{if $suit['ourprice']}<em>{Currency_Tool::symbol()}<strong>{$suit['ourprice']}</strong></em>起{else}<strong>电询</strong>{/if}</span>
                                            <span class="ori-price">（{if !empty($suit['sellprice'])}<del>{Currency_Tool::symbol()}{$suit['sellprice']}</del>{else}--{/if}）</span>
                                        </div>
                                        <div class="pay-type">{if $suit['pay_way']==1}线上支付
                                            {elseif $suit['pay_way']==2}线下支付
                                            {elseif $suit['pay_way']==3}线上支付/线下支付
                                            {/if}</div>
                                        <div class="ticket-order-btn">
                                            {if $suit['price_status']==1}
                                            <a class="booking-btn" href="{$cmsurl}spot/book/?suitid={$suit['id']}&productid={$suit['spotid']}">立即预订</a>
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
                                                    {else}验票当天24:00前{/if}
                                                </div>
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
                            <div class="more-btn-box more_suit" style="display:none;">
                                <a href="javascript:;" class="more-ticket-btn">loading</a>
                            </div>
                        </div>
                    </div>
                    {/if}
                </div>
                {/loop}
                <div class="main_mod_page clear">
                    {$pageinfo}
                </div>
                {else}
                <div class="no-content">
                    <p><i></i>抱歉，没有找到符合条件的产品！<a href="/spots/all">查看全部产品</a></p>
                </div>
                {/if}
            </div>
          </div>
        </div>
        <div class="st-sidebox">
            {st:right action="get" typeid="$typeid" data="$templetdata" pagename="search"}
        </div><!--边栏模块-->
  </div>
</div>

{request "pub/footer"}

{request "pub/flink"}

<script>
    $(function(){
        //搜索条件
        $(".arrow").on("click",function(){
            if( $(this).hasClass("down") )
            {
                $(this).removeClass("down").addClass("up");
                $(this).text("收起");
                $(this).prev(".child-list").css("height","auto")
            }
            else
            {
                $(this).removeClass("up").addClass("down");
                $(this).text("展开");
                $(this).prev(".child-list").css("height","24px")
            }
        });
        $("#searchConsoleBtn").on("click",function(){
            if( $(this).hasClass("down") ){
                $("div.search-type-block div.search-type-item").show();
                $(this).removeClass("down").addClass("up").text("收起");
            }else{
                $("div.search-type-block div.search-type-item").each(function(){
                    var index=$("div.search-type-block div.search-type-item").index(this);
                    var max=Number($("#search-content").attr('data-max'));
                    if(index>max+1){
                        $(this).hide();
                    }
                })
                $(this).removeClass("up").addClass("down").text("展开更多搜索");
            }
        });

        //搜索条件去掉最后一条边框
        $('.line-search-tj').find('dl').last().addClass('bor_0')
        $(".line-search-tj dl dd em").toggle(function(){
            $(this).prev().height('24px');
            $(this).children('b').text('展开');
            $(this).children('i').removeClass('up')
        },function(){
            $(this).prev().height('auto');
            $(this).children('b').text('收起');
            $(this).children('i').addClass('up')
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
//        //套餐点击
//        $(".type-tit").click(function(){
//            $(this).parents('tr').first().next().toggle();
//        })

        //排序方式点击
        $('.sort-sum').find('a').click(function(){
            var url = $(this).find('i').attr('data-url');
            if(url==undefined){
                url = location.href;
            }
            window.location.href = url;
        })
        //删除已选
        $(".item-check").find('i.closed').click(function(){
            var url = $(this).parent().attr('data-url');
            window.location.href = url;
        })
        //清空筛选条件
        $('.clearc').click(function(){
            var url = SITEURL+'spots/all/';
            window.location.href = url;
        })
        //隐藏没有属性下级分类
        $(".type").each(function(i,obj){
            var len = $(obj).find('dd p a').length;
            if(len<1){
                $(obj).hide();
            }
        })
        //隐藏多余的套餐
        $(".scenic-list-con .list-child").each(function () {
            var child=$(this).find(".spot-typetable ul li").length;
            $(this).find(".spot-typetable ul li").each(function () {
                if ($(this).index() < 3) {
                    $(this).removeClass('li-hide');
                }
            });
            if(child>3) {
                var hide_num = child - 3
                $(this).find(".spot-typetable div.more_suit a.more-ticket-btn").html('展开全部门票（' + hide_num + '）');
                $(this).find(".spot-typetable div.more_suit").show();
            }
        });
        //查看更多门票
        $(".more-ticket-btn").on("click",function(){
            var $this=$(this);
            var tiLi=$this.parents(".type-label").find("li.li-hide");
            if($this.hasClass("up")){
                tiLi.css({"display":"none"});
                $this.removeClass("up").text('展开全部门票（' + tiLi.length + '）');
            }else{
                tiLi.css({"display":"block"});
                $this.addClass("up").text('收起更多门票（' + tiLi.length + '）');
            }
        });
    })
</script>


</body>
</html>
