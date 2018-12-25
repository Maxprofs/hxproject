{Common::css('module.css')}
{st:destination action="query" flag="tagrelative" tagword="$tagword" row="3" return="tag_dest_list"}
{if !empty($tag_dest_list)}
<div class="module-contianer mb15">
    <div class="module-content">
        <div class="exchange"></div>
        <h3 class="module-tit">猜你喜欢</h3>
        <div class="module-dest module-dest-guess">
            <div class="bd">
                <ul>
                    {loop $tag_dest_list $dest}
                    <li class="{if count($tag_dest_list)==$n}last-li{/if}">
                        <a href="{$GLOBALS['cfg_basehost']}/{$dest['pinyin']}/">
                            <div class="pic">
                                <div class="img"><img src="{Common::img($dest['litpic'],58,58)}" alt="{$dest['kindname']}" title="{$dest['kindname']}"></div>
                            </div>
                            <p class="bt">{$dest['kindname']}</p>
                        </a>
                    </li>
                    {/loop}
                </ul>
            </div>
        </div>
    </div>
</div>
{/if}