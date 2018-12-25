<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head font_float=46ByYj >
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
                <div class="cfg-header-bar">
                    {template 'admin/line/kind_top'}
                    {template 'admin/line/attrid/header_tab'}
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="addRow()">添加</a>
                </div>
                <form id="day_fm">
                    <table class="table table-bg table-hover" id="day_tab">
                        <thead>
                        <tr>
                            <th class="text-l" scope="col" width="90%"><span class="ml-20">天数{Common::get_help_icon('attr_day')}</span></th>
                            <th class="text-c" scope="col" width="10%">管理</th>
                        </tr>
                        </thead>
                        <tbody>
                        {loop $list $k $v}
                        <tr>
                            <td class="dayname-td text-l">
                                <input type="text" id="" name="dayword[{$v['id']}]" class="input-text w100 ml-20" value="{$v['word']}">
                            </td>
                            <td class="text-c">
                                <a href="javascript:;" class="btn-link" onclick="delRow(this,{$v['id']})" title="删除">删除</a>
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
   $(".cfg-header-bar").find('#tb_lineday').addClass('on');


  function rowSave()
  {
      ST.Util.showMsg('保存中',6,10000);
      $.ajaxform({
          url   :  SITEURL+"line/admin/line/day/action/save",
          method  :  "POST",
          form  : "#day_fm",
          dataType  :  "html",
          success  :  function(result)
          {

              var text = result;
              if(text=='ok')
              {
                  ZENG.msgbox._hide();
                  ST.Util.showMsg("保存成功",4)
              }
              else
              {
                  ST.Util.showMsg("{__('norightmsg')}",5,1000)
              }
          }});

  }
  function addRow()
  {
	    $.ajaxform({
                  url   :  SITEURL+"line/admin/line/day/action/add",
                  method  :  "POST",
                  dataType  :  "html",
                  success  :  function(result)
                  {
                      var id = result;
                      if(id!='no')
                      {
						 var  $html='<tr><td class="dayname-td"><input type="text" class="input-text w100 ml-20" name="dayword['+id+']"  value=""></td>';
						  $html+='<td class="text-c"><a href="javascript:;" class="btn-link" onclick="delRow(this,'+id+')" title="删除">删除</a></td></tr>';
						  $("#day_tab").append($html);
					  }
				  }})

  }
  function delRow(dom,id)
  {
      ST.Util.confirmBox('提示','确定删除？',function(){
          if(id==0)
              $(dom).parents('tr').first().remove();
          else
          {
              $.ajaxform({
                  url   :  SITEURL+"line/admin/line/day/action/del",
                  method  :  "POST",
                  data:{id:id},
                  dataType  :  "html",
                  success  :  function(result)
                  {
                      var text = result;
                      if(text='ok')
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
