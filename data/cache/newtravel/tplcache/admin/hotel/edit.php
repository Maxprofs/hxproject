<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>酒店添加/修改</title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); ?>
    <?php echo Common::getScript('config.js');?>
    <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,choose.js,product_add.js,imageup.js,jquery.validate.js,st_validate.js"); ?>
    <?php echo Common::getCss('uploadify.css','js/uploadify/'); ?>
</head>
<body bottom_margin=Y3PzDt >
<table class="content-tab">
    <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
    <!--右侧内容区-->
    </td>
     <td valign="top" class="content-rt-td">
        <form method="post" name="product_frm" id="product_frm">
          <div class="manage-nr">
              <div class="cfg-header-bar" id="nav">
              <div class="cfg-header-tab">
              <span class="item on"><s></s>基础信息</span>
                 <!-- <span data-id="tupian"><s></s>酒店图片</span>
                  <span data-id="jieshao"><s></s>酒店介绍</span>
                  <span data-id="fuwu"><s></s>服务项目</span>
                  <span data-id="jiaotong"><s></s>交通指南</span>
                  <span data-id="zhoubian"><s></s>周边景点</span>
                  <span data-id="zhuyi"><s></s>注意事项</span>
                  
                  switchBack(this)
                 -->
                <?php $n=1; if(is_array($columns)) { foreach($columns as $column) { ?>
                <span class="item" data-id="<?php echo $column['columnname'];?>" onclick="" ><s></s><?php echo $column['chinesename'];?></span>
                <?php $n++;}unset($n); } ?>
                <span class="item" data-id="youhua"><s></s>优化设置</span>
                <span class="item" data-id="extend"><s></s>扩展设置</span>
              </div>
                
                <a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>
              </div>
               <!--基础信息开始-->
                <div class="product-add-div pb-20">
                <ul class="info-item-block">
                <li>
                <span class="item-hd">站点：</span>
                <div class="item-bd">
                <span class='select-box w100'>
                <select class="select" name="webid">
                                <option value="0" <?php if($info['webid']==0) { ?>selected="selected"<?php } ?>
