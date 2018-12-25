{if $channel['outdoor']['isopen']==1}
<div class="st-slideTab">
    <div class="st-tabnav">
        <h3 class="hw-bt">{$channel['outdoor']['channelname']}</h3>
        {st:dest action="query" flag="channel_nav" row="4" typeid="114" return="linedest"}
        {loop $linedest $ld}
        <span data-id="{$ld['id']}">{$ld['kindname']}</span>
        {/loop}
        <a href="{$cmsurl}outdoor/" class="more">更多</a>
    </div>
    {loop $linedest $ld}
    <div class="st-tabcon">
        <div class="hw-item-block">
            <ul class="clearfix">
                {st:outdoor action="query" flag="mdd" destid="$ld['id']" row="4" return="list"}
                {loop $list $key $row}
                <li {if ($key+1)%4==0}class="last"{/if} >
                    <a class="pic" href="{$row['url']}" target="_blank"><img src="{Product::get_lazy_img()}" st-src="{Common::img($row['litpic'],285,200)}" alt="{$l['title']}" /></a>
                    <a class="bt" href="{$row['url']}" target="_blank">
                        {$row['title']}
                        {loop $row['iconlist'] $ico}
                        <img src="{Product::get_lazy_img()}" st-src="{$ico['litpic']}" />
                        {/loop}
                    </a>
                    <p class="info">
                        <span class="jr">{if $row['periods'][0]}{date('m月d日',$row['periods'][0]['day'])}出发{/if}&nbsp;&nbsp;&nbsp;&nbsp;{$row['lineday']}天</span>
                        <span class="jg">{if $row['price']}{Currency_Tool::symbol()}<em>{$row['price']}</em>起{else}电询{/if}</span>
                    </p>
                </li>
                {/loop}
            </ul>
        </div>
    </div>
    {/loop}
</div>
{/if}