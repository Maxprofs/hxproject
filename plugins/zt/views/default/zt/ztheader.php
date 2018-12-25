<div class="web-top">
    <div class="wm-1200">
        <div class="notice-txt">{$GLOBALS['cfg_gonggao']}</div>
        <div class="top-login">
            <a href="{$cmsurl}member/club">会员俱乐部</a>
            <a class="dd" href="{$cmsurl}search/order"><i></i>订单查询</a>
            <dl class="dh">
                <dt><i></i>网站导航</dt>
                <dd>
                    {st:channel action="pc" row="20"}
                    {loop $data $row}
                    <a href="{$row['url']}">{$row['title']}</a>
                    {/loop}
                    {/st}
                </dd>
            </dl>
        </div>
        <div class="scroll-order">
            <ul>
                {st:comment action="query" flag="all" row="3"}
                {loop $data $row}
                <li>{$row['nickname']}{$row['pltime']}{__('评论了')}{$row['productname']}</li>
                {/loop}
                {/st}
            </ul>
        </div>
    </div>
</div>
<!--顶部-->

<div class="header">
    <div class="wm-1200">
        <div class="st-logo">
            {if !empty($GLOBALS['cfg_logo'])}
            <a href="{$GLOBALS['cfg_logourl']}"><img src="{Common::img($GLOBALS['cfg_logo'],298,85)}" alt="{$GLOBALS['cfg_logotitle']}" /></a>
            {/if}
        </div>
        <div class="st-nav-zt">
            <ul class="nav-list">
                <li><a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}<s></s></a></li>
                {st:channel action="pc" row="11"}
                    {loop $data $row}
                        <li> <a href="{$row['url']}" >{$row['title']}</a></li>
                    {/loop}

                {/st}

            </ul>
        </div>
    </div>
</div>
<!-- logo、主导航 -->