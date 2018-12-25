<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{$info['title']}预订-{$webname}</title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('swiper.min.css,lib-flexible.css,base.css,reset-style.css')}
    {Common::css_plugin('mobilebone.css,m_ship.css','ship')}
    {Common::js('lib-flexible.js,Zepto.js,swiper.min.js,jquery.min.js,delayLoading.min.js')}
    {Common::js_plugin('mobilebone.js','ship')}
</head>

<body>

<form id="bookfrm" method="post" action="create" strong_body=ymACXC >
    <div class="page out" id="pageHome" data-title="预定产品">
        {request "pub/header_new/typeid/$typeid/isbookpage/1"}
        <!-- 公用顶部 -->
        <div class="page-content user-order-page">
            <div class="wrap-content">
                {if empty($userinfo['mid'])}
                <div class="login-hint-txt">
                    温馨提示：<a class="login-link" <a data-ajax="false" href="/phone/member/login">登录</a>可享受预定送积分、积分抵现！
                </div>
                {/if}
                <!-- 温馨提示 -->
                <div class="booking-info-block clearfix">
                    <h3 class="block-tit-bar"><strong class="no-style">预定信息</strong></h3>
                    <div class="name-block">
                        <strong class="bt no-style">航线名称</strong>
                        <p class="txt">{$info['title']}</p>
                    </div>
                    <div class="block-item">
                        <ul>
                            <li>
                                <strong class="item-hd no-style">出发日期</strong>
                                <span class="more-type">{$starttime}</span>
                            </li>
                            {loop $suitlist $suit}
                            <li>
                                <strong class="item-type-name no-style">{$suit['suitname']}{$suit['kindname']}(可住{$suit['peoplenum']}人)</strong>
                                <span class="more-type">{$suit['book_roomnum']}间</span>
                            </li>
                            {/loop}

                        </ul>
                    </div>
                </div>
                <!-- 预定信息 -->

                <div class="booking-info-block clearfix">
                    <h3 class="block-tit-bar"><strong class="no-style">联系人信息</strong></h3>
                    <div class="block-item">
                        <ul>
                            <li>
                                <strong class="item-hd no-style">联系人：</strong>
                                <input id="linkman" name="linkman" type="text" value="{$userinfo['truename']}" class="write-info" placeholder="请填写真实姓名" />
                                <span class="nd">(必填)</span>
                            </li>
                            <li>
                                <strong class="item-hd no-style">手机号码：</strong>
                                <input type="text" id="linktel" name="linktel" value="{$userinfo['mobile']}" class="write-info" placeholder="请输入常用手机号码" />
                                <span class="nd">(必填)</span>
                            </li>
                            <li>
                                <strong class="item-hd no-style">电子邮箱：</strong>
                                <input type="text" id="linkemail" name="linkemail" value="{$userinfo['email']}" class="write-info" placeholder="请输入常用电子邮箱" />
                                <span class="nd"></span>
                            </li>
                        </ul>
                    </div>
                    <div class="block-remarks">
                        <strong class="item-hd no-style">订单备注：</strong>
                        <textarea name="remark" class="item-txt"></textarea>
                    </div>
                </div>
                <!-- 联系人信息 -->
                {if $GLOBALS['cfg_plugin_ship_line_usetourer']==1}
                <div class="booking-info-block clearfix">
                    <h3 class="block-tit-bar"><strong class="no-style">游客信息</strong>
                        {if $userinfo['mid']}
                        <a class="yk-check-link fr" href="#commonUse">选择常用游客<i class="more-ico"></i></a>
                        {/if}
                    </h3>
                    <div class="block-item">
                       {loop $totalnum $num}
                        <ul class="tour_ul" data-id="{$n}">
                            <li>
                                <strong class="item-bt no-style">游客{$n}</strong>
                            </li>
                            <li class="tourname">
                                <strong class="item-hd no-style">姓名</strong>
                                <input type="text" name="tourname[{$n}]" {if $n==1} value="{$userinfo['truename']}" {/if} class="write-info require" placeholder="与乘客证件一致" />
                                <span class="nd">(必填)</span>
                            </li>
                            <li  class="touridcard">
                                <strong class="item-hd no-style" flag="{$n}" onclick="change_type(this)">
                                    <input type="hidden" name="cardtype[{$n}]" value="身份证">
                                    身份证
                                    <i class="down-ico"></i></strong>
                                <input type="text" data-name="idcard" name="touridcard[{$n}]" {if $n==1} value="{$userinfo['cardid']}" {/if} {if $n==1} value="{$userinfo['truename']}" {/if} class="write-info require" placeholder="请输入证件号码" />
                                <span class="nd">(必填)</span>
                            </li>
                            <li  class="toursex">
                                <strong class="item-hd no-style">性别</strong>
                                <div class="sex-bar">
                                    <span data="男"  class="check-label-item   {if ($userinfo['sex']=='男'&&$n==1)||$n>1}  checked{/if}"><i class="icon"></i>男</span>
                                    <span data="女" class="check-label-item {if $userinfo['sex']=='女'&&$n==1}  checked{/if}"><i class="icon"></i>女</span>
                                </div>
                                <input  type="hidden" {if $n==1} value="{$userinfo['sex']}"{else} value="男" {/if}  name="toursex[{$n}]"  />
                            </li>
                            <li  class="tourmobile">
                                <strong class="item-hd no-style">联系电话</strong>
                                <input type="text" name="tourmobile[{$n}]" {if $n==1} value="{$userinfo['mobile']}" {/if} class="write-info" placeholder="请输入联系电话" />
                            </li>
                        </ul>
                        {/loop}
                    </div>
                </div>
                <!-- 游客信息 -->
                {/if}
                <div class="booking-info-block clearfix">
                    <div class="block-item">
                        <ul>
                            <li>
                                <strong class="item-hd no-style"><span class="pay-type">支付方式</span></strong>
                                <span class="more-type">全款支付</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- 支付方式 -->
                {if !empty($userinfo['mid'])}
                <div class="booking-info-block clearfix">
                    <h3 class="block-tit-bar"><strong class="no-style">优惠政策</strong></h3>
                    <div class="block-item">
                        <ul>
                            {if $jifentprice_info}
                            <li>
                                <div class="yh-info-box">
                                    <p class="jf-use">使用<input type="text" name="jifentprice_info" id="jifentprice_info"  param="{toplimit:{$jifentprice_info['toplimit']},jifentprice:{$jifentprice_info['jifentprice']} }"       class="jf-num" />积分，抵现<em class="se-num">-{Currency_Tool::symbol()}0</em></p>
                                    <p class="jf-txt">共{$userinfo['jifen']}积分，最多可使用{$jifentprice_info['toplimit']}积分抵扣{Currency_Tool::symbol()}{$jifentprice_info['jifentprice']}</p>
                                </div>
                            </li>
                            {/if}
                            {if St_Functions::is_normal_app_install('coupon')}
                            {php}$countconpon=count($couponlist){/php}
                            {if $countconpon>0}
                            <li>
                                <a class="all" href="#useCoupon">
                                    <span class="item">
                                        <strong class="no-style">优惠券</strong>
                                    </span>
                                    <span class="more-type">{$countconpon}张可用<i class="more-ico"></i></span>
                                </a>
                            </li>
                            {/if}
                            {/if}
                        </ul>
                    </div>
                </div>
                <!-- 优惠政策 -->
                {/if}

            </div>

            <div class="bom-fixed-content">
                <div class="bom-fixed-block">
                    <span class="total">
                        <em class="jg no-style">应付总额：{Currency_Tool::symbol()}{$totalprice}</em>
                    </span>
                    <span class="order-show-list" id="order-show-list">明细<i class="arrow-up-ico"></i></span>
                    <a class="now-booking-btn" href="javascript:;">立即预定</a>
                </div>
            </div>
            <!-- 立即预定 -->

            <div class="fee-box hide" id="fee-box">
                <div class="fee-container">
                    <div class="fee-row">
                        <p class="ze">
                            <strong class="no-style">应付总额</strong>
                            <em class="fr no-style">{Currency_Tool::symbol()}{$totalprice}</em>
                        </p>
                    </div>
                    <ul class="mx-list">
                        {loop $suitlist $suit}
                        <li>
                            <strong class="no-style">{$suit['suitname']}{$suit['kindname']}(可住{$suit['peoplenum']}人)</strong>
                            <em class="no-style">{Currency_Tool::symbol()}{$suit['price']}*{$suit['book_roomnum']}</em>
                        </li>
                        {/loop}
                        <li class="zk-li" style="display: none">
                            <span class="zk">-(扣减)</span>
                        </li>
                        <li class="zk-jifen"  style="display: none">
                            <strong class="no-style">积分抵现</strong>
                            <em class="no-style"></em>
                        </li>
                        <li class="zk-coupon"  style="display: none">
                            <strong class="no-style">优惠券</strong>
                            <em class="no-style"></em>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- 费用明细 -->

            <div class="foo-box hide" id="cardtype-box">
                <div class="foo-container">
                    <div class="bar clearfix">
                        <a class="fl" href="javascript:;">取消</a>
                        <a class="fr" href="javascript:;">确认</a>
                    </div>
                    <ul class="list">
                        <li class="active">身份证</li>
                        <li>护照</li>
                        <li>台胞证</li>
                        <li>港澳通行证</li>
                        <li>军官证</li>
                    </ul>
                </div>
            </div>
            <!-- 证件选择 -->
        </div>
    </div>

    <div class="page out" id="commonUse">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="#pageHome" data-rel="back"></a>
            <h1 class="page-title-bar">订单填写</h1>
        </div>
        <!-- 公用顶部 -->
        <div class="page-content user-order-page">
            <div class="add-linkman-bar">
