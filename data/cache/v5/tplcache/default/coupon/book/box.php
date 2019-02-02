<?php defined('SYSPATH') or die();?> <?php if($list) { ?> <div class="item-yh"> <h3>优惠券</h3> <div class="item-nr"> <span class="item-list"> <strong class="item-hd">使用优惠券：</strong> <select class="down-list" name="couponid"  id="couponid-sel"> <option value="0">不使用</option> <?php $n=1; if(is_array($list)) { foreach($list as $l) { ?> <option value="<?php echo $l['roleid'];?>"> <?php if($l['type']==1) { ?> <?php echo $l['amount'];?>折<?php } else { ?>￥<?php echo $l['amount'];?> <?php } ?>
（<?php echo $l['name'];?>：满<?php echo $l['samount'];?>可用）</option> <?php $n++;}unset($n); } ?> </select> </span> </div> </div> <input type="hidden" id="coupon_price" value=""> <?php } ?> <script>
    $(function(){
        $('#couponid-sel').change(function(){
          //  $('.use-jf label').removeClass('on');
            //$('#usejifen').val(0);
            var couponid = $(this).val();
            set_coupon(couponid);
        })
    })
    /**
     * 设置优惠券
     */
    function set_coupon(couponid)
    {
        var totalprice = Number($("#total_price").val());
        var typeid =<?php echo $typeid;?> ;
        var proid =<?php echo $proid;?>;
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
                        $('.totalprice').html('<i class="currency_sy">' + CURRENCY_SYMBOL + '</i>' + data.totalprice);
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