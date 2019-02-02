<!doctype html>
<html>
<head font_html=SJACXC >
<meta charset="utf-8">
    <title>订单详情-<?php echo $webname;?></title>
    <?php echo Common::css("style.css,base.css");?>
    <?php echo Common::js("jquery.min.js,common.js");?>
    <script src="/res/js/layer/layer.js"></script>
</head>
<body>
<?php echo  Stourweb_View::template("pub");  ?>
    <div class="content-box">
    <div class="frame-box">
        <div class="frame-con">
        <div class="order-box">
          <div class="order-show-tit"><strong class="bt">订单详情</strong></div>
          <?php if($info['status']==0) { ?>
          <div class="pm-btm-box fr queren-btn" style="margin: 0;padding: 0;">
                <a class="pm-gn-btn btn_sure" title="确认订单" href="javascript:;">确认订单</a>
          </div>
          <?php } ?>
          <div class="order-con">
            <div class="order-msg">
            <ul>
                <li ordersn="<?php echo $info['ordersn'];?>"><strong>订单号：</strong><?php echo $info['ordersn'];?></li>
                <li><strong>产品名称：</strong><?php echo $info['productname'];?></li>
                <?php if($info['pricetype']) { ?>
                <li><strong>套餐名称：</strong><?php echo $info['pricetype'];?></li>
                <?php } ?>
                <li><strong>下单时间：</strong><?php echo date('Y-m-d H:i',$info['addtime']);?></li>
                <li><strong>收货地址：</strong><?php echo $info['receiver_address'];?></li>
                <li><strong>订单总额：</strong><span class="jg"><?php echo Currency_Tool::symbol();?><?php echo $info['total_price'];?>  <?php if($info['subscription_price']>0) { ?>(定金<?php echo Currency_Tool::symbol();?><?php echo $info['subscription_price'];?>)<?php } ?>
