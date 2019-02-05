<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head font_html=oxACXC >
    <meta charset="utf-8">
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
    <?php } ?>
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>" />
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,swiper.min.css,reset-style.css');?>
    <?php echo Common::css_plugin('line.css','line');?>
    <?php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,delayLoading.min.js');?>
</head>
<body>
    <?php echo Request::factory("pub/header_new/typeid/$typeid/isshowpage/1")->execute()->body(); ?>
    <div class="swiper-container st-photo-container" >
        <ul class="swiper-wrapper">
            <?php $n=1; if(is_array($info['piclist'])) { foreach($info['piclist'] as $pic) { ?>
             <li class="swiper-slide">
                <a class="item" href="javascript:;"><img class="swiper-lazy" data-src="<?php echo Common::img($pic['0'],450,225);?>"></a>
                <div class="swiper-lazy-preloader"></div>
             </li>
            <?php $n++;}unset($n); } ?>
        </ul>
        <div class="swiper-pagination"></div>
        <div class="pd-info-bar">
            <?php if($info['startcity']) { ?>
            <span class="item"><?php echo $info['startcity'];?>出发</span>
            |
            <?php } ?>
            <span class="item"><?php if(!empty($info['lineday'])) { ?><?php echo $info['lineday'];?>天<?php } ?>
