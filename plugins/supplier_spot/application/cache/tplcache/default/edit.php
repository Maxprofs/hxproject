<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>添加/修改景点-<?php echo $webname;?></title>
    <?php echo Common::css("style.css,base.css,style_hotel.css,base_hotel.css");?>
    <?php echo Common::js("jquery.min.js,common.js,product.js,choose.js,imageup.js,st_validate.js");?>
    <?php echo  Stourweb_View::template("pub/public_js");  ?>
</head>
<body>
<div class="page-box">
     <?php echo Request::factory("pub/header")->execute()->body(); ?>
    
     <?php echo Request::factory("pub/sidemenu")->execute()->body(); ?>
    
    <div class="main">
    <div class="content-box">
        
        <div class="frame-box">
          
          <div class="pt-manage-box">
          <div class="manage-nr">
          <form method="post" name="product_frm" id="product_frm">
          <div class="manage-nr">
          <div class="w-set-tit bom-arrow" id="nav">
              <span class="on" onclick="Product.switchTab(this,'basic')"><s></s>基础信息</span>
              <?php $n=1; if(is_array($columns)) { foreach($columns as $column) { ?>
              <span id="column_<?php echo $column['columnname'];?>" onclick="Product.switchTab(this,'<?php echo $column['columnname'];?>')"><?php echo $column['chinesename'];?></span>
              <?php $n++;}unset($n); } ?>
              <span data-id="youhua" onclick="Product.switchTab(this,'youhua')"><s></s>优化设置</span>
              <span data-id="extend" onclick="Product.switchTab(this,'extend')"><s></s>扩展设置</span>
              <a href="javascript:;" class="refresh-btn" onclick="window.location.reload()">刷新</a>
          </div>
          <!--基础信息开始-->
          <div class="product-add-div" id="content_basic">
              <div class="add-class">
                  <dl>
                      <dt>站点：</dt>
                      <dd>
                          <select name="webid">
                              <option value="0" <?php if($info['webid']==0) { ?>selected="selected"<?php } ?>
