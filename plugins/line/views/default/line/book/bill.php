{if $GLOBALS['cfg_bill_open']==1}
<div class="booking-info-block">
    <div class="bib-hd-bar">
        <span class="col-title">发票信息</span>
        <div class="bib-radio-box" style=" margin-left: 40px">
            <span class="bib-radio-label active" data-needpiao="0"><i class="radio-icon"></i>不需要发票</span>
            <span class="bib-radio-label" data-needpiao="1"><i class="radio-icon"></i>需要发票</span>
        </div>
        <span class="c-999">（支付金额为0，无开票金额，不能申请开具发票）</span>
    </div>
    <div class="bib-bd-wrap" id="bill-detail" style="display:none">
        <div class="clearfix">
            <ul class="booking-item-block">
                <li>
                    <span class="item-hd">发票金额：</span>
                    <div class="item-bd">
                        <span class="b-item-text pay-total-price"></span>
                    </div>
                </li>
                <li>
                    <span class="item-hd">发票明细：</span>
                    <div class="item-bd">
                        <span class="b-item-text">旅游费</span>
                    </div>
                </li>
                <li>
                    <span class="item-hd"><i class="st-star-ico">*</i>发票抬头：</span>
                    <div class="item-bd">
                        <input type="text" class="input-text w300" name="bill_title" value="" placeholder="请填写个人姓名或公司名称">
                    </div>
                </li>
                <li>
                    <span class="item-hd"><i class="st-star-ico">*</i>收件人：</span>
                    <div class="item-bd">
                        <input type="text" class="input-text w300" name="bill_receiver" value="" placeholder="">
                    </div>
                </li>
                <li>
                    <span class="item-hd"><i class="st-star-ico">*</i>手机号码：</span>
                    <div class="item-bd">
                        <input type="text" class="input-text w300" name="bill_phone" value="" placeholder="">
                    </div>
                </li>
                <li>
                    <span class="item-hd"><i class="st-star-ico">*</i>邮寄地址：</span>
                    <div class="item-bd" id="city">
                        <select name="bill_prov" class="select w120 prov">
                            <option value="请选择">{__('请选择')}</option>
                        </select>
                        <select name="bill_city" class="select w120 city">
                            <option value="请选择">{__('请选择')}</option>
                        </select>
                        <textarea class="text-area mt10" name="bill_address" placeholder="请填写详细收货地址"></textarea>
                        <div class="c-999 mt10">发票将于您出游归来后5个工作日内开具并由快递寄出，请注意查收</div>
                    </div>

                </li>
            </ul>
        </div>
    </div>
</div>
<!--隐藏域-->
<input type="hidden" id="isneedbill" name="isneedbill" value="0">
<!-- 发票信息 -->
{Common::js('city/jquery.cityselect.js',0)}
<script>
    $(function(){
        //是否需要发票
        $(".bib-radio-box span").click(function(){
            $(this).addClass('active').siblings().removeClass('active');
            var v = parseInt($(this).attr('data-needpiao'));
            if(v==1){

                $('#isneedbill').val(1);
                $("input[name='bill_title']").rules("add",{ required: true, messages: { required: "{__('请填写发票抬头')}"} });
                $("input[name='bill_receiver']").rules("add",{ required: true, messages: { required: "{__('请填写收件人')}"} });
                $("input[name='bill_phone']").rules("add",{ required:true,isPhone: true, messages: {required:"{__('请填写手机号码')}"}});
                $("textarea[name='bill_address']").rules("add",{ required: true, messages: { required: ""} });
                $('#bill-detail').show();


            }else{

                $('#isneedbill').val(0);
                $("input[name='bill_title']").rules("remove");
                $("input[name='bill_receiver']").rules("remove");
                $("textarea[name='bill_address']").rules("remove");
                $("input[name='bill_phone']").rules("remove");
                $('#bill-detail').hide();


            }
        })

        $("#city").citySelect({
            nodata:"none",
            required:false
        });
    })
</script>
{/if}