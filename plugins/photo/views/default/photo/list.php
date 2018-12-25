<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head html_clear=zotJVl >
<meta charset="utf-8">
    <title>{$searchtitle}</title>
    {if $destinfo['keyword']}
       {$destinfo['keyword']}
    {/if}
    {if $destinfo['description']}
        {$destinfo['description']}
    {/if}
    {include "pub/varname"}
    {Common::css('base.css,extend.css')}
    {Common::css_plugin('photo.css','photo')}
    {Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js')}
</head>


<body>

{request "pub/header"}
  

  <div class="big">
  	<div class="wm-1200">

    <div class="st-guide">
        {st:position action="list_crumbs" destid="$destinfo['dest_id']" typeid="$typeid"}
    </div><!--面包屑-->
      
      <div class="st-photolist-box">
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
                      <a href="{$cmsurl}photos/{$dest['pinyin']}/">{$dest['kindname']}</a>
                      {/loop}
                      {/st}
                  </p>
                  {if count($destlist)>10}
                  <em><b>收起</b><i class='up'></i></em>
                  {/if}
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
                          <a href="{Model_Photo::get_search_url($attr['id'],'attrid',$param)}" {if Common::check_in_attr($param['attrid'],$attr['id'])!==false}class="on"{/if}>{$attr['attrname']}</a>
                          {/loop}
                          {/st}
                      </p>
                  </dd>
              </dl>
              {/loop}
              {/st}
          </div>
        </div><!--条件搜索-->
        <div class="photolist-con">
         {if empty($list)}
          <div class="no-content">
          	<p><i></i>抱歉，没有找到符合条件的产品！<a href="{$cmsurl}photos/all">查看全部产品</a></p>
          </div>
         {/if}
          <ul class="st-photolist">
           {loop $list $p}
          	<li {if $n%4==0}class="mr_0"{/if}>
            	<div class="pic">
            		<a href="{$p['url']}" target="_blank" title="{$p['title']}"><img src="{Product::get_lazy_img()}" st-src="{Common::img($p['litpic'],265,179)}" alt="{$p['title']}" /></a>
                <div class="num">
                  <span class="zan-on">{$p['favorite']}</span>
                	<span class="pl">{$p['commentnum']}</span>
                </div>
              </div>
              <div class="txt">
              	<a href="{$p['url']}" title="{$p['title']}" target="_blank">{Common::cutstr_html($p['title'],40)}</a>
                <span>({$p['photonum']}张)</span>
              </div>
            </li>
           {/loop}

          </ul>
          <div class="main_mod_page clear">
              {$pageinfo}
          </div><!--分页-->
        </div>
      </div><!--相册搜索列表-->
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
            var url = SITEURL+'photos/all/';
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

{request "pub/footer"}

{request "pub/flink"}

</body>
</html>
