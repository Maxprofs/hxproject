<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $info['kindname'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,help.css');?>
    <?php echo Common::js('lib-flexible.js,jquery.min.js,template.js');?>
</head>
<body>
<?php echo Request::factory("pub/header_new/typeid/0/isshowpage/1/definetitle/".urlencode($channel))->execute()->body(); ?>
    <?php require_once ("E:/wamp64/www/phone/taglib/help.php");$help_tag = new Taglib_Help();if (method_exists($help_tag, 'kind')) {$kinds = $help_tag->kind(array('action'=>'kind','row'=>'30','return'=>'kinds',));}?>
    <?php $n=1; if(is_array($kinds)) { foreach($kinds as $kind) { ?>
    <div class="st-help-block">
        <h3><?php echo $kind['title'];?></h3>
        <ul>
            <?php require_once ("E:/wamp64/www/phone/taglib/help.php");$help_tag = new Taglib_Help();if (method_exists($help_tag, 'article')) {$list = $help_tag->article(array('action'=>'article','row'=>'3','kindid'=>$kind['id'],'return'=>'list',));}?>
            <?php $n=1; if(is_array($list)) { foreach($list as $r) { ?>
               <li><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a><i class="ico"></i></li>
            <?php $n++;}unset($n); } ?>
            
        </ul>
        <?php if($kind['number']>3) { ?>
        <a class="more-link" href="<?php echo $kind['url'];?>">查看更多</a>
        <?php } ?>
    </div>
    <?php $n++;}unset($n); } ?>
    
    <!-- 帮助分类 -->
            
<?php echo Request::factory("pub/footer")->execute()->body(); ?>
</body>
</html>
