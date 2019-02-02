<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head> <meta charset="utf-8"/> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('base.css,user_new.css');?> <?php echo Common::load_skin();?> <?php echo Common::js('jquery.min.js,base.js,jquery.validate.js,jquery.validate.addcheck.js,city/jquery.cityselect.js');?> <?php echo Common::js('layer/layer.js',0);?> <script src="/tools/js/ajaxform.js"></script> </head> <body> <div class="user-content-wrap fr" style="overflow:hidden"> <div class="condition-col"> <span class="item-child fl"><?php echo __('订单号');?>：<?php echo $info['ordersn'];?></span> <span class="item-child fl"><?php echo __('订单状态');?>：<?php echo $info['statusname'];?></span> <?php if($info['status']=='1') { ?> <a class="cancel-btn fr" href="javascript:;"><?php echo __('取消订单');?></a> <a class="pay-btn fr" href="javascript:;"><?php echo __('立即付款');?></a> <?php } ?> <?php if($info['status']=='0') { ?> <a class="cancel-btn fr" href="javascript:;"><?php echo __('取消订单');?></a> <?php } ?> </div> <!-- 订单状态 --> <div class="order-show-speed"> <div class="order-speed-step"> <ul class="clearfix"> <li class="step-first cur"> <em></em> <strong></strong> <span><?php echo __('提交需求');?></span> </li> <li class="step-second <?php if($info['status']==0) { ?>active<?php } else { ?>cur<?php } ?>
"> <em></em> <strong></strong> <span><?php echo __('客服处理中');?></span> </li> <?php if($info['status']==3) { ?> <li class="step-third active"  > <em></em> <strong></strong> <span><?php echo __('已取消');?></span> </li> <?php } else if($info['status']==4) { ?> <li class="step-third cur"  > <em></em> <strong></strong> <span><?php echo __('等待消费');?></span> </li> <li class="step-fourth active"  > <em></em> <strong></strong> <span><?php echo __('已退款');?></span> </li> <?php } else { ?> <li class="step-third <?php if($info['status']>1) { ?>cur<?php } else if($info['status']==1) { ?>active<?php } ?>
"  > <em></em> <strong></strong> <span><?php echo __('获得旅行方案');?></span> </li> <li class="step-fourth <?php if($info['status']>2) { ?>cur<?php } else if($info['status']==2) { ?>active<?php } ?>
" > <em></em> <strong></strong> <span><?php echo __('等待消费');?></span> </li> <li class="step-fifth <?php if($info['status']==5) { ?>active<?php } ?>
" > <em></em> <strong></strong> <span><?php echo __('交易完成');?></span> </li> <?php } ?> </ul> </div> <div class="speed-show-list"> <?php $log_list = Model_Member_Order_Log::get_list($info['id']);?> <ul class="info-list" style="height: auto;"> <?php $n=1; if(is_array($log_list)) { foreach($log_list as $log) { ?> <li><span><?php echo date('Y-m-d H:i:s',$log['addtime']);?></span><span><?php echo $log['description'];?></span></li> <?php $n++;}unset($n); } ?> </ul> <?php if(count($log_list)>2) { ?> <div id="more-info" class="more-info up"><?php echo __('收起详细进度');?></div> <?php } ?> </div> </div> <!-- 订单进度 --> <div class="os-term"> <div class="os-tit"><?php echo __('定制需求');?></div> <div class="os-block"> <div class="custom-xq"> <div class="info-list clearfix"> <ul> <li><strong><?php echo __('目的地');?>：</strong><?php echo $customize_info['dest'];?></li> <li><strong><?php echo __('出发日期');?>：</strong><?php echo date('Y-m-d',$customize_info['starttime']);?></li> <li><strong><?php echo __('出游天数');?>：</strong><?php echo $customize_info['days'];?>天</li> <li><strong><?php echo __('成人');?>：</strong><?php echo $customize_info['adultnum'];?>人</li> <li><strong><?php echo __('儿童');?>：</strong><?php echo $customize_info['childnum'];?>人</li> </ul> <ul> <li><strong><?php echo __('出发地');?>：</strong><?php echo $customize_info['startplace'];?></li> <?php $n=1; if(is_array($extend_fields)) { foreach($extend_fields as $key => $field) { ?> <?php if($key==4) break;?> <li> <strong><?php echo $field['chinesename'];?>：</strong><?php echo $extend_info[$field['fieldname']];?> </li> <?php $n++;}unset($n); } ?> </ul> <ul> <?php $n=1; if(is_array($extend_fields)) { foreach($extend_fields as $key => $field) { ?> <?php if($key<4) continue;?> <li> <strong><?php echo $field['chinesename'];?>：</strong><?php echo $extend_info[$field['fieldname']];?> </li> <?php $n++;}unset($n); } ?> </ul> </div> <div class="txt-box"> <h4 class="txt-tit"><?php echo __('备注');?>：</h4> <p class="txt-con"><?php echo $customize_info['content'];?></p> </div> </div> </div> </div> <!-- 定制需求 --> <div class="os-term"> <div class="os-tit"><?php echo __('旅行方案');?></div> <div class="os-block"> <div class="travel-case"> <div class="case-item"> <h4 class="tit"><?php echo $customize_info['title'];?></h4> <div class="txt"><?php echo $customize_info['case_content'];?></div> </div> <div class="case-info"> <?php if(!empty($customize_info['linedoc'])) { ?> <p class="xz"><?php echo __('方案附件');?>：
                        <?php $n=1; if(is_array($customize_info['linedoc']['path'])) { foreach($customize_info['linedoc']['path'] as $k => $v) { ?> <a href="<?php echo $v;?>"><?php echo $customize_info['linedoc']['name'][$k];?></a>&nbsp;&nbsp;
                        <?php $n++;}unset($n); } ?> </p> <?php } ?> <p class="jg"><?php echo __('方案报价');?>：<span><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['price'];?></span></p> <?php if(!empty($supplier)) { ?> <p class="fa"><?php echo __('方案提供商');?>：<?php echo $supplier['suppliername'];?></p> <p class="lx"><?php echo __('联系电话');?>：<?php echo $supplier['mobile'];?> <?php if(!empty($supplier['mobile'])) { ?><span>(*<?php echo __('如有疑问？请电话联系');?>)</span><?php } ?> </p> <?php } ?> </div> </div> </div> </div> <!-- 联系人信息 --> <div class="os-term"> <div class="os-tit"><?php echo __('联系人信息');?></div> <div class="os-block"> <div class="linkman-info clearfix"> <div class="item-block"> <em><?php echo __('联系人');?>：</em> <p><?php echo $customize_info['contactname'];?></p> </div> <div class="item-block"> <em><?php echo __('手机号');?>：</em> <p><?php echo $customize_info['phone'];?></p> </div> <div class="item-block"> <em><?php echo __('邮箱');?>：</em> <p><?php echo $customize_info['email'];?></p> </div> <div class="item-block bz"> <em><?php echo __('备注');?>：</em> <p><?php echo $customize_info['content'];?></p> </div> </div> </div> </div> <form method="post" id="frm" action="<?php echo $cmsurl;?>customize/member/order_save" target="_top"> <!-- 联系人信息 --> <?php require_once ("E:/wamp64/www/taglib/member.php");$member_tag = new Taglib_Member();if (method_exists($member_tag, 'order_tourer')) {$tourer = $member_tag->order_tourer(array('action'=>'order_tourer','orderid'=>$info['id'],'return'=>'tourer',));}?> <?php if($info['status']==1) { ?> <div class="os-term"> <div class="os-tit"><?php echo __('游客信息');?></div> <div class="os-block"> <?php require_once ("E:/wamp64/www/taglib/member.php");$member_tag = new Taglib_Member();if (method_exists($member_tag, 'linkman')) {$tourerlist = $member_tag->linkman(array('action'=>'linkman','memberid'=>$mid,'return'=>'tourerlist',));}?> <?php if(!empty($tourerlist['0']['linkman'])) { ?> <div class="select-linkman"> <div class="bt"><?php echo __('选择常用旅客');?>：</div> <div class="son" id="tourer_con"> <?php $n=1; if(is_array($tourerlist)) { foreach($tourerlist as $tl) { ?> <span data-name="<?php echo $tl['linkman'];?>" data-cardtype="<?php echo $tl['cardtype'];?>" data-idcard="<?php echo $tl['idcard'];?>" class="cs-tourer-item"><i class=""></i><?php echo $tl['linkman'];?></span> <?php $n++;}unset($n); } ?> </div> <?php if(count($tourerlist)>5) { ?> <div class="more" id="tourer_more"><?php echo __('更多');?>&gt;</div> <script>
                    $("#tourer_more").click(function(){
                         if($(this).hasClass('expanded'))
                         {
                             $("#tourer_con").css('height',30);
                             $(this).html("<?php echo __('更多');?>&gt;");
                         }
                         else
                         {
                             $("#tourer_con").css('height','auto');
                             $(this).html("&lt;<?php echo __('隐藏');?>");
                         }
                         $(this).toggleClass('expanded');
                        window.parent.ReFrameHeight();
                    });
                </script> <?php } ?> </div> <?php } ?> <div class="user-table-info clear"> <table margin_padding=zkOzDt > <?php for($i=0;$i<$customize_info['totalnum'];$i++){  ?> <tbody> <tr> <td colspan="4" height="20"></td> </tr> <tr> <th width="10%"><strong class="yk"><?php echo __('旅客');?><?php echo $i+1;?></strong></th> <td width="15%"><span class="name"><?php echo __('姓名');?>：</span></td> <td width="20%"><input type="text" name="t_tourername[<?php echo $i;?>]" class="default-text" value="<?php echo $tourer[$i]['tourername'];?>"></td> <td><input type="hidden" name="t_touerid[<?php echo $i;?>]" value="<?php echo $tourer[$i]['id'];?>"/></td> </tr> <tr> <td colspan="4" height="10"></td> </tr> <tr> <th>&nbsp;</th> <td><span class="name"><?php echo __('证件类型');?>：</span></td> <td> <select class="drop-down" name="t_cardtype[<?php echo $i;?>]" > <option value=""><?php echo __('请选择');?></option> <option value="<?php echo __('护照');?>" <?php if($tourer[$i]['cardtype']=='护照') { ?>selected="selected"<?php } ?>
><?php echo __('护照');?></option> <option value="<?php echo __('身份证');?>" <?php if($tourer[$i]['cardtype']=='身份证') { ?>selected="selected"<?php } ?>
><?php echo __('身份证');?></option> <option value="<?php echo __('台胞证');?>" <?php if($tourer[$i]['cardtype']=='台胞证') { ?>selected="selected"<?php } ?>
><?php echo __('台胞证');?></option> <option value="<?php echo __('港澳通行证');?>" <?php if($tourer[$i]['cardtype']=='港澳通行证') { ?>selected="selected"<?php } ?>
><?php echo __('港澳通行证');?></option> <option value="<?php echo __('军官证');?>" <?php if($tourer[$i]['cardtype']=='军官证') { ?>selected="selected"<?php } ?>
><?php echo __('军官证');?></option> <option value="<?php echo __('出生日期');?>" <?php if($tourer[$i]['cardtype']=='出生日期') { ?>selected="selected"<?php } ?>
><?php echo __('出生日期');?></option> </select> </td> <td>&nbsp;</td> </tr> <tr> <td colspan="4" height="10"></td> </tr> <tr> <th>&nbsp;</th> <td><span class="name"><?php echo __('证件号码');?>：</span></td> <td><input type="text" class="default-text" name="t_cardnumber[<?php echo $i;?>]" value="<?php echo $tourer[$i]['cardnumber'];?>"/></td> <td></td> </tr> <tr> <td colspan="4" height="20"></td> </tr> </tbody> <?php } ?> </table> </div> </div> </div> <?php } ?> <!-- 游客信息 --> <?php if($info['status']>1 &&!empty($tourer)) { ?> <div class="os-term"> <div class="os-tit"><?php echo __('游客信息');?></div> <div class="os-block"> <div class="user-bm-info"> <ul class="clearfix"> <?php if(!empty($tourer)) { ?> <?php $n=1; if(is_array($tourer)) { foreach($tourer as $k => $t) { ?> <li class="<?php if(($k+1)%4==0) echo 'mr_0';?>"> <p><em><?php echo __('姓名');?>：</em><span><?php echo $t['tourername'];?></span></p> <p><em><?php echo __('证件类型');?>：</em><span><?php echo $t['cardtype'];?></span></p> <p><em><?php echo __('证件号码');?>：</em><span><?php echo $t['cardnumber'];?></span></p> </li> <?php $n++;}unset($n); } ?> <?php } ?> </ul> </div> </div> </div> <?php } ?> <?php require_once ("E:/wamp64/www/taglib/member.php");$member_tag = new Taglib_Member();if (method_exists($member_tag, 'order_bill')) {$bill = $member_tag->order_bill(array('action'=>'order_bill','orderid'=>$info['id'],'return'=>'bill',));}?> <!-- 游客信息 --> <?php if($info['status']==1) { ?> <!--     <div class="os-term"> <div class="os-tit"><?php echo __('发票信息');?></div> <div class="os-block"> <div class="st-item-block"> <div class="receipt-nav check-con"> <span  data-val="1" <?php if(!empty($bill)) { ?>class="on"<?php } ?>
><i class="ico"></i><?php echo __('需要发票');?></span> <span <?php if(empty($bill)) { ?>class="on"<?php } ?>
 data-val="0"><i class="ico"></i><?php echo __('不需要发票');?></span> <input type="hidden" id="isneedbill" name="isneedbill" value="0"/> </div> <ul <?php if(empty($bill)) { ?>style="display:none"<?php } ?>
 id="voice_con"> <li> <strong class="item-hd"><?php echo __('发票金额');?>：</strong> <div class="item-bd"> <span class="jg-num payprice"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['payprice'];?></span> <span class="ts-txt">(<?php echo __('发票奖于您出游归来后5个工作日开具并由快递寄出，请注意查收');?>)</span> </div> </li> <li> <strong class="item-hd"><?php echo __('发票明细');?>：</strong> <div class="item-bd"> <span class="pt-txt"><?php echo __('旅游费');?></span> </div> </li> <li> <strong class="item-hd"><?php echo __('发票抬头');?>：</strong> <div class="item-bd"> <input type="text" class="default-text w300 fl" name="bill_title" value="<?php echo $bill['title'];?>" placeholder="<?php echo __('请填写个人姓名或公司名称');?>"> </div> </li> <li> <strong class="item-hd"><?php echo __('收件人');?>：</strong> <div class="item-bd"> <input type="text" class="default-text w300 fl" name="bill_receiver" value="<?php echo $bill['receiver'];?>" placeholder="<?php echo __('请详细填写收件人姓名');?>"> </div> </li> <li> <strong class="item-hd"><?php echo __('联系电话');?>：</strong> <div class="item-bd"> <input type="text" class="default-text w300 fl" name="bill_phone" value="<?php echo $bill['mobile'];?>" placeholder="<?php echo __('请详细填写收件人电话');?>"> </div> </li> <li> <strong class="item-hd"><?php echo __('收货地址');?>：</strong> <div class="item-bd" id="city"> <select class="drop-down prov" name="bill_prov"> </select> <select class="drop-down ml5 city" name="bill_city"> </select> <input type="text" class="default-text mt10 w700" name="bill_address" value="<?php echo $bill['address'];?>" placeholder="<?php echo __('请填写详细地址');?>"> </div> </li> </ul> </div> </div> </div> --> <?php } ?> <!-- 发票信息 --> <?php if(!empty($bill) && $info['status']>1) { ?> <div class="os-term"> <div class="os-tit"><?php echo __('发票信息');?></div> <div class="os-block"> <div class="order-show-invoice"> <ul> <li><em><?php echo __('发票明细');?>：</em><?php echo __('旅游费');?></li> <li><em><?php echo __('发票金额');?>：</em><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['payprice'];?></li> <li><em><?php echo __('发票抬头');?>：</em><?php echo $bill['title'];?></li> <li><em><?php echo __('收件人');?>：</em><?php echo $bill['receiver'];?></li> <li><em><?php echo __('联系电话');?>：</em><?php echo $bill['mobile'];?></li> <li><em><?php echo __('收货地址');?>：</em><?php echo $bill['address'];?></li> </ul> </div> </div> </div> <?php } ?> <!-- 发票信息 --> <?php if($info['status']==1) { ?> <div class="os-term"> <div class="os-tit"><?php echo __('优惠信息');?></div> <div class="os-block"> <div class="order-show-cheap"> <ul> <?php if(!empty($info['iscoupon'])) { ?> <li><em><?php echo __('优惠券');?>：</em><?php echo Currency_Tool::symbol();?><?php echo $info['iscoupon']['cmoney'];?>（<?php echo $info['iscoupon']['name'];?>）</li> <input type="hidden" id="coupon_price" value="<?php echo $info['iscoupon']['cmoney'];?>"/> <?php } ?> <?php if($info['usejifen']) { ?> <li><em><?php echo __('积分抵现');?>：</em><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['jifentprice'];?></li> <input type="hidden" id="usejifen" name="usejifen" value="<?php echo $info['usejifen'];?>"/> <input type="hidden" id="jifentprice" value="<?php echo $info['jifentprice'];?>"/> <span id="jifen_tprice" style="display: none"><?php echo $info['jifentprice'];?></span> <?php } ?> </ul> </div> <?php if(empty($info['iscoupon']) || empty($info['usejifen'])) { ?> <div class="item-yh clear"> <?php if(empty($info['iscoupon'])) { ?> <div class="item-nr" id="coupon_con"> <?php if(St_Functions::is_normal_app_install('coupon')) { ?> <?php echo Request::factory('coupon/box-'.$typeid.'-'.$info['id'])->execute()->body(); ?> <?php } ?> <script>
                        $("#coupon_con h3").remove();
                    </script> </div> <?php } ?> <?php if(empty($info['usejifen'])) { ?> <!--                     <div class="item-nr"> <span class="use-jf"> <label>使用：</label> <input type="text" name="needjifen" id="jifen_need" class="jf-num"/>
                                            积分抵扣
                                        </span> <span class="dk-num">- <?php echo Currency_Tool::symbol();?><span id="jifen_tprice">0</span></span> <span class="not-full" id="jifen_error"></span> <span class="cur-jf">最多可使用<?php echo $customize_info['maxtpricejifen'];?>积分抵扣<?php echo Currency_Tool::symbol();?><?php echo $customize_info['maxjifentprice'];?>，我当前积分：<?php echo $user['jifen'];?></span> <input type="hidden" id="jifen_exchange" value="<?php echo $GLOBALS['cfg_exchange_jifen'];?>"/> <input type="hidden" id="jifen_maxuse" value="<?php if($customize_info['maxtpricejifen']>$user['jifen']) { ?><?php echo $user['jifen'];?><?php } else { ?><?php echo $customize_info['maxtpricejifen'];?><?php } ?>
"/> </div> --> <?php } ?> </div> <?php } ?> </div> </div> <?php } ?> <!-- 优惠信息 --> <?php if((!empty($info['iscoupon'])||$info['usejifen']) && $info['status']>1 ) { ?> <div class="os-term"> <div class="os-tit"><?php echo __('优惠信息');?></div> <div class="os-block"> <div class="order-show-cheap"> <ul> <?php if(!empty($info['iscoupon'])) { ?> <li><em><?php echo __('优惠券');?>：</em>-<?php echo Currency_Tool::symbol();?><?php echo $info['iscoupon']['cmoney'];?>（<?php echo $info['iscoupon']['name'];?>）</li> <?php } ?> <?php if($info['usejifen']) { ?> <li><em><?php echo __('积分抵现');?>：</em><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['jifentprice'];?></li> <?php } ?> </ul> </div> </div> </div> <?php } ?> <div class="os-term"> <div class="os-tit"><?php echo __('支付信息');?></div> <div class="os-block"> <div class="order-show-cheap"> <ul> <li><em><?php echo __('支付方式');?>：</em><?php echo $info['paytype_name'];?> </li> <?php if($GLOBALS['cfg_order_agreement_open']==1&& $info['status']>1) { ?> <li><em><?php echo __('预定协议');?>：</em><span class="check-ht" id="agreement_btn">《<?php echo $GLOBALS['cfg_order_agreement_title'];?>》</span></li> <?php } ?> </ul> </div> </div> </div> <!-- 优惠信息 --> <?php if(!empty($info['eticketno']) && Product::is_app_install('stourwebcms_app_supplierverifyorder')) { ?> <div class="os-term"> <div class="os-tit"><?php echo __('消费码');?></div> <div class="os-block"> <div class="order-show-code"> <p class="txt"><em><?php echo __('短信消费码');?>：</em><?php echo $info['eticketno'];?></p> <div class="pic"><img src="/res/vendor/qrcode/make.php?param=<?php echo $info['eticketno'];?>"></div> </div> </div> </div> <?php } ?> <!-- 消费码 --> <div class="os-term"> <div class="os-tit"><?php echo __('结算信息');?></div> <div class="os-block"> <div class="order-item-count clearfix"> <div class="item-nr"> <div class="item-list"><strong class="hd"><?php echo __('商品总额');?>：</strong><span class="jg"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $info['totalprice'];?></span></div> <div class="item-list"><strong class="hd"><?php echo __('商品优惠');?>：</strong><span class="jg" id="reward_price"><?php echo Currency_Tool::symbol();?><?php echo $info['payprice']-$info['totalprice']; ?></span></div> <hr> <div class="item-total"><strong class="hd"><?php echo __('应付总额');?>：</strong><span class="jg payprice"><i class="currency_sy" ><?php echo Currency_Tool::symbol();?></i><?php echo $info['payprice'];?></span></div> <?php if($info['status']=='1' && $GLOBALS['cfg_order_agreement_open']==1) { ?> <div class="agree-order-term"> <label class="radio-label"><input type="checkbox" class="check-btn" name="agreement"><?php echo __('同意');?></label> <a class="xy-link" href="javascript:;" id="agreement_btn">《<?php echo $GLOBALS['cfg_order_agreement_title'];?>》</a> </div> <?php } ?> </div> </div> </div> </div> <input type="hidden" name="customizeid" value="<?php echo $customize_info['id'];?>"/> <input type="hidden" id="totalprice" value="<?php echo $info['totalprice'];?>"/> <input type="hidden" id="total_price" value="{$info['totalprice']"/> <input type="hidden" id="orderid" value="<?php echo $info['id'];?>"/> </form> <div class="condition-col"> <span class="item-child"><?php echo __('在线支付');?>：<strong class="jg payprice"><i class="currency_sy" ><?php echo Currency_Tool::symbol();?></i><?php echo $info['payprice'];?></strong></span> <?php if($info['status']=='1') { ?> <a class="pay-btn fr" href="javascript:;"><?php echo __('立即付款');?></a> <?php } ?> </div> <!-- 支付结算 --> <div class="agreement-term-content" style="display: none;"> <div class="agreement-term-tit"><strong><?php echo $GLOBALS['cfg_order_agreement_title'];?></strong><i class="close-ico" onclick="$(this).parents('.agreement-term-content').hide();"></i></div> <div class="agreement-term-block"> <h3 class="agreement-bt">《<?php echo $GLOBALS['cfg_order_agreement_title'];?>》</h3> <div class="agreement-nr"> <?php echo $GLOBALS['cfg_order_agreement'];?> </div> </div> </div> <script>
        var ordersn = "<?php echo $info['ordersn'];?>";
        var status = "<?php echo $info['status'];?>";
        $(function(){
            //积分改动
            $("#jifen_need").change(function(){
                 var jifen = parseInt($("#jifen_need").val());
                 jifen=!jifen?0:jifen;
                 var jifen_exchange = $("#jifen_exchange").val();
                 var jifen_maxuse = $("#jifen_maxuse").val();
                 if(jifen>jifen_maxuse)
                 {
                     $("#jifen_error").text("积分超过使用限制");
                     $("#jifen_tprice").text(0);
                     get_total_price();
                     return;
                 }
                 var tprice = Math.floor(jifen/jifen_exchange);
                 $("#jifen_tprice").text(tprice);
                 $("#jifen_error").text("");
                 get_total_price();
            });
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
            })
            //初始化总价
            if(status=='1')
            {
                get_total_price();
            }
            //提交
            $(".pay-btn").click(function(){
                if($('#jifen_error').text() != ''){
                    parent.layer.msg($('#jifen_error').text(),{icon:5});
                    return false;
                }
                 $("#frm").submit();
            });
            $("#agreement_btn").click(function(){
                $(".agreement-term-content").show();
                adjust_agreement_pos();
            });
            $(window.parent).scroll(function(){
                adjust_agreement_pos();
            });
            //验证有效性
            $("#frm").validate({
                submitHandler: function(form) {
                    form.submit();
                },
                errorClass: 'st-ts-text',
                errorElement: 'span',
                rules: {
                    bill_title:{
                        required:{
                            depends: function(element) {
                                return $("#isneedbill").val()==1?true:false;
                            }
                        }
                    },
                    bill_receiver:{
                        required:{
                            depends: function(element) {
                                return $("#isneedbill").val()==1?true:false;
                            }
                        }
                    },
                    bill_phone:{
                        required:{
                            depends: function(element) {
                                return $("#isneedbill").val()==1?true:false;
                            }
                        }
                    },
                    agreement:{
                        required:true
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).attr('style', 'border:1px solid red');
                },
                unhighlight: function (element, errorClass) {
                    $(element).attr('style', '');
                },
                messages: {
                    bill_title:{
                        required:'<?php echo __('请填写个人姓名或公司名称');?>'
                    },
                    bill_receiver:{
                        required:'<?php echo __('请详细填写收件人姓名');?>'
                    },
                    bill_phone:{
                        required:'<?php echo __('请详细填写收件人电话');?>'
                    }
                    ,
                    agreement:{
                        required:'<?php echo __('请先同意协议');?>'
                    }
                },
                errorPlacement: function (error, element) {
                     if($(element).parent().is('td'))
                     {
                         $(element).parent().next().append(error);
                     }
                    else if($(element).attr('name')=='agreement')
                    {
                        $(element).parent().next().after(error);
                        window.parent.ReFrameHeight();
                    }
                     else
                     {
                         $(element).after(error);
                     }
                }
            });
            //添加验证
            $("input[name^='t_tourername'").each(function(){
                $(this).rules("remove");
                $(this).rules("add", {required: true, messages: {required: "<?php echo __('请填写游客姓名');?>"}});
            });
            $("select[name^='t_cardtype'").each(function(){
                $(this).rules("remove");
                $(this).rules("add", {required: true, messages: {required: "<?php echo __('请选择证件类型');?>"}});
            });
            $("input[name^='t_cardnumber'").each(function(){
                $(this).rules("remove");
                $(this).rules("add", {required: true, messages: {required: "<?php echo __('请填写证件号码');?>"}});
            });
            //省市选择
            $("#city").citySelect({
                nodata:"none",
                'prov':"<?php echo $bill['province'];?>",
                'city':"<?php echo $bill['city'];?>",
                required:false
            });
           //是否需要发票
           $(".check-con span i").click(function(){
                var ele = $(this).parent();
                if(!ele.hasClass('on'))
                {
                    var val=ele.data('val');
                    ele.addClass('on');
                    ele.siblings().removeClass('on');
                    ele.siblings('input:hidden').val(val);
                    if(val==1)
                    {
                        $("#voice_con").show();
                    }
                    else
                    {
                        $("#voice_con").hide();
                    }
                    window.parent.ReFrameHeight();
                }
           });
           //选择游客
            $('.cs-tourer-item i').click(function(){
                 var pele=$(this).parent();
                 var name=pele.data('name');
                 var cardtype=pele.data('cardtype');
                 var idcard=pele.data('idcard');
                  if($(this).hasClass('on'))
                  {
                      $(this).removeClass('on');
                      $(".user-table-info tbody").each(function(){
                            var t_touerername=$(this).find("input[name^='t_tourername']").val();
                            if(t_touerername==name)
                            {
                                $(this).find('input').val('');
                                $(this).find('select option:first').attr('selected',true);
                            }
                      });
                  }
                  else
                  {
                      var is_selected=false;
                      $(".user-table-info tbody").each(function(){
                          if(is_selected==true)
                             return;
                          var t_touerername=$(this).find("input[name^='t_tourername']").val();
                          if(t_touerername=='')
                          {
                              $(this).find("input[name^='t_tourername']").val(name).valid();
                              $(this).find("select").find("option[value='"+cardtype+"']").attr('selected',true);
                              $(this).find("select").valid();
                              $(this).find("input[name^='t_cardnumber']").val(idcard).valid();
                              is_selected=true;
                          }
                      });
                      if(is_selected)
                      {
                          $(this).addClass('on');
                      }
                  }
            });
            //积分选择
            $(".use-jf label i").click(function(){
                $(this).parent().toggleClass('on');
                 if($(this).parent().hasClass('on'))
                 {
                     $("#usejifen").val(1);
                 }
                 else
                 {
                     $("#usejifen").val(0);
                 }
                 get_total_price();
            });
            //取消订单
            $(".cancel-btn").click(function(){
                var LayerDlg = parent && parent.layer ? parent.layer:layer;
                    var orderid = $("#orderid").val();
                    var url = SITEURL +'customize/member/ajax_order_cancel';
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
        })
        function get_total_price(a)
        {
            var totalprice=$("#totalprice").val();
            var jifentprice=parseInt($("#jifen_tprice").text());
            jifentprice=!jifentprice?0:jifentprice;
            var prev_totalprice=totalprice-jifentprice;
            $("#total_price").val(prev_totalprice);
            var coupon_price=Number($("#coupon_price").val());
            coupon_price=!coupon_price?0:coupon_price;
            var reward_price = coupon_price+jifentprice;
            var payprice=prev_totalprice-coupon_price;
            $("#reward_price").html('<i class="currency_sy" >'+CURRENCY_SYMBOL+'</i>'+reward_price);
            $(".payprice").html('<i class="currency_sy" >'+CURRENCY_SYMBOL+'</i>'+payprice);
            if(payprice<0)
            {
                on_negative_totalprice();
            }
        }
        //当价格小于0时
        function on_negative_totalprice()
        {
            parent.layer.msg("<?php echo __('优惠价超过了原价');?>",{icon:5});
            $("#jifen_need").val(0);
            $("#jifen_need").trigger('change');
        }
        function coupon_callback(data)
        {
            if(data.status==1)
            {
                //$("#total_price").val(data.totalprice);
                $('#coupon_price').val(data.coupon_price);
            }
            else
            {
                $('#coupon_price').val(0);
                parent.layer.msg('<?php echo __('不符合使用条件');?>',{icon:5})
                $('select[name=couponid] option:first').attr('selected','selected');
            }
            get_total_price();
        }
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
    </script> </div> </body> </html>