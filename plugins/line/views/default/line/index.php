<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head head_script=0GACXC >
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    {include "pub/varname"}
    {Common::css_plugin('lines.css','line')}
    {Common::css('base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,template.js,delayLoading.min.js')}
</head>
<body>
  {request "pub/header"}
  <div class="big">
  	<div class="wm-1200">
    	<div class="st-guide">
      	  <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{$channelname}
        </div><!--面包屑-->
      <div class="st-line-home-top">

      	<div class="st-line-dh">
          <div class="st-dh-con">
          	<h3 class="item-bar">
              <a href="javascript:;" class="parent-tit">旅游目的地<i class="more-ico"></i></a>
              <p class="parent-box">
                {st:dest action="query" flag="channel_nav" typeid="1" row="6" return="linedestlist"}
              	 {loop $linedestlist $row}
                  <a href="{$cmsurl}lines/{$row['pinyin']}/" class="child" target="_blank">{$row['kindname']}</a>
                 {/loop}
              </p>
            </h3>
            <div class="st-dh-item">
                {php $lk = 1;}
                {loop $linedestlist $d}
            	<dl>
              	<dt><a href="{$cmsurl}lines/{$d['pinyin']}/" target="_blank">{$d['kindname']}</a></dt>
                <dd>
                    {st:dest action="query" flag="next" typeid="$typeid" pid="$d['id']" row="30" return="nextd"}
                     {loop $nextd $nd}
                	    <a href="{$cmsurl}lines/{$nd['pinyin']}/">{$nd['kindname']}</a>
                     {/loop}

                </dd>
              </dl>
                {if $lk%2==0}<div class="clear"></div>{/if}
                {php $lk++;}

               {/loop}

            </div>
          </div>


            {st:attr action="query" typeid="$typeid" flag="grouplist" row="3"}
              {loop $data $row}
             <div class="st-dh-con">
                <h3>
                  <a href="javascript:;" class="parent-tit">{$row['attrname']}</a>
                  <p class="parent-box">
                      {st:attr action="query" typeid="1" flag="childitem" groupid="$row['id']" typeid="$typeid" row="5" return="subdata"}
                          {loop $subdata $r}
                          <a href="{$cmsurl}lines/all-0-0-0-0-0-{$r['id']}-1" class="child">{$r['attrname']}</a>
                          {/loop}
                      {/st}
                  </p>
                </h3>
              </div>
              {/loop}
            {/st}

        </div><!--线路分类导航-->

        <div id="st-line-slideBox" class="st-line-slideBox">
          <div class="hd">
            <ul>
              {st:ad action="getad" name="LineRollingAd" pc="1" return="linead"}
                {loop $linead['aditems'] $k $v}
                 <li>$k</li>
                {/loop}

            </ul>
          </div>
          <div class="bd">
            <ul>
             {loop $linead['aditems'] $v}
              <li><a href="{$v['adlink']}" target="_blank"><img src="{Product::get_lazy_img()}" original-src="{Common::img($v['adsrc'],858,324)}" alt="{$v['adname']}" /></a></li>
             {/loop}
            </ul>
          </div>
          <!--前/后按钮代码-->
          {if count($linead['aditems']) > 1}
          <a class="prev" href="javascript:void(0)"></a>
          <a class="next" href="javascript:void(0)"></a>
          {/if}
        </div><!--线路首页焦点图-->

      </div>
        <!--栏目介绍-->
        {if !empty($seoinfo['jieshao'])}
        <div class="st-comm-introduce">
            <div class="st-comm-introduce-txt">
                {$seoinfo['jieshao']}
            </div>
        </div>
        {/if}

      <div class="st-line-home-lsit">

        {st:dest action="query" flag="channel_nav" typeid="1" row="6" return="destlist"}
          {php}$autoindex=0;{/php}
          {loop $destlist $dest}
            <div class="st-cp-slideTab">
              <div class="st-tabnav">
                <h3>{$dest['kindname']}</h3>
                        <span data-id="{$dest['id']}" data-url="/lines/{$dest['pinyin']}/">热门<i></i></span>
                 {st:dest action="query" flag="next" typeid="$typeid" pid="$dest['id']" row="6" return="nextdest"}
                    {loop $nextdest $nr}
                        <span data-id="{$nr['id']}" data-url="/lines/{$nr['pinyin']}/">{$nr['kindname']}<i></i></span>
                    {/loop}
                 {/st}
                <a href="/lines/{$dest['pinyin']}/" class="more">更多</a>
              </div>
              <div class="st-line-slidemenu">
                <div class="slidemenu-list">
                    <dl>
                    <dt>热门目的地</dt>
                    <dd>
                        {st:dest action="query" flag="hot" typeid="$typeid" destid="$dest['id']" row="10" return="hotdest"}
                            {loop $hotdest $hr}
                                 <a href="{$cmsurl}lines/{$hr['pinyin']}/">{$hr['kindname']}</a>
                            {/loop}
                        {/st}
                    </dd>
                  </dl>
                </div>
                <div class="slidemenu-adbg">
                    {st:ad action="sortad" index="$autoindex" pc="1" adname="LineIndex_LeftAd1,LineIndex_LeftAd2,LineIndex_LeftAd3,LineIndex_LeftAd4,LineIndex_LeftAd5,LineIndex_LeftAd6" return="pluginad" row="1"}

                        {if !empty($pluginad)}
                         {if !empty($pluginad['adlink'])}
                             <a href="{$pluginad['adlink']}" target="_blank"><img src="{Product::get_lazy_img()}" st-src="{Common::img($pluginad['adsrc'],279,610)}" title="{$pluginad['adname']}" alt="{$pluginad['adname']}" /></a>
                         {else}
                            <img src="{Product::get_lazy_img()}" st-src="{Common::img($pluginad['adsrc'],279,610)}" title="{$pluginad['adname']}" alt="{$pluginad['adname']}" />
                         {/if}
                        {/if}

                    {/st}

                </div>
              </div>
              <div class="st-tabcon">
                <ul class="st-cp-list">
                    {st:line action="query" flag="mdd" destid="$dest['id']" row="6" return="linelist"}
                      {loop $linelist $line}
                         <li>
                            <div class="pic">
                              <img src="{Product::get_lazy_img()}" st-src="{Common::img($line['litpic'],283,193)}" alt="{$line['title']}" title="{$line['title']}"/>
                              <div class="buy"><a href="{$line['url']}" title="{$line['title']}">立即预订</a></div>
                            </div>
                            <div class="js">
                              <a class="tit" href="{$line['url']}" target="_blank" title="{$line['title']}">{if $line['color']}<span style="color:{$line['color']}">{$line['title']}</span>{else}{$line['title']}{/if}</a>
                              <p class="attr">
                                  {if $GLOBALS['cfg_icon_rule']==1}
                                  {loop $line['iconlist'] $ico}
                                  <span>{$ico['kind']}</span>
                                  {/loop}
                                  {else}
                                  {loop $line['iconlist'] $ico}
                                    <img src="{$ico['litpic']}" />
                                  {/loop}
                                  {/if}

                              </p>
                              <p class="num">
                                {if $line['sellprice']}
                                 <del>原价：<i class="currency_sy">{Currency_Tool::symbol()}</i>{$line['sellprice']}</del>
                                {/if}
                                {if $line['price']}
                                  <span><b><i class="currency_sy">{Currency_Tool::symbol()}</i>{$line['price']}</b>起</span>
                                {else}
                                  <span><b>电询</b></span>
                                {/if}
                              </p>
                            </div>
                          </li>
                      {/loop}
                    {/st}

                </ul>
              </div>
            </div>
            <div class="st-list-sd">
                {st:ad action="sortad" index="$autoindex" pc="1" adname="LineIndex_BottomAd1,LineIndex_BottomAd2,LineIndex_BottomAd3,LineIndex_BottomAd4,LineIndex_BottomAd5,LineIndex_BottomAd6" return="bottomad"}
                    {if !empty($bottomad)}
                       {if !empty($bottomad['adlink'])}
                        <a href="{$bottomad['adlink']}" target="_blank"><img src="{Common::img($bottomad['adsrc'],1200,110)}" title="{$bottomad['adname']}" alt="{$bottomad['adname']}" /></a>
                       {else}
                            <img src="{Common::img($bottomad['adsrc'],1200,110)}" title="{$bottomad['adname']}" alt="{$bottomad['adname']}" />
                       {/if}
                    {/if}
                {/st}
            </div><!--广告-->
           {php}$autoindex++;{/php}
          {/loop}
        {/st}


      </div><!--列表结束-->

    </div>
  </div>


 {request "pub/footer"}
 {request "pub/flink"}

