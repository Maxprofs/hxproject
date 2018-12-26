<!doctype html> <html> <head table_head=MSuttC > <meta charset="utf-8"> <title>优惠券领取-<?php echo $GLOBALS['cfg_webname'];?></title> <?php if($seoinfo['keyword']) { ?> <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" /> <?php } ?> <?php if($seoinfo['description']) { ?> <meta name="description" content="<?php echo $seoinfo['description'];?>" /> <?php } ?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css_plugin('coupon.css','coupon');?> <?php echo Common::css('base.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js');?> </head> <body> <?php echo Request::factory('pub/header')->execute()->body(); ?> <div class="coupon-slide"> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$ad = $ad_tag->getad(array('action'=>'getad','name'=>'Coupon_Index_Ad1','pc'=>'1','return'=>'ad',));}?> <a class="pic" href="<?php echo $ad['adlink'];?>" target="_blank"><img src="<?php echo Common::img($ad['adsrc'],1920,380);?>" alt=" <?php echo $ad['adname'];?>" width="1920" height="380" /></a> </div> <!-- 广告图 --> <div class="big"> <div class="wm-1200"> <div class="coupon-list-content"> <h3 class="coupon-list-tit">免费领券</h3> <div class="coupon-list-block"> <ul class="clearfix"> <?php $index=1;?> <?php $n=1; if(is_array($list)) { foreach($list as $l) { ?> <li class="<?php if($l['status']==2) { ?>over <?php } else if($l['status']==3) { ?>usable<?php } else { ?><?php } ?> <?php if($index%3==0) { ?> mr_0<?php } ?>
"> <?php if($l['status']!=2&&$l['isout']==1) { ?> <span class="attr"></span> <?php } ?> <div class="l-con"> <span class="hd"> <?php if($l['type']==0) { ?> <strong class="jg">￥<b><?php echo $l['amount'];?></b></strong> <?php } else { ?> <strong class="jg"><b><?php echo $l['amount'];?>折</b></strong> <?php } ?> <span class="se"> <em class="t1"><?php echo $l['name'];?></em> <?php if($l['samount']) { ?> <em class="t2">满<?php echo $l['samount'];?>元可用</em> <?php } else { ?> <em class="t2">无金额限制</em> <?php } ?> </span> </span> <?php if($l['typeid']==0) { ?> <span class="xg">品类限制：无品类限制</span> <?php } else if($l['typeid']==1) { ?> <span class="xg">品类限制：<?php echo $l['typename'];?>产品</span> <?php } else { ?> <span class="xg">品类限制：限购部分<?php echo Common::cutstr_html($l['typename'],12);?>产品</span> <?php } ?> <span class="xl">需提前<?php echo $l['antedate'];?>天使用，每人限领<?php echo $l['maxnumber'];?>张</span> <?php if($l['isnever']==1) { ?> <span class="date"><?php echo $l['starttime'];?>~<?php echo $l['endtime'];?></span> <?php } else { ?> <span class="date">永久有效</span> <?php } ?> <?php if($l['status']==3) { ?> <span class="num"><?php echo $l['surplus'];?>张</span> <?php } else { ?> <span class="num">还剩<b><?php echo $l['surplus'];?></b>张</span> <?php } ?> </div> <?php if($l['status']==1||$l['status']==4) { ?> <a class="r-btn get_coupon"   <?php if($l['gradename_all']) { ?> title="<?php echo $l['gradename_all'];?>可领取"<?php } ?>
  href="javascript:void(0)" couponid="<?php echo $l['id'];?>">
                            免费领取
                            <?php if($l['gradename']) { ?> <span><i>（<?php echo $l['gradename'];?>等可领取）</i></span> <?php } ?> </a> <?php } else if($l['status']==2) { ?> <span class="r-btn">今日已领完</span> <span class="label"></span> <?php } else if($l['status']==3) { ?> <a class="r-btn" href="<?php echo $cmsurl;?>coupon/search-<?php echo $l['id'];?>">立即使用</a> <?php } ?> </li> <?php $index++;?> <?php $n++;}unset($n); } ?> </ul> </div> <div class="clearfix"> </div> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div> </div> </div> </div> <?php echo Request::factory('pub/footer')->execute()->body(); ?> <?php echo Request::factory('pub/flink')->execute()->body(); ?> <?php echo Common::js('layer/layer.js',0);?> </body> </html> <script>
    $(function(){
        //领取优惠券
        $('.get_coupon').click(function(){
            var couponid = $(this).attr('couponid');
            $.ajax({
                type: 'POST',
                url: SITEURL + 'coupon/ajxa_get_coupon',
                data: {cid:couponid},
                async: false,
                dataType: 'json',
                success: function (data) {
                    if(data.status==0)
                    {
                        layer.msg(data.msg, {icon: 5,time: 1000});
                    }
                    if(data.status==1)
                    {
                        layer.msg(data.msg, {icon: 5,time: 1000},function(){
                            var url = SITEURL+'member/login?redirecturl=<?php echo $redirecturl;?>';
                            window.location.href=url;
                        });
                    }
                    if(data.status==2)
                    {
                        layer.msg(data.msg, {icon: 6,time: 1000},function(){
                            window.location.reload();
                        });
                    }
                }
            })
        })
    })
</script>
