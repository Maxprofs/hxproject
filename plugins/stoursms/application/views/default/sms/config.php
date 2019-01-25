<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡短信接口配置-笛卡CMS</title>
    <script type="text/javascript" src="/{$admindir}/public/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/common.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/msgbox/msgbox.js"></script>
    <link type="text/css" href="/{$admindir}/public/js/msgbox/msgbox.css" rel="stylesheet" />
    {Common::get_skin_css()}
    <script>
        window.SITEURL = "{php echo URL::site();}";
        window.PUBLICURL = "{$GLOBALS['cfg_res_url']}";
        window.BASEHOST = "{$GLOBALS['cfg_basehost']}";
    </script>
    
    <link type="text/css" href="/{$admindir}/public/css/style.css" rel="stylesheet" />
    <link type="text/css" href="/{$admindir}/public/css/base.css" rel="stylesheet" />
    <link type="text/css" href="/{$admindir}/public/css/plist.css" rel="stylesheet" />
    <link type="text/css" href="/{$admindir}/public/css/sms_sms.css" rel="stylesheet" />
    <link type="text/css" href="/{$admindir}/public/css/sms_dialog.css" rel="stylesheet" />
    <link type="text/css" href="/{$admindir}/public/css/base_new.css" rel="stylesheet" />
    <script type="text/javascript" src="/{$admindir}/public/js/common.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/config.js"></script>
    <script type="text/javascript" src="/{$admindir}/public/js/DatePicker/WdatePicker.js"></script>
    

    <style>
        .s-main
        {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <table class="content-tab" margin_size=5MM8Zk >
        <tr>
            <td valign="top" class="content-rt-td">
                <div class="manage-nr">
                    <form id="configfrm">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">笛卡接口开关：</span>
                                <div class="item-bd">
                                    <label class="radio-label mr-20"><input type="radio" name="isopen" {if $provider['isopen']=='0'} checked {/if}  value="0" />关</label>
                                    <label class="radio-label mr-20"><input type="radio" name="isopen" {if $provider['isopen']=='1'} checked {/if}  value="1" />开</label>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">短信网关账号：</span>
                                <div class="item-bd">
                                    <input class="input-text w300" type="text" name="cfg_sms_username" id="cfg_sms_username" value="{$cfg_sms_username}" />
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">短信网关密码：</span>
                                <div class="item-bd">
                                    <input class="input-text w300" type="password" name="cfg_sms_password" id="cfg_sms_password" value="{$cfg_sms_password}" />
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">短信价格：</span>
                                <div class="item-bd">
                                    <input required="required" class="input-text w100" type="text" name="cfg_sms_price" id="cfg_sms_price" value="{$cfg_sms_price}" maxlength="4" />&nbsp;元/条
                                </div>
                            </li>
                        </ul>
                    </form>
                    <div class="clear clearfix">
                        <a href="javascript:;" id="sms_save_btn" class="btn btn-primary radius size-L mt-5 ml-115">保存</a>
                    </div>
                    <div class="sms-num mt-20">剩余短信：<strong>
                    {$count}
                    </strong>条</div>
                    <div class="sms-set">
                        <div class="msg-bar">
                            <span class="">使用记录</span>
                            <span class="">充值记录</span>
                        </div>
                        <div class="msg-switcher">
                            <div class="info-one clearfix">
                                <div class="s-main">
                                    <div class="search-con">
                                        <input type="text" class="input-text w200" name="querydate" onclick="WdatePicker({maxDate:'%y-%M-%d'})" />
                                        <span class="item-text ml-10">至今天</span>
                                        <a href="javascript:;" data_type="uselog" class="btn btn-primary radius ml-10">查询</a>
                                    </div>
                                    <div class="s-list">
                                        <table class="table table-bordered table-border">
                                            <tr>
                                                <th width="20%" scope="col">
                                                    时间
                                                </th>
                                                <th width="60%" scope="col" align="left">
                                                    内容
                                                </th>
                                                <th width="10%" scope="col">
                                                    手机号码
                                                </th>
                                                <th width="10%" scope="col">
                                                    操作状态
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="info-one clearfix">
                                <div class="s-main">
                                    <div class="search-con">
                                        <input type="text" class="input-text w200" name="querydate" onclick="WdatePicker({maxDate:'%y-%M-%d'})" />
                                        <span class="item-text ml-10">至今天</span>
                                        <a href="javascript:;" data_type="cashlog" class="btn btn-primary radius ml-10">查询</a>
                                    </div>
                                    <div class="s-list">
                                        <table class="table table-bordered table-border">
                                            <tr>
                                                <th width="20%" scope="col">
                                                    时间
                                                </th>
                                                <th width="38%" scope="col" align="left">
                                                    充值门市
                                                </th>
                                                <th width="22" scope="col">
                                                    内容
                                                </th>
                                                <th width="10%" scope="col">
                                                    交易金额
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

<script>
    var provider_id = {$provider['id']};

    $(document).ready(function () {
        
        $(".msg-bar span").click(function () {
            var index = $(".msg-bar span").index(this);
            $(".msg-bar span.on").removeClass('on');
            $(this).addClass('on');
            $(".msg-switcher .info-one").hide();
            $(".msg-switcher .info-one:eq(" + index + ")").show();
        });
        $(".msg-bar span:first").trigger('click');

        $("#sms_save_btn").click(function () {
            var url = SITEURL + "sms/ajax_saveconfig?provider_id=" + provider_id;
            var frmdata = $("#configfrm").serialize();
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: frmdata,
                success: function (data) {
                    if (data.status == true) {
                        ST.Util.showMsg('保存成功', 4);
                    }
                    else {
                        ST.Util.showMsg('保存失败', 5, 3000);
                    }

                }
            })
        });

        $("a[data_type$='log']").click(function () {
            var data_type = $(this).attr("data_type");
            var querydate = $(this).siblings("input[name='querydate']").val();
            var table_result = $(this).parent().siblings(".s-list").find("table");
            table_result.find(".item").remove();
            if (data_type=='cashlog') {
                var url = SITEURL + 'sms/ajax_checkcashlog/querytype/' + data_type + '/querydate/' + querydate + "?provider_id=" + provider_id;
            }else{
                var url = SITEURL + 'sms/ajax_query/querytype/' + data_type + '/querydate/' + querydate + "?provider_id=" + provider_id;
            }
            

            if (querydate == "") {
                ST.Util.showMsg("请选择查询起始日期", 5, 3000);
                return;
            }
            ST.Util.showMsg('加载中...',6,60000);
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function (data) {

                    ST.Util.hideMsgBox();
                    if (!data.Success) {
                        ST.Util.showMsg(data.msg, 5, 3000);
                        return;
                    }

                    if (data.Data.length <= 0) {
                        ST.Util.showMsg("没有查询到记录", 4);
                        return;
                    }
                    console.log(data)
                    var html = '';
                    for (var i in data.Data) {
                        var row = data.Data[i];
                        if (data_type == "uselog") {
                            html += '<tr class="item"> <td align="center">' + formatDate(row.sendtime) + '</td>' +
                                '<td class="msg-con">' + row.contents + '</td>' +
                                '<td align="center">' + row.mobile + '</td>' +
                                '<td align="center">' + row.smstype + '</td></tr>';
                        }
                        if (data_type == "cashlog") {
                            html += '<tr class="item"> <td align="center">' + formatDate(row.addtime) + '</td>' +
                                '<td class="msg-con">' + row.nickname + '</td>' +
                                '<td class="msg-con">' + row.description + '</td>' +
                                '<td align="center">' + row.amount + '</td></tr>';
                        }
                    }
                    table_result.append(html);
                }
            });


        });
    })
    function formatDate(timestamp) {
        var date = new Date(parseInt(timestamp)*1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = date.getDate()<10?'0'+date.getDate():date.getDate();
        if (date.getHours()<10) {
            h = '0'+date.getHours() + ':';
        }else{
            h = date.getHours() + ':';
        }
        if (date.getMinutes()<10) {
            m='0'+date.getMinutes()+':';
        }else{
            m = date.getMinutes() + ':';
        }
        if (date.getSeconds()<10) {
            s='0'+date.getSeconds();
        }else{
            s = date.getSeconds();
        }
        return Y+M+D+' '+h+m+s;
     }
</script>
</body>
</html>
