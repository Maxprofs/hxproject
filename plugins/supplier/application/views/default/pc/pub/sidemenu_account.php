<div class="side-menu">

    <dl class="account">
        <dt><a href="javascript:;" id="nav_account">账号管理</a></dt>
        <dd>
            <a href="{$cmsurl}pc/index/userinfo" id="nav_userinfo">帐号信息</a>
            <a href="{$cmsurl}pc/user/modify_phone" id="nav_modify_phone">更换手机</a>
            <a href="{$cmsurl}pc/user/modify_email" id="nav_modify_email">更换邮件</a>
            <a href="{$cmsurl}pc/user/modify_password" id="nav_modify_password">修改密码</a>
        </dd>
    </dl>

    <!--<dl class="order">
        <dt><a href="javascript:;">订单管理</a></dt>
        <dd>
            <a href="{$cmsurl}pc/order/all" id="nav_all_order">我的订单</a>
        </dd>
    </dl>-->

    <div class="shrink-btn"></div>
</div><!-- 侧边导航 -->

<script>
    $(function(){
        $('.shrink-btn').toggle(function(){
            $('.main').animate({left:'50px'},0);
            $(this).parent().addClass('mini-menu');
            $(this).css('right','97px');
        },function(){
            $('.main').animate({left:'160px'},0);
            $(this).parent().removeClass('mini-menu');
            $(this).css('right','-13px');
        })
    })

    $(function(){
        $("#p_enterpriseinfo").siblings().removeClass('cur');
    })
</script>