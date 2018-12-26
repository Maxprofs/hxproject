<div class="side-menu">
    <dl class="order">
        <dt><a href="javascript:;">车辆管理</a></dt>
        <dd>
            <a href="<?php echo $cmsurl;?>index/list" id="nav_car_list">车辆列表</a>
            <a href="<?php echo $cmsurl;?>order/all" id="nav_car_order">车辆订单</a>
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