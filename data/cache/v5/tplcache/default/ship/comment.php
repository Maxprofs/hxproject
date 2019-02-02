<?php defined('SYSPATH') or die();?> <!-- 客户点评 --> <?php echo Common::css("jquery.fancybox.css");?> <?php echo Common::js("jquery.fancybox.js");?> <div class="ship-show-block" id="comment_target"> <div class="column-tit">客户点评</div> <div class="column-block"> <div class="st-list-pl"> <div class="st-pl-box"> <?php require_once ("E:/wamp64/www/taglib/comment.php");$comment_tag = new Taglib_Comment();if (method_exists($comment_tag, 'get_count')) {$count = $comment_tag->get_count(array('action'=>'get_count','typeid'=>$typeid,'articleid'=>$info['id'],'return'=>'count',));}?> <span class="myd" data-myd="<?php echo $count['satisfyscore'];?>">满意度<strong><?php echo $count['satisfyscore'];?></strong></span> <span class="txt">回程归来发表点评即可获赠积分，积分根据线路而定，<br />获得的积分可在下次消费时抵用部分现金。</span> <a class="pl-btn" href="<?php echo $cmsurl;?>member">我要评论 </a> </div> <?php if($count['total']>0) { ?> <div class="st-comment-block"> <div class="comment-nav"> <span class="on" data-flag="all">全部点评<em>(<?php echo $count['total'];?>)</em></span> <span data-flag="pic">有图<em>(<?php echo $count['picnum'];?>)</em></span> <span data-flag="well">好评<em>(<?php echo $count['wellnum'];?>)</em></span> <span data-flag="mid">中评<em>(<?php echo $count['midnum'];?>)</em></span> <span data-flag="bad">差评<em>(<?php echo $count['badnum'];?>)</em></span> </div> <div class="comment-con clearfix"> <?php require_once ("E:/wamp64/www/taglib/comment.php");$comment_tag = new Taglib_Comment();if (method_exists($comment_tag, 'query')) {$data = $comment_tag->query(array('action'=>'query','typeid'=>$typeid,'row'=>'5','articleid'=>$info['id'],));}?> <?php $n=1; if(is_array($data)) { foreach($data as $c) { ?> <dl> <dt> <img src="<?php echo $c['litpic'];?>"> <span><?php echo Common::cutstr_html($c['nickname'],9);?></span> <em class="level"><?php echo Common::member_rank($c['memberid'],array('return'=>'current'));?></em> </dt> <dd> <div class="zs"> <span class="grade"><i style="width: <?php echo $c['percent'];?>"></i></span> <span class="jf"><?php echo $c['jifencomment'];?>分<i></i></span> </div> <div class="txt"><?php echo $c['content'];?></div> <?php if(!empty($c['piclist'])) { ?> <div class="plImgBox clearfix"> <?php $n=1; if(is_array($c['piclist'])) { foreach($c['piclist'] as $pic) { ?> <a class="fancybox" href="<?php echo $pic;?>" data-fancybox-group="gallery"> <img src="<?php echo Common::img($pic,86,86);?>" width="86px" height="86px"> </a> <?php $n++;}unset($n); } ?> </div> <?php } ?> <div class="date"><?php echo Common::mydate('Y-m-d',$c['addtime']);?></div> </dd> </dl> <?php $n++;}unset($n); } ?> </div> <div class="main_mod_page clear"></div> </div> <?php } ?> </div> </div> </div> <script type="text/html" id="tpl_user_comment">
    {{each list as value i}}
    <dl> <dt> <img src="{{value.litpic}}"> <span>{{value.nickname}}</span> <em class="level">{{value.level}}</em> </dt> <dd> <div class="zs"> <span class="grade"><i style="width: {{value.percent}}"></i></span> <span class="jf">{{value.jifencomment}}分<i></i></span> </div> <div class="txt">{{value.content}}</div>
            {{if value.piclist}}
            <div class="plImgBox clearfix">
                {{include 'tpl_user_comment_pic' value}}
            </div>
            {{/if}}
            <div class="date">{{value.addtime}}</div> </dd> </dl>
    {{/each}}
</script> <script type="text/html" id="tpl_user_comment_pic">
    {{each piclist as pic i}}
    <a class="fancybox" href="{{pic}}" data-fancybox-group="gallery"> <img src="{{picthumb[i]}}" width="86px" height="86px"> </a>
    {{/each}}
