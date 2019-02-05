<!doctype html> <html> <head> <meta charset="utf-8"> <title><?php echo __('会员中心');?>-<?php echo $webname;?></title> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('user.css,base.css,extend.css,base_new.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,jquery.validate.js,jquery.cookie.js,ajaxform.js');?> <link rel="stylesheet" href="/tools/js/datetimepicker/jquery.datetimepicker.css"> <script src="/tools/js/datetimepicker/jquery.datetimepicker.full.js"></script> <!--引入CSS--> <?php echo Common::css('res/js/webuploader/webuploader.css',false,false);?> <!--引入JS--> <?php echo Common::js('webuploader/webuploader.min.js');?> <!--引入自定义CSS--> <?php echo Common::css('res/css/web-uploader-custom.css',false,false);?> <style>
        .user-message-center{
            width: 963px;
            margin-bottom: 20px;
        }
        .webuploader-pick {
            top: 10px;
            padding: 0px 19px;
            font-size: 12px;
            border-radius: 4px;
            height: 28px;
            line-height: 2.4;
        }
        .checkpic{
            position: relative;
            top: 1px;
            text-decoration: none;
            margin-left: 5px;
            font-size: 12px;
            border-radius: 4px;
            border-style: solid;
            background-color: #2577e3;
            line-height: 2.4;
            height: 28px;
            padding: 5px 10px 6px 10px;
            color: #fff;
        }
        .layui-layer-content{
            overflow: hidden;
        }
    </style> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo __('首页');?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo __('我的钱包');?> </div><!--面包屑--> <div class="st-main-page"> <?php echo  Stourweb_View::template("member/left_menu");  ?> <div class="user-main-box"> <?php if($member['verifystatus']==0) { ?> <div class="hint-msg-box"> <span class="close-btn" onclick="$(this).parent().remove()">关闭</span> <p class="hint-txt">您的账户未实名认证！为了您资金的安全，<a href="/member/index/modify_idcard">去认证&gt;&gt;</a></p> </div> <?php } ?> <!-- 认证提示 --> <div class="my-wallet-bar"> <span class="txt" style="padding: 0;">账号余额：<em class="price"><?php echo Currency_Tool::symbol();?> <?php echo number_format($member['money']-$member['money_frozen'],2)?></em></span> <?php if($config['cash_min']=='1'||$config['cash_max']=='1') { ?> <span class="ms"><?php if($config['cash_min']=='1') { ?>金额超过<?php echo Currency_Tool::symbol();?><?php echo $config['cash_min_num'];?>可提现<?php } ?> <?php if($config['cash_max']=='1') { ?><?php if($config['cash_min']=='1') { ?>,<?php } ?>
本月还可提现<?php echo $cash_available_num;?>次<?php } ?> </span> <?php } ?> <?php if(((($member['money']-$member['money_frozen']<$config['cash_min_num'])&&$config['cash_min']==1)||$cash_available_num==0)&&$member['bflg']==1) { ?> <a class="go-link fr disabled" href="javascript:;">我要提现</a> <?php } else if($member['bflg']==1) { ?> <a class="go-link fr" href="/member/bag/withdraw">我要提现</a> <?php } ?> </div> <!-- 账号余额 --> <div class="details-container"> <div class="tab-nav-bar"> <a class="dh <?php if($type===null) { ?>on<?php } ?>
" href="/member/bag/index">交易明细</a> <a class="dh <?php if($type===0 || $type==='0') { ?>on<?php } ?>
" href="/member/bag/index?type=0">收入</a> <a class="dh <?php if($type===1 || $type==='1') { ?>on<?php } ?>
" href="/member/bag/index?type=1">支出</a> <?php if($member['bflg']==1) { ?> <a class="dh <?php if($type===100 || $type==='100') { ?>on<?php } ?>
" href="/member/bag/index?type=100">预存款充值</a> <?php } ?> </div> <?php if($type!=100 || $type!='100') { ?> <div class="tab-con-wrap clearfix"> <table class="tran-data-list" body_html=iIACXC > <tr> <th width="25%">时间</th> <th width="35%">交易名称</th> <th width="20%">交易类型</th> <th width="20%">交易金额</th> </tr> <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?> <tr> <td><?php echo date('Y-m-d H:i:s',$row['addtime']);?></td> <td><span class="name"><?php echo $row['description'];?></span></td> <td><?php if($row['type']==0) { ?>收入<?php } else if($row['type']==1) { ?>支出<?php } else if($row['type']==2) { ?>冻结<?php } else if($row['type']==3) { ?>解冻<?php } else if($row['type']==100) { ?>预存款充值<?php } ?> </td> <td><span class="<?php if($row['type']==0 || $row['type']==3 || $row['type']==100) { ?>add<?php } else { ?>sub<?php } ?>
"> <?php if($row['type']==0 || $row['type']==3 || $row['type']==100) { ?>+<?php } else { ?>-<?php } ?> <?php echo Currency_Tool::symbol();?><?php echo $row['amount'];?> </span></td> </tr> <?php $n++;}unset($n); } ?> </table> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div> <?php if(empty($list)) { ?> <div class="order-no-have"><span></span> <p>暂无交易记录</p> </div> <?php } ?> </div> <?php } else { ?> <div class="tab-con-wrap clearfix"> <div class="user-message-center"> <div class="user-message-bar"> <span>充值金额：<span class="mustfill">*</span></span><input type="text" class="input-text w100" id="savecash" oninput="value=value.replace(/[^\d]/g,'')" maxlength="6"> <span id="voucher">上传转账凭证</span><input type="hidden" id='voucherpath'> <button class="btn btn-warning radius" id="btn-savecash">充值</button><span style="margin-left: 5px">提示：1、转账凭证为非必选项。2、最小充值金额100元。</span> </div> </div> <table class="tran-data-list" body_html=iIACXC > <tr> <th width="25%">时间</th> <th width="35%">交易名称</th> <th width="20%">交易类型</th> <th width="20%">交易金额</th> </tr> <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?> <tr> <td><?php echo date('Y-m-d H:i:s',$row['addtime']);?></td> <td><span class="name"><?php echo $row['description'];?></span></td> <td>预存款充值</td> <td><span class="add">
                                    +<?php echo Currency_Tool::symbol();?><?php echo $row['amount'];?> </span></td> </tr> <?php $n++;}unset($n); } ?> </table> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div> <?php if(empty($list)) { ?> <div class="order-no-have"><span></span> <p>暂无交易记录</p> </div> <?php } ?> </div> <?php } ?> </div> <!-- 交易明细 --> </div> </div> </div> </div> <?php echo Common::js('layer/layer.js');?> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <script>
    $(function(){
        upload('#voucher')
        $('#btn-savecash').click(function(event) {
            /* Act on the event */
            //询问框
            layer.confirm('确认预存款充值？', {
              btn: ['确认','取消'] //按钮
            }, function(){
                $.ajax({
                    url: '/distributor/pc/precash/ajax_savecash',
                    type: 'post',
                    dataType: 'json',
                    data: {cash: $('#savecash').val(),voucherpath:$("#voucherpath").val()},
                })
                .done(function(data) {
                    if (data.status) {
                        layer.msg(data.msg,{icon:6,time:1000})
                        window.location.reload();
                    }else{
                        layer.msg(data.msg,{icon:5,time:2000})
                    }
                })
            }, function(){
                // 取消
            });
        });
        //提交申请
        $("#submit_btn").click(function(){
             $("#frm").submit();
        });
        //验证
        $("#frm").validate({
            rules: {
                amount:
                {
                    required:true,
                    digits:true
                },
                bankaccountname:
                {
                    required:true
                },
                bankcardnumber:
                {
                    required:true
                },
                bankname:
                {
                    required:true
                }
            },
            messages: {
                amount:
                {
                    required:'必填',
                    digits:'请填入整数金额'
                },
                bankaccountname:
                {
                    required:'必填'
                },
                bankcardnumber:
                {
                    required:'必填'
                },
                bankname:
                {
                    required:'必填'
                }
            },
            submitHandler:function(form){
                $.ajaxform({
                    method: "POST",
                    isUpload: true,
                    form: "#frm",
                    dataType: "html",
                    success: function (result) {
                    }
                });
                return false;
            },
            errorClass:'error-txt',
            errorElement:'span'
            /* highlight: function(element, errorClass, validClass) {
                $(element).attr('style','border:1px solid red');
            },
            unhighlight:function(element, errorClass){
                $(element).attr('style','');
            },
            errorPlacement:function(error,element){
                $(element).parent().append(error)
            }*/
        });
        //导航选中
        $("#nav_money").addClass('on');
    })
        //webuploader上传
        function upload(obj) {
            //obj='#imas'jquery对象;
            //正面上传实例
            var uploader = new WebUploader.Uploader({
                // 选完文件后，是否自动上传。
                auto: true,
                // swf文件路径
                swf: '/res/js/webuploader/Uploader.swf',
                // 文件接收服务端。
                server: SITEURL + 'distributor/pc/precash/ajax_upload_voucher',
                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick:obj,
                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                //上传前压缩项
                compress:{
                    width: 1600,
                    height: 1600,
                    // 图片质量。仅仅有type为`image/jpeg`的时候才有效。
                    quality: 90,
                    // 是否同意放大，假设想要生成小图的时候不失真。此选项应该设置为false.
                    allowMagnify: false,
                    // 是否同意裁剪。
                    crop: false,
                    // 是否保留头部meta信息。
                    preserveHeaders: true,
                    // 假设发现压缩后文件大小比原来还大，则使用原来图片
                    // 此属性可能会影响图片自己主动纠正功能
                    noCompressIfLarger: false,
                    // 单位字节，假设图片大小小于此值。不会採用压缩。(大于2M压缩)
                    compressSize: 1024*1024*2
                }
            });
            // 文件上传过程中创建进度条实时显示。
            uploader.on( 'uploadProgress', function( file, percentage ) {
            });
            // 文件上传成功
            uploader.on( 'uploadSuccess', function( file,data) {
                //如果上传成功
                if (data.status) {
                    var html = "<a class='checkpic' onclick='checkpic("+'"'+data.litpic+'"'+")' href='#'>查看</a>";
                    $(obj).append(html);
                    layer.msg(data.msg, {icon: 6});
                    $('#voucherpath').val(data.litpic);
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            });
            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on( 'uploadComplete', function( file ) {
//                $.layer.close();
            });
        }
        function checkpic(url) {
            window.open(url);
        }
</script> </body> </html>