</span></li>
                <li><strong>结算价格：</strong><span class="jg"><?php echo Currency_Tool::symbol();?><?php echo $info['suppliertotalprice'];?></span></li>
                <li><strong>优惠金额：</strong><span class="jg"><?php echo Currency_Tool::symbol();?>-<?php echo $info['compute_info']['privileg_price'];?></span></li>
                <li><strong>订单收益：</strong><span class="jg">结算<?php echo Currency_Tool::symbol();?><?php echo $info['suppliertotalprice'];?>-优惠<?php echo Currency_Tool::symbol();?><?php echo $info['compute_info']['privileg_price'];?>-分佣<?php echo Currency_Tool::symbol();?><?php echo $info['compute_info']['platform_commission'];?>=收益<?php echo Currency_Tool::symbol();?><?php echo $info['compute_info']['supplier_income'];?></span></li>
                <li><strong>平台分佣：</strong><span class="jg"><?php echo Currency_Tool::symbol();?><?php echo $info['compute_info']['platform_commission'];?></span></li>
                <li class="orderstatus"><strong>订单状态：</strong>
                    <?php if($info['status']==1) { ?>
                        <span class="dfk"><?php echo $info['order_status'];?></span>
                        <?php } else if($info['status']==0) { ?>
                        <span class="dcl"><?php echo $info['order_status'];?></span>
                        <?php } else if($info['status']==3) { ?>
                        <span class="yqx"><?php echo $info['order_status'];?></span>
                        <?php } else if($info['status']==5 && $info['ispinlun']==0) { ?>
                        <span class="wdp"><?php echo $info['order_status'];?></span>
                        <?php } else { ?>
                        <span class="ywc"><?php echo $info['order_status'];?></span>
                    <?php } ?>
                </li>
              </ul>
            </div><!-- 订单信息 -->
              <div class="order-item">
                  <table class="order-msg-table" width="100%" border="0">
                      <tr>
                          <th width="30%" height="38" scope="col">套餐</th>
                          <th width="20%" scope="col">类型</th>
                          <th width="20%" scope="col">出行日期</th>
                          <th width="10%" scope="col">单价</th>
                          <th width="10%" scope="col">人数</th>
                          <th width="10%" scope="col">金额</th>
                      </tr>
                      <?php if(!empty($info['price']) && !empty($info['dingnum'])) { ?>
                      <tr>
                          <td height="38"><?php echo $info['pricetype'];?></td>
                          <td>成人</td>
                          <td><?php echo $info['usedate'];?></td>
                          <td><?php echo $info['price'];?></td>
                          <td><?php echo $info['dingnum'];?></td>
                          <td>&yen;<?php echo intval($info['price']) * intval($info['dingnum']);?></td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($info['childprice']) && !empty($info['childnum'])) { ?>
                      <tr>
                          <td height="38"><?php echo $info['pricetype'];?></td>
                          <td>儿童</td>
                          <td><?php echo $info['usedate'];?></td>
                          <td><?php echo $info['childprice'];?></td>
                          <td><?php echo $info['childnum'];?></td>
                          <td>&yen;<?php echo intval($info['childprice']) * intval($info['childnum']);?></td>
                      </tr>
                      <?php } ?>
                      <?php if(!empty($info['oldprice']) && !empty($info['oldnum'])) { ?>
                      <tr>
                          <td height="38"><span class="l-con"><?php echo $info['pricetype'];?></span></td>
                          <td>老人</td>
                          <td><?php echo $info['usedate'];?></td>
                          <td><?php echo $info['oldprice'];?></td>
                          <td><?php echo $info['oldnum'];?></td>
                          <td>&yen;<?php echo intval($info['oldprice']) * intval($info['oldnum']);?></td>
                      </tr>
                      <?php } ?>
                  </table>
              </div>
            <?php if($info['status']!=0) { ?>
              <div class="order-item">
                  <div class="os-tit">游客信息</div>
                  <table class="user-msg-table" width="100%" border="0">
                      <tr>
                          <th width="20%" height="38" scope="col">姓名</th>
                          <th width="20%" scope="col">手机号</th>
                          <th scope="col">证件号</th>
                      </tr>
                      <?php $n=1; if(is_array($info['tourer'])) { foreach($info['tourer'] as $t) { ?>
                      <tr>
                          <td height="38"><span class="l-con"><?php echo $t['tourername'];?></span></td>
                          <td><?php echo $t['mobile'];?></td>
                          <td><?php echo $t['cardnumber'];?><span class="people-id">（<?php echo $t['cardtype'];?>)</td>
                      </tr>
                      <?php $n++;}unset($n); } ?>
                  </table>
              </div>
            <?php } ?>
              <?php if(!empty($info['roombalancenum'])) { ?>
              <div class="order-item">
                  <div class="os-tit">单房差</div>
                  <div class="item-con">
                      <ul class="nr">
                          <li>购买数量： <?php echo $info['roombalancenum'];?></li>
                          <li>支付方式：
                              <?php if($info['roombalance_paytype']==1) { ?>
                              预付
                              <?php } else { ?>
                              到店付
                              <?php } ?>
</li>
                          <li>金额：&yen;<?php echo $info['roombalance'];?></li>
                      </ul>
                  </div>
              </div><!-- 单房差 -->
              <?php } ?>
              <?php if(!empty($info['insurance'])) { ?>
              <div class="order-item">
                  <div class="os-tit">保险方案</div>
                  <div class="item-con">
                      <?php $n=1; if(is_array($info['insurance'])) { foreach($info['insurance'] as $ins) { ?>
                      <ul class="nr">
                          <li><?php echo $ins['productname'];?></li>
                          <li>数量：<?php echo $ins['insurednum'];?></li>
                          <li>金额：&yen;<?php echo $ins['payprice'];?></li>
                      </ul>
                      <?php $n++;}unset($n); } ?>
                  </div>
              </div><!-- 保险方案 -->
              <?php } ?>
              <?php if($info['status']!=0) { ?> 
              <?php if(!empty($info['bill'])) { ?>
              <div class="order-item">
                  <div class="os-tit">发票信息</div>
                  <div class="item-con">
                      <ul class="receipt">
                          <li>联系人: <?php echo $info['bill']['receiver'];?></li>
                          <li>联系电话: <?php echo $info['bill']['mobile'];?></li>
                          <li>发票抬头：<?php echo $info['bill']['title'];?></li>
                          <li>发票明细：<?php echo $info['bill']['receiver'];?></li>
                          <li>配送地址：<?php echo $info['bill']['address'];?></li>
                      </ul>
                  </div>
              </div>
              <?php } ?>
              <?php } ?>
            <?php if($info['status']!=0) { ?> 
              <div class="order-item">
                  <div class="os-tit">联系人信息</div>
                  <div class="item-con">
                      <ul class="nr">
                          <li>姓名：<?php echo $info['linkman'];?></li>
                          <li>手机号码：<?php echo $info['linktel'];?></li>
                          <li>电子邮箱：<?php echo $info['linkemail'];?></li>
                      </ul>
                      <?php if(!empty($info['remark'])) { ?>
                      <div class="remarks">订单留言：<?php echo $info['remark'];?></div>
                      <?php } ?>
                  </div>
              </div><!-- 联系人信息 -->
            <?php } ?>
          </div>
         <!-- <div class="back-prev"><a class="back-btn" href="javascript:;">返回</a></div>-->
        </div><!-- 订单详情 -->
        <div class='ordertext'style="display: none">
            <textarea name="orderReason"  cols="30" rows="10"style="width:490px"placeholder="原因说明非必填"></textarea>
        </div>
      </div>
    </div>
   <?php echo  Stourweb_View::template("footer");  ?>
  </div>
    <!-- 主体内容 -->
