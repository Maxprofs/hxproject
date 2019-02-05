<!doctype html> <html> <head div_left=XLFwOs > <meta charset="utf-8"> <title><?php echo __('会员修改密码');?>-<?php echo $webname;?></title> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('user.css,base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,jquery.validate.js');?> <style>
      .confirm-btn{
        background: transparent;;
      }
    </style> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $GLOBALS['cfg_basehost'];?>"><?php echo $GLOBALS['cfg_indexname'];?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo __('修改密码');?> </div><!--面包屑--> <div class="st-main-page"> <?php echo  Stourweb_View::template("member/left_menu");  ?> <div class="user-cont-box"> <form id="changefrm" method="post" action="<?php echo $cmsurl;?>member/index/do_changepwd"> <div class="revise-ps-word"> <h3 class="xg-tit"><?php if(empty($info['pwd'])) { ?><?php echo __('设置密码');?><?php } else { ?><?php echo __('修改密码');?><?php } ?> </h3> <div class="password-xg"> <?php if(!empty($info['pwd'])) { ?> <dl> <dt><?php echo __('当前密码');?>：</dt> <dd> <input type="password" name="oldpwd" id="oldpwd" class="msg-text"/> <span class="msg_contain"></span> </dd> </dl> <?php } ?> <dl> <dt><?php echo __('新密码');?>：</dt> <dd> <input type="password" name="newpwd1" id="newpwd1" class="msg-text"/> <span class="msg_contain"></span> </dd> </dl> <dl> <dt><?php echo __('确认密码');?>：</dt> <dd> <input type="password" name="newpwd2" id="newpwd2" class="msg-text"/> <span class="msg_contain"></span> </dd> </dl> <div class="confirm-btn"><a href="javascript:;"><?php echo __('保存修改');?></a></div> </div> </div><!--修改密码--> <input type="hidden" id="mid" name="mid" value="<?php echo $mid;?>"> <input type="hidden" name="frmcode" value="<?php echo $frmcode;?>"/> <input type="hidden" name="setpwd" value="<?php if(empty($info['pwd'])) { ?>1<?php } else { ?>0<?php } ?>
"> </form> </div> </div> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <script>
     $(function(){
         //导航选中
         $("#nav_safecenter").addClass('on');
         //提交修改
         $('.confirm-btn a').click(function(){
             $('#changefrm').submit();
         })
  jQuery.validator.addMethod("notEqualOld", function (value, element) {
             var oldpwd=$("#oldpwd").val();
            return value==oldpwd?false:true;
         }, '新密码不能与当前密码相同');
         //表单验证
         $('#changefrm').validate({
             rules:{
                 <?php if(!empty($info['pwd'])) { ?>
                    oldpwd:{
                        required:true,
                        minlength:6,
                        remote: {
                            url: SITEURL+'member/index/ajax_check_oldpwd',
                            type: 'post'
                        }
                    },
                <?php } ?>
                    newpwd1:{
                        required:true,
                        minlength:6,
notEqualOld:true
                    },
                    newpwd2:{
                        required:true,
                        equalTo: '#newpwd1'
                    }
                },
             messages: {
                 <?php if(!empty($info['pwd'])) { ?>
                 oldpwd:{
                     required:'<?php echo __("密码不能为空");?>',
                     minlength:'<?php echo __("密码不得小于6位");?>',
                     remote: '<?php echo __("旧密码错误");?>'
                 },
                <?php } ?>
                 newpwd1:{
                     required:'<?php echo __("请输入新密码");?>',
                     minlength:'<?php echo __("密码不得小于6位");?>'
                 },
                 newpwd2:{
                     required:'<?php echo __("密码前后不一致");?>',
                     equalTo:'<?php echo __("密码前后不一致");?>'
                 }
             },
             errorPlacement: function (error, element) {
                 $(element).parent().find('.msg_contain').html(error);
                 $(element).parent().find('.msg_contain').addClass('st-ts-text').removeClass('st-ts-ico');
             },
             success: function (msg, element) {
                 $(element).parent().find('.msg_contain').html('');
                 $(element).parent().find('.msg_contain').addClass('st-ts-ico').removeClass('st-ts-text');
             }/*,
             submitHandler: function (form) {
             }*/
         })
     })
 </script> </body> </html>
