<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>微信快速登陆</title>
    <script type="text/javascript" src="/{$admindir}/public/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/common.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/jquery.hotkeys.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/msgbox/msgbox.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/extjs/ext-all.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/extjs/locale/ext-lang-zh_CN.js"></script>
    <link type="text/css" href="/{$admindir}/public/js/msgbox/msgbox.css" rel="stylesheet">
    <link type="text/css" href="/{$admindir}/public/css/common.css" rel="stylesheet">
    <link type="text/css" href="/{$admindir}/public/js/extjs/resources/ext-theme-neptune/ext-theme-neptune-all-debug.css" rel="stylesheet">
    <script>
        window.SITEURL =  "/{$admindir}/";
        window.PUBLICURL ="/{$admindir}/public/";
        window.BASEHOST="{$GLOBALS['cfg_basehost']}";
        window.WEBLIST =  <?php echo json_encode(array(array('webid'=>0,'webname'=>'主站'))); ?>//网站信息数组
        $(function(){
            $.hotkeys.add('f', function(){parent.window.showIndex(); });
            $(document).click(function(e) {
                try{
                    parent.barmenu.close();
                }catch(e)
                {
                }
            });
        })
    </script>
    {Common::get_skin_css()}
    <link type="text/css" href="/{$admindir}/public/css/style.css" rel="stylesheet" />
    <link type="text/css" href="/{$admindir}/public/css/base.css" rel="stylesheet" />
    <script type="text/javascript" src="/{$admindir}/public/js/config.js"></script>
    <link rel="stylesheet" href="/{$admindir}/public/js/artDialog/css/ui-dialog.css"></head>
    <link type="text/css" href="/{$admindir}/public/css/base_new.css" rel="stylesheet" />
<body>
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">
            <!--左侧导航区-->
            <div class="menu-left">
                <div class="global_nav">
                    <div class="kj_tit">微信快速登录</div>
                </div>
                <div class="nav-tab-a leftnav">
                    <a href="javascript:;" class='active'>登录配置</a>
                </div>
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td">
            <form id="configfrm">
                <div class="w-set-con">
                	<div class="cfg-header-bar">
                		<a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                	</div>
                    
                    <div class="w-set-nr">
                        <div class="picture ml-10">
                        	<ul class="info-item-block">
                        		<li>
                        			<span class="item-hd" style="width: 140px !important;">微信公众号：(App ID)</span>
                        			<div class="item-bd" style="padding-left: 145px !important;">
                        				<input type="text" name="cfg_wx_client_appkey" id="cfg_wx_client_appkey" class="input-text w300" >
                        			</div>
                        		</li>
                        		<li>
                        			<span class="item-hd" style="width: 140px !important;">(App Secret)</span>
                        			<div class="item-bd" style="padding-left: 145px !important;">
                        				<input type="text" name="cfg_wx_client_appsecret" id="cfg_wx_client_appsecret" class="input-text w300">
                        			</div>
                        		</li>
                        	</ul>
                            
                        </div>
                        <div class="clear clearfix mt-10">
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

            var webid= 0
            Config.saveConfig(webid);
        })
        getConfig(0);
    });


    //获取配置
    function getConfig(webid)
    {
        Config.getConfig(webid,function(data){
            $("#cfg_wx_client_appkey").val(data.cfg_wx_client_appkey);
            $("#cfg_wx_client_appsecret").val(data.cfg_wx_client_appsecret);
        })
    }

</script>

</body>
</html>