<!--                <a class="add-linkman-link" href="#addLinkMan"><i class="add-ico"></i>新增常用旅客</a>-->
            </div>
            <div class="linkman-group">
                <ul class="linkman-list clearfix">
                    {st:member action="linkman" memberid="$userinfo['mid']"}
                    {loop $data $r}
                    <li>
                        <span class="checkbox-label"  data-cardtype="{$r['cardtype']}"  data-linkman="{$r['linkman']}" data-sex="{$r['sex']}" data-mobile="{$r['mobile']}" data-idcard="{$r['idcard']}"   ><i class="check-icon"></i></span>
                        <div class="info">
                            <strong class="name no-style">{$r['linkman']}</strong>
                            <span class="code">{$r['cardtype']}  {$r['idcard']}</span>
                        </div>
<!--                        <a class="edit-btn" href="#editLinkMan"><i class="ico"></i></a>-->
                    </li>
                    {/loop}
                    {/st}
                </ul>
                <a class="save-info-btn" href="javascript:;">确认</a>
            </div>
        </div>
    </div>
    {if $couponlist}
    <div class="page out" id="useCoupon">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="#pageHome" data-rel="back"></a>
            <h1 class="page-title-bar">订单填写</h1>
        </div>
        <!-- 公用顶部 -->
        <div class="page-content user-order-page">
            <div class="wrap-content">
                <div class="use-coupon-block clearfix">
                    <ul class="coupon-list">
                        {loop $couponlist $l}
                        <li data="{id:{$l['roleid']},type:{$l['type']},title:'{$l['name']}',detail:{$l['amount']} }">
                            <div class="attr-ty">通用券</div>
                            <div class="item-l fl">
                                <strong class="type no-style">{$l['name']}</strong>
                                <p class="txt">品类限制：{if $l['typeid']==9999}部分{$l['typename']}产品可用{else}无品类限制{/if}</p>
                                <p class="date">有效期：{if $l['isnever']==1}截止{$l['endtime']}{else}永久有效{/if}</p>
                            </div>
                            <div class="item-r fr">
                                <span class="jg">{if $l['type']==1} {$l['amount']}折{else}{Currency_Tool::symbol()}{$l['amount']}{/if}</span>
                                <span class="sm">满{$l['samount']}元可用</span>
                                <i class="use-label" style="display: none"></i>
                            </div>
                        </li>
                        {/loop}
                    </ul>
                </div>
                <!-- 使用列表 -->
            </div>
        </div>
    </div>
    {/if}

    <input type="hidden" id="totalprice" value="{$totalprice}">
    <input type="hidden" id="lineid" name="lineid"  value="{$info['id']}">
    <input type="hidden" id="dateid" name="dateid"  value="{$dateid}">
    <input type="hidden" id="suitid" name="suitid"  value="{$suitid}">
    <input type="hidden" id="number" name="number"  value="{$number}">
    <input type="hidden" id="frmcode" name="frmcode"  value="{$frmcode}">
    <input type="hidden" id="usedate" name="usedate"  value="{$starttime}">
    <input type="hidden" id="couponid" name="couponid"  value="">
    {St_Product::form_token()}
