{Common::css('module.css')}
{st:ship action="query" flag="tagrelative" tagword="$tagword" row="5" return="tag_ship_list"}
{if !empty($tag_ship_list)}
<div class="module-contianer mb15">
    <div class="module-content">
        <h3 class="module-tit">猜你喜欢</h3>
    </div>
    <div class="module-guess">
        <ul class="common-list">
            {loop $tag_ship_list $ship}
            <li class="{if count($tag_ship_list)==$n}last-li{/if}">
                <a class="clearfix" href="{$ship['url']}">
                    <div class="pic">
                        <div class="img"><img src="{Common::img($ship['litpic'],90,64)}" alt="{$ship['title']}" title="{$ship['title']}"></div>
                    </div>
                    <div class="nr">
                        <p class="tit">{$ship['title']}</p>
                        <p class="price">{if !empty($ship['price'])}{Currency_Tool::symbol()} {$ship['price']}起{else}电询{/if}</p>
                    </div>
                </a>
            </li>
            {/loop}
        </ul>
    </div>
</div>
{/if}