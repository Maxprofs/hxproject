<!DOCTYPE html>
<html>
<head table_script=vdDCXC >
    <meta charset="UTF-8">
    <title>供应商收入审核详情-笛卡CMS{$coreVersion}</title>
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {Common::css_plugin('lightbox.min.css', 'sterp')}
    {template 'stourtravel/public/public_js'}
    {Common::js_plugin('lightbox.min.js', 'sterp')}
</head>
<body>

<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:hidden">
            <div class="cfg-header-bar">
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
            </div>
            <div class="clear clearfix">
                <ul class="info-item-block">
                    <li>
                        <span class="item-hd">订单号：</span>
                        <div class="item-bd">
                            <a href="javascript:;" onclick="order_view({$info['orderid']},{$info['type_id']})" class="btn-link item-text">{$info['ordersn']}</a>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">产品类别：</span>
                        <div class="item-bd">
                            <span class="item-text">{$info['pdt_type']}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">支付方式：</span>
                        <div class="item-bd">
                            <span class="item-text">{$info['pay_type']}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">支付时间：</span>
                        <div class="item-bd">
                            <span class="item-text">{date('Y-m-d H:i:s', $info['pay_time'])}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">支付渠道：</span>
                        <div class="item-bd">
                            <span class="item-text">{if $info['is_online'] == 1}线上支付{else}线下支付{/if}</span>
                        </div>
                    </li>
                    {if $info['is_online'] == 1}
                    {php}
                        $transaction = json_decode($info['pay_num'],1);
                        $pay_num = $transaction['transaction_no'];
                    {/php}
                    <li>
                        <span class="item-hd">交易流水号：</span>
                        <div class="item-bd">
                            <span class="item-text">{$pay_num}</span>
                        </div>
                    </li>
                    {else}
                    <li>
                        <span class="item-hd">付款凭证：</span>
                        <div class="item-bd">
                            <a href="{$info['pay_proof']}" rel="lightbox">
                                <img id="payProofImg" src="{$info['pay_proof']}" class="up-img-area" />
                            </a>
                        </div>
                    </li>
                    {/if}
                    <li>
                        <span class="item-hd">联系人：</span>
                        <div class="item-bd">
                            <span class="item-text">{$info['linkman']}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">联系电话：</span>
                        <div class="item-bd">
                            <span class="item-text">{$info['linktel']}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">业务员：</span>
                        <div class="item-bd">
                            <span class="item-text">{$info['salesman']}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">实收金额：</span>
                        <div class="item-bd">
                            <strong class="item-text c-f60 f">&yen;{$info['amount']}</strong>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">到账状态：</span>
                        <div class="item-bd">
                            {if $info['status'] == 0}
                            <span class="item-text c-f60">待确认</span>
                            {else}
                            <span class="item-text">已到账</span>
                            {/if}
                        </div>
                    </li>
                </ul>
                {if $info['status'] == 0}
                <div class="clear">
                    <a href="javascript:;" id="sure_btn" class="btn btn-primary radius size-L ml-115">确认到账</a>
                </div>
                {/if}
            </div>
        </td>
    </tr>
</table>
<script>
    $(function(){

        //图片点击事件
        $("#payProofImg").on("click",function(){

        });

        //确认到账
        $('#sure_btn').click(function () {
            ST.Util.confirmBox('提示','确定该笔费用已到账?',function () {
                $.post(
                    SITEURL + 'income/admin/income/ajax_update',
                    {id:'{$info["id"]}', filed: 'status', val: 1, ordersn: '{$info["ordersn"]}'},
                    function (data) {
                        if(data.status){
                            window.location.reload();
                        }
                    },
                    'json'
                );
            });
        });
    });

    //订单详情
    function order_view(id,typeid) {
        var url = SITEURL + "{$info['pinyin']}/admin/order/view/id/"+id+"/typeid/"+typeid;
        ST.Util.addTab('{$info["pdt_type"]}订单：{$info["ordersn"]}',url,1);
    }
</script>

</body>
</html>