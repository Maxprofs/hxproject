<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>供应商管理系统-<?php echo $webname;?></title>
    <?php echo Common::css('style.css,base.css,extend.css');?>
    <?php echo Common::js('jquery.min.js,common.js,slideTabs.js,jquery.upload.js');?>
    <script>
        $(function(){
            $('.way').switchTab();
        })
    </script>
</head>
<body>
<div class="page-box">
    <?php echo Request::factory('pc/pub/header')->execute()->body(); ?>
    <?php echo  Stourweb_View::template("pc/pub/sidemenu_enterprise");  ?>
    <div class="main">
        <div class="content-box">
            <div class="frame-box">
                <div class="frame-con">
                  <form id="chkfrm">
                    <div class="flow-path-box">
                        <div class="flow-path-tit"><strong class="bt">资质验证</strong></div>
                        <div class="flow-path-con">
                            <div class="nr-box">
                                <?php if($userinfo['verifystatus']==0) { ?>
                                <div class="step"><span class="on">1 提交资料</span><span>2 客服审核</span><span>3 认证成功</span></div>
                                <?php } else if($userinfo['verifystatus']==1) { ?>
                                <div class="step"><span><i class="cg-ico"></i>提交资料</span><span class="on"><i class="cg-ico"></i>客服审核</span><span>3 认证成功</span></div>
                                <?php } else if($userinfo['verifystatus']==2) { ?>
                                <div class="step"><span><i class="cg-ico"></i>提交资料</span><span><i class="cg-ico"></i>客服审核</span><span class="on"><i class="sb-ico"></i>认证失败</span></div>
                                <?php } else if($userinfo['verifystatus']==3) { ?>
                                <div class="step"><span><i class="cg-ico"></i>提交资料</span><span><i class="cg-ico"></i>客服审核</span><span class="on"><i class="cg-ico"></i>认证成功</span></div>
                                <?php } ?>
                                <?php 
                                $verifytype="";
                                if(!empty($qd['mp_litpic']))
                                {
                                $verifytype="旅行社工作名片";
                                }
                                else if(!empty($qd['xk_litpic']))
                                {
                                $verifytype="经营许可证";
                                }
                                else if(!empty($qd['zz_litpic']))
                                {
                                $verifytype="营业执照(副本)";
                                }
                                ?>
                                <?php if($userinfo['verifystatus']==3) { ?>
                                <div class="verify-finally">
                                    <h3 class="pass-yes">恭喜，审核通过</h3>
                                    <p>你已通过供应商资质审核。你将获得供应商发布产品、结算等功能！</p>
                                    <ul class="info-item-block confirm-info-box c-666">
                                        <li>
                                            <span class="item-hd">企业名称：</span>
                                            <div class="item-bd">
                                                <span class="item-text"><?php echo $userinfo['suppliername'];?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="item-hd">法人代表：</span>
                                            <div class="item-bd">
                                                <span class="item-text"><?php echo $userinfo['reprent'];?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="item-hd">经营范围：</span>
                                            <div class="item-bd">
                                                <?php 
                                                $apply_product = explode(',',$userinfo['authorization']);
                                                ?>
                                                <?php $n=1; if(is_array($product_list)) { foreach($product_list as $p) { ?>
                                                    <?php if(in_array($p['id'],$apply_product)) { ?><span class="item-text"><?php echo $p['modulename'];?></span>&nbsp;&nbsp;<?php } ?>
                                                <?php $n++;}unset($n); } ?>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="item-hd">认证方式：</span>
                                            <div class="item-bd">
                                                <span class="item-text"><?php echo $verifytype;?></span>
                                            </div>
                                        </li>
                                    </ul>
                                    <input type="button" value="重新认证"  id="reverify_btn" class="jg-btn" />
                                </div>
                                <?php } ?>
                                <?php if($userinfo['verifystatus']==1) { ?>
                                <div class="send-success">
                                    <p>您的资料已<strong><?php if($isfirstupdate==1) { ?>提交成功<?php } else { ?>更新成功<?php } ?>
</strong>，请等待客服审核。</p>
                                </div>
                                <?php } ?>
                                <?php if($userinfo['verifystatus']==2) { ?>
                                <div class="verify-finally">
                                    <h3 class="pass-no">认证失败</h3>
                                    <p>原因：<?php echo $userinfo['reason'];?></p>
                                    <input type="button" value="重新认证" id="reverify_btn" class="jg-btn" />
                                </div><!-- 审核未通过 -->
                                <?php } ?>
                                <?php if($userinfo['verifystatus']==0) { ?>
                                <div class="way">
                                    <div class="gy-top-box">
                                        <ul>
                                            <li><strong class="lm">企业名称：</strong><div class="zl-con"><input type="text" name="suppliername" class="tit-text" value="<?php echo $qd['suppliername'];?>" id="suppliername" /></div></li>
                                            <li><strong class="lm">法人代表：</strong><div class="zl-con"><input type="text" name="reprent" class="tit-text" value="<?php echo $qd['reprent'];?>" /></div></li>
                                            <li>
                                                <strong class="lm">经营范围：</strong>
                                                <div class="zl-con">
                                                    <div class="zj-radio">
                                                        <?php 
                                                        $apply_product = empty($qd['apply_kind'])?$qd['apply_product']:$qd['apply_kind'];
                                                        $apply_product = explode(',',$apply_product);
                                                        ?>
                                                        <?php $n=1; if(is_array($product_list)) { foreach($product_list as $p) { ?>
                                                        <label><input type="checkbox" class="apply" name="apply_product[]" value="<?php echo $p['id'];?>" <?php if(in_array($p['id'],$apply_product)) { ?>checked="checked"<?php } ?>
><?php echo $p['modulename'];?></label>
                                                        <?php $n++;}unset($n); } ?>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="st-tabnav">
                                        <strong>验证方式：</strong>
                                        <div class="nav-list">
                                            <span>旅行社工作名片</span>
                                            <span>经营许可证</span>
                                            <span>营业执照(副本)</span>
                                        </div>
                                    </div>
                                    <div class="st-tabcon">
                                        <ul>
                                            <li>
                                                <strong class="lm">名片正面：</strong>
                                                <div class="zl-con">
                                                    <div class="up-pic mp_litpic">
                                                        <?php if(!empty($qd['mp_litpic'])) { ?>
                                                        <img src="<?php echo $qd['mp_litpic'];?>" width="215" height="136">
                                                        <?php } else { ?>
                                                        支持jpg、png、gif格式，不超过2M
                                                        <?php } ?>
                                                    </div>
                                                    <div class="upload"><a class="up-btn" href="javascript:;" data-type="mp">+上传图片</a></div>
                                                    <p class="sm-txt">可上传名片的照片或者扫描文件，清晰的图片更容易通过审核。</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="st-tabcon">
                                        <ul>
                                            <li><strong class="lm">许可证号码：</strong><div class="zl-con"><input type="text" name="licenseno" class="tit-text" value="<?php echo $qd['licenseno'];?>" /></div></li>
                                            <li>
                                                <strong class="lm">经营许可证：</strong>
                                                <div class="zl-con">
                                                    <div class="up-pic xk_litpic">
                                                        <?php if(!empty($qd['xk_litpic'])) { ?>
                                                        <img src="<?php echo $qd['xk_litpic'];?>" width="215" height="136">
                                                        <?php } else { ?>
                                                        支持jpg、png、gif格式，不超过2M
                                                        <?php } ?>
                                                    </div>
                                                    <div class="upload"><a class="up-btn" href="javascript:;" data-type="xk">+上传图片</a></div>
                                                    <p class="sm-txt">上传证件支持电子版/扫描版。清晰的图片更容易通过审核。</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="st-tabcon">
                                        <ul>
                                            <li><strong class="lm">营业执照号：</strong><div class="zl-con"><input type="text" name="certifyno" class="tit-text" value="<?php echo $qd['certifyno'];?>" /></div></li>
                                            <li>
                                                <strong class="lm">营业执照：</strong>
                                                <div class="zl-con">
                                                    <div class="up-pic zz_litpic">
                                                        <?php if(!empty($qd['zz_litpic'])) { ?>
                                                        <img src="<?php echo $qd['zz_litpic'];?>" width="215" height="136">
                                                        <?php } else { ?>
                                                        支持jpg、png、gif格式，不超过2M
                                                        <?php } ?>
                                                    </div>
                                                    <div class="upload"><a class="up-btn" href="javascript:;" data-type="zz">+上传图片</a></div>
                                                    <p class="sm-txt">上传证件为带有最新工商局年检盖章的副本，如年检盖章在背面，请拼接处理后再上传。</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <a class="submit-btn" href="javascript:;"> <?php if($userinfo['verifystatus']==0) { ?>提交审核<?php } else { ?>修改资料<?php } ?>
</a>
                                    <input type="hidden" id="mp_litpic" name="mp_litpic" value="<?php echo $qd['mp_litpic'];?>"/>
                                    <input type="hidden" id="xk_litpic" name="xk_litpic" value="<?php echo $qd['xk_litpic'];?>"/>
                                    <input type="hidden" id="zz_litpic" name="zz_litpic" value="<?php echo $qd['zz_litpic'];?>"/>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div><!-- 验证步骤 -->
                  </form>
                </div>
            </div>
            <?php echo Request::factory("pc/pub/footer")->execute()->body(); ?>
        </div>
    </div><!-- 主体内容 -->
</div>
<?php echo Common::js("layer/layer.js");?>
<script>
    $("#nav_qulification").addClass('on');
    //提交审核
    $(".submit-btn").click(function(){
        var suppliername = $('#suppliername').val();
        if(suppliername == ''){
            layer.msg("供应商名称不能为空", {icon:5,time:1200});
            return false;
        }
        var frmdata = $("#chkfrm").serialize();
        $.ajax({
            type:'POST',
            url:SITEURL+'pc/qualify/ajax_save_qualify',
            data:frmdata,
            dataType:'json',
            success:function(data){
                if(data.status){
                   /* layer.msg("<?php echo __('commit_qualify_ok');?>", {
                        icon: 6,
                        time: 1000
                    })*/
                   // layer.msg(data.msg, {icon:1,time:2000,end:function(){
                        window.location.reload();
                   // }});
                    return false;
                }else{
                    layer.msg(data.msg, {icon:5});
                    return false;
                }
        }})
    })
    //重新提交
    $("#reverify_btn").click(function(){
        $.ajax({
            type:'POST',
            url:SITEURL+'pc/qualify/ajax_reverify',
            data:'',
            dataType:'json',
            success:function(data){
                if(data.status){
                    window.location.reload();
                    /*layer.msg("提交成功", {
                         icon: 6,
                         time: 1000,
                         end:function(){
                             window.location.reload();
                         }
                     })*/
                    //$('.st-popup-box').show('slow');
                }else{
                    layer.msg(data.msg, {icon:5});
                    return false;
                }
            }})
    });
    //上传图片
    $(".up-btn").click(function(){
        var type = $(this).attr('data-type');
        upload(type);
    })
    //上传模板
    function upload(type)
    {
        var contain = type+'_litpic';
        // 上传方法
        $.upload({
            // 上传地址
            url: SITEURL+'pc/qualify/ajax_upload_litpic',
            // 文件域名字
            fileName: 'filedata',
            fileType: 'png,jpg,jpeg,gif',
            // 其他表单数据
            params: {},
            // 上传之前回调,return true表示可继续上传
            onSend: function() {
                return true;
            },
            // 上传之后回调
            onComplate: function(data) {
                var data = $.parseJSON(data);
                //如果上传成功
                if(data.status){
                    var html = '<img src="' + data.litpic + '" width="215" height="136">';
                    $("#" + contain).val(data.litpic);
                    $("." + contain).html(html);
                }else{
                    ST.Util.showMsg('上传失败,请检查图片',5);
                }
            }
        });
    }
    $(function($) {
        $(".nav-list span").each(function(){
            if($(this).text() == "<?php echo $verifytype;?>")
            {
                $(this).trigger("click");
            }
        });
    });
</script>
</body>
</html>
