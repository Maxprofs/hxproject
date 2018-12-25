<!doctype html>
<html>
<head body_script=wIACXC >
    <meta charset="utf-8">
    <title>{__('点评')}-{$webname}</title>
    {Common::css('base.css,user.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,jquery.raty.js')}
    <link rel="stylesheet" type="text/css" href="/res/vendor/uploadify/uploadify.css">
    {Common::js('webuploader/webuploader.min.js')}
    {Common::css('res/js/webuploader/webuploader.css',false,false)}
    {Common::css('base.css,user.css,extend.css')}
    <script src="/res/vendor/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
    <style>
        #some_file_queue {
            background-color: #FFF;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.25);
            height: 103px;
            margin-bottom: 10px;
            overflow: auto;
            padding: 5px 10px;
            width: 300px;
        }
        #upload_input{
            height: 86px;
            width: 86px;
            position: absolute;
            top: 0px;
            left: 0px;
            cursor: pointer;
            z-index: 99999;
            opacity: 0;
        }
        .swfupload{
            left: 0;
            top: 0;
        }
    </style>
</head>

<body>

{request "pub/header"}

<div class="big">
    <div class="wm-1200">

        <div class="st-guide">
            <a href="{$cmsurl}">{__('首页')}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;&nbsp;&nbsp;&gt;&nbsp;&nbsp;{__('点评')}
        </div><!--面包屑-->

        <div class="st-main-page">

            {include "member/left_menu"}

            <div class="user-order-box">

                <div class="user-order-plbox">
                    <div class="pl-tit">{__('评价商品')}</div>
                    <div class="pl-con">
                        <div class="pic">
                            <a href="{$info['product']['url']}"><img src="{Common::img($info['product']['litpic'],250,170)}" alt="{$info['productname']}"/><span>{$info['productname']}</span></a></div>
                        <div class="nr">
                            <div class="star-box">
                                {__('综合评分')}：
                                <div id="pl-star" class="pl-star"></div>
                                <div id="pl-hint" class="hint"></div>
                            </div>
                            <div class="txt-area">
                                <textarea name="plcontent" id="plcontent" cols="" rows="" placeholder="{__('请填写你对此产品的评论,至少5个汉字')}"></textarea>
                            </div>
                            <div class="upload-picshow">
                                <div class="upload-tit clearfix">
                                    <strong>{__('晒照片')}</strong>
                                    <span id="pic_count">（{__('最多上传10张')}）</span>
                                </div>
                                <div class="upload-con clearfix">
                                    <ul>
                                        <li class="upload-btn uploadBtn">
                                            <div type="button" name="upload_input" id="upload_input" ></div>
                                            <span>{__('上传图片')}</span>

                                        </li>

                                    </ul>

                                </div>
                            </div>
                            <div class="btn-box">
                                <a class="fb-btn" href="javascript:;">{__('发布评论')}</a>
                                <a class="qx-btn" href="javascript:history.back(-1);">{__('取 消')}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--评论订单-->
        </div>
    </div>
</div>
<input type="hidden" id="frmcode" value="{$frmcode}"/>
<input type="hidden" id="orderid" value="{$info['id']}"/>
<input type="hidden" id="level" value="0"/>

