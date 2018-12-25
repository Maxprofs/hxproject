<!-- 待消费,已完成 -->
<div class="order-complete-box order-box" style="display: none">
    <ul class="info-item-block">
        <li>
            <span class="item-hd">支付方式：</span>
            <div class="item-bd">
                <span class="item-text">线下支付</span>
            </div>
        </li>
        <li>
            <span class="item-hd">支付渠道：</span>
            <div class="item-bd">
                            <span class="select-box w200">
                                <select name="paysource" class="select">
                                    <option value="微信">微信</option>
                                    <option value="支付宝">支付宝</option>
                                    <option value="银行卡">银行卡</option>
                                </select>
                            </span>
            </div>
        </li>
        <li>
            <span class="item-hd">付款凭证{Common::get_help_icon('payment_proof')}：</span>
            <div class="item-bd">
                <div class="mt-3">
                    <a href="javascript:;" id="payment_upload_proof" class="btn btn-primary radius size-S">上传凭证</a>
                    <input type="hidden" name="payment_proof" id="payment_proof" value="" />
                    <span class="item-text c-999 ml-10"></span>
                </div>
                <div class="mt-15 payment_img">
                    <a href="" rel="lightbox">
                        <img  src="" class="up-img-area payment_proof_img" />
                    </a>
                </div>
            </div>
        </li>
    </ul>
</div>
<script>
    $(function(){



        $('#payment_upload_proof').click(function(){
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
                            $('#payment_proof').val(info.bigpic);
                            $('.payment_proof_img').attr('src',info.bigpic);
                            $('.payment_proof_img').parent().attr('href',info.bigpic);
                            $('.payment_img').show();



                        }

                }
            });
        })
    })
</script>