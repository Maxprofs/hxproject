<?php defined('SYSPATH') or die();?><!doctype html>
<html xmlns="http://www.w3.org/1999/html">
<head right_bottom=ZEybjt >
    <meta charset="utf-8">
    <title><?php echo $search_title;?></title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,reset-style.css,lib-flexible.js');?>
    <?php echo Common::css_plugin('m_ship.css','ship');?>
    <?php echo Common::js('lib-flexible.js,Zepto.js,jquery.min.js,delayLoading.min.js,template.js');?>
</head>
<body>
<?php echo Request::factory("pub/header_new/typeid/$typeid/islistpage/1")->execute()->body(); ?>
    <!-- 公用顶部 -->
    <div class="page-content">
        <div class="st-list-content">
            <ul class="st-list-group" id="result_list">
            </ul>
        </div>
        <div class="no-info-bar no-content-div" style="display: none">没有更多结果了！</div>
        <div class="no-content-page no-content-div" style="display: none">
            <div class="no-content-icon" ></div>
            <p class="no-content-txt">此页面暂无内容</p>
        </div>
    </div>
    <!-- 内容区 -->
<script type="text/html" id="tpl_hotel_item">
    {{each list as value i}}
    <li>
        <a class="item" href="{{value.url}}">
            <div class="pic">
                <img src="{{value.litpic}}" alt="{{value.title}}" />
            </div>
            <div class="info">
                <h4 class="bt">{{value.title}}</h4>
                {{if value.starttime||value.startcity_name}}
                <p class="attr">出发地：{{if value.starttime}}{{value.starttime}}，{{/if}}{{if value.startcity_name}}{{value.startcity_name}}{{/if}}</p>
                {{/if}}
                <p class="data clearfix">
                    {{if value.finaldest_name}}
                <span class="mdd">目的地：{{value.finaldest_name}}</span>
                    {{/if}}
                {{if value.price>0}}
                <span class="price fr"><strong class="no-style"><?php echo Currency_Tool::symbol();?><em class="no-style">{{value.price}}</em></strong>起/人</span>
                {{else}}
                <span class="price fr"><strong class="no-style">电询</strong></span>
                {{/if}}
                </p>
            </div>
        </a>
    </li>
    {{/each}}
