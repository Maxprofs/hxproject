{Common::get_user_css('ll_tk11257_pc_no296_index/css/footer.css')}
{Common::load_skin()}
    <div class="big st-brand">
        <div class="wm-1200">
            <ul class="brand-list">
                <li class="item"><i class="icon1"></i>价格公正，安心购买</li>
                <li class="item"><i class="icon2"></i>品质保证，放心出行</li>
                <li class="item"><i class="icon3"></i>产品丰富，一站式服务</li>
                <li class="item last"><i class="icon4"></i>专业顾问，24小时客服</li>
            </ul>
        </div>
    </div>

    {request 'pub/help'}
    <!-- 帮助 -->


    <!-- 友情链接 -->

    <div class="st-footer">
        <div class="wm-1200">
            <div class="st-foot-menu">
                {st:footnav action="pc" row="10"}
                {loop $data $row}
                <a href="{$row['url']}" target="_blank" rel="nofollow">{$row['title']}</a>
                {/loop}
                {/st}
            </div>
            <!--底部导航-->
            <div class="st-foot-edit">
                <p> {$GLOBALS['cfg_footer']}</p>
                <br />
                <!--<img src="{$tpl}/Templets_NO296/images/pic/footer.png" alt="">-->
            </div>
            <!--网站底部介绍-->
        </div>
    </div>
    <!-- 底部编辑 -->
<script src="/plugins/qq_kefu/public/js/qqkefu.js"></script>

