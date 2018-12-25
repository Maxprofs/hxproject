<!doctype html>
<html>
<head ul_padding=IiPzDt >
<meta charset="utf-8">
    <title>订单详情-{$webname}</title>
    {Common::css("style.css,base.css")}
    {Common::js("jquery.min.js")}

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
              <div class="order-con">
                
                <div class="order-msg">
									<ul>
                  	<li><strong>订单号：</strong>{$info['ordersn']}</li>
                  	<li><strong>产品名称：</strong>{$info['productname']}</li>
                                        {if $info['pricetype']}
                                        <li><strong>套餐名称：</strong>{$info['pricetype']}</li>
                                        {/if}
                  	<li><strong>下单时间：</strong>{date('Y-m-d H:i',$info['addtime'])}</li>
                    <li><strong>收货地址：</strong>{$info['receiver_address']}</li>
                  	<li><strong>订单总额：</strong><span class="jg">&yen;{$info['total']}</span></li>
                  	<li><strong>订单状态：</strong>

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
                              <th width="15%" scope="col">入住日期</th>
                              <th width="15%" scope="col">离店日期</th>
                              <th width="10%" scope="col">房间数量</th>
                              <th width="10%" scope="col">总价</th>
                          </tr>
                          <tr>
                              <td height="40"><span class="l-con">{$info['productname']}</span></td>
                              <td>{$info['usedate']}</td>
                              <td>{$info['departdate']}</td>
                              <td>{$info['dingnum']}</td>
                              <td>&yen;{$info['total']}</td>

                          </tr>
                      </table>
                  </div>


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

                
              </div>
              
              <!--<div class="back-prev"><a class="back-btn" href="#">返回</a></div>-->
              
            </div><!-- 订单详情 -->
          
          </div>
        </div>
       {request "pub/footer"}
      </div>
    </div><!-- 主体内容 -->
  
  </div>
<script>
    $(function(){
        $("#nav_hotel_order").addClass('on');
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
