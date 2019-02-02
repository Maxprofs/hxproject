<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>查看订单</title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('style.css,base.css,order-manage.css,base_new.css');?>
    <?php echo Common::getScript("jquery.validate.js,choose.js");?>
</head>
<body>
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">
            <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow-y: hidden">
       <form method="post" id="frm" name="frm">
        <div class="order-info-container">
            <div class="order-info-bar"><strong class="bt-bar">订单信息</strong><a href="javascript:;" class="btn fr btn-primary radius mt-2 mr-10"  onclick="window.location.reload()">刷新</a></div>
            <div class="order-info-block">
                <ul>
                  <li>
                        <strong class="item-hd">订单号：</strong>
                        <div class="item-bd">
                            <span class="order-num"><?php echo $info['ordersn'];?></span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">预订会员：</strong>
                        <div class="item-bd">
                            <div class="order-num"><?php echo $info['membername'];?></div>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">产品名称：</strong>
                        <div class="item-bd">
                            <div class="order-num"><?php echo $info['productname'];?></div>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">启程日期：</strong>
                        <div class="item-bd">
                            <div class="order-num">
                                <?php echo $info['usedate'];?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">结束日期：</strong>
                        <div class="item-bd">
                            <div class="order-num">
                                <?php echo $info['departdate'];?>
                            </div>
                        </div>
                    </li>
                </ul>
                <table class="user-info-table mt-5">
                    <thead>
                    <tr>
                        <td width="20%">房型</td>
                        <td width="15%">单价</td>
                        <td width="15%">预订人数</td>
                        <td width="15%">预订房间数</td>
                        <td width="15%">总计</td>
                        <td>&nbsp;</td>
                    </tr>
                    </thead>
                    <?php $n=1; if(is_array($sublist)) { foreach($sublist as $sub) { ?>
                    <tr>
                        <td><span class="cor_666"><?php echo $sub['title'];?></span></td>
                        <td><span class="cor_666"><?php echo Currency_Tool::symbol();?>
                                <?php if(in_array($info['status'],array(0,1))) { ?>
                                <input type="text" class="set-text-xh wid_80 mt-4" name="price[<?php echo $sub['id'];?>]"  style="float: none;" value="<?php echo $sub['price'];?>" />
                                <?php } else { ?>
                                   <?php echo $sub['price'];?>
                                <?php } ?>
                            </span>
                        </td>
                        <td>
                            <span class="order-num">
                                <span class="type">
                                <?php echo $sub['peoplenum'];?>
                                </span>
                            </span>
                            <span class="unit">人</span>
                        </td>
                        <td>
                            <span class="order-num">
                                <span class="type">
                                <?php echo $sub['dingnum'];?>
                                </span>
                            </span>
                            <span class="unit">间</span>
                        </td>
                        <td><span class="color_f60 adult_price_total_txt"><?php echo Currency_Tool::symbol();?><?php echo $sub['dingnum']*$sub['price'];?></span></td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php $n++;}unset($n); } ?>
                </table>
            </div>
        </div>
        <!-- 订单信息 -->
        <?php if(!empty($tourers)) { ?>
        <div class="order-info-container">
            <div class="order-info-bar"><strong class="bt-bar">游客信息</strong></div>
            <div class="order-info-block">
                <table class="user-info-table" id="tourer_list">
                    <tr>
                        <td width="32%">游客姓名</td>
                        <td width="22%">证件类型</td>
                        <td width="30%">证件号码</td>
                    </tr>
                    <?php $n=1; if(is_array($tourers)) { foreach($tourers as $r) { ?>
                    <tr>
                       <td><?php echo $r['tourername'];?></td>
                       <td><?php echo $r['cardtype'];?></td>
                       <td><?php echo $r['cardnumber'];?></td>
                    </tr>
                    <?php $n++;}unset($n); } ?>
                </table>
            </div>
        </div>
        <?php } ?>
        <!-- 游客信息 -->
        <div class="order-info-container">
            <div class="order-info-bar"><strong class="bt-bar">联系人信息</strong></div>
            <div class="order-info-block">
                <ul>
                    <li>
                        <strong class="item-hd">联系人姓名：</strong>
                        <div class="item-bd">
                            <span class="order-num"><?php echo $info['linkman'];?></span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">联系人电话：</strong>
                        <div class="item-bd">
                            <span class="order-num"><?php echo $info['linktel'];?></span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">联系人邮箱：</strong>
                        <div class="item-bd">
                            <span class="order-num"><?php echo $info['linkemail'];?></span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">预订说明：</strong>
                        <div class="item-bd">
                            <?php if(in_array($info['status'],array(0,1))) { ?>
                            <textarea  class="default-textarea" name="remark"><?php echo $info['remark'];?></textarea>
                            <?php } else { ?>
                                <span class="order-num">
                               <?php echo $info['remark'];?>
                                </span>
                            <?php } ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 联系人信息 -->
        <?php if(!empty($bill)) { ?>
        <div class="order-info-container">
            <div class="order-info-bar"><strong class="bt-bar">发票信息</strong></div>
            <div class="order-info-block">
                <ul>
                    <li>
                        <strong class="item-hd">发票金额：</strong>
                        <div class="item-bd">
                            <span class="receipt-num pay_total_price "><?php echo Currency_Tool::symbol();?><?php echo $info['payprice'];?></span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">发票明细：</strong>
                        <div class="item-bd">
                            <span class="receipt-type ">旅游费</span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">发票抬头：</strong>
                        <div class="item-bd">
                            <span class="receipt-type"><?php echo $bill['title'];?></span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">收件人姓名：</strong>
                        <div class="item-bd">
                            <span class="receipt-type"><?php echo $bill['receiver'];?></span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">收件人电话：</strong>
                        <div class="item-bd">
                            <span class="receipt-type"><?php echo $bill['mobile'];?></span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">邮寄地址：</strong>
                        <div class="item-bd" id="city">
                            <span class="receipt-type"><?php echo $bill['province'];?> <?php echo $bill['city'];?> <?php echo $bill['address'];?></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <?php } ?>
        <!-- 发票信息 -->
       <?php if($info['usejifen'] || $info['cmoney']) { ?>
       <div class="order-info-container">
            <div class="order-info-bar"><strong class="bt-bar">优惠信息</strong></div>
            <div class="order-info-block">
                <ul>
                    <li>
                        <strong class="item-hd">优惠明细：</strong>
                        <div class="item-bd">
                            <?php if($info['usejifen']) { ?>
                            <span class="pre-tial">积分抵扣<strong class="ml-10 color_f60"><?php echo Currency_Tool::symbol();?><?php echo $info['jifentprice'];?></strong></span>
                            <?php } ?>
                            <?php if($info['cmoney']) { ?>
                            <span class="pre-tial">优惠券抵扣<strong class="ml-10 color_f60"><?php echo Currency_Tool::symbol();?><?php echo $info['cmoney'];?></strong></span>
                            <?php } ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <?php } ?>
        <!-- 优惠信息 -->
           <?php if($info['refund']) { ?>
           <div class="order-info-container">
               <div class="order-info-bar"><strong class="bt-bar">退款信息</strong></div>
               <div class="order-info-block">
                   <ul>
                       <li>
                           <strong class="item-hd">返款方式：</strong>
                           <div class="item-bd">
                               <span class="order-num"><?php echo $info['refund']['platform'];?></span> </div>
                       </li>
                       <?php if($info['refund']['alipay_account']) { ?>
                       <li>
                           <strong class="item-hd">退款账号：</strong>
                           <div class="item-bd">
                               <span class="order-num"><?php echo $info['refund']['alipay_account'];?></span> </div>
                       </li>
                       <?php } ?>
                       <?php if($info['refund']['cardholder']) { ?>
                       <li>
                           <strong class="item-hd">持卡人：</strong>
                           <div class="item-bd">
                               <span class="order-num"><?php echo $info['refund']['cardholder'];?></span> </div>
                       </li>
                       <?php } ?>
                       <?php if($info['refund']['bank']) { ?>
                       <li>
                           <strong class="item-hd">开户行：</strong>
                           <div class="item-bd">
                               <span class="order-num"><?php echo $info['refund']['bank'];?></span> </div>
                       </li>
                       <?php } ?>
                       <?php if($info['refund']['cardnum']) { ?>
                       <li>
                           <strong class="item-hd">银行卡号：</strong>
                           <div class="item-bd">
                               <span class="order-num"><?php echo $info['refund']['cardnum'];?></span> </div>
                       </li>
                       <?php } ?>
                       <li>
                           <strong class="item-hd">退款金额：</strong>
                           <div class="item-bd">
                               <span class="order-num"><?php echo $info['refund']['refund_fee'];?></span> </div>
                       </li>
                       <li>
                           <strong class="item-hd">退款原因：</strong>
                           <div class="item-bd">
                               <span class="order-num"><?php echo $info['refund']['refund_reason'];?></span> </div>
                       </li>
                       <?php if($info['refund']['description']) { ?>
                       <li>
                           <strong class="item-hd">处理结果：</strong>
                           <div class="item-bd">
                               <span class="order-num"><?php echo $info['refund']['description'];?></span> </div>
                       </li>
                       <?php } ?>
                   </ul>
               </div>
           </div>
           <!-- 退款信息 -->
           <?php } ?>
        <div class="order-info-container mb-50">
            <div class="order-info-bar"><strong class="bt-bar">支付信息</strong></div>
            <div class="order-info-block">
                <ul>
                    <li>
                        <strong class="item-hd">支付方式：</strong>
                        <div class="item-bd">
                            <span class="order-num"><?php echo $info['paytype_name'];?>  &nbsp;<?php if($info['paytype']==2) { ?>(<?php echo $info['dingjin'];?>/间)<?php } ?>
