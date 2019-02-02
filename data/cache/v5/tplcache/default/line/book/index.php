<!doctype html> <html> <head> <meta charset="utf-8"> <title>预订<?php echo $info['title'];?>-<?php echo $GLOBALS['cfg_webname'];?></title> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css_plugin('booking.css','line');?> <?php echo Common::css('base.css,extend.css,stcalendar.css',false);?> <?php echo Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,jquery.validate.js,jquery.validate.addcheck.js');?> <script>
            //预订送积分
            var jifenbook = {
                rewardtype:"<?php echo $jifenbook_info['rewardway'];?>",
                value:"<?php echo $jifenbook_info['value'];?>"
            };
$(function() {
var offsetLeft = new Array();
var windowWidth = $(window).width();
function get_width() {
//设置"down-nav"宽度为浏览器宽度
$(".down-nav").width($(window).width());
$(".st-menu li").hover(function() {
var liWidth = $(this).width() / 2;
$(this).addClass("this-hover");
offsetLeft = $(this).offset().left;
//获取当前选中li下的sub-list宽度
var sub_list_width = $(this).children(".down-nav").children(".sub-list").width();
$(this).children(".down-nav").children(".sub-list").css("width", sub_list_width);
$(this).children(".down-nav").css("left", -offsetLeft);
$(this).children(".down-nav").children(".sub-list").css("left", offsetLeft - sub_list_width / 2 + liWidth);
var offsetRight = windowWidth - offsetLeft;
var side_width = (windowWidth - 1200) / 2;
if(sub_list_width > offsetRight) {
$(this).children(".down-nav").children(".sub-list").css({
"left": offsetLeft - sub_list_width / 2 + liWidth,
"right": side_width,
"width": "auto"
});
}
if(side_width > offsetLeft - sub_list_width / 2 + liWidth) {
$(this).children(".down-nav").children(".sub-list").css({
"left": side_width,
"right": side_width,
"width": "auto"
});
}
}, function() {
$(this).removeClass("this-hover");
});
};
get_width();
$(window).resize(function() {
get_width();
});

//城市站点
$(".head_start_city").hover(function(){
$(this).addClass("change_tab");
},function(){
$(this).removeClass("change_tab");
});
})
            //获得总人数
            function get_total_num() {
                var adult_num = Number($("#adult_num").val());
                var child_num = Number($("#child_num").val());
                var old_num = Number($("#old_num").val());
                adult_num = isNaN(adult_num) ? 0 : adult_num;
                child_num = isNaN(child_num) ? 0 : child_num;
                old_num = isNaN(old_num) ? 0 : old_num;
                return adult_num + child_num + old_num;
            }
