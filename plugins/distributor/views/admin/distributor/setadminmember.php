<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>分销商列表-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
</head>

<body style="overflow:hidden">
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:hidden">
                <div class="cfg-header-bar clearfix">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <div class="product-add-div">
                    <ul class="info-item-block">
                        <li class="list_dl">
                            <span class="item-hd w200">管理员分销商账号登录名：</span>
                            <div class="item-bd">
                                <input type="text" class="input-text w200" name="account" id="account" value="" placeholder="前台登录手机号或邮箱地址">
                            </div>
                        </li>
                        <li class="list_dl">
                            <span class="item-hd w500" style="color: red;">功能说明：此设置主要是为了管理员删除分销商后，分销商原有客户转至管理员业务账号下。</span>
                            <div class="item-bd">
                                <span class="input-text" style="border: none; padding: 0px 5px;"></span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="clear clearfix">
                    <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                </div>
            </td>
        </tr>
    </table>
</body>
<script>
    $(function() {
        $('#account').val("{$account}")
        $('#btn_save').click(function(event) {
            /* Act on the event */
            getdata();
        });
    });
    function getdata() {
        var data=$('#account').val();
        var mobile = /^(\+?\d+-?)?\d{11,11}$/;
        var email = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;
        if (data=="{$account}") {
            ST.Util.showMsg('登录名未变更', '5', 2000);
            return false;
        }
        if (data=='') {
            ST.Util.showMsg('未填写登录名', '1', 2000);
            return false;
        }
        if (data.match(mobile)==null && data.match(email)==null) {
            ST.Util.showMsg('输入错误', '5', 3000);
            return false;
        }
        $.ajax({
            url: '/newtravel/distributor/admin/distributor/ajax_set',
            type: 'get',
            dataType: 'json',
            data: {"param":'"'+data+'"'}
        })
        .done(function(data) {
            if (data.status) {
                ST.Util.showMsg(data.msg, '4', 2000);
                setTimeout("window.location.reload()","2000");
            }else{
                ST.Util.showMsg(data.msg, '5', 2000);
            }
        })
    }


    // // 联系人手机号验证
    // $.validator.addMethod("isMobile", function(value, element) {
    //     var mobile = /^(\+?\d+-?)?\d{6,}$/;
    //     return this.optional(element) || mobile.test(value);
    // }, "请正确填写手机号码");
    // // 联系人邮箱验证
    // $.validator.addMethod("isEmail", function(value, element) {
    //     var email = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;
    //     return this.optional(element) || email.test(value);
    // }, "请正确填写您的邮箱");
    // //表单验证
    // $("#frm").validate({
    //     // debug: true,
    //     ignore: [],
    //     focusInvalid: false,
    //     rules: {
    //         account: {
    //             is: true,
    //             required:true
    //         }
    //     },
    //     errUserFunc: function(element) {
    //         var len = $(element).closest('div').prev()[0]['innerText'].length
    //         var str = $(element).closest('div').prev()[0]['innerText']
    //         str = str.substr(0, len - 1)
    //         if (str.substr(0,1)=='*') {
    //             ST.Util.showMsg('请检查“' + str.substr(1,str.length) + '”', '1', 2000);
    //         }else{
    //             ST.Util.showMsg('请检查“' + str + '”', '1', 2000);
    //         }
    //     },
    //     submitHandler: function(form) {
    //         $.ajaxform({
    //             url: SITEURL + "distributor/admin/distributor/ajax_save",
    //             method: "POST",
    //             form: "#frm",
    //             dataType: 'json',
    //             success: function(data) {
    //                 if (data.status) {
    //                     $("#id").val(data.productid);
    //                     if (action == 'edit') {
    //                         ST.Util.showMsg('保存成功!', '4', 2000);
    //                     }
    //                     if (action == 'add') {
    //                         ST.Util.showMsg('添加成功!', '4', 2000);
    //                         window.location.reload()
    //                     }
    //                 } else {
    //                     ST.Util.showMsg(data.msg, '5', 2000);
    //                 }


    //             }
    //         });
    //         return false; //阻止常规提交
    //     }

    // });
</script>

</html>