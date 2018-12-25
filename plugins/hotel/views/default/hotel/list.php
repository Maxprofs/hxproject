<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<head>
    <meta charset="utf-8">
    <title>{if $is_all}酒店查询_酒店预订_当季热门酒店-{$GLOBALS['cfg_webname']}{else}{$searchtitle}{/if}</title>
    {$destinfo['keyword']}
    {$destinfo['description']}
    {include "pub/varname"}
    {Common::css_plugin('hotel.css','hotel')}
    {Common::css('base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,delayLoading.min.js')}
</head>


<script>
	$(function(){
		//酒店搜索条件去掉最后一条边框
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
		$(".hpic-slide").slide({mainCell:".bd ul",delayTime:0,trigger:"click"});
		
	})
</script>
<body>

{request "pub/header"}
  
  <div class="big">
  	<div class="wm-1200">
    
    	<div class="st-guide">
            {st:position action="list_crumbs" destid="$destinfo['dest_id']" typeid="$typeid"}
      </div><!--面包屑-->
      
      <div class="st-main-page">
      	<div class="st-hotellist-box">

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
              <dl class="date">
                <dt>日期：</dt>
                <dd>
                	<input type="text" placeholder="入住日期" id="txtHotelTime1" value="{$starttime}" />
                  <span>-</span>
                	<input type="text" placeholder="离开日期" id="txtHotelTime2" value="{$endtime}" />
                </dd>
              </dl>
              <dl class="type">
                <dt>目的地：</dt>
                <dd>
                	<p>
                        {st:dest action="query" typeid="$typeid" flag="nextsame" row="100" pid="$destid" return="destlist"}
                            {loop $destlist $dest}
                                <a href="{Model_Hotel::get_search_url($dest['pinyin'],'destpy',$param)}" {if $param['destpy']==$dest['pinyin']}class="on"{/if}>{$dest['kindname']}</a>
                            {/loop}
                        {/st}
                  </p>
                    {if count($destlist)>10}
                        <em><b>收起</b><i class='up'></i></em>
                    {/if}

                </dd>
              </dl>
              <dl class="type">
                <dt>星级：</dt>
                <dd>
                	<p>
                     {st:hotel action="rank_list" row="20" return="ranklist"}
                       {loop $ranklist $row}
                            <a {if $param['rankid']==$row['id']}class="on"{/if} href="{Model_Hotel::get_search_url($row['id'],'rankid',$param)}">{$row['title']}</a>
                       {/loop}
                  </p>
                   {if count($ranklist)>10}
                    <em><b>收起</b><i class='up'></i></em>
                   {/if}
                </dd>
              </dl>
              <dl class="type">
                <dt>价格区间：</dt>
                <dd>
                    <p>
                        {st:hotel action="price_list" row="20" return="pricelist"}
                            {loop $pricelist $row}
                                <a {if $param['priceid']==$row['id']}class="on"{/if} href="{Model_Hotel::get_search_url($row['id'],'priceid',$param)}">{$row['title']}</a>
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
                                    <a href="{Model_Hotel::get_search_url($attr['id'],'attrid',$param)}" {if Common::check_in_attr($param['attrid'],$attr['id'])!==false}class="on"{/if}>{$attr['attrname']}</a>
                                    {/loop}
                                    {/st}
                                </p>
                            </dd>
                        </dl>
                    {/loop}
                {/st}
            </div>
          </div><!--条件搜索-->
          <div class="st-hotellist-con">
          	<div class="st-sort-menu">
            	<span class="sort-sum">
              	<a href="javascript:;">综合排序</a>
                <a href="javascript:;">价格
                    {if $param['sorttype']!=1 && $param['sorttype']!=2}
                    <i class="jg-default" data-url="{Model_Hotel::get_search_url(1,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==1}
                    <i class="jg-up" data-url="{Model_Hotel::get_search_url(2,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==2}
                    <i class="jg-down" data-url="{Model_Hotel::get_search_url(0,'sorttype',$param)}"></i></a>
                    {/if}
                <a href="javascript:;">销量
                    {if $param['sorttype']!=3}
                    <i class="xl-default" data-url="{Model_Hotel::get_search_url(3,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==3}
                    <i class="xl-down" data-url="{Model_Hotel::get_search_url(0,'sorttype',$param)}"></i>
                    {/if}
                </a>
                <a href="javascript:;">推荐
                    {if $param['sorttype']!=4}
                    <i class="tj-default" data-url="{Model_Hotel::get_search_url(4,'sorttype',$param)}"></i>
                    {/if}
                    {if $param['sorttype']==4}
                    <i class="tj-down" data-url="{Model_Hotel::get_search_url(0,'sorttype',$param)}"></i>
                    {/if}
                </a>
              </span><!--排序-->
            </div>
            <div class="hotel-list-con">
                {if !empty($list)}
                    {loop $list $h}
                        <div class="list-child">

                    <div class="lc-image-text">
                        <div class="pic"><a href="{$h['url']}" title="{$h['title']}"><img src="{Product::get_lazy_img()}" st-src="{Common::img($h['litpic'],265,180)}" alt="{$h['title']}" /></a></div>
                      <div class="text">
                        <p class="bt">
                            <a href="{$h['url']}" target="_blank" title="{$h['title']}">{$h['title']}
                                {loop $h['iconlist'] $icon}
                                <img src="{$icon['litpic']}" />
                                {/loop}
                            </a>
                        </p>
                        <p class="attr">
                          <span>销量：{$h['sellnum']}</span>
                          <span>满意度：{if !empty($h['satisfyscore'])}{$h['satisfyscore']}%{/if}</span>
                          <span>推荐：{$h['recommendnum']}</span>
                        </p>
                        <p class="js">酒店介绍：{Common::cutstr_html($h['content'],80)}</p>
                        <p class="ads">{$h['address']}</p>
                          {if $h['suppliername']}
                        <p class="gys">供应商：{$h['suppliername']}</p>
                          {/if}
                      </div>
                      <div class="lowest-jg">
                         {if $h['price']}
                            <span><i class="currency_sy">{Currency_Tool::symbol()}</i><b>{$h['price']}</b>起</span>
                         {else}
                            <span>电询</span>
                         {/if}
                      </div>
                    </div>
                  {st:hotel action="suit" row="10" productid="$h['id']" return="roomlist"}
                    {if !empty($roomlist)}
                    <div class="roomtype-con">

                        <table width="100%" border="0">
                        <tr class="room-attr">
                            <th width="280" height="40" scope="col"><span class="pl20">房型</span></th>
                            <th width="100" scope="col">床型</th>
                            <th width="100" scope="col">餐标</th>
                            <th width="100" scope="col">原价</th>
                            <th width="100" scope="col">优惠价</th>
                            <th width="100" scope="col">支付方式</th>
                            <th scope="col">&nbsp;</th>
                        </tr>

                            {loop $roomlist $room}

                            <tr data-more="more_{$room['id']}">
                                <td height="40" class="room" style="cursor: pointer">
                                    <strong class="type-tit">{$room['title']}</strong>

                                    {if !empty($room['piclist'])}

                                    <i class="pic-ico"></i>

                                    {/if}

                                </td>
                                <td align="center"><span>{$room['roomstyle']}</span></td>
                                <td align="center"><span>{$room['breakfirst']}</span></td>
                                <td align="center"><span>{if $room['sellprice']}{Currency_Tool::symbol()}{$room['sellprice']}{/if}</span></td>
                                <td align="center"><span class="yh">{if $room['price']}{Currency_Tool::symbol()}{$room['price']}{else}电询{/if}</span></td>
                                <td>{if !empty($room['paytype_name'])}<span class="fk-way">{$room['paytype_name']}</span>{/if}</td>

                                <td><a class="booking-btn" {if empty($room['price'])}style="color: #fff;background-color: #999;cursor: default;"{/if} href="{if $room['price']}/hotels/book?suitid={$room['id']}&hotelid={$room['hotelid']}{else}javascritp:;{/if}">{if empty($room['price'])}订完{else}预订{/if}</a></td>
                            </tr>
                            <tr style="display: none">
                                <td height="40" colspan="7" >
                                    <div class="roomtype-sheshi">

                                        {if count($room['piclist'])>0}

                                        <div class="images-con">
                                            <img class="show-pic" src="{$room['piclist'][0][0]}">
                                            <span class="ck"><em>查看全部{count($room['piclist'])}张图片</em></span>
                                        </div>

                                        {/if}

                                        <ul class="type-attr">
                                            <li>面积：{$room['roomarea']}平方米</li>
                                            <li>楼层：{$room['roomfloor']}层</li>
                                            <li>房间：{$room['number']}间</li>
                                            <li>窗户：{$room['roomwindow']}</li>
                                            <li>宽带：{$room['computer']}</li>
                                        </ul>

                                        {if !empty($room['description'])}
                                        <div class="type-sm">
                                            房型说明：{Common::cutstr_html($room['description'],2000)}
                                        </div>
                                        {/if}

                                        <div class="pic-fixed-box" style=" display:none">
                                            <div class="zoom-images-box">
                                                <div id="hpic-slide" class="hpic-slide">
                                                    <div class="bd">
                                                        <h3>{$room['title']}</h3>
                                                        <ul>

                                                            {loop $room['piclist'] $pic}
                                                            <li><img src="{Common::img($pic[0],456,330)}"></li>
                                                            {/loop}

                                                        </ul>
                                                        <a class="prev" href="javascript:void(0)"></a>
                                                        <a class="next" href="javascript:void(0)"></a>
                                                    </div>
                                                    <div class="hd">
                                                        <div class="hp-closed"><span></span></div>
                                                        <ul>

                                                            {loop $room['piclist'] $pic}
                                                            <li class="on"><img src="{Common::img($pic[0],110,74)}"></li>
                                                            {/loop}

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            {/loop}

                            {/st}


                      </table>
                    </div>
                    {/if}
                  </div>
                    {/loop}
                  <div class="main_mod_page clear">
                    {$pageinfo}
                  </div>
                {else}
                <div class="no-content">
                    <p><i></i>抱歉，没有找到符合条件的产品！<a href="/hotels/all">查看全部产品</a></p>
                </div>
                {/if}
              
            </div>
          </div>
        </div><!--列表主体-->
        <div class="st-sidebox">
            {st:right action="get" typeid="$typeid" data="$templetdata" pagename="search"}
        </div><!--边栏模块-->
      </div>
    
    </div>


