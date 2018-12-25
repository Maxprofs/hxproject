
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{$seoinfo['seotitle']}-{$webname}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}"/>
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}"/>
    {/if}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('base.css,footer.css,header.css,swiper.min.css')}
    {Common::css_plugin('tickets.css','spot')}
    {Common::js('lib-flexible.js,swiper.min.js,zepto.js')}
    {Common::js('jquery.min.js')}
    {Common::js_plugin('tickets.js','spot')}
</head>
<body>

	{request "pub/header_new/default_tpl/header_new2/typeid/$typeid"}

<!-- 头部 -->
<div class="search-area clearfix">
<div class="search-area-bar">
    <input class="search-area-text keyword" type="text" name="" placeholder="搜索旅游景点" />
    <i class="search-btn-icon search"></i>
</div>
<a href="http://{$GLOBALS['main_host']}/plugins/productmap/spot/mapnear"><span class="position"><i class="near-icon"></i><span class="near-txt">周边景点</span></span></a>
</div>
<!-- 搜索 -->
<div class="swiper-container swiper-banner-container">
<ul class="swiper-wrapper">
    {st:ad action="getad" name="s_spot_index_1"}
    {loop $data['aditems'] $v}
        <li class="swiper-slide">
        <a class="item" href="{$v['adlink']}"><img src="{Common::img($v['adsrc'],540,137)}" alt="{$v['adname']}" /></a>
        </li>
    {/loop}
    {/st}
</ul>
<!-- 分页器 -->
<div class="swiper-pagination"></div>
</div>
<!-- banner -->
<div class="product-recommend-module">
<div class="product-recommend-bar">精选人气景点</div>
<div class="swiper-container product-recommend-block">
<ul class="swiper-wrapper">
		{st:spot action="query" flag="order"  row="5"}
		{loop $data $k $row}
			<li class="swiper-slide">
				<a href="{$row['url']}" class="item">
					<div class="pic"><img src="{Common::img($row['litpic'],198,135)}" alt="{$row['title']}"></div>
						<div class="info">
						<div class="tit">{$row['title']}</div>
						{if $row['price']}
								<div class="price">&yen;<span class="num">{$row['price']}</span>起</div>
						{else}
								<div class="price">电询</div>
						{/if}
					</div>
					{if $k < 3}
					<i class="item-rank"><img src="/phone/public/images/rank-0{$k+1}.png" alt="" /></i>
					{/if}
				</a>
			</li>
		{/loop}
		{/st}
</ul>
</div>
</div>
<!-- 精选 -->
<div class="product-container">
<div class="product-title-bar">
<h3>热门景点</h3>
</div>
<div class="product-list-block">
	<ul>
		{st:spot action="query" flag="order" offset="5" row="10"}
			{php} $num = 0 {/php}
			{loop $data $row}
			<li>
			<a class="item" href="{$row['url']}">
			<div class="pro-pic"><span><img src="{Common::img($row['litpic'],115,115)}" alt="{$row['title']}" /></span></div>
			<div class="pro-info">
			<h3 class="tit">{$row['title']}</h3>
			<div class="attr">
				{loop $row['attrlist'] $a}
					<span class="sx">{$a['attrname']}</span>
				{/loop}
			</div>
			<div class="data">
			<span>{$row['commentnum']}条点评</span>
			<span>{$row['satisfyscore']}满意</span>
			</div>
			<div class="addr">{$row['address']}</div>
			</div>
            <div class="pro-price">
                <span class="price"><em>
                    {if $row['price']}
                            &yen;<strong>{$row['price']}</strong>起
                    {else}
                            <strong>电询</strong>
                    {/if}
                </em></span>
            </div>
			</a>
			</li>
			{php} $num ++{/php}
			{/loop}
		{/st}
	</ul>
	{if $num == 10}
		<div class="module-more-bar">
			<a class="module-more-link" href="{$cmsurl}spots/all/">查看更多</a>
		</div>
    {/if}
</div>
</div>
<!-- 产品列表 -->

{request "pub/footer/default_tpl/footer2"}

<a href="javascript:;" class="back-top" id="backTop"></a>


<script type="text/javascript">
//头部下拉导航
	$(".st-user-menu").on("click", function() {
		$(".header-menu-bg,.st-down-bar").show();
		$("body").css("overflow", "hidden")
	});
	$(".header-menu-bg").on("click", function() {
		$(".header-menu-bg,.st-down-bar").hide();
		$("body").css("overflow", "auto");
	});

    $(".header_top a.back-link-icon").attr({'data-ajax':'false','href':'{$cmsurl}'}).removeAttr('onclick').unbind('click');

	$('.search').click(function(){
        var keyword = $('.keyword').val();
        var url = SITEURL + 'spots/all';
        if(keyword!=''){
            url+="?keyword="+encodeURIComponent(keyword);
        }
        window.location.href = url;
    })
</script>
</body>
</html>