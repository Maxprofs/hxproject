<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>申请提现-<?php echo $webname;?></title>
    <?php echo Model_Supplier::css("style.css,base.css,extend.css",'brokerage');?>
    <?php echo Common::js('jquery.min.js');?>
    <?php echo Common::js('layer/layer.js');?>
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
    <?php echo Request::factory('pc/pub/header')->execute()->body(); ?>
    <?php echo  Stourweb_View::template("pc/brokerage/sidemenu");  ?>
    <div class="main">
        <div class="content-box">
            <div class="frame-box">
                <div class="finance-content">
                    <form id="chkfrm" body_html=HsACXC >
                        <div class="finance-tit"><strong class="bt">申请提现</strong></div>
                        <div class="finance-bloock">
                            <div class="tixian-item">
                                <ul>
                                    <li class="clearfix">
                                        <strong class="item-bt">提现金额：</strong>
                                        <div class="item-nr">
                                            <input type="text" class="default-text w200" name="withdrawamount" id="withdrawamount" data-max="<?php echo $price_arr['allow_price'];?>">
                                            <span class="usable">可提现金额¥<?php echo $price_arr['allow_price'];?></span>
                                            <span class="error-txt" style="display: none">请填写正确的提现金额</span>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                                        <strong class="item-bt">账户类型：</strong>
                                        <div class="item-nr">
                                            <label id="bankcard" class="pay-way">
                                                <input type="radio" value="1" name="proceeds_type" checked="">银行卡</label>
                                            <label id="alipay" class="pay-way">
                                                <input type="radio" value="2" name="proceeds_type">支付宝</label>
                                            <label id="wechat" class="pay-way">
                                                <input type="radio" value="3" name="proceeds_type">微信</label>
                                        </div>
                                    </li>
                                    <li class="clearfix bankcard-msg">
                                        <strong class="item-bt">银行卡号：</strong>
                                        <div class="item-nr">
                                            <input type="text" class="default-text w370" name="bankcardnumber">
                                            <span class="error-txt" style="display: none">请填写银行卡卡号</span>
                                        </div>
                                    </li>
                                    <li class="clearfix bankcard-msg">
                                        <strong class="item-bt">账户名：</strong>
                                        <div class="item-nr">
                                            <input type="text" class="default-text w370" name="bankaccountname">
                                            <span class="error-txt" style="display: none">请填写银行卡账户名</span>
                                        </div>
                                    </li>
                                    <li class="clearfix bankcard-msg">
                                        <strong class="item-bt">开户银行：</strong>
                                        <div class="item-nr">
                                            <input type="text" class="default-text w370" name="bankname">
                                            <span class="error-txt" style="display: none">请填写开户行</span>
                                        </div>
                                    </li>
                                    <li class="clearfix alipay-msg" style="display: none">
                                        <strong class="item-bt">支付宝账号：</strong>
                                        <div class="item-nr">
                                            <input type="text" class="default-text w370" name="alipayaccount">
                                            <span class="error-txt" style="display: none">请填写正确的支付宝账户</span>
                                        </div>
                                    </li>
                                    <li class="clearfix wechat-msg" style="display: none">
                                        <strong class="item-bt">微信账号：</strong>
                                        <div class="item-nr">
                                            <input type="text" class="default-text w370" name="wechataccount">
                                            <span class="error-txt" style="display: none">请填写正确的微信账户</span>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                                        <strong class="item-bt">备注说明：</strong>
                                        <div class="item-nr">
                                            <textarea class="bz-txt" style="resize: none"  name="description"></textarea>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-block clearfix">
                                <a class="tj-btn" href="javascript:;">提交申请</a>
                            </div>
                        </div>
                    </form>
                </div><!-- 申请提现 -->
            </div>
            <?php echo Request::factory("pc/pub/footer")->execute()->body(); ?>
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
            $(".bankcard-msg").hide();
            $(".wechat-msg").hide();
        });
        $("#bankcard").on("click",function(){
            $(".alipay-msg").hide();
            $(".wechat-msg").hide();
            $(".bankcard-msg").show()
        });
        $("#wechat").on("click",function(){
            $(".wechat-msg").show();
            $(".alipay-msg").hide();
            $(".bankcard-msg").hide()
        })
    })
</script>
<script>
    var is_allow = 1;
    $(function () {
        $('.hd-menu a').removeClass('cur');
        $('.hd-menu #brokerage').addClass('cur');
        $('#brokerage_approval').addClass('on');
        $("#withdrawamount").blur(function(){
            var amount = $(this).val();
            amount = Number(amount);
            amount = isNaN(amount) ? 0 : amount;
            $(this).val(amount);
        });
        $('.tj-btn').click(function () {
            if(is_allow==0)
            {
                layer.msg('请勿重复提交',{icon:5,time:1000})
                return false;
            }
            var max = parseFloat($('#withdrawamount').attr('data-max'));
            var amount = parseFloat($('#withdrawamount').val());
            if(amount==0|| amount<0 ||amount>max)
            {
                $('#withdrawamount').parent().find('.error-txt').show();
                return false;
            }
            $('#withdrawamount').parent().find('.error-txt').hide();
            var proceeds_type = $('input[name=proceeds_type]:checked').val();
            if(proceeds_type==1)
            {
                var bankcardnumber = $('input[name=bankcardnumber]').val();
                var bankaccountname = $('input[name=bankaccountname]').val();
                var bankname = $('input[name=bankname]').val();
                if(bankcardnumber=='')
                {
                    $('input[name=bankcardnumber]').parent().find('.error-txt').show();
                    return false;
                }
                else
                {
                    $('input[name=bankcardnumber]').parent().find('.error-txt').hide();
                }
                if(bankaccountname=='')
                {
                    $('input[name=bankaccountname]').parent().find('.error-txt').show();
                    return false;
                }
                else
                {
                    $('input[name=bankaccountname]').parent().find('.error-txt').hide();
                }
                if(bankname=='')
                {
                    $('input[name=bankname]').parent().find('.error-txt').show();
                    return false;
                }
                else
                {
                    $('input[name=bankname]').parent().find('.error-txt').hide();
                }
            }
            else if(proceeds_type==2)
            {
                var alipayaccount = $('input[name=alipayaccount]').val();
                if(alipayaccount=='')
                {
                    $('input[name=alipayaccount]').parent().find('.error-txt').show();
                    return false;
                }
                else
                {
                    $('input[name=alipayaccount]').parent().find('.error-txt').hide();
                }
            }
            else
            {
                var wechataccount = $('input[name=wechataccount]').val();
                if(wechataccount=='')
                {
                    $('input[name=wechataccount]').parent().find('.error-txt').show();
                    return false;
                }
                else
                {
                    $('input[name=wechataccount]').parent().find('.error-txt').hide();
                }
            }
            is_allow = 0 ;
            $.ajax({
                dataType:'json',
                type:'post',
                data:$('#chkfrm').serialize(),
                url:'<?php echo $cmsurl;?>'+'brokerage/ajax_save_approval',
                success:function (data) {
                    if(data.status==1)
                    {
                        $('.st-popup-box').show();
                    }
                    else
                    {
                        layer.msg('保存失败',{icon:5,time:1000})
                    }
                }
            })
        })
        
        $('.closed').click(function () {
           location.reload();
        })
    });
</script>
</body>
</html>
