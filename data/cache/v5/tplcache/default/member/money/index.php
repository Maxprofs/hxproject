<!doctype html> <html> <head> <meta charset="utf-8"> <title><?php echo __('会员中心');?>-<?php echo $webname;?></title> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('user.css,base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,jquery.validate.js,jquery.cookie.js,ajaxform.js');?> <link rel="stylesheet" href="/tools/js/datetimepicker/jquery.datetimepicker.css"> <script src="/tools/js/datetimepicker/jquery.datetimepicker.full.js"></script> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo __('首页');?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo __('我的钱包');?> </div><!--面包屑--> <div class="st-main-page"> <?php echo  Stourweb_View::template("member/left_menu");  ?> <div class="user-main-box"> <?php if($member['verifystatus']==0) { ?> <div class="hint-msg-box"> <span class="close-btn" onclick="$(this).parent().remove()">关闭</span> <p class="hint-txt">您的账户未实名认证！为了您资金的安全，<a href="/member/index/modify_idcard">去认证&gt;&gt;</a></p> </div> <?php } ?> <!-- 认证提示 --> <div class="my-wallet-bar"> <span class="txt" style="padding: 0;">账号余额：<em class="price"><?php echo Currency_Tool::symbol();?> <?php echo number_format($member['money']-$member['money_frozen'],2)?></em></span> <?php if($config['cash_min']=='1'||$config['cash_max']=='1') { ?> <span class="ms"><?php if($config['cash_min']=='1') { ?>金额超过<?php echo Currency_Tool::symbol();?><?php echo $config['cash_min_num'];?>可提现<?php } ?> <?php if($config['cash_max']=='1') { ?><?php if($config['cash_min']=='1') { ?>,<?php } ?>
本月还可提现<?php echo $cash_available_num;?>次<?php } ?> </span> <?php } ?> <?php if((($member['money']-$member['money_frozen']<$config['cash_min_num'])&&$config['cash_min']==1)||$cash_available_num==0) { ?> <a class="go-link fr disabled" href="javascript:;">我要提现</a> <?php } else { ?> <a class="go-link fr" href="/member/bag/withdraw">我要提现</a> <?php } ?> </div> <!-- 账号余额 --> <div class="details-container"> <div class="tab-nav-bar"> <a class="dh <?php if($type===null) { ?>on<?php } ?>
" href="/member/bag/index">交易明细</a> <a class="dh <?php if($type===0 || $type==='0') { ?>on<?php } ?>
" href="/member/bag/index?type=0">收入</a> <a class="dh <?php if($type===1 || $type==='1') { ?>on<?php } ?>
" href="/member/bag/index?type=1">支出</a> </div> <div class="tab-con-wrap clearfix"> <table class="tran-data-list" body_html=iIACXC > <tr> <th width="25%">时间</th> <th width="35%">交易名称</th> <th width="20%">交易类型</th> <th width="20%">交易金额</th> </tr> <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?> <tr> <td><?php echo date('Y-m-d H:i:s',$row['addtime']);?></td> <td><span class="name"><?php echo $row['description'];?></span></td> <td><?php if($row['type']==0) { ?>收入<?php } else if($row['type']==1) { ?>支出<?php } else if($row['type']==2) { ?>冻结<?php } else if($row['type']==3) { ?>解冻<?php } ?> </td> <td><span class="<?php if($row['type']==0 || $row['type']==3) { ?>add<?php } else { ?>sub<?php } ?>
"> <?php if($row['type']==0 || $row['type']==3) { ?>+<?php } else { ?>-<?php } ?> <?php echo Currency_Tool::symbol();?><?php echo $row['amount'];?> </span></td> </tr> <?php $n++;}unset($n); } ?> </table> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div> <?php if(empty($list)) { ?> <div class="order-no-have"><span></span> <p>暂无交易记录</p> </div> <?php } ?> </div> </div> <!-- 交易明细 --> </div> </div> </div> </div> <?php echo Common::js('layer/layer.js');?> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <script>
    $(function(){
        //提交申请
        $("#submit_btn").click(function(){
             $("#frm").submit();
        });
        //验证
        $("#frm").validate({
            rules: {
                amount:
                {
                    required:true,
                    digits:true
                },
                bankaccountname:
                {
                    required:true
                },
                bankcardnumber:
                {
                    required:true
                },
                bankname:
                {
                    required:true
                }
            },
            messages: {
                amount:
                {
                    required:'必填',
                    digits:'请填入整数金额'
                },
                bankaccountname:
                {
                    required:'必填'
                },
                bankcardnumber:
                {
                    required:'必填'
                },
                bankname:
                {
                    required:'必填'
                }
            },
            submitHandler:function(form){
                $.ajaxform({
                    method: "POST",
                    isUpload: true,
                    form: "#frm",
                    dataType: "html",
                    success: function (result) {
                    }
                });
                return false;
            },
            errorClass:'error-txt',
            errorElement:'span'
            /* highlight: function(element, errorClass, validClass) {
                $(element).attr('style','border:1px solid red');
            },
            unhighlight:function(element, errorClass){
                $(element).attr('style','');
            },
            errorPlacement:function(error,element){
                $(element).parent().append(error)
            }*/
        });
        //导航选中
        $("#nav_money").addClass('on');
    })
</script> </body> </html>
