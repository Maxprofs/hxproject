<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>结算统计-{$webname}</title>

    {Common::css("style.css,base.css")}
    {Common::css("extend.css")}
    {Common::js("jquery.min.js,finance_common.js,finance_ordercount.js")}

    <script type="application/javascript" src="/res/js/datepicker/WdatePicker.js"></script>
    <script type="application/javascript" src="/res/js/template.js"></script>

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
                    <div class="finance-tit"><strong class="bt">结算统计</strong></div>
                    <div class="finance-bloock">
                        <div class="census-item">
                            <ul>
                                <li class="clearfix">
                                    <strong class="item-bt">产品类型：</strong>
                                    <div class="item-nr">


                                        <select class="search-select module-select attr-select" name="">
                                            <option value="-1">全部</option>
                                            {loop $modules $m}
                                            <option value="{$m['id']}">{$m['modulename']}</option>
                                            {/loop}

                                        </select>
                                    </div>
                                </li>
                                <li class="clearfix" id="li_product_name" style="display: none">
                                    <strong class="item-bt">产品名称：</strong>
                                    <div class="item-nr">
                                        <a href="javascript:;" id="choose-btn" class="choose-btn">选择</a>
                                        <span class="cp-title" style="display: none"><i class="close-btn"></i></span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">支付时间：</strong>
                                    <div class="item-nr">
                                            <span class="date-box">
                                                <input type="text" class="date-start" id="starttime">
                                                <i class="date-ico"></i>
                                            </span>
                                        <span>&nbsp;&nbsp;至&nbsp;&nbsp;</span>
                                            <span class="date-box">
                                                <input type="text" class="date-end" id="endtime">
                                                <i class="date-ico"></i>
                                            </span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">订单状态：</strong>
                                    <div class="item-nr">
                                        <select name="" class="attr-select" id="order_status">
                                            <option value="-1">全部</option>
                                            <option value="0">处理中</option>
                                            <option value="1">等待付款</option>
                                            <option value="2">已付款</option>
                                            <option value="3">已取消</option>
                                            <option value="4">退款成功</option>
                                            <option value="5">交易完成</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">结算状态：</strong>
                                    <div class="item-nr">
                                        <select name="" class="attr-select" id="settle_status">
                                            <option value="-1">全部</option>
                                            <option value="0">未结算</option>
                                            <option value="1">已结算</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">统计字段：</strong>
                                    <div class="item-nr" id="count_fields">

                                        {loop $count_fields $k $v}
                                        <label class="census-attr"><input type="checkbox" {if $v['checked']}checked="checked"{/if} name="{$k}">{$v['title']}</label>
                                        {if $n%8==0}
                                        <br/>
                                        {/if}
                                        {/loop}

                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">&nbsp;</strong>
                                    <div class="item-nr">
                                        <a href="javascript:;" class="create-table" id="create-table">生成报表</a>
                                        <a href="javascript:;" class="create-table" id="export_excel">导出报表</a>
                                    </div>
                                </li>
                                <li class="clearfix no-float" id="count-msg-container">
                                    <div class="item-nr">
                                        <ul>
                                            <!--<li>订单数量：<span id="total">1</span></li>-->
                                            <li class="count-item">订单总额：<span id="totalprice"></span></li>
                                            <li class="count-item">产品成本：<span id="basicprice"></span></li>
                                            <!--<li class="count-item">支付总额：<span id="payprice"></span></li>-->
                                            <!--<li class="count-item">积分抵现：<span id="jifentprice"></span></li>-->
                                            <li class="count-item">平台返佣：<span id="commission"></span></li>
                                            <li class="count-item count-item-last">结算金额：<span id="settle_amount"></span></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="view-block-table">
                            <div class="explain-txt"><!--<a href="#" target="_blank">关键字段说明</a>--></div>
                            <table class="show-table" width="100%" border="0">
                                <tbody id="order_list">
                                <tr id="order_list_header">

                                    {loop $count_fields $k $v}
                                    <th data-name="{$k}">{$v['title']}</th>
                                    {/loop}

                                </tr>

                                </tbody></table>
                            <div class="pm-btm-box">
                                <div class="pm-btm-msg pm-btm-msg-order-list">

                                    <div class="show-num ml-20" id="order_list_page">
                                        每页显示数量：
                                        <select name="" id="order_pagesize">
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
                </div><!-- 结算统计 -->

                <div id="choose-product" class="popup-layer" style="">
                    <div class="finance-popup-content">
                        <div class="popup-tit"><strong>选择产品</strong><i id="close-pdt-btn" class="close-btn"></i></div>
                        <div class="finance-popup-block">
                            <div class="search-term clearfix">

                                <div class="search-box">
                                    <input type="text" class="search-text search-text-product" placeholder="产品名称/产品编号">
                                    <input type="button" class="search-btn search-btn-product">
                                </div>
                                <div class="txt">输入产品名称或编号进行搜索，搜索刷新下面的结果列表。若没有列表显示为空</div>
                            </div>
                            <div class="search-list">
                                <form name="">
                                    <table class="table-list" width="100%" border="0">
                                        <tbody>
                                        <tr id="product_header">
                                            <th width="15%">编号</th>
                                            <th width="75%"><div class="pd-name">产品名称</div></th>
                                            <th width="10%">选择</th>
                                        </tr>


                                        </tbody>
                                    </table>
                                    <script type="text/html" id="tpl_product_list">

                                        {{each list as value i}}
                                        <tr>
                                            <td>{{value.series}}</td>
                                            <td><div class="pd-name">{{value.title}}</div></td>
                                            <td><label class="radio-btn">
                                                <input type="radio" name="products" {{if i==0}}checked="checked"{{/if}} data-id={{value.id}}>
                                            </label>
                                            </td>
                                        </tr>
                                        {{/each}}

                                    </script>
                                </form>
                            </div>
                            <div class="pm-btm-box">
                                <div class="pm-btm-msg pm-btm-msg-product">

                                </div>
                            </div>
                            <div class="sure-item"><a class="sure-btn" href="javascript:;">确定</a></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="st-record">{Common::get_sys_para('cfg_supplier_footer')}</div>
        </div>
    </div>
    <!-- 主体内容 -->

    <input type="hidden" id="category" value="1">

</div>

<script>
    window.count_fields='{json_encode($count_fields)}';

    $(function () {
        $("#nav_ordercount").addClass('on');

    });
</script>
</body>
</html>
