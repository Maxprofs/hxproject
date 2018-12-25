<div class="booking-info-block clearfix">
    <h3 class="block-tit-bar">
        <div class="write-address" style="margin-top: 0;height: 100%;padding: 0;">
            <strong>填写收货地址</strong>
            <i class="check-box" id="addAddress"></i>
        </div>
    </h3>
    <div id="add_address_content" style="display:none;">
        <div class="user-item-list" style="margin-top: 0;">
            <ul class="list-group">
                <li>
                    <strong class="item-hd no-style">收货人：</strong>
                    <input type="text" name="receiver" class="set-txt fr" value="" placeholder="请填写真实姓名">
                </li>
                <li>
                    <strong class="item-hd no-style">联系电话：</strong>
                    <input type="text" name="phone" class="set-txt fr" value="" placeholder="请填写有效电话">
                </li>
                <li>
                    <strong class="item-hd no-style">邮政编码：</strong>
                    <input type="text" name="postcode" class="set-txt fr"  value="" placeholder="请填写邮政编码">
                </li>
                <li>
                    <a id="selectCity" href="#">
                        <strong class="item-hd no-style">所在地区：</strong>
                        <span class="set-txt fr" id="showCity"></span>
                        <input type="hidden" name="province" id="province" value=""/>
                        <input type="hidden" name="city" id="city" value=""/>
                        <i class="arrow-rig-icon"></i>
                    </a>
                </li>
            </ul>
        </div>
        <input type="hidden" name="use_address" id="use_address" value="0"/>
        <div id='cityResult3' class="ui-alert"></div>
        <textarea class="show-addrss-info" id="address" name="address" placeholder="请填写详细地址，不少于5个字"></textarea>

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
</script>
