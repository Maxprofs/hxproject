{Common::css('module.css')}
{Common::js('SuperSlide.min.js')}
{st:destination action="query" typeid="12" flag="hot" row="6" return="hot_dest_list"}

{if !empty($hot_dest_list)}
<div class="module-contianer mb15">
    <div class="module-content module-dest-content">
        <h3 class="module-tit">热门目的地</h3>
        <div class="module-arrow clearfix">
            <a class="next" href="javascript:void(0)"></a>
            <a class="prev" href="javascript:void(0)"></a>
        </div>
        <div class="module-dest">
            <div class="bd">
                <ul>
                    {loop $hot_dest_list $dest}
                    <li>
                        <a href="{$GLOBALS['cfg_basehost']}/{$dest['pinyin']}/">
                            <div class="pic">
                                <div class="img"><img src="{Common::img($dest['litpic'],58,58)}" alt="{$dest['kindname']}" title="{$dest['kindname']}" /></div>
                            </div>
                            <p class="bt">{$dest['kindname']}</p>
                        </a>
                    </li>
                   {/loop}
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        //热门目的地
        $(".module-dest-content").slide({
            mainCell:".bd ul",
            autoPage:true,
            effect:"left",
            autoPlay:true,
            vis:3
        });
    })
</script>
{/if}