

    <div class="st-help clear">
        <div class="wm-1200">
            <div class="help-lsit clearfix">
                <div class="contact-us">
                    <i class="icon"></i>
                    <div class="txt">24小时服务热线<br />{$GLOBALS['cfg_phone']}</div>
                </div>
                {st:help action="kind" row="5"}
                {loop $data $row}
                <dl>
                    <dt><a href="{$row['url']}">{$row['title']}</a></dt>
                    <dd>
                        {st:help action="article" row="3" kindid="$row['id']" typeid="$typeid" return="list"}
                        {loop $list $r}
                        <a href="{$r['url']}" target="_blank" rel="nofollow">{$r['title']}</a>
                        {/loop}
                        {/st}
                    </dd>
                </dl>
                {/loop}
                {/st}
                <div class="st-wechat">
                    {if $GLOBALS['cfg_weixin_logo']}
                    <img src="{Common::img($GLOBALS['cfg_weixin_logo'],94,94)}" width="100" height="100">
                    <span>微信扫一扫，更优惠！</span>
                    {/if}
                </div>
            </div>
        </div>
    </div>
    <!-- 帮助 -->

