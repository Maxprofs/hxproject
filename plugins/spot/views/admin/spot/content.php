<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
</head>
<body>

    <table class="content-tab" body_html=pLACXC >
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow-x:hidden;">
                <div class="cfg-header-bar">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10 additem">添加</a>
                </div>
                <form id="day_fm">
                    <table class="table table-bg table-hover" id="day_tab">
                        <thead>
                            <tr class="text-c">
                                <th width="10%">排序</th>
                                <th width="50%">分类名称</th>
                                <th width="20%">字段名</th>
                                <th width="10%">显示</th>
                                <th width="10%">删除</th>
                            </tr>
                        </thead>
                        <tbody>
                            {loop $list $k $v}
                            <tr id="item_{$v['id']}" class="text-c">
                                <td>
                                    <input type="text" name="displayorder[{$v['id']}]" class="input-text w80" value="{$v['displayorder']}" size="6"/>
                                </td>
                                <td>
                                    <input type="text" name="chinesename[{$v['id']}]" class="input-text" value="{$v['chinesename']}" size="20"/>
                                </td>
                                <td>
                                    {$v['columnname']}
                                </td>
                                <td>
                                    <input type="checkbox" name="isopen[{$v['id']}]" value="1" {if $v['isopen']==1}checked="checked"{/if}/>
                                </td>
                                <td>
                                    {if strpos($v['columnname'],'e_')===0}<a href="javascript:;" class="btn-link" onclick="rowDel(this,{$v['id']})">删除</a>{/if}
                                </td>
                            </tr>
                            {/loop}
                        </tbody>
                    </table>
                </form>
                <div class="clear clearfix pd-20">
                    <a class="btn btn-primary radius size-L ml-10" href="javascript:;" onclick="rowSave()">保存</a>
                </div>
            </td>
        </tr>
    </table>

<script>


  var typeid="{$typeid}";

   //添加按钮
   $(".additem").click(function(){

       $.ajax({
           type: 'POST',
           url: SITEURL+"spot/admin/spot/ajax_content_add",
           dataType:'json',
           success: function(data)
           {
               var row=data.data;
               if(data.status)
               {
                   var isChecked=row['isopen']==1?'checked="checked"':'';
                   var html='<tr id="item_'+row['id']+'" class="text-c"><td><input type="text" name="displayorder['+row['id']+']" class="input-text w80" value="'+row['displayorder']+'" size="6"/></td>'
                   +'<td><input type="text" name="chinesename['+row['id']+']" class="input-text" value="'+row['chinesename']+'" size="20"/></td>'
                   +'<td>'+row['columnname']+'</td>'
                   +'<td><input type="checkbox" name="isopen['+row['id']+']" value="1" '+isChecked+' /></td>'
                   + '<td><a href="javascript:;" class="btn-link" onclick="rowDel(this,'+row['id']+')">删除</a></td>'
                   + '</tr>';
                   $("#day_tab").append(html);
               }
               else
               {
                   ST.Util.showMsg(data.msg,5);
               }
           }
       });

   });

  function rowSave()
  {
      ST.Util.showMsg('保存中',6,10000);
      $.ajaxform({
          url   :  SITEURL+"spot/admin/spot/content/action/save",
          method  :  "POST",
          form  : "#day_fm",
          dataType  :  "html",
          success  :  function(result)
          {
              var text = result;
              if(text=='ok')
              {
                  ZENG.msgbox._hide();
                  ST.Util.showMsg("保存成功",4,1000)
              }
              else
              {
                  ST.Util.showMsg("{__('norightmsg')}",5,1000)
              }
          }});
  }

  function rowDel(dom,id)
  {
      var url =  SITEURL+"spot/admin/spot/ajax_content_del";
      ST.Util.confirmBox("提示","确定删除这该项？",function(){
          $.ajax({
              type: 'POST',
              dataType: 'json',
              url: url ,
              data: {id:id} ,
              success: function(result){
                  if(result.status)
                     $("#item_"+id).remove();
              }
          });
      })
  }


</script>

</body>
</html>
