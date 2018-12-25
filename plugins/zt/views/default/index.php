<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>{if $info['seotitle']}{$info['seotitle']}{else}{$info['title']}{/if}-{$GLOBALS['cfg_webname']}</title>
	{if $info['keyword']}
	<meta name="keywords" content="{$info['keyword']}" />
	{/if}
	{if $info['description']}
	<meta name="description" content="{$info['description']}" />
	{/if}
	{include "pub/varname"}
    {Common::css('base.css')}
	{Common::css_plugin('pc_theme.css,pc_header.css','zt')}
    {Common::js('jquery.min.js,base.js,SuperSlide.min.js,jquery.validate.js,jquery.validate.addcheck.js,delayLoading.min.js')}

</head>
<body>
	{include "ztheader"}
    <div class="theme-container"{if $info['bgimage']} style="background:url('{$info['bgimage']}') center repeat" {elseif $info['bgcolor']}style="background:{$info['bgcolor']}"{/if}>

        <div class="theme-top-wrap" {if $info['pc_banner']}style="background:url('{$info['pc_banner']}') center no-repeat"{/if}></div>
        <!-- 顶部背景 -->
        <div class="wm-1200">

            <div class="theme-sale-wrap" >
                <h3 class="theme-sale-tit"><strong class="bt">{$info['title']}</strong></h3>
                <div class="theme-sale-block">
                    <div class="theme-hd"></div>
                    <div class="theme-md">
	                    {$info['introduce']}
                    </div>
                    <div class="theme-bd"></div>
                </div>
            </div>
            <!-- 特惠专享 -->
            {loop $channellist $channel}
                {if $channel['kindtype']==1}
		            <div class="theme-item-box">
			            <div class="theme-item-tit">
				            <h3 class="bt">{$channel['title']}</h3>
				            <div class="txt">
					            {$channel['introduce']}
				            </div>
			            </div>
			            <div class="theme-coupon-item" id="theme-coupon-item">
				            <a class="prev" href="javascript:;"></a>
				            <a class="next" href="javascript:;"></a>
				            <div class="bd">
					            <ul class="clearfix">
						            {loop $channel['productlist'] $coupon}
						            <li>
							            {if $coupon['status']==2}<i class="over-icon"></i>{/if}
							            <span class="type"><em>{$coupon['amount']}</em>{$coupon['name']}</span>
							            <span class="txt">
                                            (满{$coupon['samount']}可用{if $coupon['typeid']==0},无品类限制{else},仅限{$coupon['typename']}部分产品{/if})
                                        </span>
							            <a href="javascript:;" class="get get_coupon" data-couponid="{$coupon['id']}">立即领取&gt;&gt;</a>
						            </li>
						            {/loop}

					            </ul>
                                {Common::js('layer/layer.js',0)}
                                <script>
                                    $(function(){
                                        $('.get_coupon').click(function(){
                                            var couponid = $(this).attr('data-couponid');
                                            $.ajax({
                                                type: 'POST',
                                                url: SITEURL + 'coupon/ajxa_get_coupon',
                                                data: {cid:couponid},
                                                async: false,
                                                dataType: 'json',
                                                success: function (data) {
                                                    if(data.status==0)
                                                    {
                                                        layer.msg(data.msg, {icon: 5});
                                                    }
                                                    if(data.status==1)
                                                    {
                                                        //show login box
                                                        $('#is_login_order').removeClass('hide');

                                                    }
                                                    if(data.status==2)
                                                    {
                                                        layer.msg(data.msg, {icon: 6,time: 1000},function(){
                                                            window.location.reload();
                                                        });
                                                    }
                                                }
                                            })
                                        })
                                    })
                                </script>
				            </div>
			            </div>
		            </div>
		            <!-- 优惠券 -->

                {/if}
                {if $channel['kindtype']==2}
				            <div class="theme-item-box">
					            <div class="theme-item-tit">
						            <h3 class="bt">{$channel['title']}</h3>
						            <div class="txt">
							            {$channel['introduce']}
						            </div>
					            </div>
					            <div class="theme-product-item">
						            <ul class="clearfix">
							            {php $index=1;}
							            {loop $channel['productlist'] $p}
							            <li {if $index%3==0}class="mr_0"{/if}>
								            <div class="hd">
									            <a class="pic" href="{$p['url']}" target="_blank"><img src="{Product::get_lazy_img()}" st-src="{Common::img($p['litpic'],380,258)}" alt="{$p['title']}" width="380" height="258" /></a>
				                                <span class="bt">
				                                    <a href="{$p['url']}" target="_blank">{$p['title']}</a>
				                                </span>
								            </div>
								            <div class="info">
									            <span class="jg">{if !empty($p['price'])}{Currency_Tool::symbol()}<em>{$p['price']}</em>起{else}电询{/if}</span>
									            <a class="buy-link" href="{$p['url']}" target="_blank">立即购买</a>
								            </div>
							            </li>
							            {php $index++;}
							            {/loop}

						            </ul>
						            {if $channel['moreurl']}
						                <a href="{$channel['moreurl']}" target="_blank" class="more-link">查看更多&gt;&gt;</a>
						            {/if}
					            </div>
				            </div>

                {/if}
	            {if $channel['kindtype']==3}
	                     <div class="theme-item-box">
					        <div class="theme-item-tit">
						        <h3 class="bt">{$channel['title']}</h3>
						        <div class="txt">
							        {$channel['introduce']}
						        </div>
					        </div>
					        <div class="theme-product-item">
						        <ul class="clearfix">
							        {php $j=1;}
							        {loop $channel['productlist'] $p}
							        <li {if $j%3==0}class="mr_0"{/if}>
								        <div class="hd">
									        <a class="pic" href="{$p['url']}" target="_blank"><img src="{Product::get_lazy_img()}" st-src="{Common::img($p['litpic'],380,250)}" alt="{$p['title']}" width="380" height="258" /></a>
								        </div>
								        <div class="info">
									        <a class="bt" href="{$p['url']}" target="_blank">{$p['title']}</a>
								        </div>
							        </li>
							        {php $j++;}
							        {/loop}
						        </ul>
						        {if $channel['moreurl']}
						            <a href="{$channel['moreurl']}" class="more-link">查看更多&gt;&gt;</a>
						        {/if}
					        </div>
	                </div>

	            {/if}

            {/loop}

        </div>

    </div>

{request "pub/footer"}



    <script>
        $(function(){
            $("#theme-coupon-item").slide({
                mainCell:".bd ul",
                effect:"left",
                delayTime: 500,
                vis:4,
                scroll:4,
                autoPage: true,
                autoPlay: false


            })
        })
    </script>
    {if empty($userinfo['mid'])}
    {Common::js('jquery.md5.js')}
    {include "member/login_fast"}

    {/if}

</body>
</html>
