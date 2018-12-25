<div class="page out" id="useCoupon">
<header script_div=_MACXC >
    <div class="header_top">
        <div class="st_back"><a href="javascript:;"></a></div>
        <h1 class="tit">使用优惠券</h1>
        <a class="confirm-btn" href="javascript:;">确定</a>
    </div>
</header>
<!-- 公用顶部 -->

<section>
    <div class="wrap-content">
        <div class="use-coupon-block clearfix">
            <ul class="coupon-list">
                {loop $list $l}
                <li data-id="{$l['roleid']}" is_check="0" couponprice="{if $l['type']==1} {$l['amount']}折{else}{$l['amount']}元{/if}" cname="{$l['name']}">
                    {if $l['kindid']==1}
                    <div class="attr-ty">通用券</div>
                    {elseif $l['kindid']==2}
                    <div class="attr-zs">兑换券</div>
                    {/if}
                    <div class="item-l">
                        <strong class="type">{$l['name']}</strong>
                        <p class="txt">品类限制：{if $l['typeid']==9999}部分{$l['typename']}产品可用{elseif $l['typeid']==1}{$l['typename']}产品可用{else}无品类限制{/if}</p>
                        <p class="date">有效期：{if $l['isnever']==1}{$l['starttime']}至{$l['endtime']}{else}永久有效{/if}</p>
                    </div>
                    <div class="item-r">
                        <span class="jg">{if $l['type']==1} {$l['amount']}折{else}{Currency_Tool::symbol()}{$l['amount']}  {/if}</span>
                        <span class="sm">满{$l['samount']}元可用</span>
                        <i class=""></i>
                    </div>
                </li>
                {/loop}
            </ul>
        </div>
        <!-- 使用列表 -->

    </div>
</section>
<script>
    $(function(){

        //优惠券选择展开
        $('.use_coupon_btn').click(function(){
            $("#coupon_box").show();
            $(".mid_content").hide();
            $(".integral_content").hide();
            $(".sys_header").hide();
            $("header").eq(0).hide();
			$('.page').show();
			$('.page').css('overflow','initial');
		
        })
        //选择优惠券
        $('.coupon-list li').click(function() {
            var totoalprice =  $('#org_total_price').val();
            var this_obj = $(this);
            var is_check = $(this).attr('is_check');
            var couponprice= this_obj.attr('couponprice');
            if (is_check == 1)
            {
                coupon_reset();
                if(typeof(get_total_price)=='function')
                {
                    get_total_price(1);
                }
            }
            else
            {
                $('.coupon-list li i').removeClass('use-label');
                $('.coupon-list li').attr('is_check',0);
                this_obj.find('i').addClass('use-label');
                this_obj.attr('is_check',1);
                var couponid = this_obj.attr('data-id');
                var typeid = '{$typeid}';
                var proid = "{$info['id']}";
                var couponname= this_obj.attr('cname');

                check_and_set_coupon(couponid,totoalprice,typeid,proid,couponname,couponprice)
            }
        })
        //优惠券选择隐藏
        $('.st_back,.confirm-btn').click(function(){
            $("#coupon_box").hide();
            $(".mid_content").show();
            $(".integral_content").show();
            $(".sys_header").show();
			 $("header").eq(0).show();
			$('.page').hide();
        })


    })


    $('.confirm-btn').click(function(){
        $("#coupon_box").hide();
        $(".mid_content").show();
        $(".integral_content").show();
        $(".sys_header").show();
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
                    if(typeof(get_total_price)=='function')
                    {
                        get_total_price(1);
                    }
                }
                else
                {

                    layer.open({
                            content:'不满足使用条件'
                        }
                    )
                }
            }
        })


    }

    //重置优惠券
    function coupon_reset()
    {
        var ele=$(".coupon-list li[is_check='1']");
        ele.find('i').removeClass('use-label');
        ele.attr('is_check',0);
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