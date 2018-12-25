<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <title>{if $is_all}租车预订_租车车型选择_租车价格-{$GLOBALS['cfg_webname']}{else}{$searchtitle}{/if}</title>
    {$destinfo['keyword']}
    {$destinfo['description']}
    {include "pub/varname"}
    {Common::css_plugin('car.css','car')}
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
      	<div class="st-carlist-box">
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
                            <a href="{$cmsurl}cars/{$dest['pinyin']}/">{$dest['kindname']}</a>
                            {/loop}
                            {/st}
                        </p>
                        {if count($destlist)>10}
                        <em><b>收起</b><i class='up'></i></em>
                        {/if}
                    </dd>
                </dl>
              <dl class="type">
                <dt>车型：</dt>
                <dd>
                	<p>
                        {st:car action="kind_list" row="10"}
                            {loop $data $kind}
                                <a href="{Model_Car::get_search_url($kind['id'],'carkindid',$param)}" {if $param['carkindid']==$kind['id']}class="on"{/if}>{$kind['title']}</a>
                            {/loop}
                        {/st}

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
                            <a href="{Model_Car::get_search_url($attr['id'],'attrid',$param)}" {if Common::check_in_attr($param['attrid'],$attr['id'])!==false}class="on"{/if}>{$attr['attrname']}</a>
                            {/loop}
                            {/st}
                        </p>
                    </dd>
                </dl>
                {/loop}
                {/st}
            </div>
          </div><!--条件搜索-->
          <div class="st-carlist-con">
          	<div class="st-sort-menu">
            	<span class="sort-sum">
              <a data-url="{Model_Car::get_search_url(0,'sorttype',$param)}">综合排序</a>
                  <a href="javascript:;">价格
                      {if $param['sorttype']!=1 && $param['sorttype']!=2}
                      <i class="jg-default" data-url="{Model_Car::get_search_url(1,'sorttype',$param)}"></i>
                      {/if}
                      {if $param['sorttype']==1}
                      <i class="jg-up" data-url="{Model_Car::get_search_url(2,'sorttype',$param)}"></i>
                      {/if}
                      {if $param['sorttype']==2}
                      <i class="jg-down" data-url="{Model_Car::get_search_url(0,'sorttype',$param)}"></i></a>
                    {/if}
                <a href="javascript:;">销量
                    {if $param['sorttype']!=3}
                    <i class="xl-default" data-url="{Model_Car::get_search_url(3,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==3}
                    <i class="xl-down" data-url="{Model_Car::get_search_url(0,'sorttype',$param)}"></i>
                    {/if}
                </a>
                <a href="javascript:;">推荐
                    {if $param['sorttype']!=4}
                    <i class="tj-default" data-url="{Model_Car::get_search_url(4,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==4}
                    <i class="tj-down" data-url="{Model_Car::get_search_url(0,'sorttype',$param)}"></i>
                    {/if}
                </a>
                <!-- 价格区间搜索 -->
                <select class="sel-price search-sel">
                    <option data-url="{Model_Car::get_search_url(0,'priceid',$param)}">价格区间</option>
                    {st:car action="price_list"}
                        {loop $data $r}
                            <option {if $param['priceid']==$r['id']}selected{/if}  data-url="{Model_Car::get_search_url($r['id'],'priceid',$param)}">{$r['title']}</option>
                        {/loop}
                    {/st}
                </select>
              </span><!--排序-->
            </div>
            <div class="car-list-con">
            {if !empty($list)}
                {loop $list $c}
                  <div class="list-child">

                    <div class="lc-image-text">
                        <div class="pic"><a href="{$c['url']}" target="_blank" title="{$c['title']}"><img src="{Product::get_lazy_img()}" st-src="{Common::img($c['litpic'],265,180)}" alt="{$c['title']}" /></a></div>
                      <div class="text">
                        <p class="bt">
                            <a href="{$c['url']}" target="_blank" title="{$c['title']}">{$c['title']}
                                {loop $c['iconlist'] $icon}
                                    <img src="{$icon['litpic']}" />
                                {/loop}
                            </a></p>
                        <p class="attr">
                          <span>销量：{$c['sellnum']}</span>
                          <span>满意度：{if $c['satisfyscore']}{$c['satisfyscore']}%{/if}</span>
                          <span>推荐：{$c['recommendnum']}</span>
                        </p>
                        <p class="js">推荐理由：{$c['sellpoint']}</p>
                        <p class="ads">车型：{$c['kindname']}</p>
                          {if $c['suppliername']}
                        <p class="gys">供应商：{$c['suppliername']}</p>
                          {/if}
                      </div>
                      <div class="lowest-jg">
                          {if $c['price']}
                            <span><i class="currency_sy">{Currency_Tool::symbol()}</i><b>{$c['price']}</b>起</span>
                          {else}
                            <span>电询</span>
                          {/if}
                      </div>
                    </div>
                    <div class="car-typetable">
                        <table width="100%" border="0">

                            {st:car action="suit_type" row="8" productid="$c['id']" return="typelist"}
                            {loop $typelist $type}

                            <tr>
                                <th width="320" height="40" scope="col"><span class="pl20">{$type['title']}</span></th>
                                <th width="100" scope="col">单位</th>
                                <th width="100" align="center" scope="col">优惠价</th>
                                <th width="120" scope="col">支付方式</th>
                                <th>&nbsp;</th>
                            </tr>
                            {st:car action="suit" row="10" productid="$c['id']" suittypeid="$type['id']" return="suitlist"}
                            {loop $suitlist $suit}
                            <tr>
                                <td height="40"><strong class="type-tit">{$suit['title']}</strong></td>
                                <td align="center">{$suit['unit']}</td>
                                <td align="center"><span class="price">{if !empty($suit['price'])}<i class="currency_sy">{Currency_Tool::symbol()}</i>{$suit['price']}起{else}电询{/if}</span></td>
                                <td>
                                    {if $suit['paytype']==1}
                                    <span class="fk-way">全款支付</span>

                                    {elseif $suit['paytype']==2}
                                    <span class="fk-way">定金支付</span>
                                    {elseif $suit['paytype']==3}
                                    <span class="fk-way">二次确认</span>
                                    {/if}
                                </td>
                                <td>
                                    {if !empty($suit['price'])}
                                        <a class="booking-btn book-btn" href="javascript:;" data-url="{$c['url']}" >查看</a>
                                    {else}
                                        <a class="booking-btn" style="color: #fff;background-color: #999;cursor: default;" href="javascritp:;">订完 </a>
                                    {/if}
                                </td>
                            </tr>
                            <tr style="display: none">
                                <td colspan="6">
                                    <div class="cartype-nr">
                                        {$suit['content']}
                                    </div>
                                </td>
                            </tr>
                            {/loop}
                            {/loop}

                        </table>
                    </div>
                  </div>
                {/loop}
                 <div class="main_mod_page clear">
                     {$pageinfo}
                  </div>
            {else}
                <div class="no-content">
                    <p><i></i>抱歉，没有找到符合条件的产品！<a href="/cars/all">查看全部产品</a></p>
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
        //租车搜索条件去掉最后一条边框
        $('.line-search-tj').find('dl').last().addClass('bor_0')
        $(".line-search-tj dl dd em").toggle(function(){
            $(this).prev().children('.hide-list').hide();
            $(this).children('b').text('展开');
            $(this).children('i').removeClass('up')
        },function(){
            $(this).prev().children('.hide-list').show();
            $(this).children('b').text('收起');
            $(this).children('i').addClass('up')
        });

        //套餐点击
        $(".type-tit").click(function(){
            $(this).parents('tr').first().next().toggle();
        })

        //隐藏没有属性下级分类
        $(".type").each(function(i,obj){
            var len = $(obj).find('dd p a').length;
            if(len<1){
                $(obj).hide();
            }
        })

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
            var url = SITEURL+'cars/all/';
            window.location.href = url;
        })
        //预订
        $(".book-btn").click(function(){

            var dataurl = $(this).attr('data-url');
            window.location.href = dataurl;
            //$(this).parents('tr').first().find('.date').trigger('click');

        })
        //价格搜索排序
        $('.search-sel').change(function () {
        var url = $(this).find('option:selected').data('url');
        location.href = url;
        })
    })
</script>

</body>
</html>
