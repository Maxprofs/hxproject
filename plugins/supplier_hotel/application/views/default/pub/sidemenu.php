<div class="side-menu">


    <dl class="order">
        <dt><a href="javascript:;">酒店管理</a></dt>
        <dd>

            <a href="{$cmsurl}index/list" id="nav_hotel_list">酒店列表</a>
            <a href="{$cmsurl}order/all" id="nav_hotel_order">酒店订单</a>

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