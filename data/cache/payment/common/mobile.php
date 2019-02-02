<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><stourweb_title/>-笛卡旅游</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="/phone/public/css/base.css">
    <script type="text/javascript" src="/phone/public/js/lib-flexible.js"></script>
    <script type="text/javascript" src="/phone/public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/phone/public/js/template.js"></script>
</head>
<body>
<link type="text/css" href="/phone/public/css/header.css" rel="stylesheet" />
<script type="text/javascript" src="/phone/public/js/common.js"></script>
<script type="text/javascript" src="/phone/public/js/login.js"></script>
<div class="header_top">
        <a class="back-link-icon" href="http://www.deccatech.cn"  data-ajax="false"></a>
        <h1 class="page-title-bar">确认订单</h1>
    <div class="st-top-menu">
                <span class="st-user-menu"></span>
        <div class="header-menu-bg"></div>
        <div class="st-down-bar">
            <ul>
                <li><a href="/phone/" data-ajax="false"><i class="icon home-ico"></i>首页</a></li>
                <li><a href="/phone/search" data-ajax="false"><i class="icon search-ico"></i>搜索</a></li>
                <li><a href="/phone/member" data-ajax="false"><i class="icon center-ico"></i>个人中心</a></li>
            </ul>
        </div>
            </div>
</div>
<script>
    var SITEURL = "/phone/";
    $(function(){
        //头部下拉导航
        $(".st-user-menu").on("click",function(){
            $(".header-menu-bg,.st-down-bar").show();
            $("html,body").css({overflow:"hidden"})
        });
        $(".header-menu-bg").on("click",function(){
            $(".header-menu-bg,.st-down-bar").hide();
            $("html,body").css({overflow:"auto"})
        })
    })
function is_login($obj){
        var fx_url="content=";
        if($obj['islogin']==1){
            if($obj['info']['fx_member']){
                if(window.location.href.indexOf('/show_')!=-1)
                {
                    var btn = $($obj['info']['fx_btn'].replace('[fx_url]', fx_url));
                    $('.bom_fixed a').eq(0).after(btn);
                    btn.attr('data-ajax',false);
                    btn.addClass('now-sell');
                }
            }
            //ST.
        }
    }
    //登陆检测
    ST.Login.check_login();
    //$('body').append('<script'+' type="text/javascript" src="'+SITEURL+'member/login/ajax_islogin"></'+'script>');
</script>
<!--微信分享-->
<stourweb_pay_content/>
<div class="hold-bottom-bar">
    <div class="bottom-fixed">
        <a class="confirm_pay_btn" id="confirm_pay_btn" href="javascript:;"><stourweb_title/></a>
    </div>
</div>
</body>
<script>
    var login_status=0;
    $('#confirm_pay_btn').click(function(){
        if (status>0) {
            var data = $('#mobile_common_pay').find('a.on').attr('data');
            var payurl = $('#mobile_common_pay').find('a.on').attr('data-payurl');
            if (payurl == "") {
                window.location.href = '/payment/index/confirm/?' + data;
            } else {
                window.location.href = payurl + '/?' + data;
            }
        } else {
            window.location.href = login_status>0?'/phone/member#&myOrder':'/phone/member/login?redirecturl=%2Fphone%2Fmember%23%26myOrder';
        }
    });
    function is_login($obj){
        if($obj.bool<1){
            return;
        }
        login_status=$obj.islogin;
        var html='<div class="st_user_header_pic">'
            +'<img src="'+$obj.info.litpic+'" />'
            +'<p><a>'+$obj.info.nickname+'</a></p>'
            +'</div>'
            +'<div class="st_user_cz">'
            +'<a href="/phone/"><i class="ico_01"></i>首页</a>'
            +'<a href="/phone/member/order/list"><i class="ico_02"></i>我的订单<em>'+$obj.info.orderNum+'</em></a>'
            +'<a href="/phone/member/linkman"><i class="ico_03"></i>常用联系人</a>'
            +'<a class="cursor" id="logout"><i class="ico_04"></i>退出</a>'
            +'</div>';
        $('#login-html').html(html);
    }
</script>
<script type="text/javascript" src="/phone/member/login/ajax_islogin"></script>
</html>
