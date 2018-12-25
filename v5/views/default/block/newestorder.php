
    {Common::css('module.css')}
    {Common::js("SuperSlide.min.js")}
    <!-- new order start -->
    {st:order action="query" flag="all" row="6" return="olist"}
    {if count($olist)>0}
    <div class="module-contianer module-contianer-bg mb15">
        <div class="module-content">
            <h3 class="module-tit">最新订单</h3>
            <div class="module-order">
                <div class="bd">
                    <ul>

                        {loop $olist $o}
                        <li>
                            <a class="tit" href="{$o['producturl']}" target="_blank">{$o['productname']}</a>
                            <p class="bkTime">
                                <i></i>
                                用户{$o['nickname']} {$o['dingtime']}预订
                            </p>
                        </li>
                        {/loop}


                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){

            //订单
            $('.module-order').slide({
                mainCell:".bd ul",
                autoPage:true,
                effect:"topLoop",
                autoPlay:true,
                vis:5,
                interTime:5000,
                delayTime:1000
            });

        })

    </script>
    {/if}
    {/st}
    <!-- new order end -->