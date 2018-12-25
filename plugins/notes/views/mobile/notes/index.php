<?php defined('SYSPATH') or die();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('base.css')}
    {Common::css_plugin('note.css','notes')}
    {Common::js('lib-flexible.js,jquery.min.js,template.js,delayLoading.min.js')}
    {Common::js('layer/layer.m.js')}
</head>
<body>

   {request "pub/header_new/typeid/$typeid"}

    <div class="st-search">
        <div class="st-search-box">
            <form method="get" action="" margin_background=2Ya1fl >
                <input type="text" class="st-search-text" name="keyword" placeholder="搜索游记" value="{$keyword}">
                <input type="submit" class="st-search-btn" value="">
            </form>
        </div>
    </div>
    <!--搜索-->

    <div class="order-topfix-menu">
        <a class="item {if empty($sorttype)}on{/if}" href="{$cmsurl}notes/">热门游记</a>
        <a class="item {if $sorttype==1}on{/if}" href="{$cmsurl}notes/all-1">最新游记</a>
    </div>

    {if !empty($list)}
	<div class="travel-diary-content-h">
		<ul class="travel-diary-list" id="list_container">
            {loop $list $row}
			 <li class="item">
				<a class="pic" href="{$row['url']}"><img src="{$row['litpic']}" align="{$row['title']}" /></a>
				<a class="tit" href="{$row['url']}">{$row['title']}</a>
				<div class="info">
                    <span class="label">作者:{$row['memberinfo']['nickname']}</span>
                    <span class="label">{Common::mydate('Y/m/d',$row['modtime'])}</span>
                    <span class="label num"><i class="icon"></i>{$row['shownum']}</span>
                </div>
			 </li>
            {/loop}
		</ul>
        <div class="list_more"><a class="more-link" href="javascript:;" id="btn_more">查看更多</a></div>
	</div>
    {/if}
    
    <div class="no-content-page" id="no-content" {if !empty($list)}style="display: none"{/if}>
        <div class="no-content-icon"></div>
        <p class="no-content-txt">此页面暂无内容</p>
    </div>
    <!--没有相关信息-->

   {request 'pub/code'}
   {request "pub/footer"}
    <script>
        var destid="{$destid}";
        var sorttype="{$sorttype}";
        var keyword="{$keyword}";
        var current_page=1;
        var pagesize="{$pagesize}";
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
