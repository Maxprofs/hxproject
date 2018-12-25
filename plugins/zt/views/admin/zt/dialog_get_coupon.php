<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base.css,dialog_basic.css'); }
</head>
<body >
<div class="s-main">

    <div class="s-list" >
        <table id="dlg_tb" class="dlg-list">
            <tr class="dlg-hd">
                <th width="15%">优惠券编码</th>
                <th width="15%">优惠券类型</th>
                <th width="35%">优惠券名称</th>
                <th width="20%">有效期</th>
                <th class="hd-last">选择</th></tr>
        </table>
        <div id="page_info" class="page-info"></div>
    </div>
    <div class="save-con">
        <a href="javascript:;" class="confirm-btn">确定</a>
    </div>
</div>
<script>
    var data_pool=[];
    var channelid="{$channelid}";
    $(function(){
        load(1);
        $("#search_btn").click(function(){
            load(1);
        });
        //确定
        $(".confirm-btn").click(function(){
            saveIds();

            if(data_pool.length==0)
            {
                ST.Util.showMsg('请先选择优惠券','5',1500);
                return;
            }
            var url=SITEURL+'zt/admin/zt/ajax_set_channel_coupon';

            $.ajax({
                type: "post",
                url: url,
                dataType: 'json',
                data: {channelid:channelid,couponids:data_pool.join(',')},
                success: function (result){

                    ST.Util.responseDialog(result.channelid,true);
                }
            });
        });

    })

   function load(page)
   {

       var url=SITEURL+'zt/admin/zt/ajax_get_coupon';
       $.ajax({
           type: "post",
           url: url,
           dataType: 'json',
           data: {page: page},
           success: function (result, textStatus){
               saveIds();
               gen_list(result);
               ST.Util.resizeDialog('.s-main');
           }
       });
   }

   function gen_list(result){
       var html='';
       for(var i in result.list)
       {
           var row=result.list[i];
           var check_str= $.inArray(row['id'],data_pool)!=-1?'checked="checked"':'';
           html+="<tr class='tb-item'>";
           html+="<td align='center'>"+row['code']+"</td>";
           html+="<td align='center'>"+row['kindname']+"</td>";
           html+="<td align='center'>"+row['name']+"</a></td>";
           html+="<td align='center'>"+row['endtime']+"</a></td>";
           html+="<td align='center'><input type='checkbox' class='tb-ck' name='productid' value='"+row['id']+"' "+check_str+"/></td>";
           html+="</tr>";
       }

       $("#dlg_tb .tb-item").remove();
       $("#dlg_tb").append(html);

       var pageHtml = ST.Util.page(result.pagesize, result.page, result.total, 5);
       $("#page_info").html(pageHtml);
       $("#page_info a").click(function () {
           var page = $(this).attr('page');
           load(page);
       });
   }
   function saveIds()
   {

       $(".tb-ck").each(function(){
           var id = $(this).val();
           if($.inArray(id,data_pool)==-1 && $(this).is(":checked"))
           {
               data_pool.push(id);
           }
           else if($.inArray(id,data_pool)!=-1 && !$(this).is(":checked"))
           {
               data_pool.splice($.inArray(id,data_pool),1);
           }
       })

   }


</script>
</body>
</html>
