<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    {template "pub/varname"}
    {Common::css('base.css,user.css')}
    {Common::load_skin()}
    {Common::js('jquery.min.js')}
</head>
<body>
<div class="user-order-box">
    <div class="user-order-box">
        <div class="user-home-box">
            <div class="tabnav">
                <span {if $ordertype=='all'}class="on"{/if} data-type="all">全部订单</span>
                <span {if $ordertype=='unpay'}class="on"{/if} data-type="unpay">未付款订单</span>
                <span {if $ordertype=='uncomment'}class="on"{/if} data-type="uncomment">未点评订单</span>
            </div><!-- 订单切换 -->
            <div class="user-home-order">
                {if !empty($list)}
                <div class="order-list">
                    <table width="100%" border="0" margin_padding=zkOzDt >
                        <tr>
                        <tr>
                            <th width="40%" height="38" bgcolor="#fbfbfb" scope="col">定制信息</th>
                            <th width="20%" height="38" bgcolor="#fbfbfb" scope="col">定制费用</th>
                            <th width="20%" height="38" bgcolor="#fbfbfb" scope="col">状态</th>
                            <th width="20%" height="38" bgcolor="#fbfbfb" scope="col">操作</th>
                        </tr>
                        </tr>
                        {loop $list $row}
                        <tr>
                            <td height="114">
                                <div class="item-dz">
                                    <a class="bt" href="{$cmsurl}member/order/view?ordersn={$row['ordersn']}" target="_blank">目的地：{$row['customize']['dest']} &nbsp;日期：{date('Y-m-d',$row['customize']['starttime'])}出发 &nbsp;出游天数：{$row['customize']['days']}天成人：{$row['customize']['adultnum']}人&nbsp;儿童：{$row['customize']['childnum']}人&nbsp;出发地：{$row['customize']['startplace']}</a>
                                    <p class="num">订单编号：{$row['ordersn']}</p>
                                </div>
                            </td>
                            <td align="center"><span class="price">{$row['price']}</span></td>
                            <td align="center"><span class="dfk">{$row['statusname']}</span></td>
                            <td align="center">

                                {if $row['status']=='1'}
                                <a class="now-fk" target="_top" href="{$cmsurl}member/index/pay?ordersn={$row['ordersn']}">立即付款</a>
                                <a class="order-ck cancel_order"  href="javascript:;" data-orderid="{$row['id']}">取消</a>
                                {/if}
                                <a class="order-ck" target="_top" href="{$cmsurl}member/order/view?ordersn={$row['ordersn']}">查看订单</a>

                            </td>
                        </tr>
                        {/loop}
                    </table>
                    <div class="main_mod_page clear">
                        {$pageinfo}
                    </div><!-- 翻页 -->
                </div>
                {else}
                <div class="order-no-have"><span></span><p>没有查到相关订单信息，<a href="/" target="_blank">去逛逛</a>去哪儿玩吧！</p></div>
                {/if}
            </div><!-- 我的订单 -->
        </div>
    </div><!--所有订单-->
</div>
<script>
    var typeid = "{$typeid}";
    $(function(){
        $(".tabnav span").click(function(){
            var orderType = $(this).attr('data-type');
            var url = SITEURL+'member/order/plugin_list?typeid='+typeid+'&ordertype='+orderType;
            top.location.href = url;
        })

        //取消订单
        var LayerDlg = parent && parent.layer ? parent.layer:layer;
        $(".cancel_order").click(function(){
            var orderid = $(this).attr('data-orderid');
            var url = SITEURL +'customize/member/ajax_order_cancel';
            LayerDlg.confirm('{__("order_cancel_content")}', {
                icon: 3,
                btn: ['{__("Abort")}','{__("OK")}'], //按钮
                btn1:function(){
                    LayerDlg.closeAll();
                },
                btn2:function(){
                    $.getJSON(url,{orderid:orderid},function(data){
                        if(data.status){
                            LayerDlg.msg('{__("order_cancel_ok")}', {icon:6,time:1000});
                            setTimeout(function(){location.reload()},1000);
                        }
                        else{
                            LayerDlg.msg('{__("order_cancel_failure")}', {icon:5,time:1000});
                        }
                    })
                },
                cancel:function(){
                    LayerDlg.closeAll();
                }
            })
        })
    })

</script>
</body>
</html>