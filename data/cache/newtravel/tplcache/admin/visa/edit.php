<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="admin/public/css/common.css"/>
    <meta charset="utf-8">
    <title>签证添加/修改</title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base_new.css'); ?>
    <?php echo Common::getScript("jquery.upload.js,choose.js,product_add.js,imageup.js,st_validate.js"); ?>
    <style>
        #attachment-content{  margin-left: 15px; line-height: 30px; list-style: none; clear: both;}
        #attachment-content li{ list-style-position: inside; list-style: decimal;}
        #attachment-content span{ padding-right:5px;}
        #attachment-content span.del{ color: #f00; cursor:pointer;margin: 0 5px;}
        #attachment-content span.del:hover{text-decoration:underline }
    </style>
</head>
<body>
<table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td ">
                <form method="post" name="product_frm" id="product_frm">
                    <div class="cfg-header-bar" id="nav">
                        <div class="cfg-header-tab">
                            <span class="item on">基础信息</span>
                            <?php $n=1; if(is_array($columns)) { foreach($columns as $column) { ?>
                            <span class="item" data-id="<?php echo $column['columnname'];?>"><?php echo $column['chinesename'];?></span>
                            <?php $n++;}unset($n); } ?>
                            <span class="item" data-id="youhua">优化设置</span>
                            <span class="item" data-id="extend">扩展设置</span>
                        </div>
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
                      <!--基础信息开始-->
                      <div class="product-add-div">
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">签证名称<?php echo Common::get_help_icon('product_visa_title');?>：</span>
                                  <div class="item-bd">
                                      <input type="text" name="title" id="title" class="input-text w900"  value="<?php echo $info['title'];?>" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">签证卖点<?php echo Common::get_help_icon('product_visa_sellpoint');?>：</span>
                                  <div class="item-bd">
                                      <input type="text" name="sellpoint" value="<?php echo $info['sellpoint'];?>"  class="input-text w900"/>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">签证类型：</span>
                                  <div class="item-bd">
                                      <span class="select-box w150">
                                          <select class="select" name="visatype">
                                              <option value="0">请选择</option>
                                              <?php $n=1; if(is_array($visatypelist)) { foreach($visatypelist as $k) { ?>
                                               <option value="<?php echo $k['id'];?>" <?php if($info['visatype']==$k['id']) { ?>selected="selected"<?php } ?>
 ><?php echo $k['kindname'];?></option>
                                              <?php $n++;}unset($n); } ?>
                                          </select>
                                      </span>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">所属区域：</span>
                                  <div class="item-bd">
                                      <span class="select-box w100">
                                      <select class="select" name="areaid" onchange="getNation(this.options[this.options.selectedIndex].value)">
                                          <option value="0">请选择</option>
                                          <?php $n=1; if(is_array($arealist)) { foreach($arealist as $k) { ?>
                                           <option value="<?php echo $k['id'];?>" <?php if($info['areaid']==$k['id']) { ?>selected="selected"<?php } ?>
 ><?php echo $k['kindname'];?></option>
                                          <?php $n++;}unset($n); } ?>
                                      </select>
                                      </span>
                                      <span class="select-box w100 ml-5">
                                          <select class="select" name="nationid" id="nationid">
                                              <option value="0">请选择</option>
                                              <?php $n=1; if(is_array($nationlist)) { foreach($nationlist as $k) { ?>
                                               <option value="<?php echo $k['id'];?>" <?php if($info['nationid']==$k['id']) { ?>selected="selected"<?php } ?>
 ><?php echo $k['kindname'];?></option>
                                              <?php $n++;}unset($n); } ?>
                                          </select>
                                      </span>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">签发城市：</span>
                                  <div class="item-bd">
                                      <span class="select-box w100">
                                          <select class="select" name="cityid">
                                              <option value="0">请选择</option>
                                              <?php $n=1; if(is_array($citylist)) { foreach($citylist as $k) { ?>
                                              <option value="<?php echo $k['id'];?>" <?php if($info['cityid']==$k['id']) { ?>selected="selected"<?php } ?>
 ><?php echo $k['kindname'];?></option>
                                              <?php $n++;}unset($n); } ?>
                                          </select>
                                      </span>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">办理时间：</span>
                                  <div class="item-bd">
                                      <input type="text" name="handleday" id="handleday" class="input-text w300" value="<?php echo $info['handleday'];?>" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">有效时间：</span>
                                  <div class="item-bd">
                                      <input type="text" name="validday" id="validday" class="input-text w300" value="<?php echo $info['validday'];?>" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">面签：</span>
                                  <div class="item-bd">
                                      <label class="radio-label"><input type="radio" name="needinterview" value="0" <?php if($info['needinterview']==0) { ?> checked="checked"<?php } ?>
