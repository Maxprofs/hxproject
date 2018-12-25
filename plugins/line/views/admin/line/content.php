<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); }
</head>
<body>

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow-x:hidden;">
                <div class="cfg-header-bar">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" id="additem">添加</a>
                </div>
                <div class="clearfix">
                    <form id="day_fm">
                        <table class="table table-bg table-hover" id="day_tab">
                            <thead>
                            <tr class="text-c">
                                <th scope="col" width="10%" align="center">排序</th>
                                <th scope="col" width="50%" align="left" class="text-l">分类名称{Common::get_help_icon('category_title')}</th>
                                <th scope="col" width="20%" align="center">字段名</th>
                                <th scope="col" width="10%">显示</th>
                                <th scope="col" width="10%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            {loop $list $k $v}
                            <tr id="item_{$v['id']}">
                                <td class="text-c">
                                    <input type="text" name="displayorder[{$v['id']}]" class="input-text text-c w60" value="{$v['displayorder']}" size="6"/>
                                </td>
                                <td>
                                    <input type="text" name="chinesename[{$v['id']}]" class="input-text w200" value="{$v['chinesename']}" size="20"/>
                                </td>
                                <td class="text-c">{$v['columnname']}</td>
                                <td class="text-c">
                                    <input type="checkbox" name="isopen[{$v['id']}]" value="1" {if $v['isopen']==1}checked="checked"{/if}/>
                                </td>
                                <td class="text-c">
                                    {if strpos($v['columnname'],'e_')===0}<a href="javascript:;" class="btn-link" onclick="rowDel(this,{$v['id']})">删除</a>{else}{if $v['columnname']=='payment'}<a href="javascript:;" data-url="{$v['link_url']}" data-title="{$v['link_title']}" class="btn-link tab_link">全局设置</a>{/if}{/if}

                                </td>
                            </tr>
                            {/loop}
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="clear clearfix pd-20">
                    <a class="btn btn-primary radius size-L ml-20" href="javascript:;" onclick="rowSave()">保存</a>
                </div>
            </td>
        </tr>
    </table>

<script>


  var typeid="{$typeid}";
  //链接跳转
  $('.tab_link').click(function(){
      var url = $(this).attr('data-url');
      var data_title=$(this).attr('data-title');
      ST.Util.addTab(data_title, url);
  });
   //添加按钮
   $("#additem").click(function(){

       $.ajax({
           type: 'POST',
           url: SITEURL+"line/admin/line/ajax_content_add",
           dataType:'json',
           success: function(data)
           {
               var row=data.data;
               if(data.status)
               {
                   var isChecked=row['isopen']==1?'checked="checked"':'';
                   var html='<tr id="item_'+row['id']+'"><td class="text-c"><input type="text" name="displayorder['+row['id']+']" class="input-text text-c w60" value="'+row['displayorder']+'" size="6"/></td>'
                   +'<td class="text-c"><input type="text" name="chinesename['+row['id']+']" class="input-text" value="'+row['chinesename']+'" size="20"/></td>'
                   +'<td class="text-c">'+row['columnname']+'</td>'
                   +'<td class="text-c"><input type="checkbox" name="isopen['+row['id']+']" value="1" '+isChecked+' /></td>'
                   + '<td class="text-c"><a href="javascript:;" class="btn-link" onclick="rowDel(this,'+row['id']+')">删除</a></td>'
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
          url   :  SITEURL+"line/admin/line/content/action/save",
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
      var url =  SITEURL+"line/admin/line/ajax_content_del";
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
