<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head head_ul=fwACXC >
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}"/>
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}"/>
    {/if}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('base.css,swiper.min.css')}
    {Common::css_plugin('customize.css,mobiscroll.min.css','customize')}	
    {Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,layer/layer.m.js,common.js,jquery.validate.min.js')}
    {Common::js_plugin('mobiscroll.min.js,datetime.js','customize')}
</head>
<body>
{request "pub/header_new/typeid/$typeid"}
<section>
    <div class="mid_content">

        {st:ad action="getad" name="CustomizeWapIndexTop"}
            {if $data['adsrc']}
                <div class="sr_homeTop_pic">
                    <a class="item" target="_blank" href="{$data['adlink']}"><img src="{$data['adsrc']}" alt="{$data['adname']}" title="{$data['adname']}" /></a>
                </div>
            {else}
            <!--默认banner图片-->
            <div class="sr_homeTop_pic">
                <img src="{$GLOBALS['cfg_public_url']}images/siren.jpg"/>
            </div>
            {/if}
        {/st}

        <!--顶部图片-->

        {if !empty($plans)}
        <div class="case-box">
        	<h3>优秀定制方案</h3>
        	<div class="case-list swiper-container">
        		<ul class="clearfix swiper-wrapper">
                    {loop $plans $plan}
        			<li class="swiper-slide">
        				<a href="{$plan['url']}">
        					<div class="pic"><img src="{Common::img($plan['litpic'],310,212)}" alt="{$plan['title']}"  /></div>
        					<div class="day"><p>{if !empty($plan['days'])}{$plan['days']}{__('天')}{/if}</p></div>
        					<p class="hd">{$plan['title']}</p>
							<p class="bd"><i></i>{$plan['dest']}</p>
        				</a>
        			</li>
                    {/loop}
        		</ul>
        	</div>
        </div>
        {/if}

        <form id="st_form" method="post" action="{$cmsurl}customize/ajax_do_add" enctype="application/x-www-form-urlencoded">
            <div class="customMade_con">
                <h3 class="made_tit"><i>1</i><span>{__('您的旅行计划')}</span></h3>

                <div class="made_con">
                    <ul>
                        <li>
                            <strong class="bt">{__('目的地')}</strong>
                            <input type="text" class="mdd" name="dest" id="dest" placeholder="{__('必填,您要去的地方')}"/>
                        </li>
                        <li>
                            <strong class="bt">{__('出发地点')}</strong>
                            <input type="text" class="mdd" name="startplace" id="startplace" placeholder="{__('必填,您的出发地点')}"/>
                        </li>
                        <li>
                            <strong class="bt">{__('出发时间')}</strong>
                            <span class="date" id="txt_starttime">{date('Y-m-d',strtotime('+1 day'))}</span>
                            <input type="hidden" name="starttime" id="field_starttime" value="{date('Y-m-d',strtotime('+1 day'))}"/>
                        </li>
                        <li>
                            <strong class="bt">{__('出行时长')}</strong>
                            <span class="before">
                                <a class="sub" href="javascript:;">-</a>
                                <input type="text" name="days" id="days" readonly="readonly" value="1"/>
                                <a class="add" href="javascript:;">+</a>
                                <em>{__('天')}{__('左右')}</em>
                            </span>
                        </li>
                        <li>
                            <strong class="bt">{__('成人数')}</strong>
                            <span class="before">
                                <a class="sub" href="javascript:;">-</a>
                                <input type="text" name="adultnum" id="adultnum" readonly="readonly" value="1"/>
                                <a class="add" href="javascript:;">+</a>
                                <em>{__('人')}</em>
                            </span>
                        </li>
                        <li>
                            <strong class="bt">{__('儿童数')}</strong>
                            <span class="before">
                                <a class="sub" href="javascript:;">-</a>
                                <input type="text" name="childnum" id="childnum" readonly="readonly" value="0"/>
                                <a class="add" href="javascript:;">+</a>
                                <em>{__('人')}</em>
                            </span>
                        </li>

                        {loop $extend_fields $field}
                        <li class="custom-con">
                            <dl>
                                <dt>{$field['chinesename']}</dt>
                                <dd>
                                    <input type="hidden" name="{$field['fieldname']}" id="{$field['fieldname']}" value="{$field['options'][0]}">
                                    {loop $field['options'] $k $option}
                                    <a href="javascript:;" {if $k==0}class="on"{/if}><span>{$option}</span></a>
                                    {/loop}
                                </dd>
                            </dl>
                        </li>
                        {/loop}
                    </ul>
                </div>
            </div>
            <!--第三步-->

            <div class="customMade_con">
                <h3 class="made_tit"><i>2</i><span>{__('您的联系方式')}</span></h3>

                <div class="made_con">
                    <ul>
                        <li>
                            <strong class="bt">{__('您的称呼')}</strong>
                            <input type="text" class="mdd" name="contactname" id="contactname" placeholder="{__('必填,方便客服与您联系')}"/>
                        </li>
                        <li>
                            <strong class="bt bt-sex">{__('性别')}</strong>
                            <span class="sex">
                                <input type="hidden" name="sex" id="sex" value="{__('先生')}">
                                <a class="on" href="javascript:;">{__('先生')}</a>
                                <a href="javascript:;">{__('女士')}</a>
                            </span>
                        </li>
<!--                        <li>-->
<!--                            <strong class="bt">{__('所在地点')}</strong>-->
<!--                            <input type="text" class="mdd" name="address" id="address" placeholder="{__('必填,方便客服与您联系')}"/>-->
<!--                        </li>-->
                        <li>
                            <strong class="bt">{__('手机号码')}</strong>
                            <input type="text" class="mdd" name="phone" id="phone" placeholder="{__('必填,方便客服与您联系')}"/>
                        </li>
                        <li>
                            <strong class="bt">E-mail</strong>
                            <input type="text" class="mdd" name="email" id="email" placeholder="{__('必填,电子邮箱')}"/>
                        </li>
                        <li>
                            <dl>
                                <dt>{__('合适的联系时间')}</dt>
                                <dd class="contacttime">
                                    <input type="hidden" name="contacttime" id="contacttime" value="9:00-12:00">
                                    <a class="on" href="javascript:;"><span>9:00-12:00</span></a>
                                    <a href="javascript:;"><span>14:00-18:00</span></a>
                                    <a href="javascript:;"><span>19:00-22:00</span></a>
                                </dd>
                            </dl>
                        </li>
                        <li>
                            <dl>
                                <dt>{__('其他要求')}</dt>
                                <dd>
                                    <textarea name="content" id="content" cols="" rows="" placeholder="{__('您还有其他的要求吗')}？"></textarea>
                                </dd>
                            </dl>
                        </li>
                        <li>
                            <strong class="bt">{__('验证码')}</strong>
                            <input type="text" class="mdd" name="code" id="code" placeholder="{__('验证码')}"/><img
                                class="captcha yzm_pic cursor" src="" height="30"/>
                        </li>
                    </ul>
                </div>
            </div>
            <!--第二步-->
            <div class="error_txt"></div>

            <div class="sr_submit"><input type="submit" class="btn_save" value="{__('提交订制')}"/></div>
        </form>

    </div>

</section>

{request 'pub/code'}
{request 'pub/footer'}

<script>
    $(function(){
        function goto(){
            location.href = SITEURL+'customize';
        }
        
        //验证码切换
        $('.captcha').attr('src', ST.captcha(SITEURL+'captcha'));
        $('.captcha').click(function () {
            $(this).attr('src', ST.captcha($(this).attr('src')));
        });

        $(".sub").click(function () {
            var obj = $(this).parent().children('input');
            if (parseInt($(obj).val()) > 0) {
                $(obj).val(parseInt($(obj).val()) - 1);
            }
        });
        $(".add").click(function () {
            var obj = $(this).parent().children('input');
            $(obj).val(parseInt($(obj).val()) + 1);
        });

        //交通方式
        $(".custom-con dd a").click(function(){
            $(this).siblings('a').removeClass('on');
            $(this).addClass('on');
            $(this).siblings('input:hidden').val($(this).text());
        });

        //性别
        $("body").delegate(".sex a", 'click', function () {
            $(this).siblings().removeClass('on');
            $(this).addClass('on');
            $("#sex").val($(this).html());
        });

        //合适的联系时间
        $("body").delegate(".contacttime a", 'click', function () {
            $(this).siblings().removeClass('on');
            $(this).addClass('on');
            $("#contacttime").val($(this).children('span').html());
        });
        
        //时间选择
        $('#txt_starttime').mobiscroll().calendar({
            theme: 'mobiscroll',    //日期选择器使用的主题
            lang: 'zh',          //使用语言
            dateFormat: 'yy-mm-dd',     //显示方式
            display: 'bottom',     //显示方式,
            min: new Date(),    //显示方式,
            onDayChange:function(event){
                var date=event.date;
                var date_fmt=Datetime.format('yyyy-MM-dd',date);
                $("#field_starttime").val(date_fmt);
                $("#txt_starttime").text(date_fmt);
            }
        });
        
        //优秀定制方案
		var swiper = new Swiper('.case-list', {
			slidesPerView: 'auto'
		});

        //提交定制
        $("body").delegate(".btn_save", 'click', function () {
            //验证
            $('#st_form').validate({
                rules: {
                    dest: 'required',
                    startplace: 'required',
                    starttime: {
                        required: true,
                        dateISO: true
                    },
                    days: {
                        required: true,
                        min: 1
                    },
                    adultnum: {
                        required: true,
                        min: 1
                    },
                    childnum: {
                        required: true,
                        min: 0
                    },
                    planerank: 'required',
                    hotelrank: 'required',
                    room: 'required',
                    food: 'required',
                    contactname: 'required',
                    sex: 'required',
//                    address: 'required',
                    phone: {
                        required: true,
                        mobile: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    contacttime: 'required',
                    code: 'required'
                },
                messages: {
                    dest: '{__("error_customize_dest_not_empty")}',
                    startplace: '{__("error_customize_startplace_not_empty")}',
                    starttime: {
                        required: '{__("error_customize_starttime_not_empty")}',
                        dateISO: '{__("error_date")}'
                    },
                    days: {
                        required: '{__("error_customize_days_digit")}',
                        min: '{__("error_customize_days_digit")}'
                    },
                    adultnum:{
                        required: '{__("error_adultnum_digit")}',
                        min: '{__("error_adultnum_digit")}'
                    },
                    childnum:{
                        required: '{__("error_childnum_digit")}',
                        min: '{__("error_childnum_digit")}'
                    },
                    planerank: '{__("error_customize_planerank_not_empty")}',
                    hotelrank: '{__("error_customize_hotelrank_not_empty")}',
                    room: '{__("error_customize_room_not_empty")}',
                    food: '{__("error_customize_food_not_empty")}',
                    contactname: '{__("error_customize_contactname_not_empty")}',
                    sex: '{__("error_customize_sex_not_empty")}',
//                    address: '{__("error_customize_address_not_empty")}',
                    phone: {
                        required: '{__("error_user_phone")}',
                        mobile: '{__("error_user_phone")}'
                    },
                    email:  {
                        required: '{__("error_user_email")}',
                        email: '{__("error_user_email")}'
                    },
                    contacttime: '{__("error_customize_contacttime_not_empty")}',
                    code: '{__("error_code")}'

                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    var content = $('#st_form').find('.error_txt:eq(0)').html();
                    console.log(element)
                    if (content == '') {
                        $('#st_form').find('.error_txt:eq(0)').html('<i></i>');
                        error.appendTo($('#st_form').find('.error_txt:eq(0)'));
                    }
                },
                showErrors: function (errorMap, errorList) {
                    if (errorList.length < 1) {
                        $('#st_form').find('.error_txt:eq(0)').html('');
                    } else {
                        this.defaultShowErrors();
                    }
                }, submitHandler: function (form) {
                    //表单提交句柄,为一回调函数，带一个参数：form
                    $.post('{$cmsurl}customize/ajax_check_code', {
                        'code': $.trim($("#code").val())
                    }, function (data) {
                        if(data ==  true){
                            var params = $("#st_form").serialize();
                            $.post('{$cmsurl}customize/ajax_do_add', params, function (data) {
                                if (data.status == 1) {
                                    layer.open({
                                        content: '{__("success_customize_add_insert")}',
                                        time: 2,
                                        end:function(){
                                            goto();
                                        }
                                    });
                                }else{
                                    layer.open({
                                        content: data.message,
                                        time: 2
                                    });
                                }
                            }, 'json')
                        }else{
                            layer.open({
                                content: '{__("error_code")}',
                                time: 2
                            });
                        }
                    }, 'json');
                }
            });
        });

    })
</script>
</body>
</html>
