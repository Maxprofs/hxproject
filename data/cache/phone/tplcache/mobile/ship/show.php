<?php defined('SYSPATH') or die();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>" />
    <?php } ?>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <?php echo Common::css('swiper.min.css,lib-flexible.css,base.css,reset-style.css');?>
    <?php echo Common::css_plugin('mobilebone.css,m_ship.css','ship');?>
    <?php echo Common::js('lib-flexible.js,Zepto.js,swiper.min.js,jquery.min.js,delayLoading.min.js');?>
    <?php echo Common::js_plugin('mobilebone.js','ship');?>
</head>
<body>
    <div class="page" id="pageHome" data-title="<?php echo $channelname;?>">
        <?php echo Request::factory("pub/header_new/typeid/$typeid/isshowpage/1")->execute()->body(); ?>
        <!-- 公用顶部 -->
        <div class="page-content ship-line-show-page">
            <div class="swiper-container slide-ls-block">
                <div class="swiper-wrapper">
                    <?php $n=1; if(is_array($info['piclist'])) { foreach($info['piclist'] as $pic) { ?>
                    <div class="swiper-slide">
                        <a class="pic" href="javascript:;"><img class="swiper-lazy" data-src="<?php echo Common::img($pic['0'],750,375);?>" alt="<?php echo $info['title'];?>" /></a>
                        <div class="swiper-lazy-preloader"></div>
                    </div>
                    <?php $n++;}unset($n); } ?>
                </div>
                <!-- 分页器 -->
                <div class="swiper-pagination"></div>
                <div class="info">
                    <span class="data">推荐 <?php echo $info['recommendnum'];?></span>
                    <span class="data">销量 <?php echo $info['sellnum'];?></span>
                </div>
            </div>
            <!-- 图片切换 -->
            <div class="pdt-show-tip-info">
                <h2 class="tit">
                    <?php echo $info['title'];?>
                    <?php $n=1; if(is_array($info['iconlist'])) { foreach($info['iconlist'] as $icon) { ?>
                    <img src="<?php echo $icon['litpic'];?>" />
                    <?php $n++;}unset($n); } ?>
                </h2>
                <div class="supplier_data clearfix hide">
                    <?php if($info['suppliers']) { ?>
                    <p class="supplier">供应商：<?php echo $info['suppliers']['suppliername'];?></p>
                    <?php } ?>
                    <?php if($info['xxxxx']) { ?>
                    <s></s>
                    <p class="num"><?php echo $info['sellnum'];?>人参加过</p>
                    <s></s>
                    <p class="dest">目的地：<?php echo $info['finaldest_name'];?></p>
                    <?php } ?>
                </div>
                <div class="info">
                    <span class="dest"><?php echo $info['finaldest_name'];?></span>
                    <?php if($info['price']) { ?>
                    <span class="pri"><?php echo Currency_Tool::symbol();?><em class="num no-style"><?php echo $info['priceinfo']['price'];?></em>起/人</span>
                    <?php } else { ?>
                    <span class="pri"><em class="num no-style">电询</em></span>
                    <?php } ?>
                </div>
            </div>
            <!-- 航线信息 -->
            <div class="ship-ls-info-item">
                <ul class="ship-list-group">
                    <li>
                        <a class="item-a"  <?php if(!empty($info['lastest_line'])) { ?> href="#chooseDate" <?php } else { ?> href="javascript:;"<?php } ?>
