<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title background_size=0UI3_k >笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
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
            <td valign="top" class="content-rt-td" style="overflow:auto;">
                <div class="cfg-header-bar">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="addRow()">添加</a>
                </div>
                <form id="day_fm">
                    <table class="table table-bg table-hover" id="day_tab">
                        <thead>
                            <tr class="text-c">
                                <th width="10%">排序</th>
                                <th width="20%">车型</th>
                                <th width="60%">优化标题</th>
                                <th width="10%">删除</th>
                            </tr>
                        </thead>
                        <tbody>
                            {loop $list $k $v}
                            <tr class="text-c">
                                <td><input class="input-text w80" name="displayorder[{$v['id']}]" value="{$v['displayorder']}" size="6"/></td>
                                <td><input class="input-text" name="kindname[{$v['id']}]" value="{$v['kindname']}" size="20"/> </td>
                                <td><input class="input-text" name="title[{$v['id']}]" value="{$v['title']}" size="30" /></td>
                                <td><a href="javascript:;" class="btn-link" onclick="delRow(this,'{$v['id']}')" title="删除">删除</a></td>
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
   //$(".w-set-tit").find('#tb_cartype').addClass('on');




  function rowSave()
  {

      $.ajaxform({
          url   :  SITEURL+"car/admin/car/kind/action/save",
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
                  url   :  SITEURL+"car/admin/car/kind/action/add",
                  method  :  "POST",
                  dataType  :  "html",
                  success  :  function(result)
                  {
                      var id = result;
                      if(id!='no')
                      {
					  var html='<tr class="text-c"><td><input class="input-text w80" name="displayorder['+id+']" size="6"></td>';
					  html+='<td><input class="input-text" name="kindname['+id+']"  size="20"> </td>';
					  html+='<td><input class="input-text" name="title['+id+']" size="30"></td>';
					  html+='<td><a href="javascript:;" class="btn-link" onclick="delRow(this,'+id+')" title="删除">删除</a></td></tr>';
					  $("#day_tab").append(html);
					  }
					 }})

  }
  function delRow(dom,id)
  {
      ST.Util.confirmBox('提示','确定删除?',function(){
          if(id==0)
              $(dom).parents('tr').first().remove();
          else
          {
              $.ajaxform({
                  url:  SITEURL+"car/admin/car/kind/action/del",
                  method: "POST",
                  data:{id:id},
                  dataType  :  "html",
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