</script> <script>
    $(function(){
        init_fancybox();
        //分页功能
        $(".comment-nav span").click(function(){
            if($(this).hasClass("on"))
            {
                return;
            }
            else
            {
                $(this).addClass("on").siblings().removeClass("on");
                get_comment_list(1);
            }
        });
        //初始化分页
        gen_pager(<?php echo $count['total'];?>,1,5);
        //检测layer是否加载
        if(typeof(layer)=='undefined')
        {
            $.getScript("/res/js/layer/layer.js")
        }
        //判断template是否加载
        if(typeof(template)=='undefined')
        {
            $.getScript("/res/js/template.js")
        }
        //满意度设置
        var myd = $(".st-list-pl .st-pl-box .myd").attr("data-myd");
        if(myd)
        {
            $(".cp-show-msg .sl .myd").html("满意度："+myd);
        }
    });
    //获取评论列表
    function get_comment_list(pageno)
    {
        var index = layer.load(2, {time: 10*1000});
        var flag = $(".comment-nav span.on").attr("data-flag");
        $.ajax({
            type:'POST',
            aysnc:true,
            url:SITEURL+'comment/ajax_get_pinlun',
            data:{
                typeid:<?php echo $typeid;?>,
                flag:flag,
                articleid:<?php echo $info['id'];?>,
                pageno:pageno
            },
            dataType:'json',
            success:function(data){
                //console.info(data);
                var html = "";
                $(".comment-con").html(html);
                if(data.list.length>0){
                    html = template('tpl_user_comment',data);
                    $(".comment-con").html(html);
                    init_fancybox();
                    gen_pager(data.total,data.pageno,data.pagesize)
                }
                else
                {
                    $(".main_mod_page").html('');
                }
            }
        })
        layer.close(index);
    }
    //初始化图片查看功能
    function init_fancybox(){
        $(".comment-con .plImgBox").each(function(){
            var cls = "fancybox_"+Math.floor(Math.random()*10000);
            $(this).find("a").addClass(cls);
            $("."+cls).fancybox({
                'overlayShow'   :   false,
                'showNavArrows' : true
            });
        });
    }
    //生成分页
    function gen_pager(total, pageno, pagesize)
    {
        $(".main_mod_page").html('');
        //分页不够不显示分页
        if(total<=pagesize)
        {
            return;
        }
        var page_count = Math.ceil(total/pagesize);
        var start_page = pageno - 2;
        var end_page = pageno + 2;
        //var seed = 5-1;
        if(start_page <= 0)
        {
            var num = end_page + Math.abs(start_page) + 1;
            if (num <= page_count)
            {
                end_page = num;
            }
            else
            {
                end_page = page_count;
            }
            start_page = 1;
        }
        if(end_page >= page_count)
        {
            var num = start_page - (end_page-page_count);
            if (num >= 1)
            {
                start_page = num;
            }
            else
            {
                start_page = 1;
            }
            end_page = page_count;
        }
        var pager = '<p class="page_right">';
        if(pageno > 1)
        {
            pager += '<a class="back-first" title="第一页" href="#" data-pageno="1"></a>' +
                '<a class="prev" title="上一页" href="#" data-pageno="'+(pageno-1)+'"></a>'
        }
        pager += '<span class="mod_pagenav_count">';
        for(var i=start_page; i<=end_page; i++)
        {
            var cls = pageno == i ? 'class="current"' : '';
            pager += '<a title="第'+i+'页" '+cls+' href="#" data-pageno="'+i+'">'+i+'</a>';
        }
        pager += '</span>';
        if(pageno < page_count)
        {
            pager +='<a class="next" title="下一页" href="#" data-pageno="'+(pageno+1)+'"></a>' +
                '<a class="go-last" title="尾页" href="#" data-pageno="'+page_count+'"></a>';
        }
        pager += '</p>';
        $(".main_mod_page").html(pager);
        bind_pager_click();
    }
    //绑定分页点击事件
    function bind_pager_click()
    {
        $(".main_mod_page a").click(function(e){
            e.preventDefault();
            var pageno = $(this).attr("data-pageno");
            get_comment_list(pageno);
        });
    }
</script> <!-- 客户点评 -->