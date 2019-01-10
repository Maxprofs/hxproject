<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>网站Logo</title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base_new.css'); ?>
    <?php echo Common::getScript('config.js');?>
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
                                <li>
                                    <span class="item-hd">后台Logo <?php echo Common::get_help_icon('cfg_backstage_logo');?>：</span>
                                    <div class="item-bd">
                                        <a href="javascript:;" id="file_upload" class="btn btn-primary radius size-S mt-5">上传图片</a>
                                        <a href="javascript:;" class="btn btn-grey-outline radius size-S mt-5 ml-5" onClick="delad()">恢复默认</a>
                                        <div class="pt-10 clearfix">
                                            <img src="" id="adimg" class="up-img-area " style="background: #e7e7e7">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="clear clearfix mt-5">
                                <a class="btn btn-primary size-L radius ml-115" href="javascript:;" id="btn_save">保存</a>
                                <!-- <a class="cancel" href="#">取消</a>-->
                                <input type="hidden" name="webid" id="webid" value="0">
                                <input type="hidden" name="cfg_backstage_logo" id="cfg_backstage_logo" value=""/>
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
                    $("#adimg").attr('src',SITEURL+'public/images/version-pic.png');
                }
            },fields)
        }
        //删除图片
        function delad()
        {
            var adfile=$("#cfg_backstage_logo").val();
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
                            $("#adimg")[0].src=SITEURL+'public/images/version-pic.png';
                            $("#cfg_backstage_logo").val('');
                        }
                    }
                });
            }
        }
    </script>
</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201803.0102&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
