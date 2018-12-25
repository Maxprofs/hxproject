{Common::css('module.css')}
{st:notes action="query" flag="mdd" destid="$destid" row="5" return="dest_notes_list"}
{if !empty($dest_notes_list)}
<div class="module-contianer module-contianer-bg mb15">
    <div class="module-content">
        <h3 class="module-tit">相关游记</h3>
    </div>
    <div class="module-about-content">
        <ul class="common-list">
            {loop $dest_notes_list $note}
            <li class="{if count($dest_notes_list)==$n}last-li{/if}">
                <a class="clearfix" href="{$note['url']}">
                    <div class="pic">
                        <div class="img"><img src="{Common::img($note['litpic'],90,64)}" alt="{$note['title']}" title="{$note['title']}"></div>
                    </div>
                    <div class="nr">
                        <p class="tit">{$note['title']}</p>
                        <p class="mb clearfix">
                            <span class="user">{$note['nickname']}</span>
                            <span class="date">{date('Y-m-d',$note['modtime'])}</span>
                        </p>
                    </div>
                </a>
            </li>
            {/loop}
        </ul>
    </div>
</div>
{/if}