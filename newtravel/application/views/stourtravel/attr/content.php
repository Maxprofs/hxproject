<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,jqtransform.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,st_validate.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }

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
                 <a href="javascript:;" class="additem fr btn btn-primary radius mt-6 mr-10">添加</a>
             </div>

            <div class="clearfix">
                <form id="day_fm">
                    <table width="90%" border="0" cellspacing="0" cellpadding="0" id="day_tab" class="table table-bg table-hover">
                        <thead>
                           <tr class="text-c">
                               <th scope="col" width="15%" align="center">排序</th>
                               <th scope="col" width="30%" align="center">分类名称</th>
                               <th scope="col" width="20%" align="center">字段名</th>
                               <th scope="col" width="15%">显示</th>
                               <th scope="col" width="15%">删除</th>
                           </tr>
                        </thead>
                        <tbody>
                            {loop $list $k $v}
                            <tr id="item_{$v['id']}">
                                <td align="center" class="text-c"><input type="text" name="displayorder[{$v['id']}]" class="input-text text-c w60" value="{$v['displayorder']}" size="6"/></td>
                                <td align="center"><input type="text" name="chinesename[{$v['id']}]" class="input-text" value="{$v['chinesename']}" size="20"/></td>
                                <td align="center" class="text-c">{$v['columnname']}</td>
                                <td align="center" class="text-c"><input type="checkbox" name="isopen[{$v['id']}]" value="1" {if $v['isopen']==1}checked="checked"{/if}/></td>
                                <td align="center" class="text-c">{if strpos($v['columnname'],'e_')===0}<a href="javascript:;" class="btn-link" onclick="rowDel(this,{$v['id']})">删除</a>{/if}</td>
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

   //添加按钮
   $(".additem").click(function(){

       $.ajax({
           type: 'POST',
           url: SITEURL+"attrid/ajax_addfield/typeid/{$typeid}",
           dataType:'json',
           success: function(data)
           {
               var row=data.data;
               if(data.status)
               {
                   var isChecked=row['isopen']==1?'checked="checked"':'';
                   var html='<tr id="item_'+row['id']+'"><td align="center" class="text-c"><input type="text" name="displayorder['+row['id']+']" class="text_60 center" value="'+row['displayorder']+'" size="6"/></td>'
                   +'<td align="center"><input type="text" name="chinesename['+row['id']+']" class="input-text" value="'+row['chinesename']+'" size="20"/></td>'
                   +'<td align="center" class="text-c">'+row['columnname']+'</td>'
                   +'<td align="center" class="text-c"><input type="checkbox" name="isopen['+row['id']+']" value="1" '+isChecked+' /></td>'
                   + '<td align="center" class="text-c"><a href="javascript:;" class="btn-link" onclick="rowDel(this,'+row['id']+')">删除</a></td>'
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
          url   :  SITEURL+"attrid/content/action/save/typeid/{$typeid}",
          method  :  "POST",
          form  : "#day_fm",
          dataType  :  "html",
          success  :  function(text)
          {

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
  function backDel(result,bool)
  {

      $.ajax({
          type: 'POST',
          url: SITEURL+"attrid/ajax_delfield",
          dataType:'json',
          data:{typeid:typeid,id:result.id},
          success: function(data)
          {
              $("#item_"+result.id).remove();
          }
      })
  }
  function rowDel(dom,id)
  {
      ST.Util.showBox('删除字段',SITEURL+'attrid/dialog_delfield?id='+id+"&typeid="+typeid,150,'',null,null,document,{loadWindow:window,loadCallback:backDel,maxHeight:600});
     /* ST.Util.confirmBox('确定删除?','',function(){
          if(id==0)
              $(dom).parents('tr').first().remove();
          else
          {
              Ext.Ajax.request({
                  url   :  SITEURL+"line/content/ajax_delfield",
                  method  :  "POST",
                  params:{id:id,typeid:typeid},
                  datatype  :  "JSON",
                  success  :  function(response, opts)
                  {
                      var text = response.responseText;
                      if(text='ok')
                      {
                          $(dom).parents('tr').first().remove();
                      }
                      else
                      {

                      }
                  }});

          }


      });*/

  }


</script>

</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201802.1301&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
