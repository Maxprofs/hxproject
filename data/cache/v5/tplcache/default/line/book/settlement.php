<div class="booking-r-container"> <div class="booking-side-total"> <div class="side-total-bar"><span class="tit">结算信息</span></div> <div class="side-total-block"> <h4 class="side-total-tit">预订明细</h4> <ul class="side-total-list"> <li> <span class="hd">预订方式</span> <span class="bd"><?php if($suitInfo['paytype']==1) { ?>全额预订<?php } else { ?>定金预订<?php } ?> </span> </li> <li> <span class="hd">预订时间</span> <span class="bd"><?php echo date('Y-m-d');?></span> </li> <li> <span class="hd">出发日期</span> <span class="bd usedate"><?php echo $info['usedate'];?></span> </li> <li> <span class="hd">预定套餐</span> <span class="bd"><?php echo $suitInfo['title'];?></span> </li> <li class="settlement_adult"  <?php if(!Common::check_instr($suitPrice['propgroup'],2) || $adultnum==0) { ?>style="display:none"<?php } ?>
> <span class="hd">成人</span> <span class="bd"><?php echo Currency_Tool::symbol();?><em class="txt_adultprice"><?php echo $suitPrice['adultprice'];?></em>×<em class="txt_adultnum"><?php echo $adultnum;?></em></span> </li> <li class="settlement_child" <?php if(!Common::check_instr($suitPrice['propgroup'],1) || $childnum==0) { ?>style="display:none"<?php } ?>
> <span class="hd">儿童</span> <span class="bd"><?php echo Currency_Tool::symbol();?><em class="txt_childprice"><?php echo $suitPrice['childprice'];?></em>×<em class="txt_childnum"><?php echo $childnum;?></em></span> </li> <li class="settlement_old" <?php if(!Common::check_instr($suitPrice['propgroup'],3) || $oldnum==0) { ?>style="display:none"<?php } ?>
> <span class="hd">老人</span> <span class="bd"><?php echo Currency_Tool::symbol();?><em class="txt_oldprice"><?php echo $suitPrice['oldprice'];?></em>×<em class="txt_oldnum"><?php echo $oldnum;?></em></span> </li> <li class="settlement_roombalance" <?php if((!$suitPrice['roombalance'])) { ?>style="display:none"<?php } ?>
> <span class="hd">单房差</span> <span class="bd"><?php echo Currency_Tool::symbol();?><em class="txt_roombalanceprice"><?php echo $suitPrice['roombalance'];?></em>×<em class="txt_roombalancenum"><?php echo $roombalance;?></em></span> </li> </ul> </div> <div class="side-total-block"> <h4 class="side-total-tit">附加产品</h4> <ul class="side-total-list" id="additional"> </ul> </div> <div class="side-total-block"> <h4 class="side-total-tit">优惠明细</h4> <ul class="side-total-list" id="discount"> </ul> </div> <?php if($suitInfo['paytype']==2) { ?> <div class="side-total-block"> <h4 class="side-total-tit">定金明细</h4> <ul class="side-total-list"> <li> <span class="hd">定金</span> <span class="bd settle-dg-detail"></span> </li> </ul> </div> <?php } ?> <div class="side-total-block side-amount-bar"> <ul class="side-total-list"> <?php if($suitInfo['paytype']==2) { ?> <li> <span class="hd">预定总额</span> <span class="bd c-f60 order-total-price"></span> </li> <li class="discount-total"> <span class="hd">优惠总额</span> <span class="bd c-f60 discount-total-price"></span> </li> <li class="settel-dg"> <span class="hd">应付总额</span> <span class="bd c-f60 pay-total-price"></span> </li> <li class="settel-dg"> <span class="hd">待支付尾款</span> <span class="bd c-f60 left-total-price"></span> </li> <li class="all-li"> <span class="hd all-item">应付定金</span> <span class="bd all-pri dingjin-total-price"></span> </li> <?php } else { ?> <li> <span class="hd">预定总额</span> <span class="bd c-f60 order-total-price"></span> </li> <li class="discount-total"> <span class="hd">优惠总额</span> <span class="bd c-f60 discount-total-price"></span> </li> <li class="all-li"> <span class="hd all-item">应付总额</span> <span class="bd all-pri pay-total-price"></span> </li> <?php } ?> </ul> </div> </div> <!-- 结算信息 --> </div> <script>
    /**
     * 计算总价.
     * @param resetDiscount 是否重置优惠
     */
    function get_total_price(resetDiscount) {
        if(resetDiscount==0)
        {
            if(typeof(reset_discount)=='function'){
                reset_discount();
            }
        }
        //结算信息
        set_settle_info();
        var adult_num = Number($("#adult_num").val());
        var child_num = Number($("#child_num").val());
        var old_num = Number($("#old_num").val());
        var room_balance_num = Number($('#roombalance_num').val());
        adult_num = isNaN(adult_num) ? 0 : adult_num;
        child_num = isNaN(child_num) ? 0 : child_num;
        old_num = isNaN(old_num) ? 0 : old_num;
        room_balance_num = isNaN(room_balance_num) ? 0 : room_balance_num;
        var adult_price = Number($("#adultprice").val());
        var child_price = Number($("#childprice").val());
        var old_price = Number($("#oldprice").val());
        var room_balance_price = Number($('#roombalance_price').val());
        //按人群价格
        var adult_total_price = ST.Math.mul(adult_num, adult_price);// adult_num * adult_price;
        var child_total_price = ST.Math.mul(child_num, child_price);
        var old_total_price = ST.Math.mul(old_num, old_price);
        var room_total_price = ST.Math.mul(room_balance_num,room_balance_price);
        $(".adult_total_price").html('<i class="currency_sy">' + CURRENCY_SYMBOL + '</i>' + adult_total_price);
        $(".child_total_price").html('<i class="currency_sy">' + CURRENCY_SYMBOL + '</i>' + child_total_price);
        $(".old_total_price").html('<i class="currency_sy">' + CURRENCY_SYMBOL + '</i>' + old_total_price);
        $(".roombalance_total_price").html('<i class="currency_sy">' + CURRENCY_SYMBOL + '</i>' + room_total_price);
        //保险总价
        var ins_total_price = Number($('#ins_total_price').val());
        ins_total_price = isNaN(ins_total_price) ? 0 : ins_total_price;
        //订单总价
        var total_price = ST.Math.add(adult_total_price,child_total_price);
            total_price = ST.Math.add(total_price,old_total_price);
            total_price = ST.Math.add(total_price,room_total_price);
            total_price = ST.Math.add(total_price,ins_total_price);
        var pay_price = total_price;
        var discount_price = 0;
        //检测是否使用优惠
        if(typeof(get_discount_price)=='function'){
            discount_price = get_discount_price();
            //应付总价
            pay_price = total_price - discount_price;
        }
        //如果总价<0,则重置优惠策略
        if(pay_price<0)
        {
            on_negative_totalprice();
            return;
        }
        //设置红包
        var envelope_price =Number($('#envelope_price').val());
        if(envelope_price>0)
        {
            pay_price = pay_price-envelope_price;
            if(pay_price<0)
            {
                pay_price = 0 ;
            }
            discount_price += envelope_price;
        }
        //优惠总额小于0,则隐藏优惠显示
        if(discount_price ==0){
            $('.discount-total').hide();
        }else{
            $('.discount-total').show();
        }
        //订单总额
        $('.order-total-price').html(CURRENCY_SYMBOL+total_price);
        //优惠总额
        $('.discount-total-price').html(CURRENCY_SYMBOL+discount_price);
        //应付总额
        $('.pay-total-price').html(CURRENCY_SYMBOL+pay_price);
        //是否是定金支付
        var paytype = Number($('#paytype').val());
        if(paytype == 2){
            var dingjin_price = Number($('#dingjin').val());
            var total_num = get_total_num();
            //优惠总额
            var discount = discount_price ? discount_price : 0;
            //定金总额
            var dingjin_total_price = dingjin_price * total_num;
            //尾款,
            var left_price = total_price - dingjin_total_price - discount;
            left_price =left_price>0 ? left_price : 0;
            //如果定金总额大于订单金额,则直接取订单金额
            if(dingjin_total_price > total_price){
                dingjin_total_price = total_price;
            }
            dingjin_total_price = dingjin_total_price - discount;
            var dingjin_info = "（定金）"+CURRENCY_SYMBOL+dingjin_total_price+' +（尾款）'+CURRENCY_SYMBOL+left_price+'=（应付总额）'+CURRENCY_SYMBOL+pay_price;
            $('#left-dg-info').html(dingjin_info);
            //右侧结算
            var dg =CURRENCY_SYMBOL+dingjin_price+'×'+total_num;
            $('.settle-dg-detail').html(dg);
            //尾款总额
            $('.left-total-price').html(CURRENCY_SYMBOL+left_price);
            //应付定金
            $('.dingjin-total-price').html(CURRENCY_SYMBOL+dingjin_total_price);
        }else{
            $('#djinfo').html('');
        }
        $("#total_price").val(total_price);
        //预订送积分提前预估
        var jf_value = 0;
        if(jifenbook){
            if(jifenbook.rewardtype ==1){
                jf_value = parseFloat(pay_price * jifenbook.value / 100);
            }else{
                jf_value = jifenbook.value;
            }
            if(jf_value > 0){
                $('.jifenbook').html('（预订赠送积分'+jf_value+'分）')
            }
        }
        if(pay_price<=0)
        {
            if($("#invoice_block .bib-radio-label").length>0)
            {
                $("#invoice_block .bib-radio-label:first").trigger('click');
                $("#invoice_block .bib-radio-label:gt(0)").hide();
            }
            else
            {
                $("#invoice_block .bib-radio-label").show();
            }
        }
        else
        {
            $("#invoice_block .bib-radio-label").show();
        }
    }
    //设置结算信息.
    function set_settle_info(){
        var adultprice = Number($('#adultprice').val());
        var childprice = Number($('#childprice').val());
        var oldprice = Number($('#oldprice').val());
        var roombalance = Number($('#roombalance_price').val());
        var adultnum = $('#adult_num').val();
        var childnum = $('#child_num').val();
        var oldnum = $('#old_num').val();
        var roombalance_num = $('#roombalance_num').val();
        $('.txt_adultprice').text(adultprice);
        $('.txt_childprice').text(childprice);
        $('.txt_oldprice').text(oldprice);
        $('.txt_roombalanceprice').text(roombalance);
        $('.txt_adultnum').text(adultnum);
        $('.txt_childnum').text(childnum);
        $('.txt_oldnum').text(oldnum);
        $('.txt_roombalancenum').text(roombalance_num);
        if(adultprice>0 && adultnum>0 ){
            $('.settlement_adult').show();
        }else{
            $('.settlement_adult').hide();
        }
        if(childprice>0 && childnum>0){
            $('.settlement_child').show();
        }else{
            $('.settlement_child').hide();
        }
        if(oldprice>0 && oldnum>0){
            $('.settlement_old').show();
        }else{
            $('.settlement_old').hide();
        }
        if(roombalance>0 && roombalance_num>0){
            $('.settlement_roombalance').show();
        }else{
            $('.settlement_roombalance').hide();
        }
        //保险结算信息
        var ins_total_price = 0;
        $('#additional').html('');
        $('.ins-check-key').each(function(i,obj){
            if($(obj).attr('ischeck') == 1){
                var total_num = get_total_num();
                var title = $(obj).attr('title');
                var price = Number($(obj).attr('price'));
                var ins_price = price * total_num;
                var price_txt = '<i class="currency_sy">' + CURRENCY_SYMBOL + '</i>'+ST.Math.mul(price,total_num);
                $(obj).parents('tr').first().find('.price').html(price_txt);
                var settle_info = ' <li>';
                    settle_info +='<span class="hd">'+title+'</span>';
                    settle_info +='<span class="bd">'+CURRENCY_SYMBOL +price+'×'+total_num+'</span>';
                    settle_info +='</li>';
                    ins_total_price+=ins_price;
                    $('#additional').append(settle_info);
            }else{
                var price_txt = '<i class="currency_sy">' + CURRENCY_SYMBOL + '0</i>';
                $(obj).parents('tr').first().find('.price').html(price_txt);
            }
        })
        //保险总价
        $('#ins_total_price').val(ins_total_price);
        //优惠信息
        $('#discount').html('');
        var coupon_price = Number($('#coupon_price').val());
        if(!isNaN(coupon_price) && coupon_price!=0){
           var coupon_info = '<li>';
               coupon_info+= '<span class="hd">优惠券抵扣</span>';
               coupon_info+= '<span class="bd">-<i class="currency_sy">' + CURRENCY_SYMBOL + coupon_price+'</i>×1</span>';
               coupon_info+= '</li>';
            $('#discount').append(coupon_info);
        }
        var envelope_price = Number($('#envelope_price').val());
        if(!isNaN(envelope_price) && envelope_price!=0){
            var envelope_info = '<li>';
            envelope_info+= '<span class="hd">红包抵扣</span>';
            envelope_info+= '<span class="bd">-<i class="currency_sy">' + CURRENCY_SYMBOL + envelope_price+'</i></span>';
            envelope_info+= '</li>';
            $('#discount').append(envelope_info);
        }
        if(typeof(jifentprice_calculate)=='function' ){
            var jifen_price = jifentprice_calculate();
            if(jifen_price>0){
                var jifen_info = '<li>';
                jifen_info+= '<span class="hd">积分抵扣</span>';
                jifen_info+= '<span class="bd">-<i class="currency_sy">' + CURRENCY_SYMBOL + jifen_price+'</i></span>';
                jifen_info+= '</li>';
                $('#discount').append(jifen_info);
            }
        }
        //隐藏无内容项
        if($('#additional').html()==''){
            $('#additional').parent().hide()
        }else{
            $('#additional').parent().show()
        }
        if($('#discount').html()==''){
            $('#discount').parent().hide()
        }else{
            $('#discount').parent().show()
        }
    }
    //当总价小于0时
    function on_negative_totalprice(params) {
        layer.msg('优惠价格超过产品总价，请重新选择优惠策略',{icon:5,time:2200})
        if(typeof(jifentprice_reset)=='function'){
            jifentprice_reset();
        }
        if(typeof(coupon_reset)=='function'){
            coupon_reset();
        }
        if(typeof(envelope_reset)=='function'){
            envelope_reset();
        }
        get_total_price(1);
    }
</script>