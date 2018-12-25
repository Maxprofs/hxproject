<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
    {php echo Common::css_plugin('admin/css/red-paper.css','red_envelope')}
    {php echo Common::js_plugin('admin/js/echarts.js','red_envelope')}
</head>

<body>

    <!--顶部-->
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:auto;">
                <div class="container-page">
                    <div class="cfg-header-bar">
                        <a href="javascript:;"  onclick="location.reload()"  class="fr btn btn-primary radius mt-6 mr-10">刷新</a>
                    </div>
                    <div class="clearfix pd-10">
                        <div class="charts-item-block">
                            <div class="charts-box" id="main0"></div>
                        </div>
                        <div class="charts-item-block">
                            <div class="charts-box" id="main1"></div>
                            <div class="charts-data-block">
                                <span class="item">成交转化率：{$use_rate}%</span>
                                <span class="item">领取率：{$get_rate}%</span>
                            </div>
                        </div>
                        <div class="charts-item-block">
                            <div class="charts-box" id="main2"></div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <script>

        $(function(){

            setCharts();
            $(window).resize(function(){
                setCharts();
            });


        });

        //绘制图标
        function setCharts(){

            var dataStyle = {
                normal: {
                    label: {show:false},
                    labelLine: {show:false}
                }
            };
            var placeHolderStyle = {
                normal : {
                    color: 'rgba(0,0,0,0)',
                    label: {show:false},
                    labelLine: {show:false}
                },
                emphasis : {
                    color: 'rgba(0,0,0,0)'
                }
            };

            $('.charts-box').each(function(index){

                var myChart = echarts.init(document.getElementById("main" + index));

                var option = [
                    {
                        title : {
                            text: '分享监控'
                        },
                        tooltip : {
                            trigger: 'item'
                        },
                        legend: {
                            orient : 'vertical',
                            x : 'right',
                            data:['已分享','剩余次数']
                        },
                        calculable : false,
                        series : [
                            {
                                name:'类别分析',
                                type:'pie',
                                radius : ['50%', '70%'],
                                itemStyle : {
                                    normal : {
                                        color: function (params){
                                            var colorList = ['#b2d464','#3dd0be'];
                                            return colorList[params.dataIndex];
                                        },
                                        label : {
                                            show : true
                                        },
                                        labelLine : {
                                            show : true
                                        }
                                    },
                                    emphasis : {
                                        label : {
                                            show : true,
                                            position : 'center',
                                            textStyle : {
                                                fontSize : '30',
                                                fontWeight : 'bold'
                                            }
                                        }
                                    }
                                },
                                data:[
                                    {value:'{$envelope['share_number']}', name:'已分享'},
                                    {value:'{$envelope['total_number']}', name:'剩余次数'}
                                ]
                            }
                        ]
                    },
                    {
                        title : {
                            text: '成交转化率'
                        },
                        legend: {
                            x: 'right',
                            y: '10px',
                            data : ['可领总次数','领取次数','使用次数']
                        },
                        calculable : false,
                        series : [
                            {
                                name:'',
                                type:'funnel',
                                x: '20%',
                                y: 100,
                                y2: 50,
                                width: '60%',
                                min: 0,
                                max: 40,
                                minSize: '0%',
                                maxSize: '60%',
                                sort : 'descending',
                                gap : 2,
                                itemStyle: {
                                    normal: {
                                        color: function (params){
                                            var colorList = ['#56a3f3','#3dd0be','#f8b551'];
                                            return colorList[params.dataIndex];
                                        },
                                        borderColor: '#fff',
                                        borderWidth: 1,
                                        label: {
                                            show: true,
                                            formatter: '{c}',
                                            textStyle:{
                                                fontSize:14
                                            },
                                            position: 'inside'
                                        },
                                        labelLine: {
                                            show: false,
                                            length: 10,
                                            lineStyle: {
                                                width: 1,
                                                type: 'solid'
                                            }
                                        }
                                    },
                                    emphasis: {
                                        borderWidth: 2,
                                        label: {
                                            show: true
                                        },
                                        labelLine: {
                                            show: true
                                        }
                                    }
                                },
                                data:[
                                    {value:'{$total_number}', name:'可领总次数'},
                                    {value:'{$total_get}', name:'领取次数'},
                                    {value:'{$total_use}', name:'使用次数'}
                                ]
                            }
                        ]
                    },
                    {
                        title : {
                            text: '拉新能力分析'
                        },
                        tooltip : {
                            trigger: 'item',
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },
                        legend: {
                            orient : 'vertical',
                            x : 'right',
                            data:['老用户','新用户']
                        },
                        calculable : false,
                        series : [
                            {
                                name:'类别分析',
                                type:'pie',
                                radius : ['50%', '70%'],
                                itemStyle : {
                                    normal : {
                                        color: function (params){
                                            var colorList = ['#70d3fc','#5692f4'];
                                            return colorList[params.dataIndex];
                                        },
                                        label : {
                                            show : true
                                        },
                                        labelLine : {
                                            show : true
                                        }
                                    },
                                    emphasis : {
                                        label : {
                                            show : true,
                                            position : 'center',
                                            textStyle : {
                                                fontSize : '30',
                                                fontWeight : 'bold'
                                            }
                                        }
                                    }
                                },
                                data:[
                                    {value:'{$old_get}', name:'老用户'},
                                    {value:'{$new_get}', name:'新用户'}
                                ]
                            }
                        ]
                    }
                ];

                myChart.setOption(option[index]);



            });

        }

    </script>
</body>
</html>
