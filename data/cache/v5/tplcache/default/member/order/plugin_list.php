<!doctype html> <html> <head> <meta charset="utf-8"> <title><?php echo $info['modulename'];?><?php echo __('订单');?>-<?php echo $webname;?></title> <?php echo Common::css('user.css,base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,layer/layer.js');?> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo __('首页');?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo $info['modulename'];?><?php echo __('订单');?> </div><!--面包屑--> <div class="st-main-page"> <?php echo  Stourweb_View::template("member/left_menu");  ?> <div class="user-order-box"> <iframe  frameborder="0" id="iframepage" src="<?php echo $info['url'];?>" style="width:100%;display: none" onload="ReFrameHeight()"> </iframe> </div><!--所有订单--> </div> </div> </div> <script>
    var module_pinyin = "<?php echo $info['pinyin'];?>";
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