>主站</option>
                                <?php $n=1; if(is_array($weblist)) { foreach($weblist as $k) { ?>
                                <option value="<?php echo $k['webid'];?>" <?php if($info['webid']==$k['webid']) { ?>selected="selected"<?php } ?>
 ><?php echo $k['webname'];?></option>
                                <?php $n++;}unset($n); } ?>
                              </select>
                </span>
                </div>
                </li>
                <li>
                <span class="item-hd">酒店名称<?php echo Common::get_help_icon('product_title');?>：</span>
                <div class="item-bd">
                <input type="text" name="title" id="hotelname" class="input-text w700"  value="<?php echo $info['title'];?>" />
                </div>
                </li>
                <li>
                <span class="item-hd">酒店卖点<?php echo Common::get_help_icon('product_sell_point');?>：</span>
                <div class="item-bd">
                <input type="text" name="sellpoint" value="<?php echo $info['sellpoint'];?>"  class="input-text w700"/>
                </div>
                </li>
                <li>
                <span class="item-hd">酒店地址<?php echo Common::get_help_icon('product_address');?>：</span>
                <div class="item-bd">
                <input type="text" name="address" id="address" class="input-text w700" value="<?php echo $info['address'];?>" />
                </div>
                </li>
                <li>
                <span class="item-hd">酒店坐标：</span>
                <div class="item-bd">
                <div>
                <span class="w60 item-text">经度(Lng):</span>
                                  <input type="text" name="lng" id="lng"  class="input-text ml-10 mr-30 w300" value="<?php echo $info['lng'];?>" />
                </div>
                <div class="mt-15">
                <span class="w60 item-text">纬度(Lat):</span>
                                  <input type="text" name="lat" id="lat" class="input-text ml-10 mr-10 w300" value="<?php echo $info['lat'];?>"  />
                                  <a href="javascript:;" class="btn btn-primary radius size-S" onclick="Product.Coordinates(700,500)"  title="选择">选择</a>
                </div>
                </div>
                </li>
                <li>
                <span class="item-hd">联系电话：</span>
                <div class="item-bd">
                <input type="text" name="telephone" id="telephone" class="input-text w250" value="<?php echo $info['telephone'];?>" />
                </div>
                </li>
                <li>
                <span class="item-hd">开业时间：</span>
                <div class="item-bd">
                <input type="text" name="opentime" id="opentime" class="input-text w250" value="<?php echo $info['opentime'];?>" />
                </div>
                </li>
                <li>
                <span class="item-hd">装修时间：</span>
                <div class="item-bd">
                <input type="text" name="decoratetime" id="decoratetime" class="input-text w250" value="<?php echo $info['decoratetime'];?>" />
                </div>
                </li>
                <li>
                <span class="item-hd">供应商：</span>
                <div class="item-bd">
                <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getSupplier(this,'.supplier-sel')" title="选择">选择</a>
                <div class="fl save-value-div ml-10 supplier-sel">
                                <?php if(!empty($info['supplier_arr']['id'])) { ?>
                                <span class="item-text mb-5"><s onclick="$(this).parent('span').remove()"></s><?php echo $info['supplier_arr']['suppliername'];?><input type="hidden" name="supplierlist[]" value="<?php echo $info['supplier_arr']['id'];?>"></span>
                                <?php } ?>
                              </div>
                </div>
                </li>
                </ul>
                <div class="line"></div>
                <ul class="info-item-block">
                <li>
                <span class="item-hd">目的地选择：</span>
                <div class="item-bd">
                <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getDest(this,'.dest-sel',2)" title="选择">选择</a>
                                <div class="fl save-value-div ml-10 dest-sel w700">
                                    <?php $n=1; if(is_array($info['kindlist_arr'])) { foreach($info['kindlist_arr'] as $k => $v) { ?>
                                    <span class="item-text mb-5 <?php if($info['finaldestid']==$v['id']) { ?>finaldest<?php } ?>
" title="<?php if($info['finaldestid']==$v['id']) { ?>最终目的地<?php } ?>
" ><s onclick="$(this).parent('span').remove()"></s><?php echo $v['kindname'];?><input type="hidden" class="lk" name="kindlist[]" value="<?php echo $v['id'];?>"/>
                                           <?php if($info['finaldestid']==$v['id']) { ?><input type="hidden" class="fk" name="finaldestid" value="<?php echo $info['finaldestid'];?>"/><?php } ?>
</span>
                                    <?php $n++;}unset($n); } ?>
                                </div>
                </div>
                </li>
                <li>
                <span class="item-hd">酒店属性：</span>
                <div class="item-bd">
                <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getAttrid(this,'.attr-sel',2)" title="选择">选择</a>
                                <div class="fl save-value-div ml-10 attr-sel w700">
                                <?php $n=1; if(is_array($info['attrlist_arr'])) { foreach($info['attrlist_arr'] as $k => $v) { ?>
                                <span class="item-text mb-5"><s onclick="$(this).parent('span').remove()"></s><?php echo $v['attrname'];?><input type="hidden" name="attrlist[]" value="<?php echo $v['id'];?>"></span>
                                <?php $n++;}unset($n); } ?>
                                </div>
                </div>
                </li>
                <li>
                <span class="item-hd">星级：</span>
                <div class="item-bd">
                <span class='select-box w100'>
                <select class="select" name="hotelrankid">
                                    <?php $n=1; if(is_array($ranklist)) { foreach($ranklist as $k) { ?>
                                    <option value="<?php echo $k['id'];?>" <?php if($info['hotelrankid']==$k['id']) { ?>selected="selected"<?php } ?>
 ><?php echo $k['hotelrank'];?></option>
                                    <?php $n++;}unset($n); } ?>
                                    </select>
                </span>
                </div>
                </li>
                </ul>
                    <div class="line"></div>
                    <ul class="info-item-block">
                    <li>
                    <span class="item-hd">图标设置：</span>
                    <div class="item-bd">
                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getIcon(this,'.icon-sel')" title="选择">选择</a>
                                <div class="fl save-value-div ml-10 icon-sel w700">
                                    <?php $n=1; if(is_array($info['iconlist_arr'])) { foreach($info['iconlist_arr'] as $k => $v) { ?>
                                    <span class="item-text mb-5"><s onclick="$(this).parent('span').remove()"></s><img src="<?php echo $v['picurl'];?>"><input type="hidden" name="iconlist[]" value="<?php echo $v['id'];?>"></span>
                                    <?php $n++;}unset($n); } ?>
                                </div>
                    </div>
                    </li>
                    <li>
                    <span class="item-hd">前台隐藏：</span>
                    <div class="item-bd">
                    <label class="radio-label mr-20"><input type="radio" name="ishidden"  <?php if($info['ishidden']==0) { ?>checked="checked"<?php } ?>
 value="0">显示</label>
                    <label class="radio-label"><input type="radio" name="ishidden"  <?php if($info['ishidden']==1) { ?>checked="checked"<?php } ?>
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
                    <li>
                    <span class="item-hd">显示数据：</span>
                    <div class="item-bd">
                    <span class="item-text">推荐次数</span>
                                  <input type="text" name="recommendnum" id="yesjian" data-regrex="number" data-msg="*必须为数字"  class="input-text  ml-10 mr-30 w60" value="<?php echo $info['recommendnum'];?>" />
                                  <span class="item-text">满意度</span>
                                  <input type="text" name="satisfyscore" id="satisfyscore" data-regrex="number" data-msg="*必须为数字" class="input-text  ml-10 mr-30 w60" value="<?php echo $info['satisfyscore'];?>"  />
                                  <span class="item-text">销量</span>
                                  <input type="text" name="bookcount" id="bookcount" data-regrex="number" data-msg="*必须为数字" class="input-text  ml-10 w60" value="<?php echo $info['bookcount'];?>" />
                    </div>
                    </li>
                    </ul>  
