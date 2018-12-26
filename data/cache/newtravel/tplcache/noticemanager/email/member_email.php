<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS<?php echo $coreVersion;?>email平台</title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('style.css,base.css,plist.css,sms_sms.css,base_new.css'); ?>
    <?php echo Common::getScript('common.js,config.js,DatePicker/WdatePicker.js');?>
</head>
<body>
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">
            <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td">
        <div class="cfg-header-bar">
        <a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>
        </div>
            <!--面包屑-->
            
            <form id="msgfrm" head_bottom=z8MzDt >
                <ul class="info-item-block clearfix">
                    <?php $n=1; if(is_array($msg_config_data)) { foreach($msg_config_data as $msg_member_action => $msg_config_value) { ?>
                    <li>
                        <span class="item-hd">
                            <div class="box-tit"><?php echo $msg_member_action;?><?php echo Common::get_help_icon('noticemanager_member_email_'.$msg_config_value['msgtype']);?>：</div>
                         </span>
                         <div class="item-bd">
                             <div class="">
                                <label class="radio-label mr-20"><input type="radio" id="<?php echo $msg_config_value['msgtype'];?>_isopen" name="<?php echo $msg_config_value['msgtype'];?>_isopen" value="1" <?php if($msg_config_value['is_open']=='1') { ?>checked="checked"<?php } ?>
/>开启</label>
                                <label class="radio-label mr-20"><input type="radio" id="<?php echo $msg_config_value['msgtype'];?>_isopen" name="<?php echo $msg_config_value['msgtype'];?>_isopen" value="0" <?php if($msg_config_value['is_open']!='1') { ?>checked="checked"<?php } ?>
/>关闭</label>
                             </div>
                           
                            <textarea class="textarea w900" name="<?php echo $msg_config_value['msgtype'];?>" id="<?php echo $msg_config_value['msgtype'];?>"><?php echo $msg_config_value['templet'];?></textarea>
                             <div class="mt-5">
                                 <?php if($n==1) { ?>
                                 <a href="javascript:;" class="short-cut label-module-cur-item" data="{#WEBNAME#}">网站名称</a>
                                 <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#EMAIL#}">邮箱</a>
                                 <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PASSWORD#}">密码</a>
                                 <?php } ?>
                                 <?php if($n==2) { ?>
                                 <a href="javascript:;" class="short-cut label-module-cur-item" data="{#WEBNAME#}">网站名称</a>
                                 <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#EMAIL#}">邮箱</a>
                                 <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#CODE#}">验证码</a>
                                 <?php } ?>
                                 <?php if($n==3) { ?>
                                 <a href="javascript:;" class="short-cut label-module-cur-item" data="{#WEBNAME#}">网站名称</a>
                                 <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#EMAIL#}">邮箱</a>
                                 <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#CODE#}">验证码</a>
                                 <?php } ?>
                                 <?php if($n==4) { ?>
                                 <a href="javascript:;" class="short-cut label-module-cur-item" data="{#WEBNAME#}">网站名称</a>
                                 <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#EMAIL#}">邮箱</a>
                                 <a href="javascript:;" class="short-cut label-module-cur-item ml-5" data="{#PASSWORD#}">密码</a>
                                 <?php } ?>
                             </div>
                                
                         </div>
                    </li>
                    <?php $n++;}unset($n); } ?>
                </ul>
            </form>
<div class="pt-5">
            <a class="normal-btn btn btn-primary radius size-L ml-115" href="javascript:void(0)">保存</a>
</div>
        </td>
    </tr>
</table>
<script language="javascript">
    $(function(){
        $('.short-cut').click(function(){
            var ele=$(this).parents('.item-bd:first').find('textarea');
            var value=$(this).attr('data');
            ST.Util.insertContent(value,ele);
        });
        $(".normal-btn").click(function(){
            $.ajax({
                url:SITEURL+'noticemanager/ajax_save_email_msg',
                data: $('#msgfrm').serialize(),
                type: "POST",
                dataType:'json',
                success:function(data){
                    if(data.status){
                        ST.Util.showMsg('保存成功',4);
                    }
                    else {
                        ST.Util.showMsg('保存失败',5);
                    }
                }
            })
            return false;
        });
        //文本框的开启与关闭
        $(".tz-type input").click(function(){
            var thisVal=$(this).val();
            if(thisVal=="1"){
                $(this).parents('.tz-type').siblings('.set-one').find('.box-con').show();
            }else{
                $(this).parents('.tz-type').siblings('.set-one').find('.box-con').hide();
            }
        });
    })
</script>
</body>
</html>
