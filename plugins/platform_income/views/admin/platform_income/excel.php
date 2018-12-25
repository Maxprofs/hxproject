<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base.css,order.css,jqtransform.css'); }
    {php echo Common::getScript('jquery.jqtransform.js,hdate/hdate.js');}
    {php echo Common::getCss('hdate.css','js/hdate'); }

    <script language="javascript">

    </script>
</head>

<body style="background-color: #fff">
<div class="derive_box">
    <div class="derive_con">
        <form ul_right=4VLzDt >
            <table class="derive_tb">
                <tr>
                    <td>产品类别：</td>
                    <td>
                        <select name="type_id" class="select">
                            <option value="">请选择</option>
                            {loop $modules $row}
                            <option value="{$row['id']}">{$row['modulename']}</option>
                            {/loop}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>支付方式：</td>
                    <td>
                        <select name="pay_type" class="select">
                            <option value="">请选择</option>
                            {loop $pay_sources $v}
                            <option value="{$v['paysource']}">{$v['paysource']}</option>
                            {/loop}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>到账状态：</td>
                    <td>
                        <select name="status" class="select">
                            <option value="">请选择</option>
                            {loop $account_status $k $v}
                            <option value="{$k}">{$v}</option>
                            {/loop}
                        </select>
                    </td>
                </tr>
            </table>
            <div class="now_derive_box"><a class="derive_btn btn_excel" href="javascript:;">立即导出</a></div>
        </form>
    </div>
</div>
</body>
<script>
    var channelname = "{$channelname}";
    $(function () {
        $(".btn_excel").click(function () {
            var typeid = $("select[name='type_id']").val();
            var status = $("select[name='status']").val();
            var pay_type = $.trim($("select[name='pay_type']").val());
            var url = SITEURL + 'income/admin/income/genexcel/?typeid=' + typeid + '&status=' + status + '&pay_type=' + pay_type;
            window.open(url);
        })
    })
</script>
</html>