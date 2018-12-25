
    {Common::css('module.css')}
    <!--hot line start-->
    {st:hotel action="query" flag="order" row="5" return="hlist"}
    {if count($hlist)>0}
    <div class="module-contianer mb15" id="right_hot_hotel_list">
        <div class="module-content">
            <h3 class="module-tit">热卖酒店</h3>
            <div class="module-hot">
                <ul class="common-list">

                    {loop $hlist $l}
                    <li {if $n>=count($hlist)}class="last-li"{/if}>
                        <div class="num-label {if $n<=3}top{/if}">{$n}</div>
                        <a class="clearfix" href="{$l['url']}" target="_blank">
                            <div class="pic">
                                <div class="img"><img src="{Common::img($l['litpic'],90,64)}" alt="{$l['title']}" title="{$l['title']}" /></div>
                            </div>
                            <div class="nr">
                                <p class="bt">{$l['title']}</p>
                                <p class="des">{Common::cutstr_html($l['sellpoint'],30)}</p>
                                <p class="data clearfix">
                                    <span class="num">销量：{$l['sellnum']}</span>
                                    <span class="price">
                                        {if !empty($l['price'])}
                                        {Currency_Tool::symbol()}{$l['price']}起
                                        {else}
                                        电询
                                        {/if}
                                    </span>
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
            $('#right_hot_hotel_list .module-hot').each(function() {
                $(this).find('li').eq(0).addClass('hover')
            });
            $('#right_hot_hotel_list .module-hot li').mouseover(function(){
                $(this).addClass('hover').siblings().removeClass('hover')
            })

        })
    </script>
    {/if}
    {/st}
    <!--热卖酒店-->


