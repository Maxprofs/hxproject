<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head> <meta charset="utf-8"/> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('base.css,user_new.css');?> <?php echo Common::load_skin();?> <?php echo Common::js('jquery.min.js,base.js');?> <?php echo Common::js('layer/layer.js',0);?> </head> <body> <div class="user-content-wrap fr" style="overflow:hidden"> <div class="condition-col"> <span class="item-child fl"><?php echo __('订单号');?>：<?php echo $info['ordersn'];?></span> <span class="item-child fl"><?php echo __('订单状态');?>：<?php echo $info['statusname'];?></span> <?php if($info['status']=='1') { ?> <a class="cancel-btn fr" href="javascript:;"><?php echo __('取消订单');?></a> <a class="pay-btn fr" href="javascript:;"><?php echo __('立即付款');?></a> <?php } ?> <?php if($info['status']=='0') { ?> <a class="cancel-btn fr" href="javascript:;"><?php echo __('取消订单');?></a> <?php } ?> <?php if($info['status']==2) { ?> <a id="apply-refund-Click" class="refund-btn fr cursor">申请退款</a> <?php } ?> <?php if($info['status']==6) { ?> <a id="cancel-refund-Click" class="refund-btn fr cursor">取消退款</a> <?php } ?> </div> <!-- 订单状态 --> <div class="order-show-speed"> <?php if($info['status']<6 && $info['status']!=4) { ?> <div class="order-speed-step"> <ul class="clearfix"> <li class="step-first cur"> <em></em> <strong></strong> <span><?php echo __('提交订单');?></span> </li> <li class="step-second <?php if($info['status']>1) { ?>cur<?php } else if($info['status']==1) { ?>active<?php } ?>
"> <em></em> <strong></strong> <span><?php echo __('等待付款');?></span> </li> <?php if($info['status']==3) { ?> <li class="step-third active"> <em></em> <strong></strong> <span><?php echo __('已取消');?></span> </li> <?php } else if($info['status']==4) { ?> <li class="step-third cur"  > <em></em> <strong></strong> <span><?php echo __('等待消费');?></span> </li> <li class="step-fourth active"  > <em></em> <strong></strong> <span><?php echo __('已退款');?></span> </li> <?php } else { ?> <li class="step-third <?php if($info['status']>2) { ?>cur<?php } else if($info['status']==2) { ?>active<?php } ?>
"  > <em></em> <strong></strong> <span><?php echo __('等待消费');?></span> </li> <li class="step-fourth <?php if($info['status']==5 && $info['ispinlun']!=1) { ?>active<?php } else if($info['status']==5) { ?>cur<?php } ?>
"> <em></em> <strong></strong> <span><?php echo __('等待评价');?></span> </li> <li class="step-fifth <?php if($info['status']==5 && $info['ispinlun']==1) { ?>active<?php } ?>
" > <em></em> <strong></strong> <span><?php echo __('交易完成');?></span> </li> <?php } ?> </ul> </div> <?php } else { ?> <div class="order-speed-step"> <ul class="clearfix"> <li class="step-first cur blue"> <em></em> <strong></strong> <span><?php echo __('申请退款');?></span> </li> <li class="step-second cur"> <strong></strong> </li> <li class="step-third <?php if($info['status']==6) { ?>active<?php } else { ?> cur blue<?php } ?>
"> <em></em> <strong></strong> <span><?php echo __('退款确认');?></span> </li> <li class="step-fourth <?php if($info['status']==4) { ?>cur<?php } ?>
"> <strong></strong> </li> <li class="step-fifth <?php if($info['status']==4) { ?> cur active<?php } ?>
"> <em></em> <strong></strong> <span><?php echo __('已退款');?></span> </li> </ul> </div> <?php } ?> <div class="speed-show-list"> <?php $log_list = Model_Member_Order_Log::get_list($info['id']);?> <ul class="info-list" style="height: 52px;"> <?php $n=1; if(is_array($log_list)) { foreach($log_list as $log) { ?> <li><span><?php echo date('Y-m-d H:i:s',$log['addtime']);?></span><span><?php echo $log['description'];?></span></li> <?php $n++;}unset($n); } ?> </ul> <?php if(count($log_list)>2) { ?> <div id="more-info" class="more-info down"><?php echo __('展开详细进度');?></div> <?php } ?> </div> </div> <!-- 订单进度 --> <div class="os-term"> <div class="os-tit"><?php echo __('联系人信息');?></div> <div class="os-block"> <div class="linkman-info clearfix"> <div class="item-block"> <em><?php echo __('联系人');?>：</em> <p><?php echo $info['linkman'];?></p> </div> <div class="item-block"> <em><?php echo __('手机号');?>：</em> <p><?php echo $info['linktel'];?></p> </div> <div class="item-block"> <em><?php echo __('邮箱');?>：</em> <p><?php echo $info['linkemail'];?></p> </div> <?php if(!empty($info['remark'])) { ?> <div class="item-block bz"> <em><?php echo __('备注');?>：</em> <p><?php echo $info['remark'];?></p> </div> <?php } ?> </div> </div> </div> <?php require_once ("E:/wamp64/www/taglib/member.php");$member_tag = new Taglib_Member();if (method_exists($member_tag, 'order_bill')) {$bill = $member_tag->order_bill(array('action'=>'order_bill','orderid'=>$info['id'],'return'=>'bill',));}?> <?php if(!empty($bill)) { ?> <div class="os-term"> <div class="os-tit"><?php echo __('发票信息');?></div> <div class="os-block"> <div class="order-show-invoice"> <ul> <li><em><?php echo __('发票明细');?>：</em><?php echo __('旅游费');?></li> <li><em><?php echo __('发票金额');?>：</em><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['payprice'];?></li> <li><em><?php echo __('发票抬头');?>：</em><?php echo $bill['title'];?></li> <li><em><?php echo __('收件人');?>：</em><?php echo $bill['receiver'];?></li> <li><em><?php echo __('联系电话');?>：</em><?php echo $bill['mobile'];?></li> <li><em><?php echo __('收货地址');?>：</em><?php echo $bill['province'];?> <?php echo $bill['city'];?> <?php echo $bill['address'];?></li> </ul> </div> </div> </div> <?php } ?> <!-- 发票信息 --> <?php if(!empty($info['iscoupon'])|| !empty($info['usejifen'])) { ?> <div class="os-term"> <div class="os-tit"><?php echo __('优惠信息');?></div> <div class="os-block"> <div class="order-show-cheap"> <ul> <?php if(!empty($info['iscoupon'])) { ?> <li><em><?php echo __('优惠券');?>：</em><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['iscoupon']['cmoney'];?>（<?php echo $info['iscoupon']['name'];?>）</li> <?php } ?> <?php if($info['usejifen']) { ?> <li><em><?php echo __('积分抵现');?>：</em><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['jifentprice'];?></li> <?php } ?> </ul> </div> </div> </div> <?php } ?> <!-- 优惠信息 --> <div class="os-term"> <div class="os-tit"><?php echo __('支付信息');?></div> <div class="os-block"> <div class="order-show-cheap"> <ul> <li><em><?php echo __('支付方式');?>：</em><?php echo $info['paytype_name'];?> &nbsp;<?php if($info['paytype']==2) { ?>(<?php echo $info['dingjin'];?>/<?php echo __('人');?>)<?php } ?> </li> <?php if($GLOBALS['cfg_order_agreement_open']==1&&!empty($GLOBALS['cfg_order_agreement_title'])) { ?> <li><em><?php echo __('预定协议');?>：</em><span class="check-ht" id="agreement_btn">《<?php echo $GLOBALS['cfg_order_agreement_title'];?>》</span></li> <?php } ?> </ul> </div> </div> </div> <?php if($info['refund']) { ?> <div class="os-term"> <div class="os-tit">退款信息</div> <div class="os-block"> <div class="order-show-cheap"> <ul> <li><em>返款方式：</em><?php echo $info['refund']['platform'];?></li> <?php if($info['refund']['alipay_account']) { ?> <li><em>退款账号：</em><?php echo $info['refund']['alipay_account'];?></li> <?php } ?> <?php if($info['refund']['cardholder']) { ?> <li><em>持卡人：</em><?php echo $info['refund']['cardholder'];?></li> <?php } ?> <?php if($info['refund']['bank']) { ?> <li><em>开户行：</em><?php echo $info['refund']['bank'];?></li> <?php } ?> <?php if($info['refund']['cardnum']) { ?> <li><em>银行卡号：</em><?php echo $info['refund']['cardnum'];?></li> <?php } ?> <li><em>退款金额：</em><?php echo $info['refund']['refund_fee'];?></li> <li style="height: auto;"><em>退款原因：</em><?php echo $info['refund']['refund_reason'];?></li> <?php if($info['refund']['description']) { ?> <li><em>处理结果：</em><?php echo $info['refund']['description'];?></li> <?php } ?> </ul> </div> </div> </div> <?php } ?> <!-- 支付信息 --> <?php if(!empty($info['eticketno']) && Product::is_app_install('stourwebcms_app_supplierverifyorder')) { ?> <div class="os-term"> <div class="os-tit"><?php echo __('消费码');?></div> <div class="os-block"> <div class="order-show-code"> <p class="txt"><em><?php echo __('短信消费码');?>：</em><?php echo $info['eticketno'];?></p> <div class="pic"><img src="/res/vendor/qrcode/make.php?param=<?php echo $info['eticketno'];?>"></div> </div> </div> </div> <?php } ?> <!-- 消费码 --> <div class="os-term"> <div class="os-tit"><?php echo __('订单信息');?></div> <div class="os-block"> <div class="order-show-info"> <table width="100%" border="0" class="order-show-table" div_head=KZzCXC > <tr> <th width="39%" height="40" scope="col"><span class="l-con"><?php echo __('产品名称');?></span></th> <th width="15%" scope="col"><?php echo __('使用日期');?></th> <th width="11%" scope="col"><?php echo __('单价');?></th> <th width="11%" scope="col"><?php echo __('人数');?></th> <th width="11%" scope="col"><?php echo __('总价');?></th> </tr> <?php if(!empty($info['price']) && !empty($info['dingnum'])) { ?> <tr> <td height="40"><span class="l-con"><?php echo $info['productname'];?></span></td> <td><?php echo $info['usedate'];?></td> <td><?php echo $info['price'];?></td> <td><?php echo $info['dingnum'];?></td> <td><span class="jg"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['price'] * $info['dingnum'];?></span></td> </tr> <?php } ?> </table> </div> </div> </div> <!-- 订单信息 --> <div class="order-item-count clearfix"> <div class="item-nr"> <div class="item-list"><strong class="hd"><?php echo __('商品总额');?>：</strong><span class="jg"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['totalprice'];?></span></div> <div class="item-list"><strong class="hd"><?php echo __('商品优惠');?>：</strong><span class="jg">-<?php echo Currency_Tool::symbol();?><?php echo $info['privileg_price'];?></span></div> <hr> <div class="item-total"><strong class="hd"><?php echo __('应付总额');?>：</strong><span class="jg"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['actual_price'];?></span></div> <?php if($info['paytype']==2) { ?> <div class="item-way">(<?php echo __('到店支付');?> <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['actual_price']-$info['payprice']; ?> + <?php echo __('定金支付');?> <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['payprice'];?>)</div> <?php } ?> </div> </div> <div class="condition-col"> <span class="item-child"><?php if($info['paytype']==2) { ?><?php echo __('定金支付');?><?php } else { ?><?php echo __('应付总额');?><?php } ?>
：<strong class="jg"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['payprice'];?></strong></span> <?php if($info['status']=='1') { ?> <a class="pay-btn fr" href="javascript:;"><?php echo __('立即付款');?></a> <?php } ?> <?php if($info['status']==5 && $info['ispinlun']!=1) { ?> <a class="pl-btn fr" href="javascript:;"><?php echo __('立即评论');?></a> <?php } ?> </div> <!-- 支付结算 --> </div> <div class="agreement-term-content" style="display: none;"> <div class="agreement-term-tit"><strong><?php echo $GLOBALS['cfg_order_agreement_title'];?></strong><i class="close-ico" onclick="$(this).parents('.agreement-term-content').hide();"></i></div> <div class="agreement-term-block"> <h3 class="agreement-bt">《<?php echo $GLOBALS['cfg_order_agreement_title'];?>》</h3> <div class="agreement-nr"> <?php echo $GLOBALS['cfg_order_agreement'];?> </div> </div> </div> <script>
    var orderid="<?php echo $info['id'];?>";
    $(document).ready(function(){
        //订单详细进度
        $("#more-info").on("click",function(){
            if( $(this).hasClass("down") )
            {
                $(this).addClass("up").removeClass("down").text("<?php echo __('收起详细进度');?>");
                $(this).prev().css("height","auto");
            }
            else
            {
                $(this).addClass("down").removeClass("up").text("<?php echo __('查看详细进度');?>");
                $(this).prev().css("height","64px");
            }
            parent.ReFrameHeight();
        })
        //付款
        $(".pay-btn").click(function(){
            var locateurl = "<?php echo $GLOBALS['cfg_basehost'];?>/member/index/pay/?ordersn=<?php echo $info['ordersn'];?>";
            top.location.href = locateurl;
        })
        //显示协议
        $("#agreement_btn").click(function(){
            $(".agreement-term-content").show();
            adjust_agreement_pos();
        });
        $(window.parent).scroll(function(){
            adjust_agreement_pos();
        });
        //取消订单
        $(".cancel-btn").click(function(){
            var LayerDlg = parent && parent.layer ? parent.layer:layer;
            var url = SITEURL +'visa/member/ajax_order_cancel';
            LayerDlg.confirm('<?php echo __("order_cancel_content");?>', {
                icon: 3,
                btn: ['<?php echo __("Abort");?>','<?php echo __("OK");?>'], //按钮
                btn1:function(){
                    LayerDlg.closeAll();
                },
                btn2:function(){
                    $.getJSON(url,{orderid:orderid},function(data){
                        if(data.status){
                            LayerDlg.msg('<?php echo __("order_cancel_ok");?>', {icon:6,time:1000});
                            setTimeout(function(){location.reload()},1000);
                        }
                        else{
                            LayerDlg.msg('<?php echo __("order_cancel_failure");?>', {icon:5,time:1000});
                        }
                    })
                },
                cancel:function(){
                    LayerDlg.closeAll();
                }
            })
        });
        //立即评论
        $(".pl-btn").click(function(){
            var url = "<?php echo $GLOBALS['cfg_basehost'];?>/member/order/pinlun?ordersn=<?php echo $info['ordersn'];?>";
            top.location.href = url;
        })
    })
    function adjust_agreement_pos()
    {
        var top = $(window.parent).scrollTop();
        var w_height=$(window).height();
        if(top+550>w_height)
        {
            top= w_height-550;
        }
        $(".agreement-term-content").css({top:top,'margin':'0px 0 0 -400px'});
    }
</script> <?php if($info['status']==2) { ?> <script>
    $(function () {
        //申请退款
        $("#apply-refund-Click").on("click", function () {
            parent.layer.open({
                type: 2,
                title: "申请退款",
                area: ['560px','570px'],
                content: '<?php echo $cmsurl;?>visa/member/order_refund?ordersn=<?php echo $info['ordersn'];?>',
                btn: ['确认', '取消'],
                btnAlign: 'C',
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
                btn: ['<?php echo __("OK");?>'],
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
                        btn: ['<?php echo __("OK");?>'],
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
                        btn: ['<?php echo __("OK");?>'],
                    });
                    return false;
                }
            }
        }
        return true;
    }
    function refund_status(data) {
        $.post('<?php echo $GLOBALS["cfg_basehost"];?>/visa/member/ajax_order_refund', data, function (result) {
            parent.layer.open({
                content: result.message,
                btn: ['<?php echo __("OK");?>'],
                end:function(){
                    window.location.reload();
                }
            });
        }, 'json');
    }
</script> <?php } ?> <?php if($info['status']==6) { ?> <script>
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
                    refund_status({'ordersn': '<?php echo $info['ordersn'];?>'});
                }
            });
        });
    });
    function refund_status(data) {
        $.post('<?php echo $GLOBALS["cfg_basehost"];?>/visa/member/ajax_order_refund_back', data, function (result) {
            parent.layer.open({
                content: result.message,
                btn: ['<?php echo __("OK");?>'],
                end:function(){
                    window.location.reload();
                }
            });
        }, 'json');
    }
</script> <?php } ?> </body> </html>