</span>
                        </div>
                    </li>
                    <?php if(!empty($info['paysource'])) { ?>
                    <li>
                        <strong class="item-hd">支付来源：</strong>
                        <div class="item-bd">
                            <span class="order-num"><?php echo $info['paysource'];?></span>
                        </div>
                    </li>
                    <?php } ?>
                    <li>
                        <strong class="item-hd">订单状态：</strong>
                        <div class="item-bd" id="status_con">
                            <?php $n=1; if(is_array($orderstatus)) { foreach($orderstatus as $v) { ?>
                            <label class="radio-label mr-30" <?php if($current_status['displayorder']>$v['displayorder'] || ($current_status['status']==4 && $v['status']==5)||(in_array($current_status['status'],array(3,4))&&$current_status['status']!=$v['status'])) { ?> style="color:#999" <?php } ?>
>
                            <input name="status" type="radio" class="checkbox" value="<?php echo $v['status'];?>" <?php if($info['status']==$v['status']) { ?>checked="checked"<?php } ?>
 <?php if($current_status['displayorder']>$v['displayorder'] || ($current_status['status']==4 && $v['status']==5)||(in_array($current_status['status'],array(3,4))&&$current_status['status']!=$v['status'])) { ?>disabled="disabled"<?php } ?>
/><?php echo $v['status_name'];?>
                            </label>
                            <?php $n++;}unset($n); } ?>
                        </div>
                    </li>
                  <!--  <li>
                        <strong class="item-hd">备注说明：</strong>
                        <div class="item-bd">
                            <textarea name="admin_remark" class="default-textarea mt-8" placeholder="管理员备注的一些想要针对订单说明的内容"></textarea>
                        </div>
                    </li>-->
                </ul>
            </div>
        </div>
        <!-- 支付信息 -->
        <div class="order-amount-bar">
            <span class="item">原价合计：<strong class="color_f60 org_total_price"><?php echo Currency_Tool::symbol();?><?php echo $info['totalprice'];?></strong></span>
            <?php if($info['privileg_price']) { ?>
            <span class="item">优惠合计：<strong class="color_f60 privilege_total_price">-<?php echo Currency_Tool::symbol();?><?php echo $info['privileg_price'];?></strong></span>
            <?php } ?>
            <span class="item">应付总额：<strong class="color_f60 pay_total_price"><b><?php echo Currency_Tool::symbol();?><?php echo $info['actual_price'];?></b></strong>
                <?php if($info['paytype']==2) { ?>
                  <span class="price-hint">(到店支付 <?php echo Currency_Tool::symbol();?><?php echo $info['actual_price']-$info['payprice']; ?> + 定金支付 <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['payprice'];?>)
                  </span>
               <?php } ?>
           </span>
            <?php if($info['paytype']==2) { ?>
               <span class="item">
                定金支付：<strong class="color_f60"><b><?php echo Currency_Tool::symbol();?><?php echo $info['payprice'];?></b></strong>
               </span>
            <?php } ?>
            <div class="fr">
                <a class="btn btn-primary size-L radius ml-5 va-m" href="javascript:;" id="btn_save">保存</a>
                <?php if($info['status']==6&&$info['pay_online']==1) { ?>
                <a class="btn btn-warning size-L radius ml-5 va-m" id="refund_back" href="javascript:;">拒绝退款</a>
                <a class="btn btn-success size-L radius ml-5 va-m" id="refund_allow" href="javascript:;">同意退款</a>
                <?php } ?>
            </div>
        </div>
        <!-- 总计价格 -->
        <input type="hidden" id="id" name="id" value="<?php echo $info['id'];?>">
        <input type="hidden" id="typeid" name="typeid" value="<?php echo $typeid;?>">
        </form>