/>不需要</label>
                                      <label class="radio-label ml-20"><input type="radio" name="needinterview" value="1" <?php if($info['needinterview']==1) { ?> checked="checked"<?php } ?>
/>需要</label>
                                      <label class="radio-label ml-20"><input type="radio" name="needinterview" value="2" <?php if($info['needinterview']==2) { ?> checked="checked"<?php } ?>
/>领馆决定</label>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">邀请函：</span>
                                  <div class="item-bd">
                                      <label class="radio-label"><input type="radio" name="needletter" value="0" <?php if($info['needletter']==0) { ?> checked="checked"<?php } ?>
/>不需要</label>
                                      <label class="radio-label ml-20"><input type="radio" name="needletter" value="1" <?php if($info['needletter']==1) { ?> checked="checked"<?php } ?>
/>需要</label>
                                      <label class="radio-label ml-20"><input type="radio" name="needletter" value="2" <?php if($info['needletter']==2) { ?> checked="checked"<?php } ?>
/>领馆决定</label>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">本站报价：</span>
                                  <div class="item-bd">
                                      <input type="text" name="price" id="price" class="input-text w100" value="<?php echo $info['price'];?>" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">市场报价：</span>
                                  <div class="item-bd">
                                      <input type="text" name="marketprice" id="marketprice" class="input-text w100" value="<?php echo $info['marketprice'];?>" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">受理范围：</span>
                                  <div class="item-bd">
                                      <input type="text" name="handlerange" id="handlerange" class="input-text w900" value="<?php echo $info['handlerange'];?>" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">停留时间：</span>
                                  <div class="item-bd">
                                      <input type="text" name="partday" id="partday" class="input-text w300" value="<?php echo $info['partday'];?>" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">受理时间：</span>
                                  <div class="item-bd">
                                      <input type="text" name="acceptday" id="acceptday" class="input-text w300" value="<?php echo $info['acceptday'];?>" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">受理人群：</span>
                                  <div class="item-bd">
                                      <input type="text" name="handlepeople" id="handlepeople" class="input-text w300" value="<?php echo $info['handlepeople'];?>" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">所属领馆：</span>
                                  <div class="item-bd">
                                      <input type="text" name="belongconsulate" id="belongconsulate" class="input-text w300" value="<?php echo $info['belongconsulate'];?>" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">供应商：</span>
                                  <div class="item-bd">
                                      <input type="button" class="fl btn btn-primary radius size-S mt-3" value="选择" onclick="Product.getSupplier(this,'.supplier-sel')" />
                                      <div class="save-value-div ml-10 supplier-sel w700">
                                          <?php if(!empty($info['supplier_arr']['id'])) { ?>
                                          <span class="mb-5"><s onclick="$(this).parent('span').remove()"></s><?php echo $info['supplier_arr']['suppliername'];?><input type="hidden" name="supplierlist[]" value="<?php echo $info['supplier_arr']['id'];?>"></span>
                                          <?php } ?>
                                      </div>
                                  </div>
                              </li>
                              <li>
                                <span class="item-hd">前台隐藏：</span>
                                <div class="item-bd">
                                    <label class="radio-label"><input type="radio" name="ishidden"  <?php if($info['ishidden']==0) { ?>checked="checked"<?php } ?>
 value="0">显示</label>
                                    <label class="radio-label ml-20"><input type="radio" name="ishidden"  <?php if($info['ishidden']==1) { ?>checked="checked"<?php } ?>
 value="1">隐藏</label>
                                </div>
                              </li>
                              <li>
                                  <span class="item-hd">显示模版：</span>
                                  <div class="item-bd">
                                      <div class="temp-chg" id="templet_list">
                                          <a <?php if($info['templet']=='') { ?>class="on"<?php } ?>
  href="javascript:void(0)"  data-value="" onclick="setTemplet(this)">标准</a>
                                          <?php $n=1; if(is_array($templetlist)) { foreach($templetlist as $r) { ?>
                                          <a <?php if($info['templet']==$r['path']) { ?>class="on"<?php } ?>
  href="javascript:void(0)" data-value="<?php echo $r['path'];?>" onclick="setTemplet(this)"><?php echo $r['templetname'];?></a>
                                          <?php $n++;}unset($n); } ?>
                                          <input type="hidden" name="templet" id="templet" value="<?php echo $info['templet'];?>"/>
                                      </div>
                                  </div>
                              </li>
                          </ul>
                          <div class="line"></div>
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">预订送积分策略：</span>
                                  <div class="item-bd">
                                      <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getJifenbook(this,'.jifenbook-sel',8)" title="选择">选择</a>
                                      <div class="save-value-div ml-10 jifenbook-sel">
                                          <?php if(!empty($info['jifenbook_info'])) { ?>
                                        <span><s onclick="$(this).parent('span').remove()"></s><?php echo $info['jifenbook_info']['title'];?>(<?php echo $info['jifenbook_info']['value'];?><?php if($info['jifenbook_info']['rewardway']==1) { ?>%<?php } ?>
积分)
                                            <?php if($info['jifenbook_info']['isopen']==0) { ?><a class="cor_f00">[已关闭]</a><?php } ?>
<input type="hidden" name="jifenbook_id" value="<?php echo $info['jifenbook_info']['id'];?>">
                                        </span>
                                          <?php } ?>
                                      </div>
                                      <span class="item-text c-999 ml-20">*未选择的情况下默认使用全局策略</span>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">积分抵现策略：</span>
                                  <div class="item-bd">
                                      <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getJifentprice(this,'.jifentprice-sel',8)" title="选择">选择</a>
                                      <div class="save-value-div ml-10 jifentprice-sel">
                                          <?php if(!empty($info['jifentprice_info'])) { ?>
                                        <span><s onclick="$(this).parent('span').remove()"></s><?php echo $info['jifentprice_info']['title'];?>(<?php echo $info['jifentprice_info']['toplimit'];?>积分)
                                            <?php if($info['jifentprice_info']['isopen']==0) { ?><a class="cor_f00">[已关闭]</a><?php } ?>
<input type="hidden" name="jifentprice_id" value="<?php echo $info['jifentprice_info']['id'];?>">
                                        </span>
                                          <?php } ?>
                                      </div>
                                      <span class="item-text c-999 ml-20">*未选择的情况下默认使用全局策略</span>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">支付方式：</span>
                                  <div class="item-bd">
                                      <div class="on-off">
                                          <label class="radio-label"><input type="radio" name="paytype" value="1" <?php if($info['paytype']=='1') { ?>checked="checked"<?php } ?>
 />全款支付</label>
                                          <label class="radio-label ml-20"><input type="radio" name="paytype" value="2" <?php if($info['paytype']=='2') { ?>checked="checked"<?php } ?>
 />定金支付</label>
                                            <span class="ml-5" id="dingjin" style="<?php if($info['paytype'] == '2') { ?>display:inline-block<?php } else { ?>display: none<?php } ?>
