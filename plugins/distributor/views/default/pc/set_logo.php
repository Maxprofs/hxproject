<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>网站Logo</title>
    <script type="text/javascript" src="/{$admindir}/public/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/common.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/jquery.hotkeys.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/msgbox/msgbox.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/extjs/ext-all.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/extjs/locale/ext-lang-zh_CN.js"></script>
    <link type="text/css" href="/{$admindir}/public/js/msgbox/msgbox.css" rel="stylesheet">
    <link type="text/css" href="/{$admindir}/public/css/common.css" rel="stylesheet">
    <link type="text/css" href="/{$admindir}/public/js/extjs/resources/ext-theme-neptune/ext-theme-neptune-all-debug.css" rel="stylesheet">
    {php echo Common::get_skin_css();}
    <script>
        window.SITEURL =  "/{$admindir}/";
        window.PUBLICURL ="/{$admindir}{$GLOBALS['cfg_public_url']}";
        window.BASEHOST="{$GLOBALS['cfg_basehost']}";
        window.WEBLIST =  <?php echo json_encode(array('webid'=>0,'webname'=>'主站')); ?>//网站信息数组
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
    <link type="text/css" href="/{$admindir}/public/css/style.css" rel="stylesheet">
    <link type="text/css" href="/{$admindir}/public/css/base.css" rel="stylesheet">
    <script type="text/javascript" src="/{$admindir}/public/js/config.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/uploadify/jquery.uploadify.min.js?t=3719243"></script>
    <link type="text/css" href="/{$admindir}/public/js/uploadify/uploadify.css" rel="stylesheet">
    <link type="text/css" href="/{$admindir}/public/css/base_new.css" rel="stylesheet">
</head>

<body>

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'pc/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <form id="configfrm">
                    <div class="w-set-con">
                        <div class="cfg-header-bar">
                            <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                        </div>
                        <div class="clear">

                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">网站LOGO<img class="ml-5" style="cursor:pointer;" title="查看帮助cfg_supplier_logo" src="/{$admindir}/public/images/help-ico.png" onclick="ST.Util.helpBox(this,'cfg_supplier_logo',event)">：</span>
                                    <div class="item-bd">

                                        <a href="javascript:;" id="file_upload" class="btn btn-primary radius size-S mt-5">上传图片</a>
                                        <a href="javascript:;" class="btn btn-grey-outline radius size-S mt-5 ml-5" onClick="delad()">恢复默认</a>

                                        <div class="clear logolist pt-10">
                                            <img src="" id="adimg" class="up-img-area" />
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">LOGO链接：</span>
                                    <div class="item-bd">
                                        <input type="text" name="cfg_supplier_logourl" id="cfg_supplier_logourl" class="input-text w900" >
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">LOGO说明：</span>
                                    <div class="item-bd">
                                        <input type="text" name="cfg_supplier_logotitle" id="cfg_supplier_logotitle" class="input-text w900" />
                                    </div>
                                </li>
                            </ul>

                            <div class="clear">
                                <a class="btn btn-primary radius size-L ml-115" href="javascript:;" id="btn_save">保存</a>
                                <input type="hidden" name="webid" id="webid" value="0">
                                <input type="hidden" name="cfg_supplier_logo" id="cfg_supplier_logo" value=""/>
                                <input type="hidden" name="cfg_supplier_logodisplay" id="cfg_supplier_logodisplay" value=""/>
                            </div>

                        </div>
                    </div>
                </form>

            </td>
        </tr>
    </table>

<script>
    $(document).ready(function(){

        //选中导航
        $('.leftnav').find('a').each(function(i,obj){
            var dataUrl = $(obj).data('url');
            if(dataUrl == '/plugins/supplier/set/logo/parentkey/supplier/itemid/1'){
                $(obj).addClass('active');
            }
        })


        //配置信息保存
        $("#btn_save").click(function(){
            var display = '';
            //显示的栏目
            $("input[name='display']").each(function(){
                if($(this).is(':checked'))
                {
                    display=display+$(this).attr('value')+',';
                }
            })
            $("#cfg_supplier_logodisplay").val(display);
            var webid= $("#webid").val();
            Config.saveConfig(webid);
        })

        //文件上传
        var webid=$("#webid").val();

        //上传图片
        $('#file_upload').click(function(){
            ST.Util.showBox('上传logo', SITEURL + 'image/insert_view', 0,0, null, null, parent.document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){

                var temp =result.data[0].split('$$');
                var src = temp[0];
                if(src){
                    $("#adimg").attr('src',src);
                    $('#cfg_supplier_logo').val(src);

                }

            }
        })
        getConfig(0);
    });


    //获取配置
    function getConfig(webid)
    {
        Config.getConfig(webid,function(data){
            $("#cfg_supplier_logourl").val(data.cfg_supplier_logourl);
            $("#cfg_supplier_logotitle").val(data.cfg_supplier_logotitle);
            $("#cfg_supplier_logo").val(data.cfg_supplier_logo);
            $("#cfg_supplier_logodisplay").val(data.cfg_supplier_logodisplay);
            if(data.cfg_supplier_logo!='')
            {
                $("#adimg").attr('src',data.cfg_supplier_logo);
            }
            else
            {
                $("#adimg").attr('src',SITEURL+'public/images/pic_tem.gif');
            }
        })


    }
    //删除图片
    function delad()
    {
        var adfile=$("#cfg_supplier_logo").val();
        var webid = $("#webid").val();
        if(adfile=='')
        {
            ST.Util.showMsg('还没有上传图片',1,1000);
        }
        else
        {
            $.ajax({
                type: "post",
                data: {picturepath:adfile,webid:webid},
                url: SITEURL+"uploader/delpicture",
                success: function(data,textStatus)
                {
                    if(data=='ok')
                    {
                        $("#adimg")[0].src=SITEURL+'public/images/pic_tem.gif';
                        $("#cfg_supplier_logo").val('');

                    }
                }

            });
        }

    }
    //获取logo显示位置
    function getLogoDisplay(webid,displayids)
    {
        $.ajax({
            type: "post",
            data: {logodisplay:displayids,webid:webid},
            url: SITEURL+"config/ajax_getlogodisplay",
            success: function(data,textStatus)
            {
                $("#display_set").html(data)

            }

        });
    }

</script>

</body>
</html>
