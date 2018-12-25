<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <title>{if $is_all}旅游攻略大全_热门旅游攻略_旅游资讯-{$GLOBALS['cfg_webname']}{else}{$searchtitle}{/if}</title>
    {$destinfo['keyword']}
    {$destinfo['description']}
    {include "pub/varname"}
    {Common::css_plugin('gonglue.css','article')}
    {Common::css('base.css,extend.css')}
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
      	
      	<div class="st-gl-list-box">
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
            <div class="been-tj" {if count($chooseitem)<1}style="display:none"{/if}>
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
                            <a href="{$cmsurl}raiders/{$dest['pinyin']}/">{$dest['kindname']}</a>
                          {/loop}
                      {/st}
                      {if count($destlist)>10}
                        <em><b>收起</b><i class='up'></i></em>
                      {/if}
                  </p>
                </dd>
              </dl>
                <!--属性组读取-->
                {st:attr action="query" flag="grouplist" typeid="$typeid" return="grouplist"}
                {loop $grouplist $group}
                <dl class="type">
                    <dt>{$group['attrname']}：</dt>
                    <dd>
                        <p>
                            {st:attr action="query" flag="childitem" typeid="$typeid" groupid="$group['id']" return="attrlist"}
                            {loop $attrlist $attr}
                            <a href="{Model_Article::get_search_url($attr['id'],'attrid',$param)}" {if Common::check_in_attr($param['attrid'],$attr['id'])!==false}class="on"{/if}>{$attr['attrname']}</a>
                            {/loop}
                            {/st}
                        </p>
                    </dd>
                </dl>
                {/loop}
                {/st}
            </div>
          </div><!-- 条件搜索 -->
          <div class="st-gl-list-con">
           {if !empty($list)}
          	<ul>
                {loop $list $a}
            	    <li>
                        <div class="pic"><i>HOT</i><a href="{$a['url']}" target="_blank" title="{$a['title']}"><img src="{Product::get_lazy_img()}" st-src="{Common::img($a['litpic'],320,218)}" alt="{$a['title']}" /></a></div>
                        <div class="con">
                          <p class="tit">
                              <a href="{$a['url']}" target="_blank" title="{$a['title']}">{$a['title']} </a>
                          </p>
                          <p class="attr">
                              {loop $a['attrlist'] $attr}
                                 <span>{$attr['attrname']}</span>
                              {/loop}

                          </p>
                          <p class="txt">{Common::cutstr_html($a['content'],300)}</p>
                          <p class="data">
                            <span class="num">{$a['shownum']}</span>
                            <span class="date">{Common::mydate('Y-m-d',$a['modtime'])}</span>
                          </p>
                        </div>
                    </li>
                {/loop}

            </ul>
            <div class="main_mod_page clear">
              {$pageinfo}
            </div><!-- 翻页 -->
          {else}
              <div class="no-content">
                  <p><i></i>抱歉，没有找到相关攻略！<a href="/raiders/all">查看全部攻略</a></p>
              </div>
          {/if}
          </div>
        </div>
      
      </div>
    
    </div>

{request "pub/footer"}

{request "pub/flink"}

<script>
    $(function(){
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

        //排序方式点击
        $('.sort-sum').find('a').click(function(){
            var url = $(this).find('i').attr('data-url');
            window.location.href = url;
        })
        //删除已选
        $(".chooseitem").find('i').click(function(){
            var url = $(this).parent().attr('data-url');
            window.location.href = url;
        })
        //清空筛选条件
        $('.clearc').click(function(){
            var url = SITEURL+'raiders/all/';
            window.location.href = url;
        })
        //隐藏没有属性下级分类
        $(".type").each(function(i,obj){
            var len = $(obj).find('dd p a').length;
            if(len<1){
                $(obj).hide();
            }
        })
    })

</script>

</body>
</html>
