
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>套餐添加/修改</title>
    <?php echo Common::css("style.css,base.css,style_hotel.css,base_hotel.css,base2.css,jquery.datetimepicker.css,calendar-price-jquery.min.css");?>
    <?php echo Common::js("jquery.min.js,common.js,product.js,choose.js,imageup.js,jquery.datetimepicker.full.js");?>
    <script src="/plugins/supplier_spot/public/js/calendar-price-jquery.js"></script>
    <script type="text/javascript"src="/tools/js/DatePicker/WdatePicker.js"></script>
    <?php echo  Stourweb_View::template("pub/public_js");  ?>
</head>
<body>
<div class="page-box">
    <?php echo Request::factory("pub/header")->execute()->body(); ?>
    <?php echo Request::factory("pub/sidemenu")->execute()->body(); ?>
    <div class="main">
        <div class="content-box">
            <div class="frame-box">
                <div class="pt-manage-box">
<div class="content-box">
    <form method="post" name="product_frm" id="product_frm" autocomplete="off">
        <div class="manage-nr">
            <div class="w-set-con">
                <div class="w-set-tit bom-arrow" id="nav">
                    <span class="on" data-id="base"><s></s>活动套餐</span>
                    <span data-id="more"><s></s>高级</span>
                    <a href="javascript:;" class="refresh-btn" onclick="window.location.reload()">刷新</a>
                </div>
            </div>
            <!--基础信息开始-->
            <div class="product-add-div" id="content_base">
                <div class="add-class">
                    <dl>
                        <dt>当前景点：</dt>
                        <dd>
                            <button type="button" class="fl" id="sel_spot_btn">选择景点</button>
                            <div class="save-value-div mt-2 ml-10" id="spotid_con">
                                <?php if(!empty($product)) { ?>
                                <span><s onclick="$(this).parent('span').remove()"></s><?php echo $product['title'];?><input type="hidden" class="lk" name="spotid" value="<?php echo $product['id'];?>"></span>
                                <?php } ?>
                            </div>
                        </dd>
                    </dl>
                    <dl>
                        <dt>门票名称：</dt>
                        <dd>
                            <input type="text" name="title" id="suitname"  class="set-text-xh text_700 mt-2" value="<?php echo $info['title'];?>" />
                        </dd>
                    </dl>
                    <dl>
                        <dt>门票类型：</dt>
                        <dd>
                            <select id="field_tickettypeid" class="set-text-xh mt-2" name="tickettypeid"></select>
                            <input type="text" id="field_newtickettype"  style="display: none;" name="newtickettype"   class="set-text-xh text_60 mt-2 ml-10" value="" />
                            <a href="javascript:;" class="ml-10 mt-2" id="tickettype_add_btn">添加类型</a>
                        </dd>
                    </dl>
                    <dl>
                        <dt>原价：</dt>
                        <input type="text" name="sellprice"  class="set-text-xh text_100 mt-2" value="<?php echo $info['sellprice'];?>" />
                    </dl>
                    <dl>
                        <dt>报价日历：</dt>
                        <dd><button type="button" id="price_set_btn">设置报价</button>
                            <button type="button" onclick="clearPrice()">清除报价</button></dd>
                    </dl>
                    <dl>
                        <dt></dt>
                        <dd>
                            <div class="container">
                            </div>
                        </dd>
                    </dl>
                    <dl>
                        <dt>套餐说明：</dt>
                        <dd>
                            <?php Common::get_editor('description',$info['description'],700,120,'Line');?>
                        </dd>
                    </dl>
                </div>
                <div class="add-class">
                    <dl>
                        <dt style="width:120px;">提前预订时间：</dt>
                        <dd style="width:800px">
                            <label class="fl">提前 </label><input type="text" id="day_before" maxlength="3" name="day_before" class="set-text-xh text_60 mt-2 ml-5" value="<?php echo $info['day_before'];?>" />
                            <label class="fl ml-5"> 天预订 </label>
                            <input type="text" name="time_before" id="time_before" class="set-text-xh text_60 mt-2 ml-20" value="<?php echo $info['time_before'];?>" />
                            <label class="fl ml-5"> 前结束当天预订</label>
                            <span class="ml-10" style="color:#999">*前台报价会根据提前时间来显示, 小时分钟均为00时，表示可以在23：59：59秒前预订</span>
                            <label class="error-lb"></label>
                        </dd>
                    </dl>
                    <dl>
                        <dt>取票方式：</dt>
                       <dd><input type="text" name="get_ticket_way"  class="set-text-xh text_700 mt-2" value="<?php echo $info['get_ticket_way'];?>" /> </dd>
                    </dl>
                    <dl>
                        <dt>有效期：</dt>
                        <dd> <label class="fl ml-5">游客指定入园日期后&nbsp;&nbsp; </label><input type="text" name="effective_days"  class="set-text-xh text_60 mt-2" value="<?php echo $info['effective_days'];?>" />&nbsp;&nbsp;天内有效 </dd>
                    </dl>
                    <dl>
                        <dt>退票类型：</dt>
                        <dd>
                            <label class="radio-label"><input type="radio" name="refund_restriction" value="0" <?php if(empty($info['refund_restriction'])) { ?>checked="checked"<?php } ?>
 />无条件退款</label>
                            <label class="radio-label ml-20"><input type="radio" name="refund_restriction" value="1" <?php if($info['refund_restriction']=='1') { ?>checked="checked"<?php } ?>
 />不可退改</label>
                            <label class="radio-label ml-20"><input type="radio" name="refund_restriction" value="2" <?php if($info['refund_restriction']=='2') { ?>checked="checked"<?php } ?>
 />有条件退改</label>
                        </dd>
                    </dl>
                    <dl>
                        <dt>预定方式：</dt>
                        <dd>
                                <label class="radio-label"><input type="radio" name="paytype" value="1" <?php if($info['paytype']=='1' OR empty($info['paytype'])) { ?>checked="checked"<?php } ?>
 />全额预定</label>
                        </dd>
                    </dl>
                    <dl>
                        <dt>支付方式：</dt>
                        <dd>
                            <div class="on-off">
                                <input type="checkbox" name="pay_way[]" value="1" <?php if($info['pay_way']=='1'||$info['pay_way']=='3') { ?>checked="checked"<?php } ?>
 />线上支付 &nbsp;
                                <input type="checkbox" name="pay_way[]" value="2" <?php if($info['pay_way']=='2'||$info['pay_way']=='3') { ?>checked="checked"<?php } ?>
 />线下支付 &nbsp;
                            </div>
                        </dd>
                    </dl>
                    <dl>
                        <dt style="width:120px">预定确认方式：</dt>
                        <dd>
                            <label class="radio-label"><input type="checkbox" name="need_confirm" value="1" <?php if($info['need_confirm']=='1') { ?>checked="checked"<?php } ?>
 />需要管理员手动确认</label>
                        </dd>
                    </dl>
                </div>
               <!-- <div class="add-class">
                    <dl>
                        <dt>供应结算价：</dt>
                        <dd>
                            <input type="text" name="basicprice" value="<?php echo $suit['basicprice'];?>" class="set-text-xh text_100 mt-2 "  />
                            <span class="fl ml-5">元</span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>建议零售价：</dt>
                        <dd>
                            <input type="text" name="suggest_price"  value="<?php echo $suit['suggest_price'];?>" class="set-text-xh text_100 mt-2 "  />
                            <span class="fl ml-5">元</span><span style="color:gray;padding-left:10px">*供应结算价：给平台提供的结算价格。建议零售价：建议平台的零售价格。</span>
                        </dd>
                    </dl>
                </div> -->
            </div>
            <div class="product-add-div" id="content_more">
                <div class="add-class">
                    <dl>
                        <dt>游客信息：</dt>
                        <dd>
                            <label class="radio-label"><input type="radio" name="fill_tourer_type" value="0" <?php if(empty($info['fill_tourer_type'])) { ?>checked="checked"<?php } ?>
 />不需要</label>
                            <label class="radio-label ml-20"><input type="radio" name="fill_tourer_type" value="1" <?php if($info['fill_tourer_type']=='1') { ?>checked="checked"<?php } ?>
 />仅需要一位</label>
                            <label class="radio-label ml-20"><input type="radio" name="fill_tourer_type" value="2" <?php if($info['fill_tourer_type']=='2') { ?>checked="checked"<?php } ?>
 />需要所有游客信息</label>
                        </dd>
                    </dl>
                    <dl>
                        <dt style="width:120px">游客信息必填项：</dt>
                        <dd>
                            <label class="radio-label"><input type="checkbox" name="fill_tourer_items[]" value="tourername" <?php if(in_array('tourername',$info['fill_tourer_items_arr']) || empty($info['id'])) { ?>checked="checked"<?php } ?>
 />姓名</label>
                            <label class="radio-label"><input type="checkbox" name="fill_tourer_items[]" value="mobile" <?php if(in_array('mobile',$info['fill_tourer_items_arr'])|| empty($info['id'])) { ?>checked="checked"<?php } ?>
 />手机号</label>
                            <label class="radio-label"><input type="checkbox" name="fill_tourer_items[]" value="cardnumber" <?php if(in_array('cardnumber',$info['fill_tourer_items_arr'])|| empty($info['id'])) { ?>checked="checked"<?php } ?>
 />证件号</label>
                            <label class="radio-label"><input type="checkbox" name="fill_tourer_items[]" value="sex"  <?php if(in_array('sex',$info['fill_tourer_items_arr'])|| empty($info['id'])) { ?>checked="checked"<?php } ?>
