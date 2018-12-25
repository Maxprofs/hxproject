<?php defined('SYSPATH') or die();?>
<style>


    .coupon-side-block{
        width: 162px;
        height: 398px;
        position: absolute;
        top: 250px;
        left: 0;
        z-index: 99999;
        background: url("/plugins/coupon/public/images/coupon-bg.png") top no-repeat;
    }
    .coupon-side-block .coupon-close-btn{
        display: block;
        width: 14px;
        height: 14px;
        position: absolute;
        right: 17px;
        top: 5px;
        -webkit-transition: all .3s;
        -moz-transition: all .3s;
        -ms-transition: all .3s;
        -o-transition: all .3s;
        transition: all .3s;
        background: url("/plugins/coupon/public/images/coupon-ico.png") no-repeat -128px -132px;
    }
    .coupon-side-block .coupon-close-btn:hover{
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .coupon-item-block{
        padding: 80px 14px 0 16px;
    }
    .coupon-item-block > li{
        height: 78px;
        margin-bottom: 10px;
        background: url("/plugins/coupon/public/images/coupon-ico.png") no-repeat;
    }
    .coupon-item-block > li.item-first{
        background-position: 0 -204px;
    }
    .coupon-item-block > li.item-second{
        background-position: 0 -283px;
    }
    .coupon-item-block > li.item-third{
        background-position: 0 -362px;
    }
    .coupon-item-block > li .l-con{
        float: left;
        width: 102px;
        height: 78px;
        text-align: center;
    }
    .coupon-item-block > li .l-con .jz{
        color: #e5402d;
        display: block;
        height: 30px;
        line-height: 30px;
        margin-top: 4px;
        font-size: 18px;
        font-weight:bold;
    }
    .coupon-item-block > li .l-con .jz strong{
        font-size: 28px;
        font-weight:bold;
    }
    .coupon-item-block > li .l-con .md{
        color: #fd7304;
        display: block;
        font-weight: bold;
    }
    .coupon-item-block > li .l-con .yh{
        color: #fd7304;
        display: block;
        font-size: 16px;
        font-weight: bold;
    }
    .coupon-item-block > li .zt{
        float: right;
        width: 16px;
        height: 64px;
        line-height: 16px;
        padding: 9px 7px 5px;
        font-size: 14px;
        font-weight:bold;
    }
    .coupon-item-block > li.item-first .zt{
        color: #fd7402;
    }
    .coupon-item-block > li.item-second .zt{
        color: #fff;
    }
    .coupon-item-block > li.item-third .zt{
        color: #a8a8a8;
        padding: 18px 7px 12px;
    }
    .coupon-side-block .more-coupon{
        display: inline-block;
        color: #df0625;
        width: 92px;
        height: 24px;
        line-height: 26px;
        margin: 7px 0 0 36px;
        text-align: center;
        font-size: 14px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        background: #ffe5e9;
    }
    .coupon-side-btn{
        z-index: 9999999;
        display: none;
        color: #fff;
        width: 16px;
        height: 100px;
        line-height: 16px;
        padding: 10px 13px;
        position: absolute;
        left: 0;
        top: 300px;
        font-size: 16px;
        cursor: pointer;
        border-top-right-radius: 3px;
        border-bottom-right-radius: 3px;
        background: #df0625;
    }


</style>

<div class="coupon-side-block" style="top: 1300px;"><a href="javascript:;" class="coupon-close-btn">
    </a>
    <ul class="coupon-item-block clearfix">

    </ul><a class="more-coupon"  target="_blank" href="/coupon-{$typeid}-{$proid}">更多优惠券</a></div>
    <div class="coupon-side-btn" style="top: 400px; display: none;">先领券 再购物</div>





<script>
    $(function(){

        $(window).scroll(function () {
            var offsetTop = $(window).scrollTop() + 250 + "px";
            $(".coupon-side-block,.coupon-side-btn").animate({top: offsetTop}, {duration: 500, queue: false});
        });
        //关闭优惠券展示
        $(".coupon-close-btn").on("click",function(){
            $(".coupon-side-block").hide();
            $(".coupon-side-btn").show()
        });
        //显示优惠券展示
        $(".coupon-side-btn").on("click",function(){
            $(this).hide();
            $(".coupon-side-block").show();
        })
    })
</script>
{Common::js('layer/layer.js',0)}
<script>
    $(function(){
        //领取优惠券

        $('.coupon-side-block').on('click','.get_coupon',function(){
            var couponid = $(this).attr('couponid');
            $.ajax({
                type: 'POST',
                url: SITEURL + 'coupon/ajxa_get_coupon',
                data: {cid:couponid},
                async: false,
                dataType: 'json',
                success: function (data) {
                    if(data.status==0)
                    {
                        layer.msg(data.msg, {icon: 5,time:1000});
                    }
                    if(data.status==1)
                    {
                        layer.msg(data.msg, {icon: 5,time: 1000},function(){
                            var url = SITEURL+'member/login';
                            window.location.href=url;
                        });
                    }
                    if(data.status==2)
                    {
                        layer.msg(data.msg, {icon: 6,time: 1000},function(){
                            window.location.reload();
                        });
                    }
                }
            })


        })

        $('.get_coupon').click(function(){
            var couponid = $(this).attr('couponid');
            $.ajax({
                type: 'POST',
                url: SITEURL + 'coupon/ajxa_get_coupon',
                data: {cid:couponid},
                async: false,
                dataType: 'json',
                success: function (data) {
                    if(data.status==0)
                    {
                        layer.msg(data.msg, {icon: 5});
                    }
                    if(data.status==1)
                    {
                        layer.msg(data.msg, {icon: 5,time: 1000},function(){
                            var url = SITEURL+'member/login';
                            window.location.href=url;
                        });
                    }
                    if(data.status==2)
                    {
                        layer.msg(data.msg, {icon: 6,time: 1000},function(){
                            window.location.reload();
                        });
                    }
                }
            })
        })
        get_list();
    })

    function get_list()
    {
        var typeid = '{$typeid}';
        var proid = '{$proid}';
        $.ajax({
            type: 'POST',
            url: SITEURL + 'coupon/ajax_get_float_list',
            async: false,
            data:{typeid:typeid,proid:proid},
            dataType: 'json',
            success: function (data) {
                if(data.list.length>0)
                {
                    var html = '';
                    $(data.list).each(function(index,val){
                        var classval='item-first';
                        var get_html = '<a class="zt get_coupon" href="javascript:void (0)" couponid="'+val.id+'">立即领券</a>';
                        var  pricr_html = '<span class="jz">￥<strong>'+val.amount+'</strong></span>';
                        if(val.status==2)
                        {
                            classval = 'item-third';
                            get_html='<span class="zt">领完了</span>';
                        }
                        else if(val.status==3)
                        {
                            classval = 'item-second';
                            get_html='<span class="zt">已领取</span>';
                        }
                       if(val.type==1)
                       {
                            pricr_html= ' <span class="jz"><strong>'+val.amount+'</strong>折</span>'
                       }
                        html += '<li class="'+classval+'"><span class="l-con">'+pricr_html+' <span class="md">满'+val.samount+'元使用</span>' +
                        '<span class="yh">优惠券</span></span>'+get_html+'</li>'
                    })
                    $('.coupon-item-block').html(html);
                }
                else
                {
                    $('.coupon-side-block').hide()
                }

            }
        })

    }

</script>