</script> </head> <body style=" background: #f6f6f6"> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo $GLOBALS['cfg_indexname'];?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo $channelname;?> </div> <!-- 面包屑 --> <?php if(empty($userInfo['mid'])) { ?> <div class="order-hint-msg-box"> <p class="hint-txt">温馨提示：<a href="javascript:;" onclick="showDialogLogin()" id="fast_login">登录</a>可享受预定送积分、积分抵现！</p> </div> <!-- 温馨提示 --> <?php } ?> <div class="clearfix"> <form id="orderfrm" method="post" action="<?php echo $cmsurl;?>line/create"> <div class="booking-l-container"> <div class="booking-info-block"> <div class="bib-hd-bar"> <h1 class="hb-title"><?php echo $info['title'];?></h1> <div class="hb-number">产品编号：<?php echo $info['series'];?></div> </div> <div class="bib-bd-wrap"> <ul class="booking-item-block"> <li> <span class="item-hd">预订套餐：</span> <div class="item-bd"> <div class="b-item-text"><?php echo $suitInfo['title'];?></div> </div> </li> <li> <span class="item-hd">预订方式：</span> <div class="item-bd"> <div class="b-item-text"><?php if($suitInfo['paytype']==1) { ?>全额预订<?php } else { ?>定金预订<?php } ?> </div> </div> </li> <li> <span class="item-hd">出发日期：</span> <div class="item-bd"> <input type="text" class="input-text w230" id="inputdate" name="usedate" readonly
                                                   value="<?php echo $info['usedate'];?>" /> </div> </li> <li> <span class="item-hd">价格明细：</span> <div class="item-bd"> <table class="booking-price-table people_info"> <thead> <tr> <th width="40%">人群/补差</th> <th width="20%">单价</th> <th width="20%">数量</th> <th width="20%">小计</th> </tr> </thead> <tbody> <?php if(Common::check_instr($suitPrice['propgroup'],2) && $suitPrice['adultprice']) { ?> <tr> <td>成人</td> <td> <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i> <span class="txt_adultprice"><?php echo $suitPrice['adultprice'];?></span> </td> <td> <div class="booking-amount-control"> <span class="sub-btn sub is_order_number">-</span> <input type="text" id="adult_num" name="adult_num" class="number-text" readonly value="<?php echo $adultnum;?>"/> <span class="add-btn add is_order_number">+</span> </div> </td> <td> <span class="o-price adult_total_price"> <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i> </span> </td> </tr> <?php } ?> <?php if(Common::check_instr($suitPrice['propgroup'],1) && $suitPrice['childprice']) { ?> <tr> <td>儿童</td> <td> <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i> <span class="txt_childprice"><?php echo $suitPrice['childprice'];?></span> </td> <td> <div class="booking-amount-control"> <span class="sub-btn  sub is_order_number">-</span> <input type="text" id="child_num" name="child_num" class="number-text" readonly value="<?php echo $childnum;?>"/> <span class="add-btn add is_order_number">+</span> </div> </td> <td> <span class="o-price child_total_price"> <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i> </span> </td> </tr> <?php } ?> <?php if(Common::check_instr($suitPrice['propgroup'],3) && $suitPrice['oldprice']) { ?> <tr> <td>老人</td> <td> <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i> <span class="txt_oldprice"><?php echo $suitPrice['oldprice'];?></span> </td> <td> <div class="booking-amount-control"> <span class="sub-btn sub is_order_number">-</span> <input type="text" id="old_num" name="old_num" class="number-text" readonly value="<?php echo $oldnum;?>"/> <span class="add-btn add is_order_number">+</span> </div> </td> <td> <span class="o-price old_total_price"> <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $suitPrice['oldprice'];?> </span> </td> </tr> <?php } ?> <?php if(($suitPrice['roombalance']>0)) { ?> <tr> <td>单房差</td> <td> <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i> <span class="txt_roombalancerice"><?php echo $suitPrice['roombalance'];?></span> </td> <td> <div class="booking-amount-control"> <span class="sub-btn sub">-</span> <input type="text" id="roombalance_num" name="roombalance_num" class="number-text" readonly value="<?php echo $roomnum;?>"/> <span class="add-btn add">+</span> </div> </td> <td> <span class="o-price roombalance_total_price"> <i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $suitPrice['roombalance'];?> </span> </td> </tr> <?php } ?> </tbody> </table> </div> </li> </ul> </div> </div> <!-- 产品信息 --> <?php echo  Stourweb_View::template("line/book/additional");  ?> <div class="booking-info-block"> <div class="bib-hd-bar"> <span class="col-title">联系人信息</span> </div> <div class="bib-bd-wrap"> <ul class="booking-item-block"> <li> <span class="item-hd"><i class="st-star-ico">*</i>姓名：</span> <div class="item-bd"> <input type="text" class="input-text w230" name="linkman" value="<?php echo $userInfo['truename'];?>" placeholder="" /> </div> </li> <li> <span class="item-hd"><i class="st-star-ico">*</i>手机：</span> <div class="item-bd"> <input type="text" class="input-text w230" name="linktel" value="<?php echo $userInfo['mobile'];?>" placeholder="" /> </div> </li> <li> <span class="item-hd">邮箱：</span> <div class="item-bd"> <input type="text" class="input-text w230" name="linkemail" value="<?php echo $userInfo['email'];?>" placeholder="" /> </div> </li> <li> <span class="item-hd">预订备注：</span> <div class="item-bd"> <textarea name="remark" class="text-area"></textarea> </div> </li> </ul> </div> </div> <!-- 联系人信息 --> <?php echo  Stourweb_View::template("line/book/tourer");  ?> <!--定金支付不享受优惠--> <?php if($suitInfo['paytype']!=2) { ?> <?php echo  Stourweb_View::template("line/book/discount");  ?> <?php } ?> <div class="booking-info-block"> <div class="pay-info-bar"> <?php if($suitInfo['paytype'] == 2) { ?> <span class="item">应付定金：<span class="pri dingjin-total-price"></span></span> <?php } else { ?> <span class="item">应付总额：<span class="pri pay-total-price"></span></span> <?php } ?> <span class="c-999 ml10 jifenbook"></span> <div class="mt10 c-999" id="left-dg-info"></div> </div> </div> <!-- 应付总额 --> <?php if($GLOBALS['cfg_invoice_open_1']==1) { ?> <?php echo Request::factory("invoice/choose/typeid/1")->execute()->body(); ?> <?php } ?> <div class="booking-info-block clearfix"> <?php echo  Stourweb_View::template("line/book/agreement");  ?> <div class="fr booking-submit-block"> <span class="yzm-txt">验证码：</span> <img class="yzm-label" src="<?php echo $cmsurl;?>captcha" onClick="this.src=this.src+'?math='+ Math.random()" width="80" height="30"/> <input type="text" name="checkcode" id="checkcode" maxlength="4" class="input-text w100 ml10" /> <a class="booking-submit-btn ml10" href="javascript:;">提交订单</a> </div> </div> <!-- 协议、合同 --> </div> <?php echo  Stourweb_View::template("line/book/settlement");  ?> <!--隐藏域--> <input type="hidden" name="suitid" id="suitid" value="<?php echo $suitInfo['id'];?>"/> <input type="hidden" name="lineid" id="lineid" value="<?php echo $info['id'];?>"/> <input type="hidden" name="store" id="store" value="<?php echo $suitPrice['number'];?>"/> <!--<input type="hidden" name="usedate" value="<?php echo $info['usedate'];?>"/>--> <input type="hidden" name="webid" value="<?php echo $info['webid'];?>"/> <input type="hidden" name="frmcode" value="<?php echo $frmcode;?>"><!--安全校验码--> <input type="hidden" name="usejifen" id="usejifen" value="0"/><!--是否使用积分--> <input type="hidden" id="ins_total_price" value="0"/> <!--保险总价--> <input type="hidden" id="jifentprice" value="<?php echo $suitInfo['jifentprice'];?>"><!--积分抵现金额--> <input type="hidden" id="oldprice" value="<?php echo $suitPrice['oldprice'];?>"><!--老人价格--> <input type="hidden" id="childprice" value="<?php echo $suitPrice['childprice'];?>"><!--小孩价格--> <input type="hidden" id="adultprice" value="<?php echo $suitPrice['adultprice'];?>"><!--成人价格--> <input type="hidden" id="roombalance_price" value="<?php echo $suitPrice['roombalance'];?>"><!--单房差价格--> <input type="hidden" id="total_price" value=""/> <input type="hidden" id="coupon_price" value=""/> <input type="hidden" id="envelope_price" value=""/> <input type="hidden" id="paytype" value="<?php echo $suitInfo['paytype'];?>"/> <input type="hidden" id="dingjin" value="<?php echo $suitInfo['dingjin'];?>"/> </form> </div> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Common::js('layer/layer.js',0);?> <div id="calendar" style="display:none"></div> <script>
            //游客信息
            var is_tourer_open = "<?php echo $GLOBALS['cfg_write_tourer'];?>";