>
                            <i class="date-icon"></i>
                            <?php if(!empty($info['lastest_line'])) { ?>
                            <span class="txt" id="show-time"><?php echo date('Y-m-d',$info['lastest_line']);?>出发</span>
                            <?php } else { ?>
                            <span class="txt">不可预定</span>
                            <?php } ?>
                            <i class="arrow-rig-icon fr"></i>
                        </a>
                    </li>
                    <li>
                        <a class="item-a" data-ajax="false" href="<?php echo $cmsurl;?>pub/comment/id/<?php echo $info['id'];?>/typeid/104">
                            <i class="message-icon"></i>
                            <span class="txt"><em class="myd no-style"><?php echo $info['satisfyscore'];?></em>满意度<em class="com-num no-style">（<?php echo $info['commentnum'];?>条点评）</em></span>
                            <i class="arrow-rig-icon fr"></i>
                        </a>
                    </li>
                    <li>
                        <a class="item-a" href="#slBaseAttr">
                            <i class="text-icon"></i>
                            <span class="txt">基本介绍：<?php echo Common::cutstr_html($info['sellpoint'],10);?></span>
                            <i class="arrow-rig-icon fr"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- 航线信息 -->
            <?php if($coupon['totalnum']>0) { ?>
            <div class="ship-ls-info-item ship-coupon-bar">
                <ul class="ship-list-group">
                    <li>
                        <a class="item-a" data-ajax="false" href="<?php echo $cmsurl;?>coupon-0-104-<?php echo $info['id'];?>">
                            <span class="hd">领券</span>
                            <?php $n=1; if(is_array($coupon['price'])) { foreach($coupon['price'] as $price) { ?>
                            <?php 
                            if(strpos($price,'元')!==false)
                            $coupontype="现金券";
                            else
                            $coupontype="优惠券";?>
                            <em class="coupon-label no-style"><?php echo $price;?><?php echo $coupontype;?></em>
                            <?php $n++;}unset($n); } ?>
                            <i class="arrow-rig-icon fr"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <?php } ?>
            <!-- 领取优惠券 -->
            <div class="ship-ls-info-item" id="ship_box" style="display: none">
                <ul class="ship-list-group">
                    <li>
                        <a class="item-a" href="#chooseCabin">
                            <span class="hd">舱房信息</span>
                            <i class="arrow-rig-icon fr"></i>
                            <span class="more-txt-link fr">更多</span>
                        </a>
                    </li>
                </ul>
                <ul class="ship-cabin-block">
                </ul>
            </div>
            <!-- 舱房信息 -->
            <?php $ship=Model_Ship::get_ship($info['shipid']);?>
            <div class="ship-ls-info-item">
                <ul class="ship-list-group">
                    <li>
                        <a class="item-a" data-ajax="false" href="<?php echo $cmsurl;?>ship/cruise_<?php echo $ship['id'];?>.html">
                            <span class="hd">游轮介绍</span>
                            <i class="arrow-rig-icon fr"></i>
                            <span class="more-txt-link fr">更多</span>
                        </a>
                    </li>
                </ul>
                <div class="ship-js-txt clearfix">
                    <p><?php echo Model_Ship::get_ship_supplier($info['shipid'],'suppliername');?> -<?php echo $ship['title'];?></p>
                    <?php echo $ship['content'];?>
                </div>
            </div>
            <!-- 游轮介绍 -->
            <?php $jieshao_list=Model_Ship_Line::mobile_jieshao($info['id'],$info['lineday']);?>
            <?php if(!empty($jieshao_list)) { ?>
            <?php $firstday=$jieshao_list['0']?>
            <div class="ship-ls-info-item">
                <ul class="ship-list-group">
                    <li>
                        <a class="item-a" href="#slRoute">
                            <span class="hd">行程安排</span>
                            <i class="arrow-rig-icon fr"></i>
                            <span class="more-txt-link fr">更多</span>
                        </a>
                    </li>
                </ul>
                <?php if($info['isstyle']==2) { ?>
                <div class="ship-xc-block clearfix">
                    <div class="xc-day"><strong class="day-num">第1天</strong><p class="day-name"><?php echo $firstday['title'];?></p></div>
                    <div class="day-attr">
                        <p class="clearfix">
                            <?php if($firstday['starttimehas']==1) { ?>
                            <span>启航时间：<?php echo $firstday['starttime'];?></span>
                            <?php } ?>
                            <?php if($firstday['endtimehas']==1) { ?>
                            <span>到港时间：<?php echo $firstday['endtime'];?></span>
                            <?php } ?>
                        </p>
                        <p class="clearfix">
                            <span>早餐： <?php if($firstday['breakfirsthas']) { ?>
                                                        <?php if(!empty($firstday['breakfirst'])) { ?>
                                                          <?php echo $firstday['breakfirst'];?>
                                                        <?php } else { ?>
                                                          含
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                      不含
                                                    <?php } ?>
                            </span>
                            <span>午餐：
                                <?php if($firstday['lunchhas']) { ?>
                                <?php if(!empty($firstday['lunch'])) { ?>
                                <?php echo $firstday['lunch'];?>
                                <?php } else { ?>
                                含
                                <?php } ?>
                                <?php } else { ?>
                                不含
                                <?php } ?>
                            </span>
                            <span>晚餐： <?php if($firstday['supperhas']) { ?>
                                                    <?php if(!empty($firstday['supper'])) { ?>
                                                      <?php echo $firstday['supper'];?>
                                                    <?php } else { ?>
                                                      含
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    不含
                                                <?php } ?>
</span>
                        </p>
                        <p class="clearfix">
                            <?php if($firstday['countryhas']==1) { ?>
                            <span>国家/城市：<?php echo $firstday['country'];?></span>
                            <?php } ?>
                            <?php if($firstday['livinghas']==1) { ?>
                            <span>入住：<?php echo $firstday['living'];?></span>
                            <?php } ?>
                        </p>
                    </div>
                    <div class="xc-txt">
                        <?php echo $firstday['content'];?>
                    </div>
                </div>
                <?php } else { ?>
                <div class="ship-xc-block clearfix">
                    <?php echo $info['jieshao'];?>
                    </div>
                <?php } ?>
            </div>
            <?php } ?>
            <!-- 行程安排 -->
            <div class="ship-ls-info-item">
                <ul class="ship-list-group">
                    <?php $ship_tag = new Taglib_Ship();if (method_exists($ship_tag, 'get_content')) {$linecontent = $ship_tag->get_content(array('action'=>'get_content','pc'=>'0','typeid'=>$typeid,'productinfo'=>$info,'return'=>'linecontent',));}?>
                    <?php $n=1; if(is_array($linecontent)) { foreach($linecontent as $line) { ?>
                    <?php if(empty($line['content'])) continue;?>
                    <?php if(preg_match('/^\d+$/',$line['content']) && $line['columnname']=='jieshao') { ?>
                    <?php } else { ?>
                    <li>
                        <a class="item-a" href="#<?php echo $line['columnname'];?>">
                            <i class="text-icon"></i>
                            <span class="txt"><?php echo $line['chinesename'];?></span>
                            <i class="arrow-rig-icon fr"></i>
                        </a>
                    </li>
                    <?php } ?>
                    <?php $n++;}unset($n); } ?>
                </ul>
            </div>
            <!-- 航线信息 -->
        </div>
        <form id="bookfrm" action="book" head_script=FmACXC >
            <?php if($info['lastest_line']) { ?>
                <input type="hidden" id="start_time" name="start_time" value="<?php echo date('Y-m-d',$info['lastest_line']);?>">
            <?php } ?>
            <?php if($info['price']) { ?>
            <input type="hidden" id="lineid" name="lineid" value="<?php echo $info['id'];?>">
            <?php } ?>
            <input type="hidden" id="dateid" name="dateid" value="0">
            <input type="hidden" id="suitid" name="suitid" value="0">
            <input type="hidden" id="number" name="number" value="0">
        </form>
        <div class="ship-ls-bottom-fix">
            <a href="tel:<?php echo $GLOBALS['cfg_m_phone'];?>" class="btn-link kefu-btn"><i class="link-icon"></i>联系客服</a>
            <?php if($info['price']) { ?>
            <a href="javascript:;" class="btn-link booking-btn">立即预订</a>
            <?php } else { ?>
            <a href="javascript:;" class="btn-link bk-over">立即预订</a>
            <?php } ?>
        </div>
    </div>
    <div class="page out" id="slBaseAttr">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="#pageHome" data-rel="back"></a>
            <h1 class="page-title-bar">航线基本介绍</h1>
        </div>
        <!-- 公用顶部 -->
        <div class="page-content full-page">
            <div class="ship-base-attr">
                <ul class="sl-attr-item">
                    <li>
                        <span class="hd">航线编号：</span>
                        <div class="bd"><?php echo $info['series'];?></div>
                    </li>
                    <li>
                        <?php $ship=Model_Ship::get_ship($info['shipid']);?>
                        <span class="hd">邮轮品牌：</span>
                        <div class="bd"><?php echo Model_Ship::get_ship_supplier($info['shipid'],'suppliername');?> -<?php echo $ship['title'];?></div>
                    </li>
                    <?php if($info['startcity']) { ?>
                    <li>
                        <span class="hd">出发地点：</span>
                        <div class="bd"><?php echo Model_Ship_Line::get_start_city($info['startcity'],'cityname');?></div>
                    </li>
                    <?php } ?>
                    <?php if($info['finaldest_name']) { ?>
                    <li>
                        <span class="hd">目的地点：</span>
                        <div class="bd"><?php echo $info['finaldest_name'];?></div>
                    </li>
                    <?php } ?>
                    <?php if($info['schedule_name']) { ?>
                    <li>
                        <span class="hd">行程天数：</span>
                        <div class="bd"><?php echo $info['schedule_name'];?></div>
                    </li>
                    <?php } ?>
                    <?php if($info['attrid']) { ?>
                    <li>
                        <span class="hd">航线属性：</span>
                        <div class="bd"><?php echo implode(',',Model_Ship_Line_Attr::get_attrs($info['attrid'],'attrname',true));?></div>
                    </li>
                    <?php } ?>
                    <?php if($info['sellpoint']) { ?>
                    <li>
                        <span class="hd">航线卖点：</span>
                        <div class="bd"><?php echo $info['sellpoint'];?></div>
                    </li>
                    <?php } ?>
                    <li>
                        <span class="hd">付款方式：</span>
                        <div class="pay-item clear">
                            <?php $paymethod = Model_Ship::get_paytype_list();?>
                            <?php $n=1; if(is_array($paymethod)) { foreach($paymethod as $method) { ?>
                            <span class="pay-sp"><img src="<?php echo $GLOBALS['cfg_m_img_url'];?>/res/images/<?php echo $method['ico'];?>" alt=""></span>
                            <?php $n++;}unset($n); } ?>
                        </div>
                    </li>
                </ul>
                <?php if(!empty($info['jifentprice_info']) || !empty($info['jifenbook_info']) || !empty($info['jifencomment_info'])) { ?>
                <div class="sl-jifen-item">
                    <h3 class="jf-tit">积分优惠</h3>
                    <ul class="jf-wrap">
                        <?php if(!empty($info['jifenbook_info'])) { ?>
                        <li>
                            <span class="label"><em class="hd no-style">订</em><em class="num no-style"><?php echo $info['jifenbook_info']['value'];?><?php if($info['jifenbook_info']['rewardway']==1) { ?>%<?php } else { ?>分<?php } ?>
</em></span>
                            <p class="txt">预定产品可获得<?php echo $info['jifenbook_info']['value'];?><?php if($info['jifenbook_info']['rewardway']==1) { ?>%<?php } else { ?>分<?php } ?>
积分。</p>
                        </li>
                        <?php } ?>
                        <?php if(!empty($info['jifentprice_info'])) { ?>
                        <li>
                            <span class="label"><em class="hd no-style">抵</em><em class="num no-style"><?php echo Currency_Tool::symbol();?><?php echo $info['jifentprice_info']['jifentprice'];?></em></span>
                            <p class="txt">预定产品可使用积分抵现金，最高可抵<?php echo Currency_Tool::symbol();?><?php echo $info['jifentprice_info']['jifentprice'];?>。</p>
                        </li>
                        <?php } ?>
                        <?php if(!empty($info['jifencomment_info'])) { ?>
                        <li>
                            <span class="label"><em class="hd no-style">评</em><em class="num no-style"><?php echo $info['jifencomment_info']['value'];?>分</em></span>
                            <p class="txt">旅游归来，评论订单可获得<?php echo $info['jifencomment_info']['value'];?>分。</p>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- 航线基本介绍 -->
    <div class="page out" id="chooseCabin">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="#pageHome" data-rel="back"></a>
            <h1 class="page-title-bar">选择舱房</h1>
        </div>
        <!-- 公用顶部 -->
        <div class="page-content choose-cabin-page">
            <div class="choose-date">
                <ul class="ship-list-group">
                    <li>
                        <a class="item-a" href="#chooseDate">
                            <span class="txt">出发日期：</span>
                            <span class="date"><?php if($info['lastest_line']) { ?><?php echo date('Y-m-d',$info['lastest_line']);?><?php } ?>
</span>
                            <i class="arrow-rig-icon fr"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="cabin-type-wrap">
                <div class="swiper-container slide-tab-nav">
                    <div class="swiper-wrapper">
                    </div>
                </div>
                <ul class="ship-cabin-block">
                </ul>
            </div>
        </div>
        <div class="bom-fixed-content">
            <div class="bom-fixed-block" >
                <span class="total">
                    <em class="jg no-style"></em>
                </span>
                <span class="order-show-list" id="order-show-list">明细<i class="arrow-up-ico"></i></span>
                <a class="now-booking-btn" href="javascript:;">立即预定</a>
            </div>
        </div>
        <!-- 立即预定 -->
        <div class="fee-box hide" id="fee-box">
            <div class="fee-container">
                <ul class="mx-list">
                </ul>
            </div>
        </div>
        <!-- 费用明细 -->
    </div>
    <!-- 选择舱房 -->
    <div class="page out" id="chooseDate">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="#pageHome" data-rel="auto"></a>
            <h1 class="page-title-bar">选择日期</h1>
        </div>
        <!-- 公用顶部 -->
        <div class="page-content full-page">
            <div class="calendar-container">
            </div>
            <!-- 选择日期 -->
        </div>
    </div>
    <!-- 选择日期 -->
    <div class="page out" id="slRoute">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="#pageHome" data-rel="back"></a>
            <h1 class="page-title-bar">航线行程安排</h1>
        </div>
        <!-- 公用顶部 -->
        <div class="page-content full-page">
            <?php if($info['isstyle']==2) { ?>
            <?php $n=1; if(is_array($jieshao_list)) { foreach($jieshao_list as $v) { ?>
            <div class="ship-xc-block clearfix">
                <div class="xc-day"><strong class="day-num no-style">第<?php echo $v['day'];?>天</strong>
                    <p class="day-name"><?php echo $v['title'];?></p></div>
                <div class="day-attr">
                    <p class="clearfix">
                        <?php if($v['starttimehas']==1) { ?>
                        <span>启航时间：<?php echo $v['starttime'];?></span>
                        <?php } ?>
                        <?php if($v['endtimehas']==1) { ?>
                        <span>到港时间：<?php echo $v['endtime'];?></span>
                        <?php } ?>
                    </p>
                    <p class="clearfix">
                            <span>早餐： <?php if($v['breakfirsthas']) { ?>
                                                        <?php if(!empty($v['breakfirst'])) { ?>
                                                          <?php echo $v['breakfirst'];?>
                                                        <?php } else { ?>
                                                          含
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                      不含
                                                    <?php } ?>
                            </span>
                            <span>午餐：
                                <?php if($v['lunchhas']) { ?>
                                <?php if(!empty($v['lunch'])) { ?>
                                <?php echo $v['lunch'];?>
                                <?php } else { ?>
                                含
                                <?php } ?>
                                <?php } else { ?>
                                不含
                                <?php } ?>
                            </span>
                            <span>晚餐： <?php if($v['supperhas']) { ?>
                                                    <?php if(!empty($v['supper'])) { ?>
                                                      <?php echo $v['supper'];?>
                                                    <?php } else { ?>
                                                      含
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    不含
                                                <?php } ?>
</span>
                    </p>
                    <p class="clearfix">
                        <?php if($v['countryhas']==1) { ?>
                        <span>国家/城市：<?php echo $v['country'];?></span>
                        <?php } ?>
                        <?php if($v['livinghas']==1) { ?>
                        <span>入住：<?php echo $v['living'];?></span>
                        <?php } ?>
                    </p>
                </div>
                <div class="xc-txt">
                    <?php echo $v['content'];?>
                </div>
            </div>
            <?php $n++;}unset($n); } ?>
            <?php } else { ?>
            <?php echo $info['jieshao'];?>
            <?php } ?>
        </div>
    </div>
    <!-- 航线行程安排 -->
    <?php $n=1; if(is_array($linecontent)) { foreach($linecontent as $line) { ?>
    <?php if(empty($line['content'])) continue;?>
    <?php if(preg_match('/^\d+$/',$line['content']) && $line['columnname']=='jieshao') { ?>
    <?php } else { ?>
    <div class="page out" id="<?php echo $line['columnname'];?>">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
            <h1 class="page-title-bar"><?php echo $line['chinesename'];?></h1>
        </div>
        <!-- 公用顶部 -->
        <div class="page-content full-page">
            <div class="edit-show-box">
                <?php echo $line['content'];?>
            </div>
        </div>
    </div>
      <?php } ?>
    <?php $n++;}unset($n); } ?>
    <?php echo Common::js('layer/layer.m.js');?>
    <?php echo Request::factory("pub/code")->execute()->body(); ?>
    <script>
        var symbolchar ='<?php echo Currency_Tool::symbol();?>';
        $(function(){
            //头部下拉导航
            $(".st-user-menu").on("click",function(){
                $(".header-menu-bg,.st-down-bar").show();
                $("body").css("overflow","hidden")
            });
            $(".header-menu-bg").on("click",function(){
                $(".header-menu-bg,.st-down-bar").hide();
                $("body").css("overflow","auto")
            });
            //轮播图
            var mySwiper = new Swiper ('.slide-ls-block', {
                autoplay: 5000,
                pagination: '.slide-ls-block .swiper-pagination',
                lazyLoading : true,
                observer: true,
                observeParents: true
            });
            //选择数量
            $(".amount-opt-wrap>.add-btn").on("click",function(){
                var amount = $(this).parent().find(".num-text");
                if( amount.val() >= 0 ){
                    $(this).parent().find(".sub-btn").removeClass("end");
                }
                amount.val(parseInt(amount.val())+1);
            });
            $(".amount-opt-wrap>.sub-btn").on("click",function(){
                var amount = $(this).parent().find(".num-text");
                if( amount.val() > 0 ){
                    amount.val(parseInt(amount.val())-1)
                }
                else
                {
                    $(this).addClass("end");
                    amount.val(0);
                }
            });
            //明细列表
            $("#order-show-list").click(function(){
                $("#fee-box").removeClass("hide")
            });
            $("#fee-box").click(function(){
                $(this).addClass("hide")
            });
            //日历
            $(".item").on("click",function(){
                if( $(this).hasClass("opt") )
                {
                    $(this).addClass("active");
                    $(this).parents("td").siblings().children(".item").removeClass("active");
                    $(this).parents("tr").siblings().children("td").children(".item").removeClass("active")
                }
            });
           // $('.header_top:first').find('.back-link-icon').attr('href',SITEURL+'ship');
           // $('.header_top:first').find('.back-link-icon').attr('onclick','');
            //日历加载
            var date = $('#start_time').val().split('-');
            get_calendar(0, this, date[0], date[1]);
            //数据加载
            load_data();
            //舱房类型切换
            $('.choose-cabin-page .slide-tab-nav').on('click','span',function(){
                $('.choose-cabin-page .slide-tab-nav span').removeClass('active');
                $(this).addClass('active');
                var data_id= $(this).attr('data-id');
                if(data_id>0)
                {
                    $('.choose-cabin-page .ship-cabin-block li').hide();
                    $('.choose-cabin-page .ship-cabin-block li[data-id='+data_id+']').show();
                }
                else
                {
                    $('.choose-cabin-page .ship-cabin-block li').show();
                }
            });
            //房间数量增加
            $('.choose-cabin-page .ship-cabin-block').on('click','.add-btn',function(){
                var  obj = $(this).prev().prev();
                var num = $(obj).val();
                var maxnum = $(this).attr('maxnum')
                num++;
                var people_length = $(obj).attr('data-people');
                var dingnum = Math.ceil(num/people_length)
                if(dingnum>maxnum)
                {
                    layer.open(
                        {
                            content:'库存不足!'
                        }
                    )
                    return false;
                }
                $($(obj).prev()).removeClass('end');
                $(obj).val(num);
                set_total_price();
            })
            //房间数量减少
            $('.choose-cabin-page .ship-cabin-block').on('click','.sub-btn',function(){
                var  obj = $(this).next();
                var num = $(obj).val();
                if(num>0)
                {
                    num--;
                }
                if(num==0)
                {
                    $(this).addClass('end')
                }
                $(obj).val(num);
                set_total_price();
            })
            //预定
            $('.now-booking-btn').click(function()
            {
                if(!$('#suitid').val())
                {
                    layer.open(
                        {
                            content:'请先选择舱房!'
                        }
                    )
                    return false;
                }
                $('#bookfrm').submit();
            });
            $('.bk-over').click(function(){
                layer.open(
                    {
                        content:'请先选择舱房!'
                    }
                )
            });
            $('.booking-btn').click(function(){
                location.href="#chooseCabin"
            })
        });
        //选择时间
        function choose_day(date)
        {
            $('#show-time').text(date+'出发');
            $('#start_time').val(date);
            $('#chooseCabin .date').text(date);
            load_data();
            history.go(-1);
        }
        //加载日历
        function get_calendar(suitid, obj, year, month)
        {
            var containdiv = '';
            if (obj) {
                containdiv = $(obj).attr('id');
            }
            var url = SITEURL + 'ship/ajax_dialog_calendar';
            var lineid = $('#lineid').val();
            $.ajax({
                type:'post',
                dataType:'html',
                url:url,
                data:{lineid:lineid,year:year,month:month},
                success:function(data)
                {
                    $('.calendar-container').html(data);
                }
            })
        }
        //加载舱房信息
        function load_data()
        {
            var starttime = $('#start_time').val();
            var lineid = $('#lineid').val();
            $.ajax({
                type:'post',
                dataType:'json',
                data:{starttime:starttime,lineid:lineid},
                url:SITEURL+'ship/ajax_load_data',
                success:function(data)
                {
                    if(data.backTime)
                    {
                        set_home_data(data.suit);
                        set_cabin_page(data);
                        $('#ship_box').show();
                    }
                    else
                    {
                        location.href = "#pageHome";
                        $('#ship_box').hide();
                    }
                    set_total_price();
                }
            })
        }
        function set_home_data(suit)
        {
            var html = '';
            $.each(suit,function(index,obj){
               if(index<2)
               {
                 var room = obj.room;
                   var btnclass="ing-link";
                   var gohref="#chooseCabin";
                   var gotext='预定'
                   if(obj.number==0)
                   {
                       btnclass = "over-link";
                       gohref = 'javascript:;'
                       gotext = '售罄'
                   }
                 html +='<li><div class="l-box"><img src="'+room.litpic+'" alt="'+room.title+'" title="'+room.title+'"></div>' +
                     '<div class="m-box"><h4 class="name">'+room.title+'</h4>' +
                     '<p class="txt">'+room.content+'</p>' +
                     '<p class="pri"><span>'+symbolchar+'<em class="no-style">'+obj.price+'</em></span>间</p></div>' +
                     '<div class="r-box"><a class="booking-btn '+btnclass+'" href="'+gohref+'">'+gotext+'</a></div></li>';
               }
            })
            $('#ship_box .ship-cabin-block').html(html);
        }
        function set_cabin_page(data)
        {
            var kindhtml = '<span class="swiper-slide active" data-id="0">全部</span>';
            $.each(data.kind,function(index,kind){
                kindhtml += '<span class="swiper-slide" data-id="'+index+'">'+kind+'</span>';
            });
            $('#chooseCabin .swiper-wrapper').html(kindhtml);
            var suithtml = '';
            $.each(data.suit,function(index,obj){
                    var room = obj.room;
                    var number = 9999;
                    var strnum = '不限';
                    if(obj.number!=-1)
                    {
                        if(obj.number>0)
                        {
                            strnum = obj.number;
                        }
                        else
                        {
                            strnum = '售罄';
                        }
                        number = obj.number;
                    }
                    suithtml +='<li data-id="'+room.kindid+'"><div class="l-box"><img src="'+room.litpic+'" alt="'+room.title+'" title="'+room.title+'"></div>' +
                        '<div class="m-box"><h4 class="name">'+room.title+'</h4>' +
                        '<p class="txt">'+room.area+'m<sup>2</sup>  住'+room.peoplenum+'人   库存'+strnum+'</p>' +
                        '<p class="pri"><span>'+symbolchar+'<em class="no-style">'+obj.price+'</em></span>间</p></div>' +
                        '<div class="r-box"><span class="amount-opt-wrap">' +
                        '<a href="javascript:;" class="sub-btn end">–</a>' +
                        '<input type="text" readonly data-people="'+room.peoplenum+'"  data-price="'+obj.price+'" date-id="'+obj.dateid+'" suit-id="'+obj.suitid+'"  data-title="'+room.title+'"  class="num-text" maxlength="4" value="0"> <em class="unit">人</em>' +
                        '<a href="javascript:;" class="add-btn" maxnum="'+number+'">+</a></span></div></li>';
            });
            $('#chooseCabin .ship-cabin-block').html(suithtml);
        }
        function set_total_price()
        {
            var listhtml = '';
            var dateid = '';
            var number= [];
            var suit = [];
            var totalprice = 0;
            $('.ship-cabin-block input').each(function(index,obj){
                var num = $(obj).val();
                if(num>0)
                {
                    var price = $(obj).attr('data-price');
                    var title = $(obj).attr('data-title');
                    var suitid = $(obj).attr('suit-id');
                    var people_lenth = $(obj).attr('data-people');
                    var dingnum = Math.ceil(num/people_lenth)
                     dateid = $(obj).attr('date-id');
                    totalprice += dingnum*price;
                    number.push(num);
                    suit.push(suitid)
                    listhtml += '<li><strong>'+title+'('+num+'人)</strong><em>'+symbolchar+price+'×'+dingnum+'(间)</em></li>';
                }
            });
            $('#fee-box .mx-list').html(listhtml);
            $('.bom-fixed-block .total .jg').text('应付总额:'+symbolchar+totalprice);
            number = number.join("_");
            suit = suit.join("_");
            $('#dateid').val(dateid)
            $('#suitid').val(suit)
            $('#number').val(number)
        }
        //重写登陆后的操作
        function is_login($obj){
            var fx_url="content=<?php echo urlencode($info['title']);?>";
            if($obj['islogin']==1){
                if($obj['info']['fx_member']){
                    if(window.location.href.indexOf('/show_')!=-1)
                    {
                        //var btn = $($obj['info']['fx_btn'].replace('[fx_url]', fx_url));
                       // var fx_href = $(btn).attr('href');
                       // var btn = '<a href="'+fx_href+'" data-ajax="false" class="btn-link fenxiao-btn">我要分销</a>';
                       /// $('.ship-ls-bottom-fix').append(btn);
                                $('.ship-ls-bottom-fix').append($obj['info']['fx_btn'].replace('[fx_url]',fx_url));
                          $("#share_btn").addClass('btn-link');
                        $("#share_btn").addClass('fenxiao-btn');
                    }
                }
            }
        }
    </script>
</body>
</html>