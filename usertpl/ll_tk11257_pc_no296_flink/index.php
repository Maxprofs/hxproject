
    <!-- 帮助 -->
    {st:flink action="query"}
    {if !empty($data) && $isindex==1}
    <div class="st-link">
        <div class="wm-1200">
            <div class="st-link-list clearfix">
                <strong>友情链接：</strong>
                <div class="child">
                    {loop $data $row}
                    <a href="{$row['url']}" {if $row['is_follow']==0}rel="nofollow"{/if} target="_blank">{$row['title']}</a>
                    {/loop}
                </div>
            </div>
        </div>
    </div>
    <!-- 友情链接 -->
    {/if}
