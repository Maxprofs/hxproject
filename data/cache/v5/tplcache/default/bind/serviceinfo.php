<!doctype html> <html> <head> <meta charset="utf-8"> <title>笛卡CMS<?php echo $coreVersion;?></title> <?php echo Common::css('base.css,base_new.css'); ?> <style type="text/css">
        .key{
            font-size: 16px;
            text-align: center;
        }
        .val{
            font-size: 16px;
        }
    </style> </head> <body style="background-color: #fff"> <table class="content-tab"> <tr> <td valign="top" class="content-rt-td"> <div class="cfg-header-bar"> <span class="w100 fl key">服务网点:</span> <span class="w400 fl val"><?php echo $info['nickname'];?></span> </div> <div class="cfg-header-bar"> <span class="w100 fl key">服务人员:</span> <span class="w400 fl val"><?php echo $info['truename'];?></span> </div> <div class="cfg-header-bar"> <span class="w100 fl key">手机号码:</span> <span class="w400 fl val"><?php echo $info['mobile'];?></span> </div> <div class="cfg-header-bar"> <span class="w100 fl key">座机号码:</span> <span class="w400 fl val"><?php echo $info['phone'];?></span> </div> <div class="cfg-header-bar"> <span class="w100 fl key">邮件地址:</span> <span class="w400 fl val"><?php echo $info['email'];?></span> </div> <div class="cfg-header-bar"> <span class="w100 fl key">联系地址:</span> <span class="w400 fl val"><?php echo $info['address'];?></span> </div> </td> </tr> </table> </body> </html>