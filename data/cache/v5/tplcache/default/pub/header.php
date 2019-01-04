<?php echo Common::css('header.css',true);?> <?php echo Common::load_skin();?> <?php if($indexpage) { ?> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$data = $ad_tag->getad(array('action'=>'getad','name'=>'HeaderAd','pc'=>'1','row'=>'1',));}?> <?php if(!empty($data)) { ?> <div class="top-column-banner"> <div class="wm-1200"><i class="top-closed"></i></div> <a href="<?php echo $data['adlink'];?>" target="_blank"><img src="<?php echo Common::img($data['adsrc']);?>" title="<?php echo $data['adname'];?>"></a> </div><!--顶部广告--> <?php } ?> <script>
        $(function(){
            $('.top-closed').click(function(){
                $(".top-column-banner").slideUp();
            })
        })
    </script> <?php } ?> <div class="web-top"> <div class="wm-1200"> <div class="notice-txt"><?php echo $GLOBALS['cfg_gonggao'];?></div> <div class="top-login"> <span id="loginstatus"> </span> <a class="dd" href="<?php echo $cmsurl;?>search/order"><i></i><?php echo __('订单查询');?></a> <dl class="dh"> <dt><i></i><?php echo __('网站导航');?></dt> <dd> <?php require_once ("E:/wamp64/www/taglib/channel.php");$channel_tag = new Taglib_Channel();if (method_exists($channel_tag, 'pc')) {$data = $channel_tag->pc(array('action'=>'pc','row'=>'30',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?> <a href="<?php echo $row['url'];?>" title="<?php echo $row['linktitle'];?>"><?php echo $row['title'];?></a> <?php $n++;}unset($n); } ?> </dd> </dl> </div> <div class="scroll-order"> <ul> <?php require_once ("E:/wamp64/www/taglib/comment.php");$comment_tag = new Taglib_Comment();if (method_exists($comment_tag, 'query')) {$data = $comment_tag->query(array('action'=>'query','flag'=>'all','row'=>'3',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?> <li><?php echo $row['nickname'];?><?php echo $row['pltime'];?><?php echo __('评论了');?><?php echo $row['productname'];?></li> <?php $n++;}unset($n); } ?> </ul> </div> </div> </div><!--顶部--> <div class="st-header"> <div class="wm-1200"> <div class="st-logo"> <?php if(!empty($GLOBALS['cfg_logo'])) { ?> <a title="<?php echo $GLOBALS['cfg_logotitle'];?>" href="<?php echo $GLOBALS['cfg_logourl'];?>"><img src="<?php echo Common::img($GLOBALS['cfg_logo']);?>"  alt="logo" /></a> <?php } ?> </div> <?php if(St_Functions::is_normal_app_install('city_site')) { ?> <?php echo Request::factory('city/index')->execute()->body(); ?> <?php } ?> <div class="st-top-search"> <div class="st-search-down"> <strong id="typename"><span class=""></span><i></i></strong> <ul class="st-down-select searchmodel"> <?php $n=1; if(is_array($searchmodel)) { foreach($searchmodel as $m) { ?> <li <?php if($m['issystem']==1) { ?>  data-pinyin="<?php echo $m['pinyin'];?>"  <?php } else { ?>  data-pinyin="general/<?php echo $m['pinyin'];?>" <?php } ?>
 ><?php echo $m['modulename'];?></li> <?php $n++;}unset($n); } ?> </ul> </div> <input type="text" id="st-top-search" class="st-txt searchkeyword" placeholder="<?php echo Model_Global_Search::get_hot_search_default();?>" /> <input type="button" value="<?php echo __('搜索');?>" class="st-btn" /> <span id="dt-top-search-span" class="hide"> <?php require_once ("E:/wamp64/www/taglib/hotsearch.php");$hotsearch_tag = new Taglib_Hotsearch();if (method_exists($hotsearch_tag, 'hot')) {$data = $hotsearch_tag->hot(array('action'=>'hot','row'=>'3',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?> <a href="javascript:;" class="hot_search_key" data-keyword="<?php echo $row['title'];?>"><?php echo $row['title'];?></a> <?php $n++;}unset($n); } ?> </span> <div class="st-hot-dest-box" id="stHotDestBox"> <div class="block-tit"><strong><?php echo __('热门搜索');?></strong><i class="close-ico"></i></div> <div class="block-nr"> <dl> <dt><?php echo __('热搜词');?></dt> <dd class="clearfix"> <?php require_once ("E:/wamp64/www/taglib/hotsearch.php");$hotsearch_tag = new Taglib_Hotsearch();if (method_exists($hotsearch_tag, 'hot')) {$d = $hotsearch_tag->hot(array('action'=>'hot','row'=>'20','return'=>'d',));}?> <?php $n=1; if(is_array($d)) { foreach($d as $row) { ?> <a class="hot_search_key" href="javascript:;" data-keyword="<?php echo $row['title'];?>"><?php echo $row['title'];?></a> <?php $n++;}unset($n); } ?> </dd> </dl> <dl> <dt><?php echo __('目的地');?></dt> <dd class="clearfix"> <?php $destination_tag = new Taglib_Destination();if (method_exists($destination_tag, 'query')) {$data = $destination_tag->query(array('flag'=>'order','action'=>'query','row'=>'20',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?> <a href="<?php echo $GLOBALS['cfg_basehost'];?>/<?php echo $row['pinyin'];?>/" target="_blank"><?php echo $row['kindname'];?></a> <?php $n++;}unset($n); } ?> </dd> </dl> </div> </div><!--热搜框--> <script>
                $(function(){
                    $('#st-top-search').click(function(event){
                        $('#stHotDestBox').show();
                        event.stopPropagation();
                    });
                    $('.close-ico').click(function(event){
                        $('#stHotDestBox').hide();
                        event.stopPropagation();
                    });
                    $('body').click(function(){
                        $('#stHotDestBox').hide();
                    });
                })
            </script> </div> <div class="st-link-way"> <img class="link-way-ico" src="<?php if(empty($GLOBALS['cfg_kefu_icon'])) { ?>/res/images/24hours-ico.png<?php } else { ?><?php echo $GLOBALS['cfg_kefu_icon'];?><?php } ?>
" width="45" height="45" /> <div class="link-way-txt"> <em><?php echo str_replace(array(',',';',':','，'),'<br />',$GLOBALS['cfg_phone']);?></em> </div> </div> </div> </div><!--header--> <div class="st-nav"> <div class="wm-1200"> <div class="st-menu"> <ul class="clearfix"> <li><a href="<?php echo $cmsurl;?>"><?php echo $GLOBALS['cfg_indexname'];?><s></s></a></li> <?php require_once ("E:/wamp64/www/taglib/channel.php");$channel_tag = new Taglib_Channel();if (method_exists($channel_tag, 'pc')) {$data = $channel_tag->pc(array('action'=>'pc','row'=>'20',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?> <li class="nav_header_<?php echo $row['typeid'];?>"> <?php if($row['kind']) { ?> <?php 
                            $src = Common::get_nav_icon($row['kind']);
                            if($src)
                            {
                               echo '<img class="st-nav-icon" src="'.$src.'" />';
                            }
                        ?> <?php } ?> <s></s> <a href="<?php echo $row['url'];?>" title="<?php if(empty($row['linktitle'])) { ?><?php echo $row['title'];?><?php } else { ?><?php echo $row['linktitle'];?><?php } ?>
" > <?php echo $row['title'];?> <?php if(!empty($row['submenu'])) { ?> <i class="st-arrow-ico"></i> <?php } ?> </a> <?php if(!empty($row['submenu'])) { ?> <div class="down-nav"> <div class="sub-list"> <?php $n=1; if(is_array($row['submenu'])) { foreach($row['submenu'] as $submenu) { ?> <a href="<?php echo $submenu['url'];?>"><?php echo $submenu['title'];?></a> <?php $n++;}unset($n); } ?> </div> </div> <?php } ?> </li> <?php $n++;}unset($n); } ?> </ul> </div> </div> </div><!--主导航--> <?php echo Common::js('SuperSlide.min.js');?> <script>
    var SITEURL = "<?php echo $cmsurl;?>";
    $(function(){
        $(".st-search-down").hover(function(){
            $(".st-down-select").show()
        },function(){
            $(".st-down-select").hide()
        });
        $(".searchmodel li").click(function(){
            var pinyin = $(this).attr('data-pinyin');
            var typename = $(this).text();
            $("#typename").html(typename+'<i></i>');
            $("#typename").attr('data-pinyin',pinyin);
            $(".st-down-select").hide()
        });
        $(".searchmodel li:first").trigger('click');
        //search
        $('.st-btn').click(function(){
            var keyword = $.trim($('.searchkeyword').val());
            if(keyword == ''){
                keyword = $('.searchkeyword').attr('placeholder');
                if(keyword=='')
                {
                    $('.searchkeyword').focus();
                    return false;
                }
            }
            var pinyin = $("#typename").attr('data-pinyin');
            var url = SITEURL+'query/'+pinyin+'?keyword='+encodeURIComponent(keyword);
            location.href = url;
        });
        $('.hot_search_key').click(function () {
            var keyword = $(this).attr('data-keyword');
            var pinyin = $("#typename").attr('data-pinyin');
            var url = SITEURL+'query/'+pinyin+'?keyword='+encodeURIComponent(keyword);
            location.href = url;
        });
        //search focus
        var topSearch={};
        topSearch.placeholder=$('#st-top-search').attr('placeholder');
        topSearch.spanHtml=$('#dt-top-search-span').html();
        $('#st-top-search').focus(function(){
            $('#st-top-search').attr('placeholder','');
            $('#dt-top-search-span').html('');
            $(this).keyup(function(event){
                if(event.keyCode ==13){
                    $('.st-btn').click();
                }
            });
        });
        $('#st-top-search').blur(function(){
          if($(this).val()==''){
              $('#st-top-search').attr('placeholder',topSearch.placeholder);
              $('#dt-top-search-span').html(topSearch.spanHtml);
          }
        });
        //导航的选中状态
        $(".st-menu a").each(function(){
            var url= window.location.href;
            url=url.replace('index.php','');
            url=url.replace('index.html','');
            var ulink=$(this).attr("href");
            if(url==ulink)
            {
                $(this).parents("li:first").addClass('active');
            }
        });
        ST.Login.check_login(function (data) {
            if(data.status){
                var msg_new=data.user.has_msg>0?'<s class="point-icon"></s>':'';
                $txt= '<a class="dl" style="padding:0" href="javascript:;"><?php echo __("你好");?>,</a>';
                $txt+= '<a class="dl" href="<?php echo Common::get_main_host();?>/member/">'+data.user.nickname+'</a>';
                $txt+= '<a class="dl" href="javascript:ST.Login.login_out();"><?php echo __("退出");?></a>';
                $txt+='<a class="msg" href="<?php echo Common::get_main_host();?>/member/message/index"><i></i>消息'+msg_new+'</a>';
                //$txt+= '<a class="dl" href="<?php echo $cmsurl;?>member">个人中心</a>';
            }else{
                $txt = '<a class="dl" href="<?php echo Common::get_main_host();?>/member/login"><?php echo __("登录");?></a>';
                $txt+= '<a class="zc" href="<?php echo Common::get_main_host();?>/member/register"><?php echo __("免费注册");?></a>';
            }
            $("#loginstatus").html($txt);
        });
        //二级导航
        var offsetLeft = new Array();
        var windowWidth = $(window).width();
        function get_width(){
            windowWidth = $(window).width();
            //设置"down-nav"宽度为浏览器宽度
            $(".down-nav").width($(window).width());
            $(".st-menu li").hover(function(){
                var liWidth = $(this).width()/2;
                $(this).addClass("this-hover");
                offsetLeft = $(this).offset().left;
                $(this).children(".down-nav").css("left",-offsetLeft);
                offsetLeft = $(this).offset().left;
                //获取当前选中li下的sub-list宽度
                var nav_left = $(this).parents(".wm-1200:first").offset().left;
                var nav_width=$(this).parents(".wm-1200:first").width();
                var nav_right= nav_left+nav_width;
                var sub_list_width = $(this).children(".down-nav").children(".sub-list").width();
                if(sub_list_width>nav_width)
                   sub_list_width=nav_width;
                var sub_list_left=offsetLeft-sub_list_width/2+liWidth;
                var sub_list_right=sub_list_left+sub_list_width;
                $(this).children(".down-nav").children(".sub-list").css("width",sub_list_width);
                $(this).children(".down-nav").children(".sub-list").css("left",sub_list_left);
                if(sub_list_left<nav_left)
                {
                    $(this).children(".down-nav").children(".sub-list").css("left",nav_left);
                }
                if(sub_list_right>nav_right)
                {
                    $(this).children(".down-nav").children(".sub-list").css("left",nav_right-sub_list_width);
                }
               // alert(nav_left);
              /*  var offsetRight = windowWidth-offsetLeft;
                var side_width = (windowWidth - 1200)/2;
                if(sub_list_width > offsetRight){
                    $(this).children(".down-nav").children(".sub-list").css({"right":side_width,"left":offsetLeft-sub_list_width/2+liWidth,"width":"auto"});
                }
                if(side_width > offsetLeft-sub_list_width/2+liWidth){
                    $(this).children(".down-nav").children(".sub-list").css({"right":side_width,"left":side_width,"width":"auto"});
                }
                */
            },function(){
                $(this).removeClass("this-hover");
            });
        };
        $(window).resize(function(){
            get_width();
        });
        get_width();
        //选中导航
        var typeid = "<?php echo $typeid;?>";
        if(typeid!=''){
            $('.nav_header_'+typeid).addClass('active');
        }
        //超出的栏目隐藏
        var maxWidth = 0;
        var primaryMenuLi = $(".st-menu>ul>li");
        for(i=0;i<primaryMenuLi.length;i++){
            maxWidth += $(primaryMenuLi[i]).width();
            if(maxWidth>980){
                $(primaryMenuLi[i]).hide()
            }
        }
    })
</script> <script>
    //全站顶部滚动订单信息
    function AutoScroll(obj) {
        $(obj).find("ul:first").animate({marginTop: "-35px"}, 500, function(){
            $(this).css({ marginTop: "0px" }).find("li:first").appendTo(this);
        });
    }
    $(document).ready(function() {
        var myar = setInterval('AutoScroll(".scroll-order")', 5000)
        $(".scroll-order").hover(function(){
            clearInterval(myar)
        },function(){
            myar = setInterval('AutoScroll(".scroll-order")', 5000)
        }); //当鼠标放上去的时候，滚动停止，鼠标离开的时候滚动开始
    })
    $(function(){
        //顶部网站导航显示隐藏
        var topNavToggle = $('.top-login dl');
        topNavToggle.hover(function(){
            $(this).css({background:'#fff',borderLeft:'1px solid #f9f7f6',borderRight:'1px solid #f9f7f6'});
            $(this).children('dd').slideDown(100)
        },function(){
            $(this).css({background:'none',borderLeft:'1px solid #f9f7f6',borderRight:'1px solid #f9f7f6'});
            $(this).children('dd').slideUp(100)
        });
        //线路首页分类导航
        $('.st-dh-con').hover(function(){
            $(this).children('h3').addClass('hover').next('.st-dh-item').show()
        },function(){
            $(this).children('h3').removeClass('hover').next('.st-dh-item').hide()
        })
    })
</script> <?php echo Common::js('login.js');?>