
    {Common::css('module.css')}
    {st:question action="query" row="6" return="qlist"}
    {if count($qlist)>0}
    <div class="module-contianer module-contianer-bg mb15">
        <div class="module-content">
            <h3 class="module-tit">在线咨询</h3>
            <a class="module-more" href="/questions/" target="_blank">更多></a>
            <div class="module-onlineZx">
                <ul>

                    {loop $qlist $q}
                    <li>
                        <span class="tit">{$q['content']}</span>
                        <p class="txt">{$q['replycontent']}</p>
                    </li>
                    {/loop}


                </ul>
            </div>
        </div>
    </div>
    {/if}
    {/st}
    <!--在线咨询-->
