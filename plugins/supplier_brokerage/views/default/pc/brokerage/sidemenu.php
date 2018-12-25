<div class="side-menu">
    <dl class="home">
        <dt><a href="{$cmsurl}brokerage" >财务管理</a></dt>
        <dd>
            <a href="{$cmsurl}brokerage" id="brokerage_index">结算记录</a>
            <a href="{$cmsurl}brokerage/approval" id="brokerage_approval">提现管理</a>
            <a href="{$cmsurl}brokerage/stat" id="brokerage_stat">结算统计</a>
        </dd>
    </dl>
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
</script>