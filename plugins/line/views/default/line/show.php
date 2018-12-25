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

    {Common::css_plugin('lines.css','line')}
    {Common::css('base.css,extend.css,calendar.css,jquery.fancybox.css')}
    {Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js,floatmenu/floatmenu.js,SuperSlide.min.js,scorll.img.js,template.js,date.js,calendar.js')}
    {Common::js('jquery.fancybox.js')}

    {Common::css('/res/js/floatmenu/floatmenu.css',0,0)}

</head>

<body bottom_ul=_GACXC >
{request "pub/header"}
{if St_Functions::is_normal_app_install('coupon')}
{request 'coupon/float_box-'.$typeid.'-'.$info['id']}
{/if}
    <div class="big">
        <div class="wm-1200">

            <div class="st-guide">
                {st:position action="show_crumbs" typeid="$typeid" info="$info"}
            </div>
            <!--面包屑-->

            <div class="st-main-page">
                <div class="st-line-show">

                    <div class="lineshow-tw">
                        <div class="lw-title">
                            <h1>{if $info['color']}<span style="color:{$info['color']}">{$info['title']}</span>{else}{$info['title']}{/if}
                                {if $GLOBALS['cfg_icon_rule']==1}
                                {loop $info['iconlist'] $icon}
                                <span class="sell-point">{$icon['kind']}</span>
                                {/loop}
                                {else}
                                {loop $info['iconlist'] $icon}
                                <img src="{$icon['litpic']}" />
                                {/loop}
                                {/if}
                            </h1>
                            <div class="sp-tip">
                                <span class="num">线路编号：{$info['series']}</span>
                                {$info['sellpoint']}
                            </div>
                        </div>

                        <!-- 线路轮播图 -->
                        <div class="slide-content">
                            <ul class="bigImg">
                                {loop $info['piclist'] $pic}
                                <li><a href="javascript:;"><img src="{Common::img($pic[0],460,312)}" /></a></li>
                                {/loop}
                            </ul>
                            <div class="smallScroll clearfix">
                                <a class="sPrev prevStop" href="javascript:void(0)"></a>
                                <div class="smallImg">
                                    <ul>
                                        {loop $info['piclist'] $pic}
                                        <li><a href="javascript:;"><img src="{Common::img($pic[0],122,82)}" width="90" height="60"/></a></li>
                                        {/loop}
                                    </ul>
                                </div>
                                <a class="sNext" href="javascript:void(0)"></a>
                            </div>
                            <div id="default-bdshare" class="bdshare_t bds_tools get-codes-bdshare bdsharebuttonbox">
                                <a class="bds_more" data-cmd="more">分享</a>
                            </div>
                        </div>

                        <div class="product-show-info">
                            <div class="ps-price-block " id="min_price_tips">
                                <span class="pri-sale {if empty($info['price'])}hide{/if}  min_price-tips">优惠价：{Currency_Tool::symbol()}<span class="num" id="minprice">{$info['price']}</span>起</span>
                                <span class="pri-sale  {if !empty($info['price'])}hide{/if} min_price-tips">优惠价：<span class="num">电询</span></span>
                                {if $GLOBALS['cfg_line_price_description']}
                                <div class="pop-info-explain">
                                    <span class="tit">起价说明</span>
                                    <div class="txt clearfix">
                                        {$GLOBALS['cfg_line_price_description']}
                                    </div>
                                </div>
                                {/if}
                                <span class="pri-base" style="display: none;">原价：{Currency_Tool::symbol()}<em id="sellprice">{$info['sellprice']}</em></span>
                            </div>
                            <div class="ps-data-block">
                                <span class="item">销量：{$info['sellnum']}</span><i></i>
                                <span class="item">满意度：{$info['score']}</span><i></i>
                                <span class="item"><a href="#comment_target">{$info['commentnum']}条点评</a></span>
                            </div>
                            {st:line action="suit" productid="$info['id']"}
                            {if $data && $info['status']==3}
                            <div class="ps-type-block">
                                <div class="info-bar">
                                    <span class="item-hd">套餐类型：</span>
                                    <div class="item-bd">

                                        {loop $data $s}
                                        <div class="ps-attr-wrapper">
                                            <span class="attr-item change-suit {if $s['minprice']}hasprice{/if}" data-number="{$s['number']}"  data-adultdest="{$s['adultdesc']}"  data-childdesc="{$s['childdesc']}"  data-olddesc="{$s['olddesc']}" data-roomdesc="{$s['roomdesc']}"  data-sellprice="{$s['sellprice']}" data-suitid="{$s['id']}" title="{$s['title']}" data-minprice="{$s['minprice']}" data-jifentprice="{$s['jifentprice']}" data-jifenbook="{$s['jifenbook']}">{$s['suitname']}</span>
                                            <div class="attr-info">
                                                <dl class="dl clearfix">
                                                    <dt class="dt">套餐说明：</dt>
                                                    <dd class="dd">{$s['description']}</dd>
                                                </dl>
                                                <dl class="dl clearfix">
                                                    <dt class="dt">支付方式：</dt>
                                                    {if $s['paytype']==1}
                                                    <dd class="dd">全额预订</dd>
                                                    {elseif $s['paytype']==2}
                                                    <dd class="dd">定金预订</dd>
                                                    {else}
                                                    <dd class="dd">二次确认</dd>
                                                    {/if}
                                                </dl>
                                            </div>
                                        </div>
                                        {/loop}
                                    </div>
                                </div>
                                <div class="info-bar">
                                    <span class="item-hd">出发日期：</span>
                                    <div class="item-bd">
                                        <select class="start-date-select date-list">
                                            <option value="0">请选择日期</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="info-bar book-num" style="display: none">
                                    <span class="item-hd">出游人数：</span>
                                    <div class="item-bd">
                                        <ul class="type-num-bar">
                                            <li class="item adult_price">
                                                <span class="amount-opt-wrap">
                                                    <a href="javascript:;" class="sub-btn go-un">–</a>
                                                    <input type="text" class="num-text adult" maxlength="4" value="2" disabled>
                                                    <a href="javascript:;" class="add-btn">+</a>
                                                </span>
                                                <span class="h-label"></span>

                                            </li>
                                            <li class="item child_price">
                                                <span class="amount-opt-wrap">
                                                    <a href="javascript:;" class="sub-btn go-un">–</a>
                                                    <input type="text" class="num-text child" maxlength="4" value="0" disabled>
                                                    <a href="javascript:;" class="add-btn">+</a>
                                                </span>
                                                <span class="h-label "></span>
                                                <div class="pop-info-explain">
                                                    <span class="tit">儿童标准</span>
                                                    <div class="txt clearfix">

                                                    </div>
                                                </div>
                                            </li>
                                            <li class="item old_price">
                                                <span class="amount-opt-wrap">
                                                    <a href="javascript:;" class="sub-btn go-un">–</a>
                                                    <input type="text" class="num-text old" maxlength="4" value="0" disabled>
                                                    <a href="javascript:;" class="add-btn">+</a>
                                                </span>
                                                <span class="h-label"></span>
                                                <div class="pop-info-explain">
                                                    <span class="tit">老人标准</span>
                                                    <div class="txt clearfix">

                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="info-bar room_price" style="display: none">
                                        <span class="item-hd">&nbsp;&nbsp;&nbsp;&nbsp;单房差&nbsp;: </span>
                                        <div class="item-bd">
                                            <ul class="type-num-bar">
                                            <li class="item room_price">
                                                <span class="amount-opt-wrap">
                                                        <a href="javascript:;" class="sub-btn go-un">–</a>
                                                        <input type="text" class="num-text room" maxlength="4" value="0" disabled>
                                                        <a href="javascript:;" class="add-btn">+</a>
                                                    </span>
                                                <span class="h-label"></span>
                                                <div class="pop-info-explain">
                                                    <span class="tit">单房差标准</span>
                                                    <div class="txt clearfix">

                                                    </div>
                                                </div>
                                            </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-bar">
                                    <span class="item-hd">&nbsp;</span>
                                    <div class="item-bd">
                                        <a href="javascript:;" style="display:none " class="booking-btn-link btn-yd status-over">立即预订</a>
                                    </div>
                                </div>

                            </div>
                            {/if}
	                        {if $info['status']!=3}
	                        <div class="ps-under-block">非常抱歉！该商品已下架！</div>
	                        {/if}
                            <ul class="ps-info-block">
                                {if !empty($info['startcity'])}
                                <li>
                                    <span class="item-hd">出发地：</span>
                                    <div class="item-bd">{$info['startcity']}</div>
                                </li>
                                {/if}
                                {if $info['lineday']||$info['linenight']}
                                <li>
                                    <span class="item-hd">旅游天数：</span>
                                    <div class="item-bd">{$info['lineday']}天{$info['linenight']}晚</div>
                                </li>
                                {/if}
                                {if !empty($info['jifentprice_info']) || !empty($info['jifenbook_info']) || !empty($info['jifencomment_info'])}
                                <li>
                                    <span class="item-hd">积分优惠：</span>
                                    <div class="item-bd">
                                        {if !empty($info['jifentprice_info'])}
                                        <div class="jf-type-wrap">
                                            <span class="di num">{Currency_Tool::symbol()}{$info['jifentprice_info']['jifentprice']}<i></i></span>
                                            <div class="info">
                                                <strong class="tit">积分抵现金</strong>
                                                <p class="txt">预订产品可使用积分抵现金，最高可抵{Currency_Tool::symbol()}{$info['jifentprice_info']['jifentprice']}。</p>
                                            </div>
                                        </div>
                                        {/if}
                                        {if !empty($info['jifenbook_info'])}
                                        <div class="jf-type-wrap">
                                            <span class="ding num">{$info['jifenbook_info']['value']}{if $info['jifenbook_info']['rewardway']==1}%{else}分{/if}<i></i></span>
                                            <div class="info">
                                                <strong class="tit">预订送积分</strong>
                                                <p class="txt">预订产品并消费成功可获得积分赠送，可获得{if $info['jifenbook_info']['rewardway']==1}订单总额{$info['jifenbook_info']['value']}%的{else}{$info['jifenbook_info']['value']}{/if}积分。</p>
                                            </div>
                                        </div>
                                        {/if}
                                        {if !empty($info['jifencomment_info'])}
                                        <div class="jf-type-wrap">
                                            <span class="ping num">{$info['jifencomment_info']['value']}分<i></i></span>
                                            <div class="info">
                                                <strong class="tit">评论送积分</strong>
                                                <p class="txt">预订并消费产品后，评论产品通过审核可获得{$info['jifencomment_info']['value']}积分</p>
                                            </div>
                                        </div>
                                        {/if}
                                    </div>
                                </li>
                                {/if}

                                {if St_Functions::is_normal_app_install('together')}
                                {php}
                                $together = Model_Together::get_product_show_list($typeid,$info['id']);
                                $url = Common::get_web_url($info['webid']).'/lines/show_'.$info['aid'].'.html';
                                {/php}
                                {if $together}
                                <li>
                                    <span class="item-hd">拼团返现：</span>
                                    <div class="item-bd">
                                        <div class="group-sale-box">
                                            <div class="group-box">
                                                {loop $together $t}
                                                <span class="item">{$t['people_number']}人拼成返{$t['price']}元</span>
                                                {/loop}
                                            </div>
                                            <div class="group-btn">
                                                <a href="javascript:;" class="group-more-btn">更多></a>
                                                <div class="code-layer-box">
                                                    <div class="pic"><img src="/res/vendor/qrcode/make.php?param={$url}" alt="" /></div>
                                                    <p>扫描上方二维码，即刻参与拼团优惠活动！</p>
                                                    <i class="close-ico"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                {/if}
                                {/if}
                                {if $info['linebefore']}
                                <li>
                                    <span class="item-hd">提前预定：</span>
                                    <div class="item-bd">建议提前{$info['linebefore']}天预定</div>
                                </li>
                                {/if}
                                {if $info['suppliername']}
                                <li class="mb_0">
                                    <span class="item-hd">供应商：</span>
                                    <div class="item-bd">
                                        <span>{$info['suppliername']}</span>
                                    </div>
                                </li>
                                {/if}
                            </ul>
                        </div>
                    </div>

                    <div class="lineshow-con">
                        <div class="tab-fix-bar">
                            <div class="tabnav-list">
                                <span class="on">在线预订</span>
                                {st:detailcontent action="get_content" pc="1" typeid="$typeid" productinfo="$info" return="linecontent"}
                                {loop $linecontent $row}
                                <span>{$row['chinesename']}</span>
                                {/loop}
                                {/st}
                                <span>客户评价</span>
                                <span>我要咨询</span>
                                {if $data && $info['status']==3}
                                <a class="yd-btn btn-yd yd-btn-menu"  style="display: none;background: #ccc"  href="javascript:;">立即预订</a>
                                {/if}
                            </div><!--线路导航-->
                        </div>
                        <div class="tabbox-list">
                            <div class="tabcon-list" id="calendar">

                            </div>
                            {loop $linecontent $line}
                            {if preg_match('/^\d+$/',$line['content']) && $line['columnname']=='jieshao'}
                            <div class="tabcon-list">
                                <div class="list-tit">
                                    <strong>{$line['chinesename']}</strong>
                                    {php}$index=1;{/php}

                                    {loop $info['linedoc']['path'] $k $v}
                                    {if $index==1}
                                    <a class="fr travel-plan-link" href="/pub/download/?file={$v}&name={$info['linedoc']['name'][$k]}">下载行程</a>
                                    {/if}
                                    {php}$index++;{/php}
                                    {/loop}
                                    <a class="fr travel-plan-link" target="_blank" href="/line/print/id/{$info['id']}">打印行程</a>
                                </div>
                                {if $info['isstyle']==2}
                                <div class="eachday">
                                    {php $indexkey = 1; $day_str='';}
                                    {loop Model_Line_Jieshao::detail($line['content'],$info['lineday']) $v}
                                    {php} if(!$v['title']){break;}   $day_str.= '<li><a href="#day_c_'.$indexkey.'" class="">DAY'.$indexkey.'</a></li>';{/php}


                                    <div class="day-con part" id="day_c_{$indexkey}">
                                        <div class="day-num"><i class="sz">{$v['day']}</i></div>
                                        <div class="day-tit"><strong>第{Common::daxie($v['day'])}天</strong><p>{$v['title']}</p></div>
                                        <table class="day-tb" width="100%" border="0" bgcolor="#f9f8f8">
                                            {if $info['showrepast']==1}
                                            <tr>
                                                <th width="110" scope="row"><span class="yc">用餐情况：</span></th>
                                                <td width="237">
                                                    {if $v['breakfirsthas']}
                                                    {if !empty($v['breakfirst'])}
                                                    早餐：{$v[breakfirst]}
                                                    {else}
                                                    早餐：含
                                                    {/if}
                                                    {else}
                                                    早餐：不含
                                                    {/if}
                                                </td>
                                                <td width="237">
                                                    {if $v['lunchhas']}
                                                    {if !empty($v['lunch'])}
                                                    午餐：{$v[lunch]}
                                                    {else}
                                                    午餐：含
                                                    {/if}
                                                    {else}
                                                    午餐：不含
                                                    {/if}
                                                </td>
                                                <td width="237">

                                                    {if $v['supperhas']}
                                                    {if !empty($v['supper'])}
                                                    晚餐：{$v['supper']}
                                                    {else}
                                                    晚餐:含
                                                    {/if}
                                                    {else}
                                                    晚餐:不含
                                                    {/if}
                                                </td>
                                            </tr>
                                            {/if}
                                            {if $info['showhotel']==1 && !empty($v['hotel'])}
                                            <tr>
                                                <th width="110" scope="row"><span class="zs">住宿情况：</span></th>
                                                <td colspan="3">{$v['hotel']}</td>
                                            </tr>
                                            {/if}
                                            {if $info['showtran']==1 && !empty($v['transport'])}
                                            <tr class="bor_0">
                                                <th width="110" scope="row"><span class="gj">交通工具：</span></th>
                                                <td colspan="3">
                                                    {loop explode(',',$v['transport']) $t}
                                                    {$t}
                                                    {/loop}
                                                </td>
                                            </tr>
                                            {/if}
                                        </table>
                                        <div class="txt">
                                            {Common::content_image_width($v['jieshao'],791,0)}
                                        </div>
                                        {if St_Functions::is_system_app_install(5)}
                                        <ul class="jd-lsit">
                                            {st:line action="line_spot" day="$v['day']" productid="$v['lineid']" return="spotlist"}
                                            {php $sindex=1;}
                                            {loop $spotlist $spot}
                                            <li {if $sindex%3==0}class="mr_0"{/if}>
                                                <a class="pic" href="{$spot['url']}" target="_blank"><img src="{Common::img($spot['litpic'],240,162)}" alt="{$spot['title']}" /></a>
                                                <a class="tit" href="{$spot['url']}" target="_blank">{$spot['title']}</a>
                                            </li>
                                            {php $sindex++;}
                                            {/loop}
                                        </ul>
                                        {/if}
                                    </div>
                                    {php $indexkey++;}
                                    {/loop}
                                    <div class="day-leftnav" id="day-leftNav">
                                        <ul class="day-navlist">
                                            {$day_str}

                                        </ul>
                                    </div>
                                    <div class="end"></div>
                                </div>
                                {else}
                                <div class="list-txt">
                                    {Common::content_image_width($info['jieshao'],791,0)}
                                </div>
                                {/if}
                            </div>
                            {else}
                            <div class="tabcon-list">
                                <div class="list-tit">
                                    <strong>{$line['chinesename']}</strong>
                                    {if $line['columnname']=='jieshao'}
                                    <a class="fr travel-plan-link" target="_blank" href="/line/print/id/{$info['id']}">打印行程</a>
                                    {/if}
                                </div>
                                <div class="list-txt">
                                    {Common::content_image_width($line['content'],833,0)}
                                </div>
                            </div>
                            {/if}
                            {/loop}
                            {include "pub/comment"}
                            {include "pub/ask"}

                        </div>
                    </div>
                </div>
                <!--详情主体-->
                <div class="st-sidebox">
                    {st:right action="get" typeid="$typeid" data="$templetdata" pagename="show"}
                </div>
                <!--边栏模块-->
            </div>

        </div>
        <!--隐藏域-->
        <input type="hidden" id="suitid" value=""/>
        <input type="hidden" id="lineid" value="{$info['id']}"/>
        <input type="hidden" id="adultnum" value="0"/>
        <input type="hidden" id="childnum" value="0"/>
        <input type="hidden" id="oldnum" value="0"/>
        <input type="hidden" id="roomnum" value="0"/>
    </div>

    {request "pub/footer"}
    {request "pub/flink"}
{include "member/login_order"}
    <script>
        $(function(){

            insertVideo();

            //轮播图
            $(".slide-content").slide({
                titCell:".smallImg li",
                mainCell:".bigImg",
                effect:"fold",
                autoPlay:false,
                interTime:5000,
                delayTime:500
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


            //切换套餐
            $('.change-suit').click(function(){
                var minprice=$(this).attr('data-minprice');
                var sellprice=$(this).attr('data-sellprice');
                $('#min_price_tips .min_price-tips').addClass('hide');
                if(parseFloat(minprice)>0){
                    $('#min_price_tips .min_price-tips:first').removeClass('hide');
                    $('#minprice').text(minprice);
                    $('#minprice').removeClass('hide');
                }else{
                    $('#min_price_tips .min_price-tips:eq(1)').removeClass('hide');
                }
                if(parseFloat(sellprice)>0){
                    $('.pri-base').show();
                    $('#sellprice').text(sellprice);
                }else{
                    $('.pri-base').hide();
                }
                var suitid = $(this).attr('data-suitid');
                $("#suitid").val(suitid);
                $('.change-suit').removeClass('active');
                $(this).addClass('active');
                var lineid = $("#lineid").val();
                get_calendar(suitid,lineid);
                get_date_list(suitid,lineid);

            });
            //优先选中有报价的.
            if($('.hasprice').length>0){
                $('.hasprice').first().trigger('click');
            }else{
                $('.change-suit').first().trigger('click');
            }
            //预定日期变化
            $('.date-list').change(function () {
                change_date()
            });

            //预订页面
            $('body').delegate('.gobook','click',function(){
                var usedate = $('.date-list').val();
                var suitid = $('#suitid').val();
                var lineid = $('#lineid').val();
                if(usedate == null){
                    return false;
                }
                var adultnum = $('#adultnum').val();
                var childnum = $('#childnum').val();
                var oldnum = $('#oldnum').val();
                if((Number(adultnum)+Number(childnum)+Number(oldnum))<=0)
                {
                    return false;
                }
                var roomnum = $('#roomnum').val();



                if(!is_login_order()){
                    return false;
                }

                var url = SITEURL+"lines/book/?usedate="+usedate+"&lineid="+lineid+"&suitid="+suitid+'&adultnum='+adultnum+'&childnum='+childnum+'&oldnum='+oldnum+'&roomnum='+roomnum;
                window.location.href = url;

            });
            //数量改变
            $('.book-num .add-btn').click(function () {
                var number = $(this).prev().val();
                var store = $('.date-list option:selected').data('store');
                var total = Number($('.adult_price .num-text').val())+Number($('.child_price .num-text').val())+Number($('.old_price .num-text').val())
                if(store!=-1&&store<(total+1))
                {
                    return false;
                }

                number ++ ;
                $(this).prev().val(number);
                number_change();
            });
            $('.book-num .sub-btn').click(function () {
                var number = $(this).next().val();
                if(number>0)
                {
                    number -- ;
                }
                $(this).next().val(number);
                number_change();
            })




        });

        //数量改变
        function number_change() {
            var total = 0;
            $('.book-num .num-text').each(function (i,v) {
                var number = $(v).val();
                total += Number(number);
                if($(v).hasClass('adult'))
                {
                    $('#adultnum').val(number)
                }
                if($(v).hasClass('child'))
                {
                    $('#childnum').val(number)
                }
                if($(v).hasClass('old'))
                {
                    $('#oldnum').val(number)
                }
                if($(v).hasClass('room'))
                {
                    $('#roomnum').val(number)
                }
            })
            //总数为0不可预定
            if(total==0)
            {
                $('.booking-btn-link').removeClass('status-ing');
                $('.booking-btn-link').addClass('status-over');
            }
            else
            {
                $('.booking-btn-link').removeClass('status-over');
                $('.booking-btn-link').addClass('status-ing');
            }
        }

        //下拉日期改变
        function change_date() {
            var obj = $('.date-list').find('option:selected');
            var adult = $(obj).data('adult');
            var child = $(obj).data('child');
            var old = $(obj).data('old');
            var room = $(obj).data('room');

            var store = $(obj).data('store');
            var adultnum = 2;

            if(store!=-1&&store<2)
            {
                adultnum = 1;
            }
            if(adult>0||child>0||old>0||room>0)
            {
                $('.book-num').show();
                $('.adult_price .num-text').val(adultnum);
                $('.child_price .num-text').val(0);
                $('.old_price .num-text').val(0);
                $('.room_price .num-text').val(0);
                adult>0 ?  $('.adult_price').show() : $('.adult_price').hide();
                child>0 ?  $('.child_price').show() : $('.child_price').hide();
                old>0 ?  $('.old_price').show() : $('.old_price').hide();
                room>0 ? $('.room_price').show() : $('.room_price').hide();
                $('.adult_price .h-label').text(CURRENCY_SYMBOL+adult+'/成人');
                $('.child_price .h-label').text(CURRENCY_SYMBOL+child+'/儿童');
                $('.old_price .h-label').text(CURRENCY_SYMBOL+old+'/老人');
                $('.room_price .h-label').text(CURRENCY_SYMBOL+room+'/人');
                $('.change-suit').each(function (i,suit) {
                    if($(suit).hasClass('active'))
                    {
                        //var adultdest = $(suit).data('adultdest');
                        var childdesc = $(suit).data('childdesc');
                        var olddesc = $(suit).data('olddesc');
                        var roomdesc = $(suit).data('roomdesc');



                       // $('.adult_price .pop-info-explain .txt').text(adultdest);
                        $('.child_price .pop-info-explain .txt').text(childdesc);
                        $('.old_price .pop-info-explain .txt').text(olddesc);
                        $('.room_price .pop-info-explain .txt').text(roomdesc);
                        /*if(!adultdest)
                        {
                            $('.adult_price .pop-info-explain').hide();
                        }*/
                        if(!childdesc)
                        {
                            $('.child_price .pop-info-explain').hide();
                        }
                        else
                        {
                            $('.child_price .pop-info-explain').show();
                        }
                        if(!olddesc)
                        {
                            $('.old_price .pop-info-explain').hide();
                        }
                        else
                        {
                            $('.old_price .pop-info-explain').show();
                        }
                        if(!roomdesc)
                        {

                            $('.room_price .pop-info-explain').hide();
                        }
                        else
                        {
                            $('.room_price .pop-info-explain').show();
                        }
                    }
                });
            }
            else
            {
                $('.book-num').hide();
            }
        }

        //获取日历报价
        function get_calendar(suitid,lineid)
        {

            showCalendar('calendar',suitid,function(){$(".calendar:first").css("margin-right","15px")},lineid);
        }

        //获取日历下拉列表
        function get_date_list(suitid,lineid){
            $.ajax({
                type:'POST',
                url:SITEURL+'line/ajax_date_options',
                data:{suitid:suitid,lineid:lineid},
                dataType:'json',
                success:function(data){
                    $('.date-list').empty();
                    var html = '';
                    if(data.list!=''){

                        $.each(data.list,function(i,row){

                            var people = '';
                            if(row.adultprice>0){
                                people+='{Currency_Tool::symbol()}'+row.adultprice+'/成人 ';
                            }
                            if(row.childprice>0){
                                people+='{Currency_Tool::symbol()}'+row.childprice+'/儿童 ';
                            }
                            if(row.oldprice>0){
                                people+='{Currency_Tool::symbol()}'+row.oldprice+'/老人 ';
                            }

                            if(i==0){
                                if(row.number==-1){
                                    $('#adultnum').val(2);
                                }else if(row.number>=2){
                                    $('#adultnum').val(2);
                                }else{
                                    $('#adultnum').val(row.number);
                                }
                            }
                            html+='<option data-room="'+row.roombalance+'" data-adult="'+row.adultprice+'" data-store="'+row.number+'" data-child="'+row.childprice+'" data-old="'+row.oldprice+'" value="'+row.useday+'">'+row.shortdate+'('+row.weekday+')'+people+'</option>';
                            $('.booking-btn-link').addClass('status-ing');
                            $(".btn-yd").addClass('gobook');
                            $('.booking-btn-link').removeClass('status-over');
                            $(".btn-yd").text('立即预定');
                            $(".booking-btn-link").show();
                            $(".yd-btn").css('background','#ff8a00');
                        })
                    }
                    else if(data.hasprice==0) {
                        html+='<option value="0">请选择日期</option>';
                        $(".btn-yd").text('立即预定');
                        $('.booking-btn-link').addClass('status-over');
                        $('.booking-btn-link').removeClass('status-ing');
                        $(".yd-btn").css('background','#ccc');
                        $(".btn-yd").removeClass('gobook');
                        $(".booking-btn-link").show();

                    }
                    else
                    {
                        html+='<option value="0">请选择日期</option>';
                        $(".btn-yd").text('订完');
                        $('.booking-btn-link').addClass('status-over');
                        $('.booking-btn-link').removeClass('status-ing');
                        $(".yd-btn").css('background','#ccc');
                        $(".btn-yd").removeClass('gobook');
                        $(".booking-btn-link").show();
                    }
                    $('.date-list').append(html);
                    change_date();

                }
            })
        }

        //预订产品
        function setBeginTime(y,m,d,price,lineid,suitid)
        {
            if(!is_login_order()){
                return false;
            }

            var udate = y+'-'+m+'-'+d;

            var adultnum = $('#adultnum').val();
            var childnum = $('#childnum').val();
            var oldnum = $('#oldnum').val();
            var roomnum = $('#roomnum').val();

            var url = SITEURL+"lines/book/?usedate="+udate+"&lineid="+lineid+"&suitid="+suitid+'&adultnum='+adultnum+'&childnum='+childnum+'&oldnum='+oldnum+'&roomnum='+roomnum;
            window.location.href = url;
        }

        //视屏
        function insertVideo(){
            {if $info['product_video']}
            //{php}list($videoPath)=explode('|',$info['product_video']){/php}
            var video, output,
                    smallLiElem = "<li><a id='output' href='javascript:;'></a></li>",
                    bigLIElem = '<li>' +
                            '<video id="video" class="lib-video" width="460" height="312" controls src="{$videoPath}" type="video/mp4">浏览器版本太低，请升级查看。</video>' +
                            '<span class="vis-play-btn"></span>' +
                            '</li>';
            $(".smallImg").find("ul").prepend(smallLiElem);
            $(".bigImg").prepend(bigLIElem);

            //视频
            var initialize = function() {
                output = document.getElementById("output");
                video = document.getElementById("video");
                video.addEventListener('loadeddata',captureImage);
                $(".vis-play-btn").on("click",function(){
                    $(this).hide();
                    video.play();
                });
                video.onended = function(){
                    $(".vis-play-btn").show()
                }
            };

            var captureImage = function() {
                var canvas = document.createElement("canvas");
                canvas.width = 122;
                canvas.height = 80;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

                var img = document.createElement("img");
                img.src = canvas.toDataURL("image/png");
                output.appendChild(img);
            };

            initialize();
            {/if}
        }
    </script>

<script>

    $(function () {
        //起价说明
        $(".pop-info-explain").hover(function(){
            $(this).children(".txt").show()
        },function(){
            $(this).children(".txt").hide()
        });

        //套餐说明
        $(".ps-attr-wrapper").hover(function(){
            $(this).children(".attr-info").show()
        },function(){
            $(this).children(".attr-info").hide()
        });

        //积分
        $(".jf-type-wrap").hover(function(){
            $(this).children(".info").show()
        },function(){
            $(this).children(".info").hide()
        });

        var topHeight = $('.tabnav-list').offset().top;
        $(window).scroll(function(){
            if($(document).scrollTop() >= topHeight){
                $(".yd-btn-menu").show()
            }else{
                $(".yd-btn-menu").hide();
            }
        });

        //floatMenu导航
        $.floatMenu({
            menuContain : '.tabnav-list',
            tabItem : 'span',
            chooseClass : 'on',
            contentContain : '.tabbox-list',
            itemClass : '.tabcon-list'
        });
        if($(".part").length>0)
        {
            function pageScroll() {
                var scrollTop = $(window).scrollTop();
                var size = $(".day-navlist a").size();
                var listTop = $(".part").eq(0).offset().top;
                if (size != null) {
                    for (var i = 0; i < size; i++) {
                        var firstOffset = $(".part").eq(0).offset().top;
                        var edge = $(".part").eq(size - 1).offset().top+$(".part").eq(size - 1).height();
                        var offset = $(".part").eq(i).offset().top;
                        dayLeftNav = $("#day-leftNav").height();
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
                    offset = $('.part').eq(index).offset().top,
                    scrollTop = $(window).scrollTop();
                $(".day-navlist a").removeClass("cur");
                $(this).find("a").addClass("cur");
                $("html, body").animate({
                    scrollTop: offset
                }, "slow", function () {
                    $(window).bind('scroll', pageScroll);
                });
                e.preventDefault();
            });
        }



        //弹出相册
        $('.fancybox').fancybox({
            'overlayShow'   :   false
        });


        //拼团优惠
        $(".group-more-btn").click(function(){
            $(this).siblings(".code-layer-box").show();
        });
        $(".code-layer-box .close-ico").click(function(){
            $(this).parent(".code-layer-box").hide();
        });

    });

</script>

</body>
</html>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='/res/js/bdshare/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