">
                                                <input type="text" class="input-text w80" name="dingjin" id="dingjintxt" value="<?php echo $info['dingjin'];?>" size="8" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-\.]+/,'');}).call(this)" onblur="this.v();">&nbsp;元
                                            </span>
                                          <label class="radio-label ml-20"><input type="radio" name="paytype" value="3"  <?php if($info['paytype']=='3') { ?>checked="checked"<?php } ?>
 />二次确认支付</label>
                                          <script>
                                              $("input[name='paytype']").click(function(){
                                                  if($(this).val() == 2)
                                                  {
                                                      $("#dingjin").show();
                                                  }
                                                  else
                                                  {
                                                      $("#dingjin").hide()
                                                  }
                                              })
                                          </script>
                                      </div>
                                  </div>
                              </li>
                          </ul>
                          <div class="line"></div>
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">图标设置：</span>
                                  <div class="item-bd">
                                      <input type="button" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getIcon(this,'.icon-sel')" value="选择"/>
                                      <div class="save-value-div ml-10 icon-sel w700">
                                          <?php $n=1; if(is_array($info['iconlist_arr'])) { foreach($info['iconlist_arr'] as $k => $v) { ?>
                                          <span class="mb-5"><s onclick="$(this).parent('span').remove()"></s><img src="<?php echo $v['picurl'];?>"><input type="hidden" name="iconlist[]" value="<?php echo $v['id'];?>"></span>
                                          <?php $n++;}unset($n); } ?>
                                      </div>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">显示数据：</span>
                                  <div class="item-bd">
                                      <span class="item-text">推荐次数<input type="text" name="recommendnum" id="yesjian" data-regrex="number" data-msg="*必须为数字"  class="input-text w80 ml-5" value="<?php echo $info['recommendnum'];?>" /></span>
                                      <span class="item-text ml-20">满意度<input type="text" name="satisfyscore" id="satisfyscore" data-regrex="number" data-msg="*必须为数字" class="input-text w80 ml-5" value="<?php echo $info['satisfyscore'];?>"  /></span>
                                      <span class="item-text ml-20">销量<input type="text" name="bookcount" id="bookcount" data-regrex="number" data-msg="*必须为数字" class="input-text w80 ml-5" value="<?php echo $info['bookcount'];?>" /></span>
                                  </div>
                              </li>
                          </ul>
                          <div class="line"></div>
                      </div>
                      <!--基础信息结束-->
                      <!--图片开始-->
                      <div class="product-add-div" data-id="tupian">
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">签证图片：</span>
                                  <div class="item-bd">
                                      <div class="">
                                          <div id="pic_btn" class="btn btn-primary radius size-S mt-3">上传图片</div>
                                          <span class="item-text c-999 ml-20">建议上传尺寸1024*695px</span>
                                      </div>
                                      <div class="up-list-div">
                                          <ul class="pic-sel">
                                              <li class="img-li h100">
                                                 <?php if(!empty($info['litpic'])) { ?>
                                                  <img class="fl" id="visapic" src="<?php echo $info['litpic'];?>" width="100" height="100"><p class="p1"><span class="btn-closed" onclick="Imageup.delImg(this,'<?php echo $info['litpic'];?>',1)"></span></p></li>
                                                 <?php } else { ?>
                                                   <img id="visapic" class="up-img-area" src="<?php echo Common::getDefaultImage();?>" >
                                                 <?php } ?>
                                              <input type="hidden" name="litpic" id="litpic" value="<?php echo $info['litpic'];?>"/>
                                          </ul>
                                      </div>
                                  </div>
                              </li>
                          </ul>
                      </div>
                      <!--图片结束-->
                      <div class="product-add-div" data-id="content">
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">签证介绍：</span>
                                  <div class="item-bd">
                                      <?php Common::getEditor('content',$info['content'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                                  </div>
                              </li>
                          </ul>
                      </div>
                      <div class="product-add-div" data-id="material">
                          <ul class="subTitNav">
                              <?php $n=1; if(is_array($materials)) { foreach($materials as $ma) { ?>
                              <li data-id="<?php echo $ma['pinyin'];?><?php echo $n;?>" class="<?php if($n==1) { ?>yes<?php } ?>
"><?php echo $ma['title'];?></li>
                              <?php $n++;}unset($n); } ?>
                          </ul>
                          <?php $n=1; if(is_array($materials)) { foreach($materials as $ma) { ?>
                          <div id="<?php echo $ma['pinyin'];?><?php echo $n;?>" style="<?php if($n>1) { ?>display: none<?php } ?>
">
                              <ul class="info-item-block">
                                  <li>
                                      <span class="item-hd"><?php echo $ma['title'];?>：</span>
                                      <div class="item-bd">
                                          <?php Common::getEditor($ma['pinyin'],$ma['content'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                                      </div>
                                  </li>
                              </ul>
                          </div>
                          <?php $n++;}unset($n); } ?>
                          <!--<div id="material-1">
                              <ul class="info-item-block">
                                  <li>
                                      <span class="item-hd">在职人员：</span>
                                      <div class="item-bd">
                                        <?php Common::getEditor('material',$info['material'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                                      </div>
                                  </li>
                              </ul>
                          </div>
                          <div id="material-2" style="display: none">
                              <ul class="info-item-block">
                                  <li>
                                      <span class="item-hd">自由职业者：</span>
                                      <div class="item-bd">
                                        <?php Common::getEditor('material2',$info['material2'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                                      </div>
                                  </li>
                              </ul>
                          </div>-->
                      </div>
                      <div class="product-add-div" data-id="booknotice">
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">预订须知：</span>
                                  <div class="item-bd">
                                    <?php Common::getEditor('booknotice',$info['booknotice'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                                  </div>
                              </li>
                          </ul>
                      </div>
                      <div class="product-add-div" data-id="circuit">
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">办理流程：</span>
                                  <div class="item-bd">
                                    <?php Common::getEditor('circuit',$info['circuit'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                                  </div>
                              </li>
                          </ul>
                      </div>
                      <div class="product-add-div" data-id="friendtip">
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">办理流程：</span>
                                  <div class="item-bd">
                                    <?php Common::getEditor('friendtip',$info['friendtip'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                                  </div>
                              </li>
                          </ul>
                      </div>
                      <div class="product-add-div" data-id="attachment">
                          <ul id="doclist" class="info-item-block">
                              <li>
                                  <span class="item-hd">签证附件：</span>
                                  <div class="item-bd">
                                      <!--<div class="up-file-div">
                                          <div id="attach_btn" class="btn-file mt-4">上传附件</div>
                                          <input type="hidden" name="attachment" id="attachment" value="<?php echo $info['attachment'];?>">
                                      </div>-->
                                      <div>
                                          <a href="javascript:;" id="attach_btn" class="btn btn-primary radius size-S">上传附件</a>
                                      </div>
                                      <ol id="attachment-content">
                                          <?php $n=1; if(is_array($info['attachment']['path'])) { foreach($info['attachment']['path'] as $k => $v) { ?>
                                          <li><span class="name"><?php echo $info['attachment']['name'][$k];?></span><input type="hidden" name="attachment[name][]" value="<?php echo $info['attachment']['name'][$k];?>"><input type="hidden" class="path" name="attachment[path][]" value="<?php echo $v;?>"><span class="del">删除</span></li>
                                          <?php $n++;}unset($n); } ?>
                                      </ol>
                                  </div>
                              </li>
                          </ul>
                      </div>
                      <div class="product-add-div" data-id="youhua">
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">优化标题：</span>
                                  <div class="item-bd">
                                      <input type="text" name="seotitle" id="seotitle" class="input-text w500" value="<?php echo $info['seotitle'];?>" >
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">Tag词：</span>
                                  <div class="item-bd">
                                      <input type="text" id="tagword" name="tagword" class="input-text w500" value="<?php echo $info['tagword'];?>" >
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">关键词：</span>
                                  <div class="item-bd">
                                      <input type="text" name="keyword" id="keyword" name="keyword" class="input-text w500" value="<?php echo $info['keyword'];?>">
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">页面描述：</span>
                                  <div class="item-bd">
                                      <textarea class="textarea w900"  name="description" id="description" cols="" rows=""><?php echo $info['description'];?></textarea>
                                  </div>
                              </li>
                          </ul>
                      </div>
                      <?php $contentArr=Common::getExtendContent(8,$extendinfo);?>
                      <?php echo $contentArr['contentHtml'];?>
                      <div class="product-add-div" data-id="extend" id="content_extend">
                          <?php echo $contentArr['extendHtml'];?>
                      </div>
                      <div class="clear clearfix pt-20 pb-20">
                          <input type="hidden" name="productid" id="productid" value="<?php echo $info['id'];?>"/>
                          <input type="hidden" name="action" id="action" value="<?php echo $action;?>"/>
                          <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                      </div>
                </form>
            </td>
        </tr>
    </table>
<script>
    var id='<?php echo $info['id'];?>';
$(document).ready(function(){
        $("#nav").find('span').click(function(){
            Product.changeTab(this,'.product-add-div');//导航切换
        })
        $("#nav").find('span').first().trigger('click');
        var action = "<?php echo $action;?>";
        $('.subnav li').click(function(){
            hideAll();
            $(this).attr('class','selected');
            var id=$(this).attr('data-id');
            $("#"+id).show();
        })
        //所需资料切换
        $(".subTitNav").find('li').click(function(){
            var id = $(this).attr('data-id');
            $(this).addClass('yes').siblings().removeClass('yes');
            $("#"+id).show().siblings('div').hide();
        })
        $('#pic_btn').click(function(){
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                if(result.data.length>0){
                    var len=result.data.length-1;
                    var temp =result.data[len].split('$$');
                    $("#litpic").val(temp[0]);
                    $("#visapic").attr('src',temp[0]);
                }
            }
        })
        //签证附件
        $('#attach_btn').click(function(){
            uploadFile();
        })
        $("#product_frm input").st_readyvalidate();
        //保存
        $("#btn_save").click(function(){
               var visaname = $("#title").val();
            //验证酒店名称
             if(visaname==''){
                   $("#nav").find('span').first().trigger('click');
                   $("#title").focus();
                   ST.Util.showMsg('请填写签证名称',5,2000);
               }
               else
               {
                   $.ajaxform({
                       url   :  SITEURL+"visa/admin/visa/ajax_save",
                       method  :  "POST",
                       form  : "#product_frm",
                       dataType  :  "JSON",
                       success  :  function(data)
                       {
                           if(data.status)
                           {
                               if(data.productid!=null){
                                   $("#productid").val(data.productid);
                               }
                               ST.Util.showMsg('保存成功!','4',2000);
                           }
                       }});
               }
        })
        //如果是修改页面
            var litpic = $("#litpic").val();
            $(".img-li").find('img').each(function(i,item){
                        if($(item).attr('src')==litpic){
                            var obj = $(item).parent().find('.btn-ste')[0];
                            Imageup.setHead(obj,i+1);
                        }
            })
     });
            function hideAll()
            {
                $('.subnav li').each(function(){
                    $(this).attr('class','');
                    var id=$(this).attr('data-id');
                    $("#"+id).hide();
                })
            }
            function getNation(id)
            {
                $.ajax(
                    {
                        type: "post",
                        data: {pid:id},
                        url: SITEURL+"visa/admin/visa/ajax_getnation/",
                        dataType:'json',
                        success: function(data,textStatus)
                        {
                            $("#nationid").empty();
                            $("#nationid").append("<option value='0'>请选择</option>");
                            $.each(data,function(i,v){
                                $("#nationid").append("<option value='"+ v.id+"'>"+ v.kindname+"</option>");
                            })
                        },
                        error: function()
                        {
                            ST.Util.showMsg("请求出错,请联系管理员",5,1000);
                        }
                    }
                );
            }
            //设置模板
            function setTemplet(obj)
            {
                var templet = $(obj).attr('data-value');
                $(obj).addClass('on').siblings().removeClass('on');
                $("#templet").val(templet);
            }
    //上传
    function uploadFile() {
        // 上传方法
        $.upload({
            // 上传地址
            url: SITEURL+'uploader/uploaddoc',
            // 文件域名字
            fileName: 'Filedata',
            fileType: 'doc,pdf,docx',
            // 其他表单数据
            params: {uploadcookie:"<?php echo Cookie::get('username')?>"},
            // 上传完成后, 返回json, text
            dataType: 'json',
            // 上传之前回调,return true表示可继续上传
            onSend: function() {
                return true;
            },
            // 上传之后回调
            onComplate: function(info) {
                if(info.status){
                    var html='<li><span class="name">'+info.name+'</span><input type="hidden" name="attachment[name][]" value="'+info.name+'"><input class="path" type="hidden" name="attachment[path][]" value="'+info.path+'"><span class="del">删除</span></li>';
                    $("#attachment-content").append(html);
                }
            }
        });
    }
            $("#attachment-content").find('.del').live('click',function(){
                var parent=$(this).parent();
                ST.Util.confirmBox('删除签证附件','确定删除吗?',function(){
                    $.post(SITEURL+'visa/admin/visa/ajax_del_doc/',{'file':parent.find('.path').val(),'id':id},function(rs){
                        if(rs.status){
                            parent.remove();
                        }
                    },'json');
                })
            });
            //删除附件
            function delDoc()
            {
                var data={};
                if(parseInt('<?php echo $info['id'];?>')>0){
                    data.id='<?php echo $info['id'];?>'
                }
                data.file=$("#attachment").val();
                $.ajax({
                    type:'POST',
                    url:SITEURL+'/visa/ajax_del_doc',
                    data:data,
                    dataType:'json',
                    success:function(data){
                        if(data.status){
                            $("#doclist").html('');
                            $("#attachment").val('');
                            ST.Util.showMsg('删除成功',4,1000);
                        };
                    }
                })
            }
    </script>
    <style>
        .subTitNav{
            padding:10px 0 0 10px;
            border-bottom:1px #d8d8d8 solid;
            zoom:1;
            overflow:hidden;
            margin-bottom:10px;
        }
        .subTitNav li{
            float:left;
            padding:0 10px;
            height:25px;
            line-height:25px;
            text-align:center;
            border:1px #d8d8d8 solid;
            border-width:1px 1px 0 1px;
            margin-right:10px;
            cursor:pointer;
        }
        .subTitNav li.yes{
            border:1px #d8d8d8 solid;
            border-width:1px 1px 0 1px;
            background:#f6f6f6;
            font-weight:bold; }
    </style>
</body>
</html>
