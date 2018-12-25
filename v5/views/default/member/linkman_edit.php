<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{__('常用联系人')}-{$webname}</title>
    {include "pub/varname"}
    {Common::css('user.css,base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,jquery.validate.js,jquery.cookie.js,jquery.validate.addcheck.js')}
</head>

<body>

{request "pub/header"}
  
  <div class="big">
  	<div class="wm-1200">
    
    	<div class="st-guide">
      	<a href="{$cmsurl}">{__('首页')}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{__('常用地址')}
      </div><!--面包屑-->
      
      <div class="st-main-page">
          {include "member/left_menu"}
          <div class="user-cont-box">

              <div class="add-linkman-box">
                  <div class="linkman-tit clearfix">{if $info['id']}编辑常用旅客{else}新增常用旅客{/if}</div>
                  <div class="linkman-con">
                      <form id="linkmanfrm">
                          <ul class="add-content">
                              <li class="clearfix">
                                  <strong class="tit"><sup>*</sup>姓名：</strong>
                                  <div class="content"><input class="txt" name="linkman" type="text" value="{$info['linkman']}"  /></div>
                              </li>
                              <li class="clearfix">
                                  <strong class="tit">性别：</strong>
                                  <div class="content">
                                      <div class="sex-box clearfix">
                                          <label   class="sex {if $info['sex']!='女'} on{/if}">男</label>
                                          <label class="sex {if $info['sex']=='女'} on{/if}">女</label>
                                      </div>
                                  </div>

                              </li>
                              <li class="clearfix">
                                  <strong class="tit">手机号：</strong>
                                  <div class="content"><input name="mobile" value="{$info['mobile']}" class="txt" type="text"  /></div>

                              </li>
                              <li class="clearfix">
                                  <strong class="tit"><sup>*</sup>证件类型：</strong>
                                  <div class="content">
                                      <select class="sel" name="cardtype">
                                          <option value="身份证" {if $info['cardtype']=='身份证'}selected="selected"{/if}>{__('身份证')}</option>
                                          <option value="护照" {if $info['cardtype']=='护照'}selected="selected"{/if}>{__('护照')}</option>
                                          <option value="台胞证" {if $info['cardtype']=='台胞证'}selected="selected"{/if}>{__('台胞证')}</option>
                                          <option value="港澳通行证" {if $info['cardtype']=='港澳通行证'}selected="selected"{/if}>{__('港澳通行证')}</option>
                                          <option value="军官证" {if $info['cardtype']=='军官证'}selected="selected"{/if}>{__('军官证')}</option>
                                          <option value="出生日期" {if $info['cardtype']=='军官证'}selected="selected"{/if}>{__('出生日期')}</option>
                                      </select>
                                  </div>
                              </li>
                              <li class="clearfix">
                                  <strong class="tit"><sup>*</sup>证件号码：</strong>
                                  <div class="content"><input onKeyUp="value=value.replace(/[^\d|^a-zA-Z]/g,'')" name="idcard" value="{$info['idcard']}" class="txt" type="text" /></div>

                              </li>
                          </ul>
                          <div class="add-btn-box">
                              <a class="save" id="linkmanfrm" href="javascript:void(0)">保存</a>
                              <a class="cancel" href="{$cmsurl}member/index/linkman">取消</a>
                          </div>
                          <input type="hidden" name="sex" value="{if $info['sex']} {$info['sex']}{else}男{/if}">
                          <input type="hidden" name="id" value="{$info['id']}">
                      </form>
                  </div>
              </div>
          </div>
      </div>
    
    </div>
  </div>
  
{request "pub/footer"}
{Common::js('layer/layer.js')}
<script>
    var is_allow = 1;
    $(function(){

        //导航选中
        $("#nav_linkman").addClass('on');

        $('.sex-box label').click(function () {
           var val = $.trim($(this).text());
           $('input[name=sex]').val(val);
            $('.sex-box label').removeClass('on');
            $(this).addClass('on');

        });

        $('select[name=cardtype]').change(function () {
            validator.resetForm();
        });

        jQuery.validator.addMethod("byteRangeLength", function(value, element) {
            var length = 0;
            for(var i = 0; i < value.length; i++){
                if(value.charCodeAt(i) > 127){
                    length++;
                }
                else
                {
                    length += 0.5;
                }
            }
            return this.optional(element) || ( length >= 0 && length <= 4 );
        }, $.validator.format("最大支持4个中文汉字"));


     var validator  =  $("#linkmanfrm").validate({
            rules:{
                linkman:{
                    required:true,
                    byteRangeLength :true
                },
                mobile:{
                    isMobile:true
                },
                idcard:{
                    required:true,
                    remote: {
                        url: SITEURL+'member/index/ajax_check_linkman_card',
                        type: 'post',
                        data:{
                            cardtype:function(){
                                return $("select[name=cardtype]").val();
                            },
                            id:function(){
                                return $("input[name=id]").val();
                            }
                        }
                    }
                }
            },
            messages:{
                linkman:{
                    required:'请填写游客名称'
                },
                mobile:{
                    isMobile:'手机号码不正确'
                },
                idcard:{
                    required :'请填写证件号',
                    remote:'证件号重复'
                }
            },
            submitHandler:function(form){
                if(is_allow==0)
                {
                    return false;
                }
                is_allow = 0;
                var index = layer.load(1, {
                    shade: [0.5,'#ccc'] //0.1透明度的白色背景
                });
                $.ajax({
                    type:'POST',
                    url:SITEURL+'member/index/ajax_do_save_linkman',
                    data:$("#linkmanfrm").serialize(),
                    dataType:'json',
                    success:function(data){
                       if(data.status){
                           layer.msg("{__('save_success')}", {
                               icon: 6,
                               time: 1000
                           },function () {
                               location.href= '{$cmsurl}member/index/linkman';
                           })
                       }else{
                           layer.msg("{__('save_failure')}", {
                               icon: 5,
                               time: 1000

                           },function () {
                               layer.closeAll();
                           })

                       }
                    }
                });
                return false;
            } ,
            errorClass:'erro-msg',
            errorElement:'span',
            highlight: function(element, errorClass, validClass) {
                $(element).attr('style','border:1px solid red');
            },
            unhighlight:function(element, errorClass){
                $(element).attr('style','');
            },
            errorPlacement:function(error,element){
                error.appendTo(element.parents('li'));

            }

        });


        //保存
        $(".save").click(function(){

            if( $('select[name=cardtype]').val()=='身份证')
            {
                $('input[name=idcard]').rules("add", {alnum:true,isIDCard:true, messages: {required: "请输入证件号",isIDCard: "身份证号码格式不正确"}});
            }
            else
            {
                $('input[name=idcard]').rules("remove","alnum");
                $('input[name=idcard]').rules("remove","isIDCard")
            }
            $("#linkmanfrm").submit();
            return false
        });


    });

</script>
</body>
</html>
