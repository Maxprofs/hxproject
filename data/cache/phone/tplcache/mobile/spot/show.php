<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $webname;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
    <?php } ?>
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>" />
    <?php } ?>
    <?php echo Common::css('swiper.min.css,mobilebone.css,base.css,header.css,footer.css');?>
    <?php echo Common::css_plugin('spot.css','spot');?>
    <?php echo Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,delayLoading.min.js,mobilebone.js,Zepto.js,layer2.0/layer.js');?>
    <?php echo Common::js_plugin('spot.js','spot');?>
</head>
<style>
    #share_btn{
        color: #666!important;
        background-color: transparent!important;
        display: block;
        width: 33.333333%;
        height: 1.28rem;
        line-height: 1.28rem;
        position: relative;
        text-align: center;
        -webkit-box-flex: 1;
        font-size: 0.32rem;
    }
</style>
<body>
<div class="page out" id="pageHome">
    <?php echo Request::factory("pub/header_new/typeid/$typeid/isshowpage/1")->execute()->body(); ?>
    <!-- 公用顶部 -->
    <div class="page-content spot-content" id="productScrollFixed">
        <div class="swiper-container st-photo-container" >
            <ul class="swiper-wrapper">
                <?php if($info['piclist']) { ?>
                <?php $n=1; if(is_array($info['piclist'])) { foreach($info['piclist'] as $pic) { ?>
                <li class="swiper-slide">
                    <a class="item" href="javascript:;"><img class="swiper-lazy" data-src="<?php echo Common::img($pic['0'],750,375);?>" /></a>
                    <div class="swiper-lazy-preloader"></div>
                </li>
                <?php $n++;}unset($n); } ?>
                <?php } else { ?>
                <li class="swiper-slide">
                    <a class="item" href="javascript:;"><img class="swiper-lazy" data-src="<?php echo $GLOBALS['cfg_df_img'];?>" /></a>
                    <div class="swiper-lazy-preloader"></div>
                </li>
                <?php } ?>
            </ul>
            <div class="swiper-pagination"></div>
            <div class="swiper-info"><span id="slideCurrentIndex"></span>/<span id="slideAllCount"></span></div>
        </div>
        <!-- 轮播图 -->
        <div class="product-tip-wrapper">
            <h1 class="product-title-bar"><?php echo $info['title'];?></h1>
            <div class="product-ads-bar">
                <?php if(Plugin_Productmap::_is_installed()&&!empty($info['lat'])&&!empty($info['lng'])&&!empty($info['address'])) { ?>
                <i class="ads-icon"></i>
                <a href="//<?php echo $GLOBALS['main_host'];?>/plugins/productmap/spot/map?id=<?php echo $info['id'];?>" data-ajax='false'>
                    <span class="ads-msg"><?php echo $info['address'];?></span>
                    <i class="ads-link"></i>
                </a>
                <?php } else { ?>
                <?php if(!empty($info['address'])) { ?>
                <i class="ads-icon"></i>
                <span class="ads-msg"><?php echo $info['address'];?></span>
                <?php } ?>
                <?php } ?>
            </div>
            <div class="product-info-bar">
                <a href="<?php echo $cmsurl;?>pub/comment/id/<?php echo $info['id'];?>/typeid/<?php echo $typeid;?>" data-ajax=false class="item">
                    <span class="name"><?php if($info['satisfyscore']>100) { ?>100<?php } else { ?><?php echo $info['satisfyscore'];?><?php } ?>
