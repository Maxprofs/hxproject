<!doctype html>
<html>
<head padding_top=XIHwOs >
    <meta charset="utf-8">
    <title>404页面未找到-<?php echo $GLOBALS['cfg_webname'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css');?>
    <?php echo Common::js('lib-flexible.js,swiper.min.js,jquery.min.js,template.js');?>
    
</head>
<body>
<?php echo Request::factory("pub/header_new/typeid/$typeid")->execute()->body(); ?>
<section>
    <div class="mid_content">
        <div class="no-content">
            <img src="<?php echo $cmsurl;?>public/images/nofound.png">
            <div class="st_userSelect_cz">
                <a href="<?php echo $cmsurl;?>">返回首页</a>
            </div>
        </div>
    </div>
    </div>
</section>
<?php echo Request::factory("pub/footer")->execute()->body(); ?>
</body>
</html>