{request "pub/footer"}
{Common::js('layer/layer.js')}
<script>
    $(function(){

        //评分
        $.fn.raty.defaults.path = '/res/images';
        $('#pl-star').raty({
            target    : '#pl-hint',
            targetText: ' ',
            targetKeep: true,
            width     :120,
            hints     : ['{__("很不满意")}', '{__("不满意")}', '{__("一般")}', '{__("满意")}', '{__("非常满意")}'],
            click     :function(score, evt){
                $("#level").val(score);
            }
        });


        $('.fb-btn').click(function(){
            var orderid = $("#orderid").val();
            var frmcode = $("#frmcode").val();
            var plcontent = $("#plcontent").val();
            var level = $("#level").val();
            if(level == 0){
                layer.msg("{__('comment_score_empty')}", {
                    icon: 5,
                    time: 1000

                })
                return false;
            }
            if(plcontent.length<5){
                layer.msg("{__('comment_len_failure')}", {
                    icon: 5,
                    time: 1000

                })
                return false;
            }
            //图片列表
            var piclist = '';
            var $imgs = $(".upload-pic img");
            for(var i=0;i<$imgs.length;i++)
            {
                var $img = $($imgs[i]);
                piclist += ","+$img.attr("src");
            }
            if(piclist.length>0)
            {
                piclist = piclist.substring(1);
            }
            $.ajax({
                type:'POST',
                url:SITEURL+'member/order/ajax_save_pinlun',
                data:{
                    orderid:orderid,
                    frmcode:frmcode,
                    plcontent:plcontent,
                    level:level,
                    piclist:piclist
                },
                dataType:'json',
                success:function(data){
                    if(data.status){
                        layer.msg("{__('comment_success')}", {
                            icon: 6,
                            time: 1000
                        });
                        //评论成功跳转至对应模块的未评价订单
                        location.href = "{$GLOBALS['cfg_basehost']}/member/order/{if $model_info['maintable']=='model_archive'}tongyong{else}plugin_list{/if}?typeid="+data.typeid+"&ordertype=uncomment";
                    }else{
                        layer.msg(data.msg, {
                            icon: 5,
                            time: 1000
                        })
                    }
                }
            })

        })

        upload_pic();
    })

    function upload_pic(){

        var uploader = WebUploader.create({
            // swf文件路径
            auto:true,
            swf: '/res/js/webuploader/Uploader.swf',
            // 文件接收服务端。
            server: '{$cmsurl}comment/upload_pic',
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {id:'#upload_input',label:'上传'},
            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            duplicate:true,
            fileVal:'Filedata',
                'formData'     : {
                'piccount' : ($('.upload-con').find('li').length-1),
                'token' : '{$frmcode}'
            }
        });
        uploader.on( 'uploadSuccess', function( file,response ) {
            if(response){
                var get_data = response;
                if(get_data.code){
                    var ls = $('.upload-pic');
                    if(ls.length<10){
                        var $li=$('<li class="upload-pic"><img width="86" height="86" src="'+get_data.filename+'"/><i class="close-btn"></i></li>');
                        $('.upload-btn').before($li);
                        close_img();
                        pic_count();
                    }
                    else
                    {
                        layer.msg("{__('图片个数超过10个')}",{icon:5});
                        $(".upload-btn").hide();
                    }
                }else{
                    layer.msg(get_data.msg,{icon:5});
                }
            }
        });

        /* $("#upload_input").uploadify({
             'height': 86,
             'width': 86,
             method : 'post',
             'formData'     : {
                 'piccount' : ($('.upload-con').find('li').length-1),
                 'token' : '{$frmcode}',
                 'sessionid':'{session_id()}'
             },
             queueID:'some_file_queue',
             'fileTypeExts':'*.jpg;*.jpeg;*.png',
             'swf'             : '/res/vendor/uploadify/uploadify.swf',
             'uploader'        : '{$cmsurl}comment/upload_pic',
             'button_image_url':'/res/images/aph_bg.png',

             'onUploadSuccess' : function(file, data, response) {
                 if(response){
                     var get_data = $.parseJSON(data);
                     if(get_data.code){
                         var ls = $('.upload-pic');
                         if(ls.length<10){
                             var $li=$('<li class="upload-pic"><img width="86" height="86" src="'+get_data.filename+'"/><i class="close-btn"></i></li>');
                             $('.upload-btn').before($li);
                             close_img();
                             pic_count();
                         }
                         else
                         {
                             layer.msg("图片个数超过10个",{icon:5});
                             $(".upload-btn").hide();
                         }
                     }else{
                         layer.msg(get_data.msg,{icon:5});
                     }
                 }

             }
         });*/
    }

    function close_img(){
        $(".close-btn").unbind('click').click(function(){
            $(this).parent('li').remove();
            $(".upload-btn").show();
            pic_count();
        })
    }

    function pic_count()
    {
        var ls = $('.upload-pic');
        if(ls.length<=0)
        {
            $("#pic_count").html("（{__('最多上传10张')}）");
        }
        else if(ls.length<=10)
        {
            $("#pic_count").html("（{__('还能上传')}"+(10-ls.length)+"{__('张')}）");
        }
        if(ls.length>=10)
        {
            $(".upload-btn").hide();
        }
        else
        {
            $(".upload-btn").show();
        }
    }

</script>

</body>
</html>
