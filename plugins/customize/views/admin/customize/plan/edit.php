<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("jquery.validate.js,jquery.upload.js"); }
    {php echo Common::getScript("choose.js,product_add.js,imageup.js"); }

    {php echo Common::getScript("datetimepicker/jquery.datetimepicker.full.js"); }
    {php echo Common::getCss('jquery.datetimepicker.css','js/datetimepicker/'); }
   <style>
       #linedoc-content{line-height: 30px; clear: both;}
       #linedoc-content span{ padding-right:5px;}
       #linedoc-content a.del{ color: #f00;margin: 0 5px;}
       #linedoc-content a.del:hover{text-decoration:underline }
        .error{
            color:red;
            padding-left:5px;
        }
    </style>
</head>
<body>

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <form id="frm" name="frm">
                    <div class="cfg-header-bar">
                        <div class="cfg-header-tab" id="nav">
                            <span class="item on" data-id="basic" id="column_basic">旅行方案</span>
                            <span class="item"  data-id="other" id="column_other">旅行计划</span>
                        </div>
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
                    <div id="product_grid_panel" class="manage-nr">
                        <div class="product-add-div" data-id="basic" id="content_basic" >
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd"><i class="c-red va-m mr-5">*</i>标题：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w900" name="title" id="title" value="{$info['title']}" >
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">图片：</span>
                                    <div class="item-bd">
                                        <div class="">
                                            <a href="javascript:;" id="pic_btn" class="btn btn-primary radius size-S mt-3">上传图片</a>
                                            <span class="item-text c-999 ml-5">建议上传尺寸1200*600</span>
                                        </div>
                                        <div class="up-list-div">
                                            <input type="hidden" class="headimgindex" name="imgheadindex" value=""/>
                                            <input type="hidden" name="litpic" id="litpic" value="{$info['litpic']}"/>
                                            <ul class="pic-sel">

                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="list_dl">
                                    <span class="item-hd">内容：</span>
                                    <div class="item-bd">{php Common::getEditor('content',$info['content'],$sysconfig['cfg_admin_htmleditor_width'],400);}</div>
                                </li>
                                <li class="list_dl">
                                    <span class="item-hd">行程附件：</span>
                                    <div class="item-bd">
                                        <div>
                                            <div id="attach_btn" class="btn btn-primary radius size-S mt-3">上传附件</div>
                                            <input type="hidden" name="linedoc" id="linedoc" value="{$info['linedoc']}">
                                        </div>
                                        <div>
                                        <ol id="linedoc-content" >
                                            {loop $info['linedoc']['path'] $k $v}
                                            <li><span class="name">{$info['linedoc']['name'][$k]}</span><input type="hidden" name="linedoc[name][]" value="{$info['linedoc']['name'][$k]}"><input type="hidden" class="path" name="linedoc[path][]" value="{$v}"><a href="javascript:;" class="del">删除</a></li>
                                            {/loop}
                                        </ol>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="product-add-div" data-id="other" id="content_other">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd"><i class="c-red va-m mr-5"></i>目的地：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w300" name="dest"  value="{$info['dest']}" />
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd"><i class="c-red va-m mr-5"></i>出发地：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w300" name="startplace"  value="{$info['startplace']}" />
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd"><i class="c-red va-m mr-5"></i>出发日期：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w300" id="starttime" name="starttime"  value="{$info['starttime']}" />
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd"><i class="c-red va-m mr-5"></i>出游天数：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w300" name="days"  value="{$info['days']}" />
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">成人数：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w100" name="adultnum"  value="{$info['adultnum']}" />
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">儿童数：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w100" name="childnum"  value="{$info['childnum']}" />
                                    </div>
                                </li>
                                {php $extend_fields=Model_Customize_Extend_Field_Desc::get_fields();}

                                {loop $extend_fields $field}
                                    <li>
                                        <span class="item-hd">{$field['chinesename']}：</span>
                                        <div class="item-bd">
                                            {loop $field['options'] $option}
                                               <span class="mr-10"><input type="radio" name="{$field['fieldname']}" {if $extend_info[$field['fieldname']]==$option}checked=checked{/if} value="{$option}"/>{$option}</span>
                                            {/loop}
                                        </div>
                                    </li>
                                {/loop}
                            </ul>
                        </div>
                        <div class="clear clearfix pt-20 pb-20">
                            <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                        </div>
                        <input type="hidden" id="id" name="id" value="{$info['id']}">
                        <input type="hidden" name="litpic" id="litpic" value="{$info['litpic']}">
                    </div>
                </form>
            </td>
        </tr>
    </table>


