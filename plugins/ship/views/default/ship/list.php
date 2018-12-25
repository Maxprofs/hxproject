<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{if $is_all}邮轮旅游_邮轮航线大全_邮轮特价-{$GLOBALS['cfg_webname']}{else}{$searchtitle}{/if}</title>
    {$destinfo['keyword']}
    {$destinfo['description']}
    {include "pub/varname"}
    {Common::css('base.css,extend.css')}
    {Common::css_plugin('ship.css','ship',0)}
    {Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js')}
</head>

<body>
{request "pub/header"}

    <div class="big">
        <div class="wm-1200">

            <div class="st-guide">
                {st:position action="list_crumbs" destid="$destinfo['dest_id']" typeid="$typeid"}
            </div><!-- 面包屑 -->

            <div class="st-main-page">

                <div class="ship-content">

                    <div class="seo-content-box">
                        <h3 class="seo-bar"><span class="seo-title">{if $destinfo['dest_name']}{$destinfo['dest_name']}{$channelname}{else}{$channelname}{/if}</span></h3>
                        {if $destinfo['dest_jieshao']}
                        <div class="seo-wrapper clearfix">
                            {$destinfo['dest_jieshao']}
                        </div>
                        {/if}
                    </div>
                    <!-- 目的地优化设置 -->

                    <div class="st-list-search">
                        <div class="been-tj">
                            <strong>已选条件：</strong>
                            <p>
                                {loop $chooseitem $item}
                                <span class="chooseitem" data-url="{$item['url']}">{$item['itemname']}<i></i></span>
                                {/loop}
                                <a href="javascript:;" class="clearc">清空筛选条件 </a>
                            </p>
                        </div>
                        <div class="line-search-tj">
                            <dl class="type">
                                <dt>目的地：</dt>
                                <dd>
                                    <p>
                                        {st:dest action="query" typeid="$typeid" flag="nextsame" row="100" pid="$destid" return="destlist"}
                                        {loop $destlist $dest}
                                        <a {if $param['destpy']==$dest['pinyin']}class="on"{/if} href="{Model_Ship_Line::get_search_url($dest['pinyin'],'destpy',$param)}">{$dest['kindname']}</a>
                                        {/loop}
                                        {/st}
                                    </p>
                                    {if count($destlist)>10}
                                    <em><b>收起</b><i class='up'></i></em>
                                    {/if}
                                </dd>
                            </dl>
                            <dl class="type">
                                <dt>航线出发地：</dt>
                                <dd>
                                    <p>
                                        {st:startplace action="city" row="100" return="startcitylist"}
                                        {loop $startcitylist $city}
                                        <a {if $param['startcityid']==$city['id']}class="on"{/if} href="{Model_Ship_Line::get_search_url($city['id'],'startcityid',$param)}">{$city['title']}</a>
                                        {/loop}
                                        {/st}
                                    </p>
                                    {if count($startcitylist)>10}
                                    <em><b>收起</b><i class='up'></i></em>
                                    {/if}
                                </dd>
                            </dl>
                            <dl class="type">
                                <dt>轮船：</dt>
                                <dd>
                                    <p>
                                        {st:ship action="ship" flag="order" row="100" return="shiplist"}
                                        {loop $shiplist $ship}
                                        <a {if $param['shipid']==$ship['id']}class="on"{/if} href="{Model_Ship_Line::get_search_url($ship['id'],'shipid',$param)}">{$ship['title']}</a>
                                        {/loop}
                                    </p>
                                </dd>
                            </dl>
                            <dl class="type">
                                <dt>航线天数：</dt>
                                <dd>
                                    <p>
                                        {st:ship action="day_list"}
                                        {loop $data $r}
                                        <a {if $param['dayid']==$r['number']}class="on"{/if} href="{Model_Ship_Line::get_search_url($r['number'],'dayid',$param)}">{$r['title']}</a>
                                        {/loop}
                                        {/st}
                                    </p>
                                </dd>
                            </dl>
                            <dl class="type">
                                <dt>航线价格：</dt>
                                <dd>
                                    <p>

                                        {st:ship action="price_list"}
                                        {loop $data $r}
                                        <a {if $param['priceid']==$r['id']}class="on"{/if} href="{Model_Ship_Line::get_search_url($r['id'],'priceid',$param)}">{$r['title']}</a>
                                        {/loop}
                                        {/st}
                                    </p>
                                </dd>
                            </dl>
                            {st:attr action="query" flag="grouplist" typeid="$typeid" return="grouplist"}
                            {loop $grouplist $group}
                            <dl class="type">
                                <dt>{$group['attrname']}：</dt>
                                <dd>
                                    <p>
                                        {st:attr action="query" flag="childitem" typeid="$typeid" groupid="$group['id']" return="attrlist"}
                                        {loop $attrlist $attr}
                                        <a href="{Model_Ship_Line::get_search_url($attr['id'],'attrid',$param)}" {if Common::check_in_attr($param['attrid'],$attr['id'])!==false}class="on"{/if}>{$attr['attrname']}</a>
                                        {/loop}
                                        {/st}
                                    </p>
                                </dd>
                            </dl>
                            {/loop}
                            {/st}
                        </div>
                    </div><!-- 条件搜索 -->

                    <div class="st-sort-menu">
                        <span class="sort-sum">
                            	<a href="javascript:;">综合排序</a>
                                <a href="javascript:;">价格
                                    {if $param['sorttype']!=1 && $param['sorttype']!=2}
                                    <i class="jg-default" data-url="{Model_Ship_Line::get_search_url(1,'sorttype',$param)}"></i>
                                    {/if}
                                    {if $param['sorttype']==1}
                                    <i class="jg-up" data-url="{Model_Ship_Line::get_search_url(2,'sorttype',$param)}"></i>
                                    {/if}
                                    {if $param['sorttype']==2}
                                    <i class="jg-down" data-url="{Model_Ship_Line::get_search_url(0,'sorttype',$param)}"></i></a>
                                    {/if}
                                <a href="javascript:;">销量
                                    {if $param['sorttype']!=3}
                                    <i class="xl-default" data-url="{Model_Ship_Line::get_search_url(3,'sorttype',$param)}"></i>
                                    {/if}
                                    {if $param['sorttype']==3}
                                    <i class="xl-down" data-url="{Model_Ship_Line::get_search_url(0,'sorttype',$param)}"></i>
                                    {/if}
                                </a>
                                <a href="javascript:;">推荐
                                    {if $param['sorttype']!=4}
                                    <i class="tj-default" data-url="{Model_Ship_Line::get_search_url(4,'sorttype',$param)}"></i>
                                    {/if}
                                    {if $param['sorttype']==4}
                                    <i class="tj-down" data-url="{Model_Ship_Line::get_search_url(0,'sorttype',$param)}"></i>
                                    {/if}
                                </a>
                        </span>
                    </div><!-- 排序搜索 -->


                    <div class="ship-list-content">
                        {if !empty($list)}
                        <ul>
                            {loop $list $line}
                            <li>
                                <div class="pic"><a href="{$line['url']}" target="_blank" title="{$line['title']}"><img src="{Product::get_lazy_img()}" st-src="{Common::img($line['litpic'],265,180)}" alt="{$line['title']}"/></a></div>
                                <div class="txt">
                                    <p class="bt"><a href="{$line['url']}" title="{$line['title']}">{Common::cutstr_html($line['title'],50)}
                                            {loop $line['iconlist'] $icon}
                                            <img src="{$icon['litpic']}" />
                                            {/loop}
                                            </a>
                                    </p>
                                    <p class="data">
                                        <span>销量：{$line['sellnum']}</span><s>|</s>
                                        <span>满意度：{$line['score']}</span><s>|</s>
                                        <span>推荐：{$line['recommendnum']}</span>
                                    </p>
                                    <p class="xc"><strong>行程概括：</strong><span>{implode('-',$line['passed_destnames'])}</span></p>
                                    <p class="ts">
                                        {php}
                                           $attr_names=array();
                                           foreach($line['attrlist'] as $attr)
                                           {
                                                $attr_names[] = $attr['attrname'];
                                           }
                                           $attr_str = implode(',',$attr_names);
                                        {/php}
                                        {if !empty($line['sellpoint']) || !empty($line['attrlist'])}
                                        <strong>特色</strong>
                                        <span>{if !empty($line['sellpoint'])}{Common::cutstr_html($line['sellpoint'],60)}{else} {$attr_str} {/if}</span>
                                        {/if}
                                    </p>
                                    <p class="msg">
                                        <span class="start">
                                          {if !empty($line['startcity_name'])}
                                              [{$line['startcity_name']}出发]
                                          {/if}
                                        </span>
                                        <span class="date"><strong>出发日期：</strong>{$line['starttime']}</span>
                                    </p>
                                </div>
                                <div class="booking">
                                    <span class="yh">
                                    {if !empty($line['price'])}
                                    <i class="currency_sy">{Currency_Tool::symbol()}</i><b>{$line['price']}</b>起/人
                                    {else}
                                     <b>电询</b>
                                    {/if}
                                    </span>
                                    <span class="yj">{if !empty($line['storeprice'])}原价：<del><i class="currency_sy">{Currency_Tool::symbol()}</i>{$line['storeprice']}起/人</del>{/if}</span>
                                    <a href="{$line['url']}" title="{$line['title']}" target="_blank">立即预订</a>
                                </div>
                            </li>
                            {/loop}
                        </ul>
                        {else}
                        <div class="no-content">
                            <p><i></i>抱歉，没有找到符合条件的产品！<a href="/ship/all">查看全部产品</a></p>
                        </div>
                        {/if}
                    </div><!-- 产品列表 -->
                    <div class="main_mod_page clear">
                        {$pageinfo}
                    </div>


                </div><!-- 主体内容 -->

                <div class="st-sidebox">

                    {st:right action="get" typeid="$typeid" data="$templetdata" pagename="search"}

                </div><!-- 右侧自定义内容 -->

            </div>

        </div>
    </div>

{request "pub/footer"}

{request "pub/flink"}


    <script>

        $(function(){



            //排序方式点击
            $('.sort-sum').find('a').click(function(){
                var url = $(this).find('i').attr('data-url');
                if(url==undefined){
                    url = location.href;
                }
                window.location.href = url;
            })
            //删除已选
            $(".chooseitem").find('i').click(function(){
                var url = $(this).parent().attr('data-url');
                window.location.href = url;
            })
            //清空筛选条件
            $('.clearc').click(function(){
                var url = SITEURL+'ship/all/';
                window.location.href = url;
            })
            //隐藏没有属性下级分类
            $(".type").each(function(i,obj){
                var len = $(obj).find('dd p a').length;
                if(len<1){
                    $(obj).hide();
                }
            })

            //线路搜索条件去掉最后一条边框
            $('.line-search-tj').find('dl').last().addClass('bor_0')
            $(".line-search-tj dl dd em").toggle(function(){
                $(this).prev().height('24px');
                $(this).children('b').text('展开');
                $(this).children('i').addClass('up')
            },function(){
                $(this).prev().height('auto');
                $(this).children('b').text('收起');
                $(this).children('i').removeClass('up')
            });
        })

    </script>

</body>
</html>