<?php if(!empty($info['linenight'])) { ?><?php echo $info['linenight'];?>晚<?php } ?>
</span>
            <span class="item fr">产品编号：<?php echo $info['lineseries'];?></span>
        </div>
    </div>
    <!--轮播图-->
    <div class="line-show-top">
        <h1 class="tit">
            <!-- <?php if(!empty($info['startcity'])) { ?>
            <span class="city"><?php if(!empty($info['startcity'])) { ?>[<?php echo $info['startcity'];?>]<?php } ?>
</span>
            <?php } ?>
 -->
            <?php if($info['color']) { ?>
                <span style="color: <?php echo $info['color'];?>"><?php echo $info['title'];?></span>
            <?php } else { ?>
                <?php echo $info['title'];?>
            <?php } ?>
            <?php if($GLOBALS['cfg_icon_rule']!=1) { ?>
            <?php $n=1; if(is_array($info['iconlist'])) { foreach($info['iconlist'] as $v) { ?>
             <img class="icon" src="<?php echo $v['litpic'];?>"/>
            <?php $n++;}unset($n); } ?>
            <?php } ?>
        </h1>
        <div class="txt"><?php echo $info['sellpoint'];?></div>
        <div class="attr">
            <?php if($GLOBALS['cfg_icon_rule']==1) { ?>
            <?php $n=1; if(is_array($info['iconlist'])) { foreach($info['iconlist'] as $v) { ?>
             <span class="label"><?php echo $v['kind'];?></span>
            <?php $n++;}unset($n); } ?>
            <?php } ?>
        </div>
        <div class="price">
            <?php if(!empty($info['price'])) { ?>
             <span class="jg"><i class="currency_sy no-style"><?php echo Currency_Tool::symbol();?></i><span class="num"><?php echo $info['price'];?></span>起</span>
            <?php } else { ?>
            <span class="jg"><span class="num">电询</span></span>
            <?php } ?>
            <?php if($info['sellprice']>0) { ?>
            <span class="del">原价:<i class="currency_sy no-style"><?php echo Currency_Tool::symbol();?></i><?php echo $info['sellprice'];?></span>
            <?php } ?>
        </div>
        <?php if($info['suppliers']) { ?>
        <div class="supplier">
            <span class="hd-item">供应商：</span>
            <div class="bd-item"><?php echo $info['suppliers']['suppliername'];?></div>
        </div>
        <?php } ?>
        <ul class="info">
            <li class="item">
                <span class="num"><?php echo $info['sellnum'];?></span>
                <span class="unit">销量</span>
            </li>
            <li class="item">
                <span class="num"><?php echo $info['satisfyscore'];?></span>
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
    <!--顶部介绍-->
    <div class="discount-block">
    <?php if(St_Functions::is_normal_app_install('coupon')) { ?>
    <?php echo Request::factory("coupon/float_box-$typeid-".$info['id'])->execute()->body(); ?>
    <?php } ?>
    <!--优惠券-->
    <?php if(St_Functions::is_normal_app_install('together')) { ?>
    <?php echo Request::factory("together/app/typeid/".$typeid."/productid/".$info['id'])->execute()->body(); ?>
    <?php } ?>
    <!-- 拼团 -->
    </div>
    <?php $line_tag = new Taglib_Line();if (method_exists($line_tag, 'suit')) {$suitlist = $line_tag->suit(array('action'=>'suit','productid'=>$info['id'],'return'=>'suitlist',));}?>
    <?php if($suitlist && $info['status']==3) { ?>
    <div class="line-info-container">
        <div class="line-choose-date order" data-id="<?php echo $info['id'];?>"><i class="car-icon"></i>选择线路类型、出发日期<i class="more-icon"></i></div>
    </div>
    <?php } ?>
    <!--产品信息-->
    <?php require_once ("E:/wamp64/www/phone/taglib/detailcontent.php");$detailcontent_tag = new Taglib_Detailcontent();if (method_exists($detailcontent_tag, 'get_content')) {$data = $detailcontent_tag->get_content(array('action'=>'get_content','typeid'=>'1','productinfo'=>$info,));}?>
        <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
        <?php if($row['columnname']=='jieshao') { ?>
        <!--行程安排-->
        <?php if($info['isstyle']==1&&$info['jieshao']) { ?>
        <div class="line-info-container">
            <h3 class="line-info-bar">
                <span class="title-txt"><?php echo $row['chinesename'];?></span>
            </h3>
            <div class="line-info-wrapper clearfix">
                <!--简洁版-->
                <?php echo Common::content_image_width($info['jieshao'],540,0);?>
            </div>
        </div>
         <!--标准版-->
        <?php } else if($info['isstyle']==2) { ?>
        <?php $daysinfo = Model_Line_Jieshao::detail_mobile($row['content'],$info['lineday']);$k=0;
         foreach($daysinfo as $v)
         {
            if($v['title']){$k++;}
         }
        ?>
        <?php if($k>0) { ?>
        <div class="line-info-container">
            <h3 class="line-info-bar">
                <span class="title-txt"><?php echo $row['chinesename'];?></span>
                <?php $index=1;?>
                <?php $n=1; if(is_array($info['linedoc']['path'])) { foreach($info['linedoc']['path'] as $a => $v) { ?>
                <?php if($index==1) { ?>
                <a class="down-file-btn"  href="/pub/download/?file=<?php echo $v;?>&name=<?php echo $info['linedoc']['name'][$a];?>">下载行程</a>
                <?php } ?>
                <?php $index++;?>
                <?php $n++;}unset($n); } ?>
            </h3>
            <div class="line-info-wrapper">
                <div class="eachday">
                    <?php $n=1; if(is_array($daysinfo)) { foreach($daysinfo as $v) { ?>
                    <?php  if(!$v['title']){break;}?>
                    <div class="day-num">
                        <div class="hd">
                            <span class="day-on">第<?php echo $v['day'];?>天</span>
                            <span class="dest"><?php echo $v['title'];?></span>
                        </div>
                        <div class="hg clearfix">
                            <?php if($info['showrepast']==1) { ?>
                            <dl class="sum">
                                <dt class="yc"><i class="icon"></i>用餐</dt>
                                <dd class="con">
                                    <?php if($v['breakfirsthas']) { ?>
                                    <?php if(!empty($v['breakfirst'])) { ?>
                                    <span class="tc">早餐：<?php echo $v['breakfirst'];?></span>
                                    <?php } else { ?>
                                    <span class="tc">早餐：含</span>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <span class="tc">早餐：不含</span>
                                    <?php } ?>
                                    <?php if($v['lunchhas']) { ?>
                                    <?php if(!empty($v['lunch'])) { ?>
                                    <span class="tc">午餐：<?php echo $v['lunch'];?></span>
                                    <?php } else { ?>
                                    <span class="tc">午餐：含</span>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <span class="tc">午餐：不含</span>
                                    <?php } ?>
                                    <?php if($v['supperhas']) { ?>
                                    <?php if(!empty($v['supper'])) { ?>
                                    <span class="tc">晚餐：<?php echo $v['supper'];?></span>
                                    <?php } else { ?>
                                    <span class="tc">晚餐：含</span>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <span class="tc">晚餐：不含</span>
                                    <?php } ?>
                                </dd>
                            </dl>
                            <?php } ?>
                            <?php if($info['showhotel']==1) { ?>
                            <dl class="sum">
                                <dt class="zs"><i class="icon"></i>住宿</dt>
                                <dd class="con">
                                    <?php echo $v['hotel'];?>
                                </dd>
                            </dl>
                            <?php } ?>
                            <?php if($info['showtran']==1) { ?>
                            <dl class="sum">
                                <dt class="jt"><i class="icon"></i>交通</dt>
                                <dd class="con">
                                    <?php $n=1; if(is_array(explode(',',$v['transport']))) { foreach(explode(',',$v['transport']) as $t) { ?>
                                    <span class="gj"><?php echo $t;?></span>
                                    <?php $n++;}unset($n); } ?>
                                </dd>
                            </dl>
                            <?php } ?>
                            <dl class="sum">
                                <dt class="xc"><i class="icon"></i>行程</dt>
                                <dd class="con clearfix">
                                    <?php echo $v['jieshao'];?>
                                </dd>
                                <?php if(St_Functions::is_system_app_install(5)) { ?>
                                <dd class="spot">
                                    <ul class="clearfix">
                                        <?php $line_tag = new Taglib_Line();if (method_exists($line_tag, 'line_spot')) {$spotlist = $line_tag->line_spot(array('action'=>'line_spot','day'=>$v['day'],'productid'=>$v['lineid'],'return'=>'spotlist',));}?>
                                        <?php $sindex=1;?>
                                        <?php $n=1; if(is_array($spotlist)) { foreach($spotlist as $spot) { ?>
                                        <li>
                                            <a class="item" href="<?php echo $spot['url'];?>">
                                                <img src="<?php echo $spot['litpic'];?>" alt="<?php echo $spot['title'];?>">
                                                <span class="bt"><?php echo $spot['title'];?></span>
                                            </a>
                                        </li>
                                        <?php $sindex++;?>
                                        <?php $n++;}unset($n); } ?>
                                    </ul>
                                </dd>
                                <?php } ?>
                            </dl>
                        </div>
                    </div>
                    <?php $n++;}unset($n); } ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
        <?php } else { ?>
        <!--其他-->
        <div class="line-info-container">
            <h3 class="line-info-bar">
                <span class="title-txt"><?php echo $row['chinesename'];?></span>
            </h3>
            <div class="line-info-wrapper clearfix">
                <?php echo $row['content'];?>
            </div>
        </div>
        <?php } ?>
        <?php $n++;}unset($n); } ?>
    
    <?php echo Request::factory("pub/code")->execute()->body(); ?>
    <?php echo Request::factory('pub/footer')->execute()->body(); ?>
<?php if($info['status']!=3) { ?>
    <div class="product-under-shelves">
    <div class="shelves-txt">非常抱歉！该商品已下架！</div>
    </div>
    <?php } ?>
    <div class="bom_link_box">
        <div class="bom_fixed">
            <a href="tel:<?php echo $GLOBALS['cfg_m_phone'];?>">电话咨询</a>
        <?php if($info['status'] == 3 && $suitlist) { ?>
              <a class="on order"  data-id="<?php echo $info['id'];?>" href="javascript:;" >立即预定</a>
        <?php } else { ?>
        <a class="on order grey"   href="javascript:;" >立即预定</a>
        <?php } ?>
        </div>
    </div>
    <?php if(St_Functions::is_normal_app_install('together')) { ?>
         <?php echo Request::factory("together/joinlist/typeid/$typeid/productid/".$info['id'])->execute()->body(); ?>
    <?php } ?>
    <!-- 参团弹出框 -->
    <script>
        $(function(){
            insertVideo();
            //详情页滚动图
            var mySwiper = new Swiper('.st-photo-container', {
                autoPlay: false,
                pagination : '.swiper-pagination',
                lazyLoading : true,
                observer: true,
                observeParents: true
            });
            $('.pl').click(function(){
                var url = SITEURL+"pub/comment/id/<?php echo $info['id'];?>/typeid/<?php echo $typeid;?>";
                window.location.href = url;
            });
            //问答页面
            $('.question').click(function(){
                var url = SITEURL+"question/product_question_list?articleid=<?php echo $info['id'];?>&typeid=<?php echo $typeid;?>";
                window.location.href = url;
            });
            //预订按钮
            $('.order').click(function(){
                var productid = $(this).attr('data-id');
                if(productid)
                {
                    url = SITEURL+'line/book/id/'+productid;
                    window.location.href = url;
                }
            })
            //拼团
            $(".group-info-block").click(function(){
                $(".group-list-block").show();
                $("html,body").css({height:"100%",overflow:"hidden"});
            });
            $("#group-close-ico").click(function(){
                $(".group-list-block").hide();
                $("html,body").css({height:"auto",overflow:"auto"});
            });
        });
        //视屏
        function insertVideo(){
            <?php if($info['product_video']) { ?>
                //<?php list($videoPath)=explode('|',$info['product_video'])?>
                var video,
                    bigLIElem = '<li class="swiper-slide">' +
                                    '<video id="myVideo" class="video-js" preload="auto" width="100%" height="100%" style="object-fit:fill" x5-playsinline="true" webkit-playsinline="" playsinline="" poster="<?php echo Common::img($info['litpic'],450,225);?>" data-setup="{}">' +
                                        '<source src="<?php echo $GLOBALS["cfg_m_main_url"];?><?php echo $videoPath;?>" type="video/mp4">' +
                                        '<source src="<?php echo $GLOBALS["cfg_m_main_url"];?><?php echo $videoPath;?>" type="video/webm">' +
                                    '</video>' +
                                    '<span class="vis-play-btn"></span>' +
                                    '<span class="vis-pause-btn hide"></span>' +
                                '</li>';    
                $(".swiper-wrapper").prepend(bigLIElem);
                video = document.getElementById("myVideo");
                $(".vis-play-btn").on("click",function(){
                    if(video.paused){
                        $(this).hide();
                        video.play();
                    }
                    else{
                        video.pause();
                    }
                });
                $(video).on("click",function(){
                    if(!video.paused){
                        if($(".vis-pause-btn").hasClass("hide")){
                            $(".vis-pause-btn").removeClass("hide");
                        }
                        else{
                            $(".vis-pause-btn").addClass("hide");
                        }
                    }
                });
                $(video).on("ended",function(){
                    $(".vis-play-btn").show();
                });
                $(".vis-pause-btn").on("click",function(){
                    $(this).addClass("hide");
                    $(".vis-play-btn").show();
                    video.pause();
                })
            <?php } ?>
        }
    </script>
</body>
</html>