</form>

{request "pub/code"}
    {Common::js('layer/layer.m.js')}
    <script>





        var change_node = '';
        $(function(){
            //明细列表
            $("#order-show-list").click(function(){
                $("#fee-box").removeClass("hide")
            });
            $("#fee-box").click(function(){
                $(this).addClass("hide")
            })

            $('.header_top:first').find('.back-link-icon').attr('href',SITEURL+'ship/show_{$info['id']}.html');
            $('.header_top:first').find('.back-link-icon').attr('onclick','');

            set_total_price();

             //选择优惠券
            $('.coupon-list li').click(function() {
                if ($(this).hasClass('choosed'))
                {
                   location.href="#pageHome"
                }
                else
                {
                    $(this).siblings().removeClass('choosed');
                    check_and_set_coupon(eval('('+$(this).attr('data')+')'),$(this));
                }
            });
            //积分
            $('#jifentprice_info').keyup(function()
            {
                var jifenparams = eval('('+$(this).attr('param')+')')
                var jifen = $(this).val();
                if(jifen>jifenparams.toplimit)
                {
                    layer.open({
                        content:'您最多可以使用'+jifenparams.toplimit+'积分',
                        time:1000
                    });
                    clear_jifen();
                }
                else
                {
                    var jifenprice =  jifenparams.jifentprice/jifenparams.toplimit;
                    jifenprice = Math.floor(jifen * jifenprice);
                    $('.jf-use .se-num').text('-{Currency_Tool::symbol()}'+jifenprice)
                    set_total_price();
                }
            })
            //选择常用联系人
            $('.linkman-list li').click(function()
            {
                if($(this).find('.check-icon').hasClass('on'))
                {
                    $(this).find('.check-icon').removeClass('on');
                    $(this).removeClass('choose')
                    change_likman(this,2)
                }
                else
                {
                    var totallength = $('.tour_ul').length;
                    var nowlength = $('.linkman-list li .on').length;
                    if(nowlength<totallength)
                    {
                        $(this).find('.check-icon').addClass('on');
                        $(this).addClass('choose');
                        change_likman(this,1)
                    }
                }
            });
            $('#cardtype-box .fl').click(function(){
                $('#cardtype-box').addClass('hide');
                change_node = '';
            });
            $('#cardtype-box .fr').click(function(){
                var cardtype = $('#cardtype-box .list .active').text();
                if(cardtype=='身份证')
                {
                    $(change_node).next().attr('data-name','idcard')
                }
                else
                {
                    $(change_node).next().attr('data-name','cardtype')
                }
                var flag=  $(change_node).attr('flag')
                $(change_node).html('<input type="hidden" name="cardtype['+flag+']" value="'+cardtype+'">'+cardtype+'<i class="down-ico"></i>');

                $('#cardtype-box').addClass('hide');
                change_node = '';
            });
            $('#cardtype-box .list li').click(function(){

                $('#cardtype-box .list li').removeClass('active')
                $(this).addClass('active')

            })
            $('.sex-bar span').click(function(){
                $(this).parent().find('span').removeClass('checked')
                $(this).addClass('checked');
                $(this).parent().parent().find('input[type=hidden]').val($(this).attr('data'))


            })



            //常用联系人确认
            $('.linkman-group .save-info-btn').click(function(){

                location.href="#pageHome"
            })
            //立即预定
            $('.now-booking-btn').click(function(){
                var validate = requireCheck();
                if(validate)
                {
                    var lkman = $("#linkman").val();
                    var lkmobile = $("#linktel").val();
                    //联系人信息验证
                    if(lkman==''){
                        layer.open({
                            content: '{__("error_linkman_not_empty")}',
                            btn: ['{__("OK")}']
                        });
                        return false;
                    }
                    //联系人手机验证
                    re = /^1\d{10}$/
                    tel = /^\d{3,4}-?\d{7,9}$/
                    if (!re.test(lkmobile)&&!tel.test(lkmobile)) {
                        layer.open({
                            content: '请正确填写您的联系电话(手机/电话皆可)',
                            btn: ['{__("OK")}']
                        });
                        return false;
                    }
                    //订单金额验证
                    set_total_price();
                    $('#bookfrm').submit();


                }
            })




        });



        /**
         * 切换证件类型
         * @param node
         */
        function change_type(node)
        {
            change_node = node;
            var nowtype = $(node).find('input[name=cardtype]').val();
            $('#cardtype-box .list li').removeClass('active')
            $('#cardtype-box .list li').each(function(index,obj){
               if($(obj).text()==nowtype)
               {
                   $(obj).addClass('active')
               }
            });
            $('#cardtype-box').removeClass('hide')
        }


        /**
         * 常用联系人选择
         * @param node
         * @param type 为1的时候是选择 为2的时候是取消
         */
        function change_likman(node,type)
        {
            var span_obj = $(node).find('.checkbox-label');
            var likman = span_obj.attr('data-linkman');
            var sex = span_obj.attr('data-sex');
            var mobile = span_obj.attr('data-mobile');
            var cardid = span_obj.attr('data-idcard');
            var cardtype = span_obj.attr('data-cardtype');

            sex = sex==1 ? '男':'女';
            if(type==1)
            {

                 $('.tourname input').each(function(index,obj){
                    if($(obj).val()=='')
                    {
                        $(obj).val(likman);
                        var tour_ul = $(obj).parent().parent();
                        var flag= tour_ul.attr('data-id')
                        var cardhtml = '<input type="hidden" name="cardtype['+flag+']" value="'+cardtype+'">'+cardtype+'<i class="down-ico"></i>';
                        tour_ul.find('.touridcard .item-hd').html(cardhtml);
                        tour_ul.find('.touridcard .item-hd').next().val(cardid);
                        if(cardtype=='身份证')
                        {
                            tour_ul.find('.touridcard .item-hd').next().attr('data-name','idcard');
                        }
                        else
                        {
                            tour_ul.find('.touridcard .item-hd').next().attr('data-name','cardtype');
                        }
                        tour_ul.find('.toursex input[type=hidden]').val(sex)
                        tour_ul.find('.toursex .sex-bar span').removeClass('checked')
                        tour_ul.find('.toursex .sex-bar span[data='+sex+']').addClass('checked')
                        tour_ul.find('.tourmobile input').val(mobile)
                        return false;
                    }
                 })
            }
            else if(type==2)
            {
                $('.tourname input').each(function(index,obj){
                    if($(obj).val()==likman)
                    {
                        $(obj).val('');
                        var tour_ul = $(obj).parent().parent();
                        var flag= tour_ul.attr('data-id')
                        var cardhtml = '<input type="hidden" name="cardtype['+flag+']" value="身份证">身份证<i class="down-ico"></i>';
                        tour_ul.find('.touridcard .item-hd').html(cardhtml);
                        tour_ul.find('.touridcard .item-hd input').val('');
                        tour_ul.find('.touridcard .item-hd').next().val('');
                        tour_ul.find('.touridcard .item-hd').next().attr('data-name','idcard');
                        tour_ul.find('.toursex input[type=hidden]').val('')
                        tour_ul.find('.tourmobile input').val('')
                        return false;
                    }
                })


            }


        }


        function requireCheck()
        {
           var  flag = true;
            $('.require').each(function(i,obj){


                if($(obj).val()==''){
                    layer.open({
                        content: '请您将游客信息补充完整',
                        btn: ['{__("OK")}']
                    })
                    flag = false;
                }
                var datatype = $(obj).attr('data-name');
                if(datatype == 'idcard'){
                    if(!check_id_card($(obj).val())){
                        layer.open({
                            content: '身份证号码格式不正确',
                            btn: ['{__("OK")}']
                        })

                        flag = false;
                    }
                }
                else if(datatype=='cardtype')
                {
                    var reg = /^[0-9a-zA-Z]+$/;
                    if(!reg.test($(obj).val()))
                    {
                        layer.open({
                            content: '证件号码格式不正确',
                            btn: ['{__("OK")}']
                        })
                        flag = false;
                    }
                }
            })
            return flag;
        }
        function check_id_card(card)
        {
            card=card.toLowerCase();
            var vcity={ 11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"};
            var arrint = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            var arrch = new Array('1', '0', 'x', '9', '8', '7', '6', '5', '4', '3', '2');
            var reg = /(^\d{15}$)|(^\d{17}(\d|x)$)/;
            if(!reg.test(card))return false;
            if(vcity[card.substr(0,2)] == undefined)return false;
            var len=card.length;
            if(len==15)
                reg=/^(\d{6})(\d{2})(\d{2})(\d{2})(\d{3})$/;
            else
                reg=/^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|x)$/;
            var d,a = card.match(new RegExp(reg));
            if(!a)return false;
            if (len==15){
                d = new Date("19"+a[2]+"/"+a[3]+"/"+a[4]);
            }else{
                d = new Date(a[2]+"/"+a[3]+"/"+a[4]);
            }
            if (!(d.getFullYear()==a[2]&&(d.getMonth()+1)==a[3]&&d.getDate()==a[4]))return false;
            if(len=18)
            {
                len=0;
                for(var i=0;i<17;i++)len += card.substr(i, 1) * arrint[i];
                return arrch[len % 11] == card.substr(17, 1);
            }
            return true;
        };

        //检测优惠券有效性
        function check_and_set_coupon(objParams, node) {
            $.ajax({
                type: "post",
                url: SITEURL + 'coupon/ajax_check_samount',
                data: {
                    couponid: objParams.id, //优惠券编号
                    totalprice: '{$totalprice}', //支付总价
                    typeid: '{$typeid}',//产品类型编号
                    proid: '{$info['id']}', //产品编号
                    startdate: '{$starttime}' || '{date("Y-m-d")}' //产品预订时间
                },
                datatype: 'json',
                success: function (data) {
                   data = $.parseJSON(data)
                    if(data.status==1)
                    {
                        if(data.totalprice>0)
                        {
                            $('.coupon-list li').removeClass('choosed');
                            $('.coupon-list li').find('.use-label').hide();
                            $(node).addClass('choosed');
                            $(node).find('.use-label').show();
                            var cprice = objParams.detail;
                            if(objParams.type==1)
                            {
                                cprice += '折'
                            }
                            else
                            {
                                cprice = '{Currency_Tool::symbol()}'+cprice;
                            }
                            $('#couponid').val(objParams.id)
                            $('a[href=#useCoupon]').find('.item').html(' <strong class="no-style">优惠券</strong><em class="type no-style">'+cprice+'</em>')
                            $('a[href=#useCoupon]').find('.more-type').html('已选择<i class="more-ico"></i>')
                            set_total_price();
                            location.href="#pageHome"
                        }
                        else
                        {
                            layer.open({
                               content:'不满足使用条件!',
                                time:1000
                            });
                        }
                    }
                    else
                    {
                        layer.open({
                            content:'不满足使用条件!',
                            time:1000
                        });
                    }
                }
            })
        }

        //清楚优惠券
        function clear_coupon()
        {
            $('.coupon-list li').removeClass('choosed');
            $('.coupon-list li').find('.use-label').hide();
            $('a[href=#useCoupon]').find('.item').html(' <strong class="no-style">优惠券</strong>')
            $('a[href=#useCoupon]').find('.more-type').html('{$countconpon}张可用<i class="more-ico"></i>')

        }
        //清除积分
        function clear_jifen()
        {
            $('#jifentprice_info').val('');
            $('.jf-use .se-num').text('-{Currency_Tool::symbol()}0')
        }
        //计算总价
        function set_total_price()
        {
            var totalprice = '{$totalprice}';
            var  jifenprice = 0;
            var couponprice = 0;
            var jifen_obj = $('#jifentprice_info');
            var jifenparams = eval('('+jifen_obj.attr('param')+')');
            var jifen = jifen_obj.val();
            var userjifen = '{$userinfo['jifen']}';
            if(jifen>Number(userjifen))
            {
                layer.open({
                    content:'您的积分不足!',
                    time:1000
                });
                clear_jifen();
                set_total_price();
                return false;
            }
            if(jifen>0)
            {
                jifenprice =  jifenparams.jifentprice/jifenparams.toplimit;
                jifenprice = Math.floor(jifen * jifenprice);
            }
            var coupon_obj = $('.coupon-list .choosed');
            if(coupon_obj.length>0)
            {

                var couponparams = eval('('+coupon_obj.attr('data')+')');
                if(couponparams.type==1)
                {
                    couponprice = Math.floor(totalprice * (couponparams.detail/10))
                }
                else
                {
                    couponprice = couponparams.detail;
                }
            }
            totalprice = totalprice - jifenprice - couponprice;
            if(totalprice>-1)
            {
                $('.bom-fixed-block .total .jg').text('应付总额：{Currency_Tool::symbol()}'+totalprice);
                $('#fee-box .fee-row .ze .fr').text('{Currency_Tool::symbol()}'+totalprice);
                if(jifenprice>0||couponprice>0)
                {
                    $('#fee-box .mx-list .zk-li').show();
                    if(jifenprice>0)
                    {
                        $('#fee-box .mx-list .zk-jifen').show();
                        $('#fee-box .mx-list .zk-jifen em').text('{Currency_Tool::symbol()}'+jifenprice);
                    }
                    else
                    {
                        $('#fee-box .mx-list .zk-jifen').hide();
                    }
                    if(couponprice>0)
                    {
                        $('#fee-box .mx-list .zk-coupon').show();
                        $('#fee-box .mx-list .zk-coupon em').text('{Currency_Tool::symbol()}'+couponprice);
                    }
                    else
                    {
                        $('#fee-box .mx-list .zk-coupon').hide();
                    }
                }
                else
                {
                    $('#fee-box .mx-list .zk-li').hide();
                    $('#fee-box .mx-list .zk-jifen').hide();
                    $('#fee-box .mx-list .zk-coupon').hide();
                }
            }
            else
            {
                layer.open({
                    content:'订单金额不合法!',
                    time:1000
                });
                clear_coupon();
                clear_jifen();
                set_total_price();
            }
        }

    </script>

</body>
</html>