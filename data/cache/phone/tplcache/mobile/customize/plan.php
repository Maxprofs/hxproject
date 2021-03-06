<!DOCTYPE html>
<html>
<head ul_float=Xcyt-j >
<meta charset="UTF-8">
<title><?php echo $info['title'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php echo Common::css('base.css,swiper.min.css');?>
        <?php echo Common::css_plugin('customize.css','customize');?>
        <?php echo Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,layer/layer.m.js,common.js,delayLoading.min.js');?>
</head>
<body>
    <?php echo Request::factory("pub/header_new/typeid/$typeid/isshowpage/1")->execute()->body(); ?>
    <div class="page-content">
    <div class="banner">
    <div class="img"><img src="<?php echo $info['litpic'];?>" alt="<?php echo $info['title'];?>"  /></div>
    <div class="info clearfix">
    <p class="fl"><?php if(!empty($info['startplace'])) { ?><?php echo $info['startplace'];?>出发|<?php } ?>
行程<?php echo $info['days'];?>天</p>
    <p class="fr"><?php if(!empty($info['starttime'])) { ?><?php echo date('Y-m-d',$info['starttime']);?>出发 |<?php } ?>
浏览<?php echo $info['shownum'];?></p>
    </div>
    </div> 
    <div class="text-box">
    <?php echo $info['title'];?>
    </div>
    
    <div class="des-box">
    <p class="clearfix">
    <label>目的地：</label>
    <span><?php echo $info['dest'];?></span>
    </p>
    <p class="clearfix">
    <label>成人数：</label>
    <span><?php echo $info['adultnum'];?>人</span>
    </p>
    <p class="clearfix">
    <label>儿童数：</label>
    <span><?php echo $info['childnum'];?>人</span>
    </p>
    </div>
    
    <div class="content-box">
    <h3>出游方案</h3>
    <div class="content">
      <?php echo Product::strip_style($info['content']);?>
    </div>
    </div>
    
    </div>
    
    <a class="dz-btn" href="<?php echo $cmsurl;?>customize">我要定制</a>
    <script type="text/javascript">
    $(function(){
    $("html,body").css("height", "100%");
    });
    </script>
    <?php echo Request::factory("pub/code")->execute()->body(); ?>
</body>
</html>
