
    {Common::css('module.css')}
    <!-- new comment start -->
    {Common::js("SuperSlide.min.js")}
    {st:comment action="query" flag="all" row="6" return="clist"}
    {if count($clist)>0}
    <div class="module-contianer module-contianer-bg mb15">
        <div class="module-content">
            <h3 class="module-tit">最新点评</h3>
            <div class="module-dp">
                <div class="bd">
                    <ul>

                        {loop $clist $c}
                        <li>
                            <p class="name">用户{$c['nickname']} 发表了点评</p>
                            <a class="tit" href="javascript:void(0)">{$c['productname']}</a>
                            <p class="txt">{Common::cutstr_html(strip_tags($c['content']),70)}</p>
                        </li>
                        {/loop}


                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){

            //点评
            $('.module-dp').slide({
                mainCell:".bd ul",
                autoPage:true,
                effect:"topLoop",
                autoPlay:true,
                vis:3,
                interTime:5000,
                delayTime:1000
            });

        })

    </script>
    {/if}
    {/st}
    <!--最新点评-->
