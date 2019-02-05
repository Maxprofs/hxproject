<!doctype html> <html> <head> <meta charset="utf-8"> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('base.css,user_new.css',false);?> <?php echo Common::css_plugin('update-add.css','line');?> <?php echo Common::load_skin();?> <?php echo Common::js('jquery.min.js,base.js');?> <!--引入CSS--> <?php echo Common::css('res/js/webuploader/webuploader.css',false,false);?> <!--引入JS--> <?php echo Common::js('webuploader/webuploader.min.js');?> <!--引入自定义CSS--> <style>
        .submit-btn {
    background: #fb4734;
    color: #fff;
    border: 1px solid #fb4734;
    float: right;
    margin: 7px 0 0 12px;
    width: 98px;
    height: 34px;
    text-align: center;
    line-height: 34px;
    border-radius: 5px;
    font-size: 14px;
}
.modifyinput{
border: 1px solid #000;
    float: right;
    margin: 7px 0 0 12px;
    width: 150px;
    height: 34px;
    text-align: center;
    line-height: 34px;
    font-size: 14px;
    display: none;
}
.modifybtn{
    float: right;
    margin: 7px 0 0 12px;
    width: 98px;
    height: 34px;
    text-align: center;
    line-height: 34px;
    border-radius: 5px;
    font-size: 14px;
    border: 1px solid #ffb84d;
    background: #ffb84d;
    color: #fff;
}
        .checkpic{
    position: relative;
    top: -12px;
    text-decoration: none;
    margin-left: 5px;
    font-size: 14px;
    border-radius: 4px;
    border-style: solid;
    background-color: #2577e3;
    line-height: 16px;
    height: 30px;
    padding: 8px 10px;
    color: #fff;
        }
        .voucher-item{
    float: right;
    margin-left: 10px;
    position: relative;
    top: 7px;
    height: 30px;
    line-height: 16px;
    border-radius: 4px;
    font-size: 14px;
        }
        </style> </head> <body class="bg-f6f6f6"> <div class="user-line-order-wrap"> <div class="info-item"> <div class="condition-item clearfix"> <div class="text"> <?php if(in_array($info['status'],array(0,1,2,6))) { ?> <h3 class="orange"><?php echo $info['statusname'];?></h3> <?php } else { ?> <h3><?php echo $info['statusname'];?></h3> <?php } ?> <div class="list clearfix"> <p>订单编号：<?php echo $info['ordersn'];?></p> <?php if($info['subscription_price']>0) { ?> <p>应付定金：<em><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['pay_price'];?></em></p> <?php } ?> </div> </div> <div class="btn clearfix"> <?php if($info['distributor']!=$mid) { ?> <!-- 游客订单 --> <!--待确认--> <?php if($info['status']==0) { ?> <a id="cancel-order-Click" class="cancel-btn" href="javascript:void(0)">取消订单</a> <?php } ?> <!--待付款--> <?php if($info['status']==1) { ?> <a id="cancel-order-Click" class="cancel-btn" href="javascript:void(0)">取消订单</a> <a class="pay-btn" href="javascript:void(0)">立即付款</a> <?php } ?> <!--待消费--> <?php if($info['status']==2) { ?> <a id="apply-refund-Click" class="refund-btn" href="javascript:void(0)">申请退款</a> <a class="confirm-btn" href="javascript:void(0)">确认消费</a> <?php } ?> <!--已完成--> <?php if($info['status']==5 && $info['ispinlun']=='0') { ?> <a class="comment-btn pl-btn" href="javascript:void(0)">立即点评</a> <?php } ?> <!--待审核--> <?php if($info['status']==6) { ?> <a id="cancel-refund-Click" class="cancel-refund-btn" href="javascript:void(0)">取消退款</a> <?php } ?> <!-- 游客订单 --> <?php } else { ?> <!-- 门市订单和下属游客订单 --> <!--待确认--> <?php if($info['status']==0 && $info['dconfirm']==0) { ?> <?php if($info['memberid']==$mid) { ?> <a id="cancel-order-Click" class="cancel-btn" href="javascript:void(0)">取消订单</a> <?php } ?> <?php } ?> <?php if($info['status']==1 && $info['memberid']==$mid) { ?> <a id="cancel-order-Click" class="cancel-btn" href="javascript:void(0)">取消订单</a> <a class="pay-btn" href="javascript:void(0)">立即付款</a> <?php } ?> <?php if($info['status']==2 && $info['memberid']==$mid) { ?> <a id="apply-refund-Click" class="refund-btn" href="javascript:void(0)">申请退款</a> <a class="confirm-btn" href="javascript:void(0)">确认消费</a> <?php } ?> <?php if($info['status']==5 && $info['ispinlun']=='0' && $info['memberid']==$mid) { ?> <a class="comment-btn pl-btn" href="javascript:void(0)">立即点评</a> <?php } ?> <?php if($info['status']==6 && $info['memberid']==$mid) { ?> <a id="cancel-refund-Click" class="cancel-refund-btn" href="javascript:void(0)">取消退款</a> <?php } ?> <!-- 门市订单和下属游客订单 --> <?php } ?> </div> </div> </div> <?php if($info['status']==0 && $info['dconfirm']==0) { ?> <?php if($info['distributor']==$mid) { ?> <div class="info-item"> <div class="ost-item"> <h3 class="tit">分销商订单处理</h3> <div class="list clearfix"> <?php if($info['distributor']==$mid) { ?> <p style="font-size: 14px;">修改订单不得低于：<?php echo Currency_Tool::symbol();?><?php 
$supplier_total_price=Model_Member_Order::order_supplier_total_price($info['ordersn']);
echo $supplier_total_price.'元';
$minuscoupon=$supplier_total_price-$info['iscoupon']['cmoney'];
 ?>
 (结算金额:<?php echo Currency_Tool::symbol();?><?php echo $minuscoupon;?>元)
</p> <?php } ?> </div> <div class="btn clearfix"> <span id="voucher" class="voucher-item">已付供应订金凭证</span><input class="checkpic" type="hidden" id='voucherpath'> <a id="submitclick" class="submit-btn" href="javascript:void(0)">提交订单</a> <a id="modifyprice" class="modifybtn" href="javascript:void(0)">修改价格</a> <input type="text" id="modify" class="modifyinput" placeholder="不低于<?php echo Currency_Tool::symbol();?><?php echo $supplier_total_price;?>元" oninput = "value=value.replace(/[^\d]/g,'')"> </div> </div> </div> <?php } ?> <?php } ?> <div class="info-item"> <div class="order-speed-box"> <?php if($info['status']<6 && $info['status']!=4 && $info['status']!=3) { ?> <div class="order-speed-step"> <ul class="clearfix"> <li class="step-first cur"> <em></em> <strong></strong> <span><?php echo __('提订单');?></span> </li> <li class="step-second <?php if($info['status']>0) { ?>cur<?php } else if($info['status']==0) { ?>active<?php } ?>
"> <em></em> <strong></strong> <span><?php echo __('待确认');?></span> </li> <li class="step-third <?php if($info['status']>1 ) { ?>cur<?php } else if($info['status']==1) { ?>active<?php } ?>
"> <em></em> <strong></strong> <span><?php echo __('待付款');?></span> </li> <li class="step-fourth <?php if($info['status']>2) { ?>cur<?php } else if($info['status']==2) { ?>active<?php } ?>
"  > <em></em> <strong></strong> <span><?php echo __('待消费');?></span> </li> <li class="step-fifth <?php if($info['status']==5) { ?>active<?php } ?>
" > <em></em> <strong></strong> <span><?php echo __('已完成');?></span> </li> </ul> </div> <?php } else if($info['status'] == 3) { ?> <div class="order-speed-step"> <ul class="clearfix"> <li class="step-first cur"> <em></em> <strong></strong> <span><?php echo __('提订单');?></span> </li> <li class="step-second cur"> <strong></strong> </li> <li class="step-third cur"> <em></em> <strong></strong> <span><?php echo __('待付款');?></span> </li> <li class="step-fourth cur"> <strong></strong> </li> <li class="step-fifth cur active"> <em></em> <strong></strong> <span><?php echo __('已关闭');?></span> </li> </ul> </div> <?php } else { ?> <div class="order-speed-step"> <ul class="clearfix"> <li class="step-first cur blue"> <em></em> <strong></strong> <span><?php echo __('提申请');?></span> </li> <li class="step-second cur"> <strong></strong> </li> <li class="step-third <?php if($info['status']==6) { ?>active<?php } else { ?> cur blue<?php } ?>
"> <em></em> <strong></strong> <span><?php echo __('待审核');?></span> </li> <li class="step-fourth <?php if($info['status']==4) { ?>cur<?php } ?>
"> <strong></strong> </li> <li class="step-fifth <?php if($info['status']==4) { ?> cur active<?php } ?>
"> <em></em> <strong></strong> <span><?php echo __('已退款');?></span> </li> </ul> </div> <?php } ?> <div class="speed-show-list"> <?php $log_list = Model_Member_Order_Log::get_list($info['id']);?> <ul class="info-list" style="height: 52px;"> <?php $n=1; if(is_array($log_list)) { foreach($log_list as $log) { ?> <li><span><?php echo date('Y-m-d H:i:s',$log['addtime']);?></span><span><?php echo $log['description'];?></span></li> <?php $n++;}unset($n); } ?> </ul> <?php if(count($log_list)>2) { ?> <div id="more-info" class="more-info down"><?php echo __('展开详细进度');?></div> <?php } ?> </div> </div> </div> <!--流程--> <div class="info-item"> <div class="ost-item"> <h3 class="tit">订单信息</h3> <ul class="ost-content"> <li> <span class="hd">预订产品：</span> <div class="bd"> <p class="bt"><?php echo $product['title'];?></p> </div> </li> <li> <span class="hd">套餐：</span> <div class="bd"> <p class="bt"><?php echo $info['suitname'];?></p> </div> </li> <li> <span class="hd">预订方式：</span> <div class="bd"> <p class="ty ty1"><?php if($info['paytype']==1) { ?>全额预订<?php } else if($info['paytype']==2) { ?>定金预订<?php } else { ?>二次确认<?php } ?> </p> <p class="ty ty2"> <label>预订时间：</label> <?php echo date('Y-m-d:h:i:s',$info['addtime']);?> </p> <p class="ty ty3"> <label>出发时间：</label> <?php echo $info['usedate'];?> </p> </div> </li> <?php if($info['contract']) { ?> <li> <span class="hd">旅游合同：</span> <div class="bd"> <a class="download-link" style="cursor: pointer" data-url="<?php echo $cmsurl;?>contract/view/ordersn/<?php echo $info['ordersn'];?>" id="contract_btn" ><?php echo $info['contract']['title'];?></a> </div> </li> <?php } ?> <li> <span class="hd">价格明细：</span> <div class="bd"> <table class="order-line-table" script_table=8GACXC > <thead> <tr> <th>名称</th> <th>会员零售价</th> <th>数量</th> <th>小计</th> </tr> </thead> <tbody> <?php if(!empty($info['price']) && !empty($info['dingnum'])) { ?> <tr> <td>成人</td> <td><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['price'];?></td> <td><?php echo $info['dingnum'];?></td> <td><em class="price"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['price'] * $info['dingnum'];?></em></td> </tr> <?php } ?> <?php if(!empty($info['childprice']) && !empty($info['childnum'])) { ?> <tr> <td>儿童</td> <td><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['childprice'];?></td> <td><?php echo $info['childnum'];?></td> <td><em class="price"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['childprice'] * $info['childnum'];?></em></td> </tr> <?php } ?> <?php if(!empty($info['oldprice']) && !empty($info['oldnum'])) { ?> <tr> <td>老人</td> <td><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['oldprice'];?></td> <td><?php echo $info['oldnum'];?></td> <td><em class="price"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['oldprice'] * $info['oldnum'];?></em></td> </tr> <?php } ?> <?php if(!empty($info['roombalance']) && !empty($info['roombalancenum'])) { ?> <tr> <td>单房差</td> <td><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['roombalance'];?></td> <td>1</td> <td><em class="price"><?php echo Currency_Tool::symbol();?></i><?php echo $info['roombalance'] * $info['roombalancenum'];?></em></td> </tr> <?php } ?> </tbody> </table> </div> </li> </ul> </div> </div> <!--订单信息--> <?php if($user['bflg']==1) { ?> <div class="info-item"> <div class="ost-item"> <h3 class="tit">下单会员信息</h3> <ul class="ost-content"> <li> <div class="contact-list"> <p class="ty ty1"> <label>会员账号：</label> <?php 
if ($user['mobile']) {
echo $user['mobile'];
}else{
echo $user['email'];
}
?> </p> <p class="ty ty2"> <label>联系电话：</label> <?php echo $user['mobile'];?> </p> </div> </li> </ul> </div> </div> <?php } ?> <!-- 会员信息 --> <?php if(!empty($additional)) { ?> <div class="info-item"> <div class="ost-item"> <h3 class="tit">附加产品</h3> <ul class="ost-content"> <li> <span class="hd">保险产品：</span> <div class="bd"> <table class="order-line-table"> <thead> <tr> <th width="34%">产品名称</th> <th width="22%">优惠价</th> <th width="22%">数量</th> <th width="22%">小计</th> </tr> </thead> <tbody> <?php $n=1; if(is_array($additional)) { foreach($additional as $sub) { ?> <tr> <td><?php echo $sub['productname'];?></td> <td><?php echo Currency_Tool::symbol();?><?php echo $sub['price'];?></td> <td><?php echo $sub['dingnum'];?></td> <td><em class="price"><?php echo Currency_Tool::symbol();?><?php echo $sub['dingnum']*$sub['price'];?></em></td> </tr> <?php $n++;}unset($n); } ?> </tbody> </table> </div> </li> </ul> </div> </div> <!--附加产品--> <?php } ?> <div class="info-item"> <div class="ost-item"> <h3 class="tit">联系信息</h3> <ul class="ost-content"> <li> <div class="contact-list clearfix"> <p class="ty ty1"> <label>姓名：</label> <?php echo $info['linkman'];?> </p> <p class="ty ty2"> <label>手机号码：</label> <?php echo $info['linktel'];?> </p> <?php if($info['linkemail']) { ?> <p class="ty ty3"> <label>电子邮箱：</label> <?php echo $info['linkemail'];?> </p> <?php } ?> </div> </li> <?php if($info['remark']) { ?> <li> <span class="hd">预订备注：</span> <div class="bd"> <p><?php echo $info['remark'];?></p> </div> </li> <?php } ?> </ul> </div> </div> <!--联系信息--> <?php require_once ("E:/wamp64/www/taglib/member.php");$member_tag = new Taglib_Member();if (method_exists($member_tag, 'order_tourer')) {$tourer = $member_tag->order_tourer(array('action'=>'order_tourer','orderid'=>$info['id'],'return'=>'tourer',));}?> <?php if(!empty($tourer)) { ?> <div class="info-item"> <div class="ost-item"> <h3 class="tit">旅客信息</h3> <ul class="tourist-list"> <?php $num=1;?> <?php $n=1; if(is_array($tourer)) { foreach($tourer as $t) { ?> <?php $t_mobile_secret = substr($t['mobile'], 0, 5).'****'.substr($t['mobile'], 9); ?> <li class="last-li"> <div class="base-info"> <label>旅客<?php echo $num;?></label> <span class="off"><?php echo $t['tourername'];?><i class="ico secret" data-mobile="<?php echo $t['mobile'];?>" data-secret="<?php echo $t_mobile_secret;?>"></i></span> </div> <div class="more-info clearfix"> <p> <label>手机号码：</label> <em class="phone"><?php echo $t_mobile_secret;?></em> </p> <p> <label>性别：</label> <?php echo $t['sex'];?> </p> <p> <label>证件类型：</label> <?php echo $t['cardtype'];?> </p> <p> <label>证件号码：</label> <?php echo $t['cardnumber'];?> </p> </div> </li> <?php $num++;?> <?php $n++;}unset($n); } ?> </ul> </div> </div> <!--旅客信息--> <?php } ?> <?php if(!empty($info['iscoupon'])|| !empty($info['usejifen'])||$info['platform_discount']||$info['envelope_price']) { ?> <div class="info-item"> <div class="ost-item"> <h3 class="tit">优惠信息</h3> <ul class="ost-content"> <?php if(!empty($info['iscoupon'])) { ?> <li> <span class="hd">优惠券：</span> <div class="bd"> <p>（<?php echo $info['iscoupon']['name'];?>） <em class="price"><i class="currency_sy">-<?php echo Currency_Tool::symbol();?></i><?php echo $info['iscoupon']['cmoney'];?></em></p> </div> </li> <?php } ?> <?php if($info['usejifen']) { ?> <li> <span class="hd">积分抵现：</span> <div class="bd"> <p>（使用<?php echo $info['jifenbook'];?>积分抵扣） <em class="price"><i class="currency_sy">-<?php echo Currency_Tool::symbol();?></i><?php echo $info['jifentprice'];?></em></p> </div> </li> <?php } ?> <?php if($info['envelope_price']) { ?> <li> <span class="hd">红包优惠：</span> <div class="bd"> <p>（红包抵扣） <em class="price"><i class="currency_sy">-<?php echo Currency_Tool::symbol();?></i><?php echo $info['envelope_price'];?></em></p> </div> </li> <?php } ?> <?php if($info['platform_discount']>0) { ?> <li> <span class="hd">平台优惠：</span> <div class="bd"> <p>（平台管理员优惠） <em class="price"><i class="currency_sy">-<?php echo Currency_Tool::symbol();?></i><?php echo $info['platform_discount'];?></em></p> </div> </li> <?php } ?> </ul> </div> </div> <!--优惠信息--> <?php } ?> <?php require_once ("E:/wamp64/www/taglib/member.php");$member_tag = new Taglib_Member();if (method_exists($member_tag, 'order_bill')) {$bill = $member_tag->order_bill(array('action'=>'order_bill','orderid'=>$info['id'],'return'=>'bill',));}?> <?php if(!empty($bill)) { ?> <div class="info-item"> <div class="ost-item"> <h3 class="tit">发票信息</h3> <ul class="ost-content"> <li> <span class="hd">发票类型：</span> <div class="bd"> <p><?php if($bill['type']==2) { ?>增值专票<?php } else { ?>普通发票<?php } ?> </p> </div> </li> <li> <span class="hd">发票金额：</span> <div class="bd"> <p><em class="price"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['pay_price'];?></em></p> </div> </li> <li> <span class="hd">发票明细：</span> <div class="bd"> <p><?php echo $bill['content'];?></p> </div> </li> <li> <span class="hd">发票抬头：</span> <div class="bd"> <p><?php echo $bill['title'];?></p> </div> </li> <?php if(!empty($bill['taxpayer_number'])) { ?> <li> <span class="hd">识别号：</span> <div class="bd"> <p><?php echo $bill['taxpayer_number'];?></p> </div> </li> <?php } ?> <?php if($bill['type']==2) { ?> <li> <span class="hd">地址：</span> <div class="bd"> <p><?php echo $bill['taxpayer_address'];?></p> </div> </li> <li> <span class="hd">联系电话：</span> <div class="bd"> <p><?php echo $bill['taxpayer_phone'];?></p> </div> </li> <li> <span class="hd">开户网点：</span> <div class="bd"> <p><?php echo $bill['bank_branch'];?></p> </div> </li> <li> <span class="hd">银行账号：</span> <div class="bd"> <p><?php echo $bill['bank_account'];?></p> </div> </li> <?php } ?> <li> <span class="hd">收件人：</span> <div class="bd"> <p><?php echo $bill['receiver'];?></p> </div> </li> <li> <span class="hd">手机号码：</span> <div class="bd"> <p><?php echo $bill['mobile'];?></p> </div> </li> <?php if(!empty($bill['postcode'])) { ?> <li> <span class="hd">邮政编码：</span> <div class="bd"> <p><?php echo $bill['postcode'];?></p> </div> </li> <?php } ?> <li> <span class="hd">邮寄地址：</span> <div class="bd"> <p><?php echo $bill['province'];?> <?php echo $bill['city'];?> <?php echo $bill['address'];?></p> </div> </li> </ul> </div> </div> <?php } ?> <?php if(!empty($info['paytime'])) { ?> <div class="info-item"> <div class="ost-item"> <h3 class="tit">支付信息</h3> <ul class="ost-content"> <li> <span class="hd">支付方式：</span> <div class="bd"> <p> <?php if(!empty($info['online_transaction_no'])) { ?>
                                                线上支付
                                                <?php } else { ?>
                                                线下支付
                                                <?php } ?> </p> </div> </li> <li> <span class="hd">支付渠道：</span> <div class="bd"> <p><?php echo $info['paysource'];?></p> </div> </li> <?php if(!empty($info['online_transaction_no'])) { ?> <?php 
                                    $trade = json_decode($info['online_transaction_no'],true);
                                    ?> <li> <span class="hd">流水号：</span> <div class="bd"> <p><?php echo $trade['transaction_no'];?></p> </div> </li> <?php } ?> <li> <span class="hd">付款时间：</span> <div class="bd"> <p><?php echo date('Y-m-d H:i:s',$info['paytime']);?></p> </div> </li> <?php if(!empty($info['payment_proof'])) { ?> <li> <span class="hd">付款凭证：</span> <div class="bd"> <div class="img yt-img"> <a href="javascript:;" id="layer-photos-demo"> <div class="mask"></div> <p>查看原图</p> <img src="<?php echo $info['payment_proof'];?>" width="150"  alt="" title="" /> </a> </div> </div> </li> <?php } ?> </ul> </div> </div> <?php } ?> <?php if($info['refund']) { ?> <div class="info-item"> <div class="ost-item"> <h3 class="tit">退款信息</h3> <ul class="ost-content"> <li> <span class="hd">退款金额：</span> <div class="bd"> <p><em class="price"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['refund']['refund_fee'];?></em></p> </div> </li> <li> <span class="hd">退款原因：</span> <div class="bd"> <p><?php echo $info['refund']['refund_reason'];?></p> </div> </li> <li> <span class="hd">退款方式：</span> <div class="bd"> <p><?php if($info['refund']['refund_proof'] && empty($info['refund']['refund_no'])) { ?>
                                                线下
                                                <?php } else { ?>
                                                线上
                                                <?php } ?> </p> </div> </li> <?php if($info['refund']['platform']) { ?> <li> <span class="hd">退款渠道：</span> <div class="bd"> <p><?php echo $info['refund']['platform'];?></p> </div> </li> <?php } ?> <?php if($info['refund']['alipay_account']) { ?> <li> <span class="hd">退款账号：</span> <div class="bd"> <p><?php echo $info['refund']['alipay_account'];?></p> </div> </li> <?php } ?> <?php if($info['refund']['cardholder']) { ?> <li> <span class="hd">持卡人：</span> <div class="bd"> <p><?php echo $info['refund']['cardholder'];?></p> </div> </li> <?php } ?> <?php if($info['refund']['bank']) { ?> <li> <span class="hd">开户行：</span> <div class="bd"> <p><?php echo $info['refund']['bank'];?></p> </div> </li> <?php } ?> <?php if($info['refund']['cardnum']) { ?> <li> <span class="hd">卡号：</span> <div class="bd"> <p><?php echo $info['refund']['cardnum'];?></p> </div> </li> <?php } ?> <li> <span class="hd">退款时间：</span> <div class="bd"> <p><?php echo date('Y-m-d H:i:s',$info['refund']['modtime']);?></p> </div> </li> <?php if($info['refund']['refund_proof']) { ?> <li> <span class="hd">退款凭证：</span> <div class="bd"> <div class="img yt-img" > <a href="javascript:void(0)" > <div class="mask"></div> <p>查看原图</p> <img  src="<?php echo $info['refund']['refund_proof'];?>" width="150" /> </a> </div> </div> </li> <?php } ?> </ul> </div> </div> <!--退款信息--> <?php } ?> <?php if(!empty($info['eticketno']) && Product::is_app_install('stourwebcms_app_supplierverifyorder') && $info['status']==2) { ?> <div class="info-item"> <div class="ost-item"> <h3 class="tit">消费码</h3> <ul class="ost-content"> <li> <span class="hd">验单码：</span> <div class="bd"> <p><?php echo $info['eticketno'];?></p> </div> </li> <li> <span class="hd">二维码：</span> <div class="bd"> <div class="code"> <img src="/res/vendor/qrcode/make.php?param=<?php echo $info['eticketno'];?>" alt="" title="" /> </div> </div> </li> </ul> </div> </div> <!--消费码--> <?php } ?> <div class="info-item"> <div class="settlement-info clearfix"> <div class="total"> <?php if($info['paytype'] == 1) { ?> <p class="price">应付总额：<em><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['pay_price'];?></em><?php if($info['jifenbook']) { ?><span>预订赠送积分<?php echo $info['jifenbook'];?></span><?php } ?> </p> <p class="calc">（总额<i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['totalprice'];?> - 优惠<?php echo Currency_Tool::symbol();?><?php echo $info['privileg_price'];?> = 应付总额<?php echo Currency_Tool::symbol();?><?php echo $info['pay_price'];?>）</p> <?php } else { ?> <p class="price">定金支付：<em><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['pay_price'];?></em><?php if($info['jifenbook']) { ?><span>预订赠送积分<?php echo $info['jifenbook'];?></span><?php } ?> </p> <p class="calc"> (<?php echo __('到店支付');?> <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['totalprice']-$info['payprice']; ?> + <?php echo __('定金支付');?> <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['payprice'];?>)</p> <?php } ?> </div> <div class="pay"> <?php if($info['status']=='1') { ?> <a class="pay-btn" href="javascript:;"><?php echo __('立即付款');?></a> <?php } ?> <?php if($info['paytype']==2) { ?> <p>*尾款请通过联系商家转账或到店支付</p> <?php } ?> </div> </div> </div> <!--结算--> </div> <?php echo Common::js('layer/layer.js');?> <script>
            var orderid="<?php echo $info['id'];?>";
