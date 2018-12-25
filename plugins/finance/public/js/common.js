$(function(){

    //菜单选中
    var url = window.location.href;
    $(".menu-left .leftnav a").each(function(){
        var $this = $(this);
        var href = $this.attr('data-url');
        if(url.indexOf(href)!=-1)
        {
            $this.addClass("active");
        }
    });
});

//生成分页
function gen_pager(pageSize,currentPage,totalCount,displayNum,params){
    var defaultParams={
        /*hint:'<span class="pageHint">总共<span class="totalPage">{totalPage}</span>页,共<span class="totalCount">{totalCount}</span>条记录</span>'*/
    };

    if(params)
    {
        defaultParams= $.extend(defaultParams,params);
    }
    if(!totalCount||totalCount==0)
        return '';

    displayNum=!displayNum?6:displayNum;
    var totalPage=Math.ceil(totalCount/pageSize);
    var html="<div class='pm-fy-page'><div class='main_mod_page clear'><p class='page_right'>";
    if(currentPage<=1)
    {

    }
    else
    {
        html+='<a href="javascript:;" class="back-first" data-pageno="1" title="第一页" page="1"></a>';
        var prevPage=parseInt(currentPage)-1;
        html+='<a  href="javascript:;" class="prev" data-pageno="'+prevPage+'" title="上一页" page="'+prevPage+'"></a>';
    }
    var flowNum=Math.floor(displayNum/2);
    var leftTicks=displayNum%2==0?flowNum:flowNum;
    var rightTicks=displayNum%2==0?flowNum-1:flowNum;

    var minPage=1;
    var maxPage=totalPage;

    html+='<span class="mod_pagenav_count">';
    if(currentPage>(leftTicks+1)&&totalPage>displayNum)
    {
        minPage=currentPage-leftTicks;
        maxPage=minPage+displayNum-1;
    }
    if(currentPage>totalPage-rightTicks&&totalPage>displayNum)
    {
        maxPage=totalPage;
        minPage=totalPage-displayNum+1;
    }
    if(currentPage<=leftTicks+1&&totalPage>displayNum)
    {
        maxPage=displayNum;
    }
    if(minPage>1)
    {
        // html+='<span class="more floor">...</span>';
    }
    for(var i=minPage;i<=maxPage;i++)
    {
        if(i==currentPage)
        {
            html+='<a class="current"  href="javascript:;" data-pageno="'+i+'">'+i+'</a>';
            continue;
        }
        html+='<a href="javascript:;" class="" data-pageno="'+i+'">'+i+'</a>';
    }
    if(maxPage<totalPage)
    {
        //  html+='<span class="more floor">...</span>';
    }
    html+='</span>';
    if(currentPage!=totalPage)
    {
        var nextPage=parseInt(currentPage)+1;
        html+='<a href="javascript:;" data-pageno="'+nextPage+'" title="下一页" class="next" page="'+nextPage+'"></a>';
        html+='<a href="javascript:;" data-pageno="'+totalPage+'" title="最后一页" class="go-last" page="'+totalPage+'"></a>';
    }
    else
    {
        // html+='<span class="nextPage short" title="下一页">下一页</span>';
        //  html+='<span class="lastPage short" title="最后一页"></span>';
    }
    html+='</p></div></div>';

    var text ='<div class="page-text ml-20"><p>总共 <span class="color-red">'+totalPage+'</span> 页,共 <span class="color-red">'+totalCount+'</span> 条记录</p></div>';

    return html+text;
}
(function($){
    var STTOOL = {};
    var STMath={
        add:function(a, b) {
            var c, d, e;
            try {
                c = a.toString().split(".")[1].length;
            } catch (f) {
                c = 0;
            }
            try {
                d = b.toString().split(".")[1].length;
            } catch (f) {
                d = 0;
            }
            return e = Math.pow(10, Math.max(c, d)), (this.mul(a, e) + this.mul(b, e)) / e;
        },
        sub:function(a, b) {
            var c, d, e;
            try {
                c = a.toString().split(".")[1].length;
            } catch (f) {
                c = 0;
            }
            try {
                d = b.toString().split(".")[1].length;
            } catch (f) {
                d = 0;
            }
            return e = Math.pow(10, Math.max(c, d)), (this.mul(a, e) - this.mul(b, e)) / e;
        },
        mul:function(a, b) {
            var c = 0,
                d = a.toString(),
                e = b.toString();
            try {
                c += d.split(".")[1].length;
            } catch (f) {}
            try {
                c += e.split(".")[1].length;
            } catch (f) {}
            return Number(d.replace(".", "")) * Number(e.replace(".", "")) / Math.pow(10, c);
        },
        div: function(a, b){
            var c, d, e = 0,
                f = 0;
            try {
                e = a.toString().split(".")[1].length;
            } catch (g) {}
            try {
                f = b.toString().split(".")[1].length;
            } catch (g) {}
            return c = Number(a.toString().replace(".", "")), d = Number(b.toString().replace(".", "")), this.mul(c / d, Math.pow(10, f - e));
        }
    }
    STTOOL.Math = STMath;
    window.STTOOL = STTOOL;
})(jQuery)