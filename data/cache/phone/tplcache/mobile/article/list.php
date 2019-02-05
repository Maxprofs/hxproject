<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $search_title;?></title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,swiper.min.css');?>
    <?php echo Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,delayLoading.min.js');?>
    <?php echo Common::css_plugin('article.css','article');?>
</head>
<body>
<?php echo Request::factory("pub/header_new/typeid/$typeid/islistpage/1")->execute()->body(); ?>
<!-- 公用顶部 -->
<div class="page-content show-content list-content-btm">
    <div class="st-list-content">
        <ul class="st-list-group" id="product_list">
        </ul>
        <div class="no-content-page hide">
            <div class="no-content-icon"></div>
            <p class="no-content-txt">此页面暂无内容</p>
        </div>
    </div>
</div>
<?php echo Request::factory("article/searchnav")->execute()->body(); ?>
<?php echo Request::factory("pub/code")->execute()->body(); ?>
    <!-- 排序 -->
<script>
    var CURRENCY_SYMBOL="<?php echo Currency_Tool::symbol();?>";
    var $no_content_page = $('.no-content-page');
    function get_init_fields()
    {
        var params={
            destpy:"<?php echo $destpy;?>",
            attrid:'<?php echo $attrid;?>',
            sorttype:'<?php echo $sorttype;?>',
            keyword:'<?php echo $keyword;?>',
            page:'<?php echo $page;?>'
        };
        return params;
    }
    function on_selected_search(params)
    {
        var destpy = params['destpy']?params['destpy']:'all';
        var attrid = params['attrid']?params['attrid']:'0';
        var sorttype = params['sorttype']?params['sorttype']:'0';
        var page = params['page']?params['page']:'0';
        var keyword=params['keyword'];
        var url=SITEURL+'raiders/';
        url+=destpy+'-'+sorttype+'-'+attrid+'-'+page;
        url+=keyword?'?keyword=' + encodeURIComponent(keyword):'';
        window.location.href = url;
    }
    $(document).ready(function(){
        var init_page="<?php echo $page;?>";
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
            var url = SITEURL+'article/ajax_article_more';
            $.ajax({
                url:url,
                type:'GET',
                dataType:'json',
                data:params,
                success:function(data) {
                    is_getting=false;
                     var html='';
                    if(!data.list && page > 1)
                    {
                        $no_content_page.find('.no-content-txt').text('内容已全部加载');
                        $no_content_page.find('.no-content-icon').hide();
                        $no_content_page.show();
                        return false;
                    }
                    if(!data.list || (page==1 && data.list.length==0))
                    {
                        $no_content_page.find('.no-content-txt').text('此页面暂无内容');
                        $no_content_page.find('.no-content-icon').show();
                        $no_content_page.show();
                        return;
                    }
                     for(var i in data.list) {
                         var row = data.list[i];
                         html += '<li>'
                         html += '<a class="item" href="'+row['url']+'">';
                         html += '<div class="pic"><img src="'+row.litpic+'" alt="'+row['title']+'"></div>';
                         html += '<div class="txt">';
                         html += '<h3 class="tit">' + row['title'] + '</h3>';
                         html +='<p class="des">'+row['summary']+'</p>';
                         html+='<p class="info clearfix">';
                         html+='<span class="time">'+row['modtime']+'</span>';
                         html+='<span class="msg"><i></i>'+row['commentnum']+'</span>';
                         html+='<span class="read"><i></i>'+row['shownum']+'</span></p>';
                     html+='</div></a></li>';
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