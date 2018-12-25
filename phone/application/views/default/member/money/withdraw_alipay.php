<div>
		<div class="header_top bar-nav">
	        <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
	        <h1 class="page-title-bar">提现</h1>
	    </div>
	    <!-- 公用顶部 -->
	    <div class="withdrawals-box">
            <form id="widthdraw_frm_alipay" padding_strong=rLRzDt >
	    	<div class="sum">
	    		<strong>提现金额</strong>
	    		<div class="money">
	    			<label>{Currency_Tool::symbol()}</label>
	    			<input type="number" name="amount"  placeholder="0.00" />
	    		</div>
	    		<p>可提现金额：{php echo number_format($member['money']-$member['money_frozen'],2)}</p>
                {if $config['cash_min']==1}
                <p>最少提现金额：{php echo number_format($config['cash_min_num'],2)}</p>
                {/if}
                {if $cash_available_num!=0&&$config['cash_max']==1}
                <p>当月剩余提现次数：{$cash_available_num}</p>
                {/if}
	    	</div>
	    	<div class="list">
	    		<ul>
	    			<li>
	    				<strong class="hd">支付宝账号</strong>
	    				<input type="text" name="bankcardnumber"  placeholder="收款人支付宝账号" />
	    			</li>
	    			<li>
	    				<strong class="hd">真实姓名</strong>
	    				<input type="text" name="bankaccountname" placeholder="收款人姓名" />
	    			</li>
	    			<li>
	    				<strong class="hd">备注说明</strong>
	    				<textarea class="area-txt" name="description" placeholder=""></textarea>
	    			</li>
	    		</ul>
	    	</div>

	    	<div class="btn">
	    		<a href="javascript:void(0)" id="widthdraw_submit_btn_alipay">提交</a>
	    	</div>
              <input type="hidden" name="total" value="{php echo $member['money']-$member['money_frozen']}"/>
            </form>
	    </div>

        <script>
            $(function(){

                $("#widthdraw_submit_btn_alipay").click(function(){

                    var amount=$("#widthdraw_frm_alipay input[name=amount]").val();
                        amount=parseFloat(amount);
                    var total = $("#widthdraw_frm_alipay input[name=total]").val();
                         total=parseFloat(total);
                    var bankcardnumber=$("#widthdraw_frm_alipay input[name=bankcardnumber]").val();
                    var bankaccountname=$("#widthdraw_frm_alipay input[name=bankaccountname]").val();
                    var bankname=$("#widthdraw_frm_alipay input[name=bankname]").val();
                    var description=$("#widthdraw_frm_alipay textarea[name=description]").val();


                    try {
                        if (!amount || amount < 0.1) {
                            throw  "提现金额不能小于0.1";
                        }
                        if(amount>total)
                        {
                            throw "提现金额超过可提现金额";
                        }
                        if(!bankcardnumber)
                        {
                            throw "支付宝账号不能为空";
                        }
                        if(!bankaccountname)
                        {
                            throw "真实姓名不能为空";
                        }


                        $.ajax({
                            url:SITEURL+'member/bag/ajax_withdraw_save',
                            type:'POST', //GET
                            data:{
                                amount:amount,
                                bankcardnumber:bankcardnumber,
                                bankaccountname:bankaccountname,
                                description:description,
                                way:'alipay'
                            },
                            dataType:'json',
                            success:function(data,textStatus,jqXHR){
                                if(data.status)
                                {
                                    $.layer({
                                        type:2,
                                        text:"提交成功,请耐心等待管理员审核",
                                        time:1500

                                    })

                                    setTimeout(function(){

                                            window.history.back();

                                    },1400);


                                }
                                else
                                {
                                    $.layer({
                                        type:2,
                                        text:data.msg,
                                        time:1000
                                    })
                                }
                            }
                        })
                    }catch(e)
                    {
                        $.layer({
                            type:2,
                            text:e,
                            time:1000
                        })
                    }
                });

            })
        </script>
</div>