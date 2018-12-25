{Common::css('module.css')}
{st:article action="query" flag="mdd_order" destid="$destid" row="5" return="dest_article_list"}
{if !empty($dest_article_list)}

<div class="module-contianer module-contianer-bg mb15">
    <div class="module-content">
        <h3 class="module-tit">相关攻略</h3>
    </div>
    <div class="module-about-content">
        <ul class="common-list">
          {loop $dest_article_list $article}
            <li class="{if count($dest_article_list)==$n}last-li{/if}">
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
{/if}