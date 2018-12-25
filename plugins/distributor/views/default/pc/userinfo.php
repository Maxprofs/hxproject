<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <title>供应商管理系统-{$webname}</title>
    {Common::css("style.css,base.css,extend.css")}
    {Common::js("jquery.min.js,common.js,city/jquery.cityselect.js")}

</head>

<body left_color=3wpE7l >

	<div class="page-box">

    {request 'pc/pub/header'}

    {include "pc/pub/sidemenu_account"}
    
    <div class="main">
    	<div class="content-box">

        {include "pc/pub/qualifyalert"}
        
        <div class="frame-box">
        	<div class="frame-con">
          
            <div class="account-box">
            	<div class="account-tit"><strong class="bt">帐号信息</strong></div>

                <form id="usrfrm">
                    <div class="account-con">
                        <ul>
                            <li><strong class="lm">头像：</strong>

                                <div class="nr">
                                    <div class="account-headimg-box">
                                        {if !empty($userinfo['litpic'])}
                                        <img id="face" src="{$userinfo['litpic']}" width="94" height="94"/>
                                        {else}
                                        <img id="face" src="{$GLOBALS['cfg_res_url']}/images/default-headimg.jpg" width="94" height="94"/>
                                        {/if}
                                        <a class="upload" href="javascript:void(0)">上传头像</a>
                                        <input type="hidden" id="litpic" name="litpic" value="{$userinfo['litpic']}">
                                    </div>
                                </div>
                            </li>
                            <!--<li><strong class="lm"><i>*</i>昵称：</strong><div class="nr"><input type="text" class="msg-text" /></div></li>-->
                            <li><strong class="lm">姓名：</strong>

                                <div class="nr"><input type="text" class="msg-text" name="linkman" value="{$userinfo['linkman']}"/></div>
                            </li>
                            <li><strong class="lm">手机号码：</strong>

                                <div class="nr"><span class="name">{$userinfo['mobile']}&nbsp;</span><a class="revise-mz" href="{$cmsurl}pc/user/modify_phone">{if empty($userinfo['mobile'])}绑定{else}更换{/if}手机</a></div>
                            </li>
                            <li><strong class="lm">电子邮箱：</strong>

                                <div class="nr"><span class="name">{$userinfo['email']}&nbsp;</span><a class="revise-mz" href="{$cmsurl}pc/user/modify_email">{if empty($userinfo['email'])}绑定{else}更换{/if}邮件</a></div>
                            </li>
                            <li><strong class="lm">QQ：</strong>

                                <div class="nr"><input type="text" class="msg-text" name="qq" value="{$userinfo['qq']}"/></div>
                            </li>
                            <li><strong class="lm">座机电话：</strong>

                                <div class="nr"><input type="text" class="msg-text" name="telephone" value="{$userinfo['telephone']}"/></div>
                            </li>
                            <li><strong class="lm">电话传真：</strong>

                                <div class="nr"><input type="text" class="msg-text" name="fax" value="{$userinfo['fax']}"/></div>
                            </li>


                        </ul>

                        <input type="hidden" id="supplierid" name="supplierid" value="{$userinfo['id']}">
                        <input type="hidden" id="frmcode" name="frmcode" value="{$frmcode}"/>

                        <div class="account-save-box"><a href="javascript:;" class="save_btn">保存</a></div>
                    </div>
                </form>
            </div><!-- 账户资料 -->
          
          </div>
        </div>

        {request "pc/pub/footer"}
        
      </div>
    </div><!-- 主体内容 -->
  
  </div>
  {Common::js("layer/layer.js")}
<script>
    $(function(){
        $("#nav_userinfo").addClass('on');


        //上传头像点击
        $('.upload').click(function(){


            if($("#upiframe").length<1)
            {
                var s_left=Math.abs($(window).width()/2-350);
                var s_top=$(window).scrollTop()+200;
                ST.Util.createFade();//创建遮罩
                var url = SITEURL+"pc/index/uploadface";
                var imgdiv="<div id='upiframe' style='width:700px;height:500px;position:absolute;left:"+s_left+"px;top:"+s_top+"px;z-index:9999'> <iframe src='"+url+"' style='width:100%;height:100%;border:none;'></iframe></div>";
                $("body").append(imgdiv);
                //fade点击
                $(".fade").live('click',function(){
                    ST.Util.closeFade();
                    $("#upiframe").remove();//移除
                });
            }



        })

        //保存资料
        $(".save_btn").click(function(){
            var frmdata = $("#usrfrm").serialize();

            $.ajax({
                type:'post',
                url:SITEURL + 'pc/index/ajax_userinfo_save',
                data:frmdata,
                dataType:'json',
                success:function(data){
                    if(data.status){
                        layer.msg("{__('save_success')}", {
                            icon: 6,
                            time: 1000
                        })

                    }else{
                        layer.msg(data.msg, {icon:5});
                        return false;
                    }
                }
            })



        })
    })
</script>
</body>
</html>
