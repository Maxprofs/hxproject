<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>支付设置</title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('style.css,base.css,payset.css,base_new.css'); ?>
    <?php echo Common::getScript("uploadify/jquery.uploadify.min.js"); ?>
    <?php echo Common::getCss('uploadify.css','js/uploadify/'); ?>
</head>
<body>
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">
            <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td">
            <div class="w-set-con">
            <div class="cfg-header-bar">
            <a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>
            </div>
                
                <div class="w-set-nr">
                    <form id="frm">
                    <ul class="info-item-block">
                    <li>
                    <span class="item-hd">是否开启：</span>
                    <div class="item-bd">
                    <label class="radio-label mr-20"><input type="radio" <?php if($payset['isopen']==1) { ?>checked="checked"<?php } ?>
 name="isopen" value="1" />开启</label>
                    <label class="radio-label mr-20"><input type="radio" name="isopen" value="0" <?php if($payset['isopen']==0) { ?> checked="checked"<?php } ?>
/>关闭</label>
                    </div>
                    </li>
                    <li>
                    <span class="item-hd">公众帐号ID<?php echo Common::get_help_icon('payset_weixin_appid');?>：</span>
                    <div class="item-bd">
                    <input name="appid" type="text" value="<?php echo $config['appid'];?>"  class="input-text w300">
                    </div>
                    </li>
                    <li>
                    <span class="item-hd">APPSECRET<?php echo Common::get_help_icon('payset_weixin_appsecret');?>：</span>
                    <div class="item-bd">
                    <input name="appsecret" type="text" value="<?php echo $config['appsecret'];?>" class="input-text w300">
                    </div>
                    </li>
                    <li>
                    <span class="item-hd">商户号<?php echo Common::get_help_icon('payset_weixin_mchid');?>：</span>
                    <div class="item-bd">
                    <input name="mchid" type="text" value="<?php echo $config['mchid'];?>" id="cfg_wxpay_mchid" class="input-text w300">
                    </div>
                    </li>
                    <li>
                    <span class="item-hd">API密钥<?php echo Common::get_help_icon('payset_weixin_mchkey');?>：</span>
                    <div class="item-bd">
                    <input name="mchkey" type="text" value="<?php echo $config['mchkey'];?>" class="input-text w300">
                    </div>
                    </li>
                    <li>
                    <span class="item-hd">排序<?php echo Common::get_help_icon('payset_displayorder');?>：</span>
                    <div class="item-bd">
                    <input name="displayorder" type="text" value="<?php echo $payset['displayorder'];?>" id="displayorder" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,'')" class="input-text w300">
                    </div>
                    </li>
                    </ul>
                        <div class="pt-5">
                        <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                        <input type="hidden" name="payid" value="<?php echo $payset['id'];?>"/>
                </div>
                        
                        
                    </form>
                </div>
            </div>
        </td>
    </tr>
</table>
<script>
    $(document).ready(function(){
        $("#btn_save").click(function(){
            $.ajaxform({
                url : SITEURL + "wxh5/admin/wxh5/ajax_save_config",
                method  :  "POST",
                form  : "#frm",
                dataType:'json',
                success  :  function(data)
                {
                    if(data.status)
                    {
                        ST.Util.showMsg('保存成功!','4',2000);
                    }
                    else
                    {
                        ST.Util.showMsg(data.msg,'5',2000);
                    }
                }
            });
        });
        //上传文件
    });
</script>
</body>
</html>
