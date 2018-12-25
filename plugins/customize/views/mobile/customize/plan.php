<!DOCTYPE html>
<html>
	<head ul_float=Xcyt-j >
		<meta charset="UTF-8">
		<title>{$info['title']}-{$GLOBALS['cfg_webname']}</title>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        {Common::css('base.css,swiper.min.css')}
        {Common::css_plugin('customize.css','customize')}
        {Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,layer/layer.m.js,common.js,delayLoading.min.js')}
	</head>
	<body>
    {request "pub/header_new/typeid/$typeid/isshowpage/1"}
	    <div class="page-content">
	    	<div class="banner">
	    		<div class="img"><img src="{$info['litpic']}" alt="{$info['title']}"  /></div>
	    		<div class="info clearfix">
	    			<p class="fl">{if !empty($info['startplace'])}{$info['startplace']}出发|{/if}行程{$info['days']}天</p>
	    			<p class="fr">{if !empty($info['starttime'])}{date('Y-m-d',$info['starttime'])}出发 |{/if}浏览{$info['shownum']}</p>
	    		</div>
	    	</div> 
	    	<div class="text-box">
	    		{$info['title']}
	    	</div>
	    	
	    	<div class="des-box">
	    		<p class="clearfix">
	    			<label>目的地：</label>
	    			<span>{$info['dest']}</span>
	    		</p>
	    		<p class="clearfix">
	    			<label>成人数：</label>
	    			<span>{$info['adultnum']}人</span>
	    		</p>
	    		<p class="clearfix">
	    			<label>儿童数：</label>
	    			<span>{$info['childnum']}人</span>
	    		</p>
	    	</div>
	    	
	    	<div class="content-box">
	    		<h3>出游方案</h3>
	    		<div class="content">
	    		  {Product::strip_style($info['content'])}
	    		</div>
	    	</div>
	    	
	    </div>
	    
	    <a class="dz-btn" href="{$cmsurl}customize">我要定制</a>
	    <script type="text/javascript">
	    	$(function(){
	    		$("html,body").css("height", "100%");
	    	});
	    </script>
    {request "pub/code"}
	</body>
</html>
