<!doctype html>
<html>
<head ul_float=6cyt-j >
    <meta charset="utf-8">
    <title>线路管理</title>
    <?php echo Common::css('admin_base.css,admin_base2.css,admin_style.css,style.css,base_new.css');?>
    <?php echo Common::js('jquery.min.js,jquery.colorpicker.js,common.js,choose.js,product.js,imageup.js,jquery.upload.js');?>
    <script type="text/javascript"src="/min/?f=/tools/js/uploadify/jquery.uploadify.min.js"></script>
    <link type="text/css" href="/min/?f=/tools/js/uploadify/uploadify.css" rel="stylesheet" />
    <?php echo  Stourweb_View::template("pub");  ?>
    <style>
        #linedoc-content{  margin-left: 10px; line-height: 30px; list-style: none; clear: both;}
        #linedoc-content li{ list-style-position: inside; list-style: decimal;}
        #linedoc-content span{ padding-right:5px;}
        #linedoc-content span.del{ color: #f00; cursor:pointer;margin: 0 5px;}
        #linedoc-content span.del:hover{text-decoration:underline }
    </style>
</head>
<body>
<!--顶部-->
<?php Common::get_editor('jseditor','',700,300,'Sline','','print',true);?>
    <div class="content-box">
            <div class="manage-nr">
                <div class="w-set-con">
                <div class="w-set-tit bom-arrow">
                    <span class="on" id="column_basic" onclick="Product.switchTab(this,'basic')">基础信息</span>
                    <span  id="column_tupian" onclick="Product.switchTab(this,'tupian')">图片管理</span>
                    <?php
                      foreach($columns as $col)
                      {
                         echo "<span id=\"column_".$col['columnname']."\" onclick=\"Product.switchTab(this,'".$col['columnname']."',switchBack)\"><s></s>".$col['chinesename']."</span>";
                      }
                    ?>
                    <span id="column_basic" onclick="Product.switchTab(this,'seo')">优化</span>
                    <span id="column_basic" onclick="Product.switchTab(this,'extend')">扩展设置</span>
                    <a href="javascript:;" class="refresh-btn" onclick="window.location.reload()">刷新</a>
                </div>
                </div>
                <form id="product_fm" method="post" action="<?php echo $cmsurl;?>index/ajax_linesave">
                <div id="content_basic" class="product-add-div content-show">
                    <div class="add-class">
                        <dl>
                            <dt>站点：</dt>
                            <dd>
                                <span class="select-box w200">
                                    <select class="select va-t" name="webid">
                                        <option value="0" <?php if($info['webid']==0) { ?>selected="selected"<?php } ?>
