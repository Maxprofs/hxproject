<!doctype html>
<html>
<head font_html=SJACXC >
<meta charset="utf-8">
    <title>订单详情-{$webname}</title>
    {Common::css("style.css,base.css")}
    {Common::js("jquery.min.js,common.js")}
    <script src="/res/js/layer/layer.js"></script>
</head>
<body>
{include "pub"}
    <div class="content-box">

    <div class="frame-box">
        <div class="frame-con">

        <div class="order-box">
          <div class="order-show-tit"><strong class="bt">订单详情</strong></div>
          {if $info['status']==0}
          <div class="pm-btm-box fr queren-btn" style="margin: 0;padding: 0;">
                <a class="pm-gn-btn btn_sure" title="确认订单" href="javascript:;">确认订单</a>
          </div>
          {/if}
          <div class="order-con">

            <div class="order-msg">
            <ul>
                <li ordersn="{$info['ordersn']}"><strong>订单号：</strong>{$info['ordersn']}</li>
                <li><strong>产品名称：</strong>{$info['productname']}</li>
                {if $info['pricetype']}
                <li><strong>套餐名称：</strong>{$info['pricetype']}</li>
                {/if}
                <li><strong>下单时间：</strong>{date('Y-m-d H:i',$info['addtime'])}</li>
                <li><strong>收货地址：</strong>{$info['receiver_address']}</li>
                <li><strong>订单总额：</strong><span class="jg">{Currency_Tool::symbol()}{$info['total_price']}  {if $info['subscription_price']>0}(定金{Currency_Tool::symbol()}{$info['subscription_price']}){/if}</span></li>
                <li><strong>订单收益：</strong><span class="jg">{Currency_Tool::symbol()}{$info['compute_info']['distributor_income']}</span></li>
                <li><strong>平台分佣：</strong><span class="jg">{Currency_Tool::symbol()}{$info['compute_info']['platform_commission']}</span></li>
                <li class="orderstatus"><strong>订单状态：</strong>
                    {if $info['status']==1}
                        <span class="dfk">{$info['order_status']}</span>
                        {elseif $info['status']==0}
                        <span class="dcl">{$info['order_status']}</span>
                        {elseif $info['status']==3}
                        <span class="yqx">{$info['order_status']}</span>
                        {elseif $info['status']==5 && $info['ispinlun']==0}
                        <span class="wdp">{$info['order_status']}</span>
                        {else}
                        <span class="ywc">{$info['order_status']}</span>
                    {/if}
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
                      {if !empty($info['price']) && !empty($info['dingnum'])}
                      <tr>
                          <td height="38">{$info['pricetype']}</td>
                          <td>成人</td>
                          <td>{$info['usedate']}</td>
                          <td>{$info['price']}</td>
                          <td>{$info['dingnum']}</td>
                          <td>&yen;{php}echo intval($info['price']) * intval($info['dingnum']);{/php}</td>
                      </tr>
                      {/if}
                      {if !empty($info['childprice']) && !empty($info['childnum'])}
                      <tr>
                          <td height="38">{$info['pricetype']}</td>
                          <td>儿童</td>
                          <td>{$info['usedate']}</td>
                          <td>{$info['childprice']}</td>
                          <td>{$info['childnum']}</td>
                          <td>&yen;{php}echo intval($info['childprice']) * intval($info['childnum']);{/php}</td>

                      </tr>
                      {/if}
                      {if !empty($info['oldprice']) && !empty($info['oldnum'])}
                      <tr>
                          <td height="38"><span class="l-con">{$info['pricetype']}</span></td>
                          <td>老人</td>
                          <td>{$info['usedate']}</td>
                          <td>{$info['oldprice']}</td>
                          <td>{$info['oldnum']}</td>
                          <td>&yen;{php}echo intval($info['oldprice']) * intval($info['oldnum']);{/php}</td>

                      </tr>
                      {/if}
                  </table>
              </div>
            {if $info['status']!=0}
              <div class="order-item">
                  <div class="os-tit">游客信息</div>
                  <table class="user-msg-table" width="100%" border="0">
                      <tr>
                          <th width="20%" height="38" scope="col">姓名</th>
                          <th width="20%" scope="col">手机号</th>
                          <th scope="col">证件号</th>
                      </tr>
                      {loop $info['tourer'] $t}
                      <tr>
                          <td height="38"><span class="l-con">{$t['tourername']}</span></td>
                          <td>{$t['mobile']}</td>
                          <td>{$t['cardnumber']}<span class="people-id">（{$t['cardtype']})</td>

                      </tr>
                      {/loop}

                  </table>
              </div>
            {/if}

              {if !empty($info['roombalancenum'])}
              <div class="order-item">
                  <div class="os-tit">单房差</div>
                  <div class="item-con">
                      <ul class="nr">
                          <li>购买数量： {$info['roombalancenum']}</li>
                          <li>支付方式：
                              {if $info['roombalance_paytype']==1}
                              预付
                              {else}
                              到店付
                              {/if}</li>
                          <li>金额：&yen;{$info['roombalance']}</li>
                      </ul>
                  </div>
              </div><!-- 单房差 -->
              {/if}
              {if !empty($info['insurance'])}
              <div class="order-item">
                  <div class="os-tit">保险方案</div>
                  <div class="item-con">
                      {loop $info['insurance'] $ins}
                      <ul class="nr">
                          <li>{$ins['productname']}</li>
                          <li>数量：{$ins['insurednum']}</li>
                          <li>金额：&yen;{$ins['payprice']}</li>
                      </ul>
                      {/loop}
                  </div>
              </div><!-- 保险方案 -->
              {/if}
              {if $info['status']!=0} 
              {if !empty($info['bill'])}
              <div class="order-item">
                  <div class="os-tit">发票信息</div>
                  <div class="item-con">
                      <ul class="receipt">
                          <li>联系人: {$info['bill']['receiver']}</li>
                          <li>联系电话: {$info['bill']['mobile']}</li>
                          <li>发票抬头：{$info['bill']['title']}</li>
                          <li>发票明细：{$info['bill']['receiver']}</li>
                          <li>配送地址：{$info['bill']['address']}</li>
                      </ul>
                  </div>
              </div>
              {/if}
              {/if}
            {if $info['status']!=0} 
              <div class="order-item">
                  <div class="os-tit">联系人信息</div>
                  <div class="item-con">
                      <ul class="nr">
                          <li>姓名：{$info['linkman']}</li>
                          <li>手机号码：{$info['linktel']}</li>
                          <li>电子邮箱：{$info['linkemail']}</li>
                      </ul>
                      {if !empty($info['remark'])}
                      <div class="remarks">订单留言：{$info['remark']}</div>
                      {/if}
                  </div>
              </div><!-- 联系人信息 -->
            {/if}

          </div>

         <!-- <div class="back-prev"><a class="back-btn" href="javascript:;">返回</a></div>-->

        </div><!-- 订单详情 -->
        <div class='ordertext'style="display: none">
            <textarea name="orderReason"  cols="30" rows="10"style="width:490px"placeholder="原因说明非必填"></textarea>
        </div>

      </div>
    </div>
   {include "footer"}
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
