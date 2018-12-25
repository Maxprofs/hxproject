<!DOCTYPE html>
<html lang="en">
<head padding_strong=SvRzDt >
    <meta charset="UTF-8">
    <title>{$info['name']}-{$GLOBALS['cfg_webname']}</title>
    {include "pub/varname"}
    {Common::css('header-club.css,club.css,base.css,extend.css',false)}
    {Common::css_plugin('jf.mall.css','integral')}
    {Common::js("jquery.min.js,base.js,common.js,SuperSlide.min.js")}
</head>
<body>
{request "member/club/header"}

<div class="main-container bg-grey-f7">
    <div class="wm-1200">

        <div class="st-guide">
            <a href="/" title="首页" target="_blank">首页</a>
            &nbsp;&gt;&nbsp;
            <a href="/integral/" title="积分商城" target="_blank">积分商城</a>
            &nbsp;&gt;&nbsp;
            <strong title="{$info['name']}">{$info['name']}</strong>
        </div>
        <!-- 面包屑 -->

        <div class="mall-show-container clearfix">
            <div class="slide-content">
                <ul class="bigImg">
                    <li><a><img width="406" height="276" src="{Common::img($info['litpic'],406,276)}" /></a></li>
                </ul>
                <div class="smallScroll clearfix">
                    <a class="sPrev prevStop" href="javascript:void(0)"></a>

                    <div class="smallImg">
                        <ul>
                            <li><a><img src="{Common::img($info['litpic'],122,82)}" /></a></li>

                        </ul>
                    </div>
                    <a class="sNext" href="javascript:void(0)"></a>
                </div>
            </div>
            <!-- 活动轮播图 -->
            <div class="mid-info-wrap" id="info">
                <h1 class="tit">{$info['name']}</h1>

                <div class="num">编号：{$info['code']}</div>
                <div class="pri">
                    <span class="jf">价格<strong><em>{$info['needjifen']}</em>积分</strong></span>
                </div>
                <div class="sum">
                    <span class="sl">数量</span>
                        <span class="amount-opt-wrap">
                            <a href="javascript:;" class="sub-btn">–</a>
                            <input type="text" disabled="disabled" class="num-text" id="book_name" maxlength="4"
                                   value="1"/>
                            <a href="javascript:;" class="add-btn">+</a>
                        </span>
                    <span class="kc">库存{$info['leftnum']}件</span>
                </div>
                {if $info['leftnum']>0}
                <a class="exchange-btn cursor" id="exchange"  >立即兑换</a>
                {else}
                <a class="exchange-btn cursor"  style="background-color: #ccc;">立即兑换</a>
                {/if}

            </div>
            <!-- 兑换信息 -->
            <div class="side-jf-info">
                {if $member}
                <img class="hd-img" src="{$member['litpic']}">
                <span class="name">Hi，<strong>{$member['nickname']}</strong></span>
                <span class="sum">您当前可用积分为：<em>{$member['jifen']}</em></span>
                <!--<span class="date">预计2016年10月12日到期</span>-->
                {else}
                <img class="hd-img" src="{$cmsurl}res/images/user-headimg.png" />
                <div class="login-member-bar">
                    <a class="login-btn" href="{Common::get_main_host()}/member/login/?redirecturl={urlencode($_SERVER['REQUEST_URI'])}">立即登录</a>
                    <div class="login-txt">登录后可查看您的会员等级和积分</div>
                </div>
                {/if}
            </div>
            <!-- 我的积分 -->
        </div>

        <div class="show-main-container clearfix">
            <div class="show-main-wrap">
                <div class="show-tit-bar"><strong class="bt">商品详情</strong></div>
                <div class="show-edit-box clearfix">
                    订单满减：
                    {if $info['type']==0}
                    <em>订单满{$info['samount']}立减{$info['amount']}元</em>
                    {else}
                    <em>订单满{$info['samount']}享{$info['amount']}折</em>
                    {/if}
                    <br>
                    <br>
                    有效期：
                    {if $info['isnever']==0}
                    永久有效
                    {else}
                    {$info['starttime']}至{$info['endtime']}有效
                    {/if}
                    <br>
                    <br>
                    {if $info['gradename_all']}
                    限{$info['gradename_all']}可领取
                    {/if}
                    <br>
                    <br>
                    使用限制:
                    {if $info['typename']}
                    {$info['typename']}
                    {if $info['typeid']==1}
                    等产品可用
                    {else}
                    等部分产品可用
                    {/if}
                    {else}
                    无产品限制
                    {/if}
                </div>
            </div>
            <div class="side-other-wrap">
                <h3>其他兑换商品</h3>
                <ul>
                    {st:integral action="hotProduct" row="3" orderby="display" return=hotProduct}
                    {loop $hotProduct $k $v}
                    <li {if $k==2}class="last"{/if}>
                        <a class="pic" href="{$v['url']}" target="_blank"><img src="{Common::img($v['litpic'],220,150)}"
                                                                               alt="{$v['title']}"/></a>
                        <a class="bt" href="{$v['url']}" target="_blank">{$v['title']}</a>

                        <p class="pri clearfix">
                            <span class="jf">{$v['need_jifen']}积分</span>
                            <span class="jg">市场价:{Currency_Tool::symbol()}{$v['sellprice']}</span>
                        </p>
                    </li>
                    {/loop}
                    {/st}
                </ul>
            </div>
        </div>

    </div>
