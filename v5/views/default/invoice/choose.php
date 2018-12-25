{Common::js('city/jquery.cityselect.js',0)}
<div class="booking-info-block" id="invoice_block">
    <div class="bib-hd-bar">
        <span class="col-title">发票信息</span>
        <div class="bib-radio-box">
            <span data-val="" class="bib-radio-label c-999 active"><i class="radio-icon"></i>不开发票</span>
            {if in_array(1,$types)}
            <span data-val="1" class="bib-radio-label c-999"><i class="radio-icon"></i>普通发票</span>
            {/if}
            {if in_array(2,$types)}
            <span data-val="2" class="bib-radio-label c-999 "><i class="radio-icon"></i>增值专票</span>
            {/if}
            <input type="hidden" name="usebill" value="0"/>
        </div>
        <span class="bib-tips fr c-999">（支付金额为0，无开票金额，不能申请开具发票）</span>
    </div>
    <div class="bib-bd-wrap invoice-con-wrap" style="display: none">
        <div class="invoice-tips">{$description}</div>
        <div class="invoice-block clearfix" id="invoice_fm_con">
            <ul class="booking-item-block">
                <li>
                    <span class="item-hd">发票金额：</span>
                    <div class="item-bd">
                        <span class="b-item-text pay-total-price">&yen;500</span>
                    </div>
                </li>
                <li>
                    <span class="item-hd">发票明细：</span>
                    <div class="item-bd">
                        <select class="select w100" name="invoice_content">
                            {loop $contents  $content}
                            <option value="{$content}">{$content}</option>
                            {/loop}
                        </select>
                    </div>
                </li>
                <li>
                    <span class="item-hd"><i class="st-star-ico">*</i>发票抬头：</span>
                    <div class="item-bd">

                        <select class="select w100 mr5 type_sel" name="invoice_subtype">
                            <option value="0">个人</option>
                            <option value="1">公司</option>
                        </select>
                        <div class="invoice-name-box">
                            <input type="text" class="input-text clr_item  w300" name="invoice_title" value="" placeholder="请填写发票抬头">
                            <!--<input type="text" class="input-text w300" value="" placeholder="请填写公司全称">-->
                            <ul class="input-down" id="invoice_choose_list" style="display: none">
                            </ul>
                            <input type="hidden" name="invoice_type" value="0"/>
                        </div>
                    </div>
                </li>

                <li  class="taxpayer_number_con" style="display: none">
                    <span class="item-hd"><i class="st-star-ico">*</i>纳税人识别号：</span>
                    <div class="item-bd">
                        <input type="text" class="input-text clr_item w300" name="invoice_taxpayer_number" value="" placeholder="">
                    </div>
                </li>
                <li class="type_item">
                    <span class="item-hd"><i class="st-star-ico">*</i>地址：</span>
                    <div class="item-bd">
                        <input type="text" class="input-text clr_item w300" name="invoice_taxpayer_address"  value="" placeholder="">
                    </div>
                </li>
                <li class="type_item">
                    <span class="item-hd"><i class="st-star-ico">*</i>联系电话：</span>
                    <div class="item-bd">
                        <input type="text" class="input-text clr_item w300" name="invoice_taxpayer_phone"  value="" placeholder="">
                    </div>
                </li>
                <li class="type_item">
                    <span class="item-hd"><i class="st-star-ico">*</i>开户网点：</span>
                    <div class="item-bd">
                        <input type="text" class="input-text clr_item w300" name="invoice_bank_branch"  value="" placeholder="">
                    </div>
                </li>
                <li class="type_item">
                    <span class="item-hd"><i class="st-star-ico">*</i>银行账号：</span>
                    <div class="item-bd">
                        <input type="text" class="input-text clr_item w300" name="invoice_bank_account" value="" placeholder="">
                    </div>
                </li>

            </ul><!-- 增值专票 -->

            {if empty($userinfo['mid']) || empty($address_list) }
            <div class="login-invoice-info">
                <ul class="booking-item-block">
                    <li>
                        <span class="item-hd"><i class="st-star-ico">*</i>收件人：</span>
                        <div class="item-bd">
                            <input type="text" class="input-text w300" name="invoice_addr_receiver" value="" placeholder="">
                        </div>
                    </li>
                    <li>
                        <span class="item-hd"><i class="st-star-ico">*</i>手机号码：</span>
                        <div class="item-bd">
                            <input type="text" class="input-text w300" name="invoice_addr_phone" value="" placeholder="">
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">邮政编码：</span>
                        <div class="item-bd">
                            <input type="text" class="input-text w300" name="invoice_addr_postcode" value="" placeholder="">
                        </div>
                    </li>
                    <li>
                        <span class="item-hd"><i class="st-star-ico">*</i>邮寄地址：</span>
                        <div class="item-bd">
                            <div class="w300 fl" id="invoice_pcity">
                                <select class="select fl province-sel dest-select prov" name="invoice_addr_province">
                                    <option value="">请选择</option>
                                </select>
                                <select class="select fl city-sel ml10 city" name="invoice_addr_city">
                                    <option value="">请选择</option>

                                </select>
                                <textarea class="text-area fl mt10 w300" name="invoice_addr_address" placeholder="请填写详细收货地址"></textarea>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            {else}
            <div class="login-invoice-info"><!-- 登陆后 -->

                <dl class="addr-list clearfix">
                    {loop $address_list $key $addr}
                    <dd class="det-addr {if ($key+1)%3==0}mr_0{/if}" data-province="{$addr['province']}" data-city="{$addr['city']}" data-address="{$addr['address']}" data-postcode="{$addr['postcode']}" data-receiver="{$addr['receiver']}" data-phone="{$addr['phone']}">
                        <div class="addr-item">
                            <div class="person-info clearfix">
                                <span class="name fl">{$addr['receiver']}</span>
                                <span class="phone fr">{$addr['phone']}</span>
                            </div>
                            <p class="addr-info">{$addr['address']}</p>
                        </div>
                        <i class="selected-ico"></i>
                    </dd>
                    {/loop}
                    <dd class="addr_add mr_0">
                        <a href="javascript:;" class="add-addr-btn" id="add-addr-btn">+&nbsp;新增地址</a>
                    </dd>
                </dl>
                <div class="addr-btn-box" style="{if count($address_list)<=2}display: none{/if}"><a href="javascript:;" class="down" id="more-addr-btn">更多地址</a></div>
                <div id="invoice_addr_hid">

                </div>
            </div>
            {/if}
            <!-- 登陆后 -->
        </div>
    </div>
