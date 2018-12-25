{Common::css('module.css')}
{st:notes action="query" flag="new" row="3" return="hot_notes_list"}
{if !empty($hot_notes_list)}
<div class="module-contianer mb15">
    <div class="module-content module-hot-content">
        <h3 class="module-tit">热门游记</h3>
        <div class="module-youji">
            <ul class="youji-list">
                {loop $hot_notes_list $note}
                <li>
                    <a href="{$note['url']}">
                        <div class="pic"><img src="{Common::img($note['litpic'],246,145)}" alt="{$note['title']}" title="{$note['title']}"></div>
                        <div class="bt">{$note['title']}</div>
                        <div class="data clearfix">
                            <span class="user">{$note['nickname']}</span>
                            <span class="read">{$note['shownum']}</span>
                            <span class="date">{date('Y-m-d',$note['modtime'])}</span>
                        </div>
                    </a>
                </li>
                {/loop}
            </ul>
        </div>
    </div>
</div>
{/if}