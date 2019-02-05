<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
    <?php } ?>
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>" />
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,reset-style.css');?>
    <?php echo Common::css_plugin('visa.css','visa');?>
    <?php echo Common::js('lib-flexible.js,jquery.min.js,delayLoading.min.js');?>
</head>
<body>
    <?php echo Request::factory("pub/header_new/typeid/$typeid/isshowpage/1")->execute()->body(); ?>
    <div class="visa-show-top">
        <div class="pic"><img src="<?php echo Common::img($info['litpic'],750,375);?>" /></div>
        <div class="tit"><?php echo $info['title'];?>
            <?php $n=1; if(is_array($info['iconlist'])) { foreach($info['iconlist'] as $icon) { ?>
            <img src="<?php echo $icon['litpic'];?>" />
            <?php $n++;}unset($n); } ?></div>
        <div class="txt"><?php echo $info['sellpoint'];?></div>
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
        <div class="price">
            <?php if(!empty($info['price'])) { ?>
            <i class="currency_sy no-style"><?php echo Currency_Tool::symbol();?></i>
            <span class="num"><?php echo $info['price'];?></span>
            <?php } else { ?>电询<?php } ?>
        </div>
        <ul class="info">
            <li class="item">
                <span class="num"><?php echo $info['sellnum'];?></span>
                <span class="unit">销量</span>
            </li>
            <li class="item">
                <span class="num"><?php echo $info['satisfyscore'];?>%</span>
                <span class="unit">满意度</span>
            </li>
            <li class="item link pl">
                <span class="num"><?php echo $info['commentnum'];?></span>
                <span class="unit">人点评</span>
                <i class="more-icon"></i>
            </li>
            <li class="item link question">
                <span class="num"><?php echo Model_Question::get_question_num($typeid,$info['id']);?></span>
                <span class="unit">人咨询</span>
                <i class="more-icon"></i>
            </li>
        </ul>
    </div>
    <!--优惠券-->
    <?php if(St_Functions::is_normal_app_install('coupon')) { ?>
    <?php echo Request::factory("coupon/float_box-$typeid-".$info['id'])->execute()->body(); ?>
    <?php } ?>
    <div class="visa-info-container">
        <h3 class="visa-info-bar">
            <span class="title-txt">产品信息</span>
        </h3>
        <ul class="visa-info-list">
            <?php if(!empty($info['handleday'])) { ?>
            <li class="item"><span class="hd">办理时间：</span><?php echo $info['handleday'];?></li>
            <?php } ?>
            <?php if(!empty($info['kindname'])) { ?>
            <li class="item"><span class="hd">签证类型：</span><?php echo $info['kindname'];?></li>
            <?php } ?>
            <?php if(!empty($info['country'])) { ?>
            <li class="item"><span class="hd">签证地区：</span><?php echo $info['country'];?></li>
            <?php } ?>
            <?php if(!empty($info['cityname'])) { ?>
            <li class="item"><span class="hd">签发城市：</span><?php echo $info['cityname'];?></li>
            <?php } ?>
            <?php if(!empty($info['validday'])) { ?>
            <li class="item"><span class="hd">有&nbsp;&nbsp;效&nbsp;&nbsp;期：</span><?php echo $info['validday'];?></li>
            <?php } ?>
            <li class="item"><span class="hd">面试需要：</span><?php if($info['needinterview']==1) { ?>需要<?php } else { ?>不需要<?php } ?>
</li>
            <li class="item"><span class="hd">邀&nbsp;&nbsp;请&nbsp;&nbsp;函：</span><?php if($info['needletter']==1) { ?>需要<?php } else { ?>不需要<?php } ?>
