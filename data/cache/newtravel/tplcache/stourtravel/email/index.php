<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS<?php echo $coreVersion;?>短信平台</title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('style.css,base.css,plist.css,sms_sms.css,base_new.css'); ?>
    <?php echo Common::getScript('common.js,config.js,DatePicker/WdatePicker.js');?>
</head>
<body left_bottom=bmNzDt >
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <!--面包屑-->
                <div class="cfg-header-bar">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <form id="configfrm">
                    <ul class="info-item-block">
                        <li>
                            <span class="item-hd">SMTP服务器<?php echo Common::get_help_icon('cfg_mail_smtp');?>：</span>
                            <div class="item-bd">
                                <input class="input-text w300" type="text" name="cfg_mail_smtp" id="cfg_mail_smtp" value="<?php echo $config['cfg_mail_smtp'];?>"/>
                                <span class="item-text c-999 ml-10"></span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">加密方法<?php echo Common::get_help_icon('cfg_mail_securetype');?>：</span>
                            <div class="item-bd">
                                <span class="select-box w150">
                                    <select class="select" name="cfg_mail_securetype" id="cfg_mail_securetype">
                                        <option value="" <?php if(empty($config['cfg_mail_securetype'])) { ?>selected<?php } ?>
>无</option>
                                        <option value="ssl" <?php if($config['cfg_mail_securetype']=='ssl') { ?>selected<?php } ?>
>SSL</option>
                                        <option value="tls" <?php if($config['cfg_mail_securetype']=='tls') { ?>selected<?php } ?>
>TLS</option>
                                    </select>
                                </span>
                                <span class="item-text c-999 ml-10"></span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">发送端口<?php echo Common::get_help_icon('cfg_mail_port');?>：</span>
                            <div class="item-bd">
                                <input class="input-text w300" type="text" name="cfg_mail_port" id="cfg_mail_port" value="<?php echo $config['cfg_mail_port'];?>"/>
                                <span class="item-text c-999 ml-10"></span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">邮箱地址<?php echo Common::get_help_icon('cfg_mail_address');?>：</span>
                            <div class="item-bd">
                                <input class="input-text w300" type="text" name="cfg_mail_address" id="cfg_mail_address" value="<?php echo $config['cfg_mail_address'];?>"/>
                                <span class="item-text c-999 ml-10"></span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">发件人<?php echo Common::get_help_icon('cfg_mail_fromname');?>：</span>
                            <div class="item-bd">
                                <input class="input-text w300" type="text" name="cfg_mail_fromname" id="cfg_mail_fromname" value="<?php echo $config['cfg_mail_fromname'];?>"/>
                                <span class="item-text c-999 ml-10"></span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">邮箱帐号<?php echo Common::get_help_icon('cfg_mail_user');?>：</span>
                            <div class="item-bd">
                                <input class="input-text w300" type="text" name="cfg_mail_user" id="cfg_mail_user" value="<?php echo $config['cfg_mail_user'];?>"/>
                                <span class="item-text c-999 ml-10"></span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">密码/授权码<?php echo Common::get_help_icon('cfg_mail_pass');?>：</span>
                            <div class="item-bd">
                                <input class="input-text w300" type="password" name="cfg_mail_pass" id="cfg_mail_pass" value="<?php echo $config['cfg_mail_pass'];?>"/>
                                <span class="item-text c-999 ml-10"></span>
                            </div>
                        </li>
                    </ul>
                </form>
                <div class="clear clearfix mt-20">
                    <a href="javascript:;" id="email_save_btn" class="btn btn-primary radius size-L ml-115">保存</a>
                    <a href="javascript:;" id="email_test_btn" class="btn btn-primary radius size-L ml-5">发送邮件测试</a>
                </div>
            </td>
        </tr>
    </table>
<script>
   $(document).ready(function(){
         $('.set-one .short-cut').click(function(){
                 var ele=$(this).parents('.set-one:first').find('.box-con textarea');
                 var value=$(this).attr('data');
                 ST.Util.insertContent(value,ele);
         })
       $("#email_save_btn").click(function(){
           var url = SITEURL+"email/ajax_saveconfig";
           var frmdata = $("#configfrm").serialize();
           $.ajax({
               type:'POST',
               url:url,
               dataType:'json',
               data:frmdata,
               success:function(data){
                   if(data.status==true)
                   {
                       ST.Util.showMsg('保存成功',4);
                   }
                   else
                   {
                       ST.Util.showMsg('保存失败',5,3000);
                   }
               }
           })
       });
       $("#email_test_btn").click(function(){
           ST.Util.showBox('发送测试',SITEURL+'email/dialog_test',400,238);
       });
   })
</script>
</body>
</html>
