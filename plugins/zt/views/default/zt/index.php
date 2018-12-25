<!doctype html>
<html>
	<head table_head=awBCXC >
		<meta charset="utf-8">
		<title>{$seo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
        {if $seo['keyword']}
        <meta name="keywords" content="{$seo['keyword']}"/>
        {/if}
        {if $seo['description']}
        <meta name="description" content="{$seo['description']}"/>
        {/if}
        {include "pub/varname"}
        {Common::css('base.css')}
        {Common::css_plugin('zhuanti-list.css','zt')}
        {Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js,SuperSlide.min.js')}
		<script>
			$(function() {

				var offsetLeft = new Array();
				var windowWidth = $(window).width();

				function get_width() {

					//设置"down-nav"宽度为浏览器宽度
					$(".down-nav").width($(window).width());

					$(".st-menu li").hover(function() {

						var liWidth = $(this).width() / 2;

						$(this).addClass("this-hover");
						offsetLeft = $(this).offset().left;
						//获取当前选中li下的sub-list宽度
						var sub_list_width = $(this).children(".down-nav").children(".sub-list").width();
						$(this).children(".down-nav").children(".sub-list").css("width", sub_list_width);

						$(this).children(".down-nav").css("left", -offsetLeft);
						$(this).children(".down-nav").children(".sub-list").css("left", offsetLeft - sub_list_width / 2 + liWidth);

						var offsetRight = windowWidth - offsetLeft;

						var side_width = (windowWidth - 1200) / 2;

						if(sub_list_width > offsetRight) {
							$(this).children(".down-nav").children(".sub-list").css({
								"left": offsetLeft - sub_list_width / 2 + liWidth,
								"right": side_width,
								"width": "auto"
							});
						}

						if(side_width > offsetLeft - sub_list_width / 2 + liWidth) {
							$(this).children(".down-nav").children(".sub-list").css({
								"left": side_width,
								"right": side_width,
								"width": "auto"
							});
						}

					}, function() {

						$(this).removeClass("this-hover");

					});

				};

				get_width();

				$(window).resize(function() {
					get_width();
				});

				//首页焦点图
				$('.st-focus-banners').slide({
					mainCell: ".banners ul",
					titCell: ".focus li",
					effect: "fold",
					interTime: 5000,
					delayTime: 1000,
					autoPlay: true
				});
				
				//城市站点
				$(".head_start_city").hover(function(){
					$(this).addClass("change_tab");
				},function(){
					$(this).removeClass("change_tab");
				});

			})
		</script>
	</head>

	<body>

    {request "pub/header"}

		<div class="big">
			<div class="wm-1200">
				<div class="st-guide">
                    <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{$channelname}
				</div>
				<!-- 面包屑 -->

				<div class="st-zt-list">

					<div class="zt-sort-block">
						<a class="item {if empty($sorttype)}on{/if}" href="/zt/">综合排序</a>
						<a class="item {if !empty($sorttype)}on{/if}" href="/zt/?sorttype={if $sorttype==1}2{else}1{/if}">时间{if empty($sorttype)}<i class="default-ico"></i>{elseif $sorttype==1}<i class="down-ico"></i>{else}<i class="up-ico"></i>{/if}</a>
						<span class="info">共计<em>{$total}</em>个专题</span>
					</div>
					<!-- 排序 -->

					<div class="zt-list-con">
						<ul class="clearfix">
                            {loop $list $row}
							<li class="{if $n%4==0}mr_0{/if}">
								<a href="{$row['url']}" class="pic"><img src="{Common::img($row['pc_banner'],271,134)}" alt="{$row['title']}" /></a>
								<div class="info">
									<a href="javascript:;" class="tit">{$row['title']}</a>
									<p class="time">发布时间：{date('Y-m-d',$row['addtime'])}</p>
								</div>
							</li>
                            {/loop}
						</ul>
					</div>

				</div>
				<!-- 砖头列表 -->

				<div class="main_mod_page clear">
					{$pageinfo}
				</div>
				<!-- 翻页 -->


			</div>
		</div>

    {request "pub/footer"}
		<script>
			$(function() {
				//动态获取改变窗口高度
				function getConsize() {
					$('.st-sidemenu-box').height($(window).height());
				}
				$(window).resize(function() {
					getConsize()
				});
				getConsize();
			})
		</script>

	</body>

</html>