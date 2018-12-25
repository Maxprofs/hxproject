
    {Common::css('module.css')}
    {st:spot action="query" flag="order" row="5" return="slist"}
    {if count($slist)>0}
    <div class="module-contianer mb15">
        <div class="module-content">
            <h3 class="module-tit">热门景点</h3>
            <div class="module-hot-zx module-hot-spot">
                <ul>

                    {loop $slist $l}
                    <li {if $n>=count($slist)}class="last-li"{/if}>
                        <div class="num-label {if $n<=3}top{/if}">{$n}</div>
                        <a class="tit" href="{$l['url']}" target="_blank">{$l['title']}</a>
                        <p class="des">满意度：{$l['satisfyscore']}</p>

                    </li>
                    {/loop}


                </ul>
            </div>
        </div>
    </div>
    {/if}
    {/st}



