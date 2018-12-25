<?php defined('SYSPATH') or die('No direct script access.');?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>我的红包</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        {Common::css('base.css,mobilebone.css')}
        {Common::js('lib-flexible.js')}
        {Common::js('jquery.min.js,mobilebone.js,swiper.min.js,jquery.validate.min.js,jquery.layer.js,template.js,layer/layer.m.js')}
        {Common::css_plugin('redenvelope.css','red_envelope')}
	</head>
	<body>
        <div class="page out" id="myRedenvelope">
            <div class="header_top">
                <a class="back-link-icon" {$backurl}  data-ajax="false" ></a>
                <h1 class="page-title-bar">我的红包</h1>
                <a class="re-show-link" href="#redenvelopeShow">红包说明</a>
            </div>
            <div class="page-content">
                <div class="st-tab-bar">
                    <span data-type="1" class="item active">未使用</span>
                    <span data-type="2" class="item">已使用</span>
                </div>
                <div class="st-tab-container">
                    <div class="st-tab-box" style="display: block">
                        <ul class="user-red-envelope-list">


                        </ul>
                        <div class="no-content" style="display: none">
                            <div class="no-content-page" >
                                <div class="no-content-icon"></div>
                                <p class="no-content-txt">你的包包空空如也</p>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="page out" id="redenvelopeShow">
            <header>
                <div class="header_top">
                    <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
                    <h1 class="page-title-bar">红包说明</h1>
                </div>
            </header>
            <!-- 公用顶部 -->
            <div class="page-content">
                <div class="re-document-page">
                    {Common::content_image_width($config,540,0)}
                </div>
            </div>
        </div>


	</body>

</html>
<script>
    var page = 1 ;
    var is_allow = 1 ;
    var SITERUL = '{url::site()}';
    var Currency_Tool = '{Currency_Tool::symbol()}';
    var type = 1;
    $(function() {
        $("html,body").css({height: "100%"});
        get_more();
        $(".page-content").scroll(function(){
            var scroll_top=$('.page-content').scrollTop();
            if(scroll_top+3>=($(".page-content")[0].scrollHeight - $('.page-content').outerHeight()))
            {
                get_more();
            }
        });
        $('.st-tab-bar .item').click(function () {
            if(!$(this).hasClass('active'))
            {
                $('.st-tab-bar .item').removeClass('active');
                $(this).addClass('active');
                type = $(this).data('type');
                page = 1;
                $('.user-red-envelope-list').html('');
                get_more();
            }



        })
    });

    function get_more() {
        if(page==-1||is_allow==0)
        {
            return false;
        }
        $.ajax({
            type:'post',
            dataType:'json',
            url:'{$cmsurl}/member/envelope/ajax_get_more_list',
            data:{page:page,type:type},
            async:false,
            success:function (data) {
                var list =data.list;
                if(list.length>0)
                {
                    var html = '';
                    $.each(list,function (index,obj) {
                        html += ' <li>';
                                if(obj.use==1)
                                {
                                    html +=  '<a class="item end" href="javascript:;">'
                                }
                                else
                                {
                                    html +=  '<a class="item" data-ajax="false" href="'+SITERUL+'">'
                                }
                                html += '<div class="info">' +
                                    '<span class="num">'+Currency_Tool+obj.money+'</span>' +
                                    '<span class="date">'+obj.module_title+'产品可用</span>' +
                                    '</div>' +
                                    '<div class="txt">立即使用</div></a></li>'

                    });
                    $('.user-red-envelope-list').append(html);
                }
                if(page==1&&list.length<1)
                {
                    $('.no-content').show();
                }
                else
                {
                    $('.no-content').hide();
                }
                page = data.outpage;
                is_allow=1;
            }
        });



    }




</script>