<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); }
    {php echo Common::getScript("config.js"); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }

</head>
<body style="overflow:hidden">
<table class="content-tab" script_div=5UCCXC >
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:hidden">
            <form id="configfrm">
                <div class="w-set-con">
                	<div class="cfg-header-bar">
                		<div class="cfg-header-tab conf-title">
                			<span class="item on" data-target="wx">公众号配置</span>
                        	<span class="item" data-target="default">默认分享信息</span>
                		</div>
                		<a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>
                	</div>
                    
                    <div class="w-set-nr">
                        <div class="conf-item conf-item-wx">
                        	<ul class="info-item-block">
                        		<li>
                        			<span class="item-hd" style="width:170px !important">微信公众号：(App ID{Common::get_help_icon('cfg_wx_share_appkey')})</span>
                        			<div class="item-bd" style="padding-left: 175px !important;">
                        				<input type="text" name="cfg_wx_share_appkey" id="cfg_wx_share_appkey" class="input-text w250" >
                        			</div>
                        		</li>
                        		<li>
                        			<span class="item-hd" style="width:170px !important">(App Secret{Common::get_help_icon('cfg_wx_share_appsecret')})</span>
                        			<div class="item-bd" style="padding-left: 175px !important;">
                        				<input type="text" name="cfg_wx_share_appsecret" id="cfg_wx_share_appsecret" class="input-text w250">
                        			</div>
                        		</li>
                        	</ul>
                            
                        </div>
                        
                        <div class="conf-item conf-item-default" style="display: none;">
                        	<ul class="info-item-block">
                        		<li>
                        			<span class="item-hd">图片{Common::get_help_icon('cfg_wx_share_default_litpic')}：</span>
                        			<div class="item-bd">
                        				<a href="javascript:;" id="file_upload" class="btn btn-primary radius size-S mt-5" name="file_upload">上传图片</a>
                        				<span class="item-text c-999 ml-10">页面图片不能获取时使用,建议上传尺寸(至少)300px*300px</span>
                        			</div>
                        		</li>
                        	</ul>
                        	<ul class="info-item-block logolist" style="display: none;">
                        		<li>
                        			<span class="item-hd"></span>
                        			<div class="item-bd">
                        				<img src="" id="adimg" style="margin: 3px;max-height: 100px;max-width: 100px">
                                		<a href="" class="btn-link" onClick="delad()")>删除</a>
                        			</div>
                        		</li>
                        	</ul>
                        	<ul class="info-item-block">
                        		<li>
                        			<span class="item-hd">标题{Common::get_help_icon('cfg_wx_share_default_title')}：</span>
                        			<div class="item-bd">
                        				<input type="text" name="cfg_wx_share_default_title" id="cfg_wx_share_default_title" class="input-text w700" >
                        				<span class="item-text c-999 ml-10">页面标题不能获取时使用</span>
                        			</div>
                        		</li>
                        		<li>
                        			<span class="item-hd">描述{Common::get_help_icon('cfg_wx_share_default_desc')}：</span>
                        			<div class="item-bd">
                        				<input type="text" name="cfg_wx_share_default_desc" id="cfg_wx_share_default_desc" class="input-text w700" >
                        				<span class="item-text c-999 ml-10">页面描述不能获取时使用</span>
                        			</div>
                        		</li>
                        	</ul>
                        </div>
                        <div class="clear clearfix mt-5">
                            <a class="btn btn-primary size-L radius w100 ml-115" href="javascript:;" id="btn_save">保存</a>
                            <input type="hidden" name="cfg_wx_share_default_litpic" id="cfg_logo" value=""/>
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

        //
        $(".conf-title span").click(function(){
            $(this).addClass('on').siblings().removeClass('on');
            $(".conf-item").hide();
            $(".conf-item-"+$(this).data('target')).show();
        });


        $('#file_upload').click(function(){
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, parent.document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){

                var temp =result.data[0].split('$$');
                var src = temp[0];
                if(src){
                    $("#adimg").attr('src',src);
                    $('#cfg_logo').val(src);
                    $(".logolist").show();
                }

            }
        })

      /*  setTimeout(function(){
            $('#file_upload').uploadify({
                'formData'     : {
                    'webid':webid,
                    'thumb':false,
                    uploadcookie:"<?php echo Cookie::get('username')?>"
                },
                'swf'      : PUBLICURL+'js/uploadify/uploadify.swf',
                'uploader' : SITEURL+'uploader/uploadfile',
                'buttonImage' : PUBLICURL+'images/upload-ico.png',
                'fileSizeLimit' : '512KB',
                'fileTypeDesc' : 'Image Files',
                'fileTypeExts' : '*.gif; *.jpg; *.png',
                'cancelImg' : PUBLICURL+'js/uploadify/uploadify-cancel.png',
                'multi' : false,
                'removeCompleted' : true,
                'height':25,
                'width':80,
                'removeTimeout':0.2,
                'wmode ':'transparent',

                onUploadSuccess:function(file,data,response){


                    var obj = $.parseJSON(data);
                    //var obj = eval('('+data+')');
                    if(obj.bigpic!=''){
                        $('#adimg')[0].src=obj.bigpic;
                        $('#cfg_logo').val(obj.bigpic);

                    }

                }

            });
        },10)
        */
        setTimeout(function(){
            $('#file_m_upload').uploadify({
                'formData'     : {
                    'webid':webid,
                    'thumb':1,
                    uploadcookie:"<?php echo Cookie::get('username')?>"
                },
                'swf'      : PUBLICURL+'js/uploadify/uploadify.swf',
                'uploader' : SITEURL+'uploader/uploadfile',
                'buttonImage' : PUBLICURL+'images/upload-ico.png',
                'fileSizeLimit' : '512KB',
                'fileTypeDesc' : 'Image Files',
                'fileTypeExts' : '*.gif; *.jpg; *.png',
                'cancelImg' : PUBLICURL+'js/uploadify/uploadify-cancel.png',
                'multi' : false,
                'removeCompleted' : true,
                'height':25,
                'width':80,
                'removeTimeout':0.2,
                'wmode ':'transparent',

                onUploadSuccess:function(file,data,response){


                    var obj = $.parseJSON(data);
                    //var obj = eval('('+data+')');
                    if(obj.bigpic!=''){
                        $('#m_adimg')[0].src=obj.bigpic;
                        $('#cfg_m_logo').val(obj.bigpic);
                    }

                }

            });
        },20)


    });


    //获取配置
    function getConfig(webid)
    {
        Config.getConfig(webid,function(data){
            $("#cfg_wx_share_appkey").val(data.cfg_wx_share_appkey);
            $("#cfg_wx_share_appsecret").val(data.cfg_wx_share_appsecret);

            $("#cfg_logo").val(data.cfg_wx_share_default_litpic);
            $("#adimg").attr('src',data.cfg_wx_share_default_litpic);
            $("#cfg_wx_share_default_title").val(data.cfg_wx_share_default_title);
            $("#cfg_wx_share_default_desc").val(data.cfg_wx_share_default_desc);
            if(data.cfg_wx_share_default_litpic)
            {
                $(".logolist").show();
            }
        })
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
                       $("#adimg")[0].src='';//"{sline:global.cfg_templets_skin/}/images/pic_tem.gif";
                        $("#cfg_logo").val('');
                        $(".logolist").hide();
                    }
                }

            });
        }

    }

</script>


</body>
</html>
