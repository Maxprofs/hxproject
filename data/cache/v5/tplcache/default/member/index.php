<!doctype html> <html> <head> <meta charset="utf-8"> <title><?php echo __('会员中心');?>-<?php echo $webname;?></title> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('user.css,base.css,extend.css',false);?> <script type="text/javascript" src="/res/js/artDialog/lib/sea.js"></script> <?php echo Common::js('jquery.min.js,base.js,common.js,dialog.js');?> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo __('首页');?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo __('会员中心');?> </div><!--面包屑--> <div class="st-main-page"> <?php echo  Stourweb_View::template("member/left_menu");  ?> <div class="user-order-box"> <div class="user-home-box"> <?php if((empty($info['email']) || empty($info['mobile'])||empty($info['nickname'])||empty($info['truename'])||empty($info['cardid'])||empty($info['address']))) { ?> <div class="hint-msg-box"> <span class="close-btn"><?php echo __('关闭');?></span> <p class="hint-txt"> <?php if(empty($info['email']) || empty($info['mobile'])) { ?> <?php echo __('温馨提示：请完善<a href="/member/index/userinfo">手机/邮箱</a>信息，避免错过产品预定联系等重要通知!');?> <?php } else if((empty($info['nickname'])||empty($info['truename'])||empty($info['cardid'])||empty($info['address']))) { ?> <?php echo __('温馨提醒：请完善<a href="/member/index/userinfo">个人资料</a>信息，体验更便捷的产品预定流程！');?> <?php } ?> </p> </div> <script>
            $(function(){
                $('.close-btn').click(function(){
                    $('.hint-msg-box').hide(500);
                })
            })
        </script> <?php } ?> <div class="user-home-msg"> <div class="user-msg-con"> <div class="user-pic"><div class="level"><a href="/member/club/rank"><?php echo Common::member_rank($info['mid'],array('return'=>'current'));?></a></div><a href="/member/index/userinfo"><img src="<?php echo $info['litpic'];?>" width="118" height="118" /></a></div> <div class="user-txt"> <p class="name"><?php echo $info['nickname'];?></p> <p class="item-bar"><?php echo __('会员等级');?>：<?php echo Common::member_rank($info['mid'],array('return'=>'rankname'));?></p> <p class="item-bar"><?php echo __('登录邮箱');?>：
                        <?php if($info['email']) { ?><?php echo $info['email'];?><?php } else { ?><?php echo __('未绑定');?> <a class="rz-no" href="<?php echo $cmsurl;?>member/index/modify_email?change=0"><?php echo __('立即绑定');?></a><?php } ?> </p> <p class="item-bar"><?php echo __('手机号码');?>：
                        <?php if($info['mobile']) { ?><?php echo $info['mobile'];?><?php } else { ?><?php echo __('未绑定');?> <a class="rz-no" href="<?php echo $cmsurl;?>member/index/modify_phone?change=0"><?php echo __('立即绑定');?></a><?php } ?> </p> <p class="item-bar">真实姓名：
                        <?php if($info['verifystatus']==2) { ?><?php echo $info['truename'];?><?php } else { ?><?php if($info['verifystatus']==1) { ?>审核中 <?php } else if($info['verifystatus']==3) { ?>审核失败 <?php } else { ?>未实名<?php } ?> <a class="rz-no" href="<?php echo $cmsurl;?>member/index/modify_idcard">实名认证</a><?php } ?> </p> <p class="item-bar">服务网点：
                        <?php 
                            if ($info['binddistributor']=='0') {
                                echo '未绑定 <a class="rz-no" href="#" onclick="bindbox()">绑定网点</a>';
                            }else{
                                $dinfo=Model_Distributor::distributor_find_relationship($info['mid'],'view');
                                echo "<a href='#' style='text-decoration: underline;color:blue;' onclick='serviceinfo()'>服务网点信息</a>";
                            }
                         ?> </p> </div> </div><!-- 账号信息 --> <div class="user-msg-right"> <div class="user-msg-tj"> <ul class="clearfix"> <li class="my-jf" data-url="/member/order/all-unpay"> <em></em> <span><?php echo __('未付款');?></span> </li> <li class="un-fk" data-url="/member/order/all-uncomment"> <em></em> <span><?php echo __('未点评');?></span> </li> <li class="un-dp" data-url="/member/index/myquestion"> <em></em> <span><?php echo __('我的咨询');?></span> </li> <?php if(St_Functions::is_normal_app_install('system_integral')) { ?> <li class="my-sc" data-url="/integral"> <em></em> <span>积分商城</span> </li> <?php } ?> <?php if(St_Functions::is_normal_app_install('integral_award')) { ?> <li class="my-hd" data-url="/award"> <em></em> <span>积分活动</span> </li> <?php } ?> </ul> </div><!-- 订单信息 --> <div class="user-info-exchange"> <ul class="clearfix"> <li><em>我的余额：</em><strong><?php echo Currency_Tool::symbol();?><?php echo $info['money']-$info['money_frozen']?></strong></li> <li><em>我的积分：</em><strong><?php echo $info['jifen'];?></strong></li> <!--                    <li><em>我的余额：</em><strong>¥6525</strong></li>--> <?php if(isset($info['coupon'])) { ?> <li class="last-li"><em>优惠券：</em><strong><?php echo $info['coupon'];?>张</strong></li> <?php } ?> </ul> </div> </div> </div> <div class="user-home-order"> <div class="order-tit"><?php echo __('最新订单');?><a class="more" href="/member/order/all">查看更多&gt;</a></div> <?php if(!empty($neworder)) { ?> <div class="order-list"> <table width="100%" border="0"> <tr> <th width="55%" height="38" scope="col"><?php echo __('订单信息');?></th> <th width="15%" height="38" scope="col"><?php echo __('订单金额');?></th> <th width="15%" height="38" scope="col"><?php echo __('订单状态');?></th> <th width="15%" height="38" scope="col"><?php echo __('订单操作');?></th> </tr> <?php $n=1; if(is_array($neworder)) { foreach($neworder as $order) { ?> <tr> <td height="114"> <div class="con"> <dl> <dt><a href="<?php if($order['is_standard_product']) { ?><?php echo $order['producturl'];?><?php } else { ?><?php echo $cmsurl;?>member/order/view?ordersn=<?php echo $order['ordersn'];?><?php } ?>
" target="_blank"><img src="<?php echo Common::img($order['litpic'],110,80);?>" width="110" height="80" alt="<?php echo $order['title'];?>" /></a></dt> <dd> <a class="tit" href="<?php if($order['is_standard_product']) { ?><?php echo $order['producturl'];?><?php } else { ?><?php echo $cmsurl;?>member/order/view?ordersn=<?php echo $order['ordersn'];?><?php } ?>
" target="_blank"><?php echo $order['productname'];?></a> <p><?php echo __('订单编号');?>：<?php echo $order['ordersn'];?></p> <p><?php echo __('下单时间');?>：<?php echo Common::mydate('Y-m-d H:i:s',$order['addtime']);?></p> </dd> </dl> </div> </td> <?php if($order['typeid']!=107) { ?> <td align="center"><span class="price"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $order['totalprice'];?></span></td> <?php } else { ?> <td align="center"><span class="price"><?php echo $order['needjifen'];?>&nbsp;积分</span></td> <?php } ?> <td align="center"><span class="dfk"><?php echo $order['statusname'];?></span></td> <td align="center"> <?php if($order['status']=='1'&&$order['pid']==0) { ?> <a class="now-fk" href="<?php echo $cmsurl;?>member/index/pay?ordersn=<?php echo $order['ordersn'];?>"><?php echo __('立即付款');?></a> <a class="cancel_order now-dp" style="background:#ccc" href="javascript:;" data-orderid="<?php echo $order['id'];?>"><?php echo __('取消');?></a> <?php } else if($order['status']=='5' && $order['ispinlun']!=1 && $order['is_commentable']) { ?> <a class="now-dp" href="<?php echo $cmsurl;?>member/order/pinlun?ordersn=<?php echo $order['ordersn'];?>"><?php echo __('立即点评');?></a> <?php } ?> <a class="order-ck" href="<?php echo $cmsurl;?>member/order/view?ordersn=<?php echo $order['ordersn'];?>"><?php echo __('查看订单');?></a> </td> </tr> <?php $n++;}unset($n); } ?> </table> </div> <?php } else { ?> <div class="order-no-have"><span></span><p><?php echo __('您的订单空空如也');?>，<a href="/"><?php echo __('去逛逛');?></a><?php echo __('去哪儿玩吧');?>！</p></div> <?php } ?> </div><!-- 我的订单 --> <?php if(St_Functions::is_system_app_install(1)) { ?> <?php $line_tag = new Taglib_Line();if (method_exists($line_tag, 'query')) {$recline = $line_tag->query(array('action'=>'query','flag'=>'order','row'=>'4','return'=>'recline',));}?> <?php if(!empty($recline)) { ?> <div class="guess-you-like"> <div class="like-tit"><?php echo __('猜你喜欢的');?></div> <div class="like-list"> <ul> <?php $n=1; if(is_array($recline)) { foreach($recline as $line) { ?> <li <?php if($n%4==0) { ?>class="mr_0"<?php } ?>
> <div class="pic"><a href="<?php echo $line['url'];?>" target="_blank"><img src="<?php echo Common::img($line['litpic']);?>" alt="<?php echo $line['title'];?>" /></a></div> <div class="con"> <a href="<?php echo $line['url'];?>" target="_blank"><?php echo $line['title'];?></a> <p> <?php if(!empty($line['sellprice'])) { ?> <del><?php echo __('市场价');?>：<i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $line['sellprice'];?></del> <?php } ?> <?php if(!empty($line['price'])) { ?> <span><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><b><?php echo $line['price'];?></b><?php echo __('元');?><?php echo __('起');?></span> <?php } else { ?> <span><?php echo __('电询');?></span> <?php } ?> </p> </div> </li> <?php $n++;}unset($n); } ?> </ul> </div> </div> <?php } ?> <?php } ?> </div> </div><!--会员首页--> </div> </div> </div> <?php echo Common::js('layer/layer.js');?> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <script>
    function serviceinfo(){
        var url=SITEURL+"distributor/pc/distributor/serviceinfo/"+"<?php echo $dinfo;?>";
        floatBox('服务网点信息',url,'500','250');
    }
    function bindbox(){
        var url=SITEURL+"distributor/pc/distributor/bind";
        floatBox('绑定服务网点',url,'800','500');
    }
    $(function(){
        $("#nav_index").addClass('on');
        if(typeof(on_leftmenu_choosed)=='function')
        {
            on_leftmenu_choosed();
        }
        $(".user-msg-tj li").click(function(){
            var url = $(this).attr('data-url');
            if(url!=''){
                location.href = url;
            }
        })
    })
</script> <?php echo  Stourweb_View::template("member/order/jsevent");  ?> </body> </html>
