{Common::css('module.css')}
{st:ship action="query" flag="order" row="5" return="hot_ship_list"}
{if !empty($hot_ship_list)}
<div class="module-contianer mb15" id="right_hot_ship_list">
    <div class="module-content">
        <h3 class="module-tit">热门航线</h3>
        <div class="module-hot">
            <ul class="common-list">
                {loop $hot_ship_list $ship}
                <li class="{if count($hot_ship_list)==$n}last-li{/if}">
                    <div class="num-label {if $n<4}top{/if}">{$n}</div>
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
</div>
<script type="text/javascript">
    $(function(){
        $('#right_hot_ship_list .module-hot').each(function() {
            $(this).find('li').eq(0).addClass('hover')
        });
        $('#right_hot_ship_list .module-hot li').mouseover(function(){
            $(this).addClass('hover').siblings().removeClass('hover')
        })
    })
</script>
{/if}