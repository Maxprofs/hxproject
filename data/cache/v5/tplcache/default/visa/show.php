<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head div_head=LZzCXC > <meta charset="utf-8"> <head> <meta charset="utf-8"> <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title> <?php if($seoinfo['keyword']) { ?> <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" /> <?php } ?> <?php if($seoinfo['description']) { ?> <meta name="description" content="<?php echo $seoinfo['description'];?>" /> <?php } ?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css_plugin('visa.css','visa');?> <?php echo Common::css('base.css,extend.css',false);?> <?php echo Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,slideTabs.js,delayLoading.min.js');?> </head> <script>
$(function(){
$('.crowd-tabbox').switchTab();
            if($('#attachment').length>0){
                $('#download_arr').removeClass('hide');
            }
})
</script> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <?php if(St_Functions::is_normal_app_install('coupon')) { ?> <?php echo Request::factory('coupon/float_box-'.$typeid.'-'.$info['id'])->execute()->body(); ?> <?php } ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo $GLOBALS['cfg_indexname'];?></a>&gt;
            <a href="/visa/"><?php echo $channelname;?></a>&gt;
            <?php echo $info['title'];?> </div><!--面包屑--> <div class="st-main-page"> <div class="visa_show_top"> <div class="pic"><a href="javascript:;"><img src="<?php echo Common::img($info['litpic'],450,306);?>" alt="<?php echo $info['title'];?>" /></a></div> <div class="txt_con"> <h1><?php echo $info['title'];?> <?php $n=1; if(is_array($info['iconlist'])) { foreach($info['iconlist'] as $icon) { ?> <img src="<?php echo $icon['litpic'];?>" /> <?php $n++;}unset($n); } ?></h1> <ul> <li class="li_c"> <span>销量：<?php echo $info['sellnum'];?></span> <span>|</span> <span>满意度：<?php if($info['satisfyscore']) { ?><?php echo $info['satisfyscore'];?><?php } else { ?>100<?php } ?>
%</span> <span>|</span> <a href="#comment_target"><?php echo $info['commentnum'];?>条点评</a> </li> <li class="li_c"><em>办理时长：</em><?php echo $info['handleday'];?></li> <li class="li_d"><em>签证类型：</em><?php echo $info['visatype'];?></li> <li class="li_d"><em>所属领区：</em><?php echo $info['belongconsulate'];?></li> <li class="li_d"><em>停留时间：</em><?php echo $info['partday'];?></li> <li class="li_d"><em>有效日期：</em><?php echo $info['validday'];?></li> <li class="li_d"><em>面试需要：</em><?php echo $info['interview'];?></li> <li class="li_d"><em>邀 请 函：</em><?php echo $info['letter'];?></li><?php $download=1;?> <li class="li_c"><em>受理范围：</em><?php echo $info['handlerange'];?></li> <?php if(!empty($info['attachment'])) { ?> <li class="li_c hide" id="download_arr"><a class="download-btn" href="#download">下载资料</a></li> <?php } ?> </ul> <?php if(!empty($info['jifentprice_info']) || !empty($info['jifenbook_info']) || !empty($info['jifencomment_info'])) { ?> <div class="msg-ul clearfix"> <em class="item-hd">积分优惠：</em> <div class="item-bd"> <?php if(!empty($info['jifentprice_info'])) { ?> <div class="jf-type-wrap"> <span class="di num"><?php echo Currency_Tool::symbol();?><?php echo $info['jifentprice_info']['jifentprice'];?><i></i></span> <div class="info"> <strong class="tit">积分抵现金</strong> <p class="txt">预订产品可使用积分抵现金，最高可抵<?php echo Currency_Tool::symbol();?><?php echo $info['jifentprice_info']['jifentprice'];?>。</p> </div> </div> <?php } ?> <?php if(!empty($info['jifenbook_info'])) { ?> <div class="jf-type-wrap"> <span class="ding num"><?php echo $info['jifenbook_info']['value'];?><?php if($info['jifenbook_info']['rewardway']==1) { ?>%<?php } else { ?>分<?php } ?> <i></i></span> <div class="info"> <strong class="tit">预订送积分</strong> <p class="txt">预订并消费产品可活动积分赠送，可获得<?php if($info['jifenbook_info']['rewardway']==1) { ?>订单总额<?php echo $info['jifenbook_info']['value'];?>%的<?php } else { ?><?php echo $info['jifenbook_info']['value'];?><?php } ?>
积分。</p> </div> </div> <?php } ?> <?php if(!empty($info['jifencomment_info'])) { ?> <div class="jf-type-wrap"> <span class="ping num"><?php echo $info['jifencomment_info']['value'];?>分<i></i></span> <div class="info"> <strong class="tit">评论送积分</strong> <p class="txt">预订并消费产品后，评论产品通过审核可获得<?php echo $info['jifencomment_info']['value'];?>积分</p> </div> </div> <?php } ?> </div> </div> <?php } ?> <p class="md-js"><?php echo $info['sellpoint'];?></p> </div> <div class="show_msg"> <p class="price">优惠价：<span><?php if(!empty($info['price'])) { ?><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><b><?php echo $info['price'];?></b><?php } else { ?>电询<?php } ?> </span></p> <p class="date"><input type="text" id="usedate" placeholder="请选择出行时间" /></p> <p class="lx"><span><?php echo $info['visatype'];?><s></s></span></p> <p class="num"> <em>预定数量：</em> <span class="sub"></span> <input type="text" id="dingnum" value="1" /> <span class="add"></span> </p> <p class="price">总价：<span><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><b class="totalprice"><?php echo $info['price'];?></b></span></p> <p class="now_btn"><a href="javascript:;">立即预定</a></p> </div> </div><!--顶部介绍--> <div class="st-visa-show"> <div class="visashow-con"> <div class="tabnav-list"> <?php require_once ("E:/wamp64/www/taglib/detailcontent.php");$detailcontent_tag = new Taglib_Detailcontent();if (method_exists($detailcontent_tag, 'get_content')) {$visacontent = $detailcontent_tag->get_content(array('action'=>'get_content','pc'=>'1','typeid'=>$typeid,'productinfo'=>$info,'return'=>'visacontent',));}?> <?php $n=1; if(is_array($visacontent)) { foreach($visacontent as $row) { ?> <?php if($row['columnname']=='attachment' && empty($info['attachment'])) { ?> <?php } else { ?> <span><?php echo $row['chinesename'];?></span> <?php } ?> <?php $n++;}unset($n); } ?> <span>客户评价</span> <span>我要咨询</span> <a class="yd-btn" style="display: none"  href="javascript:;">开始预订</a> </div><!--签证导航--> <div class="tabbox-list"> <?php $n=1; if(is_array($visacontent)) { foreach($visacontent as $v) { ?> <?php if($v['columnname']=='material') { ?> <div class="tabcon-list"> <div class="list-tit"><strong><?php echo $v['chinesename'];?></strong></div> <div class="crowd-tabbox"> <div class="st-tabnav"> <?php $in = 1;?> <?php $n=1; if(is_array($materials)) { foreach($materials as $ma) { ?> <?php if($ma['content']) { ?> <span class="<?php if($in==1) { ?>on<?php } ?>
"><?php echo $ma['title'];?></span> <?php } ?> <?php $in++;?> <?php $n++;}unset($n); } ?> </div> <?php $ind = 1;?> <?php $n=1; if(is_array($materials)) { foreach($materials as $ma) { ?> <?php if($ma['content']) { ?> <div class="st-tabcon" style="display: <?php if($ind==1) { ?>block<?php } else { ?>none<?php } ?>
;"> <?php echo $ma['content'];?> </div> <?php } ?> <?php $ind++;?> <?php $n++;}unset($n); } ?> </div> <div class="list-txt"> </div> </div> <?php } else if($v['columnname']=='attachment') { ?> <?php if(!empty($info['attachment'])) { ?> <a name="download"></a> <div class="tabcon-list"> <div class="list-tit"><strong><?php echo $v['chinesename'];?></strong></div> <div class="list-txt"> <ol class="attachment" id="attachment"> <?php $n=1; if(is_array($info['attachment']['path'])) { foreach($info['attachment']['path'] as $k => $v) { ?> <li><a href="/pub/download/?file=<?php echo $v;?>&name=<?php echo $info['attachment']['name'][$k];?>" title="<?php echo $info['attachment']['name'][$k];?> 下载" class="name"><?php echo $info['attachment']['name'][$k];?></a></li> <?php $n++;}unset($n); } ?> </ol> </div> </div> <?php } ?> <?php } else { ?> <div class="tabcon-list"> <div class="list-tit"><strong><?php echo $v['chinesename'];?></strong></div> <div class="list-txt"> <?php echo Common::content_image_width($v['content'],833,0);?> </div> </div> <?php } ?> <?php $n++;}unset($n); } ?> <?php echo  Stourweb_View::template("pub/comment");  ?> <?php echo  Stourweb_View::template("pub/ask");  ?> </div> </div> </div><!--详情主体--> <div class="st-sidebox"> <?php require_once ("E:/wamp64/www/taglib/right.php");$right_tag = new Taglib_Right();if (method_exists($right_tag, 'get')) {$data = $right_tag->get(array('action'=>'get','typeid'=>$typeid,'data'=>$templetdata,'pagename'=>'show',));}?> </div><!--边栏模块--> </div> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Request::factory("pub/flink")->execute()->body(); ?> <?php echo Common::js('floatmenu/floatmenu.js');?> <?php echo Common::css('/res/js/floatmenu/floatmenu.css',0,0);?> <?php echo Common::js('datepicker/WdatePicker.js',0);?> <input type="hidden" id="price" value="<?php echo $info['price'];?>"> <input type="hidden" id="productid" value="<?php echo $info['id'];?>"/> <script>
    $(function(){
        //积分
        $(".jf-type-wrap").hover(function(){
            $(this).children(".info").show()
        },function(){
            $(this).children(".info").hide()
        });
        //滚动显示预订按钮
        var topHeight = $('.tabnav-list').offset().top;
        $(window).scroll(function(){
            if($(document).scrollTop() >= topHeight){
                $(".yd-btn").show()
            }else{
                $(".yd-btn").hide();
            }
        });
        $(".yd-btn").click(function(){
            $(".now_btn").trigger('click');
        });
        //预订
        $(".now_btn").click(function(){
            if(!is_login_order()){
                return false;
            }
            var productId = $("#productid").val();
            var useDate = $("#usedate").val();
            var dingNum = Number($("#dingnum").val());
            var url = SITEURL+'visa/book?usedate='+useDate+"&productid="+productId+"&dingnum="+dingNum;
            window.location.href = url;
        })
        //内容切换
        $.floatMenu({
            menuContain : '.tabnav-list',
            tabItem : 'span',
            chooseClass : 'on',
            contentContain : '.tabbox-list',
            itemClass : '.tabcon-list'
        });
        $("#usedate").focus(function(){
            WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d',doubleCalendar:false,isShowClear:false,readOnly:true,errDealMode:1})
        })
        //减少数量
        $(".sub").click(function(){
            var dingnum = Number($("#dingnum").val());
            if(dingnum>1){
                dingnum--;
                $("#dingnum").val(dingnum);
            }
            get_total_price();
        })
        //增加数量
        $(".add").click(function(){
            var dingnum = Number($("#dingnum").val());
            dingnum++;
            $("#dingnum").val(dingnum);
            get_total_price();
        })
    })
    //获取总价
    function get_total_price()
    {
        var price = Number($("#price").val());
        var dingnum = Number($("#dingnum").val());
        var total = price * dingnum;
        $('.totalprice').html(total);
    }
</script> <?php echo  Stourweb_View::template("member/login_order");  ?> </body> </html>
