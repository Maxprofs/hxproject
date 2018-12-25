<?php defined('SYSPATH') or die();?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {template 'stourtravel/public/public_min_js'}
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
            height:600px;
            padding-left:10px;
            float:left;
        }
        table td {
            border: 1px solid #dcdcdc;
            width:54px;
            max-height:67px;

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

{$calendar}
<input type="hidden" id="typeid" value="{$typeid}">
<script language="javascript">

    var typeid="{$typeid}";
    //修改单独报价
    function  modPrice(obj)
    {
        var price = $(obj).attr('data-price');//
        var profit = $(obj).attr('data-profit');
        var basicprice = $(obj).attr('data-basicprice');
        var suitid = $(obj).attr('data-suitid');
        var day = $(obj).attr('data-day');
        var daydate =$(obj).attr('data-date');


        var productid=$(obj).attr('data-productid');

        //库存
        var number = $(obj).attr('data-number');




       // var title = typeid==1 ? '成人价格' : '价格';
        var html = '<table id="tabl">';
        var title='产品';


       html+= '<tr>' +
            '<td>'+title+'报价:</td>' +
            '<td>成本<input type="text" size="5" onkeyup="calPrice(this)" class="txt" id="basicprice" name="adultbasicprice"  value="'+basicprice+'"/></td>' +
            '<td>&nbsp;利润<input type="text" size="5"  onkeyup="calPrice(this)" class="txt" id="profit" name="adultprofit" value="'+profit+'"/></td>' +
            '<td class="tprice"><font color="#FF9900">'+price+'</font>元</td>' +
            '</tr>'



        //库存
        html+= '<tr>' +
            '<td>产品库存:</td>' +
            '<td colspan="3"><input type="text" size="5" class="txt" id="number" name="number"  value="'+number+'"/></td>' +

            '</tr>'
            html+=  '</table>';
            html+= "<style>" +
                "#tabl tr td{height:50px;font-size:12px;}"+
                "</style>";

        parent.window.dialog({
            title: daydate+'价格修改',
            okValue:'确定',
            content:html,
            ok: function () {

                //成人
                var basicprice = $("#basicprice",parent.document).val();
                var profit = $("#profit",parent.document).val();


                //库存
                var number = $("#number",parent.document).val();



                var params={
                    basicprice:basicprice,
                    profit:profit,
                    number:number,
                    productid:productid
                }
                params.suitid = suitid;
                params.day = day;


                 $.ajax({
                 type:"POST",
                 url: SITEURL+'hotel/admin/calendar/ajax_modprice',
                 data: params,
                 dataType: 'json',
                 success: function(data)
                 {

                 if(data.status==true){
                     var resultInfo='';
                     var msg=data.number==-1?'不限':data.number;
                     if(data.price>0)
                     {
                         resultInfo='报价:'+data.price;
                     }


                     ST.Util.showMsg('保存成功',4,1000)
                     $(obj).find('.yes_yd').html(resultInfo);
                     $(obj).find('.kucun').html('库存:'+msg);
                     $(obj).attr('data-number',data.number);
                     //成人
                     $(obj).attr('data-price',data.price);//
                     $(obj).attr('data-profit',data.profit);
                      $(obj).attr('data-basicprice',data.basicprice);

                 };

                 }
               })

            }
        }).show();

        //$.jBox(html, {title: daydate+'价格修改', width:340,top:'30%',submit:submit});
    }
    //添加单独报价
    function addPrice(obj)
    {


        var suitid = $(obj).attr('data-suitid');
        var productid=$(obj).attr('data-productid');
        var day =$(obj).attr('data-day');
        var daydate =$(obj).attr('data-date');

        //var title = typeid==1 ? '成人价格' : '价格';
        var html = '<table id="tabl">';


        html+= '<tr>' +
            '<td>产品报价:</td>' +
            '<td>成本<input type="text" size="5" onkeyup="calPrice(this)" class="txt" id="basicprice" name="adultbasicprice"  value=""/></td>' +
            '<td>&nbsp;利润<input type="text" size="5"  onkeyup="calPrice(this)" class="txt" id="profit" name="adultprofit" value=""/></td>' +
            '<td class="tprice"><font color="#FF9900"></font>元</td>' +
            '</tr>'

        //库存
        html+= '<tr>' +
            '<td>产品库存:</td>' +
            '<td colspan="3"><input type="text" size="5" class="txt" id="number" name="number"  value=""/></td>' +

            '</tr>'



        html+=  '</table>';
        html+= "<style>" +
            "#tabl tr td{height:50px;font-size:12px;}"+
            "</style>";



        parent.window.dialog({
            title: daydate+'价格添加',
            okValue:'确定',
            content:html,
            ok: function () {


                //成人
                var basicprice = $("#basicprice",parent.document).val();
                var profit = $("#profit",parent.document).val();


                //库存
                var number = $("#number",parent.document).val();



                var params={
                    basicprice:basicprice,
                    profit:profit,
                    number:number
                }
                params.suitid = suitid;
                params.day = day;
                params.productid = productid;

                $.ajax({
                    type:"POST",
                    url: SITEURL+'hotel/admin/calendar/ajax_addprice',
                    data: params,
                    dataType: 'json',
                    success: function(data)
                    {

                        if(data.status==true){

                            ST.Util.showMsg('保存成功',4,1000)
                            $(obj).find('.no_yd').html('报价：¥'+data.price);
                            $(obj).find('.no_yd').removeClass('no_yd').addClass('yes_yd');
                            $(obj).find('.kucun').html('库存:'+data.number);


                            $(obj).attr('data-number',data.number);
                            //成人
                            $(obj).attr('data-price',data.price);//
                            $(obj).attr('data-profit',data.profit);
                            $(obj).attr('data-basicprice',data.basicprice);


                            $(obj).removeAttr('onclick');
                            $(obj).click(function(){
                                modPrice(obj);
                            })

                        };

                    }
                })

            }
        }).show();


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
</script>

</body>
</html>