<div class="header_top bar-nav">
    <a class="back-link-icon"  href="#pageHome" data-rel="back"></a>
    <h1 class="page-title-bar">我的钱包</h1>
</div>
<!-- 公用顶部 -->
<div class="wallet-box">
    <div class="money">
        <p>现金余额
            {if $config['cash_min']=='1'||$config['cash_max']=='1'}
            <span class="bz">（{if $config['cash_min']=='1'}金额超过{Currency_Tool::symbol()}{$config['cash_min_num']}可提现{/if}
                {if $config['cash_max']=='1'}
                    {if $config['cash_min']=='1'},{/if}{if $cash_available_num>=0}本月还可提现{$cash_available_num}次{/if}
                {/if}）</span>
            {/if}
        </p>
        <p class="num">{Currency_Tool::symbol()}{php echo number_format($member['money']-$member['money_frozen'],2)}</p>
    </div>
    <div class="detail">
        <a href="{$cmsurl}member/bag/record">
            <i class="mx-ico"></i>
            <span class="txt">收支明细</span>
            <i class="more-ico"></i>
        </a>
    </div>
    <div class="btn">
        {if (($member['money']-$member['money_frozen']<$config['cash_min_num'])&&$config['cash_min']==1)||$cash_available_num==0}
        <a class="disabled" href="javascript:;">
            <i class="tx-ico"></i>
            <span>提现</span>
        </a>
        {else}
        <a href="{$cmsurl}member/bag/way">
            <i class="tx-ico"></i>
            <span>提现</span>
        </a>
        {/if}
    </div>
</div>
