{Common::css('module.css')}
{st:article action="query" flag="order" row="5" return="hot_article_list"}
{if !empty($hot_article_list)}
<div class="module-contianer mb15" id="right_hot_article_list">
    <div class="module-content">
        <h3 class="module-tit">热门攻略</h3>
        <div class="module-hot">
            <ul class="common-list">
                {loop $hot_article_list $article}
                <li class="{if count($hot_article_list)==$n}last-li{/if}">
                    <div class="num-label {if $n<4}top{/if}">{$n}</div>
                    <a class="clearfix" href="{$article['url']}">
                        <div class="pic">
                            <div class="img"><img src="{Common::img($article['litpic'],90,64)}" alt="{$article['title']}" title="{$article['title']}"></div>
                        </div>
                        <div class="nr">
                            <p class="tit">{$article['title']}</p>
                            <p class="mb clearfix">
                                <span class="read">{$article['shownum']}</span>
                                <span class="date">{date('Y-m-d',$article['addtime'])}</span>
                            </p>
                        </div>
                    </a>
                </li>
                {/loop}
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#right_hot_article_list .module-hot').each(function() {
            $(this).find('li').eq(0).addClass('hover')
        });
        $('#right_hot_article_list .module-hot li').mouseover(function(){
            $(this).addClass('hover').siblings().removeClass('hover')
        })
    })
</script>
{/if}