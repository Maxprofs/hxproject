<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>门票价格范围分类-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
</head>
<body>

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:auto;">
                <div class="cfg-header-bar">
                    {template 'admin/spot/attrid/header_tab'}
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="addrow()">添加</a>
                </div>
                <form id="price_fm">
                    <table class="table table-bg table-hover" id="price_tab">
                        <thead>
                            <tr>
                                <th><span class="ml-20">价格范围</span></th>
                                <th class="text-c">管理</th>
                            </tr>
                        </thead>
                        <tbody>
                            {loop $list $k $v}
                            <tr>
                                <td class="dayname-td">
                                    <span class="ml-20">
                                        <input type="text" name="min[]" class="input-text w200" value="{$v['min']}">
                                        <span color="#f4a460">~</span>
                                        <input type="text" name="max[]" class="input-text w200" value="{$v['max']}"/>
                                        <input type="hidden" name="id[]" value="{$v['id']}">
                                    </span>
                                </td>
                                <td class="text-c"><a href="javascript:;" class="btn-link" onclick="delrow(this,{$v['id']})" title="删除">删除</a></td>
                            </tr>
                            {/loop}
                        </tbody>
                    </table>
                </form>
                <div class="clear clearfix pd-20">
                    <a class="btn btn-primary radius size-L ml-10" href="javascript:;" onclick="rowsave()">保存</a>
                </div>
            </td>
        </tr>
    </table>

<script>
  var delpic ="{php echo Common::getIco('del');}";
  function rowsave()
  {
      ST.Util.showMsg('保存中',6,10000);
      $.ajaxform({
          url   :  SITEURL+"spot/admin/spot/ajax_price/action/save",
          method  :  "POST",
          form  : "#price_fm",
          dataType: 'json',
          success  :  function(data)
          {
                  if(data.status)
                  {
                      ZENG.msgbox._hide();
                      ST.Util.showMsg("保存成功",4,1000)
                  }
                  else{
                      ST.Util.showMsg("{__('norightmsg')}",5,1000);
                  }
          }




          });

  }
  function addrow()
  {

      var min = Number($("#price_tab tr:last").find('input').eq(1).val())+1;
      $html = '<tr>';
      $html += '<td class="dayname-td">'
      $html += '<span class="ml-20"><input type="text" class="input-text w200" name="newmin[]" value="'+min+'">&nbsp;<span color="#f4a460">~</span>&nbsp;<input type="text" class="input-text w200" name="newmax[]" value=""/><input type="hidden" name="newid[]" value="0"></span></td>';
      $html += '<td class="text-c">'+'<a href="javascript:;" class="btn-link" onclick="delrow(this,0)" title="删除">删除</a>'+'</td></tr>';
      $("#price_tab tr:last").after($html);


  }
  function delrow(dom,id)
  {

      ST.Util.confirmBox('提示','确认删除这个价格范围吗?',function(){
          if(id==0)
              $(dom).parents('tr').first().remove();
          else
          {
              $.ajaxform({
                  url   :  SITEURL+"spot/admin/spot/ajax_price/action/del",
                  method  :  "POST",
                  data:{id:id},
                  dataType  :  "JSON",
                  success  :  function(data)
                  {

                      if(data.status)
                      {
                          $(dom).parents('tr').first().remove();
                      }
                      else
                      {
                          ST.Util.showMsg("{__('norightmsg')}",5,1000);
                      }
                  }});

          }


      });

  }


</script>

</body>
</html>
