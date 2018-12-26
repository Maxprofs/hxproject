<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>提现记录-{$webname}</title>
    {Model_Supplier::css("style.css,base.css,extend.css",'brokerage')}
    {Common::js("jquery.min.js")}

    <style>
        .show-link
        {
            color: #28b463;
            font-size: 14px;
        }
    </style>
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
<!--                                    <strong class="item-bt"></strong>-->
                                    <div class="item-bt">
                                        <select name="" class="attr-select" id="status" style="padding-left: 5px">
                                            <option value="0">提现状态</option>
                                            <option value="1" {if $status==1}selected{/if}>待审核</option>
                                            <option value="2" {if $status==2}selected{/if}>未通过</option>
                                            <option value="3" {if $status==3}selected{/if}>已提现</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <div class="item-nr">
                                        <a href="javascript:;"  class="choose-btn">搜索</a>
                                    </div>
                                </li>
                                <li class="clearfix" style="float: right">
                                    <div class="item-nr fr">
                                        <a href="{$cmsurl}brokerage/approval_apply"  class="choose-btn">申请提现</a>
                                    </div>

                                </li>
                            </ul>
                        </div>
                        <div class="cw-table clearfix">

                            <table width="100%" border="0">
                                <tbody>
                                <tr id="record_list_header">
                                    <th width="10%">申请时间</th>
                                    <th width="20%">提现金额</th>
                                    <th width="10%">提现到</th>
                                    <th width="10%">提现状态</th>
                                    <th width="15%">操作</th>
                                </tr>
                                {loop $list $l}
                                <tr>

                                    <td>{$l['addtime']}</td>
                                    <td><span style="color: red">{$l['withdrawamount']}</span></td>
                                    <td>{$l['proceeds_type_title']}</td>
                                    <td>{if $l['status']==0} <span style="color: red">待审核</span>{elseif $l['status']==1}已提现{else}未通过{/if}</td>
                                    <td><a href="{$cmsurl}brokerage/approval_show/id/{$l['id']}" data-id="{$l['id']}" class="show-link">详情</a></td>
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
            <div class="st-record">{Common::get_sys_para('cfg_distributor_footer')}</div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function () {
        $('.hd-menu a').removeClass('cur');
        $('.hd-menu #brokerage').addClass('cur');
        $('#brokerage_approval').addClass('on');

        $('.choose-btn').click(function () {
            var status = $('#status').val();
            var url = '{$cmsurl}brokerage/approval?status='+status;
            location.href = url;
        });



    })

</script>
