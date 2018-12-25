
    {Common::css('module.css')}

    {st:help action="hot" row="5" typeid="$typeid" return="olist"}
    {if count($olist)>0}
    <div class="module-contianer mb15">
        <div class="module-content module-hot-content">
            <h3 class="module-tit">热门帮助</h3>
            <div class="module-help">

                <ul class="help-list">

                    {loop $olist $o}
                    <li>
                        <a href="{$o['url']}" target="_blank">
                            <div class="bt"><i></i>{$o['title']}</div>
                            <div class="txt">{Common::cutstr_html($o['body'],180)}</div>

                        </a>

                    </li>
                    {/loop}


                </ul>

            </div>
        </div>
    </div>

    {/if}
    {/st}