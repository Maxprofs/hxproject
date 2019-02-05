<!doctype html>
<html>

	<head>
		<meta charset="utf-8">
        {template "pub/varname"}
        {Common::css('base.css,user_new.css',false)}
        {Common::css_plugin('update-add.css','line')}
        {Common::load_skin()}
        {Common::js('jquery.min.js,base.js')}
                <!--引入CSS-->
    {Common::css('res/js/webuploader/webuploader.css',false,false)}
    <!--引入JS-->
    {Common::js('webuploader/webuploader.min.js')}
    <!--引入自定义CSS-->

        <style>

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
        </style>
	</head>

	<body class="bg-f6f6f6">
              <div class="user-line-order-wrap">

						<div class="info-item">
							<div class="condition-item clearfix">
								<div class="text">
                                    {if in_array($info['status'],array(0,1,2,6))}
									 <h3 class="orange">{$info['statusname']}</h3>
                                    {else}
                                     <h3>{$info['statusname']}</h3>
                                    {/if}
									<div class="list clearfix">
										<p>订单编号：{$info['ordersn']}</p>
                                        {if $info['subscription_price']>0}
										<p>应付定金：<em><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['pay_price']}</em></p>
                                        {/if}

									</div>
								</div>
								<div class="btn clearfix">
									{if $info['distributor']!=$mid}
									<!-- 游客订单 -->
	                                    <!--待确认-->
	                                    {if $info['status']==0}
	                                    <a id="cancel-order-Click" class="cancel-btn" href="javascript:void(0)">取消订单</a>

	                                    {/if}
	                                    <!--待付款-->
	                                    {if $info['status']==1}
										 <a id="cancel-order-Click" class="cancel-btn" href="javascript:void(0)">取消订单</a>
										 <a class="pay-btn" href="javascript:void(0)">立即付款</a>
	                                    {/if}
	                                    <!--待消费-->
	                                    {if $info['status']==2}
	                                      <a id="apply-refund-Click" class="refund-btn" href="javascript:void(0)">申请退款</a>
	                                      <a class="confirm-btn" href="javascript:void(0)">确认消费</a>
	                                    {/if}
	                                    <!--已完成-->
	                                    {if $info['status']==5 && $info['ispinlun']=='0'}
	                                      <a class="comment-btn pl-btn" href="javascript:void(0)">立即点评</a>
	                                    {/if}
	                                    <!--待审核-->
	                                    {if $info['status']==6}
	                                    <a id="cancel-refund-Click" class="cancel-refund-btn" href="javascript:void(0)">取消退款</a>
	                                    {/if}
	                                <!-- 游客订单 -->
	                                {else}
	                                <!-- 门市订单和下属游客订单 -->
	                               		<!--待确认-->
	                                    {if $info['status']==0 && $info['dconfirm']==0}
	                                    	{if $info['memberid']==$mid}
	                                    		<a id="cancel-order-Click" class="cancel-btn" href="javascript:void(0)">取消订单</a>
	                                    	{/if}
										{/if}
										{if $info['status']==1 && $info['memberid']==$mid}
											<a id="cancel-order-Click" class="cancel-btn" href="javascript:void(0)">取消订单</a>
											<a class="pay-btn" href="javascript:void(0)">立即付款</a>
										{/if}
										{if $info['status']==2 && $info['memberid']==$mid}
	                                    	<a id="apply-refund-Click" class="refund-btn" href="javascript:void(0)">申请退款</a>
	                                    	<a class="confirm-btn" href="javascript:void(0)">确认消费</a>
										{/if}
										{if $info['status']==5 && $info['ispinlun']=='0' && $info['memberid']==$mid}
											<a class="comment-btn pl-btn" href="javascript:void(0)">立即点评</a>
										{/if}
										{if $info['status']==6 && $info['memberid']==$mid}
										<a id="cancel-refund-Click" class="cancel-refund-btn" href="javascript:void(0)">取消退款</a>
										{/if}
										
									<!-- 门市订单和下属游客订单 -->
	                                {/if}
								</div>
							</div>
						</div>
						{if $info['status']==0 && $info['dconfirm']==0}
	                        {if $info['distributor']==$mid}
								<div class="info-item">
									<div class="ost-item">
										<h3 class="tit">分销商订单处理</h3>
										<div class="list clearfix">
										{if $info['distributor']==$mid}
										<p style="font-size: 14px;">修改订单不得低于：{Currency_Tool::symbol()}<?php 
												$supplier_total_price=Model_Member_Order::order_supplier_total_price($info['ordersn']);
												echo $supplier_total_price.'元';
												$minuscoupon=$supplier_total_price-$info['iscoupon']['cmoney'];
											 ?>
											 (结算金额:{Currency_Tool::symbol()}{$minuscoupon}元)
										</p>
                                        {/if}
										</div>
										<div class="btn clearfix">
											<span id="voucher" class="voucher-item">已付供应订金凭证</span><input class="checkpic" type="hidden" id='voucherpath'>
											<a id="submitclick" class="submit-btn" href="javascript:void(0)">提交订单</a>
											<a id="modifyprice" class="modifybtn" href="javascript:void(0)">修改价格</a>
											<input type="text" id="modify" class="modifyinput" placeholder="不低于{Currency_Tool::symbol()}{$supplier_total_price}元" oninput = "value=value.replace(/[^\d]/g,'')">
										</div>

									</div>
								</div>
							{/if}
						{/if}
						<div class="info-item">
							<div class="order-speed-box">
                                {if  $info['status']<6 && $info['status']!=4 && $info['status']!=3}
                                    <div class="order-speed-step">
                                        <ul class="clearfix">
                                            <li class="step-first cur">
                                                <em></em>
                                                <strong></strong>
                                                <span>{__('提订单')}</span>
                                            </li>
                                            <li class="step-second {if $info['status']>0}cur{elseif $info['status']==0}active{/if}">
                                                <em></em>
                                                <strong></strong>
                                                <span>{__('待确认')}</span>
                                            </li>
                                            <li class="step-third {if $info['status']>1 }cur{elseif $info['status']==1}active{/if}">
                                                <em></em>
                                                <strong></strong>
                                                <span>{__('待付款')}</span>
                                            </li>
                                            <li class="step-fourth {if $info['status']>2}cur{elseif $info['status']==2}active{/if}"  >
                                                <em></em>
                                                <strong></strong>
                                                <span>{__('待消费')}</span>
                                            </li>

                                            <li class="step-fifth {if $info['status']==5}active{/if}" >
                                                <em></em>
                                                <strong></strong>
                                                <span>{__('已完成')}</span>
                                            </li>

                                        </ul>
                                    </div>
                                {elseif $info['status'] == 3}
                                <div class="order-speed-step">
                                    <ul class="clearfix">
                                        <li class="step-first cur">
                                            <em></em>
                                            <strong></strong>
                                            <span>{__('提订单')}</span>
                                        </li>
                                        <li class="step-second cur">
                                            <strong></strong>
                                        </li>
                                        <li class="step-third cur">
                                            <em></em>
                                            <strong></strong>
                                            <span>{__('待付款')}</span>
                                        </li>


                                        <li class="step-fourth cur">
                                            <strong></strong>
                                        </li>
                                        <li class="step-fifth cur active">
                                            <em></em>
                                            <strong></strong>
                                            <span>{__('已关闭')}</span>
                                        </li>
                                    </ul>
                                </div>

                                {else}


                                <div class="order-speed-step">
                                    <ul class="clearfix">
                                        <li class="step-first cur blue">
                                            <em></em>
                                            <strong></strong>
                                            <span>{__('提申请')}</span>
                                        </li>
                                        <li class="step-second cur">
                                            <strong></strong>
                                        </li>
                                        <li class="step-third {if $info['status']==6}active{else} cur blue{/if}">
                                            <em></em>
                                            <strong></strong>
                                            <span>{__('待审核')}</span>
                                        </li>
                                        <li class="step-fourth {if $info['status']==4}cur{/if}">
                                            <strong></strong>
                                        </li>
                                        <li class="step-fifth {if $info['status']==4} cur active{/if}">
                                            <em></em>
                                            <strong></strong>
                                            <span>{__('已退款')}</span>
                                        </li>
                                    </ul>
                                </div>
                                {/if}



								<div class="speed-show-list">
                                    {php $log_list = Model_Member_Order_Log::get_list($info['id']);}
                                    <ul class="info-list" style="height: 52px;">
                                        {loop $log_list $log}
                                        <li><span>{date('Y-m-d H:i:s',$log['addtime'])}</span><span>{$log['description']}</span></li>
                                        {/loop}
                                    </ul>
                                    {if count($log_list)>2}
                                    <div id="more-info" class="more-info down">{__('展开详细进度')}</div>
                                    {/if}
								</div>

							</div>
						</div>
						<!--流程-->

						<div class="info-item">
							<div class="ost-item">
								<h3 class="tit">订单信息</h3>
								<ul class="ost-content">
									<li>
										<span class="hd">预订产品：</span>
										<div class="bd">
											<p class="bt">{$product['title']}</p>
										</div>
									</li>
                                    <li>
                                        <span class="hd">套餐：</span>
                                        <div class="bd">
                                            <p class="bt">{$info['suitname']}</p>
                                        </div>
                                    </li>
									<li>
										<span class="hd">预订方式：</span>
										<div class="bd">
											<p class="ty ty1">{if $info['paytype']==1}全额预订{elseif $info['paytype']==2}定金预订{else}二次确认{/if}</p>
											<p class="ty ty2">
												<label>预订时间：</label>
												{date('Y-m-d:h:i:s',$info['addtime'])}
											</p>
											<p class="ty ty3">
												<label>出发时间：</label>
												{$info['usedate']}
											</p>
										</div>
									</li>
                                    {if $info['contract']}
									<li>
										<span class="hd">旅游合同：</span>
										<div class="bd">

											<a class="download-link" style="cursor: pointer" data-url="{$cmsurl}contract/view/ordersn/{$info['ordersn']}" id="contract_btn" >{$info['contract']['title']}</a>
										</div>
									</li>
                                    {/if}
									<li>
										<span class="hd">价格明细：</span>
										<div class="bd">
											<table class="order-line-table" script_table=8GACXC >
												<thead>
													<tr>
														<th>名称</th>
														<th>会员零售价</th>
														<th>数量</th>
														<th>小计</th>
													</tr>
												</thead>
												<tbody>
                                                {if !empty($info['price']) && !empty($info['dingnum'])}
													<tr>
														<td>成人</td>
														<td><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['price']}</td>
														<td>{$info['dingnum']}</td>
														<td><em class="price"><i class="currency_sy">{Currency_Tool::symbol()}</i>{php echo $info['price'] * $info['dingnum'];}</em></td>
													</tr>
                                                {/if}
                                                {if !empty($info['childprice']) && !empty($info['childnum'])}
													<tr>
														<td>儿童</td>
														<td><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['childprice']}</td>
														<td>{$info['childnum']}</td>
														<td><em class="price"><i class="currency_sy">{Currency_Tool::symbol()}</i>{php echo $info['childprice'] * $info['childnum'];}</em></td>
													</tr>
                                                {/if}
                                                {if !empty($info['oldprice']) && !empty($info['oldnum'])}
													<tr>
														<td>老人</td>
														<td><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['oldprice']}</td>
														<td>{$info['oldnum']}</td>
														<td><em class="price"><i class="currency_sy">{Currency_Tool::symbol()}</i>{php echo $info['oldprice'] * $info['oldnum'];}</em></td>
													</tr>
                                                {/if}
                                                {if !empty($info['roombalance']) && !empty($info['roombalancenum'])}
													<tr>
														<td>单房差</td>
														<td><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['roombalance']}</td>
														<td>1</td>
														<td><em class="price">{Currency_Tool::symbol()}</i>{php echo $info['roombalance'] * $info['roombalancenum'];}</em></td>
													</tr>
                                                {/if}
												</tbody>
											</table>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<!--订单信息-->
						{if $user['bflg']==1}
						<div class="info-item">
							<div class="ost-item">
								<h3 class="tit">下单会员信息</h3>
								<ul class="ost-content">
									<li>
										<div class="contact-list">
											<p class="ty ty1">
												<label>会员账号：</label>
                                                <?php 
													if ($user['mobile']) {
														echo $user['mobile'];
													}else{
														echo $user['email'];
													}
												?>
											</p>
											<p class="ty ty2">
												<label>联系电话：</label>
												{$user['mobile']}
											</p>
										</div>
									</li>
								</ul>
							</div>
						</div>
						{/if}
						<!-- 会员信息 -->
                        {if !empty($additional)}
						<div class="info-item">
							<div class="ost-item">
								<h3 class="tit">附加产品</h3>
								<ul class="ost-content">
									<li>
										<span class="hd">保险产品：</span>
										<div class="bd">
											<table class="order-line-table">
												<thead>
													<tr>
														<th width="34%">产品名称</th>
														<th width="22%">优惠价</th>
														<th width="22%">数量</th>
														<th width="22%">小计</th>
													</tr>
												</thead>
												<tbody>
                                                  {loop $additional $sub}
													<tr>

														<td>{$sub['productname']}</td>
														<td>{Currency_Tool::symbol()}{$sub['price']}</td>
														<td>{$sub['dingnum']}</td>
														<td><em class="price">{Currency_Tool::symbol()}{php echo $sub['dingnum']*$sub['price'];}</em></td>
													</tr>
                                                   {/loop}
												</tbody>
											</table>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<!--附加产品-->
                        {/if}

						<div class="info-item">
							<div class="ost-item">
								<h3 class="tit">联系信息</h3>
								<ul class="ost-content">
									<li>
										<div class="contact-list clearfix">
											<p class="ty ty1">
												<label>姓名：</label>
                                                {$info['linkman']}
											</p>
											<p class="ty ty2">
												<label>手机号码：</label>
                                                {$info['linktel']}
											</p>
                                            {if $info['linkemail']}
											<p class="ty ty3">
												<label>电子邮箱：</label>
                                                {$info['linkemail']}
											</p>
                                            {/if}
										</div>
									</li>
                                    {if $info['remark']}
									<li>
										<span class="hd">预订备注：</span>
										<div class="bd">
											<p>{$info['remark']}</p>
										</div>
									</li>
                                    {/if}
								</ul>
							</div>
						</div>
						<!--联系信息-->
                        {st:member action="order_tourer" orderid="$info['id']" return="tourer"}
                  {if !empty($tourer)}
						<div class="info-item">
							<div class="ost-item">
								<h3 class="tit">旅客信息</h3>
								<ul class="tourist-list">
									{php $num=1;}
                                    {loop $tourer $t}
                                    {php}$t_mobile_secret = substr($t['mobile'], 0, 5).'****'.substr($t['mobile'], 9); {/php}
									<li class="last-li">
										<div class="base-info">
											<label>旅客{$num}</label>
											<span class="off">{$t['tourername']}<i class="ico secret" data-mobile="{$t['mobile']}" data-secret="{$t_mobile_secret}"></i></span>
										</div>
										<div class="more-info clearfix">
											<p>
												<label>手机号码：</label>
                                                <em class="phone">{$t_mobile_secret}</em>
											</p>
											<p>
												<label>性别：</label>
                                                {$t['sex']}
											</p>
											<p>
												<label>证件类型：</label>
                                                {$t['cardtype']}
											</p>
											<p>
												<label>证件号码：</label>
                                                {$t['cardnumber']}
											</p>
										</div>
									</li>
                                    {php $num++;}
                                    {/loop}
								</ul>
							</div>
						</div>
						<!--旅客信息-->
                  {/if}
                  {if !empty($info['iscoupon'])|| !empty($info['usejifen'])||$info['platform_discount']||$info['envelope_price']}
						<div class="info-item">
							<div class="ost-item">
								<h3 class="tit">优惠信息</h3>
								<ul class="ost-content">
                                    {if !empty($info['iscoupon'])}
									<li>
										<span class="hd">优惠券：</span>
										<div class="bd">
											<p>（{$info['iscoupon']['name']}） <em class="price"><i class="currency_sy">-{Currency_Tool::symbol()}</i>{$info['iscoupon']['cmoney']}</em></p>
										</div>
									</li>
                                    {/if}
                                    {if $info['usejifen']}
									<li>
										<span class="hd">积分抵现：</span>
										<div class="bd">
											<p>（使用{$info['jifenbook']}积分抵扣） <em class="price"><i class="currency_sy">-{Currency_Tool::symbol()}</i>{$info['jifentprice']}</em></p>
										</div>
									</li>
                                    {/if}
                                    {if $info['envelope_price']}
                                    <li>
                                        <span class="hd">红包优惠：</span>
                                        <div class="bd">
                                            <p>（红包抵扣） <em class="price"><i class="currency_sy">-{Currency_Tool::symbol()}</i>{$info['envelope_price']}</em></p>
                                        </div>
                                    </li>
                                    {/if}
                                    {if $info['platform_discount']>0}
									<li>
										<span class="hd">平台优惠：</span>
										<div class="bd">
											<p>（平台管理员优惠） <em class="price"><i class="currency_sy">-{Currency_Tool::symbol()}</i>{$info['platform_discount']}</em></p>
										</div>
									</li>
                                    {/if}
								</ul>
							</div>
						</div>
						<!--优惠信息-->
                  {/if}
                  {st:member action="order_bill" orderid="$info['id']" return="bill"}
                  {if !empty($bill)}
                  <div class="info-item">
                      <div class="ost-item">
                          <h3 class="tit">发票信息</h3>
                          <ul class="ost-content">
                              <li>
                                  <span class="hd">发票类型：</span>
                                  <div class="bd">
                                      <p>{if $bill['type']==2}增值专票{else}普通发票{/if}</p>
                                  </div>
                              </li>
                              <li>
                                  <span class="hd">发票金额：</span>
                                  <div class="bd">
                                      <p><em class="price"><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['pay_price']}</em></p>
                                  </div>
                              </li>
                              <li>
                                  <span class="hd">发票明细：</span>
                                  <div class="bd">
                                      <p>{$bill['content']}</p>
                                  </div>
                              </li>
                              <li>
                                  <span class="hd">发票抬头：</span>
                                  <div class="bd">
                                      <p>{$bill['title']}</p>
                                  </div>
                              </li>
                              {if !empty($bill['taxpayer_number'])}
                              <li>
                                  <span class="hd">识别号：</span>
                                  <div class="bd">
                                      <p>{$bill['taxpayer_number']}</p>
                                  </div>
                              </li>
                              {/if}
                              {if $bill['type']==2}
                              <li>
                                  <span class="hd">地址：</span>
                                  <div class="bd">
                                      <p>{$bill['taxpayer_address']}</p>
                                  </div>
                              </li>
                              <li>
                                  <span class="hd">联系电话：</span>
                                  <div class="bd">
                                      <p>{$bill['taxpayer_phone']}</p>
                                  </div>
                              </li>
                              <li>
                                  <span class="hd">开户网点：</span>
                                  <div class="bd">
                                      <p>{$bill['bank_branch']}</p>
                                  </div>
                              </li>
                              <li>
                                  <span class="hd">银行账号：</span>
                                  <div class="bd">
                                      <p>{$bill['bank_account']}</p>
                                  </div>
                              </li>
                              {/if}
                              <li>
                                  <span class="hd">收件人：</span>
                                  <div class="bd">
                                      <p>{$bill['receiver']}</p>
                                  </div>
                              </li>
                              <li>
                                  <span class="hd">手机号码：</span>
                                  <div class="bd">
                                      <p>{$bill['mobile']}</p>
                                  </div>
                              </li>
                              {if !empty($bill['postcode'])}
                              <li>
                                  <span class="hd">邮政编码：</span>
                                  <div class="bd">
                                      <p>{$bill['postcode']}</p>
                                  </div>
                              </li>
                              {/if}
                              <li>
                                  <span class="hd">邮寄地址：</span>
                                  <div class="bd">
                                      <p>{$bill['province']} {$bill['city']} {$bill['address']}</p>
                                  </div>
                              </li>
                          </ul>
                      </div>
                  </div>
                  {/if}
                  {if !empty($info['paytime'])}
						<div class="info-item">
							<div class="ost-item">
								<h3 class="tit">支付信息</h3>
								<ul class="ost-content">
									<li>
										<span class="hd">支付方式：</span>
										<div class="bd">
											<p>
                                                {if !empty($info['online_transaction_no'])}
                                                线上支付
                                                {else}
                                                线下支付
                                                {/if}

                                               </p>
										</div>
									</li>
									<li>
										<span class="hd">支付渠道：</span>
										<div class="bd">
											<p>{$info['paysource']}</p>
										</div>
									</li>
                                    {if !empty($info['online_transaction_no'])}
                                    {php}
                                    $trade = json_decode($info['online_transaction_no'],true);

                                    {/php}
									<li>
										<span class="hd">流水号：</span>
										<div class="bd">
											<p>{$trade['transaction_no']}</p>
										</div>
									</li>
                                    {/if}
									<li>
										<span class="hd">付款时间：</span>
										<div class="bd">
											<p>{date('Y-m-d H:i:s',$info['paytime'])}</p>
										</div>
									</li>
                                    {if !empty($info['payment_proof'])}
									<li>
										<span class="hd">付款凭证：</span>
										<div class="bd">
											<div class="img yt-img">
												<a href="javascript:;" id="layer-photos-demo">
													<div class="mask"></div>
													<p>查看原图</p>
													<img src="{$info['payment_proof']}" width="150"  alt="" title="" />
												</a>
											</div>
										</div>
									</li>
                                    {/if}

								</ul>
							</div>
						</div>
                  {/if}
                  {if $info['refund']}
						<div class="info-item">
							<div class="ost-item">
								<h3 class="tit">退款信息</h3>
								<ul class="ost-content">
									<li>
										<span class="hd">退款金额：</span>
										<div class="bd">
											<p><em class="price"><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['refund']['refund_fee']}</em></p>
										</div>
									</li>
									<li>
										<span class="hd">退款原因：</span>
										<div class="bd">
											<p>{$info['refund']['refund_reason']}</p>
										</div>
									</li>
									<li>
										<span class="hd">退款方式：</span>
										<div class="bd">
											<p>{if $info['refund']['refund_proof'] && empty($info['refund']['refund_no'])}
                                                线下
                                                {else}
                                                线上
                                                {/if}
                                            </p>
										</div>
									</li>
                                    {if $info['refund']['platform']}
									<li>
										<span class="hd">退款渠道：</span>
										<div class="bd">
											<p>{$info['refund']['platform']}</p>
										</div>
									</li>
                                    {/if}
                                    {if $info['refund']['alipay_account']}
									<li>
										<span class="hd">退款账号：</span>
										<div class="bd">
											<p>{$info['refund']['alipay_account']}</p>
										</div>
									</li>
                                    {/if}
                                    {if $info['refund']['cardholder']}
                                    <li>
                                        <span class="hd">持卡人：</span>
                                        <div class="bd">
                                            <p>{$info['refund']['cardholder']}</p>
                                        </div>
                                    </li>
                                    {/if}
                                    {if $info['refund']['bank']}
                                    <li>
                                        <span class="hd">开户行：</span>
                                        <div class="bd">
                                            <p>{$info['refund']['bank']}</p>
                                        </div>
                                    </li>
                                    {/if}
                                    {if $info['refund']['cardnum']}
                                    <li>
                                        <span class="hd">卡号：</span>
                                        <div class="bd">
                                            <p>{$info['refund']['cardnum']}</p>
                                        </div>
                                    </li>
                                    {/if}
									<li>
										<span class="hd">退款时间：</span>
										<div class="bd">
											<p>{date('Y-m-d H:i:s',$info['refund']['modtime'])}</p>
										</div>
									</li>
                                    {if $info['refund']['refund_proof']}
									<li>
										<span class="hd">退款凭证：</span>
										<div class="bd">
											<div class="img yt-img" >
												<a href="javascript:void(0)" >
													<div class="mask"></div>
													<p>查看原图</p>
													<img  src="{$info['refund']['refund_proof']}" width="150" />
												</a>
											</div>
										</div>
									</li>
                                    {/if}
								</ul>
							</div>
						</div>
						<!--退款信息-->
                  {/if}
                  {if !empty($info['eticketno']) && Product::is_app_install('stourwebcms_app_supplierverifyorder') && $info['status']==2}
						<div class="info-item">
							<div class="ost-item">
								<h3 class="tit">消费码</h3>
								<ul class="ost-content">
									<li>
										<span class="hd">验单码：</span>
										<div class="bd">
											<p>{$info['eticketno']}</p>
										</div>
									</li>
									<li>
										<span class="hd">二维码：</span>
										<div class="bd">
											<div class="code">
												<img src="/res/vendor/qrcode/make.php?param={$info['eticketno']}" alt="" title="" />
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<!--消费码-->
                  {/if}

						<div class="info-item">
							<div class="settlement-info clearfix">
								<div class="total">

                                    {if $info['paytype'] == 1}

									<p class="price">应付总额：<em><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['pay_price']}</em>{if $info['jifenbook']}<span>预订赠送积分{$info['jifenbook']}</span>{/if}</p>
									<p class="calc">（总额<i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['totalprice']} - 优惠{Currency_Tool::symbol()}{$info['privileg_price']} = 应付总额{Currency_Tool::symbol()}{$info['pay_price']}）</p>

                                    {else}
                                    <p class="price">定金支付：<em><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['pay_price']}</em>{if $info['jifenbook']}<span>预订赠送积分{$info['jifenbook']}</span>{/if}</p>
                                    <p class="calc"> ({__('到店支付')} <i class="currency_sy">{Currency_Tool::symbol()}</i>{php}echo $info['totalprice']-$info['payprice']; {/php} + {__('定金支付')} <i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['payprice']})</p>

                                    {/if}

								</div>
								<div class="pay">
                                    {if $info['status']=='1'}
                                    <a class="pay-btn" href="javascript:;">{__('立即付款')}</a>
                                    {/if}

									{if $info['paytype']==2}
									<p>*尾款请通过联系商家转账或到店支付</p>
                                    {/if}
								</div>
							</div>
						</div>
						<!--结算-->

					</div>





