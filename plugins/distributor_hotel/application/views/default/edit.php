<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>酒店管理-{$webname}</title>
    {Common::css("style.css,base.css,style_hotel.css,base_hotel.css")}
    {Common::js("jquery.min.js,common.js,product.js,choose.js,imageup.js")}
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
          <form method="post" name="product_frm" id="product_frm">
          <div class="manage-nr">
          <div class="w-set-tit bom-arrow" id="nav">
              <span class="on">基础信息</span>

              {loop $columns $column}
                <span data-id="{$column['columnname']}"><s></s>{$column['chinesename']}</span>
              {/loop}
              <span data-id="youhua"><s></s>优化设置</span>
              <span data-id="extend"><s></s>扩展设置</span>
              <a href="javascript:;" class="refresh-btn" onclick="window.location.reload()">刷新</a>
          </div>

          <!--基础信息开始-->
          <div class="product-add-div">
              <div class="add-class">
                  <dl>
                      <dt>站点：</dt>
                      <dd>

                          <select name="webid">
                              <option value="0" {if $info['webid']==0}selected="selected"{/if}>主站</option>
                              {loop $weblist $k}
                              <option value="{$k['webid']}" {if $info['webid']==$k['webid']}selected="selected"{/if} >{$k['webname']}</option>
                              {/loop}

                          </select>

                      </dd>
                  </dl>

                  <dl>
                      <dt>酒店名称：</dt>
                      <dd>
                          <input type="text" name="title" id="hotelname" class="set-text-xh text_700 mt-2"  value="{$info['title']}" />

                      </dd>
                  </dl>
                  <dl>
                      <dt>酒店卖点：</dt>
                      <dd>
                          <input type="text" name="sellpoint" value="{$info['sellpoint']}"  class="set-text-xh text_700 mt-2"/>


                      </dd>
                  </dl>
                  <dl>
                      <dt>酒店地址：</dt>
                      <dd>
                          <input type="text" name="address" id="address" class="set-text-xh text_700 mt-2" value="{$info['address']}" />

                      </dd>
                  </dl>
                  <dl>
                      <dt>酒店坐标：</dt>
                      <dd>
                          <span class="fl">经度(Lng):</span>
                          <input type="text" name="lng" id="lng"  class="set-text-xh text_150 mt-2 ml-10 mr-30 w300" value="{$info['lng']}" />
                          <span class="fl">纬度(Lat):</span>
                          <input type="text" name="lat" id="lat" class="set-text-xh text_150 mt-2 ml-10 mr-30 w300" value="{$info['lat']}"  />
                          <a href="javascript:;" class="choose-btn mt-4" onclick="Product.Coordinates(700,500)"  title="选择">选择</a>
                      </dd>

                  </dl>
                  <dl>
                      <dt>联系电话：</dt>
                      <dd>
                          <input type="text" name="telephone" id="telephone" class="set-text-xh text_250 mt-2" value="{$info['telephone']}" />
                      </dd>
                  </dl>
                  <dl>
                      <dt>开业时间：</dt>
                      <dd>
                          <input type="text" name="opentime" id="opentime" class="set-text-xh text_250 mt-2" value="{$info['opentime']}" />
                      </dd>
                  </dl>
                  <dl>
                      <dt>装修时间：</dt>
                      <dd>
                          <input type="text" name="decoratetime" id="decoratetime" class="set-text-xh text_250 mt-2" value="{$info['decoratetime']}" />
                      </dd>
                  </dl>
                  <!--<dl>
                      <dt>供应商：</dt>
                      <dd>
                          <a href="javascript:;" class="choose-btn mt-4" onclick="Product.getSupplier(this,'.distributor-sel')" title="选择">选择</a>
                          <div class="save-value-div mt-2 ml-10 distributor-sel">
                              {if !empty($info['distributor_arr']['distributorname'])}
                              <span><s onclick="$(this).parent('span').remove()"></s>{$info['distributor_arr']['distributorname']}<input type="hidden" name="distributorlist[]" value="{$info['distributor_arr']['id']}"></span>
                              {/if}
                          </div>
                      </dd>
                  </dl>-->
              </div>

              <div class="add-class">
                  <dl>
                      <dt>目的地：</dt>
                      <dd>
                          <a href="javascript:;" class="choose-btn mt-4" onclick="Product.getDest(this,'.dest-sel',2)" title="选择">选择</a>
                          <div class="save-value-div mt-2 ml-10 dest-sel">
                              {loop $info['kindlist_arr'] $k $v}

                                       <span class="{if $info['finaldestid']==$v['id']}finaldest{/if}" title="{if $info['finaldestid']==$v['id']}最终目的地{/if}" ><s onclick="$(this).parent('span').remove()"></s>{$v['kindname']}<input type="hidden" class="lk" name="kindlist[]" value="{$v['id']}"/>
                                           {if $info['finaldestid']==$v['id']}<input type="hidden" class="fk" name="finaldestid" value="{$info['finaldestid']}"/>{/if}</span>
                              {/loop}

                                           <input type="hidden" class="fk" name="finaldestid" value="36"></span>
                          </div>
                      </dd>
                  </dl>
                  <dl>
                      <dt>属性：</dt>
                      <dd>
                          <a href="javascript:;" class="choose-btn mt-4" onclick="Product.getAttrid(this,'.attr-sel',2)" title="选择">选择</a>
                          <div class="save-value-div mt-2 ml-10 attr-sel">
                              {loop $info['attrlist_arr'] $k $v}
                              <span><s onclick="$(this).parent('span').remove()"></s>{$v['attrname']}<input type="hidden" name="attrlist[]" value="{$v['id']}"></span>
                              {/loop}

                          </div>
                      </dd>
                  </dl>
                  <dl>
                      <dt>星级：</dt>
                      <dd>

                          <select name="hotelrankid">

                              {loop $ranklist $k}
                              <option value="{$k['id']}" {if $info['hotelrankid']==$k['id']}selected="selected"{/if} >{$k['hotelrank']}</option>
                              {/loop}

                          </select>

                      </dd>
                  </dl>


              </div>

              <div class="add-class">
                  <dl>
                      <dt>图标设置：</dt>
                      <dd>
                          <a href="javascript:;" class="choose-btn mt-4" onclick="Product.getIcon(this,'.icon-sel')" title="选择">选择</a>
                          <div class="save-value-div mt-2 ml-10 icon-sel">

                              {loop $info['iconlist_arr'] $k $v}
                              <span><s onclick="$(this).parent('span').remove()"></s><img src="{$v['picurl']}"><input type="hidden" name="iconlist[]" value="{$v['id']}"></span>
                              {/loop}

                          </div>
                      </dd>
                  </dl>

               <!--   <dl>
                      <dt>显示模版：</dt>
                      <dd>
                          <div class="temp-chg" id="templet_list">
                              <a {if $info['templet']==''}class="on"{/if}  href="javascript:void(0)"  data-value="" onclick="setTemplet(this)">标准</a>

                              <input type="hidden" name="templet" id="templet" value="{$info['templet']}"/>
                          </div>
                      </dd>
                  </dl>-->
                  <dl>
                      <dt>显示数据：</dt>
                      <dd>
                          <span class="fl">推荐次数</span>
                          <input type="text" name="recommendnum" id="yesjian" data-regrex="number" data-msg="*必须为数字"  class="set-text-xh text_60 mt-2 ml-10 mr-30" value="{$info['recommendnum']}" />
                          <span class="fl">满意度</span>
                          <input type="text" name="satisfyscore" id="satisfyscore" data-regrex="number" data-msg="*必须为数字" class="set-text-xh text_60 mt-2 ml-10 mr-30" value="{$info['satisfyscore']}"  />
                          <span class="fl">销量</span>
                          <input type="text" name="bookcount" id="bookcount" data-regrex="number" data-msg="*必须为数字" class="set-text-xh text_60 mt-2 ml-10" value="{$info['bookcount']}" />
                      </dd>
                  </dl>
              </div>

          </div>
          <!--/基础信息结束-->
          <!--酒店图片开始-->
          <div class="product-add-div" data-id="tupian">
              <div class="up-pic">
                  <dl>
                      <dt>酒店图片：</dt>
                      <dd>
                          <div class="up-file-div">
                              <div id="pic_btn" class="btn-file mt-4">上传图片</div>
                          </div>
                          <div class="up-file-div" style="width: 180px;">
                              <div class="mt-7" style="float: left;color: #999;">建议上传尺寸1024*695px</div>
                          </div>
                          <div class="up-list-div">
                              <input type="hidden" class="headimgindex" name="imgheadindex" value=""/>
                              <input type="hidden" name="litpic" id="litpic" value="{$info['litpic']}"/>
                              <ul class="pic-sel">

                              </ul>
                          </div>
                      </dd>
                  </dl>


              </div>
          </div>
          <!--酒店图片结束-->
          <div class="product-add-div addclass" data-id="content">
              <div class="add-class">
                <div style=" margin: 0 0 10px 10px;">{Common::get_editor('jieshao',$info['content'],700,400)}</div>
              </div>
          </div>
          <div class="product-add-div addclass" data-id="fuwu">
              <div class="add-class">
                <div style=" margin: 0 0 10px 10px;">{Common::get_editor('fuwu',$info['fuwu'],700,400)}</div>
              </div>
          </div>
          <div class="product-add-div addclass" data-id="traffic">
              <div class="add-class">
                <div style=" margin: 0 0 10px 10px;">{Common::get_editor('jiaotong',$info['traffic'],700,400)}</div>
              </div>
          </div>
          <div class="product-add-div addclass" data-id="aroundspots">
              <div class="add-class">
                <div style=" margin: 0 0 10px 10px;">{Common::get_editor('zhoubian',$info['aroundspots'],700,400)}</div>
              </div>
          </div>
          <div class="product-add-div addclass" data-id="notice">
              <div class="add-class">
                <div style=" margin: 0 0 10px 10px;">{Common::get_editor('zhuyi',$info['notice'],700,400)}</div>
              </div>
          </div>
          <div class="product-add-div addclass" data-id="equipment">
              <div class="add-class">
                <div style=" margin: 0 0 10px 10px;">{Common::get_editor('fujian',$info['equipment'],700,400)}</div>
              </div>
          </div>
          <div class="product-add-div" data-id="youhua">
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



          <div class="opn-btn">
              <input type="hidden" name="productid" id="productid" value="{$info['id']}"/>
              <input type="hidden" name="action" id="action" value="{$action}"/>

              <a class="normal-btn" id="btn_save" href="javascript:;">保存</a>
              <!--<a class="save" href="#">下一步</a>-->
          </div>

          </div>
          </form>
            
          </div>
            
        </div>
        
        {request "pub/footer"}
        
      </div>
    </div><!-- 主体内容 -->
  
  </div>

</body>

<script>
    $(function(){
        $("#nav_hotel_list").addClass('on');
        $("#nav").find('span').click(function(){
            Product.changeTab(this,'.product-add-div');//导航切换
        })
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
        $("#btn_save").click(function(){

            var hotelname = $("#hotelname").val();

            //验证酒店名称
            if(hotelname==''){
                $("#nav").find('span').first().trigger('click');
                $("#hotelname").focus();
                ST.Util.showMsg('请填写酒店名称',5,2000);
            }
            else
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
