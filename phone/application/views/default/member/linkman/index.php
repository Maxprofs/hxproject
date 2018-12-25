
{Common::css('add-passenger.css')}
<div class="header_top bar-nav">
    <a class="back-link-icon"  href="javascript:;" data-rel="back"></a>
    <h1 class="page-title-bar">常用旅客</h1>
    <a class="add-link" href="{$cmsurl}member/linkman/update?action=add" data-reload="true">添加</a>
</div>
<!-- 公用顶部 -->

<div class="page-content">
    <div class="passenger-all-list" id="linkman-list">

    </div>
    <div class="onload-box">
        <div class="onloading hide"><i></i>加载中</div>
        <div class="network-erro hide"><i></i>网络异常，加载失败</div>
        <div class="no-passenger hide">
            <i></i>
            暂无常用旅客，请添加！
        </div>
    </div>
</div>

<script type="text/javascript">

    var is_loading = false;
    var refresh = "{$refresh}";
    var params={
        page:1
    };
    $(function(){
        $("body,html").css("height", "100%");

        if(Number(refresh == 1)){
            var url = '{$cmsurl}member#&{$cmsurl}member/linkman/refresh/0';
            location.href = url;
        }

        get_data();

        /*下拉加载*/
        $('.page-content').scroll( function() {
            var totalheight = parseFloat($(this).height()) + parseFloat($(this).scrollTop());
            var scrollHeight = $(this)[0].scrollHeight;//实际高度
            if(totalheight-scrollHeight>= -10){
                if(params.page!=-1 && !is_loading){
                    is_loading = true;
                    get_data();
                }
            }
        });

    });

    function get_data() {
        $('.onloading').removeClass('hide');

        var url = SITEURL + 'member/linkman/ajax_more';

        $.ajax({
           type:'get',
           dataType:'json',
           data:params,
           url:url,
           success:function (data) {
               if(data.list.length>0)
               {
                   var has_pinyin = [];
                   $('#linkman-list .item').each(function () {
                       var pinyin = $(this).data('pinyin');
                       if($.inArray(pinyin,has_pinyin)==-1)
                       {
                           has_pinyin.push(pinyin);
                       }
                   })
               }
               $(data.list).each(function (index,obj)
               {
                   var l_pinyin = obj.pinyin;
                   if($.inArray(l_pinyin,has_pinyin)==-1)
                   {
                       has_pinyin.push(l_pinyin);
                       var html = ' <div class="item" data-pinyin="'+l_pinyin+'">' +
                           '<h4>'+l_pinyin+'</h4>' +
                           '<ul>' +
                           '<li class="clearfix">' +
                           '<div class="info"><div class="tp clearfix"><strong class="name">'+obj.linkman+'</strong>' +
                           '<strong class="sex">'+obj.sex+'</strong></div>' +
                           '<div class="bp clearfix"><span class="tel">'+obj.mobile+'</span>' +
                           '<span class="type">'+obj.cardtype+'</span><span class="card">'+obj.idcard+'</span></div>' +
                           '</div><a class="edit-btn" href="'+obj.url+'">' +
                           '</li>' +
                           '</ul> </div>';
                       $('#linkman-list').append(html);
                   }
                   else
                   {
                       var html = '<li class="clearfix">' +
                           '<div class="info"><div class="tp clearfix"><strong class="name">'+obj.linkman+'</strong>' +
                           '<strong class="sex">'+obj.sex+'</strong></div>' +
                           '<div class="bp clearfix"><span class="tel">'+obj.mobile+'</span>' +
                           '<span class="type">'+obj.cardtype+'</span><span class="card">'+obj.idcard+'</span></div>' +
                           '</div><a class="edit-btn" href="'+obj.url+'"></li>';
                       $('#linkman-list .item[data-pinyin='+l_pinyin+']').find('ul').append(html);

                   }
               });
               if(params.page==1&&data.list.length==0)
               {
                   $('.no-passenger').removeClass('hide');
               }
               else
               {
                   $('.no-passenger').addClass('hide');
               }

               $('.onloading').addClass('hide');
               $('.network-erro').addClass('hide');
               params.page = data.page;
               is_loading = false;
           },
           error:function (a, b, c) {
               $('.network-erro').removeClass('hide');
               $('.onloading').addClass('hide');
               is_loading = false;

           }

        });


    }

</script>

