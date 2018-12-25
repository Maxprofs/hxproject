{Common::css('module.css')}
{st:notes action="query" flag="new" row="3" return="new_notes_list"}
{if !empty($new_notes_list)}
<div class="module-contianer module-contianer-bg mb15">
    <div class="module-content">
        <h3 class="module-tit">最新游记</h3>
        <div class="module-youji">
            <ul class="youji-list">
                {loop $new_notes_list $note}
                <li>
                    <a href="{$note['url']}">
                        <div class="pic"><img src="{Common::img($note['litpic'],246,145)}" alt="{$note['title']}" title="{$note['title']}"></div>
                        <div class="bt">{$note['title']}</div>
                        <div class="data clearfix">
                            <span class="user">{$note['nickname']}</span>
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