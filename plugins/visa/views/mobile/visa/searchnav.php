
<div id="dest-page" class="dest-page first-floor" {if $show_area==1}style="display: block;"{/if}>    <div class="header-top bar-nav">
        <a class="back-link-icon" href="javascript:;"></a>
        <h1 class="page-title-bar">签证区域</h1>
    </div>
    <div class="dest-list">
        <div class="hd">
            <ul class="p_area">
                {st:visa action="area" row="1000" flag="query" pid="0" return="area_list"}
                {loop $area_list $area}
                <li data-sub="area_{$area['id']}" id="area_{$area['id']}">{$area['title']}</li>
                {/loop}
            </ul>
        </div>
        <div class="bd">
            {loop $area_list $area}
            <ul id="sub_area_{$area['id']}" data-pid="{$area['id']}"  class="sub_area" style="display: none;">
                {st:visa action="area" row="1000" flag="query" pid="$area['id']" return="sub_area_list"}
                {loop $sub_area_list $sub_area}
                <li data-id="{$sub_area['pinyin']}" selfield="area">{$sub_area['title']}<i class="on"></i></li>
                {/loop}
            </ul>
            {/loop}
        </div>
    </div>
</div>
<div class="foot-menu">
    <div id="dest-item" class="check-item fl" data-floor="dest">
        <span class="check-hd"><i class="mdd-icon"></i>签证区域</span>
    </div>
    <div id="sort-item" class="check-item fl" data-floor="sort">
        <span class="check-hd"><i class="px-icon"></i>签发城市</span>
    </div>
    <div id="filter-item" class="check-item fl" data-floor="filter">
        <span class="check-hd"><i class="sx-icon"></i>筛选</span>
    </div>
</div>
<!-- 目的地 -->

<div id="filter-page" class="filter-page first-floor" style="">
    <ul class="filter-group">
        <li class="active" data-id="0" selfield="visatype">全部<em class="ico"></em></li>
        {st:visa action="kind" return="kind_list"}
        {loop $kind_list $kind}
        <li data-id="{$kind['id']}" selfield="visatype">{$kind['title']}<em class="ico"></em></li>
        {/loop}

    </ul>
</div>
<!-- 筛选 -->

<div id="sort-page" class="sort-page first-floor">
    <ul class="sort-group">
        <li class="active" data-id="0" selfield="cityid">所有城市<em class="ico"></em></li>
        {st:visa action="city" return="city_list"}
        {loop $city_list $city}
        <li data-id="{$city['id']}" selfield="cityid">{$city['kindname']}<em class="ico"></em></li>
        {/loop}

    </ul>
</div>

<script>
    $(document).ready(function(){
        var typeid="{$typeid}";
        //目的地缓存
        var cache_parents={};
        //初始参数缓存
        var cache_init_params={};
        //选中项缓存
        var cache_new_params={};
        //实始化参数
        if(typeof(get_init_fields)=='function')
        {
            cache_init_params = cache_new_params= get_init_fields();
        }
        //get_next_dests(cache_init_params['destpy']);



        $("html,body").css("height","100%");
        //弹出菜单
         $(".foot-menu .check-item").click(function(){
              var floor = $(this).data('floor');
              $('.'+floor+'-page').show();
              $('.'+floor+'-page').siblings('.first-floor').hide();
         });

         //杂项切换
         $("#filter-page .hd ul li").click(function(){
              $(this).addClass('active');
              $(this).siblings().removeClass('active');
              var sub = $(this).data('sub');
              $("#sub_"+sub).show();
              $("#sub_"+sub).siblings().hide();
         });

        $(".first-floor .back-link-icon").click(function(){
             $(this).parents('.first-floor:first').hide();
        });
        //隐藏排序
        $("#sort-page").on("click",function(){
            $(this).hide();
        });


        //确定按钮点击
        $(".first-floor .confirm-btn").click(function(){
             go_search();
        });





        //排序项点击
        $(".sort-page ul li[selfield]").click(function(){
            $(this).siblings().removeClass('active');
            var field=$(this).attr('selfield');
            var id = $(this).data('id');
            if($(this).hasClass('active'))
            {
                $(this).removeClass('active');
                cache_new_params[field]=0;
            }
            else
            {
                $(this).addClass('active');
                cache_new_params[field]=id;
            }
            go_search();
        });

        $("#filter-page").click(function(){
            $(this).hide();
        });


        //类型切换
        $("#filter-page ul li[selfield]").click(function(){
            $(this).siblings().removeClass('active');
            var field=$(this).attr('selfield');
            var id = $(this).data('id');
            if($(this).hasClass('active'))
            {
                $(this).removeClass('active');
                cache_new_params[field]=0;
            }
            else
            {
                $(this).addClass('active');
                cache_new_params[field]=id;
            }
            go_search();
        });

        //区域切换
        $(".p_area li").click(function(){
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
            var sub=$(this).attr('data-sub');
            $("#sub_"+sub).show();
            $("#sub_"+sub).siblings().hide();
        });
        $(".sub_area li").click(function(){
            $(".sub_area li").removeClass('active');
            var field=$(this).attr('selfield');
            var id = $(this).data('id');
            if($(this).hasClass('active'))
            {
                $(this).removeClass('active');
                cache_new_params[field]=0;
            }
            else
            {
                $(this).addClass('active');
                cache_new_params[field]=id;
            }
            if(id){
                window.location.href = '{$cmsurl}visa/'+id;
            }else {
                window.location.reload();
            }

            //go_search();
        });

        $(".p_area li:first").trigger('click');



        //恢复默认
        $("#filter_back_btn").click(function(){
              refresh_selected(null,'.filter-item .bd ul li[selfield]')
        });

        //初始化数据
        refresh_selected();


        //初始化选中项
        function refresh_selected(field,selector)
        {
            if(typeof(get_init_fields)=='function')
            {
                var params = get_init_fields();

                var selector_str=selector;
                if(!selector)
                {
                    selector_str = field ? ".first-floor ul li[selfield='" + field + "']" : ".first-floor ul li[selfield]";
                }
                $(selector_str).each(function(){
                       var fieldname = $(this).attr('selfield');
                       var val = $(this).data('id');
                       val = String(val);
                       var is_selected=false;



                       if(val==params[fieldname] && val!='0')
                       {
                           $(this).addClass('active');
                           $(this).siblings().removeClass('active');

                           //如果是区域
                           if(fieldname=='area')
                           {
                               var pid=$(this).parent().attr('data-pid');
                               $("#area_"+pid).trigger('click');
                           }
                       }
                       else if(val!='0' && val!=params[fieldname])
                       {
                           $(this).removeClass('active');
                       }


                       if(val=='0' && (params[fieldname]==0 || !params[fieldname]))
                       {
                           $(this).addClass('active');
                           $(this).siblings().removeClass('active');
                       }

                       if(selector)
                       {
                           cache_new_params[fieldname]=cache_init_params[fieldname];
                       }
                });

            }
        }


        function go_search()
        {
            if(typeof(on_selected_search)=='function')
            {
                var attrids=[];
                for(var key in cache_new_params)
                {
                    if(key.indexOf('attrid_')!=-1)
                    {
                        attrids.push(cache_new_params[key]);
                    }
                }
                if(attrids.length>0)
                {
                    cache_new_params['attrid']=attrids.join('_');
                }

              on_selected_search(cache_new_params);
            }
        }

    });

</script>