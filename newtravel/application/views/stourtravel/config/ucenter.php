<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ucenter设置</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript('config.js');}
</head>
<body>

	<table class="content-tab" margin_size=5MM8Zk >
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <form id="configfrm">
                    <div class="w-set-con">
                    	<div class="cfg-header-bar">
                    		<a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    	</div>
        
                        <div class="w-set-nr">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">是否启用</span>
                                    <div class="item-bd">
                                        <label class="radio-label ml-20"><input type="radio" name="cfg_uc_open" value="1" {if $config['cfg_uc_open']==1}checked{/if}>开启</label>
                                        <label class="radio-label ml-20"><input type="radio" name="cfg_uc_open" value="0" {if $config['cfg_uc_open']==0}checked{/if}>关闭</label>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">Api地址：</span>
                                    <div class="item-bd">
                                        <input type="text" name="cfg_uc_url" id="cfg_uc_url" class="input-text w300" value="{$config['cfg_uc_url']}" >
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">Ip地址：</span>
                                    <div class="item-bd">
                                        <input type="text" name="cfg_uc_ip" id="cfg_uc_ip" class="input-text w300" value="{$config['cfg_uc_ip']}" >
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">数据库主机名：</span>
                                    <div class="item-bd">
                                        <input type="text" name="cfg_uc_host" id="cfg_uc_host" class="input-text w300" value="{$config['cfg_uc_host']}" >
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">数据库用户名：</span>
                                    <div class="item-bd">
                                        <input type="text" name="cfg_uc_user" id="cfg_uc_user" class="input-text w300" value="{$config['cfg_uc_user']}" >
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">数据库密码：</span>
                                    <div class="item-bd">
                                        <input type="password" name="cfg_uc_pwd" id="cfg_uc_pwd" class="input-text w300" value="{$config['cfg_uc_pwd']}" >
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">数据库名称：</span>
                                    <div class="item-bd">
                                        <input type="text" name="cfg_uc_db" id="cfg_uc_db" class="input-text w300" value="{$config['cfg_uc_db']}" >
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">数据表前辍：</span>
                                    <div class="item-bd">
                                        <input type="text" name="cfg_uc_dbprefix" id="cfg_uc_dbprefix" class="input-text w300" value="{$config['cfg_uc_dbprefix']}" >
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">数据库字符集：</span>
                                    <div class="item-bd">
                                        <span class="select-box w150">
                                            <select class="select" name="cfg_uc_charset" id="cfg_uc_charset">
                                                <option value="UTF-8" {if $config['cfg_uc_charset']=='UTF-8' }selected="selected"{/if}>UTF-8</option>
                                                <option value="GBK" {if $config['cfg_uc_charset']=='GBK' }selected="selected"{/if}>GBK</option>
                                            </select>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                  <span class="item-hd">应用ID：</span>
                                    <div class="item-bd">
                                        <input type="text" name="cfg_uc_appid" id="cfg_uc_appid" class="input-text w300" value="{$config['cfg_uc_appid']}" >
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">通信密钥：</span>
                                    <div class="item-bd">
                                        <input type="text" name="cfg_uc_key" id="cfg_uc_key" class="input-text w500" value="{$config['cfg_uc_key']}" >
                                    </div>
                                </li>
                            </ul>

                            <div class="clear clearfix mt-20">
                                <a class="btn btn-primary radius size-L ml-115" href="javascript:;" id="btn_save">保存</a>
                                <!-- <a class="cancel" href="#">取消</a>-->
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

            var webid= 0
            Config.saveConfig(webid);
            var url = SITEURL+"config/ajax_save_ucenter";
            var frmdata = $("#configfrm").serialize();
            $.ajax({
                type:'POST',
                url:url,
                dataType:'json',
                data:frmdata,
                success:function(data){


                }
            })
        })


     });


    </script>

</body>
</html>
