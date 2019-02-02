<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head> <meta charset="utf-8"> <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title> <?php if($seoinfo['keyword']) { ?> <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" /> <?php } ?> <?php if($seoinfo['description']) { ?> <meta name="description" content="<?php echo $seoinfo['description'];?>" /> <?php } ?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js,SuperSlide.min.js');?> <?php echo Common::css_plugin('customize.css','customize');?> <style>
        span.error-style{
           margin-left:5px;
            color:red;
        }
    </style> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="dz-banner-box"> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$ad = $ad_tag->getad(array('action'=>'getad','name'=>'s_customize_index_1','pc'=>'1','return'=>'ad',));}?> <?php if(!empty($ad)) { ?> <a href="<?php if(empty($ad['adlink'])) { ?>javascript:;<?php } else { ?><?php echo $ad['adlink'];?><?php } ?>
" target="_blank"><img  src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo Common::img($ad['adsrc'],1920,386);?>" alt="<?php echo $ad['adname'];?>"></a> <?php } else { ?> <a href="javascript:;" target="_blank"><img src="<?php echo $GLOBALS['cfg_plugin_customize_public_url'];?>images/siren-dz-banner.jpg" width="1920" height="386"></a> <?php } ?> </div><!-- banner --> <div class="big bg-grey-f5"> <div class="wm-1200"> <div class="custom-content"> <form id="cusfrm" method="post" action="<?php echo $cmsurl;?>customize/ajax_save"> <div class="custom-bt"> <h3><?php echo __('我要定制');?></h3> <p><?php echo __('为更好的了解您的旅行计划，为您提供完美的定制服务，请完善以下资料');?></p> </div> <div class="custom-block"> <h3><?php echo __('您的旅行计划');?></h3> <div class="block-content"> <ul class="clearfix"> <li class="half-li"> <em class="item"><?php echo __('目的地');?>：</em> <div class="con"><input type="text" class="custom-default-text w270" name="dest"/></div> </li> <li class="half-li"> <em class="item"><?php echo __('出游天数');?>：</em> <div class="con"> <span class="amount-opt-wrap"> <a href="javascript:;" class="sub-btn">–</a> <input type="text" class="num-text" name="days" maxlength="4" value="1"> <a href="javascript:;" class="add-btn">+</a> </span> </div> </li> <li class="half-li"> <em class="item"><?php echo __('出发时间');?>：</em> <div class="con"><input type="text" class="custom-default-text w270" id="starttime" name="starttime"/></div> </li> <li class="half-li"> <em class="item"><?php echo __('成人数');?>：</em> <div class="con"> <span class="amount-opt-wrap"> <a href="javascript:;" class="sub-btn">–</a> <input type="text" class="num-text" name="adultnum" maxlength="4" value="1"> <a href="javascript:;" class="add-btn">+</a> </span> </div> </li> <li class="half-li"> <em class="item"><?php echo __('出发地');?>：</em> <div class="con"><input type="text" name="startplace" class="custom-default-text w270"/></div> </li> <li class="half-li"> <em class="item"><?php echo __('儿童数');?>：</em> <div class="con"> <span class="amount-opt-wrap"> <a href="javascript:;" class="sub-btn">–</a> <input type="text" class="num-text" name="childnum" maxlength="4" value="0"> <a href="javascript:;" class="add-btn">+</a> </span> </div> </li> <?php $n=1; if(is_array($extend_fields)) { foreach($extend_fields as $field) { ?> <li class="full-li"> <em class="item"><?php echo $field['chinesename'];?>：</em> <div class="con"> <input type="hidden" name="<?php echo $field['fieldname'];?>"/> <?php $n=1; if(is_array($field['options'])) { foreach($field['options'] as $k => $option) { ?> <a class="custom-child-item <?php if($k==0) { ?>cc-active<?php } ?>
" href="javascript:;"><?php echo $option;?></a> <?php $n++;}unset($n); } ?> </div> </li> <?php $n++;}unset($n); } ?> <li class="full-li"> <em class="item"><?php echo __('其它需求');?>：</em> <div class="con"> <textarea name="content" class="default-textarea"></textarea> </div> </li> </ul> </div> </div> <div class="custom-block"> <h3><?php echo __('您的联系方式');?></h3> <div class="block-content"> <ul class="clearfix"> <li class="half-li"> <em class="item"><?php echo __('您的称呼');?>：</em> <div class="con"><input type="text" class="custom-default-text w270" name="contactname"/></div> </li> <li class="half-li"> <em class="item"><?php echo __('性别');?>：</em> <div class="con"> <input type="hidden" name="sex" value="<?php echo __('先生');?>"/> <a class="custom-child-item cc-active" href="javascript:;"><?php echo __('先生');?></a> <a class="custom-child-item" href="javascript:;"><?php echo __('女士');?></a> </div> </li> <li class="half-li"> <em class="item"><?php echo __('联系电话');?>：</em> <div class="con"><input type="text" class="custom-default-text w270" name="phone"/></div> </li> <li class="half-li"> <em class="item"><?php echo __('电子邮箱');?>：</em> <div class="con"><input type="text" class="custom-default-text w270" name="email"/></div> </li> <!--                            <li class="full-li">--> <!--                                <em class="item"><?php echo __('所在地点');?>：</em>--> <!--                                <div class="con"><input type="text" class="custom-default-text w790" name="address"/></div>--> <!--                            </li>--> <li class="full-li"> <em class="item"><?php echo __('合适的联系时间');?>：</em> <div class="con"> <input type="hidden" name="contacttime" value="9:00-12:00"/> <a class="custom-child-item cc-active" href="javascript:;">9：00-12：00</a> <a class="custom-child-item" href="javascript:;">14：00-18：00</a> <a class="custom-child-item" href="javascript:;">19：00-22：00</a> </div> </li> <li class="full-li"> <em class="item">验证码：</em> <div class="con"> <input type="text" name="captcha" class="custom-default-text"> <img class="yzm-img" src="<?php echo $cmsurl;?>captcha" onClick="this.src=this.src+'?math='+ Math.random()" > <span id="captcha_error" class="error-msg" style="display: none">验证码错误</span> </div> </li> </ul> <div class="custom-submit-block"><a href="javascript:;" class="custom-submit-btn" id="submit_btn"><?php echo __('提交订单');?></a></div> </div> </div> <input type="hidden" name="frmcode" value="<?php echo $frmcode;?>"/> </form> </div> <!--栏目介绍--> <?php if(!empty($seoinfo['jieshao'])) { ?> <div class="st-comm-introduce st-comm-introduce-siren"> <div class="st-comm-introduce-txt"> <?php echo $seoinfo['jieshao'];?> </div> </div> <?php } ?> <div class="custom-case"> <h3 class="case-tit"><?php echo __('优秀定制方案');?></h3> <div class="slide-case"> <div class="slide-bd"> <ul class="clearfix"> <?php $n=1; if(is_array($plans)) { foreach($plans as $plan) { ?> <li> <a class="con" href="<?php echo $plan['url'];?>" target="_blank"> <div class="pic"><img src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo Common::img($plan['litpic'],285,143);?>" alt="<?php echo $plan['title'];?>" /></div> <div class="bt"><?php echo $plan['title'];?></div> <div class="info"> <span><?php echo __('目的地');?>：<?php echo $plan['dest'];?></span> </div> <div class="info clearfix"> <span class="fl"><?php echo __('行程天数');?>：<?php if(!empty($plan['days'])) { ?><?php echo $plan['days'];?><?php echo __('天');?><?php } ?> </span> <span class="fr"><?php echo __('浏览');?>：<?php echo $plan['shownum'];?></span> </div> </a> </li> <?php $n++;}unset($n); } ?> </ul> </div> <div class="slide-hd"> <ul> <?php if(count($plans)>4) { ?> <li></li> <li></li> <?php } ?> </ul> </div> </div> </div> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <script src="/tools/js/DatePicker/WdatePicker.js"></script> <?php echo Common::js('layer/layer.js',0);?> <?php echo  Stourweb_View::template("member/login_order");  ?> <?php echo Common::js('jquery.validate.addcheck.js');?> <script>
    $(function(){
        //选择
        $(".custom-child-item").click(function(){
             $(this).siblings('.custom-child-item').removeClass('cc-active');
             $(this).addClass('cc-active');
             $(this).siblings('input:hidden').val($(this).text());
        });
        //数量选择
        $(".add-btn,.sub-btn").click(function(){
              var num_ele=$(this).siblings('.num-text');
              var num=num_ele.val();
              num = parseInt(num);
              if($(this).is('.add-btn'))
              {
                  num+=1;
              }
              else if(num>0)
              {
                  num-=1;
              }
              num_ele.val(num);
        });
        //默认选中第一个
        $(".con").each(function(){
            $(this).find(".custom-child-item:first").trigger('click');
        });
        //提交订单
        $("#submit_btn").click(function(){
            $("#cusfrm").submit();
        });
        //出发时间选择
        $("#starttime").click(function(){
            WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d'})
        })
        //案例滚动
        $(function() {
            $(".slide-case").slide({
                mainCell: ".slide-bd ul",
                titCell: ".slide-hd li",
                effect: "left",
                delayTime: 500,
                vis: 4,
                scroll: 4,
                autoPlay: false
            })
        })
        //验证有效性
        $("#cusfrm").validate({
            submitHandler:function(form){
                if(!is_login_order()){
                    return false;
                }
                ST.Util.showLoading({isfade:true,text:'<?php echo __("提交中...");?>'});
                $.ajax({
                    type:'POST',
                    url:SITEURL+'customize/ajax_save',
                    data:$("#cusfrm").serialize(),
                    dataType:'json',
                    success:function(data){
                        ST.Util.closeLoading();
                        if(data.status){
                            layer.alert("<?php echo __('提交成功');?>", {
                                icon: 1,
                                skin: 'layer-ext-moon',
                                yes:function()
                                {
                                    window.location.reload();
                                }
                            })
                        }else{
                            if(data.flag=='captcha')
                            {
                                $('#captcha_error').show();
                            }
                            else
                            {
                                layer.alert("<?php echo __('提交失败');?>", {
                                    icon: 2,
                                    skin: 'layer-ext-moon'
                                })
                            }
                        }
                    }
                })
            } ,
            errorClass:'error-style',
            errorElement:'span',
            rules: {
                dest:{
                    required: true
                },
                starttime:{
                    required: true
                },
                startplace:{
                   required:true
                },
                phone:{
                    required:true,
                    isPhone:true
                },
                email:{
                    required:true,
                    email:true
                },
                captcha:{
                        required:true
                }
            },
            messages: {
                dest:{
                    required: "<?php echo __('必填');?>"
                },
                starttime:{
                    required: "<?php echo __('必填');?>"
                },
                startplace:{
                    required: "<?php echo __('必填');?>"
                },
                phone:{
                    required:"<?php echo __('必填');?>",
                    isPhone: "<?php echo __('手机号码格式错误');?>"
                },
                email:{
                    required:"<?php echo __('必填');?>",
                    email:"<?php echo __('邮箱格式错误');?>"
                },
                captcha: {
                    required:"<?php echo __('必填');?>"
                }
            }
        });
    });
</script> </body> </html>