<script type="text/html" id="tpl_line">
    <ul class="st-cp-list">
   {{each list as value i}}

    <li>
        <div class="pic">
            <img class="fl" src="{{value.litpic}}" alt="{{value.title}}" title="{{value.title}}" width="285" height="190" />
            <div class="buy"><a href="{{value.url}}" title="{{value.title}}">立即预订</a></div>
        </div>
        <div class="js">
            <a class="tit" href="{{value.url}}" title="{{value.title}}" target="_blank">{{if value.color}}<span style="color:{{value.color}}">{{value.title}}</span>{{else}}{{value.title}}{{/if}}</a>
            <p class="attr">

                {{each value.iconlist as ico k}}
                    <img src="{{ico['litpic']}}" />
                {{/each}}
            </p>
            <p class="num">

                {{if value.sellprice>0}}
                   <del>原价：<i class="currency_sy">{Currency_Tool::symbol()}</i>{{value.sellprice}}</del>
                {{/if}}

                {{if value.price>0}}
                  <span><b><i class="currency_sy">{Currency_Tool::symbol()}</i>{{value.price}}</b>起</span>
                {{else}}
                  <span><b>电询</b></span>
                {{/if}}
            </p>
        </div>
    </li>
    {{/each}}
    </ul>

</script>

<script>
    $(function(){
            var url = SITEURL+'line/ajax_index_line';
            console.log(url);
                            $.getJSON(url, {destid:destid,pagesize:6}, function(data) {

                    var licontent = template('tpl_line',data);
                    concontain.html(licontent);
                    concontain.data(destid,licontent);
                });
        //线路首页焦点图
        $('.st-line-slideBox').slide({
					mainCell:'.bd ul',
					effect:"fold",
					interTime: 5000,
					delayTime: 500,
					autoPlay:true,
                    switchLoad:'original-src'
				})

        //选中第一个选项
        $('.st-tabnav').each(function(i,obj){
            $(obj).find('span').first().addClass('on');
        })

        $('.st-tabnav').find('span').click(function(){
            var destid = $(this).attr('data-id');
            var url = SITEURL+'line/ajax_index_line';
            var content = $(this).data(destid);
            var concontain = $(this).parents('.st-cp-slideTab').first().find('.st-tabcon');
            $(this).addClass('on').siblings().removeClass('on');
            var urlmore = $(this).attr("data-url");
            $(this).parent().find('.more').attr('href',urlmore);

            concontain.html('<img src="/res/images/loading.gif" style="display:block;width:28px;height:28px;margin:160px auto 157px auto;">');
            if(content){
                concontain.html(content);
            }else{
                $.getJSON(url, {destid:destid,pagesize:6}, function(data) {

                    var licontent = template('tpl_line',data);
                    concontain.html(licontent);
                    concontain.data(destid,licontent);
                });

            }

        })
    })
</script>
</body>
</html>