<?php if(!empty($GLOBALS['cfg_usernav_open'])) { ?> <div class="st-global"> <?php echo Request::factory("pub/startcity")->execute()->body(); ?> <!-- <div class="global-bt"><?php echo __('旅游导航');?></div> --> <?php require_once ("E:/wamp64/www/taglib/usernav.php");$usernav_tag = new Taglib_Usernav();if (method_exists($usernav_tag, 'topkind')) {$data = $usernav_tag->topkind(array('action'=>'topkind','row'=>'9',));}?> <?php if(!empty($data)) { ?> <div class="global-list" <?php if(empty($indexpage)) { ?>style="display: none;"<?php } ?>
> <?php $k=0;$i=0;?> <?php $n=1; if(is_array($data)) { foreach($data as $nav) { ?> <div class="gl-list-tabbox"> <h3> <strong><em><i style="float:left;background: url(<?php echo Common::img($nav['litpic']);?>);width: 35px;height: 35px; margin: 5px 10px 0 0;" class="usernavicon<?php echo $i++;?>"></i></em><a <?php if(!empty($nav['url'])&&filter_var($nav['url'],FILTER_VALIDATE_URL)) { ?>href="<?php echo $nav['url'];?>" <?php } else { ?>href="javascript:;"<?php } ?>
target="_blank"><?php echo $nav['kindname'];?></a></strong> <p> <?php require_once ("E:/wamp64/www/taglib/usernav.php");$usernav_tag = new Taglib_Usernav();if (method_exists($usernav_tag, 'childnav')) {$childnav = $usernav_tag->childnav(array('action'=>'childnav','parentid'=>$nav['id'],'row'=>'5','return'=>'childnav',));}?> <?php $n=1; if(is_array($childnav)) { foreach($childnav as $c) { ?> <a <?php if(!empty($c['url'])) { ?>href="<?php echo $c['url'];?>"<?php } else { ?>href="javascript:;"<?php } ?>
 target="_blank"><?php echo $c['kindname'];?></a> <?php $n++;}unset($n); } ?> </p> <i class="arrow-rig"></i> </h3> <div class="tabcon-item"> <div class="item-list"> <?php require_once ("E:/wamp64/www/taglib/usernav.php");$usernav_tag = new Taglib_Usernav();if (method_exists($usernav_tag, 'childnav')) {$childnav2 = $usernav_tag->childnav(array('action'=>'childnav','parentid'=>$nav['id'],'row'=>'100','return'=>'childnav2',));}?> <?php $ind = 1;?> <?php $n=1; if(is_array($childnav2)) { foreach($childnav2 as $r2) { ?> <dl <?php if($ind%2!=0 && $ind!=1) { ?>class="clear"<?php } ?>
> <dt><a <?php if(!empty($r2['url'])) { ?>href="<?php echo $r2['url'];?>"<?php } else { ?>href="javascript:;"<?php } ?>
 target="_blank"><?php echo $r2['kindname'];?></a></dt> <dd> <?php require_once ("E:/wamp64/www/taglib/usernav.php");$usernav_tag = new Taglib_Usernav();if (method_exists($usernav_tag, 'childnav')) {$childnav3 = $usernav_tag->childnav(array('action'=>'childnav','parentid'=>$r2['id'],'return'=>'childnav3','row'=>'100',));}?> <?php $n=1; if(is_array($childnav3)) { foreach($childnav3 as $r3) { ?> <a <?php if(!empty($r3['url'])) { ?>href="<?php echo $r3['url'];?>"<?php } else { ?>href="javascript:;"<?php } ?>
 target="_blank"><?php echo $r3['kindname'];?></a> <?php $n++;}unset($n); } ?> </dd> </dl> <?php $ind++;?> <?php $n++;}unset($n); } ?> </div> <div class="ad-box"> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'sortad')) {$pluginad = $ad_tag->sortad(array('action'=>'sortad','index'=>$k,'pc'=>'1','adname'=>'Header_Usernav_1,Header_Usernav_2,Header_Usernav_3,Header_Usernav_4,Header_Usernav_5,Header_Usernav_6','return'=>'pluginad',));}?> <?php if(!empty($pluginad)) { ?> <a <?php if(!empty($pluginad['adlink'])) { ?>href="<?php echo $pluginad['adlink'];?>"<?php } else { ?>href="javascript:;"<?php } ?>
 target="_blank"><img src="<?php echo Common::img($pluginad['adsrc']);?>" title="<?php echo $pluginad['adname'];?>" width="220" height="560"></a> <?php } ?> </div> </div> </div> <?php $k++;?> <?php $n++;}unset($n); } ?> </div> <?php } ?> </div> <script>
    $(function(){
      // 境内
      $('.usernavicon2').css('background-position', '-35px 0');
      // 港澳台
      $('.usernavicon3').css('background-position', '-70px 0');
      // 东北亚
      $('.usernavicon4').css('background-position', '-105px 0');
      // 东南亚
      $('.usernavicon5').css({'background-position':'0 -35px','height':'36px'});
      // 欧洲
      $('.usernavicon6').css({'background-position':'-35px -35px','height':'36px'});
      // 美洲
      $('.usernavicon7').css({'background-position':'-70px -35px','height':'36px'});
      // 澳新中东非洲
      $('.usernavicon8').css({'background-position':'-108px -35px','height':'36px'});
        $('.gl-list-tabbox,.st-dh-con').hover(function(){
            $(this).children('h3').addClass('hover').next('.tabcon-item,.st-dh-item').show();
            $(this).children('h3').find('.arrow-rig').hide();
        },function(){
            $(this).children('h3').removeClass('hover').next('.tabcon-item,.st-dh-item').hide();
            $(this).children('h3').find('.arrow-rig').show();
        })
        <?php if(empty($indexpage)) { ?>
            $('.global-list').hide();
            $('.st-global').hoverDelay(function(){
                $('.global-list').show();
            },function(){
                $('.global-list').hide();
            })
        <?php } ?>
    })
</script> <?php } ?>