>主站</option>
                                     <?php
                                       foreach($weblist as $web)
                                       {
                                           $is_selected=$web['webid']==$info['webid']?"selected='selected'":'';
                                           echo "<option ".$is_selected." value='".$web['webid']."'>".$web['webname']."</option>";
                                       }
                                       ?>
                                    </select>
                                  </span>
                            </dd>
                        </dl>
                        <dl>
                            <dt>产品名称：</dt>
                            <dd>
                                <input type="text" name="title" data-required="true" class="set-text-xh text_700 mt-2" value="<?php echo $info['title'];?>"/>
                                <input type="hidden" name="lineid" id="line_id" value="<?php echo $info['id'];   ?>"/>
                                <div class="help-ico mt-9 ml-5"></div>
                            </dd>
                        </dl>
                        <dl>
                            <dt>标题颜色：</dt>
                            <dd><input type="text" name="color" value="<?php echo $info['color'];?>" class="set-text-xh text_100 mt-2 title-color"/></dd>
                        </dl>
                        <dl>
                            <dt>产品卖点：</dt>
                            <dd>
                                <input type="text" name="sellpoint" value="<?php echo $info['sellpoint'];?>"  class="set-text-xh text_700 mt-2"/>
                                <div class="help-ico mt-9 ml-5"></div>
                            </dd>
                        </dl>
                    </div>
                    <div class="add-class">
                        <dl>
                            <dt>出发地：</dt>
                            <dd>
                                <a href="javascript:;" class="choose-btn mt-4" onclick="Product.setStartPlace(this,'.startplace-sel')" title="选择">选择</a>
                                <div class="save-value-div mt-2 ml-10 startplace-sel">
                                    <?php $n=1; if(is_array($startplacelist)) { foreach($startplacelist as $place) { ?>
                                    <?php if($place['id']==$info['startcity']) { ?>
                                    <span class="mb-5 finaldest" ><s onclick="$(this).parent('span').remove()"></s><?php echo $place['cityname'];?>
                                            <input type="hidden" class="lk" name="startcity" value="<?php echo $info['startcity'];?>"/>
                                        </span>
                                    <?php } ?>
                                    <?php $n++;}unset($n); } ?>
                                </div>
                                <!--<span class="select-box w200">
                                    <select class="select va-t" name="startcity">
                                        <option value="0">请选择出发地</option>
                                       <?php $n=1; if(is_array($startplacelist)) { foreach($startplacelist as $place) { ?>
                                       <option value="<?php echo $place['id'];?>" <?php if($info['startcity']==$place['id']) { ?>selected="selected"<?php } ?>
><?php echo $place['cityname'];?></option>
                                        <?php $n++;}unset($n); } ?>
                                    </select>
                                </span>-->
                            </dd>
                        </dl>
                        <dl>
                            <dt>目的地选择：</dt>
                            <dd>
                                <a href="javascript:;" class="choose-btn mt-4" onclick="Product.getDest(this,'.dest-sel',1)" title="选择">选择</a>
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
                            <dt>产品属性：</dt>
                            <dd>
                                <a href="javascript:;" class="choose-btn mt-4" onclick="Product.getAttrid(this,'.attr-sel',1)" title="选择">选择</a>
                                <div class="save-value-div mt-2 ml-10 attr-sel wid_650">
                                    <?php $n=1; if(is_array($info['attrlist_arr'])) { foreach($info['attrlist_arr'] as $k => $v) { ?>
                                    <span><s onclick="$(this).parent('span').remove()"></s><?php echo $v['attrname'];?><input type="hidden" name="attrlist[]" value="<?php echo $v['id'];?>"></span>
                                    <?php $n++;}unset($n); } ?>
                                </div>
                            </dd>
                        </dl>
                        <dl>
                            <dt>图标设置：</dt>
                            <dd>
                                <a href="javascript:;" class="choose-btn mt-4" onclick="Product.getIcon(this,'.icon-sel')" title="选择">选择</a>
                                <div class="save-value-div mt-2 ml-10 icon-sel">
                                    <?php $n=1; if(is_array($info['iconlist_arr'])) { foreach($info['iconlist_arr'] as $k => $v) { ?>
                                    <span><s onclick="$(this).parent('span').remove()"></s><img src="<?php echo $v['picurl'];?>"><input type="hidden" name="iconlist[]" value="<?php echo $v['id'];?>"></span>
                                    <?php $n++;}unset($n); } ?>
                                </div></dd>
                        </dl>
                        <dl>
                            <dt>旅游天数：</dt>
                            <dd>
                                <input type="text" value="<?php echo $info['lineday'];?>"  id="travel_days" maxlength="2" class="set-text-xh text_60 mt-2 number_only" name="lineday"/>
                                <span class="fl ml-10">*天</span>
                                <input type="text" value="<?php echo $info['linenight'];?>" class="set-text-xh text_60 mt-2 ml-10 number_only" name="linenight"/>
                                <span class="fl ml-10">晚</span>
                            </dd>
                            </dd>
                        </dl>
                        <dl>
                            <dt>提前天数：</dt>
                            <dd>
                                <span class="fl">建议提前</span>
                                <input type="text" name="linebefore" value="<?php echo $info['linebefore'];?>" maxlength="2" class="set-text-xh text_60 mt-2 ml-10 number_only"/>
                                <span class="fl ml-10">天报名</span>
                                &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<input type="checkbox" name="islinebefore" value="1" <?php if($info['islinebefore']==1) { ?>checked="checked"<?php } ?>
/><span class="ml-5">报价显示限制提前天数</span>
                            </dd>
                        </dl>
                    </div>
                    <div class="add-class">
                        <dl>
                            <dt>显示数据：</dt>
                            <dd>
                                <span class="fl">推荐次数</span>
                                <input type="text" name="recommendnum" maxlength="6" value="<?php echo $info['recommendnum'];?>"  class="set-text-xh text_60 mt-2 ml-10 mr-30 number_only" />
                                <span class="fl">满意度</span>
                                <input type="text" name="satisfyscore" maxlength="3" value="<?php if(empty($info['satisfyscore'])) { ?>100<?php } else { ?><?php echo $info['satisfyscore'];?><?php } ?>
