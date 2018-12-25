{if $info['status']!=3 && $info['status']!=4 && $info['status']!=5}
<div class="order-show-block">
    <ul class="info-item-block">
        <li>
            <span class="item-hd">订单状态：</span>
            <div class="item-bd" id="status_con">


                {loop $orderstatus $v}
                  {php}
                    $relation = $relationship[$info['status']];
                    if(in_array($v['status'],$relation))
                    {
                       $is_useful = 1;
                    }
                    else
                    {
                        $is_useful = 0;
                    }

                  {/php}
                    {if $is_useful}
                        <label class="radio-label order-status mr-30">
                        <input name="status" type="radio" class="checkbox" {if $info['status']==$v['status']}checked="checked"{/if} value="{$v['status']}" />{$v['status_name']}
                        </label>
                    {/if}
                {/loop}


            </div>
        </li>
    </ul>
</div>
{include "admin/line/order/status/box-order-complete"}
{include "admin/line/order/status/box-order-close"}
{include "admin/line/order/status/box-order-refund"}

<script>
    $(function(){
        //退款审核是否通过
        $('.order-status').click(function() {

            $('.order-box').hide();
            var status = $(this).find('input').val();

            if(status == oldstatus){
                $(this).find('input').attr('checked','checked');
                return false;
            }

            //付款成功,交易完成
            if ((status == 2 || (status == 5 && oldstatus!=2)) && oldstatus!=0) {
                $('.order-complete-box').show();
            }
            //订单关闭
            else if (status == 3) {
                $('.order-close-box').show();
            }
            //退款
            if (status ==4 ) {
                $('.order-refund-box').show();
            }


        })



    })
</script>
{/if}