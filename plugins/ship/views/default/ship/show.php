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
    {Common::css('base.css,extend.css,header.css,footer.css,stcalendar.css')}
    {Common::css_plugin('ship.css,cupertino/jquery-ui.cupertino.css','ship',0)}
    {Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,slideTabs.js,delayLoading.min.js')}
    {Common::js_plugin('jquery-ui.min.js,datetime.js','ship',false)}
</head>

<body>
{request "pub/header"}

    <div class="big">
        <div class="wm-1200">
            <div class="st-guide">
                <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<a href="/ship/">{$channelname}</a>&nbsp;&gt;&nbsp;
                <strong title="{$info['title']}">{$info['title']}</strong>
            </div>
            <!-- 面包屑 -->

            <div class="show-msg-content clearfix">

                <div class="slide-content">
                    <ul class="bigImg">
                        {loop $info['piclist'] $pic}
                        <li><a href=""><img src="{Common::img($pic[0],500,340)}"/></a></li>
                        {/loop}
                    </ul>
                    <div class="smallScroll">
                        <a id="front" class="sPrev prevStop" href="javascript:void(0)"></a>
                        <div class="smallImg">
                            <ul>
                                {loop $info['piclist'] $pic}
                                <li><span><img src="{Common::img($pic[0],98,66)}"/></span></li>
                                {/loop}
                            </ul>
                        </div>
                        <a id="next" class="sNext" href="javascript:void(0)"></a>
                    </div>
                </div>
                <!-- 轮播图 -->

                <div class="msg-txt-block">
                    <h1>{$info['title']}
                        {loop $info['iconlist'] $icon}
                        <img src="{$icon['litpic']}" />
                        {/loop}</h1>
                    <div class="data clearfix">
                        <span>销量：{$info['sellnum']}</span><i></i>
                        <span>满意度：{$info['satisfyscore']}</span><i></i>
                        <span><a href="#comment_target">{$info['commentnum']}条点评</a></span>
                    </div>
                    <div class="price">
                        {if $info['priceinfo']['price']}
                        <span>优惠价：<em>{Currency_Tool::symbol()}<strong>{$info['priceinfo']['price']}</strong>起/人</em></span>
                        {else}
                        <span>优惠价：<em><strong>电询</strong></em></span>
                        {/if}
                        {if $info['priceinfo']['storeprice']}
                        <del>市场价：{Currency_Tool::symbol()}{$info['priceinfo']['storeprice']}</del>
                        {/if}
                    </div>
                    <div class="attr">
                        <ul>
                            <li>
                                <span class="half">航线编号：{$info['series']}</span>
                                {php}$ship=Model_Ship::get_ship($info['shipid']);{/php}
                                <span class="half">邮轮品牌：<a href="/ship/cruise_{$ship['id']}.html" target="_blank"><strong class="gs">{Model_Ship::get_ship_supplier($info['shipid'],'suppliername')} -{$ship['title']}</strong></a></span>
                            </li>
                            <li>航线属性：{implode(',',Model_Ship_Line_Attr::get_attrs($info['attrid'],'attrname'))}</li>
                            <li>
                                <span class="half">出发地点：{Model_Ship_Line::get_start_city($info['startcity'],'cityname')}</span>
                                <span class="half">行程天数：{$info['schedule_name']}</span>
                            </li>
                            <li>目的地点：{$info['finaldest_name']}</li>
                            {if $info['islinebefore']}
                            <li>提前预订：请提前<strong class="day">{$info['linebefore']}</strong>天报名</li>
                            {/if}
                            <li>
                                <strong class="fk-way">付款方式：</strong>
                                <p class="way-list">
                                    {php $paymethod = Product::get_paytype_list();}
                                    {loop $paymethod $method}
                                    <img src="{$method['icon']}" />
                                    {/loop}
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 文字信息 -->

            </div>
            <!-- 详情信息展示 -->
            {if $info['sellpoint']}
            <div class="airline-sell-point clearfix">
                <strong>航线卖点：</strong><p>{$info['sellpoint']}</p>
            </div>
            <!-- 航线卖点 -->
            {/if}

            <div class="show-booking-content" id="load_data" data="{ startTime:'{date('Y-m-d',$info['lastest_line'])}',lineId:{$info['id']} }">
                <div class="show-booking-hd clearfix">
                    <div class="sdate">
                        <strong class="bt">当前航期：</strong>
                        <div class="hq">
                            {if !empty($info['lastest_line'])}
                            <span class="dt" id="start_time">{date('Y-m-d',$info['lastest_line'])}</span>
                            <span class="dj"><strong>{Currency_Tool::symbol()} <em id="suit_mini">{$info['lastest_price']}</em></strong>起</span>
                            {else}
                              <span class="dt" style="cursor:default">无航期</span>

                            {/if}
                        </div>
                    </div>
                    {if !empty($info['lastest_line'])}
                    <div class="edate">返回日期：<em id="back_time"></em></div>
                    <div class="price">
                        <span class="txt">入住人数：<em id="visitor_num">0</em>人 总价：<em>{Currency_Tool::symbol()}<strong id="order_total">0</strong></em></span>
                        <a class="begin-booking-btn" id="booking_btn" href="javascript:;" data="{lineid:{$info['id']},shipid:{$info['shipid']},url:''}">开始预订</a>
                    </div>
                    {/if}
                </div>
                <div class="show-booking-bd">
                    <table border="0" width="100%" id="load_content" margin_padding=JPOzDt >

                    </table>
                </div>
            </div>
            <!-- 预订房型、航期 -->

            <div class="ship-show-content">

                <div class="ship-show-nav clearfix">
                    <span class="on">邮轮介绍</span>
                    {st:ship action="get_content" pc="1" typeid="$typeid" productinfo="$info" return="linecontent"}
                    {loop $linecontent $row}
                      {if !empty($row['content'])}
                    <span>{$row['chinesename']}</span>
                      {/if}
                    {/loop}
                    {/st}
                    <span>客户点评</span>
                    <span>我要咨询</span>
                </div>
                <!-- 分类导航 -->

                <div class="ship-show-box">

                    <div class="ship-show-block">
                        <div class="column-tit">{$ship['title']}</div>
                        <div class="column-block">
                            <div class="pic"><img src="{Common::img($ship['litpic'],1140,446)}"/></div>
                            <div class="txtCon">{Common::cutstr_html($ship['content'],100000)}<a href="/ship/cruise_{$ship['id']}.html" target="_blank" class="more">了解更多&gt;</a></div>
                        </div>
                    </div>
                    <!-- 游轮介绍 -->
                    {loop $linecontent $line}
                         {php if(empty($line['content'])) continue;}
                    {if preg_match('/^\d+$/',$line['content']) && $line['columnname']=='jieshao'}

                    <div class="ship-show-block">
                        <div class="column-tit">{$line['chinesename']}</div>
                        <div class="column-block">
                            {if $info['isstyle']==2}
                            <div class="route-bt"><h3>行程详情</h3><a class="print" href="{$GLOBALS['cfg_basehost']}/ship/print_{$info['id']}.html">打印行程</a></div>
                            <div class="day-leftnav" id="day-leftNav">
                                {php $jieshao_list=Model_Ship_Line::jieshao($info['id'],$info['lineday']);}
                                <ul class="day-navlist">
                                    {loop $jieshao_list $v}
                                    <li><a href="#">DAY{$v['day']}</a></li>
                                    {/loop}
                                </ul>
                            </div>
                            <div class="route-day">
                                {loop $jieshao_list $v}
                                <div class="each-day section">
                                    <div class="day-tit clearfix">
                                        <strong>第{$v['day']}天</strong>
                                        <p>{$v['title']}</p>
                                    </div>
                                    <div class="day-msg">
                                        <ul>
                                            {if $v['starttimehas']==1 || $v['endtimehas']==1}
                                            <li class="clearfix">
                                                {if $v['starttimehas']==1}
                                                <span class="stime">起航时间：{$v['starttime']}</span>
                                                {/if}
                                                {if $v['endtimehas']==1}
                                                <span class="etime">抵达时间：{$v['endtime']}</span>
                                                {/if}
                                            </li>
                                            {/if}

                                            <li class="clearfix">

                                                <span class="fast">邮轮早餐：
                                                    {if $v['breakfirsthas']}
                                                        {if !empty($v['breakfirst'])}
                                                          {$v[breakfirst]}
                                                        {else}
                                                          含
                                                        {/if}
                                                    {else}
                                                      不含
                                                    {/if}
                                                </span>
                                                <span class="lunch">邮轮午餐：
                                                {if $v['lunchhas']}
                                                        {if !empty($v['lunch'])}
                                                            {$v[lunch]}
                                                        {else}
                                                            含
                                                        {/if}
                                                {else}
                                                   不含
                                                {/if}
                                                </span>

                                                <span class="supper">邮轮晚餐：
                                                {if $v['supperhas']}
                                                    {if !empty($v['supper'])}
                                                      {$v['supper']}
                                                    {else}
                                                      含
                                                    {/if}
                                                {else}
                                                    不含
                                                {/if}
                                                </span>
                                            </li>

                                            {if $v['countryhas']==1 || $v['livinghas']==1}
                                            <li class="clearfix">
                                                {if $v['countryhas']==1}
                                                <span class="dest">国家/城市：{$v['country']}</span>
                                                {/if}
                                                {if $v['livinghas']==1}
                                                <span class="stay">入住：{$v['living']}</span>
                                                {/if}
                                            </li>
                                            {/if}
                                        </ul>
                                    </div>
                                    <div class="column-txt">
                                        {$v['content']}
                                    </div>
                                </div>
                                {/loop}

                            </div>
                            {else}
                            <div class="list-txt">
                                {$info['jieshao']}
                            </div>
                            {/if}

                        </div>
                    </div>
                    <!-- 行程介绍 -->
                    {else}
                    <div class="ship-show-block">
                        <div class="column-tit">{$line['chinesename']}</div>
                        <div class="column-block">
                            <div class="column-txt">
                                {if $line['columnname'] == 'payment' && empty($line['content'])}
                                {$GLOBALS['cfg_payment']}
                                {else}
                                {$line['content']}
                                {/if}
                            </div>
                        </div>
                    </div>
                    {/if}
                    {/loop}
                    {include "ship/comment"}
                    {include "ship/ask"}
                </div>
            </div>
            <!-- 详情分类展示 -->
        </div>
    </div>
<script id="load_tpl" type="text/html">
    <tr>
        <th width="96" bgcolor="#f6f6f6" valign="top"><strong class="select-type">选择房型</strong></th>
        <td width="1100" valign="top">
            <div class="type-tabbox">
                <div class="type-tabnav">
                    {{each kind as value i}}
                    <span index="{{i}}" {{if i==kindSuit}}class="on"{{/if}}>{{value}}</span>
                    {{/each}}
                </div>
                <div class="type-tabcon" id="data_content">
                    <table width="100%" border="0">
                        <tr>
                            <th width="20%">舱房名称</th>
                            <th width="10%">房间面积</th>
                            <th width="10%">可住人数</th>

                            <th width="10%">优惠价</th>
                            <th width="10%">人均价</th>
                            <th width="10%">支付方式</th>
                            <th width="10%">库存房间数</th>
                            <th width="10%">入住人数</th>
                            <th width="10%">房间数</th>
                        </tr>
                        {{each suit as value i}}
                        <tr class="kind_{{value.room.kindid}} {{if value.room.kindid!=kindSuit}}hide{{/if}} isdata" data="{'suitid':{{value.suitid}},'dateid':{{value.dateid}},'price':{{if value.suit.paytypeid==2}}{{value.suit.dingjin}}{{else}}{{value.price}}{{/if}},'needroom':0,'number':0,'rooms':{{value.number}},preroompeople:{{value.room.peoplenum}},maxnumber:{{value.number*value.room.peoplenum}}}">
                            <td width="20%"><a class="type-tit" href="javascript:">{{value.room.title}}<img src="/res/images/type-pic-ico.png" /></a></td>
                            <td width="10%"><span class="sz">{{if value.area!=0}}{{value.room.area}}m<sup>2</sup>{{else}}{{/if}}</span></td>
                            <td width="10%"><span class="sz">{{value.room.peoplenum}}</span></td>

                            <td width="10%"><span class="jg">{{if value.price!=0}}{Currency_Tool::symbol()}<strong>{{value.price}}</strong>{{else}}电询{{/if}}</span></td>
                            <td width="10%"><span class="jg">{{if value.price!=0}}{Currency_Tool::symbol()}<strong>{{value.avgprice}}</strong>{{else}}--{{/if}}</span></td>

                            <td width="10%"><span class="attr">{{value.suit.paytype}}</span></td>
                            <td width="10%">{{if value.number==-1}}不限{{else}}{{value.number}}{{/if}}</td>
                            <td width="10%">
                                {{if value.price!=0 && (value.number>0 || value.number==-1)}}
                                <span class="num-opt">
                                    <i class="sub">-</i>
                                    <input class="change_number" readonly type="text" value="0" />
                                    <i class="add">+</i>
                                </span>
                                {{/if}}
                            </td>
                            <td width="10%"><span class="sz needroom">0</span></td>
                        </tr>
                        {{if value.room}}
                        <tr class="kind_{{value.room.kindid}} hide type-msg-layer">
                            <td colspan="8">
                                <div class="roomtype-sheshi clearfix">
                                    <div class="images-con">
                                        <img class="show-pic" src="{{value.room.litpic}}">
                                        <span class="ck"><em>查看全部{{value.room.piccount}}张图片</em></span>
                                    </div>
                                    <ul class="type-attr">
                                        <li title="{{value.room.floors_names}}">所在楼层：{{value.room.floors_names}}</li>
                                        <li>舱房面积：{{value.room.area}}㎡</li>
                                        <li>舱房窗型：{{if value.room.iswindow}}有{{else}}无{{/if}}窗</li>
                                        <li>可住人数：{{value.room.num}}人</li>
                                    </ul>
                                    <div class="type-sm">{{#value.room.content}}</div>
                                    <div class="integral">
                                        {{if value.suit.jifenbook>0}}
                                        <span class="s-jf">{{value.suit.jifenbook}}</span>
                                        {{/if}}
                                        {{if value.suit.jifentprice>0}}
                                        <span class="d-jf">{{value.suit.jifentprice}}</span>
                                        {{/if}}
                                        {{if value.suit.jifencomment>0}}
                                        <span class="p-jf">{{value.suit.jifencomment}}</span>
                                        {{/if}}
                                    </div>
                                    <div class="clearfix clear"><span class="pack-up">收起</span></div>
                                    <div class="pic-fixed-box hide">
                                        <div class="zoom-images-box">
                                            <div id="hpic-slide" class="hpic-slide">
                                                <div class="bd">
                                                    <h3>{{value.room.title}}</h3>
                                                    <ul>
                                                        {{each value.room.piclist as pic i}}
                                                        <li {{if i>0}}style="display: none;"{{/if}}><img src="{{pic}}"></li>
                                                        {{/each}}
                                                    </ul>
                                                    <a class="prev" href="javascript:void(0)"></a>
                                                    <a class="next" href="javascript:void(0)"></a>
                                                </div>
                                                <div class="hd">
                                                    <div class="hp-closed"><span></span></div>
                                                    <ul>
                                                        {{each value.room.thumb as pic i}}
                                                        <li {{if i==0}}class="on"{{/if}}><img src="{{pic}}"></li>
                                                        {{/each}}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{/if}}
                        {{/each}}
                    </table>
                </div>
            </div>
        </td>
    </tr>
</script>
{request "pub/footer"}
{request "pub/flink"}
{Common::js('floatmenu/floatmenu.js')}
{Common::js('SuperSlide.min.js,template.js,date.js,calendar.js,scorll.img.js',false)}
{Common::js('layer/layer.js',0)}
{Common::css('/res/js/floatmenu/floatmenu.css')}
    <script>

        var lineid = "{$info['id']}";
        $(function(){
            //轮播图
            $(".slide-content").slide({
                titCell:".smallImg li",
                mainCell:".bigImg",
                effect:"fold",
                autoPlay:true,
                interTime:5000,
                delayTime:500,
                startFun:function(i){
                    if(i==0)
                    {
                        $(".slide-content .sPrev").click()
                    }
                    else if( i%4==0 )
                    {
                        $(".slide-content .sNext").click()
                    }
                }
            });
            $(".slide-content .smallScroll").slide({
                mainCell:"ul",
                interTime:5000,
                delayTime:500,
                vis:4,
                scroll:4,
                effect:"left",
                autoPage:true,
                prevCell:".sPrev",
                nextCell:".sNext",
                pnLoop:false
            });
            //天数跳转
            function pageScroll() {
                var scrollTop = $(window).scrollTop();
                var size = $(".day-navlist a").size();
                //var listTop = $(".section").eq(0).offset().top;
                if (size != null) {
                    for (var i = 0; i < size; i++) {
                        var firstOffset = $(".section").eq(0).offset().top-100,
                            edge = $(".section").eq(size - 1).offset().top + $(".section").eq(size - 1).height(),
                            offset = $(".section").eq(i).offset().top-100;
                        dayLeftNav = $("#day-leftNav").height()+100;
                        if (scrollTop < firstOffset || scrollTop > edge - dayLeftNav) {
                            $("#day-leftNav").hide();
                            $(".day-navlist a").removeClass("cur");
                        } else if (scrollTop >= offset && scrollTop <= edge) {
                            $("#day-leftNav").show();
                            $(".day-navlist a").removeClass("cur");
                            $(".day-navlist a").eq(i).addClass("cur");
                        }
                    }
                }
            }
            $(window).onload = pageScroll();
            $(window).bind('scroll', pageScroll);
            $(".day-navlist li").click(function (e) {
                //$(window).unbind("scroll");
                var index = $(this).index(),
                    offset = $('.section').eq(index).offset().top-60;
                //scrollTop = $(window).scrollTop();
                $(".day-navlist a").removeClass("cur");
                $(this).find("a").addClass("cur");
                $("html, body").animate({
                    scrollTop: offset
                }, "slow", function () {
                    $(window).bind('scroll', pageScroll);
                });
                e.preventDefault();
            });
            //load套餐
            load_data();
            //floatMenu导航
            $.floatMenu({
                menuContain : '.ship-show-nav',
                tabItem : 'span',
                chooseClass : 'on',
                contentContain : '.ship-show-box',
                itemClass : '.ship-show-block'
            });
            //订单整理
            $('body').delegate('.sub',"click",function(){
                var next=$(this).next('input');
                var val=parseInt(next.val());
                if(val<1){
                    return;
                }
                --val;
                var parent=$(this).parents('.isdata');
                var suit=format_data(parent.attr('data'),true);
                next.val(val);
                suit.number=val;
                suit.needroom=Math.ceil(val/(suit.preroompeople));
                parent.find('.needroom').text(suit.needroom);
                parent.attr('data',format_data(suit));
                $('#visitor_num').text(val);
                total_price();
            });

            $('body').delegate('.add',"click",function(){
                var prev=$(this).prev('input');
                var val=prev.val();
                var parent=$(this).parents('.isdata');
                var suit=format_data(parent.attr('data'),true);
                ++val;

                suit.needroom=Math.ceil(val/(suit.preroompeople));

                if(suit.rooms!=-1 && suit.needroom>suit.rooms)
                {
                    layer.alert('库存不足', {
                        icon: 2
                    })
                    return;
                }
                prev.val(val);
                suit.number=val;
                parent.find('.needroom').text(suit.needroom);
                parent.attr('data',format_data(suit));
                $('#visitor_num').text(val);
                total_price();
            });
            $('.change_number').live('change',function(){
                var val=$(this).val();
                var parent=$(this).parents('.isdata');
                var suit=format_data(parent.attr('data'),true);
                if(val<1){
                    val=0;
                }
                if(suit.maxnumber>=0&&val>suit.maxnumber){
                  val=suit.maxnumber;
                }
                $(this).val(val);
                suit.number=val;
                suit.needroom=Math.ceil(val/(suit.preroompeople));
                parent.find('.needroom').text(suit.needroom);
                parent.attr('data',format_data(suit));

                total_price();
            });
            function total_price(){
                var total=0;
                var dateId;
                var suit=new Array();
                var suitId=new Array();
                var suitNumber=new Array();
                var peopleNumber=0;
                var bookNode=$('#booking_btn');
                var book=format_data(bookNode.attr('data'),true);
                $('#data_content').find('tr.isdata').each(function(){
                    suit.push(format_data($(this).attr('data'),true));
                });
                for(var i in suit){
                    if(!suit[i].needroom){
                        continue;
                    }
                    total+=parseInt(suit[i].needroom*suit[i].price);
                    peopleNumber+=parseInt(suit[i].number);
                    suitId.push(suit[i].suitid);
                    suitNumber.push(suit[i].number);
                    dateId=suit[i].dateid;
                }
                $('#visitor_num').text(peopleNumber);
                book.url=suit.length<1?'':'\'&dateid='+dateId+'&suitid='+suitId.join(',')+'&number='+suitNumber.join(',')+'\'';
                bookNode.attr('data',format_data(book));
                $('#order_total').text(total);
            }
            //提交预订数据
            $('#booking_btn').click(function(){
                var url;
                var data=format_data($(this).attr('data'),true);
                if(!data.url){
                   return;
                }
                url=window.SITEURL+'ship/book?lineid='+data.lineid+data.url;
                window.location.href=url;
            });
            //日历选择
            $("#start_time").click(function () {
                var date = $(this).text().split('-');
                get_calendar(0, this, date[0], date[1]);
            });
        })
        //格式化数据
        function format_data($obj){
            var data;
            var isString = arguments[1] ? true : arguments[1];
            if(isString){
                data=eval('('+$obj+')');
            }else{
                data=[];
                for(var k in $obj){
                    data.push(k+':'+$obj[k]);
                }
                data='{'+data.join(',')+'}';
            }
            return data;
        }
        //选择日期
        function choose_day(day, containdiv) {
            $('#start_time').text(day);
            load_data();
            layer.closeAll();
        }
        //下个月或上个月
        $('body').delegate('.prevmonth,.nextmonth', 'click', function () {

            var year = $(this).attr('data-year');
            var month = $(this).attr('data-month');
            var suitid = $(this).attr('data-suitid');
            var contain = $(this).attr('data-contain');
            get_calendar(suitid, $("#" + contain)[0], year, month);
        });
        function get_calendar(suitid, obj, year, month) {

            //加载等待
            layer.open({
                type: 3,
                icon: 2
            });
            var containdiv = '';
            if (obj) {
                containdiv = $(obj).attr('id');
            }
            var url = SITEURL + 'ship/dialog_calendar';
            var data=format_data($('#booking_btn').attr('data'),true);
            $.post(url, {
                year: year,
                month: month,
                containdiv: containdiv,
                lineid: data.lineid
            }, function (data) {
                if (data) {
                    $("#calendar").html(data);
                    show_calendar_box();
                }
            })
        }
        //显示日历
        function show_calendar_box() {
            layer.closeAll();
            layer.open({
                type: 1,
                title: '',
                area: ['580px', '390px'],
                shadeClose: true,
                content: $('#calendar').html()
            });

        }
        function load_data(){
            //var data=eval('('+$('#load_data').attr('data')+')');
            var starttime = $("#start_time").text();
            var data = {starttime:starttime,lineid:lineid};
            $.get(SITEURL+'ship/ajax_load_data',data,function(data){

                if(data.length==0){
                    return;
                }
                $('#suit_mini').text(data.suitMini);
                $('#back_time').text(data.backTime);

                var html=template('load_tpl',data);
                $('#load_content').html(html);
                $('.type-tabnav').find('span').click(function(){
                    var kindid=$(this).attr('index');
                    var obj=$('#data_content').find('tr[class^="kind_"]');
                    $(this).addClass('on').siblings().removeClass('on');
                    obj.addClass('hide');
                    $('#data_content').find('.kind_'+kindid).each(function(){
                        if(!$(this).hasClass('type-msg-layer')){
                            $(this).removeClass('hide');
                        }
                    });
                });
                $('#data_content').find('.type-tit').click(function(){
                    var next=$(this).parents('tr').next();
                    if(next.hasClass('hide')){
                        next.removeClass('hide').siblings('tr.type-msg-layer').addClass('hide');
                    }else{
                        next.addClass('hide')
                    }
                });
                $('.pack-up').click(function(){
                    $(this).parents('.type-msg-layer').addClass('hide');
                });
                //弹出图层
                $('.ck').click(function(){
                    $(".hpic-slide").slide({
                        mainCell:".bd ul",
                        delayTime:0,
                        trigger:"mouseover"
                    });
                    $(this).parents('tr').find('.pic-fixed-box').removeClass('hide');
                    $('.hp-closed').click(function(){
                        $(this).parents('.pic-fixed-box').addClass('hide');
                    })
                });
                get_bookable(data.suit);
            },'json')
        }

        function get_bookable(suits)
        {
            var bookable=false;
            for(var i in suits)
            {
                var suit = suits[i];
                if(suit['price']>0 && suit['number']!=0)
                {
                    bookable=true;
                    break;
                }
            }
            if(bookable)
            {
                $("#booking_btn").css('background','#ff7800');
                $("#booking_btn").text('开始预订');
            }
            else
            {
                $("#booking_btn").css('background','#999999');
                $("#booking_btn").text('不可预订');

            }
        }

    </script>
<div id="calendar"></div>
</body>
</html>