" data-regrex="number" data-msg="*必须为数字" class="set-text-xh text_60 mt-2 ml-10 mr-30"/>
                                <span class="fl">销量</span>
                                <input type="text" name="bookcount" maxlength="6" value="<?php echo $info['bookcount'];?>" class="set-text-xh text_60 mt-2 ml-10 number_only"/>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div id="content_jieshao" class="product-add-div content-hide">
                    <div class="ap-div-top">
                        <dl>
                            <dt>排版方式：</dt>
                            <dd>
                                <div class="temp-chg">
                                    <a <?php if($info['isstyle']==2 ||empty($info['isstyle'])) echo 'class="on"';   ?> href="javascript:void(0)" onclick="togStyle(this,2)">标准版</a>
                                    <a <?php if($info['isstyle']==1) echo 'class="on"';   ?> href="javascript:void(0)" onclick="togStyle(this,1)">简洁版</a>
                                    <input type="hidden" name="isstyle" id="line_isstyle" value="<?php echo $info['isstyle'];?>"/>
                                </div>
                            </dd>
                        </dl>
                        <ul class="info-item-block">
                        <li>
                            <span class="item-hd w90">
                               行程附件：
                            </span>
                            <div class="item-bd" style="padding-left: 90px">
                                <div class="">
                                    <a id="attach_btn" class="btn btn-primary radius size-S mt-3" href="javascript:;">上传附件</a>
                                    <span class="item-text" id="linedoc-content">
                            <?php $n=1; if(is_array($info['linedoc']['path'])) { foreach($info['linedoc']['path'] as $k => $v) { ?>
                                    <span class="name"><?php echo $info['linedoc']['name'][$k];?></span>
                                            <input type="hidden" name="linedoc[name][]" value="<?php echo $info['linedoc']['name'][$k];?>">
                                            <input type="hidden" class="path" name="linedoc[path][]" value="<?php echo $v;?>">
                                            <span class="del">删除</span>
                            <?php $n++;}unset($n); } ?>
                                        </span>
                                </div>
                            </div>
                        </li>
                        </ul>
                        <dl class="content-jieshao-detail-repast">
                            <dt>用餐情况：</dt>
                            <dd>
                            <div class="on-off">
                                <label class="radio-label"><input type="radio" onclick="togDiner(1)" name="showrepast" value="1" <?php if($info['showrepast']==1 OR !isset($info['showrepast'])) { ?>checked="checked"<?php } ?>
>显示</label>
                                <label class="radio-label ml-20"><input type="radio" onclick="togDiner(0)" <?php if($info['showrepast']==0 AND isset($info['showrepast'])) { ?>checked="checked"<?php } ?>
 name="showrepast" value="0">隐藏</label>
                            </div>
                            </dd>
                        </dl>
                        <dl class="content-jieshao-detail-hotel">
                            <dt>住宿情况：</dt>
                            <dd>
                                <div class="on-off">
                                    <label class="radio-label"><input type="radio" onclick="togHotel(1)" name="showhotel" value="1" <?php if($info['showhotel']==1 OR !isset($info['showhotel'])) { ?>checked="checked"<?php } ?>
>显示</label>
                                    <label class="radio-label ml-20"><input type="radio" onclick="togHotel(0)" <?php if($info['showhotel']==0 AND isset($info['showhotel'])) { ?>checked="checked"<?php } ?>
 name="showhotel" value="0">隐藏</label>
                                </div>
                            </dd>
                        </dl>
                        <dl class="content-jieshao-detail-traffic">
                            <dt>往返交通：</dt>
                            <dd>
                                <div class="on-off">
                                    <label class="radio-label"><input type="radio" onclick="togTran(1)" name="showtran" value="1" <?php if($info['showtran']==1 OR !isset($info['showtran'])) { ?>checked="checked"<?php } ?>
