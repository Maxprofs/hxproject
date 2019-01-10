<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title color_right=rULzDt >系统参数</title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('style.css,base.css,jqtransform.css,base_new.css'); ?>
    <?php echo Common::getScript('config.js,jquery.jqtransform.js,jquery.colorpicker.js');?>
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
                <form id="configfrm">
                    <div class="w-set-con">
                    
                        <div class="cfg-header-bar">
                            <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                        </div>
                        
                        <div class="w-set-nr">
                            <div class="info-item-block">
                                <li class="rowElem">
                                    <span class="item-hd">CSS/JS压缩<?php echo Common::get_help_icon('cfg_compress_open');?>：</span>
                                    <div class="item-bd">
                                        <label class="radio-label"><input type="radio" name="cfg_compress_open" value="1" <?php if($config['cfg_compress_open']==1) { ?>checked<?php } ?>
>开启</label>
                                        <label class="radio-label ml-20"><input type="radio" name="cfg_compress_open" value="0" <?php if($config['cfg_compress_open']==0) { ?>checked<?php } ?>
>关闭</label>
                                        <span class="item-text va-t c-999 ml-20">*开启：打包合并压缩CSS/JS文件，减少加载次数；关闭：独立调取每个文件，加载一个调取一次</span>
                                    </div>
                                </li>
                                <li class="rowElem">
                                    <span class="item-hd">服务端缓存<?php echo Common::get_help_icon('cfg_cache_open');?>：</span>
                                    <div class="item-bd">
                                        <label class="radio-label"><input type="radio" name="cfg_cache_open" value="1" <?php if($config['cfg_cache_open']==1) { ?>checked<?php } ?>
>开启</label>
                                        <label class="radio-label ml-20"><input type="radio" name="cfg_cache_open" value="0" <?php if($config['cfg_cache_open']==0) { ?>checked<?php } ?>
>关闭</label>
                                        <span class="item-text va-t c-999 ml-20">*开启：服务端将缓存访问数据，定期自动更新；关闭：服务端不缓存访问数据，每次从服务器获取最新数据</span>
                                    </div>
                                </li>
                                <li class="rowElem">
                                    <span class="item-hd">登录下单<?php echo Common::get_help_icon('cfg_login_order');?>：</span>
                                    <div class="item-bd">
                                        <label class="radio-label"><input type="radio" name="cfg_login_order" value="1" <?php if($config['cfg_login_order']==1) { ?>checked<?php } ?>
>开启</label>
                                        <label class="radio-label ml-20"><input type="radio" name="cfg_login_order" value="0" <?php if($config['cfg_login_order']==0) { ?>checked<?php } ?>
>关闭</label>
                                        <span class="item-text va-t c-999 ml-20">*开启：只能登录后才能下订单；关闭：不登录即可下订单，后台会默认将联系人手机注册成为会员，并通知该手机号码。</span>
                                    </div>
                                </li>
                                <li class="rowElem">
                                    <span class="item-hd">后台常用菜单<?php echo Common::get_help_icon('cfg_quick_menu');?>：</span>
                                    <div class="item-bd">
                                        <label class="radio-label"><input type="radio"  name="cfg_quick_menu" value="1" <?php if($config['cfg_quick_menu']=='1') { ?>checked<?php } ?>
>开启</label>
                                        <label class="radio-label ml-20"><input type="radio"  name="cfg_quick_menu" value="0" <?php if(empty($config['cfg_quick_menu'])) { ?>checked<?php } ?>
>关闭</label>
                                        <span class="item-text va-t c-999 ml-20">*开启：后台首页显示快捷菜单模块；关闭：后台首页不显示快捷菜单模块</span>
                                    </div>
                                </li>
                            </div>
                            <div class="clear clearfix">
                                <a class="btn btn-primary radius size-L ml-115" href="javascript:;" id="btn_save">保存</a>
                                <input type="hidden" name="webid" id="webid" value="0">
                            </div>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
  </table>
  
  
<script>
$(document).ready(function(){
        //配置信息保存
        $("#btn_save").click(function(){
            //var webid= $("#webid").val();
            Config.saveConfig(0);
        });
    })
    </script>
</body>
</html>
