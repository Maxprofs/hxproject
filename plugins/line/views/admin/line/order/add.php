<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加订单</title>
    {template 'stourtravel/public/public_min_js'}
    {Common::getCss('style.css,style-new.css,base.css,order-manage.css,base_new.css')}
    {Common::getScript("jquery.validate.js,choose.js,jquery.validate.addcheck.js")}
    <script type="text/javascript" src="/res/js/city/jquery.cityselect.js"></script>
    <script>
        window.CURRENCY_SYMBOL="{Currency_Tool::symbol()}";
    </script>
</head>
<body>
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow-y: hidden">

       <form method="post" id="frm" name="frm" head_ul=cHACXC >

        <div class="order-info-container">
            <div class="order-info-bar"><strong class="bt-bar">订单信息</strong><a href="javascript:;" class="fr btn btn-primary radius mt-2 mr-10" onclick="window.location.reload()">刷新</a></div>
            <div class="order-info-block">
                <ul>

                    <li>
                        <strong class="item-hd">预订会员：</strong>
                        <div class="item-bd">
                            <a href="javascript:;" class="btn btn-primary radius size-S choose-member" title="选择">选择</a>

                        </div>

                    </li>
                    <li>
                        <strong class="item-hd">产品名称：</strong>
                        <div class="item-bd">
                            <a href="javascript:;" class="btn btn-primary radius size-S choose-product mt-2" title="选择">选择</a>

                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">选择套餐：</strong>
                        <div class="item-bd">
                            <select name="suitid" class="drop-down wid_300" id="suit_list" onchange="">

                            </select>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">出发日期：</strong>
                        <div class="item-bd">
                            <div class="choose-start-date">
                                <input type="text" class="date-text choose-date" id="usedate" name="usedate" placeholder="选择出发日期"   />
                                <i class="date-icon"></i>
                            </div>
                        </div>
                    </li>
                </ul>
                <table class="user-info-table mt-5">
                    <thead>
                    <tr>
                        <td width="20%">预订数量</td>
                        <td width="15%">单价</td>
                        <td width="15%">总计</td>
                        <td>&nbsp;</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="group_adult" style="display:none">
                        <td>
                            <span class="type wid_40">成人</span>
                            <span class="amount-opt-wrap">
                                <a href="javascript:;" class="sub-btn">&ndash;</a>
                                <input type="text" class="num-text" name="adult_num" id="adult_num" maxlength="4" value="0" />
                                <a href="javascript:;" class="add-btn">&#43;</a>
                            </span>
                            <span class="unit">人</span>
                        </td>
                        <td><span class="cor_666 adult_price_single_txt">&yen;1500</span></td>
                        <td><span class="color_f60 adult_price_total_txt">&yen;1500</span></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr id="group_child" style="display:none">
                        <td>
                            <span class="type wid_40">儿童</span>
                            <span class="amount-opt-wrap">
                                <a href="javascript:;" class="sub-btn">&ndash;</a>
                                <input type="text" class="num-text" name="child_num" id="child_num" maxlength="4" value="0" />
                                <a href="javascript:;" class="add-btn">&#43;</a>
                            </span>
                            <span class="unit">人</span>
                        </td>
                        <td><span class="cor_666 child_price_single_txt">&yen;1500</span></td>
                        <td><span class="color_f60 child_price_total_txt">&yen;1500</span></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr id="group_old" style="display:none">
                        <td>
                            <span class="type wid_40">老人</span>
                            <span class="amount-opt-wrap">
                                <a href="javascript:;" class="sub-btn">&ndash;</a>
                                <input type="text" class="num-text" name="old_num" id="old_num" maxlength="4" value="0" />
                                <a href="javascript:;" class="add-btn">&#43;</a>
                            </span>
                            <span class="unit">人</span>
                        </td>
                        <td><span class="cor_666 old_price_single_txt">&yen;1500</span></td>
                        <td><span class="color_f60 old_price_total_txt">&yen;1500</span></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr id="group_room" style="display:none">
                        <td>
                            <span class="type wid_40">单房差</span>
                            <span class="amount-opt-wrap">
                                <a href="javascript:;" class="sub-btn">&ndash;</a>
                                <input type="text" class="num-text" name="room_balance_num" id="room_balance_num" maxlength="4" value="0" />
                                <a href="javascript:;" class="add-btn">&#43;</a>
                            </span>
                            <span class="unit">人</span>
                        </td>
                        <td><span class="cor_666 room_balance_single_txt">&yen;1500</span></td>
                        <td><span class="color_f60 room_balance_total_txt">&yen;1500</span></td>
                        <td>&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- 订单信息 -->

        <div class="order-info-container">
            <div class="order-info-bar"><strong class="bt-bar">联系人信息</strong></div>
            <div class="order-info-block">
                <ul>
                    {if $config['cfg_write_tourer']==1}
                	<li>
                		<strong class="item-hd">旅客信息：</strong>
                		<div class="item-bd">
                			<table class="table table-bg table-bordered table-border">
                				<thead>
                					<tr>
                						<th width="15%" class="pl-5">姓名</th>
                						<th width="15%" class="pl-5">性别</th>
                						<th width="25%" class="pl-5">手机号</th>
                						<th width="10%" class="pl-5">证件类型</th>
                						<th width="35%" class="pl-5">证件号码</th>
                					</tr>
                				</thead>
                				<tbody id="tourer_list">


                				</tbody>
                			</table>
                		</div>
                	</li>
                    {/if}
                    <li>
                        <strong class="item-hd">联系人姓名：</strong>
                        <div class="item-bd">
                            <input type="text" class="default-text" name="linkman"/>
                            <span class="star-note-ico">&#42;</span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">联系人电话：</strong>
                        <div class="item-bd">
                            <input type="text" class="default-text" name="linktel" />
                            <span class="star-note-ico">&#42;</span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">联系人邮箱：</strong>
                        <div class="item-bd">
                            <input type="text" class="default-text" name="linkemail" />
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">预订说明：</strong>
                        <div class="item-bd">
                            <textarea  class="default-textarea" name="remark"></textarea>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 联系人信息 -->
        {if $config['cfg_bill_open']==1}
        <div class="order-info-container">
            <div class="order-info-bar"><strong class="bt-bar">发票信息</strong></div>
            <div class="order-info-block">
                <ul>
                    <li>
                        <strong class="item-hd">发票金额：</strong>
                        <div class="item-bd">
                            <span class="receipt-num pay_total_price"></span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">发票明细：</strong>
                        <div class="item-bd">
                            <span class="receipt-type">旅游费</span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">发票抬头：</strong>
                        <div class="item-bd">
                            <input type="text" class="default-text wid_460" name="bill_title"  placeholder="填写个人姓名或公司全称" />
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">收件人姓名：</strong>
                        <div class="item-bd">
                            <input type="text" class="default-text wid_150" name="bill_receiver" placeholder="写收件人真实姓名" />
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">收件人电话：</strong>
                        <div class="item-bd">
                            <input type="text" class="default-text wid_150" name="bill_phone" placeholder="填写收件人电话" />
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">邮寄地址：</strong>
                        <div class="item-bd" id="city">
                            <select name="bill_prov" class="dest-select prov drop-down wid_150">
                                <option value="请选择">请选择</option>
                            </select>
                            <select name="bill_city" class="dest-select city drop-down wid_150">
                                <option value="请选择">请选择</option>
                            </select>
                            <input type="text" class="default-text wid_460 ml-5" name="bill_address" placeholder="填写详细收货地址" />
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <script>
            $(function(){
                //城市选择
                $("#city").citySelect({
                    nodata:"none",
                    required:false
                });
            })
        </script>
        {/if}
        <!-- 发票信息 -->

        <div class="order-info-container mb-50">
            <div class="order-info-bar"><strong class="bt-bar">订单状态</strong></div>
            <div class="order-info-block">
                <ul>

                    <li>
                        <strong class="item-hd">订单状态：</strong>
                        <div class="item-bd">
                            {loop $statusnames $row}
                                {if $row['status']!=6 && $row['status']!=0}
                                 <label class="radio-label mr-30"><input type="radio" name="status" {if $row['status']==2}checked{/if} value="{$row['status']}">{$row['name']}</label>
                                {/if}
                            {/loop}

                        </div>
                    </li>

                  <!--  <li>
                        <strong class="item-hd">备注说明：</strong>
                        <div class="item-bd">
                            <textarea name="admin_remark" class="default-textarea mt-8" placeholder="管理员备注的一些想要针对订单说明的内容"></textarea>
                        </div>
                    </li>-->
                </ul>
            </div>
        </div>
        <!-- 支付信息 -->

        <div class="order-amount-bar">
            <span class="item">原价合计：<strong class="color_f60 org_total_price">&yen;0</strong></span>
            <span class="item">优惠合计：<strong class="color_f60 privilege_total_price">-&yen;0</strong></span>
            <span class="item">支付总计：<strong class="color_f60 pay_total_price"><b>&yen;0</b></strong></span>
            <div class="fr">
                <a class="btn btn-primary size-L radius ml-5 va-m" id="btn_save" href="javascript:;">保存</a>
            </div>
        </div>
        <!-- 总计价格 -->
        <input type="hidden" id="member_id" name="member_id" value="0"/>
        <input type="hidden" id="product_id" name="product_id" value="0"/>
        <input type="hidden" id="adult_price" name="adult_price" value="0"/>
        <input type="hidden" id="child_price" name="child_price" value="0"/>
        <input type="hidden" id="old_price" name="old_price" value="0"/>
        <input type="hidden" id="room_balance_price" name="room_balance_price" value="0"/>

        </form>

        </td>
    </tr>
