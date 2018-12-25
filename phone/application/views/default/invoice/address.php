
<div id="editInvoiceAddress" class="page out">
<div class="header_top bar-nav">
    <a class="back-link-icon"  href="javascript:;" data-rel="back"></a>
    <h1 class="page-title-bar">选择收货地址</h1>
</div>
<!-- 公用顶部 -->
<link type="text/css" rel="stylesheet" href="{$cmsurl}public/mui/css/mui.picker.css" />
<link type="text/css" rel="stylesheet" href="{$cmsurl}public/mui/css/mui.poppicker.css" />
<script src="{$cmsurl}public/mui/js/mui.min.js"></script>
<script src="{$cmsurl}public/mui/js/mui.picker.js"></script>
<script src="{$cmsurl}public/mui/js/mui.poppicker.js"></script>
<script src="{$cmsurl}public/mui/js/city.data-3.js" type="text/javascript" charset="utf-8"></script>
{Common::js('jquery.validate.min.js')}
<script type="text/javascript" src="//{$GLOBALS['main_host']}/res/js/jquery.validate.addcheck.js"></script>

<div class="addrss-container">
    <ul class="addrss-wrap" id="invoice_address_con">
        {loop $address $v}
        <li style="cursor: pointer" data-id="{$v['id']}" data-receiver="{$v['receiver']}"  data-phone="{$v['phone']}" data-province="{$v['province']}" data-city="{$v['city']}" data-address="{$v['address']}" data-postcode="{$v['postcode']}">
            <div class="info-bar">
                <span class="name">{$v['receiver']}</span>
                <span class="num">{$v['phone']}</span>
            </div>
            <div class="addrss-bar">
                {if $v['is_default']}<em class="label-cur">[默认地址]</em>{/if}
                <span class="show-addrss">{$v['province']}{$v['city']}{$v['address']} {$v['postcode']}</span>
            </div>
        </li>
        {/loop}
    </ul>
</div>
<!-- 选择收货地址 -->
<div class="bottom-fix-bar">
    <a class="addrss-fix-btn fix-btn" href="#editAddrss" data-reload="true">添加新地址</a>
</div>
</div>


