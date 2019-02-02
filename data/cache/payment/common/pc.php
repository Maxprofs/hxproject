<!doctype html> <html> <head> <meta charset="utf-8"> <title> <stourweb_title/>-笛卡旅游 </title> <stourweb_header/> <link type="text/css" href="/res/css/base.css" rel="stylesheet" />
 <script type="text/javascript" src="/res/js/jquery.min.js"></script>
<script type="text/javascript" src="/res/js/base.js"></script>
<script type="text/javascript" src="/res/js/common.js"></script>
 </head> <body> <link type="text/css" href="/res/css/header.css" rel="stylesheet" />
 <link type="text/css" href="/res/css/skin.css" rel="stylesheet"  />
  <div class="web-top"> <div class="wm-1200"> <div class="notice-txt"><p><span style="color: #808080">笛卡CMS系统，用于快速建设旅游网站<a href="http://www.deccatech.cn">www.deccatech.cn</a>，电话：028-87036601</span></p></div> <div class="top-login"> <span id="loginstatus"> </span> <a class="dd" href="/search/order"><i></i>订单查询</a> <dl class="dh"> <dt><i></i>网站导航</dt> <dd>   <a href="http://www.deccatech.cn/destination/" title="目的地">目的地</a>  <a href="http://www.deccatech.cn/lines/" title="">线路</a>  <a href="http://www.deccatech.cn/hotels/" title="">酒店</a>  <a href="http://www.deccatech.cn/spots/" title="">景点</a>  <a href="http://www.deccatech.cn/visa/" title="">签证</a>  <a href="http://www.deccatech.cn/cars/" title="">租车</a>  <a href="http://www.deccatech.cn/ship/" title="邮轮">邮轮</a>  <a href="http://www.deccatech.cn/customize/" title="">定制旅行</a>  <a href="http://www.deccatech.cn/zt/" title="专题">专题</a>  <a href="http://www.deccatech.cn/photos/" title="">相册</a>  <a href="http://www.deccatech.cn/notes/" title="">游记</a>  <a href="http://www.deccatech.cn/raiders/" title="">攻略</a>  </dd> </dl> </div> <div class="scroll-order"> <ul>   </ul> </div> </div> </div><!--顶部--> <div class="st-header"> <div class="wm-1200"> <div class="st-logo">  <a title="笛卡旅游" href="http://www.deccatech.cn"><img src="/uploads/2018/1226/a1671a752aa7d2d5e563796c6f90110c.png"  alt="logo" /></a>  </div>  <div class="st-top-search"> <div class="st-search-down"> <strong id="typename"><span class=""></span><i></i></strong> <ul class="st-down-select searchmodel">  <li   data-pinyin="line"   >线路</li>  <li   data-pinyin="hotel"   >酒店</li>  <li   data-pinyin="spot"   >景点</li>  <li   data-pinyin="visa"   >签证</li>  <li   data-pinyin="car"   >租车</li>  <li   data-pinyin="ship_line"   >邮轮</li>  <li   data-pinyin="photo"   >相册</li>  <li   data-pinyin="notes"   >游记</li>  <li   data-pinyin="article"   >攻略</li>  </ul> </div> <input type="text" id="st-top-search" class="st-txt searchkeyword" placeholder="九寨沟旅游" /> <input type="button" value="搜索" class="st-btn" /> <span id="dt-top-search-span" class="hide">   <a href="javascript:;" class="hot_search_key" data-keyword="九寨沟旅游">九寨沟旅游</a>  <a href="javascript:;" class="hot_search_key" data-keyword="峨眉二日游">峨眉二日游</a>  </span> <div class="st-hot-dest-box" id="stHotDestBox"> <div class="block-tit"><strong>热门搜索</strong><i class="close-ico"></i></div> <div class="block-nr"> <dl> <dt>热搜词</dt> <dd class="clearfix">   <a class="hot_search_key" href="javascript:;" data-keyword="九寨沟旅游">九寨沟旅游</a>  <a class="hot_search_key" href="javascript:;" data-keyword="峨眉二日游">峨眉二日游</a>  </dd> </dl> <dl> <dt>目的地</dt> <dd class="clearfix">   <a href="http://www.deccatech.cn/zhoubianlvyou/" target="_blank">周边旅游</a>  <a href="http://www.deccatech.cn/jingnalvyou/" target="_blank">境内旅游</a>  <a href="http://www.deccatech.cn/tesezhuti/" target="_blank">特色主题</a>  <a href="http://www.deccatech.cn/kandaxiongmiao/" target="_blank">看大熊猫</a>  <a href="http://www.deccatech.cn/xianggangaomentaiwan/" target="_blank">香港 澳门 台湾</a>  <a href="http://www.deccatech.cn/dongbeiya/" target="_blank">东北亚</a>  <a href="http://www.deccatech.cn/dongnanyananya/" target="_blank">东南亚 南亚</a>  <a href="http://www.deccatech.cn/ouzhou/" target="_blank">欧洲</a>  <a href="http://www.deccatech.cn/meizhou/" target="_blank">美洲</a>  <a href="http://www.deccatech.cn/aoxinzhongdongfeizhou/" target="_blank">澳新 中东非洲</a>  </dd> </dl> </div> </div><!--热搜框--> <script>
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
            </script> </div> <div class="st-link-way"> <img class="link-way-ico" src="/res/images/24hours-ico.png" width="45" height="45" /> <div class="link-way-txt"> <em>028-87036601</em> </div> </div> </div> </div><!--header--> <div class="st-nav"> <div class="wm-1200"> <div class="st-menu"> <ul class="clearfix"> <li><a href="/">首页<s></s></a></li>   <li class="nav_header_12">  <s></s> <a href="http://www.deccatech.cn/destination/" title="目的地" > 目的地  </a>  </li>  <li class="nav_header_1">  <img class="st-nav-icon" src="/res/images/nav/jingxuan.png" />  <s></s> <a href="http://www.deccatech.cn/lines/" title="线路" > 线路  </a>  </li>  <li class="nav_header_2">  <s></s> <a href="http://www.deccatech.cn/hotels/" title="酒店" > 酒店  </a>  </li>  <li class="nav_header_5">  <s></s> <a href="http://www.deccatech.cn/spots/" title="景点" > 景点  </a>  </li>  <li class="nav_header_8">  <s></s> <a href="http://www.deccatech.cn/visa/" title="签证" > 签证  </a>  </li>  <li class="nav_header_3">  <s></s> <a href="http://www.deccatech.cn/cars/" title="租车" > 租车  </a>  </li>  <li class="nav_header_104">  <s></s> <a href="http://www.deccatech.cn/ship/" title="邮轮" > 邮轮  </a>  </li>  <li class="nav_header_14">  <s></s> <a href="http://www.deccatech.cn/customize/" title="定制旅行" > 定制旅行  </a>  </li>  <li class="nav_header_">  <s></s> <a href="http://www.deccatech.cn/zt/" title="专题" > 专题  </a>  </li>  <li class="nav_header_6">  <s></s> <a href="http://www.deccatech.cn/photos/" title="相册" > 相册  </a>  </li>  <li class="nav_header_101">  <s></s> <a href="http://www.deccatech.cn/notes/" title="游记" > 游记  </a>  </li>  <li class="nav_header_4">  <s></s> <a href="http://www.deccatech.cn/raiders/" title="攻略" > 攻略  </a>  </li>  </ul> </div> </div> </div><!--主导航--> <script type="text/javascript" src="/res/js/SuperSlide.min.js"></script>
 <script>
    var SITEURL = "/";
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
                $txt= '<a class="dl" style="padding:0" href="javascript:;">你好,</a>';
                $txt+= '<a class="dl" href="http://www.deccatech.cn/member/">'+data.user.nickname+'</a>';
                $txt+= '<a class="dl" href="javascript:ST.Login.login_out();">退出</a>';
                $txt+='<a class="msg" href="http://www.deccatech.cn/member/message/index"><i></i>消息'+msg_new+'</a>';
                //$txt+= '<a class="dl" href="/member">个人中心</a>';
            }else{
                $txt = '<a class="dl" href="http://www.deccatech.cn/member/login">登录</a>';
                $txt+= '<a class="zc" href="http://www.deccatech.cn/member/register">免费注册</a>';
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
        var typeid = "";
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
</script> <script type="text/javascript" src="/res/js/login.js"></script>
 <div class="big"> <div class="wm-1200"> <stourweb_pay_content/> </div> </div> <stourweb_content/> <link type="text/css" href="/res/css/footer.css" rel="stylesheet" />
 <link type="text/css" href="/res/css/skin.css" rel="stylesheet"  />
 <div class="st-brand"> <div class="wm-1200"> <div class="st-serve"> <dl class="ico01 bor_0"> <dt></dt> <dd> <em>阳光价格</em> <span>同类产品，保证低价</span> </dd> </dl> <dl class="ico02"> <dt></dt> <dd> <em>阳光行程</em> <span>品质护航，透明公开</span> </dd> </dl> <dl class="ico03"> <dt></dt> <dd> <em>阳光服务</em> <span>专属客服，快速响应</span> </dd> </dl> <dl class="ico04"> <dt></dt> <dd> <em>救援保障</em> <span>途中意外，保证援助</span> </dd> </dl> </div> </div> </div><!--品牌介绍--> <div class="st-help"> <div class="wm-1200"> <div class="help-lsit">   <dl> <dt><a href="http://www.deccatech.cn/help/index_9.html" rel="nofollow">预订常见问题</a></dt> <dd>   <a href="http://www.deccatech.cn/help/show_43.html" target="_blank" rel="nofollow">如何获取发票？</a>  <a href="http://www.deccatech.cn/help/show_39.html" target="_blank" rel="nofollow">预定常见问</a>  </dd> </dl>  <dl> <dt><a href="http://www.deccatech.cn/help/index_10.html" rel="nofollow">付款方式</a></dt> <dd>   <a href="http://www.deccatech.cn/help/show_48.html" target="_blank" rel="nofollow">能不能脱团自己玩？</a>  <a href="http://www.deccatech.cn/help/show_49.html" target="_blank" rel="nofollow">签订旅游合同</a>  <a href="http://www.deccatech.cn/help/show_1.html" target="_blank" rel="nofollow">纯玩是什么意思？</a>  </dd> </dl>  <dl> <dt><a href="http://www.deccatech.cn/help/index_11.html" rel="nofollow">签订合同</a></dt> <dd>   </dd> </dl>  <dl> <dt><a href="http://www.deccatech.cn/help/index_12.html" rel="nofollow">其它问题</a></dt> <dd>   <a href="http://www.deccatech.cn/help/show_46.html" target="_blank" rel="nofollow">单房差是什么？</a>  </dd> </dl>  <dl> <dt><a href="http://www.deccatech.cn/help/index_46.html" rel="nofollow">游客中心</a></dt> <dd>   <a href="http://www.deccatech.cn/help/show_40.html" target="_blank" rel="nofollow">合同的签订</a>  </dd> </dl>  <div class="st-wechat">  </div> </div> </div> </div><!--帮助 扫码--> <div class="st-footer"> <div class="wm-1200"> <div class="st-foot-menu">   <a href="http://www.deccatech.cn/servers/index_1.html" target="_blank" rel="nofollow">关于我们</a>  <a href="http://www.deccatech.cn/servers/index_4.html" target="_blank" rel="nofollow">支付方式</a>  <a href="http://www.deccatech.cn/servers/index_2.html" target="_blank" rel="nofollow">联系我们</a>  <a href="http://www.deccatech.cn/servers/index_11.html" target="_blank" rel="nofollow">使用帮助</a>  <a href="http://www.deccatech.cn/servers/index_10.html" target="_blank" rel="nofollow">服务条款</a>  </div> <!--底部导航--> <div class="st-foot-edit"> <div class="foot_con"><p>
        经营许可证号：XXX　业务接待地址：四川省成都市XXXX</p></div> </div> <!--网站底部介绍--> <div class="support">技术支持：<a href="http://www.deccatech.cn/" target="_blank">笛卡CMS</a></div> <p></p> </div> </div> <script src="/plugins/qq_kefu/public/js/qqkefu.js"></script>
 <stourweb_footer/> </body> </html>
