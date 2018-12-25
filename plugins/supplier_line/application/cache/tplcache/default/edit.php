<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>线路管理</title>
    <?php echo Common::css('admin_base.css,admin_base2.css,admin_style.css,style.css');?>
    <?php echo Common::js('jquery.min.js,jquery.colorpicker.js,common.js,choose.js,product.js,imageup.js,insurance.js');?>
    <script type="text/javascript"src="/min/?f=/tools/js/uploadify/jquery.uploadify.min.js"></script>
    <link type="text/css" href="/min/?f=/tools/js/uploadify/uploadify.css" rel="stylesheet" />
    <?php echo  Stourweb_View::template("pub");  ?>
</head>
<body>
<!--顶部-->
<?php Common::get_editor('jseditor','',700,300,'Sline','','print',true);?>
    <div class="content-box">
            <div class="manage-nr">
                <div class="w-set-con">
                <div class="w-set-tit bom-arrow">
                    <span class="on" id="column_basic" onclick="Product.switchTab(this,'basic')">基础信息</span>
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
                                    <select name="webid">
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
                            </dd>
                        </dl>
                        <dl>
                            <dt>线路名称：</dt>
                            <dd>
                                <input type="text" name="title" data-required="true" class="set-text-xh text_700 mt-2" value="<?php echo $info['title'];?>"/>
                                <input type="hidden" name="lineid" id="line_id" value="<?php echo $info['id'];   ?>"/>
                                <div class="help-ico mt-9 ml-5"></div>
                            </dd>
                        </dl>
                        <dl>
                            <dt>线路卖点：</dt>
                            <dd>
                                <input type="text" name="sellpoint" value="<?php echo $info['sellpoint'];?>"  class="set-text-xh text_700 mt-2"/>
                                <div class="help-ico mt-9 ml-5"></div>
                            </dd>
                        </dl>
                        <dl>
                            <dt>出发地：</dt>
                            <dd>
                                <select name="startcity">
                                    <option value="0">请选择出发地</option>
                                <?php $n=1; if(is_array($startplacelist)) { foreach($startplacelist as $place) { ?>
                                    <option value="<?php echo $place['id'];?>" <?php if($info['startcity']==$place['id']) { ?>selected="selected"<?php } ?>
><?php echo $place['cityname'];?></option>
                                <?php $n++;}unset($n); } ?>
                                </select>
                            </dd>
                        </dl>
                    </div>
                    <div class="add-class">
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
                            <dt>线路属性：</dt>
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
                            <dt>保险：</dt>
                            <dd>
                                <a href="javascript:;" class="choose-btn mt-4" onclick="Insurance.chooseDialog(this,'.insurance-sel',updateInsurance)" title="选择">选择</a>
                                <div class="save-value-div mt-2 ml-10 wid_650 insurance-sel">
                                    <?php $n=1; if(is_array($info['insurance_arr'])) { foreach($info['insurance_arr'] as $k => $v) { ?>
                                    <span><s onclick="$(this).parent('span').remove()"></s><?php echo $v['productname'];?><input type="hidden" name="insuranceids[]" value="<?php echo $v['id'];?>"></span>
                                    <?php $n++;}unset($n); } ?>
                                </div>
                            </dd>
                        </dl>
                        <dl>
                          <dt>前台隐藏：</dt>
                          <dd>
                              <label>
                                <input class="fl mt-8 mr-3" type="radio" name="ishidden"  <?php if($info['ishidden']==0) { ?>checked="checked"<?php } ?>
 value="0">
                                <span class="fl mr-20">显示</span>
                              </label>
                              <label>
                                <input class="fl mt-8 mr-3" type="radio" name="ishidden"  <?php if($info['ishidden']==1) { ?>checked="checked"<?php } ?>
 value="1">
                                <span>隐藏</span>
                              </label>
                          </dd>
                        </dl>
                        <dl>
                            <dt>旅游天数：</dt>
                            <dd>
                                <input type="text" value="<?php echo $info['lineday'];?>" data-regrex="number" data-required="true" data-msg="必须为数字" id="travel_days" class="set-text-xh text_60 mt-2" name="lineday"/>
                                <span class="fl ml-10">*天</span>
                                <input type="text" value="<?php echo $info['linenight'];?>" data-regrex="number" data-msg="必须为数字" class="set-text-xh text_60 mt-2 ml-10" name="linenight"/>
                                <span class="fl ml-10">晚</span>
                            </dd>
                            </dd>
                        </dl>
                        <dl>
                            <dt>提前天数：</dt>
                            <dd>
                                <span class="fl">建议提前</span>
                                <input type="text" name="linebefore" value="<?php echo $info['linebefore'];?>" data-regrex="number" data-msg="必须为数字" class="set-text-xh text_60 mt-2 ml-10"/>
                                <span class="fl ml-10">天报名</span>
                                &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<input type="checkbox" name="islinebefore" value="1" <?php if($info['islinebefore']==1) { ?>checked="checked"<?php } ?>
