<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <title>供应商管理系统-{$webname}</title>
    {Common::css("style.css,base.css,extend.css")}
    {Common::js("jquery.min.js,common.js,city/jquery.cityselect.js")}

</head>

<body>

	<div class="page-box">

    {request 'pc/pub/header'}

    {include "pc/pub/sidemenu_enterprise"}
    
    <div class="main">
    	<div class="content-box">

        {include "pc/pub/qualifyalert"}
        
        <div class="frame-box">
        	<div class="frame-con">
          
            <div class="account-box">
            	<div class="account-tit"><strong class="bt">企业信息</strong></div>

                <form id="usrfrm">
                    <div class="account-con">
                        <ul>
                            <li><strong class="lm">企业名称：</strong>

                                <div class="nr"><span class="name">{$userinfo['suppliername']}</span></div>
                            </li>
                            <li><strong class="lm">法人代表：</strong>
                                <div class="nr"><span class="name">{$userinfo['reprent']}</span></div>
                            </li>

                            <li><strong class="lm">经营范围：</strong>
                                <div class="nr">
                                {loop $apply_product $p}
                                <span class="name">{$p['modulename']}&nbsp;&nbsp;</span>
                                {/loop}

                                {if $userinfo['verifystatus']==1}
                                <a class="revise-mz" href="#" style=" color:#666; cursor:not-allowed; background:#e0e2e7">等待验证</a>
                                {elseif $userinfo['verifystatus']==2 || $userinfo['verifystatus']==0}
                                <a class="revise-mz" href="{$cmsurl}pc/qualify/step">立即验证</a>
                                {elseif $userinfo['verifystatus']==3}
                                <a class="revise-mz" href="{$cmsurl}pc/qualify/step">重新验证</a>
                                {/if}

                                </div>
                            </li>
                            <li>
                                <strong class="lm">公司地址：</strong>
                                <div class="nr">
                                    <input type="text" class="msg-text" name="address" value="{$userinfo['address']}"/>
                                </div>
                            </li>
                            <li>
                                <strong class="lm">联系电话：</strong>
                                <div class="nr">
                                    <input type="text" class="msg-text" name="telephone" value="{$userinfo['telephone']}"/>
                                </div>
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
        $("#nav_enterpriseinfo").addClass('on');

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
