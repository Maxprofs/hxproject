
{Common::css('module.css')}
{st:photo action="query" flag="tagrelative" row="5" tagword="$tagword" return="hlist"}
{if count($hlist)>0}
<div class="module-contianer mb15">
    <div class="module-content">
        <h3 class="module-tit">猜你喜欢</h3>
        <div class="module-guess-photo">
            <a class="prev" href="javascript:void(0)"></a>
            <a class="next" href="javascript:void(0)"></a>
            <div class="bd">

                <ul class="clearfix">

                    {loop $hlist $l}
                    <li {if $n>=count($hlist)}class="last-li"{/if}>
                    <a class="clearfix" href="{$l['url']}" target="_blank">
                        <div class="pic">
                            <img src="{Common::img($l['litpic'],246,143)}" alt="{$l['title']}" title="{$l['title']}" />
                        </div>
                        <p class="txt">{$l['title']}</p>

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

        //猜你喜欢（相册）
        $(".module-guess-photo").slide({
            mainCell:".bd ul",
            autoPage:true,
            autoPlay:true,
        });

    })
</script>

{/if}
{/st}




