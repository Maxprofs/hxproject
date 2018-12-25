<!doctype html>
<html>
<head border_font=5sqjwk >
<meta charset="utf-8">
<title>网站Logo</title>
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
                                    <span class="item-hd">编辑器大小{Common::get_help_icon('cfg_admin_htmleditor_width')}：</span>
                                    <div class="item-bd">
                                        <span class="item-text">宽</span>
                                        <input class="input-text w50 ml-5" type="text"  name="cfg_admin_htmleditor_width" id="cfg_admin_htmleditor_width" value="{$config['cfg_admin_htmleditor_width']}" />
                                        <span class="item-text ml-5">px</span>
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

	$(document).ready(function(){



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
            $("#cfg_logodisplay").val(display);
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
                    $('#cfg_backstage_logo').val(src);
                }

            }
        })

        getConfig(0);

     });


       //获取配置
        function getConfig(webid)
        {
            var fields=['cfg_backstage_logo'];
            Config.getConfig(webid,function(data){


                $("#cfg_backstage_logo").val(data.cfg_backstage_logo);
                if(data.cfg_backstage_logo )
                {
                    $("#adimg").attr('src',data.cfg_backstage_logo);
                }
                else
                {
                    $("#adimg").attr('src',SITEURL+'public/images/logo.png');
                }
            },fields)

        }
        //删除图片
        function delad()
        {
            var adfile=$("#cfg_logo").val();
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
                            $("#adimg")[0].src=SITEURL+'public/images/logo.png';
                            $("#cfg_backstage_logo").val('');

                        }
                    }

                });
            }

        }

    </script>

</body>
</html>
