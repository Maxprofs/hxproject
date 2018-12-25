<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>用户管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); }
    {php echo Common::getScript("jquery.validate.js,choose.js"); }
    <style>
        .user-add-tb{
            width:340px;
            table-layout: fixed;
            line-height: 35px;
        }
        .user-add-tb td input{
            height: 24px;
        }
        .user-add-tb td textarea{
            height: 50px;
            width: 240px;
        }
        .error{
            color:red;
            padding-left:5px;
        }
    </style>

</head>
<body >

<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" >
            <div class="list-top-set">
                <div class="list-web-pad"></div>
                <div class="list-web-ct">
                    <table class="list-head-tb">
                        <tr>
                            <td class="head-td-lt"></td>
                            <td class="head-td-rt">
                                <a href="javascript:;" class="btn btn-primary radius" onclick="window.location.reload()">刷新</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="s-main">
                <form action="user/ajax_save" method="post" id="product_fm">
                    <div class="basic-con">
                        <ul class="info-item-block">

                            <li>
                                <span class="item-hd">用户名：</span>
                                <div class="item-bd">
                                    {if empty($info)}
                                    <input class="input-text w200" id="username" name="username" value=""/>
                                    <label class="item-text c-red ml-5">*</label>
                                    {else}
                                    <span class="item-text">{$info['username']}</span>
                                    {/if}
                                    <input type="hidden" name="id" value="{$info['id']}"/>
                                </div>
                            </li>

                            <li>
                                <span class="item-hd">密码：</span>
                                <div class="item-bd">

                                    <input class="input-text w200"    onfocus="this.type='password'"  id="password" type="text" name="password"/>
                                    {if !$info['id']}
                                    <label class="item-text c-red ml-5">*</label>
                                    {/if}

                                </div>
                            </li>
                            <li>
                                <span class="item-hd">权限{Common::get_help_icon('admin_field_roleid',true)}：</span>
                                <div class="item-bd">
                                    <div class="select-box w200">
                                        <select class="select" name="roleid" {if $info['roleid']==1} disabled  style="color:#b9b9b9" {/if}>
                                        {loop $roles $role}
                                        <option value="{$role['roleid']}" {if $info['roleid']==$role['roleid']}selected="selected"{/if}>{$role['rolename']}</option>
                                        {/loop}
                                        </select>
                                    </div>
                                </div>
                            </li>
                        </ul>

                            <div class="line"></div>
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">手机号：</span>
                                <div class="item-bd">
                                    <input class="input-text w200"   value="{$info['phone']}"  id="phone" type="text" name="phone"/>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">邮箱：</span>
                                <div class="item-bd">

                                    <input class="input-text w200"   id="email" value="{$info['email']}"  type="text" name="email"/>

                                </div>
                            </li>

                            <li>

                                <span class="item-hd">接收通知产品：</span>
                                <div class="item-bd w800">
                                    {loop $products $p}
                                    <label class="radio-label w100">
                                        <input {if in_array($p['id'],$info['notice_products'])}checked {/if} type="checkbox" name="products[]"  class="i-box" value="{$p['id']}">
                                        <span class="i-lb">{$p['shortname']}</span>
                                    </label>
                                    {/loop}
                                </div>
                            </li>
                            <li>

                                <span class="item-hd">接收其他通知：</span>
                                <div class="item-bd w800">
                                    <label class="radio-label w100">
                                        <input {if in_array('free_kefu',$info['notice_other_arr'])}checked {/if} type="checkbox" name="notice_other[]"  class="i-box" value="free_kefu">
                                        <span class="i-lb">免费通话</span>
                                    </label>
                                </div>
                            </li>
                        </ul>

                        <div class="line"></div>
                        <ul class="info-item-block">


                            <li>
                                <span class="item-hd">头像：</span>
                                <div class="item-bd">
                                    <a id="pic_btn" class="btn btn-primary radius size-S mt-3">上传图片</a>
                                    <div class="clearfix mt-10">
                                        <img id="pic_upload" class=" up-img-area"  src="{$info['litpic']}"/>
                                    </div>

                                    <input id="hid_pic_upload" type="hidden" name="pic_upload" value="{$info['litpic']}">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">备注：</span>
                                <div class="item-bd w800">
                                    <textarea class="textarea" name="beizu">{$info['beizu']}</textarea>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="clear clearfix pt-20 pb-20">
                        <a href="javascript:;" id="btn-save" class="btn btn-primary radius size-L ml-115">保存</a>
                    </div>
                </form>
            </div>
        </td>
    </tr>
</table>

</body>
</html>

<script>
    jQuery.validator.addMethod("notblank", function(value, element) {
        var pwdblank = /^\S*$/;
        return this.optional(element) ||(pwdblank.test(value));
    }, "密码不可包含空格");
    //用户名必须需包含数字和大小写字母中至少两种
    jQuery.validator.addMethod("pwdrule", function(value, element) {
        var userblank = /^(?![0-9]+$)(?![a-z]+$)(?![A-Z]+$)[0-9A-Za-z]{6,16}$/;
        return this.optional(element) ||(userblank.test(value));
    }, "需包含数字和大小写字母中至少两种字符的6-16位字符");

    $(function() {
        $("#product_fm").validate({
            rules:{
                'username':{
                    required:true,
                    remote:{
                        type:"POST",
                        url:SITEURL+"user/ajax_checkuser", //请求地址
                        data:{
                            username:function(){ return $("#username").val(); }
                        }
                    }
                }
            },
            messages:
                {
                    'username':{
                        required:'必填',
                        remote:'用户名已存在'
                    },
                    'password':{
                        required:'必填'

                    }
                },
            submitHandler:function(form)
            {
                $.ajaxform({
                    url   :  SITEURL+"user/ajax_save",
                    method  :  "POST",
                    form  : "#product_fm",
                    dataType  :  "json",
                    success  :  function(data)
                    {
                        if(data.status)
                        {
                            $('input[name=id]').val(data.adminid);

                            ST.Util.showMsg('保存成功',4,1000);
                        }
                        else
                        {
                            ST.Util.showMsg('保存失败',5);
                        }
                    }});

            }
        });

        $(document).on('click','#btn-save',function(){
            var password = $('#password').val();
            if(password)
            {
                $("#password").rules("add",{required:true,notblank:true,pwdrule:true});
            }
            $("#product_fm").submit();
        });

        if(!$('input[name=id]').val())
        {
            $("#password").rules("add",{required:true,notblank:true,pwdrule:true});
        }


        $('#pic_btn').click(function(){
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, parent.document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                var len=result.data.length;
                for(var i=0;i<len;i++){
                    var temp =result.data[i].split('$$');
                    $('#pic_upload').attr('src',temp[0]);
                    $('#hid_pic_upload').val(temp[0]);
                    $('#pic_upload').load(function () {
                        ST.Util.resizeDialog('.s-main')
                    })

                }
            }
        });

    });




</script>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201805.1003&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