$(function() {
                //出发日期选择
                $("#inputdate").click(function () {
                    var suitid = $("#suitid").val();
                    var date = $(this).val().split('-');
                    get_calendar(suitid, this, date[0], date[1]);
                });
                //日历切换
                $('body').delegate('.prevmonth,.nextmonth', 'click', function () {
                    var year = $(this).attr('data-year');
                    var month = $(this).attr('data-month');
                    var suitid = $(this).attr('data-suitid');
                    var contain = $(this).attr('data-contain');
                    get_calendar(suitid, $("#" + contain)[0], year, month);
                });
                //数量减少
                $('body').delegate('.sub-btn','click',function(){
                    var obj = $(this).parent().find('.number-text');
                    var cur = Number(obj.val());
                    if (cur > 0) {
                        cur = cur - 1;
                        obj.val(cur);
                        var total = get_total_num();
                        if (total <= 0) {
                            $('.booking-submit-btn').addClass('disabled');
                            //避免多人群不可单独选择
                            if($(".number-text").length>1)
                            {
                                obj.val(cur);
                            }
                            else
                            {
                                obj.val(cur + 1);
                            }
                        }else{
                            $('.booking-submit-btn').removeClass('disabled');
                            if($(this).hasClass('is_order_number')){
                                if(typeof(remove_tourer)=='function'){
                                    remove_tourer();
                                }
                            }
                        }
                    }
                    if(typeof(set_insurance_num)=='function')
                    {
                        set_insurance_num();
                    }
                    get_total_price();
                });
                //数量添加
                $('body').delegate('.add-btn','click',function(){
                    var obj = $(this).parent().find('.number-text');
                    var cur = Number(obj.val());
                    var total = get_total_num();
                    var store = $('#store').val();
                    if(store!=-1&&store<(total+1))
                    {
                        return false;
                    }
                    obj.val(cur + 1);
                    $('.booking-submit-btn').removeClass('disabled');
                    if($(this).hasClass('is_order_number'))
                    {
                        //添加游客
                        //add_tourer();
                        if(typeof(add_tourer)=='function'){
                            add_tourer();
                        }
                    }
                    //设置保险
                    if(typeof(set_insurance_num)=='function')
                    {
                        set_insurance_num();
                    }
                    get_total_price();
                });
//结算固定
                var windowHeight = $(window).height();
                var offSetTop = $(".booking-side-total").offset().top;
                $(window).scroll(function(){
                    if( $(window).scrollTop() > offSetTop ){
                        $(".booking-side-total").addClass("booking-side-fixed");
                        if( $(".booking-side-total").height() > windowHeight ){
                            $(".booking-side-fixed").css({
                                "bottom":"0",
                                "overflow-y":"auto"
                            })
                        }
                    }
                    else{
                        $(".booking-side-total").removeClass("booking-side-fixed")
                    }
                })
                //提交订单
                $('.booking-submit-btn').click(function () {
                    if($(this).hasClass('disabled'))
                    {
                        return false;
                    }
                    $("#orderfrm").submit();
                })
                //表单验证
                $("#orderfrm").validate({
                    submitHandler: function(form) {
                        //判断总人数,必须>0
                        var dingnum = get_total_num();
                        if(dingnum < 1){
                            layer.open({
                                content: '请选择预订人数',
                                btn: ['<?php echo __("OK");?>']
                            });
                            return false;
                        }
                        if($('#agreementBookingCheck').length>0 && !$('#agreementBookingCheck').hasClass('active'))
                        {
                            layer.open({
                                content: '请确认同意并阅读预订须知',
                                btn: ['<?php echo __("OK");?>']
                            });
                            return false;
                        }
                        var flag = check_storage();
                        if(!flag){
                            layer.open({
                                content: '<?php echo __("error_no_storage");?>',
                                btn: ['<?php echo __("OK");?>']
                            });
                            return false;
                        }else{
                            ST.Util.showLoading({isfade:true,text:'提交中...'});
                            form.submit();
                        }
                    },
                    errorClass: 'error-txt',
                    errorElement: 'span',
                    rules: {
                        linkman: {
                            required: true
                        },
                        linktel: {
                            required: true,
                            isPhone: true
                        },
                        linkemail:{
                            email:true
                        },
                        checkcode: {
                            required: true,
                            minlength:4,
                            remote: {
                                param: {
                                    url: SITEURL + 'line/ajax_check_code',
                                    type: 'post',
                                },
                                depends : function(element) {
                                    return element.value.length==4;
                                },
                            }
                        }
                    },
                    messages: {
                        linkman: {
                            required: "请填写联系人信息"
                        },
                        linktel: {
                            required: "请填写联系方式"
                        },
                        linkemail:{
                            email:'邮箱格式错误'
                        },
                        needjifen:{
                            digits:'请输入数字',
                            min:'不得小于0',
                            max:'超过抵扣上限'
                        },
                        checkcode: {
                            required: "请填写验证码",
                            minlength: "",
                            remote: "验证码错误"
                        }
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).attr('style', 'border:1px solid red');
                    },
                    unhighlight: function (element, errorClass) {
                        $(element).attr('style', '');
                    },
                    errorPlacement: function (error, element) {
                        if (element.is('#checkcode')) {
                            if ($(error).text() != '') {
                                layer.tips('验证码错误', '#checkcode', {
                                    tips: 3
                                });
                            }
                        }
                        else if (element.is('#needjifen')) {
                            $(".jifen-error").append(error);
                        }
                        else if (element.hasClass('tour_txt'))
                        {
                            error.appendTo(element.parents('li'));
                        }
                        else
                        {
                            $(element).parent().append(error)
                        }
                    }
                });
                if(is_tourer_open==1){
                    add_tourer();
                }
                check_book_num();
                get_total_price();
})
            //检查现有预定数量是否符合要求
            function check_book_num() {
                var total = get_total_num();
                var store = $('#store').val();
//                console.log(total,store);
                if(store!='-1')
                {
                    if(total>store){
                        $('.booking-submit-btn').addClass('disabled');
                    }else{
                        $('.booking-submit-btn').removeClass('disabled');
                    }
                }else{
                    $('.booking-submit-btn.disabled').removeClass('disabled');
                }
            }
            function get_calendar(suitid, obj, year, month) {
                //加载等待
                layer.open({
                    type: 3,
                    icon: 2
                });
                var containdiv = '';
                if (obj) {
                    containdiv = $(obj).attr('id');
                }
                var url = SITEURL + 'line/dialog_calendar';
                var lineid = $('#lineid').val();
                $.post(url, {
                    suitid: suitid,
                    year: year,
                    month: month,
                    containdiv: containdiv,
                    lineid: lineid
                }, function (data) {
                    if (data) {
                        $("#calendar").html(data);
                        $("#calendar").data(suitid, data);
                        show_calendar_box();
                    }
                })
            }
            function show_calendar_box() {
                layer.closeAll();
                layer.open({
                    type: 1,
                    title: '',
                    area: ['480px', '430px'],
                    shadeClose: true,
                    content: $('#calendar').html()
                });
            }
            //选择日期
            function choose_day(day, containdiv) {
                var suitid = $("#suitid").val();
                var url = SITEURL + 'line/ajax_price_day';
                $.getJSON(url, {'useday': day, 'suitid': suitid}, function (data) {
                    set_people_tr(data);
                    $('#adultprice').val(data.adultprice);
                    $('#childprice').val(data.childprice);
                    $('#oldprice').val(data.oldprice);
                    $("#roombalance_price").val(data.roombalance);
                    $('.usedate').text(day);
                    //设置结算信息.
                    get_total_price();
                });
                $('#' + containdiv).val(day);
                layer.closeAll();
            }
            //设置可预定人群
            function set_people_tr(data) {
                var adult_num = $('#adult_num').val() ? $('#adult_num').val() : 2;
                var child_num = $('#child_num').val() ? $('#child_num').val() : 0;
                var old_num = $('#old_num').val() ? $('#old_num').val() : 0 ;
                var roombalance_num = $('#roombalance_num').val() ? $('#roombalance_num').val() : 0;
                $('.people_info tr:not(:first)').remove();
                var html = '';
                if(Number(data.adultprice)>0)
                {
                    html+= people_templeate_relace('成人','txt_adultprice','adult_num','adult_total_price',adult_num);
                }
                if(Number(data.childprice)>0)
                {
                    html+= people_templeate_relace('小孩','txt_childprice','child_num','child_total_price',child_num);
                }
                if(Number(data.oldprice)>0)
                {
                    html+= people_templeate_relace('老人','txt_oldprice','old_num','old_total_price',old_num);
                }
                if(Number(data.roombalance)>0)
                {
                    html+= people_templeate_relace('单房差','txt_roombalanceprice','roombalance_num','roombalance_total_price',roombalance_num);
                }
                $('.people_info tbody').append(html)
                if(is_tourer_open){
                    add_tourer();
                }
            }
            //人群信息模板替换
            function people_templeate_relace(kind,txtpricename,numbername,totalpricename,num){
                //变量
                // {{kind}}=>类别 成人
                // {{txtpricename}} => 单价容器 txt_adultprice;
                // {{numbername}} =>人数容器 adult_num;
                // {{totalpricename}} => 总价容器 adult_total_price
                var template = ' <tr>';
                template+=' <td>{{kind}}</td>';
                template+=' <td>';
                template+=' <i class="currency_sy">'+CURRENCY_SYMBOL+'</i>';
                template+='<span class="{{txtpricename}}"></span>';
                template+=' </td>';
                template+='<td>';
                template+='  <div class="booking-amount-control">';
                if(kind!='单房差'){
                    template+='<span class="sub-btn sub is_order_number">-</span>';
                    template+='<input type="text" id="{{numbername}}" name="{{numbername}}" class="number-text" readonly value="{{num}}"/>';
                    template+='<span class="add-btn add is_order_number">+</span>';
                }else{
                    template+='<span class="sub-btn sub">-</span>';
                    template+='<input type="text" id="{{numbername}}" name="{{numbername}}" class="number-text" readonly value="{{num}}"/>';
                    template+='<span class="add-btn add">+</span>';
                }
                template+='</div>';
                template+='</td>';
                template+='<td>';
                template+='<span class="o-price {{totalpricename}}">';
                template+='<i class="currency_sy">'+CURRENCY_SYMBOL+'</i>';
                template+='</span>';
                template+='</td>';
                template+='</tr>';
                var html = '';
                html = template.replace(/\{\{kind\}\}/g,kind);
                html = html.replace(/\{\{txtpricename\}\}/g,txtpricename);
                html = html.replace(/\{\{numbername\}\}/g,numbername);
                html = html.replace(/\{\{totalpricename\}\}/g,totalpricename);
                html = html.replace(/\{\{num\}\}/g,num);
                return html;
            }
            //检测库存
            function check_storage() {
                var startdate = $("#inputdate").val();
                var dingnum = get_total_num();
                var productid = $("#lineid").val();
                var suitid = $("#suitid").val();
                var flag = 1;
                $.ajax({
                    type: 'POST',
                    url: SITEURL + 'line/ajax_check_storage',
                    data: {startdate: startdate,  dingnum: dingnum, productid: productid,suitid:suitid},
                    async: false,
                    dataType: 'json',
                    success: function (data) {
                        flag = data.status;
                    }
                })
                return flag;
            }
    </script> <?php if(empty($userInfo['mid'])) { ?> <?php echo  Stourweb_View::template("member/login_dialog");  ?> <?php } ?> </body> </html>