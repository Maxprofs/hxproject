<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head bottom_margin=gxQzDt >
<meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    {include "pub/varname"}
    {Common::css_plugin('youji.css','notes')}
    {Common::css('base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,template.js,delayLoading.min.js')}
</head>
<body>

	{request "pub/header"}
  
	<div class="big bgcolor_pa20">
  	<div class="yj_top_fb">
        {st:ad action="getad" name="NoteTopAd" pc="1" row="1" return="ad"}
        {if !empty($ad)}
            <a class="travel-ad-img" {if !empty($ad['adlink'])}href="{$ad['adlink']}"{else}href="javascript:;"{/if} target="_blank"><img src="{$ad['adsrc']}" alt="{$ad['adname']}"></a>
        {else}
            <a class="travel-ad-img" href="javascript:;" target="_blank"><img src="{$GLOBALS['cfg_plugin_notes_public_url']}/images/user_youji_bg.png"></a>
        {/if}
        <a class="travel-notes-btn" href="/notes/write"><i class="travel-notes-icon"></i>发表新游记</a>
    </div>
  </div>
  
  <div class="big">
  	<div class="wm-1200">
    	
      <div class="user_yj_con">
      	
        <div class="slide_lm">
        	
          <div class="lm_tj">
          	<h3><strong>{$total_notes}</strong>篇游记攻略</h3>
            <span>讲述精彩旅行故事</span>
          </div>
          
          <div class="user_ph">
          	<h3><strong>达人排行榜</strong>看旅游达人分享经历</h3>
            <div class="ph_list">
            	<ul>
                {st:notes action="daren" row="5"}
                    {loop $data $row}
                        <li>
                            <strong class="pic">
                                {if $n==1}
                                <i class="bgico_f5">{$n}</i>
                                {elseif $n==2}
                                <i class="bgico_f6">{$n}</i>
                                {elseif $n==3}
                                <i class="bgico_fb">{$n}</i>
                                {else}
                                <i class="bgico_fa">{$n}</i>
                                {/if}
                                <img src="{Common::img($row['m_litpic'])}" width="56" height="56" /></strong>
                          <p>
                                <span class="name">{$row['nickname']}</span>
                            <span class="js">{$row['remarks']}</span>
                          </p>
                        </li>
                    {/loop}
                {/st}
              </ul>
            </div>
          </div><!--达人排行榜-->
          
          <div class="youji_ph">
          	<h3><strong>热门游记排行</strong>看旅游达人分享经历</h3>
            <div class="ph_list">
            	<ul>
                {st:notes action="query" flag="hot" row="5" return="hotlist"}

                    {loop $hotlist $hot}
                    <a class="fl" href="{$hot['url']}" target="_blank">

                    <li>
                            <strong class="num{$n}">{$n}</strong>
                          <p>
                                <span class="name">{$hot['title']}</span>
                            <span class="js">{$hot['description']}</span>
                          </p>
                        </li>
                    </a>
                    {/loop}

              </ul>
            </div>
          </div><!--热门攻略排行-->

         {st:ad action="getad" name="NotesLeftAd1" pc="1" return="ad1"}
            {if !empty($ad1)}
          <div class="pic_ad">
          	<a class="fl" href="{$ad1['adlink']}"><img class="fl" src="{Common::img($ad1['adsrc'],263,150)}" alt="{$ad1['adname']}"/></a>
          </div>
            {/if}
         {/st}
          
          <div class="new_ph">
          	<h3><strong>最新攻略</strong>看旅游达人分享经历</h3>
            <div class="ph_list">
                {st:notes action="query" flag="new" row="5" return="newarc"}
                {loop $newarc $new}
                    <dl>
                        <dt><img src="{Common::img($new['litpic'],48,48)}" alt="{$new['title']}" width="48" height="48" /></dt>
                        <dd>
                            <a href="{$new['url']}" target="_blank">{$new['title']}</a>
                            <p>{Common::cutstr_html($new['description'],10)}</p>
                            <span>{Common::mydate('Y-m-d',$new['modtime'])}</span>
                        </dd>
                    </dl>
                {/loop}

            </div>
          </div><!--最新攻略-->
          
        </div>
        
        <div class="main_con">
        
        	<div class="dj_hot_box">
          	<div class="dj_tit">
            	<h3>本季热门</h3>
              <span>看旅游达人分享经历</span>
             <!-- <p>
                {st:dest action="query" flag="hot" row="3" return="hotdest"}
                  {loop $hotdest $h}
              	    <a href="/{$h['pinyin']}/" target="_blank">{$h['kindname']}</a>
                  {/loop}

                <a href="/destination/" class="more">更多&gt;&gt;</a>
              </p>-->
            </div>
            <div class="dj_con">
                {st:notes action="query" flag="season" row="9" return="seasonarc"}
            	<ul class="top_list">
                    {loop $seasonarc $sarc}
                        {if $n<4}
                            <li {if $n==3}class="mr_0"{/if}>
                                <i><img class="fl" src="{Common::img($sarc['memberpic'],60,60)}" alt="{$sarc['title']}" /></i>
                                <a class="pic" href="{$sarc['url']}" target="_blank"><img src="{Product::get_lazy_img()}" st-src="{Common::img($sarc['litpic'],280,189)}" alt="{$sarc['title']}"/></a>
                              <p class="tit"><a href="{$sarc['url']}" target="_blank">{$sarc['title']}</a></p>
                              <p class="txt">{$sarc['description']}</p>
                              <p class="msg">
                                <span class="name">{$sarc['nickname']}</span>
                                <span class="time">{Common::mydate("Y-m-d",$sarc['modtime'])}</span>
                              </p>
                            </li>
                        {/if}
                    {/loop}

              </ul>
              <ul class="bom_list">
                  {loop $seasonarc $sarc}
                  {if $n>3}
                    <li {if ($n==5 || $n==7 || $n==9)}class="mr_0"{/if}>
                      <div class="pic"><a href="{$sarc['url']}" target="_blank"><img src="{Product::get_lazy_img()}" st-src="{Common::img($sarc['litpic'],140,95)}" alt="{$sarc['title']}"/></a></div>
                      <div class="box_t">
                        <a class="tit" href="{$sarc['url']}" target="_blank">{$sarc['title']}</a>
                        <p class="txt">{$sarc['description']}</p>
                        <p class="msg">
                            <span class="name"><img class="fl" src="{Common::img($sarc['memberpic'],26,26)}" alt="asdf" width="26" height="26" />{$sarc['nickname']}</span>
                            <span class="time">{Common::mydate("Y-m-d",$sarc['modtime'])}</span>
                        </p>
                      </div>
                    </li>
                  {/if}
                  {/loop}

              </ul>
            </div>
          </div><!--本季热门-->
          
          <div class="dr_hot_box">
          	<div class="dr_tit">
            	<h3>达人攻略</h3>
              <span>看旅游达人分享经历</span>
              <!--<p>
                  {loop $hotdest $h}
                    <a href="/{$h['pinyin']}/" target="_blank">{$h['kindname']}</a>
                  {/loop}
                <a href="/destination/" class="more">更多&gt;&gt;</a>
              </p> -->
            </div>
            <div class="dt_con">
            	<ul id="list_contain">

              </ul>
            </div>
            <div  id="pageinfo" style="text-align: right">

            </div>
          </div><!--达人攻略-->
        
        </div>
        
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
    <script type="text/html" id="tpl_notes">
        <ul class="st-cp-list">
            {{each list as value i}}

                <li>
                    <div class="pic">
                        <a href="{{value.url}}" target="_blank"><img src="{{value.litpic}}" alt="{{value.title}}"></a>
                    </div>
                    <div class="box_t">
                        <a class="tit" href="{{value.url}}">{{value.title}}</a>
                        <p class="txt">{{value.description}}</p>
                        <p class="msg">
                            <span class="name"><img class="fl" src="{{if value.memberpic}}{{value.memberpic}}{{else}}/res/images/member_nopic.png{{/if}}" width="26" height="26">{{value.nickname}}</span>
                            <span class="time">{{value.pubdate}}</span>
                        </p>
                    </div>
                    <div class="num">
                        <span>{{value.shownum}}</span>人<br>已阅读
                    </div>
                </li>
            {{/each}}
        </ul>

    </script>

    {request "pub/footer"}
    {request "pub/flink"}
<script src="/res/js/laypage/laypage.js"></script>
<script>


    $(function(){
        var pagesize = 6 //显示条数
        var total_count = {$total_notes};
        var totalPageNumber = Math.ceil(total_count/pagesize);
        layPage(totalPageNumber,1);
    })

    function layPage(pagenum,currentpage){
        //分页
        var ajaxUrl = SITEURL+'notes/ajax_get_new_notes';
        laypage({
            cont: 'pageinfo', //页码显示容器。【如该容器为】：<div id="page1"></div>
            pages: pagenum, //通过后台拿到的总页数
            curr: currentpage, //初始化当前页
            next:false,
            skin:'#00a0e9',
            jump: function(e){ //触发分页后的回调

                $.getJSON(ajaxUrl, {curr: e.curr}, function(res){
                    //渲染
                    var view = $('#list_contain');
                    var licontent = template('tpl_notes',res);
                    view.html(licontent);
                });

            }
        });
    }
</script>
</body>
</html>
