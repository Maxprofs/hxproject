<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>财务总览-{$webname}</title>

    <link type="text/css" rel="stylesheet" href="/plugins/distributor_finance/public/default/pc/css/base.css">
    <link type="text/css" rel="stylesheet" href="/plugins/distributor_finance/public/default/pc/css/style.css">

    {Common::css("style.css,base.css")}
    {Common::js("jquery.min.js")}
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
                    <div class="finance-tit"><strong class="bt">财务总览</strong></div>
                    <div class="finance-bloock">
                        <div class="cw-item clearfix">
                            <ul>
                                <li class="clearfix">
                                    <strong class="item-bt">账户余额：</strong>
                                    <div class="item-nr">
                                        <span class="surplus">¥{$info['account_balance']}</span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">可提现金额：</strong>
                                    <div class="item-nr">
                                        <span class="num">¥{$info['withdraw_total']}</span>
                                        <a href="/plugins/distributor_finance/pc/drawcash/drawcash_apply"  class="btn-link">申请提现</a>
                                        <a href="/plugins/distributor_finance/pc/drawcash/list"  class="txt-link">提现记录</a>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">提现中金额：</strong>
                                    <div class="item-nr">
                                        <span class="num color-red">¥{$info['withdrawing']}</span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">已提现金额：</strong>
                                    <div class="item-nr">
                                        <span class="num">¥{$info['withdraw']}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="cw-item clearfix">
                            <ul>
                                <li class="clearfix">
                                    <strong class="item-bt">累计已结算：</strong>
                                    <div class="item-nr">
                                        <span class="num">¥{$info['settled_amount']}</span>
                                        <a href="/plugins/distributor_finance/pc/financeextend/ordercount"  class="btn-link">结算统计</a>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">未结算：</strong>
                                    <div class="item-nr">
                                        <span class="num">¥{$info['un_settle_amount']}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="cw-table clearfix">
                            <h3 class="new-bt">最新交易</h3>
                            <table width="100%" border="0">
                                <tbody>
                                <tr>
                                    <th width="15%">时间</th>
                                    <th width="40%">交易名称</th>
                                    <th width="15%">交易类型</th>
                                    <th width="15%">交易金额</th>
                                    <th width="15%">交易状态</th>
                                </tr>


                                {loop $list $l}
                                <tr>
                                    <td>{Common::mydate("Y-m-d H:i:s",$l['addtime'])}</td>
                                    <td><div class="name" title="{$l['productname']}">{$l['productname']}</div></td>
                                    <td>{$l['type_name']}</td>
                                    <td>{$l['operator']}{$l['price']}</td>
                                    <td>{$l['status_name']}</td>
                                </tr>

                                {/loop}


                                </tbody>
                            </table>
                            <a href="/plugins/distributor_finance/pc/financeextend/orderrecord"  class="all-list-link">查看所有交易记录</a>
                        </div>
                    </div>
                </div><!-- 财务总览 -->
            </div>
            <div class="st-record">{Common::get_sys_para('cfg_distributor_footer')}</div>
        </div>
    </div>
    <!-- 主体内容 -->

</div>

<script>
    $(function () {
        $("#nav_overview").addClass('on');

    });
</script>
</body>
</html>