</li>
            <?php if(!empty($info['partday'])) { ?>
            <li class="item"><span class="hd">停留时间：</span><?php echo $info['partday'];?></li>
            <?php } ?>
            <?php if(!empty($info['acceptday'])) { ?>
            <li class="item" class="item"><span class="hd">受理时间：</span><?php echo $info['acceptday'];?></li>
            <?php } ?>
            <?php if(!empty($info['handlepeople'])) { ?>
            <li class="item"><span class="hd">受理人群：</span><?php echo $info['handlepeople'];?></li>
            <?php } ?>
            <?php if(!empty($info['belongconsulate'])) { ?>
            <li class="item"><span class="hd">所属领管：</span><?php echo $info['belongconsulate'];?></li>
            <?php } ?>
            <?php if(!empty($info['handlerange'])) { ?>
            <li class="item"><span class="hd">受理范围：</span><?php echo $info['handlerange'];?></li>
            <?php } ?>
        </ul>
        <div class="visa-choose-date order" data-id="<?php echo $info['id'];?>"><i class="car-icon"></i>选择出行时间<i class="more-icon" ></i></div>
    </div>
        <div class="show_cont">
            <?php if($is_show_material) { ?>
            <div class="visa-info-container">
                <h3 class="visa-info-bar">
                    <span class="title-txt">材料所需</span>
                </h3>
                <div class="down-tab-list">
                    <?php $n=1; if(is_array($materials)) { foreach($materials as $ma) { ?>
                    <?php if($ma['content']) { ?>
                    <dl class="tab-item">
                        <dt class="tab-nav">
                            <?php echo $ma['title'];?>
                        </dt>
                        <dd class="tab-box">
                            <div class="">
                                <?php echo Product::strip_style($ma['content']);?>
                            </div>
                        </dd>
                    </dl>
                    <?php } ?>
                    <?php $n++;}unset($n); } ?>
                </div>
            </div>
            <?php } ?>
            <?php require_once ("E:/wamp64/www/phone/taglib/detailcontent.php");$detailcontent_tag = new Taglib_Detailcontent();if (method_exists($detailcontent_tag, 'get_content')) {$data = $detailcontent_tag->get_content(array('action'=>'get_content','typeid'=>'8','productinfo'=>$info,));}?>
            <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
            <?php if($row['columnname']=='material') { ?>
            <?php continue?>
            <?php } ?>
            <?php if($row['columnname']=='attachment' && empty($info['attachment'])) { ?>
                <?php continue?>
            <?php } ?>
            <?php if($row['columnname']=='attachment' && empty($info['attachment'])) { ?>
               <?php continue?>
            <?php } ?>
            <div class="visa-info-container">
                <h3 class="visa-info-bar">
                    <span class="title-txt"><?php echo $row['chinesename'];?></span>
                </h3>
                <div class="visa-info-wrapper clearfix">
                    <?php if($row['columnname']=='attachment') { ?>
                    <ol class="attachment" id="attachment">
                        <?php $n=1; if(is_array($info['attachment']['path'])) { foreach($info['attachment']['path'] as $k => $v) { ?>
                        <li><a href="/pub/download/?file=<?php echo $v;?>&name=<?php echo $info['attachment']['name'][$k];?>" title="<?php echo $info['attachment']['name'][$k];?> 下载" class="name"><?php echo $info['attachment']['name'][$k];?></a></li>
                        <?php $n++;}unset($n); } ?>
                    </ol>
                    <?php } else { ?>
                    <?php echo $row['content'];?>
                    <?php } ?>
                </div>
            </div>
            <?php $n++;}unset($n); } ?>
            
        </div>
    <?php echo Request::factory('pub/code')->execute()->body(); ?>
    <?php echo Request::factory('pub/footer')->execute()->body(); ?>
    <div class="bom_link_box">
        <div class="bom_fixed">
            <a href="tel:<?php echo $GLOBALS['cfg_m_phone'];?>">电话咨询</a>
            <a class="on cursor order" data-id="<?php echo $info['id'];?>">立即预定</a>
        </div>
    </div>
    <script>
        $(function () {
            $(".tab-item").eq(0).children(".tab-box").show();
            $(".tab-item").on("click",function(){
                var _this = $(this);
                _this.children(".tab-box").show();
                _this.siblings().children(".tab-box").hide()
            })
            $('.pl').click(function(){
                var url = SITEURL+"pub/comment/id/<?php echo $info['id'];?>/typeid/<?php echo $typeid;?>";
                window.location.href = url;
            })
            //预订按钮
            $('.order').click(function(){
                var productid = $(this).attr('data-id');
                url = SITEURL+'visa/book/id/'+productid;
                window.location.href = url;
            })
            //问答页面
            $('.question').click(function(){
                var url = SITEURL+"question/product_question_list?articleid=<?php echo $info['id'];?>&typeid=<?php echo $typeid;?>";
                window.location.href = url;
            })
        });
    </script>
</body>
</html>
