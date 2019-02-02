<!--订单中心用的js事件--> <script>
    $(function(){
        //取消订单
        $(".cancel_order").click(function(){
            var orderid = $(this).attr('data-orderid');
            var url = SITEURL +'member/order/ajax_order_cancel';
            layer.confirm('<?php echo __("order_cancel_content");?>', {
                icon: 3,
                btn: ['<?php echo __("Abort");?>','<?php echo __("OK");?>'], //按钮
                btn1:function(){
                    layer.closeAll();
                },
                btn2:function(){
                    $.getJSON(url,{orderid:orderid},function(data){
                        if(data.status){
                            layer.msg('<?php echo __("order_cancel_ok");?>', {icon:6,time:1000});
                            setTimeout(function(){location.reload()},1000);
                        }
                        else{
                            layer.msg('<?php echo __("order_cancel_failure");?>', {icon:5,time:1000});
                        }
                    })
                },
                cancel:function(){
                    layer.closeAll();
                }
        })
    })
 })
</script>