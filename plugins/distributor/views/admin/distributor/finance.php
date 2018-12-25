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
                                    <span class="item on" data-id="jieshao"><s></s>账户财务信息</span>
<!--                                     <span class="item" id="basic"><s></s>基础信息</span>
                                    <span class="item" data-id="qualify"><s></s>经营材料</span> -->
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
                                    <span class="item-hd">联系地址：</span>
                                    <div class="item-bd">
                                        <input type="text" class="input-text w500" name="address" id="address" value="">
                                    </div>
                                </li>
                                <li class="list_dl">
                                    <span class="item-hd">坐标：</span>
                                    <div class="item-bd">
                                        <span class="item-text">经度(Lng):</span>
                                        <input type="text" readonly="readonly" name="lng" id="lng" class="input-text w200" value="" />
                                        <span class="item-text ml-20">纬度(Lat):</span>
                                        <input type="text" readonly="readonly" name="lat" id="lat" class="input-text w200" value="" />
                                        <a href="javascript:;" class="btn btn-primary radius size-S ml-5" onclick="Product.Coordinates(700,500)"  title="选择">选择</a><br>
                                        <span>说明：坐标是直客注册过程中绑定分销商时使用，也可以不设置。</span>
                                    </div>
                                </li>
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

    }
    if (action == 'add') {

    }
    // 日期
    $.validator.addMethod("isDate", function(value, element) {
        var isdate = /^(\d{1,4})(-|\/)(\d{1,2})(-|\/)(\d{1,2})$/;
        return this.optional(element) || isdate.test(value);
    }, "日期格式不合法");
    //表单验证
    $("#frm").validate({
        // debug: true,
        ignore: [],
        focusInvalid: false,
        rules: {
            truename: {
                isName: true
            }
        },
        messages: {
            mobile: {
                isMobile: '请正确填写手机号'
            }
        },
        errUserFunc: function(element) {
            var len = $(element).closest('div').prev()[0]['innerText'].length
            var str = $(element).closest('div').prev()[0]['innerText']
            str = str.substr(0, len - 1)
            ST.Util.showMsg('请检查“' + str + '”', '1', 2000);
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

        $("#nav").find('span').click(function() {
            Product.changeTab(this, '.product-add-div'); //导航切换
        })
        $("#nav").find('span').first().trigger('click');

    });

    </script>
</body>

</html>