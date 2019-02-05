<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $info['title'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,help.css');?>
    <?php echo Common::js('lib-flexible.js,jquery.min.js,template.js,delayLoading.min.js');?>
</head>
<body>
<?php echo Request::factory("pub/header_new/typeid/0/isshowpage/1/definetitle/".urlencode('帮助详情'))->execute()->body(); ?>
    <div class="st-help-block">
        <h3><?php echo $info['title'];?></h3>
        <div class="st-help-show">
           <?php echo Product::strip_style($info['body']);?>
        </div>
    </div>
    <!-- 帮助详情 -->
<?php echo Request::factory("pub/footer")->execute()->body(); ?>
</body>
</html>
