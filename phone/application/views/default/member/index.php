<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>会员中心</title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('style-new.css,mobilebone.css,swiper.min.css,certification.css,invoice.css')}
    {Common::js('lib-flexible.js')}
    {Common::css_plugin('note.css','notes')}
    {Common::js('jquery.min.js,template.js,mobilebone.js,Zepto.js')}
    {Common::js('common.js')}
    {Common::js('eleditor/Eleditor.js')}
    {Common::js('login.js')}
</head>
<body>
    <div id="pageHome" class="page out">
        <div class="header_top bar-nav">
            <a class="back-link-icon back-center" href="javascript:;"></a>
            <h1 class="page-title-bar">我的会员中心</h1>
            {if !empty($member)}
            <a class="header-message-tip {if $has_msg}new-msg{/if}" href="#sysMessage"></a>
            {/if}
        </div>
        <!-- 公用顶部 -->

        <div class="page-content">

            <div class="user-info-content">
                <div class="user-login-block">
                    <div class="user-login-status">
                        {if !empty($member)}
                        <a href="#myAccount" class="u-l-head"><img src="{$member['litpic']}" alt=""></a>
                        <div class="u-l-info">
                            <!--<a class="u-l-btn" href="">登录/注册</a>-->
                            <a class="u-l-name" href="#myAccount">
                                <span class="txt">{$member['nickname']}</span>
                                <span class="lv">{$member['rank']}</span>
                            </a>
                            <a class="u-l-club" href="{$cmsurl}member/club" data-ajax="false">会员俱乐部</a>
                        </div>
                        <a class="u-info-more" href="#myAccount" data-reload="true"></a>
                        {else}
                        <a href="javascript:;" class="u-l-head"><img src="{Model_Member::member_nopic()}" alt="默认头像"></a>
                        <div class="u-l-info">
                            <span class="u-l-name">
                                <span class="txt">
                                    <a href="{$cmsurl}member/login?redirecturl={urlencode($cmsurl.'member')}" data-ajax="false">登录</a>/<a href="{$cmsurl}member/register" data-ajax="false">注册</a>
                                </span>
                            </span>
                            <a class="u-l-club" href="{$cmsurl}member/club" data-ajax="false">会员俱乐部</a>
                        </div>
                        {/if}
                    </div>
                </div>
                <div class="user-shortcut-menu">
                    <div class="us-menu-bar">
                        <span class="tit">我的订单</span>
                        <a href="#myOrder" data-preventdefault="is_login" class="all">全部订单<i class="icon"></i></a>
                    </div>
                    <div class="us-menu-group clearfix">
                        <a href="#myOrder_needpay" data-preventdefault="is_login">
                            {if $member['number']['needpay']}
                            <i class="remind-num">{$member['number']['needpay']}</i>
                            {/if}
                            <i class="dd-icon icon"></i>
                            <em>待付款</em>
                        </a>
                        <a href="#myOrder_needconsume" data-preventdefault="is_login">
                            {if $member['number']['needconsume']}
                            <i class="remind-num">{$member['number']['needconsume']}</i>
                            {/if}
                            <i class="fk-icon icon"></i>
                            <em>待消费</em>
                        </a>
                        <a href="#myOrder_needcomment" data-preventdefault="is_login">
                            {if $member['number']['needcomment']}
                            <i class="remind-num">{$member['number']['needcomment']}</i>
                            {/if}
                            <i class="xf-icon icon"></i>
                            <em>待点评</em>
                        </a>
                        <a href="#myOrder_needrefunds" data-preventdefault="is_login">
                            {if $member['number']['needrefunds']}
                            <i class="remind-num">{$member['number']['needrefunds']}</i>
                            {/if}
                            <i class="dp-icon icon"></i>
                            <em>退款</em>
                        </a>
                    </div>
                </div>
            </div>
            <!-- 用户信息 -->
            {if !empty($member)}
            <div class="user-app-bar {if !St_Functions::is_normal_app_install('red_envelope') && !St_Functions::is_normal_app_install('coupon')} app-seldom {/if}">
                <a class="item" href="#myWallet" data-preventdefault="is_login">
                    <span class="num">{Currency_Tool::symbol()}{php echo $member['money']-$member['money_frozen']}</span>
                    <span class="txt">我的钱包</span>
                </a>
                {if St_Functions::is_normal_app_install('coupon')}
                <a class="item" href="{$cmsurl}member/coupon" data-preventdefault="is_login" >
                    <span class="num">{$member['number']['coupon']}张</span>
                    <span class="txt">优惠券</span>
                </a>
                {/if}
                {if St_Functions::is_normal_app_install('red_envelope')}
                <a class="item" data-ajax="false" href="{$cmsurl}member/envelope/member_list" data-preventdefault="is_login" >
                    <span class="num">{$member['number']['red_envelope']}个</span>
                    <span class="txt">红包</span>
                </a>
                {/if}
                <a class="item" href="{$cmsurl}member/club#&{$cmsurl}member/club/score" data-ajax="false" data-preventdefault="is_login">
                    <span class="num">{$member['jifen']}</span>
                    <span class="txt">积分{if St_Functions::is_normal_app_install('member_sign')}{request "sign/check"}{/if}</span>
                </a>
            </div>
            <!-- 钱包、优惠券、红包、积分 -->
            {/if}

            {if St_Functions::is_normal_app_install('mobiledistribution')}
            <div class="user-item-list">
                <ul class="list-group">
                    <li>
                        <a href="{$fx_url}"  data-ajax="false" data-preventdefault="is_login">
                            <i class="icon fxs-icon"></i>
                            <span class="hd-name">分销商</span>
                            {if !empty($fx)}
                            <span class="fxs-txt fr">分销商中心</span>
                            {else}
                            <span class="fxs-txt fr">立即申请</span>
                            {/if}
                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- 分销商中心 -->
            {/if}

            <div class="user-item-list">
                <ul class="list-group">
                    {if St_Functions::is_normal_app_install('together')}
                    <li>
                        <a  href="{$cmsurl}member/together/member_list#myRedenvelope" data-preventdefault="is_login" >
                            <span class="hd-name">我的拼团</span>
                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                    {/if}
                    {if St_Functions::is_system_app_install(101)}
                    <li>
                        <a href="{$cmsurl}notes/member" data-preventdefault="is_login">
                            <span class="hd-name">我的游记</span>
                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                    {/if}
                    {if St_Functions::is_system_app_install(11)}
                    <li>
                        <a href="{$cmsurl}jieban/member" data-preventdefault="is_login">
                            <span class="hd-name">我的结伴</span>
                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                    {/if}
                    <li>
                        <a href="{$cmsurl}member/consult/" data-preventdefault="is_login">
                            <span class="hd-name">我的咨询<i class="new-msg-icon hide"></i></span>
                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                    {if empty($member)}
                    <li>
                        <a href="#orderSeek">
                            <span class="hd-name">订单查询</span>
                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                    {/if}
                    <li>
                        <a href="#myFrequency" data-preventdefault="is_login">
                            <span class="hd-name">常用信息</span>
                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- 分类列表 -->
            <div class="error-info-bar hide"><i class="error-icon"></i>异常错误</div>
            <!-- 错误提示 -->
            <div class="no-content-page hide">
                <div class="no-content-icon"></div>
                <p class="no-content-txt">此页面暂无内容</p>
            </div>
            <!-- 页面暂无类容 -->
        </div>
        <!-- 公用顶部 -->
        <div class="page-content hide">
            <!-- 我的积分、优惠 -->
            <div class="user-item-list">
                <ul class="list-group">
                    <li>
                        <a href="#orderSeek">
                            <i class="icon dd-icon"></i>
                            <span class="txt">订单查询</span>

                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                    {if St_Functions::is_system_app_install(11)}
                    <li>
                        <a href="{$cmsurl}jieban/member" data-preventdefault="is_login">
                            <i class="icon jb-icon"></i>
                            <span class="txt">我的结伴</span>
                            <em class="num">{$member['number']['jieban']}</em>
                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                    {/if}
                    <li>
                        <a href="{$cmsurl}member/consult/" data-preventdefault="is_login">
                            <i class="icon zx-icon"></i>
                            <span class="txt">我的咨询</span>
                            <em class="num">{$member['number']['question']}</em>
                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- 我的订单、发表 -->
            <div class="user-item-list">
                <ul class="list-group">
                    <li>
                        <a href="#myFrequency" data-preventdefault="is_login">
                            <i class="icon lk-icon"></i>
                            <span class="txt">常用信息</span>
                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- 我的常用旅客 -->
        </div>
    </div>
    <!-- 个人中心首页 -->
    <div id="myAccount" class="page out" data-url="{$cmsurl}member/account/index"  data-params="root=window&callback=callback_page"> </div>
    <!--个人资料-->
    <div id="editData" class="page out" data-url="{$cmsurl}member/account/edit"  data-params="root=window&callback=callback_page"></div>
    <!--绑定手机-->
    <div id="bindPhone" class="page out" data-url="{$cmsurl}member/account/phone"  data-params="root=window&callback=callback_page"></div>
    <!--绑定邮箱-->
    <div id="bindMailbox" data-url="{$cmsurl}member/account/email"  data-params="root=window&callback=callback_page" class="page out"></div>
    <!--修改登陆密码-->
    <div id="passWord" data-url="{$cmsurl}member/account/password"  data-params="root=window&callback=callback_page" class="page out"></div>
    <!--我的订单-->
    <div id="myOrder_needrefunds" data-url="{$cmsurl}member/order/list?type=3"  data-params="root=window&callback=callback_page" class="page out"></div>
    <div id="myOrder" data-url="{$cmsurl}member/order/list?type=-1"  data-params="root=window&callback=callback_page" class="page out"></div>
    <div id="myOrder_needpay" data-url="{$cmsurl}member/order/list?type=0"  data-params="root=window&callback=callback_page" class="page out"></div>
    <div id="myOrder_needconsume" data-url="{$cmsurl}member/order/list?type=1"  data-params="root=window&callback=callback_page" class="page out"></div>
    <div id="myOrder_needcomment" data-url="{$cmsurl}member/order/list?type=2"  data-params="root=window&callback=callback_page" class="page out"></div>
    <!--订单查询-->
    <div id="orderSeek" data-url="{$cmsurl}member/order/query"  data-params="root=window&callback=callback_page" class="page out"></div>
    <div id="myLinkman" data-url="{$cmsurl}member/linkman"  data-params="root=window&callback=callback_page" class="page out"></div>

    <div id="myFrequency" data-url="{$cmsurl}member/frequency" data-params="root=window&callback=callback_page" class="page out">
    </div>

    <!--我的钱包-->
    <div id="myWallet" data-url="{$cmsurl}member/bag/index"  data-params="root=window&callback=callback_page" class="page out"></div>
    <!--实名认证-->
    <div id="certification" data-url="{$cmsurl}member/account/certification" data-params="root=window&callback=callback_page" class="page out" data-preventdefault="is_login"></div>
    <!--收货地址-->
    <div id="receiveAddress" data-url="{$cmsurl}member/receive/address"  data-params="root=window&callback=callback_page" class="page out" style="overflow: scroll" ></div>

    <div id="sysMessage" data-url="{$cmsurl}member/message/index"  data-params="root=window&callback=callback_page" class="page out">

    </div>


    <input type="hidden" id="islogin" value="{$islogin}"/>
    <input type="hidden" id="memberid" value="{$member['mid']}"/>
    {Common::js('jquery.min.js,mobilebone.js,swiper.min.js,jquery.validate.min.js,jquery.layer.js,template.js,layer/layer.m.js')}
    <script type="text/javascript" src="//{$GLOBALS['main_host']}/res/js/jquery.validate.addcheck.js"></script>
    <!--引入CSS-->
    <link rel="stylesheet" type="text/css" href="//{$GLOBALS['main_host']}/res/js/webuploader/webuploader.css" />
    <!--引入JS-->
    <script type="text/javascript" src="//{$GLOBALS['main_host']}/res/js/webuploader/webuploader.min.js"></script>
    <!--引入自定义CSS-->
    <link rel="stylesheet" type="text/css" href="//{$GLOBALS['main_host']}/res/css/web-uploader-custom.css" />
    <link type="text/css" rel="stylesheet" href="{$cmsurl}public/mui/css/mui.picker.css" />
    <link type="text/css" rel="stylesheet" href="{$cmsurl}public/mui/css/mui.poppicker.css" />
    <script src="{$cmsurl}public/mui/js/mui.min.js"></script>
    <script src="{$cmsurl}public/mui/js/mui.picker.js"></script>
    <script src="{$cmsurl}public/mui/js/mui.poppicker.js"></script>
    <script src="{$cmsurl}public/mui/js/city.data-3.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var SITEURL = "{$cmsurl}";
        Mobilebone.evalScript = true;
        window.callback_page = function(pageInto, pageOut, response) {

              var contain_id = $(pageInto).attr('id');
              var url = $(pageInto).attr('data-url');
              $("#"+contain_id).load(url);
        };
        window.is_login = function(object){
            var login_status = parseInt($('#islogin').val());
            if(!login_status){
                window.location.href = "{$cmsurl}member/login"
                return true;
            }else{
                return false;
            }


        }
        $('.back-center').click(function(){
            window.location.href = SITEURL;
        })
        window.do_reload = function(){
            console.log($('#linkman-list').find('li').length);
        }
    </script>
{if St_Functions::is_normal_app_install('member_sign') && $member}
    {request "sign/index"}
{/if}
</body>

</html>

