<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>结算记录-{$webname}</title>
    {Model_Supplier::css("style.css,base.css,extend.css",'brokerage')}
    {Common::js("jquery.min.js")}


</head>

<body>

<div class="page-box">
    {request 'pc/pub/header'}
    <!-- 顶部 -->

    {template 'pc/brokerage/sidemenu'}
    <!-- 侧边导航 -->

    <div class="main">
        <div class="content-box">
            <div class="frame-box">
                <div class="finance-content">
                    <div class="finance-bloock">
                        <div class="census-item census-item-float-left">
                            <ul>

                                <li class="clearfix">
                                    <strong class="item-bt">结算状态：</strong>
                                    <div class="item-nr">
                                        <select name="" class="attr-select" id="status" style="padding-left: 5px">
                                            <option value="0">全部</option>
                                            <option value="1" {if $status==1}selected{/if}>未结算</option>
                                            <option value="2" {if $status==2}selected{/if}>已结算</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">产品名称：</strong>
                                    <div class="item-nr">
                                        <input type="text" class="date-start" value="{$keyword}" id="keyword" style="padding-left: 5px" placeholder="产品名称" >
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
                                    <th width="10%">订单号</th>
                                    <th width="20%">产品名称</th>
                                    <th width="10%">收款时间</th>
                                    <th width="10%">订单状态</th>
                                    <th width="15%">应结金额</th>
                                    <th width="15%">未结金额</th>
                                    <th width="15%">已结金额</th>
                                    <th width="10%">结算状态</th>
                                </tr>

                                {loop $list $l}
                                <tr>
                                    <td>{$l['ordersn']}</td>
                                    <td>{$l['productname']}</td>
                                    <td>{$l['addtime']}</td>
                                    <td>{if $l['order_status']==2}待消费{else}已完成{/if}</td>
                                    <td>{$l['brokerage']}{if $l['dingjin']>0&&$l['paytype']==2}(定金:{$l['dingjin']}){/if}</td>
                                    <td>{if $l['open_price']} <span style="color: red">{$l['open_price']}</span>{else}0{/if}</td>
                                    <td>{$l['finish_brokerage']}</td>
                                    <td>{if $l['status']==1} <span style="color: red">未结算</span>{else}已结算{/if}</td>
                                </tr>
                                {/loop}
                                </tbody>
                            </table>
                        </div>
                        <div class="view-block-table">
                            {$pageinfo}
                        </div>
                    </div>
                </div><!-- 财务总览 -->
            </div>
            <div class="st-record">{Common::get_sys_para('cfg_supplier_footer')}</div>
        </div>
    </div>



</div>


</body>
</html>
<script>
    $(function () {
        $('.hd-menu a').removeClass('cur');
        $('.hd-menu #brokerage').addClass('cur');
        $('#brokerage_index').addClass('on');

        $('.choose-btn').click(function () {
            var status = $('#status').val();
            var keyword = $('#keyword').val();
            var url = '{$cmsurl}brokerage/index?status='+status+'&keyword='+keyword;
            location.href = url;




        })



    })

</script>
