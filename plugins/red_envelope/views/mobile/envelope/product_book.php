{Common::css_plugin('redenvelope.css','red_envelope')}
<div class="page out" id="useRedEnvelope" >
    <header>
        <div class="header_top">
            <a class="back-link-icon" href="#pageHome" data-rel="back"></a>
            <h1 class="page-title-bar">选择红包</h1>
        </div>
    </header>
    <!-- 公用顶部 -->
    <div class="page-content">
        {if $list}
        <div class="wrap-content">
            <ul class="use-redenvelope-list">
                {loop $list $l}
                <li class="item choose-envelope" data-money="{$l['money']}" data-id="{$l['id']}">
                    <span class="num">{Currency_Tool::symbol()}{$l['money']}</span>
                    <span class="txt">立即使用</span>
                </li>
                {/loop}

            </ul>
            <!-- 红包列表 -->
        </div>
        {else}
        <div class="no-content" >
            <div class="no-content-page" >
                <div class="no-content-icon"></div>
                <p class="no-content-txt">你的包包空空如也</p>

            </div>
        </div>
        {/if}
    </div>
</div>
<script>

    $(function () {

        //选择红包
        $('.choose-envelope').click(function () {
            var envelope_id = $(this).data('id');
            var envelope_price = $(this).data('money');
            $('#envelope_price').val(envelope_price);
            $('#envelope_member_id').val(envelope_id);
            window.history.go(-1);
            get_total_price(1);
            $('.envelope_type').html('<strong>红包抵扣</strong><em class="type">{Currency_Tool::symbol()}'+envelope_price+'</em>')

        })
    })

</script>