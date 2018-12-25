<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>申请提现-{$webname}</title>
    {Common::css('style.css,base.css,extend.css')}

    <link type="text/css" rel="stylesheet" href="/plugins/supplier_finance/public/default/pc/css/base.css">
    <link type="text/css" rel="stylesheet" href="/plugins/supplier_finance/public/default/pc/css/style.css">

    {Common::js('jquery.min.js,common.js,slideTabs.js,jquery.upload.js,jquery.validate.min.js')}
    {Common::js('layer/layer.js')}

    <style>
        .error-txt {
            color: #333;
            display: inline-block;
            margin-left: 10px;
            font-size: 14px;
        }

        .error-txt:before {
            content: ' ';
            display: inline-block;
            width: 16px;
            height: 16px;
            vertical-align: middle;
            margin: -3px 5px 0 0;
            background: url(/plugins/supplier/public/default/pc/images/gys-dg-ico.png) no-repeat -52px -83px;
        }
    </style>
</head>
<body>
<div class="page-box">

    {request 'pc/pub/header'}
    {include "pc/pub/sidemenu"}

    <div class="main">
        <div class="content-box">

            <div class="frame-box">
                <div class="finance-content">
                    <form id="chkfrm" html_strong=3fRzDt >
                        <div class="finance-tit"><strong class="bt">申请提现</strong></div>
                        <div class="finance-bloock">
                            <div class="tixian-item">
                                <ul>
                                    <li class="clearfix">
                                        <strong class="item-bt">提现金额：</strong>

                                        <div class="item-nr">
                                            <input type="text" class="default-text w200" name="withdrawamount" id="withdrawamount" data-un-withdraw="{$withdraw_total}">
                                            <span class="usable">可提现金额¥{$withdraw_total}</span>

                                            <span class="error-txt" style="display: none"></span>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                                        <strong class="item-bt">账户类型：</strong>

                                        <div class="item-nr">
                                            <label id="bankcard" class="pay-way">
                                                <input type="radio" value="1" name="proceeds_type" checked="">银行卡</label>
                                            <label id="alipay" class="pay-way">
                                                <input type="radio" value="2" name="proceeds_type">支付宝</label>
                                        </div>
                                    </li>
                                    <li class="clearfix bankcard-msg">
                                        <strong class="item-bt">银行卡号：</strong>

                                        <div class="item-nr">
                                            <input type="text" class="default-text w370" name="bankcardnumber">
                                        </div>
                                    </li>
                                    <li class="clearfix bankcard-msg">
                                        <strong class="item-bt">账户名：</strong>

                                        <div class="item-nr">
                                            <input type="text" class="default-text w370" name="bankaccountname">
                                        </div>
                                    </li>
                                    <li class="clearfix bankcard-msg">
                                        <strong class="item-bt">开户银行：</strong>

                                        <div class="item-nr">
                                            <input type="text" class="default-text w370" name="bankname">
                                        </div>
                                    </li>
                                    <li class="clearfix alipay-msg">
                                        <strong class="item-bt">支付宝账号：</strong>

                                        <div class="item-nr">
                                            <input type="text" class="default-text w370" name="alipayaccount">
                                        </div>
                                    </li>
                                    <li class="clearfix alipay-msg">
                                        <strong class="item-bt">真实姓名：</strong>

                                        <div class="item-nr">
                                            <input type="text" class="default-text w370" name="alipayaccountname">
                                        </div>
                                    </li>
                                    <li class="clearfix">
                                        <strong class="item-bt">备注说明：</strong>

                                        <div class="item-nr">
                                            <textarea class="bz-txt" name="description"></textarea>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-block clearfix">
                                <a class="tj-btn" href="javascript:;">提交申请</a>
                                <a class="cancel-btn" href="javascript:;">取消</a>
                            </div>
                        </div>
                    </form>
                </div><!-- 申请提现 -->
            </div>

            {request "pc/pub/footer"}
        </div>
    </div>
    <!-- 主体内容 -->

</div>
<div class="st-popup-box hide" style="border: 1px solid #dcdcdc;">
    <div class="st-tit"><strong>信息提示</strong><span class="closed"></span></div>
    <div class="st-conbox">
        <div class="txtcon">提现申请提交成功，请等待审核！</div>
        <div class="sure-btn"><a href="javascript:;" class="closed">确 定</a></div>
    </div>
</div>


<script>
    $(function(){
        $("#alipay").on("click",function(){
            $(".alipay-msg").show();
            $(".bankcard-msg").hide()
        });
        $("#bankcard").on("click",function(){
            $(".alipay-msg").hide();
            $(".bankcard-msg").show()
        })
    })
</script>

<script>

    var un_withdraw = $("#withdrawamount").attr("data-un-withdraw");
    un_withdraw = Number(un_withdraw);
    un_withdraw = isNaN(un_withdraw) ? 0 : un_withdraw;

    $(function () {
        $("#nav_drawcash").addClass('on');
        $('#chkfrm').validate({
            rules: {
                withdrawamount: {
                    required: true,
                    number: true,
                    range: [1, un_withdraw]
                }
            },
            messages: {
                withdrawamount: {
                    required: '“提现金额”不能为空',
                    number: '“提现金额”必须为数字',
                    range: '“提现金额”必须在1到'+un_withdraw
                }
            },
            errorElement: "em",
            errorPlacement: function (error, element) {
                var content = $(element).parent().find('.error-txt').html();
                if (content == '') {
                    $(element).parent().find('.error-txt').html('')
                    error.appendTo($(element).parent().find('.error-txt'));
                }
            },
            showErrors: function (errorMap, errorList) {
                if (errorList.length < 1) {
                    $('.error-txt').html('');
                    $('.error-txt').hide();
                } else {
                    $(errorList[0].element).parent().find('.error-txt').show();
                    this.defaultShowErrors();
                }
            }, submitHandler: function (form) {

                var frmdata = $("#chkfrm").serialize();
                $.ajax({
                    type: 'POST',
                    url: SITEURL + 'pc/drawcash/ajax_post_drawcash_apply',
                    data: frmdata,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            /* layer.msg("{__('commit_qualify_ok')}", {
                             icon: 6,
                             time: 1000
                             })*/
                            $('.st-popup-box').show('slow');

                        } else {
                            layer.msg(data.msg, {icon: 5});
                            return false;
                        }
                    }})
            }
        });
        //第一步
        $(".tj-btn").click(function () {
            $("#chkfrm").submit();
        });

        $(".closed").click(function () {
            $('.st-popup-box').hide('slow');
            location.href = "{$cmsurl}pc/drawcash/list";
        })

        //保留两位小数
        $("#withdrawamount").blur(function(){
            var amount = $(this).val();
            amount = Number(amount);
            amount = isNaN(amount) ? 0 : amount;
            if(amount>0)
            {
                amount = xround(amount, 2);
            }
            $(this).val(amount);
        });
    });

    //保留两位小数
    function xround(x, num){
        var v = Math.round(x * Math.pow(10, num)) / Math.pow(10, num);
        if(v%parseInt(v) ==0){
            v = v+".0";
        }
        return  v;
    }
</script>

</body>
</html>