<div class="line"></div>
<ul class="info-item-block">
<li>
<span class="item-hd">预订送积分策略：</span>
<div class="item-bd">
<a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getJifenbook(this,'.jifenbook-sel',2)" title="选择">选择</a>
                                <div class="fl save-value-div ml-10 jifenbook-sel">
                                    <?php if(!empty($info['jifenbook_info'])) { ?>
                                    <span class="item-text"><s onclick="$(this).parent('span').remove()"></s><?php echo $info['jifenbook_info']['title'];?>(<?php echo $info['jifenbook_info']['value'];?><?php if($info['jifenbook_info']['rewardway']==1) { ?>%<?php } ?>
积分)
                                        <?php if($info['jifenbook_info']['isopen']==0) { ?><a class="cor_f00">[已关闭]</a><?php } ?>
<input type="hidden" name="jifenbook_id" value="<?php echo $info['jifenbook_info']['id'];?>">
                                    </span>
                                    <?php } ?>
                                </div>
                                <span class="item-text ml-10 c-999">*未选择的情况下默认使用全局策略</span>
</div>
</li>
<li>
<span class="item-hd">积分抵现策略：</span>
                           <div class="item-bd">
                              <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getJifentprice(this,'.jifentprice-sel',2)" title="选择">选择</a>
                              <div class="save-value-div mt-2 ml-10 jifentprice-sel">
                                  <?php if(!empty($info['jifentprice_info'])) { ?>
                                <span><s onclick="$(this).parent('span').remove()"></s><?php echo $info['jifentprice_info']['title'];?>(<?php echo $info['jifentprice_info']['toplimit'];?>积分)
                                    <?php if($info['jifentprice_info']['isopen']==0) { ?><a class="cor_f00">[已关闭]</a><?php } ?>
<input type="hidden" name="jifentprice_id" value="<?php echo $info['jifentprice_info']['id'];?>">
                                </span>
                                  <?php } ?>
                              </div>
                              <span class="item-text ml-10 c-999">*未选择的情况下默认使用全局策略</span>
</div>

