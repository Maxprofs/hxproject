{Common::css('header2.css')}
{Common::css('base2.css')}
{Common::js('delayLoading.min.js')}
{Common::js('common.js')}
{Common::js('login.js')}
{if St_Functions::is_normal_app_install('mobiledistribution')}
    {Model_Fenxiao::save_fxcode()}
{/if}
{if !empty($channelname)}
	<div class="header_top">
		<a class="back-link-icon" {$backurl}  data-ajax="false"></a>
		<h1 class="page-title-bar">{$channelname}</h1>
		<div class="st-top-menu">
			{if !$isindex}
			<span class="st-user-menu"></span>
			<div class="header-menu-bg"></div>
			<div class="st-down-bar">
				<ul>
					<li><a href="{$cmsurl}" data-ajax="false"><i class="icon home-ico"></i>首页</a></li>
					<li><a href="{$cmsurl}search" data-ajax="false"><i class="icon search-ico"></i>搜索</a></li>
					<li><a href="{$cmsurl}member" data-ajax="false"><i class="icon center-ico"></i>个人中心</a></li>
				</ul>
			</div>
			{else}
			<a class="st-user-center" href="{$cmsurl}member"></a>
			{/if}
		</div>
	</div>
{else}
	<div class="header-bar">
		{if !St_Functions::is_normal_app_install('city_site')}
		
		{else}
		{request "city/header"}
		{/if}
		<div class="header-search-bar">
			<input type="text" id="myinput" class="search-text" placeholder="目的地/酒店/景点/关键词" />
			<input type="button" class="search-btn" />
		</div>

		<a class="header-ucenter-link" href="{$cmsurl}member"></a>
	</div>
{/if}
<!-- 头部 -->

<script type="text/javascript">
	var SITEURL = "{$cmsurl}";
    //过滤非法字符
    function StripScript(s){
        var pattern = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）――|{}【】‘；：”“'。，、？]");
        var rs = "";
        for (var i = 0; i < s.length; i++) {
            rs = rs+s.substr(i, 1).replace(pattern, '');
        }
        return rs;
    }
	//全局搜索s
	$('.search-btn').click(function () {
		var keyword = StripScript($.trim($("#myinput").val()));
		if (keyword == '') {
			keyword = $('#myinput').attr('placeholder');
			if(keyword == '')
			{
				layer.open({
					content: '{__("error_keyword_not_empty")}',
					btn: ['{__("OK")}']
				});
				return false;
			}
		}
		url = SITEURL +'search?keyword='+encodeURIComponent(keyword);

		window.location.href = url;
	});
	$(function(){
        //头部下拉导航
        $(".st-user-menu").on("click",function(){
            $(".header-menu-bg,.st-down-bar").show();
            $("html,body").css({overflow:"hidden"})
        });
        $(".header-menu-bg").on("click",function(){
            $(".header-menu-bg,.st-down-bar").hide();
            $("html,body").css({overflow:"auto"})
        });
        //登陆检测
        ST.Login.check_login();
        //$('body').append('<script'+' type="text/javascript" src="'+SITEURL+'member/login/ajax_islogin"></'+'script>');
    });

	function is_login($obj){
		var fx_url="content={urlencode($info['title'])}";
		if($obj['islogin']==1){
			if($obj['info']['fx_member']){
				if(window.location.href.indexOf('/show_')!=-1)
				{
					var btn = $($obj['info']['fx_btn'].replace('[fx_url]', fx_url));
                    $('.bom_fixed a').eq(0).after(btn);
					btn.attr('data-ajax',false);
					btn.addClass('now-sell');
				}
			}
		}
	}
</script>
{include 'pub/share'}
