<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); ?>
    <?php echo Common::getScript("jquery.validate.js"); ?>
    <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,choose.js,product_add.js,imageup.js"); ?>
    <?php echo Common::getCss('uploadify.css','js/uploadify/'); ?>
   <style>
        .error{
            color:red;
            padding-left:5px;
        }
        .hide{
            display: none;
        }
    </style>
</head>
<body style="background-color: #fff">
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td">
            <form id="frm" name="frm" table_float=56ByYj >
            <div id="product_grid_panel" class="manage-nr">
            <div class="cfg-header-bar">
            <a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>
            </div>
                
                <div class="product-add-div" >
                <ul class="info-item-block">
                <li>
                <span class="item-hd">提现方式<?php echo Common::get_help_icon('withdraw_way');?>：</span>
                <div class="item-bd lh-30">
                <?php echo $info['way_name'];?>
                </div>
                </li>
                <li>
                <span class="item-hd">提现账号：</span>
                <div class="item-bd lh-30">
                <?php echo $info['account'];?>
                </div>
                </li>
                <li>
                <span class="item-hd">用户昵称：</span>
                <div class="item-bd lh-30">
                <?php echo $info['nickname'];?>
                </div>
                </li>
                <li>
                <span class="item-hd">提现金额：</span>
                <div class="item-bd lh-30">
                <?php echo $info['withdrawamount'];?>
                </div>
                </li>
                <?php if($info['way']=='bank') { ?>
                <li>
                <span class="item-hd">开户行名称：</span>
                <div class="item-bd lh-30">
                <?php echo $info['bankname'];?>
                </div>
                </li>
                <?php } ?>
                <li>
                <span class="item-hd">帐户姓名：</span>
                <div class="item-bd lh-30">
                <?php echo $info['bankaccountname'];?>
                </div>
                </li>
                <li>
                <span class="item-hd"><?php echo $info['way_name'];?>账号：</span>
                <div class="item-bd lh-30">
                <?php echo $info['bankcardnumber'];?>
                </div>
                </li>
                <li>
                <span class="item-hd">申请说明：</span>
                <div class="item-bd lh-30">
                <?php echo $info['description'];?>
                </div>
                </li>
                <li>
                <span class="item-hd">申请时间：</span>
                <div class="item-bd lh-30">
                <?php echo date('Y-m-d H:i:s',$info['addtime']);?>
                </div>
                </li>
                        <li>
                            <span class="item-hd">当前状态：</span>
                            <div class="item-bd lh-30">
                               <?php if($info['status']==0) { ?>申请中<?php } ?>
                               <?php if($info['status']==1) { ?>已完成<?php } ?>
                               <?php if($info['status']==2) { ?>未通过<?php } ?>
                            </div>
                        </li>
                        <?php if($info['status']!=0) { ?>
                        <li>
                            <span class="item-hd">审核备注：</span>
                            <div class="item-bd lh-30">
                                <?php echo $info['audit_description'];?>
                            </div>
                        </li>
                        <?php } ?>
                </ul>
                    <div>
                        <input type="hidden" id="field_audit_description" name="audit_description" value=""/>
                        <input type="hidden" id="field_status" name="status" value="<?php echo $info['status'];?>"/>
                        <input type="hidden" id="id" name="id" value="<?php echo $info['id'];?>">
                    </div>
                
                <div class="pt-5">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd"></span>
                                <div class="item-bd lh-30">
                                    <?php if($info['way']=='alipay' && $info['status']==0) { ?>
                                    <a class="btn btn-primary radius mr-20 " id="btn_alipay" href="javascript:;">线上打款</a>
                                    <?php } ?>
                                    <?php if($info['status']==0) { ?>
                                    <a class="btn btn-primary radius mr-20" id="btn_save" href="javascript:;">线下打款</a>
                                    <a class="btn btn-primary radius mr-20" id="btn_refuse" href="javascript:;">拒绝提现</a>
                                    <?php } ?>
                                  </div>
                            </li>
                        </ul>
                </div>
               
            </div>
            </form>
        </td>
    </tr>
</table>
<script language="JavaScript">
var old_status="<?php echo $info['status'];?>";
 $(function(){
     $("#btn_save").click(function(){
         ST.Util.showBox("线下打款说明",SITEURL+'member/dialog_withdraw_check',500,'',null,null,document,{loadWindow: window, loadCallback: offline_check});
         /*var cur_status=$("input[name=status]:checked").val();
         if(cur_status!=old_status)
         {
             ST.Util.confirmBox("提示", "审核状态有改动，确定保存？", function () {
                 $.ajaxform({
                     url   :  SITEURL+"member/ajax_withdraw_save",
                     method  :  "POST",
                     form  : "#frm",
                     dataType:'json',
                     success  :  function(data)
                     {
                         if(data.status)
                         {
                             ST.Util.showMsg(data.msg,'4',2000);
                         }
                         else
                         {
                             ST.Util.showMsg(data.msg,'5',2000);
                         }
                     }});
             })
         }*/
     });
     //拒绝请求
     $("#btn_refuse").click(function(){
         ST.Util.showBox("拒绝提现说明",SITEURL+'member/dialog_withdraw_check',500,'',null,null,document,{loadWindow: window, loadCallback: refuse_check});
     });
     function offline_check(data)
     {
         if(data.status==1)
         {
             $("#field_status").val(1);
             $("#field_audit_description").val(data.audit_description);
             save_confirm();
         }
     }
     function refuse_check(data)
     {
         if(data.status==1)
         {
             $("#field_status").val(2);
             $("#field_audit_description").val(data.audit_description);
             save_confirm();
         }
     }
     function save_confirm()
     {
         $.ajaxform({
             url   :  SITEURL+"member/ajax_withdraw_save",
             method  :  "POST",
             form  : "#frm",
             dataType:'json',
             success  :  function(data)
             {
                 if(data.status)
                 {
                     ST.Util.showMsg(data.msg,'4',2000);
                     setTimeout(function(){window.location.reload()},2000);
                 }
                 else
                 {
                     ST.Util.showMsg(data.msg,'5',2000);
                 }
             }});
     }
     //支付宝在线
     $("#btn_alipay").click(function(){
         var php_version="<?php echo phpversion();?>";
         var pre_hint = '';
         if(php_version<'5.5')
         {
             pre_hint="当前php版本低于5.5,可能无法请求成功，"
         }
         ST.Util.confirmBox("提示", pre_hint+"是否立即使用支付宝在线提现功能？", function () {
             $.ajaxform({
                 url   :  SITEURL+"member/ajax_withdraw_alipay_save",
                 method  :  "POST",
                 form  : "#frm",
                 dataType:'json',
                 success  :  function(data)
                 {
                     if(data.status)
                     {
                         ST.Util.showMsg(data.msg,'4',2000);
                         setTimeout(function()
                         {
                             window.location.reload()
                         },2000)
                     }
                     else
                     {
                         ST.Util.showMsg(data.msg,'5',4000);
                     }
                 }});
         })
     });
 })
</script>
</body>
</html>