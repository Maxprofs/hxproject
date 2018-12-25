
    {Common::css('module.css')}
    {st:photo action="query" flag="new" row="5" return="hlist"}
    {if count($hlist)>0}
    <div class="module-contianer module-contianer-bg mb15">
        <div class="module-content">
            <h3 class="module-tit">最新相册</h3>
            <div class="module-photo">
                <ul class="youji-list">

                    {loop $hlist $l}
                    <li {if $n>=count($hlist)}class="last-li"{/if}>
                        <a class="clearfix" href="{$l['url']}" target="_blank">
                            <div class="pic">
                                <img src="{Common::img($l['litpic'],246,145)}" alt="{$l['title']}" title="{$l['title']}" />
                            </div>
                            <div class="bt">
                                {$l['title']}
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