</script>
    <div class="foot-menu">
        <div id="dest-item" class="check-item fl">
            <span class="check-hd"><i class="mdd-icon"></i>目的地</span>
        </div>
        <div id="sort-item" class="check-item fl">
            <span class="check-hd"><i class="px-icon"></i>排序</span>
        </div>
        <div id="filter-item" class="check-item fl">
            <span class="check-hd"><i class="sx-icon"></i>筛选</span>
        </div>
    </div>
    <div id="dest-page" class="dest-page">
        <div class="header-top bar-nav">
            <a class="back-link-icon" href="javascript:;"></a>
            <h2 class="page-title-bar">目的地</h2>
        </div>
        <div class="dest-crumbs">
            <a href="javascript:;">目的地</a>
        </div>
        <div class="dest-group">
            <ul class="dest-list">
            </ul>
        </div>
        <div class="control-block">
            <a class="back-btn" href="javascript:;">返回上一级</a>
            <a class="confirm-btn" href="javascript:;">确定</a>
        </div>
    </div>
    <!-- 目的地 -->
    <div id="filter-page" class="filter-page">
        <div class="header-top bar-nav">
            <a class="back-link-icon" href="javascript:;"></a>
            <h2 class="page-title-bar">筛选</h2>
        </div>
        <div class="filter-item">
            <div class="hd">
                <ul id="choose_item">
                    <li class="active"  data-type="startcity">出发地</li>
                    <li data-type="shipid">邮轮</li>
                    <li data-type="shipday">航线天数</li>
                    <li data-type="shipprice">航线价格</li>
                    <?php require_once ("E:/wamp64/www/phone/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$grouplist = $attr_tag->query(array('action'=>'query','flag'=>'grouplist','typeid'=>$typeid,'return'=>'grouplist',));}?>
                    <?php $n=1; if(is_array($grouplist)) { foreach($grouplist as $group) { ?>
                    <li data-type="<?php echo $group['id'];?>"><?php echo $group['attrname'];?></li>
                    <?php $n++;}unset($n); } ?>
                </ul>
            </div>
            <div class="bd" id="choose_ul">
                <ul data-type="startcity">
                    <li  data-id="0">全部<i class="on"></i></li>
                    <?php require_once ("E:/wamp64/www/phone/taglib/startplace.php");$startplace_tag = new Taglib_Startplace();if (method_exists($startplace_tag, 'city')) {$startcitylist = $startplace_tag->city(array('action'=>'city','row'=>'100','return'=>'startcitylist',));}?>
                    <?php $n=1; if(is_array($startcitylist)) { foreach($startcitylist as $city) { ?>
                    <li data-id="<?php echo $city['id'];?>"><?php echo $city['title'];?><i class="on"></i></li>
                    <?php $n++;}unset($n); } ?>
                </ul>
                <ul style="display: none" data-type="shipid">
                    <li  data-id="0">全部<i class="on"></i></li>
                    <?php $ship_tag = new Taglib_Ship();if (method_exists($ship_tag, 'ship')) {$shiplist = $ship_tag->ship(array('action'=>'ship','flag'=>'order','row'=>'100','return'=>'shiplist',));}?>
                    <?php $n=1; if(is_array($shiplist)) { foreach($shiplist as $ship) { ?>
                    <li data-id="<?php echo $ship['id'];?>"><?php echo $ship['title'];?><i class="on"></i></li>
                    <?php $n++;}unset($n); } ?>
                </ul>
                <ul style="display: none" data-type="shipday">
                    <li  data-id="0">全部<i class="on"></i></li>
                    <?php $ship_tag = new Taglib_Ship();if (method_exists($ship_tag, 'day_list')) {$data = $ship_tag->day_list(array('action'=>'day_list',));}?>
                    <?php $n=1; if(is_array($data)) { foreach($data as $r) { ?>
                    <li data-id="<?php echo $r['number'];?>"><?php echo $r['title'];?><i class="on"></i></li>
                    <?php $n++;}unset($n); } ?>
                </ul>
                <ul style="display: none" data-type="shipprice">
                    <li  data-id="0">全部<i class="on"></i></li>
                    <?php $ship_tag = new Taglib_Ship();if (method_exists($ship_tag, 'price_list')) {$data = $ship_tag->price_list(array('action'=>'price_list',));}?>
                    <?php $n=1; if(is_array($data)) { foreach($data as $r) { ?>
                    <li data-id="<?php echo $r['id'];?>"><?php echo $r['title'];?><i class="on"></i></li>
                    <?php $n++;}unset($n); } ?>
                </ul>
                <?php $n=1; if(is_array($grouplist)) { foreach($grouplist as $group) { ?>
                <ul style="display: none" data-type="<?php echo $group['id'];?>" class="attrlist">
                    <?php require_once ("E:/wamp64/www/phone/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$attrlist = $attr_tag->query(array('action'=>'query','flag'=>'childitem','typeid'=>$typeid,'groupid'=>$group['id'],'return'=>'attrlist',));}?>
                    <?php $n=1; if(is_array($attrlist)) { foreach($attrlist as $attr) { ?>
                    <li data-id="<?php echo $attr['id'];?>" <?php if(in_array($attr['id'],$attr_arr)) { ?>class="active"<?php } ?>
><?php echo $attr['attrname'];?><i class="on"></i></li>
                    <?php $n++;}unset($n); } ?>
                </ul>
                <?php $n++;}unset($n); } ?>
            </div>
        </div>
        <div class="control-block">
            <a class="back-btn" href="javascript:;">恢复默认</a>
            <a class="confirm-btn" href="javascript:;">确定</a>
        </div>
    </div>
    <!-- 筛选 -->
    <div id="sort-page" class="sort-page">
        <ul class="sort-group">
            <li  data-id="0">综合排序<em class="ico"></em></li>
            <li data-id="1">价格由低到高<em class="ico"></em></li>
            <li data-id="2">价格由高到低<em class="ico"></em></li>
            <li data-id="3">销量优先<em class="ico"></em></li>
            <li data-id="4">人气推荐<em class="ico"></em></li>
        </ul>
    </div>
    <!-- 排序 -->
    <input type="hidden" id="destpy" value="<?php echo $params['destpy'];?>">
    <input type="hidden" id="dayid" value="<?php echo $params['dayid'];?>">
    <input type="hidden" id="priceid" value="<?php echo $params['priceid'];?>">
    <input type="hidden" id="sorttype" value="<?php echo $params['sorttype'];?>">
    <input type="hidden" id="startcityid" value="<?php echo $params['startcityid'];?>">
    <input type="hidden" id="shipid" value="<?php echo $params['shipid'];?>">
    <input type="hidden" id="attrid" value="<?php echo $params['attrid'];?>">
    <input type="hidden" id="keyword" value="<?php echo $params['keyword'];?>">
    <input type="hidden" id="page" value="<?php echo $params['page'];?>">
    <input type="hidden" id="destid" value="<?php echo $params['destid'];?>">
<?php echo Request::factory('pub/code')->execute()->body(); ?>
<?php echo Common::js('layer/layer.m.js');?>
    <script>
        var intpage = 1;
        $(function () {
            //加载目的地
            get_dest_list();
            //第一次加载数据
             get_data();
            //默认选中
            set_default_params();
            $('.dest-crumbs').on('click','a',function(){
                var destid = $(this).attr('destid');
                var pinyin = $(this).attr('pinyin');
                if(destid!=$('#destid').val())
                {
                    $('#destpy').val(pinyin);
                    $('#destid').val(destid);
                    get_dest_list();
                }
            })
            $('.dest-list').on('click','li',function(){
                var destid = $(this).attr('destid');
                var pinyin = $(this).attr('pinyin');
                var has_sub = $(this).attr('has_sub');
                if(destid!=$('#destid').val())
                {
                    if(has_sub=='more')
                    {
                        $('#destpy').val(pinyin);
                        $('#destid').val(destid);
                        get_dest_list();
                    }
                    else if(has_sub=='on')
                    {
                        $('.dest-list li').removeClass('active')
                        $(this).addClass('active')
                        $('#destpy').val(pinyin);
                        $('#destid').val(destid);
                    }
                }
            })
            //目的地返回上级
            $('#dest-page .back-btn').click(function(){
                var length = $('.dest-crumbs a').length;
                $.each($('.dest-crumbs a'),function(index,obj){
                   if(index+1==length-1)
                   {
                       var destid = $(obj).attr('destid');
                       var pinyin = $(obj).attr('pinyin');
                       if(destid!=$('#destid').val())
                       {
                           $('#destpy').val(pinyin);
                           $('#destid').val(destid);
                           get_dest_list();
                       }
                   }
                })
            });
            //目的地确认
            $('#dest-page .confirm-btn').click(function(){
                $('#page').val(0)
                var url = SITEURL+'ship/'+get_url();
                top.location.href=url
            });
            //默认筛选
            $('#filter-page .back-btn').click(function(){
                $('#choose_ul ul li').removeClass('active');
                $('#attrid').val(0);
                $.each($('#choose_ul ul'),function(index,obj){
                    if(index<4)
                    {
                        $(obj).find('li:first').addClass('active')
                    }
                })
            });
            //确认筛选
            $('#filter-page .confirm-btn').click(function(){
               var startcity = $('#choose_ul ul[data-type=startcity]').find('.active').attr('data-id');
               var shipid = $('#choose_ul ul[data-type=shipid]').find('.active').attr('data-id');
               var shipday = $('#choose_ul ul[data-type=shipday]').find('.active').attr('data-id');
               var shipprice = $('#choose_ul ul[data-type=shipprice]').find('.active').attr('data-id');
                $('#startcityid').val(startcity);
                $('#dayid').val(shipday);
                $('#shipid').val(shipid);
                $('#priceid').val(shipprice);
                $('#page').val(0)
                var url = SITEURL+'ship/'+get_url();
                top.location.href=url
            })
            //排序
            $('.sort-group li').click(function(){
                var sorttype = $(this).attr('data-id');
                $('#sorttype').val(sorttype)
                $('#page').val(0)
                var url = SITEURL+'ship/'+get_url();
                top.location.href=url
            });
            $('#choose_item li').click(function(){
                var data_type= $(this).attr('data-type');
                $('#choose_item li').removeClass('active');
                $(this).addClass('active');
                $('#choose_ul ul').hide();
                $('#choose_ul ul[data-type='+data_type+']').show();
            })
            $('#dest-page .back-link-icon,#filter-page .back-link-icon').click(function(){
                $('#dest-page,#filter-page').hide();
            })
            $(".page-content").scroll(function(){
                var scroll_top=$('.page-content').scrollTop();
                if(scroll_top+3>=($(".page-content")[0].scrollHeight - $('.page-content').outerHeight()))
                {
                    var page = $("#page").val();
                    if(page=='-1')
                    {
                        return false;
                    }
                    var page2=parseInt(page)+1;
                    $("#page").val(page2);
                    get_data();
                   // get_line_list(init_page+1);
                }
            });
            //头部下拉导航
            $(".st-user-menu").on("click",function(){
                $(".header-menu-bg,.st-down-bar").show();
                $("body").css("overflow","hidden")
            });
            $(".header-menu-bg").on("click",function(){
                $(".header-menu-bg,.st-down-bar").hide();
                $("body").css("overflow","auto")
            });
            $("html,body").css("height","100%");
            //排序
            $(".sort-group > li").on("click",function(){
                $(this).addClass("active").siblings().removeClass("active");
            });
            $("#sort-page").on("click",function(){
                $(this).hide()
            });
            $("#sort-item").on("click",function(){
                $(".sort-page").show();
                $("#dest-page").hide();
                $("#filter-page").hide();
            });
            //目的地选择
            $("#dest-item").on("click",function(){
                $("#dest-page").show();
                $("#sort-page").hide();
                $("#filter-page").hide();
            });
            $(".dest-list > li").on("click",function(){
                if( $(this).children("i").hasClass("on") )
                {
                    $(this).addClass("active").siblings().removeClass("active")
                }
            });
            //筛选
            $("#filter-item").on("click",function(){
                $("#filter-page").show();
                $("#dest-page").hide();
                $("#sort-page").hide();
            });
            $(".filter-item .bd li").on("click",function(){
                $(this).addClass("active").siblings().removeClass("active")
            })
        })
        //初始化筛选项目
        function set_default_params()
        {
            var sorttype = $('#sorttype').val();
            $('.sort-group li[data-id='+sorttype+']').addClass('active');
            var startcityid = $('#startcityid').val();
            var shipid = $('#shipid').val();
            var priceid = $('#priceid').val();
            var dayid = $('#dayid').val();
            $('#choose_ul ul[data-type=startcity]').find('li[data-id='+startcityid+']').addClass('active');
            $('#choose_ul ul[data-type=shipid]').find('li[data-id='+shipid+']').addClass('active');
            $('#choose_ul ul[data-type=shipprice]').find('li[data-id='+priceid+']').addClass('active');
            $('#choose_ul ul[data-type=shipday]').find('li[data-id='+dayid+']').addClass('active');
        }
        //获取list地址
        function get_url() {
            //获取选中的目的地
            var url = $("#destpy").val();
            //获取dayid
            var dayid = $("#dayid").val();
            //获取priceid
            var priceid = $("#priceid").val();
            //startcityid
            var startcityid = $("#startcityid").val();
            var shipid = $('#shipid').val();
            //获取选中的属性
            var attr = [];
            $('.attrlist .active').each(function (i, obj) {
                attr.push($(this).attr('data-id'));
            })
            var attrid = $("#attrid").val();
            if (attr.length > 0) {
                attrid = attr.join('_');
            }
            //排序规则
            var sorttype = $("#sorttype").val();
            //搜索名称
            var keyword = $('#keyword').val();
            //当前页 page
            var page = $("#page").val();
            keyword = keyword == '' ? 0 : keyword;
            url += '-' + dayid + '-' + priceid + '-' + sorttype + '-' + startcityid+'-'+shipid + '-' + attrid + '-' + page;
            if (keyword != 0) {
                url += '?keyword=' + keyword;
            }
            return url;
        }
        function get_data()
        {

            if($("#page").val()=='-1'||intpage==0)
            {

                return false;
            }
            intpage = 0;
            var paramUrl = get_url();
            var url = SITEURL + 'ship/ajax_line_more/' + paramUrl;
           
            $.getJSON(url, {}, function (data) {
                intpage = 1
                if (data.list.length > 0)
                {
                    $('.no-content-div').hide();
                    var itemHtml = template('tpl_hotel_item', data);
                    $("#result_list").append(itemHtml);
                }
                else
                {
                    $('.no-content-div').show();
                }
                $('#page').val(data.page);
                
            })
        }
        //设置目的地
        function get_dest_list()
        {
            var destid = $('#destid').val();
            $.ajax({
                type:'post',
                dataType:'json',
                url:SITEURL+'ship/ajax_get_dest_rel',
                data:{destid:destid},
                success:function(data)
                {
                    var parent_html = ' <a href="javascript:;" pinyin="all" destid="0">目的地</a>'
                    if(data.parent&&data.parent.pinyin!='all')
                    {
                        parent_html += '<a href="javascript:;" pinyin="'+data.parent.pinyin+'" destid="'+data.parent.id+'">'+data.parent.kindname+'</a>'
                    }
                    if(data.current.pinyin!='all')
                    {
                        parent_html += '<a href="javascript:;" pinyin="'+data.current.pinyin+'" destid="'+data.current.id+'">'+data.current.kindname+'</a>'
                    }
                    $('.dest-crumbs').html(parent_html);
                    if(data.sub_list)
                    {
                        var sub_html = '';
                        $.each(data.sub_list,function(index,obj)
                        {
                            if(obj.has_sub==true)
                            {
                                var iclass= 'more';
                            }
                            else
                            {
                                var iclass = 'on';
                            }
                            sub_html += '<li has_sub="'+iclass+'" pinyin="'+obj.pinyin+'" destid="'+obj.id+'">'+obj.kindname+'<i class="'+iclass+'"></i></li>';
                        });
                        $('.dest-list').html(sub_html);
                    }
                }
            });
        }
    </script>
</body>
</html>