</div>

<div class="add-address-box" style=" display: none;" id="addAddressBox">
    <ul class="booking-item-block">
        <li>
            <span class="item-hd"><i class="st-star-ico">*</i>收件人：</span>
            <div class="item-bd">
                <input type="text" class="input-text w300 receiver"  value="" placeholder="">
            </div>
        </li>
        <li>
            <span class="item-hd"><i class="st-star-ico">*</i>手机号码：</span>
            <div class="item-bd">
                <input type="text" class="input-text w300 phone" value="" placeholder="">
            </div>
        </li>
        <li>
            <span class="item-hd">邮政编码：</span>
            <div class="item-bd">
                <input type="text" class="input-text w300 postcode" value="" placeholder="">
            </div>
        </li>
        <li>
            <span class="item-hd"><i class="st-star-ico">*</i>邮寄地址：</span>
            <div class="item-bd">
                <div class="w300" id="invoice_pcity">
                    <select class="select fl province-sel prov" name="">
                        <option value="">请选择</option>
                    </select>
                    <select class="select fl city-sel ml10 city" name="">
                        <option value="">请选择</option>
                    </select>
                    <textarea class="text-area fl mt10 w300 address" name="" placeholder="请填写详细收货地址"></textarea>
                </div>
            </div>
        </li>
        <li><p class="set-default"><label><input type="checkbox" checked="">设为默认地址</label></p></li>
    </ul>
    <div class="btn-wrap">
        <a href="javascript:;" class="cancel-btn">取消</a>
        <a href="javascript:;" class="confirm-btn">确认</a>
        <span class="error-txt"></span>
    </div>
