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
    <div class="s-search">
        <div class="fl">
            <select id="typeid" style="height: 25px;line-height: 25px;margin-right: 5px" onchange="load(1)">
                {loop $channel_arr $channel}
                <option value="{$channel['id']}">{$channel['modulename']}</option>
                {/loop}
            </select>
        </div>
        <div class="txt-wp">
            <input type="text" name="keyword" placeholder="输入产品标题搜索"  id="keyword" class="s-txt" style="padding-left:3px"/><a href="javascript:;" id="search_btn" class="s-btn"></a>
        </div>
    </div>
    <div class="s-list" style="height:355px">
        <table id="dlg_tb" class="dlg-list">
            <tr class="dlg-hd"><th width="20%">产品编号</th><th width="60%">产品标题</th><th class="hd-last">选择</th></tr>
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
                ST.Util.showMsg('请先选择产品','5',1500);
                return;
            }
            var url=SITEURL+'zt/admin/zt/ajax_set_channel_product';
            var typeid = $('#typeid').val();
            $.ajax({
                type: "post",
                url: url,
                dataType: 'json',
                data: {typeid:typeid,channelid:channelid,productids:data_pool.join(',')},
                success: function (result){

                    ST.Util.responseDialog(result.channelid,true);
                }
            });
        });

    })

   function load(page)
   {
       var keyword = $("#keyword").val();
       var typeid = $('#typeid').val();
       var url=SITEURL+'zt/admin/zt/ajax_get_products';
       $.ajax({
           type: "post",
           url: url,
           dataType: 'json',
           data: {page: page, keyword: keyword,typeid:typeid},
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
           html+="<tr class='tb-item'><td align='center'>"+row['series']+"</td><td><a href='"+row['url']+"' target='_blank'>"+row['title']+"</a></td><td align='center'><input type='checkbox' class='tb-ck' name='productid' value='"+row['id']+"' "+check_str+"/></td></tr>"
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
