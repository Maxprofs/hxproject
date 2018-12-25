<!doctype html> <html> <head> <meta charset="utf-8"> <title><?php echo $seoinfo['seotitle'];?>-<?php echo $webname;?></title> <?php if($seoinfo['keyword']) { ?> <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>"/> <?php } ?> <?php if($seoinfo['description']) { ?> <meta name="description" content="<?php echo $seoinfo['description'];?>"/> <?php } ?> <?php echo $GLOBALS['cfg_indexcode'];?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css("font-awesome.min.css,base.css,index_2.css,extend.css");?> <?php echo Common::js("jquery.min.js,jquery.cookie.js,base.js,common.js,SuperSlide.min.js,slideTabs.js,delayLoading.min.js");?> <script>
    $(function(){
        $('.con_list,.car_con_list,.article_con').switchTab({trigger:'hover'});
            //首页焦点图
            $('.st-focus-banners').slide({
                mainCell:".banners ul",
                titCell:".focus li",
                effect:"fold",
                interTime: 5000,
                delayTime: 1000,
                autoPlay:true,
                switchLoad:"original-src"
            });
    })
</script> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="usernav-frame"> <div class="usernav"> <?php echo  Stourweb_View::template("pub/usernav");  ?> <div class="index-right"> <!--滚动焦点图开始--> <div class="st-focus-banners"> <div class="banners"> <ul> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$ad = $ad_tag->getad(array('action'=>'getad','name'=>'Index2RollingAd','pc'=>'1','return'=>'ad',));}?> <?php $n=1; if(is_array($ad['aditems'])) { foreach($ad['aditems'] as $v) { ?> <li class="banner"><a href="<?php echo $v['adlink'];?>" target="_blank"><img src="<?php echo Product::get_lazy_img();?>" original-src="<?php echo Common::img($v['adsrc'],810,235);?>" /></a></li> <?php $n++;}unset($n); } ?> </ul> </div> <div class="focus"> <ul> <?php $n=1; if(is_array($ad['aditems'])) { foreach($ad['aditems'] as $k) { ?> <li></li> <?php $n++;}unset($n); } ?> </ul> </div> </div> <!--滚动焦点图结束--> <div class="arr"> <span class="arrspan">出行风向标<i class="arri"></i></span> <div> <div class="usertitle hot"> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'indexhot','pc'=>'1','row'=>'1',));}?> <?php if(!empty($data)) { ?> <div class="userbanner"> <a href="<?php echo $data['adlink'];?>" target="_blank"> <img class="userimg" src="<?php echo Common::img($data['adsrc']);?>" title="<?php echo $data['adname'];?>"> </a> </div> <?php } ?> </div> <!-- 近期热门 --> <div class="usertitle"> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'indexnew','pc'=>'1','row'=>'1',));}?> <?php if(!empty($data)) { ?> <div class="userbanner usernew"> <a href="<?php echo $data['adlink'];?>" target="_blank"> <img class="userimg" src="<?php echo Common::img($data['adsrc']);?>" title="<?php echo $data['adname'];?>"> </a> </div> <?php } ?> </div> <!-- 新品上市 --> <div class="usertitle"> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'indexval','pc'=>'1','row'=>'1',));}?> <?php if(!empty($data)) { ?> <div class="userbanner"> <a href="<?php echo $data['adlink'];?>" target="_blank"> <img class="userimg" src="<?php echo Common::img($data['adsrc']);?>" title="<?php echo $data['adname'];?>"> </a> </div> <?php } ?> </div> <!-- 超值特价 --> </div> </div> <div class="top_pz_box"> <div class="child"><i class="fa fa-camera ico"></i> <span class="txt">深度旅行线路</span></div> <div class="child"><i class="fa fa-star ico"></i> <span class="txt">专业精品小团</span></div> <div class="child"><i class="fa fa-diamond ico"></i> <span class="txt">全程细心指导</span></div> <div class="child"><i class="fa fa-thumbs-up ico"></i> <span class="txt">全面安全保障</span></div> </div> </div> </div> </div> <div class="user-frame"> <div class="usernav"> <div class="useradvtitle"> <div class="useradvbg"></div> <!-- 广告1 --> <div class="useradv"> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'indexadv1','pc'=>'1','row'=>'1',));}?> <?php if(!empty($data)) { ?> <div class="useradvbanner"> <a href="<?php echo $data['adlink'];?>" target="_blank"> <img class="useradvimg1 advright" src="<?php echo Common::img($data['adsrc']);?>" title="<?php echo $data['adname'];?>"> </a> </div> <?php } ?> </div> <!-- 广告2 --> <div class="useradv"> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'indexadv2','pc'=>'1','row'=>'1',));}?> <?php if(!empty($data)) { ?> <div class="useradvbanner"> <a href="<?php echo $data['adlink'];?>" target="_blank"> <img class="useradvimg2 advright" src="<?php echo Common::img($data['adsrc']);?>" title="<?php echo $data['adname'];?>"> </a> </div> <?php } ?> </div> <div class="useradv useradvbanner"> <table> <td> <tr> <!-- 广告3 --> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'indexadv3','pc'=>'1','row'=>'1',));}?> <?php if(!empty($data)) { ?> <div> <a href="<?php echo $data['adlink'];?>" target="_blank"> <img class="useradvimg3 advright" src="<?php echo Common::img($data['adsrc']);?>" title="<?php echo $data['adname'];?>"> </a> </div> <?php } ?> </tr> <tr> <!-- 广告4 --> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'indexadv4','pc'=>'1','row'=>'1',));}?> <?php if(!empty($data)) { ?> <div> <a href="<?php echo $data['adlink'];?>" target="_blank"> <img class="useradvimg4" src="<?php echo Common::img($data['adsrc']);?>" title="<?php echo $data['adname'];?>"> </a> </div> <?php } ?> </tr> </td> </table> </div> </div> </div> </div> <!--品质保证--> <div class="big"> <div class="wm-1200"> <?php require_once ("E:/wamp64/www/taglib/channel.php");$channel_tag = new Taglib_Channel();if (method_exists($channel_tag, 'pc')) {$data = $channel_tag->pc(array('action'=>'pc','row'=>'20',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?> <?php if($row['typeid'] < 14 && $row['issystem'] && !in_array($row['typeid'],array(0,6,7,9,10,11,12))) { ?> <?php echo  Stourweb_View::template('standard_pc_0_2_index/index_2/'.Model_Model::all_model($row['typeid'],'maintable'));  ?> <?php } ?> <?php $n++;}unset($n); } ?> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Request::factory("pub/flink/isindex/1")->execute()->body(); ?> </body> </html>
