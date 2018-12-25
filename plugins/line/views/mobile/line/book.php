<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <title>{$info['title']}预订-{$webname}</title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('base.css,reset-style.css')}
    {Common::css_plugin('line.css','line')}
    {Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,delayLoading.min.js,jquery.layer.js,validate.js,common.js')}
    {Common::js('layer/layer.js',0)}
</head>
<body>

{request "pub/header_new/typeid/$typeid/isbookpage/1"}
<!--    <div class="header_top bar-nav">-->
<!--        <a class="back-link-icon" href="javascript:;"></a>-->
<!--        <h1 class="page-title-bar">选择套餐</h1>-->
<!--    </div>-->
    <!-- 公用顶部 -->

    <div class="type-choose-container">
        {loop $suitlist $suit}
		<a href="javascript:;" data-id="{$suit['id']}" data-minprice="{$suit['minprice']}" class="item {if $suit['id']==$suitid}on{/if}">{$suit['suitname']}</a>
        {/loop}
    </div>
    <!-- 选择套餐 -->

    <div class="calendar-container">
        <div class="calendar-tit-bar">选择日期{if $info['islinebefore']}<span class="jy">建议提前{$info['linebefore']}天预定</span>{/if}
        </div>
    </div>
    <!-- 报价 -->
<form id="submit" action="{$cmsurl}line/over_book" method="get">
    <div class="people-num-container">
        <h3 class="tit-bar">选择数量</h3>
        <div class="block-item">
            <ul id="book-info">

            </ul>
        </div>
    </div>
    <!-- 选择数量 -->

	<div class="other-item-box">

    </div>
	
	<div class="type-bottom-bar">
	    <div class="type-bottom-fixed">
			<span class="order-total">订单总额{Currency_Tool::symbol()}0</span>
            <a class="next-step disabled" href="javascript:;">下一步</a>
	    </div>
    </div>

    <input type="hidden" name="productid" id="lineid" value="{$info['id']}">
    <input type="hidden"  name="suitid" id="suitid" value="{$suitid}">
    <input type="hidden" id="roombalance" value="0">
    <input type="hidden" id="childprice" value="0">
    <input type="hidden" id="adultprice" value="0">
    <input type="hidden" id="oldprice" value="0">
    <input type="hidden" id="storage" value="0">
    <input type="hidden" name="usedate"  id="usedate" value="0">
</form>

</body>
</html>
<script>
    var CURRENCY_SYMBOL="{Currency_Tool::symbol()}";
    $(function () {
        //套餐选择
        $('.type-choose-container a').click(function () {
            $('.type-choose-container a').removeClass('on');
            $(this).addClass('on');
            var suitid = $(this).data('id');
            $('#suitid').val(suitid);
            change_suit();
        });
        var suitid = $('#suitid').val();
        if(suitid)
        {
            $('.type-choose-container a[data-id='+suitid+']').trigger('click');
        }
        else
        {
            $('.type-choose-container a:first').trigger('click');
        }

        //数量增加
        $('#book-info').on('click','.add-btn',function () {
            var number = $(this).prev().val();
            number++;
            $(this).prev().val(number);
            var total = get_total_number();
            var storage = Number($('#storage').val());

            if(storage!=-1)
            {
                if(storage<total)
                {
                    $.layer({type:1, icon:2,time:1000, text:'余位不足'});
                    $(this).prev().val(--number);
                }
            }
            get_total_price();
            $('.next-step').removeClass('disabled');
        });
        //数量减少
        $('#book-info').on('click','.sub-btn',function () {
            var number = $(this).next().val();
            if(number<0)
            {
                return false;
            }
            if($(this).next().attr('id')!='roombalance_num')
            {
                var total = get_total_number();
                //至少应该有一个预定人
                if(total<1)
                {
                    return false;
                }

            }
            number--;
            $(this).next().val(number);
            var _total = get_total_number();
            if(_total<=0)
            {
                $('.next-step').addClass('disabled');
            }
            else
            {
                $('.next-step').removeClass('disabled');
            }
            get_total_price();
        });
        //时间切换
        $('.calendar-container').on('click','.calendar-prev,.calendar-next',function () {
            var year = $(this).data('year');
            var month = $(this).data('month');
            get_calendar(year,month,'');

        });

        $('.next-step').click(function () {
            if($(this).hasClass('disabled'))
            {
                return false;
            }
            if(get_total_number()<1)
            {
                $.layer({type:1, icon:2,time:1000, text:'请填写预订人数'});
                return false;
            }
            if(!$('#usedate').val()||!$('#suitid').val())
            {
                $.layer({type:1, icon:2,time:1000, text:'请选择预订时间'});
                return false;
            }
            $('#submit').submit();

        })


    });







    //套餐变更
    function change_suit() {
        var suitid = $('#suitid').val();
        var lineid = $('#lineid').val();
        $.ajax({
            data:{suitid:suitid,productid:lineid},
            url:SITEURL+'line/ajax_suit_people',
            dataType:'json',
            type:'get',
            success:function (data) {
                var html ='';
                if(data.row.description)
                {
                    html+= '<div class="other-item-block"><h3 class="col-tit">套餐说明</h3>' +
                        '<div class="con-box">'+data.row.description+'</div></div>'
                }
                if(data.row.paytype==1)
                {
                    html+= '<div class="other-item-block"><h3 class="col-tit">支付方式</h3>' +
                        '<div class="con-box">'+data.row.paytype_name+'</div></div>'
                }
                /*if(data.row.adultdesc)
                {
                    html+= '<div class="other-item-block"><h3 class="col-tit">成人标准</h3>' +
                        '<div class="con-box">'+data.row.adultdesc+'</div></div>'
                }*/
                if(data.row.childdesc)
                {
                    html+= '<div class="other-item-block"><h3 class="col-tit">儿童标准</h3>' +
                        '<div class="con-box">'+data.row.childdesc+'</div></div>'
                }
                if(data.row.olddesc)
                {
                    html+= '<div class="other-item-block"><h3 class="col-tit">老人标准</h3>' +
                        '<div class="con-box">'+data.row.olddesc+'</div></div>'
                }
                if(data.row.roomdesc)
                {
                    html+= '<div class="other-item-block"><h3 class="col-tit">单房差标准</h3>' +
                        '<div class="con-box">'+data.row.roomdesc+'</div></div>'
                }
                $('.other-item-box').html(html);
                $("img[st-src]").delayLoading({          // 预加载前显示的图片
                    errorImg: "",                        // 读取图片错误时替换图片(默认：与defaultImg一样)
                    imgSrcAttr: "st-src",           // 记录图片路径的属性(默认：originalSrc，页面img的src属性也要替换为originalSrc)
                    beforehand: window.screen.height,                       // 预先提前多少像素加载图片(默认：0)
                    event: "scroll",                     // 触发加载图片事件(默认：scroll)
                    duration: "normal",                  // 三种预定淡出(入)速度之一的字符串("slow", "normal", or "fast")或表示动画时长的毫秒数值(如：1000),默认:"normal"
                    container: $('.other-item-box'),                   // 对象加载的位置容器(默认：window)
                    success: function (imgObj) {
                    },      // 加载图片成功后的回调函数(默认：不执行任何操作)
                    error: function (imgObj) {
                    }         // 加载图片失败后的回调函数(默认：不执行任何操作)
                });

                set_book_user(data);
                get_calendar('','',data.useday);
            }

        })
    }

    //处理预定人群
    function set_book_user(data)
    {
        var book_html = '';
        $('#roombalance').val(data.roombalance);
        $('#storage').val(data.storage);
        var store = data.storage;
        var adultnum = 1;
        if(store!=-1&&store<adultnum)
        {
            adultnum = 1;
        }



        if(data.hasadult==1)
        {
            book_html += '<li><strong class="item-hd no-style">成人</strong><span class="item-jg">'+CURRENCY_SYMBOL+data.adultprice+'</span>' +
                '<span class="amount-opt-wrap"><a href="javascript:;" class="sub-btn">–</a>' +
                '<input type="text" id="adult_num" onfocus="document.activeElement.blur()" name="adult_num" readonly class="num-text" maxlength="4" value="'+adultnum+'">' +
                '<a href="javascript:;" class="add-btn">+</a></span></li>';
            $('#adultprice').val(data.adultprice);
        }
        else
        {
            $('#adultprice').val(0);
        }
        if(data.haschild==1)
        {
            book_html += '<li><strong class="item-hd no-style">儿童</strong><span class="item-jg">'+CURRENCY_SYMBOL+data.childprice+'</span>' +
                '<span class="amount-opt-wrap"><a href="javascript:;" class="sub-btn">–</a>' +
                '<input type="text" id="child_num" onfocus="document.activeElement.blur()" name="child_num" readonly class="num-text" maxlength="4" value="0">' +
                '<a href="javascript:;" class="add-btn">+</a></span></li>';

            $('#childprice').val(data.childprice);
        }
        else
        {
            $('#childprice').val(0);
        }
        if(data.hasold==1)
        {
            book_html += '<li><strong class="item-hd no-style">老人</strong><span class="item-jg">'+CURRENCY_SYMBOL+data.oldprice+'</span>' +
                '<span class="amount-opt-wrap"><a href="javascript:;" class="sub-btn">–</a>' +
                '<input type="text" id="old_num" name="old_num" onfocus="document.activeElement.blur()" readonly class="num-text" maxlength="4" value="0">' +
                '<a href="javascript:;" class="add-btn">+</a></span></li>';
            $('#oldprice').val(data.oldprice);
        }
        else
        {
            $('#oldprice').val(0);
        }
        if(data.roombalance>0)
        {
            book_html += '<li><strong class="item-hd no-style">单房差</strong><span class="item-jg">'+CURRENCY_SYMBOL+data.roombalance+'</span>' +
                '<span class="amount-opt-wrap"><a href="javascript:;" class="sub-btn">–</a>' +
                '<input type="text" id="roombalance_num" onfocus="document.activeElement.blur()" name="roombalance_num"   readonly class="num-text" maxlength="4" value="0">' +
                '<a href="javascript:;" class="add-btn">+</a></span></li>';
        }

        $('#book-info').html(book_html);

        if(data.useday)
        {
            $('.next-step').removeClass('disabled');
            $('.next-step').text('下一步');
            $('#usedate').val(data.useday)
        }
        else if (data.hasprice==0)
        {
            $('.next-step').addClass('disabled');
            $('.next-step').text('下一步');
            $('#usedate').val('')

        }
        else
        {
            $('.next-step').addClass('disabled');
            $('.next-step').text('订完');
            $('#usedate').val('')
        }

        get_total_price();
    }


    //计算总价
    function get_total_price() {
        var adult_num  = $('#adult_num').val();
        var child_num  = $('#child_num').val();
        var old_num  = $('#old_num').val();
        var roombalance_num  = $('#roombalance_num').val();
        var roombalance = $('#roombalance').val();
        var adultprice = $('#adultprice').val();
        var childprice = $('#childprice').val();
        var oldprice = $('#oldprice').val();
        var total = 0;
        if(Number(adult_num))
        {
            total += ST.Math.mul(Number(adult_num),Number(adultprice));
        }
        if(Number(child_num))
        {

            total += ST.Math.mul(Number(child_num),Number(childprice));
        }
        if(Number(old_num))
        {
            total += ST.Math.mul(Number(old_num),Number(oldprice));
        }
        if(Number(roombalance_num))
        {
            total += ST.Math.mul(Number(roombalance_num),Number(roombalance));
        }
        $('.order-total').text('订单总额'+CURRENCY_SYMBOL+total);
    }
    
    //获取日历
    function get_calendar(year,month,date) {
        var url=SITEURL+'line/ajax_price_calendar_new';
        var suitid=$("#suitid").val();
        var lineid = $('#lineid').val();
        $.ajax({
            type: 'GET',
            url: url,
            data: {suitid: suitid, productid: lineid,year:year,month:month,date:date},
            dataType: 'html',
            success: function (data)
            {
                $('.calendar-container').html(data);
                var usedate = $('#usedate').val();
                $('.calendar-container td .opt').each(function (i,v) {
                    if(usedate&&$(v).parent().attr('date')==usedate)
                    {
                        $(v).addClass('active');
                    }
                })
            }
        });
        
    }

    function get_total_number() {
        var total = 0;
        var adult_num = Number($('#adult_num').val());
        var child_num = Number($('#child_num').val());
        var old_num = Number($('#old_num').val());
        if(adult_num>0)
        {
            total += adult_num;
        }
        if(child_num>0)
        {
            total += child_num;
        }
        if(old_num>0)
        {
            total += old_num;
        }
        return total;
    }


    //选择日期
    function choose_day(obj) {
        var adultprice = $(obj).attr('adultprice');
        var childprice = $(obj).attr('childprice');
        var oldprice = $(obj).attr('oldprice');
        var number = $(obj).attr('number');
        var roombalance = $(obj).attr('roombalance');
        var date = $(obj).attr('date');
        var data = {};
        if(adultprice>0)
        {
            data.adultprice = adultprice;
            data.hasadult = 1;
        }
        if(childprice>0)
        {
            data.childprice = childprice;
            data.haschild = 1;
        }
        if(oldprice>0)
        {
            data.oldprice = oldprice;
            data.hasold = 1;
        }
        data.storage = number;
        data.roombalance = roombalance;
        data.useday = date;
        set_book_user(data);
        $('.calendar-container td .opt').removeClass('active');
        $(obj).find('.opt').addClass('active');
    }

</script>
