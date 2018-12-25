{Common::css('footer2.css')}
<div class="footer-container">
    <ul class="footer-menu">
        <li>
            <a class="item" href="tel:{$GLOBALS['cfg_m_phone']}">
                <i class="icon m-contact"></i>
                <span class="name">客服电话</span>
            </a>
        </li>
        <li>
            <a class="item" href="/help/">
                <i class="icon m-help"></i>
                <span class="name">帮助中心</span>
            </a>
        </li>
        <li>
            <a class="item" href="/member#&myOrder">
                <i class="icon m-order"></i>
                <span class="name">我的订单</span>
            </a>
        </li>
        <li>
            <a class="item" href="/servers/index_1.html">
                <i class="icon m-about"></i>
                <span class="name">关于我们</span>
            </a>
        </li>
    </ul>
    <div class="footer-log-reg">
        <a class="item" href="{$cmsurl}member/login">登录</a>
        <a class="item" href="{$cmsurl}member/register">注册</a>
    </div>
    <div class="footer-edit clearfix">
        <p>{$GLOBALS['cfg_footer']}</p>
    </div>
</div>
<!-- 公用底部 -->
<script>
    {if !$is_index}
    document.addEventListener('plusready', function() {
        var webview = plus.webview.currentWebview();
        plus.key.addEventListener('backbutton', function() {
            webview.canBack(function(e) {
                if(e.canBack) {
                    webview.back();
                } else {
                    webview.close(); //hide,quit
                    //plus.runtime.quit();
                }
            })
        });
    });
    {/if}
</script>