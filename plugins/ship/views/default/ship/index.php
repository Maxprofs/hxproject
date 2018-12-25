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
    {Common::css('base.css,extend.css')}
    {Common::css_plugin('ship.css,jmonthcalendar.css,cupertino/jquery-ui.cupertino.css','ship',0)}
    {Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,slideTabs.js,delayLoading.min.js')}
    {Common::js_plugin('jquery-ui.min.js,jmonthcalendar.js,datetime.js','ship',false)}

</head>

<body>
 {request "pub/header"}
 <div class="big">
     <div class="wm-1200">
         <div class="st-guide">
             <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{$channelname}
         </div>
         <!-- 面包屑 -->
         <div class="st-container clearfix">
             <div class="ship-menu-block">
                 <ul>
                     <li class="first">
                         <div class="hd-block">
                             <h3>热门目的地</h3>
                             <div class="hd-list">
                                 <div class="fw">
                                 {st:dest action="query" flag="hot" typeid="$typeid" row="100" return="shipdestlist"}
                                 {loop $shipdestlist $row}
                                 <a href="{$cmsurl}ship/{$row['pinyin']}/" target="_blank">{$row['kindname']}</a>
                                     {php if($n==10) break;}
                                 {/loop}
                                 </div>
                             </div>
                         </div>
                         <div class="item-block">
                             <h4>热门目的地</h4>
                             <div class="item-list">
                                 <div class="fw">
                                 {loop $shipdestlist $row}
                                 <a href="{$cmsurl}ship/{$row['pinyin']}/" target="_blank">{$row['kindname']}</a>
                                 {/loop}
                                 </div>
                             </div>
                         </div>
                     </li>
                     <li class="{if $key==2}last{/if}">
                         <div class="hd-block">
                             <h3>热门邮轮</h3>
                             <div class="hd-list">
                                 <div class="fw">
                                 {st:ship action="ship" row="100" return="subdata"}
                                 {loop $subdata $r}
                                 <a href="{$cmsurl}ship/all-0-0-0-0-{$r['id']}-0-1">{$r['title']}</a>
                                 {php if($n==10) break;}
                                 {/loop}
                                 {/st}
                                 </div>
                             </div>
                         </div>
                         <div class="item-block">
                             <h4>热门邮轮</h4>
                             <div class="item-list">
                                 {loop $subdata $r}
                                 <a href="{$cmsurl}ship/all-0-0-0-0-{$r['id']}-0-1">{$r['title']}</a>
                                 {/loop}
                             </div>
                         </div>
                     </li>

                     {st:attr action="query" typeid="$typeid" flag="grouplist" row="2"}
                     {loop $data $key $row}
                        <li class="{if $key==1}last{/if}">
                         <div class="hd-block">
                             <h3>{$row['attrname']}</h3>
                             <div class="hd-list">
                                 <div class="fw">
                                 {st:attr action="query" typeid="$typeid" flag="childitem" groupid="$row['id']" typeid="$typeid" row="100" return="subdata"}
                                 {loop $subdata $r}
                                 <a href="{$cmsurl}ship/all-0-0-0-0-0-{$r['id']}-1">{$r['attrname']}</a>
                                      {php if($n==10) break;}
                                 {/loop}
                                 {/st}
                                 </div>
                             </div>
                         </div>
                         <div class="item-block">
                             <h4>{$row['attrname']}</h4>
                             <div class="item-list">
                                 {loop $subdata $r}
                                 <a href="{$cmsurl}ship/all-0-0-0-0-0-{$r['id']}-1">{$r['attrname']}</a>
                                 {/loop}
                             </div>
                         </div>
                     </li>
                     {/loop}
                 </ul>
             </div><!-- 属性筛选导航 -->

             <div class="st-focus-banners">
                 <a href="javascript:;" class="prev"></a>
                 <a href="javascript:;" class="next"></a>
                 <div class="banners">

                     {st:ad action="getad" name="IndexRollingAd_104" pc="1" return="indexads"}
                     <ul>
                         {loop $indexads['aditems'] $v}
                           <li class="banner"><a href="{$v['adlink']}" target="_blank"><img src="{Product::get_lazy_img()}" original-src="{Common::img($v['adsrc'],858,382)}" alt="{$v['adname']}" /></a></li>
                         {/loop}
                     </ul>
                 </div>
                 <div class="focus">
                     <ul>
                         {loop $indexads['aditems'] $v}
                         <li></li>
                         {/loop}
                     </ul>
                 </div>
             </div><!--滚动焦点图结束-->

         </div>
         <!-- 属性导航 -->

         <div class="hot-content">
             <div class="hot-tit"><h3>热门推荐</h3><a class="more" href="/ship/all" target="_blank">查看更多</a></div>
             <div class="hot-block">
                 <ul class="clearfix">
                     {st:ship action="query" flag="order" row="4" return="shiplist"}
                     {loop $shiplist $ship}
                     <li class="{if $n==4}mr_0{/if}">
                         <div class="pic">
                             <a href="{$ship['url']}" target="_blank" title="{$ship['title']}"><img src="{Product::get_lazy_img()}" st-src="{Common::img($ship['litpic'],283,193)}" alt="{$ship['title']}"  /></a>
                             <i class="attr"></i>
                         </div>
                         <div class="txt">
                             <p class="bt"><a href="{$ship['url']}" target="_blank" title="{$ship['title']}">{$ship['title']}</a></p>
                             <p class="date">{if !empty($ship['starttime'])}{date('m月d日',$ship['starttime'])}{/if}</p>
                             <p class="clearfix">
                                 {if $ship['price']}
                                 <span class="jg"><em><i class="currency_sy">{Currency_Tool::symbol()}</i><strong>{$ship['price']}</strong></em>起/人</span>
                                 {else}
                                 <span class="jg"><em><strong>电询</strong></em></span>
                                 {/if}
                                 <span class="start">{$ship['startcity_name']}</span>
                             </p>
                         </div>
                     </li>
                     {/loop}
                 </ul>
             </div>
         </div>
         <!-- 热门推荐 -->

        <div class="ship-calendar-content">
             <div class="ship-calendar-title">邮轮日历</div>
             <div id="jMonthCalendar" class="ship-calendar-block">

             </div>
             <div class="calendar-more-lines"><a href="/ship/all" target="_blank">查看更多航线</a></div>
         </div>
         <!-- 邮轮日历 -->

         <div class="company-content">
             <div class="company-hd">
                 <h3>邮轮公司</h3>
                 {st:ship action="supplier" row="6" return="suppliers"}
                 {loop $suppliers $v}
                 <span>{$v['suppliername']}</span>
                 {/loop}
             </div>
             {loop $suppliers $v}
               <div class="company-bd clearfix">
                 <div class="ship-js">
                     <div class="type">
                         <span><img src="{$v['litpic']}" class="ship-logo"/></span>
                         <strong>{$v['suppliername']}</strong>
                     </div>
                     {st:ship action="ship" flag="sub" supplierid="$v['id']" row="100" return="subships"}

                     <div class="con">
                         <h4><a href="{$subships[0]['url']}" target="_blank" title="{$subships[0]['title']}">{$subships[0]['title']}</a></h4>
                         <div class="txt">{Common::cutstr_html($subships[0]['content'],64)}</div>
                         <ul class="cs clearfix">
                             <li>总吨位<br />{$subships[0]['weight']}吨</li>
                             <li>载客数<br />{$subships[0]['seatnum']}人</li>
                             <li>总长度<br />{$subships[0]['length']}米</li>
                             <li class="last">甲板层<br />{$subships[0]['floornum']}层</li>
                         </ul>
                     </div>

                 </div>
                 <div class="ship-pic"><a href="{$subships[0]['url']}" target="_blank" title="{$subships[0]['title']}"><img   src="{Product::get_lazy_img()}" st-src="{Common::img($subships[0]['litpic'],548,298)}" alt="{$subships[0]['title']}"  /></a></div>
                 <div class="ship-cp">
                     <ul class="clearfix">
                         {st:ship action="query" flag="byship" shipid="$subships[0]['id']" row="4" return="sublines"}

                         {loop $sublines $line}
                         <li>
                             <a class="pic" href="{$line['url']}" target="_blank" title="{$line['title']}">
                                 <img src="{Product::get_lazy_img()}" st-src="{Common::img($line['litpic'],176,112)}" alt="{$line['title']}" />
                                 <span class="bt">{Common::cutstr_html($line['title'],25)}</span>
                             </a>
                             <div class="msg">
                                 {if $line['price']}
                                 <span class="jg"><em><i class="currency_sy">{Currency_Tool::symbol()}</i><strong>{$line['price']}</strong></em>起/人</span>
                                 {else}
                                 <span class="jg"><em><strong>电询</strong></em></span>
                                 {/if}
                                 <span class="date">{if !empty($line['starttime'])}{date('m月d日',$line['starttime'])}{/if}</span>
                             </div>
                         </li>
                         {/loop}
                     </ul>
                 </div>


                   <div class="clear"></div>
                   <div class="ship-brand clearfix clear">
                       <strong>旗下游轮</strong>
                       {loop $subships $ship}
                       <a href="{$ship['url']}" target="_blank" title="{$ship['title']}">{$ship['title']}</a>
                       {/loop}

                   </div>
             </div>
             {/loop}

         </div>
         <!-- 邮轮公司 -->


         <!-- 旗下游轮 -->
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

<div class="ship-empty-content" style="display: none;">
     <div class="ship-empty-block">
         <div class="txt">本月暂无线路，快去看看其他月份吧！</div>
         <div class="select-down">
             {php  $firstday= date("Y-m-01")}
             <div id="cur-date" class="cur-date">{date("Y年m月",strtotime($firstday))}</div>
             <div id="select-date" class="select-date">

                 <ul>
                     <li data-time="{date("Y-m-d",strtotime($firstday))}">
                     {date("Y年m月",strtotime($firstday))}</li>
                     <li data-time="{date("Y-m-d",strtotime("$firstday +1 month"))}">
                     {date("Y年m月",strtotime("$firstday +1 month"))}</li>
                     <li data-time="{date("Y-m-d",strtotime("$firstday +2 month"))}">
                     {date("Y年m月",strtotime("$firstday +2 month"))}</li>
                     <li data-time="{date("Y-m-d",strtotime("$firstday +3 month"))}">
                     {date("Y年m月",strtotime("$firstday +3 month"))}</li>
                     <li data-time="{date("Y-m-d",strtotime("$firstday +4 month"))}">
                     {date("Y年m月",strtotime("$firstday +4 month"))}</li>
                 </ul>
             </div>
         </div>
     </div>
 </div>

 <!-- 无线路 -->



 <!-- 邮轮线路 -->

<script>
    $(function(){

        //游轮首页焦点图
        $('.st-focus-banners').slide({
            mainCell:".banners ul",
            titCell:".focus li",
            effect:"fold",
            interTime: 5000,
            delayTime: 1000,
            autoPlay:true,
            switchLoad:'original-src'
        });

        //邮轮公司切换
        $(".company-content").switchTab({
            titOnClassName: "on",
            titCell: ".company-hd span",
            mainCell: ".company-bd",
            trigger: "hover"
        });

        //游轮线路标题显示
        $(".ship-cp .pic").hover(function(){
            $(this).children(".bt").stop(true,false).animate({bottom: "0px"})
        },function(){
            $(this).children(".bt").stop(true,false).animate({bottom: "-40px"})
        })

    })

</script>

<!--日历相关-->
<script>

    $(function(){
        //游轮日历
        var options = {
            height: "auto",
            width: '100%',
            navHeight: 0,
            labelHeight: 35,
            onMonthChanging: on_month_changing,
            onMonthChanged:function(dateIn){ return true;},
          // onMoreBtnClick:on_more_click,
            onTdOver:function(ele,event){
                var more_btn = ele.find('.more');
                on_more_click(more_btn,event,true);
                ele.addClass('mouseover');
            },
            onTdOut:function(ele,event)
            {
                var more_btn = ele.find('.more');
                on_more_click(more_btn,event,false);
                ele.removeClass('mouseover');
            }
            ,
            onTdClick:function(ele,event)
            {
                window.location.href=event.lineurl;
            },
            onEventBlockClick:function(event)
            {
                window.location.href=event.lineurl;
            }
        };

        var events=[];
       $.jMonthCalendar.Initialize(options,events);



        on_month_changing();

        //月份切换后
        function on_month_changing(dateIn)
        {

            //$.jMonthCalendar.ChangeMonth(new Date('10/10/2016'));


            var date = !dateIn?new Date():dateIn;
            var firstdate = Datetime.getMonthFirstDate(new Date());
            if(Datetime.dateCompare(firstdate,date))
            {
                return false;
            }

            var year = date.getFullYear();
            var month = date.getMonth()+1;
            var params = {year:year,month:month};
            var url = SITEURL+'ship/ajax_get_month_shiplist'
            $.ajax({
                url: url,
                dataType: 'json',
                type:'post',
                data: params,
                success: function(result){
                      var eventdata=[];
                      if(!result || result.length==0)
                      {
                          var parentTop=$('.ship-calendar-content').offset().top;
                          $(".ship-empty-content").css('top',parentTop+250);
                          $(".ship-empty-content").show();

                          return;
                      }
                      $(".ship-empty-content").hide();
                      for(var i in result)
                      {
                          var row = result[i];
                          eventdata.push({
                              EventID:i,
                              StartDateTime:row['date'],
                              Title: row['title'],
                              URL: "javascript:;",
                              Description: '<a href="javascript:;">'+row['passed_destnames']+'</a>',
                              Price: row['price'],
                              CssClass: "name",
                              Lines:row.lines,
                              lineurl:row.url
                          });
                      }

                    $.jMonthCalendar.ReplaceEventCollection(eventdata);

                }
            });
            return true;
        }

        //点击更多按钮
        function on_more_click(ele,event,isshow){

            var line_container =  ele.find('.cs-calendar-dropdown');
            if(line_container.length>0 && isshow)
            {
                line_container.show();
                return;
            }

            if(!isshow && line_container.length>0)
            {
                line_container.hide();
                return;
            }


            var calendar_right = $(".ship-calendar-content").offset().left+$(".ship-calendar-content").width();
            var html='<div class="cs-calendar-dropdown cs-calendar-dropdown-left"><div class="triangle">'
                +'<em>◆</em><i style="color: rgb(255, 255, 255);">◆</i></div><div class="cs-cd-lists">'

            for(var i in event.Lines)
            {
                var line = event.Lines[i];
                var pricestr = line['price']!=0 && line['price']!=''?'<i>'+CURRENCY_SYMBOL+'</i><em>'+line['price']+'</em>起/人':'<em>电询</em>';
                 html+='<a target="_blank" href="'+line['url']+'" class="cs-cd-list clearfix">'
                     +'<div class="cs-cd-route">'+line['destname']+'</div>'
                     +'<div class="cs-cd-title clearfix">'
                     +'<p>'+line['title']+'</p>'
                     +'<div class="cs-cd-label"></div>'
                     +'<div class="cs-cd-area">'+line['passed_destnames']+'</div>'
                     +'</div><div class="cs-cd-price">'+pricestr+'</div></a>';
            }
           html+='</div></div>';
           ele.append(html);
           line_container = ele.find('.cs-calendar-dropdown');
           var line_container_right = line_container.offset().left+line_container.width();
           var minus_offset = calendar_right-line_container_right;
            if(minus_offset<0)
            {
                line_container.css('left',minus_offset);
                var triangle_ele=line_container.find('.triangle');
                var triangle_ele_left= triangle_ele.position().left-minus_offset;
                triangle_ele.css('left',triangle_ele_left);
            }

        }








        //无线路提示
        $("#cur-date").on("click",function(){
            $("#select-date").show()
        });

        $(".select-date li").on("click",function(){
            var time = $(this).data('time');
            $(".ship-empty-content").hide();
            $.jMonthCalendar.ChangeMonth(Datetime.getDateByStr(time));
        });

    })
</script>




 {request "pub/footer"}
 {request "pub/flink"}
</body>
</html>