>显示</label>
                                    <label class="radio-label ml-20"><input type="radio" onclick="togTran(0)" <?php if($info['showtran']==0 AND isset($info['showtran'])) { ?>checked="checked"<?php } ?>
 name="showtran" value="0">隐藏</label>
                                </div>
                            </dd>
                        </dl>
                    </div>
                    <div class="content-jieshao-simple" style="<?php  if(empty($info['isstyle'])||$info['isstyle']==2) echo 'display:none'   ?>">
                       <div><textarea name="jieshao" id="simple_jieshao"><?php echo $info['jieshao'];?></textarea></div>
                    </div>
                    <div class="content-jieshao-detail" style="<?php  if($info['isstyle']==1) echo 'display:none'   ?>">
                        <?php
                           foreach($info['linejieshao_arr'] as $k=>$v)
                           {
                               $jiaotong = '';
                               $transport_arr=explode(',',$v['transport']);
                               foreach($sysjiaotong as $v1)
                               {
                                   $checkstatus = in_array($v1,$transport_arr) ? "checked='checked'" : '';
                                   $jiaotong.="<span class=\"fl\"><input class=\"fl mt-8\" type=\"checkbox\" ".$checkstatus."  name=\"transport[".$v['day']."][]\" value=\"".$v1."\"/></span>&nbsp;<label class=\"fl ml-5 mr-20\" style=\"cursor:pointer;\">".$v1."</label>";
                               }
                               foreach($transport_arr as $user)
                               {
                                    if(!in_array($user,$sysjiaotong) && !empty($user))
                                    {
                                       $jiaotong.="<span class=\"fl zdy\"><input checked='checked'  class=\"fl mt-8\" type=\"checkbox\"  name=\"transport[".$v['day']."][]\" value=\"".$user."\"/></span>&nbsp;<label class=\"fl ml-5 mr-20\" style=\"cursor:pointer;\">".$user."</label>";
                                    }
                               }
                               $jiaotong.=" <span id=\"addjt_".$v['day']."\"></span><img class='addimg' data-contain='addjt_".$v['day']."' data-day='".$v['day']."' style=\"line-height: 30px;vertical-align: middle;cursor: pointer\"  src=\"".$GLOBALS['cfg_public_url']."images/tianjia.png\">";
                               $breakfirst_check=$v['breakfirsthas']==1?'checked="checked"':'';
                               $lunch_check=$v['lunchhas']==1?'checked="checked"':'';
                               $supper_check=$v['supperhas']==1?'checked="checked"':'';
                               $transport_arr=explode(',',$v['transport']);
                               $car_check=in_array(2,$transport_arr)?'checked="checked"':'';
                               $train_check=in_array(3,$transport_arr)?'checked="checked"':'';
                               $plane_check=in_array(1,$transport_arr)?'checked="checked"':'';
                               $ship_check=in_array(4,$transport_arr)?'checked="checked"':'';
                               $food_style=$info['showrepast']==0?"display:none":'';
                               $dayspot= Model_Line::getDaySpotHtml($v['day'],$v['lineid']);
                               $jieshao='<div class="add-class">';
                               $jieshao.='<dl><dt>第'.$v['day'].'天：</dt>';
                               $jieshao.='<dd>';
                               $jieshao.='<input type="text" name="jieshaotitle['.$v['day'].']" value="'.$v['title'].'" class="set-text-xh text_700 mt-2"/></dd>';                                      $jieshao.='</dl>';
                               $jieshao.='<dl class="jieshao-diner" style="'.$food_style.'">';
                               $jieshao.='<dt>用餐情况：</dt>';
                               $jieshao.='<dd>';
                               $jieshao.='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="breakfirsthas['.$v['day'].']" '.$breakfirst_check.' value="1"></span>';
                               $jieshao.='<label style=" float:left; cursor: pointer;">早餐</label>';
                               $jieshao.='<span><input class="set-text-xh text_177 ml-5 mr-10" type="text" name="breakfirst['.$v['day'].']" value="'.$v['breakfirst'].'"/></span>';
                               $jieshao.='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="lunchhas['.$v['day'].']" '.$lunch_check.' value="1"></span>';
                               $jieshao.='<label style=" float:left; cursor: pointer;">午餐</label>';
                               $jieshao.='<span><input class="set-text-xh text_177 ml-5 mr-10" type="text" name="lunch['.$v['day'].']" value="'.$v['lunch'].'"/></span>';
                               $jieshao.='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="supperhas['.$v['day'].']" '.$supper_check.' value="1"></span>';
                               $jieshao.='<label style=" float:left; cursor: pointer;">晚餐</label>';
                               $jieshao.='<span><input class="set-text-xh text_177 ml-5 mr-10" type="text"name="supper['.$v['day'].']" value="'.$v['supper'].'"/></span>';
                               $jieshao.='</dd>';
                               $jieshao.='</dl>';
                               $jieshao.='<dl class="jieshao-hotel"><dt>住宿情况：</dt>';
                               $jieshao.='<dd><input type="text"  class="set-text-xh text_222 mt-2" name="hotel['.$v['day'].']" value="'.$v['hotel'].'"></dd>';
                               $jieshao.='</dl>';
                               $jieshao.='<dl class="jieshao-tran"><dt>交通工具：</dt>';
                               $jieshao.='<dd>';
                               $jieshao.=$jiaotong;
                               $jieshao.='</dd>';
                               $jieshao.='</dl>';
                               $jieshao.='<div class="xc-con">';
                               $jieshao.='<h4>行程内容：</h4>';
                               $jieshao.='<div>';
                               $jieshao.='<textarea name="txtjieshao['.$v['day'].']" style=" float:left" id="line_content_'.$v['day'].'">'.$v['jieshao'].'</textarea>';
                               $jieshao.='</div>';
                               $jieshao.='<dl>';
                               $jieshao.='<dt>相关景点：</dt>';
                               $jieshao.='<dd><input type="button" class="btn btn-primary radius size-S" value="提取" onclick="autoGetSpot('.$v['day'].')"><div class="save-value-div mt-2 ml-10" id="listspot_'.$v['day'].'">'.$dayspot.'</div></dd>';
                               $jieshao.='</dl>';
                               $jieshao.='</div></div>';
                               echo $jieshao;
                           }
                        ?>
                    </div>
                </div>
                <div id="content_biaozhun" class="product-add-div content-hide">
                     <div  class="editor-range">
                         <textarea id="biaozhun" name="biaozhun"><?php echo $info['biaozhun'];?></textarea>
                     </div>
                </div>
                <div id="content_beizu" class="product-add-div content-hide">
                    <div  class="editor-range">
                        <textarea id="beizu" name="beizu"><?php echo $info['beizu'];?></textarea>
                    </div>
                </div>
                <div id="content_payment" class="product-add-div content-hide">
                    <div  class="editor-range">
                        <textarea id="payment" name="payment"><?php echo $info['payment'];?></textarea>
                    </div>
                </div>
                <div id="content_feeinclude" class="product-add-div content-hide">
                    <div  class="editor-range">
                        <textarea id="feeinclude" name="feeinclude"><?php echo $info['feeinclude'];?></textarea>
                    </div>
                </div>
                <div id="content_features" class="product-add-div content-hide">
                    <div  class="editor-range">
                        <textarea id="features" name="features"><?php echo $info['features'];?></textarea>
                    </div>
                </div>
                <div id="content_reserved1" class="product-add-div content-hide">
                    <div  class="editor-range">
                        <textarea id="reserved1" name="reserved1"><?php echo $info['reserved1'];?></textarea>
                    </div>
                </div>
                <div id="content_reserved2" class="product-add-div content-hide">
                    <div  class="editor-range">
                        <textarea id="reserved2" name="reserved2"><?php echo $info['reserved2'];?></textarea>
                    </div>
                </div>
                <div id="content_reserved3" class="product-add-div content-hide">
                    <div  class="editor-range">
                        <textarea id="reserved3" name="reserved3"><?php echo $info['reserved3'];?></textarea>
                    </div>
                </div>
                <div id="content_tupian" class="product-add-div content-hide">
                    <div class="up-pic">
                        <dl>
                            <dt>图片：</dt>
                            <dd>
                                <div class="up-file-div">
                                    <div id="pic_btn" class="btn-file mt-4">上传图片</div>
                                </div>
                                <div class="up-file-div" style="width: 180px;">
                                    <div class="mt-7" style="float: left;color: #999;">建议上传尺寸1024*695px</div>
                                </div>
                                <div class="up-list-div">
                                    <ul>
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
                                            $html .= '<img class="fl" src="' . $imginfo_arr[0] . '" width="100" height="100">';
                                            $html .= '<p class="p1">';
                                            $html .= '<input type="text" class="img-name" name="imagestitle[' . $img_index . ']" value="' . $imginfo_arr[1] . '" style="width:90px">';
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
                            </dd>
                        </dl>
                    </div>
                </div>
                <div id="content_seo" class="product-add-div content-hide">
                    <div class="add-class">
                        <dl>
                            <dt>优化标题：</dt>
                            <dd>
                                <input type="text" name="seotitle" value="<?php echo $info['seotitle'];?>" class="set-text-xh text_700 mt-2">
                            </dd>
                        </dl>
                        <dl>
                            <dt>Tag词：</dt>
                            <dd>
                                 <!-- <input type="button" class="btn-sum-xz mt-4" value="提取">-->
                                <input type="text" name="tagword" class="set-text-xh text_700 mt-2 " value="<?php echo $info['tagword'];?>">
                            </dd>
                        </dl>
                        <dl>
                            <dt>关键词：</dt>
                            <dd>
                                <input type="text" name="keyword" value="<?php echo $info['keyword'];?>" class="set-text-xh text_700 mt-2">
                            </dd>
                        </dl>
                        <dl>
                            <dt>页面描述：</dt>
                            <dd style="height:auto">
                                <textarea class="set-area wid_695" name="description" cols="" rows=""><?php echo $info['description'];?></textarea>
                            </dd>
                        </dl>
                    </div>
                </div>
                <?php $contentArr=Common::get_line_extend_content(1,$extendinfo);?>
                <?php echo $contentArr['contentHtml'];?>
                <div id="content_extend" class="product-add-div content-hide">
                    <?php echo $contentArr['extendHtml'];?>
                </div>
                </form>
                <div class="opn-btn">
                    <a class="normal-btn" id="save_btn" href="javascript:;">保存</a>
                </div>
            </div>
    </div>