{Common::js('layer/layer.js')}
		<script>
            var orderid="{$info['id']}";
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

                                        LayerDlg.msg('{__("order_cancel_ok")}', {icon: 6, time: 1000});
                                        setTimeout(function () {
                                            location.reload()
                                        }, 500);
                                    }
                                    else {
                                        LayerDlg.msg('{__("order_cancel_failure")}', {icon: 5, time: 1000});
                                    }

                                })

                            }
                        }


                    })

                });

                //付款
                $(".pay-btn").click(function(){
                    var locateurl = "{$GLOBALS['cfg_basehost']}/member/index/pay/?ordersn={$info['ordersn']}";
                    top.location.href = locateurl;
                })
                //立即评论
                $(".pl-btn").click(function(){
                    var url = "{$GLOBALS['cfg_basehost']}/member/order/pinlun?ordersn={$info['ordersn']}";
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
		</script>

       {if $info['status'] == 2}
           <script>
            $(function () {
                //申请退款
                $("#apply-refund-Click").on("click", function () {
                    parent.layer.open({
                        type: 2,
                        title: "申请退款",
                        area: ['560px','570px'],
                        content: '{$cmsurl}lines/member/order_refund?ordersn={$info['ordersn']}',
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
                    var ordersn = "{$info['ordersn']}";
                    parent.layer.confirm('确认已经消费?',{icon:3,title:'提示'},function(index){
                        $.post('{$GLOBALS["cfg_basehost"]}/lines/member/ajax_order_consume_confirm', {ordersn:ordersn}, function (result) {
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
                        btn: ['{__("OK")}'],
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
                                btn: ['{__("OK")}'],
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
                                btn: ['{__("OK")}'],
                            });
                            return false;
                        }
                    }
                }
                return true;
            }



            function refund_status(data) {
                $.post('{$GLOBALS["cfg_basehost"]}/lines/member/ajax_order_refund', data, function (result) {
                    parent.layer.open({
                        content: result.message,
                        btn: ['{__("OK")}'],
                        end:function(){
                            window.location.reload();
                        }
                    });
                }, 'json');
            }

        </script>
       {/if}
       {if $info['status']==6}
           <script>
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
                                  refund_status({'ordersn': '{$info['ordersn']}'});
                              }
                          });
                      });
                  });
                  function refund_status(data) {
                      $.post('{$GLOBALS["cfg_basehost"]}/lines/member/ajax_order_refund_back', data, function (result) {
                          parent.layer.open({
                              content: result.message,
                              btn: ['{__("OK")}'],
                              end:function(){
                                  window.location.reload();
                              }
                          });
                      }, 'json');
                  }

              </script>
       	{/if}
		{if $info['status']==0}
			<script>
				$(function() {
					$('#submitclick').click(function(event) {
						/* Act on the event */
						orderid="{$info['id']}";
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
								ordersn="{$info['ordersn']}";
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
			</script>
		{/if}
	</body>

</html>