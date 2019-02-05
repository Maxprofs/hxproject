<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title size_color=7ATBbm ><?php echo $search_title;?></title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,header.css,footer.css,swiper.min.css,reset-style.css');?>
    <?php echo Common::css_plugin('spot.css','spot');?>
    <?php echo Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,delayLoading.min.js');?>
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
<?php echo Request::factory("spot/searchnav")->execute()->body(); ?>
<?php echo Request::factory("pub/code")->execute()->body(); ?>
<!-- 目的地 -->
<script type="text/javascript">
    var CURRENCY_SYMBOL="<?php echo Currency_Tool::symbol();?>";
    function get_init_fields()
    {
        var params={
            destpy:"<?php echo $destpy;?>",
            attrid:'<?php echo $attrid;?>',
            sorttype:'<?php echo $sorttype;?>',
            keyword:'<?php echo $keyword;?>',
            priceid:'<?php echo $priceid;?>',
            page:'<?php echo $page;?>'
        };
        return params;
    }
    function on_selected_search(params)
    {
        var destpy = params['destpy']?params['destpy']:'all';
        var attrid = params['attrid']?params['attrid']:'0';
        var sorttype = params['sorttype']?params['sorttype']:'0';
        var priceid = params['priceid']?params['priceid']:'0';
        var page = params['page']?params['page']:'0';
        var url=SITEURL+'spots/';
        url+=destpy+'-'+priceid+'-'+sorttype+'-'+attrid+'-'+page+'?keyword='+params['keyword'];
        window.location.href = url;
    }
    $(document).ready(function(){
        var init_page="<?php echo $page;?>";
        var init_total=0;
        var is_getting=false;
        init_page=Number(init_page);
        init_page=init_page<=0?1:init_page;
        get_line_list(init_page);
        $(".page-content").scroll(function(){
            var scroll_top=$('.page-content').scrollTop();
            if(init_total>0 && init_total<=$("#product_list li").length)
            {
                return;
            }
            if(scroll_top+3>=($(".page-content")[0].scrollHeight - $('.page-content').outerHeight()))
            {
                get_line_list(init_page+1);
            }
        });
        //获取活动列表
        function get_line_list(page)
        {
            if(is_getting)
            {
                return;
            }
            is_getting=true;
            var params=get_init_fields();
            params['page']=page;
            var url=SITEURL+'spot/ajax_spot_more/';
            url+=params['destpy']+'-'+params['priceid']+'-'+params['sorttype']+'-'+params['attrid']+'-'+params['page']+'?keyword='+params['keyword'];
            $.ajax({
                url:url,
                type:'GET',
                dataType:'json',
                // data:params,
                success:function(data) {
                    is_getting=false;
                    var html='';
                    if(page==1 && data.list.length==0)
                    {
                        $(".no-content-page").removeClass('hide');
                        return;
                    }
                    $(".no-content-page").addClass('hide');
                    for(var i in data.list) {
                        var row = data.list[i];
                        html+='<li><a class="item" href="'+row['url']+'"><div class="pic">';
                        html+='<img src="'+row.litpic+'" alt="'+row['title']+'" title="'+row['title']+'"></div>';
                        html+='<div class="info"><h4 class="bt">' + row['title'] + '</h4>';
                        if (row['iconlist'] && row['iconlist'].length > 0)
                        {
                            html += '<p class="attr">';
                            for(var j in row['iconlist'])
                            {
                                <?php if($GLOBALS['cfg_icon_rule']==1) { ?>
                                html += '<em class="bor1">'+row['iconlist'][j]['kind']+'</em>';
                                <?php } else { ?>
                                html += '<img style="margin-right:0.1rem;" src="'+row['iconlist'][j]['litpic']+'"/>';
                                <?php } ?>
                            }
                            html += '</p>';
                        }
                        html+='<p class="data clearfix">';
                        html+='<span>满意度'+(row.satisfyscore>100?"100%":row.satisfyscore)+'</span><span>销量'+row.sellnum+'</span>';
                        if(row.price && row.price>0)
                        {
                            html += '<span class="price fr"><strong class="no-style">'+CURRENCY_SYMBOL+'<em class="no-style">' + row.price + '</em></strong>起</span>';
                        }
                        else
                        {
                            html += '<span class="price fr"><strong class="no-style"><em class="no-style">电询</em></strong></span>';
                        }
                        html+='</p></div></a></li>';
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
    });
    $(function() {
        //设置body高度
        $("html,body").css("height", "100%");
        //排序
        $(".sort-group > li").on("click", function() {
            $(this).addClass("active").siblings().removeClass("active");
        });
        $("#sort-page").on("click", function() {
            $(this).hide()
        });
        $("#sort-item").on("click", function() {
            $(".sort-page").show();
            $("#dest-page").hide();
            $("#filter-page").hide();
        });
        //目的地选择
        $("#dest-item").on("click", function() {
            $("#dest-page").show();
            $("#sort-page").hide();
            $("#filter-page").hide();
        });
        $(".dest-list > li").on("click", function() {
            if($(this).children("i").hasClass("on")) {
                $(this).addClass("active").siblings().removeClass("active")
            }
        });
        //筛选
        $("#filter-item").on("click", function() {
            $("#filter-page").show();
            $("#dest-page").hide();
            $("#sort-page").hide();
        });
        $(".filter-item .bd li").on("click", function() {
            $(this).addClass("active").siblings().removeClass("active")
        })
        $(".header_top a.back-link-icon").attr({'data-ajax':'false','href':'<?php echo $cmsurl;?>'}).removeAttr("onclick");
    });
</script>
</body>
</html>