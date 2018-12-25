<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>我的红包-{$GLOBALS['cfg_webname']}</title>
    {include "pub/varname"}
    {Common::css_plugin('envelope.css','red_envelope')}
    {Common::css('base.css,user.css')}
    {Common::js('jquery.min.js,base.js,user-center-operate.js,layer/layer.js,common.js')}

</head>

<body>

  {request 'pub/header'}

    <div class="big">
        <div class="wm-1200">
            <div class="st-guide">
                <a href="/">首页</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;会员中心
            </div>
            <!--面包屑-->
            <div class="st-main-page">
                {include "member/left_menu"}
                <!-- 会员中心导航 -->
                <div class="user-coupon-content">
                    <div class="user-coupon-block">
                        <div class="user-coupon-tit clearfix"><strong class="bt">我的红包</strong><a id="redEnvelopeExplain" class="more-link" href="javascript:;">红包说明&gt;</a>
                        </div>
                        <div class="user-coupon-item">
                            <div class="user-re-tab-bar">
                                <span data-type="1" class="item {if $type==1} cur{/if}">未使用({$unuse_number})</span>
                                <span data-type="2" class="item {if $type==2} cur{/if}" >已使用({$use_number})</span>
                            </div>
                        </div>
                        <div class="user-red-envelope-block">
                            <ul class="user-red-envelope-list clearfix">
                                {loop $list $l}
                                <li class="item {if $l['use']}end{/if}">
                                    <div class="total">{Currency_Tool::symbol()}{$l['money']}红包</div>
                                    <div class="date">{$l['module_title']}产品可用</div>
                                    {if $l['use']}
                                    <a href="javascript:;" class="link">立即使用</a>
                                    {else}
                                    <a href="{$cmsurl}" class="link">立即使用</a>
                                    {/if}
                                </li>
                                {/loop}
                            </ul>
                        </div>
                        {if empty($list)}
                        <div class="no-coupon">
                            <i class="icos"></i>
                            <p>您的红包空空如也</p>
                        </div>
                        {/if}
                    </div>
                    <div class="main_mod_page clear">
                        {$pageinfo}
                    </div>
                </div>
                <!-- 优惠券列表 -->

            </div>

        </div>
    </div>




  {request 'pub/footer'}
  {request 'pub/flink'}

    <div class="red-envelope-layer"  style="display: none;" id="redEnvelopeLayer">

            {Common::content_image_width($config,600,0)}

    </div>
    <!-- 红包说明 -->

    <script>
        $(function(){
            //红包说明
            $("#redEnvelopeExplain").on("click",function(){
                layer.open({
                    type: 1,
                    title: "红包说明",
                    area: ['600px', 'auto'],
                    btn: ['确定'],
                    btnAlign: "c",
                    scrollbar: true,
                    content: $('#redEnvelopeLayer')
                })
            });

            $('.user-re-tab-bar .item').click(function () {
                if(!$(this).hasClass('cur'))
                {
                    var type = $(this).data('type');
                    location.href=SITEURL+'member/envelope-'+type
                }

            });


            $("#nav_envelope").addClass('on');
            if(typeof(on_leftmenu_choosed)=='function')
            {
                on_leftmenu_choosed();
            }
        })

    </script>

</body>
</html>
