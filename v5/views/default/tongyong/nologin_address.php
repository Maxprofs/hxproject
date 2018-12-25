{Common::js('city/jquery.cityselect.js',0)}
    <div class="product-msg">

        <div class="user-address-tit">{__('收货地址')}</div>
        <div class="user-address-block">
                <ul id="address_list">
                    <li class="on">
                        <label class="radio-label">
                            <input type="radio" name="use_address" checked class="radio-btn" value="0"/>
                            <span>{__('不需要收货地址')}</span>
                        </label>
                    </li>
                    <li class="on">
                        <label class="radio-label">
                            <input type="radio" name="use_address" class="radio-btn" value="1"/>
                            <span>{__('使用收货地址')}</span>
                        </label>
                    </li>
                </ul>
                <ul id="address_content" class="address-item" style="display:none;">
                    <li>
                        <strong class="item-bt">{__('所在地区')}<i>*</i></strong>
                        <div class="item-nr" id="m_area">
                            <select class="drop-down prov fl" name="m_area_prov" id="m_area_prov">
                                <option value="请选择省">{__('请选择省')}</option>

                            </select>
                            <select class="drop-down ml5 city fl" name="m_area_city" id="m_area_city">
                                <option value="请选择市">{__('请选择市')}</option>

                            </select>
                        </div>
                    </li>
                    <li>
                        <strong class="item-bt">{__('详细地址')}<i>*</i></strong>
                        <div class="item-nr">
                            <textarea name="m_address" id="m_address" class="ads-textarea fl" placeholder="{__('建议您如实填写详细收货地址，例如街道名称，门牌号码，楼层和房间号等信息')}"></textarea>
                        </div>
                    </li>
                    <li>
                        <strong class="item-bt">{__('邮政编码')}<i>*</i></strong>
                        <div class="item-nr">
                            <input type="text" class="default-text fl" name="m_postcode" id="m_postcode">
                        </div>
                    </li>
                    <li>
                        <strong class="item-bt">{__('收件人')}<i>*</i></strong>
                        <div class="item-nr">
                            <input type="text" class="default-text fl" id="m_receiver" name="m_receiver">
                        </div>
                    </li>
                    <li>
                        <strong class="item-bt">{__('联系电话')}<i>*</i></strong>
                        <div class="item-nr">
                            <input type="text" class="default-text fl" name="m_phone" id="m_phone">
                        </div>
                    </li>
                    <li>
                        <strong class="item-bt">&nbsp;</strong>
                        <div class="item-nr">
                            <label class="radio-label"><input type="checkbox" name="m_is_default" id="m_is_default" checked class="check-btn" value="1">{__('设置默认收货地址')}</label>
                        </div>
                    </li>
                </ul>
        </div>
    </div>

<script>
    $(function(){
        $(".radio-btn[name=use_address]").click(function(){
            if($(this).val()==1)
            {
                $("#address_content").show();
            }
            else
            {
                $("#address_content").hide();
            }
        });
        $('#m_area').citySelect({
            nodata:"none",
            prov:'',
            city:'',
            required:false
        });
    })
</script>