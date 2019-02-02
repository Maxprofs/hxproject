<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head html_strong=SvRzDt > <meta charset="utf-8"> <title>优惠券领取-<?php echo $GLOBALS['cfg_webname'];?></title> <?php if($seoinfo['keyword']) { ?> <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" /> <?php } ?> <?php if($seoinfo['description']) { ?> <meta name="description" content="<?php echo $seoinfo['description'];?>" /> <?php } ?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css_plugin('coupon.css','coupon');?> <?php echo Common::css('base.css,user.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js');?> </head> <body> <?php echo Request::factory('pub/header')->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="/">首页</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;会员中心
        </div> <!--面包屑--> <div class="st-main-page"> <?php echo  Stourweb_View::template("member/left_menu");  ?> <div class="user-coupon-content"> <div class="user-coupon-block"> <div class="user-coupon-tit clearfix"><strong class="bt">优惠券</strong><a class="more-link" href="/coupon">领用优惠券&gt;</a></div> <div class="user-coupon-item"> <div class="down-select"> <strong class="hd"><?php if($param['isout']==1) { ?> 未使用 <?php } else if($param['isout']==2 ) { ?>已过期 <?php } else if($param['isout']==3 ) { ?>已使用 <?php } else { ?>全部  <?php } ?>
（<?php echo count($list);?>）<i></i></strong> <ul class="bd isout"> <li isout="0">全部</li> <li isout="1">未使用</li> <li isout="2">已过期</li> <li isout="3">已使用</li> </ul> </div> <div class="down-select"> <strong class="hd"  > <?php if($param['kindid']==1) { ?>通用券<?php } else if($param['kindid']==2) { ?>兑换券<?php } else { ?>全部 <?php } ?> </strong> <ul class="bd kindid"> <li kindid="0">全部</li> <li kindid="1">通用券</li> <li kindid="2">兑换券</li> </ul> </div> </div> <div class="user-coupon-list"> <ul class="clearfix"> <?php $index=1;?> <?php $n=1; if(is_array($list)) { foreach($list as $l) { ?> <li  class=" <?php if($l['isout']==2|| $l['totalnum']==$l['usenum']) { ?>grey  <?php } ?> <?php if($index%4==0) { ?>mr_0 <?php } ?>
 "> <?php if($l['isout']==1&& $l['totalnum']!=$l['usenum']) { ?> <span class="ico"></span> <?php } ?> <div class="t-con"> <span class="attr"> <strong> <?php if($l['type']==0) { ?>
                                            ￥<b><?php echo $l['amount'];?></b> <?php } else { ?> <b><?php echo $l['amount'];?></b>折
                                            <?php } ?> </strong> <em><?php echo $l['name'];?>【<?php if($l['kindid']==1) { ?>通用券<?php } else { ?>兑换券<?php } ?>
】</em> </span> <?php if($l['samount']) { ?> <span class="md">【满<?php echo $l['samount'];?>元可用】</span> <?php } else { ?> <span class="md">【无金额限制】</span> <?php } ?> <?php if($l['isnever']==1) { ?> <span class="date"><?php echo $l['starttime'];?>~<?php echo $l['endtime'];?></span> <?php } else { ?> <span class="date">永久有效</span> <?php } ?> </div> <div class="b-con"> <ul> <li>品类限制：<span class="y1"><?php if($l['typename']) { ?><?php echo Common::cutstr_html($l['typename'],12);?>产品<?php } else { ?> 无品类限制<?php } ?> </span></li> <li>使用限制：<span class="y1">需提前<?php echo $l['antedate'];?>天使用</span></li> <?php if($l['ordersn']) { ?> <li>订单号 ：<a href="/member/order/view?ordersn=<?php echo $l['ordersn'];?>"><span class="y2"><?php echo $l['ordersn'];?></span></a></li> <?php } ?> </ul> <?php if($l['isout']!=2&& $l['totalnum']!=$l['usenum']) { ?> <a class="use-btn" href="<?php echo $cmsurl;?>coupon/search-<?php echo $l['cid'];?>">立即使用</a> <?php } ?> </div> <?php if($l['isout']!=2&& $l['totalnum']!=$l['usenum']) { ?> <span class="num">共<?php echo $l['totalnum'];?>张</span> <?php } else if($l['isout']==2&& $l['totalnum']!=$l['usenum']) { ?> <span class="over-time"></span> <?php } else if($l['totalnum']==$l['usenum']) { ?> <span class="use-over"></span> <?php } ?> </li> <?php $index++;?> <?php $n++;}unset($n); } ?> </ul> <?php if(empty($list)) { ?> <div class="no-coupon"> <i class="icos"></i> <p>您的优惠券空空如也，赶紧<a class="color-2" href="/coupon">领取优惠券！</a></p> </div> <?php } ?> </div> </div> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div> <!-- 翻页 --> </div> <!-- 优惠券列表 --> </div> <input type="hidden" id="kindid" value="<?php echo $param['kindid'];?>"> <input type="hidden" id="isout" value="<?php echo $param['isout'];?>"> </div> </div> <?php echo Request::factory('pub/footer')->execute()->body(); ?> </body> </html> <script>
    $(function(){
        $('.isout li').click(function(){
            var isout = $(this).attr('isout');
            var kindid = $('#kindid').val();
            var url = SITEURL +'member/coupon-'+isout+'-'+kindid;
            window.location.href = url;
        })
        $('.kindid li').click(function(){
            var kindid = $(this).attr('kindid');
            var isout = $('#isout').val();
            var url = SITEURL +'member/coupon-'+isout+'-'+kindid;
            window.location.href = url;
        })
        $("#nav_mycoupon").addClass('on');
        if(typeof(on_leftmenu_choosed)=='function')
        {
            on_leftmenu_choosed();
        }
    })
</script>