</table>
<div id="calendar" style="display: none"></div>
<script>
    var isSaving = false;
    $(function(){
        var typeid = "{$typeid}";

        //选择会员
        $('.choose-member').click(function(){
            CHOOSE.setSome("选择会员",{loadCallback:setMember,maxHeight:525,width:800},SITEURL+'member/dialog_member_list',true);

        })
        $("body").delegate('.delete-member','click',function(){
             $('#member_id').val(0);
             $(this).parent().remove();
        })

        //选择产品
        $('.choose-product').click(function(){
            CHOOSE.setSome("选择产品",{loadCallback:setProduct,maxHeight:500,width:800},SITEURL+'comment/dialog_product_list?typeid='+typeid,true);

        })

        $('body').delegate('.delete-product','click',function(){
            $('#product_id').val(0);
            $(this).parent().remove();
        })

        //选择出发日期
        $('.choose-date').click(function(){
            var suit_id = parseInt($('#suit_list').val());
            if(!suit_id){
                ST.Util.showMsg('请先选择套餐',5,1000);
                return false;
            }else{
                //出发日期选择
                    get_calendar(suit_id);
            }

        })

        //数量减少
        $('.sub-btn').click(function(){
            var obj = $(this).parent().find('input');
            var num = parseInt(obj.val());
            if(num>0){
                obj.val(num-1);
                get_total_price();

                if($(this).parents('#group_room').length==0)
                {
                    remove_tourer();
                }
            }

        })
        //数量增加
        $('.add-btn').click(function(){
            var obj = $(this).parent().find('input');
            var num = parseInt(obj.val());
            obj.val(num+1);
            get_total_price();
            if($(this).parents('#group_room').length==0)
            {
                add_tourer();
            }
        })
     

        //提交订单
        $('#btn_save').click(function(){
            $('#frm').submit();
        })
        //表单验证

        $("#frm").validate({
            ignore: [],
            focusInvalid:false,
            rules: {
                suitid:
                    {
                        required:true
                    },
                usedate:
                {
                    required: true
                },
                linkman:
                {
                    required: true
                },
                linktel:
                {
                    required:true
                }


            },
            messages: {
                suitid:{
                   required:'请选择套餐'
                },
                usedate:
                {
                    required:''
                },

                linkman:
                {
                    required:"联系人不能为空"
                },
                linktel:
                {
                    required:"联系人手机不能为空"
                }
            },
            errUserFunc:function(element){


            },
            submitHandler:function(form){

             
                if(product_id==0){
                    ST.Util.showMsg('请选择产品',5);
                    return false;
                }
                var adult_num = Number($('#adult_num').val());
                var child_num = Number($('#child_num').val());
                var old_num = Number($('#old_num').val());
                var total_num = adult_num + child_num + old_num;
                if(total_num<=0){
                    ST.Util.showMsg('预订人数不能为0',5);
                    return false;
                }

                if(!isSaving){
                    isSaving = true;
                    $.ajax({
                        type:'POST',
                        url:SITEURL+'line/admin/order/ajax_save_order',
                        data:$('#frm').serialize(),
                        dataType:'json',
                        beforeSend :function(){
                            ST.Util.showMsg('保存中',6,1000000);
                            $('#btn_save').addClass('disabled')
                        },
                        success:function(data){

                            if(data.status){
                                ST.Util.showMsg('订单添加成功',4);
                                setTimeout(function(){
                                    location.reload();
                                },1000)

                            }else{
                                var msg = data.msg ? data.msg : '订单添加失败';
                                ST.Util.showMsg(msg, 5);
                                isSaving = false;
                            }
                        },
                        complete: function () {
                           ST.Util.closeBox();
                            $('#btn_save').removeClass('disabled');
                        },
                    })


                }


            
            }

        })


    })


    /*计算总价*/
    function get_total_price()
    {
        var adult_num = Number($("#adult_num").val());
        var child_num = Number($("#child_num").val());
        var old_num = Number($("#old_num").val());
        adult_num = isNaN(adult_num) ? 0 : adult_num;
        child_num = isNaN(child_num) ? 0 : child_num;
        old_num = isNaN(old_num) ? 0 : old_num;

        var adult_price = $("#adult_price").val();
        var child_price = $("#child_price").val();
        var old_price = $("#old_price").val();

        //按人群价格
        var adult_total_price = mul(adult_num, adult_price);// adult_num * adult_price;
        var child_total_price = mul(child_num, child_price);
        var old_total_price = mul(old_num, old_price);

        //单房差
        var room = $("#room_balance_num").val();
        var room_num = room == undefined ? 0 : Number(room);
        var room_price = $("#room_balance_price").val();
        var room_total_price = mul(room_num, room_price);

        $('.adult_price_total_txt').html(CURRENCY_SYMBOL+adult_total_price);
        $('.child_price_total_txt').html(CURRENCY_SYMBOL+child_total_price);
        $('.old_total_price_txt').html(CURRENCY_SYMBOL+old_total_price);
        $('.room_balance_total_txt').html(CURRENCY_SYMBOL+room_total_price);

        //总计原价
        var org_total_price = adult_total_price+child_total_price+old_total_price+room_total_price;
        var privilege_total_price = 0;
        var pay_total_price = org_total_price-privilege_total_price;

        $('.org_total_price').html(CURRENCY_SYMBOL+org_total_price);
        $('.privilege_total_price').html(CURRENCY_SYMBOL+privilege_total_price);
        $('.pay_total_price').html(CURRENCY_SYMBOL+pay_total_price);






    }
    function setMember(result,bool)
    {

        var html = '<span class="choose-child-item ml-10">'+result.title+'<i class="close-icon delete-member" data-id="'+result.id+'" ></i></span>';
        $("#member_id").val(result.id);
        $(".choose-member").after(html);
        $("#frm").valid();
    }
    function setProduct(result,bool)
    {

        var html = '<span class="choose-child-item ml-10">'+result.title+'<i class="close-icon delete-product" data-id="'+result.id+'" ></i></span>';
        $("#product_id").val(result.id);
        $(".choose-product").after(html);
        $("#frm").valid();
        get_suit_list();
    }



    //获取套餐
    function get_suit_list(){
        var product_id = $('#product_id').val();
        $.ajax({
            type:'POST',
            url:SITEURL+'line/admin/line/ajax_suit_list',
            data:{product_id:product_id},
            dataType:'json',
            success:function(data){
                if(data.status){
                    $('#suit_list').empty();
                    var html ='<option value="0">请选择套餐</option>';
                    $.each(data.list,function(i,row){
                        html += '<option value="'+row.id+'" data-group='+row.propgroup+'>'+row.suitname+'</option>';
                    })
                    $('#suit_list').append(html);
                }
            }

        })
    }

    //获取套餐具体报价
    function get_suit_price(day,bool){
        var params = {
            suit_id:$('#suit_list').val(),
            useday :day

        };
        $.getJSON(SITEURL+'line/admin/line/ajax_suit_price',params,function(data){

            var total_price = 0;
            if(data.adultprice>0){
                $('#group_adult').show();
                $('#adult_num').val(1);
                $('#adult_price').val(data.adultprice);
                $('.adult_price_single_txt,.adult_price_total_txt').html(CURRENCY_SYMBOL+data.adultprice);
                total_price+=data.adultprice;

            }else{
                $('#group_adult').hide();
                $('#adult_num').val(0);
                $('#adult_price').val(0);
                $('.adult_price_single_txt,.adult_price_total_txt').html(CURRENCY_SYMBOL+'0');

            }
            if(data.childprice>0){
                $('#group_child').show();
                $('#child_price').val(data.childprice);
                $('#child_num').val(1);
                $('.child_price_single_txt,.child_price_total_txt').html(CURRENCY_SYMBOL+data.childprice);
                total_price+=data.childprice;
            }else{
                $('#group_child').hide();
                $('#child_price').val(0);
                $('#child_num').val(0);
                $('.child_price_single_txt,.child_price_total_txt').html(CURRENCY_SYMBOL+'0');
            }
            if(data.oldprice>0){
                $('#group_old').show();
                $('#old_price').val(data.oldprice);
                $('#old_num').val(1);

                $('.old_price_single_txt,.old_price_total_txt').html(CURRENCY_SYMBOL+data.oldprice);
                total_price+=data.oldprice;
            }else{
                $('#group_old').hide();
                $('#old_price').val(0);
                $('#old_num').val(0);
                $('.old_price_single_txt,.old_price_total_txt').html(CURRENCY_SYMBOL+'0');
            }
            if(data.roombalance>0){
                $('#group_room').show();
                $('#room_balance_price').val(data.roombalance);
                $('.room_balance_single_txt').html(CURRENCY_SYMBOL+data.roombalance);
                $('.room_balance_total_txt').html(CURRENCY_SYMBOL+0);
            }else{
                $('#group_room').hide();
                $('#room_balance_price').val(0);
            }
            $('.org_total_price,.pay_total_price').html(CURRENCY_SYMBOL+total_price);
            add_tourer();
            ST.Util.closeDialog();

        })
    }
    function get_calendar(suit_id,year,month) {

        var width = 500;
        var height = 430;
        var lineid = $('#product_id').val();
        var url = SITEURL + 'line/admin/calendar/dialog_calendar/suitid/'+suit_id+'/lineid/'+lineid;
        CHOOSE.setSome("选择预订日期",{loadCallback:get_suit_price,maxHeight:height,width:width},url,true);


    }

    function mul(a, b) {
        var c = 0,
            d = a.toString(),
            e = b.toString();
        try {
            c += d.split(".")[1].length;
        } catch (f) {}
        try {
            c += e.split(".")[1].length;
        } catch (f) {}
        return Number(d.replace(".", "")) * Number(e.replace(".", "")) / Math.pow(10, c);
    }

    /*生成tourer html*/
    function add_tourer() {

        var adult_num = parseInt($("#adult_num").val());
        var child_num = parseInt($("#child_num").val());
        var old_num = parseInt($("#old_num").val());

        adult_num = isNaN(adult_num) ? 0 : adult_num;
        child_num = isNaN(child_num) ? 0 : child_num;
        old_num = isNaN(old_num) ? 0 : old_num;
        var total_num = adult_num + child_num + old_num;
        var html = '';
        var hasnum = $("#tourer_list").find('tr').length;

        while(hasnum>total_num){
            remove_tourer();
            hasnum--;
        }


        for (var i = hasnum; i < total_num; i++) {
           html+=' <tr>';
           html+= '<td class="pl-5"><input type="text" class="input-text w100" name="t_name[' + i + ']" /></td>';
           html+= '<td class="pl-5"><span class="select-box w100">';
            html += '<select class="t_cardtype select" name="t_sex[' + i + ']">';
            html += '<option value="男">男</option>';
            html += '<option value="女">女</option>';
            html += '</select></span></td>';
            html+= '<td class="pl-5"><input type="text" class="input-text w150" name="t_mobile[' + i + ']" /></td>';
            html+= '<td class="pl-5"><span class="select-box w100">';
            html += '<select class="t_cardtype select" name="t_cardtype[' + i + ']">';
            html += '<option value="身份证">身份证</option>';
            html += '<option value="护照">护照</option>';
            html += '<option value="台胞证">台胞证</option>';
            html += '<option value="港澳通行证">港澳通行证</option>';
            html += '<option value="军官证">军官证</option>';
            html += '<option value="出生日期">出生日期</option>';
            html += '</select></span></td>';
            html += '<td class="pl-5"><input type="text" class="input-text w200 t_cardno" name="t_cardno[' + i + ']" /></td>'
            html +='</tr>';

        }
        $("#tourer_list").append(html);

        //动态添加游客姓名
        $("input[name^='t_name']").each(
            function (i, obj) {
                //console.log(obj);
                //$(obj).rules("remove");
                $(obj).rules("add", {required: true, messages: {required: "请输入姓名"}});
            }
        );
        //证件类型
        $("input[name^='t_cardno']").each(
            function (i, obj) {
                $(obj).rules("remove");
                $(obj).rules("add", {required: true, messages: {required: "请输入证件号"}});
            }
        );
        //手机号
        $("input[name^='t_mobile']").each(
            function (i, obj) {
                $(obj).rules("remove");
                $(obj).rules("add", {required: true,isPhone:true, messages: {required: "请输入手机号",isPhone:'请输入正确的手机号'}});
            }
        )

    }
    /*移除tourer*/
    function remove_tourer() {
        $("#tourer_list tr").last().remove();
    }



</script>
</body>
</html>