%满意度</span>
                    <span class="sub">共有<?php echo $info['commentnum'];?>条评论</span>
                </a>
                <?php $extends_title=Model_Spot::get_spot_extend_content($info['id'],2);?>
                <?php if($extends_title) { ?>
                <a href="#spotShowInfo" class="item">
                    <span class="name">景区介绍</span>
                    <span class="sub">
                        <?php $n=1; if(is_array($extends_title)) { foreach($extends_title as $k => $extend_title) { ?>
                        <?php echo $extend_title['title'];?><?php if($k<1) { ?>、<?php } ?>
                        <?php $n++;}unset($n); } ?>
                    </span>
                </a>
                <?php } ?>
            </div>
            <!--优惠券-->
            <?php if(St_Functions::is_normal_app_install('coupon')) { ?>
                <?php $coupon=Model_Coupon::get_mobile_coupon_info($typeid,$info['id']);?>
                <?php if($coupon['totalnum']>0) { ?>
                <div class="product-coupon-bar">
                    <i class="coupon-icon"></i>
                    <div class="coupon-type">
                        <?php $n=1; if(is_array($coupon['price'])) { foreach($coupon['price'] as $coupon_price) { ?>
                        <span class="item"><?php echo $coupon_price;?>优惠券</span>
                        <?php $n++;}unset($n); } ?>
                    </div>
                    <span class="more-item"><?php echo $coupon['totalnum'];?>张可领取</span>
                </div>
                <?php } ?>
                <script>
                    $(function(){
                        $('.product-coupon-bar .more-item').click(function(){
                            var typeid='<?php echo $typeid;?>';
                            var proid="<?php echo $info['id'];?>";
                            var url = SITEURL + 'coupon-0-'+typeid+'-'+proid;
                            window.location.href=url;
                        })
                    });
                </script>
            <?php } ?>
            <?php if(!empty($info['jifenbook_id'])||!empty($info['jifentprice_id'])) { ?>
            <div class="product-itg-bar">
                <i class="itg-icon"></i>
                <span class="item">获赠积分</span>
                <span class="item">积分抵扣</span>
                <i class="more-item"></i>
            </div>
            <?php } ?>
        </div>
        <!-- 顶部信息 -->
        <div class="product-type-wrapper" id="productTypeWrapper">
            <?php $spot_tag = new Taglib_Spot();if (method_exists($spot_tag, 'suit_type')) {$typelist = $spot_tag->suit_type(array('action'=>'suit_type','row'=>'8','productid'=>$info['id'],'return'=>'typelist',));}?>
            <?php $n=1; if(is_array($typelist)) { foreach($typelist as $type) { ?>
            <div class="product-type-block retract">
                <div class="type-bar">
                    <span class="title"><?php echo $type['title'];?></span>
                    <i class="icon"></i>
                </div>
                <ul class="product-type-group">
                    <?php $spot_tag = new Taglib_Spot();if (method_exists($spot_tag, 'suit_by_type')) {$suitlist = $spot_tag->suit_by_type(array('action'=>'suit_by_type','row'=>'10','productid'=>$info['id'],'suittypeid'=>$type['id'],'return'=>'suitlist',));}?>
                    <?php $n=1; if(is_array($suitlist)) { foreach($suitlist as $suit) { ?>
                    <li class="type-item">
                        <div class="product-type-info" data-id="<?php echo $suit['id'];?>">
                            <div class="tit"><?php echo $suit['title'];?></div>
                            <div class="set">
                                <!--退款条件-->
                                <?php if($suit['refund_restriction']==0) { ?>
                                <span class="label">无条件退</span>
                                <?php } else if($suit['refund_restriction']==1) { ?>
                                <span class="label">不可退改</span>
                                <?php } else if($suit['refund_restriction']==2) { ?>
                                <span class="label">有条件退</span>
                                <?php } ?>
                                <!--支付方式-->
                                <?php if($suit['pay_way']==1) { ?>
                                <span class="label">线上支付</span>
                                <?php } else if($suit['pay_way']==2) { ?>
                                <span class="label">线下支付</span>
                                <?php } else if($suit['pay_way']==3) { ?>
                                <span class="label">线上支付</span>
                                <span class="label">线下支付</span>
                                <?php } ?>
                            </div>
                            <div class="explain">
                                <?php if(!empty($suit['day_before_des_mobile'])) { ?>
                                <span class="txt"><?php echo $suit['day_before_des_mobile'];?></span>
                                <?php } else { ?>
                                <span>当天24:00前预定</span>
                                <?php } ?>
                                <span class="txt">门票说明<i class="icon"></i></span>
                            </div>
                        </div>
                        <div class="product-type-booking">
                            <?php if($suit['price_status']==1) { ?>
                            <?php if($suit['ourprice']) { ?><span class="price"><?php echo Currency_Tool::symbol();?><span class="num"><?php echo $suit['ourprice'];?></span>起</span><?php } ?>
                            <?php if(!empty($suit['ourprice'])) { ?>
                            <a class="spot-yd" href="<?php echo $cmsurl;?>spot/book/id/<?php echo $info['id'];?>?suitid=<?php echo $suit['id'];?>" data-ajax="false"><span class="buy">预订</span></a>
                            <?php } else { ?>
                            <span class="buy grey">电询</span>
                            <?php } ?>
                            <?php } else if($suit['price_status']==3) { ?>
                            <span class="buy grey">电询</span>
                            <?php } else if($suit['price_status']==2) { ?>
                            <span class="buy grey">订完</span>
                            <?php } ?>
                        </div>
                    </li>
                    <?php $n++;}unset($n); } ?>
                </ul>
            </div>
            <?php $n++;}unset($n); } ?>
        </div>
        <!-- 门票分类 -->
        <?php if(Model_Comment::get_comment_num($info['id'],$typeid)>0) { ?>
        <div class="rele-module-block">
            <div class="rele-hd-bar">
                <span class="title">游客点评</span>
                <span class="secondary">
                    <span class="item"><?php if($info['satisfyscore']>100) { ?>100<?php } else { ?><?php echo $info['satisfyscore'];?><?php } ?>
%满意度</span>
                    <span class="item"><?php echo $info['commentnum'];?>条评论</span>
                </span>
            </div>
            <div class="rele-module-area">
                <?php $comment_list=Model_Comment::search_result($typeid, $info['id'],'well',1,1);?>
                <?php if($comment_list['total']==0){$comment_list=Model_Comment::search_result($typeid, $info['id'],'mid',1,1);};?>
                <?php if($comment_list['total']==0){$comment_list=Model_Comment::search_result($typeid, $info['id'],'bad',1,1);};?>
                <ul class="comment-list-group">
                    <?php $n=1; if(is_array($comment_list['list'])) { foreach($comment_list['list'] as $comment) { ?>
                    <li>
                        <div class="info-hd">
                            <img src="<?php echo $comment['litpic'];?>" alt="<?php echo $comment['nickname'];?>" class="hd-img" />
                            <div class="user">
                                <span class="name"><?php echo $comment['nickname'];?></span>
                                <span class="date"><?php echo $comment['add_time'];?></span>
                            </div>
                            <div class="comment-grade-bar">
                                <?php $rank=array();for($i=0; $i<$comment['rank'];$i++){$rank[$i]=$i;};?>
                                <?php $n=1; if(is_array($rank)) { foreach($rank as $level) { ?>
                                <span class="icon <?php if($level<$comment['rank']) { ?>on<?php } ?>
"></span>
                                <?php $n++;}unset($n); } ?>
                            </div>
                        </div>
                        <div class="info-bd">
                            <?php echo $comment['content'];?>
                        </div>
                    </li>
                    <?php $n++;}unset($n); } ?>
                </ul>
                <div class="more-bar-link">
                    <a href="javascript:;" class="more-btn pl">查看全部点评</a>
                </div>
            </div>
        </div>
        <!-- 评论模块 -->
        <?php } ?>
        <div class="rele-module-block">
            <div class="rele-hd-bar">
                <span class="title">游客问答</span>
                <span class="secondary">
                    <span class="item"><?php echo Model_Question::get_question_num($typeid,$info['id']);?>条问答</span>
                </span>
            </div>
            <div class="rele-module-area">
                <?php if(Model_Question::get_question_num($typeid,$info['id'])>0) { ?>
                <?php $question_list=Model_Question::search_result(1,1,0,$typeid,$info['id']);?>
                <ul class="faq-list-group">
                    <?php $n=1; if(is_array($question_list['list'])) { foreach($question_list['list'] as $question) { ?>
                    <li class="item"><i class="icon">问</i><?php echo $question['content'];?></li>
                    <?php $n++;}unset($n); } ?>
                </ul>
                <div class="more-bar-link">
                    <a href="javascript:;" class="more-btn question">查看全部问答</a>
                </div>
                <?php } else { ?>
                <div class="rele-module-area">
                    <div class="module-empty-content">
                        <span class="txt">本产品暂无问答内容！</span>
                        <a href="javascript:;" class="link question_add">去提问</a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <!-- 问答模块 -->
        <?php $spot_tag = new Taglib_Spot();if (method_exists($spot_tag, 'get_tagword_spot')) {$recommends = $spot_tag->get_tagword_spot(array('action'=>'get_tagword_spot','tagword'=>$info['tagword'],'spotid'=>$info['id'],'row'=>'5','return'=>'recommends',));}?>
        <?php if(count($recommends)>0) { ?>
        <div class="rele-module-block">
            <div class="rele-hd-bar">
                <span class="title">相关推荐</span>
            </div>
            <div class="rele-module-area">
                <ul class="product-list-group">
                    <?php $n=1; if(is_array($recommends)) { foreach($recommends as $rec) { ?>
                    <li>
                        <a class="item" href="<?php echo $rec['url'];?>" data-ajax="false">
                            <div class="pro-pic"><span><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($rec['litpic']);?>" alt="<?php echo $rec['title'];?>" title="<?php echo $rec['title'];?>" /></span></div>
                            <div class="pro-info">
                                <h3 class="tit"><?php echo $rec['title'];?></h3>
                                <?php if(count($rec['iconlist'])>0) { ?>
                                <div class="attr">
                                    <?php if($GLOBALS['cfg_icon_rule']==1) { ?>
                                    <?php $n=1; if(is_array($rec['iconlist'])) { foreach($rec['iconlist'] as $icon) { ?>
                                    <span class="sx"><?php echo $icon['kind'];?></span>
                                    <?php $n++;}unset($n); } ?>
                                    <?php } else { ?>
                                    <?php $n=1; if(is_array($rec['iconlist'])) { foreach($rec['iconlist'] as $ico) { ?>
                                    <img style="margin-right:0.1rem;" src="<?php echo $ico['litpic'];?>"/>
                                    <?php $n++;}unset($n); } ?>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                                <div class="data">
                                    <span><?php echo Model_Comment::get_comment_num($rec['id'],$typeid);?>条点评</span>
                                    <span><?php echo rtrim($rec['satisfyscore'], '%') . '%';?>满意</span>
                                </div>
                                <?php if(!empty($rec['address'])) { ?>
                                <div class="addr"><?php echo $rec['address'];?></div>
                                <?php } ?>
                            </div>
                            <div class="pro-price">
                                <?php if($rec['price']) { ?>
                                <span class="price">
                                    <em><?php echo Currency_Tool::symbol();?><strong><?php echo $rec['price'];?></strong>起</em>
                                </span>
                                <?php } else { ?>
                                <span class="price"><b class="no-style">电询</b></span>
                                <?php } ?>
                            </div>
                        </a>
                    </li>
                    <?php $n++;}unset($n); } ?>
                </ul>
            </div>
        </div>
        <!-- 推荐相关 -->
        <?php } ?>
        <div class="no-info-bar">亲，拉到最底啦~</div>
        <?php echo Request::factory("pub/code")->execute()->body(); ?>
        <div class="fixed-container-area">
            <div class="fixed-container-bar bom_fixed">
                <a href="tel:<?php echo $GLOBALS['cfg_m_phone'];?>" class="item kf" data-ajax="false" ><i class="icon"></i>电话客服</a>
                <?php if($info['hasticket']) { ?>
                <a href="javascript:;" class="item xz" id="chooseTicketType">选择票型</a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php $extends=Model_Spot::get_spot_extend_content($info['id']);?>
<?php if($extends) { ?>
<div class="page out" id="spotShowInfo">
    <div class="header_top">
        <a class="back-link-icon" href="#pageHome" data-rel="back"></a>
        <h1 class="page-title-bar">景区介绍</h1>
    </div>
    <!-- 公用顶部 -->
    <div class="page-content">
        <?php $n=1; if(is_array($extends)) { foreach($extends as $extend) { ?>
            <?php if(!empty($extend['content'])) { ?>
            <div class="spot-js-wrapper">
                <h4 class="tit-bar"><?php echo $extend['title'];?></h4>
                <div class="spot-js-content editor-content clearfix">
                    <?php echo Common::content_image_width($extend['content'],540,0);?>
                </div>
            </div>
            <?php } ?>
        <?php $n++;}unset($n); } ?>
        <div class="no-info-bar">亲，拉到最底啦~</div>
    </div>
</div>
<!-- 景区介绍 -->
<?php } ?>
<?php $spot_tag = new Taglib_Spot();if (method_exists($spot_tag, 'suit_type')) {$typelist = $spot_tag->suit_type(array('action'=>'suit_type','row'=>'8','productid'=>$info['id'],'return'=>'typelist',));}?>
<?php $n=1; if(is_array($typelist)) { foreach($typelist as $type) { ?>
<?php $spot_tag = new Taglib_Spot();if (method_exists($spot_tag, 'suit_by_type')) {$suitlist = $spot_tag->suit_by_type(array('action'=>'suit_by_type','row'=>'10','productid'=>$info['id'],'suittypeid'=>$type['id'],'return'=>'suitlist',));}?>
<?php $n=1; if(is_array($suitlist)) { foreach($suitlist as $suit) { ?>
<div id="ticketInfo_<?php echo $suit['id'];?>" class="hide">
    <div class="product-show-info">
        <div class="info-show-bar">门票说明<i class="close-icon" id="closeTicketLayer_<?php echo $suit['id'];?>"></i></div>
        <div class="info-show-area">
            <div class="info-primary-hd">
                <h4 class="tit"><?php echo $suit['title'];?></h4>
                <div class="attr">
                    <!--退款条件-->
                    <?php if($suit['refund_restriction']==0) { ?>
                    <span class="item">无条件退</span>
                    <?php } else if($suit['refund_restriction']==1) { ?>
                    <span class="item">不可退改</span>
                    <?php } else if($suit['refund_restriction']==2) { ?>
                    <span class="item">有条件退</span>
                    <?php } ?>
                    <!--支付方式-->
                    <?php if($suit['pay_way']==1) { ?>
                    <span class="item">线上支付</span>
                    <?php } else if($suit['pay_way']==2) { ?>
                    <span class="item">线下支付</span>
                    <?php } else if($suit['pay_way']==3) { ?>
                    <span class="item">线上支付</span>
                    <span class="item">线下支付</span>
                    <?php } ?>
                </div>
            </div>
            <div class="info-other-bd">
                <h4 class="tit">预定时间</h4>
                <div class="txt">
                    <?php if(!empty($suit['day_before_des_mobile'])) { ?>
                    <?php echo $suit['day_before_des_mobile'];?>
                    <?php } else { ?>当天24:00前可预定<?php } ?>
                </div>
            </div>
            <div class="info-other-bd">
                <h4 class="tit">有效期</h4>
                <div class="txt">
                    <?php if(!empty($suit['effective_days'])) { ?>
                    <?php echo $suit['effective_before_days_des'];?>
                    <?php } else { ?>验票当天24:00前<?php } ?>
                </div>
            </div>
            <?php if(!empty($suit['get_ticket_way'])) { ?>
            <div class="info-other-bd">
                <h4 class="tit">取票说明</h4>
                <div class="txt"><?php echo $suit['get_ticket_way'];?></div>
            </div>
            <?php } ?>
            <?php if(!empty($suit['suppliername'])) { ?>
            <div class="info-other-bd">
                <h4 class="tit">供应商</h4>
                <div class="txt editor-content clearfix">
                    <?php echo $suit['suppliername'];?>
                </div>
            </div>
            <?php } ?>
            <?php if(!empty($suit['description'])) { ?>
            <div class="info-other-bd">
                <h4 class="tit">门票说明</h4>
                <div class="txt editor-content clearfix">
                    <?php echo Common::content_image_width($suit['description'],540,0);?>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="product-booking-bar">
            <span class="total"><?php if(!empty($suit['ourprice'])) { ?><?php echo Currency_Tool::symbol();?><span class="num"><?php echo $suit['ourprice'];?></span>起<?php } else { ?>电询<?php } ?>
</span>
            <?php if($suit['price_status']==1) { ?>
                <?php if(!empty($suit['ourprice'])) { ?>
                <a class="btn" href="<?php echo $cmsurl;?>spot/book/id/<?php echo $info['id'];?>?suitid=<?php echo $suit['id'];?>" data-ajax="false">立即预订</a>
                <?php } else { ?>
                <a class="btn" style="color: #fff;background-color: #999;cursor: default;" href="javascript:;">立即预订</a>
                <?php } ?>
            <?php } else { ?>
            <a class="btn" style="color: #fff;background-color: #999;cursor: default;" href="javascript:;">立即预订</a>
            <?php } ?>
        </div>
    </div>
</div>
<?php $n++;}unset($n); } ?>
<?php $n++;}unset($n); } ?>
<!-- 门票说明详情 -->
<?php if((!empty($jifenbook_info)&&$jifenbook_info['value']>0)||(!empty($jifentprice_info)&&$jifentprice_info['jifentprice']>0)||(!empty($jifencomment_info)&&$jifencomment_info['value']>0)) { ?>
<div id="integralInfo" class="hide">
    <div class="product-show-info">
        <div class="info-show-bar">积分优惠<i class="close-icon" id="closeTicketLayer_jifen"></i></div>
        <div class="info-show-area full">
            <?php if(!empty($jifentprice_info)&&$jifentprice_info['jifentprice']>0) { ?>
            <div class="info-integral-block">
                <h4 class="tit">积分抵现</h4>
                <ul class="info-list">
                    <li>购买该产品可使用积分抵现<span class="dk">（<?php echo $jifentprice_info['toplimit'];?>积分抵<?php echo Currency_Tool::symbol();?><?php echo $jifentprice_info['jifentprice'];?>）</span></li>
                </ul>
            </div>
            <?php } ?>
            <?php if((!empty($jifenbook_info)&&$jifenbook_info['value']>0)||(!empty($jifencomment_info)&&$jifencomment_info['value']>0)) { ?>
            <div class="info-integral-block">
                <h4 class="tit">赠送积分</h4>
                <ul class="info-list">
                    <?php if(!empty($jifenbook_info)&&$jifenbook_info['value']>0) { ?>
                    <li>购买该产品可获得<?php if($jifenbook_info['rewardway']==1) { ?>订单总额<?php echo $jifenbook_info['value'];?>%的<?php } else { ?><?php echo $jifenbook_info['value'];?><?php } ?>
积分</li>
                    <?php } ?>
                    <?php if(!empty($jifencomment_info)&&$jifencomment_info['value']>0) { ?>
                    <li>评论该产品可获得<?php if($jifencomment_info['rewardway']==1) { ?>订单总额<?php echo $jifencomment_info['value'];?>%的<?php } else { ?><?php echo $jifencomment_info['value'];?><?php } ?>
积分</li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>
<!-- 积分抵扣优惠 -->
<script>
    $(function(){
        //顶部菜单监听,分销按钮事件特殊处理
        var callback=false;
        $(".bom_fixed").bind("DOMNodeInserted",function(e){
            if($("#share_btn").length>0&&callback==false){
                //移除dom
                callback=true;
                $("#share_btn").removeAttr('style').addClass('item').addClass('fx').html('<i class="icon"></i>我要分销');
            }
        });
        $("#pageHome .header_top a.back-link-icon").attr({'data-ajax':'false','href':'<?php echo $cmsurl;?>spots'}).removeAttr("onclick");
        $('.pl').click(function(){
            var url = SITEURL+"pub/comment/id/<?php echo $info['id'];?>/typeid/<?php echo $typeid;?>";
            window.location.href = url;
        });
        //问答页面
        $('.question').click(function(){
            var url = SITEURL+"question/product_question_list?articleid=<?php echo $info['id'];?>&typeid=<?php echo $typeid;?>";
            window.location.href = url;
        });
        //提问页面
        $('.question_add').click(function(){
            var url = SITEURL+"question/product_question_write?articleid=<?php echo $info['id'];?>&typeid=<?php echo $typeid;?>";
            window.location.href = url;
        });
    })
</script>
</body>
</html>
