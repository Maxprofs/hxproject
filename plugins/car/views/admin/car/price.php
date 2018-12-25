<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title size_color=0wpE7l >笛卡CMS{$coreVersion}</title>
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
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="addRow()">添加</a>
                </div>
                <form id="day_fm">
                    <table class="table table-bg table-hover" id="day_tab">
                        <thead>
                            <tr>
                                <th width="90%"><span class="ml-20">价格范围</span></th>
                                <th width="10%" class="text-c">删除</th>
                            </tr>
                        </thead>
                        <tbody>
                            {loop $list $k $v}
                            <tr>
                                <td class="dayname-td">
                                    <input type="text" name="min[{$v['id']}]" class="input-text w200 ml-20" value="{$v['min']}">
                                    &nbsp;<span>~</span>&nbsp;
                                    <input type="text" class="input-text w200" name="max[{$v['id']}]" value="{$v['max']}"/>
                                </td>
                                <td class="text-c">
                                    <a href="javascript:;" class="btn-link" onclick="delRow(this,<?php echo $v['id'];  ?>)" title="删除">删除</a>
                                </td>
                            </tr>
                            {/loop}
                        </tbody>
                    </table>
                </form>
                <div class="clear clearfix pd-20">
                    <a class="btn btn-primary radius size-L" href="javascript:;" onclick="rowSave()">保存</a>
                </div>
            </td>
        </tr>
    </table>

<script>
   //$(".w-set-tit").find('#tb_carprice').addClass('on');




  function rowSave()
  {

      $.ajaxform({
          url   :  SITEURL+"car/admin/car/price/action/save",
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
                  ST.Util.showMsg("{__('norightmsg')}",5,1000);
              }


          }});

  }
  function addRow()
  {
      $.ajaxform({
                  url   :  SITEURL+"car/admin/car/price/action/add",
                  method  :  "POST",
                  dataType  :  "html",
                  success  :  function(result)
                  {
                      var id = result;
                      if(id!='no')
                      {
						  var $html='<tr><td class="dayname-td"><input type="text" name="min['+id+']"  class="input-text w200 ml-20" value="">&nbsp;<span>~</span>&nbsp;<input type="text" name="max['+id+']" value=""  class="input-text w200"/></td>';
						  $html+='<td class="text-c"><a href="javascript:;" class="btn-link" onclick="delRow(this,'+id+')" title="删除">删除</a></td></tr>';
						  $("#day_tab").append($html);
					  }
                      else
                      {
                          ST.Util.showMsg("{__('norightmsg')}",5,1000);
                      }
				  }})

  }
  function delRow(dom,id)
  {
      ST.Util.confirmBox('提示','确定删除吗?',function(){
          if(id==0)
              $(dom).parents('tr').first().remove();
          else
          {
              $.ajaxform({
                  url   :  SITEURL+"car/admin/car/price/action/del",
                  method  :  "POST",
                  data:{id:id},
                  dataType:'html',
                  success  :  function(result)
                  {
                      var text = result;
                      if(text=='ok')
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
