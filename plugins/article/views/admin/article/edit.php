<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>文章添加/修改</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>

    <table class="content-tab" margin_body=40zCXC >
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td ">
                <form method="post" name="product_frm" id="product_frm">
                    <div class="cfg-header-bar">
                        <div class="cfg-header-tab" id="nav">
                            <span class="item"><s></s>基础信息</span>
                            <span class="item" data-id="tupian"><s></s>攻略附件</span>
                            <span class="item" data-id="youhua"><s></s>优化设置</span>
                            <span class="item" data-id="extend"><s></s>扩展设置</span>
                        </div>
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>

                    <div class="product-add-div">
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">站点：</span>
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
                                  <span class="item-hd">文章标题：</span>
                                  <div class="item-bd">
                                      <input type="text" name="title" id="articlename" class="input-text w900"  value="{$info['title']}" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">作者：</span>
                                  <div class="item-bd">
                                      <input type="text" name="author" id="author" class="input-text w300" value="{$info['author']}" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">文章来源：</span>
                                  <div class="item-bd">
                                      <input type="text" name="comefrom" id="comefrom" class="input-text w300" value="{$info['comefrom']}" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">来源网址：</span>
                                  <div class="item-bd">
                                      <input type="text" name="fromsite" id="fromsite" class="input-text w300" value="{$info['fromsite']}" />
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">显示模版：</span>
                                  <div class="item-bd">
                                      <div class="temp-chg" id="templet_list">
                                          <a {if $info['templet']==''}class="on"{/if}  href="javascript:void(0)"  data-value="" onclick="setTemplet(this)">标准1</a>
                                          <a {if $info['templet']=='moban2'}class="on"{/if}  href="javascript:void(0)"  data-value="moban2" onclick="setTemplet(this)">标准2</a>
                                          {loop $templetlist $r}
                                          <a {if $info['templet']==$r['path']}class="on"{/if}  href="javascript:void(0)" data-value="{$r['path']}" onclick="setTemplet(this)">{$r['templetname']}</a>
                                          {/loop}
                                          <input type="hidden" name="templet" id="templet" value="{$info['templet']}"/>
                                      </div>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">封面图片：</span>
                                  <div class="item-bd">
                                      <label class="check-label"><input type="checkbox" name="allow" value="usecontentpic">使用文章内图片作封面</label>
                                  </div>
                              </li>
                          </ul>
                          <ul class="info-item-block">
                              <li>
                                  <span class="item-hd">目的地选择：</span>
                                  <div class="item-bd">
                                      <a href="javascript:;" class="fl btn btn-primary radius size-S mt-4" onclick="Product.getDest(this,'.dest-sel',4)"  title="选择">选择</a>
                                      <div class="save-value-div mt-2 ml-10 dest-sel">
                                          {loop $info['kindlist_arr'] $k $v}
                                           <span class="{if $info['finaldestid']==$v['id']}finaldest{/if}" title="{if $info['finaldestid']==$v['id']}最终目的地{/if}" ><s onclick="$(this).parent('span').remove()"></s>{$v['kindname']}<input type="hidden" class="lk" name="kindlist[]" value="{$v['id']}"/>
                                               {if $info['finaldestid']==$v['id']}<input type="hidden" class="fk" name="finaldestid" value="{$info['finaldestid']}"/>{/if}</span>
                                          {/loop}
                                      </div>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">文章属性：</span>
                                  <div class="item-bd">

                                      <a href="javascript:;" class="fl btn btn-primary radius size-S mt-4" onclick="Product.getAttrid(this,'.attr-sel',4)"  title="选择">选择</a>
                                      <div class="save-value-div mt-2 ml-10 attr-sel">
                                          {loop $info['attrlist_arr'] $k $v}
                                          <span><s onclick="$(this).parent('span').remove()"></s>{$v['attrname']}<input type="hidden" name="attrlist[]" value="{$v['id']}"></span>
                                          {/loop}
                                      </div>
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">摘要：</span>
                                  <div class="item-bd">
                                      <textarea class="textarea w900"  name="summary" id="" cols="" rows="">{$info['summary']}</textarea>
                                  </div>
                              </li>
                              <li id="gf_content"  {if $info['templet']=='moban2'}style="display:block"{else}style="display:none"{/if}>
                                  <span class="item-hd">文章内容：</span>
                                  <div class="item-bd">
                                      {php Common::getEditor('content',$info['content'],$sysconfig['cfg_admin_htmleditor_width'],400,'raider');}
                                  </div>
                              </li>
                              <li id="bz_content" {if $info['templet']!='moban2'}style="display:block"{else}style="display:none"{/if} >
                                  <span class="item-hd">文章内容：</span>
                                  <div class="item-bd">
                                      {php Common::getEditor('bzcontent',$info['content'],$sysconfig['cfg_admin_htmleditor_width'],400);}
                                  </div>
                              </li>
                              <li>
                                  <span class="item-hd">前台隐藏：</span>
                                  <div class="item-bd">
                                      <label class="check-label"><input type="radio" name="ishidden"  {if $info['ishidden']==0}checked="checked"{/if} value="0">显示</label>
                                      <label class="check-label ml-20"><input type="radio" name="ishidden"  {if $info['ishidden']==1}checked="checked"{/if} value="1">隐藏</label>
                                  </div>
                              </li>
                          </ul>
                    </div>
                    <!-- 基础信息 -->
                    <div class="product-add-div" data-id="tupian">
                      <ul class="info-item-block">
                          <li>
                              <span class="item-hd">攻略图片：</span>
                              <div class="item-bd">
                                  <a href="javascript:;" id="pic_btn" class="btn btn-primary radius size-S">上传图片</a>
                                  <span class="item-text c-999 ml-10">建议上传尺寸750*510px</span>
                                  <div class="up-list-div">
                                      <input type="hidden" class="headimgindex" name="imgheadindex" value=""/>
                                      <input type="hidden" name="litpic" id="litpic" value="{$info['litpic']}"/>
                                      <ul class="pic-sel">
                                      </ul>
                                  </div>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">攻略附件：</span>
                               <div class="item-bd">
                                   <div class="up-file-div">
                                       <a href="javascript:;" id="attach_btn" class="btn btn-primary radius size-S">上传附件</a>
                                       <input type="hidden" name="attachment" id="attachment" value="{$info['attachment']}">
                                   </div>
                                  <div id="doclist" class="doclist">
                                      {if !empty($info['attachment'])}
                                      <a href="{$cmsurl}{$info['attachment']}">查看附件</a>
                                      <a href="javascript:;" onclick="delAttach()">删除</a>
                                      {/if}
                                  </div>
                               </div>
                          </li>
                      </ul>
                    </div>
                    <div class="product-add-div" data-id="youhua">
                      <ul class="info-item-block">
                          <li>
                              <span class="item-hd">优化标题：</span>
                              <div class="item-bd">
                                  <input type="text" name="seotitle" id="seotitle" class="input-text w900" value="{$info['seotitle']}" >
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">301重定向：</span>
                              <div class="item-bd">
                                  <input type="text" name="redirecturl" id="redirecturl" class="input-text w300" value="{$info['redirecturl']}">
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">访问量：</span>
                              <div class="item-bd">
                                  <input type="text" name="shownum" id="shownum" class="input-text w300" value="{$info['shownum']}">
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">Tag词：</span>
                              <div class="item-bd">

                                  <input type="text" id="tagword" name="tagword" class="input-text w300" value="{$info['tagword']}" >
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
                                  <textarea class="textarea w900"  name="description" id="description" cols="" rows="">{$info['description']}</textarea>
                              </div>
                          </li>
                      </ul>
                    </div>
                    <div class="product-add-div" data-id="extend">
                        {php Common::genExtendData(4,$extendinfo);}
                    </div>
                    <div class="clear clearfix pt-20 pb-20">
                      <input type="hidden" name="productid" id="productid" value="{$info['id']}"/>
                      <input type="hidden" name="action" id="action" value="{$action}"/>
                      <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                    </div>
                </form>
            </td>
        </tr>
    </table>

	<script>
        //保存状态
        window.is_saving = 0;
        //设置模板
        function setTemplet(obj)
        {
            var templet = $(obj).attr('data-value');
            $(obj).addClass('on').siblings().removeClass('on');
            $("#templet").val(templet);
            if(templet=='moban2'){
                $('#gf_content').show();
                $('#bz_content').hide();
            }else{
                $('#gf_content').hide();
                $('#bz_content').show();
            }

        }
	$(document).ready(function(){

        $("#nav").find('span').click(function(){

            Product.changeTab(this,'.product-add-div');//导航切换
        })
        $("#nav").find('span').first().trigger('click');


        var action = "{$action}";
        //上传图片

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
        //pdf附件
        setTimeout(function(){
            $('#attach_btn').uploadify({
                'swf': PUBLICURL + 'js/uploadify/uploadify.swf',
                'uploader': SITEURL + 'uploader/uploaddoc',
                'buttonImage' : PUBLICURL+'images/uploadfile.png',  //指定背景图
                'formData':{uploadcookie:"<?php echo Cookie::get('username')?>"},
                'fileTypeExts':'*.pdf',
                'auto': true,   //是否自动上传
                'removeTimeout':0.2,
                'height': 25,
                'width': 80,
                'onUploadSuccess': function (file, data, response) {


                    var info=$.parseJSON(data);
                    var html = '<a href="'+info.path+'" target="_blank">查看附件</a>&nbsp;';
                    $("#attachment").val(info.path);
                    if(action=='edit')
                        html+= '<a href="javascript:;" onclick="delAttach()">删除</a>'
                    $("#doclist").html(html);

                }
            });
        },10)

        //保存
        $("#btn_save").click(function(){

            //检测是否是在保存状态
            if(is_saving == 1){
                return false;
            }
            window.is_saving = 1;
               var articlename = $("#articlename").val();

            //验证名称
             if(articlename==''){
                   $("#nav").find('span').first().trigger('click');
                   $("#articlename").focus();
                   ST.Util.showMsg('请填写文章名称',5,2000);
               }
               else
               {
                   $.ajaxform({
                       url   :  SITEURL+"article/admin/article/ajax_save",
                       method  :  "POST",
                       isUpload :  true,
                       form  : "#product_frm",
                       dataType  :  "JSON",
                       success  :  function(data)
                       {

                           //var data = $.parseJSON(response.responseText);
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

            var piclist = ST.Modify.getUploadFile({$info['piclist_arr']});
            $(".pic-sel").html(piclist);
            var litpic = $("#litpic").val();
            $(".img-li").find('img').each(function(i,item){

                if($(item).attr('src')==litpic){
                    var obj = $(item).parents('.img-li').first().find('.btn-ste')[0];
                    Imageup.setHead(obj,i+1);

                }
            })
            window.image_index= $(".pic-sel").find('li').length;//已添加的图片数量

                $('input[name="allow"]').click(function(){
                    if($(this).is(':checked')){
                        ST.Util.confirmBox('提取封面图','如果已提取过封面再次从内容中提取封面图可能造成图片重复,确认要再次提取?',function(){},function(){
                            $('input[name="allow"]').attr('checked',false);
                        })
                    }
                })

        {/if}






     });

     function showpic()
     {
         $("#updiv").show();
     }
     function unshowpic()
     {
         $("#updiv").hide();
     }

     function delAttach()
     {
                var articleid = '{$info['id']}';
                $.ajax({
                    type:'POST',
                    url:SITEURL+'article/admin/article/ajax_del_attach',
                    data:{articleid:articleid},
                    dataType:'json',
                    success:function(data){
                        if(data.status){
                            $("#doclist").html('');
                            ST.Util.showMsg('删除成功',4,1000);

                        };
                    }
                })
      }



    </script>

</body>
</html>
