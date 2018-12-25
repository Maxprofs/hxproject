
  <?php if($conf['pos']=='right') { ?>
  <?php echo Common::css('/plugins/qq_kefu/public/kf5/css/right.css',true,false);?>
  <?php } else { ?>
  <?php echo Common::css('/plugins/qq_kefu/public/kf5/css/left.css',true,false);?>
  <?php } ?>
  <?php echo Common::js('/public/js/freekefu.js',false,false);?>
  <link type="text/css" href="/res/js/layer/skin/layer.css" rel="stylesheet">
  <script src="/res/js/layer/layer.js"></script>
  <div></div>
    <script>
        var posh="<?php echo $conf['posh'];?>";
        posh=parseInt(posh);
        $(function(){
            //呼出免费通话
            $(".st-side-call").mouseover(function(){
                $(this).children(".call-set").show()
            });
            //关闭免费通话
            $(".call-close").click(function(){
                $(this).parent(".call-set").hide();
            });
            //返回顶部
            $(".st-side-back-top").click(function(){
                $('html,body').animate({
                    scrollTop: '0px'}, 500);
            });
            $("#freekefu_btn").click(function(){
                Freekefu.send_freekefu(function(result){
                    layer.msg(result.msg,{time:3000})
                });
            });
        })
    </script>
  <?php if($conf['pos']=='right') { ?>
    <script>
        $(function() {
            $(".st-side-close").click(function () {
                $(this).parents(".st-side-menu-block").animate({
                    right: "-40px"
                }, 100, function () {
                    $(".st-side-flexible-block").animate({
                        right: 0
                    }, 200)
                });
                $(".call-set").hide();
            })
            $(".st-side-flexible-block").click(function () {
                $(this).animate({
                    right: "-70px"
                }, 100, function () {
                    $(this).parents(".st-side-menu-block").animate({
                        right: 0
                    }, 200)
                })
            })
        });
    </script>
  <?php } else { ?>
   <script>
       $(function() {
           $(".st-side-close").click(function () {
               $(this).parents(".st-side-menu-block").animate({
                   left: "-40px"
               }, 100, function () {
                   $(".st-side-flexible-block").animate({
                       left: 0
                   }, 200)
               });
               $(".call-set").hide();
           })
           $(".st-side-flexible-block").click(function () {
               $(this).animate({
                   left: "-70px"
               }, 100, function () {
                   $(this).parents(".st-side-menu-block").animate({
                       left: 0
                   }, 200)
               })
           })
       });
   </script>
<?php } ?>
    <div class="st-side-menu-block" style="<?php echo $conf['pos'];?>:0px">
        <div class="st-side-menu-list">
            <div class="st-side-call">
                <div class="call-set">
                    <i class="call-close"></i>
                    <input type="text" class="call-num" id="freekefu_phone" placeholder="请输入您的电话号码">
                    <input type="submit" class="call-btn" id="freekefu_btn" value="立即免费通话">
                    <p class="call-txt">输入电话号码，点击免费通话、稍后我们将与您联系，此次通话将不收取您任何费用，请注意接听。</p>
                </div>
            </div>
            <ul class="menu-ul-child">
                <li>
                    <span class="side-qq"></span>
                    <div class="child-block">
                        <div class="side-online-qq">
                            <div class="online-tit">在线咨询</div>
                            <?php $n=1; if(is_array($group)) { foreach($group as $row) { ?>
                            <dl class="online-group">
                                <dt><?php echo $row['qqname'];?></dt>
                                <dd class="clearfix">
                                    <?php $n=1; if(is_array($row['qq'])) { foreach($row['qq'] as $subqq) { ?>
                                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $subqq['qqnum'];?>&site=qq&menu=yes"><?php echo $subqq['qqname'];?></a>
                                    <?php $n++;}unset($n); } ?>
                                </dd>
                            </dl>
                           <?php $n++;}unset($n); } ?>
                        </div>
                    </div>
                </li>
                <?php if(!empty($Glb['cfg_phone'])) { ?>
                <li>
                    <span class="side-phone"></span>
                    <div class="child-block">
                        <div class="side-link-num">客服电话：<?php echo $Glb['cfg_phone'];?></div>
                    </div>
                </li>
                <?php } ?>
                <?php if(!empty($Glb['cfg_weixin_logo'])) { ?>
                <li>
                    <span class="side-wechat"></span>
                    <div class="child-block">
                        <div class="side-wechat-Sweep">
                            <img src="<?php echo $Glb['cfg_weixin_logo'];?>" />
                            <p>关注官方微信</p>
                        </div>
                    </div>
                </li>
                <?php } ?>
                <?php if(!empty($Glb['cfg_weibo_url'])) { ?>
                <li>
                    <span class="side-blog"></span>
                    <div class="child-block">
                        <div class="side-link-num" onclick="window.open('<?php echo $Glb['cfg_weibo_url'];?>','_blank')">关注官方微博</div>
                    </div>
                </li>
                <?php } ?>
            </ul>
            <div class="st-side-back-top">TOP</div>
            <div class="st-side-close"></div>
        </div>
        <div class="st-side-flexible-block"></div>
    </div><!-- 黑色边栏客服 -->
