{Common::get_user_css('ll_tk11257_pc_no296_header/css/header.css')}
{common::js('login.js')}
{st:ad action="getad" name="ll_tk11257_no296_top" pc="1" row="1"}
{if !empty($data)}
    <div class="top-column-banner">
        <a href="{$data['adlink']}"><img src="{Common::img($data['adsrc'])}" alt="{$data['adname']}" /></a>
        <i class="top-closed"></i>
    </div>
{/if}
    <!--顶部广告-->

    <div class="header-top">
        <div class="wm-1200">
            <div class="login-info">

            </div>
            <!-- user 入口 -->
            <div class="notice-msg clearfix">
                {$GLOBALS['cfg_gonggao']}
            </div>
            <!-- 网站公告 -->
            <ul class="top-msg-group">
                <li class="nav-item">
                    <a class="dd" href="{$cmsurl}search/order"><i></i>{__('订单查询')}</a>
                </li>
                <li class="nav-item has-down">
                    网站地图
                    <i class="top-arrow-icon"></i>
                    <div class="dropdown-panel">
                        <ul class="top-map-list clearfix">
                            {st:channel action="pc" row="30"}
                            {loop $data $row}
                           <li> <a href="{$row['url']}" title="{$row['linktitle']}">{$row['title']}</a></li>
                            {/loop}
                            {/st}
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="top-new-msg unread" href="{Common::get_main_host()}/member/message/index"></a>
                </li>
                {st:ad action="getad" name="ll_tk11257_no296_phone" pc="1" row="1"}
                {if !empty($data)}
                <li class="nav-item has-down">
                    <span class="top-phone-icon"></span>
                    <div class="dropdown-panel">
                        <div class="top-qr-code">
                            <div class="txt">手机预订，更优惠</div>
                            <img src="{Common::img($data['adsrc'],94,94)}" alt="">
                        </div>
                    </div>
                </li>
                {/if}
                <li class="nav-item has-down">
                    <span class="top-wechat-icon"></span>
                    <div class="dropdown-panel">
                        <div class="top-qr-code">
                            <img src="{Common::img($GLOBALS['cfg_weixin_logo'],94,94)}" width="100" height="100">
                        </div>
                    </div>
                </li>
            </ul>
            <!-- 信息提示 -->
        </div>
    </div>
    <!-- 顶部信息栏 -->

    <div class="header-search">
        <div class="wm-1200">
            <div class="header-logo">
                {if !empty($GLOBALS['cfg_logo'])}
                <a title="{$GLOBALS['cfg_logotitle']}" href="{$GLOBALS['cfg_logourl']}"><img src="{Common::img($GLOBALS['cfg_logo'])}"  alt="logo" /></a>
                {/if}
            </div>
            <!-- logo -->
            {if St_Functions::is_normal_app_install('city_site')}
            {request 'city/index'}
            {/if}
            <!-- 城市切换 -->
            <div class="search-area-bar">
                <div class="search-term">
                    <span class="current-item" id="currentItemVal"></span>
                    <i class="arrow-icon"></i>
                    <ul class="search-down-select hide searchmodel" id="searchDownSelect">
                        {loop $searchmodel $m}
                        <li {if $m['issystem']==1}  data-pinyin="{$m['pinyin']}"  {else}  data-pinyin="general/{$m['pinyin']}" {/if} >{$m['modulename']}</li>
                        {/loop}
                    </ul>
                </div>
                <input type="text" class="top-search-ipt searchkeyword" id="topSearchIpt" name="" value="" placeholder="{Model_Global_Search::get_hot_search_default()}" />
                <button type="button" class="top-search-btn" id="st-btn" name="">搜 索</button>
                <div class="top-search-tag" id="topSearchTag">
                    {st:hotsearch action="hot" row="3"}
                    {loop $data $row}
                    <a href="javascript:;" class="label" data-keyword="{$row['title']}">{$row['title']}</a>
                    {/loop}
                    {/st}
                </div>
                <div class="st-hot-dest-box" id="stHotDestBox">
                    <div class="block-nr" id="close-ico">
                        <dl>
                            <dt>热搜词</dt>
                            <dd class="clearfix">
                                {st:hotsearch action="hot" row="20" return="d"}
                                {loop $d $row}
                                <a class="hot_search_key" href="javascript:;" data-keyword="{$row['title']}">{$row['title']}</a>
                                {/loop}
                                {/st}
                            </dd>
                        </dl>
                        <dl>
                            <dt>目的地</dt>
                            <dd class="clearfix">
                                {st:destination flag="order" action="query" row="20"}
                                {loop $data $row}
                                <a href="{$GLOBALS['cfg_basehost']}/{$row['pinyin']}/" target="_blank">{$row['kindname']}</a>
                                {/loop}
                                {/st}
                            </dd>
                        </dl>
                    </div>
                </div>
                <script>
                    $(function(){
                        $('#search-area-bar').click(function(event){
                            $('#stHotDestBox').show();
                            event.stopPropagation();
                        });
                        $('#close-ico').click(function(event){
                            $('#stHotDestBox').hide();
                            event.stopPropagation();
                        });
                        $('body').click(function(){
                            $('#stHotDestBox').hide();
                        });
                    })
                </script>
            </div>

            <!-- 搜索栏 -->
            <div class="header-contact">
                <div class="tit">客户服务电话<i class="arrow-icon"></i></div>
                {php $string_arr = explode(",", $GLOBALS['cfg_phone']);}
                <div class="num">{$string_arr[0]}</div>
                <div class="more-box">
                    <span class="item">{$string_arr[1]}</span>
                    <span class="item">{$string_arr[2]}</span>
                </div>
            </div>
            <!-- 联系方式 -->
        </div>
    </div>
    <!-- 顶部搜索 -->

    <div class="header-nav">
        <div class="wm-1200">
            <div class="header-menu">
                <ul class="menu-group clearfix">
                    <li class><a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a></li>
                    {st:channel action="pc" row="15"}
                    {loop $data $row}
                    <li class="nav_header_{$row['typeid']}">
                        {if $row['kind']}
                        {php}
                        $src = Common::get_nav_icon($row['kind']);
                        if($src)
                        {
                        echo '<img class="st-nav-icon" src="'.$src.'" />';
                        }
                        {/php}
                        {/if}
                        <a href="{$row['url']}" title="{if empty($row['linktitle'])}{$row['title']}{else}{$row['linktitle']}{/if}" >
                            {$row['title']}
                            {if !empty($row['submenu'])}
                            <i class="st-arrow-ico"></i>
                            {/if}
                        </a>
                        {if !empty($row['submenu'])}
                        <div class="down-nav">
                            <div class="sub-list">
                                {loop $row['submenu'] $submenu}
                                <a href="{$submenu['url']}">{$submenu['title']}</a>
                                {/loop}
                            </div>
                        </div>
                        {/if}
                    </li>
                    {/loop}
                </ul>
            </div>
        </div>
    </div>
    <!-- 主导航 -->


	<script>
        var SITEURL = "{$cmsurl}";
        $(function(){

            //关闭广告
            $('.top-closed').on('click',function(){
                $(this).parent('.top-column-banner').hide();
            });
            $(".search-term").hover(function(){
                $(".search-down-select").show()
            },function(){
                $(".search-down-select").hide()
            });
            $(".searchmodel li").click(function(){
                var pinyin = $(this).attr('data-pinyin');
                var typename = $(this).text();
                $("#currentItemVal").html(typename+'<i></i>');
                $("#currentItemVal").attr('data-pinyin',pinyin);
                $(".search-down-select").hide()
            });
            $(".searchmodel li:first").trigger('click');
            //search
            $('#st-btn').click(function(){
                var keyword = $.trim($('.searchkeyword').val());
                if(keyword == ''){
                    keyword = $('.searchkeyword').attr('placeholder');
                    if(keyword=='')
                    {
                        $('.searchkeyword').focus();
                        return false;
                    }

                }
                var pinyin = $("#currentItemVal").attr('data-pinyin');
                var url = SITEURL+'query/'+pinyin+'?keyword='+encodeURIComponent(keyword);
                location.href = url;
            });

            $('.hot_search_key').click(function () {
                var keyword = $(this).attr('data-keyword');
                var pinyin = $("#currentItemVal").attr('data-pinyin');
                var url = SITEURL+'query/'+pinyin+'?keyword='+encodeURIComponent(keyword);
                location.href = url;
            });
            $('.top-search-tag').click(function () {
                var keyword = $(this).attr('data-keyword');
                var pinyin = $("#currentItemVal").attr('data-pinyin');
                var url = SITEURL+'query/'+pinyin+'?keyword='+encodeURIComponent(keyword);
                location.href = url;
            });
            //城市站点
            $(".head_start_city").hover(function(){
                $(this).addClass("change_tab");
            },function(){
                $(this).removeClass("change_tab");
            });

            //选择搜索栏目
            $('.search-term').hover(function(){
                $('#searchDownSelect').removeClass('hide')
            },function(){
                $('#searchDownSelect').addClass('hide')
            });
            $('#searchDownSelect').on('click', 'li', function(){
                $('#searchDownSelect').addClass('hide');
                $('#currentItemVal').text($(this).text())
            });

            //搜索框获取焦点tag隐藏
            $('#topSearchIpt').on('click', function(e){
                $('#topSearchTag').hide();
                if($('#stHotDestBox').css('display') == 'none'){
                    $('#stHotDestBox').show();
                }
                $(document).on('click',function(e){
                    if(e.target !== $('#stHotDestBox')[0]){
                        $('#stHotDestBox').hide();
                    }
                });
                e.stopPropagation();
            });

            $('#stHotDestBox').on('click',function(e){
                e.stopPropagation();
            });

            //搜索框失去焦点判断有无值
            $('#topSearchIpt').on('blur', function(){
                if($(this).val() !== ''){
                    $('#topSearchTag').hide()
                }
                else{
                    $('#topSearchTag').show()
                }
            });

            //主导航
            get_width();
            $(window).resize(function() {
                get_width();
            });

            //全局导航
            $('.global-nav-group').hover(function(){
                $(this).children('.global-nav-bd').show()
            },function(){
                $(this).children('.global-nav-bd').hide()
            });
            //登陆状态
            $.ajax({
                type:"POST",
                async:false,
                url:SITEURL+"member/login/ajax_is_login",
                dataType:'json',
                success:function(data){
                    if(data.status){
                        $txt = '<div class="login-after">您好，<a class="user-name" style="padding:0" href="javascript:;">{__("你好")},</a>';
                        $txt+= '<a class="user-name" href="{Common::get_main_host()}/member/">'+data.user.nickname+'</a>';
                        $txt+= '<a class="user-out" href="{Common::get_main_host()}/member/login/loginout">{__("退出")}</a>';
                        //$txt+= '<a class="dl" href="{$cmsurl}member">个人中心</a>';
                    }else{

                        $txt = '<div class="login-before">您好，请<a class="lgn-link" href="{Common::get_main_host()}/member/login">{__("登录")}</a>';
                        $txt+= '<a class="reg-link" href="{Common::get_main_host()}/member/register">{__("立即注册")}</a></div>';
                        $('.top-new-msg').removeClass('top-new-msg');
                    }
                    $(".login-info").html($txt);
                }
            })

          
            $('.new-order-bar').hover(function(){
                newOrderBar.stopAutoplay()
            },function(){
                newOrderBar.startAutoplay()
            });          
        });
		 //导航的选中状态
        $(".header-menu a").each(function(){
            var url= window.location.href;
            url=url.replace('index.php','');
            url=url.replace('index.html','');
            var ulink=$(this).attr("href");
            if(url==ulink)
            {
                $(this).parents("li:first").addClass('active');
            }
        });
		 //选中导航
        var typeid = "{$typeid}";
        if(typeid!=''){
            $('.nav_header_'+typeid).addClass('active');
        }
        function get_width() {

            var offsetLeft = new Array();
            var windowWidth = $(window).width();

            //设置"down-nav"宽度为浏览器宽度
            $(".down-nav").width($(window).width());

            $(".header-menu li").hover(function() {

                var liWidth = $(this).width() / 2;

                $(this).addClass("this-hover");
                offsetLeft = $(this).offset().left;
                //获取当前选中li下的sub-list宽度
                var sub_list_width = $(this).children(".down-nav").children(".sub-list").width();
                $(this).children(".down-nav").children(".sub-list").css("width", sub_list_width);

                $(this).children(".down-nav").css("left", -offsetLeft);
                $(this).children(".down-nav").children(".sub-list").css("left", offsetLeft - sub_list_width / 2 + liWidth);

                var offsetRight = windowWidth - offsetLeft;

                var side_width = (windowWidth - 1200) / 2;

                if(sub_list_width > offsetRight) {
                    $(this).children(".down-nav").children(".sub-list").css({
                        "left": offsetLeft - sub_list_width / 2 + liWidth,
                        "right": side_width,
                        "width": "auto"
                    });
                }

                if(side_width > offsetLeft - sub_list_width / 2 + liWidth) {
                    $(this).children(".down-nav").children(".sub-list").css({
                        "left": side_width,
                        "right": side_width,
                        "width": "auto"
                    });
                }

            }, function() {

                $(this).removeClass("this-hover");

            });

        }

	</script>

</body>

</html>