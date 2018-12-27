{Common::css_plugin_distributor('header.css','distributor')}
{Common::js('login.js')}
<div class="header">

    <div class="logo"><a href="{$logourl}" title="{$logotitle}" target="_blank"><img src="{Common::img($GLOBALS['cfg_logo'])}" /></a></div>

    <div class="hd-menu">
        <a href="/distributor/pc/backpage/index" id="p_account" class="cur">首页</a>
        {if !empty($line_product)}
        <a href="/plugins/distributor_line/" id="p_line">线路</a>
        {/if}
        {if !empty($hotel_product)}
        <a href="/plugins/distributor_hotel/" id="p_hotel" >酒店</a>
        {/if}
        {if !empty($car_product)}
        <a href="/plugins/distributor_car/" id="p_car">租车</a>
        {/if}
        {if !empty($spot_product)}
        <a href="/plugins/distributor_spot/" id="p_spot">景点</a>
        {/if}
        {if !empty($tuan_product)}
        <a href="/plugins/distributor_tuan/" id="p_tuan">团购</a>
        {/if}
        {if !empty($visa_product)}
        <a href="/plugins/distributor_visa/" id="p_visa">签证</a>
        {/if}
        {if !empty($outdoor_product)}
        <a href="/plugins/distributor/outdoor/" id="p_campaign">户外活动</a>
        {/if}
        {if !empty($tongyong_product)}
           {loop $tongyong_list $t}
            <a href="/plugins/distributor_tongyong/index/index/typeid/{$t['id']}" id="p_product_{$t['id']}">{$t['modulename']}</a>
           {/loop}
        {/if}
        {if !empty($check_product)}
        <a href="/plugins/distributor_check/" id="p_check">验单</a>
        {/if}
        {if !empty($finance_manage)}
        <a href="/plugins/distributor/brokerage/" id="brokerage">财务</a>
        {/if}
        <a href="/plugins/distributor/pc/index/enterpriseinfo" id="p_enterpriseinfo">企业设置</a>
        
        <a class="return" href="{$cmsurl}">返回商城</a>
    </div>
    <div class="tx">
        <span class="wc">欢迎您，<a id="myaccountlink" href="/distributor/pc/distributor/index/userinfo" style="color: #fff">{if $userinfo['nickname']}{$userinfo['nickname']}{else}供应商{/if}</a></span>
        <a class="tc" href="javascript:ST.Login.login_out();">退出</a>

    </div>
</div><!-- 顶部 -->
<script>

    var SITEURL = "{$cmsurl}";
    $("#myaccountlink").hover(
        function () {
            $(this).css({"color": "#fff100"});
        },
        function () {
            $(this).css({"color": "#fff"});
        }
    );
</script>