<!--       <div class="opn-btn">-->
<!--           <a class="normal-btn ml-20" id="btn_save" href="javascript:;">保存</a>-->
<!--       </div>-->
        </td>
    </tr>
</table>
<div id="calendar" style="display: none"></div>
<script>
    var oldstatus = "<?php echo $info['status'];?>";
    $(function(){
        $("#btn_save").click(function(){
            var curstatus=$("#status_con input:radio:checked").val();
            if(curstatus!=oldstatus)
            {
                ST.Util.confirmBox("提示", "订单状态有改动，确定保存？", function () {
                     ajax_submit();
                });
            }
            else
            {
                ajax_submit();
            }
        })
        //同意退款
        $('#refund_allow').click(function () {
            ST.Util.confirmBox("退款提示", "退款金额会原路退回，确定同意退款？", function () {
                refund_submit('allow','同意退款');
            });
        });
        //拒绝退款
        $('#refund_back').click(function () {
            ST.Util.confirmBox("拒绝退款", '<div class="pop-refund-back"><span class="hd-item">原因：</span><textarea class="bd-area" id="description"></textarea><div>', function () {
                var description = $("#description", window.parent.document).val();
                refund_submit('back',description);
            });
        })
    })
    function refund_submit(type,description)
    {
        var ordersn = '<?php echo $info['ordersn'];?>';
        $.ajax({
            url : SITEURL+"ship/admin/order/ajax_refund_submit",
            type:'post',
            dataType:'json',
            data:{type:type,ordersn:ordersn,description:description},
            success : function(data)
            {
                if(data.status)
                {
                    ST.Util.showMsg('保存成功!','4',2000);
                    setTimeout(function(){
                        window.location.reload();
                    },1500)
                }
            }
        });
    }
    function ajax_submit()
    {
        $.ajaxform({
            url   :  SITEURL+"ship/admin/order/ajax_save",
            method  :  "POST",
            form  : "#frm",
            dataType:'json',
            success  :  function(data)
            {
                if(data.status)
                {
                    ST.Util.showMsg('保存成功!','4',2000);
                    setTimeout(function(){
                        window.location.reload();
                    },1500)
                }
            }
          })
    }
</script>
</body>
</html>