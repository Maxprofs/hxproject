{if $channel['outdoor']['isopen']==1}
<div class="st-product-block">
    <h3 class="st-title-bar">
        <i class="line-icon"></i>
        <span class="title-txt">{$channel['outdoor']['channelname']}</span>
    </h3>
    <ul class="st-outdoor-list">
        {st:outdoor action="query" flag="order" row="4" return="outdoor_list"}
                    {loop $outdoor_list $row}
                    <li class="in">
                        <a href="{$row['url']}" data-ajax="false">
                            <div class="pic">
                                <div class="img"><img src="{Common::img($row['litpic'],450,225)}" alt="" title="{$row['title']}" /></div>
                            </div>
                            <div class="info">{$row['title']}</div>
                            <div class="des clearfix">
                                {if !empty($row['periods'][0])}
                                <p class="num">{date('m月d日',$row['periods'][0]['day'])},{$row['lineday']}天</p>
                                {/if}
                                <p class="price">
                                    {if $row['price']}
                                    <i>{Currency_Tool::symbol()}</i><strong>{$row['price']}</strong>起
                                    {else}
                                    <strong>电询</strong>
                                    {/if}
                                </p>
                            </div>
                        </a>
                    </li>
                    {/loop}
    </ul>
    <div class="st-more-bar">
        <a class="more-link" href="/phone/outdoor/all/">查看更多</a>
    </div>
</div>
{/if}