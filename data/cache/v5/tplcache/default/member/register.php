<!doctype html> <html> <head> <meta charset="utf-8"> <title><?php echo __('会员注册');?>-<?php echo $webname;?></title> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('user.css,base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,jquery.validate.js,jquery.cookie.js');?> <link rel="stylesheet" type="text/css" href="/res/js/artDialog7/css/dialog.css"> <script type="text/javascript" src="/res/js/artDialog7/dist/dialog-plus.js"></script> <style type="text/css">
        .reg-cont-box ul{
            height: 243px;
        }
        .ui-dialog-header{
            background-color: #008ed8;
        }
        div.ui-dialog{
            border-color: #2577e3;
            border-top-left-radius:5px;
            border-top-right-radius:5px;
        }
    </style> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="st-userlogin-box" <?php if($GLOBALS['cfg_login_bg']) { ?>style="background: url('<?php echo $GLOBALS['cfg_login_bg'];?>') center top no-repeat;"<?php } ?>
> <div class="st-login-wp"> <div class="st-reg-box"> <div class="reg-tabnav"> <span class="on" data-type="phone"><?php echo __('手机注册');?></span> <i></i> <span data-type="email"><?php echo __('邮箱注册');?></span> </div> <script>
                $(function(){
                    var mid="<?php echo $mid;?>";
                    $('.reg-tabnav span').click(function(){
                        $(this).addClass('on').siblings().removeClass('on');
                        var frm = $(this).attr('data-type');
                        $(".reg-cont-box").find('ul').hide();
                        $('#'+frm+'_reg').show();
                        $('#regfrm').val(frm+'frm');
                        if (mid=='') {
                            $('#phonedid,#emaildid').val('nothing');
                            $('.now-reg-next').css('display','inline');
                            $('.now-reg-btn').css('display','none');
                        }
                    })
                })
            </script> <div class="reg-cont-box"> <form id="phonefrm" method="post" action="<?php echo $cmsurl;?>member/register/doreg"> <ul id="phone_reg"> <li> <span class="bt-sp"><?php echo __('登录帐号');?></span> <input type="text" class="reg-text w230" id="mobile" name="mobile" placeholder="<?php echo __('请输入手机号');?>" /> <span class="msg_contain"></span> </li> <li> <span class="bt-sp"><?php echo __('验证码');?></span> <input type="text" class="reg-text w105" id="p_checkcode" name="p_checkcode" /> <span class="reg-yzm"><img src="<?php echo $cmsurl;?>captcha" width="114" height="31" onClick="this.src=this.src+'?math='+ Math.random()" /></span> <span class="reg-change"><a href="javascript:;"><?php echo __('换一张');?></a></span> <span class="msg_contain"></span> </li> <?php if($msgcode == 'shortmsg') { ?> <li> <span class="bt-sp"><?php echo __('动态密码');?></span> <input type="text" class="reg-text w105" id="msgcode" name="msgcode" /> <input type="button" class="reg-get-pw sendmsg" value="<?php echo __('获取验证码');?>"> <span class="msg_contain"></span> </li> <?php } ?> <li> <span class="bt-sp"><?php echo __('密码');?></span> <input type="password" name="password1" id="password1" class="reg-text w230" placeholder="<?php echo __('请输入登录密码');?>" /> <span class="msg_contain"></span> <span class="complex_contain"></span> </li> <li> <span class="bt-sp"><?php echo __('确认密码');?></span> <input type="password" name="password2" id="password2" class="reg-text w230" placeholder="<?php echo __('请再次输入登录密码');?>" /> <span class="msg_contain"></span> </li> <li> <?php if(!empty($GLOBALS['cfg_member_agreement_open'])) { ?> <div class="agree-term"> <span class="fl"> <input type="checkbox" name="agreement" id="agreement" checked /><?php echo __('同意');?><a href="javascript:;" class="show_agreement" target="_blank">《<?php echo $GLOBALS['cfg_member_agreement_title'];?>》</a></span> <span class="msg_contain"></span> </div> <?php } ?> </li> </ul> <input type="hidden" name="frmcode" value="<?php echo $frmcode;?>"/> <input type="hidden" name="regtype" value="phone"/> <?php 
                    if (isset($mid)) {
                        echo '<input type="hidden" id="phonedid" name="did" value="'.$mid.'"/>';
                    }else{
                        echo '<input type="hidden" id="phonedid" name="did" value="nothing"/>';
                    }
                 ?> </form> <!--邮箱登陆--> <form id="emailfrm" method="post" action="<?php echo $cmsurl;?>member/register/doreg"> <ul id="email_reg" style="display: none"> <li> <span class="bt-sp"><?php echo __('登录帐号');?></span> <input type="text" class="reg-text w230" id="email" name="email" placeholder="<?php echo __('请输入邮箱帐号');?>" /> <span class="msg_contain"></span> </li> <li> <span class="bt-sp"><?php echo __('验证码');?></span> <input type="text" class="reg-text w105" id="e_checkcode" name="e_checkcode" /> <span class="reg-yzm"><img src="<?php echo $cmsurl;?>captcha" onClick="this.src=this.src+'?math='+ Math.random()" width="114" height="31" /></span> <span class="reg-change"><a href="javascript:;"><?php echo __('换一张');?></a></span> <span class="msg_contain"></span> </li> <?php if($emailcode == 1) { ?> <li> <span class="bt-sp"><?php echo __('邮箱验证码');?></span> <input type="text" class="reg-text w105" id="e_email_code" name="e_email_code" /> <input type="button" class="reg-get-pw sendemail" value="<?php echo __('获取验证码');?>"> <span class="msg_contain"></span> </li> <?php } ?> <li> <span class="bt-sp"><?php echo __('密码');?></span> <input type="password" class="reg-text w230" name="e_password1" id="e_password1" placeholder="<?php echo __('请输入登录密码');?>" /> <span class="msg_contain"></span> <span class="complex_contain"></span> </li> <li> <span class="bt-sp"><?php echo __('确认密码');?></span> <input type="password" name="e_password2" id="e_password2" class="reg-text w230" placeholder="<?php echo __('请再次输入登录密码');?>" /> <span class="msg_contain"></span> </li> <li> <?php if(!empty($GLOBALS['cfg_member_agreement_open'])) { ?> <div class="agree-term"> <span class="fl"> <input type="checkbox" name="e_agreement" id="e_agreement" checked /><?php echo __('同意');?> <a href="javascript:;" class="show_agreement" target="_blank">《<?php echo $GLOBALS['cfg_member_agreement_title'];?>》</a> </span> <span class="msg_contain"></span> </div> <?php } ?> </li> <input type="hidden" name="frmcode" value="<?php echo $frmcode;?>"/> <input type="hidden" name="regtype" value="email"/> <?php 
                    if (isset($mid)) {
                        echo '<input type="hidden" id="emaildid" name="did" value="'.$mid.'"/>';
                    }else{
                        echo '<input type="hidden" id="emaildid" name="did" value="nothing"/>';
                    }
                 ?> </ul> </form> <?php 
                if (isset($mid)) {
                    echo '<div class="now-reg-btn"><a href="javascript:;">立即注册</a></div>';
                }else{
                    echo '<div class="now-reg-next"><button id="next" >下一步</button></div>';
                    echo '<div class="now-reg-btn" style="display:none"><a href="javascript:;">立即注册</a></div>';
                }
            ?> </div> <div class="reg-tig-box"> <p>已有账号，<a href="/member/login">立即登录</a></p> <!--           <dl> <dt>使用其他方式登录</dt> <dd> <?php if((!empty($GLOBALS['cfg_qq_appid']) && !empty($GLOBALS['cfg_qq_appkey']))) { ?> <a class="qq qqlogin" href="<?php echo $GLOBALS['cfg_basehost'];?>/plugins/login_qq/index/index/?refer=<?php echo urlencode($backurl);?>">QQ</a> <?php } ?> <?php if((!empty($GLOBALS['cfg_weixi_appkey']) && !empty($GLOBALS['cfg_weixi_appsecret']))) { ?> <a class="wx wxlogin" href="<?php echo $GLOBALS['cfg_basehost'];?>/plugins/login_weixin/index/index/?refer=<?php echo urlencode($backurl);?>">wx</a> <?php } ?> <?php if((!empty($GLOBALS['cfg_sina_appkey']) && !empty($GLOBALS['cfg_sina_appsecret']))) { ?> <a class="wb wblogin" href="<?php echo $GLOBALS['cfg_basehost'];?>/plugins/login_weibo/index/index/?refer=<?php echo urlencode($backurl);?>">wb</a> <?php } ?> </dd> </dl> --> </div> </div> </div> </div> <input type="hidden" id="regfrm" value="phonefrm"/> <input type="hidden" id="backurl" value="<?php echo $backurl;?>"/> <?php echo Common::js('layer/layer.js');?> <script>
