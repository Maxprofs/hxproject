<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <title>订单详情-{$webname}</title>
    {Common::css("style.css,base.css")}
    {Common::js("jquery.min.js")}

</head>

<body>

	<div class="page-box">

        {request 'pc/pub/header'}

        {template 'pc/pub/sidemenu_account'}
    
    <div class="main">
    	<div class="content-box">
            {include "pc/pub/qualifyalert"}
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
                  	<li><strong>订单总额：</strong><span class="jg">&yen;{$info['total']}</span></li>
                  	<li><strong>订单状态：</strong>
                        {if $info['status']==1}
                        <span class="dfk">待付款</span>
                        {elseif $info['status']==0}
                        <span class="dcl">待处理</span>
                        {elseif $info['status']==3}
                        <span class="yqx">已取消</span>
                        {elseif $info['status']==5 && $info['ispinlun']==0}
                        <span class="wdp">未点评</span>
                        {else}
                        <span class="ywc">已完成</span>
                        {/if}
                    </li>
                  </ul>

                </div><!-- 订单信息 -->


                  {template "pc/order/tongyong_detail"}

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
              
              <div class="back-prev"><a class="back-btn" href="javascript:history.go(-1)">返回</a></div>
              
            </div><!-- 订单详情 -->
          
          </div>
        </div>
        
        <div class="st-record">Copyright@2017笛卡CMS</div>
        
      </div>
    </div><!-- 主体内容 -->
  
  </div>

</body>
</html>
