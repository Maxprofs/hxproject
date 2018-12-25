<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>{$seoinfo['seotitle']}-{$webname}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}"/>
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}"/>
    {/if}
    {$GLOBALS['cfg_indexcode']}
    {include "pub/varname"}
    {php $template = 'll_tk11257_pc_no296_index';}
    {Common::get_user_css($template . '/css/base.css')}
    {Common::get_user_css($template . '/css/header.css')}
    {Common::get_user_css($template . '/css/swiper.min.css')}
    {Common::get_user_css($template . '/css/city.css')}
    {Common::get_user_css($template . '/css/index.css')}
    {Common::get_user_js($template . '/js/jquery.min.js')}
    {Common::get_user_js($template . '/js/swiper.min.js')}
    {Common::js('template.js,tuan.js')}
    {Common::get_user_js($template . '/js/SuperSlide.min.js')}

</head>

<body>

        {request 'pub/header'}

        <div class="global-area">
            {if !empty($GLOBALS['cfg_usernav_open'])}
            {st:usernav action="topkind" row="6"}
            {if !empty($data)}
            <div class="global-nav-box" {if empty($indexpage)}style="display: none;"{/if}>
            {php}$k=0;{/php}

            {loop $data $nav}
            <div class="global-nav-group">
                <div class="global-nav-hd">
                    <div class="icon-area">
                        <span class="icon">
                            <img src="{Common::img($nav['litpic'],20,20)}" alt="">
                        </span>
                    </div>
                    <div class="bar">
                        <h4 class="tit"><a {if !empty($nav['url'])&&filter_var($nav['url'],FILTER_VALIDATE_URL)}href="{$nav['url']}" {else}href="javascript:;"{/if}target="_blank">{$nav['kindname']}</a></h4>
                        <div class="child">
                            {st:usernav action="childnav" parentid="$nav['id']" row="5" return="childnav"}
                            {loop $childnav $c}
                            <a  class="item" {if !empty($c['url'])}href="{$c['url']}"{else}href="javascript:;"{/if} target="_blank">{$c['kindname']}</a>
                            {/loop}
                            {/st}
                        </div>
                    </div>
                </div>
                <div class="global-nav-bd">
                    {st:usernav action="childnav" parentid="$nav['id']" row="100" return="childnav2"}
                    {php $ind = 1;}
                    {loop $childnav2 $r2}
                    <dl class="type-block">
                        <dt class="type-bar"><a {if !empty($r2['url'])}href="{$r2['url']}"{else}href="javascript:;"{/if} target="_blank">{$r2['kindname']}</a></dt>
                        <dd class="type-list">
                            {st:usernav action="childnav" parentid="$r2['id']" return="childnav3" row="100"}
                            {loop $childnav3 $r3}
                            <a {if !empty($r3['url'])}href="{$r3['url']}"{else}href="javascript:;"{/if} target="_blank">{$r3['kindname']}</a>
                            {/loop}
                            {/st}
                        </dd>
                    </dl>

                    {php $ind++;}
                    {/loop}
                    {/st}
                </div>
            </div>
            {php}$k++;{/php}
            {/loop}
        </div>
        {/if}
        {/st}
        {/if}        <!-- 自定义导航 -->

        <div class="swiper-container st-banner-container">
            <ul class="swiper-wrapper">
                {st:ad action="getad" name="ll_tk11257_no296_index" pc="1" return="ad"}
                {loop $ad['aditems'] $v}
                <li class="swiper-slide">
                    <a href="{$v['adlink']}" class="item"><img src="{Common::img($v['adsrc'],1920,420)}" alt="{$v['adname']}"></a>
                </li>
               {/loop}
            </ul>
            <div class="swiper-pagination"></div>
            <!-- 分页器 -->
        </div>
        <!-- 通栏轮播广告 -->
    </div>

    <div class="new-data-bar">
        <div class="wm-1200">
            <div class="myd"><i class="icon"></i>满意度<span class="data"><span class="num">98</span>%</span></div>
            <div class="swiper-container new-order-bar">
                <ul class="swiper-wrapper">
                    {st:order action="query" flag="all" row="6" return="olist"}
                    {loop $olist $o}
                    <li class="swiper-slide">
                        <a href="" class="name">{$o['productname']}</a>
                        <span class="item">用户{$o['nickname']}</span>
                        <span class="item">{$o['dingtime']}预订</span>
                    </li>
                    {/loop}

                </ul>
            </div>
        </div>
    </div>
    <!-- 满意度、订单 -->

    <div class="big">
        <div class="wm-1200">
            {if $channel['line']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['line']['channelname']}</span>
                    <ul class="tab-group">
                        {st:attr  action="query" flag="grouplist" typeid="1" row="5" return="attrs" }
                        {loop $attrs $a}
                        <li>{$a['attrname']}</li>
                        {/loop}
                    </ul>
                    <a href="{$cmsurl}lines/all" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper">
                    <div class="tab-box line-type-box">
                        {loop $attrs $a}
                        {st:line action="query" flag="attr" attrid="$a['id']" row="9"  return="lists" }

                        <ul class="column-list-group clearfix">
                            {loop $lists $l}
                            {if $n==1}
                            <li class="first-item" {$n}>
                            {elseif $n ==4 || $n == 9 }
                            <li class="item mr_0" {$n}>
                             {else}
                            <li class="item" {$n}>
                            {/if}
                                <i class="sale-icon"></i>
                                {if $n == 1}
                                <a href="{$l['url']}" class="img-area"><img src="{Common::img($l['litpic'],468,256)}" alt="{$l['title']}"></a>
                                <div class="info-bar">
                                    <a href="{$l['url']}" class="tit">{$l['title']}</a>
                                        <span class="pri">
                                             {if !empty($l['price'])}
                                            <span class="jg">
                                                {Currency_Tool::symbol()}<span class="num">{$l['price']}</span></span>起
                                            {else}
                                            <span class="jg">
                                               <span class="num">电询</span></span>
                                            {/if}
                                        </span>
                                </div>
                                {else}
                                <a href="{$l['url']}">
                                    <div class="img-area"><img src="{Common::img($l['litpic'],224,152)}" alt="{$l['title']}"></div>
                                    <div class="info-area">
                                        <div class="tit">{$l['title']}</div>
                                        <div class="data-bar clearfix">
                                            <span class="myd">满意度{if $l['satisfyscore']}{$l['satisfyscore']}{else}100%{/if}</span>
                                            <span class="pri">
                                                {if !empty($l['price'])}
                                            <span class="jg">
                                                {Currency_Tool::symbol()}<span class="num">{$l['price']}</span>
                                            </span>起
                                            {else}
                                            <span class="jg">
                                               <span class="num">电询</span>
                                            </span>
                                            {/if}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                                {/if}
                            </li>
                            {/loop}
                        </ul>
                        {/loop}
                    </div>
                </div>
            </div>
            {/if}
            <!-- 精品特惠GO -->
            {if $channel['hotel']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['hotel']['channelname']}</span>
                    <ul class="tab-group">
                        {st:dest action="query" flag="channel_nav" row="5" typeid="2" return="hoteldest"}
                        {loop $hoteldest $hd}
                        <li>{$hd['kindname']}</li>
                        {/loop}
                    </ul>
                    <a href="{$cmsurl}hotels/all" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <div class="col-side-area">
                        <div class="side-con">
                            <h4 class="type-bar">价位</h4>
                            <ul class="type-group">
                                <li><a href="{$cmsurl}hotels/all-0-0-0-0-0-1" class="item">不限</a></li>
                                {st:hotel action="price_list"}
                                {loop $data $r}
                                <li><a href="{$cmsurl}hotels/all-0-{$r['id']}-0-0-0-1" class="item">{$r['title']}</a></li>
                                {/loop}
                                {/st}
                            </ul>
                        </div>
                        <div class="side-banner">
                            {st:ad action="getad" name="ll_tk11257_no296_hotel" pc="1" row="1"}
                            {if !empty($data)}
                            <a href="{$data['adlink']}" class=""><img src="{Common::img($data['adsrc'])}" alt="{$data['adname']}" class=""></a>
                            {/if}
                        </div>
                    </div>
                    <div class="tab-box same-type-box fr">
                        {loop $hoteldest $hd}
                        {st:hotel action="query" flag="mdd" destid="$hd['id']" row="6" return="hotellist"}
                        <ul class="column-list-group clearfix">
                            {loop $hotellist $h}
                            <li {if $n%4==0} class="item mr_0"{else} class="item"{/if}>
                                <a href="{$h['url']}">
                                    <div class="img-area"><img src="{Common::img($h['litpic'],224,152)}" alt="{$v['adname']}"></div>
                                    <div class="info-area">
                                        <div class="tit-al">{$h['title']}</div>
                                        <div class="data-bar clearfix">
                                            <span class="myd">满意度{if $h['satisfyscore']}{$h['satisfyscore']}{else}100{/if}%</span>
                                        <span class="pri">
                                            {if !empty($h['price'])}
                                            <span class="jg">
                                                {Currency_Tool::symbol()}<span class="num">{$h['price']}</span></span>起
                                            {else}
                                            <span class="jg">
                                               <span class="num">电询</span></span>
                                            {/if}</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            {/loop}
                        </ul>
                        {/loop}
                    </div>
                </div>
            </div>
            {/if}
            <!-- 住酒店 -->
            {if $channel['outdoor']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['outdoor']['channelname']}</span>
                    <ul class="tab-group">
                        <li>最新活动</li>
                        {st:dest action="query" flag="channel_nav" row="4" typeid="114" return="linedest"}
                        {loop $linedest $ld}
                        <li>{$ld['kindname']}</li>
                        {/loop}
                    </ul>
                    <a href="{$cmsurl}outdoor/all" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <div class="tab-box outdoor-type-box">
                        {st:outdoor action="query" flag="order"  row="4" return="week_list"}
                        <ul class="outdoor-list-group clearfix">
                            {loop $week_list $k $row}
                            <li {if $n%4==0} class="item mr_0"{else} class="item"{/if}>
                                <a href="{$row['url']}">
                                    {if !empty($row['periods'][0])}
                                    <div class="status {if $row['periods'][0]['bookstatus']==3}full{elseif $row['periods'][0]['bookstatus']==2}
                                   ing{elseif $row['periods'][0]['bookstatus']==1}suc{else}end{/if}">{$row['periods'][0]['bookstatus_name']}</div>
                                    {/if}
                                    <div class="img-area"><img src="{Common::img($row['litpic'],285,193)}" alt="{$row['title']}"></div>
                                    <div class="info-area">
                                        <div class="tit">{$row['title']}</div>
                                        <div class="data-bar clearfix">
                                            <span class="date">{if $row['periods'][0]}{date('m月d日',$row['periods'][0]['day'])}出发{/if}&nbsp;&nbsp;{$row['lineday']}天</span>
                                            <span class="pri"><span class="jg">{if $row['price']}{Currency_Tool::symbol()}<span class="num">{$row['price']}</span></span>起{else}<strong>电询</strong>{/if}</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            {/loop}
                        </ul>
                        {loop $linedest $ld}
                        <ul class="outdoor-list-group clearfix">
                            {st:outdoor action="query" flag="mdd" destid="$ld['id']" row="4" return="lists"}
                            {loop $lists $key $row}
                            <li {if $n%4==0} class="item mr_0"{else} class="item"{/if}>
                            <a href="{$row['url']}">
                                {if !empty($row['periods'][0])}
                                <div class="status {if $row['periods'][0]['bookstatus']==3}full{elseif $row['periods'][0]['bookstatus']==2}
                                   ing{elseif $row['periods'][0]['bookstatus']==1}suc{else}end{/if}">{$row['periods'][0]['bookstatus_name']}</div>
                                {/if}
                                <div class="img-area"><img src="{Common::img($row['litpic'],285,193)}" alt="{$row['title']}"></div>
                                <div class="info-area">
                                    <div class="tit">{$row['title']}</div>
                                    <div class="data-bar clearfix">
                                        <span class="date">{if $row['periods'][0]}{date('m月d日',$row['periods'][0]['day'])}出发{/if}&nbsp;&nbsp;{$row['lineday']}天</span>
                                        <span class="pri"><span class="jg">{if $row['price']}{Currency_Tool::symbol()}<span class="num">{$row['price']}</span></span>起{else}<strong>电询</strong>{/if}</span>
                                    </div>
                                </div>
                            </a>
                            </li>
                            {/loop}
                        </ul>
                        {/loop}
                    </div>
                </div>
            </div>
            {/if}
            <!-- 户外活动 -->
            {if $channel['spot']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['spot']['channelname']}</span>
                    <ul class="tab-group">
                        {st:dest action="query" flag="channel_nav" row="5" typeid="5" return="spotdest"}
                        {loop $spotdest $sd}
                        <li>{$sd['kindname']}</li>
                        {/loop}
                    </ul>
                    <a href="{$cmsurl}spots/all" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <div class="col-side-area">
                        <div class="side-con">
                            {st:attr action="query" flag="grouplist" row="1" typeid="5" return="spotattr"}
                            <h4 class="type-bar">{$spotattr[0]['attrname']}</h4>
                            <ul class="type-group">
                                {st:attr action="query" flag="childitem" row="8" groupid="$spotattr[0]['id']" typeid="5" return="childitem"}
                                {loop $childitem $ch}
                                <li><a href="{$cmsurl}spots/all-0-0-{$ch['id']}-1" class="item">{$ch['attrname']}</a></li>
                                {/loop}
                            </ul>
                        </div>
                        <div class="side-banner">
                            {st:ad action="getad" name="ll_tk11257_no296_spot" pc="1" row="1"}
                            {if !empty($data)}
                            <a href="{$data['adlink']}" class=""><img src="{Common::img($data['adsrc'])}" alt="{$data['adname']}" class=""></a>
                            {/if}
                        </div>
                    </div>
                    <div class="tab-box same-type-box fr">
                        {loop $spotdest $sd}
                        <ul class="column-list-group clearfix">
                            {st:spot action="query" flag="mdd" destid="$sd['id']" row="6" return="spotlist"}
                            {loop $spotlist $s}
                            <li {if $n%4==0} class="item mr_0"{else} class="item"{/if}>
                                <a href="{$s['url']}">
                                    <div class="img-area"><img src="{Common::img($s['litpic'],224,152)}" alt="{$s['title']}"></div>
                                    <div class="info-area">
                                        <div class="tit-al">{$s['title']}</div>
                                        <div class="data-bar clearfix">
                                            <span class="myd">满意度{if $s['satisfyscore']}{$s['satisfyscore']}{else}100%{/if}</span>
                                            <span class="pri">
                                            {if !empty($s['price'])}
                                            <span class="jg">
                                                {Currency_Tool::symbol()}<span class="num">{$s['price']}</span></span>起
                                            {else}
                                            <span class="jg">
                                               <span class="num">电询</span></span>
                                            {/if}</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            {/loop}
                        </ul>
                        {/loop}

                    </div>
                </div>
            </div>
            {/if}
            <!-- 玩景点 -->
            {if $channel['car']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['car']['channelname']}</span>
                    <ul class="tab-group">
                        {st:dest action="query" flag="channel_nav" row="6" typeid="3" return="cardest"}
                        {loop $cardest $cd}
                        <li>{$cd['kindname']}</li>
                        {/loop}
                    </ul>
                    <a href="{$cmsurl}cars/" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <div class="col-side-area">
                        <div class="side-con">
                            {st:attr action="query" flag="grouplist" row="1" typeid="3" return="spotattr"}
                            <h4 class="type-bar">{$spotattr[0]['attrname']}</h4>
                            <ul class="type-group">
                                {st:attr action="query" flag="childitem" row="8" groupid="$spotattr[0]['id']" typeid="3" return="childitem"}
                                {loop $childitem $ch}
                                <li><a href="{$cmsurl}cars/all-0-0-{$ch['id']}-1" class="item">{$ch['attrname']}</a></li>
                                {/loop}
                            </ul>
                        </div>
                        <div class="side-banner">
                            {st:ad action="getad" name="ll_tk11257_no296_car" pc="1" row="1"}
                            {if !empty($data)}
                            <a href="{$data['adlink']}" class=""><img src="{Common::img($data['adsrc'])}" alt="{$data['adname']}" class=""></a>
                            {/if}
                        </div>
                    </div>
                    <div class="tab-box same-type-box fr">
                        {loop $cardest $cd}
                        <ul class="column-list-group clearfix">
                            {st:car action="query" flag="mdd" destid="$cd['id']" row="8" return="carlist"}
                            {loop $carlist $c}
                            <li {if $n%4==0} class="item mr_0"{else} class="item"{/if}>
                                <a href="{$c['url']}">
                                    <div class="img-area"><img src="{Common::img($c['litpic'],224,152)}" alt="{$c['title']}"></div>
                                    <div class="info-area">
                                        <div class="tit-al">{$c['title']}</div>
                                        <div class="data-bar clearfix">
                                            <span class="myd">满意度{if $c['satisfyscore']}{$c['satisfyscore']}{else}100{/if}%</span>
                                            <span class="pri">
                                               {if !empty($c['price'])}
                                            <span class="jg">
                                                {Currency_Tool::symbol()}<span class="num">{$c['price']}</span>
                                            </span>起
                                            {else}
                                            <span class="jg">
                                               <span class="num">电询</span></span>
                                            {/if}
                                            </span>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            {/loop}
                        </ul>
                        {/loop}
                    </div>
                </div>
            </div>
            {/if}
            <!-- 租个车 -->
            {if $channel['ship_line']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['ship_line']['channelname']}</span>
                    <ul class="tab-group">
                        {st:dest action="query" flag="channel_nav" row="6" typeid="104" return="linedest"}
                        {loop $linedest $ld}
                        <li>{$ld['kindname']}</li>
                        {/loop}
                    </ul>
                    <a href="{$cmsurl}ship/" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <div class="col-side-area">
                        <div class="ship-banner">
                            {st:ad action="getad" name="ll_tk11257_no296_ship" pc="1" row="1"}
                            {if !empty($data)}
                            <a href="{$data['adlink']}" class=""><img src="{Common::img($data['adsrc'])}" alt="{$data['adname']}" class=""></a>
                            {/if}
                        </div>
                    </div>
                    <div class="tab-box ship-type-box fr">
                        {loop $linedest $ld}
                        <ul class="ship-list-group clearfix">
                            {st:ship action="query" flag="mdd" destid="$ld['id']" row="8" return="linelist"}
                            {loop $linelist $l}
                            <li {if $n%4==0} class="mr_0"{else}{/if}>
                                <a href="" class="name">{$l['shiptitle']}</a>
                                <a href="" class="info-area">
                                    <div class="tit">1{$l['title']}</div>
                                    <div class="data-bar clearfix">
                                        <span class="myd">{if $l['satisfyscore']}{$l['satisfyscore']}{else}100{/if}%</span>
                                        <span class="pri">
                                                {if !empty($l['price'])}
                                            <span class="jg">
                                                {Currency_Tool::symbol()}<span class="num">{$l['price']}</span>
                                            </span>起
                                            {else}
                                            <span class="jg">
                                               <span class="num">电询</span></span>
                                            {/if}
                                            </span>
                                            </span>
                                    </div>
                                </a>
                            </li>
                            {/loop}
                        </ul>
                        {/loop}
                    </div>
                </div>
            </div>
            {/if}
            <!-- 坐邮轮 -->
            {if $channel['tuan']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['tuan']['channelname']}</span>
                    <a href="$cmsurl}tuan/" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <ul class="tuan-list-group">
                        {st:tuan action="query" flag="order" status=0 row="4" return="tuanlist"}
                        {loop $tuanlist $t}
                        {if $t['starttime'] > time()}
                        <li class="item ing">
                            {else}
                        <li class="item load">
                            {/if}
                            <a href="{$t['url']}">
                                {if $t['starttime'] > time()}
                                <div class="date">距离开始<span class="rq">
                            {else}
                               <div class="date">距离结束<span class="rq">
                            {/if}
                                  <span class="dao" id="tick_{$t['id']}">
                                      <span class="RemainD{$n}"></span>天
                                      <span class="RemainH{$n}"></span>时
                                      <span class="RemainM{$n}"></span>分
                                      <span class="RemainS{$n}"></span>秒
                                      <input type="hidden" class="ticktime" rel="tick_{$t['id']}" value="{php echo date('Y/m/d H:i:s',$t['starttime']);}"/>

                                 </span>
                              </span></div>
                                <div class="img-area"><img src="{Common::img($t['litpic'],285,194)}" alt=""></div>
                                <div class="info-area">
                                    <div class="tit">{$t['title']}</div>
                                    <div class="data-bar clearfix">
                                        <span class="yhq">
                                            <span class="yj">原价 <del>
                                                {if !empty($t['sellprice'])}
                                                {Currency_Tool::symbol()}{$t['sellprice']}</del>
                                                {/if}</span>
                                            {if $t['discount']}<span class="zk">{$t['discount']}折</span>{/if}
                                        </span>
                                        <span class="pri"><span class="jg">   {if !empty($t['price'])}
                                            <span class="jg">
                                                {Currency_Tool::symbol()}<span class="num">{$t['price']}</span>
                                            </span>起
                                            {else}
                                            <span class="jg">
                                               <span class="num">电询</span></span>
                                            {/if}
                                            </span></span>
                                    </div>
                                </div>
                            </a>
                            {if $t['starttime'] > time()}
                            {php $time1 = $t['starttime']-time();}
                            {else}
                            {php $time1 = $t['endtime']-time();}
                            {/if}
                            <script type="text/javascript">
                                var time1 = "{$time1}"-0;
                                if(time1>0){
                                    timer1(time1);
                                }else{
                                    timer1(0)
                                }
                                function timer1(intDiff) {
                                    window.setInterval(function () {
                                        var day = 0,
                                            hour = 0,
                                            minute = 0,
                                            second = 0;//时间默认值
                                        if (intDiff > 0) {
                                            day = Math.floor(intDiff / (60 * 60 * 24));
                                            hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                                            //hour = Math.floor(intDiff / (60 * 60));
                                            minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                                            second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
                                        }
                                        if (minute <= 9) minute = '0' + minute;
                                        if (second <= 9) second = '0' + second;
                                        $('.RemainD{$n}').html(day);
                                        $('.RemainH{$n}').text(hour);
                                        $('.RemainM{$n}').html(minute);
                                        $('.RemainS{$n}').html(second);
                                        intDiff--;
                                    }, 1000);
                                }

                            </script>
                        </li>
                        {/loop}

                    </ul>
                </div>
            </div>
            {/if}
            <!-- 团购 -->
            {if $channel['guide']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['guide']['channelname']}</span>
                    <a href="{$cmsurl}guide/all" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <ul class="guide-list-group">
                        {st:guide action="service_new"  row="4"  return="service"}
                        {loop $service $k $s}
                        <li {if $n%4==0} class="item mr_0"{else} class="item"{/if}>
                            <a href="{$s['url']}" class="img-area"><img src="{Common::img($s['litpic'],285,194)}" alt="{$s['title']}"></a>
                            <div class="info-area">
                                <a href="" class="tit">{$s['title']}</a>
                                <div class="data-bar clearfix">
                                    <a href="" class="user"><img src="{Common::img($s['member_litpic'],30,30)}" alt="">服务导游：{$s['truename']}</a>
                                    <span class="pri"><span class="jg">
                                            {if $s['price']}
                                            {Currency_Tool::symbol()}
                                            <span class="num">{$s['price']}
                                            </span></span>/天{else}电询{/if}</span>
                                </div>
                            </div>
                        </li>
                        {/loop}
                    </ul>
                </div>
            </div>
            {/if}
            <!-- 导游服务 -->
            {if $channel['visa']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['visa']['channelname']}</span>
                    <ul class="tab-group">
                        {st:car action="kin"  row="5"  return="service"}
                        {loop $service $se}
                        <li {$se['id']}>{$se['title']}</li>
                        {/loop}
                    </ul>
                    <a href="{$cmsurl}visa/all" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <div class="tab-box visa-type-box">
                        {loop $service $se}
                        {st:car action="query" flag="arrvisa" row="8" visatype="$se['id']" return="visa"}
                        <ul class="visa-list-group clearfix">
                            {loop $visa $v}
                            <li {if $n%4==0} class="mr_0"{else}{/if}>
                                <a href="{$v['url']}">
                                    <div class="hd-img"><img src="{Common::img($v['litpic'],80,80)}" alt=""></div>
                                    <div class="bd-con">
                                        <h4 class="tit">{$v['title']}</h4>
                                        <div class="pri">  {if !empty($v['price'])}
                                            <span class="jg">
                                                {Currency_Tool::symbol()}<span class="num">{$v['price']}</span>
                                            </span>起
                                            {else}
                                            <span class="jg">
                                               <span class="num">电询</span></span>
                                            {/if}
                                            </span>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                             {/loop}
                        </ul>
                        {/loop}
                    </div>
                </div>
            </div>
            {/if}
            <!-- 办签证 -->
            {st:channel action="pc" row="20"}
            {loop $data $row}
            {if !empty($row['typeid'])&&(Model_Model::all_model($row['typeid'],'maintable'))=='model_archive'&&(Model_Model::all_model($row['typeid'],'issystem'))==0}
            {if $row['isopen']==1}
            <div class="column-container">
                {php}$pinyin=Model_Model::all_model($row['typeid'],'pinyin');{/php}
                <div class="column-bar">
                    <span class="col-title">{$row['title']}</span>
                    <a href="{$cmsurl}{$pinyin}" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <div class="tab-box other-type-box">
                        <ul class="column-list-group clearfix">
                            {st:tongyong action="query" typeid="$row['typeid']" flag="order" row="4" return="tongyong_data"}
                            {php}$ty_index=1;{/php}
                            {loop $tongyong_data $ty}
                            <li {if $ty_index==4} class="item mr_0"{else} class="item"{/if}>
                                <a href="{$ty['url']}">
                                    <div class="img-area"><img src="{Common::img($ty['litpic'],224,194)}" alt="{$ty['title']}"></div>
                                    <div class="info-area">
                                        <div class="tit-al">{$ty['title']}</div>
                                        <div class="data-bar clearfix">
                                            <span class="myd">销量：{$ty['sellnum']}</span>
                                            <span class="pri"><span class="jg">
                                             {if !empty($ty['price'])}
                                             {Currency_Tool::symbol()}<span class="num">{$ty['price']}</span>
                                            </span>起
                                            {else}
                                            <span class="jg">
                                               <span class="num">电询</span></span>
                                            {/if}
                                            </span>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            {php}$ty_index++;{/php}
                            {/loop}
                            {/st}
                        </ul>
                    </div>
                </div>
            </div>
            {/if}
            {/if}
            {/loop}
            <!-- 扩展产品 -->
            {if $channel['photo']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['photo']['channelname']}</span>
                    <a href="{$cmsurl}photos/all" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <ul class="photo-list-group clearfix">
                        {st:photo action="query"  flag="order" row="5" return="photo"}
                        {loop  $photo $p}
                        <li {if $n==5} class="item mr_0"{else} class="item"{/if}>
                            <a href="{$p['url']}">
                                <div class="img-area"><img src="{Common::img($p['litpic'],224,152)}" alt=""></div>
                                <div class="name">{$p['title']}</div>
                            </a>
                        </li>
                        {/loop}

                    </ul>
                </div>
            </div>
            {/if}
            <!-- 看相册 -->
            {if $channel['jieban']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['jieban']['channelname']}</span>
                    <a href="{$cmsurl}jieban" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <ul class="jieban-list-group clearfix">
                        {st:jieban action="query" flag="order" row="4"}
                        {loop $data $row}
                        <li {if $n==4} class="item mr_0"{else}{/if}>
                            <a href="{$row['url']}" class="">
                                {if strtotime($row['startdate']) < time()}
                                <div class="status">已成团</div>
                                {/if}
                                <div class="img-area"><img src="{Common::img($row['litpic'],253,172)}" alt="" class=""></div>
                                <div class="info-area">
                                    <h4 class="tit">{$row['title']}</h4>
                                    <div class="user"><img src="{$row['memberpic']}" alt="">{$row['nickname']}</div>
                                    <div class="data-bar">
                                        <span class="item">剩余时间：<span class="num">{$row['leftday']}</span>天</span>
                                        <span class="item fr">已有<span class="num">{$row['joinnum']}</span>人加入</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        {/loop}

                    </ul>
                </div>
            </div>
            {/if}
            <!-- 结伴 -->
            {if $channel['notes']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['notes']['channelname']}</span>
                    <a href="{$cmsurl}notes" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <ul class="travel-notes-group clearfix">
                        {st:notes action="query" flag="order" row="4"}
                        {loop $data $row}
                        {if $n ==1}
                        <li class="item first">
                        {elseif $n==2}
                        <li class="item second">
                        {elseif $n==3}
                        <li class="item third">
                        {else}
                        <li class="item fourth">
                        {/if}
                            <a href="{$row['url']}">
                                {if $n ==1 || $n == 4}
                                <div class="img-area"><img src="{Common::img($row['litpic'],470,320)}" alt=""></div>
                                {else}
                                <div class="img-area"><img src="{Common::img($row['litpic'],224,152)}" alt=""></div>
                                {/if}
                                <div class="info-area">
                                    <h4 class="tit">{$row['title']}</h4>
                                    <div class="user">
                                        <img src="{$row['memberpic']}" alt="" class="">
                                        <span class="name">{$row['nickname']}</span>
                                        <span class="date">{$row['description']}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        {/loop}
                    </ul>
                </div>
            </div>
            {/if}
            <!-- 看游记 -->
            {if $channel['article']['isopen']==1}
            <div class="column-container">
                <div class="column-bar">
                    <span class="col-title">{$channel['article']['channelname']}</span>
                    <ul class="tab-group">
                        <li>热门攻略</li>
                        <li>最新攻略</li>
                    </ul>
                    <a href="{$cmsurl}raiders/all" class="more-link">更多<i class="more-icon"></i></a>
                </div>
                <div class="column-wrapper clearfix">
                    <div class="tab-box">

                        <ul class="strategy-list-group clearfix">
                            {st:article action="query" flag="order" row="4" return="articlelist"}
                            {loop $articlelist $a}
                            <li {if $n==4} class="mr_0"{else}{/if}>
                                <a href="{$a['url']}">
                                    <div class="img-area">
                                        <img src="{Common::img($a['litpic'],285,193)}" alt="">
                                        <span class="date">{date('Y-m-s',$a['modtime'])}</span>
                                    </div>
                                    <div class="info-area">
                                        <h4 class="tit">{$a['title']}</h4>
                                        <div class="line-bar"></div>
                                        <div class="txt">{if !empty($a['summary'])}{Common::cutstr_html($a['summary'],50)}{else}{Common::cutstr_html($a['content'],50)}{/if}</div>
                                    </div>
                                </a>
                            </li>
                            {/loop}
                        </ul>
                        <ul class="strategy-list-group clearfix">
                            {st:article action="query" flag="new" row="4" return="articlelist"}
                            {loop $articlelist $a}
                            <li {if $n==4} class="mr_0"{else}{/if}>
                            <a href="{$a['url']}">
                                <div class="img-area">
                                    <img src="{Common::img($a['litpic'],285,193)}" alt="">
                                    <span class="date">{date('Y-m-s',$a['modtime'])}</span>
                                </div>
                                <div class="info-area">
                                    <h4 class="tit">{$a['title']}</h4>
                                    <div class="line-bar"></div>
                                    <div class="txt">{if !empty($a['summary'])}{Common::cutstr_html($a['summary'],50)}{else}{Common::cutstr_html($a['content'],50)}{/if}</div>
                                </div>
                            </a>
                            </li>
                            {/loop}
                        </ul>
                    </div>
                </div>
            </div>
            {/if}
            <!-- 做攻略 -->

        </div>
    </div>

        {request 'pub/footer'}
        {request "pub/flink/isindex/1"}
    <!-- 底部编辑 -->



	<script>

        $(function(){

            //关闭广告
            $('.top-closed').on('click',function(){
                $(this).parent('.top-column-banner').hide();
            });

            //城市站点
            $(".head_start_city").hover(function(){
                $(this).addClass("change_tab");
            },function(){
                $(this).removeClass("change_tab");
            });

            //选择搜索栏目
            $('.search-term').hover(function(){
                $('#searchDownSelect').removeClass('hide')
            },function(){
                $('#searchDownSelect').addClass('hide')
            });
            $('#searchDownSelect').on('click', 'li', function(){
                $('#searchDownSelect').addClass('hide');
                $('#currentItemVal').text($(this).text())
            });

            //搜索框获取焦点tag隐藏
            $('#topSearchIpt').on('click', function(e){
                $('#topSearchTag').hide();
                if($('#stHotDestBox').css('display') == 'none'){
                    $('#stHotDestBox').show();
                }
                $(document).on('click',function(e){
                    if(e.target !== $('#stHotDestBox')[0]){
                        $('#stHotDestBox').hide();
                    }
                });
                e.stopPropagation();
            });

            $('#stHotDestBox').on('click',function(e){
                e.stopPropagation();
            });

            //搜索框失去焦点判断有无值
            $('#topSearchIpt').on('blur', function(){
                if($(this).val() !== ''){
                    $('#topSearchTag').hide()
                }
                else{
                    $('#topSearchTag').show()
                }
            });

            //主导航
            get_width();
            $(window).resize(function() {
                get_width();
            });

            //全局导航
            $('.global-nav-group').hover(function(){
                $(this).children('.global-nav-bd').show()
            },function(){
                $(this).children('.global-nav-bd').hide()
            });

            //轮播图
            var BannerSwiper = new Swiper ('.st-banner-container', {
                autoplay:5000,
                pagination: '.st-banner-container .swiper-pagination',
                paginationClickable: true,
                observer:true,
                observeParents:true,
                autoplayDisableOnInteraction : false
            });

            $(document).on('mouseover mouseout','.st-banner-container .swiper-pagination-bullet',function(event) {
                if(event.type == 'mouseover'){
                    $(this).click()
                }
                else if(event.type == 'mouseout'){
                    BannerSwiper.startAutoplay()
                }
            });

            //滚动订单列表
            var newOrderBar = new Swiper ('.new-order-bar', {
                autoplay: 2000,
                direction : 'vertical',
                speed: 500,
                loop: true,
                observer: true,
                observeParents: true,
                autoplayDisableOnInteraction : false
            });

            $('.new-order-bar').hover(function(){
                newOrderBar.stopAutoplay()
            },function(){
                newOrderBar.startAutoplay()
            });

            //线路切换
            $('.column-container').slide({
                titCell: '.tab-group li',
                mainCell: '.tab-box',
                trigger: 'click',
                effect: 'fold',
                delayTime: 0
            });

        });

        function get_width() {

            var offsetLeft = new Array();
            var windowWidth = $(window).width();

            //设置"down-nav"宽度为浏览器宽度
            $(".down-nav").width($(window).width());

            $(".header-menu li").hover(function() {

                var liWidth = $(this).width() / 2;

                $(this).addClass("this-hover");
                offsetLeft = $(this).offset().left;
                //获取当前选中li下的sub-list宽度
                var sub_list_width = $(this).children(".down-nav").children(".sub-list").width();
                $(this).children(".down-nav").children(".sub-list").css("width", sub_list_width);

                $(this).children(".down-nav").css("left", -offsetLeft);
                $(this).children(".down-nav").children(".sub-list").css("left", offsetLeft - sub_list_width / 2 + liWidth);

                var offsetRight = windowWidth - offsetLeft;

                var side_width = (windowWidth - 1200) / 2;

                if(sub_list_width > offsetRight) {
                    $(this).children(".down-nav").children(".sub-list").css({
                        "left": offsetLeft - sub_list_width / 2 + liWidth,
                        "right": side_width,
                        "width": "auto"
                    });
                }

                if(side_width > offsetLeft - sub_list_width / 2 + liWidth) {
                    $(this).children(".down-nav").children(".sub-list").css({
                        "left": side_width,
                        "right": side_width,
                        "width": "auto"
                    });
                }

            }, function() {

                $(this).removeClass("this-hover");

            });

        }

	</script>

</body>

</html>