>主站</option>
                              <?php $n=1; if(is_array($weblist)) { foreach($weblist as $k) { ?>
                              <option value="<?php echo $k['webid'];?>" <?php if($info['webid']==$k['webid']) { ?>selected="selected"<?php } ?>
 ><?php echo $k['webname'];?></option>
                              <?php $n++;}unset($n); } ?>
                          </select>
                      </dd>
                  </dl>
                  <dl>
                      <dt>景点名称：</dt>
                      <dd>
                          <input type="text" name="title" id="spotname" data-required="true" class="set-text-xh text_700 mt-2 w300"  value="<?php echo $info['title'];?>" />
                      </dd>
                  </dl>
                  <dl>
                      <dt>景点简称：</dt>
                      <dd>
                          <input type="text" name="shortname" id="shortname" class="set-text-xh text_700 mt-2" value="<?php echo $info['shortname'];?>" />
                      </dd>
                  </dl>
                  <dl>
                      <dt>景点卖点：</dt>
                      <dd>
                          <input type="sellpoint" name="sellpoint" id="sellpoint" class="set-text-xh text_250 mt-2 text_700" value="<?php echo $info['sellpoint'];?>" />
                      </dd>
                  </dl>
                  <dl>
                      <dt>景点地址：</dt>
                      <dd>
                          <input type="text" name="address" id="address" class="set-text-xh text_700 mt-2 w300" value="<?php echo $info['address'];?>" />
                      </dd>
                  </dl>
                  <dl>
                      <dt>景点坐标：</dt>
                      <dd>
                          <span class="fl">经度(Lng):</span>
                          <input type="text" name="lng" id="lng"  class="set-text-xh text_150 mt-2 ml-10 mr-30 w300" value="<?php echo $info['lng'];?>" />
                          <span class="fl">纬度(Lat):</span>
                          <input type="text" name="lat" id="lat" class="set-text-xh text_150 mt-2 ml-10 mr-30 w300" value="<?php echo $info['lat'];?>"  />
                          <a href="javascript:;" class="choose-btn mt-4" onclick="Product.Coordinates(700,500)"  title="选择">选择</a>
                      </dd>
                  </dl>
                  <dl>
                      <dt>查看人数：</dt>
                      <dd>
                          <input type="text" name="shownum" id="shownum" class="set-text-xh text_250 mt-2 w50" value="<?php echo $info['shownum'];?>" />
                      </dd>
                  </dl>
                  <dl>
                      <dt>景点编辑：</dt>
                      <dd>
                          <input type="text" name="author" id="author" class="set-text-xh text_250 mt-2" value="<?php echo $info['author'];?>" />
                      </dd>
                  </dl>
                  <dl>
                      <dt>取票方式：</dt>
                      <dd>
                          <input type="text" name="getway" id="getway" class="set-text-xh text_250 mt-2" value="<?php echo $info['getway'];?>" />
                      </dd>
                  </dl>
              </div>
              <div class="add-class">
                  <dl>
                      <dt>目的地选择：</dt>
                      <dd>
                          <a href="javascript:;" class="choose-btn mt-4" onclick="Product.getDest(this,'.dest-sel',<?php echo $typeid;?>)"  title="选择">选择</a>
                          <div class="save-value-div mt-2 ml-10 dest-sel">
                              <?php $n=1; if(is_array($info['kindlist_arr'])) { foreach($info['kindlist_arr'] as $k => $v) { ?>
                                       <span class="<?php if($info['finaldestid']==$v['id']) { ?>finaldest<?php } ?>
" title="<?php if($info['finaldestid']==$v['id']) { ?>最终目的地<?php } ?>
" ><s onclick="$(this).parent('span').remove()"></s><?php echo $v['kindname'];?><input type="hidden" class="lk" name="kindlist[]" value="<?php echo $v['id'];?>"/>
                                           <?php if($info['finaldestid']==$v['id']) { ?><input type="hidden" class="fk" name="finaldestid" value="<?php echo $info['finaldestid'];?>"/><?php } ?>
</span>
                              <?php $n++;}unset($n); } ?>
                          </div>
                      </dd>
                  </dl>
                  <dl>
                      <dt>景点属性：</dt>
                      <dd>
                          <a href="javascript:;" class="choose-btn mt-4"onclick="Product.getAttrid(this,'.attr-sel',<?php echo $typeid;?>)"  title="选择">选择</a>
                          <div class="save-value-div mt-2 ml-10 attr-sel">
                              <?php $n=1; if(is_array($info['attrlist_arr'])) { foreach($info['attrlist_arr'] as $k => $v) { ?>
                              <span><s onclick="$(this).parent('span').remove()"></s><?php echo $v['attrname'];?><input type="hidden" name="attrlist[]" value="<?php echo $v['id'];?>"></span>
                              <?php $n++;}unset($n); } ?>
                          </div>
                      </dd>
                  </dl>
              </div>
              <div class="add-class">
                  <!-- <dl>
                       <dt>显示模版：</dt>
                       <dd>
                       </dd>
                   </dl>-->
                  <dl>
                      <dt>图标设置：</dt>
                      <dd>
                          <a href="javascript:;" class="choose-btn mt-4" onclick="Product.getIcon(this,'.icon-sel')"  title="选择">选择</a>
                          <div class="save-value-div mt-2 ml-10 icon-sel">
                              <?php $n=1; if(is_array($info['iconlist_arr'])) { foreach($info['iconlist_arr'] as $k => $v) { ?>
                              <span><s onclick="$(this).parent('span').remove()"></s><img src="<?php echo $v['picurl'];?>"><input type="hidden" name="iconlist[]" value="<?php echo $v['id'];?>"></span>';
                              <?php $n++;}unset($n); } ?>
                          </div>
                      </dd>
                  </dl>
                  <dl>
                      <dt>显示数据：</dt>
                      <dd>
                          <span class="fl">推荐次数</span>
                          <input type="text" name="recommendnum" id="yesjian" data-regrex="number" data-msg="*必须为数字" class="set-text-xh text_60 mt-2 ml-10 mr-30 w50" value="<?php echo $info['recommendnum'];?>" />
                          <span class="fl">满意度</span>
                          <input type="text" name="satisfyscore" id="satisfyscore" data-regrex="number" data-msg="*必须为数字" class="set-text-xh text_60 mt-2 ml-10 mr-30 w50" value="<?php echo $info['satisfyscore'];?>"  />
                          <span class="fl">销量</span>
                          <input type="text" name="bookcount" id="bookcount" data-regrex="number" data-msg="*必须为数字" class="set-text-xh text_60 mt-2 ml-10 w50" value="<?php echo $info['bookcount'];?>" />
                      </dd>
                  </dl>
              </div>
          </div>
          <!--/基础信息结束-->
          <!--图片开始-->
          <div class="product-add-div content-hide" id="content_tupian">
              <div class="up-pic">
                  <dl>
                      <dt>景点图片：</dt>
                      <dd>
                          <div class="up-file-div">
                              <div id="pic_btn" class="btn-file mt-4">上传图片</div>
                          </div>
                          <div class="up-list-div">
                              <input type="hidden" class="headimgindex" name="imgheadindex" value=""/>
                              <input type="hidden" name="litpic" id="litpic" value="<?php echo $info['litpic'];?>"/>
                              <ul class="pic-sel">
                              </ul>
                          </div>
                      </dd>
                  </dl>
              </div>
          </div>
          <!--图片结束-->
          <div class="product-add-div content-hide" id="content_content">
              <?php echo Common::get_editor('content',$info['content'],700,400);?>
          </div>
          <div class="product-add-div content-hide" id="content_booknotice">
              <?php echo Common::get_editor('booknotice',$info['booknotice'],700,400);?>
          </div>
          <div class="product-add-div content-hide" id="content_youhua">
              <div class="add-class">
                  <dl>
                      <dt>优化标题：</dt>
                      <dd>
                          <input type="text" name="seotitle" id="seotitle" class="set-text-xh text_700 mt-2 w500" value="<?php echo $info['seotitle'];?>" >
                      </dd>
                  </dl>
                  <dl>
                      <dt>Tag词：</dt>
                      <dd>
                          <input type="text" id="tagword" name="tagword" class="set-text-xh text_700 mt-2" value="<?php echo $info['tagword'];?>" >
                      </dd>
                  </dl>
                  <dl>
                      <dt>关键词：</dt>
                      <dd>
                          <input type="text" name="keyword" id="keyword" name="keyword" class="set-text-xh text_700 mt-2 w300" value="<?php echo $info['keyword'];?>">
                      </dd>
                  </dl>
                  <dl>
                      <dt>页面描述：</dt>
                      <dd style="height:auto">
                          <textarea class="set-area wid_695"  name="description" id="description" cols="" rows=""><?php echo $info['description'];?></textarea>
                      </dd>
                  </dl>
              </div>
          </div>
          <?php $contentArr=Common::get_extend_content(5,$extendinfo);?>
          <?php echo $contentArr['contentHtml'];?>
          <div class="product-add-div content-hide" data-id="extend" id="content_extend">
              <?php echo $contentArr['extendHtml'];?>
          </div>
          <div class="opn-btn">
              <input type="hidden" name="productid" id="productid" value="<?php echo $info['id'];?>"/>
              <input type="hidden" name="action" id="action" value="<?php echo $action;?>"/>
              <a class="normal-btn ml-20" id="save_btn" href="javascript:;">保存</a>
          </div>
          </div>
          </form>
          </div>
            
          </div>
            
        </div>
        
        <?php echo Request::factory("pub/footer")->execute()->body(); ?>
        
      </div>
    </div><!-- 主体内容 -->
  
  </div>
