<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('dialog.css','js/artDialog7/css'); ?>
    <?php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); ?>
    <?php echo Common::getScript("jquery.validate.js"); ?>
    <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,choose.js,product_add.js,imageup.js"); ?>
    <?php echo Common::getCss('uploadify.css','js/uploadify/'); ?>
    <?php echo Common::getScript("artDialog7/dist/dialog-plus.js"); ?>
   <style>
        .error{
            color:red;
            padding-left:5px;
        }
        .hide{
            display: none;
        }
    .finaldest span{
        color: red;
        display: inline-block;
        height: 30px;
        line-height: 30px;
        padding: 0 28px 0 10px;
        vertical-align: middle;
        margin-right: 10px;
        position: relative;
        background: #f1f1f1;
    }
    .finaldest span s {
        display: inline-block;
        width: 8px;
        height: 8px;
        cursor: pointer;
        opacity: .6;
        position: absolute;
        right: 10px;
        top: 11px;
        background: url(/newtravel/public/images/tab-bar-closed-icon.png) no-repeat 0 0;
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
            <form id="frm" name="frm">
            <div id="product_grid_panel" class="manage-nr">
                <div class="w-set-con">
                    <div class="cfg-header-bar" id="nav">
                    <div class="cfg-header-tab">
                    <span class="item on" id="basic"><s></s>基础信息</span>
                            <span class="item" data-id="qualify"><s></s>认证材料</span>
                        <span class="item" data-id="jieshao"><s></s>联系人</span>
                        <!-- <span class="item" data-id="extend"><s></s>高级</span> -->
                    </div>
                        <a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>
                    </div>
                </div>
                <div class="product-add-div" >
                    <ul class="info-item-block">
                        <li>
                            <span class="item-hd">经营范围：</span>
                            <div class="item-bd">
                                <div>
                                    <?php 
                                    $r_kind = array();
                                    if(empty($info['authorization']))
                                    {
                                        foreach($apply_product as $apply_product_item)
                                        {
                                            $r_kind[] = $apply_product_item['id'];
                                        }
                                    }
                                    else
                                    {
                                        $r_kind = explode(',',$info['authorization']);
                                    }
                                    ?>
                                    <?php $n=1; if(is_array($product_list)) { foreach($product_list as $p) { ?>
                                    <label class="check-label mr-5"><input type="checkbox" class="right" name="authorization[]" value="<?php echo $p['id'];?>" <?php if(in_array($p['id'],$r_kind)) { ?>checked="checked"<?php } ?>
><?php echo $p['modulename'];?></label>
                                    <?php $n++;}unset($n); } ?>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">目的地范围：</span>
                            <div class="item-bd">
                                    <div id="showdest" style="line-height: 2.5">
                                        <ul>
                                            <li style="float: left;" id="dest_li" class="finaldest">
                                                <?php if($desthtml!=null) { ?>
                                                    <?php echo $desthtml;?>
                                                <?php } ?>
                                            </li>
                                            <li style="float: left;">
                                                &nbsp&nbsp&nbsp<a href="#" id="limitdest" class="btn btn-primary btn-xs">请选择</a>
                                            </li>
                                        </ul>
                                    </div>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">出发地范围：</span>
                            <div class="item-bd">
                                    <div id="showfrom" style="line-height: 2.5">
                                        <ul>
                                            <li style="float: left;" id="from_li" class="finaldest">
                                                <?php if($fromhtml!='') { ?>
                                                    <?php echo $fromhtml;?>
                                                <?php } ?>
                                            </li>
                                            <li style="float: left;">
                                                &nbsp&nbsp&nbsp<a href="#" id="limitfrom" class="btn btn-warning btn-xs">请选择</a>
                                            </li>
                                        </ul>
                                    </div>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">所属分类<?php echo Common::get_help_icon('supplier_field_kindid');?>：</span>
                            <div class="item-bd">
                                <span class="select-box w150">
                                    <select class="select" name="kindid" id="">
                                        <option value="0">默认</option>
                                        <?php $n=1; if(is_array($kind)) { foreach($kind as $v) { ?>
                                        <option value="<?php echo $v['id'];?>" <?php if($v['id']==$info['kindid'] ) { ?>selected="selected"<?php } ?>
><?php echo $v['kindname'];?></option>
                                        <?php $n++;}unset($n); } ?>
                                    </select>
                                </span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">商家类型<?php echo Common::get_help_icon('supplier_field_suppliertype');?>：</span>
                            <div class="item-bd">
                            <span class="select-box w150">
                                <select class="select" name="suppliertype">
                                    <option value="0" <?php if($info['suppliertype']==0 ) { ?>selected="selected"<?php } ?>
>平台供应商</option>
                                    <option value="1" <?php if($info['suppliertype']==1 ) { ?>selected="selected"<?php } ?>
>第三方供应商</option>
                                </select>
                            </span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">供应商名称：</span>
                            <div class="item-bd">
                                <input type="text" class="input-text w200" name="suppliername" id="suppliername" value="<?php if(empty($info['suppliername'])) { ?><?php echo $qua['suppliername'];?><?php } else { ?><?php echo $info['suppliername'];?><?php } ?>
" >
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">企业名称：</span>
                            <div class="item-bd">
                                <span class="item-text"><?php echo $qua['suppliername'];?></span>
                            </div>
                        </li>
                        <li class="list_dl">
                            <span class="item-hd">联系电话：</span>
                            <div class="item-bd">
                                <input type="text" class="input-text w200" name="telephone" id="telephone" value="<?php if(empty($info['telephone'])) { ?><?php echo $qua['telephone'];?><?php } else { ?><?php echo $info['telephone'];?><?php } ?>
" >
                            </div>
                        </li>
                        <li class="list_dl">
                            <span class="item-hd">公司地址：</span>
                            <div class="item-bd">
                                <input type="text" class="input-text w500" name="address" id="address" value="<?php if(empty($info['address'])) { ?><?php echo $qua['address'];?><?php } else { ?><?php echo $info['address'];?><?php } ?>
" >
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">添加时间：</span>
                            <div class="item-bd">
                                <span class="item-text"><?php echo empty($info['addtime'])?date('Y-m-d H:i:s'):date('Y-m-d H:i:s',$info['addtime']);?></span>
                            </div>
                        </li>
                   </ul>
                </div>
                <div class="product-add-div" data-id="qualify">
                    <ul class="info-item-block">
                        <li><p class="lh-30 c-primary pl-75">注意：本功能是用于供应商资质验证，标准用户不需要进行配置</p></li>
                        <li>
                            <span class="item-hd">认证方式：</span>
                            <div class="item-bd">
                                <div class="authority_type">
                                    <label class="radio-label mr-5" for="v1">
                                        <input class="verify-type" type="radio" name="verifytype" id="v1" data-type="card" checked value="旅行社工作名片">旅行社工作名片
                                    </label>
                                    <label class="radio-label mr-5" for="v2">
                                        <input class="verify-type" type="radio" name="verifytype" id="v2" data-type="license" value="经营许可证">经营许可证
                                    </label>
                                    <label class="radio-label mr-5" for="v3">
                                        <input class="verify-type" type="radio" name="verifytype" id="v3" data-type="certify" value="营业执照(副本)">营业执照(副本)
                                    </label>
                                </div>
                            </div>
                        </li>
                        <li class="card optial">
                            <span class="item-hd">名片图片：</span>
                            <div class="item-bd">
                                <img src="<?php echo $qua['mp_litpic'];?>" width="215" height="136">
                                &nbsp;&nbsp;<a class="btn-link" href="<?php echo $qua['mp_litpic'];?>" target="_blank">查看</a>
                            </div>
                        </li>
                        <li class="license hide optial">
                            <span class="item-hd">许可证号码：</span>
                            <div class="item-bd">
                                <span class="item-text"><?php echo $qua['licenseno'];?></span>
                            </div>
                        </li>
                        <li class="license hide optial">
                            <span class="item-hd">许可证图片：</span>
                            <div class="item-bd">
                                <img src="<?php echo $qua['xk_litpic'];?>" width="215" height="136">
                                &nbsp;&nbsp;<a class="btn-link" href="<?php echo $qua['xk_litpic'];?>" target="_blank">查看</a>
                            </div>
                        </li>
                        <li class="certify hide optial">
                            <span class="item-hd">营业执照：</span>
                            <div class="item-bd">
                                <span class="item-text"><?php echo $qua['certifyno'];?></span>
                            </div>
                        </li>
                        <li class="certify hide optial">
                            <span class="item-hd">营业执照图片：</span>
                            <div class="item-bd">
                                <img src="<?php echo $qua['zz_litpic'];?>" width="215" height="136">
                                &nbsp;&nbsp;<a class="btn-link" href="<?php echo $qua['zz_litpic'];?>" target="_blank">查看</a>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">企业名称：</span>
                            <div class="item-bd">
                                <span class="item-text"><?php echo $qua['suppliername'];?></span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">法人代表：</span>
                            <div class="item-bd">
                                <span class="item-text"><?php echo $qua['reprent'];?></span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">公司地址：</span>
                            <div class="item-bd">
                                <span class="item-text"><?php if(empty($info['address'])) { ?><?php echo $qua['address'];?><?php } else { ?><?php echo $info['address'];?><?php } ?>
</span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">经营范围：</span>
                            <div class="item-bd">
                                <span class="item-text">
                                    <?php $n=1; if(is_array($apply_product)) { foreach($apply_product as $p) { ?>
                                    <?php if($p['kindname']) { ?>
                                     <label><?php echo $p['kindname'];?>&nbsp;&nbsp;</label>
                                    <?php } else { ?>
                                     <label><?php echo $p['modulename'];?>&nbsp;&nbsp;</label>
                                    <?php } ?>
                                    <?php $n++;}unset($n); } ?>
                                </span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">认证状态：</span>
                            <div class="item-bd">
                                <span class="item-text verify">
                                    <label class="radio-label mr-5" for="c0">
                                        <input type="radio" name="verifystatus" id="c0" <?php if($info['verifystatus']==0) { ?>checked<?php } ?>
 value="0">未认证
                                    </label>
                                    <label class="radio-label mr-5" for="c1">
                                        <input type="radio" name="verifystatus" id="c1" <?php if($info['verifystatus']==1) { ?>checked<?php } ?>
 value="1">审核中
                                    </label>
                                     <label class="radio-label mr-5" for="c2">
                                        <input type="radio" name="verifystatus" id="c2" <?php if($info['verifystatus']==2) { ?>checked<?php } ?>
 value="2">未通过
                                     </label>
                                    <label class="radio-label mr-5" for="c3">
                                        <input type="radio" name="verifystatus" id="c3" <?php if($info['verifystatus']==3) { ?>checked<?php } ?>
 value="3">已认证
                                    </label>
                                </span>
                            </div>
                        </li>
                        <li class="reason <?php if($info['verifystatus']!=2) { ?>hide<?php } ?>
">
                            <span class="item-hd">未通过原因：</span>
                            <div class="item-bd">
                                <input type="text" name="reason" id="reason" class="input-text w400" value="<?php echo $info['reason'];?>"/>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="product-add-div pd-20" data-id="jieshao">
                    <ul class="info-item-block">
                        <li class="list_dl">
                            <span class="item-hd">手机号码：</span>
                            <div class="item-bd">
                                <input type="text" class="input-text w200" name="mobile" id="mobile" autocomplete="off" value="<?php echo $info['mobile'];?>" >
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">登录密码<?php echo Common::get_help_icon('supplier_field_password');?>：</span>
                            <div class="item-bd">
                                <input type="text" class="input-text w200" name="password" autocomplete="off" onfocus="this.type='password'" id="password" >
                            </div>
                        </li>
                        <li class="list_dl">
                            <span class="item-hd">姓名：</span>
                            <div class="item-bd">
                                <input type="text" class="input-text w200"  name="linkman" id="linkman" value="<?php echo $info['linkman'];?>" >
                            </div>
                        </li>
                        <li class="list_dl">
                            <span class="item-hd">电子邮箱：</span>
                            <div class="item-bd">
                                <input type="text" class="input-text w200" name="email" id="fax" value="<?php echo $info['email'];?>">
                            </div>
                        </li>
                        <li class="list_dl">
                            <span class="item-hd">QQ：</span>
                            <div class="item-bd">
                                <input type="text" class="input-text w200" name="qq" id="qq" value="<?php echo $info['qq'];?>" >
                            </div>
                        </li>
                        <li class="list_dl">
                            <span class="item-hd">传真：</span>
                            <div class="item-bd">
                                <input type="text" class="input-text w200" name="fax" id="fax" value="<?php echo $info['fax'];?>">
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="product-add-div pb-5" data-id="extend">
                    <div class="c-primary pl-30 pt-15">高级中的字段未调用，开放给二次开发客户使用</div>
                    <ul class="info-item-block">
                        <li class="list_dl">
                            <span class="item-hd">坐标<?php echo Common::get_help_icon('supplier_field_lng_lat');?>：</span>
                            <div class="item-bd">
                                <span class="item-text">经度(Lng):</span>
                                <input type="text" name="lng" id="lng"  class="input-text w200" value="<?php echo $info['lng'];?>" />
                                <span class="item-text ml-20">纬度(Lat):</span>
                                <input type="text" name="lat" id="lat" class="input-text w200" value="<?php echo $info['lat'];?>"  />
                                <a href="javascript:;" class="btn btn-primary radius size-S ml-5" onclick="Product.Coordinates(700,500)"  title="选择">选择</a>
                            </div>
                        </li>
                        <li class="list_dl">
                            <span class="item-hd">目的地<?php echo Common::get_help_icon('supplier_field_finaldestid');?>：</span>
                            <div class="item-bd">
                                <a href="javascript:;" class="btn btn-primary radius size-S mt-3" onclick="Product.getDest(this,'.dest-sel',0)"  title="选择">选择</a>
                                <div class="save-value-div mt-2 ml-10 dest-sel">
                                    <?php $n=1; if(is_array($info['kindlist_arr'])) { foreach($info['kindlist_arr'] as $k => $v) { ?>
                                    <span class="<?php if($info['finaldestid']==$v['id']) { ?>finaldest<?php } ?>
" title="<?php if($info['finaldestid']==$v['id']) { ?>最终目的地<?php } ?>
" ><s onclick="$(this).parent('span').remove()"></s><?php echo $v['kindname'];?><input type="hidden" class="lk" name="kindlist[]" value="<?php echo $v['id'];?>"/>
                                    <?php if($info['finaldestid']==$v['id']) { ?><input type="hidden" class="fk" name="finaldestid" value="<?php echo $info['finaldestid'];?>"/><?php } ?>
</span>
                                    <?php $n++;}unset($n); } ?>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">供应商图片：</span>
                            <div class="item-bd">
                                <div id="pic_btn" class="btn btn-primary radius size-S mt-4">上传图片</div>
                                <div class="clear"></div>
                                <div class="up-list-div">
                                    <input type="hidden" class="headimgindex" name="imgheadindex" value=""/>
                                    <input type="hidden" name="litpic" id="litpic" value="<?php echo $info['litpic'];?>"/>
                                    <ul class="pic-sel">
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">供应商介绍：</span>
                            <div class="item-bd">
                            <?php Common::getEditor('content',$info['content'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="clear clearfix">
                    <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                </div>
                <dl class="list_dl">
                    <dt class="wid_90">&nbsp;</dt>
                    <dd>
                        <input type="hidden" id="id" name="id" value="<?php echo $info['id'];?>">
                        <input type="hidden" id='action' name="action" value="<?php echo $action;?>">
                        <input type="hidden" name="kind_right" id="kind_right" value="<?php echo $action;?>">
                        <input type="hidden" name="litpic" id="litpic" value="<?php echo $info['litpic'];?>">
                    </dd>
                </dl>
            </div>
            </form>
        </td>
    </tr>
</table>
<script language="JavaScript">
    window.d=null;
    function removespan(ele) {
        var tbl = $(ele).parent('span').parent('li').attr('id').substring(0,4);
        if (tbl=='dest') {
            tbl='destinations';
        }else{
            tbl='startplace';
        }
        $.ajax({
            url: '/newtravel/supplier/ajax_set_supplierid',
            type: 'post',
            dataType: 'json',
            data: {tbl: tbl,isopen:0,placeid:$(ele).parent('span').attr('id'),supplierid:$('#id').val()},
        })
        .done(function(msg) {
            $(ele).parent('span').remove();
        })
    }
//弹出框
/*
  params为附加参数，可以是与dialog有关的所有参数，也可以是自定义参数
  其中自定义参数里有
  loadWindow: 表示回调函数的window
  loadCallback: 表示回调函数
  maxHeight:指定最高高度
 */
function floatBox(boxtitle, url, boxwidth, boxheight, closefunc, nofade,fromdocument,params) {
    boxwidth = boxwidth != '' ? boxwidth : 0;
    boxheight = boxheight != '' ? boxheight : 0;
    var func = $.isFunction(closefunc) ? closefunc : function () {
    };
    fromdocument = fromdocument ? fromdocument : null;//来源document
    var initParams={
        id:'showdest',
        url: url,
        title: boxtitle,
        width: boxwidth,
        height: boxheight,
        scroll:0,
        loadDocument:fromdocument,
        cancel:false,
        onclose: function () {
            func();
        }
    }
    initParams= $.extend(initParams,params);
    var dlg = dialog(initParams);
    if(typeof(dlg.loadCallback)=='function'&&typeof(dlg.loadWindow)=='object')
    {
       dlg.finalResponse=function(arg,bool,isopen){
            dlg.loadCallback.call(dlg.loadWindow,arg,bool);
            if(!isopen)
              this.remove();
       }
    }
    window.d=dlg;
    d.close()
    if (initParams.width != 0) {
        d.width(initParams.width);
    }
    if (initParams.height!= 0) {
        d.height(initParams.height);
    }
  
    if (nofade) {
        d.show()
    } else {
        d.showModal();
    }
}
    var action='<?php echo $action;?>';
    <?php if($action=='edit') { ?>
        var piclist = ST.Modify.getUploadFile(<?php echo $info['piclist_arr'];?>);
        $(".pic-sel").html(piclist);
        var litpic = $("#litpic").val();
        $(".img-li").find('img').each(function(i,item){
            if($(item).attr('src')==litpic){
                var obj = $(item).parent().find('.btn-ste')[0];
                Imageup.setHead(obj,i+1);
            }
        })
        window.image_index= $(".pic-sel").find('li').length;//已添加的图片数量
    <?php } ?>
    //验证是否通过
        $('.verify').find('input').click(function(){
            if($(this).val()==2){
                $('.reason').removeClass('hide');
            }else{
                $('.reason').addClass('hide');
            }
        })
    // 联系人手机号验证
    $.validator.addMethod("isMobile", function(value, element) {
     var mobile = /^(\+?\d+-?)?\d{6,}$/;
     return this.optional(element) ||  mobile.test(value);
    }, "请正确填写您的手机号码");
    // 联系人邮箱验证
    $.validator.addMethod("isEmail", function(value, element) {
     var email = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;
     return this.optional(element) ||  email.test(value);
    }, "请正确填写您的邮箱");
    //表单验证
    $("#frm").validate({
        focusInvalid:false,
        rules: {
            suppliername:
            {
                required: true
            },
            password:
            {
                minlength: 6
            },
            mobile:
            {
                required:true,
                isMobile:true,
            },
            email:
            {
                // required:true,
                isEmail:true,
            }
        },
        messages: {
            suppliername:{
                required:"请输入供应商名称"
            },
            password:
            {
                minlength: '密码不能少于6位'
            },
            mobile:
            {
                required: '请输入手机号'
            },
        },
        errUserFunc:function(element){
        },
        submitHandler:function(form){
            if($("#suppliername").val() == ""){
                ST.Util.showMsg('请输入供应商名称','1',2000);
                return false;
            }
            if($("#mobile").val() == ""){
                ST.Util.showMsg('请输入手机号或者邮箱','1',2000);
                return false;
            }
            if ($("#password").val() != "" && $("#password").val().length < 6) {
                ST.Util.showMsg('密码不能少于6位', '1', 2000);
                return false;
            }
            var right = [];
            $(".right").each(function(i,obj){
                if($(obj).attr('checked')=='checked'){
                    right.push($(obj).val());
                }
            })
            $("#kind_right").val(right.join(','));
            $.ajaxform({
                url   :  SITEURL+"supplier/ajax_save",
                method  :  "POST",
                form  : "#frm",
                dataType:'json',
                success  :  function(data)
                {
                    if(data.status)
                    {
                        $("#id").val(data.productid);
                        ST.Util.showMsg('保存成功!','4',3000);
                        window.location.reload()
                    }
                    else
                    {
                        ST.Util.showMsg(data.msg,'5',3000);
                    }
                }});
            return false;//阻止常规提交
       }
    });
    $(function(){
        $('#limitdest').click(function(event) {
            /* Act on the event */
            if ($('#action').val()=='add') {
                floatBox("设置供应商目的地","/newtravel/supplier/select_limit/<?php echo $info['id'];?>/"+"<?php echo $action;?>"+"/query/dest/ids/"+$('#destids').val(),"400","470")
            }else{
                floatBox("编辑供应商目的地","/newtravel/supplier/select_limit/<?php echo $info['id'];?>/"+"<?php echo $action;?>"+"/query/dest/ids/"+$('#destids').val(),"400","470")
            }
        });
        $('#limitfrom').click(function(event) {
            /* Act on the event */
            if ($('#action').val()=='add') {
                floatBox("设置供应商出发地","/newtravel/supplier/select_limit/<?php echo $info['id'];?>/"+"<?php echo $action;?>"+"/query/from/ids/"+$('#fromids').val(),"400","470")
            }else{
                floatBox("编辑供应商出发地","/newtravel/supplier/select_limit/<?php echo $info['id'];?>/"+"<?php echo $action;?>"+"/query/from/ids/"+$('#fromids').val(),"400","470")
            }
        });
        $("#nav").find('span').click(function(){
            Product.changeTab(this,'.product-add-div');//导航切换
        })
        $("#nav").find('span').first().trigger('click');
        //保存
        $("#btn_save").click(function(){
            $("#frm").submit();
            return false;
        })
        //上传图片
        $('#pic_btn').click(function(){
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                var len=result.data.length;
                for(var i=0;i<len;i++){
                    var temp =result.data[i].split('$$');
                    Imageup.genePic(temp[0],".up-list-div ul",".cover-div");
                }
            }
        });
        //验证方式切换
        $('.verify-type').change(function(){
            var type = $(this).data('type');
            switch(type){
                case 'license':
                    $('.info-item-block').find('.license').removeClass('hide');
                    $('.info-item-block').find('.card').addClass('hide');
                    $('.info-item-block').find('.certify').addClass('hide');
                    break;
                case 'certify':
                    $('.info-item-block').find('.certify').removeClass('hide');
                    $('.info-item-block').find('.card').addClass('hide');
                    $('.info-item-block').find('.license').addClass('hide');
                    break;
                default:
                    $('.info-item-block').find('.card').removeClass('hide');
                    $('.info-item-block').find('.license').addClass('hide');
                    $('.info-item-block').find('.certify').addClass('hide');
                    break;
            }
        });
        <?php 
        $verifytype="";
        if(!empty($qua['mp_litpic']))
        {
            $verifytype="旅行社工作名片";
        }
        else if(!empty($qua['xk_litpic']))
        {
            $verifytype="经营许可证";
        }
        else if(!empty($qua['zz_litpic']))
        {
            $verifytype="营业执照(副本)";
        }
        ?>
        $(".authority_type input").each(function(){
            if($(this).val() == "<?php echo $verifytype;?>")
            {
                $(this).trigger("click");
            }
        });
    })
</script>
</body>
</html>
