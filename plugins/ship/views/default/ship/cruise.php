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
    {Common::css_plugin('ship.css','ship',0)}
    {Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,slideTabs.js,delayLoading.min.js')}
    {Common::js_plugin('floatmenu.js','ship',false)}
</head>

<body>

{request "pub/header"}

    <div class="big">
        <div class="wm-1200">

            <div class="st-guide">
                <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&nbsp;&gt;&nbsp;
                <a href="/ship/">{$channelname}</a> &nbsp;&gt;&nbsp;
                <strong>{$info['title']}</strong>
            </div>
            <!-- 面包屑 -->

            <div class="ship-about">
                <div class="pic"><img src="{Common::img($info['litpic'],1200,500)}" alt="{$info['title']}"  /></div>
                <div class="msg clearfix">
                    <div class="company-logo"><a href="javascrip:;"><img src="{$info['supplier']['litpic']}" alt="{$info['supplier']['suppliername']}" width="288" height="70" /></a></div>
                    <h1 class="name">{$info['title']}</h1>
                    <div class="attr">
                        <span><strong>{$info['weight']}吨</strong>总吨位</span>
                        <span><strong>{$info['seatnum']}人</strong>载客量</span>
                        <span><strong>{$info['length']}米</strong>船体长度</span>
                        <span><strong>{$info['width']}米</strong>船体宽度</span>
                        <span><strong>{$info['floornum']}层</strong>甲板楼层</span>
                        <span><strong>{$info['speed']}节</strong>船速</span>
                        <span class="last"><strong>{$info['sailtime']}年</strong>首航时间</span>
                    </div>
                </div>
            </div>
            <!-- 游轮信息 -->

            <div class="ship-introduce">
                <h3>游轮简介</h3>
                <div class="txt">{$info['content']}</div>
            </div>
            <!-- 游轮简介 -->

        </div>
    </div>

    <div class="big">
        <div class="wm-1200">

            <div class="ship-nav-bar">
                <span class="on">舱房介绍</span>
                {st:ship action="facility_kind" shipid="$info['id']" row="100" return="facilitykinds"}
                {loop $facilitykinds $kind}
                  <span>{$kind['title']}</span>
                {/loop}
                <span>甲板导航</span>
                <span>精选航线</span>
            </div>
            <!-- 分类介绍导航 -->

        </div>
    </div>

    <div class="big">
        <div class="ship-container">

            <div class="big-block bg-white">
                <div class="wm-1200">

                    <div class="t-tab-box">
                        <h3 class="block-tit">舱房介绍</h3>
                        <div class="t-tab-nav">
                            {st:ship action="room_kind" shipid="$info['id']"  row="100" return="roomkinds"}
                            {loop $roomkinds $roomkind}
                            <span><strong>{$roomkind['title']}</strong>{$roomkind['roomnum']}间</span>
                            {/loop}
                        </div>
                        {loop $roomkinds $roomkind}
                        <div class="t-tab-con">
                            <div class="l-tab-box clearfix">
                                <div class="l-tab-nav">
                                    {st:ship action="room" shipid="$info['id']" kindid="$roomkind['id']"  row="100" return="rooms"}
                                    {loop $rooms $room}
                                    <span>{$room['title']}</span>
                                    {/loop}
                                </div>
                                {loop $rooms $room}
                                <div class="l-tab-con">
                                    <div class="clearfix">
                                        {php}
                                           $pic_arr = explode(',',$room['piclist']);
                                           foreach($pic_arr as &$pic)
                                           {
                                              $pieces = explode('||',$pic);
                                              $pieces[0] = Common::img($pieces[0],864,580);
                                              $pic = implode('||',$pieces);
                                           }
                                           $room['piclist'] = implode(',',$pic_arr);
                                        {/php}
                                        <div class="pic" data-piclist="{$room['piclist']}"><a href="javascript:;"><img src="{Product::get_lazy_img()}" st-src="{Common::img($room['litpic'],490,332)}"  alt="{$room['title']}" width="490" height="332" /></a></div>
                                        <div class="attr">
                                            <ul class="clearfix">
                                                <li><strong>窗型：</strong>{if $room['iswindow']==1}有窗{else}无窗{/if}</li>
                                                <li><strong>入住：</strong>{$room['peoplenum']}人</li>
                                                <li><strong>面积：</strong>{$room['area']}m²</li>
                                                <li><strong>楼层：</strong>{$room['floors_str']}</li>
                                                <li class="last">
                                                    <table>
                                                        <tr><td width="45" valign="top"><strong>设施：</strong></td><td>{$room['content']}</td></tr>
                                                    </table>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                {/loop}
                            </div>
                        </div>
                        {/loop}
                    </div>

                </div>
            </div>
            <!-- 舱房介绍 -->
<script>
    var facility_arr={};
</script>
            {loop $facilitykinds $key $kind}
            <div class="big-block bg-{$key}">
                <div class="wm-1200">
                    <div class="scroll-content">
                        <h3 class="block-tit">{$kind['title']}</h3>
                        <div class="scroll-block">
                            <div class="scroll-bd">
                                <ul class="clearfix">

                                    {st:ship action="facility" shipid="$info['id']" kindid="$kind['id']" row="100" return="facilities"}
                                     {loop $facilities $facility}
                                    <li data-id="{$facility['id']}">
                                        <div class="pic"><img src="{Common::img($facility['litpic'],376,252)}" alt="" width="376" height="252" /></div>
                                        <div class="bt">{$facility['title']}</div>
                                        <div class="attr">
                                            <span>楼层：{$facility['floors_names']}</span>
                                            <span>容纳：{$facility['seatnum']}</span>
                                            <span class="last">消费：{if $facility['isfree']==1}免费{else}自费{/if}</span>
                                        </div>
                                        <div class="txt">{Common::cutstr_html($facility['content'],50)}</div>
                                    </li>
                                    {/loop}

                                </ul>
                                {loop $facilities $facility}
                                <script>
                                    facility_arr[{$facility['id']}]={json_encode($facility)}
                                </script>
                                {/loop}
                            </div>
                            <div class="scroll-hd">
                                <ul>
                                    {php}
                                        $total_facility_count=count($facilities);
                                        $block_num = ceil($total_facility_count/3);
                                        for($i=0;$i<$block_num;$i++)
                                        {
                                           echo '<li></li>';
                                        }
                                    {/php}

                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {/loop}
            <div class="big-block bg-grey">
                <div class="wm-1200">

                    <div class="deck-content">
                        <div class="block-tit">甲板导航</div>
                        <div class="deck-block">
                            <div class="deck-tab-nav">
                                {st:ship action="floor" row="100" shipid="$info['id']" return="floors"}
                                {loop $floors $floor}
                                <span>{$floor['title']}</span>
                                {/loop}
                            </div>
                            {loop $floors $floor}
                            <div class="deck-tab-con">
                                <table width="100%" border="0">
                                    <tr>
                                        <th width="15%" height="40">
                                            <div class="item-tit">舱房</div>
                                        </th>
                                        <td width="85%" height="40">
                                            <div class="txt">{if !empty($floor['roomname_arr'])}{implode('、',$floor['roomname_arr'])}{else}无{/if}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="15%" height="40">
                                            <div class="item-tit">玩乐</div>
                                        </th>
                                        <td width="85%" height="40">
                                            <div class="txt">
                                                {if !empty($floor['facilityname_arr'])}{implode('、',$floor['facilityname_arr'])}{else}无{/if}</div>
                                        </td>
                                    </tr>
                                </table>
                                <a class="check-show-btn" data-id="{$floor['id']}" href="javascript:;">甲板示意图<em>(查看具体位置)</em></a>
                            </div>
                            {/loop}
                        </div>
                    </div>

                </div>
            </div>
            <!-- 甲板导航 -->

            <div class="big-block bg-white">
                <div class="wm-1200">

                    <div class="choice-content">
                        <div class="block-tit">精选航线</div>
                        <div class="more"><a href="/ship/all-0-0-0-0-{$info['id']}-0-1" target="_blank">更多相关航线&gt;</a></div>
                        <div class="choice-block">
                            <ul class="clearfix">

                                {st:ship action="query" flag="byship" shipid="$info['id']" row="3" return="sublines"}
                                {loop $sublines $line}
                                <li class="{if $n==3}last{/if}">
                                    <a href="{$line['url']}" target="_blank" class="pic"><img src="{Product::get_lazy_img()}" st-src="{Common::img($line['litpic'],384,258)}" alt="{$line['title']}" width="384" height="258" /></a>
                                    <div class="dt clearfix">
                                        <a href="{$line['url']}" target="_blank" class="bt">{$line['title']}</a>
                                        <span class="time">{$line['schedule_name']}</span>
                                    </div>
                                    <div class="db clearfix">
                                        <span class="date">出发日期：{if !empty($line['starttime'])}{date('Y-m-d',$line['starttime'])}{/if}</span>
                                        {if $line['price']}
                                        <span class="jg"><em><i class="currency_sy">{Currency_Tool::symbol()}</i><strong>{$line['price']}</strong></em>起/人</span>
                                        {else}
                                        <span class="jg"><em><strong>电询</strong></em></span>
                                        {/if}
                                    </div>
                                </li>
                                {/loop}

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <!-- 精选航线 -->

        </div>
    </div>
{request "pub/footer"}
{request "pub/flink"}

    <div id="cabin-layer" class="content-layer">
        <div class="cabin-slide">
            <a href="javascript:;" class="prev"></a>
            <div id="cabin-close" class="cabin-close"></div>
            <div class="cabin-bd">
                <ul>

                </ul>
            </div>
            <a href="javascript:;" class="next"></a>
        </div>
    </div>
    <!-- 舱房介绍弹出层图片展示 -->

    <div id="delicacy-layer" class="content-layer">
        <div class="delicacy-block clearfix">
            <div id="delicacy-close" class="delicacy-close"></div>
            <div class="delicacy-slide">
                <ul class="bigImg">

                </ul>
                <div class="smallScroll">
                    <a class="sPrev prevStop" href="javascript:void(0)"></a>
                    <div class="smallImg">
                        <ul>

                        </ul>
                    </div>
                    <a class="sNext" href="javascript:void(0)"></a>
                </div>
            </div>
            <div class="delicacy-js">
                <h3 id="fac_title"></h3>
                <div class="txt" id="fac_content"></div>
                <ul class="list">
                    <li class="clearfix">
                        <strong>开放时间</strong>
                        <p id="fac_opentime"></p>
                    </li>
                    <li class="clearfix">
                        <strong>是否免费</strong>
                        <p id="fac_isfree"></p>
                    </li>
                    <li class="clearfix">
                        <strong>所在楼层</strong>
                        <p id="fac_floors_names"></p>
                    </li>
                    <li class="clearfix">
                        <strong>着装建议</strong>
                        <p id="fac_dress"></p>
                    </li>
                    <li class="clearfix">
                        <strong>特色</strong>
                        <p id="fac_sellpoint"></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- 美食餐厅弹出层图片展示 -->

    <div id="deck-layer" class="content-layer">
        <div class="deck-container clearfix">
            <div id="deck-close" class="deck-close"></div>
            <div class="deck-tabbox">
                <div class="deck-tabnav">
                    {loop $floors $floor}
                    <span id="box_floor_{$floor['id']}">{$floor['title']}</span>
                    {/loop}
                </div>
                {loop $floors $floor}
                <div class="deck-tabnr" style="display: block;">
                    <div class="scroll-img"><img src="{$floor['litpic']}" alt="{$floor['title']}" width="510"></div>
                    <div class="deck-type">
                        <a href="javascript:;" class="topBtn"></a>
                        <div class="type-list clearfix">
                            <h3>舱房类型</h3>
                            <ul class="cf-list clearfix">
                                {loop $floor['roomname_arr'] $name}
                                <li>{$name}</li>
                                {/loop}
                            </ul>
                        </div>
                        <div class="type-list clearfix">
                            <h3>邮轮娱乐</h3>
                            <ul class="clearfix">
                                {loop $floor['facilityname_arr'] $name}
                                <li>{$name}</li>
                                {/loop}
                            </ul>
                        </div>
                        <a href="javascript:;" class="bomBtn"></a>
                    </div>
                </div>
                {/loop}
            </div>

        </div>
    </div>
    <!-- 甲板导航弹出 -->

    <script>

        $(function(){

            //切换房型
            $(".t-tab-box").switchTab({
                titCell: ".t-tab-nav span",
                mainCell: ".t-tab-con",
                trigger: "hover"
            });

            //floatMenu导航
            $.floatMenu({
                menuContain : '.ship-nav-bar',
                tabItem : 'span',
                chooseClass : 'on',
                contentContain : '.ship-container',
                itemClass : '.big-block'
            });

            //切换产品
            $(".l-tab-box").switchTab({
                titCell: ".l-tab-nav span",
                mainCell: ".l-tab-con",
                trigger: "hover"
            });

            //美食展示
            $(".scroll-block").slide({
                mainCell:".scroll-bd ul",
                titCell:".scroll-hd li",
                effect:"left",
                vis:3,
                scroll:3,
                autoPlay:true,
                interTime:5000,
                delayTime:500
            });

            //甲板导航
            $(".deck-block").switchTab({
                titCell: ".deck-tab-nav span",
                mainCell: ".deck-tab-con",
                trigger: "hover"
            });

            //舱房图片
            $(".cabin-slide").slide({
                mainCell:".cabin-bd ul",
                effect:"left",
                interTime: 2000,
                delayTime: 500,
                autoPlay:false
            });

            $(".l-tab-con .pic").on("click",function(){

                var picstr = $(this).data('piclist');
                if(!picstr)
                   return;

                var arr = get_piclist(picstr);
                var html='';
                for(var i in arr)
                {
                   html+='<li><a href="javascript:;"><img src="'+arr[i][0]+'" alt="'+arr[i][1]+'" /></a></li>'
                }
                $("#cabin-layer ul").html(html);
                $(".cabin-slide").slide({
                    mainCell:".cabin-bd ul",
                    effect:"left",
                    interTime: 2000,
                    delayTime: 500,
                    autoPlay:false
                });
                $("#cabin-layer").show();

            });

            $("#cabin-close").on("click",function(){
                $("#cabin-layer").hide()
            });

            //滚动产品弹出图片

            $(".delicacy-slide .smallScroll").slide({
                mainCell:"ul",
                interTime:5000,
                delayTime:500,
                vis:5,
                scroll:5,
                effect:"left",
                autoPage:true,
                prevCell:".sPrev",
                nextCell:".sNext",
                pnLoop:false
            });

            $(".scroll-bd li").on("click",function(){
                show_facility(this);
            });

            $("#delicacy-close").on("click",function(){
                $("#delicacy-layer").hide()
            });

            //甲板导航楼层图切换
            $(".deck-tabbox").switchTab({
                titCell: ".deck-tabnav span",
                mainCell: ".deck-tabnr",
                trigger: "click"
            });

            $(".check-show-btn").on("click",function(){
                var floorid = $(this).data('id');
                $("#box_floor_"+floorid).trigger('click');
                $("#deck-layer").show()
            });

            $("#deck-close").on("click",function(){
                $("#deck-layer").hide()
            });

        })

        //显示设施详情
        function show_facility(ele)
        {
            var id = $(ele).data('id');
            var facility = facility_arr[id];
            var piclist = get_piclist(facility['piclist']);
            var bigimgHtml='';
            var smallimgHtml='';
            for(var i in piclist)
            {
                var pic = piclist[i];
                bigimgHtml+='<li><a href="javascript:;"><img src="'+pic[0]+'" width="534" height="362" /></a></li>';
                smallimgHtml+='<li><a><img src="'+pic[0]+'" width="83" height="58" /></a></li>';
            }

            $("#delicacy-layer").find(".smallImg ul").html(smallimgHtml);
            $("#delicacy-layer").find(".bigImg").html(bigimgHtml);

            facility['isfree'] = facility['isfree']==1?'免费':'自费';
            for(var i in facility)
            {
               var field_ele =  $("#delicacy-layer").find("#fac_"+i);
                if(field_ele.length>0)
                {
                    field_ele.html(facility[i]);
                }
            }


            $(".delicacy-slide").slide({
                titCell:".smallImg li",
                mainCell:".bigImg",
                effect:"fold",
                autoPlay:true,
                interTime:5000,
                delayTime:500,
                startFun:function(i){
                    if(i==0)
                    {
                        $(".delicacy-slide .sPrev").click()
                    }
                    else if( i%5==0 )
                    {
                      //  $(".delicacy-slide .sNext").click()
                    }
                }
            });
            $(".delicacy-slide .smallScroll").slide({
                mainCell:"ul",
                interTime:5000,
                delayTime:500,
                vis:5,
                scroll:5,
                effect:"left",
                autoPage:true,
                prevCell:".sPrev",
                nextCell:".sNext",
                pnLoop:false
            });
            $("#delicacy-layer").show()

        }

        //获取图片数组
        function get_piclist(str)
        {
            if(!str || str=='')
               return '';
            var pic_arr=str.split(',');
            for(var i in pic_arr)
            {
                pic_arr[i] = pic_arr[i].split(',');
            }
            return pic_arr;
        }
    </script>
</body>
</html>
