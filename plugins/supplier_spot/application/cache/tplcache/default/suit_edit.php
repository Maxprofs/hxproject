<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>门票套餐管理-<?php echo $webname;?></title>
    <?php echo Common::css("style.css,base.css,style_hotel.css,base_hotel.css");?>
    <?php echo Common::js("jquery.min.js,common.js,product.js,choose.js,imageup.js");?>
    <?php echo  Stourweb_View::template("pub/public_js");  ?>
    <script type="text/javascript"src="/tools/js/DatePicker/WdatePicker.js"></script>
</head>
<body>
<div class="page-box">
<?php echo Request::factory("pub/header")->execute()->body(); ?>
<?php echo Request::factory("pub/sidemenu")->execute()->body(); ?>
<div class="main">
<div class="content-box">
<div class="frame-box">
<div class="pt-manage-box">
    <form method="post" name="product_frm" id="product_frm" autocomplete="off">
        <div class="manage-nr">
            <div class="w-set-tit bom-arrow" id="nav">
                <span class="on"><s></s><?php echo $position;?></span>
                <a href="javascript:;" class="refresh-btn" onclick="window.location.reload()">刷新</a>
            </div>
            <!--基础信息开始-->
            <div class="product-add-div">
                <div class="add-class">
                    <dl>
                        <dt>当前景点：</dt>
                        <dd>
                            <?php echo $productname;?>
                        </dd>
                    </dl>
                    <dl>
                        <dt>门票名称：</dt>
                        <dd>
                            <input type="text" name="title" id="suitname"  class="set-text-xh text_700 mt-2" value="<?php echo $info['title'];?>" />
                        </dd>
                    </dl>
                    <dl>
                        <dt>门票类型：</dt>
                        <dd>
                            <select name="suittypeid" id="suittypeid_choose">
                                <option value="0">请选择</option>
                                <?php $n=1; if(is_array($suittypes)) { foreach($suittypes as $k => $v) { ?>
                                    <option value="<?php echo $v['id'];?>" <?php if($info['tickettypeid']==$v['id']) { ?>selected="selected"<?php } ?>
><?php echo $v['kindname'];?></option>
                                <?php $n++;}unset($n); } ?>
                                <option value="other">添加新类型</option>
                            </select>
                            <input type="text" class="newsuittype set-text-xh text_200" name="newsuittype" style="display: none;float:none;" placeholder="请输入新门票类型名称" value=""/>
                        </dd>
                    </dl>
                    <dl>
                        <dt>门票描述：</dt>
                        <dd>
                            <?php echo Common::get_editor('description',$info['description'],700,150,'Line');?>
                        </dd>
                    </dl>
                    <dl>
                        <dt>票面价格：</dt>
                        <dd>
                            <input type="text" name="sellprice" id="sellprice" class="set-text-xh text_100 mt-2" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $info['sellprice'];?>" />
                            <span class="fl ml-5"></span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>本站价格：</dt>
                        <dd>
                            <input type="text" name="ourprice" id="ourprice" class="set-text-xh text_100 mt-2"  onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $info['ourprice'];?>" />
                            <span class="fl ml-5"></span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>门票库存：</dt>
                        <dd>
                            <input type="text" name="number" id="number" class="set-text-xh text_100 mt-2" onkeyup="this.value=this.value.replace(/\-+\D/g,'')" value="<?php echo $info['number'];?>" />
                            <span class="fl ml-5"></span>
                        </dd>
                    </dl>
                </div>
                <div class="add-class">
                    <dl>
                        <dt>预订送积分：</dt>
                        <dd>
                            <input type="text" name="jifenbook" id="jifenbook" class="set-text-xh text_100 mt-2" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $info['jifenbook'];?>" />
                            <span class="fl ml-5">分</span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>积分抵现金：</dt>
                        <dd>
                            <input type="text" name="jifentprice" id="jifentprice" value="<?php echo $info['jifentprice'];?>" onkeyup="this.value=this.value.replace(/\D/g,'')" class="set-text-xh text_100 mt-2" />
                            <span class="fl ml-5">元</span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>评论送积分：</dt>
                        <dd>
                            <input type="text" name="jifencomment" id="jifencomment" class="set-text-xh text_100 mt-2" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $info['jifencomment'];?>" />
                            <span class="fl ml-5">分</span>
                        </dd>
                    </dl>
                    <dl>
                        <dt>支付方式：</dt>
                        <dd>
                            <div class="on-off">
                                <input type="radio" name="paytype" value="1" <?php if($info['paytype']=='1') { ?>checked="checked"<?php } ?>
 />全款支付 &nbsp;
                                <input type="radio" name="paytype" value="2" <?php if($info['paytype']=='2') { ?>checked="checked"<?php } ?>
 />定金支付 &nbsp;
                                <span id="dingjin" style="<?php if($info['paytype'] == '2') { ?>display:inline-block<?php } else { ?>display: none<?php } ?>
"><input type="text"  name="dingjin" id="dingjintxt" class="set-text-xh text_100" style="float:none;" value="<?php echo $info['dingjin'];?>" size="8" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-\.]+/,'');}).call(this)" onblur="this.v();">&nbsp;元</span>
                                <input type="radio" name="paytype" value="3"  <?php if($info['paytype']=='3') { ?>checked="checked"<?php } ?>
 />二次确认支付 &nbsp;
                                <script>
                                    $("input[name='paytype']").click(function(){
                                        if($(this).val() == 2)
                                        {
                                            $("#dingjin").show();
                                        }
                                        else
                                        {
                                            $("#dingjin").hide()
                                        }
                                    })
                                </script>
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
</div>
</div>
<!--/基础信息结束-->
<div class="opn-btn" style="padding-left: 10px; " id="hidevalue">
    <input type="hidden" name="suitid" id="suitid" value="<?php echo $info['id'];?>"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>"/>
    <input type="hidden" name="productid" id="productid" value="<?php echo $productid;?>"/>
    <input type="hidden" name="suitid" id="suitid" value="<?php echo $info['id'];?>">
    <a class="normal-btn" id="btn_save" href="javascript:;">保存</a>
</div>
</div>
</form>
</div>
</div>
<!--/基础信息结束-->
<?php echo Request::factory("pub/footer")->execute()->body(); ?>
</div>
</div>
<!-- 主体内容 -->
</div>
</body>
<script>
    $(function () {
        $("#nav_spot_list").addClass('on');
        //保存
        $("#btn_save").click(function(){
            var suitname = $("#suitname").val();
            if(suitname==''){
                ST.Util.showMsg('请输入门票名称',5,1000);
                return false;
            }
            $.ajax({
                type:'POST',
                url:SITEURL+'index/ajax_suit_save',
                data:$("#product_frm").serialize(),
                dataType:'json',
                success:function(data){
                    if(data.status)
                    {
                        if(data.suitid!=null){
                            $("#suitid").val(data.suitid);
                        }
                        ST.Util.showMsg('保存成功!','4',2000);
                    }
                }
            })
        })
        //select 改变
        $("#suittypeid_choose").change(function(){
                var v = $(this).val();
                if(v=='other'){
                    $('.newsuittype').show();
                }else{
                    $('.newsuittype').hide();
                }
        });
    })
</script>
</html>
