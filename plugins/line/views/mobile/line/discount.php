
<div class="booking-info-block clearfix" id="discount_con">
    <h3 class="block-tit-bar"><strong>优惠政策</strong></h3>
    <div class="block-item">
        <ul>
            {if $jifen['isopen']}
            <li class="jifen-con">
              <div>
                <p class="jf-use">使用<input type="number"  id="pub_needjifen" class="jf-num" />积分，抵现{Currency_Tool::symbol()}<span id="txt_jifentprice"></span></p>
                <p class="jf-txt">共{$jifen['userjifen']}积分，最多可使用<span id="txt_jifentprice_limit"></span>积分抵扣{Currency_Tool::symbol()}<span id="txt_jifentprice_price"></span></p>
              </div>
            </li>
            {/if}
            {if St_Functions::is_normal_app_install('coupon')}
            <li>
                                    <span class="item coupon_type">
                                        <strong>优惠券</strong>
                                    </span>
                <span class="more-type"><a href="#useCoupon" class="use_coupon_btn">点击选择<i class="more-ico"></i></a></span>
            </li>
            {/if}
            {if St_Functions::is_normal_app_install('red_envelope')}
            <li>
                                    <span class="item envelope_type">
                                        <strong>红包抵扣</strong>
                                    </span>
                <span class="more-type">
                    <a href="#useRedEnvelope" class="use_envelope_btn">点击选择<i class="more-ico"></i></a>
                </span>
            </li>
            {/if}
        </ul>
    </div>
</div>

<script>
    $('document').ready(function () {
        //积分判断
        var limit_jifen=parseInt($("#jifentprice_limit").val());
        if($("#discount_con .jifen-con").length>0 && limit_jifen>0)
        {
            var limit = $("#jifentprice_limit").val();
            var price = $("#jifentprice_price").val();
            $("#txt_jifentprice_limit").html(limit);
            $("#txt_jifentprice_price").html(price);
        }
        else
        {
            $("#disocunt_con .jifen-con").hide();
        }

        //积分输入
        $("#pub_needjifen").on('keyup change',function(){
            jifentprice_check();
            jifentprice_update();
            if(typeof(get_total_price)=='function')
            {
                get_total_price(1);
            }
        });


       /* $("#pub_needjifen").change(function(){
            jifentprice_check();
            jifentprice_update();
            if(typeof(get_total_price)=='function')
            {
                get_total_price(1);
            }
        });*/

    });
</script>

<script>


    //计算积分抵现
    function jifentprice_calculate()
    {

        var  max_jifen=parseInt($("#max_useful_jifen").val());
        //var  limit_jifen=parseInt(jifentprice_limit);
        var  exchange = parseInt($("#jifentprice_exchange").val());
        if(!max_jifen||!exchange)
            return 0;
        var needjifen=parseInt($("#pub_needjifen").val());
        if(!needjifen||needjifen<=0)
            return 0;
        var price=Math.floor(needjifen/exchange);
        return price;
    }
    //刷新积分抵现
    function jifentprice_update()
    {
        var price=jifentprice_calculate();
        var needjifen=parseInt($("#pub_needjifen").val());
        $("#txt_jifentprice").text(price);

        var result=jifentprice_check(true);
        if(result)
        {
            $("#needjifen").val(needjifen);
        }else
        {
            $("#needjifen").val(0);
        }
    }

    //验证积分抵现
    function jifentprice_check(isreturn)
    {
        var  max_jifen=parseInt($("#max_useful_jifen").val());
        var needjifen=$("#pub_needjifen").val();
        needjifen =parseInt(needjifen);
        var status=false;
        if(!needjifen)
        {
            status = true;
        }
        else if(needjifen<=max_jifen)
        {
            status = true;
        }

        if(!isreturn&&!status)
        {
            $.layer({
                type:1,
                icon:2,
                text:'超过抵扣上限',
                time:1000
            });
            jifentprice_reset();
        }
        return status;

    }


    //重置红包
    function envelope_reset() {
        $('#envelope_price').val(0);
        $('#envelope_member_id').val(0);

    }

    /**
     * 清除优惠券
     */
    function clear_coupon()
    {
        $('#couponid').val(0);
        $('.coupon-list li i').removeClass('use-label');
        $('.coupon-list li').attr('is_check',0);
        $('.use_coupon_btn').html('点击选择<i class="more-ico" ></i>');
        {if empty($couponlist)}
            $('.coupon_type').html('<strong>优惠券</strong><em class="type">暂无可用优惠券</em>');
            {else}
            $('.coupon_type').html('<strong>优惠券</strong>');
            {/if}
            }
            //重设积分,即积分置0
            function jifentprice_reset()
            {
                $("#pub_needjifen").val(0);
                jifentprice_update();
            }

</script>