{Common::css('module.css')}
{st:article action="query" flag="tagrelative" tagword="$tagword" row="5" return="tag_article_list"}
{if !empty($tag_article_list)}
<div class="module-contianer mb15">
    <div class="module-content">
        <div class="exchange"></div>
        <h3 class="module-tit">猜你喜欢</h3>
        <div class="module-guess">
            <ul class="common-list">
                {loop $tag_article_list $article}
                <li class="{if count($tag_article_list)==$n}last-li{/if}">
                    <a class="clearfix" href="{$article['url']}">
                        <div class="pic">
                            <div class="img"><img src="{Common::img($article['litpic'],64,64)}" alt="{$article['title']}" title="{$article['title']}"></div>
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
{/if}