{request "pub/footer"}

{request "pub/flink"}
{Common::js('datepicker/WdatePicker.js',0)}
<script>
    $(function(){
        //展示房型详细信息
        $('.room').click(function(){
            $(this).parent().next().toggle();
        })
        //展示更新房型图片
        $('.ck').click(function(){
            $(this).parents('.roomtype-sheshi').first().find('.pic-fixed-box').show();
        })
        //关闭图层显示
        $(".hp-closed").click(function(){
            $(this).parents(".pic-fixed-box").first().hide();
        })
        //酒店预订时间选择
        $("#txtHotelTime1").focus(function(){
            $("#txtHotelTime2").attr('value','');
            WdatePicker({onpicking:function(dp){
                var starttime=dp.cal.getNewDateStr();
                var url=window.location.href;
                window.location.href=changeURLPar(url,'starttime',starttime);
            },dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d',maxDate:'#F{$dp.$D(\'txtHotelTime2\',{d:-1});}',doubleCalendar:true,isShowClear:false,readOnly:true,errDealMode:1})

            $("#txtHotelTime1").css("color","#333");
            $("#txtHotelTime2").blur();
        })
        $("#txtHotelTime2").focus(function(){
            WdatePicker({onpicking:function(dp){
                var endtime=dp.cal.getNewDateStr();
                var url=window.location.href;

                    window.location.href=changeURLPar(url,'endtime',endtime);

            },minDate:'#F{$dp.$D(\'txtHotelTime1\',{d:1});}',dateFmt:'yyyy-MM-dd',doubleCalendar:true,isShowClear:false,readOnly:true,errDealMode:1});
            $("#txtHotelTime2").css("color","#333");
            $("#txtHotelTime2").blur();
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
            var url = SITEURL+'hotels/all/';
            window.location.href = url;
        })
        //隐藏没有属性下级分类
        $(".type").each(function(i,obj){
            var len = $(obj).find('dd p a').length;
            if(len<1){
                $(obj).hide();
            }
        })

        function changeURLPar(destiny, par, par_value)
        {
            var pattern = par+'=([^&]*)';
            var replaceText = par+'='+par_value;
            if (destiny.match(pattern))
            {
                var tmp = '/'+par+'=[^&]*/';
                tmp = destiny.replace(eval(tmp), replaceText);
                return (tmp);
            }
            else
            {
                if (destiny.match('[\?]'))
                {
                    return destiny+'&'+ replaceText;
                }
                else
                {
                    return destiny+'?'+replaceText;
                }
            }
            return destiny+'\n'+par+'\n'+par_value;
        }
    })
</script>

</body>
</html>
