<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head float_background=MYa1fl >
    <meta charset="utf-8">
    <title></title>
    {Common::plugin_pinyin_css('order.css','distributor')}
    {Common::plugin_pinyin_css('hdate.css','distributor')}
    {Common::plugin_pinyin_js('hdate/hdate.js,jquery.min.js','distributor')}
</head>
<style>
    body {
        width: 100%;
        height: 100%;
        font-size: 12px;
        font-family: "微软雅黑","黑体",Arial, Helvetica, sans-serif !important;
        overflow-x: hidden;
        background-color: #fff;
        margin: 0;
    }
</style>
<body>
<div class="derive_box">
    <div class="derive_con">
        <form>
            <table class="derive_tb">
                <tr>
                    <th colspan="2">选择导出时间：</th>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="sel_item">
                            <input type="radio"  name="time" value="1" checked="checked">
                            <label>今日</label>
                        </span>
                       <span  class="sel_item">
                            <input type="radio"  name="time" value="2">
                            <label>昨日</label>
                        </span>
                        <span  class="sel_item">
                            <input type="radio"  name="time" value="3">
                            <label>最近7天</label>
                       </span>
                       <span  class="sel_item">
                            <input type="radio"  name="time" value="5">
                            <label>最近30天</label>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td><span><input type="radio"  name="time" value="6" ><label>自定义时间段：</label></span></td>
                    <td>
                        <input type="text" value="" id="starttime" class="time_box" onclick="calendar.show({ id: this })" />
                       <span class="derive_arrow_rig"></span>
                       <input type="text" id="endtime" class="time_box" onclick="calendar.show({ id: this })" />
                   </td>
                </tr>
                <tr><th>其他：</th></tr>
                <tr><td><label>订单状态：</label><select id="orderstatus"><option value="">所有</option>
                           {loop $statusnames $key $status}
                               <option value="{$key}">{$status}</option>
                           {/loop}
                        </select></td></tr>
            </table>

            <div class="now_derive_box"><a class="derive_btn excel_export" href="javascript:;">立即导出</a></div>
        </form>
    </div>
</div>
</body>
<script>
    var typeid = '{$typeid}';
    $(function(){
       $(".excel_export").click(function(){
           var timetype = $("input[name='time']:checked").val();
           var status=$("#orderstatus").val();

           var starttime = endtime = 0;
           if(timetype==6){
               var starttime = $('#starttime').val();
               var endtime = $("#endtime").val();
               if(starttime==''||endtime==''){
                   ST.Util.showMsg('请选择时间段',5,1000);
                   return false;
               }
           }
           var url = '{$cmsurl}order/genexcel/typeid/'+typeid+'/timetype/'+timetype+'?starttime='+starttime+'&endtime='+endtime+'&status='+status;
           window.open(url);
       })

    })
</script>
</html>