<!doctype html>
<html>
<head font_html=jyvz8B >
    <meta charset="utf-8">
    <title>12笛卡旅游CMS{$coreVersion}</title>
    {php echo Common::getScript('jquery-1.8.3.min.js,common.js,jquery.hotkeys.js,msgbox/msgbox.js,slideTabs.js,DatePicker/WdatePicker.js,echarts.js,echart-data.js'); }
    {php echo Common::getCss('base.css,index_5.css,home.css'); }
    {php echo Common::getCss('msgbox.css','js/msgbox'); }

</head>

<body>

<!--CMS主体内容-->
<div class="cms-main-box">
    <!--左侧内容-->
    <div class="cms-content-box">

        <!-- 正版信息 -->
        <div class="copyright-content authorright_msg" style="display: none;">
            <div class="copyright-block clearfix">
                <div class="hello-st">您好，欢迎使用正版笛卡CMS！</div>
                <div class="scroll-msg">
                    <div class="scorll-list">
                        <ul>
                            <script type="text/javascript" aynsc  src="http://www.deccatech.cn/api/cms/notice/"></script>
                        </ul>
                    </div>
                </div>
                <a class="more-msg" href="http://www.deccatech.cn/help/fenlei-599" target="_blank">更多通知 &gt;</a>
            </div>
        </div>

        <!-- 盗版信息 -->
        <div class="copyright-content un_authorright_msg" style="display: none">
            <div class="copyright-block clearfix">
                <div class="warn-txt">检测到您所使用的系统是盗版系统，对此我们保留起诉权利，将进行严厉打击！</div>
                <div class="gm-txt">请您购买正版系统，享受专业服务。</div>
            </div>
        </div>


        <!-- 管理员 -->
        <div class="cms-msg-box">
            <div class="admin_msg">
                {if !empty($admin_litpic)}
                    <img class="fl" src="{$admin_litpic}" alt="{$username}" width="50" height="50" />
                {else}
                    <img class="fl" src="{$GLOBALS['cfg_public_url']}images/admin-img.png" alt="{$username}" width="50" height="50" />
                {/if}
                <p class="name">{$username}<!--<span class="msg"><i class="ico">5</i></span>--></p>
                <p class="time">{$rolename}</p>
            </div>
            <div class="txt-msg authorright_msg"  style="display: none">
                <div class="contact-btn">
                </div>
                <div class="update-msg" id="myversion">

                </div>
            </div>
            <div class="txt-msg un_authorright_msg" style="display: none">
                <div class="contact-btn">
                </div>
            </div>
        </div>
        <!--快捷菜单-->
        {if Model_Sysconfig::get_sys_conf('value','cfg_quick_menu')}
           {request 'quickmenu/index'}
        {/if}

        <!--产品管理-->
        <div class="product-manage">
            <div class="pro-mge-tit"><s></s>产品管理</div>
            <div class="pro-mge-con">
                <ul class="clearfix">

                    {php}$_article=array();{/php}
                    {loop Model_Menu_New::get_config_by_pid(1) $data}
                    {php} if(in_array($data['typeid'],array(4,6,10,11,12,101,115,null))){$_article[]=$data;continue;}{/php}
                    <li>
                        <div class="ietm-child">
                            <strong class="column-tit"><a href="javascript:;" class="product_item" data-url="{$data['url']}">{if !empty($data['typeid'])}{Model_Menu_New::get_nav_title($data['typeid'],'shortname')}{else}{$data['title']}{/if}</a></strong>
                                <span class="column-cz clearfix">
                                    {if strpos($data['datainfo'],'1') !== false}
                                    {php}
                                    if(isset($data['order_id'])){
                                        $node=Model_Menu_New::get_config_by_id($data['order_id']);
                                        $nodeUrl=$node['url'];
                                    }
                                    {/php}
                                    {if Model_Admin::check_right($node['id'])}
                                        <a href="javascript:;" class="data_item" data-url="{$nodeUrl}" data-name="{$data['title']}订单">
                                                <em class="txt">订单</em>
                                                <em class="num" id="channel_order_num_{$data['typeid']}"></em>
                                                <i class="tip unread" id="channel_order_unview_{$data['typeid']}" style="display: none"></i>
                                         </a>
                                       {else}
                                          <a href="javascript:;"></a>
                                    {/if}
                                    {else}
                                         <a href="javascript:;">

                                         </a>
                                    {/if}

                                    {if strpos($data['datainfo'],'2')!==false}
                                        {if Model_Admin::check_right($data['question_id'])}
                                       <a href="javascript:;" class="data_item" data-url="question/index/typeid/{$data['typeid']}/menuid/{$data['question_id']}" data-name="{$data['title']}咨询" >
                                                <em class="txt">咨询</em>
                                                <em class="num" id="channel_question_num_{$data['typeid']}"></em>
                                                <i class="tip unread" id="channel_question_unans_num_{$data['typeid']}" style="display: none"></i>
                                        </a>
                                         {else}
                                          <a href="javascript:;"></a>
                                        {/if}
                                    {else}
                                         <a href="javascript:;">

                                         </a>
                                    {/if}
                                     {if strpos($data['datainfo'],'3')!==false}
                                      {if Model_Admin::check_right($data['comment_id'])}
                                        <a  href="javascript:;" class="data_item last" data-url="<?php echo Model_Menu_New::get_commnet_url($data['typeid'])?>" data-name="{$data['title']}评论" >
                                                <em class="txt">评论</em>
                                                <em class="num" id="channel_comment_num_{$data['typeid']}"></em>
                                                <i class="tip unread" id="channel_comment_uncheck_num_{$data['typeid']}" style="display: none"></i>
                                        </a>
                                        {else}
                                           <a href="javascript:;"></a>
                                        {/if}
                                     {else}
                                         <a class="last" href="javascript:;">

                                         </a>
                                     {/if}

                                </span>
                        </div>
                    </li>
                    {/loop}

                </ul>
            </div>
        </div>



        <!-- 软文管理 -->
        <div class="article-content">
            <div class="article-title"><i class="ico01"></i>软文管理</div>
            <div class="article-block">
                <ul class="clearfix">
                    {loop $_article $data}
                    <li>
                        <div class="ietm-child">
                            <strong class="column-tit"><a href="javascript:;" class="article_item" data-url="{$data['url']}">{if !empty($data['typeid'])}{Model_Menu_New::get_nav_title($data['typeid'],'shortname')}{else}{$data['title']}{/if}</a></strong>
                                <span class="column-cz clearfix">
                                    {if strpos($data['datainfo'],'1') !== false}
                                        {if $data['typeid']==11}
                                            <a href="javascript:;" class="data_item" data-url="{$data['url']}" data-name="结伴">
                                                <em class="txt">订单</em>
                                                <em class="num" id="channel_order_num_{$data['typeid']}"></em>
                                                <i class="tip unread" id="channel_order_unview_{$data['typeid']}" style="display: none"></i>
                                            </a>
                                        {elseif $data['typeid']==14}
                                            <a href="javascript:;" class="data_item" data-url="{$data['url']}" data-name="私人定制">
                                                <em class="txt">订单</em>
                                                <em class="num" id="channel_order_num_{$data['typeid']}"></em>
                                                <i class="tip unread" id="channel_order_unview_{$data['typeid']}" style="display: none"></i>
                                            </a>
                                        {else}
                                        <a href="javascript:;" class="data_item" data-url="{if $data['typeid']==14}order/dz{else}order/index{/if}/typeid/{$data['typeid']}/menuid/{$data['order_id']}" data-name="{$data['title']}订单">
                                            <em class="txt">{if $data['id']==17}需求{elseif $data['id']==18}加入{else}订单{/if}</em>
                                            <em class="num" id="channel_order_num_{$data['typeid']}"></em>
                                            <i class="tip unread" id="channel_order_unview_{$data['typeid']}" style="display: none"></i>
                                        </a>
                                        {/if}
                                    {elseif strpos($data['datainfo'],'2')!==false}
                                        <a href="javascript:;" class="data_item" data-url="{if $data['typeid']==10}{$data['url']}{else}question/index/typeid/{$data['typeid']}/menuid/{$data['question_id']}{/if}" data-name="{$data['title']}咨询" >
                                            <em class="txt">咨询</em>
                                            <em class="num" id="channel_question_num_{$data['typeid']}"></em>
                                            <i class="tip unread" id="channel_question_unans_num_{$data['typeid']}" style="display: none"></i>
                                        </a>
                                    {elseif strpos($data['datainfo'],'3')!==false}
                                        <a  href="javascript:;" class="data_item last" data-url="<?php echo Model_Menu_New::get_commnet_url($data['typeid'])?>" data-name="{$data['title']}评论" >
                                            <em class="txt">评论</em>
                                            <em class="num" id="channel_comment_num_{$data['typeid']}"></em>
                                            <i class="tip unread" id="channel_comment_uncheck_num_{$data['typeid']}" style="display: none"></i>
                                        </a>
                                    {else}
                                    <a href="javascript:;"></a>
                                    {/if}
                                </span>
                        </div>
                    </li>
                    {/loop}
                </ul>
            </div>
        </div>

        <!--数据统计-->
        <div class="manage-content">
            <div class="manage-title">
                <i class="ico03"></i>
                数据统计
                <div class="time-interval">
                    <em>时间范围</em>
                    <input type="text" class="time-begin" id="starttime" onclick="WdatePicker()" value="{$starttime}"
                           placeholder="{$starttime}" />
                    <b></b>
                    <input type="text" class="time-over" id="endtime" onclick="WdatePicker({minDate:'#F{$dp.$D(\'starttime\')}'})" value="{$endtime}"
                           placeholder="{$endtime}" />
                    <input type="button" class="inquiry-btn query_btn" value="查询" />
                </div>
            </div>
            <div class="manage-block">

                <!-- 订单统计 -->
                <div class="data-count-con">
                    <div class="list-count-tit"><s></S>订单统计</div>
                    <div id="order-count-box" style=" float: left; width: 100%; height:300px;">

                    </div>
                </div>

                <!-- 会员统计 -->
                <div class="data-count-con">
                    <div class="list-count-tit"><s></S>会员统计</div>
                    <div id="member-count-box" style=" float: left; width: 100%; height:300px;">

                    </div>
                </div>

            </div>
        </div>

        <!-- 软文管理 -->
        <div class="manage-content">
            <div class="manage-title"><i class="ico04"></i>笛卡支持</div>
            <div class="manage-block">
                <div class="update-box">
                    <h3><span>系统更新</span></h3>
                    <div class="con-list" id="newversion_list">
                        <script type="text/javascript" aynsc  src="http://www.deccatech.cn/api/cms/version"></script>
                    </div>
                </div>
                <div class="market-box">
                    <h3><span>营销文章</span></h3>
                    <div class="con-list">
                        <ul id="yx_article_list">
                            <script type="text/javascript" aynsc  src="http://www.deccatech.cn/api/cms/article"></script>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!--备案信息-->
        <div class="copyright">
            <p>Powered by Deccatech V{$majorVersion} ©2007-{$year}</p>
            <p>建议使用google浏览器访问后台</p>
        </div>

    </div>

    <!--右侧内容-->
    <div class="cms-sidle-box">
        <!-- 功能搜索 -->
        <div class="search-content clearfix">
            <input type="text" id="search-text" class="search-text" placeholder="快速定位你需要的功能" />
            <input type="button" id="search_submit" class="search-btn" />
        </div>
        <script>
            $('#search_submit').click(function(){
                var title = $('#search-text').val();
                if(title.length>0){
                    var url='quickmenu/search?keyword='+title;
                    ST.Util.removeTab(url);
                    ST.Util.addTab('菜单搜索', url);
                }else{
                    ST.Util.showMsg('请输入您的搜索关键词',1,1000)
                }
            });
        </script>
        {php $index=1;}
        {loop Model_Menu_New::get_config_by_pid(0,array(1)) $k $v}
        {if $v['id'] == 9}
            {php}
                $index++;
                continue;
            {/php}

        {/if}
        <!-- 站点管理 -->
        <div class="sidle-module">
            <div class="sidle-tit"><s class="bgs{$index}"></s>{$v['title']}</div>
            <div class="sidle-con">
                <div class="sidle-menu-a">
                    {loop Model_Menu_New::get_config_by_pid($v['id']) $sub}
                        {if $sub['title']!='产品接口' ||($sub['title']=='产品接口' && $sub['child_id']) }
                        <a href="javascript:;" class="config_item" data-url="{$sub['url']}" {if isset($sub['alias_title'])}data-title="{$sub['alias_title']}"{/if}>{$sub['title']}</a>
                        {/if}
                    {/loop}
                </div>
            </div>
        </div>
         {php $index++;}
        {/loop}

        {if !empty($menu['userdefined'])}
        <!-- 用户自定义 -->
        <div class="sidle-module">
            <div class="sidle-tit"><s class="bgs8"></s>用户自定义</div>
            <div class="sidle-con">
                <div class="sidle-menu-a">
                    {loop $menu['userdefined'] $v}

                    <span><a href="javascript:;" class="config_item" data-url="{$v['url']}" >{$v['name']}</a></span>

                    {/loop}

                </div>
            </div>
        </div>
        {/if}



    </div>

    <!--联系我们-->
    <div class="kefu-box" style="display: none">
        <div class="kf-tit">
            <em>联系笛卡</em>
            <span class="kf_close"></span>
        </div>
        <div class="kf-con-list">
        </div>
    </div>

    <!--盗版提示-->
    <div class="remind-box" style="display: none">

        <div class="rem-tit">

            <em>绑定授权</em>

            <span id="closeremind"></span>

        </div>

        <div class="rem-con-list">
            <div class="btn_box"></div>
        </div>

    </div>

