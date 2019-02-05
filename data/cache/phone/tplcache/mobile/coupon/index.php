<!DOCTYPE html>
<html>
<head padding_strong=C2QzDt >
    <meta charset="UTF-8">
    <title>领取优惠券-<?php echo $GLOBALS['cfg_webname'];?></title>
    <?php if($seoinfo['keyword']) { ?>
    <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" />
    <?php } ?>
    <?php if($seoinfo['description']) { ?>
    <meta name="description" content="<?php echo $seoinfo['description'];?>" />
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php echo Common::css('base.css,reset-style.css');?>
    <?php echo Common::css_plugin('coupon.css','coupon');?>
    <?php echo Common::js('lib-flexible.js,jquery.min.js,common.js,layer/layer.m.js,template.js');?>
</head>
<body>
<header>
    <div class="header_top">
        <a class="back-link-icon" onclick="history.go(-1)"></a>
        <h1 class="page-title-bar">领券中心</h1>
    </div>
</header>
<!-- 公用顶部 -->
<div class="page-content coupon">
    <div class="receive-coupon-block">
        <ul class="receive-coupon-list" id="coupon-list">
        </ul>
        <div class="list-loading" style="display: none">
            <i class="loading-icon"></i>努力加载中
        </div>
        <div class="list-bottom"  style="display: none">
           已经全部加载完了！
        </div>
 <div class="no-content-page hide">
            <div class="no-content-icon"></div>
            <p class="no-content-txt">此页面暂无内容</p>
        </div>
    </div>
</div>
<input type="hidden" id="page" value="1"/>
<input type="hidden" id="productid" value="<?php echo $productid;?>"/>
<input type="hidden" id="typeid" value="<?php echo $typeid;?>"/>
<script type="text/html" id="tpl_couponlist">
    {{each list as value i}}
    <li class="clearfix {{if value.status==2}}after{{else if value.status==1||value.status==4}}un{{/if}}">
        <div class="item-l fl">
            <div class="info">
                <p class="price">{{if value.type==0}}&yen;{{/if}}<b class="no-style">{{value.amount}}</b></p>
                <div class="txt">
                    <strong class="no-style">{{value.name}}</strong>
                    <span>满{{value.samount}}元可用</span>
                </div>
            </div>
            <div class="des">
                <p>品类限制：{{value.typename}}</p>
                <p>需提前{{value.antedate}}天使用，每人限领{{value.maxnumber}}张</p>
                {{if value.isnever==1}}
                <p>有效期：{{value.starttime}} 至 {{value.endtime}}</p>
                {{else}}
                <p>有效期：永久有效</p>
                {{/if}}
            </div>
        </div>
        <div class="item-r fr">
            <div class="con">
                {{if value.status==1||value.status==4}}
                {{if value.gradename}}
                <p class="txt">
                    限{{value.gradename_all}}
                </p>
                {{/if}}
                <a class="btn" href="javascript:;" onclick="get_coupon({{value.id}})">立即领取</a>
                <p class="num">还有{{value.surplus}}张</p>
                {{else if value.status==2}}
                <i class="ico"><img src="<?php echo $img_url;?>/plugins/coupon/public/mobile/images/coupon-ico-02.png" alt="" title="" /></i>
                {{else if value.status==3}}
                <i class="ico"><img src="<?php echo $img_url;?>/plugins/coupon/public/mobile/images/coupon-ico-01.png" alt="" title="" /></i>
                <a class="btn" href="<?php echo $cmsurl;?>coupon/search-{{value.id}}" >立即使用</a>
                {{/if}}
            </div>
        </div>
    </li>
    {{/each}}
</script>
<script type="text/javascript">
    $(function(){
        $("html,body").css("height", "100%");
        get_morecoupon();
        $('.coupon').scroll( function() {
            var totalheight = parseFloat($(this).height()) + parseFloat($(this).scrollTop());
            var scrollHeight = $(this)[0].scrollHeight;//实际高度
            if(totalheight-scrollHeight>= -10){
                get_morecoupon();
            }
        });
    });
    function get_coupon(couponid)
    {
        var fromurl = '<?php echo $fromurl;?>';
        $.ajax({
            type: 'POST',
            url:  '<?php echo $cmsurl;?>coupon/ajxa_get_coupon',
            data: {cid:couponid,fromurl:fromurl},
            async: false,
            dataType: 'json',
            success: function (data) {
                if(data.status==0)
                {
                    layer.open({
                        content: data.msg
                        ,btn: ['知道了']
                    });
                }
                if(data.status==1)
                {
                    layer.open({
                        content: data.msg
                        ,btn: ['前往登陆', '不要']
                        ,yes: function(index){
                            location.href = '<?php echo $cmsurl;?>member/login'
                            layer.close(index);
                        }
                    });
                }
                if(data.status==2)
                {
                    layer.open({
                        content: data.msg
                        ,btn: ['前往使用', '继续领取']
                        ,yes: function(index){
                            location.href = data.fromurl;
                            layer.close(index);
                        },no:function(index)
                        {
                            location.reload();
                        }
                    });
                }
            }
        })
    }
    var is_allow = 1;
    function get_morecoupon()
    {
        if(is_allow==0)
        {
            return false;
        }
        var page = Number($("#page").val());
        if(page==-1)
        {
            $('.list-bottom').show();
            return false;
        }
        is_allow = 0;
        $('.list-loading').show();
        var productid = Number($("#productid").val());
        var typeid = Number($("#typeid").val());
        $("#page").val(page+1);
        var url = '<?php echo $cmsurl;?>coupon/ajax_get_list';
        $.ajax({
            type:'post',
            dataType:'json',
            data:{productid:productid,typeid:typeid,page:page},
            url:url,
            success:function(data){
if(!data.list)
{
$(".no-content-page").show();
}

if( (page==0 || page==1) && data.list && data.list.length==0)
{
$(".no-content-page").show();
}

                is_allow = 1;
                $('.list-loading').hide();
                if(data.list)
                {
                    var html = template("tpl_couponlist",data);
                    $("#coupon-list").append(html);
                }
                else
                {
                    $('#page').val(-1)
                }
            }
        })
    }
</script>
</body>
</html>
