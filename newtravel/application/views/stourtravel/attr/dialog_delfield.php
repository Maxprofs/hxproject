<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base.css,base_new.css,attrid_dialog.css'); }
</head>
<body style=" overflow: hidden">
<div class="p-main">
   <div class="s-main">
       <div class="s-con text-c">
           {if empty($products)}
              <div class="item-text">确认删除？</div>
           {else}
              <div class="item-text">该字段下有数据，删除将无法恢复，是否继续？<a href="javascript:;" class="view-btn" id="view_btn">查看</a></div>
           {/if}
       </div>
       <div class="clear text-c f-0 mt-10">
           <a href="javascript:;" class="btn btn-grey-outline radius" id="cancel-btn">取消</a>
           <a href="javascript:;" class="btn btn-primary radius ml-20" id="confirm_btn">确定</a>
       </div>
   </div>
   <div class="s-list" id="product_list" style="display:none">
       <table class="product-list">
           {loop $products $product}
           <tr><td>{$product['title']}</td></tr>
           {/loop}
       </table>
       <div class="clear">
           <a href="javascript:;" class="cancel-btn">取消</a>
           <a href="javascript:;" class="confirm-btn" id="back_btn">返回</a>
       </div>
   </div>
</div>
<script>
     var id="{$id}";
     $(function(){

         $("#view_btn").click(function(){
             $("#product_list").show();
             $(".s-main").hide();
             ST.Util.resizeDialog('.p-main');
         });
         $("#back_btn").click(function(){
             $(".s-main").show();
             $("#product_list").hide();
             ST.Util.resizeDialog('.p-main');
         });

         $("#confirm_btn").click(function(){
             ST.Util.responseDialog({id:id,del:true},true);
         });

         $("#cancel-btn").click(function(){
             ST.Util.closeDialog();
         });
     })
</script>

</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201712.2001&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