<!--右侧内容区-->
<script>
 $(document).ready(function(e) {
     //编辑器
     window.biaozhun=window.JSEDITOR('biaozhun');
     window.simple_jieshao=window.JSEDITOR('simple_jieshao');
     window.beizu=window.JSEDITOR('beizu');
     window.payment=window.JSEDITOR('payment');
     window.feeinclude=window.JSEDITOR('feeinclude');
     window.features=window.JSEDITOR('features');
     window.reserved1=window.JSEDITOR('reserved1');
     window.reserved2=window.JSEDITOR('reserved2');
     window.reserved3=window.JSEDITOR('reserved3');
     //颜色选择器
  $(".title-color").colorpicker({
            ishex:true,
            success:function(o,color){
                $(o).val(color)
            },
            reset:function(o){
            }
        });
   $("#save_btn").click(function(e) {
           var days=Number($("#travel_days").val());
           if(days<=0){
               ST.Util.showMsg("请填写旅游天数",5,1500);
               $("#travel_days").css("border","1px solid red");
               return false;
           }
           //行程安排模式
           var content_style = $("#line_isstyle").val();
           var valid = true;
           var msg = '';
           if(content_style == 2){
               $("input[name^='jieshaotitle']").each(function(i,obj){
                   if($(obj).val().length == 0)
                   {
                       valid = false;
                       msg = '行程天数标题还没有填写完整';
                       return false
                   }
               })
               $("textarea[name^='txtjieshao']").each(function(i,obj){
                   var icontent = $(obj).val();
                   if(icontent.length == 0){
                       valid = false;
                       msg = '线路行程内容没有填写完整';
                       return false;
                   }
               })
           }
           if(!valid){
               ST.Util.showMsg(msg,5,1000);
               window.is_saving = 0;
               return false;
           }
           $.ajax({
               type:'POST',
               url:SITEURL+'index/ajax_linesave',
               data:$("#product_fm").serialize(),
               dataType:'json',
               success:function(data){
                   if(data.status)
                   {
                       if(data.productid!=null){
                           $("#line_id").val(data.productid);
                       }
                       ST.Util.showMsg('保存成功!','4',2000);
                   }
               }
           })
           //$("#product_fm").submit();
       });
});
//切换时的回调函数
function switchBack(columnname)
{
if(columnname=='jieshao')
{
var days=$("#travel_days").val();
        if(days<=0)
        {
          ST.Util.showMsg("请先填写旅游天数",5,1500);
          $("#travel_days").css("border","1px solid red");
          $("#column_basic").trigger("click");
        }
        else
        {
            var html="";
            var jieshao_num=$(".content-jieshao-detail").find('.add-class').length;
            jieshao_num=!jieshao_num?0:jieshao_num;
            var jiaotong = '';
            jiaotong+='<span class="fl"><input class="fl mt-8" type="checkbox" name="transport[{day}][]" value="汽车"/></span>';
            jiaotong+='<label class="fl ml-5 mr-20" style="cursor:pointer;">汽车</label>';
            jiaotong+='<span class="fl"><input class="fl mt-8" type="checkbox" name="transport[{day}][]" value="火车"></span>';
            jiaotong+='<label class="fl ml-5 mr-20" style="cursor:pointer;">火车</label>';
            jiaotong+='<span class="fl"><input class="fl mt-8" type="checkbox"value="飞机" name="transport[{day}][]"></span>';
            jiaotong+='<label class="fl ml-5 mr-20" style="cursor:pointer;">飞机</label>';
            jiaotong+='<span class="fl"><input class="fl mt-8" type="checkbox" name="transport[{day}][]" value="轮船"></span>';
            jiaotong+='<label class="fl ml-5 mr-20" style="cursor:pointer;">轮船</label>';
            /*jiaotong+="<span id=\"addjt_{day}\"></span><img class='addimg' data-contain='addjt_{day}' data-day='{day}' style=\"line-height: 30px;vertical-align: middle;cursor: pointer\"  src=\"/newtravel/public/images/tianjia.png\">";*/
            jiaotong+="<span id=\"addjt_{day}\"></span><a class='addimg btn btn-primary radius size-S va-t mt-3' data-contain='addjt_{day}' data-day='{day}' >添加</a>";
            var day_content='<div class="add-class">';
day_content+='<dl>';
day_content+='<dt>第{day}天：</dt>';
day_content+='<dd><input type="text" name="jieshaotitle[{day}]" class="set-text-xh text_700 mt-2"/></dd>';
day_content+='</dl>';
day_content+='<dl class="jieshao-diner">';
day_content+='<dt>用餐情况：</dt>';
day_content+='<dd>';
day_content+='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="breakfirsthas[{day}]" value="1"></span>';
day_content+='<label style="float:left;cursor:pointer;">早餐</label><span class="fl"><input class="set-text-xh text_177 ml-5 mr-10" type="text" name="breakfirst[{day}]"/></span>';
day_content+='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="lunchhas[{day}]" value="1"></span>';
day_content+='<label style="float:left;cursor:pointer;">午餐</label><span class="fl"><input class="set-text-xh text_177 ml-5 mr-10" type="text" name="lunch[{day}]" value=""/></span>';
day_content+='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="supperhas[{day}]" value="1"></span>';
day_content+='<label style="float:left;cursor:pointer;">晚餐</label><span class="fl"><input class="set-text-xh text_177 ml-5 mr-10" type="text"name="supper[{day}]"/></span>';
day_content+='</dd>';
day_content+='</dl>';
day_content+='<dl class="jieshao-hotel">';
day_content+='<dt>住宿情况：</dt>';
day_content+='<dd><input type="text" class="set-text-xh text_222 mt-2" name="hotel[{day}]"></dd>';
day_content+='</dl>';
day_content+='<dl class="jieshao-tran">';
day_content+='<dt>交通工具：</dt>';
day_content+='<dd>';
day_content+=jiaotong;
day_content+='</dd>';
day_content+='</dl>';
day_content+='<div class="xc-con">';
day_content+='<h4>行程内容：</h4>';
day_content+='<div><textarea name="txtjieshao[{day}]" style=" float:left" id="line_content_{day}"></textarea></div>';
day_content+='<dl>';
day_content+='<dt>相关景点：</dt>';
day_content+='<dd><input type="button" class="btn btn-primary radius size-S" value="提取" onclick="autoGetSpot({day})"><div class="save-value-div mt-2 ml-10" id="listspot_{day}"></div></dd>';
day_content+='</dl>';
day_content+='</div>';
day_content+='</div>';
            if(jieshao_num<days)
            {
               for(var i=jieshao_num+1;i<=days;i++)
               {
                 html+=day_content.replace(/\{day\}/g,i);
               }
               $(".content-jieshao-detail").append(html);
            }
            else if(jieshao_num>days)
            {
                //$(".content-jieshao-detail").find('.add-class').gt(days).remove();
            }
            for(var i=1;i<=days;i++)
            {
                window['line_content_'+i]=window.JSEDITOR('line_content_'+i);
            }
            addJiaoTong2();
        }
}
}
function togDiner(num)
{
   if(num==1)
   {
     $(".jieshao-diner").show();
   }
   else
     $(".jieshao-diner").hide();
}
 function togHotel(num)
 {
     if(num==1)
     {
         $(".jieshao-hotel").show();
     }
     else
         $(".jieshao-hotel").hide();
 }
 function togTran(num)
 {
     if(num==1)
     {
         $(".jieshao-tran").show();
     }
     else
         $(".jieshao-tran").hide();
 }