</div>

<script>
    $(document).ready(function(){
        //选中不同的类型
        $("#invoice_block .bib-radio-box span").click(function(){
            var mtype=$(this).attr('data-val');
            if(!mtype || mtype=='')
            {
                $("#invoice_block .invoice-con-wrap").hide();
                $("#invoice_block input[name=usebill]").val(0);
            }
            else
            {
                if(mtype==2) {
                    $("#invoice_fm_con ul li").show();
                    $("#invoice_fm_con select[name='invoice_subtype']").hide();
                }
                else
                {
                    $("#invoice_fm_con ul li.type_item").hide();
                    $("#invoice_fm_con select[name='invoice_subtype']").show();
                }
                $("#invoice_block .invoice-con-wrap").show();
                $("#invoice_block input[name=usebill]").val(1);
            }
            $(this).addClass('active').siblings().removeClass('active');
            on_invoice_type_change()
            set_address_valid();

        });


        //搜索
        $("#invoice_fm_con ul li input[name='invoice_title']").keyup(function(){
            get_invoice_list();
        });
        $("#invoice_fm_con ul li input[name='invoice_title']").focus(function(){
            get_invoice_list();
        });

        $("#invoice_fm_con ul li select[name='invoice_subtype']").change(function(){
            on_invoice_type_change();
        });



        //点击隐藏提示
        $(document).click(function(){
            $("#invoice_choose_list").hide();
        });

        //选中已存在的发票
        $('#invoice_choose_list').on('click','li',function(){
            var info={};
            info['type']=$(this).attr('data-type');
            info['taxpayer_number'] = $(this).attr('data-taxpayer_number');
            info['title'] = $(this).attr('data-title');
            info['type'] = $(this).attr('data-type');
            info['taxpayer_address'] = $(this).attr('data-taxpayer_address');
            info['taxpayer_phone'] = $(this).attr('data-taxpayer_phone');
            info['bank_branch'] = $(this).attr('data-bank_branch');
            info['bank_account'] = $(this).attr('data-bank_account');

            for(var key in info)
            {
                $("#invoice_fm_con input[name='invoice_"+key+"']").val(info[key]);
            }
            $("#invoice_choose_list").hide();

        });


        //当发票的类型改变时
        function on_invoice_type_change()
        {
            var mtype=$("#invoice_block .bib-radio-box span.active").attr('data-val');
            var subtype = $("#invoice_fm_con ul li select[name='invoice_subtype']").val();
            var type=mtype;
            type = mtype!=2?subtype:type;
            var itype=$("#invoice_fm_con input[name='invoice_type']").val();
            if(type!=itype)
            {
                $("#invoice_fm_con input.clr_item").val('');
            }

            if(subtype==1 || mtype==2)
            {
                $("#invoice_fm_con .taxpayer_number_con").show();
            }
            else
            {
                $("#invoice_fm_con .taxpayer_number_con").hide();
            }
            $("#invoice_fm_con input[name='invoice_type']").val(type);

            //设置验证
            set_invoice_valid();
            set_address_valid();
        }


        //获取发票列表
        function get_invoice_list()
        {
            var mtype=$("#invoice_block .bib-radio-box span.active").attr('data-val');
            var subtype = $("#invoice_fm_con ul li select[name='invoice_subtype']").val();
            var types = mtype;
            types = mtype!=2?subtype:types;

            var url = SITEURL + 'invoice/ajax_invoice_more';
            var keyword = $("#invoice_fm_con input[name='invoice_title']").val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {keyword:keyword,types:types},
                url: url,
                success: function (data) {
                    var html='';
                    if(data && data.list)
                    {
                        for(var i in data.list)
                        {
                            var row=data.list[i];
                            html+='<li data-title="'+row['title']+'" data-type="'+row['type']+'" data-taxpayer_number="'+row['taxpayer_number']+'"' +
                                ' data-taxpayer_address="'+row['taxpayer_address']+'" data-taxpayer_phone="'+row['taxpayer_phone']+'" data-bank_branch="'+row['bank_branch']+'" data-bank_account="'+row['bank_account']+'">';
                            html+=row['title'];
                            html+='</li>';
                        }
                        if(html!='')
                        {
                            $("#invoice_choose_list").html(html);
                            $("#invoice_choose_list").show();
                        }
                        else
                        {
                            $("#invoice_choose_list").hide();
                        }
                    }
                },
                complete:function(){

                }
            })
        }

        //验证发票的有效性
        function set_invoice_valid()
        {
            var mtype=$("#invoice_block .bib-radio-box span.active").attr('data-val');

            if(mtype)
            {
                $("#invoice_block input[name='invoice_title']").rules("add",{ required: true, messages: { required: "{__('请填写发票抬头')}"} });
                $("#invoice_block input[name='invoice_taxpayer_number']").rules("add",{ required: true, messages: { required: "{__('请填写纳税人识别号')}"} });
                $("#invoice_block input[name='invoice_taxpayer_address']").rules("add",{ required: true, messages: { required: "{__('请填写公司地址')}"} });
                $("#invoice_block input[name='invoice_taxpayer_phone']").rules("add",{ required: true, messages: { required: "{__('请填写正确的手机号')}"} });
                $("#invoice_block input[name='invoice_bank_branch']").rules("add",{ required: true, messages: { required: "{__('请填写开户网点')}"} });
                $("#invoice_block input[name='invoice_bank_account']").rules("add",{ required: true, messages: { required: "{__('请填写银行账号')}"} });
            }
            else{
                $("#invoice_block input[name='invoice_title']").rules("remove");
                $("#invoice_block input[name='invoice_taxpayer_number']").rules("remove");
                $("#invoice_block input[name='invoice_taxpayer_address']").rules("remove");
                $("#invoice_block input[name='invoice_taxpayer_phone']").rules("remove");
                $("#invoice_block input[name='invoice_bank_branch']").rules("remove");
                $("#invoice_block input[name='invoice_bank_account']").rules("remove");
            }
        }


        //地址选择
        $('#invoice_block').on('click',".addr-list .det-addr",function(){
            $(this).addClass('on');
            $(this).siblings().removeClass('on');

            var addr={};
            addr['province']=$(this).attr('data-province');
            addr['city']=$(this).attr('data-city');
            addr['address']=$(this).attr('data-address');
            addr['postcode']=$(this).attr('data-postcode');
            addr['receiver']=$(this).attr('data-receiver');
            addr['phone']=$(this).attr('data-phone');

            var html='';
            for(var i in addr)
            {
                html+='<input type="hidden" name="invoice_addr_'+i+'" value="'+addr[i]+'" />'
            }
            $("#invoice_addr_hid").html(html);
        });

        //默认选中第一个
        if($("#invoice_block .addr-list .det-addr").length>0)
        {
            $("#invoice_block .addr-list .det-addr:first").trigger('click');
        }



        //展开更多地址
        $("#more-addr-btn").on("click",function(){
            if($(this).hasClass("down")){
                $(this).removeClass("down").text("收起").parents().prev(".addr-list").css({
                    "height": "auto"
                })
            }
            else{
                $(this).addClass("down").text("更多地址").parents().prev(".addr-list").css({
                    "height": "117px"
                })
            }
        });





        //新增邮寄地址

        var addr_box_index=null;
        $("#add-addr-btn").on("click",function(){
            addr_box_index=layer.open({
                type: 1,
                title: "新增地址",
                area: ['520px', '476px'],
                content: $('#addAddressBox'),
                btnAlign: 'c',
                closeBtn: 1
            });
        });

        $("#invoice_pcity").citySelect({
            nodata:"none",
            required:false
        });

        $("#addAddressBox .confirm-btn").click(function(){
            var url = SITEURL+'member/index/ajax_save_address';
            var addr={};
            addr['area_prov']=$("#addAddressBox select.prov").val();
            addr['area_city']=$("#addAddressBox select.city").val();
            addr['address']=$("#addAddressBox textarea.address").val();
            addr['postcode']=$("#addAddressBox input.postcode").val();
            addr['receiver']=$("#addAddressBox input.receiver").val();
            addr['phone']=$("#addAddressBox input.phone").val();

            try {
                if(!addr['receiver'])
                {
                    throw "收货人不能为空";
                }
                if(!addr['phone']||!is_phone(addr['phone']))
                {
                    throw '电话格式错误';
                }
                if(!addr['postcode'])
                {
                    //  throw '邮编不能为空';
                }
                if(!addr['area_prov'])
                {
                    throw '省份不能为空';
                }
                if(!addr['area_city'])
                {
                    throw '城市不能为空';
                }
                if(!addr['address'])
                {
                    throw '详细地址不能为空';
                }
            }
            catch (e) {
                $("#addAddressBox .error-txt").text(e);
                return;
            }
            $("#addAddressBox .error-txt").text('');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: addr,
                url: url,
                success: function (data) {
                    if(data.status)
                    {

                        var html='<dd class="det-addr" data-province="'+addr['area_prov']+'" data-city="'+addr['area_city']+'" data-address="'+addr['address']+'" data-postcode="'+addr['postcode']+'" data-receiver="'+addr['receiver']+'" data-phone="'+addr['area_phone']+'">' +
                            ' <div class="addr-item"> ' +
                            '<div class="person-info clearfix"> ' +
                            '<span class="name fl">'+addr['receiver']+'</span> <span class="phone fr">'+addr['phone']+'</span> ' +
                            '</div> ' +
                            '<p class="addr-info">'+addr['address']+'</p> ' +
                            '</div> ' +
                            '<i class="selected-ico"></i> ' +
                            '</dd>';
                        $(html).insertBefore('#invoice_block .addr-list .addr_add');

                        //重新排列地址列表
                        $("#invoice_block .addr-list dd").each(function(index,ele){
                            var num = parseInt(index)+1;
                            var le=num%3;
                            if(le==0)
                            {
                                $(this).addClass('mr_0');
                            }
                            else
                            {
                                $(this).removeClass('mr_0');
                            }

                        });

                        //是否显示地址上的更多按钮
                        if($("#invoice_block .add-list dd").length>3)
                        {
                            $("#invoice_block .addr-btn-box").show();
                        }


                        $("#addAddressBox input,#addAddressBox textarea,#addAddressBox select").val('');
                        layer.close(addr_box_index);

                    }
                    else
                    {
                        layer.open({
                            content: '保存失败, 请重试',
                            btn: ['{__("OK")}']
                        });
                    }

                }
            });
        });
        $("#addAddressBox .cancel-btn").click(function(){
            layer.close(addr_box_index);
        });




        //判断是否为电话号码
        function is_phone(value)
        {
            var mobile = /^1+\d{10}$/;
            var tel = /^\d{3,4}-?\d{7,9}$/;
            return tel.test(value) || mobile.test(value);
        }

        //验证地址的有效性
        function set_address_valid()
        {

            if($("#invoice_block textarea[name='invoice_addr_address']").length<=0)
            {
                return;
            }
            $("#invoice_block input[name='invoice_addr_phone']").rules("add",{ required: true,isPhone:true, messages: { required: "{__('请填写收件人电话')}"} });
            $("#invoice_block input[name='invoice_addr_receiver']").rules("add",{ required: true, messages: { required: "{__('请填写收件人姓名')}"} });
            // $("#invoice_block input[name='invoice_addr_postcode']").rules("add",{ required: true, messages: { required: "{__('请填写邮政编码')}"} });
            $("#invoice_block select[name='invoice_addr_province']").rules("add",{ required: true, messages: { required: "{__('请选择省份')}"} });
            $("#invoice_block select[name='invoice_addr_city']").rules("add",{ required: true, messages: { required: "{__('请选择城市')}"} });
            $("#invoice_block textarea[name='invoice_addr_address']").rules("add",{ required: true, messages: { required: "{__('请填写收件地址')}"} });
        }

    });



</script>