/>性别</label>
                        </dd>
                    </dl>
                </div>
            </div>
            <!--/基础信息结束-->
            <div class="opn-btn" style="padding-left: 10px; " id="hidevalue">
                <input type="hidden" name="id" id="id" value="<?php echo $info['id'];?>"/>
                <a class="normal-btn" id="btn_save" href="javascript:;">保存</a>
            </div>
        </div>
    </form>
 </div>
 </div>
 </div>
 </div>
 </div>
<script>
    var suitid = "<?php echo $info['id'];?>";
    var g_allowed_days = [];
    var last_year = "<?php echo $last_year;?>";
    var last_month = "<?php echo $last_month;?>";
    var has_period = "<?php echo $has_period;?>";
    var tickettypeid = "<?php echo $info['tickettypeid'];?>"
    $(document).ready(function () {
        //日期选择
        $('#time_before').datetimepicker({
            format:'H:i',
            datepicker:false,
            timepicker:true,
            allowTimes:[
                '01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00',
                '15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00','00:00',
            ]
        });
        //初始化产品类型
        get_ticket_types(1);
        //切换
        $("#nav").find('span').click(function(){
            $(this).addClass('on');
            $(this).siblings().removeClass('on');
             var id = $(this).attr('data-id');
             $(".product-add-div").hide();
             $("#content_"+id).show();
        });
        $("#nav").find('span').first().trigger('click');
        //添加新的类型
        $("#tickettype_add_btn").click(function(){
             $("#field_newtickettype").show();
        });
        //保存
        $("#btn_save").click(function () {
            var suitname = $("#suitname").val();
            if (suitname == '') {
                ST.Util.showMsg('请输入套餐名称', 5, 1000);
                return false;
            }
            var pay_way_number = $('input[name^=pay_way]:checked').length;
            if(pay_way_number == 0){
                ST.Util.showMsg('请至少选择一种支付方式',5,1000);
                return false;
            }
            var basicprice = parseFloat($('input[name="basicprice"]').val());
            if (basicprice < 1) {
                ST.Util.showMsg('请填写供应结算价', 5, 1000);
                return false;
            }
            var suggest_price=parseFloat($('input[name="suggest_price"]').val());
            if(basicprice>suggest_price){
                ST.Util.showMsg('建议零售价不得低于供应结算价', 5, 1000);
                return false;
            }
            $.ajax({
                type: 'POST',
                url: SITEURL + "index/ajax_suit_save",
                data: $('#product_frm').serialize(),
                dataType: "json",
                success: function (data, opts) {
                    var org_suitid = $("#id").val();
                    if (data.status) {
                        $("#id").val(data.id);
                        ST.Util.showMsg('保存成功!', '4', 2000);
                        tip_no_date();
                        if(!org_suitid||org_suitid=='')
                        {
                            ajax_get_suit_price(last_year, last_month, 1);
                        }
                    }else{
                        ST.Util.showMsg(data.msg, '5', 2000);
                    }
                }
            });
        });
        //设置所有价格
        $("#price_set_btn").click(function(){
            var suitid = $("#id").val();
            if(!suitid || suitid=='')
            {
                ST.Util.showMsg('请先保存套餐',5,1000);
                return;
            }
            CHOOSE.setSome('设置报价',{maxHeight:500,width:540,loadWindow:window,loadCallback:set_all_price},SITEURL+'index/dialog_edit_all_suit_price?suitid='+suitid,1)
        });
        //初始化
        if(suitid)
        {
            tip_no_date();
            ajax_get_suit_price(last_year, last_month, 1);
        }
        //选择景点按钮
        $("#sel_spot_btn").click(function(){
            var params= {loadCallback:setSpot};
             params['loadWindow'] = window;
                if(!params['maxHeight'])
                    params['maxHeight']=600;
            var url=SITEURL+'index/dialog_get_spots';
            ST.Util.showBox('选择景点',url,600,'',null,null,document,params);
        });
        function setSpot(data)
        {
            var html='<span><s onclick="$(this).parent(\'span\').remove()"></s>'+data.title+'<input type="hidden" class="lk" name="spotid" value="'+data.id+'"></span>';
            $("#spotid_con").html(html);
            get_ticket_types();
        }
    });
    function set_all_price(data,status)
    {
        if(status)
        {
            console.log(data);
            $.ajax({
                data: data.data,
                dataType: 'json',
                type: 'post',
                url: SITEURL + 'index/ajax_save_all_price',
                success: function (data) {
                   ajax_get_suit_price(null, null, 1);
                }
            })
        }
    }
    function ajax_get_suit_price(y,m,init) {
        var suitid = $("#id").val();
        var out = [];
        $.ajax({
            type:'post',
            dataType:'json',
            async:false,
            data:{year:y,month:m,suitid:suitid},
            url:SITEURL+'index/ajax_get_suit_price',
            success:function (data) {
                if(data.allowed_days)
                {
                    g_allowed_days=data.allowed_days;
                }
                if(init)
                {
                    if(data.starttime)
                    {
                        $('#more_price').show();
                        calendar_init(data)
                        $('.container').show();
                    }
                    else
                    {
                        $('#more_price').hide();
                        $('.container').hide();
                    }
                }
                else
                {
                    out = data.list;
                }
            }
        });
        return out;
    }
    function tip_no_date()
    {
        /*if(has_period==1)
        {
            return;
        }
        ST.Util.confirmBox("提示","暂无可报价的排期，是否前往添加排期？",function(){
            window.location.href=SITEURL+"outdoor/date/index?id="+outdoorid;
        })*/
    }
    //日历初始化
    function calendar_init(mockData) {
        $.CalendarPrice({
            // 显示日历的容器
            el: '.container',
            // 设置开始日期
            // 可选参数，默认为系统当前日期
            startDate: mockData.starttime,
            // 可选参数，默认为开始日期相同的1年后的日期
            // 设置日历显示结束日期
            //  endDate: '2018-09',
            // 初始数据
            data: mockData.list,
            //点击单个日期,修改报价
            everyday: function (data) {
                edit_price(data);
            },
            // 配置需要设置的字段名称，请与你传入的数据对象对应
            config: [
                {
                    key: 'price',
                    name: '价格'
                },
                {
                    key:'number',
                    name:'库存'
                }
            ],
            // 配置在日历中要显示的字段
            show: [
                {
                    key: 'price',
                    name: '价格'
                },
                {
                    key:'number',
                    name:'库存'
                }
            ],
            // 自定义风格(颜色)
            style:
            {
            }
        });
    }
    //日期处理回调
    function calendarCallback(date) {
        return ajax_get_suit_price(date.getFullYear(),date.getMonth()+1,false)
    }
    //修改报价
    function edit_price(data)
    {
        var suitid = $("#id").val();
        CHOOSE.setSome("修改报价("+data.date+')',{maxHeight:500,width:540,loadWindow:window,loadCallback:calendar_edit},SITEURL+'index/dialog_edit_suit_price?suitid='+suitid+'&date='+data.date,1);
    }
    //修改报价，更新日历
    function calendar_edit(data,bool)
    {
        if(!bool)
        {
            return false;
        }
        else
        {
            $.ajax({
                data:data.data,
                dataType:'json',
                type:'post',
                url:SITEURL+'index/ajax_save_day_price',
                success:function (data) {
                    ST.Util.showMsg('保存成功',4,1000);
                    set_calendat_day_params(data)
                }
            })
        }
    }
    //修改日历某天的显示数据
    function set_calendat_day_params(data) {
        if(data['price']>0)
        {
            var html = '<p class="item"><span class="attr">价格</span><span class="num">' + data.price + '</span></p>';
            var num= data.number=='-1'?'充足':data.number;
            html+='<p class="item"><span class="attr">库存</span><span class="num">'+num+'</span></p>';
            $('.calendar-table-wrapper td[data-id=' + data.date + '] .data-hook').html(html)
        }
        else
        {
            $('.calendar-table-wrapper td[data-id='+data.date+'] .data-hook').html('')
        }
    }
    function onRenderFinish()
    {
        //console.log(g_allowed_days);
        $(".calendar-table-wrapper tr td.valid-hook").each(function(){
            var date=$(this).attr('data-id');
            if($.inArray(date,g_allowed_days)==-1)
            {
                //$(this).find('.data-hook').remove();
               // $(this).removeClass('valid-hook').addClass('disabled');
            }
        });
    }
    function clearPrice()
    {
        var suitid = $("#id").val();
        if(!suitid|| suitid=='')
        {
            return;
        }
        ST.Util.confirmBox("提示","确认清除报价？",function(){
            $.ajax({
                data:{suitid:suitid},
                dataType:'json',
                type:'post',
                url:SITEURL+'index/ajax_clear_suit_price',
                success:function (data) {
                    ST.Util.showMsg('清除报价成功',4,1000);
                    ajax_get_suit_price(last_year, last_month, 1);
                }
            })
        });
    }
    function get_ticket_types(is_init)
    {
        var spotid = $("input[name=spotid]").val();
        $("#field_newtickettype").val('');
        $("#field_newtickettype").hide();
        $.ajax({
            type: 'POST',
            url: SITEURL + "index/ajax_get_ticket_types",
            data: {spotid:spotid},
            dataType: "json",
            success: function (data, opts) {
                if(data)
                {
                    var html='<option>请选择</option>';
                    for(var i in data)
                    {
                        var row=data[i];
                        var select_str = is_init==1 && row['id']==tickettypeid?' selected="selected" ':'';
                        html+='<option value="'+row['id']+'" '+select_str+'>'+row['kindname']+'</option>';
                    }
                    $("#field_tickettypeid").html(html);
                }
                else
                {
                    $("#field_tickettypeid").html('');
                }
            }
        });
    }
</script>
</body>
</html>
