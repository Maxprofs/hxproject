<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>景点添加/修改</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript('config.js');}
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,choose.js,product_add.js,imageup.js,jquery.validate.js,st_validate.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>

	<table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <form method="post" name="product_frm" id="product_frm">
                    <div class="cfg-header-bar">
                        <div class="cfg-header-tab" id="nav">
                            <span class="item on">基础信息</span>
                            {loop $columns $column}
                            <span class="item" data-id="{$column['columnname']}">{$column['chinesename']}</span>
                            {/loop}
                            <span class="item" data-id="tupian">图片</span>
                            <span class="item" data-id="youhua">优化设置</span>
                            <span class="item" data-id="template">模板</span>
                            <span class="item" data-id="extend">扩展设置</span>
                        </div>
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
                    <!--基础信息开始-->
                    <div class="product-add-div">
                      <ul class="info-item-block">
                          <li>
                              <span class="item-hd">站点{Common::get_help_icon('product_site')}：</span>
                              <div class="item-bd">
                                  <span class="select-box w200">
                                      <select class="select" name="webid">
                                          <option value="0" {if $info['webid']==0}selected="selected"{/if}>主站</option>
                                          {loop $weblist $k}
                                            <option value="{$k['webid']}" {if $info['webid']==$k['webid']}selected="selected"{/if} >{$k['webname']}</option>
                                          {/loop}
                                      </select>
                                  </span>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">景点名称{Common::get_help_icon('product_title')}：</span>
                              <div class="item-bd">
                                  <input type="text" name="title" id="spotname" class="input-text w800"  value="{$info['title']}" />
                              </div>
                          </li>
                         <li>
                              <span class="item-hd">景点简称{Common::get_help_icon('product_spot_shortname')}：</span>
                              <div class="item-bd">
                                  <input type="text" name="shortname" id="shortname" class="input-text w800" value="{$info['shortname']}" />
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">景点卖点{Common::get_help_icon('product_sellpoint')}：</span>
                              <div class="item-bd">
                                  <input type="sellpoint" name="sellpoint" id="sellpoint" class="input-text w800" value="{$info['sellpoint']}" />
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">开放时间{Common::get_help_icon('product_spot_open_time')}：</span>
                              <div class="item-bd">
                                  <input type="text" name="open_time_des"  class="input-text w800" value="{$info['open_time_des']}" />
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">景点地址{Common::get_help_icon('product_spot_address')}：</span>
                              <div class="item-bd">
                                  <input type="text" name="address" id="address" class="input-text w800" value="{$info['address']}" />
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">景点坐标{Common::get_help_icon('product_spot_address_lbs')}：</span>
                              <div class="item-bd">
                                  <div>
                                      <span class="item-text w60">经度(Lng):</span>
                                      <input type="text" name="lng" id="lng"  class="input-text w300" value="{$info['lng']}" />
                                  </div>
                                  <div class="mt-10">
                                      <span class="item-text w60">纬度(Lat):</span>
                                      <input type="text" name="lat" id="lat" class="input-text w300" value="{$info['lat']}"  />
                                      <a href="javascript:;" class="btn btn-primary radius size-S ml-10" onclick="Product.Coordinates(700,500)"  title="选择">选择</a>
                                  </div>
                              </div>
                          </li>

                      </ul>
                      <div class="line"></div>
                      <ul class="info-item-block">
                          <li>
                              <span class="item-hd">目的地选择{Common::get_help_icon('product_destination')}：</span>
                              <div class="item-bd">
                                  <a href="javascript:;" class="fl btn btn-primary radius size-S mt-5" onclick="Product.getDest(this,'.dest-sel',5)"  title="选择">选择</a>
                                  <div class="save-value-div mt-2 ml-10 dest-sel w700">
                                      {loop $info['kindlist_arr'] $k $v}
                                       <span class="mb-5 {if $info['finaldestid']==$v['id']}finaldest{/if}" title="{if $info['finaldestid']==$v['id']}最终目的地{/if}" ><s onclick="$(this).parent('span').remove()"></s>{$v['kindname']}<input type="hidden" class="lk" name="kindlist[]" value="{$v['id']}"/>
                                           {if $info['finaldestid']==$v['id']}<input type="hidden" class="fk" name="finaldestid" value="{$info['finaldestid']}"/>{/if}</span>
                                      {/loop}
                                  </div>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">景点属性{Common::get_help_icon('product_attr')}：</span>
                              <div class="item-bd">
                                  <a href="javascript:;" class="fl btn btn-primary radius size-S mt-5" onclick="Product.getAttrid(this,'.attr-sel',5)"  title="选择">选择</a>
                                  <div class="save-value-div mt-2 ml-10 attr-sel w700">
                                      {loop $info['attrlist_arr'] $k $v}
                                      <span class="mb-5"><s onclick="$(this).parent('span').remove()"></s>{$v['attrname']}<input type="hidden" name="attrlist[]" value="{$v['id']}"></span>
                                      {/loop}
                                  </div>
                              </div>
                          </li>
                          <li>
                            <span class="item-hd">前台隐藏{Common::get_help_icon('product_hide')}：</span>
                            <div class="item-bd">
                                <label class="radio-label"><input type="radio" name="ishidden"  {if $info['ishidden']==0}checked="checked"{/if} value="0">显示</label>
                                <label class="radio-label ml-20"><input type="radio" name="ishidden"  {if $info['ishidden']==1}checked="checked"{/if} value="1">隐藏</label>
                            </div>
                          </li>
                      </ul>
                      <div class="line"></div>
                      <ul class="info-item-block">

                          <?php   $cfg_icon_rule = Model_Sysconfig::get_configs(0,array('cfg_icon_rule'));
                          $cfg_icon_rule = $cfg_icon_rule['cfg_icon_rule']; ?>
                          {if $cfg_icon_rule==1}
                          <li>
                              <span class="item-hd">图标设置{Common::get_help_icon('product_icon')}：</span>
                              <div class="item-bd">
                                  <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getIconNew(this,'.icon-sel')" title="选择">选择</a>
                                  <div class="save-value-div ml-10 icon-sel">
                                      {loop $info['iconlist_arr'] $k $v}
                                        <span class="mb-5 " title="{$v['kind']}" >
                                            <s onclick="$(this).parent('span').remove()"></s>{$v['kind']}
                                            <input type="hidden" class="lk" name="iconlist[]" value="{$v['id']}"/>
                                        </span>
                                      {/loop}
                                  </div>
                              </div>
                          </li>
                          {else}
                          <li>
                              <span class="item-hd">图标设置{Common::get_help_icon('product_icon')}：</span>
                              <div class="item-bd">
                                  <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getIcon(this,'.icon-sel')" title="选择">选择</a>
                                  <div class="save-value-div ml-10 icon-sel">
                                      {loop $info['iconlist_arr'] $k $v}
                                      <span class="mb-5"><s onclick="$(this).parent('span').remove()"></s><img src="{$v['picurl']}"><input type="hidden" name="iconlist[]" value="{$v['id']}"></span>
                                      {/loop}
                                  </div>
                              </div>
                          </li>
                          {/if}
                          <li>
                              <span class="item-hd">显示数据{Common::get_help_icon('product_virtual_data')}：</span>
                              <div class="item-bd">
                                  <span class="">
                                      <span class="item-text">推荐次数</span>
                                      <input type="text" name="recommendnum" id="yesjian" data-regrex="number" data-msg="*必须为数字" maxlength="6" class="input-text w80" value="{$info['recommendnum']}" />
                                  </span>
                                  <span class="ml-20">
                                      <span class="item-text">满意度</span>
                                      <input type="text" name="satisfyscore" id="satisfyscore" data-regrex="number" data-msg="*必须为数字" maxlength="3" class="input-text w80" value="{$info['satisfyscore']}"  />
                                  </span>
                                  <span class="ml-20">
                                      <span class="item-text">销量</span>
                                      <input type="text" name="bookcount" id="bookcount" data-regrex="number" data-msg="*必须为数字" maxlength="6" class="input-text w80" value="{$info['bookcount']}" />
                                  </span>
                              </div>
                          </li>
                      </ul>
                      <div class="line"></div>
                        <ul class="info-item-block">
                          <li>
                              <span class="item-hd">预订送分策略{Common::get_help_icon('product_integral_strategy')}：</span>
                              <div class="item-bd">
                                  <a href="javascript:;" class="fl btn btn-primary radius size-S mt-5" onclick="Product.getJifenbook(this,'.jifenbook-sel',5)" title="选择">选择</a>
                                  <div class="save-value-div mt-2 ml-10 jifenbook-sel">
                                      {if !empty($info['jifenbook_info'])}
                                    <span><s onclick="$(this).parent('span').remove()"></s>{$info['jifenbook_info']['title']}({$info['jifenbook_info']['value']}{if $info['jifenbook_info']['rewardway']==1}%{/if}积分)
                                        {if $info['jifenbook_info']['isopen']==0}<a class="cor_f00">[已关闭]</a>{/if}<input type="hidden" name="jifenbook_id" value="{$info['jifenbook_info']['id']}">
                                    </span>
                                      {/if}
                                  </div>
                                  <span class="item-text ml-10 c-999">*未选择的情况下默认使用全局策略</span>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">积分抵现策略{Common::get_help_icon('product_integral_strategy')}：</span>
                              <div class="item-bd">
                                  <a href="javascript:;" class="fl btn btn-primary radius size-S mt-5" onclick="Product.getJifentprice(this,'.jifentprice-sel',5)" title="选择">选择</a>
                                  <div class="save-value-div mt-2 ml-10 jifentprice-sel">
                                      {if !empty($info['jifentprice_info'])}
                                    <span><s onclick="$(this).parent('span').remove()"></s>{$info['jifentprice_info']['title']}({$info['jifentprice_info']['toplimit']}积分)
                                        {if $info['jifentprice_info']['isopen']==0}<a class="cor_f00">[已关闭]</a>{/if}<input type="hidden" name="jifentprice_id" value="{$info['jifentprice_info']['id']}">
                                    </span>
                                      {/if}
                                  </div>
                                  <span class="item-text ml-10 c-999">*未选择的情况下默认使用全局策略</span>
                              </div>
                          </li>
                      </ul>
                    </div>
                    <!--基础信息结束-->
                    <!--图片开始-->
                    <div class="product-add-div" data-id="tupian">
                      <ul class="info-item-block">
                          <li>
                              <span class="item-hd">景点图片{Common::get_help_icon('product_images')}：</span>
                              <div class="item-bd">
                                  <div class="">
                                      <div id="pic_btn" class="btn btn-primary radius size-S mt-3">上传图片</div>
                                      <span class="item-text c-999 ml-10">建议上传尺寸1024*695px</span>
                                  </div>
                                  <div class="up-list-div">
                                      <input type="hidden" class="headimgindex" name="imgheadindex" value=""/>
                                      <input type="hidden" name="litpic" id="litpic" value="{$info['litpic']}"/>
                                      <ul class="pic-sel">

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
                                <span class="item-hd">景点介绍：</span>
                                <div class="item-bd">
                                    {php Common::getEditor('content',$info['content'],$sysconfig['cfg_admin_htmleditor_width'],400);}
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="product-add-div" data-id="booknotice">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">预订须知：</span>
                                <div class="item-bd">
                                    {php Common::getEditor('booknotice',$info['booknotice'],$sysconfig['cfg_admin_htmleditor_width'],400);}
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="product-add-div" data-id="youhua">
                        <ul class="info-item-block">
                          <li>
                              <span class="item-hd">优化标题{Common::get_help_icon('content_seotitle')}：</span>
                              <div class="item-bd">
                                  <input type="text" name="seotitle" id="seotitle" class="input-text w300" value="{$info['seotitle']}" >
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">Tag词{Common::get_help_icon('content_tagword')}：</span>
                              <div class="item-bd">

                                  <input type="text" id="tagword" name="tagword" class="input-text w300" value="{$info['tagword']}" >
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">关键词{Common::get_help_icon('content_keyword')}：</span>
                              <div class="item-bd">
                                  <input type="text" name="keyword" id="keyword" name="keyword" class="input-text w300" value="{$info['keyword']}">
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">页面描述{Common::get_help_icon('content_description')}：</span>
                              <div class="item-bd">
                                  <textarea class="textarea w900"  name="description" id="description" cols="" rows="">{$info['description']}</textarea>
                              </div>
                          </li>

                      </ul>
                    </div>
                    <div data-id="template" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">电脑端模板{Common::get_help_icon('product_template_set')}：</span>
                                <input type="hidden" name="templet" id="templet" value="{$info['templet']}"/>
                                <div class="item-bd" id="templet_list_pc">

                                </div>
                            </li>
                            <li>
                                <span class="item-hd">移动端模板{Common::get_help_icon('product_template_set')}：</span>
                                <input type="hidden" name="wap_templet" id="wap_templet" value="{$info['wap_templet']}"/>
                                <div class="item-bd" id="templet_list_wap">

                                </div>
                            </li>
                        </ul>
                    </div>
                    {php $contentArr=Common::getExtendContent(5,$extendinfo);}
                    {php echo $contentArr['contentHtml'];}
                    <div class="product-add-div" data-id="extend" id="content_extend">
                      {php echo $contentArr['extendHtml'];}
                    </div>
                    <div class="clear clearfix mt-5 pb-20">
                      <input type="hidden" name="productid" id="productid" value="{$info['id']}"/>
                      <input type="hidden" name="action" id="action" value="{$action}"/>
                      <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                      <!--<a class="save" href="#">下一步</a>-->
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

        });
        $("#nav").find('span').first().trigger('click');


        var action = "{$action}";

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
        })


        $("#product_frm input").st_readyvalidate();
        //保存
        $("#btn_save").click(function(){
                //检测是否是在保存状态
                if(is_saving == 1){
                    return false;
                }
                window.is_saving = 1;

               var spotname = $("#spotname").val();

            //验证酒店名称
             if(spotname==''){
                   $("#nav").find('span').first().trigger('click');
                   $("#spotname").focus();
                   ST.Util.showMsg('请填写景点名称',5,2000);
               }
               else
               {
                   $.ajaxform({
                       url   :  SITEURL+"spot/admin/spot/ajax_save",
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


        //如果是修改页面
        {if $action=='edit'}

            //var kindlist_arr = ;
            //var attrlist_arr = ;
           // var iconlist_arr = ;
          //  var kindlist = ST.Modify.getSelectDest({$info['kindlist_arr']});
            var attrlist = ST.Modify.getSelectAttr({$info['attrlist_arr']});
           // var iconlist = ST.Modify.getSelectIcon({$info['iconlist_arr']});
            var piclist = ST.Modify.getUploadFile({$info['piclist_arr']});


            $(".attr-sel").html(attrlist);
          //  $(".icon-sel").html(iconlist);
            $(".pic-sel").html(piclist);
            var litpic = $("#litpic").val();
            $(".img-li").find('img').each(function(i,item){


                        if($(item).attr('src')==litpic){

                            var obj = $(item).parents('.img-li').first().find('.btn-ste')[0];

                            Imageup.setHead(obj,i+1);
                        }
            });
            window.image_index= $(".pic-sel").find('li').length;//已添加的图片数量


         {/if}


     });



    </script>



    <script>
      //模板相关
      $(document).ready(function(){
          ajax_get_template();
          //获取可用模板
          function ajax_get_template() {
              var webid = $('select[name=webid]').val();
              var template = "{$info['templet']}";
              var wap_templet = "{$info['wap_templet']}";
              $.ajax({
                  type:'post',
                  dataType:'json',
                  url:SITEURL+'spot/admin/spot/ajax_get_template_list',
                  data:{page:'spot_show',webid:webid},
                  success:function (data) {
                      if(data.pclist.length>0)
                      {
                          var pchtml = '';
                          $(data.pclist).each(function (i,v) {
                              var itemclass = 'label-module-item';
                              if ((!template || template=='line_show.htm') && v.isuse == 1)
                              {
                                  itemclass = 'label-module-cur-item';
                              }
                              else if (template == v.pagepath)
                              {
                                  itemclass = 'label-module-cur-item';
                              }
                              pchtml += '<a  class="'+itemclass+' mr-5"  href="javascript:void(0)" data-type="templet" data-value="'+v.pagepath+'" onclick="setTemplet(this)">'+v.title+'</a>';
                          });
                          $('#templet_list_pc').html(pchtml);
                      }
                      if(data.waplist.length>0)
                      {
                          var waphtml = '';
                          $(data.waplist).each(function (i,v) {
                              var itemclass = 'label-module-item';

                              if (wap_templet == v.pagepath)
                              {
                                  itemclass = 'label-module-cur-item';
                              }
                              waphtml += '<a  class="'+itemclass+' mr-5"  href="javascript:void(0)" data-type="wap_templet" data-value="'+v.pagepath+'" onclick="setTemplet(this)">'+v.title+'</a>';
                          });
                          $('#templet_list_wap').html(waphtml);
                      }
                  }

              })
          }
      });

      //设置模板
      function setTemplet(obj)
      {
          var templet = $(obj).data('value');
          var select = $(obj).data('type');
          $(obj).parent().find('a').removeClass('label-module-cur-item');
          $(obj).parent().find('a').addClass('label-module-item');
          $(obj).addClass('label-module-cur-item');
          $(obj).removeClass('label-module-item');
          $("#"+select).val(templet);
      }


    </script>

</body>
</html>
