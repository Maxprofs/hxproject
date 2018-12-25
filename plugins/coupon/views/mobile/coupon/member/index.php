{Common::css_plugin('coupon.css','coupon')}
{Common::js('lib-flexible.js,jquery.min.js')}
<header div_table=kNACXC >
    <div class="header_top">
        <a class="back-link-icon" href="#pageHome"></a>
        <h1 class="page-title-bar">我的优惠券</h1>
    </div>
</header>
<!-- 公用顶部 -->
<div class="show-content coupon">
    <div class="tab-bar">
        <ul class="tab-list clearfix">
            <li class="on"  data-isout="1">未使用</li>
            <li  data-isout="3">已使用</li>
            <li  data-isout="2">已失效</li>
        </ul>
    </div>
    <div class="use-coupon-center-block">
        <ul class="receive-coupon-list coupon-center-list" id="coupon_list">

        </ul>
    </div>
    <div class="end-txt" style="display: none">已全部加载完了！</div>
    <div class="no-content-page" style="display: none">
        <div class="no-content-icon"></div>
        <p class="no-content-txt">没有查找到信息</p>
    </div>

</div>






<script  type="text/html" id="tpl_coupon">
    {{each list as value i}}
    <li class="clearfix {{value.class}}">
        {{if value.kindid==1}}
        <div class="attr-ty">通用券</div>
        {{else if value.kindid==2}}
        <div class="attr-zs">赠送券</div>
        {{/if}}
        <div class="item-l fl">
            <div class="info">
                <p class="price">{{if value.type==0}}&yen;{{/if}}<b>{{value.amount}}</b></p>
                <div class="txt">
                    <strong>{{value.name}}</strong>
                    <span>满{{value.samount}}元可用</span>
                </div>
            </div>
            <div class="des">
                <p>品类限制：{{value.typename}}</p>
                {{if value.isnever==1}}
                <p>有效期：{{value.starttime}} 至 {{value.endtime}}</p>
                {{else}}
                <p>有效期：永久有效</p>
                {{/if}}
            </div>
        </div>
        <div class="item-r fr">
            <div class="con">
                {{if value.class=='after'&&value.isout==3}}
                <a class="btn" href="javascript:;">已使用</a>
                {{else if value.class!='after'}}
                {{if value.antedate>0}}
                <p class="num">提前{{value.antedate}}天使用</p>
                {{/if}}
                <a class="btn" data-ajax="false"  href="{$cmsurl}coupon/search-{{value.id}}">立即使用</a>
                {{/if}}
                <p class="num">共1张</p>
            </div>
        </div>
        {{if value.class=='after'&&value.isout==2}}
        <div class="over-ico overdue"></div>
        {{/if}}
    </li>
    {{/each}}
</script>

<div class="receive-btn">
    <a data-ajax="false"  href="{$cmsurl}coupon">领取优惠券</a>
</div>
<script type="text/javascript">
    $(function(){
        $("html,body").css("height", "100%");
    });
</script>

<script>
    var params={
        page:1,
        kindid:0
    }
    var is_loading = false;
    $(function(){
        $('.tab-list li').click(function(){
            $(this).addClass('on').siblings().removeClass('on');
            params.page = 1;
            get_data();
        })
        get_data();

        $('.coupon').scroll( function() {

            var totalheight = parseFloat($(this).height()) + parseFloat($(this).scrollTop());
            var scrollHeight = $(this)[0].scrollHeight;//实际高度

            if(totalheight-scrollHeight>= -10){

                if(params.page!=-1 && !is_loading){
                    is_loading = true;
                    get_data();
                }

            }
        });

    })
    function get_data() {
        var isout = $('.tab-list li.on').attr('data-isout');
        params.isout = isout;
        var url = SITEURL+'member/coupon/ajax_get_list'
        $.getJSON(url, params, function (data) {
            var itemHtml='';
            if (data.list.length > 0) {
                itemHtml = template('tpl_coupon', data);
            }
            if(params.page==1){
                $("#coupon_list").html(itemHtml);
            }else{
                $("#coupon_list").append(itemHtml);
            }
            var len = $('#coupon_list').find('li').length;
            if(len == 0){
                $(".no-content-page").show();
            }else{
                $(".no-content-page").hide();
            }
            //分页
            if (data.page == -1 && len>0) {
                $('.end-txt').show();
            } else {
                $('.end-txt').hide();
            }
            params.page = data.page;
            is_loading = false;

        });




    }
</script>

