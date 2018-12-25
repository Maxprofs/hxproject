<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,jqtransform.css,base_new.css'); }
    {php echo Common::getCss('ext-theme-neptune-all-debug.css','js/extjs/resources/ext-theme-neptune/'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,st_validate.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }

</head>
<body>

<table class="content-tab" div_table=NmACXC >
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
	                    <th scope="col" width="90%" class="text-l"><span class="ml-20">天数</span></th>
	                    <th scope="col" width="10%" class="text-c">删除</th>
                   	</tr>
            	</thead>
                <tbody>
                <?php

                   foreach($list as $k=>$v)
                   {
                ?>
                   <tr>
                    <td class="dayname-td" class="text-l"><input type="text" id="" name="title[<?php echo $v['id']; ?>]" class="input-text w100 ml-20"  value="<?php echo $v['title'];  ?>"></td>
                    <td class="text-c"><a href="javascript:;" class="btn-link" onclick="delRow(this,<?php echo $v['id'];  ?>)" title="删除">删除</a></td>
                   </tr>
                <?php
                   }
                ?>
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
   $(".w-set-tit").find('#tb_ship_lineday').addClass('on');


  function rowSave()
  {
      ST.Util.showMsg('保存中',6,10000);
      Ext.Ajax.request({
          url   :  SITEURL+"ship/admin/shipline/day/action/save",
          method  :  "POST",
          isUpload :  true,
          form  : "day_fm",
          datatype  :  "JSON",
          success  :  function(response, opts)
          {

              var text = response.responseText;

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
	    Ext.Ajax.request({
                  url   :  SITEURL+"ship/admin/shipline/day/action/add",
                  method  :  "POST",
                  datatype  :  "JSON",
                  success  :  function(response, opts)
                  {
                      var id = response.responseText;
                      if(id!='no')
                      {
						 var  $html='<tr><td class="dayname-td" class="text-l"><input type="text" class="input-text w100 ml-20"  name="title['+id+']"  value=""></td>';
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
              Ext.Ajax.request({
                  url   :  SITEURL+"ship/admin/shipline/day/action/del",
                  method  :  "POST",
                  params:{id:id},
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


      });

  }


</script>

</body>
</html>
