{if !empty($userInfo)}
<div class="booking-info-block">
    <div class="bib-hd-bar">
        <span class="col-title">优惠信息</span>
    </div>
    <div class="bib-bd-wrap">
        <div class="bib-yh-block">
            <ul class="booking-item-block">
                {if St_Functions::is_normal_app_install('coupon')}
                {php}
                  $typeid = 1;
                  $proid = $info['id'];
                  $coupon_list = Model_Coupon::get_pro_coupon(1,$proid);
                {/php}
                    {if !empty($coupon_list)}
                        <li>
                            <span class="item-hd">优惠券抵扣：</span>
                            <div class="item-bd">
                                <select class="select w230" name="couponid"  id="couponid-sel">
                                    <option value="0">不使用</option>
                                    {loop $coupon_list $l}
                                    <option value="{$l['roleid']}"> {if $l['type']==1}  {$l['amount']}折{else}￥{$l['amount']}  {/if}（{$l['name']}：满{$l['samount']}可用）</option>
                                    {/loop}
                                </select>
                            </div>
                        </li>
                    {/if}
                {/if}
                {if St_Functions::is_normal_app_install('red_envelope')}
                {php}
                 $envelope_list = Model_Order_Envelope::get_book_envelope(1);
                {/php}
                {if $envelope_list}
                <li>
                    <span class="item-hd">红包抵扣：</span>
                    <div class="item-bd">
                        <select class="select w230" name="envelope_member_id"  id="envelope-sel">
                            <option value="0">不使用</option>
                            {loop $envelope_list $l}
                            <option value="{$l['id']}" data-money="{$l['money']}">{Currency_Tool::symbol()}{$l['money']}</option>
                            {/loop}
                        </select>
                    </div>
                </li>
                {/if}
                {/if}
                <li>
                    <span class="item-hd">积分抵扣：</span>
                    <div class="item-bd">
                        <input type="text" class="input-text w100" id="needjifen"  data-exchange="{$jifentprice_info['cfg_exchange_jifen']}" name="needjifen" value="" placeholder="">
                        <span class="ml10">积分抵扣<span class="c-red" id="jifentprice">{Currency_Tool::symbol()}0</span></span>
                        <span class="ml10 c-999">最多可使用{$jifentprice_info['toplimit']}积分抵扣<i class="currency_sy">{Currency_Tool::symbol()}</i>{$jifentprice_info['jifentprice']}，我当前积分：{$userInfo['jifen']}</span>
                        <span class="error-txt ml10 jifen-error" style=" vertical-align: middle"></span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- 优惠信息 -->

<script>
    $(function(){
        //选择优惠券
        $('#couponid-sel').change(function(){
            var couponid = $(this).val();
            set_coupon(couponid);
        });

        //选择红包
        $('#envelope-sel').change(function(){
           var envelope_price = $(this).find('option:selected').data('money');
            $('#envelope_price').val(envelope_price);
            get_total_price(1);
        });

        //积分输入
        $("#needjifen").on('keyup change',function(){
            jifentprice_update();
            get_total_price(1);
        });
    });
    //最大可用积分
    var max_useful_jifen="{if $jifentprice_info['toplimit']>$userInfo['jifen']}{$userInfo['jifen']}{else}{$jifentprice_info['toplimit']}{/if}";
    //当原始价格发生改变时,重置优惠
    function reset_discount()
    {
        coupon_reset();
        jifentprice_reset();
        envelope_reset()
    }

    //获取优惠总价.
    function get_discount_price(){
        var price = 0;
        var jifentprice=jifentprice_calculate();
        var coupon_price = Number($('#coupon_price').val());
        if(!isNaN(coupon_price)){
            price = ST.Math.add(jifentprice,coupon_price);
        }
        return price;
    }
    //重设积分,即积分置0
    function jifentprice_reset()
    {
        $("#needjifen").val(0);
        jifentprice_update();

    }
    //更新积分价格
    function jifentprice_update()
    {
        var price=jifentprice_calculate();
        $("#jifentprice").html(CURRENCY_SYMBOL+price);

    }
    //计算积分抵现价格
    function jifentprice_calculate()
    {
        var needjifen=parseInt($("#needjifen").val());
        if(!needjifen||needjifen<=0)
            return 0;
        //当输入积分大于最大可用积分时,直接使用最大可用积分
        if(needjifen > max_useful_jifen){
            needjifen = max_useful_jifen;
            $("#needjifen").val(needjifen);
        }
        var exchange=$("#needjifen").data('exchange');
        var price=Math.floor(needjifen/exchange);
        return price;
    }

    //重置优惠券
    function coupon_reset()
    {
        $('select[name=couponid] option:first').attr('selected','selected');//优惠券重置
        $('#coupon_price').val(0);

    }

    //重置红包
    function envelope_reset()
    {
        $('select[name=envelope_member_id] option:first').attr('selected','selected');//优惠券重置
        $('#envelope_price').val(0);

    }
    //优惠券回调
    function coupon_callback(data){
        if(data.status==1)
        {

            $('#coupon_price').val(data['coupon_price']);
            get_total_price(1);
        }
        else
        {
            coupon_reset();
            layer.msg('不符合使用条件',{icon:5})
        }
    }
    /**
     * 设置优惠券
     */
    function set_coupon(couponid){
        var totalprice = Number($("#total_price").val());
        var typeid = 1;
        var proid ={$info['id']};
        var startdate = $('input[name=usedate]').val();
        if(!startdate)
        {
            startdate = $('input[name=startdate]').val();
        }
        if(couponid>0)
        {
            $.ajax({
                type:"post",
                url:SITEURL+'coupon/ajax_check_samount',
                data:{couponid:couponid,totalprice:totalprice,typeid:typeid,proid:proid,startdate:startdate},
                datatype:'json',
                success:function(data){
                    data = JSON.parse(data);

                    if(typeof(coupon_callback)=='function')
                    {
                        data['coupon_price']= totalprice-data.totalprice;
                        coupon_callback(data);
                        return;
                    }
                    if(data.status==1)
                    {
                        //$("#total_price").val(data.totalprice);
                        $('#coupon_price').val(totalprice-data.totalprice);


                    }
                    else
                    {
                        $('#coupon_price').val(0);
                        layer.msg('不符合使用条件',{icon:5})
                        $('select[name=couponid] option:first').attr('selected','selected');
                    }
                }

            })
        }
        else
        {
            $('#coupon_price').val(0);
            get_total_price();
        }

    }
</script>
{/if}