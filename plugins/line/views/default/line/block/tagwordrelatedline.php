
    {Common::css('module.css')}
    {st:line action="query" flag="tagrelative" tagword="$tagword" row="5" return="llist"}
    {if count($llist)>0}
    <div class="module-contianer mb15">
        <div class="module-content">
            <h3 class="module-tit">猜你喜欢</h3>

            <div class="module-guess">
                <ul class="common-list">

                    {loop $llist $l}
                    <li {if $n>=count($llist)}class="last-li"{/if}>
                        <a class="clearfix" href="{$l['url']}" target="_blank">
                            <div class="pic">
                                <div class="img"><img src="{Common::img($l['litpic'],64,64)}" alt="{$l['title']}" title="{$l['title']}" /></div>
                            </div>
                            <div class="nr">
                                <p class="tit">{$l['title']}</p>
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
    <!--相关线路-->

