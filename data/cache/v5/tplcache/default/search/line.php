<!doctype html> <html> <head> <meta charset="utf-8"> <title><?php echo $params['keyword'];?>__搜索结果-<?php echo $webname;?></title> <?php echo Common::css('header.css,base.css');?> <?php echo Common::css_plugin('cloud_search.css','global_search');?> <?php echo Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js');?> </head> <body> <?php echo  Stourweb_View::template("pub/search_header");  ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="/">首页</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;
                <a href="javascript:;"><?php echo $shortname;?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;
                <?php echo $params['keyword'];?> </div> <!-- 面包屑 --> <div class="search-type-block"> <?php if($search_items) { ?> <div class="search-type-item clearfix choose_items_box"> <strong class="item-hd">已选条件：</strong> <div class="item-bd"> <div class="item-check"> <?php $n=1; if(is_array($search_items)) { foreach($search_items as $item) { ?> <a class="chick-child"  data-id="<?php echo $item['id'];?>"  data-type="<?php echo $item['type'];?>"   href="javascript:;"><?php echo $item['attrname'];?><i class="closed"></i></a> <?php $n++;}unset($n); } ?> <a class="clear-item"  onclick="change_search()" href="javascript:;">清空筛选条件</a> </div> </div> </div> <?php } ?> <div class="search-type-item clearfix"> <strong class="item-hd">相关目的地：</strong> <div class="item-bd"> <div class="item-child"> <div class="child-block"> <ul class="child-list"> <?php $n=1; if(is_array($destlist)) { foreach($destlist as $dest) { ?> <li class="item" ><a href="javascript:;" class="choose_dest <?php if($dest['id']==$params['destid']) { ?> active<?php } ?>
" data-id="<?php echo $dest['id'];?>" ><?php echo $dest['kindname'];?></a></li> <?php $n++;}unset($n); } ?> </ul> <?php if(count($destlist)>8) { ?> <a class="arrow down" href="javascript:;">展开</a> <?php } ?> </div> </div> </div> </div> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$grouplist = $attr_tag->query(array('action'=>'query','flag'=>'grouplist','typeid'=>$typeid,'return'=>'grouplist',));}?> <?php $index=1;?> <?php $n=1; if(is_array($grouplist)) { foreach($grouplist as $group) { ?> <div class="search-type-item clearfix <?php if($index>4) { ?> hide<?php } ?>
"> <strong class="item-hd"><?php echo $group['attrname'];?>：</strong> <div class="item-bd"> <div class="item-child"> <div class="child-block"> <ul class="child-list"> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$attrlist = $attr_tag->query(array('action'=>'query','flag'=>'childitem','typeid'=>$typeid,'groupid'=>$group['id'],'return'=>'attrlist',));}?> <?php $n=1; if(is_array($attrlist)) { foreach($attrlist as $attr) { ?> <li class="item" ><a  class="choose_attr <?php if(in_array($attr['id'],$attr_list)) { ?> active<?php } ?>
" data-id="<?php echo $attr['id'];?>"   href="javascript:;" ><?php echo $attr['attrname'];?></a></li> <?php $n++;}unset($n); } ?> </ul> <?php if(count($attrlist)>8) { ?> <a class="arrow down" href="javascript:;">展开</a> <?php } ?> </div> </div> </div> </div> <?php $index++;?> <?php $n++;}unset($n); } ?> <div class="search-type-item clearfix <?php if(count($grouplist)>3) { ?> hide<?php } ?>
"> <strong class="item-hd">出游天数：</strong> <div class="item-bd"> <div class="item-child"> <div class="child-block"> <ul class="child-list"> <?php $line_tag = new Taglib_Line();if (method_exists($line_tag, 'day_list')) {$data = $line_tag->day_list(array('action'=>'day_list',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $r) { ?> <li class="item" ><a  class="choose_days <?php if($r['id']==$params['dayid']) { ?> active<?php } ?>
" data-id="<?php echo $r['id'];?>"   href="javascript:;" ><?php echo $r['title'];?></a></li> <?php $n++;}unset($n); } ?> </ul> <?php if(count($day_list)>8) { ?> <a class="arrow down" href="javascript:;">展开</a> <?php } ?> </div> </div> </div> </div> <div class="search-type-item clearfix <?php if(count($grouplist)>2) { ?> hide<?php } ?>
"> <strong class="item-hd">价格区间：</strong> <div class="item-bd"> <div class="item-child"> <div class="child-block"> <ul class="child-list"> <?php $line_tag = new Taglib_Line();if (method_exists($line_tag, 'price_list')) {$data = $line_tag->price_list(array('action'=>'price_list',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $r) { ?> <li class="item" ><a  class="choose_price <?php if($r['id']==$params['priceid']) { ?> active<?php } ?>
" data-id="<?php echo $r['id'];?>"   href="javascript:;" ><?php echo $r['title'];?></a></li> <?php $n++;}unset($n); } ?> </ul> <?php if(count($data)>8) { ?> <a class="arrow down" href="javascript:;">展开</a> <?php } ?> </div> </div> </div> </div> <?php if(count($grouplist)>3) { ?> <a href="javascript:;" id="searchConsoleBtn" class="search-console-btn down">展开更多搜索</a> <?php } ?> </div> <!-- 搜索条件 --> <?php if($list) { ?> <div class="search-results-container"> <ul class="search-results-list"> <?php $n=1; if(is_array($list)) { foreach($list as $l) { ?> <li class="clearfix"> <div class="hd"> <a target="_blank" href="<?php echo $l['url'];?>" class="pic"> <img src="<?php echo Product::get_lazy_img();?>"  st-src="<?php echo Common::img($l['litpic'],200,136);?>" alt="<?php echo $l['title'];?>" title="<?php echo $l['title'];?>" width="200" height="136" /> </a> </div> <div class="info"> <a class="tit" target="_blank" href="<?php echo $l['url'];?>"><?php echo $l['title'];?></a> <div class="txt"> <?php echo $l['sellpoint'];?> </div> <div class="attr"> <?php $n=1; if(is_array($l['attrlist'])) { foreach($l['attrlist'] as $attr) { ?> <span class="item"><?php echo $attr['attrname'];?></span> <?php $n++;}unset($n); } ?> </div> <div class="label"> <span class="item">产品编号：<?php echo $l['series'];?></span> <?php if($l['suppliername']) { ?> <span class="item"><?php echo $l['suppliername'];?></span> <?php } ?> </div> </div> <div class="sum"> <?php if($l['price']) { ?> <span class="pri"><?php echo Currency_Tool::symbol();?><b class="num"><?php echo $l['price'];?></b>起</span> <?php } else { ?> <span class="pri"><b class="dx">电询</b></span> <?php } ?> <?php if($l['storeprice']) { ?> <span class="del">原价：<?php echo Currency_Tool::symbol();?><?php echo $l['storeprice'];?></span> <?php } ?> <?php if($l['satisfyscore']) { ?> <span class="myd">满意度：<b class="num"><?php echo $l['satisfyscore'];?></b>%</span> <?php } ?> </div> </li> <?php $n++;}unset($n); } ?> </ul> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div> </div> <?php } else { ?> <div class="no-content"> <p><i></i>抱歉，没有找到符合条件的内容！</p> </div> <?php } ?> <!-- 搜索列表 --> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <script>
        var pinyin = '<?php echo $params['pinyin'];?>';
        var search_keyword = '<?php echo $params['keyword'];?>';
        $(function(){
            search_init();
            //选择模块
            $('.choose_model').click(function () {
                if(!$(this).hasClass('active'))
                {
                    pinyin = $(this).attr('data-pinyin');
                    change_search();
                }
            });
            //选择目的地
            $('.choose_dest').click(function () {
                 $('.choose_dest').removeClass('active');
                 $(this).addClass('active');
                 go_search();
            });
            //选择属性
            $('.choose_attr').click(function () {
                $(this).parents('.child-list').find('.choose_attr').removeClass('active')
                $(this).addClass('active');
                go_search();
            });
            //选择出游天数
            $('.choose_days').click(function () {
                $(this).parents('.child-list').find('.choose_days').removeClass('active')
                $(this).addClass('active');
                go_search();
            });
            //选择价格区间
            $('.choose_price ').click(function () {
                $(this).parents('.child-list').find('.choose_price').removeClass('active')
                $(this).addClass('active');
                go_search();
            });
            //取消筛选
            $('.chick-child .closed').click(function () {
                var type = $(this).parent().attr('data-type');
                var id = $(this).parent().attr('data-id');
                $(this).parent().remove();
                $('.choose_'+type).each(function () {
                    if($(this).attr('data-id')==id)
                    {
                        $(this).removeClass('active');
                    }
                });
                go_search();
            });
            //搜索条件
            $(".arrow").on("click",function(){
                if( $(this).hasClass("down") )
                {
                    $(this).removeClass("down").addClass("up");
                    $(this).text("收起");
                    $(this).prev(".child-list").css("height","auto")
                }
                else
                {
                    $(this).removeClass("up").addClass("down");
                    $(this).text("展开");
                    $(this).prev(".child-list").css("height","24px")
                }
            });
            $("#searchConsoleBtn").on("click",function(){
                if( $(this).hasClass("down") ){
                    $('.search-type-item').removeClass('hide');
                    $(this).removeClass("down").addClass("up").text("收起")
                }
                else
                {
                    var num = 0 ;
                    $('.search-type-item').each(function (index,obj) {
                        if(!$(obj).hasClass('choose_items_box'))
                        {
                            num++;
                        }
                        if(num>5)
                        {
                            $(obj).addClass('hide')
                        }
                    });
                    $(this).removeClass("up").addClass("down").text("展开更多搜索")
                }
            })
        });
        
        //属性，目的地搜索
        function go_search()
        {
            var destid = 0;
            var dayid = 0 ;
            var priceid = 0 ;
            var attrlist = [];
            $('.choose_dest').each(function () {
                if($(this).hasClass('active'))
                {
                    destid = $(this).attr('data-id');
                }
            });
            $('.choose_attr').each(function () {
                if($(this).hasClass('active'))
                {
                    var  attr = $(this).attr('data-id');
                    attrlist.push(attr);
                }
            });
            $('.choose_days').each(function () {
                if($(this).hasClass('active'))
                {
                    dayid = $(this).attr('data-id');
                }
            });
            $('.choose_price').each(function () {
                if($(this).hasClass('active'))
                {
                    priceid = $(this).attr('data-id');
                }
            });
            attrlist = attrlist.join('_');
            if(!attrlist)
            {
                attrlist = 0;
            }
            var url = SITEURL+'query/'+pinyin+'-'+destid+'-'+dayid+'-'+priceid+'-'+attrlist+'?keyword='+search_keyword;
            window.location.href= url;
        }
        //切换筛选模块或者关键词
        function  change_search()
        {
            $('.choose_dest,.choose_attr').removeClass('active');
            $('.choose_items_box').remove();
            var url = SITEURL+'query/'+pinyin+'?keyword='+search_keyword;
            window.location.href= url;
        }
        //页面初始化
        function search_init()
        {
            $('.choose_model').each(function ()
            {
                if($(this).attr('data-pinyin')==pinyin)
                {
                    $(this).addClass('active');
                }
            });
            $('.searchmodel li').each(function () {
                if($(this).attr('data-pinyin')==pinyin)
                {
                    $(this).trigger('click');
                }
            });
            $('#st-top-search').val(search_keyword);
        }
    </script> </body> </html>