/><span class="ml-5">报价显示限制提前天数</span>
                            </dd>
                        </dl>
                        <dl>
                            <dt>市场价：</dt>
                            <dd>
                                <input type="text" value="<?php echo $info['storeprice'];?>" name="storeprice" class="set-text-xh text_60 mt-2"/><span class="fl ml-5">元</span>
                            </dd>
                        </dl>
                        <dl>
                            <dt>往返交通:</dt>
                            <dd>
                                <?php $n=1; if(is_array($sysjiaotong)) { foreach($sysjiaotong as $v) { ?>
                                 <input name="transport_pub[]" type="checkbox" class="checkbox" id="Transport<?php echo $n;?>" <?php if(strpos($info['transport'],$v)!==false) { ?>checked="checked"<?php } ?>
 value="<?php echo $v;?>">&nbsp;<label for="Transport<?php echo $n;?>"><?php echo $v;?></label>
                                <?php $n++;}unset($n); } ?>
                                <?php $n=1; if(is_array($usertransport)) { foreach($usertransport as $user) { ?>
                                    <?php if(!in_array($user,$sysjiaotong) && !empty($user)) { ?>
                                <input name="transport_pub[]" type="checkbox" class="checkbox" id="Transport_user_<?php echo $n;?>" checked="checked" value="<?php echo $user;?>">&nbsp;<label for="Transport_user_<?php echo $n;?>"><?php echo $user;?></label>
                                    <?php } ?>
                                <?php $n++;}unset($n); } ?>
                                <span id="addjt"></span>
                                <img style="line-height: 30px;vertical-align: middle;cursor: pointer" onclick="addJiaoTong()" src="<?php echo $GLOBALS['cfg_public_url'];?>images/tianjia.png">
                            </dd>
                        </dl>
                        <dl>
                            <dt>儿童标准：</dt>
                            <dd>
                                <input type="text" class="set-text-xh text_700 mt-2" name="childrule" value="<?php echo $info['childrule'];?>"/>
                                <div class="help-ico mt-9 ml-5"></div>
                            </dd>
                        </dl>
                    </div>
                    <div class="add-class">
                        <dl>
                            <dt>显示模版：</dt>
                            <dd>
                                <div class="temp-chg" id="templet_list">
                                    <a <?php if($info['templet']=='line_show.htm') { ?>class="on"<?php } ?>
  href="javascript:void(0)"  data-value="line_show.htm" onclick="setTemplet(this)">标准</a>
                                    <a <?php if($info['templet']=='line_new/line_show.htm') { ?>class="on"<?php } ?>
  href="javascript:void(0)" data-value="line_new/line_show.htm" onclick="setTemplet(this)">模版1</a>
                                    <?php $n=1; if(is_array($templetlist)) { foreach($templetlist as $r) { ?>
                                    <a <?php if($info['templet']==$r['path']) { ?>class="on"<?php } ?>
  href="javascript:void(0)" data-value="<?php echo $r['path'];?>" onclick="setTemplet(this)"><?php echo $r['templetname'];?></a>
                                    <?php $n++;}unset($n); } ?>
                                    <input type="hidden" name="templet" id="templet" value="<?php echo $info['templet'];?>"/>
                                </div>
                            </dd>
                        </dl>
                        <dl>
                            <dt>标题颜色：</dt>
                            <dd><input type="text" name="color" value="<?php echo $info['color'];?>" class="set-text-xh text_100 mt-2 title-color"/></dd>
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
                            <dt>显示数据：</dt>
                            <dd>
                                <span class="fl">推荐次数</span>
                                <input type="text" name="recommendnum" value="<?php echo $info['recommendnum'];?>" data-regrex="number" data-msg="*必须为数字" class="set-text-xh text_60 mt-2 ml-10 mr-30"/>
                                <span class="fl">满意度</span>
                                <input type="text" name="satisfyscore" value="<?php echo $info['satisfyscore'];?>" data-regrex="number" data-msg="*必须为数字" class="set-text-xh text_60 mt-2 ml-10 mr-30"/>
                                <span class="fl">销量</span>
                                <input type="text" name="bookcount" value="<?php echo $info['bookcount'];?>" data-regrex="number" data-msg="*必须为数字" class="set-text-xh text_60 mt-2 ml-10"/>
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
                        <dl>
                            <dt>用餐情况：</dt>
                            <dd>
                            <div class="on-off">
                              <input type="radio" id="" class="fl mt-8" onclick="togDiner(1)" name="showrepast" value="1" <?php if($info['showrepast']==1||!isset($info['showrepast'])) echo 'checked="checked"';   ?>>
                              <label class="fl mr-20 ml-5">显示</label>
                              <input type="radio" id="" class="fl mt-8" onclick="togDiner(0)" <?php if($info['showrepast']==0&&isset($info['showrepast'])) echo 'checked="checked"';   ?> name="showrepast" value="0">
                              <label class="fl mr-20 ml-5">隐藏</label>
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
                               $jieshao.='<dl><dt>住宿情况：</dt>';
                               $jieshao.='<dd><input type="text"  class="set-text-xh text_222 mt-2" name="hotel['.$v['day'].']" value="'.$v['hotel'].'"></dd>';
                               $jieshao.='</dl>';
                               $jieshao.='<dl><dt>交通工具：</dt>';
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
                               $jieshao.='<dd><input type="button" class="btn-sum-xz mt-4" value="提取" onclick="autoGetSpot('.$v['day'].')"><div class="save-value-div mt-2 ml-10" id="listspot_'.$v['day'].'">'.$dayspot.'</div></dd>';
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
                        <dl>
                            <dt>行程附件：</dt>
                            <dd>
                                <div class="up-file-div">
                                    <div id="attach_btn" class="btn-file mt-4">上传附件</div>
                                    <input type="hidden" name="linedoc" id="linedoc" value="<?php echo $info['linedoc'];?>">
                                </div>
                                <div id="doclist" class="doclist">
                                   <?php if(!empty($info['linedoc'])) { ?>
                                       <a href="<?php echo $info['linedoc'];?>">查看附件</a>
                                       <a href="javascript:;" onclick="delDoc()">删除</a>
                                   <?php } ?>
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
                <?php $contentArr=Common::get_extend_content(1,$extendinfo);?>
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
          ST.Util.showMsg("请先填写旅游天数",1,1500);
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
            jiaotong+="<span id=\"addjt_{day}\"></span><img class='addimg' data-contain='addjt_{day}' data-day='{day}' style=\"line-height: 30px;vertical-align: middle;cursor: pointer\"  src=\"/newtravel/public/images/tianjia.png\">";
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
day_content+='<dl>';
day_content+='<dt>住宿情况：</dt>';
day_content+='<dd><input type="text" class="set-text-xh text_222 mt-2" name="hotel[{day}]"></dd>';
day_content+='</dl>';
day_content+='<dl>';
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
day_content+='<dd><input type="button" class="btn-sum-xz mt-4" value="提取" onclick="autoGetSpot({day})"><div class="save-value-div mt-2 ml-10" id="listspot_{day}"></div></dd>';
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
               // $(".content-jieshao-detail").find('.add-class').gt(days).remove();
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
     //var totalday="{sline:var.fields.lineday/}";
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
                 var html='';
                 $.each(data,function(i,row){
                     html+='<span><s onclick="delDaySpot(this,\''+row.autoid+'\')"></s>'+row.title+'</span>'
                 })
                 $("#listspot_"+i).append(html);//显示提取到的景点
                 ST.Util.showMsg('提取成功!',4,1000);
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
        url:SITEURL+'line/ajax_del_dayspot',
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
                Imageup.genePic(temp[0],".up-list-div ul",".cover-div");
            }
        }
    });
    setTimeout(function(){
        $('#attach_btn').uploadify({
            'swf': '/tools/js/uploadify/uploadify.swf',
            'uploader': SITEURL + 'uploader/uploaddoc',
            'buttonImage' : PUBLICURL+'images/uploadfile.png',  //指定背景图
            'formData':{uploadcookie:"<?php echo Cookie::get('username')?>"},
            'fileTypeExts':'*.doc;*.docx;*.pdf',
            'auto': true,   //是否自动上传
            'removeTimeout':0.2,
            'height': 25,
            'width': 80,
            'onUploadSuccess': function (file, data, response) {
                var info=$.parseJSON(data);
                var html = '<a href="'+info.path+'">查看附件</a>&nbsp;';
                $("#linedoc").val(info.path);
                if(action=='edit')
                    html+= '<a href="javascript:;" onclick="delDoc()">删除</a>'
                $("#doclist").html(html);
            }
        });
    },10)
    function updateInsurance(result,bool)
    {
        var container= $('.insurance-sel');
        container.children().remove();
        var html='';
        var productsArr=result.data;
        for(var i in productsArr)
        {
           var product=productsArr[i];
           html+='<span><s onclick="$(this).parent(\'span\').remove()"></s>';
           html+=product['productname'];
           html+='<input type="hidden" name="insuranceids[]" value="'+product['id']+'">'
           html+='</span>'
        }
        container.append(html);
    }
</script>
</body>
</html>
