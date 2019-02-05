<?php defined('SYSPATH') or die();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title>
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
    <?php } ?>
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>" />
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css');?>
    <?php echo Common::css_plugin('note.css','notes');?>
    <?php echo Common::js('lib-flexible.js,jquery.min.js,template.js,delayLoading.min.js');?>
    <?php echo Common::js('layer/layer.m.js');?>
</head>
<body>
   <?php echo Request::factory("pub/header_new/typeid/$typeid")->execute()->body(); ?>
    <div class="st-search">
        <div class="st-search-box">
            <form method="get" action="" margin_background=2Ya1fl >
                <input type="text" class="st-search-text" name="keyword" placeholder="搜索游记" value="<?php echo $keyword;?>">
                <input type="submit" class="st-search-btn" value="">
            </form>
        </div>
    </div>
    <!--搜索-->
    <div class="order-topfix-menu">
        <a class="item <?php if(empty($sorttype)) { ?>on<?php } ?>
" href="<?php echo $cmsurl;?>notes/">热门游记</a>
        <a class="item <?php if($sorttype==1) { ?>on<?php } ?>
" href="<?php echo $cmsurl;?>notes/all-1">最新游记</a>
    </div>
    <?php if(!empty($list)) { ?>
<div class="travel-diary-content-h">
<ul class="travel-diary-list" id="list_container">
            <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?>
 <li class="item">
<a class="pic" href="<?php echo $row['url'];?>"><img src="<?php echo $row['litpic'];?>" align="<?php echo $row['title'];?>" /></a>
<a class="tit" href="<?php echo $row['url'];?>"><?php echo $row['title'];?></a>
<div class="info">
                    <span class="label">作者:<?php echo $row['memberinfo']['nickname'];?></span>
                    <span class="label"><?php echo Common::mydate('Y/m/d',$row['modtime']);?></span>
                    <span class="label num"><i class="icon"></i><?php echo $row['shownum'];?></span>
                </div>
 </li>
            <?php $n++;}unset($n); } ?>
</ul>
        <div class="list_more"><a class="more-link" href="javascript:;" id="btn_more">查看更多</a></div>
</div>
    <?php } ?>
    
    <div class="no-content-page" id="no-content" <?php if(!empty($list)) { ?>style="display: none"<?php } ?>
>
        <div class="no-content-icon"></div>
        <p class="no-content-txt">此页面暂无内容</p>
    </div>
    <!--没有相关信息-->
   <?php echo Request::factory('pub/code')->execute()->body(); ?>
   <?php echo Request::factory("pub/footer")->execute()->body(); ?>
    <script>
        var destid="<?php echo $destid;?>";
        var sorttype="<?php echo $sorttype;?>";
        var keyword="<?php echo $keyword;?>";
        var current_page=1;
        var pagesize="<?php echo $pagesize;?>";
        $(function(){
            //bind event
            $("#btn_more").click(function(){
               get_data();
            });
            if($("#list_container li").length<pagesize)
            {
              $(".list_more").hide();
            };
            //固定选项
            var offsetTop = $(".order-topfix-menu").offset().top;
            $(window).scroll(function(){
                if( $(this).scrollTop() > offsetTop ){
                    $(".order-topfix-menu").addClass("fixed")
                }
                else{
                    $(".order-topfix-menu").removeClass("fixed")
                }
            });
        });
        function get_data()
        {
            layer.open({
                type: 2,
                content: '正在加载数据...',
                time :20
            });
            var url=SITEURL+'notes/ajax_get_more';
            var nextpage=current_page+1;
            var data={'page':nextpage,'destid':destid,'sorttype':sorttype,'keyword':keyword,'pagesize':pagesize};
            $.ajax({
                type: 'POST',
                url: url ,
                data: data ,
                dataType: 'json',
                success:function(result){
                    if(!result){
                        layer.closeAll();
                        $('.travel-diary-content-h').hide();
                        $("#no-content").show();
                        return;
                    }
                     var html='';
                     for(var i in result['list'])
                     {
                         var row=result['list'][i];
                         html+='<li class="item"><a class="pic" href="'+row['url']+'"><img src="'+row['litpic']+'" align="'+row['title']+'" /></a>'+
                               '<a class="tit" href="'+row['url']+'">'+row['title']+'</a>'+
                              '<div class="info"><span class="label">作者:'+row['memberinfo']['nickname']+'</span>'+
                              '<span class="label">'+row['modtime']+'</span><span class="label num"><i class="icon"></i>'+row['shownum']+
                              '</span></div></li>';
                     }
                     $("#list_container").append(html);
                    if(result['page']==-1)
                    {
                       $(".list_more").hide();
                    }
                    else {
                        current_page = result['page'];
                    }
                    layer.closeAll();
                }
            });
        }
    </script>
</body>
</html>
