<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }

    <link type="text/css" href="{$GLOBALS['cfg_plugin_finance_public_url']}css/base.css" rel="stylesheet" />
    <link type="text/css" href="{$GLOBALS['cfg_plugin_finance_public_url']}css/style.css" rel="stylesheet" />

</head>
<body>
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td">
        	<div class="cfg-header-bar">
        		<a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
        	</div>

            <div class="content-nrt" style="margin-top: 5px">

                <div class="finance-content">
                    <div id="finance-loading" class="text-c">
                        <span>汇总数据,加载中。。。</span>
                        <img src="{$GLOBALS['cfg_plugin_finance_public_url']}images/loading.gif">
                    </div>
                    <div class="finance-datas" style="display: none">
                        <ul class="info-item-block">
                            <li>
                            	<span class="item-hd">账户余额：</span>
                            	<div class="item-bd lh-30">
                            		<span class="available_amount c-red f14">{Currency_Tool::symbol()}{$info['available_amount']}</span>
                            	</div>
                            </li>
                            <li>
                                <span class="item-hd">收入总额：</span>
                                <div class="item-bd lh-30 total_amount">
                                    {Currency_Tool::symbol()}{$info['total_amount']}
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">已提现金额：</span>
                                <div class="item-bd lh-30">
                                    <span class="c-red withdraw">{Currency_Tool::symbol()}{$info['withdraw']}</span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">提现中金额：</span>
                                <div class="item-bd lh-30 withdrawing">
                                    {Currency_Tool::symbol()}{$info['withdrawing']}
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">可提现金额：</span>
                                <div class="item-bd lh-30 withdraw_total">
                                    {Currency_Tool::symbol()}{$info['withdraw_total']}
                                </div>
                            </li>
                            <div class="line"></div>
                            <li>
                                <span class="item-hd">累计已结算：</span>
                                <div class="item-bd lh-30 settled_amount">
                                    {Currency_Tool::symbol()}{$info['settled_amount']}
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">未结算：</span>
                                <div class="item-bd lh-30 un_settle_amount">
                                    {Currency_Tool::symbol()}{$info['un_settle_amount']}
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- 账户金额 -->
                    <div class="finance-block">
                        <h3 class="finance-tit"><strong class="btn-link">最新交易</strong></h3>
                        <table width="100%" border="0" class="finance-table-list">
                            <tbody>
                            <tr>
                                <th class="text-c" width="15%">时间</th>
                                <th class="text-c" width="50%">名称</th>
                                <th class="text-c" width="10%">交易类型</th>
                                <th class="text-c" width="10%">金额</th>
                                <th class="text-c" width="15%">交易状态</th>
                            </tr>

                            {loop $list $l}
                            <tr>
                                <td width="15%">{Common::mydate("Y-m-d H:i:s",$l['addtime'])}</td>
                                <td width="50%"><div class="name" title="{$l['productname']}">{St_Functions::cutstr_html($l['productname'],70)}</div></td>
                                <td width="10%">{$l['type_name']}</td>
                                <td width="10%">{$l['operator']}{$l['price']}</td>
                                <td width="15%">{$l['status_name']}</td>
                            </tr>

                            {/loop}

                            </tbody>
                        </table>
                    </div>
                    <!-- 最新交易 -->
                    <a href="javascript:void(0)" class="btn btn-primary radius size-S btn-block ml-30 mt-20 mb-20">查看所有交易</a>
                </div>

            </div>

        </td>
    </tr>
</table>
<script type="text/javascript" src="{$GLOBALS['cfg_plugin_finance_public_url']}js/common.js"></script>

<script>

    window.pageno       = 1;
    window.overview_info= {
        withdraw    :'{$withdraw}', //已提现金额
        withdrawing :'{$withdrawing}',  //提现中金额
        withdraw_total:0,   //可提现金额

        available_amount:0,     //账户余额
        total_amount    : 0,    //收入总额
        settled_amount  : 0,    //结算金额
        un_settle_amount: 0     //未结算金额
    };

    $(function(){
        $(".btn-block").click(function(){
            var $as = $(".menu-left .leftnav a").each(function(){
                var $this = $(this);
                var txt = $this.text();
                if(txt.indexOf('交易记录')!=-1)
                {
                    $this.click();
                }
            });

        });

        // 加载统计数据
        get_overview_summery(window.pageno);
    });


    function get_overview_summery(pageno)
    {
        var url = SITEURL + 'finance/admin/financeextend/ajax_overview_summary'
        // 加载动画
        $.post(url, {pageno: pageno}, function(data){
            // 汇总数据
            window.overview_info.total_amount   = STTOOL.Math.add(window.overview_info.total_amount, data.total_amount);
            window.overview_info.settled_amount = STTOOL.Math.add(window.overview_info.settled_amount, data.settled_amount);
            window.overview_info.un_settle_amount = STTOOL.Math.add(window.overview_info.un_settle_amount, data.un_settle_amount);
            if(data.is_finish)
            {
                var wd = STTOOL.Math.add(window.overview_info.withdraw, window.overview_info.withdrawing)
                window.overview_info.withdraw_total    = STTOOL.Math.sub(window.overview_info.settled_amount, wd);
                window.overview_info.available_amount  = STTOOL.Math.sub(window.overview_info.total_amount, window.overview_info.withdraw);

                var $block = $(".finance-datas");
                // 加载完成
                for(var k in window.overview_info)
                {
                    $block.find('.' + k).text(CURRENCY_SYMBOL+window.overview_info[k]);
                }
                // 关闭加载动画
                $("#finance-loading").hide();
                $block.show();
            }
            else
            {
                window.pageno++;
                get_overview_summery(window.pageno);
            }
        },'json');
    }

</script>

</body>
</html>
