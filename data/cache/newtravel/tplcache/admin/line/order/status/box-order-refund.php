<!-- 已退款 -->
<div class="order-refund-box order-box" style="display: none">
    <ul class="info-item-block">
        <li>
            <span class="item-hd">退款原因：</span>
            <div class="item-bd">
                <textarea class="text-area w900" name="refund_reason" id="refund_reason" placeholder="请输入退款原因"></textarea>
            </div>
        </li>
        <li>
            <span class="item-hd">退款方式：</span>
            <div class="item-bd">
                <?php if($info['online_transaction_no'] != '') { ?>
                <label class="radio-label mr-30">
                    <input name="refund_type" type="radio" class="checkbox" checked="checked" value="1">线上退款
                </label>
                <label class="radio-label mr-30">
                    <input name="refund_type" type="radio" class="checkbox" value="0">线下退款
                </label>
                <?php } else { ?>
                <input type="hidden" value="0" name="refund_type" />
                <label class="radio-label" >线下退款(非线上支付,只能线下退款)</label>
                <?php } ?>
            </div>
        </li>
        <li>
            <span class="item-hd">退款金额：</span>
            <div class="item-bd">
                <span class="item-text c-f60"><?php echo Currency_Tool::symbol();?><?php echo $info['pay_price'];?></span>
            </div>
        </li>
        <li class="offline_content" <?php if($info['online_transaction_no'] != '') { ?>style="display:none;"<?php } ?>
>
            <span class="item-hd">退款渠道：</span>
            <div class="item-bd">
                <span class="select-box w200">
                    <select name="refund_source" class="select">
                        <option value="wxpay">微信</option>
                        <option value="alipay">支付宝</option>
                        <option value="bank">银行卡</option>
                    </select>
                </span>
            </div>
        </li>
        <li class="offline_content" <?php if($info['online_transaction_no'] != '') { ?>style="display:none;"<?php } ?>
>
            <span class="item-hd">退款凭证<?php echo Common::get_help_icon('refund_proof');?>：</span>
            <div class="item-bd">
                <div class="">
                    <a href="javascript:;" id="refund_upload_proof" class="btn btn-primary radius size-S">上传凭证</a>
                    <input type="hidden" name="refund_proof" id="refund_proof" value="" />
                    <span class="item-text c-999 ml-10"></span>
                </div>
                <div class="mt-15 refund_img" style="display: none">
                    <a href="" rel="lightbox">
                        <img  src="" class="up-img-area refund_proof_img" />
                    </a>
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="order-reject-box order-box" style="display: none">
    <ul class="info-item-block">
        <li>
            <span class="item-hd">拒绝退款原因：</span>
            <div class="item-bd">
                <textarea class="text-area w900" name="reject_refund_reason" placeholder="请输入退款原因"></textarea>
            </div>
        </li>
    </ul>
</div>
<!-- 拒绝退款原因 -->
<script>
    $(function(){
        $("input[name=refund_type]").change(function(){
            if ($(this).val()==1)
            {
                $(".offline_content").hide();
            }
            else
            {
                $(".offline_content").show();
            }
        });
        if ($("input[name=refund_type]").val()==1)
        {
            $(".offline_content").hide();
        }
        else
        {
            $(".offline_content").show();
        }
        $('#refund_upload_proof').click(function(){
            // 上传方法
            $.upload({
                // 上传地址
                url: SITEURL+'uploader/uploadfile',
                // 文件域名字
                fileName: 'Filedata',
                fileType: 'jpg,png,gif',
                // 其他表单数据
                params: {uploadcookie:"<?php echo Cookie::get('username')?>"},
                // 上传完成后, 返回json, text
                dataType: 'json',
                // 上传之前回调,return true表示可继续上传
                onSend: function() {
                    return true;
                },
                // 上传之后回调
                onComplate: function(info) {
                    if(info.success=='true'){
                        $('#refund_proof').val(info.bigpic);
                        $('.refund_proof_img').attr('src',info.bigpic);
                        $('.refund_proof').parent().attr('href',info.bigpic);
                        $('.refund_img').show();
                    }
                }
            });
        })
    })
</script>