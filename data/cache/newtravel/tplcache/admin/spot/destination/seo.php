<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,listimageup.js"); ?>
    <?php echo Common::getCss('base.css,style.css,base_new.css'); ?>
</head>
<body>
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:auto;">
                <form id="product_fm" ul_font=7oYlqk >
                    <div class="s-main">
                        <div class="main-body">
                            <div class="cfg-header-bar">
                                <div class="cfg-header-tab">
<!--                                    <span data-rel="seo" class="item on"><s></s>优化信息</span>-->
<!--                                    <span data-rel="jieshao" class="item"><s></s>页面介绍</span>-->
<!--                                    <span data-rel="template" class="item"><s></s>模板设置</span>-->
                                </div>
                                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                            </div>
                            <div class="product-add-div">
                                <div class="nav-list">
                                    <div class="item-one" id="item_seo">
                                        <ul class="info-item-block">
                                            <li>
                                                <span class="item-hd">优化标题<?php echo Common::get_help_icon('content_seotitle');?>：</span>
                                                <div class="item-bd">
                                                    <input class="input-text w300" name="seotitle" value="<?php echo $info['seotitle'];?>"/>
                                                </div>
                                            </li>
                                            <li>
                                                <span class="item-hd">Tag词<?php echo Common::get_help_icon('content_tagword');?>：</span>
                                                <div class="item-bd">
                                                    <input class="input-text w300" name="tagword" value="<?php echo $info['tagword'];?>"/>
                                                </div>
                                            </li>
                                            <li>
                                                <span class="item-hd">关键词<?php echo Common::get_help_icon('content_keyword');?>：</span>
                                                <div class="item-bd">
                                                    <input class="input-text w300" name="keyword" value="<?php echo $info['keyword'];?>"/>
                                                </div>
                                            </li>
                                            <li>
                                                <span class="item-hd">页面描述<?php echo Common::get_help_icon('content_description');?>：</span>
                                                <div class="item-bd">
                                                    <textarea class="textarea w900" name="description"><?php echo $info['description'];?></textarea>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="line"></div>
                                    <div class="item-one" id="item_jieshao" >
                                        <ul class="info-item-block">
                                            <li>
                                                <span class="item-hd">页面介绍：</span>
                                                <div  class="item-bd"><?php Common::getEditor('jieshao',$info['jieshao'],900,300);?></div>
                                            </li>
                                        </ul>
                                    </div>
<!--                                    <div class="item-one" id="item_template" style="display: none;">-->
<!--                                        <ul class="info-item-block">-->
<!--                                            <li>-->
<!--                                                <span class="item-hd">模板：</span>-->
<!--                                                <div class="item-bd">-->
<!--                                                    <div class="temp-chg">-->
<!--                                                    <a href="javascript:;" data-rel="" class="i-tpl <?php if(empty($info['templetpath'])) { ?>on<?php } ?>
">标准</a>-->
<!--                                                    <?php $n=1; if(is_array($templateList)) { foreach($templateList as $tpl) { ?>-->
<!--                                                    <a href="javascript:;" data-rel="<?php echo $tpl['path'];?>" class="i-tpl <?php if($info['templetpath']==$tpl['path']) { ?>on<?php } ?>
"><?php echo $tpl['path'];?></a>-->
<!--                                                    <?php $n++;}unset($n); } ?>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </li>-->
<!--                                        </ul>-->
<!--                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="clear clearfix mt-5">
                            <a href="javascript:;" id="confirm-btn" class="btn btn-primary radius size-L ml-115">确定</a>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id;?>"/>
                    <input type="hidden" name="templetpath" id="templetpath" value="<?php echo $info['templetpath'];?>">
                </form>
            </td>
        </tr>
    </table>
    <script>
        var id="<?php echo $id;?>";
        var typeid="<?php echo $typeid;?>";
        $(function() {
            $(document).on('click',".i-tpl",function(){
                $(".i-tpl").removeClass('on');
                $(this).addClass('on');
                $('#templetpath').val($(this).attr('data-rel'));
            });
            $(document).on('click',".cfg-header-tab .item",function(){
                var name=$(this).attr('data-rel');
                $(this).siblings().removeClass('on');
                $(".nav-list .item-one").hide();
                $(this).addClass('on');
                $("#item_"+name).show();
            });
            $("#confirm-btn").click(function () {
                $.ajaxform({
                    url: SITEURL + "spot/admin/destination/ajax_save",
                    method: "POST",
                    form: "#product_fm",
                    dataType: "JSON",
                    success: function (result) {
                        if(result.status){
                            ST.Util.showMsg('保存成功', 4)
                        }else{
                            ST.Util.showMsg('保存失败', 5,1000)
                        }
                    }
                });
            });
        })
    </script>
</body>
</html>
