<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); }
    {php echo Common::getScript("jquery.validate.js"); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,choose.js,product_add.js,imageup.js"); }
    {Common::css_plugin('distributor.css','distributor')}
    {Common::js_plugin('distributor.js','distributor')}
    <style>
        .error{
            color:red;
            padding-left:5px;
        }
        .hide{
            display: none;
        }

    </style>
</head>
<body style="background-color: #fff">
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <form id="frm" name="frm" enctype="multipart/form-data">
                    <div id="product_grid_panel" class="manage-nr">
                        <div class="w-set-con">
                            <div class="cfg-header-bar" id="nav">
                                <div class="cfg-header-tab">
                                    <span class="item on" data-id="jieshao"><s></s>账号密码</span>
                                    <span class="item" id="basic"><s></s>基础信息</span>
                                    <span class="item" data-id="qualify"><s></s>经营材料</span>
                                </div>
                                <a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>
                            </div>
                        </div>
                        <div class="product-add-div">
                            <ul class="info-item-block">
                                <li class="list_dl">
                                    <span class="item-hd"><span style="color: red;">*</span>部门名称：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w200" name="nickname" id="nickname" value="">
                                    </div>
                                </li>
                                <li class="list_dl">
                                    <span class="item-hd">联系电话：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w200" name="phone" id="phone" value="">
                                    </div>
                                </li>
                                <li class="list_dl">
                                    <span class="item-hd"><span style="color: red;">*</span>真实姓名：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w200" name="truename" id="truename" value="">
                                    </div>
                                </li>
                                <li class="list_dl">
                                    <span class="item-hd">QQ号：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w200" name="qq" id="qq" value="">
                                    </div>
                                </li>
                                <li class="list_dl">
                                    <span class="item-hd">微信号：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w200" name="wechat" id="wechat" value="">
                                    </div>
                                </li>
                                <li class="list_dl">
                                    <span class="item-hd"><span style="color: red;">*</span>省份：</span>
                                    <div class="item-bd">
                                        <select class="input-text w200" name="province" id="province" >
                                        </select>
                                    </div>
                                </li>
                                <li class="list_dl">
                                    <span class="item-hd"><span style="color: red;">*</span>城市：</span>
                                    <div class="item-bd">
                                        <select class="input-text w200" name="city" id="city">
                                        </select>
                                    </div>
                                </li>
                                <li class="list_dl">
                                    <span class="item-hd"><span style="color: red;">*</span>联系地址：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w500" name="address" id="address" value="">
                                    </div>
                                </li>
<!--                                 <li class="list_dl">
                                    <span class="item-hd">坐标：</span>
                                    <div class="item-bd">
                                        <span class="item-text">经度(Lng):</span>
                                        <input type="text" readonly="readonly" name="lng" id="lng" class="input-text w200" value="" />
                                        <span class="item-text ml-20">纬度(Lat):</span>
                                        <input type="text" readonly="readonly" name="lat" id="lat" class="input-text w200" value="" />
                                        <a href="javascript:;" class="btn btn-primary radius size-S ml-5" onclick="Product.Coordinates(700,500)"  title="选择">选择</a><br>
                                        <span>说明：坐标是直客注册过程中绑定分销商时使用，也可以不设置。</span>
                                    </div>
                                </li> -->
                                <li>
                                    <span class="item-hd">添加时间：</span>
                                    <div class="item-bd">
                                        <span class="date item-text"></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="product-add-div" data-id="qualify">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">营业执照图片：</span>
                                    <div class="item-bd">
                                        <img src="" id='licenseimg' width="100" height="140">
                                &nbsp;&nbsp;<a class="licensepic-link edit" href="" target="_blank">查看</a><br><a href="#" class="btn btn-secondary" style="margin-top: 10px;" id="licensepic">选择营业执照</a>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">成立日期：</span>
                                    <div class="item-bd">
                                        <input type="date" class="input-text w200" name="createdate" id="createdate" value="">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">统一社会信用代码：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w200" name="xinyongdaima" id="xinyongdaima" value="">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd"><span style="color: red;">*</span>备案号码：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w200" name="beianhao" id="beianhao" value="">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">企业名称：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w200" name="companyname" id="companyname" value="">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">负责人身份证号：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w200" name="idcard" id="idcard" value="">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd"><span style="color: red;">*</span>负责人身份证：</span>
                                    <div class="item-bd">
                                        <div style="float: left;">
                                            <span>正面</span><br>
                                            <img src="" id='frontimg' width="160" height="100">&nbsp;&nbsp;
                                            <a class="frontpic-link edit" href="" target="_blank">查看</a>
                                            <br>
                                            <a href="#" class="btn btn-secondary" style="margin-top: 10px;" id="fronta">选择身份证正面</a>
                                            <br>
                                        </div>
                                        <div style="float: left;">
                                            <span>反面</span><br>
                                            <img src="" id='versoimg' width="160" height="100">&nbsp;&nbsp;
                                            <a class="versoimg-link edit" href="" target="_blank">查看</a><br>
                                            <a href="#" class="btn btn-secondary" style="margin-top: 10px;" id="versoa">选择身份证背面</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="product-add-div pd-20" data-id="jieshao">
                            <ul class="info-item-block">
                                <li class="add">
                                    <span class="item-hd">注册类型：</span>
                                    <div class="item-bd">
                                        <select name="regtype" id="regtype">
                                            <option value="0" selected="selected">手机</option>
                                            <option value="1">邮箱</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="edit">
                                    <span class="item-hd">账号禁用：</span>
                                    <div class="item-bd">
                                        <select name="isopen" id="isopen">
                                            <option value="1" selected="selected">启用</option>
                                            <option value="0">禁用</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd"><span class="add mobile" style="color: red;">*</span>登录手机号：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w200" name="mobile" id="mobile" value="">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd"><span class="add email" style="color: red;">*</span>登录邮箱：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w200" name="email" id="email" value="">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd"><span class="add" style="color: red;">*</span>登录密码：</span>
                                    <div class="item-bd pwd">
                                        <input type="text" value="" style="position: absolute;z-index: -1;" disabled />
                                        <input type="password" value="" style="position: absolute;z-index: -1;" disabled />
                                        <input type="password" class="input-text w200" id="pwd" name="pwd" autocomplete="off">
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd"><span class="add" style="color: red;">*</span>支付密码：</span>
                                    <div class="item-bd pwd">
                                        <input type="text" value="" style="position: absolute;z-index: -1;" disabled />
                                        <input type="password" value="" style="position: absolute;z-index: -1;" disabled />
                                        <input type="password" class="input-text w200" name="paypwd" autocomplete="off" id="paypwd">
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="clear clearfix">
                            <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                        </div>
                        <dl class="list_dl">
                            <dt class="wid_90">&nbsp;</dt>
                            <dd>
                                <input type="hidden" id='front_pic' name='front_pic' value="">
                                <input type="hidden" id='verso_pic' name='verso_pic' value="">
                                <input type="hidden" id="id" name="id" value="">
                                <input type="hidden" id='action' name="action" value="">
                                <input type="hidden" id="license_pic" name="license_pic" value="">
                            </dd>
                        </dl>
                    </div>
                </form>
            </td>
        </tr>
    </table>
    <script language="JavaScript">
    var action = '{$action}';
    $('#action').val("{$action}");
    if (action == 'edit') {
        $(".add").css('display', 'none');
        $(".edit").css('display', 'display');

        $("#id").val("{$info[0]['mid']}");
        $("#regtype").val("{$info[0]['regtype']}");
        $("#isopen").val('{$info[0]['isopen']}');

        $("#mobile").val("{$info[0]['mobile']}");
        $("#email").val("{$info[0]['email']}");
        $("#nickname").val("{$info[0]['nickname']}");
        $("#phone").val("{$info[0]['phone']}");
        $("#truename").val("{$info[0]['truename']}")
        $("#qq").val("{$info[0]['qq']}");
        $("#wechat").val("{$info[0]['wechat']}");
        $("#province").val("{$info[0]['province']}");
        $("#city").val("{$info[0]['city']}");
        $("#address").val("{$info[0]['address']}");
        $("#lng").val("{$info[0]['lng']}");
        $("#lat").val("{$info[0]['lat']}");
        $(".date").text(formatDateTime({$info[0]['jointime']}));

        $(".licensepic-link").attr('href', "{$info[0]['license_pic']}");
        $("#licenseimg").attr('src', "{$info[0]['license_pic']}")
        $("#license_pic").val("{$info[0]['license_pic']}");
        $("#createdate").val("{$info[0]['createdate']}");//成立日期

        $("#xinyongdaima").val("{$info[0]['xinyongdaima']}");
        $("#beianhao").val("{$info[0]['beianhao']}");
        $("#companyname").val("{$info[0]['companyname']}");
        $('#idcard').val("{$info[0]['cardid']}");
        $('#frontimg').attr('src', "{Common::img($info[0]['idcard_pic']['front_pic'],198,123)}");
        $('.frontpic-link').attr('href', "{Common::img($info[0]['idcard_pic']['front_pic'],198,123)}");
        $('#front_pic').val("{Common::img($info[0]['idcard_pic']['front_pic'],198,123)}");
        $('#versoimg').attr('src', "{Common::img($info[0]['idcard_pic']['verso_pic'],198,123)}");
        $('.versopic-link').attr('href', "{Common::img($info[0]['idcard_pic']['verso_pic'],198,123)}");
        $('#verso_pic').val("{Common::img($info[0]['idcard_pic']['verso_pic'],198,123)}");
    }
    if (action == 'add') {
        $(".edit").css('display', 'none');
        $(".add").css('display', 'display');
    }
    // 日期
    $.validator.addMethod("isDate", function(value, element) {
        var isdate = /^(\d{1,4})(-|\/)(\d{1,2})(-|\/)(\d{1,2})$/;
        return this.optional(element) || isdate.test(value);
    }, "日期格式不合法");
    // 身份证
    $.validator.addMethod("isIdcard", function(value, element) {
        var isidcard = /^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/;
        return this.optional(element) || isidcard.test(value);
    }, "请正确填写法人身份证号");
    // 企业名称
    $.validator.addMethod("isCompany", function(value, element) {
        var iscompany = /^[\u4e00-\u9fa5]{4,50}$/;
        return this.optional(element) || iscompany.test(value);
    }, "请正确填写企业名称");
    // 备案号
    $.validator.addMethod("isBeianhao", function(value, element) {
        var isbeianhao = /^[A-Z0-9a-z-]{21,21}$/;
        return this.optional(element) || isbeianhao.test(value);
    }, "请正确填写备案号");
    // 信用代码
    $.validator.addMethod("isLicense", function(value, element) {
        var islicense = /^[A-Z0-9]{18,18}$/;
        return this.optional(element) || islicense.test(value);
    }, "请正确填写统一社会信用代码");
    // qq号
    $.validator.addMethod("isQQ", function(value, element) {
        var isqq = /^[0-9]{0,15}$/;
        return this.optional(element) || isqq.test(value);
    }, "请正确填写QQ号");
    // 座机号码验证
    $.validator.addMethod("isTel", function(value, element) {
        var isname = /^[0-9]{3,4}[-][0-9]{7,8}$/;
        return this.optional(element) || isname.test(value);
    }, "请正确填写座机号码");
    // 部门名字验证
    $.validator.addMethod("isPartName", function(value, element) {
        var ispartname = /^[\u4e00-\u9fa5A-Za-z0-9·]{0,20}$/;
        return this.optional(element) || ispartname.test(value);
    }, "请正确填写名称");
    // 名字验证
    $.validator.addMethod("isName", function(value, element) {
        var isname = /^[\u4e00-\u9fa5A-Za-z·]{0,20}$/;
        return this.optional(element) || isname.test(value);
    }, "请正确填写名称");
    // 联系人手机号验证
    $.validator.addMethod("isMobile", function(value, element) {
        var mobile = /^(\+?\d+-?)?\d{6,}$/;
        return this.optional(element) || mobile.test(value);
    }, "请正确填写手机号码");
    // 联系人邮箱验证
    $.validator.addMethod("isEmail", function(value, element) {
        var email = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;
        return this.optional(element) || email.test(value);
    }, "请正确填写您的邮箱");
    // 密码
    $.validator.addMethod("isPwd", function(value, element) {
        var pwd = /^[a-zA-Z0-9]{6,30}$/;
        return this.optional(element) || pwd.test(value);
    }, "密码包含大小写字母和数字，最短6位最长30位。");
    //表单验证
    $("#frm").validate({
        // debug: true,
        ignore: [],
        focusInvalid: false,
        rules: {
            truename: {
                isName: true,
                required:true
            },
            createdate: {
                isDate: true
            },
            paypwd: {
                isPwd: true
            },
            nickname: {
                isPartName: true,
                required: true
            },
            phone: {
                isTel: true
            },
            contactname: {
                isName: true,
                required: true
            },
            contactmobile: {
                required: true,
                isMobile: true
            },
            qq: {
                isQQ: true
            },
            wechat: {
                isPartName: true
            },
            email: {
                isEmail: true,
            },
            email2: {
                isEmail: true,
            },
            province: {
                required: true,
            },
            city: {
                required: true,
            },
            address: {
                required: true,
                isPartName: true
            },
            xinyongdaima: {
                isLicense: true
            },
            beianhao: {
                required: true,
                isBeianhao: true
            },
            companyname: {
                isCompany: true
            },
            idcard: {
                isIdcard: true
            },
            pwd: {
                isPwd: true
            },
            mobile: {
                isMobile: true
            },
            mobile2: {
                isMobile: true
            }
        },
        messages: {
            mobile: {
                isMobile: '请正确填写手机号'
            },
            address: {
                isPartName: "请正确填写联系地址"
            },
            wechat: {
                isPartName: "请正确填写微信号"
            },
            phone: {
                isTel: "座机号码请按照028-88888888方式输入"
            },
            nickname: {
                isPartName: '请输入正确的部门名称'
            },
            beianhao: {
                required: "请输入备案号"
            },
            pwd: {
                minlength: '登录密码不能少于6位'
            },
            paypwd: {
                minlength: '支付密码不能少于6位'
            },
        },
        errUserFunc: function(element) {
            var len = $(element).closest('div').prev()[0]['innerText'].length
            var str = $(element).closest('div').prev()[0]['innerText']
            str = str.substr(0, len - 1)
            if (str.substr(0,1)=='*') {
                ST.Util.showMsg('请检查“' + str.substr(1,str.length) + '”', '1', 2000);
            }else{
                ST.Util.showMsg('请检查“' + str + '”', '1', 2000);
            }
        },
        submitHandler: function(form) {
            $.ajaxform({
                url: SITEURL + "distributor/admin/distributor/ajax_save",
                method: "POST",
                form: "#frm",
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        $("#id").val(data.productid);
                        if (action == 'edit') {
                            ST.Util.showMsg('保存成功!', '4', 2000);
                        }
                        if (action == 'add') {
                            ST.Util.showMsg('添加成功!', '4', 2000);
                            window.location.reload()
                        }
                    } else {
                        ST.Util.showMsg(data.msg, '5', 2000);
                    }


                }
            });
            return false; //阻止常规提交
        }

    });

    $(function() {
        initSelect($('#province'));

        $('#province').change(function(event) {
            /* Act on the event */
            initSelect($('#city'));
        });
        var regtype = $('#regtype').val();
        $('#regtype').change(function(event) {
            /* Act on the event */
            regtype = $('#regtype').val();
        });
        changeregtype(regtype);
        $("#nav").find('span').click(function() {
            Product.changeTab(this, '.product-add-div'); //导航切换
        })
        $("#nav").find('span').first().trigger('click');

        $('#regtype').on('change', function(event) {
            event.preventDefault();
            /* Act on the event */
            changeregtype($(this).val());
        });
        //保存
        $("#btn_save").click(function() {
            if (action == 'add') {
                $('#isopen').attr('disabled','disabled');
                if ($('#paypwd').val() == "" || $('#password').val() == "") {
                    ST.Util.showMsg("请填写登录密码及支付密码", '5', 2000);
                    return;
                }
                if (regtype=='0' && $('#mobile').val() == "") {
                    ST.Util.showMsg("请正确填写登录手机号！", '5', 2000);
                    return;
                }
                if (regtype=='1' && $('#email').val() == "") {
                    ST.Util.showMsg("请正确填写登录邮箱！", '5', 2000);
                    return;
                }
            }
            $("#frm").submit();
            return false;
        });


        //上传图片
        $('#fronta,#versoa,#licensepic').click(function() {
            var ele = $(this);
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0, 0, null, null, document, { loadWindow: window, loadCallback: Insert });

            function Insert(result, bool) {
                var len = result.data.length;
                if (len > 1) {
                    ST.Util.showMsg('请选择一张图片', '5', 2000);
                    return;
                }
                var temp = result.data[0].split('$$');
                switch (ele.attr('id')) {
                    case 'fronta':
                        $("#frontimg").attr('src', temp[0]);
                        $('.frontimg-link').attr('href', temp[0]);
                        $('#front_pic').val(temp[0]);
                        break;
                    case 'versoa':
                        $("#versoimg").attr('src', temp[0]);
                        $('.versoimg-link').attr('href', temp[0]);
                        $('#verso_pic').val(temp[0]);
                        break;
                    case 'licensepic':
                        $("#licenseimg").attr('src', temp[0]);
                        $('.licensepic-link').attr('href', temp[0]);
                        $('#license_pic').val(temp[0]);
                        break;
                }
            }
        });
    });
window.onload=function() {
    if (action=='edit') {
        $('#province').val("{$info[0]['province']}");
        initSelect($('#city'));
        $('#city').val("{$info[0]['city']}");
    }
    
}
function initSelect(ele) {
    var opt = [];
    $.getJSON('/res/json/pc.json', function(json, textStatus) {
        /*optional stuff to do after success */
        if ($(ele).attr('id')=='province') {
            opt.push('<option value=""></option>')
            $.each(json, function(index, val) {
             /* iterate through array or object */
                opt.push('<option value="'+ index +'">'+ index +'</option>');
            });
        }else{
            $.each(json, function(index, val) {
                 /* iterate through array or object */
                 if (index==$('#province').val()) {
                    $.each(val, function(i, v) {
                         /* iterate through array or object */
                         opt.push('<option value="'+ v +'">'+ v +'</option>');
                    });
                 }
            });
        }
        $(ele).html(opt.join(''));
    });
    return true;
}
    function changeregtype(type) {
        if (type=='0') {
            $('.mobile').css('display', 'inline-block');
            $('.email').css('display','none');
        }else{
            $('.mobile').css('display', 'none');
            $('.email').css('display','inline-block');
        }
    }

    </script>
</body>

</html>