{Common::css('module.css')}
{st:ship action="query" flag="mdd" destid="$destid" row="5" return="dest_ship_list"}
{if !empty($dest_ship_list)}
<div class="module-contianer module-contianer-bg mb15">
    <div class="module-content">
        <h3 class="module-tit">相关航线</h3>
    </div>
    <div class="module-about-content">
        <ul class="common-list">
            {loop $dest_ship_list $ship}
            <li class="{if count($dest_ship_list)==$n}last-li{/if}">
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