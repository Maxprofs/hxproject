<?php defined('SYSPATH') or die();?>
<!DOCTYPE html>
<html>
<head font_background=768Vrl >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {template 'stourtravel/public/public_min_js'}
    {Common::getCss('style.css,base.css,order-manage.css')}
    <link type="text/css" href="/res/css/stcalendar.css" rel="stylesheet" />
</head>
<script>
    window.CURRENCY_SYMBOL="{Currency_Tool::symbol()}";
</script>
<body style="background-color: #fff">

{$calendar}
<input type="hidden" id="typeid" value="{$typeid}">
<input type="hidden" id="lineid" value="{$lineid}">
<input type="hidden" id="suitid" value="{$suitid}">

<script language="javascript">
    $('body').delegate('.prevmonth,.nextmonth', 'click', function () {

        var year = $(this).attr('data-year');
        var month = $(this).attr('data-month');
        var suit_id = $(this).attr('data-suitid');
        var lineid = $('#lineid').val();
        var url = SITEURL + 'spot/admin/order/dialog_calendar/suitid/'+suit_id+'/year/'+year+'/month/'+month;
        window.location.href = url;
    });

    function choose_day(day)
    {
        $("#usedate",parent.d.loadDocument).val(day);

        ST.Util.responseDialog(day,true);

    }





</script>

</body>
</html>