<script language="JavaScript">

 var id="{$info['id']}";
    //图片
    {if !empty($info['id'])}
        var piclist = ST.Modify.getUploadFile({$info['piclist_arr']});
        $(".pic-sel").html(piclist);
        var litpic = $("#litpic").val();
        $(".img-li").find('img').each(function(i,item){

            if($(item).attr('src')==litpic){
                var obj = $(item).parents('.img-li').first().find('.btn-ste')[0];
                Imageup.setHead(obj,i+1);
            }
        })
        window.image_index= $(".pic-sel").find('li').length;//已添加的图片数量
    {/if}

     //附件
  /*  setTimeout(function(){
            $('#attach_btn').uploadify({
                'swf': PUBLICURL + 'js/uploadify/uploadify.swf',
                'uploader': SITEURL + 'uploader/uploaddoc',
                'buttonImage' : PUBLICURL+'images/uploadfile.png',  //指定背景图
                'formData':{uploadcookie:"<?php echo Cookie::get('username')?>"},
                'fileTypeExts':'*.doc;*.docx;*.pdf',
                'auto': true,   //是否自动上传
                'removeTimeout':0.2,
                'height': 25,
                'width': 80,
                'onUploadSuccess': function (file, data, response) {
                    var info=$.parseJSON(data);
                    if(info.status){
                        var html='<li><span class="name">'+info.name+'</span><input type="hidden" name="linedoc[name][]" value="'+info.name+'"><input class="path" type="hidden" name="linedoc[path][]" value="'+info.path+'"><a href="javascript:;" class="del">删除</a></li>';
                        $("#linedoc-content").append(html);
                    }
                }
            });
        },10);*/

    $('#attach_btn').click(function(){
        // 上传方法
        $.upload({
            // 上传地址
            url: SITEURL+'uploader/uploaddoc',
            // 文件域名字
            fileName: 'Filedata',
            fileType: 'doc,docx,pdf',
            // 其他表单数据
            params: {uploadcookie:"<?php echo Cookie::get('username')?>"},
            // 上传完成后, 返回json, text
            dataType: 'json',
            // 上传之前回调,return true表示可继续上传
            onSend: function() {
                return true;
            },
            // 上传之后回调
            onComplate: function(info) {
                if(info.status){
                    if(info.status){
                        var html='<li><span class="name">'+info.name+'</span><input type="hidden" name="linedoc[name][]" value="'+info.name+'"><input class="path" type="hidden" name="linedoc[path][]" value="'+info.path+'"><a href="javascript:;" class="del">删除</a></li>';
                        $("#linedoc-content").append(html);
                    }
                }
            }
        });

    })



    //表单验证
    $("#frm").validate({
        ignore: [],
        focusInvalid:false,
        rules: {
            title:
            {
                required: true
            },
            dest:'required',
            startplace:'required',
            starttime:'required',
            days:{
                'digits':true,
                'required':true
            },
            adultnum:{
                'digits':true
            },
            childnum:{
                'digits':true
            }
        },
        messages: {
            title:{
                required:"必填"
            },
            dest:{
                required:"必填"
            },
            startplace:{
                required:"必填"
            },
            starttime:{
                required:"必填"
            },
            days:{
                digits:'请输入数字',
                required:"必填"
            },
            adultnum:{
                digits:'请输入数字'
            },
            childnum:{
                digits:'请输入数字'
            }

        },
        errUserFunc:function(element){
            var parentEle = $(element).parents('.product-add-div:first');
            var pId = parentEle.attr('id');
            var columnId = pId.replace('content_','column_');
            if(!$("#"+columnId).hasClass('on'))
            {
                $("#"+columnId).trigger('click');
            }
            var eleTop = $(element).offset().top;
            $("html,body").animate({scrollTop: eleTop}, 200);
        },
        submitHandler:function(form){
            var right = [];
            $.ajaxform({
                url   :  SITEURL+"customize/admin/plan/ajax_save",
                method  :  "POST",
                form  : "#frm",
                dataType:'json',
                success  :  function(data)
                {
                    if(data.status)
                    {
                        $("#id").val(data.productid);
                        ST.Util.showMsg('保存成功!','4',1200);
                    }
                    else
                    {
                        ST.Util.showMsg(data.msg,'5',1200);
                    }
                }});
            return false;//阻止常规提交
       }
    });

    $(function(){

        $("#nav").find('span').click(function(){

            Product.changeTab(this,'.product-add-div');//导航切换

        })
        $("#nav").find('span').first().trigger('click');


        //保存
        $("#btn_save").click(function(){
            $("#frm").submit();
            return false;

        })

        //日期选择
        $('#starttime').datetimepicker({
            format:'Y-m-d',
            timepicker:false
        });

        //上传图片
        $('#pic_btn').click(function(){
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                var len=result.data.length;
                for(var i=0;i<len;i++){
                    var temp =result.data[i].split('$$');
                    Imageup.genePic(temp[0],".up-list-div ul",".cover-div");
                }
            }
        })

        //附件删除
        $("#linedoc-content").find('.del').live('click',function(){
            var parent_ele=$(this).parent();
           $.post(SITEURL+'customize/admin/plan/ajax_del_doc',{'file':parent_ele.find('.path').val(),'id':id},function(rs){
                if(rs.status){
                    parent_ele.remove();
                }
            },'json');
        });
    })

</script>

</body>
</html>