<script>
    $(function(){
        $("#nav_hotel_order").addClass('on');
          //确认订单
        $(".btn_sure").click(function(){
            var ordersn = $('.order-msg ul li').eq(0).attr('ordersn');
            layer.open({
                type: 1,
                title: '确认订单',
                area: ['500px','auto'],
                btn: ['库存充足,确认订单','库存不足,关闭订单'],
                btnAlign: 'c',
                content: "<div id ='order-sure-list'>"+$('.ordertext').html()+ '</div>',
                // 确认订单-1
                yes: function(index, layero){
                    // var content = $("#order-sure-list textarea[name='orderReason']").val();
                    $.ajax({
                        type: 'post',
                        url: SITEURL+'/order/ajax_order_status',
                        data: {ordersn:ordersn,status:1},
                        dataType: 'json',
                        success: function (msg) {
                            if (msg.status == true) {
                                layer.alert('库存充足,确认订单');
                                $('.orderstatus span').text('待付款');
                            }
                            $(".queren-btn").hide();
                            layer.close(index);
                        }
                    })
                },
                // 关闭订单 -3
                btn2:function (index,layero){
                    var content = $("#order-sure-list textarea[name='orderReason']").val();
                    $.ajax({
                        type: 'post',
                        url: SITEURL+'/order/ajax_order_status',
                        data: {ordersn:ordersn,status:3,content:content},
                        dataType: 'json',
                        success: function (msg) {
                            if (msg.status == true) {
                                layer.alert('库存不足,关闭订单');
                                $('.orderstatus span').text('已关闭');
                            }
                            $(".queren-btn").hide();
                            layer.close(index);
                        }
                    })
                }
            })
        })
    })
    function change_status(ele,ordersn)
    {
        var status = $(ele).val();
        $.ajax({
            type:'POST',
            data:{ordersn:ordersn,status:status},
            url:SITEURL+'order/ajax_order_status',
            dataType:'json',
            success:function(data){
            }
        })
    }
  
</script>
</body>
</html>
