<div class="page out" id="useCoupon">
    <header>
        <div class="header_top">
            <a class="back-link-icon"  href="javascript:;" onclick="window.history.go(-1)" data-ajax="false"></a>
            <h1 class="page-title-bar">使用优惠券</h1>
        </div>
    </header>
    <!-- 公用顶部 -->
    <div class="page-content">
        <div class="wrap-content">
            <div class="use-coupon-block clearfix">
                <ul class="coupon-list">
                    {loop $list $l}
                    <li data-id="{$l['roleid']}" couponprice="{if $l['type']==1} {$l['amount']}折{else}{$l['amount']}元{/if}" cname="{$l['name']}">
                        <div class="attr-zs">通用券</div>
                        <div class="item-l fl">
                            <strong class="type">{$l['name']}</strong>
                            <p class="txt">品类限制：{if $l['typeid']==9999}部分{$l['typename']}产品可用{else}无品类限制{/if}</p>
                            <p class="date">有效期：{if $l['isnever']==1}截止{$l['endtime']}{else}永久有效{/if}</p>
                        </div>
                        <div class="item-r fr">
                            <span class="jg">{if $l['type']==1} {$l['amount']}折{else}{Currency_Tool::symbol()}{$l['amount']}{/if}</span>
                            <span class="sm">满{$l['samount']}元可用</span>
                            <i class="use-label"></i>
                        </div>
                    </li>
                    {/loop}

                </ul>
            </div>
            <!-- 使用列表 -->
        </div>
    </div>
</div>
<script>
    $(function(){

        //选择优惠券
        $('.coupon-list li').click(function() {
            var totoalprice =  $('#org_total_price').val();
            var this_obj = $(this);
            var couponprice= this_obj.attr('couponprice');

            if ($(this).hasClass('choosed'))
            {
                this_obj.removeClass('choosed');
                coupon_reset();
                if(typeof(get_total_price)=='function')
                {
                    get_total_price(1);
                }
            }
            else
            {
                this_obj.addClass('choosed');
                this_obj.siblings().removeClass('choosed');
                var couponid = this_obj.data('id');
                var typeid = '{$typeid}';
                var proid = "{$info['id']}";
                var couponname= this_obj.attr('cname');
                check_and_set_coupon(couponid,totoalprice,typeid,proid,couponname,couponprice);
            }
        })
    })
    /**
     * 检查优惠券是否可用
     */
    function check_and_set_coupon(couponid,totalprice,typeid,proid,couponname,amount)
    {

        var startdate = $('input[name=startdate]').val();

        $.ajax({
            type:"post",
            url:SITEURL+'coupon/ajax_check_samount',
            data:{couponid:couponid,totalprice:totalprice,typeid:typeid,proid:proid,startdate:startdate},
            datatype:'json',
            success:function(data){
                data = JSON.parse(data);
                if(data.status==1)
                {
                    var coupon_price=totalprice-data.totalprice;
                    $('#couponid').val(couponid);
                    $("#coupon_price").val(coupon_price);
                    $('.use_coupon_btn').html(couponname+'<i class="more-ico" ></i>');
                    $('.coupon_type').html('<strong>优惠券</strong><em class="type">'+amount+'</em>');
                    window.history.go(-1);
                    if(typeof(get_total_price)=='function')
                    {
                        get_total_price(1);
                    }
                }
                else
                {
                    $.layer({
                        type:1,
                        icon:2,
                        text:'不满足使用条件',
                        time:1000
                    });
                }
            }
        })


    }

    //重置优惠券
    function coupon_reset()
    {
        $(".coupon-list ul .choosed").removeClass('choosed');
        $('#couponid').val(0);
        $("#coupon_price").val(0);
        $('.use_coupon_btn').html('点击选择<i class="more-ico" ></i>');
        {if empty($list)}
            $('.coupon_type').html('<strong>优惠券</strong><em class="type">暂无可用优惠券</em>');
        {else}
            $('.coupon_type').html('<strong>优惠券</strong>');
        {/if}
      }
</script>