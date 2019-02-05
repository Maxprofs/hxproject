<!doctype html>
<html>
<head ul_margin=rOPzDt >
<meta charset="utf-8">
<title><?php echo $info['servername'];?>-<?php echo $webname;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,help.css');?>
    <?php echo Common::js('lib-flexible.js,jquery.min.js,delayLoading.min.js');?>
</head>
<body>
<?php echo Request::factory("pub/header_new/typeid/0")->execute()->body(); ?>
     
    <div class="st-help-block">
        <h3><?php echo $info['servername'];?></h3>
        <div class="st-help-show">
            <?php echo Product::strip_style($info['content']);?>
        </div>
    </div><!--aboutus-->
  <?php echo Request::factory("pub/code")->execute()->body(); ?>
  <?php echo Request::factory("pub/footer")->execute()->body(); ?>
</body>
</html>
