<link type="text/css" rel="stylesheet" href="{$cmsurl}public/mui/css/mui.picker.css" />
<link type="text/css" rel="stylesheet" href="{$cmsurl}public/mui/css/mui.poppicker.css" />
<script src="{$cmsurl}public/mui/js/mui.min.js"></script>
<script src="{$cmsurl}public/mui/js/mui.picker.js"></script>
<script src="{$cmsurl}public/mui/js/mui.poppicker.js"></script>
<script src="{$cmsurl}public/mui/js/city.data-3.js" type="text/javascript" charset="utf-8"></script>
<div id="editInvoiceAddress" class="page out">
    <div class="header_top bar-nav">
        <a class="back-link-icon"  href="javascript:;" onclick="history.go(-1)"></a>
        <h1 class="page-title-bar">填写地址</h1>
    </div>
    <!-- 公用顶部 -->
    <div class="page-content">
        <form id="frm">
            <div class="user-item-list">
                <ul class="list-group">
                    <li>
                        <strong class="hd-name">收货人</strong>
                        <input type="text"  class="set-txt fr receiver" value="" placeholder="请填写真实姓名">
                    </li>
                    <li>
                        <strong class="hd-name">联系电话</strong>
                        <input type="text" class="set-txt fr phone" value="" placeholder="请填写有效电话">
                    </li>
                    <li>
                        <strong class="hd-name">邮政编码</strong>
                        <input type="text"  class="set-txt fr postcode"  value="" placeholder="请填写邮政编码">
                    </li>
                    <li>
                        <a id="selectCity" href="javascript;;">
                            <strong class="hd-name">所在地区</strong>
                            <span class="set-txt fr" id="showCity">{$info['province']} {$info['city']}</span>
                            <input type="hidden" class="province" id="province" value="{$info['province']}"/>
                            <input type="hidden" class="city"  id="city" value="{$info['city']}"/>
                            <i class="arrow-rig-icon"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div id='cityResult3' class="ui-alert"></div>
            <textarea class="show-addrss-info address" id="address"  placeholder="请填写详细地址"></textarea>
        </form>
        <div class="bottom-fix-bar">
            <a class="addrss-fix-btn fix-btn save_address" href="javascript:;">确定</a>
        </div>
    </div>
</div>
<!-- 编辑地址 -->
<script>
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

    $(document).ready(function(){
        $('#editInvoiceAddress .check-label-item').click(function(){
            if($(this).hasClass('checked')){
                $('input[name="is_default"]').val(0);
                $(this).removeClass('checked');
            }else{
                $('input[name="is_default"]').val(1);
                $(this).addClass('checked');
            }
        });
        $('#editInvoiceAddress .save_address').click(function(){

            var info={};
            info['receiver'] = $('#editInvoiceAddress input.receiver').val();
            info['phone'] = $('#editInvoiceAddress input.phone').val();
            info['postcode'] = $('#editInvoiceAddress input.postcode').val();
            info['province'] = $('#editInvoiceAddress input.province').val();
            info['city'] = $('#editInvoiceAddress input.city').val();
            info['address'] = $('#editInvoiceAddress textarea.address').val();


            try {
                if(!info['receiver'])
                {
                    throw "收货人不能为空";
                }
                if(!info['phone']||!is_phone(info['phone']))
                {
                    throw '电话格式错误';
                }
                if(!info['postcode'])
                {
                    throw '邮编不能为空';
                }
                if(!info['province'])
                {
                    throw '省份不能为空';
                }
                if(!info['city'])
                {
                    throw '城市不能为空';
                }
                if(!info['address'])
                {
                    throw '详细地址不能为空';
                }
            }
            catch (e) {
                $.layer({type:1, icon:2,time:1000, text:e});
                return;
            }

            if(typeof(on_invoice_address_choosed))
            {
                on_invoice_address_choosed(info);
            }
            window.history.back();
        });

        //判断是否为手机
        function is_phone(value)
        {
            var mobile = /^1+\d{10}$/;
            var tel = /^\d{3,4}-?\d{7,9}$/;
            return tel.test(value) || mobile.test(value);
        }
    });


</script>
