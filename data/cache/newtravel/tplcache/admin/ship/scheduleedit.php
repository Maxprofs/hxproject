<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>邮轮添加/修改</title>
<?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
<?php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); ?>
<?php echo Common::css_plugin('jquery.datetimepicker.css','ship');?>
<?php echo Common::js_plugin('jquery.datetimepicker.full.js','ship');?>
</head>
<body>
<table class="content-tab" padding_bottom=ZlNzDt >
    <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
    <!--右侧内容区-->
    </td>
     <td valign="top" class="content-rt-td">
        <form method="post" name="product_frm" id="product_frm">
           <div class="manage-nr">
               <div class="cfg-header-bar">
                <a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>
               </div>
               <!--基础信息开始-->
                <div class="product-add-div">
                <ul class="info-item-block">
                <li>
                <span class="item-hd">行程时间：</span>
                <div class="item-bd">
                <input type="text" name="title" id="title" class="input-text w200"  value="<?php echo $info['title'];?>" />
                </div>
                </li>
                <li>
                <span class="item-hd">航次时间：</span>
                <div class="item-bd">
                <a class="btn btn-primary radius size-S mt-3" href="javascript:;" id="addtime_btn">增加时间</a>
                                <table id="time_list" class="w500">
                                     <?php $n=1; if(is_array($timelist)) { foreach($timelist as $time) { ?>
                                     <tr id="item_<?php echo $time['id'];?>" class="lh-50">
                                         <td width="40%"><input type="text" name="starttime[<?php echo $time['id'];?>]"  class="start_time input-text" value="<?php echo date('Y-m-d',$time['starttime']);?>" /></td>
                                         <td width="10%" class="text-c">--</td>
                                         <td width="40%"><input type="text" name="endtime[<?php echo $time['id'];?>]"  class="end_time input-text"  value="<?php echo date('Y-m-d',$time['endtime']);?>" /></td>
                                         <td width="10%" class="text-c"><a href="javascript:;" class="btn-link" onclick="delTime(<?php echo $time['id'];?>)">删除</a> </td>
                                     </tr>
                                     <?php $n++;}unset($n); } ?>
                                 </table>
                </div>
                </li>
                </ul>
                      
                  </div>

<div class="fl clearfix pb-20">
                <input type="hidden" name="shipid" id="shipid" value="<?php echo $shipid;?>"/>
                      <input type="hidden" name="id" id="productid"  value="<?php echo $info['id'];?>"/>
                      <input type="hidden" name="action" id="action" value="<?php echo $action;?>"/>
                    <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
              </div>
          </div>
        </form>
    </td>
    </tr>
    </table>
<script>
$(document).ready(function() {
        $.datetimepicker.setLocale('ch');
        addDatepicker();
        $("#addtime_btn").click(function(){
             var html='<tr class="time-new-list lh-50">'+
                 '<td width="40%"><input type="text" name="newstarttime[]"  class="start_time input-text"   value=""/></td>'+
                 '<td width="10%" class="text-c">--</td>'+
                 '<td width="40%"><input type="text" name="newendtime[]"  class="end_time input-text"  value=""/></td>'+
                 '<td width="10%" class="text-c"><a href="javascript:;" onclick="$(this).parent().parent().remove();" class="btn-link">删除</a> </td>'+
                 '</tr>';
             $("#time_list").append(html);
            addDatepicker();
        });
        //保存
        $("#btn_save").click(function () {
            var title = $("#title").val();
            //验证名称
            if (title == '') {
                $("#title").focus();
                ST.Util.showMsg('请填写航次名称', 5, 2000);
            }
            else {
                $.ajaxform({
                    url: SITEURL + "ship/admin/ship/ajax_schedule_save",
                    method: "POST",
                    form: "#product_frm",
                    dataType: "JSON",
                    success: function (data) {
                        if (data.status) {
                            if (data.productid != null) {
                                $("#productid").val(data.productid);
                            }
                            updateTime(data.newlist);
                            ST.Util.showMsg('保存成功!', '4', 2000);
                        }
                    }
                });
            }
        })
    });
   function updateTime(list)
   {
       $(".time-new-list").remove();
       var html='';
       for(var i in list)
       {
           var row= list[i];
           html+='<tr class="lh-50" id="item_'+row['id']+'">'+
           '<td width="40%"><input type="text" name="starttime['+row['id']+']"  class="start_time input-text"  value="'+row['begintime']+'" /></td>'+
           '<td width="10%" class="text-c">--</td>'+
           '<td width="40%"><input type="text" name="endtime['+row['id']+']"  class="end_time input-text"  value="'+row['endtime']+'" /></td>'+
           '<td width="10%" class="text-c"><a href="javascript:;" class="btn-link" onclick="delTime('+row['id']+')">删除</a> </td>'+
           '</tr>';
       }
       $("#time_list").append(html);
       addDatepicker();
   }
   function delTime(id)
   {
       $.ajax({
           type: 'POST',
           url: SITEURL+ "ship/admin/ship/ajax_schedule_timedel",
           data: {id:id} ,
           dataType: 'json',
           success: function(result)
           {
               if(result.status)
                  $("#item_"+id).remove();
           }
       });
   }
   function addDatepicker()
   {
       jQuery('.start_time').datetimepicker({
           format:'Y-m-d',
           onShow:function( ct, ele ){
               var maxDate = $(ele).parents('tr:first').find('.end_time').val();
               this.setOptions({
                   maxDate:maxDate?maxDate:false
               })
           },
           timepicker:false
       });
       jQuery('.end_time').datetimepicker({
           format:'Y-m-d',
           onShow:function( ct ,ele){
               var minDate = $(ele).parents('tr:first').find('.start_time').val();
               this.setOptions({
                   minDate:minDate?minDate:false
               })
           },
           timepicker:false
       });
   }
</script>
</body>
</html>
