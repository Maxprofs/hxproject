<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{if $is_all}当季热门旅游线路_最新旅游线路大全-{$GLOBALS['cfg_webname']}{else}{$searchtitle}{/if}</title>
    {$destinfo['keyword']}
    {$destinfo['description']}
    {include "pub/varname"}
    {Common::css_plugin('lines.css','line')}
    {Common::css('base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js')}
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
                    $('.grouplist-all').show();

                    $(this).removeClass("down").addClass("up").text("收起")
                }
                else{
                    $('.grouplist-all').hide();
                    $(this).removeClass("up").addClass("down").text("展开更多搜索")
                }
            })

            $("#st-search-pop-layer").css({
                "top":$("#search-type-dest").height()
            })

        })
    </script>
</head>

<body top_padding=WPOzDt >

{request "pub/header"}

<div class="big">
    <div class="wm-1200">

        <div class="st-guide">
            {st:position action="list_crumbs" destid="$destinfo['dest_id']" typeid="$typeid"}
        </div>
        <!--面包屑-->
        <div class="st-main-page">
            <div class="st-linelist-box">
                <div class="st-line-brief">
                    <div class="dest-tit"><i class="st-line-icon line-mdd-icon"></i>{if $destinfo['dest_name']}{$destinfo['dest_name']}{$channelname}{else}{$channelname}{/if}</div>
                    {if $destinfo['dest_jieshao']}
                    <div class="brief-con">
                        {$destinfo['dest_jieshao']}
                    </div>
                    {/if}
                </div>
                <!--栏目介绍-->
                <div class="search-type-block ">
                    <div class="search-type-item clearfix choose-item" {if count($chooseitem)<1}style="display:none"{/if}>
                        <strong class="item-hd">已选条件：</strong>
                        <div class="item-bd">
                            <div class="item-check">
                                {loop $chooseitem $item}
                                <a class="chick-child chooseitem" data-url="{$item['url']}"   href="javascript:;">{$item['itemname']}<i class="closed"></i></a>
                                {/loop}
                                <a class="clear-item clearc" href="javascript:;">清空筛选条件</a>
                            </div>
                        </div>
                    </div>
                    <div class="search-type-item clearfix">
                        <strong class="item-hd">目的地：</strong>
                        <div class="item-bd">
                            <div class="item-child">
                                <div class="child-block">
                                    <ul class="child-list">
                                        {st:dest action="query" typeid="$typeid" flag="nextsame" row="100" pid="$destid" return="destlist"}
                                        {loop $destlist $dest}
                                        <li class="item"><a  {if $param['destpy']==$dest['pinyin']}class="active"{/if} href="{Model_Line::get_search_url($dest['pinyin'],'destpy',$param)}" >{$dest['kindname']}</a></li>
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
                {st:attr action="query" flag="grouplist" typeid="$typeid" return="grouplist"}
                {php}$index=1;{/php}
                {loop $grouplist $group}
                {st:attr action="query" flag="childitem" typeid="$typeid" groupid="$group['id']" return="attrlist"}
                {php} if(empty($attrlist)){continue;} {/php}

                    <div class="search-type-item clearfix {if $GLOBALS['cfg_line_attr_show_num']<$index}grouplist-all{/if}" {if $GLOBALS['cfg_line_attr_show_num']<$index}style="display:none"{/if}>
                        <strong class="item-hd">{$group['attrname']}：</strong>
                        <div class="item-bd">
                            <div class="item-child">
                                <div class="child-block">
                                    <ul class="child-list">

                                        {loop $attrlist $attr}
                                        <li class="item"><a {if Common::check_in_attr($param['attrid'],$attr['id'])!==false}class="active"{/if} href="{Model_Line::get_search_url($attr['id'],'attrid',$param)}" >{$attr['attrname']}</a></li>
                                        {/loop}
                                        {/st}
                                    </ul>
                                    {if count($attrlist)>5}
                                    <a class="arrow down" href="javascript:;">展开</a>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    </div>
                {php}$index++;{/php}
                {/loop}
                {/st}
                <a href="javascript:;" id="searchConsoleBtn" style="display: none" class="search-console-btn down">展开更多搜索</a>
                </div>
                <!-- 搜索条件 -->

                <div class="st-linelist-con">
                    <div class="st-sort-menu">
                            <span class="sort-sum">
                                <a href="javascript:;">综合排序</a>
                                <a href="javascript:;">价格
                                    {if $param['sorttype']!=1 && $param['sorttype']!=2}
                        <i class="jg-default" data-url="{Model_Line::get_search_url(1,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==1}
                        <i class="jg-up" data-url="{Model_Line::get_search_url(2,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==2}
                        <i class="jg-down" data-url="{Model_Line::get_search_url(0,'sorttype',$param)}"></i></a>
                    {/if}
                                </a>
                                <a href="javascript:;">销量
                                    {if $param['sorttype']!=3}
                        <i class="xl-default" data-url="{Model_Line::get_search_url(3,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==3}
                        <i class="xl-down" data-url="{Model_Line::get_search_url(0,'sorttype',$param)}"></i>
                    {/if}
                                </a>

                                <select class="sel-price search-sel">
                                	<option data-url="{Model_Line::get_search_url(0,'priceid',$param)}">价格区间</option>
                                     {st:line action="price_list"}
                                    {loop $data $r}
                                	<option  {if $param['priceid']==$r['id']}selected{/if} data-url="{Model_Line::get_search_url($r['id'],'priceid',$param)}">{$r['title']}</option>
                                     {/loop}
                                     {/st}
                                </select>
                                <select class="sel-day search-sel">
                                	<option data-url="{Model_Line::get_search_url(0,'dayid',$param)}">出游天数</option>
                                     {st:line action="day_list"}
                                    {loop $data $r}
                                	<option  {if $param['dayid']==$r['word']}selected{/if} data-url="{Model_Line::get_search_url($r['word'],'dayid',$param)}">{$r['title']}</option>
                                    {/loop}
                                     {/st}
                                </select>
                                 {if $GLOBALS['cfg_startcity_open']}
                                <select class="sel-dest search-sel">
                                	<option data-url="{Model_Line::get_search_url(0,'startcityid',$param)}">出发城市</option>
                                    {st:startplace action="city" row="100" return="startcitylist"}
                                    {loop $startcitylist $city}
                                	<option  {if $param['startcityid']==$city['id']}selected{/if} data-url="{Model_Line::get_search_url($city['id'],'startcityid',$param)}">{$city['title']}</option>
                                    {/loop}
                                     {/st}
                                </select>
                                {/if}
                            </span>
                        <span class="switch-show">

                        </span><!--切换模式-->
                    </div>
                    {if $list}

                    <div class="txt-line-list">
                        <ul>
                            {loop $list $line}
                            <li>
                                <a href="{$line['url']}" target="_blank">
                                    <div class="pic"><span><img src="{Product::get_lazy_img()}" st-src="{$line['litpic']}" alt="{$line['title']}" title="{$line['title']}"></span></div>
                                    <div class="txt">
                                        <p class="bt">{$line['title']}</p>
                                        <p class="attr">
                                            {if $GLOBALS['cfg_icon_rule']==1}
                                            {loop $line['iconlist'] $icon}
                                            <span/>{$icon['kind']}</span>
                                            {/loop}
                                            {else}
                                            {loop $line['iconlist'] $icon}
                                             <img src="{$icon['litpic']}"/></span>
                                            {/loop}
                                            {/if}

                                        </p>
                                        <p class="ts">
                                            {if !empty($line['startcity'])}
                                             <span class="pos">{$line['startcity']}出发</span>
                                            {/if}
                                            {$line['sellpoint']}
                                        </p>
                                        <p class="msg">
                                            <span class="item dates">
                                                团期：{$line['startdate']}
                                                {php}
                                                  $start = explode('、',$line['startdate']);
                                                {/php}
                                            </span>
                                            {if count($start)>5}
                                              <span class="more-date-btn">更多</span>
                                            {/if}
                                        </p>
                                        <p class="msg">
                                            <span class="item days">行程：{$line['lineday']}天</span>
                                            {if $line['suppliername']}
                                            <span class="item supplier">供应商：{$line['suppliername']}</span>
                                            {/if}
                                        </p>
                                    </div>
                                    <div class="booking">
                                        <span class="jg">
                                            {if !empty($line['price'])}
                                            <i>{Currency_Tool::symbol()}<em>{$line['price']}</em></i>起
                                            {else}
                                            <i><em class="dx">电询</em></i>
                                            {/if}
                                        </span>
                                        {if $line['jifentprice']}
                                        <span class="jf"><i>积分抵现</i><em>抵<strong>{$line['jifentprice']}</strong></em></span>
                                        {/if}
                                        <div class="data clearfix">
                                            <p class="sati">
                                                <span class="num">{$line['score']}</span>
                                                <span>满意度</span>
                                            </p>
                                            <p class="comment">
                                                <span>{$line['sellnum']}人已购买</span>
                                                <span>{$line['commentnum']}条评论</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            {/loop}


                        </ul>
                        <div class="main_mod_page clear">
                            {$pageinfo}
                        </div>
                    </div>

                    {else}
                    <div class="no-content">
                        <p><i></i>抱歉，没有找到符合条件的产品！<a href="/lines/all">查看全部产品</a></p>
                    </div>
                    {/if}

                </div>
            </div>
            <!--列表主体-->
            <div class="st-sidebox">
                {st:right action="get" typeid="$typeid" data="$templetdata" pagename="search"}
            </div>
            <!--边栏模块-->
        </div>

    </div>
</div>

{request "pub/footer"}

{request "pub/flink"}

</body>
</html>
<script>

    //排序方式点击
    $('.sort-sum').find('a').click(function(){
        var url = $(this).find('i').attr('data-url');
        if(url==undefined){
            url = location.href;
        }
        window.location.href = url;
    });
    //删除已选
    $(".chooseitem").find('i').click(function(){
        var url = $(this).parent().attr('data-url');
        window.location.href = url;
    });
    //清空筛选条件
    $('.clearc').click(function(){
        var url = SITEURL+'lines/all/';
        window.location.href = url;
    });
    //隐藏没有属性下级分类
    $(".search-type-item").each(function(i,obj){

        if($(obj).hasClass('choose-item'))
        {
            return true;
        }
        var len = $(obj).find('.child-list .item').length;
        if(len<1){
            $(obj).remove();
        }
    });
    if($('.grouplist-all').length>0)
    {
            $('#searchConsoleBtn').show();
    }
    else
    {
        $('#searchConsoleBtn').hide();
    }
    $('.search-sel').change(function () {
        var url = $(this).find('option:selected').data('url');
        location.href = url;

    })


</script>