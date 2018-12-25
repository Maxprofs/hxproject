{Common::css('module.css')}
{st:article action="query" flag="new" row="5" return="new_article_list"}
{if !empty($new_article_list)}
<div class="module-contianer module-contianer-bg mb15">
    <div class="module-content">
        <h3 class="module-tit">最新攻略</h3>
        <div class="module-newest">
            <ul class="common-list">
                {loop $new_article_list $article}
                <li class="{if count($new_article_list)==$n}last-li{/if}">
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
{/if}