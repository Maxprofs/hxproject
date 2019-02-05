<!doctype html>
<html>
<head table_bottom=56NzDt >
<meta charset="utf-8">
<title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
<?php if($seoinfo['keyword']) { ?>
<meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
<?php } ?>
<?php if($seoinfo['description']) { ?>
<meta name="description" content="<?php echo $seoinfo['description'];?>" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<?php echo Common::css('base.css,destination.css');?>
<?php echo Common::js('lib-flexible.js,jquery.min.js,template.js');?>
</head>
<body>
  <?php echo Request::factory("pub/header_new/typeid/$typeid")->execute()->body(); ?>
    <div class="dest-hd">
        <?php if($destinfo['litpic']) { ?>
        <a href="javascript:;" class="pic">
            <img src="<?php echo Common::img($destinfo['litpic'],750,510);?>" title="<?php echo $destinfo['kindname'];?>"/>
            <div class="dest-msg">
                <span class="ch"><?php echo $destinfo['kindname'];?></span>
                <span class="en"><?php echo strtoupper($destinfo['pinyin']);?></span>
            </div>
            <?php if(St_Functions::is_system_app_install(6)) { ?>
            <div class="photo-link" onclick="window.open('<?php echo $cmsurl;?>photos/<?php echo $destinfo['pinyin'];?>')"><i class="icon"></i><?php echo $destinfo['picnum'];?></div>
            <?php } ?>
        </a>
        <?php } ?>
    </div>
    <!--目的地介绍-->
    <?php if(!empty($destinfo['jieshao'])) { ?>
    <div class="dest-ht">
        <p class="txt"><?php echo St_Functions::cutstr_html($destinfo['jieshao'],40);?></p>
        <a class="more" id="more-dest-info" href="javascript:;">查看全部<i class="icon"></i></a>
    </div>
    <?php } ?>
    <div class="dest-menu clearfix">
        <?php require_once ("E:/wamp64/www/phone/taglib/channel.php");$channel_tag = new Taglib_Channel();if (method_exists($channel_tag, 'destchannel')) {$data = $channel_tag->destchannel(array('action'=>'destchannel','destpinyin'=>$destinfo['pinyin'],'row'=>'100',));}?>
        <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
        <?php if($row['m_typeid']==1) { ?>
        <?php $line_tag = new Taglib_Line();if (method_exists($line_tag, 'query')) {$list = $line_tag->query(array('action'=>'query','flag'=>'mdd','destid'=>$destinfo['id'],'row'=>'1','return'=>'list',));}?>
        <?php } else if($row['m_typeid']==2) { ?>
        <?php $hotel_tag = new Taglib_Hotel();if (method_exists($hotel_tag, 'query')) {$list = $hotel_tag->query(array('action'=>'query','flag'=>'mdd','destid'=>$destinfo['id'],'row'=>'1','return'=>'list',));}?>
        <?php } else if($row['m_typeid']==3) { ?>
        <?php $car_tag = new Taglib_Car();if (method_exists($car_tag, 'query')) {$list = $car_tag->query(array('action'=>'query','flag'=>'recommend','destid'=>$destinfo['id'],'row'=>'1','return'=>'list',));}?>
        <?php } else if($row['m_typeid']==5) { ?>
        <?php $spot_tag = new Taglib_Spot();if (method_exists($spot_tag, 'query')) {$list = $spot_tag->query(array('action'=>'query','flag'=>'mdd','destid'=>$destinfo['id'],'row'=>'1','return'=>'list',));}?>
        <?php } else if($row['m_typeid']==105) { ?>
        <?php ?>
        <?php } else if($row['m_typeid']==104) { ?>
        <?php $ship_tag = new Taglib_Ship();if (method_exists($ship_tag, 'query')) {$list = $ship_tag->query(array('action'=>'query','flag'=>'mdd','destid'=>$destinfo['id'],'row'=>'1','return'=>'list',));}?>
        <?php } else if($row['m_typeid']==114) { ?>
        <?php ?>
        <?php } else if($row['m_typeid']==4) { ?>
        <?php $article_tag = new Taglib_Article();if (method_exists($article_tag, 'query')) {$list = $article_tag->query(array('action'=>'query','flag'=>'mdd_order','destid'=>$destinfo['id'],'row'=>'1','return'=>'list',));}?>
        <?php } else if($row['m_typeid']==13) { ?>
        <?php ?>
        <?php } else if($row['m_typeid']==6) { ?>
        <?php $photo_tag = new Taglib_Photo();if (method_exists($photo_tag, 'query')) {$list = $photo_tag->query(array('action'=>'query','flag'=>'mdd','destid'=>$destinfo['id'],'row'=>'1','return'=>'list',));}?>
        <?php } else if($row['m_typeid']==106) { ?>
        <?php ?>
        <?php } else if($row['m_typeid']>200) { ?>
        <?php require_once ("E:/wamp64/www/phone/taglib/tongyong.php");$tongyong_tag = new Taglib_Tongyong();if (method_exists($tongyong_tag, 'query')) {$list = $tongyong_tag->query(array('action'=>'query','flag'=>'mdd','destid'=>$destinfo['id'],'typeid'=>$row['m_typeid'],'row'=>'1','return'=>'list',));}?>
        <?php } ?>
        <?php if($list) { ?>
        <a class="item" <?php if($list==1) { ?><?php echo $row['m_typeid'];?><?php } ?>
 href="<?php echo $row['url'];?>">
            <span class="icon"><img src="<?php echo $row['ico'];?>"/></span>
            <span class="name"><?php echo $row['title'];?></span>
        </a>
        <?php } ?>
        <?php $n++;}unset($n); } ?>
        
    </div>
    <!--目的地导航-->
    <div class="layer-dest-container" id="layerDestContainer">
        <div class="layer-dest-wrap">
            <h3 class="bar-tit"><?php echo $destinfo['kindname'];?></h3>
            <div class="dest-content clearfix">
                <?php echo $destinfo['jieshao'];?>
            </div>
        </div>
        <a class="layer-close-btn" href="javascript:;"></a>
    </div>
    <?php echo Request::factory("pub/footer")->execute()->body(); ?>
    <?php echo Request::factory("pub/code")->execute()->body(); ?>
    <script>
        $(function(){
            //目的地详情
            $("#more-dest-info").on("click",function(){
                $("#layerDestContainer").show();
            });
            $(".layer-close-btn").on("click",function(){
                $("#layerDestContainer").hide();
            })
        })
    </script>
</body>
</html>
