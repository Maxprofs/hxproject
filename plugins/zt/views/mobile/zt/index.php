<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{$seo['m_title']}-{$GLOBALS['cfg_webname']}</title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css_plugin('zhuanti-list.css','zt')}
    {Common::css('base.css,swiper.min.css,style-new.css')}
    {Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,delayLoading.min.js,jquery.layer.js')}
</head>
<body>

{request "pub/header_new/definetitle/".$seo['m_title']}

    <div class="zt-list">
        <ul class="clearfix" id="zt_list">
        </ul>
    </div>
    <!-- 专题列表 -->

    <div class="loading-wrap" id="data_loading" style="display: none">
        <i class="loading-ico"></i>
        <p>加载中…</p>
    </div>
    <!-- 加载中 -->
    <div class="list-end" id="data_finish" style="display: none">亲，已经是最底部了~</div>

     <div class="no-find-pro" id="data_none" style="display: none;">抱歉，没有找到符合条件的专题信息</div>
    <!-- 加载完毕 -->

    <script type="text/javascript">
        $(function() {
            var g_page=1;  //当前页数
            var g_is_finish=0; //是否已完成所有加载
            var g_is_loading=0; //是否正在加载

            $("html,body").css("height","100%");

            //滚动加载判断
            $(window).scroll(function() {
                if ($(document).scrollTop()<=0){

                }
                if ($(document).scrollTop() >= $(document).height() - $(window).height())
                {
                    if(g_is_finish==1)
                    {
                        $("#data_finish").show();
                    }
                    else
                    {
                        $("#data_finish").hide();
                        get_list(parseInt(g_page)+1);
                    }
                }
            });

            //首页加载
            get_list(g_page);

            //加载列表
            function get_list(page)
            {
                if(g_is_finish==1 || g_is_loading==1)
                {
                    return;
                }
                g_is_loading=1;
                $("#data_loading").show();
                var url=SITEURL+'zt/ajax_get_list';
                $.ajax({
                    url:url,
                    type:'POST',
                    dataType:'json',
                    data:{page:page},
                    success:function(data) {
                        var html = '';
                        var len = data && data.list? data.list.length : 0;
                        if (data.list) {
                            for (var i in data.list) {
                                var row = data.list[i];
                                html += '<li><a href="' + row['url'] + '">';
                                html += '<div class="pic">';
                                html += '<img src="' + row['m_banner'] + '" alt="' + row['title'] + '" />';
                                html += '</div>';
                                html += '<div class="info">';
                                html += '<p class="tit">' + row['title'] + '</p>';
                                html += '<p class="time">发布时间：' + row['addtime_str'] + '</p>';
                                html += '</div></a></li>';
                            }
                        }
                        $("#zt_list").append(html);
                        if (len > 0)
                        {
                            g_page = page;
                        }
                        if(len<6)
                        {
                            g_is_finish=1;
                        }

                        if((!data || len<=0 || !data.list) && page==1)
                        {
                            $("#data_none").show();
                        }
                    },
                    complete:function(){
                        g_is_loading=0;
                        $("#data_loading").hide();
                    }
                 });
            }
        });



    </script>
</body>
</html>