</body>
<script>
    $(function(){
        $("#nav_spot_list").addClass('on');
        $("#nav").find('span').first().trigger('click');
        //图片上传
        $('#pic_btn').click(function(){
            ST.Util.showBox('上传图片', BASEHOST + '/plugins/upload_image/image/insert_view', 430,340, null, null, document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                var len=result.data.length;
                for(var i=0;i<len;i++){
                    var temp =result.data[i].split('$$');
                    Imageup.genePic(temp[0],".up-list-div ul",".cover-div");
                }
            }
        })
        //提交保存
        //保存
        $("#save_btn").click(function(){
            var validate=$("#product_frm input").st_govalidate({require:function(element,index){
                $(element).css("border","1px solid red");
                if(index==1)
                {
                    var switchDiv=$(element).parents(".product-add-div").first();
                    if(switchDiv.is(":hidden")&&!switchId)
                    {
                        var switchId=switchDiv.attr('id');
                        var columnId=switchId.replace('content','column');
                        $("#"+columnId).trigger('click');
                    }
                }
            }});
            if(validate==true)
            {
                $.ajax({
                    type:'POST',
                    url   :  SITEURL+"index/ajax_save",
                    data:$('#product_frm').serialize(),
                    dataType  :  "json",
                    success  :  function(data, opts)
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
            else
            {
                ST.Util.showMsg("请将信息填写完整",1,1200);
            }
        })
        var action = "<?php echo $action;?>";
        if(action=='edit')
        {
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
        }
    })
</script>
</html>
