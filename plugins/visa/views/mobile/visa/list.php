<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        {Common::css('base.css,swiper.min.css,reset-style.css')}
        {Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,delayLoading.min.js')}
        {Common::css_plugin('visa.css','visa')}

	</head>
	<body>
    {request "pub/header_new/typeid/$typeid"}
    	<!-- 公用顶部 -->

    <div class="page-content show-content list-content-btm">
        <div class="st-list-content">
            <ul class="st-list-group visa-list" id="product_list">
                {if !empty($area)}
                <li class="first-li">
                    <a id="des" href="javascript:;">
                        <div class="pic"><img src="{$area['litpic']}" alt="" title="{$area['kindname']}"></div>
                        <div class="nr">
                            <p class="bt">{$area['kindname']}</p>
                            <p class="des">{$area['summary']}</p>
                            <p class="ico"></p>
                        </div>
                    </a>
                </li>
                {/if}
            </ul>
            <div class="no-content-page hide">
                <div class="no-content-icon"></div>
                <p class="no-content-txt">没有找到相关签证信息!</p>
            </div>
        </div>
    </div>

    {request "visa/searchnav"}
    {request "pub/code"}
	    
	    <div id="introduce" class="introduce">
	    	<div class="des">
	    		{$area['jieshao']}
	    	</div>
	    	<a class="close" href="javascript:;"></a>
	    </div>
	    <!--介绍弹出-->

    <script>
        var CURRENCY_SYMBOL="{Currency_Tool::symbol()}";


        $("#des").on("click",function(){
            $("#introduce").show();
        });
        $("#introduce .close").on("click",function(){
            $("#introduce").hide();
        });

        function get_init_fields()
        {
            var params={
                area:"{$areapy}",
                cityid:'{$cityid}',
                keyword:'{$keyword}',
                visatype:'{$visatype}',
                page:'{$page}'
            };

            return params;
        }

        function on_selected_search(params)
        {

            var area = params['area']?params['area']:'0';
            var cityid=params['cityid']?params['cityid']:'0';
            var visatype=params['visatype']?params['visatype']:'0';
            var page = params['page']?params['page']:'0';
            var keyword=params['keyword'];
            var url=SITEURL+'visa/';
            url+=area+'-'+cityid+'-'+visatype+'-'+page;
            url+=keyword?'?keyword=' + encodeURIComponent(keyword):'';
            window.location.href = url;
        }


        $(document).ready(function(){
            var init_page="{$page}";
            var init_total=0;
            var is_getting=false;
            init_page=Number(init_page);
            init_page=init_page<=0?1:init_page;
            get_product_list(init_page);

            $(".page-content").scroll(function(){
                var scroll_top=$('.page-content').scrollTop();
                if(init_total>0 && init_total<=$("#product_list li").length)
                {
                    return;
                }
                if(scroll_top+3>=($(".page-content")[0].scrollHeight - $('.page-content').outerHeight()))
                {
                    get_product_list(init_page+1);
                }
            });
            //获取活动列表
            function get_product_list(page)
            {
                if(is_getting)
                {
                    return;
                }
                is_getting=true;
                var params=get_init_fields();
                params['page']=page;

                var url=SITEURL+'visa/ajax_visa_more/';
                url+=params['area']+'-'+params['cityid']+'-'+params['visatype']+'-'+params['page'];
                url+=params['keyword']?'?keyword=' + encodeURIComponent(params['keyword']):'';

                $.ajax({
                    url:url,
                    type:'GET',
                    dataType:'json',
                    success:function(data) {
                        is_getting=false;
                        var html='';
                        if(page==1 && data.list.length==0)
                        {
                            $(".no-content-page").show();
                            return;
                        }

                        for(var i in data.list) {
                            var row = data.list[i];
                            html += '<li>';
                            html += '<a href="'+row['url']+'">';
                            html += '<div class="pic"><img src="'+row['litpic']+'"  title="'+row['title']+'"></div>';
                            html += '<div class="nr">';
                            html += '<p class="bt">'+row['title']+'</p>';
                            html += '<p class="md">';
                            html += '<span>满意度'+row['satisfyscore']+'%</span>';
                            html += '<span>销量'+row['sellnum']+'</span>';
                            html += '<span>推荐'+row['recommendnum']+'</span>';
                            html += '</p>';
                            html += '<p class="hj clearfix">';
                            html += '<em class="no-style">办理时长：'+row['handleday']+'</em>';
                            html += '<span class="price">';
                            if(row['price'])
                            {
                                html += '<i class="no-style">'+CURRENCY_SYMBOL+'</i><strong class="no-style">'+row['price']+'</strong>起';
                            }
                            else
                            {
                                html += '<i class="no-style">电询</i>';
                            }
                            html += '</span></p></div></a></li>';
                        }
                        $("#product_list").append(html);
                        // init_total = data.total;
                        if(html!='')
                        {
                            init_page=page;
                        }
                    }
                })
            }

        })


    </script>
	</body>
</html>
