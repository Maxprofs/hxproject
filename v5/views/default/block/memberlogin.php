
    {Common::css('module.css')}
    <!--member model-->
    <div class="side-userlogin-box mb15">
        <div class="side-userMsg" id="txt1">

        </div>
        <div class="side-userBtn" id="txt2">

        </div>
    </div>
    <script>
        $(function(){
            var url = "{$cmsurl}"+"member/login/ajax_is_login";
            var username=ST.Storage.getItem('st_username');
            var logintime=ST.Storage.getItem('st_user_logintime');
            var data=ST.Storage.getItem('st_data');
            var req={username:username,logintime:logintime,data:data};
            $.ajax({
                type:"POST",
                url:url,
                data:req,
                dataType:'json',
                success:function(data){
                    if(data.status){

                        $txt1 ='<dl>';
                        $txt1+='<dt><img src="'+data.user.litpic+'" /></dt>';
                        $txt1+='<dd>';
                        $txt1+='<p class="name"><span>'+data.user.nickname+'</span>你好！</p>';
                        $txt1+='<p class="txt">最近登录&nbsp;&nbsp;'+data.user.last_logintime+'</p>';
                        $txt1+='</dd>';
                        $txt1+='</dl>';

                        $txt2 = '<a class="uc-btn" href="/member/">会员中心</a>';

                    }else{

                        $txt1 ='<dl>';
                        $txt1+='<dt><img src="/res/images/user-headimg.png" /></dt>';
                        $txt1+='<dd>';
                        $txt1+='<p class="name">Hi，你好！</p>';
                        $txt1+='<p class="txt">感谢您的访问</p>';
                        $txt1+='</dd>';
                        $txt1+='</dl>';

                        $txt2 = '<a class="dl-btn" href="/member/login">立即登录</a>';
                        $txt2+= '<a class="zc-btn" href="/member/register">免费注册</a>';


                    }
                    $("#txt1").html($txt1);
                    $("#txt2").html($txt2);


                }

            })

        })
    </script>
    <!--/member model-->