function togStyle(dom,num)
{
    $("#line_isstyle").val(num);
    $(dom).addClass('on');
    $(dom).siblings().removeClass('on');
    if(num==1)
    {
      $(".content-jieshao-detail").hide();
      $(".content-jieshao-simple").show();
    }
    else
    {
        $(".content-jieshao-detail").show();
        $(".content-jieshao-simple").hide();
    }
}
function nextStep()
{
    $(".w-set-tit span.on").next().trigger('click');
}
//删除附件
function delDoc()
{
    var lineid = '<?php echo $info['id'];?>';
    $.ajax({
        type:'POST',
        url:SITEURL+'/index/ajax_del_doc',
        data:{lineid:lineid},
        dataType:'json',
        success:function(data){
            if(data.status){
                $("#doclist").html('');
                ST.Util.showMsg('删除成功',4,1000);
            };
        }
    })
}
 //一键提取景点
 function autoGetSpot(i)
 {
     var lineid=$("#line_id").val();
     if(lineid==0)return;
     var icontent = window['line_content_'+i].getContent();
     $.ajax(
         {
             type: "post",
             data: {content:icontent,lineid:lineid,day:i},
             url: SITEURL+"index/ajax_getspot",
             dataType:'json',
             beforeSend:function(){
                 ST.Util.showMsg('正在提取...',6,5000);
             },
             success: function(data,textStatus)
             {
                 if(data.length>0) {
                     var html='';
                     $.each(data,function(i,row){
                         html+='<span><s onclick="delDaySpot(this,\''+row.autoid+'\')"></s>'+row.title+'</span>'
                     })
                     $("#listspot_"+i).append(html);//显示提取到的景点
                     ST.Util.showMsg('提取成功!',4,1000);
                 }else{
                     ST.Util.showMsg('未找到景点!',5,1000);
                 }
             },
             error: function()
             {
                 ST.Util.showMsg("请求出错",5,1000);
             }
         });
 }
