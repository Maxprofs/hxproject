<!doctype html> <html> <head> <meta charset="utf-8"> <title><?php echo __('订单详情');?>-<?php echo $webname;?></title> <?php echo Common::css('user.css,base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js');?> <?php echo Common::js('layer/layer.js',0);?> </head> <body <?php if($moduleinfo['id']==1||$moduleinfo['id']==5) { ?>style="background: #f6f6f6"<?php } ?>
> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big <?php if($moduleinfo['id']==5) { ?>bg-f6f6f6<?php } ?>
"> <div class="wm-1200"> <div class="st-guide"><a href="/"><?php echo __('首页');?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo __('会员中心');?>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo __('订单详情');?> </div> <div class="st-main-page"> <?php echo  Stourweb_View::template("member/left_menu");  ?> <div class="user-order-box"> <iframe frameborder="0" id="iframepage" src="/<?php echo $moduleinfo['path'];?>/member/orderview?ordersn=<?php echo $ordersn;?>" style="width:100%;display: none" onload="ReFrameHeight()"></iframe> </div><!--所有订单--> </div> </div> </div> <script>
    var module_pinyin = "<?php echo $moduleinfo['pinyin'];?>";
    $(function(){
        $(".user-side-menu #nav_"+module_pinyin+"order").addClass('on');
        if(typeof(on_leftmenu_choosed)=='function')
        {
            on_leftmenu_choosed();
        }
    });
    function ReFrameHeight() {
        var ifm= document.getElementById("iframepage");
        var subWeb = document.frames ? document.frames["iframepage"].document : ifm.contentDocument;
       $(subWeb.body).addClass('clearfix')
        if(ifm != null && subWeb != null) {
           $(ifm).show();
            ifm.height = subWeb.body.scrollHeight;
        }
    }
</script> <?php echo Request::factory("pub/footer")->execute()->body(); ?> </body> </html>