</div>
<div class="hint-change hide" id="hintChange">
    <i class="icon"></i>
    <div class="hint-wrap">
        <p class="tf">您正在使用<span class="jf"></span>兑换</p>
        <p class="ts"></p>
        <p class="tt"></p>
    </div>
</div>

<input type="hidden" id="leftnum" value="{$info['leftnum']}">
<input type="hidden" id="jifen" value="{$member['jifen']}">
<input type="hidden" id="nendjifen" value="{$info['nendjifen']}">
<!-- 页面主体 -->
<!-- footer -->
{request "pub/footer"}
<!-- footer end -->
{Common::js('layer/layer.js',0)}
<script>
    $(function () {
        //轮播图
        $(".slide-content").slide({
            titCell: ".smallImg li",
            mainCell: ".bigImg",
            effect: "fold",
            autoPlay: true,
            interTime: 5000,
            delayTime: 500,
        });
        $(".slide-content .smallScroll").slide({
            mainCell: "ul",
            interTime: 5000,
            delayTime: 500,
            vis: 4,
            scroll: 4,
            effect: "left",
            autoPage: true,
            prevCell: ".sPrev",
            nextCell: ".sNext",
            pnLoop: false
        });
        $('#exchange').click(function(){
            var couponid = '{$info['id']}';
            var title ='{$info['name']}';
            var jifen ='{$info['needjifen']}';
            var endtime = '{$info['endtime']}';
            var isnever = '{$info['isnever']}';
            var maxnumber = '{$info['maxnumber']}';
            if(isnever==0)
            {
                endtime = '永久有效';
            }
            else
            {
                endtime ='有效期至：'+endtime;
            }
            if(!maxnumber)
            {
                maxnumber = '&nbsp;&nbsp;&nbsp;'
            }
            else
            {
                maxnumber = '&nbsp;&nbsp;&nbsp;每个会员限领'+maxnumber+'张'
            }
            $('#hintChange .jf').text(jifen+'积分');
            $('#hintChange .ts').text(title);
            $('#hintChange .tt').html(endtime+maxnumber);
            $("#hintChange").removeClass("hide");
            layer.open({
                type: 1,
                title: '提示兑换',
                area: ['500px'],
                btn: ['确定','取消'],
                btnAlign: 'c',
                content: $('#hintChange'),
                yes:function(){
                    get_coupon(couponid);
                }
                ,btn2: function(){
                    $("#hintChange").addClass("hide");
                    layer.closeAll()
                }
                ,cancel: function(){
                    $("#hintChange").addClass("hide");
                    layer.closeAll()
                }
            });
        })

    });



    function get_coupon(couponid)
    {

        $.ajax({
            type: 'POST',
            url: SITEURL + 'coupon/ajxa_get_coupon_from_integral',
            data: {cid:couponid},
            async: false,
            dataType: 'json',
            success: function (data)
            {
                if(data.status==0)
                {
                    layer.msg(data.msg, {icon: 5,time: 1000});
                }
                if(data.status==1)
                {
                    layer.msg(data.msg, {icon: 5,time: 1000},function(){
                        var url = SITEURL+'member/login?redirecturl={$redirecturl}';
                        window.location.href=url;
                    });
                }
                if(data.status==2)
                {
                    layer.msg(data.msg, {icon: 6,time: 1000},function(){
                        window.location.reload();
                    });
                }
            }
        })


    }
</script>

</body>
</html>