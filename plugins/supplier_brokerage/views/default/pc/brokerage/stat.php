<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>提现详情-{$webname}</title>
    {Model_Supplier::css("style.css,base.css,extend.css,tongji.css,base_new.css",'brokerage')}
    {Common::js("jquery.min.js")}
    {Common::js("layer/layer.js")}
</head>
<body>
<div class="page-box">
    {request 'pc/pub/header'}
    {template 'pc/brokerage/sidemenu'}
    <div class="main">
        <div class="content-box">

                <div class="finance-content">
                    <div class="finance-tit"><strong class="bt">结算统计</strong></div>
                    <div class="finance-bloock">
                        <div class="container-page">
                            <div class="clearfix pd-20">
                                <div class="stat-container-box w820 fl">
                                    <div class="stat-tit-bar">商家余额</div>
                                    <div class="stat-container-con clearfix">
                                        <div class="item fl">
                                            <i class="all-icon"></i>
                                            <span class="info">
                                                <span class="pri">{Currency_Tool::symbol()}{$price_arr['allow_price']}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <div class="stat-container-box w400 mt-20 fl">
                                        <div class="stat-tit-bar">结算总金额：{Currency_Tool::symbol()}{$price_arr['total_brokerage_price']}</div>
                                        <div class="stat-container-con clearfix">
                                            <div class="stat-canvas-box" id="incomeWrap"></div>
                                            <div class="stat-data-tool">
                                                <span class="bar c-666"><i class="icon blue"></i>待结算金额：<span class="b-pri">{Currency_Tool::symbol()}{$price_arr['wait_brokerage_price']}</span></span>
                                                <span class="bar c-666"><i class="icon grey"></i>已结算金额：<span class="c-999">{Currency_Tool::symbol()}{$price_arr['brokerage_price']}</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stat-container-box w400 mt-20 ml-20 fl">
                                        <div class="stat-tit-bar">可提现金额：{Currency_Tool::symbol()}{$price_arr['allow_price']}</div>
                                        <div class="stat-container-con clearfix">
                                            <div class="stat-canvas-box" id="payWrap"></div>
                                            <div class="stat-data-tool">
                                                <span class="bar c-666"><i class="icon green"></i>提现中金额：<span class="g-pri">{Currency_Tool::symbol()}{$price_arr['withdraw_price_approval']}</span></span>
                                                <span class="bar c-666"><i class="icon grey"></i>已提现金额：<span class="c-999">{Currency_Tool::symbol()}{$price_arr['withdraw_price_finish']}</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="st-record">{Common::get_sys_para('cfg_supplier_footer')}</div>

        </div>
</div>
    <!-- 主体内容 -->
<script src="http://echarts.baidu.com/build/dist/echarts-all.js"></script>
<script>
    var allow_price = '{$price_arr['allow_price']}';//可提现金额
    var total_brokerage_price = '{$price_arr['total_brokerage_price']}';//结算总金额
    var wait_brokerage_price = '{$price_arr['wait_brokerage_price']}';//待结算金额
    var brokerage_price = '{$price_arr['brokerage_price']}';//已经结算金额
    var withdraw_price_approval = '{$price_arr['withdraw_price_approval']}';//提现中金额
    var withdraw_price_finish = '{$price_arr['withdraw_price_finish']}';//已提现金额
    $(function () {
        $('.hd-menu a').removeClass('cur');
        $('.hd-menu #brokerage').addClass('cur');
        $('#brokerage_stat').addClass('on');
    });
</script>

<script>

    var i = 0;
    var colors = ['#b8b8b8','#3c9adc'];
    var myChart = echarts.init(document.getElementById('incomeWrap'));
    var CURRENCY_SYMBOL="{Currency_Tool::symbol()}";

    option = {
        tooltip : {
            trigger: 'item',
            formatter: "{b} : "+CURRENCY_SYMBOL+"{c}"
        },
        calculable : false,
        series : [
            {
                type:'pie',
                clockWise: false,
                radius : ['45%', '70%'],
                itemStyle : {
                    normal : {
                        label : {
                            show : false
                        },
                        labelLine : {
                            show : false
                        },
                        color:function(){
                            return colors[i++];
                        }
                    }
                },
                data:[
                    {value:brokerage_price, name:'已结算金额'},
                    {value:wait_brokerage_price, name:'待结算金额'}
                ]
            }
        ]
    };

    myChart.setOption(option);

</script>

<script>

    var i = 0;
    var colors = ['#b8b8b8','#92c789'];
    var myChart = echarts.init(document.getElementById('payWrap'));

    option = {
        tooltip : {
            trigger: 'item',
            formatter: "{b} : "+CURRENCY_SYMBOL+"{c}"
        },
        calculable : false,
        series : [
            {
                type:'pie',
                clockWise: false,
                radius : ['45%', '70%'],
                itemStyle : {
                    normal : {
                        label : {
                            show : false
                        },
                        labelLine : {
                            show : false
                        },
                        color:function(){
                            return colors[i++];
                        }
                    }
                },
                data:[
                    {value:withdraw_price_finish, name:'已提现金额'},
                    {value:withdraw_price_approval, name:'提现中金额'}
                ]
            }
        ]
    };

    myChart.setOption(option);

</script>


</body>
</html>
