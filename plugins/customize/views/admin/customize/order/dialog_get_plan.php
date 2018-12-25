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
        <div class="txt-wp">
            <input type="text" name="keyword" placeholder="方案标题"  id="keyword" class="s-txt"/><a href="javascript:;" id="search_btn" class="s-btn"></a>
        </div>
    </div>
    <div class="s-list" style="height:355px">
        <table id="dlg_tb" class="dlg-list">
            <tr class="dlg-hd"><th width="80%">方案标题</th><th class="hd-last">选择</th></tr>

        </table>
        <div id="page_info" class="page-info"></div>
    </div>
    <div class="save-con">
        <a href="javascript:;" class="confirm-btn">确定</a>
    </div>
</div>
<script>
    var data_pool={};
    $(function(){
        load(1);
        $("#search_btn").click(function(){
            load(1);
        });
        //确定
        $(".confirm-btn").click(function(){
            var id=$(".tb-ck:checked").val();
            if(!id)
            {
                ST.Util.showMsg('请先选择方案','5',1500);
                return;
            }
            var data=data_pool[id];
            ST.Util.responseDialog(data,true);
        });
    })

   function load(page)
   {
       var keyword = $("#keyword").val();
       var url=SITEURL+'customize/admin/order/ajax_get_plan';
       $.ajax({
           type: "post",
           url: url,
           dataType: 'json',
           data: {page: page, keyword: keyword},
           success: function (result, textStatus){
               gen_list(result);
           }
       });
   }

   function gen_list(result)
   {
       var html='';

       for(var i in result.list)
       {
           var row=result.list[i];
           data_pool[row['id']]=row;
           html+="<tr class='tb-item'><td>"+row['title']+"</td><td align='center'><input type='radio' class='tb-ck' name='planid' value='"+row['id']+"'/></td></tr>"
       }

       $("#dlg_tb .tb-item").remove();
       $("#dlg_tb").append(html);

       var pageHtml = ST.Util.page(result.pagesize, result.page, result.total, 10);
       $("#page_info").html(pageHtml);
       $("#page_info a").click(function () {
           var page = $(this).attr('page');
           load(page);
       });
   }
</script>
</body>
</html>
