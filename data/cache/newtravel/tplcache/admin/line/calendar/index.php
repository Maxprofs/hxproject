<?php defined('SYSPATH') or die();?>
<!DOCTYPE html>
<html>
<head size_strong=WMQzDt >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getScript("choose.js,product_add.js"); ?>
    <style>
        *{
            padding:0px;
            margin:0}
        html,body{
            width:100%;
            height:100%;
            font-size:12px;
            font-family:Arial, Helvetica, sans-serif;
        }
        h1,h2,h3,h4,h5{
            font-size:14px}
        a{
            color:#464646;
            text-decoration:none}
        a:hover{
            color:#f60;
            text-decoration:underline}
        a,input,textarea{
            outline:none;
            resize:none;}
        s,i{
            text-decoration:none; font-style:normal}
        .color_f60{
            color:#f60}
        li{
            list-style:none}
        img{
            border:none}
        .fl{
            float:left}
        .fr{
            float:right}
        .clear{
            clear:both}
        table {
            border-collapse: collapse;
            border-spacing: 0;
            float:left;
        }
        table .num {
            float: left;
            width: 100%;
            height: 20px;
            line-height: 20px;
            text-align: center;
        }
        .tab{
            height:700px;
            padding-left:10px;
            float:left;
        }
        .tab table
        {
            width: 630px;
        }
        table td {
            border: 1px solid #dcdcdc;
            width:54px;
            /*height: 105px;*/
            max-height:67px;
        }
        .content-td
        {
            height: 105px;
        }
        .top_title{border: 1px solid #fff;line-height: 25px;}
        table .yes_yd {
            color: #f60;
            float: left;
            width: 100%;
            height: 25px;
            line-height: 25px;
            text-align: center;
        }
        .tab table .line_yes_yd{
            color: #f60;
            float: left;
            width: 100%;
            line-height: 16px;
            text-align: center;
            height: 16px;
        }
        .tab table .roombalance_b{
            color: #f60;
            font-weight: 300;
            font-size:11px;
        }
        .kucun{
            float: left;
            color: #ccc;
            width: 100%;
            height: 20px;
            line-height: 20px;
            text-align: center;
            font-weight: 400;
        }
        #tabl tr td{
            height: 50px;
        }
    </style>
</head>
<body style="background-color: #fff">
<?php echo $calendar;?>
<input type="hidden" id="typeid" value="<?php echo $typeid;?>">
<input type="hidden" id="productid" value="<?php echo $productid;?>">
<input type="hidden" id="suitid" value="<?php echo $suitid;?>">
<script language="javascript">
    var typeid="<?php echo $typeid;?>";
    var back_symbol = '<?php echo Currency_Tool::back_symbol();?>';
    //修改单独报价
    function  modPrice(obj)
    {
        var daydate =$(obj).data('date');
        edit_price(daydate);
    }
    //添加单独报价
    function addPrice(obj)
    {
        var daydate =$(obj).data('date');
        edit_price(daydate);
    }
    function calPrice(obj)
    {
        var trs=$(obj).parents('tr:first');
        var tprice=0;
        trs.find('input:text').each(function(index, element) {
            var price=parseInt($(element).val());
            if(!isNaN(price))
                tprice+=price;
        });
        trs.find(".tprice").html("<font color='#FF9900'>"+tprice+"</font>元");
    }
    //修改报价
    function edit_price(date)
    {
        var suitid = $("#suitid").val();
        var lineid = $("#productid").val();
        CHOOSE.setSome("修改报价("+date+')',{maxHeight:500,width:540,loadWindow:window,loadCallback:calendar_edit},SITEURL+'line/admin/line/dialog_edit_suit_price?suit='+suitid+'&date='+date+'&lineid='+lineid,1)
    }
    //修改报价，更新日历
    function calendar_edit(data,bool)
    {
        if(!bool)
        {
            return false;
        }
        else
        {
            $.ajax({
                data:data.data,
                dataType:'json',
                type:'post',
                url:SITEURL+'line/admin/line/ajax_save_day_price',
                success:function (data) {
                    ST.Util.showMsg('保存成功',4,1000);
                    set_calendat_day_params(data)
                }
            })
        }
    }
    //修改日历某天的显示数据
    function set_calendat_day_params(data) {
        var obj = $('td[data-date='+data.date+']');
        var propgroup = data.propgroup.split(',');
        if(propgroup[0])
        {
            var adultprice = '' ;
            var childprice = '';
            var oldprice = '';
            var resultInfo='';
            if($.inArray('2',propgroup)!=-1)
            {
                resultInfo += '<b class="yes_yd  line_yes_yd">成人:'+back_symbol+data.adultprice+'<br></b>';
            }
            if($.inArray('1',propgroup)!=-1)
            {
                resultInfo += '<b class="yes_yd  line_yes_yd">儿童:'+back_symbol+data.childprice+'<br></b>';
            }
            if($.inArray('3',propgroup)!=-1)
            {
                resultInfo += '<b class="yes_yd  line_yes_yd">老人:'+back_symbol+data.oldprice+'<br></b>';
            }
            var msg=data.number==-1?'充足':data.number;
            $(obj).find('.yes_yd').remove();
            $(obj).find('.num').after(resultInfo);
            $(obj).find('.kucun').html('库存:'+msg);
            $(obj).find('.roombalance_b').html('单房差:'+back_symbol+data.roombalance);
        }
        else
        {
            $(obj).find('.yes_yd').html('');
            $(obj).find('.kucun').html('');
            $(obj).find('.roombalance_b').html('');
        }
    }
</script>
</body>
</html>