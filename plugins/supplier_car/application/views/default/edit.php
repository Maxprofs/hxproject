<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>添加车辆-{$webname}</title>
    {Common::css("style.css,base.css,style_hotel.css,base_hotel.css")}
    {Common::js("jquery.min.js,common.js,product.js,choose.js,imageup.js,st_validate.js")}
    {include "pub/public_js"}

</head>
<body>

	<div class="page-box">

     {request "pub/header"}
    
     {request "pub/sidemenu"}


    
    <div class="main">
    	<div class="content-box">
        
        <div class="frame-box">
          
          <div class="pt-manage-box">
          <div class="manage-nr">
          <div class="w-set-tit bom-arrow" id="nav">
              <span class="on" id="column_basic" onclick="Product.switchTab(this,'basic')">基础信息</span>

              {loop $columns $column}
              <span id="column_{$column['columnname']}" onclick="Product.switchTab(this,'{$column['columnname']}')">{$column['chinesename']}</span>
              {/loop}

              <span id="column_youhua" onclick="Product.switchTab(this,'youhua')">优化信息</span>
              <span id="column_extend" onclick="Product.switchTab(this,'extend')">扩展信息</span>
              <a href="javascript:;" class="refresh-btn" onclick="window.location.reload()">刷新</a>

          </div>
          <form id="product_fm">
          <div class="product-add-div" id="content_basic">
              <div class="add-class">
                  <dl>
                      <dt>站点：</dt>
                      <dd>
                          <select name="webid">
                              <option value="0" {if $info['webid']==0}selected="selected"{/if} >主站</option>
                              {loop $weblist $k}
                              <option value="{$k['webid']}" {if $info['webid']==$k['webid']}selected="selected"{/if} >{$k['webname']}</option>
                              {/loop}
                          </select>
                      </dd>
                  </dl>
                  <dl>
                      <dt>车辆名称：</dt>
                      <dd>
                          <input type="text" name="title" data-required="true" value="{$info['title']}" class="set-text-xh text_700 mt-2">
                          <div class="help-ico mt-9 ml-5"></div>
                          <input type="hidden" id="carid" name="carid" value="{$info['id']}">
                      </dd>
                  </dl>
                  <dl>
                      <dt>车辆卖点：</dt>
                      <dd>
                          <input type="text" name="sellpoint" value="{$info['sellpoint']}"  class="set-text-xh text_700 mt-2"/>

                          <div class="help-ico mt-9 ml-5"></div>
                      </dd>
                  </dl>
                  <dl>
                      <dt>车型：</dt>
                      <dd>
                          <select name="carkindid">

                              {loop $carkindidlist $k}
                              <option value="{$k['id']}" {if $info['carkindid']==$k['id']}selected="selected"{/if} >{$k['kindname']}</option>
                              {/loop}
                          </select>
                      </dd>
                  </dl>

                  <dl>
                      <dt>座位数：</dt>
                      <dd>
                          <input type="text" name="seatnum" data-regrex="number"  data-msg="必须为数字" value="{$info['seatnum']}" class="set-text-xh text_100 mt-2">
                      </dd>
                  </dl>
                  <dl>
                      <dt>建议乘客数：</dt>
                      <dd>
                          <input type="text" name="maxseatnum" value="{$info['maxseatnum']}" data-regrex="number"  data-msg="必须为数字" class="set-text-xh text_100 mt-2">
                      </dd>
                  </dl>
                  <dl>
                      <dt>使用年限：</dt>
                      <dd>
                          <input type="text" name="usedyears" data-regrex="number" value="{$info['usedyears']}"  data-msg="必须为数字" class="set-text-xh text_100 mt-2">
                      </dd>
                  </dl>
                  <dl>
                      <dt>咨询电话：</dt>
                      <dd>
                          <input type="text" name="phone" value="{$info['phone']}" class="set-text-xh text_100 mt-2">
                      </dd>
                  </dl>
              </div>

              <div class="add-class">

                  <dl>
                      <dt>目的地选择：</dt>
                      <dd>
                          <a href="javascript:;" class="choose-btn mt-4" onclick="Product.getDest(this,'.dest-sel',3)" title="选择">选择</a>
                          <div class="save-value-div mt-2 ml-10 dest-sel">
                              {loop $info['kindlist_arr'] $k $v}
                                       <span class="{if $info['finaldestid']==$v['id']}finaldest{/if}" title="{if $info['finaldestid']==$v['id']}最终目的地{/if}" ><s onclick="$(this).parent('span').remove()"></s>{$v['kindname']}<input type="hidden" class="lk" name="kindlist[]" value="{$v['id']}"/>
                                           {if $info['finaldestid']==$v['id']}<input type="hidden" class="fk" name="finaldestid" value="{$info['finaldestid']}"/>{/if}</span>
                              {/loop}
                          </div>
                      </dd>
                  </dl>

                  <dl>
                      <dt>车辆属性：</dt>
                      <dd>
                          <a href="javascript:;" class="choose-btn mt-4" onclick="Product.getAttrid(this,'.attr-sel',3)" title="选择">选择</a>
                          <div class="save-value-div mt-2 ml-10 attr-sel">
                              {loop $info['attrlist_arr'] $k $v}
                              <span><s onclick="$(this).parent('span').remove()"></s>{$v['attrname']}<input type="hidden" name="attrlist[]" value="{$v['id']}"></span>
                              {/loop}

                          </div>
                      </dd>
                  </dl>
                 <!-- <dl>
                      <dt>前台隐藏：</dt>
                      <dd>
                          <label>
                              <input class="fl mt-8 mr-3" type="radio" name="ishidden"  {if $info['ishidden']==0}checked="checked"{/if} value="0">
                              <span class="fl mr-20">显示</span>
                          </label>
                          <label>
                              <input class="fl mt-8 mr-3" type="radio" name="ishidden"  {if $info['ishidden']==1}checked="checked"{/if} value="1">
                              <span>隐藏</span>
                          </label>
                      </dd>
                  </dl>-->
                  <!--<dl>
                      <dt>显示模版：</dt>
                      <dd>
                          <div class="temp-chg" id="templet_list">
                              <a {if $info['templet']==''}class="on"{/if}  href="javascript:void(0)"  data-value="" onclick="setTemplet(this)">标准</a>
                              {loop $templetlist $r}
                              <a {if $info['templet']==$r['path']}class="on"{/if}  href="javascript:void(0)" data-value="{$r['path']}" onclick="setTemplet(this)">{$r['templetname']}</a>
                              {/loop}
                              <input type="hidden" name="templet" id="templet" value="{$info['templet']}"/>
                          </div>
                      </dd>
                  </dl>-->


              </div>



              <div class="add-class">
                  <dl>
                      <dt>图标设置：</dt>
                      <dd>
                          <a href="javascript:;" class="choose-btn mt-4"  onclick="Product.getIcon(this,'.icon-sel')"  title="选择">选择</a>
                          <div class="save-value-div mt-2 ml-10 icon-sel">

                              {loop $info['iconlist_arr'] $k $v}
                              <span><s onclick="$(this).parent('span').remove()"></s><img src="{$v['picurl']}"><input type="hidden" name="iconlist[]" value="{$v['id']}"></span>
                              {/loop}

                          </div>
                      </dd>
                  </dl>
                  <dl>
                      <dt>显示数据：</dt>
                      <dd>
                          <span class="fl">推荐次数</span>
                          <input type="text" name="recommendnum" value="{$info['recommendnum']}" data-regrex="number" data-msg="*必须为数字" class="set-text-xh text_60 mt-2 ml-10 mr-30">
                          <span class="fl" name="satisfyscore">满意度</span>
                          <input type="text" name="satisfyscore" class="set-text-xh text_60 mt-2 ml-10 mr-30" data-regrex="number" data-msg="*必须为数字" value="{$info['satisfyscore']}">
                          <span class="fl">销量</span>
                          <input type="text" name="bookcount" class="set-text-xh text_60 mt-2 ml-10" data-regrex="number" data-msg="*必须为数字" value="{$info['bookcount']}">
                      </dd>
                  </dl>
              </div>

          </div>
          <div class="product-add-div content-hide" id="content_content">
              <div class="add-class">
                  <dl>
                      <dt style="float:left">车辆介绍：</dt>
                      <dd style="float:left">

                          {Common::get_editor('content',$info['content'],700,400)}
                      </dd>
                  </dl>
              </div>
          </div>
          <div class="product-add-div content-hide" id="content_notice">
              <div class="add-class">
                  <dl>
                      <dt style="float:left">温馨提示：</dt>
                      <dd style="float:left">
                          {Common::get_editor('notice',$info['notice'],700,400)}
                      </dd>
                  </dl>
              </div>

          </div>
          <div class="product-add-div content-hide" id="content_tupian">

              <div class="up-pic">
                  <dl>
                      <dt>租车相册：</dt>
                      <dd>
                          <div class="up-file-div">
                              <div id="pic_btn" class="btn-file mt-4">上传图片</div>

                          </div>
                          <div class="up-file-div" style="width: 180px;">
                              <div class="mt-7" style="float: left;color: #999;">建议上传尺寸1024*695px</div>
                          </div>
                          <div class="up-list-div">
                              <ul class="pic-sel">
                              </ul>
                              <input id="litpic" type="hidden" value="{$info['litpic']}"/>
                              <input type="hidden" class="headimgindex" name="imgheadindex" value="<?php  echo $head_index;  ?>">
                          </div>
                      </dd>
                  </dl>


              </div>
          </div>
          <div class="product-add-div content-hide" id="content_youhua">
              <div class="add-class">
                  <dl>
                      <dt>优化标题：</dt>
                      <dd>
                          <input type="text" name="seotitle" id="seotitle" class="set-text-xh text_700 mt-2" value="{$info['seotitle']}" >
                      </dd>
                  </dl>
                  <dl>
                      <dt>Tag词：</dt>
                      <dd>

                          <input type="text" id="tagword" name="tagword" class="set-text-xh text_700 mt-2 " value="{$info['tagword']}" >
                      </dd>
                  </dl>
                  <dl>
                      <dt>关键词：</dt>
                      <dd>
                          <input type="text" name="keyword" id="keyword" name="keyword" class="set-text-xh text_700 mt-2" value="{$info['keyword']}">
                      </dd>
                  </dl>
                  <dl>
                      <dt>页面描述：</dt>
                      <dd style="height:auto">
                          <textarea class="set-area wid_695"  name="description" id="description" cols="" rows="">{$info['description']}</textarea>
                      </dd>
                  </dl>

              </div>
          </div>

          {php $contentArr=Common::get_extend_content($typeid,$extendinfo);}
          {php echo $contentArr['contentHtml'];}
          <div class="product-add-div" data-id="extend">
              {php echo $contentArr['extendHtml'];}
          </div>
          </form>
          <div class="opn-btn">
              <a class="normal-btn ml-20" id="save_btn" href="javascript:;">保存</a>
              <a class="next" href="javascript:;">下一步</a>
          </div>
          </div>
            
          </div>
            
        </div>
        
        {request "pub/footer"}
        
      </div>
    </div><!-- 主体内容 -->
  
  </div>

</body>

<script>
    $(function(){
        $("#nav_car_list").addClass('on');

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

            var validate=$("#product_fm input").st_govalidate({require:function(element,index){
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
                    data:$('#product_fm').serialize(),
                    dataType  :  "json",
                    success  :  function(data, opts)
                    {
                        if(data.status)
                        {
                            if(data.productid!=null){
                                $("#carid").val(data.productid);
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
        var action = "{$action}";
        if(action=='edit')
        {

            var piclist = ST.Modify.getUploadFile({$info['piclist_arr']});


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