window.d = null;
//弹出框
/*
  params为附加参数，可以是与dialog有关的所有参数，也可以是自定义参数
  其中自定义参数里有
  loadWindow: 表示回调函数的window
  loadCallback: 表示回调函数
  maxHeight:指定最高高度
 */
function floatBox(boxtitle, url, boxwidth, boxheight, closefunc, nofade,fromdocument,params) {
    boxwidth = boxwidth != '' ? boxwidth : 0;
    boxheight = boxheight != '' ? boxheight : 0;
    var func = $.isFunction(closefunc) ? closefunc : function () {
    };
    fromdocument = fromdocument ? fromdocument : null;//来源document
    var initParams={
        url: url,
        title: boxtitle,
        width: boxwidth,
        height: boxheight,
        scroll:0,
        loadDocument:fromdocument,
        onclose: function () {
            func();
        }
    }
    initParams= $.extend(initParams,params);
    var dlg = dialog(initParams);
    if(typeof(dlg.loadCallback)=='function'&&typeof(dlg.loadWindow)=='object')
    {
       dlg.finalResponse=function(arg,bool,isopen){
            dlg.loadCallback.call(dlg.loadWindow,arg,bool);
            if(!isopen)
              this.remove();
       }
    }
    window.d=dlg;
    d.close()
    if (initParams.width != 0) {
        d.width(initParams.width);
    }
    if (initParams.height!= 0) {
        d.height(initParams.height);
    }
  
    if (nofade) {
        d.show()
    } else {
        d.showModal();
    }
}
    function bindbox(){
        var url=SITEURL+"distributor/pc/distributor/bind";
        floatBox('绑定服务网点',url,'590','240');
        // window.dialog.show()
    }
     $(function(){
        $('.now-reg-next').click(function(event) {
            /* Act on the event */
            // phonefrm emailfrm
            bindbox()
            // $('.now-reg-next').css('display','none');
            // $('.now-reg-btn').css('display','inline');
        });
         //注册
        $('.now-reg-btn').click(function(){
            var name=$('.on').attr('data-type')+'frm';
            $('#'+name).submit()
        });
         //验证码刷新
         $('.reg-change').click(function(){
             $(this).parents('li').first().find('img').trigger('click');
         })
         //发送短信验证码
         $('.sendmsg').click(function(){
             var mobile = $("#mobile").val();
             var regPartton=/^1+\d{10}$/;
             if (!regPartton.test(mobile))
             {
                 layer.alert('请输入正确的手机号码', {icon:5});
                 return false;
             }
             var pcode = $("#p_checkcode").val();
             if(pcode==''){
                 layer.alert('请填写验证码', {icon:5});
                 return false;
             }
 
 var bool = true;
 $.ajax({
                 url: SITEURL + 'member/register/ajax_reg_checkmobile',
 type: "POST",
                 async: false,
                 cache: false,
                 data: {mobile:mobile},
                 dataType: 'text',
                 success:function (msg) {
 console.log(msg);
                     if(msg == 'false')
                     {
 bool = false;
                     }
                 }
             });
 if(!bool){
layer.alert('手机号已经注册,请直接登录', {icon:5});
return false;
 }
 
 
             var t=this;
             //发送次数判断
             var sendnum = $.cookie('sendnum') ? $.cookie('sendnum') : 0;
             if(sendnum>3){
                 layer.alert("验证码发送请求过于频繁,请过15分钟后再试",{icon:5});
                 return false;
             }
             if(sendnum!=0){
                 $.cookie('sendnum', sendnum++);
             }else{
                 $.cookie('sendnum', 1,{ expires: 1/96 });
             }
             var token = "<?php echo $frmcode;?>";
             var url = SITEURL+'member/register/ajax_send_msgcode';
             t.disabled=true;
             t.value="发送中...";
             $.post(url,{mobile:mobile,token:token,pcode:pcode},function(data) {
                 t.value="获取验证码";
                 if(data.status)
                 {
                     code_timeout(120);
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
         //发送邮箱验证码
         $('.sendemail').click(function(){
             var email = $("#email").val();
             var regPartton=/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
             if (!regPartton.test(email))
             {
                 layer.alert('请输入正确的邮箱', {icon:5});
                 return false;
             }
             var pcode = $("#e_checkcode").val();
             if(pcode==''){
                 layer.alert('请填写验证码', {icon:5});
                 return false;
             }
             var t=this;
             var token = "<?php echo $frmcode;?>";
             var url = SITEURL+"member/register/ajax_send_emailcode";
             var sendnum = $.cookie('email_sendnum') ? $.cookie('email_sendnum') : 0;
             if(sendnum>3){
                 layer.alert('验证码发送请求过于频繁,请过15分钟后再试', {icon:5});
                 return false;
             }
             if(sendnum!=0){
                 $.cookie('email_sendnum', sendnum++);
             }else{
                 $.cookie('email_sendnum', 1,{ expires: 1/96 });
             }
             t.disabled=true;
             t.value="发送中...";
             $.post(url,{email:email,token:token,pcode:pcode},function(data) {
                 t.value="获取验证码";
                 if(data.status)
                 {
                     email_code_timeout(120);
                     return false;
                 }
                 else
                 {
                     t.disabled=false;
                     layer.alert(data.msg, {icon:5});
                     return false;
                 }
             },'json');
         });
         /*手机注册验证开始*/
         jQuery.validator.addMethod("mobile",function(value, element){
             var pattern=/^1+\d{10}$/;
             return pattern.test(value);
         },"请输入正确的手机号");
         $("#phonefrm").validate({
             rules: {
                 'mobile': {
                     required: true,
                     mobile: true,
                     remote: {
                         url: SITEURL+'member/register/ajax_reg_checkmobile',
                         type: 'post'
                     }
                 },
                 'password1': {
                     required: true,
                     minlength: 6
                 },
                 'password2': {
                     required: true,
                     equalTo: '#password1'
                 },
                 'p_checkcode': {
                     required: true,
                     remote:{
                         url: SITEURL+'pub/ajax_check_code',
                         type:'post',
                         data:{
                             checkcode:function(){
                                 return $("#p_checkcode").val();
                             }
                         }
                     }
                 },
                 'msgcode':{
                     required:true,
                     remote:{
                         url: SITEURL+'member/register/ajax_check_msgcode',
                         type: 'post',
                         data: {
                             mobile: function() {
                                 return $( "#mobile" ).val();
                             }
                         }
                     }
                 },
                 agreement:{
                     required:true
                 }
             },
             messages: {
                 'mobile':{
                     required:'手机号不能为空',
                     remote:'该手机号已被注册,您可以<a href="/member/login">直接登陆</a>'
                 },
                 'password1':{
                     required:'密码不能为空',
                     minlength:'密码不得小于6位'
                 },
                 'password2':{
                     required:'密码前后不一致',
                     equalTo:'密码前后不一致'
                 },
                 'p_checkcode':{
                     required:'验证码不能为空',
                     remote:'验证码错误'
                 },
                 'msgcode':{
                     required:'验证码不能为空',
                     remote:'验证码错误'
                 },
                 'agreement':{
                     required:'请先同意网站服务条款'
                 }
             },
            errorPlacement: function (error, element) {
                $(element).parents('li:first').find('.msg_contain').html(error);
                $(element).parents('li:first').find('.msg_contain').addClass('reg-error-txt').removeClass('reg-pass-ico');
            },
            success: function (msg, element) {
                $(element).parents('li:first').find('.msg_contain').html('');
                $(element).parents('li:first').find('.msg_contain').addClass('reg-pass-ico').removeClass('reg-error-txt');
                if($(element).is('#password1'))
                {
                    set_pwd_safe('#phonefrm','#password1');
                }
            },
            onkeyup:function(element,event)
            {
                set_pwd_safe('#phonefrm','#password1');
                $(element).valid();
            },
            submitHandler: function (form) {
                var frmdata = $("#phonefrm").serialize();
                $.ajax({
                    type:'POST',
                    url:SITEURL+'member/register/ajax_doreg',
                    data:frmdata,
                    dataType:'json',
                    success:function(data){
                        if(data.status){
                            var url = $("#backurl").val();
                            $('body').append(data.js);//同步登陆js
                            layer.msg(data.msg, {
                                icon: 6,
                                time: 1000
                            })
                            setTimeout(function(){window.open(url,'_self');},500);
                        }else{
                            layer.msg(data.msg, {
                                icon: 5,
                                time: 1000
                            })
                        }
                    }
                })
            }
        });
        //邮箱注册验证
        $("#emailfrm").validate({
            rules: {
                'email': {
                    required: true,
                    email: true,
                    remote: {
                        url: SITEURL+'member/register/ajax_check_email',
                        type: 'post'
                    }
                },
                'e_password1': {
                    required: true,
                    minlength: 6
                },
                'e_password2': {
                    required: true,
                    equalTo: '#e_password1'
                },
                'e_checkcode':{
                    required: true,
                    remote:{
                        url: SITEURL+'pub/ajax_check_code',
                        type:'post',
                        data:{
                            checkcode:function(){
                                return $("#e_checkcode").val();
                            }
                        }
                    }
                },
                e_email_code:{
                    required:true,
                    remote:{
                        url: SITEURL+'member/register/ajax_check_email_code',
                        type: 'post',
                        data: {
                            email: function() {
                                return $("#email" ).val();
                            }
                        }
                    }
                },
                'e_agreement':{
                    required:true
                }
            },
            messages: {
                'email':{
                    required:'邮箱不能为空',
                    email:'邮箱格式错误',
                    remote:'该邮箱已经被注册,您可以<a href="/member/login">直接登陆</a>'
                },
                'e_password1':{
                    required:'密码不能为空',
                    minlength:'密码不得小于6位'
                },
                'e_password2':{
                    required:'密码前后不一致',
                    equalTo:'密码前后不一致'
                },
                'e_email_code':{
                    required:'邮箱验证码不能为空',
                    remote:'邮箱验证码错误'
                },
                'e_checkcode':{
                    required:'验证码不能为空',
                    remote:'验证码错误'
                },
                'e_agreement':{
                    required:'请先同意网站服务条款'
                }
            },
            errorPlacement: function (error, element) {
                $(element).parents('li:first').find('.msg_contain').html(error);
                $(element).parents('li:first').find('.msg_contain').addClass('reg-error-txt').removeClass('reg-pass-ico');
            },
            success: function (msg, element) {
                $(element).parents('li:first').find('.msg_contain').html('');
                $(element).parents('li:first').find('.msg_contain').addClass('reg-pass-ico').removeClass('reg-error-txt');
                if($(element).is('#e_password1')){
                    set_pwd_safe('#emailfrm','#e_password1');
                }
            },
            onkeyup:function(element,event)
            {
                set_pwd_safe('#emailfrm','#e_password1');
                $(element).valid();
            },
            submitHandler: function (form) {
                var frmdata = $("#emailfrm").serialize();
                $.ajax({
                    type:'POST',
                    url:SITEURL+'member/register/ajax_doreg',
                    data:frmdata,
                    dataType:'json',
                    success:function(data){
                        if(data.status){
                            var url = $("#backurl").val();
                            $('body').append(data.js);//同步登陆js
                            layer.msg(data.msg, {
                                icon: 6,
                                time: 1000
                            })
                            setTimeout(function(){window.open(url,'_self');},500);
                        }else{
                            layer.msg(data.msg, {
                                icon: 5,
                                time: 1000
                            })
                        }
                    }
                })
            }
        });
    })
    //密码强度
    function set_pwd_safe(pselector,selector){
         var pwd=$(pselector+' '+selector).val();
         var pattern_1=/^[0-9]*$/i;
         var pattern_2=/[a-z0-9]+/i;
         var obj = $(pselector).find('.complex_contain');
         var html = '';
         //弱
         if(pattern_1.test(pwd)&&pwd.length<8)
         {
             html = "<span class='reg-pw-intensity ruo'>弱</span>";
             obj.html(html);
             return false;
         }
         //中
         if(pattern_1.test(pwd)&&pwd.length>=8)
         {
             html = "<span class='reg-pw-intensity zhong'>中</span>";
             obj.html(html);
             return false;
         }
         //高
         if(pattern_2.test(pwd)&&pwd.length>=8)
         {
             html = "<span class='reg-pw-intensity gao'>高</span>";
             obj.html(html);
             return false;
         }
    }
     //短信发送倒计时
     function code_timeout(v){
         if(v>0)
         {
             $('.sendmsg').val((--v)+'秒后重发');
             setTimeout(function(){
                 code_timeout(v)
             },1000);
         }
         else
         {
             $('.sendmsg').val('重发验证码');
             $('.sendmsg').attr("disabled",false);
         }
     }
     //邮箱发送倒计时
     function email_code_timeout(v){
         if(v>0)
         {
             $('.sendemail').val((--v)+'秒后重发');
             setTimeout(function(){
                 email_code_timeout(v)
             },1000);
         }
         else
         {
             $('.sendemail').val('重发验证码');
             $('.sendemail').attr("disabled",false);
         }
     }
 </script> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php if(!empty($GLOBALS['cfg_member_agreement_open'])) { ?> <div class="layer-wrap-content" style="display: none"> <div class="agreement-term-content"> <div class="agreement-term-tit"><strong><?php echo $GLOBALS['cfg_member_agreement_title'];?></strong><i class="close-ico"></i></div> <div class="agreement-term-block"> <h3 class="agreement-bt">《<?php echo $GLOBALS['cfg_member_agreement_title'];?>》</h3> <div class="agreement-nr"> <?php echo $GLOBALS['cfg_member_agreement'];?> </div> </div> </div> </div> <script>
     $(function(){
         //关闭注册协议
         $(".close-ico").click(function(){
             $('.layer-wrap-content').hide();
         })
         //显示协议
         $('.show_agreement').click(function(){
             $('.layer-wrap-content').show();
         })
     })
 </script> <?php } ?> </body> </html>
