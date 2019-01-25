<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title> {__('短信管理')}-{$webname}</title>
    {Common::css('user.css,base.css,base_new.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,datepicker/WdatePicker.js')}
    <style>
        .s-main{
            margin-top: 20px;
        }
        .s-list{
            margin-top: 10px;
        }
    </style>
</head>

<body>

 {request "pub/header"}
  
  <div class="big">
    <div class="wm-1200">
    
        <div class="st-guide">
          <a href="{$cmsurl}">{__('首页')}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{__('短信管理')}
        </div><!--面包屑-->
      
      <div class="st-main-page">

          {include "member/left_menu"}
        
        <div class="user-order-box">
            <div class="user-home-box">
            <div class="tabnav">
                <div class="cfg-header-bar" id="nav">
                    <div class="cfg-header-tab">
                        <span class="item on" data-id="sended"><s></s>使用记录</span>
                        <span class="item" data-id="smspay"><s></s>短信充值</span>
                    </div>
                </div>
            </div><!-- 订单切换 -->
            <div class="product-add-div pd-20" data-id="sended">
    <table class="content-tab" margin_size=5MM8Zk >
        <tr>
            <td valign="top" class="content-rt-td">
                <div class="manage-nr">
                    <div class="sms-set">
                        <div class="msg-switcher">
                            <div class="info-one clearfix">
                                <div class="s-main">
                                    <div class="search-con">
                                        <input type="text" class="input-text w200" name="querydate" onclick="WdatePicker({maxDate:'%y-%M-%d'})" />
                                        <span class="item-text ml-10">至今天</span>
                                        <a href="javascript:;" data_type="uselog" class="btn btn-primary radius ml-10">查询</a>
                                    </div>
                                    <div class="s-list">
                                        <table class="table table-bordered table-border">
                                            <tr>
                                                <th width="20%" scope="col">
                                                    时间
                                                </th>
                                                <th width="60%" scope="col" align="left">
                                                    内容
                                                </th>
                                                <th width="10%" scope="col">
                                                    手机号码
                                                </th>
                                                <th width="10%" scope="col">
                                                    操作状态
                                                </th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
            </div>
            <div class="product-add-div pd-20" data-id="smspay">
                <ul class="info-item-block">
                            <li>
                                <span class="item-hd">短信价格：</span>
                                <div class="item-bd">
                                    <span class="w100" style="line-height: 2.5" id="cfg_sms_price">{$cfg_sms_price}</span>&nbsp;元/条
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">购买条数：</span>
                                <div class="item-bd">
                                    <input class="input-text w100" maxlength="4" type="text" oninput="value=value.replace(/[^\d]/g,'')" id="buy_sms" />（请填入100的整倍数进行购买）
                                </div>
                            </li>
                            <li>
                                <span class="item-hd"></span>
                                <div class="item-bd">
                                    <button class="btn btn-primary" id="buy_btn" onclick="buysms()">购 买</button>
                                </div>
                                
                            </li>
                </ul>
            </div>
          </div>
        </div><!--所有订单-->
        
      </div>
    
    </div>
  </div>
  
{request "pub/footer"}
{Common::js('layer/layer.js')}
 <script>
    var mid = {$mid};
     $(function(){
        //导航选中
         $('#nav_smsmanage').addClass('on');
         if(typeof(on_leftmenu_choosed)=='function')
         {
             on_leftmenu_choosed();
         }

        $("#nav").find('span').click(function() {
            changetab(this, '.product-add-div'); //导航切换
        })
        $("#nav").find('span').first().trigger('click');

        $("a[data_type$='log']").click(function () {

            var data_type = $(this).attr("data_type");
            var querydate = $(this).siblings("input[name='querydate']").val();
            var table_result = $(this).parent().siblings(".s-list").find("table");
            table_result.find(".item").remove();
            var url = SITEURL + 'distributor/pc/sms/ajax_query/querydate/' + querydate + "?mid=" + mid;

            if (querydate == "") {
                layer.msg("请选择查询起始日期", {
                    icon: 5,
                    time: 3000
                })
                return;
            }
            layer.msg('加载中。。。', {
                icon: 6,
                time: 60000
            })
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function (data) {
                    if (!data.Success) {
                        layer.msg(data.msg, {
                            icon: 5,
                            time: 2000
                        })
                        return;
                    }

                    if (data.Data.length <= 0) {
                        layer.msg("没有查询到记录", {
                            icon: 5,
                            time: 2000
                        })
                        return;
                    }
                    layer.closeAll();
                    var html = '';
                    for (var i in data.Data) {
                        var row = data.Data[i];
                        if (data_type == "uselog") {
                            html += '<tr class="item"> <td align="center">' + formatDate(row.sendtime) + '</td>' +
                                '<td class="msg-con">' + row.contents + '</td>' +
                                '<td align="center">' + row.mobile + '</td>' +
                                '<td align="center">' + row.smstype + '</td></tr>';
                        }
                    }
                    table_result.append(html);
                }
            });


        });
     })
    function buysms() {
        var url = SITEURL + 'distributor/pc/sms/ajax_buy_sms' + "?mid=" + mid;
        var num=$('#buy_sms').val();
        if (parseInt(num)%100!=0) {
            layer.msg('请输入100的整倍数',{icon:5,time:2000})
            return false;
        }
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            data: {num: num}
        })
        .done(function(data) {
            if (data.state) {
                layer.msg(data.msg, {
                    icon: 6,
                    time: 2000
                })
            }else{
                layer.msg(data.msg, {
                    icon: 5,
                    time: 2000
                })
            }
        })
    }
    function changetab(obj,contentclass){
        var dataid = $(obj).attr('data-id');
        $(obj).addClass('on').siblings().removeClass('on');
        $(contentclass).each(function(){
            if($(this).attr('data-id') == dataid){
                $(this).show();
            }
            else{
                $(this).hide();
            }
        })
    }
    function formatDate(timestamp) {
        var date = new Date(parseInt(timestamp)*1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = date.getDate()<10?'0'+date.getDate():date.getDate();
        if (date.getHours()<10) {
            h = '0'+date.getHours() + ':';
        }else{
            h = date.getHours() + ':';
        }
        if (date.getMinutes()<10) {
            m='0'+date.getMinutes()+':';
        }else{
            m = date.getMinutes() + ':';
        }
        if (date.getSeconds()<10) {
            s='0'+date.getSeconds();
        }else{
            s = date.getSeconds();
        }
        return Y+M+D+' '+h+m+s;
     }
 </script>

 {include "member/order/jsevent"}

</body>
</html>