</div>
<script>
var SITEURL = URL = '{php echo URL::site();}';
$(function(){

    //未安装产品,则直接隐藏
    var product_count = $('.product-manage').find('li').length;
    if(product_count == 0){
        $('.product-manage').hide();
    }

    //获取宽度
    function setDivAttr(){
        var cmsMainHeight = $(window).height();
        var cmsMainWidth  = $(window).width()-450;
        $(".cms-main-box").height(cmsMainHeight);
        $(".cms-content-box").width(cmsMainWidth);
    }

    setDivAttr();

    //窗口改变重新获取宽度
    $(window).resize(function(){
        setDivAttr();
        var cmsMainWidth  = $(window).width()-450;
        $(".cms-content-box").width(cmsMainWidth-20);
    });

    //滚动公告
    function marginTop(){
        $(".scorll-list > ul").animate({
            marginTop:"-32px"
        },500,function(){
            $(this).css("marginTop","0").find("li:first").appendTo(this);
        });
    }
    setInterval(marginTop,5000);

    //专属客服
    $(".kf-btn").click(function () {
        $('.kefu-box').show();
    })
    //专属客服关闭
    $('.kf_close').click(function () {
        $('.kefu-box').hide();
    })

    $('#closeremind').click(function () {
        $('.remind-box').hide();
    })

    //是否有新版本和正版检测
    $.ajax({
        url: SITEURL + "upgrade/ajax_check_all_systempart_update",
        dataType: 'json',
        success: function (data) {
            if (data.status == 1) {
                $(".up-btn .version-icon").css('visibility', 'visible')
            }
            else {
                $(".up-btn .version-icon").css('visibility', 'hidden')
            }
            $("#myversion").html("<p></p><p>系统版本：V"+data.core_system_version+"</p>");
            checkRightV();
        }});
    //绑定授权
    $(".btn_bind").click(function () {
        ST.Util.addTab('授权管理', 'config/authright/menuid/191');
    })
    //客服显示
    $(".btn_showkefu").click(function () {
        $('.kefu-box').show();
    })

    //查询日期
    $(".query_btn").click(function () {
        var starttime = $("#starttime").val();
        var endtime = $("#endtime").val();
        var arr = starttime.split("-");
        var starttime = new Date(arr[0], arr[1], arr[2]);
        var starttimes = starttime.getTime();
        var arrs = endtime.split("-");
        var lktime = new Date(arrs[0], arrs[1], arrs[2]);
        var lktimes = lktime.getTime();

        if (starttimes >= lktimes) {
            ST.Util.showMsg("结束日期不能小于开始日期", 5, 1000);
            return false;
        }
        initChart();
    })

    //链接跳转
    $('.product_item,.config_item,.article_item').click(function(){
        var url = $(this).attr('data-url');
        var data_title=$(this).attr('data-title');
        var title =typeof(data_title)=='undefined'?$(this).text():data_title;
        ST.Util.addTab(title, url);

    })
    //评论,订单,咨询跳转
    $(".data_item").click(function(){
        var url = $(this).data('url');
        var title = $(this).data('name');
        ST.Util.addTab(title,url);
    })
    //获取订单数量
    $.ajax({
        type: 'POST',
        url: URL + 'index/ajax_order_num?'+Math.random(),
        dataType: 'json',
        success: function (data) {
            $.each(data, function (i, row) {
                $("#channel_order_num_"+row.typeid).text(row.num);

                if (parseInt(row.unviewnum) >0 ) {

                    $("#channel_order_unview_" + row.typeid).text(row.unviewnum);
                    $("#channel_order_unview_" + row.typeid).show();

                }else{
                    $("#channel_order_unview_" + row.typeid).hide();
                }

                //评论数量
                if(parseInt(row.comment_num) >= 0){
                    $("#channel_comment_num_" + row.typeid).text(row.comment_num);

                }else{
                    $("#channel_comment_num_" + row.typeid).hide();
                }
                //未审核评论
                if(parseInt(row.comment_uncheck_num) > 0){
                    $("#channel_comment_uncheck_num_" + row.typeid).text(row.comment_uncheck_num);
                    $("#channel_comment_uncheck_num_" + row.typeid).show();

                }else{
                    $("#channel_comment_uncheck_num_" + row.typeid).hide();
                }

                //提问数量
                if(parseInt(row.question_num) >= 0){
                    $("#channel_question_num_" + row.typeid).text(row.question_num);
                    $("#channel_question_num_" + row.typeid).show();
                }else{
                    $("#channel_question_num_" + row.typeid).hide();
                }
                //未回复数量
                if(parseInt(row.question_unans_num) > 0){
                    $("#channel_question_unans_num_" + row.typeid).text(row.question_unans_num);
                    $("#channel_question_unans_num_" + row.typeid).show();
                }else{
                    $("#channel_question_unans_num_" + row.typeid).hide();
                }
            })
        }
    })


})
//检测正版授权
function checkRightV() {
    $.ajax({
        url: SITEURL + "upgrade/ajax_check_right/systempart/{php echo Model_SystemParts::$coreSystemPartCode}",
        dataType: 'json',
        success: function (data) {
            if (data.status == 1) {
                $('.authorright_msg').show();
                $('.un_authorright_msg').hide();


            }
            else {
                $('.authorright_msg').hide();
                $('.un_authorright_msg').show();
                $('.remind-box').show()



            }
        }});
}




</script>
</body>
</html>
