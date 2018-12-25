<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>账号登录时长</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript('config.js');}
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>
<body>

	<table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                 {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <div class="cfg-header-bar clearfix">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <form id="configfrm">
                    <div class="w-set-con">
                        <!-- <div class="w-set-tit bom-arrow"> -->
                        <!-- <span class="on"><s></s>网站Logo</span> -->
                        <!-- </div> -->
                        <div class="w-set-nr">
                            <ul class="info-item-block">
                                <li class="rowElem">
                                    <span class="item-hd">账号登录时长{Common::get_help_icon('cfg_admin_login_time_limit')}：</span>
                                    <div class="item-bd">
                                        <input class="input-text w50 ml-5" type="text"  name="cfg_admin_login_time_limit" id="cfg_admin_login_time_limit" value="{$config['cfg_admin_login_time_limit']}" />
                                        <span class="item-text ml-5">小时</span>
                                    </div>
                                </li>
                            </ul>
                            <div class="clear clearfix mt-5">
                                <a class="btn btn-primary size-L radius ml-115" href="javascript:;" id="btn_save">保存</a>
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
        function OnlyNum(obj){
            obj.css("ime-mode", "disabled");
            obj.bind("keypress",function(e) {
                var code = (e.keyCode ? e.keyCode : e.which);  //兼容火狐 IE
                if(!$.browser.msie&&(e.keyCode==0x8))  //火狐下不能使用退格键
                {
                    return ;
                }
                return code >= 48 && code<= 57;
            });
            obj.bind("focus", function() {
                obj.css("ime-mode", "disabled");
            });
            obj.bind("blur", function() {
//                if (obj.value.lastIndexOf(".") == (obj.value.length - 1)) {
//                    obj.value = obj.value.substr(0, obj.value.length - 1);
//                } else if (isNaN(obj.value)) {
//                    obj.value = "";
//                }
                if (/(^0+)/.test(obj.value)) {
                    obj.value = obj.value.replace(/^0*/, '');
                }
            });
            obj.bind("paste", function() {
                return false;
            });
            obj.bind("dragenter", function() {
                return false;
            });
            obj.bind("keyup", function() {
                if (/(^0+)/.test(obj.value)) {
                    obj.value = obj.value.replace(/^0*/, '');
                }
            });
        };

	$(document).ready(function(){
        OnlyNum($("#cfg_admin_login_time_limit"));
        //配置信息保存
        $("#btn_save").click(function(){
            var webid= $("#webid").val();
            var setVal=parseInt($("#cfg_admin_login_time_limit").val());
            if(setVal<=0)
            {
                //设置默认值
                $("#cfg_admin_login_time_limit").val(2);
            }
            Config.saveConfig(webid);
        });



        getConfig(0);

     });


       //获取配置
        function getConfig(webid)
        {
            var fields=['cfg_admin_login_time_limit'];
            Config.getConfig(webid,function(data){
                var login_time_limit=parseInt(data.cfg_admin_login_time_limit);
                if(login_time_limit<=0)
                {
                    login_time_limit=2;
                }
                $("#cfg_admin_login_time_limit").val(login_time_limit);
            },fields)

        }


    </script>

</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201805.2402&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