</li>
</ul>
<div class="line"></div>
               </div>
                  
              <!--/基础信息结束-->
                <!--酒店图片开始-->
                <div class="product-add-div pb-20" data-id="tupian">
                  <ul class="info-item-block">
                  <li>
                  <span class="item-hd">酒店图片：</span>
                  <div class="item-bd">
                  <div>
                  <div id="pic_btn" class="btn btn-primary radius size-S mt-3">上传图片</div>
                  <span class="item-text c-999 ml-10">建议上传尺寸1024*695px</span>
                  </div>
                  <div class="up-list-div">
                                    <input type="hidden" class="headimgindex" name="imgheadindex" value=""/>
                                    <input type="hidden" name="litpic" id="litpic" value="<?php echo $info['litpic'];?>"/>
                                    <ul class="clearfix">
<?php
                                        $pic_arr = explode(',', $info['piclist']);
                                        $litpic_arr = explode('||', $info['litpic']);
                                        $img_index = 1;
                                        $head_index = 0;
                                        foreach ($pic_arr as $k => $v) {
                                            if (empty($v))
                                                continue;
                                            $imginfo_arr = explode('||', $v);
                                            $headpic_style = $imginfo_arr[0] == $litpic_arr[0] ? 'style="display: block; background: green;"' : '';
                                            $head_index = $imginfo_arr[0] == $litpic_arr[0] ? $img_index : $head_index;
                                            $headpic_hint = $imginfo_arr[0] == $litpic_arr[0] ? '已设为封面' : '设为封面';
                                            $html = '<li class="img-li">';
                                            $html .= '<div class="pic"><img class="fl" src="' . $imginfo_arr[0] . '" /></div>';
                                            $html .= '<p class="p1">';
                                            $html .= '<input type="text" class="img-name" name="imagestitle[' . $img_index . ']" value="' . $imginfo_arr[1] . '">';
                                            $html .= '<input type="hidden" class="img-path" name="images[' . $img_index . ']" value="' . $imginfo_arr[0] . '">';
                                            $html.='</p>';
                                            $html.='<p class="p2">';
                                            $html.='<span class="btn-ste" onclick="Imageup.setHead(this,' . $img_index . ')" ' . $headpic_style . '>' . $headpic_hint . '</span><span class="btn-closed" onclick="Imageup.delImg(this,\'' . $imginfo_arr[0] . '\',' . $img_index . ')"></span>';
                                            $html.='</p></li>';
                                            echo $html;
                                            $img_index++;
                                        }
                                        echo '<script> window.image_index=' . $img_index . ';</script>';
                                        ?>
                                    </ul>
                                    <input type="hidden" class="headimgindex" name="imgheadindex" value="<?php  echo $head_index;  ?>">
                                </div>
                  </div>
                  </li>
                  </ul>
                  <div class="line"></div>   
                </div>
                <!--酒店图片结束-->
                <div class="product-add-div" data-id="content">
                <ul class="info-item-block">
                <li>
                <span class="item-hd item-id"></span>
                <div class="item-bd">
                <?php Common::getEditor('jieshao',$info['content'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                </div>
                </li>
                </ul>
                </div>
                <div class="product-add-div" data-id="fuwu">
                <ul class="info-item-block">
                <li>
                <span class="item-hd item-id"></span>
                <div class="item-bd">
                <?php Common::getEditor('fuwu',$info['fuwu'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                </div>
                </li>
                </ul>  
                </div>
                <div class="product-add-div" data-id="traffic">
                <ul class="info-item-block">
                <li>
                <span class="item-hd item-id"></span>
                <div class="item-bd">
                <?php Common::getEditor('jiaotong',$info['traffic'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                </div>
                </li>
                </ul>    
                </div>
                <div class="product-add-div" data-id="aroundspots">
                <ul class="info-item-block">
                <li>
                <span class="item-hd item-id"></span>
                <div class="item-bd">
                <?php Common::getEditor('zhoubian',$info['aroundspots'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                </div>
                </li>
                </ul>     
                </div>
                <div class="product-add-div" data-id="notice">
                <ul class="info-item-block">
                <li>
                <span class="item-hd item-id"></span>
                <div class="item-bd">
                <?php Common::getEditor('zhuyi',$info['notice'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                </div>
                </li>
                </ul>     
                </div>
                <div class="product-add-div pd-20" data-id="equipment">
                <ul class="info-item-block">
                <li>
                <span class="item-hd item-id"></span>
                <div class="item-bd">
                <?php Common::getEditor('fujian',$info['equipment'],$sysconfig['cfg_admin_htmleditor_width'],400);?>
                </div>
                </li>
                </ul>      
                </div>
                <div class="product-add-div" data-id="youhua">
                <ul class="info-item-block">
                <li>
                <span class="item-hd">优化标题<?php echo Common::get_help_icon('content_seotitle');?>：</span>
                <div class="item-bd">
                <input type="text" name="seotitle" id="seotitle" class="input-text w700" value="<?php echo $info['seotitle'];?>" >
                </div>
                </li>
                <li>
                <span class="item-hd">Tag词<?php echo Common::get_help_icon('content_tagword');?>：</span>
                <div class="item-bd">
                <input type="text" id="tagword" name="tagword" class="input-text w700" value="<?php echo $info['tagword'];?>" >
                </div>
                </li>
                <li>
                <span class="item-hd">关键词<?php echo Common::get_help_icon('content_keyword');?>：</span>
                <div class="item-bd">
                <input type="text" name="keyword" id="keyword" name="keyword" class="input-text w700" value="<?php echo $info['keyword'];?>">
                </div>
                </li>
                <li>
                <span class="item-hd">页面描述<?php echo Common::get_help_icon('content_description');?>：</span>
                <div class="item-bd">
                <textarea class="textarea w700"  name="description" id="description" cols="" rows=""><?php echo $info['description'];?></textarea>
                </div>
                </li>
                </ul>
                </div>
                <?php $contentArr=Common::getExtendContent(2,$extendinfo);?>
                <?php echo $contentArr['contentHtml'];?>
                <div class="product-add-div pb-20" data-id="extend">
                    <?php echo $contentArr['extendHtml'];?>
                </div>   
                <div class="fl clearfix pb-20">
                <input type="hidden" name="productid" id="productid" value="<?php echo $info['id'];?>"/>
                    <input type="hidden" name="action" id="action" value="<?php echo $action;?>"/>
                    <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
              </div>
          </div>
        </form>
    </td>
    </tr>
    </table>
  
<script>
        //保存状态
        window.is_saving = 0;
$(document).ready(function(){
        $("#nav").find('span').click(function(){
            Product.changeTab(this,'.product-add-div');//导航切换
            
            var $dom = $('.product-add-div[data-id='+$(this).data('id')+'] .item-id');
            if($dom.length == 1){
            $dom.text($(this).text() + '：');
            }
        })
        $("#nav").find('span').first().trigger('click');
        var action = "<?php echo $action;?>";
        $('#pic_btn').click(function(){
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                var len=result.data.length;
                for(var i=0;i<len;i++){
                    var temp =result.data[i].split('$$');
                    Imageup.genePic(temp[0],".up-list-div ul",".cover-div",temp[1]);
                }
            }
        })
        $("#product_frm input").st_readyvalidate();
        //保存
        $("#btn_save").click(function(){
            //检测是否是在保存状态
            if(is_saving == 1){
                return false;
            }
            window.is_saving = 1;
               var hotelname = $("#hotelname").val();
            //验证酒店名称
             if(hotelname==''){
                   $("#nav").find('span').first().trigger('click');
                   $("#hotelname").focus();
                   ST.Util.showMsg('请填写酒店名称',5,2000);
               }
               else
               {
                   $.ajaxform({
                       url   :  SITEURL+"hotel/admin/hotel/ajax_save",
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
                           window.is_saving = 0;
                       }});
               }
        })
        
     });
    //设置模板
    function setTemplet(obj)
    {
        var templet = $(obj).attr('data-value');
        $(obj).addClass('on').siblings().removeClass('on');
        $("#templet").val(templet);
    }
    </script>
</body>
</html>
