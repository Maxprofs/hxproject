<!doctype html>
<html>
<head font_float=Vcyt-j >
    <meta charset="utf-8">
    <title>交易记录-{$webname}</title>

    <link type="text/css" rel="stylesheet" href="/plugins/supplier_finance/public/default/pc/css/base.css">
    <link type="text/css" rel="stylesheet" href="/plugins/supplier_finance/public/default/pc/css/style.css">


    {Common::css("style.css,base.css")}
    {Common::js("jquery.min.js")}

    <script type="text/javascript"src="/res/js/template.js"></script>
    <script type="application/javascript" src="/plugins/supplier_finance/public/default/pc/js/finance_common.js"></script>
</head>

<body>

<div class="page-box">
    {request 'pc/pub/header'}
    <!-- 顶部 -->

    {template 'pc/pub/sidemenu'}
    <!-- 侧边导航 -->

    <div class="main">
        <div class="content-box">
            <div class="frame-box">
                <div class="finance-content">
                    <div class="finance-tit"><strong class="bt">交易记录</strong></div>
                    <div class="finance-bloock">

                        <div class="census-item census-item-float-left">
                            <ul>
                                <li class="clearfix">
                                    <strong class="item-bt">交易名称：</strong>
                                    <div class="item-nr">
                                        <input type="text" class="date-start" id="deal_name" style="padding-left: 5px" placeholder="交易名称" >
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">交易类型：</strong>
                                    <div class="item-nr">
                                        <select name="" class="attr-select" id="deal_type" style="padding-left: 5px">
                                            <option value="0">全部</option>
                                            <option value="1">销售</option>
                                            <option value="2">提现</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">交易状态：</strong>
                                    <div class="item-nr">
                                        <select name="" class="attr-select" id="deal_status" style="padding-left: 5px">
                                            <option value="0">全部</option>
                                            <option value="1">交易处理中</option>
                                            <option value="2">交易成功</option>
                                            <option value="3">交易失败</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <div class="item-nr">
                                        <a href="javascript:;"  class="choose-btn">搜索</a>
                                    </div>
                                </li>


                            </ul>
                        </div>


                        <div class="cw-table clearfix">

                            <table width="100%" border="0">
                                <tbody>
                                <tr id="record_list_header">
                                    <th width="15%">创建时间</th>
                                    <th width="40%">交易名称</th>
                                    <th width="15%">交易类型</th>
                                    <th width="15%">金额</th>
                                    <th width="15%">交易状态</th>
                                </tr>

                                </tbody>
                            </table>
                            <!--<a href="#" target="_blank" class="all-list-link">查看所有交易记录</a>-->
                        </div>
                        <script type="text/html" id="tpl_record_list">
                            {{each list as value i}}
                            <tr>
                                <td>{{value.addtime}}</td>
                                <td><div class="name">{{value.productname}}</div></td>
                                <td>{{value.type_name}}</td>
                                <td>{{value.operator}}{{value.price}}</td>
                                <td>{{value.status_name}}</td>
                            </tr>
                            {{/each}}
                        </script>


                        <div class="view-block-table">
                            <div class="pm-btm-box">
                                <a href="javascript:;" onclick="order_record_export_excel()" class="create-table" id="export_excel">导出报表</a>

                                <div class="pm-btm-msg pm-btm-msg-order-list">

                                    <div class="show-num ml-20" id="order_list_page">
                                        每页显示数量：
                                        <select name="" id="pagesize">
                                            <option value="15">15</option>
                                            <option value="30">30</option>
                                            <option value="40">40</option>
                                            <option value="50">50</option>
                                            <option value="60">60</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- 财务总览 -->
            </div>
            <div class="st-record">{Common::get_sys_para('cfg_supplier_footer')}</div>
        </div>
    </div>

<input type="hidden" id="total">

    <!-- 主体内容 -->

</div>

<script>
    $(function () {
        $("#nav_orderrecord").addClass('on');
        $(".choose-btn").click(function(){
           get_data_list(1);
        });
        //分页事件
        $(document).on('click',".page_right a:not('.current')",function(){
            var pageno = $(this).attr("data-pageno");
            get_data_list(pageno);
        });

    });

    function get_data_list(pageno)
    {
        var keyword = $("#deal_name").val();
        var deal_type = $("#deal_type").val();
        var deal_status = $("#deal_status").val();
        var pagesize = $("#pagesize").val();
        var url = SITEURL + 'pc/financeextend/orderrecord?action=read';
        $.get(url,{
            keyword:keyword,
            deal_type:deal_type,
            deal_status:deal_status,
            pagesize:pagesize,
            pageno:pageno
        },function(data){
            var html = template("tpl_record_list", data);
            $("#record_list_header").siblings().remove().end().after(html);
            //分页
            var pager = gen_pager(pagesize, pageno, data.total);
            $("#order_list_page").siblings().remove().end().before(pager);
        },'json');
    }

    //导出交易记录Excel
    function order_record_export_excel()
    {
        var keyword = $("#deal_name").val();
        var deal_type = $("#deal_type").val();
        var deal_status = $("#deal_status").val();
        var url = SITEURL + "pc/financeextend/orderrecord_export_excel/?deal_type="+deal_type+"&deal_status="+deal_status+"&keyword="+keyword;
        window.open(url);
    }
</script>

<link type="text/css" rel="stylesheet" href="/plugins/supplier_finance/public/default/pc/css/extend.css">
</body>
</html>
