<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>选择产品</title>
    {Common::css("style.css,base.css,base2.css,dialog_basic.css")}
    {Common::js("jquery.min.js,common.js,product.js,choose.js")}
    {include "pub/public_js"}
</head>
<body >
<div class="s-main">
    <div class="s-search">
        <div class="txt-wp">
            <input type="text" name="keyword" placeholder="产品标题"  id="keyword" class="s-txt"/><a href="javascript:;" id="search_btn" class="s-btn"></a>
        </div>
    </div>
    <div class="s-list" style="height:355px">
        <table id="dlg_tb" class="dlg-list" bottom_float=Mg2qek >
            <tr class="dlg-hd"><th class="hd-last">选择</th><th width="20%">产品编号</th><th width="70%">产品标题</th></tr>
        </table>
        <div id="page_info" class="page-info">

        </div>
    </div>
    <div class="save-con clear">
        <a href="javascript:;" class="confirm-btn">确定</a>
    </div>
</div>
<script>
    $(function()
    {
        load(1);
        $("#search_btn").click(function(){
            load(1);
        });
        //确定
        $(".confirm-btn").click(function(){
            var sel_ele=$(".tb-ck:checked");
            var product={
                id:sel_ele.val(),
                title:sel_ele.attr('title')
            };
            ST.Util.responseDialog(product,true);
        });
    })

   function load(page)
   {
       var keyword = $("#keyword").val();
       var typeid = $("#typeid").val();
       var url=SITEURL+'index/ajax_get_products';
       $.ajax({
           type: "post",
           url: url,
           dataType: 'json',
           data: {page: page, keyword: keyword,typeid:typeid},
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
          // var check_str= is_choosed(typeid,row['id'])?'checked="checked"':'';
           html+="<tr class='tb-item'><td align='center'>" +
           "<input type='radio' class='tb-ck' name='productid'  title='"+row['title']+"' value='"+row['id']+"'/>" +
           "</td><td align='center'>"+row['series']+"</td>" +
           "<td><a href='"+row['url']+"' target='_blank'>"+row['title']+"</a>" +
           "</td></tr>"
       }

       $("#dlg_tb .tb-item").remove();
       $("#dlg_tb").append(html);
       var selectHtml = '';
       var pageHtml = selectHtml + page(result.pagesize, result.page, result.total, 5);
       $("#page_info").html(pageHtml);
       $("#page_info a").click(function () {
           var page = $(this).attr('page');
           load(page);
       });
   }
    
   function is_choosed(typeid,productid)
   {
       if(!g_choosed_products[typeid] || !g_choosed_products[typeid]['products'] || g_choosed_products[typeid]['products'].length==0)
       {
           return false;
       }
       for(var i in g_choosed_products[typeid]['products'])
       {
          if(productid == g_choosed_products[typeid]['products'][i]['id'])
          {
              return true;
          }
       }
       return false;
   }
   function page(pageSize, currentPage, totalCount, displayNum, params) {
        var defaultParams = {
            hint: '<span class="pageHint">总共<span class="totalPage">{totalPage}</span>页,共<span class="totalCount">{totalCount}</span>条记录</span>'
        };
        if (params) {
            defaultParams = $.extend(defaultParams, params);
        }
        if (!totalCount || totalCount == 0)
            return '';

        displayNum = !displayNum ? 6 : displayNum;
        var totalPage = Math.ceil(totalCount / pageSize);
        var html = "<div class='pageContainer'><span class='pagePart'>";
        if (currentPage <= 1) {
            html += '<span class="firstPage short" title="第一页"></span>';
            html += '<span class="prevPage short" title="上一页"></span>';
        }
        else {
            html += '<a href="javascript:;" class="firstPage short" title="第一页" page="1"></a>';
            var prevPage = parseInt(currentPage) - 1;
            html += '<a  href="javascript:;" class="prevPage short" title="上一页" page="' + prevPage + '"></a>';
        }
        var flowNum = Math.floor(displayNum / 2);
        var leftTicks = displayNum % 2 == 0 ? flowNum : flowNum;
        var rightTicks = displayNum % 2 == 0 ? flowNum - 1 : flowNum;

        var minPage = 1;
        var maxPage = totalPage;
        if (currentPage > (leftTicks + 1) && totalPage > displayNum) {
            minPage = currentPage - leftTicks;
            maxPage = minPage + displayNum - 1;
        }
        if (currentPage > totalPage - rightTicks && totalPage > displayNum) {
            maxPage = totalPage;
            minPage = totalPage - displayNum + 1;
        }
        if (currentPage <= leftTicks + 1 && totalPage > displayNum) {
            maxPage = displayNum;
        }
        if (minPage > 1) {
            html += '<span class="more floor">...</span>';
        }
        for (var i = minPage; i <= maxPage; i++) {
            if (i == currentPage) {
                html += '<span class="current floor">' + i + '</span>';
                continue;
            }
            html += '<a href="javascript:;" class="pageable floor" page="' + i + '">' + i + '</a>';
        }
        if (maxPage < totalPage) {
            html += '<span class="more floor">...</span>';
        }
        if (currentPage != totalPage) {
            var nextPage = parseInt(currentPage) + 1;
            html += '<a href="javascript:;" title="下一页" class="nextPage short" page="' + nextPage + '"></a>';
            html += '<a href="javascript:;" title="最后一页" class="lastPage short" page="' + totalPage + '"></a>';
        }
        else {
            html += '<span class="nextPage short" title="下一页"></span>';
            html += '<span class="lastPage short" title="最后一页"></span>';
        }
        html += '</span>';
        var hint = defaultParams['hint'].replace('{totalPage}', totalPage);
        hint = hint.replace('{totalCount}', totalCount);
        html += hint;
        html += '</div>';
        return html;

    }
</script>
</body>
</html>
