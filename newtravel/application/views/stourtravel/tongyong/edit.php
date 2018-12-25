<!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="admin/public/css/common.css"/>
    <meta charset="utf-8">
    <title>通用产品</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,choose.js,product_add.js,imageup.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body left_table=HIACXC >
	<table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
             {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td ">
                <div class="cfg-header-bar" id="nav">
                      <div class="cfg-header-tab">
                          <span class="item on"><s></s>基础信息</span>
                          {loop $columns $column}
                          <span data-id="{$column['columnname']}" class="item"><s></s>{$column['chinesename']}</span>
                          {/loop}
                          <span data-id="youhua" class="item"><s></s>优化设置</span>
                          <span data-id="extend" class="item"><s></s>扩展设置</span>
                      </div>
                      <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <div class="clear clearfix">
                    <form method="post" name="product_frm" id="product_frm">

                        <!--基础信息开始-->
                        <div class="product-add-div">
                          <ul class="info-item-block">
                              <!-- <li>
                                 <span class="item-hd">站点：</span>
                                 <div class="item-bd">
                                   <div class="select-box">
                                       <select name="select">
                                             <option value="0" {if $info['webid']==0}selected="selected"{/if}>主站</option>
                                             {loop $weblist $k}
                                              <option value="{$k['webid']}" {if $info['webid']==$k['webid']}selected="selected"{/if} >{$k['webname']}</option>
                                             {/loop}
                                         </select>
                                   </div>
                                 </div>
                             </li>-->
                              <li>
                                  <!--<span class="item-hd">标题{Common::get_help_icon('product_title')}<div class="help-ico mt-9 ml-5">{php echo Common::getIco('help',40); }</div>：</span>-->
                                  <span class="item-hd">标题{Common::get_help_icon('product_title')}：</span>
                                  <div class="item-bd">
                                      <input type="text" name="title" id="title" class="input-text w300"  value="{$info['title']}" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">卖点{Common::get_help_icon('product_title')}：</span>
                                  <div class="item-bd">
                                      <input type="text" name="sellpoint" id="sellpoint" class="input-text w300"  value="{$info['sellpoint']}" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">满意度{Common::get_help_icon('product_title')}：</span>
                                  <div class="item-bd">
                                      <input type="text" name="satisfyscore" id="satisfyscore" class="input-text w100"  value="{$info['satisfyscore']}" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">销量：</span>
                                  <div class="item-bd">
                                      <input type="text" name="bookcount" id="bookcount" class="input-text w100"  value="{$info['bookcount']}" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">显示模版：</span>
                                  <div class="item-bd">
                                      <div class="temp-chg" id="templet_list">
                                          <a {if $info['templet']==''}class="on"{/if}  href="javascript:void(0)"  data-value="" onclick="setTemplet(this)">标准</a>
                                          {loop $templetlist $r}
                                          <a {if $info['templet']==$r['path']}class="on"{/if}  href="javascript:void(0)" data-value="{$r['path']}" onclick="setTemplet(this)">{$r['templetname']}</a>
                                          {/loop}
                                          <input type="hidden" name="templet" id="templet" value="{$info['templet']}"/>
                                      </div>
                                  </div>
                              </li>
                          </ul>
                          <div class="line"></div>
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">目的地选择：</span>
                                  <div class="item-bd">
                                      <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3"  onclick="Product.getDest(this,'.dest-sel','{$typeid}')"  title="选择">选择</a>
                                      <div class="fl save-value-div ml-10 dest-sel w700">
                                          {loop $info['kindlist_arr'] $k $v}
                                           <span class="mb-5 {if $info['finaldestid']==$v['id']}finaldest{/if}" title="{if $info['finaldestid']==$v['id']}最终目的地{/if}" ><s onclick="$(this).parent('span').remove()"></s>{$v['kindname']}<input type="hidden" class="lk" name="kindlist[]" value="{$v['id']}"/>
                                               {if $info['finaldestid']==$v['id']}<input type="hidden" class="fk" name="finaldestid" value="{$info['finaldestid']}"/>{/if}</span>
                                          {/loop}
                                      </div>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">{$modulename}属性：</span>
                                  <div class="item-bd">
                                      <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3"  onclick="Product.getAttrid(this,'.attr-sel','{$typeid}')"  title="选择">选择</a>
                                      <div class="fl save-value-div ml-10 attr-sel w700">
                                          {loop $info['attrlist_arr'] $k $v}
                                          <span class="item-text mb-5"><s onclick="$(this).parent('span').remove()"></s>{$v['attrname']}<input type="hidden" name="attrlist[]" value="{$v['id']}"></span>
                                          {/loop}
                                      </div>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">供应商：</span>
                                  <div class="item-bd">
                                      <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3"  onclick="Product.getSupplier(this,'.supplier-sel')"  title="选择">选择</a>
                                      <div class="fl save-value-div ml-10 supplier-sel w700">
                                          {if !empty($info['supplier_arr']['id'])}
                                          <span class="item-text mb-5"><s onclick="$(this).parent('span').remove()"></s>{$info['supplier_arr']['suppliername']}<input type="hidden" name="supplierlist[]" value="{$info['supplier_arr']['id']}"></span>
                                          {/if}
                                      </div>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">图标设置：</span>
                                  <div class="item-bd">
                                      <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getIcon(this,'.icon-sel')"  title="选择">选择</a>
                                      <div class="fl save-value-div ml-10 icon-sel w700">
                                          {loop $info['iconlist_arr'] $k $v}
                                          <span class="item-text mb-5"><s onclick="$(this).parent('span').remove()"></s><img src="{$v['picurl']}"><input type="hidden" name="iconlist[]" value="{$v['id']}"></span>
                                          {/loop}
                                      </div>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">{$modulename}内容：</span>
                                  <div class="item-bd">
                                      {php Common::getEditor('content',$info['content'],$sysconfig['cfg_admin_htmleditor_width'],400);}
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">预订送积分策略：</span>
                                  <div class="item-bd">
                                      <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getJifenbook(this,'.jifenbook-sel',parseInt('{$typeid}'))" title="选择">选择</a>
                                      <div class="fl save-value-div ml-10 jifenbook-sel">
                                          {if !empty($info['jifenbook_info'])}
                                        <span class="item-text"><s onclick="$(this).parent('span').remove()"></s>{$info['jifenbook_info']['title']}({$info['jifenbook_info']['value']}{if $info['jifenbook_info']['rewardway']==1}%{/if}积分)
                                            {if $info['jifenbook_info']['isopen']==0}<a class="cor_f00">[已关闭]</a>{/if}<input type="hidden" name="jifenbook_id" value="{$info['jifenbook_info']['id']}">
                                        </span>
                                          {/if}
                                      </div>
                                      <span class="item-text c-999 ml-10">*未选择的情况下默认使用全局策略</span>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">积分抵现策略：</span>
                                  <div class="item-bd">
                                      <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getJifentprice(this,'.jifentprice-sel',parseInt('{$typeid}'))" title="选择">选择</a>
                                      <div class="save-value-div mt-2 ml-10 jifentprice-sel">
                                          {if !empty($info['jifentprice_info'])}
                                        <span class="item-text"><s onclick="$(this).parent('span').remove()"></s>{$info['jifentprice_info']['title']}({$info['jifentprice_info']['toplimit']}积分)
                                            {if $info['jifentprice_info']['isopen']==0}<a class="cor_f00">[已关闭]</a>{/if}<input type="hidden" name="jifentprice_id" value="{$info['jifentprice_info']['id']}">
                                        </span>
                                          {/if}
                                      </div>
                                      <span class="item-text c-999 ml-10">*未选择的情况下默认使用全局策略</span>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">前台隐藏：</span>
                                  <div class="item-bd">
                                      <label class="radio-label"><input type="radio" name="ishidden"  {if $info['ishidden']==0}checked="checked"{/if} value="0">显示</label>
                                      <label class="radio-label ml-20"><input type="radio" name="ishidden"  {if $info['ishidden']==1}checked="checked"{/if} value="1">隐藏</label>
                                  </div>
                              </li>
                          </ul>
                        </div>
                        <!--/基础信息结束-->

                        <!--图片开始-->
                        <div class="product-add-div" data-id="tupian">
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">图片：</span>
                                  <div class="item-bd">
                                      <div class="">
                                          <div id="pic_btn" class="btn btn-primary radius size-S mt-3">上传图片</div>
                                          <span class="item-text c-999 ml-10">建议上传尺寸1024*695px</span>
                                      </div>
                                      <div class="up-list-div">
                                          <input type="hidden" class="headimgindex" name="imgheadindex" value=""/>
                                          <input type="hidden" name="litpic" id="litpic" value="{$info['litpic']}"/>
                                          <ul class="pic-sel"></ul>
                                      </div>
                                  </div>
                              </li>
                          </ul>
                        </div>
                        <!--图片结束-->

                        <!--优化开始-->
                        <div class="product-add-div" data-id="youhua">
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">优化标题：</span>
                                  <div class="item-bd">
                                      <input type="text" name="seotitle" id="seotitle" class="input-text w500" value="{$info['seotitle']}" >
                                  </div>
                              </li>

                              <li>
                                  <span class="item-hd">访问量：</span>
                                  <div class="item-bd">
                                      <input type="text" name="shownum" id="shownum"  class="input-text w50" value="{$info['shownum']}">
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">Tag词：</span>
                                  <div class="item-bd">

                                      <input type="text" id="tagword" name="tagword" class="input-text w700" value="{$info['tagword']}" >
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">关键词：</span>
                                  <div class="item-bd">
                                      <input type="text" name="keyword" id="keyword" name="keyword" class="input-text w300" value="{$info['keyword']}">
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">页面描述：</span>
                                  <div class="item-bd">
                                      <textarea class="textarea w700"  name="description" id="description" cols="" rows="">{$info['description']}</textarea>
                                  </div>
                              </li>
                          </ul>
                        </div>
                        <!--优化结束-->

                        {php $contentArr=Common::getExtendContent($typeid,$extendinfo);}
                        {php echo $contentArr['contentHtml'];}
                        <div class="product-add-div" data-id="extend" id="content_extend">{php echo $contentArr['extendHtml'];}</div>



                    <div class="clear clearfix pt-20 pb-20">
                         <input type="hidden" name="productid" id="productid" value="{$info['id']}"/>
                         <input type="hidden" name="action" id="action" value="{$action}"/>
                         <input type="hidden" name="typeid" value="{$typeid}"/>
                         <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                    </div>
                    </form>

              </div>
            </td>
        </tr>
    </table>

	<script>
        //设置模板
        function setTemplet(obj)
        {
            var templet = $(obj).attr('data-value');
            $(obj).addClass('on').siblings().removeClass('on');
            $("#templet").val(templet);

        }
	$(document).ready(function(){

        $("#nav").find('span').click(function(){

            Product.changeTab(this,'.product-add-div');//导航切换

        });
        $("#nav").find('span').first().trigger('click');


        var action = "{$action}";

        $("input[name='allow']:checked").trigger('click');


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



        //保存
       $("#btn_save").click(function(){

               var title = $("#title").val();

            //验证名称
             if(title==''){
                   $("#nav").find('span').first().trigger('click');
                   $("#title").focus();
                   ST.Util.showMsg('请填写标题',5,2000);
               }
               else
               {
                   $.ajaxform({
                       url   :  SITEURL+"tongyong/ajax_save/typeid/{$typeid}",
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

        });



        //如果是修改页面
        {if $action=='edit'}



            var piclist = ST.Modify.getUploadFile({$info['piclist_arr']});


            $(".pic-sel").html(piclist);
            var litpic = $("#litpic").val();
            $(".img-li").find('img').each(function(i,item){

                if($(item).attr('src')==litpic){
                    var obj = $(item).parent().find('.btn-ste')[0];
                    Imageup.setHead(obj,i+1);
                }
            });
            window.image_index= $(".pic-sel").find('li').length;//已添加的图片数量
            {/if}
     });





    </script>

</body>
</html>
