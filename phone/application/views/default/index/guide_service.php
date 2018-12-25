{if $channel['guide']['isopen']==1}
<div class="st-product-block">
    <h3 class="st-title-bar">
        <i class="line-icon"></i>
        <span class="title-txt">{$channel['guide']['channelname']}</span>
    </h3>
    <ul class="st-guide-block  clearfix">
        {st:guide action="service" row="4" return="services"}
        {loop $services $v}
        <li>
            <a href="{$v['url']}" class="item">
                <div class="pic">
                    <img src="{$defaultimg}" st-src="{Common::img($v['litpic'],690,470)}" alt="{$v['title']}">
                    <span class="dest">{$v['service_city']}</span>
                </div>
                <div class="info">
                    <div class="bt">{$v['title']}</div>
                    <div class="dy">
                        <img src="{Common::img($v['head_pic'])}" alt="">
                        <span class="name">服务导游：{$v['truename']}</span>
                    </div>
                    {if $v['price']}
                    <span class="price">{Currency_Tool::symbol()}<strong>{$v['price']}</strong>/天</span>
                    {else}
                    <span class="price"><strong>电询</strong></span>
                    {/if}
                </div>
            </a>
        </li>
        {/loop}
    </ul>
    <div class="st-more-bar">
        <a class="more-link" href="{$cmsurl}guide/all/">查看更多</a>
    </div>
</div>
{/if}
<!--热门线路-->