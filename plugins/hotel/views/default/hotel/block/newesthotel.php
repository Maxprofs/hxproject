
    {Common::css('module.css')}
    {st:hotel action="query" flag="new" row="5" return="hlist"}
    {if count($hlist)>0}
    <div class="module-contianer module-contianer-bg mb15">
        <div class="module-content">
            <h3 class="module-tit">最新酒店</h3>
            <div class="module-newest">
                <ul class="common-list">

                    {loop $hlist $l}
                    <li {if $n>=count($hlist)}class="last-li"{/if}>
                        <a class="clearfix" href="{$l['url']}" target="_blank">
                            <div class="pic">
                                <div class="img"><img src="{Common::img($l['litpic'],90,64)}" alt="{$l['title']}" title="{$l['title']}" /></div>
                            </div>
                            <div class="nr">
                                <p class="bt">{$l['title']}</p>
                                <p class="des">{Common::cutstr_html($l['sellpoint'],30)}</p>
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
    </div>
    {/if}
    {/st}
    <!--最新酒店-->



