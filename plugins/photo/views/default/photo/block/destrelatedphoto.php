
{Common::css('module.css')}
{st:photo action="query" flag="mdd" row="5" destid="$destid" return="hlist"}
{if count($hlist)>0}
<div class="module-contianer mb15">
    <div class="module-content">
        <h3 class="module-tit">相关相册</h3>
        <div class="module-about-photo">
            <ul>

                {loop $hlist $l}
                <li {if $n>=count($hlist)}class="last-li"{/if}>
                <a class="clearfix" href="{$l['url']}" target="_blank">
                    <div class="pic">
                        <img src="{Common::img($l['litpic'],246,143)}" alt="{$l['title']}" title="{$l['title']}" />
                    </div>
                    <div class="bt"><p>{$l['title']}</p>></div>

                </a>
                </li>
                {/loop}


            </ul>
        </div>
    </div>
</div>
{/if}
{/st}




