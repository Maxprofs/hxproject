<!--优惠券通用视图-->
<div class="page out" id="useCoupon">
    <header clear_script=cNACXC >
        <div class="header_top">
            <a class="back-link-icon" href="#pageHome" data-rel="back"></a>
            <h1 class="page-title-bar">使用优惠券</h1>
        </div>
    </header>
    <!-- 公用顶部 -->
    <div class="page-content">
        <div class="wrap-content">
            <div class="use-coupon-block clearfix">
                <ul class="coupon-list">
                    {loop $list $l}
                    <li data="{id:{$l['roleid']},type:{$l['type']},title:'{$l['name']}',detail:{$l['amount']} }">
                        <div class="attr-zs">通用券</div>
                        <div class="item-l fl">
                            <strong class="type">{$l['name']}</strong>
                            <p class="txt">品类限制：{if $l['typeid']==9999}部分{$l['typename']}产品可用{else}无品类限制{/if}</p>
                            <p class="date">有效期：{if $l['isnever']==1}截止{$l['endtime']}{else}永久有效{/if}</p>
                        </div>
                        <div class="item-r fr">
                            <span class="jg">{if $l['type']==1} {$l['amount']}折{else}{Currency_Tool::symbol()}{$l['amount']}{/if}</span>
                            <span class="sm">满{$l['samount']}元可用</span>
                            <i class="use-label"></i>
                        </div>
                    </li>
                    {/loop}
                </ul>
            </div>
        </div>
    </div>
    <script>
        var coupon = {};
        //页面加载完成
        $(function () {
            $('.coupon-list li').click(function() {
                if ($(this).hasClass('choosed'))
                {
                    queue.emit('resetCoupon');
                    queue.emit('totalPrice');
                    history.go(-1);
                }
                else
                {
                    $(this).siblings().removeClass('choosed');
                    check_and_set_coupon(eval('('+$(this).attr('data')+')'),$(this));
                }
            });
            //订阅优惠券重置
            queue.on('resetCoupon',function(){
                window.coupon = {};
                bookData.discount.couponPrice=0;
                $('.coupon-list li.choosed').removeClass('choosed');
                queue.emit('discountInfo');
            });
            queue.on('resetDiscount',function(){
                queue.emit('resetCoupon');
            });
        });
        //检测优惠券有效性
        function check_and_set_coupon(objParams, node) {
            $.ajax({
                type: "post",
                url: SITEURL + 'coupon/ajax_check_samount',
                data: {
                    couponid: objParams.id, //优惠券编号
                    totalprice: bookData.totalPrice, //支付总价
                    typeid: {$typeid},//产品类型编号
                    proid: bookData.id, //产品编号
                    startdate: bookData.currentDate || '{date("Y-m-d")}' //产品预订时间
                },
                datatype: 'json',
                success: function (data) {
                    data = JSON.parse(data);
                    var bool = data.status > 0 ? true : false;
                    var mxListNode = $('.mx-list');
                    mxListNode.find('.couponNode').remove();
                    if (bool) {
                        var couponPrice = objParams.type == 0 ? objParams.detail : (bookData.totalPrice - Math.ceil(objParams.detail * 0.1 * bookData.totalPrice));
                        if (bookData.checkCanUse('couponPrice') >= couponPrice) {
                            bookData.discount.couponPrice = couponPrice;
                            window.coupon=objParams;
                            node.addClass('choosed');
                            mxListNode.append('<li class="couponNode"><strong>优惠券</strong><em>' + currency + couponPrice + '</em></li>');
                        }
                        else {
                            bool = false;
                        }
                    }
                    if (!bool) {
                        window.coupon={};
                        $.layer({
                            type: 1,
                            icon: 2,
                            text: '不满足使用条件',
                            time: 1000
                        });
                    }
                    queue.emit('discountInfo');
                    queue.emit('totalPrice');
                    history.go(-1);
                }
            })
        }
    </script>
</div>
