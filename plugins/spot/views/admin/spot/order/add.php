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

       <form method="post" id="frm" name="frm">

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
                            <select name="suitid" class="drop-down wid_300" id="suit_list">
                            </select>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">使用日期：</strong>
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
                    <tr>
                        <td>
                            <span class="amount-opt-wrap">
                                <a href="javascript:;" class="sub-btn">&ndash;</a>
                                <input type="text" class="num-text" name="dingnum" id="field_dingnum" maxlength="4" value="1" />
                                <a href="javascript:;" class="add-btn">&#43;</a>
                            </span>
                            <span class="unit">张</span>
                        </td>
                        <td><span class="cor_666 adult_price_single_txt">&yen;0</span></td>
                        <td><span class="color_f60 adult_price_total_txt">&yen;0</span></td>
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

                	<li style="display: none" id="tourer_list_con">
                		<strong class="item-hd">旅客信息：</strong>
                		<div class="item-bd">
                			<table class="table table-bg table-bordered table-border">
                				<thead id="tourer_list_header">
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
        <input type="hidden" id="field_price" name="price" value="0"/>
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
            if(num>1){
                obj.val(num-1);
                get_total_price();
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
                //add_tourer();
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
                },
                linkemail:
                {
                    required:"联系人邮箱不能为空"
                }
            },
            errUserFunc:function(element){


            },
            submitHandler:function(form){

                var product_id = $("#product_id").val();
                if(product_id==0){
                    ST.Util.showMsg('请选择产品',5);
                    return false;
                }

                var member_id = $('#member_id').val();
                if(member_id==0){
                    ST.Util.showMsg('请选择会员',5);
                    return false;
                }

                var total_num = $('#field_dingnum').val();
                if(total_num<=0){
                    ST.Util.showMsg('预订人数不能为0',5);
                    return false;
                }

                if(!isSaving){
                    isSaving = true;
                    $.ajax({
                        type:'POST',
                        url:SITEURL+'spot/admin/order/ajax_save_order',
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
                        }
                    })


                }


            
            }

        })


    })


    /*计算总价*/
    function get_total_price()
    {
        var dingnum = Number($("#field_dingnum").val());
        var price = $("#field_price").val();
        $(".adult_price_single_txt").html(CURRENCY_SYMBOL+price)

        var total_price = mul(dingnum, price);// adult_num * adult_price;
        $(".adult_price_total_txt").html(CURRENCY_SYMBOL+total_price)

        //总计原价
        var org_total_price = total_price
        var privilege_total_price = 0;
        var pay_total_price = org_total_price-privilege_total_price;

        $('.org_total_price').html(CURRENCY_SYMBOL+org_total_price);
        $('.privilege_total_price').html(CURRENCY_SYMBOL+privilege_total_price);
        $('.pay_total_price').html(CURRENCY_SYMBOL+pay_total_price);
        add_tourer();
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
        $(".choose-child-item.ml-10").remove();
        $(".choose-product").after(html);
        $("#frm").valid();
        get_suit_list();
    }



    //获取套餐
    function get_suit_list(){
        var product_id = $('#product_id').val();
        $.ajax({
            type:'POST',
            url:SITEURL+'spot/admin/order/ajax_suit_list',
            data:{product_id:product_id},
            dataType:'json',
            success:function(data){
                if(data.status){
                    $('#suit_list').empty();
                    var html ='<option value="0">请选择套餐</option>';
                    $.each(data.list,function(i,row){
                        var fill_items = row.fill_tourer_items?row.fill_tourer_items:'';
                        html += '<option value="'+row.id+'"  data-fill_tourer_items="'+fill_items+'" data-fill_tourer_type="'+row.fill_tourer_type+'" >'+row.title+'</option>';
                    })
                    $('#suit_list').append(html);
                    suit_list_change_listener();
                }
                else
                {
                    $('#suit_list').html('');
                }

               clear_price_date();

            }

        })
    }

    function suit_list_change_listener()
    {
        $("#suit_list").unbind();
        $("#suit_list").change(function(){
            clear_price_date();
        });

    }

    function clear_price_date()
    {
        $("#usedate").val('');
        $("#field_price").val(0);
        $("#tourer_list_header").html('');
        $("#tourer_list").html('');
        get_total_price();
    }

    //获取套餐具体报价
    function get_suit_price(day,bool){
        var params = {
            suit_id:$('#suit_list').val(),
            useday :day

        };
        $.getJSON(SITEURL+'spot/admin/order/ajax_suit_price',params,function(data){
             var total_price = 0;
             $('#field_dingnum').val(1);
             $('#field_price').val(data.price);
             get_total_price();
             ST.Util.closeDialog();

        })
    }
    function get_calendar(suit_id,year,month) {

        var width = 500;
        var height = 430;
        var lineid = $('#product_id').val();
        var url = SITEURL + 'spot/admin/order/dialog_calendar/suitid/'+suit_id;
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

        var sel_option = $("#suit_list").find("option:selected");
        var fill_type = sel_option.attr('data-fill_tourer_type');
        var fill_items = sel_option.attr('data-fill_tourer_items');

        if(!fill_type || !fill_items || fill_type==0)
        {
            $("#tourer_list_con").hide();
            $("#tourer_list").find('tr').remove();
            return;
        }

        var fill_items_arr = fill_items.split(',');
        var dingnum = parseInt($("#field_dingnum").val());
        var total_num = fill_type==1?1:dingnum;
        var html = '';
        var hasnum = $("#tourer_list").find('tr').length;
        if(total_num==0)
        {
            $("#tourer_list_con").hide();
        }

        if(hasnum>total_num){
            $("#tourer_list tr:gt("+total_num+")").remove();
            return;
        }

        //生成游客列表标头
        gene_tourer_header();

        //生成游客
        for (var i = hasnum; i < total_num; i++) {
           html+=' <tr>';
           if($.inArray('tourername', fill_items_arr)!=-1)
           {
               html += '<td class="pl-5"><input type="text" class="input-text w100" name="t_name[' + i + ']" /></td>';
           }

            if($.inArray('sex', fill_items_arr)!=-1)
            {
                html += '<td class="pl-5"><span class="select-box w100">';
                html += '<select class="t_cardtype select" name="t_sex[' + i + ']">';
                html += '<option value="男">男</option>';
                html += '<option value="女">女</option>';
                html += '</select></span></td>';
            }

            if($.inArray('mobile', fill_items_arr)!=-1)
            {
                html += '<td class="pl-5"><input type="text" class="input-text w150" name="t_mobile[' + i + ']" /></td>';
            }
            if($.inArray('cardnumber', fill_items_arr)!=-1)
            {
                html += '<td class="pl-5"><span class="select-box w100">';
                html += '<select class="t_cardtype select" name="t_cardtype[' + i + ']">';
                html += '<option value="身份证">身份证</option>';
                html += '<option value="护照">护照</option>';
                html += '<option value="台胞证">台胞证</option>';
                html += '<option value="港澳通行证">港澳通行证</option>';
                html += '<option value="军官证">军官证</option>';
                html += '<option value="出生日期">出生日期</option>';
                html += '</select></span></td>';
            }

            if($.inArray('cardnumber', fill_items_arr)!=-1)
            {
                html += '<td class="pl-5"><input type="text" class="input-text w200 t_cardno" name="t_cardno[' + i + ']" /></td>';
            }
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

    function gene_tourer_header()
    {
        $("#tourer_list_con").show();
        var sel_option = $("#suit_list").find("option:selected");
        var fill_items = sel_option.attr('data-fill_tourer_items');
        var fill_items_arr = fill_items.split(',');

        var html='';
        if($.inArray('tourername', fill_items_arr)!=-1)
        {
            html += '<th width="15%" class="pl-5">姓名</th>';
        }
        if($.inArray('sex', fill_items_arr)!=-1)
        {
            html += '<th width="15%" class="pl-5">性别</th>';
        }
        if($.inArray('mobile', fill_items_arr)!=-1)
        {
            html += '<th width="25%" class="pl-5">手机号</th>';
        }
        if($.inArray('cardnumber', fill_items_arr)!=-1)
        {
            html += '<th width="10%" class="pl-5">证件类型</th>';
        }
        if($.inArray('cardnumber', fill_items_arr)!=-1)
        {
            html += '<th width="35%" class="pl-5">证件号码</th>';
        }
        $("#tourer_list_header").html(html);

    }
    /*移除tourer*/
    function remove_tourer() {
        $("#tourer_list tr").last().remove();
    }



</script>
</body>
</html>