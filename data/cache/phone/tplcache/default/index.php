<!doctype html>
<html>
<head>
    <!-- 清除缓存 -->
    <META HTTP-EQUIV="pragma" CONTENT="no-cache"> 
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate"> 
    <META HTTP-EQUIV="expires" CONTENT="0">
    <!-- 清除缓存结束 -->
    <meta charset="utf-8">
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $webname;?></title>
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>"/>
    <?php } ?>
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>"/>
    <?php } ?>
    <meta name="author" content="<?php echo $webname;?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?php echo $GLOBALS['cfg_m_main_url'];?>/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?php echo $GLOBALS['cfg_m_main_url'];?>/favicon.ico" type="image/x-icon"/>
    <?php echo Common::css('base.css,swiper.min.css,index.css,reset-style.css');?>
    <?php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,template.js,layer/layer.m.js,delayLoading.min.js');?>
</head>
<body>
    <?php echo Request::factory("pub/header_new/typeid/0/isindex/1")->execute()->body(); ?>
    <div class="swiper-container st-focus-banners">
        <ul class="swiper-wrapper">
            <?php require_once ("E:/wamp64/www/phone/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'s_index_1',));}?>
                <?php $n=1; if(is_array($data['aditems'])) { foreach($data['aditems'] as $v) { ?>
                    <li class="swiper-slide">
                        <a class="item" href="<?php echo $v['adlink'];?>"><img class="swiper-lazy" data-src="<?php echo Common::img($v['adsrc'],750,320);?>"></a>
                        <div class="swiper-lazy-preloader"></div>
                    </li>
                <?php $n++;}unset($n); } ?>
            
        </ul>
        <div class="swiper-pagination"></div>
    </div>
    <!-- 轮播图 -->
    <div class="st-search">
        <div class="st-search-box">
            <div class="st-search-down clearfix">
                <span  class="st-down-select"  ></span>
                <span class="st-down-ico"><i class=""></i></span>
            </div>
            <input type="text" class="st-search-text" id="keyword" placeholder="<?php echo Model_Global_Search::get_hot_search_default();?>"/>
            <input type="button" class="st-search-btn" value=""/>
        </div>
    </div>
    <!-- 搜索 -->
    <div class="st-home-menu">
        <?php require_once ("E:/wamp64/www/phone/taglib/channel.php");$channel_tag = new Taglib_Channel();if (method_exists($channel_tag, 'getchannel')) {$data = $channel_tag->getchannel(array('action'=>'getchannel','row'=>'100',));}?>
            <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
                <a class="menu-item" href="<?php echo $row['url'];?>">
                    <span class="icon"><img src="<?php echo $row['ico'];?>"/></span>
                    <span class="text"><?php echo $row['title'];?></span>
                </a>
            <?php $n++;}unset($n); } ?>
        
    </div>
    <!-- 主导航 -->
    <div class="st-sale-box">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">特价优惠</span>
        </h3>
        <div class="st-sale-con">
            <div class="st-advpic-l">
                <?php require_once ("E:/wamp64/www/phone/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'s_index_2','row'=>'1',));}?>
                    <?php if(!empty($data)) { ?>
                        <a class="item" href="<?php echo $data['adlink'];?>"><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($data['adsrc'],375,340);?>" title="<?php echo $data['adname'];?>"></a>
                    <?php } ?>
                
            </div>
            <div class="st-advpic-r">
                <?php require_once ("E:/wamp64/www/phone/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'s_index_3','row'=>'1',));}?>
                    <?php if(!empty($data)) { ?>
                        <a class="item" href="<?php echo $data['adlink'];?>"><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($data['adsrc'],375,170);?>" title="<?php echo $data['adname'];?>"></a>
                    <?php } ?>
                
                <?php require_once ("E:/wamp64/www/phone/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'s_index_4','row'=>'1',));}?>
                    <?php if(!empty($data)) { ?>
                        <a class="item" href="<?php echo $data['adlink'];?>"><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($data['adsrc'],375,170);?>" title="<?php echo $data['adname'];?>"></a>
                    <?php } ?>
                
            </div>
        </div>
    </div>
    <!--特价优惠-->
    <?php require_once ("E:/wamp64/www/phone/taglib/channel.php");$channel_tag = new Taglib_Channel();if (method_exists($channel_tag, 'getchannel')) {$data = $channel_tag->getchannel(array('action'=>'getchannel','row'=>'100',));}?>
        <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
            <?php if($row['m_issystem'] && in_array($row['m_typeid'],array(1,2,3,4,5,6,8,11,13,101,104,105,114,106))) { ?>
                <?php echo  Stourweb_View::template('index/'.Model_Model::all_model($row['m_typeid'],'maintable'));  ?>
            <?php } else if(!empty($row['m_typeid'])&&(Model_Model::all_model($row['m_typeid'],'issystem'))==0&&(Model_Model::all_model($row['m_typeid'],'maintable'))=='model_archive') { ?>
                <?php $pinyin=Model_Model::all_model($row['m_typeid'],'pinyin');?>
                <?php if($row['m_isopen']==1) { ?>
                <div class="st-product-block">
                    <h3 class="st-title-bar">
                        <i class="line-icon"></i>
                        <span class="title-txt"><?php echo $row['m_title'];?></span>
                    </h3>
                    <ul class="st-list-block clearfix">
                        <?php require_once ("E:/wamp64/www/phone/taglib/tongyong.php");$tongyong_tag = new Taglib_Tongyong();if (method_exists($tongyong_tag, 'query')) {$tongyong_data = $tongyong_tag->query(array('action'=>'query','typeid'=>$row['m_typeid'],'flag'=>'order','row'=>'4','return'=>'tongyong_data',));}?>
                        <?php $n=1; if(is_array($tongyong_data)) { foreach($tongyong_data as $row2) { ?>
                        <li>
                            <a class="item" href="<?php echo $row2['url'];?>">
                                <div class="pic"><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($row2['litpic'],330,225);?>" alt="<?php echo $row2['title'];?>"/></div>
                                <div class="tit"><?php echo $row2['title'];?><span class="md"><?php echo $row2['sellpoint'];?></span></div>
                                <div class="price">
                                    <?php if(!empty($row2['price'])) { ?>
                                    <span class="jg"><i class="currency_sy no-style"><?php echo Currency_Tool::symbol();?></i><span class="num"><?php echo $row2['price'];?></span>起</span>
                                    <?php } else { ?>
                                    <span class="dx">电询</span>
                                    <?php } ?>
                                </div>
                            </a>
                        </li>
                        <?php $n++;}unset($n); } ?>
                        
                    </ul>
                    <div class="st-more-bar">
                        <a class="more-link" href="<?php echo $cmsurl;?><?php echo $pinyin;?>/all/">查看更多</a>
                    </div>
                </div>
                <?php } ?>
            <?php } ?>
        <?php $n++;}unset($n); } ?>
    
   
    <?php echo Request::factory("pub/code")->execute()->body(); ?>
    <?php echo Request::factory("pub/footer")->execute()->body(); ?>
    <?php if(!empty($GLOBALS['cfg_m_phone'])) { ?>
        <a class="call-phone" href="tel:<?php echo $GLOBALS['cfg_m_phone'];?>"></a>
    <?php } ?>
    <!--全局搜索弹出框-->
    <div class="search-sx-box">
        <div class="search-sx">
            <?php $searchModel = Model_Model::get_wap_search_model();?>
            <ul>
                <?php $n=1; if(is_array($searchModel)) { foreach($searchModel as $m) { ?>
                <li  <?php if($m['issystem']==1) { ?>  data-pinyin="<?php echo $m['pinyin'];?>"  <?php } else { ?>  data-pinyin="general/index/<?php echo $m['pinyin'];?>" <?php } ?>
 ><span><?php echo $m['modulename'];?></span><i></i></li>
                <?php $n++;}unset($n); } ?>
            </ul>
        </div>
    </div>
</body>
</html>
<script>
    $(function () {
        //首页滚动广告
        var mySwiper = new Swiper('.st-focus-banners', {
            autoplay: 5000,
            pagination : '.swiper-pagination',
            lazyLoading : true,
            observer: true,
            observeParents: true
        });
        //过滤非法字符
        function StripScript(s){
            var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）――|{}【】‘；：”“'。，、？]");
            var rs = "";
            for (var i = 0; i < s.length; i++) {
                rs = rs+s.substr(i, 1).replace(pattern, '');
            }
            return rs;
        }
        //全局搜索弹出框
        $(".st-search-down").click(function(){
            $(".search-sx-box").show();
            $("html,body").css({
                height: "100%",
                overflow: "hidden"
            })
        });
        $(".search-sx-box").click(function(){
            $(this).hide();
            $("html,body").css({
                height: "auto",
                overflow: "auto"
            })
        });
         $(".search-sx li").click(function(event){
            $(this).addClass("on").siblings().removeClass("on");
            var words=$(this).text();
            var pinyin = $(this).attr('data-pinyin');
            $(".st-down-select").text(words);
            $(".st-down-select").attr('data-pinyin',pinyin);
        });
         $('.search-sx li:first').trigger('click');
        //全局搜索
        $('.st-search-btn').click(function () {
            var keyword = StripScript($.trim($("#keyword").val()));
            if (keyword == '') {
                keyword = $('#keyword').attr('placeholder');
                if(keyword == '')
                {
                    layer.open({
                        content: '<?php echo __("error_keyword_not_empty");?>',
                        btn: ['<?php echo __("OK");?>']
                    });
                    return false;
                }
            }
                var pinyin = $(".st-down-select").attr('data-pinyin');
                url = SITEURL + 'query/'+pinyin+'?keyword=' + encodeURIComponent(keyword);
                window.location.href = url;
        });
        //团购时间
        $('.st-tuan-list').find('.count').each(function (index, element) {
            show_count(element);
        });
        function show_count(node) {
            var endTime = $(node).attr('end-time') * 1000;
            var startTime = $(node).attr('start-time') * 1000;
            var timer_rt = window.setInterval(function () {
                var time;
                var now = new Date();
                now = now.getTime();
                if (startTime > now) {
                    time = startTime - now;
                    $(node).find('.sy').html('开始时间');
                } else if (endTime > now) {
                    time = endTime - now;
                    $(node).find('.sy').html('结束时间');
                } else {
                    $(node).find('.sy').html('已结束');
                    $(node).parents('li').remove();
                    clearInterval(timer_rt);
                }
                time = parseInt(time / 1000);
                var day = Math.floor(time / (60 * 60 * 24));
                var hour = Math.floor((time - day * 24 * 60 * 60) / 3600);
                var minute = Math.floor((time - day * 24 * 60 * 60 - hour * 3600) / 60);
                var html = '';
                if (day > 0) {
                    html += day + '天';
                }
                if (hour > 0) {
                    html += hour + '时';
                }
                if (minute > 0) {
                    html += minute + '分';
                }
                $(node).find('.time').html(html);
            }, 1000);
        }
    })
    document.addEventListener("plusready", function () {
        // 注册返回按键事件
        plus.key.addEventListener('backbutton', function () {
            // 事件处理
            plus.nativeUI.confirm("退出程序？", function (event) {
                if (!event.index) {
                    plus.runtime.quit();
                }
            }, null, ["取消", "确定"]);
        }, false);
    });
</script>