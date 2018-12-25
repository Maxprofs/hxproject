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
    <td valign="top" class="content-rt-td" style="overflow:auto;">
            <div class="w-set-con">
                <div class="cfg-header-bar">
                    {template 'admin/hotel/kind_top'}
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="_add()">添加</a>
                </div>
                <div class="w-set-nr">
                     <form id="price_fm">
                        <table class="table table-bg table-hover" width="100%" border="0" cellspacing="0" cellpadding="0" id="price_tab">
                        	<thead>
                        		<tr>
		                            <th scope="col" width="50%"><span class="pl-10">价格范围</span></th>
		                            <th class="text-r" scope="col" width="50%"><span class="pr-20">删除</span></th>
	                           	</tr>
                        	</thead>
                           
                           {loop $list $k $v}
                               <tr>
                                <td>
                                    <input type="text" name="min[]" class="input-text w200 ml-10" value="{$v['min']}"><font class="mr-5 ml-5">~</font><input type="text" name="max[]" class="input-text w200" value="{$v['max']}"/>
                                    <input type="hidden" name="id[]" value="{$v['id']}">
                                </td>
                                <td class="text-r"><a href="javascript:;" class="btn-link pr-20" onclick="del(this,<?php echo $v['id'];  ?>)" title="删除">删除</a></td>
                               </tr>
                           {/loop}
                        </table>
                     </form>
                    <div class="clear pb-20">
                        <a class="btn btn-primary radius size-L mt-20 ml-20" href="javascript:;" onclick="save()">保存</a>
                    </div>
                </div>
            </div>

    </td>
</tr>
</table>

<script>
  var delpic ="{php echo Common::getIco('del');}";
  $(function(){
      //选中价格分类
      $(".w-set-tit").find('span').eq(2).addClass('on');
  })
  function save()
  {
      ST.Util.showMsg('保存中',6,10000);
      $.ajaxform({
          url   :  SITEURL+"hotel/admin/hotel/ajax_price/action/save",
          method  :  "POST",
          form  : "#price_fm",
          dataType:'json',
          success  :  function(data)
          {
              if(data.status)
              {
                  ZENG.msgbox._hide();
                  ST.Util.showMsg("保存成功",4)
              }
          }});

  }
  function _add()
  {
      var min = Number($("#price_tab tr:last").find('input').eq(1).val())+1;
      $html = '<tr>';
      $html += '<td>'
      $html += '<input type="text" class="input-text w200 ml-10" name="newmin[]" value="'+min+'"><font class="mr-5 ml-5">~</font><input type="text" class="input-text w200" name="newmax[]" value=""/><input type="hidden" name="newid[]" value="0"></td>';
      $html += '<td class="text-r">';
      $html += '<a href="javascript:;" class="btn-link pr-20" title="删除"  onclick="del(this,0)">删除</a></td></tr>';
      $("#price_tab tr:last").after($html);


  }
  function del(dom,id)
  {
      ST.Util.confirmBox('提示','确认删除这个价格范围吗?',function(){
          if(id==0)
              $(dom).parents('tr').first().remove();
          else
          {
              $.ajaxform({
                  url   :  SITEURL+"hotel/admin/hotel/ajax_price/action/del",
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

                      }
                  }});

          }


      });

  }


</script>

</body>
</html>