//删除提取的景点
function delDaySpot(obj,autoid)
{
    $.ajax({
        type:'POST',
        data:{autoid:autoid},
        url:SITEURL+'index/ajax_del_dayspot',
        dataType:'json',
        success:function(data){
            if(data.status){
                $(obj).parent().remove();
            }
        }
    })
}
//设置模板
function setTemplet(obj)
{
    var templet = $(obj).attr('data-value');
    $(obj).addClass('on').siblings().removeClass('on');
    $("#templet").val(templet);
}
//添加交通
function addJiaoTong()
{
    var myDate = new Date();
    var mid = "jt_"+myDate.getMilliseconds();//毫秒数
    var html = "<input name=\"transport_pub[]\" type=\"checkbox\" class=\"checkbox\" id=\""+mid+"\" value=\"\">&nbsp;<label for=\"Transport\"><input type=\"text\" class=\"uservalue\" data-value=\""+mid+"\" style=\"width:70px;border-left:none;border-right:none;border-top:none\"  value=\"\"></label>";
    $("#addjt").append(html);
    $('.uservalue').unbind('input propertychange').bind('input propertychange', function() {
        var datacontain = $(this).attr('data-value');
        $('#'+datacontain).val($(this).val());
    });
}
$(function(){
    addJiaoTong2();
})
function addJiaoTong2()
{
    $(".addimg").unbind('click').click(function(){
        var day = $(this).attr('data-day');
        var datacontain = $(this).attr('data-contain');
        var myDate = new Date();
        var mid = "jt_" + myDate.getMilliseconds();//毫秒数
        var html = "<input  class=\"fl mt-8\" type=\"checkbox\"  name=\"transport["+day+"][]\" id=\""+mid+"\" value=\"\"/>&nbsp;<label class=\"fl ml-5 mr-20\" style=\"cursor:pointer;\"><input type=\"text\" class=\"day_uservalue\" data-value=\"" + mid + "\" style=\"width:70px;border-left:none;border-right:none;border-top:none\"  value=\"\"></label>";
        $("#"+datacontain).append(html);
        $('.day_uservalue').unbind('input propertychange').bind('input propertychange', function () {
            var datacontain = $(this).attr('data-value');
            $('#' + datacontain).val($(this).val());
        });
    })
}
</script>
<script>
    var action = '<?php echo $action;?>';
    $('#pic_btn').click(function(){
        ST.Util.showBox('上传图片', BASEHOST + '/plugins/upload_image/image/insert_view', 430,340, null, null, document, {loadWindow: window, loadCallback: Insert});
        function Insert(result,bool){
            var len=result.data.length;
            for(var i=0;i<len;i++){
                var temp =result.data[i].split('$$');
                Imageup.genePic(temp[0],".up-list-div ul",".cover-div",temp[1]);
            }
        }
    });
    //上传附件
    $('#attach_btn').click(function(){
        // 上传方法
        $.upload({
            // 上传地址
            url: SITEURL+'uploader/uploaddoc',
            // 文件域名字
            fileName: 'Filedata',
            fileType: 'doc,docx,pdf',
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
                console.log(info);
                if(info.status){
                    if(info.status){
                        var html='<span class="name">'+info.name+'</span><input type="hidden" name="linedoc[name][]" value="'+info.name+'"><input class="path" type="hidden" name="linedoc[path][]" value="'+info.path+'"><span class="del">删除</span>';
                        $("#linedoc-content").html(html);
                    }
                }
            }
        });
    })
    $("#linedoc-content").find('.del').live('click',function(){
        var parent=$(this).parent().html('');
    });
    $(function(){
        //只能输入数字
        $('.number_only').keyup(function(){
            var v = $(this).val();
            $(this).val(v.replace(/[^\d]/g,''));
        })
    })
</script>
</body>
</html>
