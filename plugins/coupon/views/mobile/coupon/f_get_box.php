<?php defined('SYSPATH') or die();?>
<style>
    /* 优惠券领取 */
    .coupon-into-block{
        padding: 0.2rem 0.4rem;
        /*margin-bottom: 0.266667rem;*/
        -webkit-box-shadow: 0 1px 3px #e5e5e5;
        -moz-box-shadow: 0 1px 3px #e5e5e5;
        box-shadow: 0 1px 3px #e5e5e5;
        background: #fff;
    }
    .coupon-into-block .tit{
        display: inline-block;
        font-size: 0.373333rem;
    }
    .coupon-into-block .item{
        display: inline-block;
        font-size: 0;
    }
    .coupon-into-block .item .type{
        color: #f50;
        display: inline-block;
        padding: 0.1rem 0.2rem;
        margin-left: 0.2rem;
        border: 1px solid #f50;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        font-size: 0.32rem;
        font-style: normal;
    }
    .coupon-into-block .num{
        color: #999;
        float: right;
        display: inline-block;
        height: 0.7rem;
        line-height: 0.7rem;
        font-size: 0.373333rem;
    }
    .coupon-into-block .num > .more-icon{
        display: inline-block;
        width: 0.25rem;
        height: 0.25rem;
        vertical-align: middle;
        margin-top: 0.1rem;
        -webkit-transform: rotate(45deg) translateY(-50%);
        transform: rotate(45deg) translateY(-50%);
        border-top: 1px solid #a2a2a2;
        border-right: 1px solid #a2a2a2;
    }
</style>
{if $coupon['totalnum']>0}
<div class="coupon-into-block get_coupon" >
    <span class="tit">领券</span>
    <span class="item">
        {loop $coupon['price'] $price}
        <em class="type">{$price}</em>
        {/loop}
    </span>
    <span class="num">{$coupon['totalnum']}张<i class="more-icon"></i></span>
</div>
{/if}

<script>
    $(function(){
        $('.get_coupon').click(function(){
            var typeid='{$typeid}';
            var proid="{$info['id']}";
            var url = SITEURL + 'coupon-0-'+typeid+'-'+proid;
            window.location.href=url;
        })

    })


</script>