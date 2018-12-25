
    {Common::css('module.css')}
    {st:spot action="query" flag="mdd" destid="$destid" row="5" return="slist"}
    {if count($slist)>0}
    <div class="module-contianer module-contianer-bg mb15">
        <div class="module-content">
            <h3 class="module-tit">相关门票</h3>
        </div>
        <div class="module-about-content">
            <ul class="common-list">

                {loop $slist $l}
                <li {if $n>=count($slist)}class="last-li"{/if}>
                    <a class="clearfix" href="{$l['url']}" target="_blank">
                        <div class="pic">
                            <div class="img"><img src="{Common::img($l['litpic'],90,64)}" alt="{$l['title']}" title="{$l['title']}" /></div>
                        </div>
                        <div class="nr">
                            <p class="bt">{$l['title']}</p>
                            <p class="des">满意度：{$l['satisfyscore']}</p>
                            <p class="price">
                                {if !empty($l['price'])}
                                {Currency_Tool::symbol()}{$l['price']}起
                                {else}
                                电询
                                {/if}
                            </p>
                        </div>
                    </a>
                </li>
                {/loop}

            </ul>
        </div>
    </div>
    {/if}
    {/st}

