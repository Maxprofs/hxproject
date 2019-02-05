<div class="side-menu">
    <dl class="account">
        <dt><a href="javascript:;" id="nav_enterprise">企业设置</a></dt>
        <dd>
            <a href="<?php echo $cmsurl;?>pc/index/enterpriseinfo" id="nav_enterpriseinfo">企业信息</a>
            <a href="<?php echo $cmsurl;?>pc/qualify/index" id="nav_qulification">资质验证</a>
        </dd>
    </dl>
    <!--<dl class="order">
        <dt><a href="javascript:;">订单管理</a></dt>
        <dd>
            <a href="<?php echo $cmsurl;?>pc/order/all" id="nav_all_order">我的订单</a>
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
        $("#p_enterpriseinfo").addClass('cur').siblings().removeClass('cur');
    })
</script>