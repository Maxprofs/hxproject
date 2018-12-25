<div class="header_top bar-nav">
    <a class="back-link-icon"  href="javascript:;" data-rel="back"></a>
    <h1 class="page-title-bar">选择收货地址</h1>
</div>
<!-- 公用顶部 -->

<div class="addrss-container">
    <ul class="addrss-wrap">
        {loop $address $v}
        <li style="cursor: pointer" onclick="selectAddress({$v['id']},['{$v['receiver']}','{$v['phone']}','{$v['province']}{$v['city']}{$v['address']} {$v['postcode']}','{$v['is_default']}'])">
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
    <a class="addrss-fix-btn fix-btn" id="add_address">添加新地址</a>
</div>
<script>
    $("#add_address").click(function () {
        $.ajax({
            type: 'GET',
            url: SITEURL + 'member/receive/ajax_update',
            data: '',
            dataType: 'html',
            success: function (html) {
                $("body").append(html);

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
                $('.check-label-item').click(function(){
                    if($(this).hasClass('checked')){
                        $('input[name="is_default"]').val(0);
                        $(this).removeClass('checked');
                    }else{
                        $('input[name="is_default"]').val(1);
                        $(this).addClass('checked');
                    }
                });
                $("#close_add_page").click(function(){
                    $("#editAddrss").remove();
                });
                function back_list(address) {
                    var str='';
                    if(address.is_default){
                        $("em.label-cur").remove();
                        str='<em class="label-cur">[默认地址]</em>';
                    }
                    var $html='<li style="cursor: pointer" onclick="selectAddress('+address.id+',[\''+address.receiver+'\',\''+address.phone+'\',\''+address.province+address.city+address.address+' '+address.postcode+'\',\''+address.is_default+'\'])">'
                        +'<div class="info-bar">'
                        +'<span class="name">'+address.receiver+'</span>'
                        +'<span class="num">'+address.phone+'</span></div><div class="addrss-bar">'
                        + str+'<span class="show-addrss">'+address.province+address.city+address.address+' '+address.postcode+'</span></div></li>';
                    $("ul.addrss-wrap").prepend($html);
                    $("#editAddrss").remove();
                }
                $('.save_address').click(function(){
                    $('#frm').submit();
                });
                $('#frm').validate({
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
                        var frmdata = $("#frm").serialize();
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
                                    back_list(data.address);
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
            }
        })
    })
</script>
