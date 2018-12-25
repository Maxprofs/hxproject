<div id="editAddrss" class="page">
    <div class="header_top bar-nav">
        <a class="back-link-icon" id="close_add_page"  href="javascript:;"></a>
        <h1 class="page-title-bar">{$title}地址</h1>
    </div>
    <!-- 公用顶部 -->
    <div class="page-content">
        <form id="frm">
        <div class="user-item-list">
            <ul class="list-group">
                <li>
                    <strong class="hd-name">收货人</strong>
                    <input type="text" name="receiver" class="set-txt fr" value="{$info['receiver']}" placeholder="请填写真实姓名">
                </li>
                <li>
                    <strong class="hd-name">联系电话</strong>
                    <input type="text" name="phone" class="set-txt fr" value="{$info['phone']}" placeholder="请填写有效电话">
                </li>
                <li>
                    <strong class="hd-name">邮政编码</strong>
                    <input type="text" name="postcode" class="set-txt fr"  value="{$info['postcode']}" placeholder="请填写邮政编码">
                </li>
                <li>
                    <a id="selectCity" href="#">
                        <strong class="hd-name">所在地区</strong>
                        <span class="set-txt fr" id="showCity">{$info['province']} {$info['city']}</span>
                        <input type="hidden" name="province" id="province" value="{$info['province']}"/>
                        <input type="hidden" name="city" id="city" value="{$info['city']}"/>
                        <i class="arrow-rig-icon"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div id='cityResult3' class="ui-alert"></div>
        <textarea class="show-addrss-info" id="address" name="address" placeholder="请填写详细地址，不少于5个字">{$info['address']}</textarea>
        <div class="set-default-addrss clearfix">
            <em class="set-tit">设为默认</em>
            <span class="check-label-item {if $info['is_default']}checked{/if} fr"><i class="icon"></i>默认地址</span>
            <input type="hidden" name="is_default" value="{$info['is_default']}"/>
        </div>
        <input type="hidden" name="id" value="{$info['id']}">
        <div class="error-txt" style="display: none"><i class="ico"></i><span class="errormsg"></div>
        </form>
        <div class="bottom-fix-bar">
            <a class="addrss-fix-btn fix-btn save_address" href="javascript:;">保存</a>
        </div>
    </div>
</div>