$(function() {
upload('#voucher')
//订单详细进度
$("#more-info").on("click", function() {
if($(this).hasClass("down")) {
$(this).addClass("up").removeClass("down").text("收起详细进度");
$(this).prev().css("height", "auto");
} else {
$(this).addClass("down").removeClass("up").text("查看详细进度");
$(this).prev().css("height", "64px");
}
                    parent.ReFrameHeight();
});
//手机号显示隐藏
                $('.secret').click(function(){
                    var t_m = $(this).data('mobile');
                    var t_secret = $(this).data('secret');
                    if($(this).parent().hasClass('off')){
                        $(this).parent().removeClass('off').addClass('on');
                        $(this).parents('li').first().find('.phone').html(t_m);
                    }else{
                        $(this).parent().removeClass('on').addClass('off');
                        $(this).parents('li').first().find('.phone').html(t_secret);
                    }
                })
                //合同
                $('#contract_btn').click(function () {
                    var url = $(this).data('url');
                    window.open(url);
                })
                //取消订单
                $(".cancel-btn").on("click", function() {
                    var LayerDlg = parent && parent.layer ? parent.layer:layer;
                    var url = SITEURL +'lines/member/ajax_order_cancel';
                    LayerDlg.open({
                        type: 1,
                        title: "取消订单",
                        area: ['480px', '250px'],
                        content: '<div  id="cancel-order" class="cancel-order"> <textarea class="back-area" id="cancel_reason" name="" placeholder="请填写取消原因，不少于5个字"></textarea></div>',
                        btn: ['确认', '取消'],
                        btnAlign: 'c',
                        closeBtn: 1,
                        yes:function (index, b){
                            var reason = $('#cancel_reason',parent.document).val();
                            if(reason.length==0){
                                LayerDlg.msg('取消原因不能少于5个字');
                                return false;
                            }else {
                                $.getJSON(url, {orderid: orderid}, function (data) {
                                    if (data.status) {
                                        LayerDlg.msg('<?php echo __("order_cancel_ok");?>', {icon: 6, time: 1000});
                                        setTimeout(function () {
                                            location.reload()
                                        }, 500);
                                    }
                                    else {
                                        LayerDlg.msg('<?php echo __("order_cancel_failure");?>', {icon: 5, time: 1000});
                                    }
                                })
                            }
                        }
                    })
                });
                //付款
                $(".pay-btn").click(function(){
                    var locateurl = "<?php echo $GLOBALS['cfg_basehost'];?>/member/index/pay/?ordersn=<?php echo $info['ordersn'];?>";
                    top.location.href = locateurl;
                })
                //立即评论
                $(".pl-btn").click(function(){
                    var url = "<?php echo $GLOBALS['cfg_basehost'];?>/member/order/pinlun?ordersn=<?php echo $info['ordersn'];?>";
                    top.location.href = url;
                })
//图片显示
$(".yt-img").click(function() {
                    var litpic = $(this).find('img').attr('src');
                    var content = "<div style='width: 100%'><img src='"+litpic+"' width='100%' height='100%'></div>";
                    parent.layer.open({
                        type: 1,
                        title: false,
                        area:['800px','600px'],
                        content: content
                    })
                })
});
        //webuploader上传
        function upload(obj) {
            //obj='#imas'jquery对象;
            //正面上传实例
            var uploader = new WebUploader.Uploader({
                // 选完文件后，是否自动上传。
                auto: true,
                // swf文件路径
                swf: '/res/js/webuploader/Uploader.swf',
                // 文件接收服务端。
                server: SITEURL + 'distributor/pc/precash/ajax_upload_voucher',
                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick:obj,
                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                //上传前压缩项
                compress:{
                    width: 1600,
                    height: 1600,
                    // 图片质量。仅仅有type为`image/jpeg`的时候才有效。
                    quality: 90,
                    // 是否同意放大，假设想要生成小图的时候不失真。此选项应该设置为false.
                    allowMagnify: false,
                    // 是否同意裁剪。
                    crop: false,
                    // 是否保留头部meta信息。
                    preserveHeaders: true,
                    // 假设发现压缩后文件大小比原来还大，则使用原来图片
                    // 此属性可能会影响图片自己主动纠正功能
                    noCompressIfLarger: false,
                    // 单位字节，假设图片大小小于此值。不会採用压缩。(大于2M压缩)
                    compressSize: 1024*1024*2
                }
            });
            // 文件上传过程中创建进度条实时显示。
            uploader.on( 'uploadProgress', function( file, percentage ) {
            });
            // 文件上传成功
            uploader.on( 'uploadSuccess', function( file,data) {
                //如果上传成功
                if (data.status) {
                    var html = "<a class='checkpic' onclick='checkpic("+'"'+data.litpic+'"'+")' href='#'>查看</a>";
                    $(obj).append(html);
                    layer.msg(data.msg, {icon: 6});
                    $('#voucherpath').val(data.litpic);
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on( 'uploadComplete', function( file ) {
//                $.layer.close();
            });
        }
        function checkpic(url) {
            window.open(url);
        }
</script> <?php if($info['status'] == 2) { ?> <script>
            $(function () {
                //申请退款
                $("#apply-refund-Click").on("click", function () {
                    parent.layer.open({
                        type: 2,
                        title: "申请退款",
                        area: ['560px','570px'],
                        content: '<?php echo $cmsurl;?>lines/member/order_refund?ordersn=<?php echo $info['ordersn'];?>',
                        btn: ['确认', '取消'],
                        btnAlign: 'c',
                        closeBtn: 0,
                        yes: function (index, b) {
                            var frm = parent.layer.getChildFrame('#refund_frm', index);
                            if(check_refund_frm(frm)==false)
                            {
                                return false;
                            }
                            parent.layer.close(index);
                            var data = $(frm).serialize();
                            refund_status(data);
                        }
                    });
                });
                //确认消费
                $('.confirm-btn').click(function(){
                    var ordersn = "<?php echo $info['ordersn'];?>";
                    parent.layer.confirm('确认已经消费?',{icon:3,title:'提示'},function(index){
                        $.post('<?php echo $GLOBALS["cfg_basehost"];?>/lines/member/ajax_order_consume_confirm', {ordersn:ordersn}, function (result) {
                            if(result.status){
                                parent.layer.msg("操作成功");
                                window.location.reload();
                            }else{
                                parent.layer.msg("操作失败");
                            }
                        }, 'json');
                    })
                })
            });
            /**
             *
             * @param frm_data 表单验证
             */
            function check_refund_frm(frm_data)
            {
                var refund_reason = $(frm_data).find('textarea[name=refund_reason]').val();
                if(refund_reason.replace(/(^\s*)|(\s*$)/g, "").length<5)
                {
                    parent.layer.open({
                        content: '退款原因不能少于五个字',
                        btn: ['<?php echo __("OK");?>'],
                    });
                    return false;
                }
                var refund_auto = $(frm_data).find('input[name=refund_auto]').val();
                var platform = $(frm_data).find('input[name=platform]:checked').val();
                if(refund_auto!=1)
                {
                    if(platform=='alipay')
                    {
                        var alipay_account = $(frm_data).find('input[name=alipay_account]').val();
                        if(alipay_account.replace(/(^\s*)|(\s*$)/g, "").length<5)
                        {
                            parent.layer.open({
                                content: '请填写正确的支付宝账号',
                                btn: ['<?php echo __("OK");?>'],
                            });
                            return false;
                        }
                    }
                    else if(platform=='bank')
                    {
                        var cardholder = $(frm_data).find('input[name=cardholder]').val();
                        var cardnum = $(frm_data).find('input[name=cardnum]').val();
                        var bank = $(frm_data).find('input[name=bank]').val();
                        if(cardholder.length<1||cardnum.length<10||bank.length<2)
                        {
                            parent.layer.open({
                                content: '请填写正确的银行卡信息',
                                btn: ['<?php echo __("OK");?>'],
                            });
                            return false;
                        }
                    }
                }
                return true;
            }
            function refund_status(data) {
                $.post('<?php echo $GLOBALS["cfg_basehost"];?>/lines/member/ajax_order_refund', data, function (result) {
                    parent.layer.open({
                        content: result.message,
                        btn: ['<?php echo __("OK");?>'],
                        end:function(){
                            window.location.reload();
                        }
                    });
                }, 'json');
            }
        </script> <?php } ?> <?php if($info['status']==6) { ?> <script>
                  $(function () {
                      //取消退款
                      $("#cancel-refund-Click").on("click", function () {
                          parent.layer.open({
                              type: 1,
                              title: "取消退款",
                              area: ['480px', '250px'],
                              content: '<div id="cancel-refund" class="cancel-refund"><p>确定取消退款申请？</p></div>',
                              btn: ['确认', '取消'],
                              btnAlign: 'c',
                              closeBtn: 0,
                              yes: function (index, b) {
                                  parent.layer.close(index);
                                  //提交信息
                                  refund_status({'ordersn': '<?php echo $info['ordersn'];?>'});
                              }
                          });
                      });
                  });
                  function refund_status(data) {
                      $.post('<?php echo $GLOBALS["cfg_basehost"];?>/lines/member/ajax_order_refund_back', data, function (result) {
                          parent.layer.open({
                              content: result.message,
                              btn: ['<?php echo __("OK");?>'],
                              end:function(){
                                  window.location.reload();
                              }
                          });
                      }, 'json');
                  }
              </script> <?php } ?> <?php if($info['status']==0) { ?> <script>
$(function() {
$('#submitclick').click(function(event) {
/* Act on the event */
orderid="<?php echo $info['id'];?>";
$.ajax({
url: '/distributor/pc/traveler/ajax_submitorder',
type: 'POST',
dataType: 'json',
data: {orderid:orderid,voucherpath:$('#voucherpath').val()},
})
.done(function(data) {
if (data.status) {
parent.layer.alert('提交成功',{icon:1,time:2000})
}else{
parent.layer.alert('提交失败',{icon:2,time:2000})
}
})

});
$('#modifyprice').click(function(event) {
if ($(this).text()=='修改价格') {
$('.modifyinput').css('display', 'inline-block');
$(this).text('确定修改')
}else{
parent.layer.confirm('确定修改？', {
  btn: ['确定','不了'] //按钮
}, function(){
if ($('.modifyinput').val()=='') {
parent.layer.alert('没有输入');
return;
}
ordersn="<?php echo $info['ordersn'];?>";
  $.ajax({
  url: '/distributor/pc/traveler/ajax_modifyorderprice',
  type: 'POST',
  dataType: 'json',
  data: {price: $('.modifyinput').val(),ordersn:ordersn},
  })
  .done(function(data) {
  if (!data.status) {
  parent.layer.alert(data.msg,{icon:2,time:3000});
  }else{
  parent.layer.alert(data.msg,{icon:1,time:2000});
  window.location.reload();
  }
  
  })
}, function(){
$('.modifyinput').css('display', 'none');
$("#modifyprice").text('修改价格')
});
}
});
});
</script> <?php } ?> </body> </html>