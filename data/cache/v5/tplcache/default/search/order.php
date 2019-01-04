<!doctype html> <html> <head> <meta charset="utf-8"> <title><?php echo __('订单查询');?>-<?php echo $webname;?></title> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('photo.css,base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,jquery.validate.js,jquery.validate.addcheck.js,jquery.cookie.js');?> <style>
        .inquiry-msg ul li strong{
            width: 100px;
        }
        .inquiry-msg ul li .send-yzm{
            margin-top: -3px;
            vertical-align: middle;
        }
        .inquiry-msg .begin-cx-btn{
            padding-left: 460px;
        }
    </style> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo $GLOBALS['cfg_indexname'];?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo __('订单查询');?> </div><!--面包屑--> <div class="inquiry-order-box"> <form action="<?php echo $cmsurl;?>search/order" method="get" id="queryfrm"> <div class="inquiry-msg"> <h3><?php echo __('订单查询');?></h3> <ul> <li><strong><?php echo __('手机号码');?>：</strong><input type="text" class="cx-text" id="mobile" name="mobile" value="<?php echo $mobile;?>" /><span class="send-txt" style="display: none;">验证码已经发送到您手机，请注意查收</span></li> <li><strong><?php echo __('图片验证码');?>：</strong><input type="text" class="cx-text" id="checkcode_img" name="checkcode_img" /> <img class="send-yzm" src="<?php echo $cmsurl;?>captcha" width="114" height="31" onClick="this.src=this.src+'?math='+ Math.random()" /> </li> <li><strong><?php echo __('短信验证码');?>：</strong><input type="text" class="cx-text" id="checkcode" name="checkcode" /> <input type="button" class="send-yzm sendmsg" value="<?php echo __('发送验证码');?>"/> </li> </ul> <input type="hidden" id="frmcode" name="frmcode" value="<?php echo $frmcode;?>"/> <div class="begin-cx-btn"><a href="javascript:;" class="query"><?php echo __('开始查询');?></a></div> </div> </form> <?php if(!empty($mobile)) { ?> <div class="inquiry-box"> <h3><?php echo __('手机');?><?php echo $mobile;?><?php echo __('查询到以下订单');?>：</h3> <div class="inquiry-con"> <div class="order-list"> <table width="100%" border="0" html_color=5ATBbm > <tr> <th width="40%" height="38" scope="col"><?php echo __('订单信息');?></th> <th width="20%" height="38" scope="col"><?php echo __('订单金额');?></th> <th width="20%" height="38" scope="col"><?php echo __('订单状态');?></th> <th width="20%" height="38" scope="col"><?php echo __('订单操作');?></th> </tr> <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?> <tr> <td height="114"> <div class="con"> <dl> <dt><a href="<?php echo $row['producturl'];?>" target="_blank"><img src="<?php echo $row['litpic'];?>" alt="<?php echo $row['productname'];?>" /></a></dt> <dd> <a class="tit" href="<?php echo $row['producturl'];?>" target="_blank"><?php echo $row['productname'];?></a> <p><?php echo __('订单编号');?>：<?php echo $row['ordersn'];?></p> <p><?php echo __('下单时间');?>：<?php echo Common::mydate('Y-m-d H:i:s',$row['addtime']);?></p> </dd> </dl> </div> </td> <td align="center"><span class="price"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $row['totalprice'];?></span></td> <td align="center"><span class="dfk"><?php echo $row['statusname'];?></span></td> <td align="center"> <?php if($row['status']=='0') { ?> <a class="order-ck"><?php echo $row['statusname'];?></a> <?php } else if($row['status']=='1') { ?> <a class="now-fk" href="<?php echo $GLOBALS['cfg_basehost'];?>/payment/?ordersn=<?php echo $row['ordersn'];?>"><?php echo __('立即付款');?></a> <?php } else if($row['status']=='3') { ?> <a class="order-ck"><?php echo $row['statusname'];?></a> <?php } else if($row['status']=='5') { ?> <a class="order-ck"><?php echo $row['statusname'];?></a> <?php } else if($row['status']=='4') { ?> <a class="order-ck"><?php echo $row['statusname'];?></a> <?php } else if($row['status']=='2') { ?> <a class="order-ck"><?php echo $row['statusname'];?></a> <?php } else if(empty($row['ispinlun'])) { ?> <a class="order-ck"><?php echo __('未点评');?></a> <?php } ?> <a class="order-ck" href="<?php echo $cmsurl;?>member/order/view?ordersn=<?php echo $row['ordersn'];?>"><?php echo __('查看订单');?></a> </td> </tr> <?php $n++;}unset($n); } ?> </table> </div> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div> <?php if(empty($list)) { ?> <div class="order-no-have"><span></span><p><?php echo __('您的订单空空如也');?>，<a href="<?php echo $GLOBALS['cfg_basehost'];?>"><?php echo __('去逛逛');?></a><?php echo __('去哪儿玩吧');?>！</p></div> <?php } ?> </div> </div> <?php } ?> </div><!-- 订单查询 --> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Common::js('layer/layer.js');?> <script>
    $(function(){
        $.validator.addMethod('is_Mobile', function(value, element) {
            var length = value.length;
            var mobile = /^1[2-9]\d{9}$/;
            return this.optional(element) || (length == 11 && mobile.test(value));
        }, '<?php echo __("请正确填写您的手机号码");?>');
        $("#queryfrm").validate({
            submitHandler:function(form){
                form.submit();
            } ,
            errorClass:'need-txt',
            errorElement:'span',
            rules: {
                mobile:{
                    required:true,
                    is_Mobile:true
                },
                checkcode_img:{
                    required:true
                },
                checkcode:{
                    required:true,
                    remote:{
                        url:SITEURL+'search/ajax_check_msgcode',
                        type: 'post',
                        data:{
                            mobile: function() {
                                return $( "#mobile" ).val();
                            }}
                    }
                },
                adultnum:{
                    required:true,
                    digits:true
                },
                childnum:{
                    digits:true
                }
            },
            messages: {
                mobile:{
                    required: ""
                },
                checkcode_img:{
                    required:""
                },
                checkcode:{
                    required:"",
                    remote:""
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).attr('style','border:1px solid red');
            },
            unhighlight:function(element, errorClass){
                $(element).attr('style','');
            }
            /* errorPlacement:function(error,element){
             *//* if(!element.is('#checkcode'))
             {
             $(element).parent().append(error)
             }
             else{
             layer.tips('验证码错误', '#checkcode', {
             tips: 3
             });
             }*//*
             }*/
        });
        //查询
        $('.query').click(function(){
            $("#queryfrm").submit();
        })
        //发送短信验证码
        $('.sendmsg').click(function(){
            var mobile = $("#mobile").val();
            var regPartton=/^1[3-8]\d{9}$/;
            if (!regPartton.test(mobile))
            {
                layer.alert('<?php echo __("请输入正确的手机号码");?>', {icon:5});
                return false;
            }
            var check_code_img =  $("#checkcode_img").val();
            if (check_code_img=="")
            {
                layer.alert('<?php echo __("请输入正确的图片验证码");?>', {icon:5});
                return false;
            }
            var t=this;
            var token = "<?php echo $frmcode;?>";
            var url = SITEURL+'search/ajax_send_msgcode';
            t.disabled=true;
            t.value='<?php echo __("发送中...");?>';
            $.post(url,{pcode:check_code_img,mobile:mobile,token:token},function(data) {
                t.value='<?php echo __("发送验证码");?>';
                if(data.status)
                {
                    code_timeout(120);
                    $(".send-txt").show();
                    return false;
                }
                else
                {
                    t.disabled=false;
                    layer.alert(data.msg,{icon:5});
                    return false;
                }
            },'json');
        })
    })
    //短信发送倒计时
    function code_timeout(v){
        if(v>0)
        {
            $('.sendmsg').val((--v)+'<?php echo __("秒");?><?php echo __("后");?><?php echo __("重发");?>');
            setTimeout(function(){
                code_timeout(v)
            },1000);
        }
        else
        {
            $('.sendmsg').val('<?php echo __("重发验证码");?>');
            $('.sendmsg').attr("disabled",false);
        }
    }
</script> </body> </html>