<div id="editAddrss" class="page out">
    <div class="header_top bar-nav">
        <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
        <h1 class="page-title-bar">新增地址</h1>
    </div>
    <!-- 公用顶部 -->
    <div class="page-content">
        <form id="addr_frm" novalidate="novalidate" ul_table=HIACXC >
            <div class="user-item-list">
                <ul class="list-group">
                    <li>
                        <strong class="hd-name">收货人</strong>
                        <input type="text" name="receiver" class="set-txt fr" value="" placeholder="请填写真实姓名" aria-required="true" aria-invalid="false">
                    </li>
                    <li>
                        <strong class="hd-name">联系电话</strong>
                        <input type="text" name="phone" class="set-txt fr" value="" placeholder="请填写有效电话" aria-required="true" aria-invalid="false">
                    </li>
                    <li>
                        <strong class="hd-name">邮政编码</strong>
                        <input type="text" name="postcode" class="set-txt fr" value="" placeholder="请填写邮政编码" aria-required="true" aria-invalid="false">
                    </li>
                    <li>
                        <a id="selectCity" href="#">
                            <strong class="hd-name">所在地区</strong>
                            <span class="set-txt fr" id="showCity">北京市 北京市</span>
                            <input type="hidden" name="province" id="province" value="北京市">
                            <input type="hidden" name="city" id="city" value="北京市">
                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div id="cityResult3" class="ui-alert"></div>
            <textarea class="show-addrss-info" id="address" name="address" placeholder="请填写详细地址，不少于5个字" aria-required="true" aria-invalid="false">东城区</textarea>
            <div class="set-default-addrss clearfix">
                <em class="set-tit">设为默认</em>
                <span class="check-label-item  fr"><i class="icon"></i>默认地址</span>
                <input type="hidden" name="is_default" value="">
            </div>
            <input type="hidden" name="id" value="">
            <div class="error-txt" style="display: none"><i class="ico"></i><span class="errormsg"></span></div>
        </form>
        <div class="bottom-fix-bar">
            <a class="addrss-fix-btn fix-btn save_address" href="javascript:;">保存</a>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        $(document).on('click',"#invoice_address_con li",function(){
            var info={};
            info['receiver']=$(this).attr('data-receiver');
            info['phone']=$(this).attr('data-phone');
            info['province']=$(this).attr('data-province');
            info['city']=$(this).attr('data-city');
            info['address']=$(this).attr('data-address');
            info['postcode']=$(this).attr('data-postcode');

            if(typeof(on_invoice_address_choosed))
            {
                on_invoice_address_choosed(info);
            }
            if(!$("#editInvoiceAddress").is(':hidden'))
            {
                window.history.back();
            }
        });

        get_address_list(1);



        //添加地址
        $('.check-label-item').click(function(){
            if($(this).hasClass('checked')){
                $('input[name="is_default"]').val(0);
                $(this).removeClass('checked');
            }else{
                $('input[name="is_default"]').val(1);
                $(this).addClass('checked');
            }
        });
        $('.save_address').click(function(){
            $('#addr_frm').submit();
        });
        $('#addr_frm').validate({
            rules: {
                receiver: {
                    required: true
                },
                phone: {
                    required: true,
                    digits: true,
                    mobile:true
                },
                postcode: {
                    required: true,
                    digits: true,
                    postCode:true
                },
                province: {
                    required: true
                },
                city: {
                    required: true
                },
                address: {
                    required: true
                }
            },
            messages: {
                receiver: {
                    required: '请填写收货人'
                },
                phone: {
                    required: '请填写联系电话',
                    digits: '请输入正确的联系电话',
                    mobile:"请输入正确的联系电话"
                },
                postcode: {
                    required: '请填写邮政编码',
                    digits: '请输入正确的邮政编码',
                    postCode:'请输入正确的邮政编码'
                },
                province: {
                    required: '请选择所在地区'
                },
                city: {
                    required: '请选择所在地区'
                },
                address: {
                    required: '请填写详细地址'
                }
            },
            errorPlacement: function (error, element) {
                var content = $('.errormsg').html();
                if (content == '') {
                    error.appendTo($('.errormsg'));
                }
            },
            showErrors: function (errorMap, errorList) {
                if (errorList.length < 1) {
                    $('.errormsg:eq(0)').html('');
                    $('.error-txt').hide();
                } else {
                    this.defaultShowErrors();
                    $('.error-txt').show();
                }
            },
            submitHandler: function (form) {
                var frmdata = $("#addr_frm").serialize();
                $.ajax({
                    type: 'POST',
                    url: SITEURL + 'member/receive/ajax_save',
                    data: frmdata,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            $.layer({
                                type: 1,
                                icon: 1,
                                text: '保存成功',
                                time: 1000
                            });
                            //返回上一页面并动态刷新
                            get_address_list(1);
                            window.history.back();
                        } else {
                            $.layer({
                                type: 1,
                                icon: 2,
                                text: data.msg,
                                time: 1000
                            })
                        }
                    }
                })
            }
        });


        //获取地址列表
        function get_address_list(page)
        {
            $.ajax({
                type: 'POST',
                url: SITEURL + 'invoice/ajax_address_more',
                data: {page:page},
                dataType: 'json',
                success: function (data) {
                    if (data.status) {
                        var html='';
                        for(var i in data.list)
                        {
                            var row=data.list[i];
                            html+='<li style="cursor: pointer" data-receiver="'+row['receiver']+'" data-phone="'+row['phone']+'" data-province="'+row['province']+'" data-city="'+row['city']+'" data-address="'+row['address']+'" data-postcode="'+row['postcode']+'">';
                            html+='<div class="info-bar">';
                            html+='<span class="name">'+row['receiver']+'</span>';
                            html+='<span class="num">'+row['phone']+'</span>';
                            html+='</div>';
                            html+='<div class="addrss-bar">';
                            if(row['is_default']==1)
                            {
                                html += '<em class="label-cur">[默认地址]</em> ';
                            }
                            html+='<span class="show-addrss">'+row['province']+row['city']+row['address']+'</span>';
                            html+='</div></li>'
                        }
                        if(page<=1)
                        {
                            $("#invoice_address_con").html(html);
                            $("#invoice_address_con li:first").trigger('click');
                        }
                        else
                        {
                            $("#invoice_address_con").append(html);
                        }


                    }
                }
            })
        }
    });




        //级联选择
    (function($, doc) {
        $.init();
        $.ready(function() {
            //级联示例
            var cityPicker3 = new $.PopPicker({
                layer: 3
            });
            cityPicker3.setData(cityData3);
            var showCityPickerButton = doc.getElementById('selectCity');
            var showCity = doc.getElementById('showCity');
            showCityPickerButton.addEventListener('tap', function(event) {
                cityPicker3.show(function(items) {
                    showCity.innerText = (items[0] || {}).text + " " + (items[1] || {}).text;
                    doc.getElementById('province').value=items[0]['text'];
                    doc.getElementById('city').value=items[1]['text'];
                    doc.getElementById('address').innerText=typeof(items[2]['text'])=='undefined'?'':items[2]['text'];
                });
            }, false);
        });
    })(mui, document);


</script>

</script>