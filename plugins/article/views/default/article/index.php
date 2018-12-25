<?php defined('SYSPATH') or die();?>
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
    {include "pub/varname"}
    {Common::css_plugin('gonglue.css','article')}
    {Common::css('base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,template.js,delayLoading.min.js')}
</head>
<body>
{request "pub/header"}
  
  <div class="st-gl-home-top">
    
    <div id="st-gl-slideBox" class="st-gl-slideBox">
      <div class="hd">
        <ul>
            {st:ad action="getad" name="ArticleRollingAd" pc="1" return="articlead"}
            {loop $articlead['aditems'] $k $v}
            <li>{$k}</li>
            {/loop}
        </ul>
      </div>
      <div class="bd">
        <ul>
            {loop $articlead['aditems'] $v}
             <li><a href="{$v['adlink']}" target="_blank"><img src="{Product::get_lazy_img()}" original-src="{Common::img($v['adsrc'],1920,380)}" alt="{$v['adname']}" /></a></li>
            {/loop}
        </ul>
      </div>
      <!--前/后按钮代码-->
      <a class="prev" href="javascript:void(0)"></a>
      <a class="next" href="javascript:void(0)"></a>
    </div><!--酒店首页焦点图-->
    
  </div>   
  
  <div class="big">
  	<div class="wm-1200">
    	<div class="st-guide">
            <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&nbsp;&gt;&nbsp;<strong title="{$channelname}">{$channelname}</strong>
        </div><!--面包屑-->
      <div class="st-main-page">
        <div class="st-gl-home-list">
          <ul>

           {st:article action="query" flag="order" row="4" return="arclist"}
            {loop $arclist $arc}
            <li {if $n%4==0}class="mr_0"{/if}>
              <div class="tj-tb"></div>
              <div class="pic">
                <img src="{Product::get_lazy_img()}" st-src="{Common::img($arc['litpic'],283,190)}" alt="{$arc['title']}" />
                <div class="buy"><a href="{$arc['url']}" target="_blank">查看详情</a></div>
              </div>
              <div class="js">
                <a href="{$arc['url']}" target="_blank" title="{$arc['title']}" class="tit">{$arc['title']}</a>
                <p class="txt">{if !empty($arc['summary'])}{Common::cutstr_html($arc['summary'],20)}{else}{Common::cutstr_html($arc['content'],20)}{/if}</p>
              </div>
            </li>
            {/loop}
          {/st}
          </ul>
        </div>
          {st:dest action="query" flag="channel_nav" typeid="$typeid" row="5" return="destlist"}
          {php}$index=0;{/php}
              {loop $destlist $dest}
              <div class="st-slideTab">
               <div class="st-gl-dest-module">
                  <div class="st-tabnav">
                    <h3>{$dest['kindname']}</h3>
                        <span data-id="{$dest['id']}" class="on" data-url="/raiders/{$dest['pinyin']}/">热门<i></i></span>
                        {st:dest action="query" flag="next" typeid="$typeid" pid="$dest['id']" row="6" return="nextdest"}
                            {loop $nextdest $nr}
                            <span data-id="{$nr['id']}" data-url="/raiders/{$nr['pinyin']}/">{$nr['kindname']}<i></i></span>
                            {/loop}
                        {/st}

                    <a href="/raiders/{$dest['pinyin']}/" class="more">更多{$channelname}</a>
                  </div>
                   <div class="st-tabcon">
                       <ul>
                           {st:article action="query" flag="mdd" destid="$dest['id']" row="7" return="arclist"}
                           {php}$autoindex=1;{/php}
                           {loop $arclist $a}
                           {if $autoindex==1}
                           <li class="list-pic">
                               <i class="hot-ico">HOT</i>
                               <a class="pic" href="{$a['url']}" target="_blank"><img src="{Product::get_lazy_img()}" st-src="{Common::img($a['litpic'],360,245)}" alt="{$a['title']}" /></a>
                               <a class="tit" href="{$a['url']}" target="_blank" title="{$a['title']}">{$a['title']}</a>
                               <p class="txt">{if !empty($a['summary'])}{Common::cutstr_html($a['summary'],40)}{else}{Common::cutstr_html($a['content'],40)}{/if}</p>
                           </li>
                           {else}
                           <li class="list-txt{if $autoindex>5} mb_0{/if}">
                               <a class="tit" href="{$a['url']}" target="_blank" title="{$a['title']}">{$a['title']}</a>
                               <p class="txt">{if !empty($a['summary'])}{Common::cutstr_html($a['summary'],40)}{else}{Common::cutstr_html($a['content'],40)}{/if}</p>
                           </li>

                           {/if}
                           {php}$autoindex++;{/php}
                           {/loop}
                       </ul>
                   </div>
              {loop $nextdest $ad}
               <div class="st-tabcon">
                <ul>
                    {st:article action="query" flag="mdd" destid="$ad['id']" row="7" return="arclist"}
                    {php}$autoindex=1;{/php}
                    {loop $arclist $a}
                     {if $autoindex==1}
                       <li class="list-pic">
                        <i class="hot-ico">HOT</i>
                        <a class="pic" href="{$a['url']}" target="_blank" title="{$a['title']}"><img src="{Product::get_lazy_img()}" st-src="{Common::img($a['litpic'],360,245)}" alt="{$a['title']}" /></a>
                        <a class="tit" href="{$a['url']}" target="_blank" title="{$a['title']}">{$a['title']}</a>
                        <p class="txt">{if !empty($a['summary'])}{Common::cutstr_html($a['summary'],40)}{else}{Common::cutstr_html($a['content'],40)}{/if}</p>
                       </li>
                     {else}
                        <li class="list-txt{if $autoindex>5} mb_0{/if}">
                        <a class="tit" href="{$a['url']}" target="_blank" title="{$a['title']}">{$a['title']}</a>
                        <p class="txt">{if !empty($a['summary'])}{Common::cutstr_html($a['summary'],40)}{else}{Common::cutstr_html($a['content'],40)}{/if}</p>
                        </li>
                     {/if}
                     {php}$autoindex++;{/php}
                    {/loop}
                </ul>
              </div>
              {/loop}
            </div><!-- 分类攻略 -->
              </div>
              {/loop}
          {/st}
        </div>

        <!--栏目介绍-->
        {if !empty($seoinfo['jieshao'])}
        <div class="st-comm-introduce">
            <div class="st-comm-introduce-txt">
                {$seoinfo['jieshao']}
            </div>
        </div>
        {/if}

      </div>
    
    </div>


{request "pub/footer"}
{request "pub/flink"}
{Common::js("fcous.js,slideTabs.js")}

</body>
<script>
    $(function(){
        //攻略首页焦点图
        $('.st-gl-slideBox').slide({mainCell:'.bd ul',easing:'easeOutCirc',autoPlay:true, switchLoad:'original-src'})
        $('.st-slideTab').switchTab()
        $('.st-tabnav').find('span').click(function(){

            var urlmore = $(this).attr("data-url");
            $(this).parent().find('.more').attr('href',urlmore);

        })

    })


</script>
</html>
