<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <title>订单详情-{$webname}</title>
    {Common::css("style.css,base.css")}
    {Common::js("jquery.min.js,common.js")}
    <script src="/res/js/layer/layer.js"></script>
</head>

<body>

	<div class="page-box">

        {request "pub/header"}

        {request "pub/sidemenu"}

    <div class="main">
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
                  	<li><strong>订单总额：</strong><span class="jg">&yen;{$info['total']}</span></li>
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
                              <th width="50%" height="40" scope="col"><span class="l-con">产品名称</span></th>
                              <th width="15%" scope="col">使用日期</th>

                              <th width="10%" scope="col">数量</th>
                              <th width="15%" scope="col">单价</th>
                              <th width="10%" scope="col">总价</th>
                          </tr>
                          <tr>
                              <td height="40"><span class="l-con">{$info['productname']}ddd</span></td>
                              <td>{$info['usedate']}</td>
                              <td>{$info['dingnum']}</td>
                              <td>{$info['price']}</td>
                              <td>&yen;{$info['total']}</td>

                          </tr>
                      </table>
                  </div>
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
                    {/if}
                  </div><!-- 联系人信息 -->


              </div>

              <!--<div class="back-prev"><a class="back-btn" href="#">返回</a></div>-->

            </div><!-- 订单详情 -->
            <!-- 订单确认弹出框 -->
            <div class='ordertext'style="display: none">
                <textarea name="orderReason"  cols="30" rows="10"style="width:490px"placeholder="原因说明非必填"></textarea>
            </div>
          </div>
        </div>
       {request "pub/footer"}
      </div>
    </div><!-- 主体内容 -->

  </div>
<script>
    $(function(){
        $("#nav_spot_order").addClass('on');
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
</script>

</body>
</html>
